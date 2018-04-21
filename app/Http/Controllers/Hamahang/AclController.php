<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\Hamahang\ACL\AclCategory;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\DB;
use Validator;

class AclController extends Controller
{
    public function index($username)
    {
//        $Subjects =
//            DB::table('user as u')
//                ->leftJoin('role_user as ru', 'ru.user_id', '=', 'u.id')
//                ->leftJoin('permission_role as pr', 'pr.role_id', '=', 'ru.role_id')
//                ->where('u.id', 85)
//                ->select('pr.permission_id as permision_id')->get();
//        $permissions = '';
//        foreach($Subjects as $Subject)
//            $permissions .= ','.$Subject->permision_id;
//        $permissions .= ',';
//        $result['message'][] = trans('app.operation_is_success');
//        $result['success'] = true;
//        echo '<pre>';
//        print_r($permissions);
//        foreach (tree_permissions_categories(['_users']) as $item){
//            if (array_key_exists('children', $item))
//            {
//            print_r($item);
//            die();
//           }
//        }

//        $Subjects =
//            DB::table('user as u')
//                ->leftJoin('role_user as ru', 'ru.user_id', '=', 'u.id')
//                ->leftJoin('permission_role as pr', 'pr.role_id', '=', 'ru.role_id')
//                ->where('u.id', 85)
//                ->select('pr.permission_id as permision_id')->get();
//
////        echo '<pre>';
//        $per = '';
//        foreach($Subjects as $Subject)
//            $per .= ','.$Subject->permision_id;
//        echo $per;
//        print_r($Subjects[0]->permision_id);
//
//        die();
////        return redirect('/');
//        $role = User::where('id', (85))->first();
//        $return = Datatables::eloquent($role->subject_policies())
////            ->addColumn('row_id', function ($data)
////            {
////                return $data->id;
////            })
////            ->editColumn('id', function ($data)
////            {
////                return enCode($data->id);
////            })
////            ->addColumn('jalali_reg_date', function ($data)
////            {
////                return $data->Reg_date;
////            })
//            ->make(true);
//        echo '<pre>';
//        print_r($return);
//        die();
        $arr = variable_generator('user', 'desktop', $username);
        $categories = AclCategory::get();
        return view('hamahang.ACL.index',$arr)
            ->with('cats', $categories);
    }

    public function getRoles()
    {
        return Datatables::eloquent(Role::withCount('_users', '_permissions'))
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
//            ->addColumn('edit_access', function ($data)
//            {
//                $user = auth()->user();
//                return $user->can(['acl.update_role']);
//            })
//            ->addColumn('delete_access', function ($data)
//            {
//                $user = auth()->user();
//                return $user->can(['backend.acl.delete_role']);
//            })
            ->make(true);
    }

    public function getPermissions()
    {
        return Datatables::eloquent(Permission::query())
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->make(true);
    }

    public function getCategories()
    {
        return Datatables::eloquent(AclCategory::with('parent'))
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->make(true);
    }

