<?php

/**
 * Description of SlaveDevice
 *
 * @author nvelchev
 */

namespace App\Models;

use App;
use App\Device;
use App\Models\SlaveDeviceModel;
use App\Models\SlaveGpsEvent;
use App\Models\TrackedObject;
use App\Traits\SwitchesDatabaseConnection;
use App\Modules\Installer\Models\DeviceInput;
use App\Trip;
use Session;
use App\Modules\Restrictions\Models\LimitViolation;
use App\Modules\TrackedObjects\Models\DeviceTranslation;

class SlaveDevice extends Device
{

    use SwitchesDatabaseConnection;

    public $managedCompany = null;

    protected $table = 'devices';

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        if (!Session::has('migrating')) {
            $this->connection = 'slave';
        }
    }

    public static function boot()
    {
        parent::boot();
        if (!Session::has('migrating')) {
            SlaveDevice::observe(App::make('SlaveDeviceObserver'));
        }
    }

    protected $analogInputCount;
    protected $digitalInputCount;

    protected $appends = [
        'analogInputCount',
        'digitalInputCount',
    ];

    public function company()
    {
        return $this->belongsTo(SlaveCompany::class, 'company_id');
    }

    public function deviceModel()
    {
        return $this->belongsTo(SlaveDeviceModel::class, 'device_model_id');
    }

    public function trackedObject()
    {
        return $this->belongsTo(TrackedObject::class)
            ->with('type')
            ->with('brand')
            ->with('model')
            ->with('groups');
    }

    public function limitViolations()
    {
        return $this->hasMany(LimitViolation::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class, 'device_id');
    }

    public function gpsEvents()
    {
        return $this->hasMany(SlaveGpsEvent::class, 'device_id');
    }

    public function lastTrip()
    {
        // return $this->hasOne(Trip::);
    }

    public function lastGpsEvent()
    {
        return $this->belongsTo(SlaveGpsEvent::class, 'last_gps_event_id');
    }


}
