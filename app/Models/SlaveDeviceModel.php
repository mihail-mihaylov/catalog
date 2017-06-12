<?php

/**
 * Description of SlaveDeviceModel
 *
 * @author nvelchev
 */

namespace App\Models;

use App;
use App\DeviceModel;
use App\Traits\SwitchesDatabaseConnection;
use Session;

class SlaveDeviceModel extends DeviceModel
{

    use SwitchesDatabaseConnection;

    public $managedCompany = null;
    protected $connection = 'slave';

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        if (!Session::has('migrating'))
        {
            $this->connection = 'slave';
        }
    }

}
