<?php
namespace App\Modules\Reports\Http\Objects;

use App\Modules\Reports\Http\Utils\Report as Report;

class Trip implements \JsonSerializable
{
    protected $startTime;
    protected $endTime;
    protected $startPoint;
    protected $endPoint;
    protected $totalDistance;
    protected $travelTime;
    protected $driver;
    protected $gpsPoints;
    protected $ignOnTime; // In seconds
    protected $moveTime; // In seconds
    protected $address;

    public static function createWith($startTime, $endTime, $startPoint, $endPoint, $totalDistance, $travelTime, $driver, $gpsPoints, $ignOnTime, $moveTime, $address = null)
    {
        $instance = new self();
        $instance->setStartTime($startTime);
        $instance->setEndTime($endTime);
        $instance->setStartPoint($startPoint);
        $instance->setEndPoint($endPoint);
        $instance->setTotalDistance($totalDistance);
        $instance->setTravelTime($travelTime);
        $instance->setDriver($driver);
        $instance->setGpsPoints($gpsPoints);
        $instance->setIgnOnTime($ignOnTime);
        $instance->setMoveTime($moveTime);
        $instance->setAddress($address);
        return $instance;
    }

    public static function create($dbTrip)
    {
        $instance = new self();
        if (!is_null($dbTrip->driver)) {
            $instance->setDriver($dbTrip->driver->translation[0]->first_name . " " . $dbTrip->driver->translation[0]->last_name);
        } else {
            $instance->setDriver('-');
        }
        return $instance;
    }

    public static function setInfo($trip, $tripType)
    {
        $gpsPointsForTrip = $trip->getGpsPoints();

        if($tripType == 'general')
        {
            $firstPoint = reset($gpsPointsForTrip);
            // $firstPoint->setAddress(Report::reverseGeocode($firstPoint->getGpsLat(), $firstPoint->getGpsLng()));
            $lastPoint = end($gpsPointsForTrip);
        }
        elseif($tripType == 'trips')
        {
            $firstPoint = reset($gpsPointsForTrip);
            $firstPoint->setAddress(Report::reverseGeocode($firstPoint->getGpsLat(), $firstPoint->getGpsLng()));
            $lastPoint = end($gpsPointsForTrip);
            $lastPoint->setAddress(Report::reverseGeocode($lastPoint->getGpsLat(), $lastPoint->getGpsLng()));
        }

        $trip->setStartTime($firstPoint->getGpsUtcTime());
        $trip->setEndTime($lastPoint->getGpsUtcTime());
        $trip->setStartPoint($firstPoint);
        $trip->setEndPoint($lastPoint);
        $trip->setTotalDistance(Report::getTotalDistance($firstPoint, $lastPoint));
        $trip->setTravelTime(Report::getTravelTime($firstPoint, $lastPoint));
        $trip->setIgnOnTime(Report::getIgnOnTime($firstPoint, $lastPoint));
        $trip->setMoveTime(Report::getMoveTime($gpsPointsForTrip));
    }

    public function jsonSerialize()
    {
        return [
            'startTime'     => $this->getStartTime(),
            'endTime'       => $this->getEndTime(),
            'startPoint' => $this->getStartPoint(),
            'endPoint'   => $this->getEndPoint(),
            'totalDistance' => $this->getTotalDistance(),
            'travelTime'    => $this->getTravelTime(),
            'driver'        => $this->getDriver(),
            'gpsPoints'     => $this->getGpsPoints(),
            'ignOnTime'     => $this->getIgnOnTime(),
            'moveTime'      => $this->getMoveTime(),
            'address'      => $this->getAddress(),
        ];
    }

    public function addGpsPoint($gpsPoint)
    {
        $this->gpsPoints[] = $gpsPoint;
    }
    /**
     * Gets the value of startTime.
     *
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Sets the value of startTime.
     *
     * @param mixed $startTime the start time
     *
     * @return self
     */
    protected function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Gets the value of endTime.
     *
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Sets the value of endTime.
     *
     * @param mixed $endTime the end time
     *
     * @return self
     */
    protected function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Gets the value of startPoint.
     *
     * @return mixed
     */
    public function getStartPoint()
    {
        return $this->startPoint;
    }

    /**
     * Sets the value of startPoint.
     *
     * @param mixed $startPoint the start location
     *
     * @return self
     */
    protected function setStartPoint($startPoint)
    {
        $this->startPoint = $startPoint;

        return $this;
    }

    /**
     * Gets the value of endPoint.
     *
     * @return mixed
     */
    public function getEndPoint()
    {
        return $this->endPoint;
    }

    /**
     * Sets the value of endPoint.
     *
     * @param mixed $endPoint the end location
     *
     * @return self
     */
    protected function setEndPoint($endPoint)
    {
        $this->endPoint = $endPoint;

        return $this;
    }

    /**
     * Gets the value of totalDistance.
     *
     * @return mixed
     */
    public function getTotalDistance()
    {
        return $this->totalDistance;
    }

    /**
     * Sets the value of totalDistance.
     *
     * @param mixed $totalDistance the total distance
     *
     * @return self
     */
    protected function setTotalDistance($totalDistance)
    {
        $this->totalDistance = $totalDistance;

        return $this;
    }

    /**
     * Gets the value of travelTime.
     *
     * @return mixed
     */
    public function getTravelTime()
    {
        return $this->travelTime;
    }

    /**
     * Sets the value of travelTime.
     *
     * @param mixed $travelTime the travel time
     *
     * @return self
     */
    protected function setTravelTime($travelTime)
    {
        $this->travelTime = $travelTime;

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
     * Gets the value of driver.
     *
     * @return mixed
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Sets the value of driver.
     *
     * @param mixed $driver the driver
     *
     * @return self
     */
    protected function setDriver($driver)
    {
        $this->driver = $driver;

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
     * @param mixed $address the address
     *
     * @return self
     */
    protected function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }
}
