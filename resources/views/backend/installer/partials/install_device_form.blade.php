<form method="post" id="installer_form" class="form-horizontal" action="{{route('installer.match.device.tracked.object')}}">
    {!! Form::token() !!}
    <div class="form-group {{$errors->has('device_identification_number')?'has-error':''}}">
        <label class="col-sm-2 control-label">{{trans('installer.device_ime_title')}}</label>
        <div class="col-sm-10">
            <input type="text"  class="form-control" name="device_identification_number" value="{{{Input::old('device_identification_number')}}}">
            @if($errors->has('device_identification_number'))
            <br>
            <div class="alert alert-danger" role="alert">
                {{$errors->first('device_identification_number')}}
            </div>
            @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group {{$errors->has('tracked_object_identification_number')?'has-error':''}}">
        <label class="col-sm-2 control-label">{{trans('installer.tracked_object_number')}}</label>
        <div class="col-sm-10">
            <input type="text"  class="form-control" name="tracked_object_identification_number" value="{{{Input::old('tracked_object_identification_number')}}}">
            @if($errors->has('tracked_object_identification_number'))
            <br>
            <div class="alert alert-danger" role="alert">
                {{$errors->first('tracked_object_identification_number')}}
            </div>
            @endif                </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">&nbsp;</label>
        <div class="col-sm-10">
            <button class='btn btn-custom btn-sm' type='submit'>
                <i class="fa fa-save"></i>
                {{trans('installer.connect_title')}}
            </button>
        </div>
        
    </div>
</form>