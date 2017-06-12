<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Session;
use App\Traits\TimezoneAccessors;

class PoiPoint extends Model
{

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

    }
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'poi_points';

    /**
     * The guarded model fields, which cannot be filled-in
     * @var array
     */
    protected $guarded = [];
    // protected $appends = [
    //     'managedCompany',
    // ];

    public function poi()
    {
        return $this->belongsToOne(Poi::class);
    }

    public function getPoiIdAttribute($value)
    {
        return $value;
    }

    public function getLatitudeAttribute($value)
    {
        return $value;
    }

    public function getLongitudeAttribute($value)
    {
        return $value;
    }
}
