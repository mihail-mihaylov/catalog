<?php

namespace App\Models;

use App\Traits\TimezoneAccessors;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Session;

class Role extends Model
{
    use TimezoneAccessors;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
    }
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The guarded model fields, which cannot be filled-in
     * @var array
     */
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    public function getNameAttribute($value)
    {
        return ((array)json_decode($value))[env('APP_LANG')];
    }
}
