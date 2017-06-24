<form id="createNewDeviceForm" class="form-horizontal" data-submit data-table-name="devices_table" method='POST' action="{{URL::route('device.store')}}" >
    <input type='hidden' name='_token' value='{{csrf_token()}}' >

    <div class="form-group">
        <label class="col-sm-4 control-label">{{trans('general.name')}}</label>
        <div class="col-sm-8">
            <input type="text" name="name" class="form-control" required autofocus>
        </div>
    </div>

    <div class="hr-line-dashed"></div>

    <div class="form-group">
        <label class="col-sm-4 control-label">{{trans('general.identification_number')}}</label>
        <div class="col-sm-8">
            <input type="text" name="identification_number" class="form-control" required autofocus>
        </div>
    </div>

    <div class="hr-line-dashed"></div>

    <div class="form-group">
        <label class="col-sm-4 control-label">{{trans_choice('groups.group', 1)}}</label>
        <div class="col-sm-8">
            <select name="device_model_id" class="form-control">
                @foreach($groups as $group)
                    <option value="{{{$group->id}}}" >{{{$group->name}}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 pull-right m-r">
            <button type="button" class="btn btn-white" data-dismiss="modal">{{trans('general.cancel')}}</button>
            <button class="inline btn btn-primary" type="submit">{{trans('general.save')}}</button>
        </div>
    </div>
</form>
