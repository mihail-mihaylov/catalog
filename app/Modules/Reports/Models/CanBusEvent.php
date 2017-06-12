<?php
namespace App\Modules\Reports\Models;

use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;

class CanBusEvent extends Model
{
    use TimezoneAccessors;

    public function __construct($attributes = [])
    {
        if (!\Session::has('migrating')) {
            $this->connection = 'slave';
        }

        parent::__construct($attributes);
    }

    protected $table = 'can_bus_events';
    // protected $fillable  = ['*'];
    protected $guarded = [];

    public function getTotalDistanceAttribute($value)
    {
        // convert hectometers into meters
        return $value * 0.1;
    }
}
