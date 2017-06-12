<?php

/**
 * Description of Groups
 *
 * @author Nikolay Velchev <nvelchev@neterra.net>,
 */

namespace App;

use App\Traits\SwitchesDatabaseConnection;
use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Group extends Model
{
    use SwitchesDatabaseConnection,
        SoftDeletes,
        TimezoneAccessors;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        if (!Session::has('migrating')) {
            $this->connection = 'slave';
        }
    }
    protected $translatedAttributes = ['name'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = array('company_id', 'created_at', 'updated_at');

    protected $guarded = array();

    public function groupI18n()
    {
        return $this->hasMany(GroupI18n::class, 'group_id')->where('language_id', '=', Session::get('user_language_id', 1));
    }

    public function translation()
    {
        return $this->hasMany(GroupI18n::class, 'group_id')->where('language_id', Session::get('locale_id'));
    }

    public function translations()
    {
        return $this->hasMany(GroupI18n::class, 'group_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_groups', 'group_id', 'user_id');
    }


    public function usersWithTranslations()
    {
        return $this->users()->withTrashed()->with('translation');
    }

    public function trackedObjects()
    {
        return $this->belongsToMany(TrackedObject::class, 'groups_tracked_objects', 'group_id', 'tracked_object_id')->with('brand');
    }

}
