<?php
namespace App\Modules\Users\Models;

use App;
use App\Models\SlaveUser;
use App\Modules\Users\Observers\SlaveUserTranslationsObserver;
use App\UserI18n;
use App\Traits\HasTranslatedAttributes;

class SlaveUserI18n extends UserI18n
{
    use HasTranslatedAttributes;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = 'slave';
    }

    public function user()
    {
        return $this->belongsTo(SlaveUser::class);
    }

    public static function boot()
    {
        parent::boot();
        SlaveUserI18n::observe(App::make(SlaveUserTranslationsObserver::class));
    }
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['language_id', 'user_id', 'first_name', 'middle_name', 'last_name'];
    protected $guarded  = [];

    protected $translatedAttributes = ['first_name', 'last_name'];
}
