<?php

/**
 * Description of GroupI18n
 *
 * @author Nikolay Velchev <nvelchev@neterra.net>,
 */

namespace App;

use App\Traits\HasTranslation;
use App\Traits\SwitchesDatabaseConnection;
use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class GroupI18n extends Model
{
    use SwitchesDatabaseConnection,
        SoftDeletes,
        HasTranslation,
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
    protected $table = 'groups_i18n';

    protected $dates = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];

    /**
     * The guarded model fields, which cannot be filled-in
     * @var array
     */
    protected $guarded = [];

}
