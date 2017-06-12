<?php

namespace App\Modules\Dashboard\Http\Requests;

use App\Http\Requests\Request;

class ManageTrainRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'train_name' => 'required|not_in:0',
            'train_role' => 'required|exists:slave.tracked_objects_roles,id'
        ];
    }

    /**
     * Validation messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'train_name.*' => trans('dashboard.validation.train_name'),
            'train_role.*' => trans('dashboard.validation.train_role'),
        ];
    }
}
