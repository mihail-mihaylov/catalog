@forelse($group->devices as $device)
    @if($device->deleted_at != null)
        <span class="btn btn-white ">
            <label class="badge badge-danger">
                {{{ $device->name }}}
            </label>
        </span>
    @else
        <span class="btn btn-white ">
            <label class="badge badge-success">
                {{{ $device->name }}}
            </label>
        </span>
    @endif
@empty
    {{ trans('devices.none_found') }}
@endforelse
