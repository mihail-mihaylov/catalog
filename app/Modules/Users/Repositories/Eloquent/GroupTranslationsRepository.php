<?php
namespace App\Modules\Users\Repositories\Eloquent;

use App\GroupI18n;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Modules\Users\Repositories\SlaveUserInterface;
use Event;

class GroupTranslationsRepository extends EloquentRepository
{
    /**
     *
     * @param App $app Application container
     */
    public function __construct(GroupI18n $model)
    {
        $this->model = $model;
    }
}
