<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'user_id', 'active'];

    public function getUserId()
    {
        return $this->user_id;
    }
}
