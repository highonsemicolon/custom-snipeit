<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\RedirectResponse;
use \Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use App\Models\Location;
use App\Models\Asset;
use Illuminate\Http\Request;


/**
 * This controller handles all actions related to the Admin Dashboard
 * for the Snipe-IT Asset Management application.
 *
 * @author A. Gianotto <snipe@snipe.net>
 * @version v1.0
 */
class DashboardController extends Controller
{
    /**
     * Check authorization and display admin dashboard, otherwise display
     * the user's checked-out assets.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     */
    public function index() : View | RedirectResponse
    {
        // Show the page
        if (auth()->user()->hasAccess('admin')) {
            $asset_stats = null;

            $counts['asset'] = \App\Models\Asset::count();
            $counts['accessory'] = \App\Models\Accessory::count();
            $counts['license'] = \App\Models\License::assetcount();
            $counts['consumable'] = \App\Models\Consumable::count();
            $counts['component'] = \App\Models\Component::count();
            $counts['user'] = \App\Models\Company::scopeCompanyables(auth()->user())->count();
            $counts['grand_total'] = $counts['asset'] + $counts['accessory'] + $counts['license'] + $counts['consumable'];

            $expiringSoon = $this->getExpiringAssets();
            // $counts['expiring_soon'] = $expiringSoon;

            $ageDistribution = $this->getAssetAgeDistribution();
            // $counts['age_distribution'] = $ageDistribution;

            // $licenseUtilization = $this->getLicenseUtilization();
            $softwareAllocation = $this->getSoftwareAllocationByDepartment();

            $locations = Location::select('name', 'id')->distinct()->get();
            $assetsData = Asset::query()
                ->when(request('location_id'), function ($query) {
                    return $query->where('location_id', request('location_id'));
                })
                ->get();

            $taggingStatus = $assetsData->groupBy('tagging_status');
            $assetStatus = $assetsData->groupBy('status');


            if ((! file_exists(storage_path().'/oauth-private.key')) || (! file_exists(storage_path().'/oauth-public.key'))) {
                Artisan::call('migrate', ['--force' => true]);
                \Artisan::call('passport:install');
            }

            return view('dashboard')
                ->with('asset_stats', $asset_stats)
                ->with('counts', $counts)
                ->with('expiringSoon', $expiringSoon)
                ->with('ageDistribution', $ageDistribution)
                // ->with('licenseUtilization', $licenseUtilization)
                ->with('softwareAllocation', $softwareAllocation)
                ->with('locations', $locations)
                ->with('taggingStatus', $taggingStatus)
                ->with('assetStatus', $assetStatus)
                ;
        } else {
            Session::reflash();

            // Redirect to the profile page
            return redirect()->intended('account/view-assets');
        }
    }

    public function getLocationWiseAssetData(Request $request)
    {
        // Get location from the request
        $location_id = $request->input('location_id', '*');

        $assets = Asset::query()
            ->when($location_id !== '*', function ($query) use ($location_id) {
            return $query->where('location_id', $location_id);
        })
        ->leftJoin('status_labels', 'assets.status_id', '=', 'status_labels.id')
        ->select('assets.*', 'status_labels.name as status_name') 
        ->get();

        $status = $assets->groupBy('status_name')->map->count();

        $asset_tagging_status = Asset::query()
        ->when($location_id !== '*', function ($query) use ($location_id) {
            return $query->where('location_id', $location_id);
        })
        ->pluck('_snipeit_asset_tagging_status_yn_53')
        ->countBy();


        return response()->json([
            // 'location_id' => $location_id,
            'asset_status' => $status,
            'asset_tagging_status' => $asset_tagging_status
        ]);
    }

    private function getExpiringAssets(array $timeBuckets = [30, 60, 90])
    {
        $now = \Carbon\Carbon::now();
        $expiringSoon = [];

        foreach ($timeBuckets as $bucket) {
            $expiringSoon["{$bucket}_days"] = 0;
        }

        $assets = \App\Models\Asset::whereNotNull('purchase_date')
                                ->whereNotNull('warranty_months')
                                ->get();

        foreach ($assets as $asset) {
            $warrantyExpiryDate = \Carbon\Carbon::parse($asset->purchase_date)->addMonths($asset->warranty_months);
            $daysToExpire = $now->diffInDays($warrantyExpiryDate, false);

            foreach ($timeBuckets as $bucket) {
                $previousBucket = $timeBuckets[array_search($bucket, $timeBuckets) - 1] ?? 0;
                if ($daysToExpire <= $bucket && $daysToExpire > $previousBucket) {
                    $expiringSoon["{$bucket}_days"]++;
                }
            }
        }

        return $expiringSoon;
    }

