<?php

namespace App\Modules\TrackedObjects\Repositories\Eloquent;

use App\Models\TrackedObject;
use App\Modules\TrackedObjects\Repositories\TrackedObjectInterface;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use DB;
use Gate;
use Session;
use Carbon\Carbon;
use DBNetfleet;

class TrackedObjectRepository extends EloquentRepository implements TrackedObjectInterface
{

    protected $model;

    public function __construct(TrackedObject $trackedObject)
    {
        $this->model = $trackedObject;
    }

    public function withBrand()
    {
        return $this->model->with('brand');
    }

    public function withDevices()
    {
        return $this->model->with('devices', 'brand', 'model');
    }

    public function getTrackedObjectsLastData()
    {
        $select = 'gps_events.*, trips.id as trip_id, trips.start_time, trips.end_time, CONCAT(drivers_i18n.first_name, " ", drivers_i18n.last_name) as driver, CONCAT(tracked_object_brands_i18n.name, " ", tracked_object_models_i18n.name) as tracked_object_name, tracked_objects.identification_number as tracked_object_identification_number, tracked_objects.id AS tracked_object_id';

        $res = DB::table("devices")
            ->leftJoin('trips', function($join)
                {
                    $join->on('trips.id', '=', 'devices.last_trip_id');
                })
            ->leftJoin('gps_events', function($join)
                {
                    $join->on('gps_events.id', '=', 'devices.last_gps_event_id');
                })
            ->whereNull('devices.deleted_at')
            ->groupBy('devices.id');

        $res = $res->select(DB::raw($select))->get();

        return DBNetfleet::getDecoratedDateResult($res);
    }



    public function getTrackedObjectsBasedOnGroup($user)
    {
        $collection = collect([]);

        if (auth()->user()->can(getenv('ROLE_OWNER'))) {
            $collection = $this->withDevices()->get();
        } else {
            $user->groups->each(function ($group) use ( & $collection) {
                $collection->push($group->trackedObjects);
            });

            $collection = $collection->first();
        }

        return $collection->unique();
    }

    public function getUsersBasedOnTrackedObject($trackedObjectId) {

        $return = DB::connection("slave")
            ->table("groups_tracked_objects")
            ->select('groups_tracked_objects.tracked_object_id', 'users.id','groups.id as group_id' , 'users_i18n.first_name', 'users_i18n.last_name')
            ->leftJoin('groups', 'groups.id', '=', 'groups_tracked_objects.group_id')
            ->leftJoin('users_groups', 'users_groups.group_id', '=', 'groups.id')
            ->leftJoin('users', 'users.id', '=', 'users_groups.user_id')
            ->leftJoin('users_i18n', 'users_i18n.user_id', '=', 'users.id')
            ->where('groups_tracked_objects.tracked_object_id', '=', $trackedObjectId)
            ->whereNotNull('users.id')
            ->where(function($query) {
                return $query->where('users_i18n.language_id', Session::get('locale_id'))
                    ->orWhereNull('users_i18n.language_id');
            })
            ->groupBy('users.id')
            ->get();

        return $return;
    }


}

