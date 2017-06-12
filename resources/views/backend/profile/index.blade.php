@extends('backend.wrapper')

@section('page_title')
    {{ trans_choice("profile.profile", 1) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ trans('profile.user_preferences') }}</h5>
                </div>
                <div class="ibox-content user_profile_data">
                   @include('backend.profile.user_profile_index_data')
                </div>
            </div>
        </div>
</div>
@endsection

@section('javascript')
    {!! Html::script('js/modules/profile.js') !!}
@endsection