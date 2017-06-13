@extends('backend.wrapper')

@section('page_title')
    {{trans_choice("users.user", 2)}}
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#tab_1">
                        <i class="fa fa-user"></i>
                        {{trans_choice("users.user", 2)}}
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

                <!-- Users tab -->
                <div id="tab_1" class="tab-pane active">

                    <div class="ibox" id="users_list">
                        <div class="ibox-title" style="border-top:none">
                            <div class="col-md-5">
                                <h3>
                                    {{ trans('general.list_of') }} {{ trans_choice("users.user", 2) }}
                                </h3>
                            </div>
                            <div class="ibox-tools">
                      
                                    <button type="button" class="btn btn-sm btn-custom create_user" data-action="{{route('user.create')}}" data-title="{{trans('users.add_new')}}" data-get>
                                        <i class="fa fa-plus"></i>&nbsp;
                                        {{trans('users.add_new')}}
                                    </button>
                             

                                <div class="users_search inline"></div>
                            </div>

                        </div>
                        <div class="ibox-content" id="user_panel">
                            @include('backend.users.partials.users_list')
                        </div>

                    </div>

                </div>

                <!-- Groups tab -->
                <div id="tab_2" class="tab-pane">
                    <div class="ibox" id="users_groups_list">
                        <div class="ibox-title" style="border-top:none">
                            <div class="col-md-5">
                                <h3>
                                    {{ trans('general.list_of') }} {{ trans_choice("groups.group", 2) }}
                                </h3>
                            </div>
                            <div class="ibox-tools">
                                <button type="button" class="add_group btn btn-custom btn-sm" data-toggle="modal" data-target="#user_module_modal" data-href="{{--{{route('group.create')}}--}}" id="add_group"
                                data-title="{{ trans('groups.add_new') }}" data-action="{{--{{route('group.create')}}--}}" data-get>
                                    <i class="fa fa-plus"></i>&nbsp;
                                    {{trans('groups.add_new')}}
                                </button>
                                <div class="users_groups_search inline"></div>
                            </div>
                        </div>
                        <div class="ibox-content" id="group_panel">
                           @include('backend.users.partials.groups_list')
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection


@section('javascript')
{!! Html::script('js/users.js'); !!}
{!! Html::script('js/data-tables.js'); !!}
@endsection


