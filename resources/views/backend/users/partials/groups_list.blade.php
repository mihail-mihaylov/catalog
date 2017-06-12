<table class="table table-striped table-bordered table-hover data-table text-left table-condensed" id="groups_table" >
    <thead>
        <tr class="gradeX">
            <th></th>
            <th>{{ trans('general.name') }}</th>
            <th>{{ trans_choice("users.user", 2) }}</th>
            <th>{{ trans('general.actions') }}</th>
        </tr>
    </thead>
    <tfoot>
        <tr class="gradeX">
            <th></th>
            <th>{{ trans('general.name') }}</th>
            <th>{{ trans_choice("users.user", 2) }}</th>
            <th>{{ trans('general.actions') }}</th>
        </tr>
    </tfoot>
    <tbody>
        @foreach ($groups as $group)
            @include('backend.users.partials.groups.list_row', ['group' => $group])
        @endforeach
    </tbody>
</table>

