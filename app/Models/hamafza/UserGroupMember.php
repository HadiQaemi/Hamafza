<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGroupMember extends Model
{
    use softdeletes;
    protected  $table = 'user_group_member';
    

}

