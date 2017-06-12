@extends('backend.wrapper')

@section('page_title')
<i class="fa fa-wrench"></i>
{{trans('installer.installer')}}
@endsection

@section('content')

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5> {{trans('installer.successfully_connect_device_and_tracked_object')}} </h5>
        <div class="ibox-tools">

        </div>
    </div>
    <div class="ibox-content">
        <div class="alert alert-success" role="alert">
            {{trans('installer.successfully_connect_device_and_tracked_object')}} 
        </div>
        <a href="{{route('installer.index')}}" class="btn btn-custom btn-md">
            <i class="fa fa-mail-reply">
            </i>
            {{trans('installer.return_back')}}
        </a>
    </div>
</div>


<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>{{trans('installer.test_components')}}</h5>
        <div class="ibox-tools">

        </div>
    </div>
    <div class="ibox-content">

    </div>
</div>
@endsection
