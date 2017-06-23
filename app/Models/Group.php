<?php

namespace App\Models;

use App\Traits\TimezoneAccessors;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;
//use Session;

class Group extends Model
{
    use SoftDeletes, TimezoneAccessors;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
    }
    protected $translatedAttributes = ['name'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = array('created_at', 'updated_at');

    protected $guarded = array();

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_groups', 'group_id', 'user_id');
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class, 'devices_groups', 'group_id', 'device_id');
    }

    public function getNameAttribute($value)
    {
        return ((array)json_decode($value))[env('APP_LANG')];
    }
}
