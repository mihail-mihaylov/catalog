<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        @yield('test')

        <td colspan="8" height="50" align="center">
            <h1>{{ strtoupper(trans('trips.trip_report')) }}</h1>
        </td>

        <table class="text-center">
            <tr>
                <td></td>
                <td></td>
                <th align="right">{{ trans('trips.for_period') }}</th>
                <td>
                    @if ( ! is_null($from) && ! is_null($to))
                        {{ Carbon\Carbon::parse($from)->format('d.m.Y') . " - " . Carbon\Carbon::parse($to)->format('d.m.Y') }}
                    @endif
                </td>
                <th align="right">{{ trans('general.firm') }}:</th>
                <td align="left">{{ $companyName }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <th align="right">{{ trans('general.automobile') }}:</th>
                <td>
                    {!! $trackedObject->brand->translation->first()->name . " " . $trackedObject->model->translation->first()->name !!}
                </td>
                <th align="right">{{ trans('trips.eik') }}:</th>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <th align="right">{{ trans('general.identification_number') }}:</th>
                <td align="left">
                    {!! $trackedObject->identification_number !!}
                </td>
                <th align="right">{{ trans('general.liable_person') }}:</th>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <th align="right">{{ trans('trips.starting_mileage') }}:</th>
                <td align="left">
                    @if( ! $trips->isEmpty())
                    {{ $first = $trips->first()['gpsEvents']->first()->mileage }}
                    @else
                    {{ $first = $trips->first->gpsEvents->first()->mileage }}
                    @endif
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <th align="right">{{ trans('trips.ending_mileage') }}:</th>
                <td align="left">
                    @if( ! $trips->isEmpty())
                    {{ $last = $trips->last()['gpsEvents']->last()->mileage }}
                    @else
                    {{ $last = $trips->last()->gpsEvents->last()->mileage }}
                    @endif
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <th align="right">{{ trans('travelList.total') }}:</th>
                <td align="left">
                    {{ $last - $first}}
                </td>
            </tr>
        </table>

        <table class="table table-bordered table-striped text-center table-responsive tripsReportTable" >
            <thead>
                <div class="page-break">
                    <tr>
                        <th align="center" class="course-number">
                            {{trans('trips.course')}} {{trans('general.number')}}
                        </th>
                        <th align="center" class="left">
                            {{trans('trips.took_off')}}
                        </th>
                        <th align="center" class="from">
                            {{trans('general.from')}}
                        </th>
                        <th align="center" class="arrived">
                            {{trans('trips.arrived')}}
                        </th>
                        <th align="center" class="to">
                            {{trans('general.to')}}
                        </th>
                        <th align="center" class="distance">
                            {{trans('general.distance')}}
                        </th>
                        <th align="center" class="travel-time">
                            {{trans('trips.total_movement')}}
                        </th>
                        <th align="center" class="driver">
                            {{trans('trips.driver')}}
                        </th>
                    </tr>
                </div>
            </thead>
            <tbody>
                @if ( ! $trips->isEmpty())
                    <div class="hidden">{{ $total = 0 }}</div>
                    @foreach ($trips as $key => $trip)
                        @if ($trip['gpsEvents']->isEmpty())
                            @continue
                        @endif
                        <div class="page-break">
                            <tr>
                                <td></td>
                                <td class="left">
                                    <span class="badge badge-primary">
                                        @if(is_array($trip))
                                        {!! $trip['gpsEvents']->first()->gps_utc_time->format('d.m.Y H:i') !!}
                                        @else
                                        {!! $trip->gpsEvents->first()->gps_utc_time->format('d.m.Y H:i') !!}
                                        @endif
                                        {!! trans('general.hours') !!}
                                    </span>
                                </td>
                                <td class="from">
                                    @if(is_array($trip))
                                        @if ($trip['tripData']->start_time < $trip['gpsEvents']->first()->gps_utc_time)
                                            -
                                        @else
                                            {{ $trip['tripData']->translation->first()->start_address }}
                                        @endif
                                    @else
                                        {{ $trip->translation->first()->start_address }}
                                    @endif
                                </td>
                                <td class="arrived">
                                    <span class="badge badge-danger">
                                    @if(is_array($trip))
                                        {!! $trip['gpsEvents']->last()->gps_utc_time->format('d.m.Y H:i') !!}{!! trans('general.hours') !!}
                                    @else
                                        {!! $trip->gpsEvents->last()->gps_utc_time->format('d.m.Y H:i') !!}{!! trans('general.hours') !!}
                                    @endif    
                                    </span>
                                </td>
                                <td class="to">
                                    @if(is_array($trip))
                                        @if (($trip['tripData']->end_time > $trip['gpsEvents']->last()->gps_utc_time) || ( ! isset($trip['tripData']->end_time)))
                                            -
                                        @else
                                            {{ $trip['tripData']->translation->first()->end_address }}
                                        @endif
                                    @else
                                        {{ $trip->translation->first()->end_address }}
                                    @endif
                                </td>
                                <td class="distance">
                                    @if(is_array($trip))
                                    {!! round(( $trip['gpsEvents']->last()->mileage - $trip['gpsEvents']->first()->mileage), 1) !!}
                                    @else
                                    {!! round(( $trip->gpsEvents->last()->mileage - $trip->gpsEvents->first()->mileage), 1) !!}
                                    @endif
                                </td>
                                <td class="travel-time">
                                    <span class="badge badge-success" style="font-size: 13px">
                                    @if(is_array($trip))
                                        {!! gmdate("H:i", $trip['gpsEvents']->last()->gps_utc_time->diffInSeconds($trip['gpsEvents']->first()->gps_utc_time)) !!}
                                    @else
                                        {!! gmdate("H:i", $trip->gpsEvents->last()->gps_utc_time->diffInSeconds($trip->gpsEvents->first()->gps_utc_time)) !!}
                                    @endif
                                    </span>
                                </td>
                                <td class="driver">
                                    @if (isset($trip['tripData']->driver))
                                        @if(is_array($trip))
                                            {!! $trip['tripData']->driver->translation->first()->first_name !!} {!! $trip['tripData']->driver->translation->first()->last_name !!}
                                        @else
                                            {!! $trip->driver->translation->first()->first_name !!} {!! $trip['tripData']->driver->translation->first()->last_name !!}
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        </div>
                    @endforeach

                @else
                    <tr>
                        <td>{{ trans('trips.no_data') }}</td>
                        <td>{{ trans('trips.no_data') }}</td>
                        <td>{{ trans('trips.no_data') }}</td>
                        <td>{{ trans('trips.no_data') }}</td>
                        <td>{{ trans('trips.no_data') }}</td>
                        <td>{{ trans('trips.no_data') }}</td>
                        <td>{{ trans('trips.no_data') }}</td>
                        <td>{{ trans('trips.no_data') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <td></td>
        <td></td>
    </body>
</html>
