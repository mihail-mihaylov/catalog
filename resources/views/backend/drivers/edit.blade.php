<div class="tabs-container">
    <form method="post" id="updateDriverForm" class="form-horizontal" action="{{route('drivers.update',$driver->id)}}" data-driver-id='{{$driver->id}}' data-submit data-table-name="driversTable">
        <input type="hidden" name='id' value='{{$driver->id}}'>
        <input type="hidden" name='_method' value='PUT'>


        @include('backend.providers.compose_translation_tabs_edit')

        <div class="form-group {{$errors->has('identification_number')?'has-error':''}}">
            <label class="col-sm-2 control-label">{{trans('drivers.id')}}</label>
            <div class="col-sm-10"><input type="text" name="identification_number" class="form-control" value="{{{Input::old('identification_number',$driver->identification_number)}}}"></div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group {{$errors->has('phone')?'has-error':''}}">
            <label class="col-sm-2 control-label">{{trans('general.phone')}}</label>
            <div class="col-sm-10"><input type="text" name="phone" class="form-control" value="{{{Input::old('phone',$driver->phone)}}}"></div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <div class="col-sm-offset-2 pull-right m-r">
                <button type="button" class="btn btn-white" data-dismiss="modal">{{trans('general.cancel')}}</button>
                <button class="inline btn btn-primary" type="submit">{{trans('general.save')}}</button>
            </div>
        </div>
        {{--<button class='btn btn-success' type='submit'>--}}
            {{--<i class="fa fa-refresh"></i>--}}
            {{--{{trans('general.update')}}--}}
        {{--</button>--}}
    </form>
</div>
