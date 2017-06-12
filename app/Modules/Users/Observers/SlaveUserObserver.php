<?php
namespace App\Modules\Users\Observers;

use App\Models\MasterUser;
use App\Models\SlaveUser;
use App\Modules\Users\Repositories\MasterUserInterface;
use App\Modules\Users\Repositories\SlaveUserInterface;
use Event;

class SlaveUserObserver
{

    public function __construct(MasterUserInterface $masterUser, SlaveUserInterface $slaveUser)
    {
        $this->masterUser = $masterUser;
        $this->slaveUser  = $slaveUser;
    }

    public function deleted($model)
    {
        Event::fire('company.user.deleted');

        return $this->masterUser->delete($model->master_user_id);
    }

    public function restored($model)
    {
        Event::fire('company.user.restored');

        return $this->masterUser->restore($model->master_user_id);
    }
    public function updating($model)
    {

    }
    public function updated($model)
    {
        $masterUser = $this->masterUser->findWithDeletes($model->master_user_id);
        $attributes = $this->prepareMasterAttributes($model);

        unset($attributes['company_id']);
        Event::fire('company.user.updated');

        if (($rememberMe = $masterUser->remember_token) !== NULL) {
            $attributes['remember_token'] = $rememberMe;
        }

        return $masterUser = $this->masterUser->update($masterUser->id, $attributes);
    }

    private function prepareMasterAttributes(SlaveUser $slaveUser)
    {
        $attributes                  = $slaveUser->getAttributes();
        $attributes['slave_user_id'] = $slaveUser->id;

        unset($attributes['master_user_id']);
        unset($attributes['last_login']);

        return $attributes;
    }

    public function created($model)
    {
        $attributes               = $model->getAttributes();
        $attributes['company_id'] = $model->company->master_company_id;

        $masterUser = $this->masterUser->create($attributes);

        $this->setSlaveUserId($masterUser, $model);
        $this->setMasterUserId($model, $masterUser);

        Event::fire('company.user.created');
    }

    private function assignNewUserToCompanyDefaultGroup(SlaveUser $slaveUser)
    {
        $defaultCompanyGroup = $slaveUser->company->groups->sortBy('created_at')->first();

        $slaveUser->groups()->sync([$defaultCompanyGroup->id]);
        $slaveUser->save();
    }
    private function setSlaveUserId(MasterUser $masterUser, SlaveUser $slaveUser)
    {
        $obj = $this->masterUser->update($masterUser->id, ['slave_user_id' => $slaveUser->id]);
    }

    private function setMasterUserId(SlaveUser $slaveUser, MasterUser $masterUser)
    {
        $this->slaveUser->update($slaveUser->id, ['master_user_id' => $masterUser->id]);
    }
}
