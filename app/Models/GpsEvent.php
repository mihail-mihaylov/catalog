<?php

namespace App\Models;

use App\Models\SlaveDevice;
use App\Traits\SwitchesDatabaseConnection;
use App\Traits\TimezoneAccessors;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Session;

class GpsEvent extends Model
{
    protected $table = 'gps_events';
    protected $managedCompany = null;

    protected $fillable = ['*'];
    protected $guarded  = [''];

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id')->with('trips', 'trackedObject');
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
}
