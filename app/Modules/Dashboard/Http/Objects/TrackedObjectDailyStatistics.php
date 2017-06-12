<?php

namespace App\Modules\Dashboard\Http\Objects;

use App\Modules\Reports\Http\Utils\Report;

class TrackedObjectDailyStatistics implements \JsonSerializable
{

    protected $deviceId;
    protected $trackedObjectName;
    protected $trackedObjectDeviceIdentificationNumber;
    protected $trackedObjectIdentificationNumber;
    protected $dailyDistance;
    protected $dailyMaxSpeed;

    public function jsonSerialize()
    {
        return [
            'deviceId'                                => $this->getDeviceId(),
            'trackedObjectName'                       => $this->getTrackedObjectName(),
            'trackedObjectDeviceIdentificationNumber' => $this->getTrackedObjectDeviceIdentificationNumber(),
            'trackedObjectIdentificationNumber'       => $this->getTrackedObjectIdentificationNumber(),
            'dailyDistance'                           => $this->getDailyDistance(),
            'dailyMaxSpeed'                           => $this->getDailyMaxSpeed(),
        ];
    }

    public static function create($trackedObject, $device, $gpsEvents)
    {
        $firstPoint = $gpsEvents->first();
        $lastPoint  = $gpsEvents->last();

        $toDailyStat = new self();
        $toDailyStat->setDeviceId($device->id);
        $toDailyStat->setTrackedObjectName($trackedObject->brand->translation()->first()->name . " " . $trackedObject->model->translation()->first()->name);
        $toDailyStat->setTrackedObjectDeviceIdentificationNumber($device->identification_number);
        $toDailyStat->setTrackedObjectIdentificationNumber($trackedObject->identification_number);
        $toDailyStat->setDailyDistance(Report::getTotalDistance($firstPoint, $lastPoint));
        $toDailyStat->setDailyMaxSpeed(Report::dailyMaxSpeed($gpsEvents));
        return $toDailyStat;
    }

    public static function createNull($trackedObject, $device)
    {
        $toDailyStat = new self();
        $toDailyStat->setDeviceId($device->id);
        $toDailyStat->setTrackedObjectName($trackedObject->brand->translation()->first()->name . " " . $trackedObject->model->translation()->first()->name);
        $toDailyStat->setTrackedObjectDeviceIdentificationNumber($device->identification_number);
        $toDailyStat->setTrackedObjectIdentificationNumber($trackedObject->identification_number);
        return $toDailyStat;
    }

    /**
     * Gets the value of deviceId.
     *
     * @return mixed
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * Sets the value of deviceId.
     *
     * @param mixed $deviceId the device id
     *
     * @return self
     */
    protected function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * Gets the value of trackedObjectName.
     *
     * @return mixed
     */
    public function getTrackedObjectName()
    {
        return $this->trackedObjectName;
    }

    /**
     * Sets the value of trackedObjectName.
     *
     * @param mixed $trackedObjectName the tracked object name
     *
     * @return self
     */
    protected function setTrackedObjectName($trackedObjectName)
    {
        $this->trackedObjectName = $trackedObjectName;

        return $this;
    }

    /**
     * Gets the value of trackedObjectDeviceIdentificationNumber.
     *
     * @return mixed
     */
    public function getTrackedObjectDeviceIdentificationNumber()
    {
        return $this->trackedObjectDeviceIdentificationNumber;
    }

    /**
     * Sets the value of trackedObjectDeviceIdentificationNumber.
     *
     * @param mixed $trackedObjectDeviceIdentificationNumber the tracked object device identification number
     *
     * @return self
     */
    protected function setTrackedObjectDeviceIdentificationNumber($trackedObjectDeviceIdentificationNumber)
    {
        $this->trackedObjectDeviceIdentificationNumber = $trackedObjectDeviceIdentificationNumber;

        return $this;
    }

    /**
     * Gets the value of trackedObjectIdentificationNumber.
     *
     * @return mixed
     */
    public function getTrackedObjectIdentificationNumber()
    {
        return $this->trackedObjectIdentificationNumber;
    }

    /**
     * Sets the value of trackedObjectIdentificationNumber.
     *
     * @param mixed $trackedObjectIdentificationNumber the tracked object identification number
     *
     * @return self
     */
    protected function setTrackedObjectIdentificationNumber($trackedObjectIdentificationNumber)
    {
        $this->trackedObjectIdentificationNumber = $trackedObjectIdentificationNumber;

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
}
