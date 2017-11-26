<?php

namespace App\Models\Hamahang\Tools;

use DB;
use Auth;
use App\User;
use App\Policies\ToolsPolicy;
use App\Policies\ToolsGroupPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolsGroup extends Model
{
    use SoftDeletes;
    protected $table = 'hamahang_tools_groups';
    protected $dates = ['deleted_at'];

    public function table_name()
    {
        return $this->table();
    }

    public function tools()
    {
        return $this->hasMany('App\Models\Hamahang\Tools\Tools', 'tools_group_id','id');
    }

    public function roles()
    {
        return $this->morphToMany('App\Role','target','hamahang_role_policy');
    }
}
