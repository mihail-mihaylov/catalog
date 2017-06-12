<form class="form-horizontal" id="postinput" method="POST" action="{{route('installer.post.input', [ 'device' => $device->id ])}}">
    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <?php $i = 0; ?>
            @foreach(Session::get('company_languages') as $language)
                <li role="presentation" class="{{($i==0)?'active':''}}">
                    <a href="#language-tab-{{$i}}" aria-controls="language-tab-{{$i}}" role="tab" data-toggle="tab">{{{$language->name}}}</a>
                </li>
                <?php $i++; ?>
            @endforeach
        </ul>

        <div class="tab-content">
            <?php $i = 0; ?>
            @foreach(Session::get('company_languages') as $language)
                <div class="tab-pane {{($i==0)?'active':''}}" id="language-tab-{{$i}}" role="tabpanel">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-5 control-label" for="name{{$language->id}}">{{trans('general.name')}}</label>
                            <div class="col-sm-7">
                                @if(isset($selectedInput))
                                <input id="name{{$language->id}}" type="text" name="translations[{{$language->id}}][name]" class="form-control" placeholder="{{trans('general.enter_in_language')}} {{{$language->name}}}" value="{{
                                ($selectedInput->translations()->where('language_id', $language->id)->get()->isEmpty() ? null : $selectedInput->translations()->where('language_id', $language->id)->first()->name)

                                }}" />
                                @else
                                <input id="name{{$language->id}}" type="text" name="translations[{{$language->id}}][name]" class="form-control" placeholder="{{trans('general.enter_in_language')}} {{{$language->name}}}" value="" />
                                @endif
                            </div>
                        </div>
                        <div class="form-group digital">
                            <label class="col-sm-5 control-label" for="name{{$language->id}}">{{trans('installer.digital_input_on')}}</label>
                            <div class="col-sm-7">
                                @if(isset($selectedInput))
                                <input id="name{{$language->id}}" type="text" name="translations[{{$language->id}}][digital_on]" class="form-control" placeholder="{{trans('general.enter_in_language')}} {{{$language->name}}}" value="{{
                                ($selectedInput->translations()->where('language_id', $language->id)->get()->isEmpty() ? null : $selectedInput->translations()->where('language_id', $language->id)->first()->digital_on)

                                }}" />
                                @else
                                <input id="name{{$language->id}}" type="text" name="translations[{{$language->id}}][digital_on]" class="form-control" placeholder="{{trans('general.enter_in_language')}} {{{$language->name}}}" value="" />
                                @endif
                            </div>
                        </div>
                        <div class="form-group digital">
                            <label class="col-sm-5 control-label" for="name{{$language->id}}">{{trans('installer.digital_input_off')}}</label>
                            <div class="col-sm-7">
                                @if(isset($selectedInput))
                                <input id="name{{$language->id}}" type="text" name="translations[{{$language->id}}][digital_off]" class="form-control" placeholder="{{trans('general.enter_in_language')}} {{{$language->name}}}" value="{{
                                ($selectedInput->translations()->where('language_id', $language->id)->get()->isEmpty() ? null : $selectedInput->translations()->where('language_id', $language->id)->first()->digital_off)

                                }}" />
                                @else
                                <input id="name{{$language->id}}" type="text" name="translations[{{$language->id}}][digital_off]" class="form-control" placeholder="{{trans('general.enter_in_language')}} {{{$language->name}}}" value="" />
                                @endif
                            </div>
                        </div>
                    </div>
                    <?php $i++; ?>
                </div>
            @endforeach
        </div>
    </div>
        <br />
    @if(isset($selectedInput))
        <input name="input_id" class="hidden" value="{{$selectedInput->id}}">
    @endif
    <div class="form-group">
        <div class="col-md-12">
            {{-- <div class="validation_errors"></div> --}}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.input_type') }}</label>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <select class="form-control m-b" id="input_type" name="devices_inputs[{{$increment}}][input_type_id]">
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
    <div class="form-group digital">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.reverse') }}</label>
        <div class="col-sm-6 col-md-6 col-lg-6">
        <select class="form-control  m-b" name="devices_inputs[{{$increment}}][reverse]">
                @if (isset($selectedInput))
                    <option value="{{$selectedInput->reverse}}" selected>{{trans('devices.reverse' . $selectedInput->reverse)}}</option>
                @endif
            @foreach ([0, 1] as $reverse)
                @if(isset($selectedInput))
                    @if($selectedInput->reverse != $reverse)
                        <option value="{{$reverse}}">{{trans('devices.reverse' . $reverse)}}</option>
                    @endif
                @else
                    <option value="{{$reverse}}">{{trans('devices.reverse' . $reverse)}}</option>
                @endif
            @endforeach
        </select>

        </div>
    </div>
    <div class="form-group one_wire analog">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.measurement_unit') }}</label>
        <div class="col-sm-6 col-md-6 col-lg-6">
        <select class="form-control  m-b" name="devices_inputs[{{$increment}}][input_measurement_unit_id]">
            @if (isset($selectedInput))
                @if(null !== ($selectedInput->unit))
                <option value="{{$selectedInput->unit->id}}" selected>{{$selectedInput->unit->measurement_unit}}
                </option>
                    @foreach ($units as $unit)
                        @if($selectedInput->unit->id != $unit->id)
                            <option value="{{$unit->id}}">{{$unit->measurement_unit}}</option>
                        @endif
                    @endforeach
                @else
                    @foreach ($units as $unit)
                        <option value="{{$unit->id}}">{{$unit->measurement_unit}}</option>
                    @endforeach
                @endif
            @else
                @foreach ($units as $unit)
                    <option value="{{$unit->id}}">{{$unit->measurement_unit}}</option>
                @endforeach
            @endif

        </select>

        </div>
    </div>

    <div class="form-group analog digital">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.order') }}</label>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <select class="form-control m-b" name="devices_inputs[{{$increment}}][order]">
                @if (isset($selectedInput))
                    <option value="{{$selectedInput->order}}" selected>{{$selectedInput->order}}</option>
                @endif
                @for ($i = 1; $i <= 10; $i++)
                    @if(isset($selectedInput))
                        @if ($selectedInput->order != $i)
                            <option value="{{$i}}">{{$i}}</option>
                        @endif
                    @else
                        <option value="{{$i}}">{{$i}}</option>
                    @endif
                @endfor
            </select>
        </div>
    </div>

    <div class="form-group one_wire">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.one_wire_identification_number') }}</label>
        <div class="col-sm-6 col-md-6 col-lg-6 control-label">
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

    <div class="form-group analog">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.minimum_input') }}</label>
        <div class="col-sm-6 col-md-6 col-lg-6 control-label">
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

    <div class="form-group analog">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.maximum_input') }}</label>

        <div class="col-sm-6 col-md-6 col-lg-6 control-label">
            @if(isset($selectedInput))
                <div class="hidden">

                {{$value = $selectedInput->maximum_input}}
                </div>
            @else
                {{$value = ""}}
            @endif
            <input type="text" class="form-control analog" value="{{$value}}" name="devices_inputs[{{$increment}}][maximum_input]">
        </div>
    </div>

    <div class="form-group analog">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.minimum_output') }}</label>
        <div class="col-sm-6 col-md-6 col-lg-6 control-label">
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

    <div class="form-group analog">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">{{ trans('devices.maximum_output') }}</label>
        <div class="col-sm-6 col-md-6 col-lg-6 control-label">
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
    <div class="form-group">
        <label class="col-sm-5 col-lg-5 col-md-5 control-label">&nbsp;</label>
        <div class="col-sm-6 col-md-6 col-lg-6 control-label">
            @if (isset($selectedInput))
                <input class="manage_inputs inline btn col-lg-6 col-md-6 col-sm-6 col-xs-6 btn-custom btn-sm postinput" type="submit" value="{{trans('general.save')}}" style="margin-top: 0px!important;">
                </input>
                <input class="manage_inputs add_input inline btn col-lg-5 col-md-5 col-sm-5 col-xs-5 btn-white btn-sm postinput" type="button" value="{{trans('general.cancel')}}" data-get="{{route('installer.get.input', ['device' => $device])}}">
                </input>
            @else
                <input class="manage_inputs inline btn col-lg-12 col-md-12 col-sm-12 col-xs-12 btn-custom btn-sm postinput" type="submit" value="{{trans('general.create')}}">
                </input>
            @endif
        </div>
    </div>
</form>
