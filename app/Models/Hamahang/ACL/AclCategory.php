<?php

namespace App\Models\Hamahang\ACL;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AclCategory extends Model
{
   use softDeletes;

    public function parent()
    {
        return $this->hasOne('App\Models\Hamahang\ACL\AclCategory', 'id', 'parent_id');
    }

    public function permissions()
    {
        return $this->hasMany('App\Permission', 'cat_id');
    }


}
