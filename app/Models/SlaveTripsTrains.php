<?php

namespace App\Models;

use App\TripsTrains;
use App\Traits\SwitchesDatabaseConnection;
use Illuminate\Support\Facades\Session;

class SlaveTripsTrains extends TripsTrains
{
    use SwitchesDatabaseConnection;

    protected $table = 'trips_trains';

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        if ( ! Session::has('migrating')) {
            $this->connection = 'slave';
        }
    }
}
