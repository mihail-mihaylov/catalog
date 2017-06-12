@extends('backend.wrapper')

@section('page_title')
    {{trans_choice('poi.poi', 2)}}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title fix-ibox-title">
                    <div class="col-md-5 fix-title">
                        <h5>
                            <i class="glyphicon glyphicon-map-marker"></i>
                            {{trans('poi.your_pois')}}
                        </h5>
                    </div>
                    <div class="ibox-tools">
                        <button class="btn btn-custom btn-sm" type="button" id="fit-pois">
                            <i class="glyphicon glyphicon-eye-open"></i>
                            &nbsp; {{trans('poi.focus_all_pois')}}
                        </button>
                    </div>
                </div>
                <div class="ibox-content no-padding">
                    <div id="map" style="height:512px;width:100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="ibox" id="pois_list">
                <div class="ibox-title fix-ibox-title">
                    <div class="col-md-5 fix-title">
                        <h5>
                            <i class="glyphicon glyphicon-map-marker"></i>
                            {{ trans('general.list_of') }} {{ trans_choice('poi.poi', 2) }}
                        </h5>
                    </div>
                    <div class="ibox-tools">
                        <button type="button" class="btn btn-sm btn-custom createPoi" data-title="{{ trans('poi.add_object') }}" data-action="{{URL::route('pois.create')}}" data-get>
                            <i class="fa fa-plus"></i>&nbsp;
                            {{trans("poi.add_object")}}
                        </button>
                        <div class="pois_search inline"></div>
                    </div>
                </div>
                <div class="ibox-content">
                    <table id="pois_table" class="table table-bordered table-condensed table-hover data-table text-left">
                        <thead>
                            <tr class="gradeX">
                                <th></th>
                                <th>{{ trans('poi.name') }}</th>
                                <th>{{ trans('poi.type') }}</th>
                                <th>{{ trans('general.actions') }}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="gradeX">
                                <th></th>
                                <th>{{ trans('poi.name') }}</th>
                                <th>{{ trans('poi.type') }}</th>
                                <th>{{ trans('general.actions') }}</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($pois as $key => $poi)
                                @include ('backend.pois.partials.poi_row', [
                                    'number' => $key,
                                    'poi' => $poi,
                                    'company' => $company
                                    ])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <br/><br/><br/>
@endsection

@section('javascript')
    {!! Html::script('js/modules/pois/pois.js') !!}
    {!! Html::script('js/modules/pois/loadPois.js') !!}
    {!! Html::script('js/data-tables.js') !!}
@endsection
