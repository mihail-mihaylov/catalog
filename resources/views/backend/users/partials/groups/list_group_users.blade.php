@forelse($group->usersWithTranslations as $user)
    @if($user->deleted_at != null)
        <span class="btn btn-white ">
            <label class="badge badge-danger">
                &nbsp;
                {{{ $user->translation->first()->first_name }}}
                {{{ $user->translation->first()->last_name }}}
                &nbsp;
            </label>
        </span>
    @else
        <span class="btn btn-white ">
            <label class="badge badge-success">
                &nbsp;
                {{{ $user->translation->first()->first_name }}}
                {{{ $user->translation->first()->last_name }}}
                &nbsp;
            </label>
        </span>
    @endif
@empty
    {{ trans('users.none_found') }}
@endforelse
