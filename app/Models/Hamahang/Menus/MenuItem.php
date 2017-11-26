<?php

namespace App\Models\Hamahang\Menus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use SoftDeletes;
    protected $menus = ['deleted_at'];
    protected $table='hamahang_menu_items';
    protected $default_attributes = [];

    public function __construct(array $attributes = array()){
        $this->default_attributes['created_by'] = auth()->id();
        $this->setRawAttributes(array_merge($this->attributes, $this->default_attributes), true);
        parent::__construct($attributes);
    }

//    protected $fillable = ['created_by'];

    public function user_policy()
    {
        return $this->morphToMany('App\User', 'target', 'hamahang_user_policies');
    }

    public function role_policy()
    {
        return $this->morphToMany('App\Role', 'target', 'hamahang_role_policies');
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

    public function parent()
    {
        return $this->hasOne('App\Models\Hamahang\Menus\MenuItem', 'id', 'parent_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'uid');
    }
}
