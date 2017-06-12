<div class="tabs-container">
    {!! Form::open([
            'url' => route('user.update', ['id' => $user->id]),
            'method' => 'put',
            'class' => 'form-horizontal put_user',
            'data-submit' => '',
            'data-table-name' => 'users_table'
        ]) !!}

        @include('backend.providers.compose_translation_tabs_edit')
        <div class="form-group">
            <label class="col-sm-2 control-label">
                {{trans('general.email')}}
            </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                            <span class="help-block m-b-none"></span>
                {{-- A block of help text that breaks onto a new line and may extend beyond one line.</span> --}}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">
                {{trans('general.phone')}}
            </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                            <span class="help-block m-b-none"></span>
                {{-- A block of help text that breaks onto a new line and may extend beyond one line.</span> --}}
            </div>
        </div>

        <div class="form-group"><label class="col-sm-2 control-label">{{trans('general.user_role')}}</label>
            <div class="col-sm-10">
                <select class="form-control m-b fix-select2" name="role_id">
                    @foreach($roles as $role)
                            @if($role->id == $user->role->id)
                                <option value="{{ $role->id }}" selected>{{ $role->slug }}</option>
                            @else
                                <option value="{{ $role->id }}">{{ $role->slug }}</option>
                            @endif
                    @endforeach
                </select>
            </div>
        </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">
                    {{trans_choice('groups.group',2)}}
                </label>
                <div class="col-sm-10">
                    <select class="js-example-basic-multiple form-control fix-select2" name="groups[]" multiple="multiple">
                        @foreach ($user->company->groups as $group)
                            @if ($user->groups->contains($group))
                                <option value="{{ $group->id }}" selected>
                            @else
                                <option value="{{ $group->id }}">
                            @endif
                                    {{{ $group->translation->first() != null ? $group->translation->first()->name : null }}}
                                </option>
                        @endforeach
                    </select>
                </div>
            </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">
                {{trans('general.password')}}
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


        {{--@can('super_user')
        <div class="form-group"><label class="col-sm-2 control-label">Company</label>
            <div class="col-sm-10">
                <select class="form-control m-b" name="company_id">
                        <option value="{{ $user->company->id }}" selected="selected">{{ $user->company->id }}
                        </option>
                        @foreach($user->company->clientCompanies as $company)
                            <option value="{{ $company->id }}">{{ $company->id }}
                            </option>
                        @endforeach
                </select>
            </div>
        </div>
        @endcan --}}

        <div class="form-group">
            <div class="col-sm-offset-2 pull-right m-r">
                <button class="btn btn-white" type="button" data-dismiss="modal">{{trans('general.cancel')}}</button>
                <button class="btn btn-primary" type="submit">{{trans('general.save')}}</button>
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
        <input type="hidden" name="master_user_id" value="{{$user->master_user_id}}">
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
