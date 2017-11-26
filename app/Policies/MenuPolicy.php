<?php

namespace App\Policies;

use App\Role;
use App\User;
use App\Models\Hamahang\Menus\MenuItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;
    private $parents = [];

    public function __construct()
    {
        //
    }

    private function getAllParents($menu_item)
    {
//        dd($menu_item->parent_id);
        $this->parents[] = $menu_item;
        if ($menu_item->parent_id != 0)
        {
            $this->getAllParents($menu_item->parent);
        }
    }

    private function canParentsView($user)
    {
        $parents = $this->parents;
        foreach ($parents as $parent)
        {
            $parent_access = $this->checkMenuItemAccess($user, $parent);

            if ($parent_access == false)
            {
                return false;
            }
        }
//        dd($parent_access);
        return true;
    }

    private function checkMenuItemAccess($user, $menu_item)
    {

        //Check Policy by User
        $permitted_users = $menu_item->permitted_users;
        if (isset($permitted_users) && is_array($permitted_users))
        {
            foreach ($permitted_users as $item)
            {
                if ($user->id == $item['pivot']['user_id'])
                {
                    return true;
                }
            }
        }

        //Check Policy by Role
        $permitted_roles = $menu_item->permitted_roles;
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

    public function canView(User $user, MenuItem $menu_item)
    {
        $this->getAllParents($menu_item);

        $parent_access = $this->canParentsView($user);
        $item_access = $this->checkMenuItemAccess($user, $menu_item);
        if ($parent_access == false)
        {
            return false;
        }
        if ($item_access == false)
        {
            return false;
        }
        return true;
    }
}
