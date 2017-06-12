<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeviceModel extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'device_models';

    /**
     * The guarded model fields, which cannot be filled-in
     * @var array
     */
    protected $guarded = [];
}
