@can('createUser', $company)
    <div class="tabs-container">
        {!! Form::open([
            'url' => route('user.store'),
            'method' => 'post',
            'class' => 'form-horizontal post_user',
            'data-submit' => '',
            'data-table-name' => 'users_table'
        ]) !!}

        <div class="form-group">
            <label class="col-sm-2 control-label">
                {{ trans('general.first_name') }}
            </label>

            <div class="col-sm-10">
                <input type="text" class="form-control" name="firstname">
                <span class="help-block m-b-none"></span>
                {{-- A block of help text that breaks onto a new line and may extend beyond one line. --}}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">
                {{ trans('general.last_name') }}
            </label>

            <div class="col-sm-10">
                <input type="text" class="form-control" name="lastname">
                <span class="help-block m-b-none"></span>
                {{-- A block of help text that breaks onto a new line and may extend beyond one line. --}}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">
                {{ trans('general.email') }}
            </label>

            <div class="col-sm-10">
                <input type="text" class="form-control" name="email">
                <span class="help-block m-b-none"></span>
                    {{-- A block of help text that breaks onto a new line and may extend beyond one line. --}}
            </div>
        </div>

        <div class="form-group"><label class="col-sm-2 col-md-2 col-lg-2 control-label">{{ trans('general.user_role') }}</label>
            <div class="col-sm-10">
                <select class="form-control m-b fix-select2" name="role_id">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">
                {{ trans_choice('groups.group', 2) }}
            </label>

            <div class="col-sm-10">
                <select class="js-example-basic-multiple form-control fix-select2" name="groups[]" multiple="multiple">
                    @foreach ($groups as $group)
                        <option value="{{ $group->id }}">{{{ $group->name ?: null }}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">
                {{ trans('general.password') }}
            </label>

            <div class="col-sm-10">
                <input type="password" class="form-control" name="password">
                <span class="help-block m-b-none"></span>
                {{-- A block of help text that breaks onto a new line and may extend beyond one line.</span> --}}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">
                {{ trans('general.confirm_password') }}
            </label>

            <div class="col-sm-10">
                <input type="password" class="form-control" name="password_confirmation">
                <span class="help-block m-b-none"></span>
                {{-- A block of help text that breaks onto a new line and may extend beyond one line.</span> --}}
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 pull-right m-r">
                <button type="button" class="btn btn-white" data-dismiss="modal">{{ trans('general.cancel') }}</button>
                <button class="inline btn btn-primary" type="submit">{{ trans('general.save') }}</button>
            </div>

            <div id="submit_user_spinner" class="hidden col col-lg-2 col-md-2 col-sm-2">
                <div class="sk-spinner sk-spinner-circle">
                    <div class="sk-circle1 sk-circle"></div>
                    <div class="sk-circle2 sk-circle"></div>
                    <div class="sk-circle3 sk-circle"></div>
                    <div class="sk-circle4 sk-circle"></div>
                    <div class="sk-circle5 sk-circle"></div>
                    <div class="sk-circle6 sk-circle"></div>
                    <div class="sk-circle7 sk-circle"></div>
                    <div class="sk-circle8 sk-circle"></div>
                    <div class="sk-circle9 sk-circle"></div>
                    <div class="sk-circle10 sk-circle"></div>
                    <div class="sk-circle11 sk-circle"></div>
                    <div class="sk-circle12 sk-circle"></div>
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>

    <script>
        $(".js-example-basic-multiple").select2({
            width: '100%',
            language: {
               "noResults": function(){
                   return translations.no_data;
               }
            }
        });
    </script>
@endcan
