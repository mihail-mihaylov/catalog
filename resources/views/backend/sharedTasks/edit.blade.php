<div class="tabs-container">
    <form method="POST" class="form-horizontal" action="{{route('shared_tasks.update',$task->id)}}" data-shared-task-id='{{$task->id}}' data-submit data-table-name="sharedTasksTable">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">

        @include('backend.providers.compose_translation_tabs_edit')

        <div class="form-group"><label class="col-sm-2 control-label">{{trans_choice('users.user', 2)}}</label>

            <div class="col-sm-10">
                <select class="js-example-basic-multiple form-control fix-select2" name="users[]" id="smth" multiple="multiple">
                    @foreach($users as $user)
                    <option value="{{$user->id}}" {{in_array($user->id,$sharedTasksUsersIds)?'selected':''}}>
                        @if(!($user->translation->isEmpty()))
                            {{{$user->translation()->first()->first_name}}} {{{$user->translation()->first()->last_name}}}
                        @else
                        asd
                        @endif
                    </option>
                    @endforeach
                </select>

            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group"><label class="col-sm-2 control-label">{{trans_choice('groups.group', 2)}}</label>

            <div class="col-sm-10">
                <select class="js-example-basic-multiple form-control fix-select2" name="groups[]" multiple="multiple">
                    @foreach($groups as $group)
                    <option value="{{$group->id}}" {{in_array($group->id,$sharedTasksGroupsIds)?'selected':''}}>
                    @if(!($group->translation->isEmpty()))
                        {{{$group->translation()->first()->name}}}
                    @else
                    @endif
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group"><label class="col-sm-2 control-label">{{trans('trackedObjects.tracked_objects')}}</label>

            <div class="col-sm-10">
                <select class="js-example-basic-multiple form-control fix-select2" name="tracked_bojects[]" id="trob" multiple="multiple">
                    @foreach($trackedObjects as $trackedObject)
                    <option value="{{$trackedObject->id}}" {{in_array($trackedObject->id,$sharedTasksTrackedObjectsIds)?'selected':''}}>
                    @if($trackedObject->brand->translation->isEmpty())
                    @else
                        {{{$trackedObject->brand->translation->first()->name}}} / {{{$trackedObject->identification_number}}}
                    @endif
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group"><label class="col-sm-2 control-label">{{trans('general.priority')}}</label>

            <div class="col-sm-10">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-success btn-sm {{($task->priority=='low')?'active':''}}">
                        <input type="radio" name="priority" value="low" id="option1" autocomplete="off" {{($task->priority=='low')?'checked':''}}> {{trans('tasks.priority_low')}}
                    </label>
                    <label class="btn btn-warning btn-sm {{($task->priority=='normal')?'active':''}}">
                        <input type="radio" name="priority" value="normal" id="option2" autocomplete="off" {{($task->priority=='normal')?'checked':''}}> {{trans('tasks.priority_normal')}}
                    </label>
                    <label class="btn btn-danger  btn-sm {{($task->priority=='high')?'active':''}}">
                        <input type="radio" name="priority" value="high" id="option3" autocomplete="off" {{($task->priority=='high')?'checked':''}}> {{trans('tasks.priority_high')}}
                    </label>
                </div>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group"><label class="col-sm-2 control-label">{{trans('general.type')}}</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-white btn-sm {{($task->task_type == 0)?'active':''}}">
                    <input type="radio" name="task_type" value="0" id="option1" autocomplete="off" {{($task->task_type == 0)?'checked':''}}> {{trans('tasks.scope_global')}}
                </label>
                <label class="btn btn-white btn-sm {{($task->task_type == 1)?'active':''}}">
                    <input type="radio" name="task_type" value="1" id="option2" autocomplete="off" {{($task->task_type == 1)?'checked':''}}> {{trans('tasks.scope_personal')}}
                </label>
            </div>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
        <div class="form-group">
            <div class="col-sm-offset-2 pull-right m-r">
                <button type="button" class="btn btn-white" data-dismiss="modal">{{trans('general.cancel')}}</button>
                <button class="inline btn btn-primary" type="submit">{{trans('general.save')}}</button>
            </div>
        </div>
    </form>
    <script>
        $(function () {
            $(".js-example-basic-multiple").select2({
                width: '100%',
                language: {
                   "noResults": function(){
                       return translations.no_data;
                   }
                }
            });
        });
    </script>
</div>
