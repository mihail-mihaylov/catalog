{!! Form::open([
        'url' => route('profile.postUserPreferences', ['user' => auth()->user()->slave_user_id]),
        'method' => 'post',
        'class' => 'form-horizontal',
        'data-submit' => '',
]) !!}
    {{-- <hr> --}}
    <div class="tabs-container">
        @include('backend.providers.compose_translation_tabs_edit')

        <div class="tab-content">
            <div class="tab-pane active" role="tabpanel">
                <div class="panel panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="timezone">{{trans('general.timezone')}}:</label>
                        <div class="col-sm-9">
                            <select name="timezone" onload="" id="timezone" class="form-control fix-select2">
                                @foreach ($timezones as $key => $timezone)
                                    @if (auth()->user()->timezone_id == $timezone->id)
                                        <option value="{{ $timezone->id }}" selected>{{ $timezone->translation->first()->name }}</option>
                                    @else
                                        <option value="{{ $timezone->id }}">{{ $timezone->translation->first()->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('profile.old_password') }}</label>
                        <div class="col-sm-9">
                            <input type='password' class='form-control' name='old_password'>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('profile.new_password') }}</label>
                        <div class="col-sm-9">
                            <input type='password' class='form-control' name='new_password'>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('profile.new_password_confirm') }}</label>
                        <div class="col-sm-9">
                            <input type='password' class='form-control' name='new_password_confirmation'>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 pull-right m-r">
                            <button class="btn btn-primary" type="submit">{{ trans('general.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        
    $("#timezone").select2({
        width: "100%",
        language: {
           "noResults": function(){
               return translations.no_data;
           }
        }
    });
    </script>
{!! Form::close() !!}

