<?php
namespace App\Modules\Dashboard\Http\Objects;

class TrackedObjectLastData implements \JsonSerializable
{
    protected $deviceId;
    protected $trackedObjectName;
    protected $trackedObjectId;
    protected $lastHeading; // "0"
    protected $lastLatitude;
    protected $lastLongitude;
    protected $lastSatellites;
    protected $lastSpeed;
    protected $lastVoltage;
    protected $lastAltitude; // "604", height under the sea
    protected $deviceStatus;
    protected $movingFrom; // took off time
    protected $parkedFrom;
    // protected $lastIgnition;
    protected $currentDriver;
    // protected $lastDriver;
    protected $communication;
    protected $dailyMaxSpeed;
    protected $dailyDistance;

    public static function createFull($trackedObject, $device, $trip, $gpsEvent)
    {
        $TOLastData = new self();
        $TOLastData->setDeviceId($device->id);
        $TOLastData->setTrackedObjectName($trackedObject->brand->translation[0]->name . " " . $trackedObject->model->translation[0]->name);
        $TOLastData->setTrackedObjectId($trackedObject->identification_number);
        $TOLastData->setLastHeading($gpsEvent->azimuth);
        $TOLastData->setLastLatitude($gpsEvent->latitude);
        $TOLastData->setLastLongitude($gpsEvent->longitude);
        $TOLastData->setLastSatellites(24);
        $TOLastData->setLastSpeed($gpsEvent->speed);
        $TOLastData->setLastVoltage($gpsEvent->power_voltage);
        $TOLastData->setLastAltitude($gpsEvent->altitude);
        $TOLastData->setDeviceStatus($gpsEvent->device_status);
        $TOLastData->setMovingFrom(TrackedObjectLastData::movingFrom($trip, $gpsEvent));
        $TOLastData->setParkedFrom(TrackedObjectLastData::parkedFrom($trip, $gpsEvent));
        // $TOLastData->setLastIgnition($lastIgnition);
        $TOLastData->setCurrentDriver(TrackedObjectLastData::currentDriver($trip));
        // $TOLastData->setLastDriver($lastDriver);
        $TOLastData->setCommunication($gpsEvent->gps_utc_time);
        // $TOLastData->setDailyDistance(Report::getTotalDistance($firstPoint, $lastPoint));
        // $TOLastData->setDailyMaxSpeed(Report::dailyMaxSpeed($gpsEvents));
        return $TOLastData;
    }

    public static function createPart($trackedObject, $device, $gpsEvent)
    {
        $TOLastData = new self();
        $TOLastData->setDeviceId($device->id);
        $TOLastData->setTrackedObjectName($trackedObject->brand->translation[0]->name . " " . $trackedObject->model->translation[0]->name);
        $TOLastData->setTrackedObjectId($trackedObject->identification_number);
        $TOLastData->setLastHeading($gpsEvent->azimuth);
        $TOLastData->setLastLatitude($gpsEvent->latitude);
        $TOLastData->setLastLongitude($gpsEvent->longitude);
        $TOLastData->setLastSatellites(24);
        $TOLastData->setLastSpeed($gpsEvent->speed);
        $TOLastData->setLastVoltage($gpsEvent->power_voltage);
        $TOLastData->setLastAltitude($gpsEvent->altitude);
        $TOLastData->setDeviceStatus($gpsEvent->device_status);
        $TOLastData->setMovingFrom(0);
        $TOLastData->setParkedFrom(0);
        // $TOLastData->setLastIgnition($lastIgnition);
        $TOLastData->setCurrentDriver(TrackedObjectLastData::currentDriver(0));
        // $TOLastData->setLastDriver($lastDriver);
        $TOLastData->setCommunication($gpsEvent->gps_utc_time);
        return $TOLastData;
    }

    public static function createNull($trackedObject, $device)
    {
        $TOLastData = new self();
        $TOLastData->setDeviceId($device->id);
        $TOLastData->setTrackedObjectName($trackedObject->brand->translation[0]->name . " " . $trackedObject->model->translation[0]->name);
        $TOLastData->setTrackedObjectId($trackedObject->identification_number);
        $TOLastData->setDeviceStatus(0);
        $TOLastData->setLastSatellites(0);
        $TOLastData->setCommunication(0);
        return $TOLastData;
    }

