@extends('layouts/default')
{{-- Page title --}}
@section('title')
{{ trans('general.dashboard') }}
@parent
@stop


{{-- Page content --}}
@section('content')

@if ($snipeSettings->dashboard_message!='')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        {!!  Helper::parseEscapedMarkedown($snipeSettings->dashboard_message)  !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
  <!-- panel -->
  <div class="col-lg-2 col-xs-6">
      <a href="{{ route('hardware.index') }}">
    <!-- small box -->
    <div class="dashboard small-box bg-teal">
      <div class="inner">
        <h3>{{ number_format(\App\Models\Asset::AssetsForShow()->count()) }}</h3>
        <p>{{ trans('general.assets') }}</p>
      </div>
      <div class="icon" aria-hidden="true">
          <x-icon type="assets" />
      </div>
      @can('index', \App\Models\Asset::class)
        <a href="{{ route('hardware.index') }}" class="small-box-footer">{{ trans('general.view_all') }}
            <x-icon type="arrow-circle-right" />
        </a>
      @endcan
    </div>
      </a>
  </div><!-- ./col -->

  <div class="col-lg-2 col-xs-6">
     <a href="{{ route('licenses.index') }}">
    <!-- small box -->
    <div class="dashboard small-box bg-maroon">
      <div class="inner">
        <h3>{{ number_format($counts['license']) }}</h3>
        <p>{{ trans('general.licenses') }}</p>
      </div>
      <div class="icon" aria-hidden="true">
          <x-icon type="licenses" />
      </div>
        @can('view', \App\Models\License::class)
          <a href="{{ route('licenses.index') }}" class="small-box-footer">{{ trans('general.view_all') }}
              <x-icon type="arrow-circle-right" />
          </a>
        @endcan
    </div>
     </a>
  </div><!-- ./col -->


  <div class="col-lg-2 col-xs-6">
    <!-- small box -->
      <a href="{{ route('accessories.index') }}">
    <div class="dashboard small-box bg-orange">
      <div class="inner">
        <h3> {{ number_format($counts['accessory']) }}</h3>
        <p>{{ trans('general.accessories') }}</p>
      </div>
      <div class="icon" aria-hidden="true">
          <x-icon type="accessories" />
      </div>
      @can('index', \App\Models\Accessory::class)
          <a href="{{ route('accessories.index') }}" class="small-box-footer">{{ trans('general.view_all') }}
              <x-icon type="arrow-circle-right" />
          </a>
      @endcan
    </div>
      </a>
  </div><!-- ./col -->

  <div class="col-lg-2 col-xs-6">
    <!-- small box -->

      <a href="{{ route('consumables.index') }}">
    <div class="dashboard small-box bg-purple">
      <div class="inner">
        <h3> {{ number_format($counts['consumable']) }}</h3>
        <p>{{ trans('general.consumables') }}</p>
      </div>
      <div class="icon" aria-hidden="true">
          <x-icon type="consumables" />
      </div>
      @can('index', \App\Models\Consumable::class)
        <a href="{{ route('consumables.index') }}" class="small-box-footer">{{ trans('general.view_all') }}
            <x-icon type="arrow-circle-right" />
        </a>
      @endcan
    </div>
  </div><!-- ./col -->

  <div class="col-lg-2 col-xs-6">
    <a href="{{ route('components.index') }}">
   <!-- small box -->
   <div class="dashboard small-box bg-yellow">
     <div class="inner">
       <h3>{{ number_format($counts['component']) }}</h3>
       <p>{{ trans('general.components') }}</p>
     </div>
     <div class="icon" aria-hidden="true">
         <x-icon type="components" />
     </div>
       @can('view', \App\Models\License::class)
         <a href="{{ route('components.index') }}" class="small-box-footer">{{ trans('general.view_all') }}
             <x-icon type="arrow-circle-right" />
         </a>
       @endcan
   </div>
    </a>
 </div><!-- ./col -->

 <div class="col-lg-2 col-xs-6">
    <a href="{{ route('users.index') }}">
   <!-- small box -->
   <div class="dashboard small-box bg-light-blue">
     <div class="inner">
       <h3>{{ number_format($counts['user']) }}</h3>
       <p>{{ trans('general.people') }}</p>
     </div>
     <div class="icon" aria-hidden="true">
         <x-icon type="users" />
     </div>
       @can('view', \App\Models\License::class)
         <a href="{{ route('users.index') }}" class="small-box-footer">{{ trans('general.view_all') }}
             <x-icon type="arrow-circle-right" />
         </a>
       @endcan
   </div>
    </a>
 </div><!-- ./col -->

</div>
</div>

@if ($counts['grand_total'] == 0)

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ trans('general.dashboard_info') }}</h2>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="progress">
                                <div class="progress-bar progress-bar-yellow" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                    <span class="sr-only">{{ trans('general.60_percent_warning') }}</span>
                                </div>
                            </div>


                            <p><strong>{{ trans('general.dashboard_empty') }}</strong></p>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            @can('create', \App\Models\Asset::class)
                            <a class="btn bg-teal" style="width: 100%" href="{{ route('hardware.create') }}">{{ trans('general.new_asset') }}</a>
                            @endcan
                        </div>
                        <div class="col-md-3">
                            @can('create', \App\Models\License::class)
                                <a class="btn bg-maroon" style="width: 100%" href="{{ route('licenses.create') }}">{{ trans('general.new_license') }}</a>
                            @endcan
                        </div>
                        <div class="col-md-3">
                            @can('create', \App\Models\Accessory::class)
                                <a class="btn bg-orange" style="width: 100%" href="{{ route('accessories.create') }}">{{ trans('general.new_accessory') }}</a>
                            @endcan
                        </div>
                        <div class="col-md-3">
                            @can('create', \App\Models\Consumable::class)
                                <a class="btn bg-purple" style="width: 100%" href="{{ route('consumables.create') }}">{{ trans('general.new_consumable') }}</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@else

