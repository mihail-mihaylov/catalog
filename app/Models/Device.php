<?php

namespace App\Models;

use App\Models\DeviceModel;
use App\Models\GpsEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{

    use SoftDeletes;

    protected $table = 'devices';
    public $managedCompany = null;

    /**
     * The guarded model fields, which cannot be filled-in
     * @var array
     */
    protected $guarded  = [];
    protected $fillable = [
        'device_model_id',
        'identification_number'
    ];

    public function deviceModel()
    {
        return $this->belongsTo(DeviceModel::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function gpsEvents()
    {
        return $this->hasMany(GpsEvent::class, 'device_id');
    }

    public function lastGpsEvent()
    {
        return $this->belongsTo(GpsEvent::class, 'last_gps_event_id');
    }
}
