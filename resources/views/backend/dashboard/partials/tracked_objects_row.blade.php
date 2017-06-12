<tr class="trackedObject-{{ $device->id }} gradeX">
    <td></td>

    <td>
        <strong>
            {!! $device->name !!}
        </strong>
    </td>

    <td>{!! $device->identification_number !!}</td>

    <td class="communication">
        @if ($device->lastGpsEvent)
            <span style="display:none">{{ \Carbon\Carbon::parse($device->lastGpsEvent->gps_utc_time)->format('Y.m.d H:i') }}</span> {{--Sorting--}}
            <span class="badge
                    @if (\Carbon\Carbon::now()->setTimezone(Session::get('system_timezone')['string_format'])->diffInMinutes(\Carbon\Carbon::parse($device->lastGpsEvent->gps_utc_time)) <= 5)
                        badge-primary
                    @elseif (\Carbon\Carbon::now()->setTimezone(Session::get('system_timezone')['string_format'])->diffInMinutes(\Carbon\Carbon::parse($device->lastGpsEvent->gps_utc_time)) > 5 && \Carbon\Carbon::now()->setTimezone(Session::get('system_timezone')['string_format'])->diffInMinutes(\Carbon\Carbon::parse($device->lastGpsEvent->gps_utc_time)) < 60)
                        badge-warning
                    @else
                        badge-danger
                    @endif">
                {{ \Carbon\Carbon::parse($device->lastGpsEvent->gps_utc_time)->format('H:i / d.m.Y') }}
            </span>
        @else
            -
        @endif
    </td>

    <td class="col-md-3">
        @if ($device->lastGpsEvent)
            <a href="#" data-device-id="{{ $device->id }}" class="btn btn-xs btn-info follow-device">
                <i class="fa fa-map-marker"></i>
                {{ trans('dashboard.view_on_map') }}
            </a>
            <a href="https://maps.google.com/?cbll={!! $device->lastGpsEvent->latitude !!},{!! $device->lastGpsEvent->longitude !!}&cbp=12,{!! $device->lastGpsEvent->azimuth !!},0,0,10&layer=c" class="btn btn-xs btn-success streetview-link" target="_blank">
                <i class="fa fa-eye"></i>
                {{ trans('dashboard.view_on_street_view') }}
            </a>
        @endif
    </td>
</tr>
