<tr id='device-row-{{ $device->id }}' class="gradeX">
    <td></td>
    <td class="text-left">{{{ $device->name }}}</td>
    <td class="text-left">{{{ $device->identification_number }}}</td>
    <td class="text-left">
        @if($device->deleted_at == null)

                <button class="btn btn-xs btn-warning" data-title="{{ trans('general.edit') }}" data-action="{{ route('device.edit', ['id' => $device->id]) }}" type="button" data-get>
                    <i class="fa fa-edit"></i>
                    {{ trans('general.edit') }}
                </button>
                <button class="btn btn-xs btn-danger" data-action="{{ route('device.destroy', ['id'=>$device->id]) }}"  type="button" data-delete>
                    <i class="fa fa-trash-o"></i>
                    {{ trans('general.delete') }}
                </button>
        @else
                <button class="btn btn-xs btn-success" data-action="{{ route('device.restore', ['id'=>$device->id]) }}"  type="button" data-update>
                    <i class="fa fa-refresh"></i>
                    {{ trans('general.restore') }}
                </button>
        @endif
    </td>
</tr>
