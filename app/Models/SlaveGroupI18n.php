<?php

namespace App\Models;

use App\GroupI18n;
use App\Models\SlaveGroup;
use App\Models\SlaveLanguage;
use App\Modules\Users\Observers\SlaveGroupTranslationsObserver;
use App\Traits\HasTranslation;
use App\Traits\SwitchesDatabaseConnection;
use Session;
use App\Traits\HasTranslatedAttributes;

class SlaveGroupI18n extends GroupI18n
{
    use SwitchesDatabaseConnection, HasTranslation, HasTranslatedAttributes;

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        if (!Session::has('migrating')) {
            $this->connection = 'slave';
        }
    }

    public static function boot()
    {
        parent::boot();

        SlaveGroupI18n::observe(\App::make(SlaveGroupTranslationsObserver::class));
    }

    public function group()
    {
        return $this->hasOne(SlaveGroup::class, 'id', 'group_id');
    }

    public function language()
    {
        return $this->belongsTo(SlaveLanguage::class);
    }

    protected $translatedAttributes = ['name'];
}
