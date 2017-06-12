<?php

namespace App\Modules\Restrictions\Repositories\Eloquent;

use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Modules\Restrictions\Interfaces\AreaInterface;
use App\Modules\Restrictions\Models\Area;

class SlaveAreasRepository extends EloquentRepository implements AreaInterface
{
	function __construct(Area $model)
	{
		$this->model = $model;
	}
}