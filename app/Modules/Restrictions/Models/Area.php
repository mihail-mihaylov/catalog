<?php

namespace App\Modules\Restrictions\Models;

use App\Modules\Restrictions\Models\AreaI18n;
use App\Modules\Restrictions\Models\AreaPoint;
use App\Modules\Restrictions\Models\Limit;
use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;
use Session;

class Area extends Model
{
    use TimezoneAccessors;

    protected $connection;

    public function __construct($params = [])
    {
        parent::__construct($params);
        if (!Session::has('migrating')) {
            $this->connection = 'slave';
        }
    }

    protected $table    = 'areas';
    protected $fillable = ['area_type', 'radius'];
    protected $dates    = ['created_at', 'updated_at'];

    public function areaPoints()
    {
        return $this->hasMany(AreaPoint::class);
    }

    public function limits()
    {
        return $this->hasMany(Limit::class);
    }

    public function translations()
    {
        return $this->hasMany(AreaI18n::class);
    }

    public function translation()
    {
        return $this->translations()->where('language_id', \Session::get('locale_id'));
    }

    public function defaultTranslation()
    {
        return $this->translations()->where('language_id', '=', \Session::get('company_default_language_id'))->where('area_id', $this->id);
    }

    public function restriction()
    {
        return $this->hasOne(Limit::class);
    }
}
