<?php

namespace App\Modules\TrackedObjects\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SlaveDevice;
use App;
use App\Traits\HasTranslatedAttributes;
use App\Traits\TimezoneAccessors;
use App\Modules\TrackedObjects\Observers\SlaveDevicesTranslationObserver;

class DeviceTranslation extends Model
{
    use HasTranslatedAttributes,
        TimezoneAccessors;

	public function __construct($attributes = [])
	{
		if (!\Session::has('migrating')) {
			$this->connection = 'slave';
		}

        parent::__construct($attributes);
	}

    public static function boot()
    {
        parent::boot();
        DeviceTranslation::observe(App::make(SlaveDevicesTranslationObserver::class));

    }

    protected $table = 'devices_i18n';

    protected $fillable = [
    	'name',
        'language_id',
    	'device_id',
    ];

    protected $guarded = [];

    protected $dates = [
	    'created_at',
	    'deleted_at',
	    'updated_at',
    ];
    protected $translatedAttributes = ['name'];
    public function device()
    {
    	return $this->belongsTo(SlaveDevice::class, 'device_id');
    }


}
