<?php

namespace App\Repositories;

use App\Modules\Pois\Repositories\PoiInterface;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Models\Poi;
use App\PoiHistory;
use App\PoiPoint;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PoiRepository extends EloquentRepository
{
    protected $model;

    public function __construct(Poi $poi)
    {
        $this->model = $poi;
    }

    public function getAllPoisInJson()
    {
        return $this->model->with('poiPoints', 'translation')->get()->toJson();
    }

    public function getAllPois()
    {
        return $this->model->with('poiPoints', 'translation')->get();
    }

    public function getPoi($id)
    {
        return $this->model->where('id', $id)->with('translation');
    }

    /**
     * Create POI
     *
     * @param $request
     * @return static
     */
    public function createNewPoi($request)
    {
        $coordinates = json_decode($request->coordinates, true);
        // dd($request->icon);

        $data = [
            'poi_type' => $coordinates["poi_shape"],
            'icon' => $request->icon,
            'radius' => $coordinates["radius"]
        ];

        # Create poi
        $poi = $this->model->create($data);

        # Add new poi point
        $this->createPoiPoint($poi->id, $coordinates);

        return $poi;
    }

    /**
     * Update POI
     *
     * @param $request
     * @param $id
     * @return static
     */
    public function updatePoi($request, $id)
    {
        $coordinates = json_decode($request->coordinates, true);
        // dd($request->icon);

        $data = [
            'poi_type' => $coordinates["poi_shape"],
            'icon' => $request->icon,
            'radius' => $coordinates["radius"]
        ];

        $poi = $this->model->find($id);

        # Remove all points for the current poi
        PoiPoint::where('poi_id', $id)->delete();

        # Update poi
        $poi->update($data);

        # Add new poi point
        $this->createPoiPoint($poi->id, $coordinates);

        /**
        *  #old Update translations of the poi
         * no longer necessary, as the functionality is implemented in the eloquent repository
         * used from the controller, as it only makes sense to be a separate repo call
         */
        // foreach ($request->name as $langId => $value) {
        //     $poi_tans = PoiI18n::where('poi_id', $poi->id)->where('language_id', $langId);
        //     $poi_tans->update(['name' => $value]);
        // }

        return $poi;
    }

    /**
     * Create Poi point/s
     *
     * @param $poi_id
     * @param $request
     */
    public function createPoiPoint($poi_id, $coordinates)
    {
        // dd($coordinates['poi_points'][0]['latitude']);
        if ($coordinates['poi_shape'] == 'marker' || $coordinates['poi_shape'] == 'circle')
        {
            # Add new poi point
            PoiPoint::create(['poi_id' => $poi_id, 'latitude' => $coordinates['poi_points'][0]['latitude'], 'longitude' => $coordinates['poi_points'][0]['longitude']]);
        }
        else if (in_array($coordinates['poi_shape'], ['polygon', 'polyline', 'rectangle']))
        {
            # Add new poi points
            foreach ($coordinates['poi_points'] as $key => $coordinate) {
                PoiPoint::create([
                    'poi_id' => $poi_id,
                    'latitude' => $coordinate['latitude'],
                    'longitude' => $coordinate['longitude']
                ]);
            }
        }
    }

    /**
     * Get last 10 poi visited
     *
     */
    public function getLastVisited()
    {
        $lastEventsByStartTime = PoiHistory::orderBy('start_time', 'DESC')->limit(10)->lists('start_time', 'id')->toArray();
        $lastEventsByEndTime = PoiHistory::whereNotNull('end_time')->orderBy('end_time', 'DESC')->limit(10)->lists('end_time', 'id')->toArray();

        // Merge arrays
        $lastEvents = [];
        foreach ($lastEventsByStartTime AS $lastEventId => $lastEventTime) {
            $lastEvents[$lastEventTime->toDateTimeString()][] = $lastEventId;
        }

        foreach ($lastEventsByEndTime AS $lastEventId => $lastEventTime) {
            $lastEvents[$lastEventTime->toDateTimeString()][] = $lastEventId;
        }

        // Sort array desc by key reverse
        krsort($lastEvents);

        // Get only first ten records after sorting
        $lastEvents = array_slice($lastEvents, 0, 10, true);

        // Get only ids of the last events after sorting and limiting
        $lastEventsIds = [];
        foreach ($lastEvents AS $lastEventKey => $lastEvent) {
            foreach ($lastEvent AS $lastEventId) {
                $lastEventsIds[] = $lastEventId;
            }

            // Delete last element in the array, only if we have more than one events for earlier datetime
            $countLastEventsByDateTime = count($lastEvent);
            if ($countLastEventsByDateTime > 1) {
                for ($i = 1; $i < $countLastEventsByDateTime; $i ++) {
                    array_pop($lastEvents);
                }
            }
        }

        // Set empty array for value of the all keys
        $lastEvents = array_fill_keys(array_keys($lastEvents), []);

        // Only unique ids
        $lastEventsIds = array_unique($lastEventsIds);

        // Get more information about last events by their ids
        $results = DB::connection('slave')
                    ->table('poi_history')
                    ->select(DB::raw('`poi_history`.`start_time`,
                                        `poi_history`.`end_time`,
                                        `tracked_object_brands_i18n`.`name` AS `brand_name`,
                                        `tracked_object_models_i18n`.`name` AS `model_name`,
                                        `tracked_objects`.`identification_number`,
                                        `poi_i18n`.`name` AS `poi_name`'))
                    ->leftJoin('devices', 'devices.id', '=', 'poi_history.device_id')
                    ->leftJoin('tracked_objects', 'tracked_objects.id', '=', 'devices.tracked_object_id')
                    ->leftJoin('tracked_object_brands', 'tracked_object_brands.id', '=', 'tracked_objects.tracked_object_brand_id')
                    ->leftJoin('tracked_object_brands_i18n', 'tracked_object_brands_i18n.tracked_object_brand_id', '=', 'tracked_object_brands.id')
                    ->leftJoin('tracked_object_models', 'tracked_object_models.id', '=', 'tracked_objects.tracked_object_model_id')
                    ->leftJoin('tracked_object_models_i18n', 'tracked_object_models_i18n.tracked_object_model_id', '=', 'tracked_object_models.id')
                    ->leftJoin('poi', 'poi.id', '=', 'poi_history.poi_id')
                    ->leftJoin('poi_i18n', 'poi_i18n.poi_id', '=', 'poi.id')
                    ->leftJoin('poi_history AS ph2', 'ph2.poi_id', '=', 'poi.id')
                    ->where('poi_i18n.language_id', '=', Session::get('locale_id'))
                    ->where('tracked_object_brands_i18n.language_id', Session::get('locale_id'))
                    ->where('tracked_object_models_i18n.language_id', Session::get('locale_id'))
                    ->whereNull('devices.deleted_at')
                    ->whereIn('poi_history.id', $lastEventsIds)
                    ->groupBy('poi_history.id')
                    ->get();

        $results = DBNetfleet::getDecoratedDateResult($results);
        // Add information from database to the sorted dates. Make this action only if date is set in the lastEvents array.
        foreach ($results AS $result) {
            if (array_key_exists($result->start_time, $lastEvents)) {
                $lastEvents[$result->start_time][] = $result;
            }

            if (array_key_exists($result->end_time, $lastEvents)) {
                $lastEvents[$result->end_time][] = $result;
            }
        }

        return $lastEvents;
    }
}
