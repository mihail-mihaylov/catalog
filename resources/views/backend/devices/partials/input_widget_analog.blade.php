<li class="info-element" id="task9">
    <div class="agile-detail">
        {{trans('general.name')}} : {{ $input->translation->first()->name }}<br>
        {{trans('devices.order')}} : {{ $input->order }}<br>
        {{trans('devices.minimum_input')}} : {{ $input->minimum_input }}<br>
        {{trans('devices.maximum_input')}} : {{ $input->maximum_input }}<br>
        {{trans('devices.minimum_output')}} : {{ $input->minimum_output }}<br>
        {{trans('devices.maximum_output')}} : {{ $input->maximum_output }}<br>
        {{trans('devices.measurement_unit')}} : {{ $input->unit->measurement_unit }}<br>
        @if ($input->deleted_at !== null)
            <div class="btn btn-xs btn-success manage_inputs restore_input pull-right" data-restore="{{
                route('input.restore', [
                    'id' => $input->id,
                ]) }}">
                <i class="fa fa-refresh"></i>
                {{trans('general.restore')}}
            </div>
        @else
            <div href="#" class="pull-right manage_inputs destroy_input btn btn-danger btn-xs" data-destroy="{{ route('input.destroy', [ 'input' => $input->id ]) }}">{{trans('general.delete')}}</div>
            <div href="#" data-get="{{ route('installer.update.input', ['input' => $input->id, 'device' => $input->device->id]) }}" class="manage_inputs edit_input pull-right btn btn-warning btn-xs" style="margin-right: 5px;">{{trans('general.edit')}}</div>
        @endif
        {{-- <div href="#" class="pull-right manage_inputs destroy_input btn btn-danger btn-xs " data-destroy="{{ route('input.destroy', [ 'input' => $input->id ]) }}">{{trans('general.delete')}}</div> --}}
        {{trans('general.type')}} : {{ $input->type->type }}
    </div>
</li>