<?php
namespace App\Modules\Users\Repositories\Eloquent;

use App\Models\MasterUser;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Modules\Users\Repositories\MasterUserInterface;

class MasterUserRepository extends EloquentRepository implements MasterUserInterface
{
    public function __construct(MasterUser $model)
    {
        $this->model = $model;
    }

    public function auth()
    {
    	return auth()->user();
    }
}
