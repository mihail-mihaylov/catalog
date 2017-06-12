<div class="tabs-container">
    <ul class="nav nav-tabs">
        @foreach ($companyLanguages as $language)
            <li role="presentation" class="{{ ($language->pivot->default==1)?'active':'' }}">
                <a href="#language-tab-{{ $language->id }}" aria-controls="language-tab-{{ $language->id }}" role="tab" data-toggle="tab">{{{ $language->name }}}</a>
            </li>
        @endforeach
    </ul>

    <div class="tab-content">
        @foreach ($companyLanguages as $language)
            <div class="tab-pane {{ ($language->pivot->default==1)?'active':'' }}" id="language-tab-{{ $language->id }}" role="tabpanel">
                <div class="panel-body">
                    @foreach ($model->translations()->getModel()->translatedAttributes as $attribute)
                        <div class="form-group">
                            <label class="col-sm-2 col-lg-2 col-md-2 col-sx-2 control-label" for="name{{ $language->id }}">{{ trans("general.translated_attributes.$attribute") }}:</label>
                            <div class="col-sm-10 col-md-10 col-sx-10 col-lg-10">
                                <input id="name{{ $language->id }}" type="text" name="translations[{{ $language->id }}][{{{ $attribute }}}]" class="form-control {{ $attribute }}" value="{{ $model->translations()->where('language_id', $language->id)->first()->{$attribute} }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
<br/>