<?php

namespace App;

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
    use Authenticatable,
        Authorizable,
        CanResetPassword,
        SoftDeletes;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
    }

    protected $fillable = [
        'company_id', 'email', 'role_id', 'password', 'phone', 'master_user_id',
        'remember_token', 'created_at', 'deleted_at', 'updated_at', 'last_login', 
        'timezone_id'
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

    // protected $with = ['role'];

    public function userI18n()
    {
        return $this->hasMany(UserI18n::class);
    }

    public function translations()
    {
        return $this->hasMany(UserI18n::class);
    }

    public function translation()
    {
        return $this->hasMany(UserI18n::class, 'user_id')
            ->where('language_id', '=', Session::get('locale_id', 1));
    }

    public function timezone()
    {
        return $this->belongsTo(Timezone::class, 'timezone_id');
    }
}
