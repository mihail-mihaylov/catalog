@extends('backend.wrapper')

@section('page_title')
    {{ trans("dashboard.panel_title") }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title fix-ibox-title">
                    <div class="col-md-6 fix-title">
                        <h5>
                            <i class="glyphicon glyphicon-map-marker"></i>
                            {{ trans("dashboard.panel_subtitle") }}
                        </h5>
                    </div>
                    <div class="ibox-tools">
                        <button class="btn btn-custom btn-sm" type="button" id="fit-points">
                            <i class="glyphicon glyphicon-eye-open"></i>
                            &nbsp; {{ trans('dashboard.focus') }}
                        </button>
                    </div>
                </div>

                @include('backend.dashboard.partials.map')
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="ibox" id="dashboard_devices_list">
                <div class="ibox-title fix-ibox-title">
                    <div class="col-md-5 fix-title">
                        <h5>
                            <i class="glyphicon glyphicon-list"></i>
                            {{ trans('dashboard.list') }}
                        </h5>
                    </div>

                    <div class="ibox-tools">
                        <div class="dashboard_devices_search inline"></div>
                    </div>
                </div>

                <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover table-condensed" id="devicesTable">
                        <thead class="">
                            <tr class="gradeX">
                                <th></th>
                                <th>{{ trans("dashboard.name") }}</th>
                                <th>{{ trans("dashboard.identification_number") }}</th>
                                <th>{{ trans("dashboard.last_event")}}</th>
                                <th>{{ trans("dashboard.actions") }}</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr class="gradeX">
                                <th></th>
                                <th>{{ trans("dashboard.name") }}</th>
                                <th>{{ trans("dashboard.identification_number") }}</th>
                                <th>{{ trans("dashboard.last_event")}}</th>
                                <th>{{ trans("dashboard.actions") }}</th>
                            </tr>
                        </tfoot>

                        <tbody>
                            @if ( ! empty($devicesLastData))
                                @foreach ($devicesLastData as $key => $device)
                                    @include ('backend.dashboard.partials.devices_row')
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    {!! Html::script('js/modules/dashboard/dashboard.js') !!}
    {!! Html::script('/js/data-tables.js') !!}
@endsection
