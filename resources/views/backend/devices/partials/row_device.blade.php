<tr id='device-row-{{ $device->id }}' class="gradeX">
    {{--<td class="pull-left">{{$device->id}}</td>--}}
    <td></td>
    <td class="text-left">{{{ $device->deviceModel->name }}}</td>
    <td class="text-left">{{{ $device->identification_number }}}</td>
    <td class="text-left">
        @if( ! is_null($device->trackedObject))
            {{{ $device->trackedObject->brand->translation->first()->name }}} -
            @if($device->trackedObject->tracked_object_model_id != null)
                {{{ $device->trackedObject->model->translation->first()->name }}} ({{{ $device->trackedObject->identification_number }}})
            @endif
        @else
            <span class="badge badge-danger">{{ trans('trackedObjects.missing') }}</span>
        @endif
    </td>
    <td class="text-left">
        @if($device->deleted_at == null)
            @can ('updateDevice', $company)
                <button
                        class="btn btn-xs btn-info manage_inputs"
                        type="button"
                        data-title="{{ trans('devices.manage_inputs') }}"
                        data-action="{{route('device.manageInputs', ['device' => $device->id])}}"
                        data-get>

                    <i class="fa fa-group (alias)"></i>&nbsp;
                    {{ trans('devices.manage_inputs') }}
                </button>
            @endcan
            @can ('updateDevice', $company)
                <button class="btn btn-xs btn-warning" data-title="{{ trans('general.edit') }}" data-action="{{ route('devices.edit', ['id' => $device->id]) }}" type="button" data-get>
                    <i class="fa fa-edit"></i>
                    {{ trans('general.edit') }}
                </button>
            @endcan
            @can ('deleteDevice', $company)
                <button class="btn btn-xs btn-danger" data-action="{{ route('devices.destroy', ['id'=>$device->id]) }}"  type="button" data-delete>
                    <i class="fa fa-trash-o"></i>
                    {{ trans('general.delete') }}
                </button>
            @endcan
        @else
            @can('deleteDevice', $company)
                <button class="btn btn-xs btn-success" data-action="{{ route('devices.restore', ['id'=>$device->id]) }}"  type="button" data-update>
                    <i class="fa fa-refresh"></i>
                    {{ trans('general.restore') }}
                </button>
            @endcan
        @endif
    </td>
</tr>