<!-- recent activity -->
<div class="row">
  <div class="col-md-8">
    <div class="box">
      <div class="box-header with-border">
        <h2 class="box-title">{{ trans('general.recent_activity') }}</h2>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" aria-hidden="true">
                <x-icon type="minus" />
                <span class="sr-only">{{ trans('general.collapse') }}</span>
            </button>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">

                <table
                    data-cookie-id-table="dashActivityReport"
                    data-height="350"
                    data-pagination="false"
                    data-id-table="dashActivityReport"
                    data-side-pagination="server"
                    data-sort-order="desc"
                    data-sort-name="created_at"
                    id="dashActivityReport"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.activity.index', ['limit' => 25]) }}">
                    <thead>
                    <tr>
                        <th data-field="icon" data-visible="true" style="width: 40px;" class="hidden-xs" data-formatter="iconFormatter"><span  class="sr-only">{{ trans('admin/hardware/table.icon') }}</span></th>
                        <th class="col-sm-3" data-visible="true" data-field="created_at" data-formatter="dateDisplayFormatter">{{ trans('general.date') }}</th>
                        <th class="col-sm-2" data-visible="true" data-field="admin" data-formatter="usersLinkObjFormatter">{{ trans('general.admin') }}</th>
                        <th class="col-sm-2" data-visible="true" data-field="action_type">{{ trans('general.action') }}</th>
                        <th class="col-sm-3" data-visible="true" data-field="item" data-formatter="polymorphicItemFormatter">{{ trans('general.item') }}</th>
                        <th class="col-sm-2" data-visible="true" data-field="target" data-formatter="polymorphicItemFormatter">{{ trans('general.target') }}</th>
                    </tr>
                    </thead>
                </table>



            </div><!-- /.responsive -->
          </div><!-- /.col -->
          <div class="text-center col-md-12" style="padding-top: 10px;">
            <a href="{{ route('reports.activity') }}" class="btn btn-primary btn-sm" style="width: 100%">{{ trans('general.viewall') }}</a>
          </div>
        </div><!-- /.row -->
      </div><!-- ./box-body -->
    </div><!-- /.box -->
  </div>
  <div class="col-md-4">
        <div class="box box-default">
            <div class="box-header with-border">
                <h2 class="box-title">
                    {{ (\App\Models\Setting::getSettings()->dash_chart_type == 'name') ? trans('general.assets_by_status') : trans('general.assets_by_status_type') }}
                </h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" aria-hidden="true">
                        <x-icon type="minus" />
                        <span class="sr-only">{{ trans('general.collapse') }}</span>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="chart-responsive">
                            <canvas id="statusPieChart" height="260"></canvas>
                        </div> <!-- ./chart-responsive -->
                    </div> <!-- /.col -->
                </div> <!-- /.row -->
            </div><!-- /.box-body -->
        </div> <!-- /.box -->
  </div>

