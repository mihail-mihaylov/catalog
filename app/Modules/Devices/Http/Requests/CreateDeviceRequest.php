<?php

/**
 * Description of CreateDeviceRequest
 *
 * @author nvelchev
 */

namespace App\Modules\TrackedObjects\Http\Requests;

use App\Http\Requests\Request;
use App\Modules\Users\Repositories\SlaveUserInterface;

class CreateDeviceRequest extends Request
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
            'identification_number.*'  => trans('devices.invalid_identification_number'),
            "translations.name.*"    => trans('devices.validation.name'),
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
            'identification_number' => 'required|unique:devices,identification_number|max:20|alpha_num',
            "name" => 'required',
            "group" => 'required|exists:groups,name',
        ];
    }
}
