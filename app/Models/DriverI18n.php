<?php
namespace App;

use App\Traits\HasTranslation;
use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;
use Session;

class DriverI18n extends Model
{
    use HasTranslation,
        TimezoneAccessors;

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        if (!Session::has('migrating')) {
            $this->connection = 'slave';
        }
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'drivers_i18n';

    protected $fillable = ['language_id', 'first_name', 'middle_name', 'last_name'];

}