</div> <!--/row-->
<div class="row">
    <div class="col-md-6">

		@if ($snipeSettings->full_multiple_companies_support=='1')
			 <!-- Companies -->	
			<div class="box box-default">
				<div class="box-header with-border">
					<h2 class="box-title">{{ trans('general.companies') }}</h2>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <x-icon type="minus" />
							<span class="sr-only">{{ trans('general.collapse') }}</span>
						</button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
							<table
									data-cookie-id-table="dashCompanySummary"
									data-height="400"
									data-pagination="true"
									data-side-pagination="server"
									data-sort-order="desc"
									data-sort-field="assets_count"
									id="dashCompanySummary"
									class="table table-striped snipe-table"
									data-url="{{ route('api.companies.index', ['sort' => 'assets_count', 'order' => 'asc']) }}">

								<thead>
								<tr>
									<th class="col-sm-3" data-visible="true" data-field="name" data-formatter="companiesLinkFormatter" data-sortable="true">{{ trans('general.name') }}</th>
									<th class="col-sm-1" data-visible="true" data-field="users_count" data-sortable="true">
                                        <x-icon type="users" />
										<span class="sr-only">{{ trans('general.people') }}</span>
									</th>
									<th class="col-sm-1" data-visible="true" data-field="assets_count" data-sortable="true">
                                        <x-icon type="assets" />
										<span class="sr-only">{{ trans('general.asset_count') }}</span>
									</th>
									<th class="col-sm-1" data-visible="true" data-field="accessories_count" data-sortable="true">
                                        <x-icon type="accessories" />
										<span class="sr-only">{{ trans('general.accessories_count') }}</span>
									</th>
									<th class="col-sm-1" data-visible="true" data-field="consumables_count" data-sortable="true">
                                        <x-icon type="consumables" />
										<span class="sr-only">{{ trans('general.consumables_count') }}</span>
									</th>
									<th class="col-sm-1" data-visible="true" data-field="components_count" data-sortable="true">
                                        <x-icon type="components" />
										<span class="sr-only">{{ trans('general.components_count') }}</span>
									</th>
									<th class="col-sm-1" data-visible="true" data-field="licenses_count" data-sortable="true">
                                        <x-icon type="licenses" />
										<span class="sr-only">{{ trans('general.licenses_count') }}</span>
									</th>
								</tr>
								</thead>
							</table>
							</div>
						</div> <!-- /.col -->
						<div class="text-center col-md-12" style="padding-top: 10px;">
							<a href="{{ route('companies.index') }}" class="btn btn-primary btn-sm" style="width: 100%">{{ trans('general.viewall') }}</a>
						</div>
					</div> <!-- /.row -->

				</div><!-- /.box-body -->
			</div> <!-- /.box -->
		
		@else
			 <!-- Locations -->
			 <div class="box box-default">
				<div class="box-header with-border">
					<h2 class="box-title">{{ trans('general.locations') }}</h2>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <x-icon type="minus" />
							<span class="sr-only">{{ trans('general.collapse') }}</span>
						</button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
							<table
									data-cookie-id-table="dashLocationSummary"
									data-height="400"
									data-pagination="true"
									data-side-pagination="server"
									data-sort-order="desc"
									data-sort-field="assets_count"
									id="dashLocationSummary"
									class="table table-striped snipe-table"
									data-url="{{ route('api.locations.index', ['sort' => 'assets_count', 'order' => 'asc']) }}">

								<thead>
								<tr>
									<th class="col-sm-3" data-visible="true" data-field="name" data-formatter="locationsLinkFormatter" data-sortable="true">{{ trans('general.name') }}</th>
									
									<th class="col-sm-1" data-visible="true" data-field="assets_count" data-sortable="true">
                                        <x-icon type="assets" />
										<span class="sr-only">{{ trans('general.asset_count') }}</span>
									</th>
									<th class="col-sm-1" data-visible="true" data-field="assigned_assets_count" data-sortable="true">
										
										{{ trans('general.assigned') }}
									</th>
									<th class="col-sm-1" data-visible="true" data-field="users_count" data-sortable="true">
                                        <x-icon type="users" />
										<span class="sr-only">{{ trans('general.people') }}</span>
										
									</th>
									
								</tr>
								</thead>
							</table>
							</div>
						</div> <!-- /.col -->
						<div class="text-center col-md-12" style="padding-top: 10px;">
							<a href="{{ route('locations.index') }}" class="btn btn-primary btn-sm" style="width: 100%">{{ trans('general.viewall') }}</a>
						</div>
					</div> <!-- /.row -->

				</div><!-- /.box-body -->
			</div> <!-- /.box -->
        <div>
