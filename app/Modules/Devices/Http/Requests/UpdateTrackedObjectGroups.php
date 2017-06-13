<?php

/**
 * Description of UpdateTrackedObjectGroups
 *
 * @author nvelchev
 */
namespace App\Modules\TrackedObjects\Http\Requests;

use App\Http\Requests\Request;

class UpdateTrackedObjectGroups extends Request
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'groups.required' => trans('trackedObjects.choose_tracked_object_group')
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'groups' => 'required'
        ];
    }
}
