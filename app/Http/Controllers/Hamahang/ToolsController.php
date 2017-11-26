<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\Hamahang\Tools\Tools;
use App\Models\Hamahang\Tools\ToolsRoles;
use App\Models\Hamahang\Tools\ToolsUser;
use App\Role;
use Auth;
use Datatables;
use Illuminate\Http\Request;
use Route;
use DB;
use Symfony\Component\HttpFoundation\Session\Session;
use URL;
use Response;
use App\Models\Hamahang\Tools\ToolsGroup;
use App\Models\Hamahang\Tools\ToolsOptions;
use App\Models\Hamahang\Tools\ToolsPosition;
use Validator;

class ToolsController extends Controller
{

    public function Index($Uname)
    {
        $tools = Tools::all(['id', 'title as text']);
        $roles = Role::all(['id', 'name', 'display_name']);
        foreach ($roles as $role)
        {
            $role->text = $role->name . ' (' . $role->display_name . ')';
        }

        $with_arr = [
            'roles' => json_encode($roles),
            'all_tools' => json_encode($tools),
        ];
//        $v =
//        $groups = ToolsGroup::select('id')->get();
//        $tools = Tools::select('id', 'title as text')->get();
//
//        foreach ($groups as $g)
//        {
//            $retGroup[] = $g->id;
//        }
//
//        $arr = variable_generator('user', 'desktop', $Uname);
//        $user = Auth::user();
//        $arr['uname'] = $user['Uname'];
//        $with_arr['tools'] = json_encode($tools);
        $vg = variable_generator('user', 'desktop', $Uname);
        return view('hamahang.Tools.Index', $vg, $with_arr);
    }

    public function getTools()
    {
        $tools = Tools::with('group')->get();
        return Datatables::of($tools)
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->make(true);
    }

