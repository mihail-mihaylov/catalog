<?php

namespace App\Modules\Reports\Http\Utils;

use App;
use App\Models\GpsEvent;
use App\Modules\Reports\Http\Objects\GeneralReport;
use App\Modules\Reports\Http\Objects\GpsPoint;
use App\Modules\Reports\Http\Objects\Trip as Trip;
use App\Modules\Reports\Http\Objects\TripReport;
use Carbon\Carbon;

class Report
{
    public static function generalReport($from, $to, $trackedObject, $gpsEvents, $dbTrips)
    {
        $generalReports = [];

        // dd($trackedObject, $gpsEvents,$dbTrips);
        if (count($gpsEvents) > 1 && $trackedObject && count($dbTrips) != 0)
        {
            // Put all gpsEvents to their genReport
            foreach ($gpsEvents as $key => $gpsEvent) {
                if (isset($generalReports[$gpsEvent->gps_utc_time->toDateString()])) {
                    $generalReports[$gpsEvent->gps_utc_time->toDateString()]->addGpsEvent($generalReports[$gpsEvent->gps_utc_time->toDateString()], $gpsEvent);
                } else {
                    $generalReports[$gpsEvent->gps_utc_time->toDateString()] = GeneralReport::create();
                    $generalReports[$gpsEvent->gps_utc_time->toDateString()]->addGpsEvent($generalReports[$gpsEvent->gps_utc_time->toDateString()], $gpsEvent);
                }
            }

            // dd($generalReports);
            // Filter general Reports, if there is no trip for the time period
            foreach ($dbTrips as $key => $dbTrip)
            {
                if (isset($generalReports[$dbTrip->start_time->toDateString()])) {
                    $temp[$dbTrip->start_time->toDateString()] = $generalReports[$dbTrip->start_time->toDateString()];
                }
            }
            $generalReports = $temp;

            // Iterate
            $generalReports = Report::fillMissingReports($from, $to, $generalReports);
            $generalReports = Report::fillInfo($trackedObject, $generalReports);

            // dd($generalReports, 'genRepo');
            return $generalReports;
        } else {
            // dd('dont hava gen rep');
            return Report::fillMissingReports($from, $to, $generalReports);
        }
    }

    public static function generalTrips($dbTrips, $gpsEvents)
    {
        $trips = [];

        if (count($dbTrips) > 0 || count($gpsEvents) > 1) {

            foreach ($gpsEvents as $eventKey => $gpsEvent)
            {
                foreach ($dbTrips as $tripKey => $dbTrip)
                {
                    if ($dbTrip->end_time != null && $gpsEvent->gps_utc_time->between($dbTrip->start_time, $dbTrip->end_time)) {
                        if (isset($trips[$dbTrip->id]))
                        {
                            $trips[$dbTrip->id]->addGpsPoint(Report::createGpsPoint($gpsEvent));
                        }
                        else
                        {
                            $trips[$dbTrip->id] = Trip::create($dbTrip);
                            $trips[$dbTrip->id]->addGpsPoint(Report::createGpsPoint($gpsEvent));
                        }
                    }
                }
            }

            foreach ($trips as $trip) {
                $trip->setInfo($trip, 'general');
            }
            // dd($trips);

            return $trips;
        } else {
            return null;
        }
    }

    public static function fillInfo($trackedObject, $generalReports)
    {

        foreach ($generalReports as $key => $generalReport) {
            if (!is_null($generalReport)) {
                // dd($generalReports, $trackedObject, 'fillInfo');
                $generalReport->setInfo($trackedObject);
            }
        }

        return $generalReports;
    }

    public static function fillMissingReports($date_time_from, $date_time_to, $generalReports)
    {
        $start = Carbon::createFromFormat('Y-m-d', mb_substr($date_time_from, 0, 10));
        $end   = Carbon::createFromFormat('Y-m-d', mb_substr($date_time_to, 0, 10));

        // For each day / If there are days without events
        while ($start->lte($end)) {
            if (isset($generalReports[$start->copy()->format('Y-m-d')])) {
                if (/*count($generalReports[$start->copy()->format('Y-m-d')]->getTrips()) == 0 ||*/ count($generalReports[$start->copy()->format('Y-m-d')]->getGpsPoints()) == 0) {
                    $generalReports[$start->copy()->format('Y-m-d')] = null;
                }
            } else {
                $generalReports[$start->copy()->format('Y-m-d')] = null;
            }
            $start->addDay();
        }

        ksort($generalReports);
        return $generalReports;
    }

