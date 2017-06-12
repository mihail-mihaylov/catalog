<?php

namespace App;

use App\Traits\HasTranslation;
use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;

class RoleI18n extends Model
{
    use HasTranslation,
        TimezoneAccessors;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles_i18n';
}
