<?php

namespace App\Modules\TrackedObjects\Repositories\Eloquent;

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

class DeviceRepository extends EloquentRepository implements DeviceInterface
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

    public function report($deviceId, $driverId = null, $interval, $workDays)
    {
        $now = new DateTime();

        $dateIntervals = $this->getDatesFromTripReportInterval($interval, $workDays);

        $this->getTripsByTripReportIntervals($deviceId, $dateIntervals, $workDays, $driverId);

        $this->getWhichTripsShouldBeSplit($this->trips, $dateIntervals);

        $gpsEvents = $this->getTripsGpsEvents($dateIntervals, $this->trips);

        if ($gpsEvents) {
            $gpsEvents = $this->groupGpsEventsByTripId($gpsEvents);
            $canBusEvents = $this->getCanBusEventsByDateIntervalsAndDeviceId($dateIntervals, $deviceId);
            $this->appendTripInformationToCanBusAndGpsEvents($gpsEvents, $canBusEvents, $this->tripsThatShouldBeSplit);
        }

        $this->orderSlicedAndOrdinaryTripsByGpsUtcTimeAscending();

        return $this->trips;
    }

    private function getWhichTripsShouldBeSplit($trips, $dateIntervals)
    {
        $firstDatePair = $dateIntervals[0];

        $this->tripsThatShouldBeSplit = collect([]);

        $workDayStart = new Carbon($firstDatePair['start']);
        $workDayEnd   = new Carbon($firstDatePair['end']);

        $workDayStart = $workDayStart->format('H:i:s');
        $workDayEnd   = $workDayEnd->format('H:i:s');

        foreach ($trips as $trip) {
            // $tripStartHour = $trip->start_time->format('H:i:s');
            // $tripEndHour   = isset($trip->end_time) ? $trip->end_time->format('H:i:s') : false;

            $endHour = isset($trip->end_time) ? $trip->end_time->format('Y-m-d H:i:s') : false;
            /**
             * convert the trip hour back to utc
             * we do this because the accessors 
             * get the date in user timezone
             */
            $tripStartHour = $this->timezoneHelper->converUserTimezoneDateToSystemDate($trip->start_time->format('Y-m-d H:i:s'))->format('H:i:s');
            $tripEndHour = $this->timezoneHelper->converUserTimezoneDateToSystemDate($endHour);

            $tripEndHour = $tripEndHour ? $tripEndHour->format('H:i:s') : false;

            if (
                (($tripStartHour < $workDayStart) && (($tripEndHour > $workDayStart) || ( ! $tripEndHour)) && (($tripEndHour < $workDayEnd) || ( ! $tripEndHour)))
                ||
                (($tripStartHour > $workDayStart) && ($tripStartHour < $workDayEnd) && (($tripEndHour > $workDayEnd) || ( ! $tripEndHour)))
                ||
                (($tripStartHour < $workDayStart) && (($tripEndHour > $workDayEnd) || ( ! $tripEndHour)))
            ) {
                $trip->shouldBeSplit = true;
                $this->tripsThatShouldBeSplit->push($trip);
            } else {
                $trip->shouldBeSplit = false;
            }
        }

        // dd($this->tripsThatShouldBeSplit);
    }


    private function getDatesFromTripReportInterval($interval, $workDays)
    {
        $dates = [];

        $firstDateStart = new Carbon($interval['firstDate']['start']);
        $firstDateEnd = new Carbon($interval['firstDate']['end']);

        $lastDateStart = new Carbon($interval['lastDate']['start']);
        $lastDateEnd = new Carbon($interval['lastDate']['end']);

        while ($firstDateEnd != $lastDateEnd) {
            /**
             * Compare the system timezone date with a converted user date
             * if the day of week matches with the desired days of week
             * add the date to the array of datetime start-end pairs
             */
            if ($this->timezoneHelper->matchSystemTimezoneDateDayOfWeekWithUserTimezoneWorkdays($firstDateEnd->toDateTimeString(), $workDays)) {
                $dates[] = [
                    'start' => $firstDateStart->toDateTimeString(),
                    'end'   => $firstDateEnd->toDateTimeString(),
                ];
            }

            $firstDateStart->addDay();
            $firstDateEnd->addDay();
        }

        $dates[] = [
            'start' => $interval['lastDate']['start'],
            'end'   => $interval['lastDate']['end'],
        ];
        
        $this->dateIntervals = $dates;

        return $dates;
    }

    private function getTripsByTripReportIntervals($deviceId, $dateIntervals, $workDays, $driverId)
    {
        // \DB::listen(function ($query) {
        //     echo "<pre>";
        //     print_r($query->sql);
        //     echo "<br>";
        //     print_r($query->bindings);
        // });
        $this->trips = Trip::where(function($query) use ($deviceId, $dateIntervals, $workDays, $driverId) {
            $query->where('device_id', $deviceId);

            $query->where(function ($query) use ($dateIntervals) {
                foreach ($dateIntervals as $dateInterval) {
                    // the newest new
                    $query->orWhereRaw(
                        "
                            (trips.start_time BETWEEN ? AND ?) /* start time, end time */
                            OR
                            (trips.end_time BETWEEN ? AND ?) /* start time, end time */
                            OR
                            (
                                (trips.start_time < ?) /* start time */
                                AND
                                (
                                    trips.end_time IS NULL
                                    OR
                                    trips.end_time > ? /* end time */
                                )
                            )

                        "
                    ,
                    [
                        $dateInterval['start'],
                        $dateInterval['end'],
                        $dateInterval['start'],
                        $dateInterval['end'],
                        $dateInterval['start'],
                        $dateInterval['end'],
                    ]);
                }
            });

            if ($driverId) {
                $query->where('driver_id', $driverId);
            }

            $query->orderBy('trips.start_time', 'ASC');

        })
        ->with(['translation', 'driver'])
        ->get();

        return $this->trips;
    }
    
    private function getTripsGpsEvents($dateIntervals, $trips)
    {
        $tripIds = [];

        foreach ($trips as $trip) {
            if ($trip->shouldBeSplit) {
                $tripIds[] = $trip->id;
                $this->trips = $this->trips->filter(function ($item) use ($trip) {
                    return $item->id !== $trip->id;
                });
            }
        }

        if ( ! empty($tripIds)) {
            $gpsEvents = SlaveGpsEvent::where(function ($query) use ($dateIntervals, $tripIds) {

                $query->whereIn('trip_id', $tripIds);

                $query->where(function ($query) use ($dateIntervals) {

                    foreach ($dateIntervals as $dateInterval) {

                        $query->orWhereRaw('gps_utc_time BETWEEN ? AND ?', [$dateInterval['start'], $dateInterval['end']]);
                    }

                });

                $query->groupBy('trip_id');
                $query->whereNotNull('trip_id');
            })->get();

            return $gpsEvents;
        }

        return false;

    }

    private function getCanBusEventsByDateIntervalsAndDeviceId($dateIntervals, $deviceId)
    {
        $canBusEvents = collect([]);
        
        $canBusEvents = CanBusEvent::select('total_distance', 'gps_utc_time')->where(function ($query) use ($dateIntervals, $deviceId) {
            $query->where('device_id', $deviceId);

            $query->where(function ($query) use ($dateIntervals) {

                foreach ($dateIntervals as $dateInterval) {

                    $query->orWhereRaw('gps_utc_time BETWEEN ? AND ?', [$dateInterval['start'], $dateInterval['end']]);
                }

            });
        })->get();

        return $canBusEvents;
    }

    private function groupGpsEventsByTripId($gpsEvents)
    {
        $gpsEvents = collect($gpsEvents);
        $gpsEvents = $gpsEvents->groupBy('trip_id');

        return $gpsEvents;
    }

    private function appendTripInformationToCanBusAndGpsEvents($groupedGpsEvents, $canBusEvents, $trips)
    {
        $tripData = [];

        // dd($this->trips, $this->tripsThatShouldBeSplit);

        foreach ($groupedGpsEvents as $tripId => $tripGpsEvents) {

            $tripGpsEvents = $tripGpsEvents->sortBy('gps_utc_time');

            $trip = $trips->where('id', $tripId)->first();

            if ( ! $canBusEvents->isEmpty()) {

                $tripCanBusEvents = $canBusEvents->filter(function ($canBusEvent, $key) use ($trip) {

                    return 
                    ($canBusEvent->gps_utc_time >= $trip->start_time) &&
                    (
                        ($canBusEvent->gps_utc_time <= $trip->end_time) || ( ! isset($trip->end_time))
                    );
                });

            } else {
                $tripCanBusEvents = collect([]);
            }
            $tripCanBusEvents->sortBy('gps_utc_time');


            $tripData[$tripId] = [
                'canBusEvents' => $tripCanBusEvents,
                'gpsEvents'    => $tripGpsEvents,
                'tripData'     => $trip,
            ];

            unset($tripCanBusEvents);
        }

        foreach ($this->trips as $trip) {
            $tripData[] = $trip;
        }

        $this->trips = collect($tripData);
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

    private function orderSlicedAndOrdinaryTripsByGpsUtcTimeAscending()
    {
        $sortedTrips = [];

        
        foreach ($this->trips as $tripId => $trip) {
            if (is_array($trip)) {

                if ( ! isset($trip['tripData']->end_time)) {
                    $sortedTrips[] = $this->trips->pull($tripId);
                } else {
                    $sortedTrips[$trip['tripData']->end_time->format('Y-m-d H:i:s')] = $this->trips->pull($tripId);
                }

            } else {

                if ( ! isset($trip->end_time)) {
                    $sortedTrips[] = $this->trips->pull($tripId);
                } else {
                    $sortedTrips[$trip->end_time->format('Y-m-d H:i:s')] = $this->trips->pull($tripId);
                }

            }
        }

        ksort($sortedTrips);

        $this->trips = collect($sortedTrips);
    }
}