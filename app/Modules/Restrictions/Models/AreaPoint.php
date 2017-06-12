<?php

namespace App\Modules\Restrictions\Models;

use App\Traits\TimezoneAccessors;
use Illuminate\Database\Eloquent\Model;
use Session;

class AreaPoint extends Model
{
    use TimezoneAccessors;

    public function __construct($params = [])
    {
        parent::__construct($params);
        if (!Session::has('migrating')) {
            $this->connection = 'slave';
        }
    }

    protected $table = 'area_points';
    protected $fillable = [
    	'area_id',
    	'latitude',
    	'longitude',
    ];
    protected $dates = ['created_at', 'updated_at'];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
