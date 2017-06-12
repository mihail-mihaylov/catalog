@extends('backend.wrapper')

@section('page_title')
    <div class="col-md-6">
        {{ trans('reports.fuel_report') }}
    </div>
    </h2><!-- Close h2 tag from page_title, so print buttons can be normal size -->

    <div class="col-md-6 hidden-print" id="data-tables-actions">
        {{--<a class="btn btn-custom btn-sm pull-right" id="saveAsExcel"><i class="glyphicon glyphicon-save"></i> {{ trans('general.export_to_excel') }} --}}
        {{--</a>--}}
    </div>
    <h2><!-- Open h2 tag from page_title, not to die -->
@endsection

@section('content')
    <div class="row">
        <div class="hidden" id="no_data_translation" data-translation="{{ trans('general.no_data') }}"></div>

        <div class="col-md-12">
            <div class="ibox" id="fuel_reports_list">
                <div class="ibox-title fix-ibox-title hidden-print">
                    <div class="col-md-7 fix-title">
                        <h5>
                            <i class="glyphicon glyphicon-list"></i>
                            {{ trans('reports.report_of') }}:
                            {{ \Carbon\Carbon::parse($from)->format('Y.m.d') }}  -
                            {{ \Carbon\Carbon::parse($to)->format('Y.m.d') }}
                        </h5>
                    </div>
                    <div class="ibox-tools">
                        <div class="fuel_reports_search"></div>
                    </div>
                </div>
                <div class="ibox-content">
                    <input type="hidden" id="from" name="from" value="{{ $from }}">
                    <input type="hidden" id="to" name="to" value="{{ $to }}">
                    <div class="hidden input-group date">
                        {!! Form::text( 'hiddenLastDate', '', ['class' => 'form-control', 'id' => 'hiddenLastDate']) !!}
                    </div>
                    <table class="table table-bordered table-striped text-left table-condensed fuelReportTable display responsive" id="fuelReportTable">
                        <thead>
                            <tr class="gradeX">
                                <th></th>
                                <th>{{ trans('general.name') }}</th>
                                <th>{{ trans('general.identification_number') }}</th>
                                <th>{{ trans('reports.fuel.distance') }}</th>
                                <th>{{ trans('reports.fuel.used_fuel') }}</th>
                                <th>{{ trans('reports.fuel.average_expense') }}</th>
                                <th>{{ trans('reports.fuel.end_mileage') }}</th>
                                <th>{{ trans('reports.fuel.fuel_level') }}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="gradeX">
                                <th></th>
                                <th>{{ trans('general.name') }}</th>
                                <th>{{ trans('general.identification_number') }}</th>
                                <th>{{ trans('reports.fuel.distance') }}</th>
                                <th>{{ trans('reports.fuel.used_fuel') }}</th>
                                <th>{{ trans('reports.fuel.average_expense') }}</th>
                                <th>{{ trans('reports.fuel.end_mileage') }}</th>
                                <th>{{ trans('reports.fuel.fuel_level') }}</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($devices as $deviceId => $device)
                                <tr id="device_{{ $deviceId }}">
                                    <td></td>
                                    <td>{{ $device['tracked_object_name'] }}</td>
                                    <td>{{ $device['tracked_object_id'] }}</td>
                                    <td>{{ round($device['distance'],1) }} {{ trans('general.km') }}</td>
                                    <td>{{ round($device['used_fuel'],1) }} {{ trans('general.litres') }}</td>
                                    <td>
                                        {{ $device['avg_expense'] }}
                                        {{ is_numeric($device['avg_expense']) ? trans('general.litres_per_100_km') : ""}}
                                    </td>
                                    <td>{{ $device['last_total_distance']->total_distance }} {{ trans('general.km') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-default btn-xs see_fuel_level" id="see_fuel_level" data-deviceid="{{ $deviceId }}" data-fuel="{{ route('reports.fuel.get_fuel_level') }}">
                                            <i class="fa fa-eye"></i>
                                            {{ trans('general.see') }}
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

    <div class="row hidden results">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title fix-ibox-title">
                    <div class="col-md-5 fix-title">
                        <h5>
                            <i class="fa fa-bar-chart-o"></i>
                            &nbsp; {{ trans('reports.results') }}
                        </h5>
                    </div>
                    <div class="ibox-tools">
                        <button id="clear_fuel_diagrams" class="btn btn-sm btn-custom">
                            <i class="fa fa-trash-o"></i>
                            {{ trans('general.clear') }}
                        </button>
                    </div>
                </div>

                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12 graphs"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    {!! Html::script('js/modules/reports/fuel.js') !!}

@endsection
