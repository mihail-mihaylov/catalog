<?php
namespace App\Modules\Violations\Models;

use App\Models\SlaveDevice;
use App\Modules\Restrictions\Models\Limit;
use App\Modules\Violations\Models\UserViolationNotification as Notifications;
use App\Traits\TimezoneAccessors;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Violation extends Model
{
    use SoftDeletes,
        TimezoneAccessors;

    public function __construct($params = [])
    {
        parent::__construct($params);
        if (!Session::has('migrating')) {
            $this->connection = 'slave';
        }
    }

    public function getDates()
    {
        return array('created_at', 'deleted_at', 'updated_at');
    }

    public $appends = ['hoursAgo'];

    protected $table = 'limit_violations';
    // protected $guarded  = [''];
    // public $managedCompany = null;

    public function device()
    {
        return $this->belongsTo(SlaveDevice::class)->with('trackedObject');
    }

    public function limit()
    {
        return $this->belongsTo(Limit::class)->with('area');
    }

    public function getHoursAgoAttribute()
    {
        return Carbon::now()->diffInHours($this->created_at);
    }

    public function notifications()
    {
        return $this->hasMany(Notifications::class);
    }

    protected static function boot()
    {
        // This runs on SOFT delete/update cascade
        parent::boot();

        static::deleting(function($violation) {
            $violation->notifications()->delete();
        });

        static::updating(function($violation) {
            $violation->notifications()->restore();
        });
    }
}
