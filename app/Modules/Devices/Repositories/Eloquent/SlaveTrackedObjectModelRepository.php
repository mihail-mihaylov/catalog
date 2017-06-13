<?php

/**
 * Description of MasterTrackedObjectModelReposotory
 *
 * @author nvelchev
 */

namespace App\Modules\TrackedObjects\Repositories\Eloquent;

use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Models\SlaveTrackedObjectModel;
use App\Modules\TrackedObjects\Repositories\SlaveTrackedObjectModelInterface;

class SlaveTrackedObjectModelRepository extends EloquentRepository implements SlaveTrackedObjectModelInterface
{

    protected $model;

    public function __construct(SlaveTrackedObjectModel $trackedObjectModel)
    {
        $this->model = $trackedObjectModel;
    }

}
