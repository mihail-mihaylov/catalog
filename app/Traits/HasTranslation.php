<?php

namespace App\Traits;

use App\Language;

trait HasTranslation
{
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * when we're refactoring we can work on this being every related model's
     * translations relation... AND we use translations relation only on generic models;
     * in essence, User, Role, Driver, and not UserI18n or something like that - remove HasTranslation
     * trait from every single occurence in *i18n models once we begin to do so
     * 
     * @return [type] [description]
     */
    public function wip_translations()
    {
        $modelName = mb_strtolower(class_basename($this->model));
        $modelName = str_replace('slave', '', $modelName);
        $modelName = str_replace('master', '', $modelName);	

    	return $this->belongsToMany(SlaveLanguage::class, $this->table . '_i18n', $modelName . '_id', 'language_id');
    }
}
