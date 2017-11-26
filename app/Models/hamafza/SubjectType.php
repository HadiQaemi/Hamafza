<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectType extends Model
{
    use softdeletes;
    protected $table = 'subject_type';

    public function subjects()
    {
        return $this->hasMany('App\Models\hamafza\Subject', 'kind');
    }

    public function user_policies_personal()
    {
        return $this->morphToMany('App\User', 'target', 'hamahang_user_policies', 'target_id', 'user_id')->wherePivot('type', '1');
    }

    public function role_policies_personal()
    {
        return $this->morphToMany('App\Role', 'target', 'hamahang_role_policies', 'target_id', 'role_id')->wherePivot('type', '1');
    }

    public function user_policies_official()
    {
        return $this->morphToMany('App\User', 'target', 'hamahang_user_policies', 'target_id', 'user_id')->wherePivot('type', '2');
    }

    public function role_policies_official()
    {
        return $this->morphToMany('App\Role', 'target', 'hamahang_role_policies', 'target_id', 'role_id')->wherePivot('type', '2');
    }

    public function getPermittedUsersPersonalAttribute()
    {
        $permitted_users = $this->user_policies_personal()->get(['hamahang_user_policies.user_id', 'Name', 'Family'])->toArray();
        return $permitted_users;
    }

    public function getPermittedRolesPersonalAttribute()
    {
        $permitted_roles = $this->role_policies_personal()->get(['hamahang_role_policies.role_id', 'name', 'display_name'])->toArray();
        return $permitted_roles;
    }

    public function getPermittedUsersOfficialAttribute()
    {
        $permitted_users = $this->user_policies_official()->get(['hamahang_user_policies.user_id', 'Name', 'Family'])->toArray();
        return $permitted_users;
    }

    public function getPermittedRolesOfficialAttribute()
    {
        $permitted_roles = $this->role_policies_official()->get(['hamahang_role_policies.role_id', 'name', 'display_name'])->toArray();
        return $permitted_roles;
    }

    public static function PermittedPersonalSubjectTypes()
    {
        $allSubjectTypes = self::all();
        $res = [];
        foreach ($allSubjectTypes as $item)
        {
            if (policy_CanView($item->id, 'App\Models\hamafza\SubjectType', '\App\Policies\SubjectPolicy', 'canAddPersonal'))
            {
                $res[]= $item;
            }
        }
        return $res;
    }
    public static function PermittedOfficialSubjectTypes()
    {
        $allSubjectTypes = self::all();
        $res = [];
        foreach ($allSubjectTypes as $item)
        {
            if (policy_CanView($item->id, 'App\Models\hamafza\SubjectType', '\App\Policies\SubjectPolicy', 'canAddOfficial'))
            {
                $res[]= $item;
            }
        }
        return $res;
    }

    public function fields()
    {
        return $this->hasMany('App\Models\hamafza\SubjectTypeField','stid');
    }

}

