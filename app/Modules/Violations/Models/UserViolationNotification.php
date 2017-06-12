<?php

namespace App\Modules\Violations\Models;

use App\Models\SlaveUser;
use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class UserViolationNotification extends Model
{
    use SoftDeletes,
        TimezoneAccessors;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        if (!Session::has('migrating')) {
            $this->connection = 'slave';
        }
    }
    protected $table    = 'users_violations_notifications';
    protected $fillable = [
        'violation_id',
        'user_id',
        'seen'
    ];

    public function user()
    {
        return $this->belongsTo(SlaveUser::class);
    }

    public function violation()
    {
        return $this->belongsTo(Violation::class);
    }
}
