<div class="tabs-container">
    <form method="POST" class="form-horizontal createSharedReminderForm" action="{{route('reminders.store')}}" data-submit data-table-name="sharedRemindersTable">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        @include('backend.providers.compose_translation_tabs_create')

        <!-- Fill intended for: Groups Tracked objects or groups Users -->
        <div class="form-group">
            <label class="col-sm-2 control-label">{{trans('reminders.remind_to')}}</label>
            <div class="col-sm-10">
                <div class="input-group">
                    <select name='intended_for' class="form-control fix-select2">
                        <option value="users_groups" selected>{{trans_choice('users.user', 2)}} / {{trans_choice('groups.group', 2)}}</option>
                        <option value="tracked_object">{{trans('trackedObjects.tracked_object')}}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="hr-line-dashed"></div>

        <!-- Fill users -->
        <div class="usersHolder">
            <div class="form-group"><label class="col-sm-2 control-label">{{trans_choice('users.user',2 )}}</label>

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
        </div>

        <!-- Fill Groups -->
        <div class="groupsHolder">
            <div class="form-group">
                <label class="col-sm-2 control-label">{{trans_choice('groups.group', 2)}}</label>
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
        </div>

        <!-- Fill tracked objects -->
        <div class="trackedObjectsHolder hidden">
            <div class="form-group">
                <label class="col-sm-2 control-label">{{trans('trackedObjects.tracked_object')}}</label>
                <div class="col-sm-10">
                    <select class="tracked_object_select form-control fix-select2" name="tracked_object" id="tracked_object">
                        <option value="">{{ trans('general.please_choose') }}</option>
                        @foreach($trackedObjects as $trackedObject)
                        <option value="{{$trackedObject->id}}">
                            {{{$trackedObject->brand->translation->isEmpty() ? null : $trackedObject->brand->translation->first()->name}}}
                             / {{{$trackedObject->identification_number}}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
        </div>

        <!-- Fill users -->
        <div class="usersTrackedObjectHolder hidden">
            <div class="form-group"><label class="col-sm-2 control-label">{{trans_choice('users.user',2 )}}</label>

                <div class="col-sm-10">
                    <select class="js-example-basic-multiple form-control fix-select2" name="users_for_tracked_object[]" id="usersTrackedObject" multiple="multiple">
                    </select>

                </div>
            </div>
            <div class="hr-line-dashed"></div>
        </div>

        <div class="metricsHolder hidden">

            <!-- Remind after mileage -->
            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('reminders.reminder_after')}}</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input name="remind_after_mileage" type="text" class="form-control" aria-describedby="basic-addon2">
                        <span class="input-group-addon" id="basic-addon2">{{trans('general.km')}}</span>
                    </div>
                </div>
            </div>

            <div class="hr-line-dashed"></div>

            <!-- Remind after work hours -->
            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('reminders.reminder_after')}}</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input name="remind_after_work_hours" type="text" class="form-control" aria-describedby="basic-addon2">
                        <span class="input-group-addon" id="basic-addon2">{{trans('reminders.engine_work_hours')}}</span>
                    </div>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
        </div>

        <!-- Remind at date (datePicker) -->
        <div class="dateHolder">
            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('reminders.remind_on_date')}}</label>
                <div class="col-sm-9">
                    <div class="input-group date" data-provide="datepicker">
                        <input name="remind_at" id="remind_at" type="text" class="time form-control">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
        </div>

        <!-- Remind at date (clockPicker) -->
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('reminders.remind_time')}}</label>
            <div class="col-sm-9">
                <div class="input-group clockpicker time" data-autoclose="true">
                    <input name="remind_time_at" id="remind_time_at" type="text" class="form-control" value="00:00">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="hidden input-group date">
            {!! Form::text( 'hiddenRemindDate', '', ['class' => 'form-control', 'id' => 'hiddenRemindDate']) !!}
        </div>
        <!-- Priorities -->
        <div class="form-group">
            <label class="col-sm-2 control-label">{{trans('general.priority')}}</label>
            <div class="col-sm-10">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-success btn-sm active">
                        <input type="radio" name="priority" value="low" id="option1" autocomplete="off" checked> {{trans('reminders.priority_low')}}
                    </label>
                    <label class="btn btn-warning btn-sm">
                        <input type="radio" name="priority" value="normal" id="option2" autocomplete="off"> {{trans('reminders.priority_medium')}}
                    </label>
                    <label class="btn btn-danger  btn-sm">
                        <input type="radio" name="priority" value="high" id="option3" autocomplete="off"> {{trans('reminders.priority_high')}}
                    </label>
                </div>
            </div>
        </div>

        <div class="hr-line-dashed"></div>

        <!-- Global or Personal -->
        <div class='isGlobalHolder'>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{trans('general.type')}}</label>
                <div class="col-sm-10">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-white btn-sm ">
                            <input type="radio" name="is_global" value="1" id="option1" autocomplete="off" > {{trans('reminders.scope_global')}}
                        </label>
                        <label class="btn btn-white btn-sm active">
                            <input type="radio" name="is_global" value="0" id="option2" autocomplete="off" checked> {{trans('reminders.scope_personal')}}
                        </label>
                    </div>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
        </div>

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

            $("#usersTrackedObject").select2({
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
                'default': '00:00',
                afterHourSelect: function () {
                    $('.clockpicker').trigger('change');
                    // console.log('are ve bonak');
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
