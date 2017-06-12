<?php
namespace App\Modules\Users\Repositories\Eloquent;

use App\Modules\Users\Models\SlaveUserI18n;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;

class SlaveUserI18nRepository extends EloquentRepository
{
    public function __construct(SlaveUserI18n $model)
    {
        $this->model = $model;
    }
}
