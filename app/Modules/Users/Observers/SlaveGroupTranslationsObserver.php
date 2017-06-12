<?php
namespace App\Modules\Users\Observers;

use App\Observers\TranslationsObserver;

class SlaveGroupTranslationsObserver extends TranslationsObserver
{
    protected $translatedAttributes = ['name'];

    public function creating($model)
    {
        parent::convertEmptyAttributesToDefaultLanguage($model, 'group');

        return $model;
    }
}
