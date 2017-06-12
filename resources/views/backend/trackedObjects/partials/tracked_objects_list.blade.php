<table class="table table-striped table-bordered table-hover data-table table-condensed" id="tracked_objects_table">
    <thead>
        <tr>
            <th></th>
            <th>{{ trans("trackedObjects.tracked_objects") }}</th>
            <th>{{ trans("trackedObjects.registration_number") }}</th>
            <th>{{ trans("general.actions") }}</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th>{{ trans("trackedObjects.tracked_objects") }}</th>
            <th>{{ trans("trackedObjects.registration_number") }}</th>
            <th>{{ trans("general.actions") }}</th>
        </tr>
    </tfoot>
    <tbody>
        @foreach ($trackedObjects as $trackedObject)
            @include('backend.trackedObjects.partials.row_tracked_object', ['trackedObject' => $trackedObject, 'company' => $company])
        @endforeach
    </tbody>
</table>
