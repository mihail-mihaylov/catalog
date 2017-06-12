<?php

namespace App\Modules\TrackedObjects\Http\Requests;

use App\Http\Requests\Request;

class CreateUpdateTrackedObjectRequest extends Request
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

    public function messages()
    {
        return [
            'tracked_object_brand_id.required' => trans('trackedObjects.invalid_brand_id'),
            'tracked_object_brand_id.exists' => trans('trackedObjects.invalid_brand_id'),
            'tracked_object_model_id.required' => trans('trackedObjects.invalid_model_id'),
            'tracked_object_model_id.exists' => trans('trackedObjects.invalid_model_id'),
            'tracked_object_type_id.required' => trans('trackedObjects.invalid_type_id'),
            'tracked_object_type_id.exists' => trans('trackedObjects.invalid_type_id'),
            'identification_number.required' => trans('trackedObjects.invalid_identification_number'),
            'identification_number.alpha_num' => trans('trackedObjects.invalid_identification_number'),
            'identification_number.regex' => trans('trackedObjects.latin_characters'),
            'tracked_object_groups_ids.required' => trans('trackedObjects.invalid_tracked_object_group'),
            'tracked_object_groups_ids.*.exists' => trans('trackedObjects.invalid_tracked_object_group'),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $rules = [
            'tracked_object_brand_id' => 'required|exists:slave.tracked_object_brands,id|exists:slave.tracked_object_models,tracked_object_brand_id',
            'tracked_object_model_id' => 'required|exists:slave.tracked_object_models,id',
            'tracked_object_type_id' => 'required|exists:slave.tracked_object_types,id',
            'identification_number' => 'required|regex:/^[a-zA-z0-9.-]*$/',
            'tracked_object_groups_ids' => 'required',
        ];

        if ($this->request->has('tracked_object_groups_ids')) {
            foreach ($this->request->get('tracked_object_groups_ids') as $key => $group_id) {
                $rules['tracked_object_groups_ids.' . $key++] = 'required|exists:slave.groups,id';
            }
        }

        return $rules;
    }

}
