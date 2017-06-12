@extends('backend.wrapper')

@section('page_title')
    <div class="col-md-6">
        {{ trans('trips.trip_report_of') }}
        @if ($device->first())
            {!! $device->first()->trackedObject->identification_number !!}
        @endif
        @if ($device->first() && $driver->first())
            /
        @endif
        @if ($driver->first())
            {!! $driver->first()->translation->first()->first_name !!} {!! $driver->first()->translation->first()->last_name !!}
        @endif
    </div>
    </h2><!-- Close h2 tag from page_title, so print buttons can be normal size -->

    <div class="col-md-6 hidden-print" id="data-tables-actions">
        <a class="btn btn-custom btn-sm pull-right" id="saveAsExcel"><i class="glyphicon glyphicon-save"></i> {{ trans('general.export_to_excel') }} </a>
    </div>
    <h2><!-- Open h2 tag from page_title, not to die -->
@endsection

@section('content')
    <div class="row visible-print" id="travel-list">
        <div class="col-md-12">
            {!! $travelListWidget !!}
        </div>
    </div>

    <div class="row hidden-print">
        <div class="col-md-12">
            <div class="alert alert-info alert-block">
                <a class="close" data-dismiss="alert" href="#">×</a>
                <h4 class="alert-heading">{{ trans('general.information') }} </h4>
                {{ trans('trips.information_instructions') }}<a href="/reports/trips/travel-list" target="_blank"><i>{{ trans('trips.information_instructions_url_title') }}</i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="ibox" id="trips_reports_list">
                <div class="ibox-title fix-ibox-title hidden-print">
                    <div class="col-md-5 fix-title">
                        <h5>
                            <i class="glyphicon glyphicon-list"></i>
                            {{ trans('trips.list_of_courses') }}:&nbsp;
                            {{ 
                                Carbon\Carbon::createFromFormat('Y-m-d', $startDate)->format('d.m.Y') . " - " . Carbon\Carbon::createFromFormat('Y-m-d', $endDate)->format('d.m.Y')
                            }}
                        </h5>
                    </div>
                    <div class="ibox-tools">
                        <div class="trips_reports_search"></div>
                    </div>
                </div>
                <div class="ibox-content" id="tripsReportDiv">
                    <table class="table table-bordered table-striped text-left table-condensed  tripsReportTable display responsive" id="tripsReportTable">
                        <thead>
                            <tr class="gradeX">
                                <th></th>
                                <th class="text-left col-md-1">
                                    {{ trans('trips.took_off') }}
                                </th>
                                <th class="col-md-3 text-left">
                                    {{ trans('general.from') }}
                                </th>
                                <th class="text-left col-md-1">
                                    {{ trans('trips.arrived') }}
                                </th>
                                <th class="col-md-3 text-left">
                                    {{ trans('general.to') }}
                                </th>
                                <th class="text-left col-md-1">
                                    {{ trans('general.run') }}<sup>{{ trans('general.gps') }}</sup>
                                </th>
                                <th class="text-left col-md-1">
                                    {{ trans('general.run') }}<sup>{{ trans('general.can') }}</sup>
                                </th>
                                <th class="text-left col-md-1">
                                    {{ trans('trips.total_movement') }}
                                </th>
                                <th class="text-left col-md-1">
                                    {{ trans('trips.driver') }}
                                </th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="gradeX">
                                <th></th>
                                <th class="left">
                                    {{ trans('trips.took_off') }}
                                </th>
                                <th class="from">
                                    {{ trans('general.from') }}
                                </th>
                                <th class="arrived">
                                    {{ trans('trips.arrived') }}
                                </th>
                                <th class="to">
                                    {{ trans('general.to') }}
                                </th>
                                <th class="distance">
                                    {{ trans('general.run') }}<sup>{{ trans('general.gps') }}</sup>
                                </th>
                                <th class="distance_can">
                                    {{ trans('general.run') }}<sup>{{ trans('general.can') }}</sup>
                                </th>
                                <th class="travel-time">
                                    {{ trans('trips.total_movement') }}
                                </th>
                                <th class="driver">
                                    {{ trans('trips.driver') }}
                                </th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @if ( ! $trips->isEmpty())
                                @foreach ($trips as $trip)
                                    <div class="page-break">
                                        <tr>
                                            <td></td>
                                            <td class="left">
                                                <span style="display:none">
                                                    @if(is_array($trip))
                                                        {{ $trip['gpsEvents']->first()->gps_utc_time->format('Y.m.d H:i:s') }}
                                                    @else
                                                        {{ $trip->start_time->format('Y.m.d H:i:s') }}
                                                    @endif
                                                </span> {{--Sorting--}}
                                                <span class="badge badge-primary">
                                                    @if(is_array($trip))
                                                        {{ $trip['gpsEvents']->first()->gps_utc_time->format('Y.m.d H:i:s') }}
                                                    @else
                                                        {{ $trip->start_time->format('Y.m.d H:i:s') }}
                                                    @endif
                                                        {{-- {!! $trip->start_time->format('d.m.Y H:i:s') !!} --}}
                                                    {{-- {!! Carbon\Carbon::parse(reset($trip)->gps_utc_time)->format('d.m.Y H:i') !!} --}}
                                                    {!! trans('general.hours') !!}
                                                </span>
                                            </td>
                                            <td class="from">
                                                @if(is_array($trip))
                                                {{-- only show the address if the trip has started after the workday start --}}
                                                    @if($trip['tripData']->start_time->format('H:i:s') > $time['startTime'])
                                                        @if($trip['tripData']->translation->first() !== null)
                                                            {{ $trip['tripData']->translation->first()->start_address }}
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                @else
                                                    @if($trip->translation->first() !== null)
                                                        {{ $trip->translation->first()->start_address }}
                                                    @endif

                                                @endif
                                            </td>
                                            <td class="arrived">
                                                    <span style="display:none">
                                                        @if(is_array($trip))
                                                            {!! $trip['gpsEvents']->last()->gps_utc_time->format('Y.m.d H:i:s') !!}
                                                        @else
                                                             {{ isset($trip->end_time) ? $trip->end_time->format('Y.m.d H:i:s') : "-" }}
                                                        @endif
                                                    </span> {{--Sorting--}}
                                                    <span class="badge badge-danger">
                                                        @if(is_array($trip))
                                                            {!! $trip['gpsEvents']->last()->gps_utc_time->format('Y.m.d H:i:s') !!}
                                                        @else
                                                             {{ isset($trip->end_time) ? $trip->end_time->format('Y.m.d H:i:s') : "-" }}
                                                        @endif
                                                        {!! trans('general.hours') !!}
                                                    </span>
                                            </td>
                                            <td class="to">
                                                @if(is_array($trip))
                                                {{-- only show the address if the trip has ended before the workday end --}}
                                                    @if(isset($trip['tripData']->end_time) && ($trip['tripData']->end_time->format('H:i:s') < $time['endTime']))
                                                        @if($trip['tripData']->end_time->format('H:i:s') < $time['endTime'])
                                                            @if($trip['tripData']->translation->first() !== null)
                                                                {{ $trip['tripData']->translation->first()->end_address }}
                                                            @endif
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                @else
                                                    @if($trip->translation->first() !== null)
                                                        {{ $trip->translation->first()->end_address }}
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="distance">
                                                @if(is_array($trip))
                                                    {{ number_format($mileage = $trip['gpsEvents']->last()->mileage - $trip['gpsEvents']->first()->mileage, 2) }}
                                                @else
                                                    {{ number_format($trip->distance, 2) }}
                                                @endif
                                                 {{trans('general.km') }}

                                            </td>
                                            <td class="distance_can">
                                                @if(is_array($trip))
                                                    @if ( ! $trip['canBusEvents']->isEmpty())
                                                        {!! number_format($trip['canBusEvents']->last()->total_distance - $trip['canBusEvents']->first()->total_distance, 2) !!} 
                                                        {{trans('general.km') }}
                                                    @else
                                                        -
                                                    @endif
                                                @else
                                                    {{ number_format($trip->distance_can, 2) }}
                                                    {{trans('general.km') }}
                                                @endif
                                            </td>
                                            <td class="travel-time">
                                                <span class="badge badge-success">
                                                    @if(is_array($trip))
                                                    {!! 
                                                        gmdate("H:i:s",
                                                            $trip['gpsEvents']->last()->gps_utc_time->diffInSeconds($trip['gpsEvents']->first()->gps_utc_time)
                                                        )
                                                    !!}
                                                    @else
                                                        {{ gmdate("H:i:s", $trip->end_time->diffInSeconds($trip->start_time)) }}

                                                    @endif
                                                </span>
                                            </td>
                                            <td class="driver">
                                                @if(is_array($trip))
                                                    @if (isset($trip['tripData']->driver))
                                                        {!! $trip['tripData']->driver->translation->first()->first_name !!} {!! $trip['tripData']->driver->translation->first()->last_name !!}
                                                    @endif
                                                @else
                                                    @if(isset($trip->driver))
                                                        {!! $trip->driver->translation->first()->first_name !!} {!! $trip->driver->translation->first()->last_name !!}

                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    </div>
                                @endforeach
                            @else
                                <tr>
                                    <td>{{ trans('trips.no_data') }}</td>
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
                        </tbody>
                    </table>
                </div>

                <div class="ibox-footer ibox-footer-fix text-right">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('head')
    <style type="text/css">
        @media print {
            P { margin-bottom: 0.1in; direction: ltr; color: #000000; line-height: 120%; widows: 0; orphans: 0 }
            P.western { font-family: "Liberation Serif", "Times New Roman", serif; font-size: 12pt; so-language: en-US }
            P.cjk { font-family: "Droid Sans Fallback"; font-size: 12pt; so-language: zh-CN }
            P.ctl { font-family: "FreeSans"; font-size: 12pt; so-language: hi-IN }
            TD P { margin-top: 0.04in; margin-bottom: 0.04in; direction: ltr; color: #000000; widows: 0; orphans: 0 }
            TD P.western { font-family: "Liberation Serif", "Times New Roman", serif; font-size: 12pt; so-language: en-US }
            TD P.cjk { font-family: "Droid Sans Fallback"; font-size: 12pt; so-language: zh-CN }
            TD P.ctl { font-family: "FreeSans"; font-size: 12pt; so-language: hi-IN }
        }
    </style>
@endsection

@section('javascript')
    {!! Html::script('js/data-tables.js') !!}

    <script type="text/javascript">
        $('#tripsReportTable').DataTable({
            buttons:[
                {
                    extend: 'print',
                    customize: function ( win ) {
                        $(win.document.body)
                                .css( 'font-size', '10pt' )
                                .prepend(
                                        $('#travel-list').html()
                                );

                        $(win.document.body).find( 'table' )
                                .addClass( 'compact' )
                                .css( 'font-size', 'inherit' );
                    },
                    className: 'btn btn-custom btn-sm pull-right',
                    text: '<i class="glyphicon glyphicon-print"></i> ' + translations.print,
                    title: '',
                    exportOptions: {
                        columns: ':visible :not(:first-child)',
                        stripHtml: false
                    }
                },
                {
                    extend: 'colvis',
                    className: 'btn btn-custom btn-sm pull-right',
                    text: '<i class="fa fa-eye"></i> ' + translations.colvis,
                    columns: ':not(:first-child)'
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-custom btn-sm pull-right',
                }
            ],
            "sDom": 'B ft<"row"<"col-md-5"l><"col-md-7"p>>',
            "aaSorting": [],
            "info": false,
            "responsive" : {
                "details": {
                    "type": 'column'
                }
            },
            "columnDefs": [
                {
                    "className": 'control ',
                    "orderable": false,
                    "targets":   0
                }
            ],
            "paging": true,
            "language":
            {
                "search": translations.search,
                "searchPlaceholder":translations.searchPlaceholder,
                "lengthMenu": translations.lengthMenu,
                "zeroRecords": translations.zeroRecords,
                "info": translations.info,
                "infoEmpty": translations.infoEmpty,
                "infoFiltered": translations.infoFiltered,
                "paginate": {
                    "previous": translations.previous,
                    "next": translations.next
                }
            },
        });
        $("#tripsReportTable_wrapper .dt-button").appendTo($("#data-tables-actions"));
        $("#trips_reports_list .dataTables_filter").appendTo($(".trips_reports_search"));

        // Remove datatables styles
        $(".buttons-colvis, .buttons-print").removeClass('dt-button');

        function concatParams(array)
        {
            var str = '';
            for(var z in array){
                str += array[z]+'&';
            }

            return str.substring(0, str.length - 1);
        }

        $(function ()
        {
            $('a#saveAsExcel').click(function() {
                var newWindow = window.open(" {{ route('exportTripsTable') }} ", '_blank');
            });

            $(".selective-printing").live("click", function()
            {
                var className = $(this).parent().prop('className');
                if (this.checked)
                {
                    $('.'+className.split(' ')).each(function() {
                        $(this).removeClass('hidden-print');
                    });
                }
                else
                {
                    $('.'+className).each(function() {
                        $(this).addClass('hidden-print');
                    });
                }
            });

        });
    </script>
@endsection
