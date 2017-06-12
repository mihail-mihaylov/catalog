<?php

namespace App\Models;

use App\Train;
use App\Traits\SwitchesDatabaseConnection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SlaveTrain extends Train
{
    use SwitchesDatabaseConnection;

    protected $table = 'trains';

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        if ( ! Session::has('migrating')) {
            $this->connection = 'slave';
        }
    }

     public static function getTrain($tracked_object_id)
     {
         return DB::connection('slave')
                 ->table('trains')
                 ->select(DB::raw('trains.id AS train_name_id, tracked_objects_roles.name AS train_role'))
                 ->leftJoin('current_tracked_object_status', 'current_tracked_object_status.train_id', '=', 'trains.id')
                 ->leftJoin('tracked_objects_roles', 'tracked_objects_roles.id', '=', 'current_tracked_object_status.tracked_object_role_id')
                 ->where('current_tracked_object_status.tracked_object_id', '=', $tracked_object_id)
                 ->first();
     }
}