    public static function tripReports($trackedObject, $dbTrips, $gpsEvents, $time)
    {
        $tripReports = [];

        if (count($dbTrips) > 0 || count($gpsEvents) > 1) {
            // dd('hava trip rep', $dbTrips, $trackedObject);

            $trips     = [];
            $gpsPoints = [];

//            foreach ($gpsEvents as $key => $gpsEvent) {
//                foreach ($dbTrips as $tripKey => $dbTrip) {
//                    if ($gpsEvent->gps_utc_time->between($dbTrip->start_time, $dbTrip->end_time)) {
//
//                        if (Report::isInTime($dbTrip, $gpsEvent, $time)) {
//
//                            $gpsPoint    = Report::isInTime($dbTrip, $gpsEvent, $time);
//                            $gpsPoints[] = $gpsPoint;
//
//                            if (isset($trips[$dbTrip->id])) {
//                                $trips[$dbTrip->id]->addGpsPoint($gpsPoint);
//                            } else {
//                                $trips[$dbTrip->id] = Trip::create($dbTrip);
//                                $trips[$dbTrip->id]->addGpsPoint($gpsPoint);
//                            }
//                        }
//                    }
//                }
//            }

            foreach ($trips as $trip) {
                $trip->setInfo($trip, 'trips');
                // dd($trip);
            }

            $tripReport = Report::createTripReport($trackedObject, $trips, $gpsPoints);

            return $tripReport;
        } else {
            // dd('dont hava trip rep', $tripReports);
            return null;
            // return Report::fillMissingReports($from, $to, $generalReports);
        }
    }

    public static function isInTime($dbTrip, $gpsEvent, $time)
    {

        // check time
        $fromTs = Carbon::parse(Carbon::parse($gpsEvent->gps_utc_time->toDateString()))
            ->addHours((int) explode(":", $time['startTime'])[0])
            ->addMinutes((int) explode(":", $time['startTime'])[1]);

        $toTs = Carbon::parse(Carbon::parse($gpsEvent->gps_utc_time->toDateString()))
            ->addHours((int) explode(":", $time['endTime'])[0])
            ->addMinutes((int) explode(":", $time['endTime'])[1]);

        // dd($gpsEvent->gps_utc_time, $gpsEvent->gps_utc_time->gte($fromTs), $fromTs);

        if ($gpsEvent->gps_utc_time->between($fromTs, $toTs)) {

            if (Report::isDayOfWeek($time['days'], $gpsEvent)) {

                return Report::createGpsPoint($gpsEvent);
            }
        }
        return null;
        // dd($gpsEvents, $gpsPoints);
        // return $gpsPoints;

    }

    public static function isDayOfWeek($days, $gpsEvent)
    {
        foreach ($days as $key => $day) {
            switch ($day) {
                case 1:
                    if ($gpsEvent->gps_utc_time->dayOfWeek === Carbon::MONDAY) {
                        return true;
                    }
                case 2:
                    if ($gpsEvent->gps_utc_time->dayOfWeek === Carbon::TUESDAY) {
                        return true;
                    }
                case 3:
                    if ($gpsEvent->gps_utc_time->dayOfWeek === Carbon::WEDNESDAY) {
                        return true;
                    }
                case 4:
                    if ($gpsEvent->gps_utc_time->dayOfWeek === Carbon::THURSDAY) {
                        return true;
                    }
                case 5:
                    if ($gpsEvent->gps_utc_time->dayOfWeek === Carbon::FRIDAY) {
                        return true;
                    }
                case 6:
                    if ($gpsEvent->gps_utc_time->dayOfWeek === Carbon::SATURDAY) {
                        return true;
                    }
                case 7:
                    if ($gpsEvent->gps_utc_time->dayOfWeek === Carbon::SUNDAY) {
                        return true;
                    }
                default:
                    return false;
                    break;
            }
        }
    }

    public static function createTripReport($trackedObject, $trips, $gpsPoints)
    {
        // dd($trackedObject, $trips, $gpsPoints);
        $firstPoint = reset($gpsPoints);
        $lastPoint  = end($gpsPoints);

        $tripReport = TripReport::createWith(
            $trackedObject->first()->trackedObject->brand->translation[0]->name . " " . $trackedObject->first()->trackedObject->model->translation[0]->name,
            $trackedObject->first()->identification_number,
            $trips,
            (count($gpsPoints) > 1) ? Report::getTotalDistance($firstPoint, $lastPoint) : null,
            $gpsPoints,
            $firstPoint,
            $lastPoint
        );

        // dd($tripReport);
        return $tripReport;
    }

