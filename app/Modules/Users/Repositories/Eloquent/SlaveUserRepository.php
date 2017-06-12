<?php
namespace App\Modules\Users\Repositories\Eloquent;

use App\Models\SlaveUser;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Modules\Users\Repositories\SlaveUserInterface;
use Gate;
use Illuminate\Support\Facades\Session;

class SlaveUserRepository extends EloquentRepository implements SlaveUserInterface
{
    // public $translatedAttributes = ['first_name', 'last_name'];

    /**
     *
     * @param App $app Application container
     */
    public function __construct(SlaveUser $model)
    {
        $this->model = $model;
    }

    public function auth()
    {
        return $this->findBy('master_user_id', auth()->user()->id)->first();
    }

    public function getCompany()
    {
        return $this->model->company;
    }

    public function getManagedCompany()
    {
        // dd($this->model->managedCompany);
        return $this->model->managedCompany;
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
