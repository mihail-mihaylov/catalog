<div class='form-horizontal'>
    <div class="form-group">
        <label class="col-sm-2 control-label">{{trans('general.name')}}</label>
        <div class="col-sm-10">
            <?php $i = 0; ?>
            @foreach($languages as $language)
                <div class='col-md-{{ceil(12/$languages->count())}}'>
                    <div class="{{$errors->has('name.'.$language->id)?'has-error':''}}">
                        <label class='control-label'>{{{$language->name}}}</label>
                        <input type="text" disabled class='form-control' value="{{{$sharedReminder->translations[$i]->name}}}">
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
                        <textarea disabled class='form-control'>{{{$sharedReminder->translations[$i]->description}}}</textarea>
                    </div>
                </div>
                <?php $i++; ?>
            @endforeach
        </div>
    </div>
    <div class="hr-line-dashed"></div>

    {{-- Users --}}
    <div class="form-group"><label class="col-sm-2 control-label">{{trans_choice('users.user', 2)}}</label>
        <div class="col-sm-10">
            <select class="js-example-basic-multiple form-control fix-select2" disabled multiple="multiple">
            @foreach($sharedReminder->users as $user)
                    <option value="{{$user->id}}" selected>
                        {{{ $user->translation[0]->first_name}}} {{{$user->translation[0]->last_name}}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="hr-line-dashed"></div>

    {{-- Groups --}}
    <div class="form-group">
        <label class="col-sm-2 control-label">{{trans_choice('groups.group', 2)}}</label>
        <div class="col-sm-10">
            <select class="js-example-basic-multiple form-control fix-select2" disabled multiple="multiple">
                @foreach($sharedReminder->groups as $group)
                    <option value="{{$group->id}}" selected>
                        {{{$group->translation[0]->name}}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="hr-line-dashed"></div>

    {{-- Tracked Object --}}
    @if ($sharedReminder->tracked_object_id)
    <div class="form-group">
        <label class="col-sm-2 control-label">{{trans('trackedObjects.tracked_object')}}</label>
        <div class="col-sm-10">
            <select class="js-example-basic-multiple form-control fix-select2" disabled>
                <option value="{{$sharedReminder->tracked_object_id}}" selected}}>
                    {{{$sharedReminder->trackedObject->brand->translation[0]->name}}} / {{{$sharedReminder->trackedObject->identification_number}}}
                </option>
            </select>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    @endif

    {{-- Remind after mileage --}}
    @if($sharedReminder->remind_after_mileage)
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('reminders.reminder_after')}}</label>
            <div class="col-sm-9">
                <div class="input-group">
                    <input type="text" class="form-control" value='{{$sharedReminder->remind_after_mileage}}' disabled aria-describedby="basic-addon2">
                    <span class="input-group-addon" id="basic-addon2" >{{trans('general.km')}}</span>
                </div>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
    @endif

    {{-- Remind after work hours--}}
    @if($sharedReminder->remind_after_work_hours)
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('reminders.reminder_after')}}</label>
            <div class="col-sm-9">
                <div class="input-group">
                    <input type="text" class="form-control" value='{{$sharedReminder->remind_after_work_hours}}' disabled aria-describedby="basic-addon2">
                    <span class="input-group-addon" id="basic-addon2">{{trans('reminders.engine_work_hours')}}</span>
                </div>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
    @endif

    {{-- Remind at --}}
    @if($sharedReminder->remind_at)
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('reminders.remind_on_date')}}</label>
            <div class="col-sm-9">
                <div class="input-group date">
                    <input type="text" value='{{$sharedReminder->remind_at}}' disabled class="form-control">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
    @endif

    {{-- Priority --}}
    <div class="form-group">
        <label class="col-sm-2 control-label">{{trans('general.priority')}}</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                @if($sharedReminder->priority=='low')
                    <span class="badge badge-success">
                        {{trans('reminders.priority_low')}}
                    </span>
                @elseif($sharedReminder->priority=='normal')
                    <span class="badge badge-warning">
                        {{trans('reminders.priority_medium')}}
                    </span>
                @elseif($sharedReminder->priority=='high')
                    <span class="badge badge-danger">
                        {{trans('reminders.priority_high')}}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="hr-line-dashed"></div>

    {{-- Is Global --}}
    <div class="form-group"><label class="col-sm-2 control-label">{{trans('general.type')}}</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <span class="badge badge-white">
                    @if($sharedReminder->is_global)
                    {{trans('reminders.scope_global')}}
                    @else
                    {{trans('reminders.scope_personal')}}
                    @endif
                </span>
            </div>
        </div>
    </div>

    <div class="hr-line-dashed"></div>

    {{-- Ok button --}}
    <div class="form-group">
        <div class="col-sm-offset-2 pull-right m-r">
            <button class="btn btn-primary" data-dismiss="modal" type="button">OK</button>
        </div>
    </div>
</div>

<script>
    $(function () {
        $(".js-example-basic-multiple").select2({width: '100%'});
    });
</script>
