<?php
namespace App\Modules\Reports\Repositories;

use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Modules\Reports\Interfaces\FuelReportInterface;
use App\Modules\Reports\Models\CanBusEvent;
use DB;
use Gate;
use Session;
use DBNetfleet;

class FuelReportRepository extends EloquentRepository implements FuelReportInterface
{

    public function getFuelCanBusDataByDevice($from, $to, $devices)
    {
        $fields = [
            'can_bus_events.id',
            'devices.id as device_id',
            'can_bus_events.gps_utc_time',
            'gps_events.latitude',
            'gps_events.longitude',
            'gps_events.azimuth',
            'gps_events.device_status',
            'can_bus_events.total_distance',
            'can_bus_events.total_fuel_used',
            'tracked_object_brands_i18n.name as tracked_object_brand',
            'tracked_object_models_i18n.name as tracked_object_model',
            'tracked_objects.identification_number as tracked_object_id'
        ];

        $data = DB::connection('slave')
            ->table("tracked_objects")
            ->select($fields)
            ->leftJoin('tracked_object_brands', 'tracked_object_brands.id', '=', 'tracked_objects.tracked_object_brand_id')
            ->leftJoin('tracked_object_brands_i18n', 'tracked_object_brands_i18n.tracked_object_brand_id', '=', 'tracked_object_brands.id')
            ->leftJoin('tracked_object_models', 'tracked_object_models.id', '=', 'tracked_objects.tracked_object_model_id')
            ->leftJoin('tracked_object_models_i18n', 'tracked_object_models_i18n.tracked_object_model_id', '=', 'tracked_object_models.id')
            ->leftJoin('devices', 'devices.tracked_object_id', '=', 'tracked_objects.id')
            ->leftJoin('can_bus_events', 'can_bus_events.device_id',  '=', 'devices.id')
            ->leftJoin('gps_events', 'gps_events.id', '=', 'can_bus_events.gps_event_id')

            ->whereNotNull('can_bus_events.device_id')
            ->where('tracked_object_brands_i18n.language_id', Session::get('locale_id'))
            ->where('tracked_object_models_i18n.language_id', Session::get('locale_id'))
            ->where('can_bus_events.gps_utc_time', '>=', $from)
            ->where('can_bus_events.gps_utc_time', '<=', $to)

            ->whereIn('can_bus_events.device_id', $devices)
            ->groupBy('can_bus_events.id')
            ->orderBy('can_bus_events.gps_utc_time', 'ASC')
            ->get();

        $data = $this->transform($data);

        return $data;
    }

    private function transform($reportItems)
    {
        $data = [];
        foreach ($reportItems as $item) {
            # Hectometers to Kilometers
            if (isset($item->total_distance)) {
                $item->total_distance *= 0.1;
            }

            if (isset($item->total_fuel_used)) {
                if( ! isset($data[$item->device_id]['first_value_total_fuel_used'])) {
                    $data[$item->device_id]['first_value_total_fuel_used'] = $item;
                }

                $data[$item->device_id]['last_value_total_fuel_used'] = $item;
            }

            if (isset($item->total_distance)) {

                if( ! isset($data[$item->device_id]['first_total_distance'])) {
                    $data[$item->device_id]['first_total_distance'] = $item;
                }

                $data[$item->device_id]['last_total_distance'] = $item;
            }

            $data[$item->device_id]['events'][] = $item;
            if ( ! isset($data[$item->device_id]['tracked_object_name'])) {

                $data[$item->device_id]['tracked_object_name'] = $item->tracked_object_brand.' '.$item->tracked_object_model;
            }
            if ( ! isset($data[$item->device_id]['tracked_object_id'])) {

                $data[$item->device_id]['tracked_object_id'] = $item->tracked_object_id;
            }
        }

        foreach ($data as $device => $obj) {
            # Used fuel
            $data[$device]['used_fuel'] = $obj['last_value_total_fuel_used']->total_fuel_used - $obj['first_value_total_fuel_used']->total_fuel_used;

            # Total distance
            $data[$device]['distance'] = $obj['last_total_distance']->total_distance - $obj['first_total_distance']->total_distance;

            # Average expense
            if($data[$device]['distance'] > 0) {

                $data[$device]['avg_expense'] = round($data[$device]['used_fuel'] / ($data[$device]['distance'] / 100),2);
            } else {
                $data[$device]['avg_expense'] = trans('general.no_data');
            }
        }

        return $data;
    }
}
