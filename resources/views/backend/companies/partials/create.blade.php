<div class="tabs-container">
    {!! Form::open([
    'url' => route('companies.store'),
    'method' => 'post',
    'class' => 'form-horizontal post_company',
    'data-submit' => '',
    'data-table-name' => 'companiesTable'
    ]) !!}

    @include('backend.providers.compose_translation_tabs_create')
    <div class="form-group">
        <label class="col-sm-3 control-label" for="timezone">{{trans('general.timezone')}}:</label>
        <div class="col-sm-9">
            <select name="timezone" onload="select2()" id="timezone" class="form-control fix-select2">
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
                @foreach ($modules as $key => $module)
                        <option value="{{$module->id}}" selected>{{$module->translations()->first()->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">{{trans_choice('general.language', 2)}}</label>
        <div class="col-sm-9">
                @foreach($company->companyLanguages as $key => $language)
                <input onclick="updateDefaultLanguage()" class="select2-data" type='checkbox' data-select="{{$language}}"value="{{$language->id}}" name='language[]'> {{{ isset($language->name)?$language->name : null }}}
                <br>
                @endforeach
        </div>
    </div>
    <div class="form-group hidden">
        <label for="default_language" class="col-sm-3 control-label">{{trans('companies.default_language')}}</label>
        <div class="col-sm-9">
            <select name="default_language" id="default_language" class="select2-field fix-select2"></select>
        </div>
    </div>
    <br />
    <input type="hidden" name="company_id" value="{{ $company->id }}">
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

</script>