    public static function dbTripsToTrips($dbTrips, $gpsPoints)
    {
        $trips = [];
        foreach ($gpsPoints as $key => $gpsPoint) {
            // dd($dbTrips, 'dbTripsToTrips');
            foreach ($dbTrips as $tripKey => $dbTrip) {
                if ($gpsPoint->getGpsUtcTime()->between($dbTrip->start_time, $dbTrip->end_time)) {
                    if (isset($trips[$dbTrip->id])) {
                        $trips[$dbTrip->id]->addGpsPoint($trips[$dbTrip->id], $gpsPoint);
                    } else {
                        $trips[$dbTrip->id] = Trip::create($dbTrip);
                        $trips[$dbTrip->id]->addGpsPoint($trips[$dbTrip->id], $gpsPoint);
                    }
                }
            }
        }

        foreach ($trips as $trip) {
            $trip->setInfo($trip, 'trips');
        }

        // dd($trips);
        return $trips;
    }

    public static function getIgnOnTime($firstPoint, $lastPoint)
    {
        return $lastPoint->getCurrentWorkHours() - $firstPoint->getCurrentWorkHours();
    }

    public static function getMoveTime($gpsPoints)
    {
        $oneMoveTime  = [];
        $moveTime = 0;

        // dd($gpsPoints);
        foreach ($gpsPoints as $key => $gpsPoint)
        {
            // Get Move Time
            if ($gpsPoint->getGpsSpeed() > 1) {
            // if ($gpsPoint->getDeviceStatus() == "ignition_on_motion") {
                $oneMoveTime[] = $gpsPoint;
            } else {
                if (!empty($oneMoveTime)) {
                    $moveTime  += end($oneMoveTime)->getCurrentWorkHours() - reset($oneMoveTime)->getCurrentWorkHours();
                }
                $oneMoveTime    = [];
            }

        }
        // dd($moveTime);
        return $moveTime;
    }

    public static function getMaxSpeedMoveTimeFirstLastMove($gpsPoints)
    {
        $oneMoveTime  = [];
        $moveTime = 0;
        $maxSpeed = 0;
        $firstMove = null;
        $lastMove = null;
        // dd($gpsPoints);
        foreach ($gpsPoints as $key => $gpsPoint)
        {
            // Get Move Time
            if ($gpsPoint->getGpsSpeed() > 1) {
            // if ($gpsPoint->getDeviceStatus() == "ignition_on_motion") {
                $oneMoveTime[] = $gpsPoint;
            } else {
                if (!empty($oneMoveTime)) {
                    $moveTime  += end($oneMoveTime)->getCurrentWorkHours() - reset($oneMoveTime)->getCurrentWorkHours();
                }
                $oneMoveTime    = [];
            }

            // Get MaxSpeed
            if ($gpsPoint instanceof GpsEvent) {
                if ($gpsPoint->speed > $maxSpeed) {
                    $maxSpeed = $gpsPoint->speed;
                }
            } else {
                if ($gpsPoint->getGpsSpeed() > $maxSpeed) {
                    $maxSpeed = $gpsPoint->getGpsSpeed();
                }
            }

            // Get first last move
            if($gpsPoint->getDeviceStatus() == 'ignition_on_rest' || $gpsPoint->getDeviceStatus() == 'ignition_on_motion'){
                if($firstMove == null)
                {
                    $firstMove = $gpsPoint;
                }
                $lastMove = $gpsPoint;
            }
        }
        // dd($firstMove, $lastMove, $gpsPoints);

        // dd(['moveTime' => $moveTime, 'maxSpeed' => $maxSpeed, 'firstMove' => $firstMove, 'lastMove' => $lastMove]);
        return ['moveTime' => $moveTime, 'maxSpeed' => $maxSpeed, 'firstMove' => $firstMove, 'lastMove' => $lastMove];
    }

