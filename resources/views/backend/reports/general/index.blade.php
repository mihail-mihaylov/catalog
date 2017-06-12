@extends('backend.wrapper')

@section('page_title')
    <div class="col-md-8">
        {{ trans('dashboard.general_report_for') }}
        @if ($device->first())
            {!! $device->first()->trackedObject->identification_number !!}
            <input type="hidden" class="device_id" device-id="{{ $device->first()->id }}" value="{{ $device->first()->id }}">
        @endif
        @if ($device->first() && $driver->first())
            /
        @endif
        @if ($driver->first())
            {!! $driver->first()->translation->first()->first_name !!} {!! $driver->first()->translation->first()->last_name !!}
        @endif
    </div>
@endsection

@section('content')
    <div class="data-locale" data-locale="{{ App::getLocale() }}"></div>

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
                                <th class="text-left">{{ trans("general.run") }}<sup>{{ trans('general.gps') }}</sup></th>
                                <th class="text-left">{{ trans("general.run") }}<sup>{{ trans('general.can') }}</sup></th>
                                <th class="text-left">{{ trans("dashboard.general_report_time") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_ignition") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_drive_off") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_parked") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_first_move") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_last_move") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_max_speed") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_actions") }}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th class="text-left">{{ trans("dashboard.general_report_date") }}</th>
                                <th class="text-left">{{ trans("general.run") }}<sup>{{ trans('general.gps') }}</sup></th>
                                <th class="text-left">{{ trans("general.run") }}<sup>{{ trans('general.can') }}</sup></th>
                                <th class="text-left">{{ trans("dashboard.general_report_time") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_ignition") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_drive_off") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_parked") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_first_move") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_last_move") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_max_speed") }}</th>
                                <th class="text-left">{{ trans("dashboard.general_report_actions") }}</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                                $start = Carbon\Carbon::parse($from);
                                $end = Carbon\Carbon::parse($to);
                                $pointer = 0;
                            ?>
                            @while ($start->lte($end))
                                @if (isset($generalReports[$start->format('d.m.Y')]))
                                    <?php
                                        $report = $generalReports[$start->format('d.m.Y')];
                                    ?>
                                    <tr id="report-{{ $start->format('Y-m-d') }}">
                                        <td></td>
                                        <td>
                                            <span style="display:none">{{ $start->format('Y.m.d') }}</span> {{--Sorting--}}
                                            {{ $start->format('d.m.Y') }}
                                        </td>
                                        <td class="col-md-1">
                                            {{ round($report['total_distance'], 1) }} {{ trans('general.km') }}
                                        </td>
                                        <td class="col-md-1">
                                            {{ round($report['total_distance_can'], 1) }} {{ trans('general.km') }}
                                        </td>
                                        <td>
                                            @if (isset($report['move_time']))
                                                <strong>
                                                    {{ gmdate("H:i", (int)$report['move_time']) }} {{ trans('general.hours') }}
                                                </strong>
                                                <input type="hidden" class="move_time" value="{{ $report['move_time'] }}">
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($report['work_hours']))
                                                <strong>
                                                    <!-- Vreme zapalen (curr. Work hours) -->
                                                    {{ gmdate("H:i", (int)$report['work_hours']) }} {{ trans('general.hours') }}
                                                    <input type="hidden" class="work_hours" value="{{ $report['work_hours'] }}">
                                                </strong>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $report['first_move']['address'] }}
                                        </td>
                                        <td>
                                            {{ $report['last_move']['address'] }}
                                        </td>
                                        <td>
                                            {{ Carbon\Carbon::parse($report['first_move']['time'])->format(' H:i:s') }} {{ trans('general.hours') }}
                                        </td>
                                        <td>
                                            {{ Carbon\Carbon::parse($report['last_move']['time'])->format(' H:i:s') }} {{ trans('general.hours') }}
                                        </td>
                                        <td>
                                            {{ round($report['max_speed'], 0) }} {{ trans('general.km_hours') }}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-default change-map-to btn-xs" tripdate="{!! Carbon\Carbon::parse($start)->format('Y-m-d+23:59:59') !!}">
                                                <i class="fa fa-eye"></i>
                                                {{ trans('dashboard.general_report_thorough') }}
                                            </button>
                                        </td>
                                    </tr>
                                @else
                                    @if ($pointer != 0)
                                        <tr>
                                            <td></td>
                                            <td>
                                                <span style="display:none">{{ $start->format('Y.m.d') }}</span> {{--Sorting--}}
                                                {{ $start->format('d.m.Y') }}
                                            </td>
                                            <td>{{ trans('dashboard.general_report_no_data') }}</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                    @endif
                                @endif
                                <?php
                                    $start->addDay();
                                    $pointer++;
                                ?>
                            @endwhile
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
                            {{ trans('dashboard.general_report_display_objects') }}
                        </label>
                        <div>
                            <input type="checkbox" id="showpois" data-switchery="true" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><i class="glyphicon glyphicon-cog"></i>&nbsp; {{ trans('dashboard.general_report_daily_eco_drive') }}</h5>
                </div>
                <div class="ibox-content text-center">
                    <div id="efective-work"></div>
                    <label class=""></label>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="trips-panel">
        <div class="col-md-12">
            <div class="ibox" id="general_reports_trips_list">
                <div class="ibox-title fix-ibox-title">
                    <div class="col-md-5 fix-title">
                        <h5>
                            <i class="glyphicon glyphicon-fast-forward"></i>&nbsp;
                            {{ trans('general.list_of') }} {{ trans('dashboard.general_report_courses_today') }}
                        </h5>
                    </div>
                    <div class="ibox-tools">
                        <div class="general_reports_trips_search"></div>
                    </div>
                </div>

                <div class="ibox-content">
                    <table id="tripstable" class="table table-bordered table-striped text-left table-hover tripstable">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-left">
                                    <input type="checkbox" checked id="check_all_trips"></input>
                                </th>
                                <th class="text-left">{{ trans('dashboard.general_report_courses_number') }}</th>
                                <th class="text-left">{{ trans('dashboard.general_report_courses_driver') }}</th>
                                <th class="text-left">{{ trans('dashboard.general_report_courses_drived_off') }}</th>
                                <th class="text-left">{{ trans('dashboard.general_report_courses_arrived') }}</th>
                                <th class="text-left">{{ trans('dashboard.general_report_courses_travelled_hours') }}</th>
                                <th class="text-left col-md-3">{{ trans('dashboard.general_report_courses_from') }}</th>
                                <th class="text-left col-md-3">{{ trans('dashboard.general_report_courses_to') }}</th>
                                <th class="text-left">{{ trans('general.run') }}<sup>{{ trans('general.gps') }}</sup></th>
                                <th class="text-left">{{ trans('general.run') }}<sup>{{ trans('general.can') }}</sup></th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th></th>
                                <th class="text-left">{{ trans('dashboard.general_report_courses_show') }}</th>
                                <th class="text-left">{{ trans('dashboard.general_report_courses_number') }}</th>
                                <th class="text-left">{{ trans('dashboard.general_report_courses_driver') }}</th>
                                <th class="text-left">{{ trans('dashboard.general_report_courses_drived_off') }}</th>
                                <th class="text-left">{{ trans('dashboard.general_report_courses_arrived') }}</th>
                                <th class="text-left">{{ trans('dashboard.general_report_courses_travelled_hours') }}</th>
                                <th class="text-left col-md-3">{{ trans('dashboard.general_report_courses_from') }}</th>
                                <th class="text-left col-md-3">{{ trans('dashboard.general_report_courses_to') }}</th>
                                <th class="text-left">{{ trans('general.run') }}<sup>{{ trans('general.gps') }}</sup></th>
                                <th class="text-left">{{ trans('general.run') }}<sup>{{ trans('general.can') }}</sup></th>
                            </tr>
                        </tfoot>

                        <tbody>
                            {{-- Fill from ajax request --}}
                        </tbody>
                    </table>
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
