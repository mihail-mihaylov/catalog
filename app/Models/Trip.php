<?php

/**
 * Description of Trip
 *
 * @author Nikolay Velchev <nvelchev@neterra.net>,
 */

namespace App;

use App\Traits\TimezoneAccessors;
use App\Traits\SwitchesDatabaseConnection;
use App\Models\SlaveDevice;
use App\Models\SlaveDriver;
use App\Models\SlaveGpsEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Session;

class Trip extends Model
{
    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        if (!Session::has('migrating')) {
            $this->connection = 'slave';
        }
    }

    // protected $firstGpsEvent;
    // protected $lastGpsEvent;

    // protected $appends = ['firstGpsEvent', 'lastGpsEvent'];

    protected $table = 'trips';

    public function driver()
    {
        return $this->belongsTo(SlaveDriver::class, 'driver_id')->with('translation');
    }

    public function device()
    {
        return $this->belongsTo(SlaveDevice::class, 'device_id')->with('trackedObject', 'gpsEvents');
    }

    public function gpsEvents()
    {
        return $this->hasMany(SlaveGpsEvent::class, 'trip_id');
    }

    public function translations()
    {
        return $this->hasMany(TripI18n::class, 'trip_id', 'id')->with('language');
    }

    public function translation()
    {
        return $this->translations()->where('language_id', Session::get('locale_id'));
    }
}