    private function getAssetAgeDistribution()
    {
        $now = \Carbon\Carbon::now();

        // Define the ranges dynamically
        $ranges = [
            '0-1_year' => [0, 1],
            '1-2_years' => [1, 2],
            '2-3_years' => [2, 3],
            '3-4_years' => [3, 4],
            '4-5_years' => [4, 5],
            '5+_years' => [5, null] // null for open-ended range
        ];

        // Initialize distribution
        $ageDistribution = array_fill_keys(array_keys($ranges), 0);

        // Get assets
        $assets = \App\Models\Asset::whereNotNull('purchase_date')->get();

        foreach ($assets as $asset) {
            $assetAgeInYears = $now->diffInYears(\Carbon\Carbon::parse($asset->purchase_date));

            // Determine the range
            foreach ($ranges as $label => [$min, $max]) {
                if (($min === null || $assetAgeInYears >= $min) &&
                    ($max === null || $assetAgeInYears < $max)) {
                    $ageDistribution[$label]++;
                    break;
                }
            }
        }

        return $ageDistribution;
    }


    public function getLicenseUtilization()
    {
        $licenses = \App\Models\License::with('manufacturer')->get(); // Adjust if relationships differ

        $licenseData = $licenses->map(function ($license) {
            $usedSeats = $license->used_seats;
            $totalSeats = $license->total_seats;

            return [
                'name' => $license->name,
                'manufacturer' => $license->manufacturer->name ?? 'Unknown',
                'seats' => $totalSeats,
                'used' => $usedSeats,
                'available' => $totalSeats - $usedSeats,
                'utilization_rate' => $totalSeats > 0 ? round(($usedSeats / $totalSeats) * 100, 2) . '%' : 'N/A',
                'expiry_date' => $license->expiry_date ? $license->expiry_date->format('Y-m-d') : 'No Expiry',
            ];
        });

        return response()->json(['total'=>sizeof($licenseData), 'rows' => $licenseData]);
    }


    // public function getLicenseUtilization(Request $request)
    // {
    //     // Get pagination parameters from the request
    //     $perPage = $request->input('limit', 20); // Default to 20 records per page
    //     $page = $request->input('page', 1); // Default to the first page

    //     // Fetch paginated licenses
    //     $licensesQuery = \App\Models\License::with('manufacturer');

    //     // Apply sorting if needed
    //     if ($request->has('sort') && $request->has('order')) {
    //         $licensesQuery->orderBy($request->input('sort'), $request->input('order'));
    //     }

    //     // Use pagination
    //     $licenses = $licensesQuery->paginate($perPage, ['*'], 'page', $page);

    //     // Map data for the response
    //     $licenseData = $licenses->items();
    //     $transformedData = collect($licenseData)->map(function ($license) {
    //         $usedSeats = $license->used_seats;
    //         $totalSeats = $license->total_seats;

    //         return [
    //             'name' => $license->name,
    //             'manufacturer' => $license->manufacturer->name ?? 'Unknown',
    //             'seats' => $totalSeats,
    //             'used' => $usedSeats,
    //             'available' => $totalSeats - $usedSeats,
    //             'utilization_rate' => $totalSeats > 0 ? round(($usedSeats / $totalSeats) * 100, 2) . '%' : 'N/A',
    //             'expiry_date' => $license->expiry_date ? $license->expiry_date->format('Y-m-d') : 'No Expiry',
    //         ];
    //     });

    //     // Return paginated response
    //     return response()->json([
    //         'total' => $licenses->total(), // Total records in the database
    //         'per_page' => $licenses->perPage(), // Records per page
    //         'current_page' => $licenses->currentPage(), // Current page number
    //         'last_page' => $licenses->lastPage(), // Total number of pages
    //         'rows' => $transformedData, // Data for the current page
    //     ]);
    // }



    private function getSoftwareAllocationByDepartment()
    {
        $allocationData = \DB::table('license_seats as ls')
            ->join('users as u', 'ls.assigned_to', '=', 'u.id')
            ->join('departments as d', 'u.department_id', '=', 'd.id')
            ->join('licenses as l', 'ls.license_id', '=', 'l.id')
            ->selectRaw('
                d.name AS department_name,
                l.seats AS total_seats,
                COUNT(ls.id) AS used_seats,
                (l.seats - COUNT(ls.id)) AS available_seats
            ')
            ->groupBy('d.id', 'd.name', 'l.seats')
            ->get();

        $allocations = [];
        foreach ($allocationData as $allocation) {
            $allocations[] = [
                'department' => $allocation->department_name,
                'total_seats' => $allocation->total_seats,
                'used_seats' => $allocation->used_seats,
                'available_seats' => $allocation->available_seats,
            ];
        }

        return $allocations;
    }


}