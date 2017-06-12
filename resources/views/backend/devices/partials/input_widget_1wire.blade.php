<li class="warning-element" id="task9">
    {{trans('general.name')}} : {{ $input->translation->first()->name }}<br>
    {{trans('devices.identification_number')}} : {{ $input->identification_number }}<br>
    {{trans('devices.measurement_unit')}} : {{ $input->unit->measurement_unit }}<br>
    <div class="agile-detail">
        @if ($device->deleted_at !== null)
            <div class="btn btn-xs btn-success restore_input pull-right" data-restore="{{
                route('input.restore', [
                    'input' => $input->id,
                ]) }}">
                <i class="fa fa-refresh"></i>
                {{trans('general.restore')}}
            </div>
        @else
            <div href="#" class="pull-right manage_inputs destroy_input btn btn-danger btn-xs" data-destroy="{{ route('input.destroy', [ 'input' => $input->id ]) }}">{{trans('general.delete')}}</div>
            <div href="#" data-get="{{ route('installer.update.input', ['input' => $input->id, 'device' => $input->device->id]) }}" class="manage_inputs edit_input pull-right btn btn-warning btn-xs" style="margin-right: 5px;">{{trans('general.edit')}}</div>
        @endif
    {{trans('general.type')}} : {{ $input->type->type }}
    </div>
</li>