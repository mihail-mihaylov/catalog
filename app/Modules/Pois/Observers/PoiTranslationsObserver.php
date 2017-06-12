<?php
namespace App\Modules\Pois\Observers;

use App\Observers\TranslationsObserver;

class PoiTranslationsObserver extends TranslationsObserver
{
    protected $translatedAttributes = ['name'];

    public function creating($model)
    {
        parent::convertEmptyAttributesToDefaultLanguage($model, 'poi');

        return $model;
    }
}
