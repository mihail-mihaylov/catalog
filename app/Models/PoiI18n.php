<?php

namespace App\Models;

use App\Modules\Pois\Observers\PoiTranslationsObserver;
use App\Traits\HasTranslation;
use App\Traits\HasTranslatedAttributes;
use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;
use Session;

class PoiI18n extends Model
{
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
    }

    public static function boot()
    {
        parent::boot();

        PoiI18n::observe(\App::make(PoiTranslationsObserver::class));
    }
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'poi_i18n';

    /**
     * The guarded model fields, which cannot be filled-in
     * @var array
     */
    protected $guarded = [];

    public function poi()
    {
        return $this->belongsTo(Poi::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function getPoiIdAttribute($value)
    {
        return $value;
    }

    public function getLanguageIdAttribute($value)
    {
        return $value;
    }

    public function getNameAttribute($value)
    {
        return $value;
    }

    protected $translatedAttributes = ['name'];
}
