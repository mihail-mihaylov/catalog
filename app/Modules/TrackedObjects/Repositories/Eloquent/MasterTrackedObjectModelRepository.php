<?php

/**
 * Description of MasterTrackedObjectModelReposotory
 *
 * @author nvelchev
 */

namespace App\Modules\TrackedObjects\Repositories\Eloquent;

use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Models\MasterTrackedObjectModel;
use App\Modules\TrackedObjects\Repositories\MasterTrackedObjectModelInterface;

class MasterTrackedObjectModelRepository extends EloquentRepository implements MasterTrackedObjectModelInterface
{

    protected $model;

    public function __construct(MasterTrackedObjectModel $trackedObjectModel)
    {
        $this->model = $trackedObjectModel;
    }

}
