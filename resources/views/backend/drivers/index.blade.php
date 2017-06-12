@extends('backend.wrapper')

@section('page_title')
{{trans_choice('drivers.driver', 2)}}
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="ibox" id="drivers_list">
            <div class="ibox-title fix-ibox-title">
                <div class="col-md-5 fix-title">
                    <h5>
                        <i class="fa fa-truck"></i>
                        {{ trans('general.list_of') }} {{trans_choice('drivers.driver', 2)}}
                    </h5>
                </div>
                <div class="ibox-tools">
                    @can('createDriver',$company)
                    <button type="button" data-title="{{trans('drivers.add_new')}}" data-action="{{route('drivers.create')}}" class="btn btn-custom btn-sm createDriver" data-get>
                        <i class="fa fa-plus"></i>
                        {{trans('drivers.add_new')}}
                    </button>
                    @endcan
                    <div class="drivers_search inline"></div>
                </div>
            </div>
            <div class="ibox-content">
                <table class="table table-bordered table-striped table-hover data-table table-condensed" id="driversTable">
                    <thead>
                        <tr class="gradeX">
                            <th></th>
                            <th>{{trans('drivers.name')}}</th>
                            <th>{{trans('drivers.surname')}}</th>
                            <th>{{trans('drivers.family_name')}}</th>
                            <th>{{trans('general.phone')}}</th>
                            <th>{{trans('drivers.id')}}</th>
                            <th>{{trans('general.actions')}}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr class="gradeX">
                            <th></th>
                            <th>{{trans('drivers.name')}}</th>
                            <th>{{trans('drivers.surname')}}</th>
                            <th>{{trans('drivers.family_name')}}</th>
                            <th>{{trans('general.phone')}}</th>
                            <th>{{trans('drivers.id')}}</th>
                            <th>{{trans('general.actions')}}</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if(!$drivers->isEmpty())
                            @foreach ($drivers as $driver)
                                @include('backend.drivers.partials.list_driver',['driver'=>$driver,'company'=>$company])
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
@parent
<script src='/js/modules/drivers.js'></script>
{!! Html::script('js/data-tables.js'); !!}
@endsection
