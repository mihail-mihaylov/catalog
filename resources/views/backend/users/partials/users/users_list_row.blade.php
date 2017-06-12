<tr class="gradeX" id="user_{{ $user->id }}">
    <td></td>
    <td>
        {{{ $user->translation->isEmpty() ? null : $user->translation->first()->first_name }}}
        {{{ $user->translation->isEmpty() ? null : $user->translation->first()->last_name }}}
    </td>
    <td>
        {{ $user->email }}
    </td>
    <td>
        {{ $user->phone }}
    </td>
    <td>
        {{ $user->role->translation->first()->name }}
    </td>
    <td class="center">
        {{ $user->last_login }}
    </td>
    <td class="pull-left">
            @if($user->deleted_at !== null)
                @can('deleteUser', $company)
                    <button type="button" class="btn btn-xs btn-success restore_user" data-action="{{
                        route('user.restore', [
                            'id' => $user->id,
                            'companyId' => $user->company->id,
                        ]) }}" data-update>
                        <i class="fa fa-refresh"></i>
                        {{trans('general.restore')}}
                    </button>
                @endcan
            @else
                <button class="btn btn-xs btn-warning edit_user" data-id="{{$user->id}}" data-title="{{ trans('users.edit_user') }}" data-action="{{ route('user.edit', ['user' => $user->id]) }}" data-get>
                    <i class="fa fa-pencil-square-o"></i>
                    {{trans('general.edit')}}
                </button>
          
                <button type="button" class="btn btn-xs btn-danger" data-action="{{ route('user.destroy', ['id' => $user->id]) }}" data-delete>
                    <i class="fa fa-trash-o"></i>
                    {{trans('general.delete')}}
                </button>
            @endif
    </td>
</tr>
