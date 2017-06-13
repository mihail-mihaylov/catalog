<?php

/**
 * Description of SlaveGroupsTrackedObjectsRepository
 *
 * @author nvelchev
 */

namespace App\Modules\TrackedObjects\Repositories\Eloquent;

use App\Modules\TrackedObjects\Repositories\SlaveGroupsTrackedObjectsInterface;
use App\Models\SlaveGroupsTrackedObjects;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;

class SlaveGroupsTrackedObjectsRepository extends EloquentRepository implements SlaveGroupsTrackedObjectsInterface
{

    protected $model;

    public function __construct(SlaveGroupsTrackedObjects $groupsTrackedObjects)
    {
        $this->model = $groupsTrackedObjects;
    }

    public function groupsWhereTrackedObjectIdIn($in = [])
    {
        return $this->model->whereIn('tracked_object_id', $in)->get();
    }
    
    public function trackedObjectsWhereInGroups($in = [])
    {
        return $this->model->whereIn('group_id', $in)->get();
    }

}
