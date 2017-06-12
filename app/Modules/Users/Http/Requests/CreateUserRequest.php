<?php

namespace App\Modules\Users\Http\Requests;

use App\Http\Requests\Request;
use Session;

class CreateUserRequest extends Request
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
        $languageId = Session::get('company_default_language_id');
        $code       = Session::get('company_default_language_code');

        return [
            'translations.' . \Session::get('company_default_language_id') . '.first_name.*' => trans('users.validation.first_name_required'),
            'translations.' . \Session::get('company_default_language_id') . '.last_name.*'  => trans('users.validation.last_name_required'),
            'email.required'                          => trans('users.validation.invalid_email'),
            'email.email'                             => trans('users.validation.invalid_email'),
            'email.unique'                            => trans('users.validation.invalid_email'),
            'role_id.required'                        => trans('users.validation.invalid_role'),
            'role_id.exists'                          => trans('users.validation.invalid_role'),
            'password.*'                              => trans('users.validation.invalid_password'),
            'password_confirmation.*'                 => trans('users.validation.password_not_match'),
            'groups.*'                                => trans('users.validation.invalid_group'),
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $defaultCompanyLanguageId = Session::get('company_default_language_id');

        if (is_null($this->get('groups'))) {
            $this['groups'] = [];
        }

        $rules = [
            'email'                                                      => 'required|email|unique:users,email',
            'role_id'                                                    => 'required|exists:roles,id',
            'company_id'                                                 => 'required|exists:companies,id',
            'password'                                                   => 'required|min:6|confirmed|sometimes',
            'password_confirmation'                                      => 'required|min:6|sometimes',
            'translations.' . $defaultCompanyLanguageId . '.first_name'  => 'required',
            'translations.' . $defaultCompanyLanguageId . '.last_name'   => 'required',
            'groups'   => 'required',
        ];

        if ($this->request->has('groups')) {
            foreach ($this->request->get('groups') as $key => $group_id) {
                $rules['groups.' . $key++] = 'exists:slave.groups,id';
            }
        }
//        dd($rules);
        return $rules;
    }
}
