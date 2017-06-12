<?php
namespace App\Modules\Reports\Http\Objects;

class GpsPoint implements \JsonSerializable
{
    protected $deviceId;
    protected $gpsLat;
    protected $gpsLng;
    protected $gpsSpeed;
    protected $gpsHeading;
    protected $gpsUtcTime;
    protected $deviceStatus;
    // protected $takeOffTime;
    protected $mileage;
    protected $currentWorkHours; // in seconds
    protected $address;
    // protected $subtripIndex;
    // protected $firstPoint;

    public function __construct($deviceId, $gpsLat, $gpsLng, $gpsSpeed, $gpsHeading, $gpsUtcTime, $deviceStatus, $mileage, $currentWorkHours, $address)
    {
        $this->setDeviceId($deviceId);
        $this->setGpsLat($gpsLat);
        $this->setGpsLng($gpsLng);
        $this->setGpsSpeed($gpsSpeed);
        $this->setGpsHeading($gpsHeading);
        $this->setGpsUtcTime($gpsUtcTime);
        $this->setDeviceStatus($deviceStatus);
        $this->setMileage($mileage);
        $this->setCurrentWorkHours($currentWorkHours);
        $this->setAddress($address);
    }

    public function jsonSerialize()
    {
        return [
            'deviceId'         => $this->getDeviceId(),
            'gpsLat'           => $this->getGpsLat(),
            'gpsLng'           => $this->getGpsLng(),
            'gpsSpeed'         => $this->getGpsSpeed(),
            'gpsHeading'       => $this->getGpsHeading(),
            'gpsUtcTime'       => $this->getGpsUtcTime(),
            'deviceStatus'     => $this->getDeviceStatus(),
            'mileage'          => $this->getMileage(),
            'currentWorkHours' => $this->getCurrentWorkHours(),
            'address'          => $this->getAddress(),
        ];
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
     * Gets the value of gpsLat.
     *
     * @return mixed
     */
    public function getGpsLat()
    {
        return $this->gpsLat;
    }

    /**
     * Sets the value of gpsLat.
     *
     * @param mixed $gpsLat the gps lat
     *
     * @return self
     */
    protected function setGpsLat($gpsLat)
    {
        $this->gpsLat = $gpsLat;

        return $this;
    }

    /**
     * Gets the value of gpsLng.
     *
     * @return mixed
     */
    public function getGpsLng()
    {
        return $this->gpsLng;
    }

    /**
     * Sets the value of gpsLng.
     *
     * @param mixed $gpsLng the gps lng
     *
     * @return self
     */
    protected function setGpsLng($gpsLng)
    {
        $this->gpsLng = $gpsLng;

        return $this;
    }

    /**
     * Gets the value of gpsSpeed.
     *
     * @return mixed
     */
    public function getGpsSpeed()
    {
        return $this->gpsSpeed;
    }

    /**
     * Sets the value of gpsSpeed.
     *
     * @param mixed $gpsSpeed the gps speed
     *
     * @return self
     */
    protected function setGpsSpeed($gpsSpeed)
    {
        $this->gpsSpeed = $gpsSpeed;

        return $this;
    }

    /**
     * Gets the value of gpsHeading.
     *
     * @return mixed
     */
    public function getGpsHeading()
    {
        return $this->gpsHeading;
    }

    /**
     * Sets the value of gpsHeading.
     *
     * @param mixed $gpsHeading the gps heading
     *
     * @return self
     */
    protected function setGpsHeading($gpsHeading)
    {
        $this->gpsHeading = $gpsHeading;

        return $this;
    }

    /**
     * Gets the value of gpsUtcTime.
     *
     * @return mixed
     */
    public function getGpsUtcTime()
    {
        return $this->gpsUtcTime;
    }

    /**
     * Sets the value of gpsUtcTime.
     *
     * @param mixed $gpsUtcTime the gps utc time
     *
     * @return self
     */
    protected function setGpsUtcTime($gpsUtcTime)
    {
        $this->gpsUtcTime = $gpsUtcTime;

        return $this;
    }

    /**
     * Gets the value of isIgnited.
     *
     * @return mixed
     */
    public function getDeviceStatus()
    {
        return $this->deviceStatus;
    }

    /**
     * Sets the value of isIgnited.
     *
     * @param mixed $isIgnited the is ignited
     *
     * @return self
     */
    protected function setDeviceStatus($deviceStatus)
    {
        $this->deviceStatus = $deviceStatus;

        return $this;
    }

    /**
     * Gets the value of takeOffTime.
     *
     * @return mixed
     */
    public function getTakeOffTime()
    {
        return $this->takeOffTime;
    }

    /**
     * Sets the value of takeOffTime.
     *
     * @param mixed $takeOffTime the take off time
     *
     * @return self
     */
    protected function setTakeOffTime($takeOffTime)
    {
        $this->takeOffTime = $takeOffTime;

        return $this;
    }

    /**
     * Gets the value of mileage.
     *
     * @return mixed
     */
    public function getMileage()
    {
        return $this->mileage;
    }

    /**
     * Sets the value of mileage.
     *
     * @param mixed $mileage the mileage
     *
     * @return self
     */
    protected function setMileage($mileage)
    {
        $this->mileage = $mileage;

        return $this;
    }

    /**
     * Gets the value of currentWorkHours.
     *
     * @return mixed
     */
    public function getCurrentWorkHours()
    {
        return $this->currentWorkHours;
    }

    /**
     * Sets the value of currentWorkHours.
     *
     * @param mixed $currentWorkHours the ignition time
     *
     * @return self
     */
    protected function setCurrentWorkHours($currentWorkHours)
    {
        $this->currentWorkHours = $currentWorkHours;

        return $this;
    }

    /**
     * Gets the value of address.
     *
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets the value of address.
     *
     * @param mixed $address the subtrip index
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Gets the value of firstPoint.
     *
     * @return mixed
     */
    public function getFirstPoint()
    {
        return $this->firstPoint;
    }

    /**
     * Sets the value of firstPoint.
     *
     * @param mixed $firstPoint the first point
     *
     * @return self
     */
    protected function setFirstPoint($firstPoint)
    {
        $this->firstPoint = $firstPoint;

        return $this;
    }
}
