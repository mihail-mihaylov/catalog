<?php

namespace App;

use App\Traits\HasTranslation;
use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;

class ModuleI18n extends Model
{
    use HasTranslation,
        TimezoneAccessors;

    protected $table = 'modules_i18n';

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
