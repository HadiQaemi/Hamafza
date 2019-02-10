<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGroup extends Model
{
    use softdeletes;
    protected  $table = 'user_group';

    public function user_group_member()
    {
        return $this->hasMany('App\Models\hamafza\UserGroupMember', 'gid', 'id');
    }

    public function getMemberCountAttribute()
    {
        return $this->user_group_member->count();
    }

    public function post_view_count()
    {
        return $this->hasMany('App\Models\hamafza\PostView', 'gid', 'id');
    }

    public function getPostCountAttribute()
    {
        return $this->post_view_count->count();
    }
}

