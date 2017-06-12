<table class="table table-striped table-bordered table-hover data-table table-condensed" id="restrictions_table" >
    <thead>
        <tr class="gradeX">
            <th></th>
            <th class="col-md-3">{{ trans('general.name') }}</th>
            <th class="col-md-3">{{ trans('trackedObjects.tracked_object') }}</th>
            <th class="col-md-2">{{ trans('restrictions.type') }}</th>
            <th class="col-md-1">{{ trans('general.speed') }}</th>
            <th class="col-md-2">{{ trans('general.actions') }}</th>
        </tr>
    </thead>
    <tfoot>
        <tr class="gradeX">
            <th></th>
            <th class="col-md-3">{{ trans('general.name') }}</th>
            <th class="col-md-3">{{ trans('trackedObjects.tracked_object') }}</th>
            <th class="col-md-2">{{ trans('restrictions.type') }}</th>
            <th class="col-md-1">{{ trans('general.speed') }}</th>
            <th class="col-md-2">{{ trans('general.actions') }}</th>
        </tr>
    </tfoot>
    <tbody>
        @foreach ($restrictions as $restriction)
            @include('backend.restrictions.partials.row', ['restriction' => $restriction])
        @endforeach
    </tbody>
</table>
