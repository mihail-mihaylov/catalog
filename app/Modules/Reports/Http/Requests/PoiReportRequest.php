<?php

namespace App\Modules\Reports\Http\Requests;

use Illuminate\Http\Request;

class PoiReportRequest extends Request
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
            'poi.required'                  => trans('reports.poi_report_validation.choose_poi'),
            'lastDate.required'             => trans('reports.choose_last_date'),
            'periodInput.required.required' => trans('reports.choose_period_input'),

            'poi.exists'                    => trans('reports.poi_report_validation.invalid_poi'),
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
            'poi'         => 'required|integer|exists:tracker.poi,id',
            'lastDate'    => 'required|date_format:Y-m-d',
            'periodInput' => 'required|integer|between:1,31',
        ];
    }
}
