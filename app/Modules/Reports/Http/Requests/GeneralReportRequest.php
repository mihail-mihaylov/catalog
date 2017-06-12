<?php

namespace App\Modules\Reports\Http\Requests;

use Illuminate\Http\Request;

class GeneralReportRequest extends Request
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
            'deviceId.required_without'     => trans('reports.validation.choose_tracked_object_or_driver'),
            'lastDate.required'             => trans('reports.choose_last_date'),
            'periodInput.required'          => trans('reports.choose_period_input'),
            'deviceId.exists'               => trans('trackedObjects.invalid_tracked_object'),
            'lastDate.date_format'          => trans('reports.invalid_last_date'),
            'periodInput.between'           => trans('reports.invalid_period_input'),
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
            'deviceId'      => 'required|integer|exists:tracker.devices,id',
            'lastDate'      => 'required|date_format:Y-m-d',
            'periodInput'   => 'required|integer|between:1,31',
        ];
    }
}
