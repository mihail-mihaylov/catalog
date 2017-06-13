<?php
namespace App\Observers;

use Event;
use App\Events\DefaultTranslationQueued;

abstract class TranslationsObserver
{
    protected $translatedAttributes = [];

    public function convertEmptyAttributesToDefaultLanguage($model, $parentModelName)
    {
        if (!\Session::has('migrating') && !\Session::has('no_translation_observing')) {
            // hydrate the parent model
            // the observer is called in creating() event
            $model->$parentModelName;

            // the query builder provides magic methods wherePropertyName($value)
            // thus, for example $userTranslation->whereUserId($user->id) works
            // as long as the general convention of laravel is kept
            $whereParentModelId = 'where' . ucfirst($parentModelName) . 'Id';

            if($model->language_id == \Session::get('company_default_language_id')) {
                $defaultTranslation = $model;
            } else {
                $defaultTranslation = $model
                    ->{$whereParentModelId}($model->$parentModelName->id)
                    ->where('language_id', \Session::get('company_default_language_id'))
                    ->get()->first();
            }

            foreach ($this->translatedAttributes as $attribute) {
                // try to set the value depending on the default translation
                if (($model->{$attribute} == "") && isset($defaultTranslation)) {
                    $model->{$attribute} = $defaultTranslation->{$attribute};
                }
            }

            // now, based on the position of the default language value in the request
            // we may or may have not yet inserted a row for it, but in any event
            // it will be inserted at some point. This is because of the mass
            // insertion of translated values from the user interface
            if (isset($defaultTranslation)) {
                foreach ($this->translatedAttributes as $attribute) {
                    // all empty translations
                    $emptyTranslations = $model->$parentModelName
                        ->translations()
                        ->{$whereParentModelId}($model->$parentModelName->id)
                        ->where(function ($query) use ($attribute) {
                            $query->whereNull($attribute);
                            $query->orWhere($attribute, '<' , '""');
                        })->get();

                    // fix them with default    
                    foreach ($emptyTranslations as $emptyTranslation) {
                        $emptyTranslation->$attribute = $defaultTranslation->$attribute;
                        $emptyTranslation->save();
                    }
                }

            }
            
        }

        return $model;
    }
}
