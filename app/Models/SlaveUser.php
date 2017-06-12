<?php

namespace App\Models;

use App;
use App\Models\SlaveSharedTask;
use App\Modules\Users\Models\SlaveUserI18n;
use App\User;
use Session;

class SlaveUser extends User
{

    protected $table = 'users';
    // protected $fallbackTranslation;
    // protected $appends = ['fallbackTranslation'];

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
    }

    protected $fillable = [
        'company_id', 'email', 'role_id', 'password', 'phone', 'master_user_id',
        'remember_token', 'created_at', 'deleted_at', 'updated_at', 'last_login'
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public static function boot()
    {
        parent::boot();
        SlaveUser::observe(App::make('SlaveUserObserver'));
    }

    public function groups()
    {
        return $this->belongsToMany(SlaveGroup::class, 'users_groups', 'user_id', 'group_id')->with('translations');
    }

    public function company()
    {
        return $this->belongsTo(SlaveCompany::class, 'company_id')->with('users');
    }

    public function sharedTasks()
    {
        return $this->morphToMany(SlaveSharedTask::class, 'sharedtaskable', 'sharedtaskables', 'sharedtaskable_id', 'shared_task_id')
            ->with('translation');
    }

    public function tasks()
    {
        return $this->hasMany(SlaveSharedTask::class, 'assigner_id', 'id');
    }

    public function translations()
    {
        return $this->hasMany(SlaveUserI18n::class, 'user_id', 'id');
    }

    public function defaultTranslation()
    {
        return $this->translations()->where('language_id', '=', \Session::get('company_default_language_id'))->where('user_id', $this->id);

    }

    public function translation()
    {
        return $this->translations()->where('language_id', \Session::get('locale_id'));
    }
}
