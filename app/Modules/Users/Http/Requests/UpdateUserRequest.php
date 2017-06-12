<?php

namespace App\Modules\Users\Http\Requests;

use App;
use App\Http\Requests\Request;
use Session;
use Input;

class UpdateUserRequest extends Request
{

    private $formattedGroupMessages = [];

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
        $messages = [
            'password.*'                              => trans('users.validation.invalid_password'),
            'password_confirmation.*'                 => trans('users.validation.password_not_match'),
            'groups.*'                                => trans('users.validation.invalid_group'),
        ];

        $messages['translations.' . \Session::get('company_default_language_id') . '.first_name.*'] = trans('users.validation.first_name_required');
        $messages['translations.' . \Session::get('company_default_language_id') . '.last_name.*']  = trans('users.validation.last_name_required');

        $messages['email.required']   = trans('users.validation.invalid_email', [], 'messages', App::getLocale());
        $messages['email.email']      = trans('users.validation.invalid_email', [], 'messages', App::getLocale());
        $messages['email.unique']     = trans('users.validation.email_exists', [], 'messages', App::getLocale());
        $messages['role_id.required'] = trans('users.validation.invalid_role', [], 'messages', App::getLocale());
        $messages['role_id.exists']   = trans('users.validation.invalid_role', [], 'messages', App::getLocale());
        $messages['phone.numeric']    = trans('users.validation.invalid_phone');
        // dd($messages);
        return $messages;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id                         = (int) $this->input('master_user_id');
        $defaultCompanyLanguageId   = Session::get('company_default_language_id');
        $defaultCompanyLanguageCode = Session::get('company_default_language_id');

        $groups = $this->input('groups');

        $rules = [
            'email'                                                      => 'required|email|unique:users,email,' . $id,
            'role_id'                                                    => 'required|exists:roles,id',
            'password'                                                   => 'min:6|confirmed|sometimes',
            'password_confirmation'                                      => 'min:6|sometimes',
            'translations.' . $defaultCompanyLanguageId . '.first_name'  => 'required',
            'translations.' . $defaultCompanyLanguageId . '.last_name'   => 'required',
            'groups'                                                     => 'required',
        ];
        $rules['phone'] = 'numeric';
        // $updatedGroups  = $this->updatedGroups();

        if (!empty($this->input('groups'))) {
            foreach ($this->input('groups') as $key => $group) {
                $rules['groups.' . $group]        = 'exists:slave.groups,id';
            }
        }

        return $rules;
    }

    // private function updatedGroups()
    // {
    //     if ($this->input('groups') == 0) {
    //         return [];
    //     }

    //     return $this->input('groups');
    // }

    protected function getValidatorInstance()
    {
        $data                                    = $this->all();

        if ( ($data['password'] == "") && ($data['password_confirmation'] == "") ) {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        $this->getInputSource()->replace($data);

        /*modify request data before send to validator*/

        return parent::getValidatorInstance();
    }
}
