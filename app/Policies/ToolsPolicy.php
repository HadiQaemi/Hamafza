<?php

namespace App\Policies;

use App\User;
use App\Models\Hamahang\Tools\Tools;
use App\Models\Hamahang\Tools\ToolsRoles;
use App\Models\Hamahang\Tools\ToolsUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class ToolsPolicy
{
    use HandlesAuthorization;

    public function canView(User $user, Tools $tools)
    {
        $tools_id = $tools->id;
        $roleObj = new ToolsRoles();
        $roles = $roleObj->getRole($tools_id);
        $roleArr = array();
        foreach ($roles as $r)
        {
            $roleArr[] = $r->name;
        }
        if (in_array('public', $roleArr))
        {
            return true;
        }

        $roleAccess = false;
        if (count($roleArr) > 0)
        {
            $roleAccess = $user->hasRole($roleArr);
        }
        $users = ToolsUser::select('user_id')
            ->where('tools_id', '=', $tools_id)->get();
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