</div>

		@endif
			
</div>
    <div class="col-md-6">

        <!-- Categories -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h2 class="box-title">{{ trans('general.asset') }} {{ trans('general.categories') }}</h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <x-icon type="minus" />
                        <span class="sr-only">{{ trans('general.collapse') }}</span>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                        <table
                                data-cookie-id-table="dashCategorySummary"
                                data-height="400"
                                data-pagination="true"
                                data-side-pagination="server"
                                data-sort-order="desc"
                                data-sort-field="assets_count"
                                id="dashCategorySummary"
                                class="table table-striped snipe-table"
                                data-url="{{ route('api.categories.index', ['sort' => 'assets_count', 'order' => 'asc']) }}">

                            <thead>
                            <tr>
                                <th class="col-sm-3" data-visible="true" data-field="name" data-formatter="categoriesLinkFormatter" data-sortable="true">{{ trans('general.name') }}</th>
                                <th class="col-sm-3" data-visible="true" data-field="category_type" data-sortable="true">
                                    {{ trans('general.type') }}
                                </th>
                                <th class="col-sm-1" data-visible="true" data-field="assets_count" data-sortable="true">
                                    <x-icon type="assets" />
                                    <span class="sr-only">{{ trans('general.asset_count') }}</span>
                                </th>
                                <th class="col-sm-1" data-visible="true" data-field="accessories_count" data-sortable="true">
                                    <x-icon type="licenses" />
                                    <span class="sr-only">{{ trans('general.accessories_count') }}</span>
                                </th>
                                <th class="col-sm-1" data-visible="true" data-field="consumables_count" data-sortable="true">
                                    <x-icon type="consumables" />
                                    <span class="sr-only">{{ trans('general.consumables_count') }}</span>
                                </th>
                                <th class="col-sm-1" data-visible="true" data-field="components_count" data-sortable="true">
                                    <x-icon type="components" />
                                    <span class="sr-only">{{ trans('general.components_count') }}</span>
                                </th>
                                <th class="col-sm-1" data-visible="true" data-field="licenses_count" data-sortable="true">
                                    <x-icon type="licenses" />
                                    <span class="sr-only">{{ trans('general.licenses_count') }}</span>
                                </th>
                            </tr>
                            </thead>
                        </table>
                        </div>
                    </div> <!-- /.col -->
                    <div class="text-center col-md-12" style="padding-top: 10px;">
                        <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm" style="width: 100%">{{ trans('general.viewall') }}</a>
                    </div>
                </div> <!-- /.row -->

            </div><!-- /.box-body -->
        </div> <!-- /.box -->
    </div>

    <div class="col-md-6">

        <!-- Software License Expiry -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h2 class="box-title">{{ trans('Software') }} {{ trans('License Expiry') }}</h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <x-icon type="minus" />
                        <span class="sr-only">{{ trans('general.collapse') }}</span>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <canvas id="warrantyExpiryChart" width="400" height="200"></canvas>
                        </div>
                    </div> <!-- /.col -->
                    <div class="text-center col-md-12" style="padding-top: 10px;">
                        <a href="{{ route('licenses.index') }}" class="btn btn-primary btn-sm" style="width: 100%">{{ trans('general.viewall') }}</a>
                    </div>
                </div> <!-- /.row -->

            </div><!-- /.box-body -->
        </div> <!-- /.box -->
    </div>

    <div class="col-md-6">

        <!-- Asset Age -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h2 class="box-title">{{ trans('general.asset') }} {{ trans('Age Analysis') }}</h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <x-icon type="minus" />
                        <span class="sr-only">{{ trans('general.collapse') }}</span>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <canvas id="assetAgeChart" width="400" height="200"></canvas>
                        </div> 
                    </div> <!-- /.col -->
                    <div class="text-center col-md-12" style="padding-top: 10px;">
                        <a href="{{ route('hardware.index') }}?order=desc&sort=purchase_date" class="btn btn-primary btn-sm" style="width: 100%">{{ trans('general.viewall') }}</a>
                    </div>
                </div> <!-- /.row -->

            </div><!-- /.box-body -->
        </div> <!-- /.box -->
    </div>

    <div class="col-md-6">
        <!-- License Utilization Rate -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h2 class="box-title">License Utilization Rate</h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <x-icon type="minus" />
                        <span class="sr-only">{{ trans('general.collapse') }}</span>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table
                                data-cookie-id-table="dashActivityReport"
                                data-height="350"
                                data-pagination="true"
                                data-id-table="dashActivityReport"
                                data-side-pagination="server"
                                id="licenseUtilizationTable"
                                class="table table-striped snipe-table"
                                data-url="{{ route('api.licenses.utilization', ['sort' => 'utilization_rate', 'order' => 'asc']) }}?page=1&limit=20">                       
                                <thead>
                                    <tr>
                                        <th class="col-sm-3" data-visible="true" data-field="name" data-formatter="categoriesLinkFormatter" data-sortable="true">{{ trans('general.name') }}</th>
                                        <th class="col-sm-2" data-visible="true" data-field="manufacturer" data-sortable="true">{{ trans('general.manufacturer') }}</th>
                                        <th class="col-sm-2" data-visible="true" data-field="seats" data-sortable="true">{{ trans('Seats') }}</th>
                                        <th class="col-sm-2" data-visible="true" data-field="used" data-sortable="true">{{ trans('Used') }}</th>
                                        <th class="col-sm-2" data-visible="true" data-field="available" data-sortable="true">{{ trans('Available') }}</th>
                                        <th class="col-sm-2" data-visible="true" data-field="utilization_rate" data-sortable="true">{{ trans('Utilization rate') }}</th>
                                        <th class="col-sm-2" data-visible="true" data-field="expiry_date" data-sortable="true">{{ trans('Expiry date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- /.col -->
                    <div class="text-center col-md-12" style="padding-top: 10px;">
                        <a href="{{ route('licenses.index') }}" class="btn btn-primary btn-sm" style="width: 100%">{{ trans('general.viewall') }}</a>
                    </div>
                </div> <!-- /.row -->
            </div><!-- /.box-body -->
        </div> <!-- /.box -->
    </div>

    <div class="col-md-6">

        <!-- departmental Software Allocation Chart -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h2 class="box-title">{{ trans('Departmental') }} {{ trans('Software Allocation') }}</h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <x-icon type="minus" />
                        <span class="sr-only">{{ trans('general.collapse') }}</span>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <canvas id="departmentalSoftwareAllocationChart" width="400" height="200"></canvas>
                        </div> 
                    </div> <!-- /.col -->
                    <div class="text-center col-md-12" style="padding-top: 10px;">
                        <a href="{{ route('licenses.index') }}?order=desc&sort=purchase_date" class="btn btn-primary btn-sm" style="width: 100%">{{ trans('general.viewall') }}</a>
                    </div>
                </div> <!-- /.row -->

            </div><!-- /.box-body -->
        </div> <!-- /.box -->
    </div>

</div>






<div>
    <!-- Slicer -->
    <div class="row">
        <!-- Location Dropdown (Slicer) -->
        <div class="col-lg-2 form-group">
            <label for="locationSelect">Select Location</label>
            <select id="locationSelect" class="form-control">
                <option value="*">--Select Location--</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <!-- Charts Section -->

        <div class="col-md-6">

            <!-- Asset Tagging Status -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ trans('Asset') }} {{ trans('Tagging Status') }}</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <x-icon type="minus" />
                            <span class="sr-only">{{ trans('general.collapse') }}</span>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <canvas id="assetTaggingChart" width="400" height="200"></canvas>
                            </div>
                        </div> <!-- /.col -->
                    
                    </div> <!-- /.row -->

                </div><!-- /.box-body -->
            </div> <!-- /.box -->
        </div>



        <div class="col-md-6">

            <!-- Asset Status -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ trans('Asset') }} {{ trans('Status') }}</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <x-icon type="minus" />
                            <span class="sr-only">{{ trans('general.collapse') }}</span>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <canvas id="assetStatusChart" width="400" height="200"></canvas>
                            </div>
                        </div> <!-- /.col -->
                    
                    </div> <!-- /.row -->

                </div><!-- /.box-body -->
            </div> <!-- /.box -->
        </div>
    </div>

