<?php

namespace App\Models;

use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SlaveDevice;
use Session;
use Carbon\Carbon;

class PoiHistory extends Model
{
    use SoftDeletes;

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
    }

    protected $table = 'poi_history';

    public function device()
    {
        return $this->belongsTo(SlaveDevice::class)->with('trackedObject');
    }

    public function poi()
    {
        return $this->belongsTo(Poi::class)->with('poiPoints', 'translation');
    }
}
