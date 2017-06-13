<?php
namespace App\Traits;

use App\Group;

trait HasGroups
{
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'users_groups', 'user_id', 'group_id');
    }
}
