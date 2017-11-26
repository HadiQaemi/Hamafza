<?php

namespace App\Policies;

use App\User;
use App\Models\Hamahang\Tools\ToolsGroup;
use App\Models\Hamahang\Tools\ToolsGroupRole;
use App\Models\Hamahang\Tools\ToolsGroupUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class ToolsGroupPolicy
{
    use HandlesAuthorization;

    public function canView(User $user, ToolsGroup $group)
    {
        return true;
        //dd($user);
        $group_id = $group->id;
        $roleObj = new ToolsGroupRole();
        $roles = $roleObj->getRole($group_id);


        $roleArr = array();
        foreach ($roles as $r)
        {
            $roleArr[] = $r->name;
        }

        if(in_array('public',$roleArr))
        {
            return true;
        }

        $roleAccess = false;
        if (count($roleArr) > 0)
        {
            $roleAccess = $user->hasRole($roleArr);
        }

        $users = ToolsGroupUser::select('user_id')
            ->where('group_id', '=', $group_id)->get();

        $userArr = array();
        foreach ($users as $u)
        {
            array_push($userArr, $u->user_id);
        }

        $userAccess = false;
        if (in_array($user->id, $userArr))
        {
            $userAccess = true;
        }

        return ($roleAccess || $userAccess ? true : false);
    }
}

