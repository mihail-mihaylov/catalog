<?php

namespace App;

use App\Traits\HasTranslation;
use App\Traits\TimezoneAccessors;

use Illuminate\Database\Eloquent\Model;
use Session;

class TripI18n extends Model
{
    use Traits\SwitchesDatabaseConnection,
        HasTranslation,
        TimezoneAccessors;

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        if (!Session::has('migrating')) {
            $this->connection = 'slave';
        }
    }

    protected $table = 'trips_i18n';
}
