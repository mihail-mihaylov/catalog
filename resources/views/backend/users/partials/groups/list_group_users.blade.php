@forelse($group->users as $user)
    @if($user->deleted_at != null)
        <span class="btn btn-white ">
            <label class="badge badge-danger">
                &nbsp;
                {{{ $user->firstname }}}
                {{{ $user->lastname }}}
                &nbsp;
            </label>
        </span>
    @else
        <span class="btn btn-white ">
            <label class="badge badge-success">
                &nbsp;
                {{{ $user->firstname }}}
                {{{ $user->lastname }}}
                &nbsp;
            </label>
        </span>
    @endif
@empty
    {{ trans('users.none_found') }}
@endforelse
