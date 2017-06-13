<?php

/**
 * Description of SlaveTrackedObjectTypeRepository
 *
 * @author nvelchev
 */

namespace App\Modules\TrackedObjects\Repositories\Eloquent;

use App\Models\SlaveTrackedObjectType;
use App\Modules\TrackedObjects\Repositories\SlaveTrackedObjectTypeInterface;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;

class SlaveTrackedObjectTypeRepository extends EloquentRepository implements SlaveTrackedObjectTypeInterface
{

    protected $model;

    public function __construct(SlaveTrackedObjectType $trackedObjectType)
    {
        $this->model = $trackedObjectType;
    }

}
