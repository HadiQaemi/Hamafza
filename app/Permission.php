<?php namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\LaratrustPermission;

class Permission extends LaratrustPermission
{
    public function _roles()
    {
        return $this->belongsToMany('App\Role','permission_role', 'permission_id', 'role_id');
    }

    public function _users()
    {
        return $this->belongsToMany('App\User','permission_user', 'permission_id', 'user_id');
    }
}
