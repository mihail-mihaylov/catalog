<?php

namespace App\Modules\Users\Http\Requests;

use App\Http\Requests\Request;
use App\Modules\Users\Repositories\SlaveUserInterface;
use Gate;

class AddGroupRequest extends Request
{

    public function __construct(SlaveUserInterface $slaveUser)
    {
        parent::__construct();
        $this->slaveUser = $slaveUser;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('addGroup', $this->slaveUser->getManagedCompany());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