    public function jsonSerialize()
    {
        return [
            'deviceId'          => $this->getDeviceId(),
            'trackedObjectName' => $this->getTrackedObjectName(),
            'trackedObjectId'   => $this->getTrackedObjectId(),
            'lastHeading'       => $this->getLastHeading(),
            'lastLatitude'      => $this->getLastLatitude(),
            'lastLongitude'     => $this->getLastLongitude(),
            'lastSatellites'    => $this->getLastSatellites(),
            'lastSpeed'         => $this->getLastSpeed(),
            'lastVoltage'       => $this->getLastVoltage(),
            'lastAltitude'      => $this->getLastAltitude(),
            'deviceStatus'      => $this->getDeviceStatus(),
            'parkedFrom'        => $this->getParkedFrom(),
            'movingFrom'        => $this->getMovingFrom(),
            // 'lastIgnition'      => $this->getLastIgnition(),
            'currentDriver'     => $this->getCurrentDriver(),
            // 'lastDriver'        => $this->getLastDriver(),
            'communication'     => $this->getCommunication(),
        ];
    }

    public static function movingFrom($trip, $gpsEvent)
    {
        // dd($trip, $trip->end_time);
        if (is_null($trip->end_time)) {
            return $trip->start_time;
        }
        return 0;
    }

    public static function parkedFrom($trip, $gpsEvent)
    {
        // dd($trip, $gpsEvent);
        if (!is_null($trip->end_time)) {
            return $trip->end_time;
        }
        return 0;
    }

    public static function currentDriver($trip)
    {
        if ($trip) {
            if ($trip->driver !== null) {
                return $trip->driver->translation->first()->name;
            }
        }
        return "-";
    }

    public static function lastIgnition($gpsEvents)
    {
        $lastIgnited;
        foreach ($gpsEvents as $key => $gpsEvent) {
            if ($gpsEvent->device_status == 1) {
                $lastIgnited = $gpsPoint->getGpsUtcTime();
            }
        }
        return $lastIgnited;
    }

