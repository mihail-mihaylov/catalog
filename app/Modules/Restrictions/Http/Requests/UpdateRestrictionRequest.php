<?php
namespace App\Modules\Restrictions\Http\Requests;

use App\Http\Requests\Request;

class UpdateRestrictionRequest extends Request
{
    private $authorized  = true;
    private $customRules = [];

    private function updateRules($rule)
    {
        if (is_array($rule)) {
            $this->customRules = array_merge($this->customRules, $rule);
        } else {
            $this->authorized = false;
        }
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->authorized;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // $this->updateRules($this->getRectangleRules());
        $this->updateRules($this->getSpeedRules());
        $this->updateRules($this->getAreaRules());
        $this->updateRules($this->getTrackedObjectLimitsRules());
        $this->updateRules($this->getTranslationRules());

        return $this->customRules;
    }
    public function getTranslationRules()
    {
        return [
            'area.name.' . \Session::get('company_default_language_id')         => 'required_with:area_point',
            'translations.name.' . \Session::get('company_default_language_id') => 'required',

        ];
    }
    public function messages()
    {
        return [
            'area_point.required_without'            => trans('restrictions.validation.area_speed_required'),
            'area_point.numeric'                     => trans('restrictions.validation.invalid_area_points'),
            'area_point.between'                     => trans('restrictions.validation.invalid_area_points'),
            'area_type.required_without'             => trans('restrictions.validation.area_speed_required'),
            'area_type.in'                           => trans('restrictions.validation.invalid_area_type'),
            'radius.required_if'                     => trans('restrictions.validation.circle_radius'),
            'speed.required_without'                 => trans('restrictions.validation.area_speed_required'),
            'speed.numeric'                          => trans('restrictions.validation.invalid_speed'),
            'speed.min'                              => trans('restrictions.validation.invalid_speed'),
            'trackedObjectLimits.exists'             => trans('restrictions.validation.invalid_tracked_object'),
            'trackedObjectLimits.sometimes_required' => trans('restrictions.validation.invalid_tracked_object'),
            'area_point.same'                        => trans('restrictions.validation.invalid_area_points'),
            'translations.name.*'                    => trans('restrictions.validation.restriction_name_required'),
            'area.name.*'                            => trans('restrictions.validation.area_name_required'),

        ];
    }

    /**
     *
     *  if no speed set, require the area
     *  also require latitude and longitude values without speed
     *  let them be in valid ranges
     *
     * @return [array] [an array of area rules]
     */
    private function getAreaRules()
    {
        return [
            'area_point.*'     => 'required_without:speed',
            'area_point.*.lat' => 'numeric|between:-90,90',
            'area_point.*.lng' => 'numeric|between:-180,180',
            'area_type'        => 'in:rectangle,polygon,circle',
            'radius'           => 'required_if:area_type,circle',
        ];
    }

    /**
     * if no area set, we need speed
     * @return [array] [an array of speed rules]
     */
    private function getSpeedRules()
    {
        return [
            'speed' => 'required_without:area_point|numeric|min:10',
        ];
    }

    /**
     * Sometimes the user explicitly specifies
     * which tracked objects the rule applies to
     * when he has not specified this, it applies to
     * every single tracked object which exists in db
     *
     * @return [array] [an array of tracked objects' limits rules]
     */
    private function getTrackedObjectLimitsRules()
    {
        return [
            'trackedObjectLimits.*' => 'exists:slave.tracked_objects,id|sometimes|required',
        ];
    }
    /**
     * A mathematically sound rectangle
     * requires that certain conditions are met,
     * such as corresponding latitude and longitude
     *
     * @return [array] [an array of rectangle rules]
     */
    private function getRectangleRules()
    {
        if ($this->input('area_type') === null || $this->input('area_type') != 'rectangle') {
            return [];
        }

        return [
            'area_point.0.lat' => 'same:area_point.3.lat',
            'area_point.0.lng' => 'same:area_point.1.lng',
            'area_point.2.lat' => 'same:area_point.1.lat',
            'area_point.2.lng' => 'same:area_point.3.lng',
        ];

    }
}
