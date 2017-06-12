<form id="createNewDeviceForm" class="form-horizontal" data-submit data-table-name="devices_table" method='POST' action="{{URL::route('devices.store')}}" >
    <input type='hidden' name='_token' value='{{csrf_token()}}' >

    @include('backend.providers.compose_translation_tabs_create')

    <div class="form-group">
        <label class="col-sm-4 control-label">{{trans('general.identification_number')}}</label>
        <div class="col-sm-8">
            <input type="text" name="identification_number" class="form-control" required autofocus>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">{{trans('devices.analog_inputs_count')}}</label>
        <div class="col-sm-8">
            <input type="text" name="analog_inputs" class="form-control" required autofocus>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">{{trans('devices.digital_inputs_count')}}</label>
        <div class="col-sm-8">
            <input type="text" name="digital_inputs" class="form-control" required autofocus>
        </div>
    </div>
    <div class="hr-line-dashed"></div>

    <div class="form-group">
        <label class="col-sm-4 control-label">{{trans('general.model')}}</label>
        <div class="col-sm-8">
            <select name="device_model_id" class="form-control">
                @foreach($deviceModels as $deviceModel)
                <option value="{{{$deviceModel->id}}}" >{{{$deviceModel->name}}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="hr-line-dashed"></div>

    <div class="form-group">
        <label class="col-sm-4 control-label">{{trans('trackedObjects.tracked_object')}}</label>
        <div class="col-sm-8">
            <select name="tracked_object_id" class="form-control select_trackedObjects fix-select2">
                <option value='' selected>{{trans('trackedObjects.choose_tracked_object')}}</option>
                @foreach($trackedObjects as $trackedObject)
                    <option value="{{{$trackedObject->id}}}">
                        {{{$trackedObject->brand->translation[0]->name}}} -
                        @if($trackedObject->tracked_object_model_id != null)
                            {{{$trackedObject->model->translation[0]->name}}} ({{{$trackedObject->identification_number}}})
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group">
        <div class="col-sm-offset-2 pull-right m-r">
            <button type="button" class="btn btn-white" data-dismiss="modal">{{trans('general.cancel')}}</button>
            <button class="inline btn btn-primary" type="submit">{{trans('general.save')}}</button>
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
