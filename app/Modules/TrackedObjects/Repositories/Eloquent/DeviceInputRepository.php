<?php
namespace App\Modules\TrackedObjects\Repositories\Eloquent;

use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Modules\Installer\Models\DeviceInput;

class DeviceInputRepository extends EloquentRepository
{

    protected $model;

    public function __construct(DeviceInput $deviceInput)
    {
        $this->model = $deviceInput;
    }
}