    public static function createTrip($dbTrip, $gpsPoints)
    {
        // dd($dbTrip, $gpsPoints);

        if (count($gpsPoints) > 1) {

            $firstPoint = reset($gpsPoints);
            $firstPoint->setAddress(Report::reverseGeocode($firstPoint->getGpsLat(), $firstPoint->getGpsLng()));
            $lastPoint = end($gpsPoints);
            // dd($lastPoint);
            $lastPoint->setAddress(Report::reverseGeocode($lastPoint->getGpsLat(), $lastPoint->getGpsLng()));

            return Trip::createWith(
                $firstPoint->getGpsUtcTime(),
                $lastPoint->getGpsUtcTime(),
                $firstPoint,
                $lastPoint,
                Report::getTotalDistance($firstPoint, $lastPoint),
                Report::getTravelTime($firstPoint, $lastPoint),
                ($dbTrip->driver) ? $dbTrip->driver->translation->first()->first_name . " " . $dbTrip->driver->translation->first()->last_name : "-",
                $gpsPoints
            );
        }

        // 'startTime'
        // 'endTime'
        // 'startLocation'
        // 'endLocation'
        // 'totalDistance'
        // 'travelTime'
        // 'driver'
        // 'gpsPoints'
    }

    public static function createGpsPoint($event)
    {
        return new GpsPoint(
            $event->device_id,
            $event->latitude,
            $event->longitude,
            $event->speed,
            $event->azimuth,
            $event->gps_utc_time,
            $event->device_status,
            $event->mileage,
            $event->current_work_hours,
            null //Report::reverseGeocode($event->latitude, $event->longitude)
        );
    }

    public static function lastIgnition($gpsPoints)
    {
        $lastIgnited;
        foreach ($gpsPoints as $key => $gpsPoint) {
            if ($gpsPoint->getIsIgnited() == 1) {
                $lastIgnited = $gpsPoint->getGpsUtcTime();
            }
        }
        return $lastIgnited;
    }

    public static function reverseGeocode($latitude, $longitude)
    {
        $curl     = new \Ivory\HttpAdapter\CurlHttpAdapter();
        $geocoder = new \Geocoder\Provider\Nominatim($curl, 'http://nominatim.openstreetmap.org', App::getLocale());
        // $geocoder = new \Geocoder\Provider\GoogleMaps($curl, 'bg_BG');
        // $geocoder = new \Geocoder\Provider\BingMaps($curl, 'AlmyAsJ5X2XvZ2b5u-oNsj-WV5z7f1oEY7VN3VoRwik47MhhdWDDxd54b10soPqF');
        $address = $geocoder->reverse(floatval($latitude), floatval($longitude))->first();

        $rezult = $address->getCountry()->getName() . ", " .
        $address->getLocality() . ", " .
        $address->getStreetName() . ", " .
        $address->getPostalCode();

        // dd($rezult, $latitude, $longitude);
        return $rezult;
    }

    public static function dailyMaxSpeed($gpsPoints)
    {

        $maxSpeed = 0;
        // dd($gpsPoints);
        foreach ($gpsPoints as $key => $gpsPoint) {

            if ($gpsPoint instanceof GpsEvent) {
                if ($gpsPoint->speed > $maxSpeed) {
                    $maxSpeed = $gpsPoint->speed;
                }
            } else {
                if ($gpsPoint->getGpsSpeed() > $maxSpeed) {
                    $maxSpeed = $gpsPoint->getGpsSpeed();
                }
            }
        }
        return $maxSpeed;
    }

    public static function countStops($gpsPoints)
    {
        $stops    = 0;
        $previous = 0;
        foreach ($gpsPoints as $key => $point) {
            if ($point->getIsParked() == 1) {
                if ($previous != 1) {
                    $stops++;
                }

            }
            $previous = $point->getIsParked();
        }
        // dd($stops);
        return $stops;
    }

    public static function getGpsPointsForTrip($dbTrip, $gpsEvents)
    {
        $gpsPoints = [];
        foreach ($gpsEvents as $key => $gpsEvent) {
            if ($gpsEvent->gps_utc_time->gte($dbTrip->start_time) && $gpsEvent->gps_utc_time->lte($dbTrip->end_time)) {
                $gpsPoints[] = Report::createGpsPoint($gpsEvent);
            }

        }
        return $gpsPoints;
    }

    public static function getAllGpsPointsForGeneralReport($dbTrip, $gpsEvents)
    {
        $gpsPoints = [];
        foreach ($gpsEvents as $key => $gpsEvent) {
            if (Carbon::parse($gpsEvent->gps_utc_time->toDateString())->eq(Carbon::parse($dbTrip->start_time->toDateString()))) {
                $gpsPoints[] = Report::createGpsPoint($gpsEvent);
            }

        }
        return $gpsPoints;
    }

