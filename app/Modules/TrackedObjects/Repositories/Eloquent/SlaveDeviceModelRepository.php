<?php

/**
 * Description of SlaveDeviceModelRepository
 *
 * @author nvelchev
 */
namespace App\Modules\TrackedObjects\Repositories\Eloquent;

use App\Modules\TrackedObjects\Repositories\SlaveDeviceModelInterface;
use App\Models\SlaveDeviceModel;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;

class SlaveDeviceModelRepository extends EloquentRepository implements SlaveDeviceModelInterface
{
    protected $model;

    public function __construct(SlaveDeviceModel $slaveDeviceModel)
    {
        $this->model = $slaveDeviceModel;
    }
    
    public function allWithDeleted($with = [])
    {
        $res = $this->model->withTrashed();

        foreach ($with as $relation) {
            $res = $res->with($relation);
        }

        return $res->get();
    }

}
