<?php

/**
 * Description of MasterDeviceRepository
 *
 * @author nvelchev
 */

namespace App\Modules\TrackedObjects\Repositories\Eloquent;

use App\Models\MasterDevice;
use App\Modules\TrackedObjects\Repositories\MasterDeviceInterface;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;

class MasterDeviceRepository extends EloquentRepository implements MasterDeviceInterface
{

    protected $model;

    public function __construct(MasterDevice $masterDevice)
    {
        $this->model = $masterDevice;
    }

}
