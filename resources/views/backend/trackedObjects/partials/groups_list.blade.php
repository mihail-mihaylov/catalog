<table class="table table-striped table-bordered table-hover data-table table-condensed" id="groups_table">
    <thead>
        <th></th>
        <th>{{ trans('groups.name') }}</th>
        <th>{{ trans('trackedObjects.tracked_objects') }}</th>
        <th>{{ trans('general.actions') }}</th>
    </thead>
    <tfoot>
        <th></th>
        <th>{{ trans('groups.name') }}</th>
        <th>{{ trans('trackedObjects.tracked_objects') }}</th>
        <th>{{ trans('general.actions') }}</th>
    </tfoot>
    <tbody>
        @foreach ($groups as $group)
            @include('backend.trackedObjectsGroups.partials.row_group', ['group' => $group])
        @endforeach
    </tbody>
</table>





