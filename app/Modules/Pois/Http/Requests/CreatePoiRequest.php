<?php
namespace App\Modules\Pois\Http\Requests;

use App\Http\Requests\Request;

class CreatePoiRequest extends Request
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
        $id = \Session::get('company_default_language_id');
        
        return [
            'coordinates.required'                   => trans('poi.validations.coordinates_required'),
            'coordinates.json'                       => trans('poi.validations.invalid_coordinates'),
            'translations.' . $id . '.name.required' => trans('poi.validations.name_required_language'),
            'icon.required'                          => trans('poi.choose_icon'),
            'icon.in'                                => trans('poi.validations.invalid_icon'),
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = \Session::get('company_default_language_id');

        return [
            'coordinates'                   => 'required|json',
            'translations.' . $id . '.name' => 'required',
            'icon'                          => 'required|in:' .
                                                        'house_parking,' .
                                                        'warehouse,' .
                                                        'shop,' .
                                                        'factory,' .
                                                        'office_building,' .
                                                        'service,' .
                                                        'gas_station,' .
                                                        'station,' .
                                                        'rail_station',
        ];
    }
}
