<?php

/**
 * Description of SlaveTrackedObjectBrandReposotory
 *
 * @author nvelchev
 */

namespace App\Modules\TrackedObjects\Repositories\Eloquent;

use App\Modules\TrackedObjects\Repositories\SlaveTrackedObjectBrandInterface;
use App\Models\SlaveTrackedObjectBrand;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;

class SlaveTrackedObjectBrandRepository extends EloquentRepository implements SlaveTrackedObjectBrandInterface
{

    protected $model;

    public function __construct(SlaveTrackedObjectBrand $trackedObjectBrand)
    {
        $this->model = $trackedObjectBrand;
    }


}
