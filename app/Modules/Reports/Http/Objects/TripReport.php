<?php

namespace App\Modules\Reports\Http\Objects;

class TripReport implements \JsonSerializable
{
    protected $trackedObjectName;
    protected $trackedObjectId;
    protected $trips;
    protected $tripsTotalDistance;
    protected $allGpsPoints;
    protected $firstPoint;
    protected $lastPoint;

    public static function createWith($trackedObjectName, $trackedObjectId, $trips, $tripsTotalDistance, $allGpsPoints, $firstPoint, $lastPoint)
    {
        $instance = new self();
        $instance->setTrackedObjectName($trackedObjectName);
        $instance->setTrackedObjectId($trackedObjectId);
        $instance->setTrips($trips);
        $instance->setTripsTotalDistance($tripsTotalDistance);
        $instance->setAllGpsPoints($allGpsPoints);
        $instance->setFirstPoint($firstPoint);
        $instance->setLastPoint($lastPoint);
        return $instance;
    }

    public static function create()
    {
        return new self();
    }

    public function jsonSerialize()
    {
        return [
            'trackedObjectName'  => $this->getTrackedObjectName(),
            'trackedObjectId'    => $this->getTrackedObjectId(),
            'trips'              => $this->getTrips(),
            'tripsTotalDistance' => $this->getTripsTotalDistance(),
            'allGpsPoints'       => $this->getAllGpsPoints(),
            'firstPoint'         => $this->getFirstPoint(),
            'lastPoint'          => $this->getLastPoint(),
        ];
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
     * Gets the value of trips.
     *
     * @return mixed
     */
    public function getTrips()
    {
        return $this->trips;
    }

    /**
     * Sets the value of trips.
     *
     * @param mixed $trips the trips
     *
     * @return self
     */
    protected function setTrips($trips)
    {
        $this->trips = $trips;

        return $this;
    }

    /**
     * Gets the value of tripsTotalDistance.
     *
     * @return mixed
     */
    public function getTripsTotalDistance()
    {
        return $this->tripsTotalDistance;
    }

    /**
     * Sets the value of tripsTotalDistance.
     *
     * @param mixed $tripsTotalDistance the trips total distance
     *
     * @return self
     */
    protected function setTripsTotalDistance($tripsTotalDistance)
    {
        $this->tripsTotalDistance = $tripsTotalDistance;

        return $this;
    }

    /**
     * Gets the value of allGpsPoints.
     *
     * @return mixed
     */
    public function getAllGpsPoints()
    {
        return $this->allGpsPoints;
    }

    /**
     * Sets the value of allGpsPoints.
     *
     * @param mixed $allGpsPoints the all gps points
     *
     * @return self
     */
    protected function setAllGpsPoints($allGpsPoints)
    {
        $this->allGpsPoints = $allGpsPoints;

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
}