    public function saveTools(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'group_id' => 'required|integer',
            'url_type' => 'required|integer',
            'options' => 'required',
            'positions' => 'required',
        ], [], [
            'options' => 'نمایش در',
            'url_type' => 'url',
            'positions' => 'محل قرارگیری',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $tools = new Tools();
            $tools->uid = auth()->id();
            $tools->title = $request->title;
            $tools->url_type = $request->url_type;
            $tools->url = $request->url;
            $tools->icon = $request->icon;
            $tools->tools_group_id = $request->group_id;
            $tools->available_id = $request->available_id;
            $tools->save();

            $request->options ? $tools->options()->sync($request->options) : $tools->options()->sync([]);
            $request->positions ? $tools->positions()->sync($request->positions) : $tools->positions()->sync([]);
            $request->users_list ? $tools->user_policy()->sync($request->users_list) : $tools->user_policy()->sync([]);
            $request->roles_list ? $tools->role_policy()->sync($request->roles_list) : $tools->role_policy()->sync([]);

            return json_encode(array('success' => true));
        }
    }

    public function editTools(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'group_id' => 'required|integer',
            'url_type' => 'required|integer',
            'options' => 'required',
            'positions' => 'required',
        ], [], [
            'options' => 'نمایش در',
            'url_type' => 'url',
            'positions' => 'محل قرارگیری',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $tools = Tools::find(deCode($request->tool_id));
            $tools->uid = auth()->id();
            $tools->title = $request->title;
            $tools->url_type = $request->url_type;
            $tools->url = $request->url;
            $tools->icon = $request->icon;
            $tools->tools_group_id = $request->group_id;
            $tools->available_id = $request->available_id;
            $tools->save();

            $request->options ? $tools->options()->sync($request->options) : $tools->options()->sync([]);
            $request->positions ? $tools->positions()->sync($request->positions) : $tools->positions()->sync([]);
            $request->users_list ? $tools->user_policy()->sync($request->users_list) : $tools->user_policy()->sync([]);
            $request->roles_list ? $tools->role_policy()->sync($request->roles_list) : $tools->role_policy()->sync([]);

            return json_encode(array('success' => true));
        }
    }

    public function deleteTools(Request $request)
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
            Tools::destroy(deCode($request->item_id));
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }

    }

    public function setVisibility(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $id = deCode($request->input('id'));
            $item = Tools::find($id);
            if ($item->visible)
            {
                $item->visible = '0';
            }
            else
            {
                $item->visible = '1';
            }
            $item->save();
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function addToolsRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tools_id' => 'required|not_in:0',
            'tools_role_id' => 'required|not_in:0',
        ], [], [
            'tools_role_id' => 'نقش',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $tools = Tools::find($request->tools_id);
            if ($tools->role_policy->contains($request->tools_role_id))
            {
                $result['error'][] = trans('tools.role_exists');
                $result['success'] = false;
            }
            else
            {
                $tools->role_policy()->attach([$request->tools_role_id]);
                $result['message'][] = trans('app.operation_is_success');
                $result['success'] = true;
            }
            return json_encode($result);
        }
    }

    public function addToolsUser(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'datatables_tools_user_tools_id' => 'required|not_in:0',
            'datatables_tools_user_user_id' => 'required|not_in:0',
        ], [], [
            'datatables_tools_user_tools_id' => 'ابزار',
            'datatables_tools_user_user_id' => 'کاربر',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $tools = Tools::find($request->datatables_tools_user_tools_id);
            if ($tools->user_policy->contains($request->datatables_tools_user_user_id))
            {
                $result['error'][] = trans('tools.role_exists');
                $result['success'] = false;
            }
            else
            {
                $tools->user_policy()->attach([$request->datatables_tools_user_user_id]);
                $result['message'][] = trans('app.operation_is_success');
                $result['success'] = true;
            }
            return json_encode($result);
        }
    }

    public function getToolsRoles(Request $request)
    {
//        var_dump($request->all());
        $roles = DB::table('hamahang_tools as tools');
        if ($request->filter_tool > '' && $request->filter_tool != 0)
        {
            $roles = $roles->where('tools.id', $request->filter_tool);
        }

        $roles = $roles->join('hamahang_role_policies as policies', function ($query)
        {
            $query->on('policies.target_id', '=', 'tools.id');
            $query->on('policies.target_type', '=', DB::raw("'App\\\\Models\\\\Hamahang\\\\Tools\\\\Tools'"));
        });

        $roles = $roles->join('roles', 'roles.id', '=', 'policies.role_id');

        if ($request->filter_role > '' && $request->filter_role != 0)
        {
            $roles = $roles->where('roles.id', $request->filter_role);
        }
        $roles->whereNull('tools.deleted_at')
            ->whereNull('roles.deleted_at')
            ->select('tools.id as tool_id', 'tools.title as tool_title', 'roles.id as role_id', 'roles.name as role_name', 'roles.display_name as role_display_name')
            ->get();

        return Datatables::of($roles)

            ->make(true);
    }

    public function getToolsUsers(Request $request)
    {
//        var_dump($request->all());
        $users = DB::table('hamahang_tools as tools');
        if ($request->filter_tool > '' && $request->filter_tool != 0)
        {
            $users = $users->where('tools.id', $request->filter_tool);
        }

        $users = $users->join('hamahang_user_policies as policies', function ($query)
        {
            $query->on('policies.target_id', '=', 'tools.id');
            $query->on('policies.target_type', '=', DB::raw("'App\\\\Models\\\\Hamahang\\\\Tools\\\\Tools'"));
        });

        $users = $users->join('user', 'user.id', '=', 'policies.user_id');

        if ($request->filter_user > '' && $request->filter_user != 0)
        {
            $users = $users->where('user.id', $request->filter_user);
        }
        $users->whereNull('tools.deleted_at')
            ->whereNull('user.deleted_at')
            ->select('tools.id as tool_id', 'tools.title as tool_title', 'user.id as user_id', 'user.Uname', 'user.Name', 'user.Family')
            ->get();

        return Datatables::of($users)

            ->make(true);
    }

    public function deleteToolsRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tool_id' => 'required',
            'role_id' => 'required',
        ], [], [
            'tool_id' => 'ابزار',
            'role_id' => 'نقش',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $tools = Tools::find($request->tool_id);
            $tools->role_policy()->detach($request->role_id);
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function deleteToolsUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tool_id' => 'required',
            'user_id' => 'required',
        ], [], [
            'tool_id' => 'ابزار',
            'user_id' => 'کاربر',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $tools = Tools::find($request->tool_id);
            $tools->user_policy()->detach($request->user_id);
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function setItemOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'type' => 'required',
            'value' => 'required|int',
        ]);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            set_item_order('App\Models\Hamahang\Tools\Tools',
                $request->input('id'),
                $request->input('order_step'),
                $request->input('type'),
                $request->input('value'), null, 'orders');

            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

