<?php

namespace App\Policies;

use App\Models\hamafza\SubjectType;
use App\Models\hamafza\Subject;
use App\Role;
use App\User;
use App\Models\Hamahang\Tools\Tools;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy
{
    use HandlesAuthorization;

    private function checkSubjectViewAccess($user, $subject_type)
    {
        if ($this->checkSubjectEditAccess($user, $subject_type) == true)
        {
            return true;
        }
        //Check Policy by User
        $permitted_users = $subject_type->permitted_users_view;
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
        $permitted_roles = $subject_type->permitted_roles_view;
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

    private function checkSubjectEditAccess($user, $subject_type)
    {
        //Check Policy by User
        $permitted_users = $subject_type->permitted_users_edit;
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
        $permitted_roles = $subject_type->permitted_roles_edit;
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

    private function checkSubjectTypePersonalAccess($user, $subject_type)
    {
        //Check Policy by User
        $permitted_users = $subject_type->permitted_users_personal;
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
        $permitted_roles = $subject_type->Permitted_roles_Personal;
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

    private function checkSubjectTypeOfficialAccess($user, $subject_type)
    {
        //Check Policy by User
        $permitted_users = $subject_type->permitted_users_official;
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
        $permitted_roles = $subject_type->Permitted_roles_official;
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

    public function canAddPersonal($user, SubjectType $subject_type)
    {
        return $this->checkSubjectTypePersonalAccess($user, $subject_type);
    }

    public function canAddOfficial($user, SubjectType $subject_type)
    {
        return $this->checkSubjectTypeOfficialAccess($user, $subject_type);
    }

    public function canView($user, Subject $subject)
    {
        if ($subject->admin == $user->id)
        {
            return true;
        }
        return $this->checkSubjectViewAccess($user, $subject);
    }

    public function canEdit($user, Subject $subject)
    {
        if ($subject->admin == $user->id)
        {
            return true;
        }
        return $this->checkSubjectEditAccess($user, $subject);
    }

    public function canAddSubject($user, $item)
    {
        $all_user_subject_type_policies = $user->subject_type_policies;
        if ($all_user_subject_type_policies->count())
        {
            return true;
        }
        foreach ($user->_roles as $role)
        {
            $all_role_subject_type_policies = $role->subject_type_policies;
            if ($all_role_subject_type_policies->count())
            {
                return true;
            }
        }
        return false;
    }
}
