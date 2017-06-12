@extends('backend.wrapper')
@section('content')
<div class="row">
    <div class="col-md-12">
        <button type="button" class="createNewDevice btn btn-success" data-href="{{route('devices.create')}}" class="btn btn-success">
            {{trans('devices.add_new')}}
        </button>
        <br>
        <br>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped" id="devicesTable">
            <thead>
                <tr>
                    <th>{{trans('general.number')}}</th>
                    <th>{{trans('general.model')}}</th>
                    <th>{{trans('general.identification_number')}}</th>
                    <th>{{trans('trackedObjects.tracked_object')}}</th>
                    <th>{{trans('general.actions')}}</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>{{trans('general.number')}}</th>
                    <th>{{trans('general.model')}}</th>
                    <th>{{trans('general.identification_number')}}</th>
                    <th>{{trans('trackedObjects.tracked_object')}}</th>
                    <th>{{trans('general.actions')}}</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach($devices as $device)
                    @include('backend.devices.partials.row_device',['device'=>$device])
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('javascript')
@parent
<script src='/js/modules/devices.js'></script>
@endsection