//    function saveTools()
//    {
//        dd(Request::all());
//        $validator = \Validator::make(Request::all(), [
//            'title' => 'required|string',
//            'group_id' => 'required|integer',
//            'show_in' => 'required',
//            'position' => 'required',
//        ]);
//        if ($validator->fails())
//        {
//            $result['error'] = $validator->errors();
//            $result['success'] = false;
//            return json_encode($result);
//        }
//        else
//        {
//            if (Request::input('id'))
//            {
//                $toolObj = Tools::find(Request::input('id'));
//                //deleted befor positions
//                ToolsPosition::where('tools_id', '=', Request::input('id'))->delete();
//                ToolsOptions::where('tools_id', '=', Request::input('id'))->delete();
//            }
//            else
//            {
//                $toolObj = new Tools();
//                $lastOrder =DB::table('hamahang_tools')->max('orders');
//                $toolObj->orders = $lastOrder+1;
//            }
//            $toolObj->title = Request::input('title');
//            $toolObj->menuid = Request::input('menuid');
//            $toolObj->url_type = Request::input('url_type');
//            if (Request::input('url_type') == 1)
//            {
//                $toolObj->available_id = Request::input('url');
//            }
//            else
//            {
//                if (Request::input('url_type') == 1)
//                {
//                    $toolObj->url = Request::input('url');
//                }
//            }
//            //$toolObj->desktop = Request::input('desktop');
//            $toolObj->icon = Request::input('icon');
//
//
//            if ($toolObj->save())
//            {
//                if (Request::input('users_list'))
//                {
//                    $toolObj->user_policy()->sync(Request::input('users_list'));
//                }
//                else
//                {
//                    $toolObj->user_policy()->sync([]);
//                }
//
//                if (Request::input('roles_list'))
//                {
//                    $toolObj->role_policy()->sync(Request::input('roles_list'));
//                }
//                else
//                {
//                    $toolObj->role_policy()->sync([]);
//                }
//            }
//            if ($toolObj->save())
//            {
//                $shows = Request::input('show_in');
//
//                foreach ($shows as $s)
//                {
//                    $opObj = new ToolsOptions();
//                    $opObj->tools_id = $toolObj->id;
//                    $opObj->option_id = $s;
//                    $opObj->save();
//                }
//                $positions = Request::input('position');
//
//                foreach ($positions as $p)
//                {
//                   //dd($p);
//                    $poObj = new ToolsPosition();
//                    $poObj->tools_id = $toolObj->id;
//                    $poObj->position_id = $p;
//                    //dd($opObj);
//                    $poObj->save();
//                }
//                return json_encode(array('success' => true));
//            }
//            else
//            {
//                return json_encode(array('success' => false));
//            }
//        }
//    }


