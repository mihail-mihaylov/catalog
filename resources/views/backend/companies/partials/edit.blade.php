<div class="tabs-container">
    {!! Form::open([
    'url' => route('companies.update', ['id' => $company->id]),
    'method' => 'put',
    'class' => 'form-horizontal post_company',
    'data-submit' => '',
    'data-table-name' => 'companiesTable'
    ]) !!}
        @include('backend.providers.compose_translation_tabs_edit')
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="timezone">{{trans('general.timezone')}}:</label>
                    <div class="col-sm-9">
                        <select name="timezone" id="timezone" class="form-control fix-select2">
                            @foreach ($timezones as $key => $timezone)
                                @if($company->timezone_id == $timezone->id)
                                    <option value="{{$timezone->id}}" selected>{{$timezone->translation->first()->name}}</option>
                                @else
                                    <option value="{{$timezone->id}}">{{$timezone->translation->first()->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="modules">{{trans('general.modules')}}:</label>
                    <div class="col-sm-9">
                        <select name="modules[]" onload="select2()" id="modules" class="form-control fix-select2" multiple="multiple">
                            @foreach ($availableModules as $key => $module)
                                    <option value="{{$module->id}}" selected>{{$module->translations()->first()->name}}</option>
                            @endforeach
                            @foreach ($unavailableModules as $key => $module)
                                    <option value="{{$module->id}}">{{$module->translations()->first()->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">{{trans_choice('general.language', 2)}}</label>
                    <div class="col-sm-9">
                        @foreach($languages as $key => $language)
                        @if(in_array($language->id, $company->companyLanguages->lists('id')->toArray()))
                        <input onclick="updateDefaultLanguage()" class="select2-data" type='checkbox' data-select="{{$language}}" value="{{$language->id}}" name='language[]' checked> {{{ isset($language->name)?$language->name : null }}}
                        @else
                        <input onclick="updateDefaultLanguage()" class="select2-data" type='checkbox' data-select="{{$language}}" value="{{$language->id}}" name='language[]'> {{{ isset($language->name)?$language->name : null }}}
                        @endif
                        @endforeach
                        <br>
                    </div>
                </div>
                <div class="form-group">
                    <label for="default_language" class="col-sm-3 control-label">{{trans('companies.default_language')}}</label>
                    <div class="col-sm-9">
                        <select name="default_language" id="default_language" class="select2-field fix-select2">
                            @foreach($company->companyLanguages as $language)
                                @if($language->pivot->default == true)
                                    <option value="{{$language->id}}" selected>{{$language->name}}</option>
                                @else
                                    <option value="{{$language->id}}">{{$language->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
        </div>
    </div>

    <input type="hidden" name="id" value="{{ $company->id }}">

    <div class="form-group">
        <div class="col-sm-offset-2 pull-right m-r">
            <button type="button" class="btn btn-white" data-dismiss="modal">{{trans('general.cancel')}}</button>
            <button class="inline btn btn-primary" type="submit">{{trans('general.save')}}</button>
        </div>
        {!! Form::close() !!}
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

$("#modules").select2({
    width: "100%",
    language: {
       "noResults": function(){
           return translations.no_data;
       }
    }
});

$("#default_language").select2({
    width: "100%",
    language: {
       "noResults": function(){
           return translations.no_data;
       }
    }
});

</script>
