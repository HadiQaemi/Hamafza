<?php

namespace App\Models\hamafza;

use App\User;
use Auth;
use DB;
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
        $user = User::where('id', Auth::id())->first();
        $roles = array_column($user->_roles()->select('id')->get()->toArray(),'id');
        $roles_ids = [];
        foreach($roles as $Arole)
            $roles_ids[] = $Arole;

        $SubjectType = new SubjectType();
        $roles = $SubjectType->role_policies_personal()->whereIn('role_id',$roles)->get();
        $sub_ids = DB::table('hamahang_role_policies')->where('target_type','like','%SubjectType')->where('type','=',2)->whereIn('role_id',$roles_ids)->select('target_id')->get()->toArray();
        $SubjectTypes = [];
        foreach($sub_ids as $ASubjectType)
            $SubjectTypes[] = $ASubjectType->target_id;

        $SubjectType = SubjectType::whereIn('id',$SubjectTypes)->get();

        $sub_ids = DB::table('hamahang_user_policies')->where('target_type','like','%SubjectType')->where('type','=',2)->where('user_id','=',Auth::id())->select('target_id')->get()->toArray();
        $SubjectTypes = [];
        foreach($sub_ids as $ASubjectType)
            $SubjectTypes[] = $ASubjectType->target_id;
        $UserSubjectType = SubjectType::whereIn('id',$SubjectTypes)->get();

        foreach($UserSubjectType as $AUserSubjectType)
            $SubjectType[] = $AUserSubjectType;

        return $SubjectType;

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
//        DB::enableQueryLog();
        $user = User::where('id', Auth::id())->first();
        $roles = array_column($user->_roles()->select('id')->get()->toArray(),'id');
        $roles_ids = [];
        foreach($roles as $Arole)
            $roles_ids[] = $Arole;

        $SubjectType = new SubjectType();
        $roles = $SubjectType->role_policies_personal()->whereIn('role_id',$roles)->get();
        $sub_ids = DB::table('hamahang_role_policies')->where('target_type','like','%SubjectType')->where('type','=',1)->whereIn('role_id',$roles_ids)->select('target_id')->get()->toArray();
        $SubjectTypes = [];
        foreach($sub_ids as $ASubjectType)
            $SubjectTypes[] = $ASubjectType->target_id;

        $SubjectType = SubjectType::whereIn('id',$SubjectTypes)->get();

        $sub_ids = DB::table('hamahang_user_policies')->where('target_type','like','%SubjectType')->where('type','=',1)->where('user_id','=',Auth::id())->select('target_id')->get()->toArray();
        $SubjectTypes = [];
        foreach($sub_ids as $ASubjectType)
            $SubjectTypes[] = $ASubjectType->target_id;
        $UserSubjectType = SubjectType::whereIn('id',$SubjectTypes)->get();

        foreach($UserSubjectType as $AUserSubjectType)
            $SubjectType[] = $AUserSubjectType;

        return $SubjectType;

//        dd($SubjectType);
////        dd($SubjectTypes,DB::getQueryLog(),$SubjectTypes);
//        dd($roles);

        $allSubjectTypes = self::all();
        $res = [];
        foreach ($allSubjectTypes as $item)
        {
            if (policy_CanView($item->id, 'App\Models\hamafza\SubjectType', '\App\Policies\SubjectPolicy', 'canAddOfficial'))
            {
                $res[]= $item;
            }
        }
        dd($res);
        return $res;
    }

    public static function UserPermittedOfficialSubjectTypes()
    {
        $user = User::where('id', Auth::id())->first();
        $roles = $user->_roles();
        dd($roles);
        $allSubjectTypes = self::all();
        $res = [];
        foreach ($allSubjectTypes as $item)
        {
            if (policy_CanView($item->id, 'App\Models\hamafza\SubjectType', '\App\Policies\SubjectPolicy', 'canAddOfficial'))
            {
                $res[]= $item;
            }
        }
        dd('asdasd');
        return $res;
    }

    public function fields()
    {
        return $this->hasMany('App\Models\hamafza\SubjectTypeField','stid');
    }

}

