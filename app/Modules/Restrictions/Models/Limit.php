<?php

namespace App\Modules\Restrictions\Models;

use App\Models\TrackedObject;
use App\Modules\Violations\Models\Violation;
use App\Traits\SwitchesDatabaseConnection;
use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Limit extends Model
{
    use SoftDeletes,
        SwitchesDatabaseConnection,
        TimezoneAccessors;

    protected $connection;
    protected $areaField;
    protected $deleted;

    protected $appends = ['areaField', 'deleted'];

    public function __construct($params = [])
    {
        parent::__construct($params);
        if (!Session::has('migrating')) {
            $this->connection = 'slave';
        }

    }

    protected $table    = 'limits';
    protected $fillable = ['area_id', 'speed'];
    protected $dates    = ['deleted_at', 'created_at', 'updated_at'];

    public function area()
    {
        return $this->belongsTo(Area::class)->with(['areaPoints']);
    }

    public function trackedObjects()
    {
        return $this->belongsToMany(
            TrackedObject::class, 'tracked_objects_limits', 'limit_id', 'tracked_object_id'
        );
    }

    public function getAreaFieldAttribute()
    {
        if ($this->area === null) {
            return collect([]);
        }

        return collect($this->area);
    }

    /**
     * Accessor for a virtual "deleted"
     * property for easy deletion checks
     *
     * @return boolean
     */
    public function getDeletedAttribute()
    {

        if ($this->deleted_at !== null) {
            return true;
        }

        return false;
    }

    public function violations()
    {
        return $this->hasMany(Violation::class)->with('device')->with('limit');
    }

    public function translations()
    {
        return $this->hasMany(LimitI18n::class);
    }
    public function defaultTranslation()
    {
        return $this->translations()->where('language_id', '=', \Session::get('company_default_language_id'))->where('limit_id', $this->id);

    }
    public function translation()
    {
        return $this->hasMany(LimitI18n::class)->where('language_id', '=', \Session::get('locale_id'));
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($limit) {
            $limit->violations()->delete();
        });

        static::updating(function($limit) {
            $limit->violations()->restore();
        });
    }
}
