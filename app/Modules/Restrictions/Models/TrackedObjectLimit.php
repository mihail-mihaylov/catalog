<?php

namespace App\Modules\Restrictions\Models;

use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;

class TrackedObjectLimit extends Model
{
    use TimezoneAccessors;

   protected $table = 'tracked_objects_limits';
}
