<?php

namespace App\Repositories;

use App\Modules\TrackedObjects\Repositories\DeviceInterface;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\SlaveGpsEvent;
use Carbon\Carbon;
use DatePeriod;
use DateTime;
use App\Trip;
use Session;
use App\Models\Device;

class DeviceRepository extends EloquentRepository
{
    protected $model;

    public function __construct(Device $device)
    {
        $this->model = $device;
    }

    public function getDeviceInfo($deviceId)
    {
        return $this->model
            ->where('id', $deviceId)
            ->get();
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function lastData()
    {
        return $this->model

        ->with('lastTrip', 'lastGpsEvent');
    }

    public function getAllWithLastData()
    {
        return $this->model->with('lastGpsEvent');
    }



    private function transformGpsTimeColumnsIntoCarbon($gpsEvents)
    {
        foreach ($gpsEvents as $gpsEvent)
        {
            if (isset($gpsEvent->gps_utc_time) && ! $gpsEvent->gps_utc_time instanceof Carbon)
            {
                $gpsEvent->gps_utc_time = new Carbon($gpsEvent->gps_utc_time);
            }
        }

        return $gpsEvents;
    }
}