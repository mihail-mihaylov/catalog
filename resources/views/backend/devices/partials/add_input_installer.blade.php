<div class="inputwidg">
    <div class="form-group">
        <label class="col-sm-2 control-label">
            &nbsp;
        </label>
        <div class="col-sm-10">
            @if (isset($selectedInput))            
                <div class="destroy_input btn btn-danger btn-sm" data-destroy="{{ route('input.destroy', ['input' => $selectedInput->id]) }}">{{trans('general.delete')}}</div>
            @endif
            @if (!isset($selectedInput))            
                <div class="remove_input btn pull-right">
                    <i class="fa fa-times pull-right"></i>
                </div>
            @else
                <div class="remove_input btn pull-right hidden">
                    <i class="fa fa-times pull-right"></i>
                </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">{{ trans('general.name') }}</label>
        <div class="col-sm-10 control-label">
            @if(isset($selectedInput))
                <div class="hidden">
                    
                {{$value = $selectedInput->name}}
                </div>
            @else
                {{$value = ""}}
            @endif
            <input type="text" class="form-control" value="{{$value}}" name="devices_inputs[{{$increment}}][name]">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">{{ trans('devices.input_type') }}</label>
        <div class="col-sm-10">
            <select class="form-control m-b" name="devices_inputs[{{$increment}}][input_type_id]">
                @if (isset($selectedInput))
                <div class="hidden">
                    
                    {{$value = $selectedInput->input_type_id}}
                </div>
                @else
                    {{$value = ''}}
                @endif
                @foreach ($inputTypes as $inputType)
                    @if($inputType->id == $value)
                        <option value="{{$inputType->id}}" selected>{{$inputType->type}}</option>
                    @else
                        <option value="{{$inputType->id}}">{{$inputType->type}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">{{ trans('devices.measurement_unit') }}</label>
        <div class="col-sm-10">
        <select class="form-control  m-b" name="devices_inputs[{{$increment}}][input_measurement_unit_id]">
            @foreach ($units as $unit)
                @if (isset($selectedInput))
                    @if($selectedInput->unit->id == $unit->id)
                        <option value="{{$unit->id}}" selected>{{$unit->measurement_unit}}</option>
                    @endif
                @else
                    <option value="{{$unit->id}}">{{$unit->measurement_unit}}</option>
                @endif
            @endforeach
        </select>
            
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">{{ trans('devices.order') }}</label>
        <div class="col-sm-10">
        <select class="form-control m-b" name="devices_inputs[{{$increment}}][order]">
            @for ($i = 1; $i <= 10; $i++)
                @if (isset($selectedInput))
                    @if($selectedInput->order == $i)
                        <option value="{{$i}}" selected>{{$i}}</option>
                    @endif
                @else
                        <option value="{{$i}}">{{$i}}</option>
                @endif
            @endfor
        </select>
        </div>  
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">{{ trans('devices.one_wire_identification_number') }}</label>
        <div class="col-sm-10 control-label">
            @if(isset($selectedInput))
                <div class="hidden">
                    
                {{$value = $selectedInput->identification_number}}
                </div>
            @else
                {{$value = ""}}
            @endif
            <input type="text" class="form-control" value="{{$value}}" name="devices_inputs[{{$increment}}][identification_number]">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">{{ trans('devices.minimum_input') }}</label>
        <div class="col-sm-10 control-label">
            @if(isset($selectedInput))
                <div class="hidden">
                {{$value = $selectedInput->minimum_input}}
                </div>
            @else
                {{$value = ""}}
            @endif
            <input type="text" class="form-control" value="{{$value}}" name="devices_inputs[{{$increment}}][minimum_input]">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">{{ trans('devices.maximum_input') }}</label>

        <div class="col-sm-10 control-label">
            @if(isset($selectedInput))
                <div class="hidden">
                    
                {{$value = $selectedInput->maximum_input}}
                </div>
            @else
                {{$value = ""}}
            @endif       
            <input type="text" class="form-control" value="{{$value}}" name="devices_inputs[{{$increment}}][maximum_input]">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">{{ trans('devices.minimum_output') }}</label>
        <div class="col-sm-10 control-label">
            @if(isset($selectedInput))
                <div class="hidden">
                    
                {{$value = $selectedInput->minimum_output}}
                </div>
            @else
                {{$value = ""}}
            @endif
            <input type="text" class="form-control" value="{{$value}}" name="devices_inputs[{{$increment}}][minimum_output]">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">{{ trans('devices.maximum_output') }}</label>
        <div class="col-sm-10 control-label">
            @if(isset($selectedInput))
                <div class="hidden">
                    
                {{$value = $selectedInput->maximum_output}}
                </div>
            @else
                {{$value = ""}}
            @endif
            <input type="text" class="form-control" value="{{$value}}" name="devices_inputs[{{$increment}}][maximum_output]">
        </div>
    </div>
</div>