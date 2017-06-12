<?php

namespace App\Modules\Restrictions\Observers;

use App\Observers\TranslationsObserver;

class RestrictionTranslationsObserver extends TranslationsObserver
{

    protected $translatedAttributes = ['name'];

    public function creating($model)
    {
        parent::convertEmptyAttributesToDefaultLanguage($model, 'limit');

        // if (!$model->exists) {
        //     $defaultTranslation = $model->limit->defaultTranslation()->get();

        //     foreach (['name'] as $attribute) {
        //         if ($model->{$attribute} == "") {
        //             try {
        //                 $model->{$attribute} = isset($defaultTranslation) ?
        //                 $defaultTranslation->{$attribute} : trans('general.name');
        //             } catch (\Exception $e) {
        //                 $model->{$attribute} = trans('general.name');
        //             }

        //         }
        //     }

        // }

        return $model;
    }
}
