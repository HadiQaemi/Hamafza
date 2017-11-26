<?php

namespace App\Models\Hamahang\Menus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menus extends Model
{
    use SoftDeletes;
    protected $table = 'hamahang_menus';
    protected $dates = ['deleted_at'];

    public function items()
    {
        return $this->hasMany('App\Models\Hamahang\Menus\MenuItem','menu_id','id');
    }

    public function role_policy()
    {
        return $this->morphToMany('App\Role', 'target', 'hamahang_role_policies');
    }

    public function user_policy()
    {
        return $this->morphToMany('App\User', 'target', 'hamahang_user_policies');
    }
}
