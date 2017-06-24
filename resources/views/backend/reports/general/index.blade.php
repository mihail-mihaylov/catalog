@extends('backend.wrapper')

@section('page_title')
    <div class="col-md-8">
        {{ trans('dashboard.general_report_for') }}
        {!! $device->name !!}
        <input type="hidden" class="device_id" device-id="{{ $device->id }}" value="{{ $device->id }}">
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox" id="general_reports_list">
                <div class="ibox-title fix-ibox-title">
                    <div class="col-md-5 fix-title">
                        <h5>
                            <i class="glyphicon glyphicon-list"></i>
                            {{ trans('dashboard.general_report_daily_information') }}
                        </h5>
                    </div>
                    <div class="ibox-tools">
                        <div class="general_reports_search"></div>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered table-striped text-left table-condensed generalreportstable" id="generalreportstable">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-left">{{ trans("dashboard.general_report_date") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_first_move") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_last_move") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_actions") }}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th class="text-left">{{ trans("dashboard.general_report_date") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_first_move") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_last_move") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_actions") }}</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($events as $date => $day)
                                <tr>
                                    <td></td>
                                    <td>{{ $date }}</td>
                                    <td>{{ \Carbon\Carbon::parse(reset($day)['gps_utc_time'])->format('H:m') }}</td>
                                    <td>{{ \Carbon\Carbon::parse(end($day)['gps_utc_time'])->format('H:m') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-default change-map-to btn-xs" tripdate="{!! $date !!}">
                                            <i class="fa fa-eye"></i>
                                            {{ trans('dashboard.general_report_thorough') }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="map-pois-panel">
        <div class="col-md-9">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><i class="glyphicon glyphicon-road"></i>
                        &nbsp;{{ trans('dashboard.general_report_daily_detailed_view') }} </h5>
                </div>
                <div class="ibox-content no-padding">
                    <div id="map" style="height:512px;width:100%;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>
                        <i class="glyphicon glyphicon-cog"></i>&nbsp;
                        {{ trans('dashboard.general_report_preferences') }}
                    </h5>
                </div>
                <div class="ibox-content">
                    <div class="control-group">
                        <label class="control-label col-sm-8">
                            {{ trans('dashboard.general_report_display_poi') }}
                        </label>
                        <div>
                            <input type="checkbox" id="showpois" data-switchery="true" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    {!! Html::script('js/modules/reports/general.report.js') !!}
    {!! Html::script('js/modules/pois/loadPois.js') !!}
    {!! Html::script('js/data-tables.js') !!}
@endsection
