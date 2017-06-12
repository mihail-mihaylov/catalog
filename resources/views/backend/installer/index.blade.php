@extends('backend.wrapper')

@section('page_title')
    {{trans('installer.installer')}}
@endsection

@section('content')

<link href="http://webapplayers.com/inspinia_admin-v2.4/css/plugins/steps/jquery.steps.css" rel="stylesheet" type="text/css">
<script src="http://webapplayers.com/inspinia_admin-v2.4/js/plugins/staps/jquery.steps.min.js"></script>
<div class="row">
        <div class="col-md-12">
        <div class="validation_errors"></div>
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#tab_1">
                            <i class="fa fa-car"></i>
                            {{trans("installer.install_device")}}
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#tab_2">
                            <i class="fa fa-group"></i>
                            {{trans("devices.manage_inputs")}}
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="tab_1" class="tab-pane active">
                        <div class="ibox" id="tracked_objects_to_list">
                            <div class="ibox-title" style="border-top:none">
                                <div class="col-md-8">
                                    <h3>{{ trans('installer.install_device_title') }}</h3>
                                </div>
                                <div class="ibox-tools">

                                </div>

                            </div>
                            <div class="ibox-content">
                                @include('backend.installer.partials.install_device_form')
                            </div>

                        </div>
                    </div>

                    <div id="tab_2" class="tab-pane">
                        <div class="ibox" id="groups_list">
                            <div class="ibox-title" style="border-top:none">
                                <div class="col-md-8">
                                    <h3>{{ trans('installer.find_device_inputs') }}</h3>
                                </div>
                                <div class="ibox-tools">
                                    <div class="inputs_device_search inline"></div>
                                </div>
                            </div>
                            <div class="ibox-content">
                                @include('backend.installer.partials.get_device_inputs_form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    --}}

@endsection
<script type="text/javascript" src="/js/modules/installer.js"></script>
