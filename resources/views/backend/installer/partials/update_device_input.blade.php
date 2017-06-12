<form class="form-horizontal" id="postinput" method="POST" action="{{ route('installer.post.input', [ 'device' => $device->id ]) }}">
    @include('backend.providers.compose_translation_tabs_edit')

    <input name="input_id" class="hidden" value="{{ $selectedInput->id }}">

    <div class="form-group">
        <div class="col-md-12">
            <input type="hidden" class="form-control hidden" value="{{$device->id}}" name="devices_inputs[{{$increment}}][device_id]">
            {{-- <div class="validation_errors"></div> --}}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.input_type') }}</label>

        <div class="col-sm-6 col-md-6 col-lg-6">
            <select class="form-control m-b" id="input_type" name="devices_inputs[{{ $increment }}][input_type_id]">
                <div class="hidden">
                    {{ $value = $selectedInput->input_type_id }}
                </div>

                @foreach ($inputTypes as $inputType)
                    @if ($inputType->id == $value)
                        <option value="{{ $inputType->id }}" selected>{{ $inputType->type }}</option>
                    @else
                        <option value="{{ $inputType->id }}">{{ $inputType->type }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group digital">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.reverse') }}</label>

        <div class="col-sm-6 col-md-6 col-lg-6">
            <select class="form-control  m-b" name="devices_inputs[{{ $increment }}][reverse]">
                <option value="{{ $selectedInput->reverse}}" selected>{{ trans('devices.reverse' . $selectedInput->reverse) }}</option>
                @foreach ([0, 1] as $reverse)
                    @if ($selectedInput->reverse != $reverse)
                        <option value="{{ $reverse }}">{{ trans('devices.reverse' . $reverse) }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group one_wire analog">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.measurement_unit') }}</label>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <select class="form-control  m-b" name="devices_inputs[{{$increment}}][input_measurement_unit_id]">
                @if(null !== ($selectedInput->unit))
                    <option value="{{ $selectedInput->unit->id }}" selected>{{ $selectedInput->unit->measurement_unit }}</option>
                    @foreach ($units as $unit)
                        @if ($selectedInput->unit->id != $unit->id)
                            <option value="{{ $unit->id }}">{{ $unit->measurement_unit }}</option>
                        @endif
                    @endforeach
                @else
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->measurement_unit }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="form-group analog digital">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.order') }}</label>
        <div class="col-sm-6 col-md-6 col-lg-6" id="input_order">
            @if ($selectedInput->inputTypeName != '1wire')
                <select class="form-control m-b analog_order" id="analog_order" name="devices_inputs[{{$increment}}][order]">
                    @for ($analogOrder = 1; $analogOrder <= $device->analog_inputs; $analogOrder++)
                        @if ($selectedInput->order == $analogOrder)
                            <option value="{{$analogOrder}}" selected>{{$analogOrder}}</option>
                        @else
                            <option value="{{$analogOrder}}">{{$analogOrder}}</option>
                        @endif
                    @endfor
                </select>
                <select class="form-control m-b digital_order" id="digital_order" name="devices_inputs[{{$increment}}][order]">
                    @for ($digitalOrder = 1; $digitalOrder <= $device->digital_inputs; $digitalOrder++)
                        @if ($selectedInput->order == $digitalOrder)
                            <option value="{{$digitalOrder}}" selected>{{$digitalOrder}}</option>
                        @else
                            <option value="{{$digitalOrder}}">{{$digitalOrder}}</option>
                        @endif
                    @endfor
                </select>
            @endif
        </div>
    </div>

    <div class="form-group one_wire">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.one_wire_identification_number') }}</label>

        <div class="col-sm-6 col-md-6 col-lg-6 control-label">
            <div class="hidden">
                {{ $value = $selectedInput->identification_number }}
            </div>
            <input type="text" class="form-control" value="{{ $value }}" name="devices_inputs[{{ $increment }}][identification_number]">
        </div>
    </div>

    <div class="form-group analog">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.minimum_input') }}</label>

        <div class="col-sm-6 col-md-6 col-lg-6 control-label">
            <div class="hidden">
                {{ $value = $selectedInput->minimum_input }}
            </div>
            <input type="text" class="form-control" value="{{ $value }}" name="devices_inputs[{{ $increment }}][minimum_input]">
        </div>
    </div>

    <div class="form-group analog">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.maximum_input') }}</label>

        <div class="col-sm-6 col-md-6 col-lg-6 control-label">
            <div class="hidden">
                {{ $value = $selectedInput->maximum_input }}
            </div>
            <input type="text" class="form-control analog" value="{{ $value }}" name="devices_inputs[{{ $increment }}][maximum_input]">
        </div>
    </div>

    <div class="form-group analog">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.minimum_output') }}</label>

        <div class="col-sm-6 col-md-6 col-lg-6 control-label">
            <div class="hidden">
                {{ $value = $selectedInput->minimum_output }}
            </div>
            <input type="text" class="form-control" value="{{ $value }}" name="devices_inputs[{{ $increment }}][minimum_output]">
        </div>
    </div>

    <div class="form-group analog">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.maximum_output') }}</label>

        <div class="col-sm-6 col-md-6 col-lg-6 control-label">
            <div class="hidden">
                {{ $value = $selectedInput->maximum_output }}
            </div>
            <input type="text" class="form-control" value="{{$value}}" name="devices_inputs[{{$increment}}][maximum_output]">
        </div>
    </div>

    <div class="form-group digital analog one_wire">
        <label class="col-sm-3 col-lg-3 col-md-3 control-label">&nbsp;</label>

        <div class="col-sm-7 col-md-7 col-lg-7 control-label pull-right">
            <input class="manage_inputs inline btn col-lg-6 col-md-6 col-sm-6 col-xs-6 btn-custom btn-sm postinput" type="submit" value="{{ trans('general.save') }}" style="margin-top: 0px!important;" />
            <input class="manage_inputs add_input inline btn col-lg-5 col-md-5 col-sm-5 col-xs-5 btn-white btn-sm postinput" type="button" value="{{ trans('devices.new_input') }}" data-get="{{ route('installer.get.input', ['device' => $device]) }}" />
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
            analogOrder.detach();
            inputOrderContainer.append(digitalOrder);
        } else if (inputType == 'analog') {
            digitalOrder.detach();
            inputOrderContainer.append(analogOrder);
        }
    });

</script>
