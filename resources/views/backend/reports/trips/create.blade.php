@extends('backend.wrapper')

@section('page_title')
    {{ trans('reports.trip_report') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                {!! Form::open(['url' => route('reports.trips.store'), 'method' => 'POST', 'class' => '']) !!}
                    <div class="ibox-title">
                        <h5><i class="fa fa-road"></i>&nbsp;{{ trans('trips.create') }}</h5>
                    </div>
                    <div class="ibox-content">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger col-md-12">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                @foreach ($errors->all() as $error)
                                    <div class="text-left">{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-2">
                                    {!! Form::label( 'trackedObject', trans_choice('trackedObjects.trackedОbject', 1), ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-5">
                                    <select class="select-trackedObjects form-control fix-select2" name="deviceId" >
                                        @if (count($trackedObjects))
                                            <option value="">{{ trans('general.please_choose') }}</option>
                                            @foreach ($trackedObjects as $to)
                                                @if (count($to->devices) > 1)
                                                    <optgroup label="{{ $to->brand->translation[0]->name . ' ' . $to->model->translation[0]->name . ' - ' . $to->identification_number }}">
                                                        @foreach($to->devices as $device)
                                                            <option value="{{ $device->id }}">
                                                                {{ trans('general.imei') }}: {{ $device->identification_number }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                @elseif (count($to->devices) == 0)
                                                    <option value="" disabled>{{ $to->brand->translation[0]->name . " " . $to->model->translation[0]->name . " - " . $to->identification_number . " - No device attached" }}
                                                    </option>
                                                @else
                                                    <option value="{{ $to->devices[0]->id }}">{{ $to->brand->translation[0]->name . " " . $to->model->translation[0]->name . " - " . $to->identification_number }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group" id="">
                                <div class="hr-line-dashed "></div>
                                <div class="col-md-2">
                                    {!! Form::label('driver', trans_choice('drivers.driver', 1), ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-5">
                                    {!! Form::select('driver', $drivers, null, ['id' => 'driver', 'class' => 'select-drivers form-control fix-select2']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group" id="">
                                <div class="hr-line-dashed "></div>
                                <div class="col-md-2">
                                    {!! Form::label('lastDate', trans("general.end_date"), ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group date" id="generalReportDatepicker">
                                        {!! Form::text( 'lastDate', '', ['class' => 'form-control datesForReport', 'placeholder' => 'yyyy-mm-dd', 'id' => 'lastDate']) !!}
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                    <div class="hidden input-group date">
                                        {!! Form::text( 'firstDate', '', ['class' => 'form-control', 'id' => 'firstDate']) !!}

                                        {!! Form::text( 'firstDateStart', '', ['class' => 'form-control', 'id' => 'firstDateStart']) !!}
                                        {!! Form::text( 'firstDateEnd', '', ['class' => 'form-control', 'id' => 'firstDateEnd']) !!}
                                        {!! Form::text( 'lastDateStart', '', ['class' => 'form-control', 'id' => 'lastDateStart']) !!}
                                        {!! Form::text( 'lastDateEnd', '', ['class' => 'form-control', 'id' => 'lastDateEnd']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <div class="hr-line-dashed "></div>
                                <div class="col-md-2">
                                    {!! Form::label('periodSlider', trans("general.time_period"), ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-5 controls">
                                    <div id="periodSlider" class="noUiSlider datesForReport" name="periodSlider" data-max="31" data-default="7"></div>
                                    <input type="hidden" id="periodInput" name="periodInput" class="datesForReport">
                                </div>
                                <div id="periodLabel" class="col-md-1-offset-12" style="font-size: 1.2em"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <div class="hr-line-dashed "></div>
                                <div class="col-md-2">
                                    {!! Form::label('startTime', trans("general.work_hours"), ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-5">
                                    {!! Form::text('startTime', '00:00', ['class' => 'form-control col-md-2 datesForReport', 'id' => 'startTime', 'placeholder' => 'ЧЧ:ММ', 'style' => 'width:60px']) !!}
                                    {!! Form::text('endTime', '23:59', ['class' => 'form-control col-md-2 datesForReport', 'id' => 'endTime', 'placeholder' => 'ЧЧ:ММ', 'style' => 'width:60px']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <div class="hr-line-dashed "></div>
                                <div class="col-md-2"></div>
                                <div class="col-md-5 controls">
                                    {!! Form::checkbox('days[]', '1', true) !!}&nbsp;{{ trans('dates.monday') }}&nbsp;
                                    {!! Form::checkbox('days[]', '2', true) !!}&nbsp;{{ trans('dates.tuesday') }}&nbsp;
                                    {!! Form::checkbox('days[]', '3', true) !!}&nbsp;{{ trans('dates.wednesday') }}&nbsp;
                                    {!! Form::checkbox('days[]', '4', true) !!}&nbsp;{{ trans('dates.thursday') }}&nbsp;
                                    {!! Form::checkbox('days[]', '5', true) !!}&nbsp;{{ trans('dates.friday') }}&nbsp;
                                    {!! Form::checkbox('days[]', '6', true) !!}&nbsp;{{ trans('dates.saturday') }}&nbsp;
                                    {!! Form::checkbox('days[]', '7', true) !!}&nbsp;{{ trans('dates.sunday') }}&nbsp;
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox-footer">
                        <div class="form-actions">
                            <button type="submit" class="btn btn-custom btn-sm">
                                <i class="fa fa-plus-circle"></i>&nbsp;
                                {{ trans('general.create') }}
                            </button>
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
                width:"100%",
                language: {
                   "noResults": function(){
                       return translations.no_data;
                   }
                }
            });

            $(".select-drivers").select2({
                width:"100%",
                language: {
                   "noResults": function(){
                       return translations.no_data;
                   }
                }
            });

            var locale = $('.data-locale').data('locale');

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
                    periodLabel.innerHTML = parseFloat(values[handle]).toFixed(0) + ' ' + translations.days;
                    $('#endTime').trigger('change');
                }
            });

            $(document).delegate('.datesForReport','change', function(item) {
                fillDateTimeFieldsForTripReport();
            });
            // $(document).delegate('.datesForReport','mouseup', function(item) {
            //     fillDateTimeFieldsForTripReport();
            // });


            var fillDateTimeFieldsForTripReport = function () {

                var periodIterator = period = $('#periodInput').val();
                var lastDate                = $('#lastDate').val();
                var startTime               = $('#startTime').val();
                var endTime                 = $('#endTime').val();

                var lastDateStart = moment(lastDate + ' ' + startTime + ':00', 'YYYY-MM-DD HH:mm:ss');
                var lastDateEnd   = moment(lastDate + ' ' + endTime + ':59', 'YYYY-MM-DD HH:mm:ss');
                
                var firstDayStart = moment(lastDateStart, 'YYYY-MM-DD HH:mm:ss').subtract((period - 1) * 24, 'hours');
                var firstDayEnd   = moment(lastDateEnd, 'YYYY-MM-DD HH:mm:ss').subtract((period - 1) * 24, 'hours');

                $('#firstDateStart').val(firstDayStart.format('YYYY-MM-DD HH:mm:ss'));
                $('#firstDateEnd').val(firstDayEnd.format('YYYY-MM-DD HH:mm:ss'));
                $('#lastDateStart').val(lastDateStart.format('YYYY-MM-DD HH:mm:ss'));
                $('#lastDateEnd').val(lastDateEnd.format('YYYY-MM-DD HH:mm:ss'));

                $('#firstDate').val(firstDayStart.format('YYYY-MM-DD'));
            }

            fillDateTimeFieldsForTripReport();
        });
    </script>
@endsection