    public function getDeviceId()
    {
        return $this->deviceId;
    }

    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;
    }

    public function getTrackedObjectName()
    {
        return $this->trackedObjectName;
    }

    public function setTrackedObjectName($trackedObjectName)
    {
        $this->trackedObjectName = $trackedObjectName;
    }

    public function getTrackedObjectId()
    {
        return $this->trackedObjectId;
    }

    public function setTrackedObjectId($trackedObjectId)
    {
        $this->trackedObjectId = $trackedObjectId;
    }

    public function getLastHeading()
    {
        return $this->lastHeading;
    }

    public function setLastHeading($lastHeading)
    {
        $this->lastHeading = $lastHeading;
    }

    public function getLastLatitude()
    {
        return $this->lastLatitude;
    }

    public function setLastLatitude($lastLatitude)
    {
        $this->lastLatitude = $lastLatitude;
    }

    public function getLastLongitude()
    {
        return $this->lastLongitude;
    }

    public function setLastLongitude($lastLongitude)
    {
        $this->lastLongitude = $lastLongitude;
    }

    public function getLastSatellites()
    {
        return $this->lastSatellites;
    }

    public function setLastSatellites($lastSatellites)
    {
        $this->lastSatellites = $lastSatellites;
    }

    public function getLastSpeed()
    {
        return $this->lastSpeed;
    }

    public function setLastSpeed($lastSpeed)
    {
        $this->lastSpeed = $lastSpeed;
    }

    public function getLastVoltage()
    {
        return $this->lastVoltage;
    }

    public function setLastVoltage($lastVoltage)
    {
        $this->lastVoltage = $lastVoltage;
    }

    public function getLastAltitude()
    {
        return $this->lastAltitude;
    }

    public function setLastAltitude($lastAltitude)
    {
        $this->lastAltitude = $lastAltitude;
    }

    public function getMovingFrom()
    {
        return $this->movingFrom;
    }

    public function setMovingFrom($movingFrom)
    {
        $this->movingFrom = $movingFrom;
    }

    public function getParkedFrom()
    {
        return $this->parkedFrom;
    }

    public function setParkedFrom($parkedFrom)
    {
        $this->parkedFrom = $parkedFrom;
    }

    public function getLastIgnition()
    {
        return $this->lastIgnition;
    }

    public function setLastIgnition($lastIgnition)
    {
        $this->lastIgnition = $lastIgnition;
    }

    public function getCurrentDriver()
    {
        return $this->currentDriver;
    }

    public function setCurrentDriver($currentDriver)
    {
        $this->currentDriver = $currentDriver;
    }

    public function getLastDriver()
    {
        return $this->lastDriver;
    }

    public function setLastDriver($lastDriver)
    {
        $this->lastDriver = $lastDriver;
    }

    public function getCommunication()
    {
        return $this->communication;
    }

    public function setCommunication($communication)
    {
        $this->communication = $communication;
    }

    public function getDeviceStatus()
    {
        return $this->deviceStatus;
    }

    public function setDeviceStatus($deviceStatus)
    {
        // 16 (Tow): The device attached vehicle is ignition off and it is towed.
        // 1A (Fake Tow): The device attached vehicle is ignition off and it might be towed.
        // 11 (Ignition Off Rest): The device attached vehicle is ignition off and it is motionless.
        // 12 (Ignition Off Motion): The device attached vehicle is ignition off and it is moving
        // before it is treated as being towed.
        // 21 (Ignition On Rest): The device attached vehicle is ignition on and it is motion less
        // 22 (Ignition On Motion): The device attached vehicle is ignition on and it is moving
        // 41 (Sensor Rest): The device attached vehicle is motionless without ignition signal
        // detected
        // 42 (Sensor Motion): The device attached vehicle is moving without ignition signal
        // detected
        switch ($deviceStatus) {

            case 'tow':
                $this->deviceStatus = array('status_name' => trans('trackedObjects.tow'), 'status_code' => 'tow');
                break;
            case 'fake_tow':
                $this->deviceStatus = array('status_name' => trans('trackedObjects.fake_tow'), 'status_code' => 'fake_tow');
                break;
            case 'ignition_off_rest':
                $this->deviceStatus = array('status_name' => trans('trackedObjects.ignition_off_rest'), 'status_code' => 'ignition_off_rest');
                break;
            case 'ignition_off_motion':
                $this->deviceStatus = array('status_name' => trans('trackedObjects.ignition_off_motion'), 'status_code' => 'ignition_off_motion');
                break;
            case 'ignition_on_rest':
                $this->deviceStatus = array('status_name' => trans('trackedObjects.ignition_on_rest'), 'status_code' => 'ignition_on_rest');
                break;
            case 'ignition_on_motion':
                $this->deviceStatus = array('status_name' => trans('trackedObjects.ignition_on_motion'), 'status_code' => 'ignition_on_motion');
                break;
            case 'sensor_rest':
                $this->deviceStatus = array('status_name' => trans('trackedObjects.sensor_rest'), 'status_code' => 'sensor_rest');
                break;
            case 'sensor_motion':
                $this->deviceStatus = array('status_name' => trans('trackedObjects.sensor_motion'), 'status_code' => 'sensor_motion');
                break;
            default:
                $this->deviceStatus = array('status_name' => trans('trackedObjects.no_status_detected'), 'status_code' => '0');
                break;
        }
    }

    /**
     * Gets the value of dailyMaxSpeed.
     *
     * @return mixed
     */
    public function getDailyMaxSpeed()
    {
        return $this->dailyMaxSpeed;
    }

    /**
     * Sets the value of dailyMaxSpeed.
     *
     * @param mixed $dailyMaxSpeed the daily max speed
     *
     * @return self
     */
    protected function setDailyMaxSpeed($dailyMaxSpeed)
    {
        $this->dailyMaxSpeed = $dailyMaxSpeed;

        return $this;
    }

    /**
     * Gets the value of dailyDistance.
     *
     * @return mixed
     */
    public function getDailyDistance()
    {
        return $this->dailyDistance;
    }

    /**
     * Sets the value of dailyDistance.
     *
     * @param mixed $dailyDistance the daily distance
     *
     * @return self
     */
    protected function setDailyDistance($dailyDistance)
    {
        $this->dailyDistance = $dailyDistance;

        return $this;
    }
}
