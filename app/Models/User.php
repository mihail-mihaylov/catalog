<?php

namespace App;

use App\Models\Group;
use App\Models\Role;
use App\Traits\HasCompany;
use App\Traits\HasModules;
use App\Traits\HasRoles;
use App\Traits\TimezoneAccessors;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable; // junkies
use Session;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    const ADMIN = 1;
    const USER = 2;

    use Authenticatable,
        Authorizable,
        CanResetPassword,
        SoftDeletes;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
    }

    protected $fillable = [
        'email', 'role_id', 'password', 'remember_token', 'created_at', 'deleted_at', 'updated_at',
        'firstname', 'lastname'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table   = 'users';

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'users_groups', 'user_id', 'group_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function getFirstnameAttribute($name)
    {
        return ((array)json_decode($name))[env('APP_LANG')];
    }

    public function getLastnameAttribute($name)
    {
        return ((array)json_decode($name))[env('APP_LANG')];
    }
}
