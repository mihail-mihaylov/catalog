<tr class="device-{{ $device->id }} gradeX">
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
                {{ \Carbon\Carbon::parse($device->lastGpsEvent->gps_utc_time)->format('H:i / d.m.Y') }}
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
            <a href="https://maps.google.com/?cbll={!! $device->lastGpsEvent->latitude !!},{!! $device->lastGpsEvent->longitude !!}&cbp=12,,0,0,10&layer=c" class="btn btn-xs btn-success streetview-link" target="_blank">
                <i class="fa fa-eye"></i>
                {{ trans('dashboard.view_on_street_view') }}
            </a>
        @endif
    </td>
</tr>
