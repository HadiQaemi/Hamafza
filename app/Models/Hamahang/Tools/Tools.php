<?php

namespace App\Models\Hamahang\Tools;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
class Tools extends Model
{
    use SoftDeletes;
    protected $table ='hamahang_tools';
    protected $dates = ['deleted_at'];

    public function group()
    {
        return $this->belongsTo('App\Models\Hamahang\Tools\ToolsGroup', 'tools_group_id', 'id');
    }

    public function available()
    {
        return $this->belongsTo('App\Models\Hamahang\Tools\ToolsAvailable', 'available_id', 'id');
    }

    public function options()
    {
        return $this->belongsToMany('\App\Models\Hamahang\Options', 'hamahang_tools_options', 'tools_id', 'option_id')->withTimestamps();
    }

    public function positions()
    {
        return $this->belongsToMany('\App\Models\Hamahang\TemplatePosition', 'hamahang_tools_position', 'tools_id', 'position_id')->withTimestamps();
    }


    public function user_policy()
    {
        return $this->morphToMany('App\User', 'target', 'hamahang_user_policies','target_id','user_id');
    }

    public function role_policy()
    {
        return $this->morphToMany('App\Role', 'target', 'hamahang_role_policies','target_id','role_id');
    }

    public function getPermittedUsersAttribute()
    {
        $permitted_users = $this->user_policy()->get(['hamahang_user_policies.user_id', 'Name', 'Family'])->toArray();
        return $permitted_users;
    }

    public function getPermittedRolesAttribute()
    {
        $permitted_roles = $this->role_policy()->get(['hamahang_role_policies.role_id', 'name', 'display_name'])->toArray();
        return $permitted_roles;
    }

}
