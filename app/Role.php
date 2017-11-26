<?php namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\LaratrustRole;
use DB;
class Role extends LaratrustRole
{
    public function getMenuRole($menu_id)
    {
        $roles= DB::table('roles as r')
                    ->select('r.id','r.name')
            ->join('hamahang_access_menu_role as mr','mr.role_id','r.id')
            ->where('mr.menu_id','=',$menu_id)->get();

        return $roles;
    }

    public function _users()
    {
        return $this->belongsToMany('App\User','role_user', 'role_id', 'user_id');
    }

    public function _permissions()
    {
        return $this->belongsToMany('App\Permission','permission_role', 'role_id',  'permission_id');
    }

    public function subject_type_policies()
    {
        return $this->morphedByMany('App\Models\hamafza\SubjectType', 'target', 'hamahang_role_policies','role_id','target_id');
    }

    public function subject_type_policies_personal()
    {
        return $this->morphedByMany('App\Models\hamafza\SubjectType', 'target', 'hamahang_role_policies','role_id','target_id')->wherePivot('type','1');
    }

    public function subject_type_policies_Official()
    {
        return $this->morphedByMany('App\Models\hamafza\SubjectType', 'target', 'hamahang_role_policies','role_id','target_id')->wherePivot('type','2');
    }

}
