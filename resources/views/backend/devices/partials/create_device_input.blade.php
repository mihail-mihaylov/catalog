<form class="form-horizontal" id="postinput" method="POST" action="{{route('input.store')}}">
   @include('backend.providers.compose_translation_tabs_create')
    <div class="form-group">
        <div class="col-md-12">
            <input type="hidden" class="form-control hidden" value="{{$device->id}}" name="devices_inputs[{{$increment}}][device_id]">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.input_type') }}</label>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <select class="form-control m-b" id="input_type" name="devices_inputs[{{$increment}}][input_type_id]">
                    {{$value = ''}}
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
    <div class="form-group digital">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.reverse') }}</label>
        <div class="col-sm-6 col-md-6 col-lg-6">
        <select class="form-control  m-b" name="devices_inputs[{{$increment}}][reverse]">

            @foreach ([0, 1] as $reverse)
                    <option value="{{$reverse}}">{{trans('devices.reverse' . $reverse)}}</option>
            @endforeach
        </select>

        </div>
    </div>
    <div class="form-group one_wire analog">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.measurement_unit') }}</label>
        <div class="col-sm-6 col-md-6 col-lg-6">
        <select class="form-control  m-b" id="measurement_unit" name="devices_inputs[{{$increment}}][input_measurement_unit_id]">
                @foreach ($units as $unit)
                    <option value="{{$unit->id}}">{{$unit->measurement_unit}}</option>
                @endforeach
        </select>

        </div>
    </div>

    <div class="form-group analog digital">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.order') }}</label>
        <div class="col-sm-6 col-md-6 col-lg-6" id="input_order">
            <select class="form-control m-b analog_order" id="analog_order" name="devices_inputs[{{$increment}}][order]">
                @for ($analogOrder = 1; $analogOrder <= $device->analog_inputs; $analogOrder++)
                    <option value="{{$analogOrder}}" selected>{{$analogOrder}}</option>
                @endfor
            </select>
            <select class="form-control m-b digital_order" id="digital_order" name="devices_inputs[{{$increment}}][order]">
                @for ($digitalOrder = 1; $digitalOrder <= $device->digital_inputs; $digitalOrder++)
                    <option value="{{$digitalOrder}}" selected>{{$digitalOrder}}</option>
                @endfor
            </select>
        </div>
    </div>

    <div class="form-group one_wire">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.one_wire_identification_number') }}</label>
        <div class="col-sm-6 col-md-6 col-lg-6 control-label">
                {{$value = ""}}
            <input type="text" class="form-control" value="{{$value}}" name="devices_inputs[{{$increment}}][identification_number]">
        </div>
    </div>

    <div class="form-group analog">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.minimum_input') }}</label>
        <div class="col-sm-6 col-md-6 col-lg-6 control-label">
                {{$value = ""}}
            <input type="text" class="form-control" value="{{$value}}" name="devices_inputs[{{$increment}}][minimum_input]">
        </div>
    </div>

    <div class="form-group analog">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.maximum_input') }}</label>

        <div class="col-sm-6 col-md-6 col-lg-6 control-label">
                {{$value = ""}}
            <input type="text" class="form-control analog" value="{{$value}}" name="devices_inputs[{{$increment}}][maximum_input]">
        </div>
    </div>

    <div class="form-group analog">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.minimum_output') }}</label>
        <div class="col-sm-6 col-md-6 col-lg-6 control-label">
                {{$value = ""}}
            <input type="text" class="form-control" value="{{$value}}" name="devices_inputs[{{$increment}}][minimum_output]">
        </div>
    </div>

    <div class="form-group analog">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.maximum_output') }}</label>
        <div class="col-sm-6 col-md-6 col-lg-6 control-label">
                {{$value = ""}}
            <input type="text" class="form-control" value="{{$value}}" name="devices_inputs[{{$increment}}][maximum_output]">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">&nbsp;</label>
        <div class="col-sm-6 col-md-6 col-lg-6 control-label">
                <input class="manage_inputs inline btn col-lg-12 col-md-12 col-sm-12 col-xs-12 btn-custom btn-sm postinput" type="submit" value="{{trans('general.create')}}">
                </input>
        </div>
    </div>
</form>
<script type="text/javascript">
    // cache the select menus
    var analogOrder = $('#analog_order');
    var digitalOrder = $('#digital_order');
    var inputOrderContainer = $('#input_order');

    $('#input_type').on('change', function (item) {
        var inputType = $(this).children('option:selected').html();

        if (inputType == 'digital') {
            console.log('digital');
            analogOrder.detach();
            inputOrderContainer.append(digitalOrder);
        } else if (inputType == 'analog') {
            console.log('analog');
            digitalOrder.detach();
            inputOrderContainer.append(analogOrder);
        }
    });

    $('#input_type').trigger('change');

    if ($('#input_type').html() != 'digital') {
        $.each($('.digital_on'), function () {
            $(this).closest('.form-group').first().addClass('digital').hide();
        });
        $.each($('.digital_off'), function () {
            $(this).closest('.form-group').first().addClass('digital').hide();
        });
    }
</script>