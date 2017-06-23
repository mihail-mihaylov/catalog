<tr class="gradeX" id="user_{{ $user->id }}">
    <td></td>
    <td>
        {{{ $user->firstname }}}
        {{{ $user->lastname }}}
    </td>
    <td>
        {{ $user->email }}
    </td>
    <td>
        {{ $user->role->name }}
    </td>
    <td class="pull-left">
            @if($user->deleted_at !== null)
                <button type="button" class="btn btn-xs btn-success restore_user" data-action="{{
                    route('user.restore', [
                        'id' => $user->id
                    ]) }}" data-update>
                    <i class="fa fa-refresh"></i>
                    {{trans('general.restore')}}
                </button>
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
