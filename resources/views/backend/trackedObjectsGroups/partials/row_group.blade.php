<tr id="{{ $group->id }}" class="gradeX">
    <td></td>
    <td class="text-left">
        {{{ $group->translation->first()->name }}}</a>
    </td>
    <td class="text-left">
        @include('backend.trackedObjectsGroups.partials.list_group_tracked_objects', ['group' => $group])
    </td>
    <td class="text-left">
        @if ($group->deleted_at == null)
            @can ('updateGroup', $company)
                <button class="btn btn-warning btn-xs editGroupName" type="button" data-group-id="{{ $group->id }}" data-title="{{ trans('general.edit') }}" data-action="{{ route('trackedobjects.groups.edit', $group->id) }}" data-get>
                    <i class="fa fa-edit"></i>
                    {{ trans('general.edit') }}
                </button>
            @endcan

            @can ('deleteGroup', $company)
                <button type="button" class="btn btn-danger btn-xs deleteTrackedObjectGroup" data-action="{{ route('trackedobjects.groups.destroy', ['id' => $group->id]) }}" data-delete>
                    <i class="fa fa-trash-o"></i>
                    {{ trans('general.delete') }}
                </button>
            @endcan
        @else
            @can ('deleteGroup', $company)
                <button class="btn btn-success btn-xs restoreTrackedObjectGroup" type="button"  data-action="{{ route('trackedobjects.groups.restore', ['id' => $group->id]) }}" data-update>
                    <i class="fa fa-refresh"></i>
                    {{ trans('general.restore') }}
                </button>
            @endcan
        @endif
    </td>
</tr>
