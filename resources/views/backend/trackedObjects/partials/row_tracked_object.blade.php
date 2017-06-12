<tr class="read gradeX" id="trackedObjectRow{{ $trackedObject->id }}">
    <td></td>
    <td class="text-left">
        {{{ $trackedObject->brand->translation->first()->name }}}
    </td>
    <td class="text-left">
        {{{ $trackedObject->identification_number }}}
    </td>
    <td class="text-left">
        @if ($trackedObject->deleted_at !== null)
            @can ('deleteTrackedObject', $company)
                <button class="btn btn-success btn-xs restoreTrackedObjectButton" type="button"  data-action="{{ route('trackedobjects.restore', ['id' => $trackedObject->id]) }}" data-update trackedObjectId="{{ $trackedObject->id }}">
                    <i class="fa fa-refresh"></i>
                    {{ trans('general.restore') }}
                </button>
            @endcan
        @else
            @can ('assignGroup', $company)
                @can ('admin')
                    <button
                            class="btn btn-xs btn-info"
                            type="button"
                            data-title="{{ trans('trackedObjects.add_delete_groups') }}"
                            data-action="{{ route('trackedObject.get.groups', ['trackedObjects' => $trackedObject->id]) }}"
                            data-get>

                        <i class="fa fa-group (alias)"></i>&nbsp;
                        {{ trans('trackedObjects.add_delete_groups') }}
                    </button>
                @endcan
            @endcan
            @can ('updateTrackedObject', $company)
                <button class="btn btn-warning btn-xs editTrackedObject" type="button" data-title="{{ trans('general.edit') }}" data-action="{{ route('trackedobjects.edit', $trackedObject->id) }}" data-get>
                    <i class="fa fa-edit"></i>&nbsp;
                    {{ trans('general.edit') }}
                </button>
            @endcan
            @can ('deleteTrackedObject', $company)
                <button type="button" class="btn btn-danger btn-xs removeTrackedObject" data-action="{{ route('trackedobjects.destroy', ['id' => $trackedObject->id]) }}" data-delete trackedObjectId="{{ $trackedObject->id }}">
                    <i class="fa fa-trash-o"></i>
                    {{ trans('general.delete') }}
                </button>
            @endcan
        @endif
    </td>
</tr>
