<?php

/**
 * Description of Drive
 *
 * @author Nikolay Velchev <nvelchev@neterra.net>,
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
use App\Traits\TimezoneAccessors;

class Driver extends Model
{
    use SoftDeletes,
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
    protected $table                = 'drivers';
    protected $fillable             = ['identification_number', 'phone', 'company_id'];
    protected $translatedAttributes = ['name'];

    /**
     * The guarded model fields, which cannot be filled-in
     * @var array
     */
    protected $guarded = [];

}
