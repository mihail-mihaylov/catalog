<div class='form-horizontal'>
    <div class="form-group">
        <label class="col-sm-2 control-label">{{trans('general.name')}}</label>
        <div class="col-sm-10">
            <?php $i = 0; ?>
            @foreach($languages as $language)
            <div class='col-md-{{ceil(12/$languages->count())}}'>
                <div class="{{$errors->has('name.'.$language->id)?'has-error':''}}">
                    <label class='control-label'>{{{$language->name}}}</label>
                    <input type="text" disabled class='form-control' value="{{{$task->translations[$i]->name}}}">
                </div>
            </div>
            <?php $i++; ?>
            @endforeach
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">{{trans('general.description')}}</label>
        <div class="col-sm-10">
            <?php $i = 0; ?>
            @foreach($languages as $language)
            <div class='col-md-{{ceil(12/$languages->count())}}'>
                <div class="{{$errors->has('description.'.$language->id)?'has-error':''}}">
                    <label class='control-label'>{{{$language->name}}}</label>
                    <textarea disabled class='form-control'>{{{$task->translation->first()->description}}}</textarea>
                </div>
            </div>
            <?php $i++; ?>
            @endforeach
        </div>
    </div>
    <div class="hr-line-dashed"></div>

    <div class="form-group"><label class="col-sm-2 control-label">{{trans_choice('users.user', 2)}}</label>

        <div class="col-sm-10">
            <select class="js-example-basic-multiple form-control fix-select2" disabled multiple="multiple">
                @foreach($users as $user)
                <option value="{{$user->id}}" {{in_array($user->id,$sharedTasksUsersIds)?'selected':''}}>
                    {{{$user->translation()->first()->first_name}}} {{{$user->translation()->first()->last_name}}}
                </option>
                @endforeach
            </select>

        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">{{trans_choice('groups.group', 2)}}</label>

        <div class="col-sm-10">
            <select class="js-example-basic-multiple form-control fix-select2" disabled multiple="multiple">
                @foreach($groups as $group)
                <option value="{{$group->id}}" {{in_array($group->id,$sharedTasksGroupsIds)?'selected':''}}>
                    {{{$group->translation()->first()->name}}}
                </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">{{trans('trackedObjects.tracked_objects')}}</label>

        <div class="col-sm-10">
            <select class="js-example-basic-multiple form-control fix-select2" disabled multiple="multiple">
                @foreach($trackedObjects as $trackedObject)
                <option value="{{$trackedObject->id}}" {{in_array($trackedObject->id,$sharedTasksTrackedObjectsIds)?'selected':''}}>
                    {{{$trackedObject->brand->translation()->first()->name}}} / {{{$trackedObject->identification_number}}}
                </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">{{trans('general.priority')}}</label>

        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                @if($task->priority=='low')
                <span class="badge badge-success">
                    {{trans('tasks.priority_low')}}
                </span>
                @elseif($task->priority=='normal')
                <span class="badge badge-warning">
                    {{trans('tasks.priority_medium')}}
                </span>
                @elseif($task->priority=='high')
                <span class="badge badge-danger">
                    {{trans('tasks.priority_high')}}
                </span>
                @endif
            </div>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
     <div class="form-group"><label class="col-sm-2 control-label">{{trans('general.type')}}</label>
    <div class="col-sm-10">
        <div class="btn-group" data-toggle="buttons">
            <span class="badge badge-white">
                @if($task->task_type)
                {{trans('tasks.scope_personal')}}
                @endif
                @if(!$task->task_type)
                {{trans('tasks.scope_global')}}
                @endif
            </span>
        </div>
    </div>
</div>
<div class="hr-line-dashed"></div>
    <div class="form-group">
        <div class="col-sm-offset-2 pull-right m-r">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
        </div>
    </div>
</div>
<script>
    $(function () {
        $(".js-example-basic-multiple").select2({width: '100%'});
    });
</script>
