<?php

namespace App\Modules\TrackedObjects\Http\Requests;

use App\Http\Requests\Request;
use App\Modules\Users\Repositories\SlaveUserInterface;

/**
 * Description of CreateTrackedObjectGroupRequest
 *
 * @author nvelchev
 */
class CreateTrackedObjectGroupRequest extends Request
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
    }

    public function messages()
    {
        return [
            'translations.' . \Session::get('company_default_language_id') . '.name.required' => trans('groups.validation.name_required'),
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
            'translations.' . \Session::get('company_default_language_id') . '.name' => 'required',
        ];
    }

}
