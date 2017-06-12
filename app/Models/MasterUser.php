<?php

namespace App\Models;

use App;
use App\Traits\SwitchesDatabaseConnection;
use App\User;
use App\Modules\Users\Observers\MasterUserObserver;

class MasterUser extends User
{
    use SwitchesDatabaseConnection;

    protected $connection = 'master';
    
    public static function boot()
    {
        parent::boot();
        // MasterUser::observe(App::make(MasterUserObserver::class));
    }

    public function auth()
    {
        return $this->find(auth()->user()->id);
    }

    protected $fillable = [
        'company_id',
        'slave_user_id',
        'role_id',
        'email',
        'password',
        'phone',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $dates = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];
    protected $guarded = ['id', 'managedCompany'];
    protected $hidden = ['managedCompany'];
}
