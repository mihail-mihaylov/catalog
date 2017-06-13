<?php

namespace App\Repositories;

use App\Models\Group;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;

class GroupRepository extends EloquentRepository
{
    protected $model;

    public function __construct(Group $group)
    {
        $this->model = $group;
    }

    public function allWithDeleted($with = [])
    {
        $res = $this->model->withTrashed();

        foreach ($with as $relation) {
            $res = $res->with($relation);
        }

        return $res->get();
    }

    public function withTranslations()
    {
        return $this->model->with('translations');
    }

}
