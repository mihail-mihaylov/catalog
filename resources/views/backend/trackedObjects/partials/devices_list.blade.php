<table class="table table-striped table-bordered table-hover data-table table-condensed" id="devices_table">
    <thead>
        <tr class="gradeX">
            <th></th>
            <th>{{trans('general.identification_number')}}</th>
            <th>{{trans('general.actions')}}</th>
        </tr>
    </thead>
    <tfoot>
        <tr class="gradeX">
            <th></th>
            <th>{{trans('general.identification_number')}}</th>
            <th>{{trans('general.actions')}}</th>
        </tr>
    </tfoot>
    <tbody>
        @foreach ($devices as $device)
            @include('backend.devices.partials.row_device', ['device' => $device])
        @endforeach
    </tbody>
</table>

