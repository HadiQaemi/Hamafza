<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Groups extends Model
{
    use softdeletes;
    protected  $table = 'user_group';

    public function Users()
    {
        return $this->belongsToMany('App\User','user_group_member','gid','uid');
    }
}

