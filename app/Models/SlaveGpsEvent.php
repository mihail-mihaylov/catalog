<?php

/**
 * Description of GpsEevent
 *
 * @author Nikolay Velchev <nvelchev@neterra.net>, Mihail Mihaylov <mmihaylov@neterra.net>
 */
namespace App\Models;

use App;
use App\GpsEvent;
use App\Models\SlaveDevice;
use App\Traits\SwitchesDatabaseConnection;
use App\Trip;
use Carbon\Carbon;
use Session;

class SlaveGpsEvent extends GpsEvent
{
    use SwitchesDatabaseConnection;

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        if (!Session::has('migrating')) {
            $this->connection = 'slave';
        }
    }

    public function device()
    {
        return $this->belongsTo(SlaveDevice::class, 'device_id')->with('trips', 'trackedObject');
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
}
