<?php

/**
 * Description of MasterDeviceModelRepository
 *
 * @author nvelchev
 */

namespace App\Modules\TrackedObjects\Repositories\Eloquent;

use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Modules\TrackedObjects\Repositories\MasterDeviceModelInterface;
use App\Models\MasterDeviceModel;

class MasterDeviceModelRepository extends EloquentRepository implements MasterDeviceModelInterface
{

    protected $model;

    public function __construct(MasterDeviceModel $masterDeviceModel)
    {
        $this->model = $masterDeviceModel;
    }
}