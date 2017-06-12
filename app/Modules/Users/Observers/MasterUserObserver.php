<?php
namespace App\Modules\Users\Observers;

use App\Modules\Users\Repositories\MasterUserInterface;
use App\Modules\Users\Repositories\SlaveUserInterface;
use App\Models\MasterUser;
use App\Models\SlaveUser;
use App\User;
use Event;

class MasterUserObserver
{

    public function __construct(MasterUserInterface $masterUser, SlaveUserInterface $slaveUser)
    {
        $this->masterUser = $masterUser;
        $this->slaveUser = $slaveUser;
    }

    public function deleting($model)
    {
    	$obj = new \ReflectionClass($model);

    }
}