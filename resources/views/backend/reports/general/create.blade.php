@extends('backend.wrapper')

@section('page_title')
    {{ trans('reports.general_report') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                {!! Form::open(['url' => route('reports.general.report'), 'method' => 'get', 'class' => '']) !!}
                    <div class="ibox-title">
                        <h5>
                            <i class="fa fa-bar-chart-o"></i>&nbsp;
                            {{ trans('reports.create_general_report') }}
                        </h5>
                    </div>
                    <div class="ibox-content">
                        <div class="col-md-12">
                            <div class="row">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger col-md-12">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        @foreach ($errors->all() as $error)
                                            <div class="text-left">{{ $error }}</div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-2">
                                    {!! Form::label('trackedObject', trans_choice('trackedObjects.trackedОbject', 1), ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-5">
                                    <select class="select-trackedObjects form-control fix-select2" name="deviceId" >

                                        <option value="">{{ trans('general.please_choose') }}</option>
                                        @foreach ($devices as $device)
                                            <option value="{{ $device->id }}">
                                                {{ trans('general.imei') }}: {{ $device->identification_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="hr-line-dashed "></div>
                            <div class="form-group" id="lastDate">
                                <div class="col-md-2">
                                    {!! Form::label('lastDate', trans("general.end_date"), ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group date" id="generalReportDatepicker">
                                        {!! Form::text('lastDate', '', ['class' => 'form-control']) !!}
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="hidden input-group date">
                                    {!! Form::text( 'hiddenLastDate', '', ['class' => 'form-control', 'id' => 'hiddenLastDate']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="hr-line-dashed "></div>
                            <div class="form-group">
                                <div class="col-md-2">
                                    {!! Form::label('periodSlider', trans('general.time_period'), ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-5 controls" data-title="Периода&nbsp;на&nbsp;справката&nbsp;в&nbsp;дни">
                                    <div id="periodSlider" class="noUiSlider" name="periodSlider" data-max="31" data-default="7"></div>
                                    <input type="hidden" id="periodInput" name="periodInput">
                                </div>
                                <div id="periodLabel" class="col-md-1-offset-12" style="font-size: 1.2em"></div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox-footer">
                        <div class="row">
                            <div class="form-actions">
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-custom btn-sm">
                                        <i class="fa fa-plus-circle"></i>&nbsp;
                                        {{ trans('general.create') }}
                                    </button>
                                </div>
                                <div class="col-md-5">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function()
        {
            $(".select-trackedObjects").select2({
                width: '100%',
                language: {
                   "noResults": function(){
                       return translations.no_data;
                   }
                }
            });

            $('#generalReportDatepicker').datepicker({
                todayBtn: 'linked',
                calendarWeeks: true,
                autoclose: true,
                format: 'yyyy-mm-dd',
                language: '{{ App::getLocale() }}',
                todayHighlight: true
            }).datepicker('setDate', new Date);

            var maxval = 31;
            var defaultval = 7;

            if($('#periodSlider').attr('data-max'))
            {
                maxval = $('#periodSlider').attr('data-max');
            }

            if($('#periodSlider').attr('data-default'))
            {
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
                if (!handle)
                {
                    periodInput.value = parseFloat(values[handle]).toFixed(0);
                    periodLabel.innerHTML = parseFloat(values[handle]).toFixed(0)+" "+translations.days;
                }
            });
            $("input[name=lastDate]").on('change', function (){
                // console.log($(this).val());
                mutateLastDateIntoDateTime($(this).val());
            });

            var mutateLastDateIntoDateTime = function (date) {

                $('#hiddenLastDate').val($("input[name=lastDate]").val() + ' 23:59:59');
            }

            mutateLastDateIntoDateTime();
        });
    </script>
@endsection
