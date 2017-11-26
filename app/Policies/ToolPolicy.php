<?php

namespace App\Policies;

use App\Role;
use App\User;
use App\Models\Hamahang\Tools\Tools;
use Illuminate\Auth\Access\HandlesAuthorization;

class ToolPolicy
{
    use HandlesAuthorization;

    private function checkToolAccess($user, $tool_item)
    {
        //Check Policy by User
        $permitted_users = $tool_item->permitted_users;
        if (isset($permitted_users) && is_array($permitted_users))
        {
            foreach ($permitted_users as $item)
            {
                if ($user->id == $item['user_id'])
                {
                    return true;
                }
            }
        }

        //Check Policy by Role
        $permitted_roles = $tool_item->permitted_roles;
        $user_roles = $user->_roles->toArray();
        if (isset($permitted_roles) && is_array($permitted_roles))
        {
            foreach ($permitted_roles as $role)
            {
                if (str_replace(' ', '', $role['name']) == config('constants.APP_PUBLIC_ROLE'))
                {
                    return true;
                }
                foreach ($user_roles as $user_role)
                {
                    if ($role['role_id'] == $user_role['id'])
                    {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function canView($user,Tools $tool_item)
    {
        $item_access = $this->checkToolAccess($user,$tool_item);
        if ($item_access == false)
        {
            return false;
        }
        return true;
    }
}
