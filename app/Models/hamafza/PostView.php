<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostView extends Model
{
    use softdeletes;
    protected  $table = 'post_view';

    public function user_group_member()
    {
        return $this->belongsTo('App\Models\hamafza\UserGroupMember', 'gid');
    }

}

