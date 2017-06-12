<form action="{{ route('trackedObject.groups.updateGroups', ['trackedObjectId' => $trackedObjectId]) }}" method="POST" data-table-name="groups_table" data-submit>
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
    <ul class='list-group'>
        @forelse($groups as $group)
            <li class="list-group-item">
                <label>
                    <input
                        type="checkbox"
                        name="groups[]"
                        value="{{ $group->id }}"
                        {{ (in_array($group->id, $objectGroups))?'checked':'' }} >

                    {{{ $group->groupI18n[0]->name }}}
                </label>
            </li>
        @empty
            {{ trans('general.no_data') }}
            @can('createGroup',$company)
                <button type="button" class="btn btn-primary btn-outline btn-md pull-right createTrackedObjectGroup" data-href="{{ route('trackedobjectsGroups.create') }}">
                    <i class="fa fa-plus"></i>&nbsp; {{ trans('groups.create') }}
                </button>
            @endcan
        @endforelse
    </ul>
    <div class="form-group">
        <div class="col-sm-offset-2 pull-right m-r">
            <button type="button" class="btn btn-white" data-dismiss="modal">{{ trans('general.cancel') }}</button>
            <button class="inline btn btn-primary" type="submit">{{ trans('general.save') }}</button>
        </div>
    </div>
    <br />
</form>
