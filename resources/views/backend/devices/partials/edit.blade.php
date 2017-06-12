<form class="form-horizontal" method='PUT' data-submit data-table-name="devices_table" action="{{ route('devices.update', ['id' => $device->id]) }}" >
    @include('backend.providers.compose_translation_tabs_edit')
    <div class="form-group">
        <label class="col-sm-4 control-label">{{trans('general.identification_number')}}</label>
        <div class="col-sm-8">
            <input type="text" name="identification_number" class="form-control" value='{{{$device->identification_number}}}' required autofocus>
        </div>
    </div>
    <div class="hr-line-dashed"></div>

    <div class="form-group">
        <label class="col-sm-4 control-label">{{trans('general.model')}}</label>
        <div class="col-sm-8">
            <select name="device_model_id" class="form-control">
                @foreach($deviceModels as $deviceModel)
                <option value="{{{$deviceModel->id}}}" {{($deviceModel->id == $device->device_model_id)?'selected':''}}>{{{$deviceModel->name}}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">{{trans('devices.analog_inputs_count')}}</label>
        <div class="col-sm-8">
            <input type="text" name="analog_inputs" class="form-control" value="{{$device->analog_inputs}}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">{{trans('devices.digital_inputs_count')}}</label>
        <div class="col-sm-8">
            <input type="text" name="digital_inputs" class="form-control" value="{{$device->digital_inputs}}">
        </div>
    </div>

    <div class="hr-line-dashed"></div>

    <div class="form-group">
        <label class="col-sm-4 control-label">{{trans('trackedObjects.tracked_object')}}</label>
        <div class="col-sm-8">
            <select name="tracked_object_id" class="form-control select_trackedObjects fix-select2">
                @if($device->tracked_object_id == null)
                {{-- TODO: translate --}}
                <option value="" selected>Не е прикрепено към обект за проследяване</option>
                @endif
                @foreach($trackedObjects as $trackedObject)
                <option value="{{{$trackedObject->id}}}"  {{($trackedObject->id == $device->tracked_object_id)?'selected':''}}>
                    {{{$trackedObject->brand->translation[0]->name}}} -
                    @if($trackedObject->tracked_object_model_id !== null)
                    @if($trackedObject->model === null)
                            {{dd($trackedObject)}}
                    @endif
                    {{{$trackedObject->model->translation()->first()->name}}} ({{{$trackedObject->identification_number}}})
                    @endif
                </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="hr-line-dashed"></div>

    <input type="hidden" name="device_id" value="{{ $device->id }}">

    <div class="form-group">
        <div class="col-sm-offset-2 pull-right m-r">
            <button type="button" class="btn btn-white" data-dismiss="modal">{{trans('general.cancel')}}</button>
            <button class="inline btn btn-primary" type="submit" data-device-id='{{$device->id}}'>{{trans('general.save')}}</button>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function() {
        $(".select_trackedObjects").select2({
            width: '100%',
            language: {
               "noResults": function(){
                   return translations.no_data;
               }
            }
        });
    });
</script>
