<?php
namespace App\Modules\Restrictions\Repositories;

use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Modules\Restrictions\Models\AreaPoint;

class AreaPointsRepository extends EloquentRepository
{
	public function __construct(AreaPoint $model) 
	{
		$this->model = $model;
	}
}