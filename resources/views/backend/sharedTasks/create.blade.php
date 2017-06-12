<div class="tabs-container">
    <form method="POST" class="form-horizontal" action="{{route('shared_tasks.store')}}" data-submit data-table-name="sharedTasksTable">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    
        @include('backend.providers.compose_translation_tabs_create')    

        <div class="form-group"><label class="col-sm-2 control-label">{{trans_choice('general.person', 2)}}</label>

            <div class="col-sm-10">
                <select class="js-example-basic-multiple form-control fix-select2" name="users[]" id="smth" multiple="multiple">
                    @foreach($users as $user)
                    <option value="{{$user->id}}">
                        {{{$user->translation->isEmpty() ? null : $user->translation->first()->first_name}}}
                        {{{$user->translation->isEmpty() ? null : $user->translation->first()->last_name}}}
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
                    <option value="{{$group->id}}">
                        {{{$group->translation->isEmpty() ? null : $group->translation->first()->name}}}
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
                    <option value="{{$trackedObject->id}}">
                        {{{$trackedObject->brand->translation->isEmpty() ? null : $trackedObject->brand->translation->first()->name}}}
                         / {{{$trackedObject->identification_number}}}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group"><label class="col-sm-2 control-label">{{trans('general.priority')}}</label>

            <div class="col-sm-10">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-success btn-sm active">
                        <input type="radio" name="priority" value="low" id="option1" autocomplete="off" checked>
                        {{trans('tasks.priority_low')}}
                    </label>
                    <label class="btn btn-warning btn-sm">
                        <input type="radio" name="priority" value="normal" id="option2" autocomplete="off">
                        {{trans('tasks.priority_medium')}}
                    </label>
                    <label class="btn btn-danger  btn-sm">
                        <input type="radio" name="priority" value="high" id="option3" autocomplete="off">
                        {{trans('tasks.priority_high')}}
                    </label>
                </div>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group"><label class="col-sm-2 control-label">{{trans('general.type')}}</label>

            <div class="col-sm-10">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-white btn-sm ">
                        <input type="radio" name="task_type" value="0" id="option1" autocomplete="off" > {{trans('tasks.scope_global')}}
                    </label>
                    <label class="btn btn-white btn-sm active">
                        <input type="radio" name="task_type" value="1" id="option2" autocomplete="off" checked> {{trans('tasks.scope_personal')}}
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
