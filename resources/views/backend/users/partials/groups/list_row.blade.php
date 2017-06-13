<tr class="gradeX" id="group_{{ $group->id }}">
    <td></td>
    <td>
{{--        {{ $group->translation->first()->name }}--}}
    </td>
    <td>@include('backend.users.partials.groups.list_group_users', ['group' => $group])</td>
    <td>
        @if($group->deleted_at)
            <button type="button" class="btn btn-xs btn-success" data-action="{{ route('group.restore', ['id' => $group->id]) }}" data-update>
                <i class="fa fa-refresh"></i>
                {{trans('general.restore')}}
            </button>
        @else
            <button data-act="ajax" class="edit_group btn btn-xs btn-warning" data-id="{{ $group->id }}" data-title="{{ trans('groups.edit_group') }}" data-action="{{ route('group.getEdit', ['id' => $group->id]) }}" data-get>
                <i class="fa fa-pencil-square-o"></i>
                {{ trans('general.edit') }}
            </button>
            <button type="button" class="btn btn-xs btn-danger" data-action="{{ route('group.destroy', ['id' => $group->id]) }}" data-delete>
                <i class="fa fa-trash-o"></i>
                {{trans('general.delete')}}
            </button>
        @endif
    </td>
</tr>
