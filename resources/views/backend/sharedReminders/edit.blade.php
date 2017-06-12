<div class="tabs-container">
    <form method="POST" class="form-horizontal updateSharedReminderForm" action="{{route('reminders.update',$sharedReminder->id)}}" data-shared-reminder-id='{{$sharedReminder->id}}' data-submit data-table-name="sharedRemindersTable">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">

        @include('backend.providers.compose_translation_tabs_edit')

        @if ($sharedReminder->tracked_object_id != null)
            <!-- Tracked objects -->
            <div class="form-group">
                <label class="col-sm-2 control-label">{{trans('trackedObjects.tracked_object')}}</label>
                <div class="col-sm-10">
                    <select class="js-example-basic-multiple form-control fix-select2" name="tracked_object" id="tracked_object">
                        @foreach($trackedObjects as $trackedObject)
                            <option value="{{$trackedObject->id}}" {{($trackedObject->id == $sharedReminder->tracked_object_id)?'selected':''}}>
                                {{{$trackedObject->brand->translation->first()->name}}} / {{{$trackedObject->identification_number}}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="hr-line-dashed"></div>

            <!-- Users for tracked object-->
            <div class="usersTrackedObjectHolder">
                <div class="form-group"><label class="col-sm-2 control-label">{{trans_choice('users.user',2 )}}</label>

                    <div class="col-sm-10">
                        <select class="js-example-basic-multiple form-control fix-select2" name="users_for_tracked_object[]" id="usersTrackedObject" multiple="multiple">
                            @foreach($users as $user)
                                <option value="{{$user->id}}" {{in_array($user->id,$sharedReminderUsersIds)?'selected':''}}>
                                    {{{$user->first_name}}} {{{$user->last_name}}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
            </div>

            <div class="hr-line-dashed"></div>

            <!-- Remind after mileage -->
            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('reminders.reminder_after')}}</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" name="remind_after_mileage" class="form-control" value='{{$sharedReminder->remind_after_mileage}}'  aria-describedby="basic-addon2">
                        <span class="input-group-addon" id="basic-addon2" >{{trans('general.km')}}</span>
                    </div>
                </div>
            </div>
            <div class="hr-line-dashed"></div>


            <!-- Remind after work hours -->
            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('reminders.reminder_after')}}</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" class="form-control" value='{{$sharedReminder->remind_after_work_hours}}'  aria-describedby="basic-addon2" name="remind_after_work_hours">
                        <span class="input-group-addon" id="basic-addon2">{{trans('reminders.engine_work_hours')}}</span>
                    </div>
                </div>
            </div>
            <div class="hr-line-dashed"></div>

        @else
            <!-- Users -->
            <div class="form-group"><label class="col-sm-2 control-label">{{trans_choice('users.user', 2)}}</label>
                <div class="col-sm-10">
                    <select class="js-example-basic-multiple form-control fix-select2" name="users[]" multiple="multiple">
                        @foreach($users as $user)
                            <option value="{{$user->id}}" {{in_array($user->id,$sharedReminderUsersIds)?'selected':''}}>
                                {{{$user->translation->first()->first_name}}} {{{$user->translation->first()->last_name}}}
                            </option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="hr-line-dashed"></div>

            <!-- Groups -->
            <div class="form-group">
                <label class="col-sm-2 control-label">{{trans_choice('groups.group', 2)}}</label>
                <div class="col-sm-10">
                    <select class="js-example-basic-multiple form-control fix-select2" name="groups[]" multiple="multiple">
                        @foreach($groups as $group)
                            <option value="{{$group->id}}" {{in_array($group->id,$sharedReminderGroupsIds)?'selected':''}}>
                                {{{$group->translation->first()->name}}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="hr-line-dashed"></div>

        @endif

        <!-- Remind at date -->
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('reminders.remind_on_date')}}</label>
            <div class="col-sm-9">
                <div class="input-group date">
                    <input type="text" name="remind_at" id="remind_at" value='{{ ( ! is_null($sharedReminder->remind_at)) ? Carbon\Carbon::parse($sharedReminder->remind_at)->toDateString() : ""}}'  class="form-control time">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="hr-line-dashed"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('reminders.remind_time')}}</label>
            <div class="col-sm-9">
                <div class="input-group clockpicker time" data-autoclose="true">
                    <input name="remind_time_at" id="remind_time_at" type="text" class="form-control" value="{{ ( ! is_null($sharedReminder->remind_at)) ? Carbon\Carbon::parse($sharedReminder->remind_at)->format('H:i') : ''}}">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden input-group date">
            {!! Form::text( 'hiddenRemindDate', '', ['class' => 'form-control', 'id' => 'hiddenRemindDate']) !!}
        </div>
        <div class="hr-line-dashed"></div>

        <!-- Priority -->
        <div class="form-group">
            <label class="col-sm-2 control-label">{{trans('general.priority')}}</label>
            <div class="col-sm-10">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-success btn-sm {{($sharedReminder->priority=='low')?'active':''}}">
                        <input type="radio" name="priority" value="low" id="option1" autocomplete="off" {{($sharedReminder->priority=='low')?'checked':''}}> {{trans('reminders.priority_low')}}
                    </label>
                    <label class="btn btn-warning btn-sm {{($sharedReminder->priority=='normal')?'active':''}}">
                        <input type="radio" name="priority" value="normal" id="option2" autocomplete="off" {{($sharedReminder->priority=='normal')?'checked':''}}> {{trans('reminders.priority_normal')}}
                    </label>
                    <label class="btn btn-danger  btn-sm {{($sharedReminder->priority=='high')?'active':''}}">
                        <input type="radio" name="priority" value="high" id="option3" autocomplete="off" {{($sharedReminder->priority=='high')?'checked':''}}> {{trans('reminders.priority_high')}}
                    </label>
                </div>
            </div>
        </div>

        <div class="hr-line-dashed"></div>

        <!-- Global or Personal -->
        <div class="form-group"><label class="col-sm-2 control-label">{{trans('general.type')}}</label>
            <div class="col-sm-10">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-white btn-sm {{ $sharedReminder->is_global ? 'active' : '' }}">
                        <input type="radio" name="is_global" value="1" id="option1" autocomplete="off" {{ $sharedReminder->is_global ? 'checked' : '' }}> {{trans('reminders.scope_global')}}
                    </label>
                    <label class="btn btn-white btn-sm {{ $sharedReminder->is_global ? '' : 'active' }}">
                        <input type="radio" name="is_global" value="0" id="option2" autocomplete="off" {{ $sharedReminder->is_global ? '' : 'checked' }}> {{trans('reminders.scope_personal')}}
                    </label>
                </div>
            </div>
        </div>

        <div class="hr-line-dashed"></div>

        <!-- Cancel / Save -->
        <div class="form-group">
            <div class="col-sm-offset-2 pull-right m-r">
                <button class="btn btn-white" type="button" data-dismiss="modal">{{trans('general.cancel')}}</button>
                <button class="btn btn-primary" type="submit">{{trans('general.save')}}</button>
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

            $(".tracked_object_select").select2({
                width: '100%',
                language: {
                    "noResults": function(){
                        return translations.no_data;
                    }
                }
            });

            $('.date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                language: '{{ App::getLocale() }}',
                todayHighlight: true
            });

            $('.clockpicker').clockpicker({
                // 'default': '00:00',
                afterHourSelect: function () {
                    $('.clockpicker').trigger('change');
                }
            });

            $(document).delegate('.time', 'change', function () {
                var remindDate = $('#remind_at');
                var remindHour = $('#remind_time_at');
                var hiddenRemindDateInput = $('#hiddenRemindDate');

                var hiddenRemindDate = remindDate.val() + ' ' + remindHour.val() + ':00';

                hiddenRemindDateInput.val(hiddenRemindDate);

                if (remindDate == '') {
                    hiddenRemindDateInput.val('');
                } else if (remindDate.length > 0 && remindHour.val() == '') {
                    hiddenRemindDateInput.val(hiddenRemindDate + ' 00:00:00');
                }
            });
        });
    </script>
</div>
