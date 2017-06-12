<div class="panel blank-panel">
    <div class="panel-heading">
        {{-- <div class="panel-title users-module-panel-title m-b-md"><h4>Blank Panel with text tabs</h4></div> --}}
        <div class="panel-options">
            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a href="#user_panel" aria-controls="user_panel" role="tab" data-toggle="tab">{{trans_choice('users.user', 2)}}</a></li>
                <li role="presentation"><a href="#group_panel" aria-controls="group_panel" role="tab" data-toggle="tab">{{trans_choice('groups.group', 2)}}</a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="user_panel">
                @include('backend.users.partials.users_list')
            </div>
            <div role="tabpanel" class="tab-pane" id="group_panel">
                @include('backend.users.partials.groups_list')
            </div>
        </div>
    </div>

</div>
