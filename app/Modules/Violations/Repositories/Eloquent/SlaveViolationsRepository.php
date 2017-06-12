<?php
namespace App\Modules\Violations\Repositories\Eloquent;

use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Modules\Violations\Interfaces\ViolationInterface;
use App\Modules\Violations\Models\Violation;
use DB;
use Carbon\Carbon;
use DBNetfleet;

class SlaveViolationsRepository extends EloquentRepository implements ViolationInterface
{
    public function __construct(Violation $model)
    {
        $this->model = $model;
    }

    public function getViolationData(Violation $violation)
    {
        $violationData = new \StdClass;

        // If area is violated
        $violationData->isArea = (bool) $violation->is_area_violated;
        $violationData->area = $violationData->isArea ? $violation->limit->area : false;

        // If speed is violated
        $violationData->isSpeed = (bool) $violation->is_speed_violated;
        $violationData->speed = $violationData->isSpeed ? $violation->limit->speed : false;

        // The whole violation
        $violationData->violation = $violation;

        // $violationData->areaPoints = $violationData->area ? $violation->limit->area->areaPoints : false;

        $gpsEvents = DB::connection('slave')->table('gps_events')
            ->where('device_id', $violation->device_id)
            ->whereBetween('gps_utc_time', [
                $violation->start_time,
                ($violation->end_time == null) ? Carbon::now()->toDateTimeString() : $violation->end_time
                ])
            ->take(50)
            ->get(['latitude', 'longitude', 'speed', 'id', 'gps_utc_time']);
        $gpsEvents = DBNetfleet::getDecoratedDateResult($gpsEvents);
        $violationData->trackedObjectPositions = $gpsEvents;

        return $violationData;
    }

    public function destroyAll()
    {
        $this->model->where('id', 'like', '%%')->delete();
    }

    public function getViolationsByRestriction($restriction_id)
    {
        return $this->model
            ->withTrashed()
            ->where('limit_id', $restriction_id)
            ->with(['device'])
            ->get();
    }
}
