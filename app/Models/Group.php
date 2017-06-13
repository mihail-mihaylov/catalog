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
    use SoftDeletes,
        TimezoneAccessors;

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

    public function groupI18n()
    {
        return $this->hasMany(GroupI18n::class, 'group_id')->where('language_id', '=', Session::get('user_language_id', 1));
    }

    public function translation()
    {
        return $this->hasMany(GroupI18n::class, 'group_id')->where('language_id', Session::get('locale_id'));
    }

    public function translations()
    {
        return $this->hasMany(GroupI18n::class, 'group_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_groups', 'group_id', 'user_id');
    }

    public function usersWithTranslations()
    {
        return $this->users()->withTrashed()->with('translation');
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class, 'groups_devices', 'group_id', 'device_id');
    }
}