    public function destroyRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required'
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            Role::destroy(deCode($request->item_id));
            $result['grid'] = 'Roles_Grid';
            $result['result'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function destroyPermission(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required'
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            Permission::destroy(deCode($request->item_id));
            $result['grid'] = 'Permissions_Grid';
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function destroyCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required'
        ]);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            AclCategory::destroy(deCode($request->item_id));
            $result['grid'] = 'Categories_Grid';
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function updateRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
            'name' => 'required',
            'display_name' => 'required',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $role = Role::findOrFail(deCode($request->item_id));
            $role->created_by = auth()->id();
            $role->name = str_replace(' ', '', $request->name);
            $role->display_name = $request->display_name;
            $role->description = $request->description;
            $role->save();
            $result['message'][] = trans('acl.role_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function updatePermission(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
            'name' => 'required',
            'display_name' => 'required',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $permission = Permission::findOrFail(deCode($request->item_id));
            $permission->created_by = auth()->id();
            $permission->name = str_replace(' ', '', $request->name);
            $permission->display_name = $request->display_name;
            $permission->description = $request->description;
            $permission->save();
            $result['message'][] = trans('acl.permission_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function updateCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $permission = AclCategory::findOrFail(deCode($request->item_id));
            $permission->uid = auth()->id();
            $permission->parent_id = $request->parent_id;
            $permission->title = $request->title;
            $permission->description = $request->description;
            $permission->save();
            $result['message'][] = trans('acl.permission_category_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function getRolePermissions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required'
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            $result['view'] = draw_permissions_categories(tree_permissions_categories(), (int)deCode($request->item_id));
            return json_encode($result);
        }
    }

    public function getUserPermissions(Request $request)
    {
//        dd($request->user_id);
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if($request->permission_type == 'roles')
            {
                $role = User::where('id', ($request->user_id))->first();
                return Datatables::eloquent($role->_roles())
                    ->make(true);

            }
            else if($request->permission_type == 'pages')
            {
                $Subjects =
                    DB::table('hamahang_user_policies as hup')
                        ->leftJoin('user as u', 'hup.user_id', '=', 'u.id')
                        ->leftJoin('subjects as s', 'hup.target_id', '=', 's.id')
                        ->where('u.id', $request->user_id)
                        ->select('s.id as name','s.id as id', 's.title as display_name', 's.title as description')->take(50)->get();
                $Subjects = ['data'=>json_decode($Subjects),'recordsTotal'=>count(json_decode($Subjects)),'recordsFiltered'=>count(json_decode($Subjects))];
                return $Subjects;
                $role = User::where('id', ($request->user_id))->first();
                $return = Datatables::eloquent($role->subject_policies())
                    ->make(true);
            }else if($request->permission_type == 'cases')
            {
                $Subjects =
                    DB::table('user as u')
                        ->leftJoin('role_user as ru', 'ru.user_id', '=', 'u.id')
                        ->leftJoin('permission_role as pr', 'pr.role_id', '=', 'ru.role_id')
                        ->where('u.id', $request->user_id)
                        ->select('pr.permission_id as permision_id')->get();
                $permissions = ' ';
                foreach($Subjects as $Subject)
                    $permissions .= ' '.$Subject->permision_id;
                $permissions .= ' ';
                $result['message'][] = trans('app.operation_is_success');
                $result['success'] = true;
//                print_r($permissions);
//                print_r($request->user_id);
//                print_r($permissions);
//                die();
                $result['view'] = draw_permissions_categories(tree_permissions_categories(['_users']), $request->user_id, '_users',$permissions);
                return json_encode($result);
            }
        }
    }

    public function setRolePermissions(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:roles',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;

            $role = Role::find($request['id']);
            if($request->input('selected_permission'))
            {
                $role->permissions()->sync($request['selected_permission']);
            }
            else
            {
                $role->permissions()->sync([]);
            }
            return json_encode($result);
        }
    }

    public function setUserPermissions(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:user',
        ]);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $result['result'][] = trans('acl.set_user_permissions_success');
            $result['success'] = true;
            $user = User::find($request['id']);
            if($request->input('selected_permission'))
            {
                $user->permissions()->sync($request['selected_permission']);
            }
            else
            {
                $user->permissions()->sync([]);
            }
            return json_encode($result);
        }
    }

    public function addNewRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'display_name' => 'required'
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $role = new Role();
            $role->created_by = auth()->id();
            $role->name = str_replace(' ', '', $request->name);
            $role->display_name = $request->display_name;
            $role->description = $request->description;
            $role->save();
            $result['message'][] = trans('acl.new_role_was_successfully_added');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function addNewPermission(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'display_name' => 'required'
        ]);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $permission = new Permission();
            $permission->created_by = auth()->id();
            $permission->name = str_replace(' ', '', $request->name);
            $permission->display_name = $request->display_name;
            $permission->description = $request->description;
            $permission->save();
            $result['message'][] = trans('acl.new_permission_was_successfully_added');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function addNewCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $categories = AclCategory::get();
            $category = new AclCategory();
            $category->uid = auth()->id();
            $category->parent_id = $request->parent_id ? $request->parent_id : 0;
            $category->title = $request->title;
            $category->description = $request->description;
            $category->save();
            $result['message'][] = trans('acl.new_category_permission_was_successfully_added');
            $result['success'] = true;
            $result['cats'] = json_encode($categories);
            return json_encode($result);
        }
    }

    public function getRoleUsers(Request $request)
    {
        $role = Role::where('id', deCode($request->role_id))->first();
        return Datatables::eloquent($role->_users())
            ->addColumn('row_id', function ($data)
            {
                return $data->id;
            })
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->addColumn('jalali_reg_date', function ($data)
            {
                return $data->Reg_date;
            })
            ->make(true);
    }

    public function setRoleUsers(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'item_id' => 'required',
            ]);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else
        {
            $role = Role::findOrFail(deCode($request->item_id));
            foreach ($request->user_edits as $user)
            {
                if (!User::find($user)->hasRole($role->name))
                {
                    $role->_users()->attach([$user => ['user_type' => 'App\User']]);
                }
            }
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function removeRoleUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
            'role_id' => 'required',
        ]);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $user = User::find(deCode($request->item_id));
            $role = Role::findOrFail(deCode($request->role_id));
            $user->detachRole($role);

            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }

    }
}
