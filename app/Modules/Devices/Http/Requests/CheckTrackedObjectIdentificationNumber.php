<?php

/**
 * Description of CheckTrackedObjectIdentificationNumber
 *
 * @author nvelchev
 */

namespace App\Modules\TrackedObjects\Http\Requests;

use App\Http\Requests\Request;

class CheckTrackedObjectIdentificationNumber extends Request
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
            'identification_number' => 'required|exists:slave.tracked_objects,identification_number',
        ];
    }

}
