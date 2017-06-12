<?php

/**
 * Description of MasterTrackedObjectTypeRespository
 *
 * @author nvelchev
 */

namespace App\Modules\TrackedObjects\Repositories\Eloquent;

use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Modules\TrackedObjects\Repositories\MasterTrackedObjectTypeInterface;
use App\Models\MasterTrackedObjectType;

class MasterTrackedObjectTypeRepository extends EloquentRepository implements MasterTrackedObjectTypeInterface
{

    protected $model;

    public function __construct(MasterTrackedObjectType $trackedObjectType)
    {
        $this->model = $trackedObjectType;
    }

}
