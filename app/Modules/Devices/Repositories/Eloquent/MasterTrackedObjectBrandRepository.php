<?php

/**
 * Description of MasterBrandReposotory
 *
 * @author Nikolay Velchev <nvelchev@neterra.net>
 */

namespace App\Modules\TrackedObjects\Repositories\Eloquent;

use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Modules\TrackedObjects\Repositories\MasterTrackedObjectBrandInterface;
use App\Models\MasterTrackedObjectBrand;

class MasterTrackedObjectBrandRepository extends EloquentRepository implements MasterTrackedObjectBrandInterface
{

    protected $model;

    public function __construct(MasterTrackedObjectBrand $trackedObjectBrand)
    {
        $this->model = $trackedObjectBrand;
    }

}
