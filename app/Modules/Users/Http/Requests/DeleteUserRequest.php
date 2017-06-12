<?php

namespace App\Modules\Users\Http\Requests;

use Gate;
use App\Http\Requests\Request;
use App\Modules\Users\Repositories\SlaveUserInterface;
use App\Traits\SwitchesDatabaseConnection;

class DeleteUserRequest extends Request
{
    // use SwitchesDatabaseConnection;

    // public function __construct(SlaveUserInterface $slaveUser)
    // {
    //     parent::__construct();
    //     $this->slaveUser = $slaveUser;
    // }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        // return !! Gate::allows('delete', auth()->user(), $deletedUser);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'user_deletes_himself' => 'boolean|in:0'
        ];
    }


    protected function getValidatorInstance()
    {
        $data                                    = $this->all();

        $data['user_deletes_himself']            = (int) (auth()->user()->id == $this->route('user'));

        $this->getInputSource()->replace($data);

        /*modify request data before send to validator*/

        return parent::getValidatorInstance();
    }


}
