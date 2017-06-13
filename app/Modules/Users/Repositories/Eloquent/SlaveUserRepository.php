<?php
namespace App\Modules\Users\Repositories\Eloquent;

use App\User;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Modules\Users\Repositories\SlaveUserInterface;
use Gate;
use Illuminate\Support\Facades\Session;

class SlaveUserRepository extends EloquentRepository
{
    // public $translatedAttributes = ['first_name', 'last_name'];

    /**
     *
     * @param App $app Application container
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function findWithDeletes($id, $with = [])
    {
        $obj = $this->model->withTrashed()->where('id', $id);
        foreach ($with as $relation) {
            $obj->with($relation);
        }

        return $obj->first();
    }

    public function allWithDeleted($with = [])
    {
        $res = $this->model;

        if (Gate::allows('deleteUser', Session::get('managed_company'))) {
            $res = $res->withTrashed();
        }

        foreach ($with as $relation) {
            $res = $res->with($relation);
        }

        return $res->get();
    }

    public function restore($id)
    {
        $obj = $this->model->withTrashed()->find($id);

        $obj->restore();

        return $obj;
    }

}
