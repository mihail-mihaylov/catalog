@extends('backend.wrapper')

@section('page_title')
    {{ trans('reports.general_report') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                {!! Form::open(['url' => route('reports.general.report'), 'method' => 'POST', 'class' => '']) !!}
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
                                    {!! Form::label('devices', trans('devices.devices'), ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-5">
                                    <select class="select-devices form-control fix-select2" name="deviceId" >

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
                            <div class="form-group" id="from">
                                <div class="col-md-2">
                                    {!! Form::label('from', trans("general.from"), ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group date" id="fromDatepicker">
                                        {!! Form::text('from', '', ['class' => 'form-control']) !!}
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="hr-line-dashed "></div>
                            <div class="form-group" id="to">
                                <div class="col-md-2">
                                    {!! Form::label('to', trans("general.to"), ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group date" id="toDatepicker">
                                        {!! Form::text('to', '', ['class' => 'form-control']) !!}
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
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
            $(".select-devices").select2({
                width: '100%',
                language: {
                   "noResults": function(){
                       return translations.no_data;
                   }
                }
            });

            $('#fromDatepicker').datepicker({
                todayBtn: 'linked',
                calendarWeeks: true,
                autoclose: true,
                format: 'yyyy-mm-dd',
{{--                language: '{{ App::getLocale() }}',--}}
                todayHighlight: true
            }).datepicker('setDate', new Date);

            $('#toDatepicker').datepicker({
                todayBtn: 'linked',
                calendarWeeks: true,
                autoclose: true,
                format: 'yyyy-mm-dd',
{{--                language: '{{ App::getLocale() }}',--}}
                todayHighlight: true
            }).datepicker('setDate', new Date);
        });
    </script>
@endsection
