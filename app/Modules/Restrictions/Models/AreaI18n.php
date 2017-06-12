<?php

namespace App\Modules\Restrictions\Models;

use App;
use App\Modules\Restrictions\Observers\AreaTranslationsObserver;
use App\Traits\HasTranslation;
use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;

class AreaI18n extends Model
{
    use HasTranslation,
        TimezoneAccessors;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->connection = 'slave';
    }

    public static function boot()
    {
        parent::boot();

        AreaI18n::observe(App::make(AreaTranslationsObserver::class));
    }
    protected $table = 'areas_i18n';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'language_id',
        'area_id',
        'name',
    ];

    protected $guarded = [];

    protected $translatedAttributes = ['name'];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
