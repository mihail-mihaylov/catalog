<?php

/**
 * Description of UserI18n
 *
 * @author Nikolay Velchev <nvelchev@neterra.net>,
 */
namespace App;

use App\Traits\HasTranslation;
use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;

class UserI18n extends Model
{

    use HasTranslation,
        TimezoneAccessors;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_i18n';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

}
