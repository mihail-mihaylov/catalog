<?php
namespace App\Modules\Restrictions\Repositories\Eloquent;

use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Modules\Restrictions\Interfaces\AreaPointInterface;
use App\Modules\Restrictions\Models\AreaPoint;

class SlaveAreaPointsRepository extends EloquentRepository implements AreaPointInterface
{
	public function __construct(AreaPoint $model) 
	{
		$this->model = $model;
	}
}