@extends('backend.wrapper')

@section('page_title')
    {{trans("trackedObjects.tracked_objects")}}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#tab_1">
                            <i class="fa fa-car"></i>
                            {{trans("trackedObjects.tracked_objects")}}
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#tab_2">
                            <i class="fa fa-group"></i>
                            {{trans("trackedObjects.groups")}}
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#tab_3">
                            <i class="fa fa-mobile"></i>
                            {{trans("trackedObjects.devices")}}
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="tab_1" class="tab-pane active">
                        <div class="ibox" id="tracked_objects_to_list">
                            <div class="ibox-title" style="border-top:none">
                                <div class="col-md-5">
                                    <h3>{{ trans('general.list_of') }} {{ trans('trackedObjects.tracked_objects') }}</h3>
                                </div>
                                <div class="ibox-tools">
                                    @can('createTrackedObject',$company)
                                        <button type="button" class="btn btn-sm btn-custom createTrackedObject" data-title="{{ trans("trackedObjects.add_new") }}" data-action="{{URL::route('trackedobjects.create')}}" data-get>
                                            <i class="fa fa-plus"></i>&nbsp;
                                            {{trans("trackedObjects.add_new")}}
                                        </button>
                                    @endcan
                                    <div class="tracked_objects_search inline"></div>
                                </div>

                            </div>
                            <div class="ibox-content">
                                @include('backend.trackedObjects.partials.tracked_objects_list')
                            </div>

                        </div>
                    </div>

                    <div id="tab_2" class="tab-pane">
                        <div class="ibox" id="groups_list">
                            <div class="ibox-title" style="border-top:none">
                                <div class="col-md-5">
                                    <h3>{{ trans('general.list_of') }} {{ trans('trackedObjects.groups') }}</h3>
                                </div>
                                <div class="ibox-tools">
                                    @can('createGroup',$company)
                                        <button type="button" class="btn btn-custom btn-sm  createTrackedObjectGroup" data-title="{{ trans("groups.add_new") }}" data-action="{{route('trackedobjects.groups.create')}}" data-get>
                                            <i class="fa fa-plus"></i>&nbsp;
                                            {{trans('groups.add_new')}}
                                        </button>
                                    @endcan
                                    <div class="groups_search inline"></div>
                                </div>
                            </div>
                            <div class="ibox-content">
                                @include('backend.trackedObjects.partials.groups_list')
                            </div>
                        </div>
                    </div>

                    <div id="tab_3" class="tab-pane">
                        <div class="ibox" id="tracked_objects_devices_list">
                            <div class="ibox-title" style="border-top:none">
                                <div class="col-md-5">
                                    <h3>
                                        {{ trans('general.list_of') }}
                                        {{ trans('trackedObjects.devices') }}
                                    </h3>
                                </div>
                                <div class="ibox-tools">
                                    @can('createDevice', $company)
                                        <button type="button" class="createNewDevice btn btn-custom btn-sm" data-title="{{ trans("devices.add_new") }}" data-action="{{route('devices.create')}}" class="btn btn-success" data-get>
                                            <i class="fa fa-plus"></i>&nbsp;
                                            {{trans('devices.add_new')}}
                                        </button>
                                    @endcan
                                    <div class="devices_search inline"></div>
                                </div>
                            </div>
                            <div class="ibox-content">
                                @include('backend.trackedObjects.partials.devices_list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    {!! Html::script('/js/modules/trackedObjectsGroups.js') !!}
    {!! Html::script('/js/data-tables.js') !!}
@endsection
