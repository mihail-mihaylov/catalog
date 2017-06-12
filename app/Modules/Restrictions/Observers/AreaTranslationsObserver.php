<?php

namespace App\Modules\Restrictions\Observers;

use App\Observers\TranslationsObserver;

class AreaTranslationsObserver extends TranslationsObserver
{
    protected $translatedAttributes = ['name'];

    public function creating($model)
    {

        parent::convertEmptyAttributesToDefaultLanguage($model, 'area');

        return $model;
    }
}
