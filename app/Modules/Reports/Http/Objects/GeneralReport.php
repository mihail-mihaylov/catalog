<?php
namespace App\Modules\Reports\Http\Objects;

use App\Modules\Reports\Http\Utils\Report;

class GeneralReport implements \JsonSerializable
{
    protected $trackedObjectName;
    protected $trackedObjectId;
    protected $deviceId;
    protected $firstPoint;
    protected $lastPoint;
    protected $gpsPoints;
    // protected $trips;
    // protected $stops;
    protected $dailyDistance;
    protected $dailyMaxSpeed;
    protected $ignOnTime;
    protected $moveTime;
    // protected $travelTime;

    public static function createWith(
        $trackedObjectName,
        $trackedObjectId,
        $deviceId,
        $firstPoint,
        $lastPoint,
        $gpsPoints,
        /*$trips,*/
        // $stops,
        $dailyDistance,
        $dailyMaxSpeed,
        $ignOnTime,
        $moveTime
        // $travelTime
    ) {
        $instance = new self();
        $instance->setTrackedObjectName($trackedObjectName);
        $instance->setTrackedObjectId($trackedObjectId);
        $instance->setDeviceId($deviceId);
        $instance->setFirstPoint($firstPoint);
        $instance->setLastPoint($lastPoint);
        $instance->setGpsPoints($gpsPoints);
        $instance->setTrips($trips);
        // $instance->setStops($stops);
        $instance->setDailyDistance($dailyDistance);
        $instance->setDailyMaxSpeed($dailyMaxSpeed);
        $instance->setIgnOnTime($ignOnTime);
        $instance->setMoveTime($moveTime);
        // $instance->setTravelTime($travelTime);
        return $instance;
    }

    public static function create()
    {
        $instance = new self();
        return $instance;
    }

    public function jsonSerialize()
    {
        return [
            'trackedObjectName' => $this->getTrackedObjectName(),
            'trackedObjectId'   => $this->getTrackedObjectId(),
            'deviceId'          => $this->getDeviceId(),
            'firstPoint'        => $this->getFirstPoint(),
            'lastPoint'         => $this->getLastPoint(),
            'gpsPoints'         => $this->getGpsPoints(),
            'trips'             => $this->getTrips(),
            // 'stops'             => $this->getStops(),
            'dailyDistance'     => $this->getDailyDistance(),
            'ignOnTime'         => $this->getIgnOnTime(),
            'moveTime'          => $this->getMoveTime(),
            // 'travelTime'        => $this->getTravelTime(),
        ];
    }

    public static function addGpsEvent($generalReport, $event)
    {
        $generalReport->gpsPoints[] = Report::createGpsPoint($event);
    }

    public function addTrip($dbTrip)
    {
        $this->trips[] = $dbTrip;
    }

    public function setInfo($trackedObject)
    {
        $gpsPointsForGeneralReport = $this->getGpsPoints();
        $firstPoint                = reset($gpsPointsForGeneralReport);
        $lastPoint                 = end($gpsPointsForGeneralReport);

        $get = Report::getMaxSpeedMoveTimeFirstLastMove($gpsPointsForGeneralReport);


        $this->setTrackedObjectName($trackedObject->brand->translation[0]->name . " " . $trackedObject->model->translation[0]->name);
        $this->setTrackedObjectId($trackedObject->identification_number);
        $this->setDeviceId($trackedObject->id);
        $this->setFirstPoint($get['firstMove']);
        $this->setLastPoint($get['lastMove']);
        $this->setGpsPoints($gpsPointsForGeneralReport);
        $this->setDailyDistance(Report::getTotalDistance($firstPoint, $lastPoint));
        $this->setDailyMaxSpeed($get['maxSpeed']);
        $this->setIgnOnTime(Report::getIgnOnTime($firstPoint, $lastPoint));
        $this->setMoveTime($get['moveTime']);
        // dd($this);
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
     * Gets the value of trackedObjectId.
     *
     * @return mixed
     */
    public function getTrackedObjectId()
    {
        return $this->trackedObjectId;
    }

    /**
     * Sets the value of trackedObjectId.
     *
     * @param mixed $trackedObjectId the tracked object id
     *
     * @return self
     */
    protected function setTrackedObjectId($trackedObjectId)
    {
        $this->trackedObjectId = $trackedObjectId;

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

    /**
     * Gets the value of lastPoint.
     *
     * @return mixed
     */
    public function getLastPoint()
    {
        return $this->lastPoint;
    }

    /**
     * Sets the value of lastPoint.
     *
     * @param mixed $lastPoint the last point
     *
     * @return self
     */
    protected function setLastPoint($lastPoint)
    {
        $this->lastPoint = $lastPoint;

        return $this;
    }

    /**
     * Gets the value of gpsPoints.
     *
     * @return mixed
     */
    public function getGpsPoints()
    {
        return $this->gpsPoints;
    }

    /**
     * Sets the value of gpsPoints.
     *
     * @param mixed $gpsPoints the gps points
     *
     * @return self
     */
    protected function setGpsPoints($gpsPoints)
    {
        $this->gpsPoints = $gpsPoints;

        return $this;
    }

    /**
     * Gets the value of trips.
     *
     * @return mixed
     */
    public function getTrips()
    {
        // return $this->trips;
    }

    /**
     * Sets the value of trips.
     *
     * @param mixed $trips the trips
     *
     * @return self
     */
    public function setTrips($trips)
    {
        $this->trips = $trips;

        return $this;
    }

    /**
     * Gets the value of stops.
     *
     * @return mixed
     */
    public function getStops()
    {
        return $this->stops;
    }

    /**
     * Sets the value of stops.
     *
     * @param mixed $stops the stops
     *
     * @return self
     */
    protected function setStops($stops)
    {
        $this->stops = $stops;

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

    /**
     * Gets the value of ignOnTime.
     *
     * @return mixed
     */
    public function getIgnOnTime()
    {
        return $this->ignOnTime;
    }

    /**
     * Sets the value of ignOnTime.
     *
     * @param mixed $ignOnTime the ign on time
     *
     * @return self
     */
    protected function setIgnOnTime($ignOnTime)
    {
        $this->ignOnTime = $ignOnTime;

        return $this;
    }

    /**
     * Gets the value of moveTime.
     *
     * @return mixed
     */
    public function getMoveTime()
    {
        return $this->moveTime;
    }

    /**
     * Sets the value of moveTime.
     *
     * @param mixed $moveTime the move time
     *
     * @return self
     */
    protected function setMoveTime($moveTime)
    {
        $this->moveTime = $moveTime;

        return $this;
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
}
