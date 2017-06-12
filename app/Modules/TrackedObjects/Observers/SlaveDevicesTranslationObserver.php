<?php
namespace App\Modules\TrackedObjects\Observers;

use App\Observers\TranslationsObserver;

class SlaveDevicesTranslationObserver extends TranslationsObserver
{
    protected $translatedAttributes = ['name'];
    
    public function creating($model)
    {
        // if we are creating and we filled in empty values for those fields
        // intercept and get the values of the default language for the company
        // from `company_languages` and populate those fields
        //
        // this goes under the assumption that the validation for the default language
        // to be always required, is already in place and working
        //
        // without this validation in place, we can no longer safely access
        // $model->user->translations->...->first()

        // very important check
        // to this whole thing only when creating
        // not when updating
        parent::convertEmptyAttributesToDefaultLanguage($model, 'device');

        return $model;
    }

}