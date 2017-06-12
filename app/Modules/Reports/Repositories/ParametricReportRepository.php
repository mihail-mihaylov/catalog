<?php
namespace App\Modules\Reports\Repositories;

use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Modules\Reports\Interfaces\ParametricReportInterface;
use Illuminate\Database\Query\Builder;
use DB;
use Session;
use DBNetfleet;

class ParametricReportRepository extends EloquentRepository implements ParametricReportInterface
{
    public function getParametricReport($inputId, $start, $end)
    {
        $inputsEvents = \DB::connection('slave')
            ->table('devices_inputs')
            ->leftJoin('devices_inputs_i18n', 'devices_inputs_i18n.device_input_id', '=', 'devices_inputs.id')
            ->leftJoin('input_types', 'input_types.id', '=', 'devices_inputs.input_type_id')
            ->leftJoin('input_measurement_units', 'input_measurement_units.id', '=', 'devices_inputs.input_measurement_unit_id')
            ->leftJoin('device_inputs_events', function($join) use ($start, $end){
                $join->on('device_inputs_events.device_input_id', '=', 'devices_inputs.id');
                $join->where("device_inputs_events.gps_utc_time", ">=", $start);
                $join->where("device_inputs_events.gps_utc_time", "<=", $end);
            })
            ->leftJoin('gps_events', 'gps_events.id', '=', 'device_inputs_events.gps_event_id')
            ->where('devices_inputs_i18n.language_id', \Session::get('locale_id'))
            ->where('devices_inputs.id', '=', $inputId)
            ->select('devices_inputs.order', 'devices_inputs.id as device_input_id','devices_inputs.minimum_input', 'devices_inputs.maximum_input','devices_inputs.minimum_output','devices_inputs.maximum_output','devices_inputs.identification_number','devices_inputs.reverse', 'device_inputs_events.input_event_value','device_inputs_events.id as device_input_event_id', 'device_inputs_events.gps_utc_time', 'devices_inputs_i18n.name', 'devices_inputs_i18n.digital_on', 'devices_inputs_i18n.digital_off', 'input_measurement_units.measurement_unit', 'input_types.type', 'gps_events.latitude', 'gps_events.longitude', 'gps_events.azimuth', 'gps_events.device_status')
            ->get();

        // dd($inputsEvents);
        return DBNetfleet::getDecoratedDateResult($inputsEvents);
    }
}