//    public function getToolsPermissions(\Illuminate\Http\Request $request)
//    {
//        $res = [];
//        $tools_item = Tools::find($request->item_id);
//
//        $res['user_policy'] = $tools_item->user_policy;
//        $res['role_policy'] = $tools_item->role_policy;
//        return json_encode($res);
//    }
//
//    public function getToolsList()
//    {
//        $list = Tools::select('id', 'title', 'orders', 'id as index');
//        return Datatables::eloquent($list)->make(true);
//    }
//
//    public function edit()
//    {
//       // DB::enableQueryLog();
//        $tools = Tools::where('id', '=', Request::input('id'))
//            ->with(['options' => function ($query)
//            {
//
//                $query->whereNull('deleted_at');
//            }, 'positions'=>function ($query)
//            {
//                $query->whereNull('deleted_at');
//            }])->first();
//      //  dd(DB::getQueryLog());
//         return $tools;
//
//
//    }
//
//    public function delete()
//    {
//        $delete = Tools::where('id', '=', Request::input('id'))->delete();
//        if ($delete)
//        {
//            return json_encode(['action' => Request::input('action'),
//                'success' => true,
//                'msg' => trans('tools.record_delete_success'),
//                'title' => trans('tools.deleted')]);
//        }
//        else
//        {
//            return json_encode(['action' => Request::input('action'),
//                'success' => true,
//                'msg' => trans('tools.record_delete_unsuccess'),
//                'title' => trans('tools.deleted')]);
//        }
//
//    }
//
//    public function ordering($table,$parent_id,$parent_clumn_name='parent_id')
//    {
//        $tools = $table::select('id', 'orders')->where($parent_clumn_name, '=', $parent_id)->orderBy('orders', 'asc')->get();
//        $i = 1;
//        foreach ($tools as $g)
//        {
//            $gObj = $table::find($g->id);
//            $gObj->orders = $i;
//            $gObj->save();
//            $i++;
//        }
//    }
//
//    public function reOrder()
//    {
//        $validator = \Validator::make(Request::all(), [
//            'tbl' => 'required|in:tools,group',
//            'option'=>'required|in:up,down,in',
//
//        ]);
//        if ($validator->fails())
//        {
//            $result['error'] = $validator->errors();
//            $result['success'] = false;
//            return json_encode($result);
//        }
//        else
//        {
//            if(Request::input('tbl')=='tools')
//            {
//                $table ='\App\Models\Hamahang\Tools\Tools';
//            }else{
//                $table ='\App\Models\Hamahang\Tools\ToolsGroup';
//            }
//
//            $option = Request::input('option');
//            $newOrder = intVal(Request::input('orderVal'));
//
//            $id = (int)Request::input('id');
//            $tools = $table::find($id);
//            switch ($option)
//            {
//                case  'up':
//                {
//
//                    if (Request::input('sort') == 'asc')
//                    {
//                        $afters = $table::where('menuid', '=', $tools->menuid)->where('orders', '>=', $tools->orders - 1)->orderBy('orders', 'asc')->get();
//                        foreach ($afters as $a)
//                        {
//                            $co = $a->orders;
//                            $table::where('id', '=', $id)->update(['orders' => $co + 1]);
//
//                        }
//                        $tools->orders = $tools->orders - 1;
//                        $tools->save();
//
//                    }
//                    else
//                    {
//
//                        $afters = $table::where('menuid', '=', $tools->menuid)->where('orders', '>=', $tools->orders + 1)->orderBy('orders', 'asc')->get();
//
//                        foreach ($afters as $a)
//                        {
//                            $co = $a->orders;
//                            $table::where('id', '=', $id)->update(['orders' => $co + 1]);
//
//                        }
//                        $tools->orders = $tools->orders + 1;
//                        $tools->save();
//                    }
//                    $this->ordering($table,$tools->menuid);
//                    break;
//                }
//                case 'down':
//                {
//                    if (Request::input('sort') == 'asc')
//                    {
//                        $afters = $table::where('menuid', '=', $tools->menuid)->where('orders', '>=', $tools->orders + 1)->orderBy('orders', 'asc')->get();
//                        foreach ($afters as $a)
//                        {
//                            $co = $a->orders;
//                            $tools::where('id', '=', $id)->update(['orders' => $co + 1]);
//
//                        }
//                        $tools->orders = $tools->orders + 1;
//                        $tools->save();
//
//                    }
//                    else
//                    {
//
//                        $afters = $table::where('menuid', '=', $tools->menuid)->where('orders', '>=', $tools->orders - 1)->orderBy('orders', 'asc')->get();
//
//                        foreach ($afters as $a)
//                        {
//                            $co = $a->orders;
//                            $table::where('id', '=', $id)->update(['orders' => $co + 1]);
//
//                        }
//                        $tools->orders = $tools->orders - 1;
//                        $tools->save();
//                    }
//                    $this->ordering($table,$tools->menuid);
//
//                    break;
//                }
//                case 'in':
//                {
//
//                    $afters = ToolsGroup::where('menuid', '=', $tools->menuid)->where('orders', '>=', $newOrder)->orderBy('orders', 'asc')->get();
//                    foreach ($afters as $a)
//                    {
//                        $co = $a->orders;
//                        $table::where('id', '=', $id)->update(['orders' => $co + 1]);
//
//                    }
//                    $tools->orders = $tools->$newOrder;
//                    $tools->save();
//
//                    $this->ordering($table,$tools->parent_id);
//                break;
//                }
//
//
//            }
//            $result['success']=true;
//            $result['msg'] =[0=>trans('tools.reorderMsg')];
//            return json_encode($result);
//        }
//    }
//    public function saveRole()
//    {
//        $validator = \Validator::make(Request::all(), [
//            'role_id' => 'required|int',
//            'tools_id' => 'required|int'
//
//        ]);
//        if ($validator->fails())
//        {
//            $result['error'] = $validator->errors();
//            $result['success'] = false;
//            return json_encode($result);
//        }
//        else
//        {
//            if (Request::input('id'))
//            {
//                $Obj = ToolsRoles::find(Request::input('id'));
//            }
//            else
//            {
//                $Obj = new ToolsRoles();
//            }
//            $Obj->role_id = Request::input('role_id');
//            $Obj->tools_id = Request::input('tools_id');
//            $Obj->uid = Auth::id();
//            if ($Obj->save())
//            {
//
//                return json_encode(['success' => true, ['msg' => trans('tools.savedSuccessFully')]]);
//            }
//            else
//            {
//                return json_encode(['success' => false]);
//            }
//        }
//    }
//
//    public function roleList()
//    {
//        //DB::enableQueryLog();
//        $list = DB::table('hamahang_access_tools_role as tr')
//            ->select('tr.id', 't.title', 'tr.id as index', 'tr.role_id', 'tr.tools_id', DB::raw("CONCAT(roles.display_name,'(',roles.name,')' ) AS role_name"))
//            ->join('roles', 'roles.id', 'tr.role_id')
//            ->join('hamahang_tools as t', 't.id', 'tr.tools_id')
//            ->get();
//        //dd(DB::getQueryLog());
//        return Datatables::of($list)->make(true);
//    }
//
//    public function roleEdit()
//    {
//        $role = ToolsRoles::where('id', '=', Request::input('id'))->first();
//        return json_encode($role);
//    }
//
//    public function deleteRole()
//    {  // DB::enableQueryLog();
//        $deleted = ToolsRoles::where('id', '=', Request::input('id'))->delete();
//        // dd(DB::getQueryLog());
//        if ($deleted)
//        {
//            return json_encode(['success' => true, 'msg' => trans('tools.tools_role_deleted')]);
//        }
//        else
//        {
//            return json_encode(['success' => false]);
//        }
//    }
//
//    public function userSave()
//    {
//        $validator = \Validator::make(Request::all(), [
//            'user_id' => 'required|int',
//            'tools_id' => 'required|int'
//
//        ]);
//        if ($validator->fails())
//        {
//            $result['error'] = $validator->errors();
//            $result['success'] = false;
//            return json_encode($result);
//        }
//        else
//        {
//            if (Request::input('id'))
//            {
//                $Obj = ToolsUser::find(Request::input('id'));
//            }
//            else
//            {
//                $Obj = new ToolsUser();
//            }
//            $Obj->user_id = Request::input('user_id');
//            $Obj->tools_id = Request::input('tools_id');
//            $Obj->uid = Auth::id();
//            if ($Obj->save())
//            {
//
//                return json_encode(['success' => true, ['msg' => trans('tools.savedSuccessFully')]]);
//            }
//            else
//            {
//                return json_encode(['success' => false]);
//            }
//        }
//    }
//
//    public function userList()
//    {
//
//        $list = DB::table('hamahang_access_tools_user as tr')
//            ->select('tr.id', 't.title', 'tr.id as index', 'tr.user_id', 'tr.tools_id', DB::raw("CONCAT(user.name,' ',user.family ) AS user_name"))
//            ->join('user', 'user.id', 'tr.user_id')
//            ->join('hamahang_tools as t', 't.id', 'tr.tools_id')
//            ->get();
//        return Datatables::of($list)->make(true);
//    }
//
//    public function editUser()
//    {
//        $user = DB::table('hamahang_access_tools_user as tr')
//            ->select('tr.id', 'tr.user_id', 'tr.tools_id', DB::raw("CONCAT(user.name,' ',user.family ) AS user_name"))
//            ->join('user', 'user.id', 'tr.user_id')
//            ->where('tr.id', '=', Request::input('id'))->first();
//        return json_encode($user);
//    }
//
//    public function deleteUser()
//    {  //DB::enableQueryLog();
//        $deleted = ToolsUser::where('id', '=', Request::input('id'))->delete();
//        // dd(DB::getQueryLog());
//        if ($deleted)
//        {
//            return json_encode(['success' => true, 'msg' => trans('tools.group_user_deleted')]);
//        }
//        else
//        {
//            return json_encode(['success' => false]);
//        }
//    }
//    public function toolsModal()
//    {
//       // return view('hamahang.Tools.helper.Index.modals.modal_new_tool');
//        return json_encode([
//            'header'=>trans('tools.new_tools'),
//            'content'=>view('hamahang.Tools.helper.Index.modals.modal_new_tool')->render(),
//            'footer'=>view('hamahang.Tools.helper.Index.modals.modal_buttons')->render()
//        ]);
//
//    }
}