</div>





    

@endif


@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['simple_view' => true, 'nopages' => true])
@stop

@push('js')



<script nonce="{{ csrf_token() }}">


    var assetTaggingChart, assetStatusChart;

    function fetchChartData(locationId) {
        $.ajax({
            url: '{{ route('api.dashboard.slicer') }}',
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            method: 'GET',
            data: { location_id: locationId || '*' }, // Use '*' for all locations
            success: function(response) {
                updateCharts(response);
            },
            error: function() {
                alert('Error fetching data');
            }
        });
    }

    function updateCharts(data) {
        // Asset Tagging Status Chart
        const assetTaggingCtx = document.getElementById('assetTaggingChart').getContext('2d');
        const assetTaggingLabels = Object.keys(data.asset_tagging_status);
        const assetTaggingData = Object.values(data.asset_tagging_status);

        if (assetTaggingChart) {
            // Update existing chart
            assetTaggingChart.data.labels = assetTaggingLabels;
            assetTaggingChart.data.datasets[0].data = assetTaggingData;
            assetTaggingChart.update();
        } else {
            // Create new chart
            assetTaggingChart = new Chart(assetTaggingCtx, {
                type: 'pie',
                data: {
                    labels: assetTaggingLabels,
                    datasets: [{
                        data: assetTaggingData,
                        backgroundColor: ['#4CAF50', '#FF5733', '#FFC300', '#D3D3D3'],
                    }]
                },
                options: {
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                                    const value = context.raw;
                                    return `${context.label}: ${(value / total * 100).toFixed(2)}%`;
                                }
                            }
                        }
                    }
                }
            });
        }



        // Update or Create Asset Status Chart
        const assetStatusCtx = document.getElementById('assetStatusChart').getContext('2d');
        const assetStatusLabels = Object.keys(data.asset_status);
        const assetStatusData = Object.values(data.asset_status);

        if (assetStatusChart) {
            // Update existing chart
            assetStatusChart.data.labels = assetStatusLabels;
            assetStatusChart.data.datasets[0].data = assetStatusData;
            assetStatusChart.update();
        } else {
            // Create new chart
            assetStatusChart = new Chart(assetStatusCtx, {
                type: 'bar',
                data: {
                    labels: assetStatusLabels,
                    datasets: [{
                        label: 'Asset Status',
                        data: assetStatusData,
                        backgroundColor: '#3498DB',
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.raw} assets`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }
    }

    $('#locationSelect').on('change', function() {
        const locationId = $(this).val();
        fetchChartData(locationId); // Fetch and update charts
    });

    // Fetch default data on page load
    document.addEventListener('DOMContentLoaded', function() {
        fetchChartData($('#locationSelect').val() || '*');
    });

    // Reusable function to create a chart
    function createChart(chartId, type, labels, data, options, backgroundColors = null) {
        const ctx = document.getElementById(chartId).getContext('2d');
        new Chart(ctx, {
            type: type,
            data: {
                labels: labels,
                datasets: [{
                    label: options.datasetLabel || '',
                    data: data,
                    backgroundColor: backgroundColors || ['#36a2eb', '#ffcd56', '#ff6384', '#aace56', '#45ab29', '#8F00FF']
                }]
            },
            options: options
        });
    }

    // Pie Chart for Asset Status
    document.addEventListener('DOMContentLoaded', function () {
        var pieOptions = {
            legend: {
                position: 'top',
                responsive: true,
                maintainAspectRatio: true,
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        counts = data.datasets[0].data;
                        total = 0;
                        for(var i in counts) {
                            total += counts[i];
                        }
                        prefix = data.labels[tooltipItem.index] || '';
                        return prefix+": "+Math.round(counts[tooltipItem.index]/total*100)+"%";
                    }
                }
            }
        };


        $.ajax({
            type: 'GET',
            url: '{{ (\App\Models\Setting::getSettings()->dash_chart_type == "name") ? route("api.statuslabels.assets.byname") : route("api.statuslabels.assets.bytype") }}',
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            dataType: 'json',
            success: function (data) {
                createChart('statusPieChart', 'pie', data.labels, data.datasets[0].data.map(x=>x*10), pieOptions);
            }
        });

        let lastWidth = document.getElementById('statusPieChart').clientWidth;
        window.addEventListener('resize', function () {
            const currentWidth = document.getElementById('statusPieChart').clientWidth;
            if (currentWidth !== lastWidth) location.reload();
            lastWidth = currentWidth;
        });
    });

    // Bar Chart for Warranty Expiry
    document.addEventListener('DOMContentLoaded', function () {
        const expiringData = @json($expiringSoon);
        const labels = Object.keys(expiringData).map(key => `Expiring in ${key.replace('_', ' ')}`);
        const data = Object.values(expiringData);

        createChart('warrantyExpiryChart', 'bar', labels, data, {
            datasetLabel: 'Software License Expiry',
            chartOptions: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        }, '#ff6666');
    });

    // Pie Chart for Asset Age Distribution
    document.addEventListener('DOMContentLoaded', function () {
        const ageDistribution = @json($ageDistribution);
        const labels = Object.keys(ageDistribution).map(label => label.replace(/_/g, ' '));
        const data = Object.values(ageDistribution);

        createChart('assetAgeChart', 'pie', labels, data, {
            datasetLabel: 'Asset Age Distribution',
            chartOptions: {
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { enabled: true }
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const softwareAllocations = @json($softwareAllocation);
        const labels = softwareAllocations.map(allocation => allocation.department);
        const usedSeatsData = softwareAllocations.map(allocation => allocation.used_seats);
        const totalSeatsData = softwareAllocations.map(allocation => allocation.total_seats);
        const availableSeatsData = softwareAllocations.map(allocation => allocation.available_seats);

        const tooltipTexts = softwareAllocations.map(allocation => {
            return `Used: ${allocation.used_seats}\nAvailable: ${allocation.available_seats}\nTotal: ${allocation.total_seats}`;
        });

        var pieOptions = {
            legend: {
                position: 'top',
                responsive: true,
                maintainAspectRatio: true,
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        counts = data.datasets[0].data;
                        total = 0;
                        for(var i in counts) {
                            total += counts[i];
                        }
                        prefix = data.labels[tooltipItem.index] || '';
                        suffix = tooltipTexts[tooltipItem.index];
                        return prefix+": "+ suffix;
                    }
                }
            }
        };

        createChart('departmentalSoftwareAllocationChart', 'pie', labels, usedSeatsData, pieOptions);
    });
</script>
@endpush
