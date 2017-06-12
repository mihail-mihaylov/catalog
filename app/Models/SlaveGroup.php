<?php

/**
 * Description of SlaveGroup
 *
 * @author nvelchev
 */

namespace App\Models;

use App;
use App\Group;
use App\Models\SlaveGroupI18n;
use App\Models\SlaveSharedTask;
use App\Traits\SwitchesDatabaseConnection;
use Session;

class SlaveGroup extends Group
{

    use SwitchesDatabaseConnection;

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        if (!Session::has('migrating')) {
            $this->connection = 'slave';
        }
    }

    protected $table = 'groups';

    protected $fillable = array('company_id', 'created_at', 'updated_at');

    // protected $guarded = array();

    public function translations()
    {
        return $this->hasMany(SlaveGroupI18n::class, 'group_id', 'id')->with('language');
    }

    public function translation()
    {
        return $this->translations()->where('language_id', '=', \Session::get('locale_id'));
    }
    public function users()
    {
        return $this->belongsToMany(SlaveUser::class, 'users_groups', 'group_id', 'user_id');
    }

    public function trackedObjects()
    {
        return $this->belongsToMany(TrackedObject::class, 'groups_tracked_objects', 'group_id', 'tracked_object_id')->with('brand');
    }

    public function withDeletedTrackedObjects()
    {
        return $this->belongsToMany(TrackedObject::class, 'groups_tracked_objects', 'group_id', 'tracked_object_id')->withTrashed()->with('brand');
    }

    public function sharedTasks()
    {
        return $this->morphToMany(SlaveSharedTask::class, 'sharedtaskable', 'sharedtaskables', 'sharedtaskable_id', 'shared_task_id')
            ->with('translation');
    }

    public function defaultTranslation()
    {
        return $this->translations()->where('language_id', '=', \Session::get('company_default_language_id'))->where('group_id', $this->id);

    }
}
