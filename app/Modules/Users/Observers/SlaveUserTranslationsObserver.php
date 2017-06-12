<?php
namespace App\Modules\Users\Observers;

use App\Observers\TranslationsObserver;
use Session;

class SlaveUserTranslationsObserver extends TranslationsObserver
{

    protected $translatedAttributes = ['first_name', 'last_name'];
    
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
        parent::convertEmptyAttributesToDefaultLanguage($model, 'user');

        return $model;
    }

    public function getCompanyDefaultLanguage()
    {
        foreach (Session::get('company_languages') as $language) {
            if ($language->pivot->default == 1) {
                return $language->id;
            }
        }
    }
}
