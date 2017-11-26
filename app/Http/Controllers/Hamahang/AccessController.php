<?php
namespace App\Http\Controllers\Hamahang;


use DB;
use Auth;
use Exception;
use Request;
use Entrust;
use Datatables;
use App\Role;
use App\UserRole;
use App\Permission;
use App\PermissionRole;
use App\User;
use App\Http\Controllers\Controller;
use View;


class AccessController extends Controller
{
    public function Index($Uname)
    {
        $arr = variable_generator('user','desktop',$Uname);
        return view('hamahang.Access.Index', $arr);
    }

    public function rolesList()
    {
        $roles = DB::table('roles')->select('id', 'name', 'display_name', 'id as index')->get();
        foreach($roles as $index=>$role)
        {
            $roles[$index]->user_cnt = DB::table('role_user')->where('role_id','=',$role->id)->count();
            $roles[$index]->permission_cnt = DB::table('permission_role')->where('role_id','=',$role->id)->count();
        }
        return Datatables::of($roles)->make(true);
    }

    public function saveRole()
    {
        if (Request::input('id'))
        {
            $roleObj = Role::find(Request::input('id'));
            $validator = \Validator::make(Request::all(), [
                'name' => 'required|string',

            ]);
        }
        else
        {
            $roleObj = new Role();
            $validator = \Validator::make(Request::all(), [
                'name' => 'required|string|unique:roles,name',

            ]);
        }

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $roleObj->name = Request::input('name');
            $roleObj->display_name = Request::input('display_name');
            if ($roleObj->save())
            {
                return json_encode(array('success' => true));
            }
        }
    }

    public function editRole()
    {
        $role = Role::where('id', '=', Request::input('id'))->first();
        return json_encode($role);
    }

    public function permissionsList()
    {
        $roles = DB::table('permissions')->select('id', 'name', 'display_name', 'id as index')->get();
        return Datatables::of($roles)->make(true);
    }

    public function savePermission()
    {
        if (Request::input('id'))
        {
            $pObj = Permission::find(Request::input('id'));
            $validator = \Validator::make(Request::all(), [
                'name' => 'required|string',
            ]);
        }
        else
        {
            $pObj = new Permission();
            $validator = \Validator::make(Request::all(), [
                'name' => 'required|string|unique:permissions,name',
            ]);
        }

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $pObj->name = Request::input('name');
            $pObj->display_name = Request::input('display_name');
            $pObj->description = Request::input('description');
            if ($pObj->save())
            {
                return json_encode(array('success' => true));
            }
        }
    }

    public function editPermission()
    {
        $permission = Permission::where('id', '=', Request::input('id'))->first();
        return json_encode($permission);
    }

    public function roles()
    {
        $users = Role::select('id', 'name','display_name')->get();
        return json_encode($users);
    }

    public function saveUserRole()
    {

        $roles = Request::input('roles');
        if(is_array($roles))
        {
            try
            {
                DB::beginTransaction();
                //throw new Exception("something happened");
                foreach ($roles as $key => $role)
                {

                    $ruObj = new UserRole();
                    $ruObj->user_id =Request::input('user');
                    $ruObj->role_id = $role;
                    $ruObj->uid = Auth::id();
                    $ruObj->save();

                }

                DB::commit();
            }
            catch (\PDOException $e)
            {

                DB::rollback();

                $result['error'] = 'insertError';
                $result['success'] = false;
                return json_encode($result);
            }
            return json_encode(array('success' => true));
        }else{

            $ruObj = new UserRole();
            $ruObj->user_id =Request::input('user');
            $ruObj->role_id = $roles;
            $ruObj->uid = Auth::id();
           if( $ruObj->save())
           {
               return json_encode(array('success' => true));
           }else{
               $result['error'] = 'insertError';
               $result['success'] = false;
               return json_encode($result);
           }

        }

    }

    public function userRoleList()
    {
        $userroles = DB::table('role_user as ru')->select('ru.user_id', 'ru.role_id', 'u.UName', 'u.Name', 'u.Family', 'r.name', 'u.id', 'r.id as index')
            ->join('user as u', 'ru.user_id', 'u.id')
            ->join('roles as r', 'ru.role_id', 'r.id');
            if(Request::input('user_id'))
                $userroles->where('ru.user_id','=',Request::input('user_id'))->get();
            elseif(Request::input('role_id'))
                $userroles->where('ru.role_id','=',Request::input('role_id'))->get();
            else
                $userroles->get();



        return Datatables::of($userroles)->make(true);
    }

    public function deleteUserRole()
    {
        $delete = UserRole::where(['user_id' => Request::input('uid'),
            'role_id' => Request::input('roleid')
        ])->delete();
        if ($delete)
        {
            return json_encode(array('success' => true));
        }
    }

    public function permissionList()
    {
        $permission = Permission::select('id', DB::raw('CONCAT(name,"(",display_name,")") as name'))->get();
        return json_encode($permission);
    }

    public function savePermissionRole()
    {
        DB::beginTransaction();
        $permissions = Request::input('permissions');
       if(!is_array($permissions))
           $permissions =[$permissions];
        try
        {
            foreach ($permissions as $key => $p)
            {
                $pObj = new PermissionRole();
                $pObj->permission_id = $p;
                $pObj->role_id = Request::input('role');
                $pObj->uid = Auth::id();
                $pObj->save();
            }
            DB::commit();
        } catch (\Exception $e)
        {
            dd($e);
            DB::rollback();
            $result['error'] = 'insertError';
            $result['success'] = false;
            return json_encode($result);
        }

        return json_encode(array('success' => true));
    }

    public function permissionRoleList()
    {
        DB::enableQueryLog();
        $proles = DB::table('permission_role as pr')->select('pr.permission_id', 'pr.role_id', DB::raw('CONCAT(p.name,"(",p.display_name,")") as permission_name'), 'r.name as role_name', 'r.id as index')
            ->join('permissions as p', 'pr.permission_id', 'p.id')
            ->join('roles as r', 'pr.role_id', 'r.id')
            ->whereNull('pr.deleted_at');
        if(Request::input('permission_id'))
        {
            $proles->where('pr.permission_id','=',Request::input('permission_id'))->get();

        }elseif(Request::input('role_id'))
        {
           //dd('hhhhhhhhhhhhhhh');
            $proles->where('r.id','=',Request::input('role_id'))->get();

        }
        else
            $proles->get();


        return Datatables::of($proles)->make(true);
    }

    public function deletepermissionRole()
    {
        $delete = PermissionRole::where(['permission_id' => Request::input('permission'),
            'role_id' => Request::input('roleid')
        ])->delete();
        //echo $delete;
        if ($delete)
        {
            return json_encode(array('success' => true));
        }
    }

   /* public function userList()
    {
        $users = DB::select(
            "
              SELECT
                id,
                CONCAT(Name,'  ',Family,'( ',UName ,')' ) as text
              FROM
                `user`
              WHERE CONCAT(Name,'  ',Family,'( ',UName ,')' ) LIKE '% ? %'
            ",[Request::input('q')]
        );
        return json_encode($users);
    }
*/
    public function apiPermissionCheck($permissionn)
    {

        if (Auth::user()->can($permissionn))
        {
            return json_encode(array('access' => true));
        }
        else
        {
            return json_encode(array('access' => false));
        }
    }
    public function roleUsers()
    {
        $users = DB::table('user')->select("id", "name as text", "family","id as index",'role_user.role_id as role_id','role_user.created_at')
                                ->join('role_user','user.id','role_user.user_id')
                                ->where('role_user.role_id','=',Request::input('role_id'))
                                ->get();


        return Datatables::of($users)->make(true);
    }
    public function getPermissionByRoleId()
    {
        $permissions = DB::table('permission_role as pr')
                            ->select('pr.role_id','pr.permission_id')
                            ->where('pr.role_id','=',Request::input('role_id'))->get();
        return json_encode($permissions);
    }
    public  function getPermissionList()
    {
        $permission = Permission::all();
        return json_encode($permission);
    }
    public function savePermissionRoleGroup()
    {
        PermissionRole::where('role_id','=',Request::input('role_id'))->delete();

        DB::beginTransaction();
        $permissions = Request::input('permissions');
        try
        {
            foreach ($permissions as $key => $p)
            {
                $pObj = new PermissionRole();
                $pObj->permission_id = $p;
                $pObj->role_id = Request::input('role_id');
                $pObj->uid = Auth::id();
                $pObj->save();
            }
            DB::commit();
        } catch (\Exception $e)
        {
            DB::rollback();
            $result['error'] = 'insertError';
            $result['success'] = false;
            return json_encode($result);
        }

        return json_encode(array('success' => true));
    }
     public function newRoleModal()
     {
         return json_encode([
             'header'=>trans('calendar.modal_calendar_ header_title'),
             'content'=>view('hamahang.Access.helper.Index.modals.modal_add_roles')->render(),
             'footer'=>view('hamahang.Access.helper.Index.modals.modal_buttons')->with('btn_type','addRole')->render()
         ]);

     }
     public function newPermissionModal()
     {
         return json_encode([
             'header'=>trans('access.new_permission'),
             'content'=>view('hamahang.Access.helper.Index.modals.modal_add_permission')->render(),
             'footer'=>view('hamahang.Access.helper.Index.modals.modal_buttons')->with('btn_type','new_permission')->render()
         ]);

     }
     public function userRoleModal()
     {
         return json_encode([
             'header'=>trans('access.new_user_role'),
             'content'=>view('hamahang.Access.helper.Index.modals.modal_user_role_relation')->render(),
             'footer'=>view('hamahang.Access.helper.Index.modals.modal_buttons')->with('btn_type','new_user_role')->render()
         ]);


     }
    public function permissionRoleModal()
    {
        return json_encode([
            'header'=>trans('access.new_permission_role'),
            'content'=>view('hamahang.Access.helper.Index.modals.modal_permission_role_relation')->render(),
            'footer'=>view('hamahang.Access.helper.Index.modals.modal_buttons')->with('btn_type','permission_role')->render()
        ]);


    }

}
