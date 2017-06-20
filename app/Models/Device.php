<?php

namespace App\Models;

use App\Models\GpsEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use SoftDeletes;

    protected $table = 'devices';
    protected $fillable = [
        'identification_number'
    ];
    public $casts = [
        'name' => 'array'
    ];

    public function gpsEvents()
    {
        return $this->hasMany(GpsEvent::class, 'device_id');
    }

    public function lastGpsEvent()
    {
        return $this->belongsTo(GpsEvent::class, 'last_gps_event_id');
    }

    public function getNameAttribute($name)
    {
        return ((array)json_decode($name))[env('APP_LANG')];
    }
}
