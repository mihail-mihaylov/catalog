@extends('backend.wrapper')

@section('page_title')
    {{ trans('reports.canbus_report') }}
@endsection

@section('content')
    <div class="row">
        <div class="hidden" id="no_data_translation" data-translation="{{ trans('general.no_data') }}"></div>

        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="row">
                        <div class="col-md-10">
                            <h5>
                                <i class="fa fa-bar-chart-o"></i>
                                &nbsp;{{trans('reports.make_canbus_report')}}
                            </h5>
                        </div>

                        <div class="col-md-2">
                            <div id="spiner-inputs" class="pull-right spiner-inputs hidden">
                                <div class="sk-spinner sk-spinner-rotating-plane"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="validation_errors"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="control-label" for="tracked_object">{{ trans('trackedObjects.tracked_object') }}</label>
                            </div>
                            <div class="col-md-5">
                                <select class="form-control fix-select2" name="tracked_object" id="tracked_objects">
                                    @if (count($trackedObjects))
                                        <option value="">{{ trans('general.please_choose') }}</option>
                                        @foreach ($trackedObjects as $trackedObject)
                                            @if (count($trackedObject->devices) > 1)
                                                <optgroup label="{{ $trackedObject->brand->translation[0]->name . ' ' . $trackedObject->model->translation[0]->name . ' - ' . $trackedObject->identification_number }}">
                                                    @foreach ($trackedObject->devices as $device)
                                                        <option value="{{ $device->id }}">
                                                            {{ trans('general.imei') }}: {{ $device->identification_number }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @elseif (count($trackedObject->devices) == 0)
                                                <option value="" disabled>{{ $trackedObject->brand->translation[0]->name . " " . $trackedObject->model->translation[0]->name . " - " . $trackedObject->identification_number . " - No device attached" }}
                                                </option>
                                            @else
                                                <option value="{{ $trackedObject->devices[0]->id }}" >{{ $trackedObject->brand->translation[0]->name . " " . $trackedObject->model->translation[0]->name . " - " . $trackedObject->identification_number }}
                                                </option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="parameters form-group">
                            <div class="hr-line-dashed"></div>

                            <div class="col-md-2">
                                <label class="control-label" for="tracked_object">{{ trans('reports.parametric.parameters') }}</label>
                            </div>

                            <div class="col-md-5">
                                <select class="form-control fix-select2" style="width: 100%;" name="canbus_parameters[]" id="can_bus_parameters" multiple="multiple">
                                    @foreach ($canBusParameters as $key => $parameter)
                                        <option value="{{ $key }}"> {{ $parameter['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group ">
                            <div class="hr-line-dashed "></div>

                            <div class="col-md-2">
                                <label class='control-label' for="last_date">{{ trans('general.end_date') }}</label>
                            </div>

                            <div class="col-md-5">
                                <div class="input-group last_date" id="generalReportDatepicker">
                                    {!! Form::text('last_date', '', ['class' => 'form-control', 'id' => 'last_date']) !!}
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="hidden input-group date">
                                {!! Form::text( 'hiddenLastDate', '', ['class' => 'form-control', 'id' => 'hiddenLastDate']) !!}
                            </div>
                            <div class="col-md-1">&nbsp;</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="hr-line-dashed "></div>

                            <div class="col-md-2">
                                {!! Form::label('periodSlider', trans("general.time_period"), ['class' => 'control-label']) !!}
                            </div>

                            <div class="col-md-5 controls">
                                <div id="periodSlider" class="noUiSlider" name="period_slider" data-max="31" data-default="7"></div>

                                <input type="hidden" id="periodInput" name="period_input">
                            </div>

                            <div id="periodLabel" class="col-md-1-offset-12" style="font-size: 1.2em"></div>
                        </div>
                    </div>

                    <div class="row">
                        <hr>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-custom btn-sm" id="get_canbus_report" data-canbus="{{ route('reports.canbus.get_canbus_report') }}">
                                <i class="fa fa-plus-circle"></i>&nbsp;
                                {{ trans('general.create') }}
                            </button>
                        </div>

                        <div class="col-md-5">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row hidden results">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title fix-ibox-title">
                    <div class="col-md-5 fix-title">
                        <h5>
                            <i class="fa fa-bar-chart-o"></i>
                            &nbsp; {{ trans('reports.results') }}
                        </h5>
                    </div>
                    <div class="ibox-tools">
                        <button id="clear_canbus_diagrams" class="btn btn-sm btn-custom">
                            <i class="fa fa-trash-o"></i>
                            {{ trans('general.clear') }}
                        </button>
                    </div>
                </div>

                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12 graphs"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>

    <script src='/js/define-icons.js'></script>
    <script src='/js/modules/canbus.js'></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#last_date').datepicker({
                todayBtn: 'linked',
                calendarWeeks: true,
                autoclose: true,
                format: 'yyyy-mm-dd',
                language: '{{ App::getLocale() }}',
                todayHighlight: true
            }).datepicker('setDate', new Date);
            var maxval = 31;
            if ($('#periodSlider').attr('data-max')) {
                maxval = $('#periodSlider').attr('data-max');
            }

            var defaultval = 7;
            if ($('#periodSlider').attr('data-default')) {
                defaultval = $('#periodSlider').attr('data-default');
            }

            var slider = document.getElementById('periodSlider');
            noUiSlider.create(slider, {
                start: parseInt(defaultval),
                connect: 'lower',
                step: 1,
                range: {
                    'min':  1,
                    'max':  parseInt(maxval)
                }
            });

            var periodInput = document.getElementById('periodInput'),
                periodLabel = document.getElementById('periodLabel');

            // When the slider value changes, update the input and span
            slider.noUiSlider.on('update', function( values, handle ) {
                if ( ! handle)
                {
                    periodInput.value = parseFloat(values[handle]).toFixed(0);
                    periodLabel.innerHTML = parseFloat(values[handle]).toFixed(0) + ' ' + translations.days;
                }
            });

            $("input[name=last_date]").on('change', function (){
                mutateLastDateIntoDateTime($(this).val());
            });

            var mutateLastDateIntoDateTime = function (date) {
                $('#hiddenLastDate').val($("input[name=last_date]").val() + ' 23:59:59');
            }

            mutateLastDateIntoDateTime();
        });

    </script>
@endsection
