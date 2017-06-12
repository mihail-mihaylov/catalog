<?php

namespace App;

use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class TripsTrains extends Model
{
    use TimezoneAccessors;

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        if ( ! Session::has('migrating')) {
            $this->connection = 'slave';
        }
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'trips_trains';

    protected $fillable = ['trip_id', 'train_id', 'tracked_object_role_id'];
}
