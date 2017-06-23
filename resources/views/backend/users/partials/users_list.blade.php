<table class="table table-condensed table-striped table-bordered table-hover data-table text-left" id="users_table">
    <thead>
        <tr class="gradeX">
            <th></th>
            <th class="text-left">{{trans('general.name')}}</th>
            <th class="text-left">{{trans('general.email')}}</th>
            <th class="text-left">{{trans('general.user_role')}}</th>
            <th class="text-left">{{trans('general.actions')}}</th>
        </tr>
    </thead>
    <tfoot>
        <tr class="gradeX">
            <th></th>
            <th class="text-left">{{trans('general.name')}}</th>
            <th class="text-left">{{trans('general.email')}}</th>
            <th class="text-left">{{trans('general.user_role')}}</th>
            <th class="text-left">{{trans('general.actions')}}</th>
        </tr>
    </tfoot>
    <tbody>
        @foreach ($users as $user)
            @include('backend.users.partials.users.users_list_row', ['user' => $user])
        @endforeach
    </tbody>
</table>