    public static function getTotalDistance($firstPoint, $lastPoint)
    {
        // dd($firstPoint, $lastPoint);
        if ($firstPoint instanceof GpsEvent && $lastPoint instanceof GpsEvent) {
            return ($lastPoint->mileage - $firstPoint->mileage);
        } else {
            // dd($firstPoint, $lastPoint);
            return ($lastPoint->getMileage() - $firstPoint->getMileage());
        }

    }

    public static function getTravelTime($firstPoint, $lastPoint)
    {
        // dd($lastPoint->getGpsUtcTime()->diffInSeconds($firstPoint->getGpsUtcTime()));
        return $lastPoint->getGpsUtcTime()->diffInSeconds($firstPoint->getGpsUtcTime());
    }

    public static function parseDeviceStatus($deviceStatus, $status)
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

        if (strcmp($status, 'isIgnited') == 0) {

            switch ($deviceStatus)
            {
                case 'tow':
                    return 0;
                case 'fake_tow':
                    return 0;
                case 'ignition_off_rest':
                    return 0;
                case 'ignition_off_motion':
                    return 0;
                case 'ignition_on_rest':
                    return 1;
                case 'ignition_on_motion':
                    return 1;
                case 'sensor_rest':
                    return 0;
                case 'sensor_motion':
                    return 0;
                default:
                    return 0;
            }
        } elseif (strcmp($status, 'isParked') == 0) {
            switch ($deviceStatus)
            {
                case 'tow':
                    return 0;
                case 'fake_tow':
                    return 0;
                case 'ignition_off_rest':
                    return 1;
                case 'ignition_off_motion':
                    return 0;
                case 'ignition_on_rest':
                    return 1;
                case 'ignition_on_motion':
                    return 0;
                case 'sensor_rest':
                    return 1;
                case 'sensor_motion':
                    return 0;
                default:
                    return 0;
            }
        } elseif (strcmp($status, 'isTowed') == 0) {
            switch ($deviceStatus)
            {
                case 'tow':
                    return 1;
                case 'fake_tow':
                    return 1;
                case 'ignition_off_rest':
                    return 0;
                case 'ignition_off_motion':
                    return 0;
                case 'ignition_on_rest':
                    return 0;
                case 'ignition_on_motion':
                    return 0;
                case 'sensor_rest':
                    return 0;
                case 'sensor_motion':
                    return 1;
                default:
                    return 0;
            }
        }
    }

    public static function getStatusCounts($gpsEvents)
    {
        $tow               = 0;
        $fakeTow           = 0;
        $ignitionOffRest   = 0;
        $ignitionOffMotion = 0;
        $ignitionOnRest    = 0;
        $ignitionOnMotion  = 0;
        $sensorRest        = 0;
        $sensorMotion      = 0;

        foreach ($gpsEvents as $gpsEvent) {
            switch ($gpsEvent->device_status) {
                case 'tow':
                    $tow++;
                    break;
                case 'fake_tow':
                    $fakeTow++;
                    break;
                case 'ignition_off_rest':
                    $ignitionOffRest++;
                    break;
                case 'ignition_off_motion':
                    $ignitionOffMotion++;
                    break;
                case 'ignition_on_rest':
                    $ignitionOnRest++;
                    break;
                case 'ignition_on_motion':
                    $ignitionOnMotion++;
                    break;
                case 'sensor_rest':
                    $sensorRest++;
                    break;
                case 'sensor_motion':
                    $sensorMotion++;
                    break;
                default:
                    break;
            }
        }

        return [
            trans('trackedObjects.tow')                 => $tow,
            trans('trackedObjects.fake_tow')            => $fakeTow,
            trans('trackedObjects.ignition_off_rest')   => $ignitionOffRest,
            trans('trackedObjects.ignition_off_motion') => $ignitionOffMotion,
            trans('trackedObjects.ignition_on_rest')    => $ignitionOnRest,
            trans('trackedObjects.ignition_on_motion')  => $ignitionOnMotion,
            trans('trackedObjects.sensor_rest')         => $sensorRest,
            trans('trackedObjects.sensor_motion')       => $sensorMotion,
        ];
    }
}
