 <div class="row">
    <div class="col-lg-3">
        <h3 class="no-margins">{{ trans('general.email') }}</h3>
        <br>
        <span>{{ $user->email }}</span>
    </div>
    <div class="col-lg-3">
        <h3 class="no-margins">{{ trans('general.name') }}</h3>
        <br>
        <span>{{ $user->translations()->where('language_id', Session::get('locale_id'))->first()->first_name }}</span>
    </div>
    <div class="col-lg-3">
        <h3 class="no-margins">{{ trans('general.family_name') }}</h3>
        <br>
        <span>{{ $user->translations()->where('language_id', Session::get('locale_id'))->first()->last_name }}</span>
    </div>
    <div class="col-lg-3">
        <button class="btn btn-sm btn-custom pull-right" data-action="{{ route('profile.getUserPreferences') }}" data-title="{{ trans('general.edit') }}" data-get>{{ trans('general.edit') }}</button>
    </div>
</div>