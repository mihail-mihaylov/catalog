<form method="post" id="get_device_inputs_form" class="form-horizontal" action="{{route('installer.find.device.inputs')}}">
    {!! Form::token() !!}
    <div class="form-group {{$errors->has('device_identification_number')?'has-error':''}}">
        <label class="col-sm-2 control-label">{{trans('installer.device_ime_title')}}</label>
        <div class="col-sm-10">
            <input type="text"  class="form-control" name="identification_number" value="{{{Input::old('device_identification_number')}}}">
            @if($errors->has('device_identification_number'))
            <br>
            <div class="alert alert-danger" role="alert">
                {{$errors->first('device_identification_number')}}
            </div>
            @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group">
        <div class="col-sm-2">
            <label class="col-sm-2 control-label">&nbsp;</label>
        </div>
        <div class="col-sm-10">
            <button class='btn btn-custom btn-sm' type='submit'>
                <i class="fa fa-save"></i>
                {{trans('installer.get_device_inputs')}}
            </button>
        </div>
    </div>
</form>
<div class="row">
    <div id="inputs"></div>
</div>