<?php
namespace App\Modules\Reports\Repositories;

use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Modules\Reports\Interfaces\CanBusReportInterface;
use Illuminate\Database\Query\Builder;
use App\Modules\Reports\Models\CanBusEvent;
use App\Modules\Reports\Models\CanBusEventReportGraphMutator;
use DB;
use DBNetfleet;

class CanBusReportRepository extends EloquentRepository implements CanBusReportInterface
{

    public function __construct(CanBusEvent $model)
    {
        $this->model = $model;
    }

    protected $unsetParameters = [
        'id',
         'created_at',
         'updated_at',
         'deleted_at',
         'gps_event_id',
         'gps_utc_time',
         'vehicle_identification_number',
         'tachograph_driver_two_reserved',
         'tachograph_driver_one_reserved',
         'doors_reserved_one',
         'doors_reserved_two',
         'device_id',
     ];

    public function getCanBusReportParameters()
    {
        $columns = $this->getCanBusEventsColumnNames();

        $untranslatedParameters = $this->removeUnneededCanBusEventsTableColumns($columns);

        $translatedParameters = $this->translateCanBusColumnsIntoParameterNames($untranslatedParameters);

        return $translatedParameters;
    }

    private function removeUnneededCanBusEventsTableColumns($columns)
    {
        foreach ($columns as $key => $column) {
            if (in_array($column, $this->unsetParameters)) {
                unset($columns[$key]);
            }
        }

        return $columns;
    }

    private function translateCanBusColumnsIntoParameterNames($untranslatedParameters)
    {
        $translatedParameters = [];

        foreach ($untranslatedParameters as $integer => $name) {
            $translatedParameters[$name] = [];
            $translatedParameters[$name]['name'] = trans('reports.canbus.' . $name . '.value');
            $translatedParameters[$name]['unit'] = trans('reports.canbus.' . $name . '.units');
            $translatedParameters[$name]['measurement_unit'] = trans('reports.canbus.' . $name . '.measurement_unit');
        }

        return $translatedParameters;
    }

    private function getCanBusEventsColumnNames()
    {
        return \DB::connection('slave')->getSchemaBuilder()->getColumnListing("can_bus_events");
    }

    public function prepareReport($trackedObject, $parameters, $from, $to)
    {
        $beginQuery = $this->getCanBusDataByTrackedObject($trackedObject);
        $parameteredQuery = $this->extendCanBusReportByParameters($beginQuery, $parameters);
        $datedQuery = $this->extendCanBusReportByTimespan($parameteredQuery, $from, $to);
        $reports = $this->selectRelevantCanBusFields($datedQuery, $parameters)->orderBy('can_bus_events.gps_utc_time')->get();
        $reports = $this->transformHectometersIntoKilometers($reports);

        return $reports;
    }

    public function getCanBusDataByTrackedObject($deviceId)
    {
        // Here tracked object becomes deviceId, because the name of the form field is trackedObjet but the value is device id
        $data = DB::connection('slave')
            ->table('devices')
            ->join('can_bus_events', 'can_bus_events.device_id',  '=', 'devices.id')
            ->leftJoin('gps_events', 'gps_events.id', '=', 'can_bus_events.gps_event_id')
            ->where('devices.id', $deviceId);

        return $data;
    }

    public function extendCanBusReportByParameters(Builder $query, $parameters)
    {
        foreach ($parameters as $parameter) {
            $query = $query->whereNotNull($parameter);
        }

        return $query;
    }

    public function extendCanBusReportByTimespan(Builder $query, $from, $to)
    {
        $query->whereDate('can_bus_events.gps_utc_time', '>=', $from);
        $query->whereDate('can_bus_events.gps_utc_time', '<=', $to);

        return $query;
    }

    public function selectRelevantCanBusFields(Builder $query, array $fields)
    {
        $fields[] = 'can_bus_events.id';
        $fields[] = 'can_bus_events.gps_utc_time';
        $fields[] = 'gps_events.latitude';
        $fields[] = 'gps_events.longitude';
        $fields[] = 'gps_events.azimuth';
        $fields[] = 'gps_events.device_status';
        return $query->select($fields);
    }

    private function getIdsOfQueryBuilderResult($results)
    {
        $ids = [];

        foreach ($results as $result) {
            $ids[] = $result->id;
        }

        return $ids;
    }

    private function transformIntoEloquentEntities($ids)
    {
        return CanBusEventReportGraphMutator::findMany($ids);
    }

    private function transformHectometersIntoKilometers($reportItems)
    {
        foreach ($reportItems as $item) {
            if (isset($item->total_distance)) {
                $item->total_distance *= 0.1;
            }
        }

        return $reportItems;
    }
}
