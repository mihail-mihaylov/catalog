<?php

namespace App\Modules\Dashboard\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Gate;

class TrackedObjectsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create_company_tracked_objects');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string',
            ''
        ];
    }
}
