@extends('backend.wrapper')

@section('page_title')
    {{trans("devices.devices")}}
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="ibox" id="tracked_objects_devices_list">
            <div class="ibox-title" style="border-top:none">
                <div class="col-md-5">
                    <h3>
                        {{ trans('general.list_of') }}
                        {{ trans('trackedObjects.devices') }}
                    </h3>
                </div>
                <div class="ibox-tools">
                    <button type="button" class="createNewDevice btn btn-custom btn-sm" data-title="{{ trans("devices.add_new") }}" data-action="{{route('device.create')}}" class="btn btn-success" data-get>
                        <i class="fa fa-plus"></i>&nbsp;
                        {{trans('devices.add_new')}}
                    </button>
                    <div class="devices_search inline"></div>
                </div>
            </div>
            <div class="ibox-content">
                @include('backend.trackedObjects.partials.devices_list')
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    {!! Html::script('/js/modules/trackedObjectsGroups.js') !!}
    {!! Html::script('/js/data-tables.js') !!}
@endsection
{{--@section('javascript')--}}
{{--@parent--}}

{{--<script src='/js/modules/devices.js'></script>--}}
{{--@endsection--}}
