<?php

namespace App\Models;

use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Poi extends Model
{
    use SoftDeletes;

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table    = 'poi';
    protected $fillable = ['radius', 'poi_type', 'icon'];
    protected $translatedAttributes = ['name'];


    public function poiI18n()
    {
        return $this->hasMany(PoiI18n::class, 'poi_id');
    }

    public function translations()
    {
        return $this->hasMany(PoiI18n::class, 'poi_id');
    }

    public function translation()
    {
        return $this->hasMany(PoiI18n::class, 'poi_id')->where('language_id', '=', Session::get('locale_id'));
    }

    public function poiPoints()
    {
        return $this->hasMany(PoiPoint::class, 'poi_id');
    }

    public function defaultTranslation()
    {
        return $this->translations()->where('language_id', '=', \Session::get('company_default_language_id'))->where('poi_id', $this->id);
    }

    public function getPoiTypeAttribute($value)
    {
        return $value;
    }

    public function getRadiusAttribute($value)
    {
        return $value;
    }

    public function getIconAttribute($value)
    {
        return $value;
    }
}
