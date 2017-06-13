<?php

namespace App\Modules\Restrictions\Repositories;

use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Modules\Restrictions\Models\Area;

class AreasRepository extends EloquentRepository
{
	function __construct(Area $model)
	{
		$this->model = $model;
	}
}