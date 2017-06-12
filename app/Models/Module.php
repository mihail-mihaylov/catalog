<?php

namespace App;

use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use TimezoneAccessors;

    protected $table   = 'modules';
    protected $guarded = [];

    public function internationalizations()
    {
        return $this->hasMany(ModuleI18n::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'companies_modules', 'module_id', 'company_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_modules', 'module_id', 'role_id');
    }

    public function translations()
    {
        return $this->hasMany(ModuleI18n::class);
    }

    public function translation()
    {
    return $this->translations->where('language_id', \Session::get('locale_id'));
    }
}
