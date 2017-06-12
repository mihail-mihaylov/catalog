<?php

/**
 * Description of SlaveTripRepository
 *
 * @author mmihaylov
 */
namespace App\Modules\Reports\Repositories\Eloquent;

use App\Http\Repositories\Eloquent\SlaveGpsEventRepository;
use App\Modules\Drivers\Repositories\SlaveDriverInterface;
use App\Modules\Reports\Repositories\SlaveTripInterface;
// use App\Trip as Trip;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Trip as DbTrip;
use DB;
use Carbon\Carbon;
use Session;
use Netfleet\DB\DBNetfleet;

class TripRepository extends EloquentRepository implements SlaveTripInterface
{
    protected $model;
    protected $dbGpsEvents;
    protected $dbDrivers;

    public function __construct(DbTrip $dbTrip, SlaveGpsEventRepository $dbGpsEvents, SlaveDriverInterface $dbDrivers)
    {
        $this->model       = $dbTrip;
        $this->dbGpsEvents = $dbGpsEvents;
        $this->dbDrivers   = $dbDrivers;
    }

    public function getTripsFromTo($deviceId, $from, $to)
    {
        return $this->model
            ->with('driver')
            ->where("device_id", $deviceId)
            ->whereDate("start_time", ">=", $from)
            ->whereDate("start_time", "<=", $to)
            ->get();
    }

    public function getTripsFrom($deviceId, $from)
    {
        // dd($requestedDate);
        $dbTrips = $this->model
            ->with('driver')
            ->where("device_id", $deviceId)
            ->whereDate("start_time", '=', $from)
            ->orderBy("start_time")
            ->get();

        // dd($dbTrips);
        return $dbTrips;
    }

    public function getLastTrip($deviceId)
    {
        $trip = $this->model
            ->with('driver')
            ->where("device_id", $deviceId)
            ->orderBy('start_time', 'desc')
            ->first();

        // dd($trip);
        // if (!$trip->isEmpty()) {
        //     return $trip->first();
        // } else {
            return $trip;
        // }
    }

    public function getTripsForGeneralReport($deviceId, $start, $end)
    {
        return $this->model
            ->where('device_id', $deviceId)
            ->with([
                'translation',
                'gpsEvents' => function($query) use ($start, $end)
                    {
                        $query->where("gps_utc_time", ">=", $start);
                        $query->orderBy("gps_utc_time");
                    }
            ])
            ->where("start_time", ">=", $start)
            ->where("start_time", "<=", $end)
            ->orderBy('start_time')
            ->get();
    }

    public function getGeneralReport($deviceId, $from, $to)
    {
        $sql = DB::table('trips')
                ->select('trips.id', 'trips.start_time', 'trips.end_time', 'trips.distance', 'trips.max_speed', 'trips.work_hours', 'gps_events.device_status', 'gps_events.gps_utc_time', 'trips_i18n.start_address', 'trips_i18n.end_address', 'gps_events.current_work_hours', 'trips.distance_can')
                ->join('gps_events', 'gps_events.trip_id', '=', 'trips.id')
                ->leftJoin('trips_i18n', function($join) {
                    $join->on('trips_i18n.trip_id', '=', 'trips.id');
                    $join->where('language_id', '=', Session::get('locale_id'));
                })
                ->where("trips.start_time", ">=", $from)
                ->where("trips.start_time", "<=", $to)
                ->where("gps_events.gps_utc_time", ">=", $from)
                ->where("gps_events.gps_utc_time", "<=", $to)
                ->orderBy('trips.start_time')
                ->orderBy('gps_events.id');

        if ($deviceId) {
            $sql->where('trips.device_id', $deviceId);
        }

        $results = $sql->get();

        $return = [];
        $temp_vars = [];
        foreach ($results as $result) {
            $date = Carbon::parse($result->start_time)->format('d.m.Y');

            # Start time
            if ( ! isset($return[$date]['start_time'])) {
                $return[$date]['start_time'] = $result->start_time;
            }
            # End time
            $return[$date]['end_time'] = $result->end_time;
            # Max speed
            if ( ! isset($return[$date]['max_speed']) || $return[$date]['max_speed'] < $result->max_speed) {
                $return[$date]['max_speed'] = $result->max_speed;
            }

            if ( ! isset($temp_vars['trip_id']) || $temp_vars['trip_id'] != $result->id) {
                # Total distance
                isset($return[$date]['total_distance']) ?
                $return[$date]['total_distance'] += $result->distance :
                $return[$date]['total_distance'] = $result->distance;

                # Total distance can
                isset($return[$date]['total_distance_can']) ?
                    $return[$date]['total_distance_can'] += $result->distance_can :
                    $return[$date]['total_distance_can'] = $result->distance_can;

                # Work hours
                isset($return[$date]['work_hours']) ?
                $return[$date]['work_hours'] += $result->work_hours :
                $return[$date]['work_hours'] = $result->work_hours;
            }
            if ($result->device_status == 'ignition_on_motion') {
                # First move time
                if ( ! isset($return[$date]['first_move']['time'])) {
                    $return[$date]['first_move']['time'] = $result->gps_utc_time;
                }
                # Last move time
                $return[$date]['last_move']['time'] = $result->gps_utc_time;

                $temp_vars['one_move_time'][] = $result->current_work_hours;
            } elseif (isset($temp_vars['one_move_time'])) {
                isset($return[$date]['move_time']) ?
                $return[$date]['move_time'] += end($temp_vars['one_move_time']) - reset($temp_vars['one_move_time']) :
                $return[$date]['move_time'] = end($temp_vars['one_move_time']) - reset($temp_vars['one_move_time']);
                # Reset temp variable - one_move_time
                $temp_vars['one_move_time'] = [];
            }

            if( ! isset($return[$date]['first_move']['time'])) {
                $return[$date]['first_move']['time'] = null;
            }

            if( ! isset($return[$date]['last_move']['time']))
            {
                $return[$date]['last_move']['time'] = null;
            }


            # First move address
            if ( ! isset($return[$date]['first_move']['address'])) {
                $return[$date]['first_move']['address'] = $result->start_address;
            }
            # Last move address
            $return[$date]['last_move']['address'] = $result->end_address;

            # Temp variables
            $temp_vars['trip_id'] = $result->id;
        }

        return $return;
    }
}

