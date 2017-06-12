@extends('backend.wrapper')

@section('page_title')
{{ trans('reports.fuel_report') }}
@endsection

@section('content')
<div class="row">
    <div class="hidden" id="no_data_translation" data-translation="{{ trans('general.no_data') }}"></div>

    <div class="col-md-12">
        <div class="ibox">
            {!! Form::open(['url' => route('reports.fuel.report'), 'method' => 'get', 'class' => '']) !!}
                <div class="ibox-title">
                    <div class="row">
                        <div class="col-md-10">
                            <h5>
                                <i class="fa fa-tint"></i>
                                &nbsp;{{trans('reports.make_fuel_report')}}
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

                    {{-- tracked objects --}}
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-2">
                                {!! Form::label('devices', trans_choice('trackedObjects.trackedОbject', 2), ['class' => 'control-label']) !!}
                            </div>
                            <div class="col-md-5">
                                <select class="select-trackedObjects form-control fix-select2" name="devices[]" multiple="multiple">
                                    @if (count($trackedObjects))
                                        @foreach ($trackedObjects as $to)
                                            @if ($to->devices->count() > 1)
                                                <optgroup label="{{ $to->brand->translation[0]->name . ' ' . $to->model->translation[0]->name . ' - ' . $to->identification_number }}">
                                                    @foreach ($to->devices as $device)
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

                    <div class="hr-line-dashed "></div>

                    {{-- lastDate --}}
                    <div class="row">
                        <div class="form-group ">
                            <div class="col-md-2">
                                <label class='control-label' for="lastDate">{{ trans('general.end_date') }}</label>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group lastDate">
                                    {!! Form::text('lastDate', '', ['class' => 'form-control', 'id' => 'lastDate']) !!}
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden input-group date">
                        {!! Form::text( 'hiddenLastDate', '', ['class' => 'form-control', 'id' => 'hiddenLastDate']) !!}
                    </div>
                    <div class="hr-line-dashed "></div>

                    <div class="row">
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

                    <div class="hr-line-dashed "></div>

                    <div class="row">
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-custom btn-sm" id="get_fuel_report" data-fuel="{{ route('reports.fuel.report') }}">
                                <i class="fa fa-plus-circle"></i>&nbsp;
                                {{ trans('general.create') }}
                            </button>
                        </div>                        &nbsp;
                    </div>
                </div>
            {!! Form::close() !!}
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
                    <button id="clear_fuel_diagrams" class="btn btn-sm btn-custom">
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
<script type="text/javascript">
$(document).ready(function(){
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

    $('#lastDate').datepicker({
        todayBtn: 'linked',
        calendarWeeks: true,
        autoclose: true,
        format: 'yyyy-mm-dd',
        language: '{{ App::getLocale() }}',
        todayHighlight: true
    }).datepicker('setDate', new Date);

    $(".select-trackedObjects").select2({
        width: '100%',
        language: {
           "noResults": function(){
               return translations.no_data;
           }
        }
    });
    $("input[name=lastDate]").on('change', function (){
        mutateLastDateIntoDateTime($(this).val());
    });

    var mutateLastDateIntoDateTime = function (date) {
        $('#hiddenLastDate').val($("input[name=lastDate]").val() + ' 23:59:59');
    }

    mutateLastDateIntoDateTime();

});
</script>

@endsection
