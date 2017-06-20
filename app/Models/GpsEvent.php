<?php

namespace App\Models;

use App;
use App\Models\Device;
use App\Traits\TimezoneAccessors;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Session;

class GpsEvent extends Model
{
    use TimezoneAccessors;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'gps_events';
    protected $managedCompany = null;

    protected $fillable = ['*'];
    protected $guarded  = [''];

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
