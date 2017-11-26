<?php

namespace App\Models\Hamahang\Tools;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolsGroupRole extends Model
{
    use softdeletes;
    protected $table = 'hamahang_access_tools_group_role';
    public function role()
    {
        return $this->hasOne('App\Role','id','role_id')->whereNull('deleted_at');//->select('name as role_name');
    }
    public function tools_group()
    {
        return $this->hasOne('App\Models\Hamahang\Tools\ToolsGroup','id','id')->whereNull('deleted_at');//->select('name as tools_group_name');
    }
    public function getRole($group_id)
    {
        $roles = DB::table('roles')
            ->select('roles.id', 'roles.name')
            ->join('hamahang_access_tools_group_role as gr', 'roles.id', 'gr.role_id')
            ->where('gr.group_id', '=', $group_id)
            ->get();
        return $roles;
    }
}


