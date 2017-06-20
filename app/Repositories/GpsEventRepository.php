<?php

namespace App\Repositories;

use App\Models\GpsEvent;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;

class GpsEventRepository extends EloquentRepository
{
    protected $model;

    public function __construct(GpsEvent $gpsEvent)
    {
        $this->model = $gpsEvent;
    }

    public function getGpsEventsFromTo($deviceId, $from, $to)
    {
        return $this->model->where("device_id", $deviceId)
            ->whereDate("gps_utc_time", '>=', $from)
            ->whereDate("gps_utc_time", '<=', $to)
            ->orderBy("gps_utc_time")
            ->get();
    }

    public function getGpsEventsFrom($deviceId, $from)
    {
        $gpsEvents = $this->model
            ->where("device_id", $deviceId)
            ->whereDate("gps_utc_time", '=', $from)
            ->orderBy("gps_utc_time")
            ->get();

        return $gpsEvents;
    }

    public function getLastGpsEvent($deviceId)
    {
        $gpsEvent = $this->model
            ->where("device_id", $deviceId)
            ->orderBy("gps_utc_time", 'DESC')
            ->first();

        return $gpsEvent;
    }
}
