<?php

namespace App\Modules\Users\Http\Requests;

use Gate;
use App\Http\Requests\Request;
use Session;

class RestoreUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        // return Gate::allows('deleteUser', Session::get('managed_company')) && Gate::allows('manageRole');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [];
    }
}
