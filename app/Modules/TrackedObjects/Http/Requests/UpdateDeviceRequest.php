<?php

/**
 * Description of CreateDeviceRequest
 *
 * @author nvelchev
 */

namespace App\Modules\TrackedObjects\Http\Requests;

use App\Http\Requests\Request;
use Input;
use App\Modules\Users\Repositories\SlaveUserInterface;

class UpdateDeviceRequest extends Request
{
    public function __construct(SlaveUserInterface $slaveUser)
    {
        parent::__construct();
        $this->slaveUser = $slaveUser;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
//        return auth()->user()->can('addGroup', $this->slaveUser->getManagedCompany());
    }

    public function messages()
    {
        return [
            'identification_number.*'  => trans('devices.invalid_identification_number'),
            'device_model_id.exists'   => trans('devices.invalid_device_model'),
            'digital_inputs.*'         => trans('devices.validation.invalid_analog_input_count'),
            'analog_inputs.*'          => trans('devices.validation.invalid_digital_input_count'),
            'device_model_id.required' => trans('devices.invalid_device_model'),
            "translations.*.name.*"    => trans('devices.validation.name'),
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $companyDefaultLanguageId = \Session::get('company_default_language_id');
        $device_id = Input::get('device_id');

        return [
            'identification_number' => 'required|max:20|alpha_num|unique:slave.devices,identification_number,' . $device_id,
            'device_model_id'       => 'exists:slave.device_models,id|required',
            'digital_inputs'        => 'required|integer',
            'analog_inputs'         => 'required|integer',
            "translations.$id.name" => 'required',
        ];
    }

}
