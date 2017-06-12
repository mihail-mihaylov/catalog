<?php

namespace App\Modules\Restrictions\Models;

use App\Modules\Restrictions\Observers\RestrictionTranslationsObserver;
use App\Traits\HasTranslation;
use App\Traits\HasTranslatedAttributes;
use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;
use Session;

class LimitI18n extends Model
{
    use HasTranslation,
        HasTranslatedAttributes,
        TimezoneAccessors;

    public function __construct($params = [])
    {
        parent::__construct($params);
        if (!Session::has('migrating')) {
            $this->connection = 'slave';
        }
    }
    public static function boot()
    {
        parent::boot();
        LimitI18n::observe(\App::make(RestrictionTranslationsObserver::class));
    }
    protected $table = 'limits_i18n';

    protected function limit()
    {
        return $this->belongsTo(Limit::class);
    }
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'limit_id',
        'language_id',
        'name',
    ];

    protected $guarded = [];

    public function restriction()
    {
        return $this->belongsTo(Limit::class);
    }

    protected $translatedAttributes = ['name', 'area_name'];
}
