@extends('backend.wrapper')

@section('page_title')
    {{trans_choice("devices.devices", 2)}}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#tab_1">
                            <i class="fa fa-user"></i>
                            {{ trans("devices.devices")}}
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#tab_2">
                            <i class="fa fa-group"></i>
                            {{trans_choice("groups.group", 2)}}
                        </a>
                    </li>
                </ul>
                <div class="tab-content">

                    <!-- Devices tab -->
                    <div id="tab_1" class="tab-pane active">

                        <div class="ibox" id="devices_list">
                            <div class="ibox-title" style="border-top:none">
                                <div class="col-md-5">
                                    <h3>
                                        {{ trans('general.list_of') }} {{ trans("devices.devices") }}
                                    </h3>
                                </div>
                                <div class="ibox-tools">

                                    <button type="button" class="btn btn-sm btn-custom create_device" data-action="{{route('device.create')}}" data-title="{{trans('devices.add_new')}}" data-get>
                                        <i class="fa fa-plus"></i>&nbsp;
                                        {{trans('devices.add_new')}}
                                    </button>


                                    <div class="devices_search inline"></div>
                                </div>

                            </div>
                            <div class="ibox-content" id="device_panel">
                                @include('backend.devices.partials.devices.devices_list')
                            </div>

                        </div>

                    </div>

                    <!-- Groups tab -->
                    <div id="tab_2" class="tab-pane">
                        <div class="ibox" id="devices_groups_list">
                            <div class="ibox-title" style="border-top:none">
                                <div class="col-md-5">
                                    <h3>
                                        {{ trans('general.list_of') }} {{ trans_choice("groups.group", 2) }}
                                    </h3>
                                </div>
                                <div class="ibox-tools">
                                    <button type="button" class="add_group btn btn-custom btn-sm" data-toggle="modal" data-target="#device_module_modal" data-href="{{--{{route('group.create')}}--}}" id="add_group"
                                            data-title="{{ trans('groups.add_new') }}" data-action="{{--{{route('group.create')}}--}}" data-get>
                                        <i class="fa fa-plus"></i>&nbsp;
                                        {{trans('groups.add_new')}}
                                    </button>
                                    <div class="devices_groups_search inline"></div>
                                </div>
                            </div>
                            <div class="ibox-content" id="group_panel">
                                @include('backend.devices.partials.groups.groups_list')
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('javascript')
    {!! Html::script('js/devices.js'); !!}
    {!! Html::script('js/data-tables.js'); !!}
@endsection



