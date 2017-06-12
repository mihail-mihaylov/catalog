<?php
namespace App\Modules\Restrictions\Repositories\Eloquent;

use App\Modules\Restrictions\Interfaces\SlaveRestrictionTranslationsInterface;
use App\Modules\Restrictions\Models\LimitI18n;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;

class SlaveRestrictionTranslationsRepository extends EloquentRepository implements SlaveRestrictionTranslationsInterface
{
    public function __construct(LimitI18n $model)
    {
        $this->model = $model;
    }

    public function where($attributes = [])
    {
        foreach ($attributes as $key => $value) {
            $this->model = $this->model->where($key, $value);
        }

        return $this->model->get();
    }
}
