@extends('backend.wrapper')

@section('page_title')
    <div class="col-md-6">
        @if ($poi->first())
            {{ trans('reports.report_of') }}
            {!! $poi->first()->translation->first()->name !!}
        @endif
    </div>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="ibox" id="poi_report_list">
            <div class="ibox-title fix-ibox-title">
                <div class="col-md-5 fix-title">
                    <h5>
                        <i class="glyphicon glyphicon-list"></i>
                        {{trans('sidebar.poi_report')}}:&nbsp;
                        @if(!is_null($from) && !is_null($to))
                            {{
                                Carbon\Carbon::parse($from)->format('d.m.Y')
                                . " - " .
                                Carbon\Carbon::parse($to)->format('d.m.Y')
                            }}
                        @endif
                    </h5>
                </div>
                <div class="ibox-tools">
                    <div class="poi_report_search"></div>
                </div>
            </div>
            <div class="ibox-content">
                <table class="table table-bordered data-table table-striped text-left table-condensed">
                    <thead>
                        <tr class="gradeX">
                            <th></th>
                            <th class="text-left">
                                {{trans_choice('trackedObjects.trackedОbject', 1)}}
                            </th>
                            <th class="text-left">
                                {{trans('reports.get_in')}}
                            </th>
                            <th class="text-left">
                                {{trans('reports.get_out')}}
                            </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr class="gradeX">
                            <th></th>
                            <th class="text-left">
                                {{trans_choice('trackedObjects.trackedОbject', 1)}}
                            </th>
                            <th class="text-left">
                                {{trans('reports.get_in')}}
                            </th>
                            <th class="text-left">
                                {{trans('reports.get_out')}}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if (!$poiHistory->isEmpty())
                            @foreach ($poiHistory as $poiVisit)
                                <tr>
                                    <td></td>
                                    <td>
                                        @if ($poiVisit->device->trackedObject)
                                            {{ $poiVisit->device->trackedObject->brand->translation->first()->name }}&nbsp;
                                            {{ $poiVisit->device->trackedObject->model->translation->first()->name }}&nbsp;
                                            ({{ $poiVisit->device->trackedObject->identification_number }})
                                        @endif
                                    </td>
                                    <td>
                                        <span style="display:none">{!! $poiVisit->start_time->format('Y.m.d h:i') !!}</span> {{--Sorting--}}
                                        {{ $poiVisit->start_time->format('H:i d.m.Y') }}</td>
                                    <td>
                                        @if($poiVisit->end_time != null)
                                            <span style="display:none">
                                                {!! $poiVisit->end_time->format('Y.m.d h:i') !!}
                                            </span> {{--Sorting--}}
                                            {{ $poiVisit->end_time->format('H:i d.m.Y') }}
                                        @else
                                            {{ trans('reports.still_in') }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    {!! Html::script('js/data-tables.js') !!}
@endsection
