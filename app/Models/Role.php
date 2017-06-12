<?php

namespace App;

use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;
use Session;

class Role extends Model
{
    use TimezoneAccessors;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        if (!Session::has('migrating')) {
            $this->connection = 'tracker';
        }
    }
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The guarded model fields, which cannot be filled-in
     * @var array
     */
    protected $guarded = [];

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'roles_modules', 'role_id', 'module_id')->withPivot('acl');
    }

    public function givePermissionsTo($permission)
    {
        $this->permissions()->save($permission);
    }

    public function translations()
    {
        return $this->hasMany(RoleI18n::class);
    }

    public function translation()
    {
        return $this->translations()->where('language_id', Session::get('locale_id'));
    }

    // public function permissions()
    // {
    //     return $this->belongsToMany(Permission::class, 'roles_permissions', 'role_id', 'permission_id');
    // }
}
