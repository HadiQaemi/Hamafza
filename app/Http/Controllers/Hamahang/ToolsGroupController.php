<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\Hamahang\Tools\Tools;
use App\Models\Hamahang\Tools\ToolsGroupRole;
use App\Models\Hamahang\Tools\ToolsGroupUser;
use Auth;
use Datatables;
use Illuminate\Http\Request;
use Route;
use DB;
use URL;
use Response;
use App\Models\Hamahang\Tools\ToolsGroup;
use Validator;

class ToolsGroupController extends Controller
{
    public function getToolsGroups()
    {
        $tools_groups = ToolsGroup::all();
        return Datatables::of($tools_groups)
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->make(true);
    }

    public function addNewToolsGroups(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $tools_group = new ToolsGroup();
            $tools_group->uid = auth()->id();
            $tools_group->name = $request->name;
//            $tools_group->orders = 0;
            $tools_group->save();
//            orderItem('App\Models\Hamahang\Tools\ToolsGroup', null, false, false, 'orders');
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function editToolsGroups(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $tools_group = ToolsGroup::find(deCode($request->item_id));
            $tools_group->uid = auth()->id();
            $tools_group->name = $request->name;
            $tools_group->save();
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
            set_item_order('App\Models\Hamahang\Tools\ToolsGroup',
                $request->input('id'),
                $request->input('order_step'),
                $request->input('type'),
                $request->input('value'), null, 'orders');

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
            $item = ToolsGroup::find($id);
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

    public function DeleteToolsGroups(Request $request)
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
            ToolsGroup::destroy(deCode($request->item_id));
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }

    }





//    public function Index($Uname)
//    {
//        $arr = variable_generator('user', 'desktop', $Uname);
//        $user = Auth::user()->getAttributes();
//        $arr['uname'] = $user['Uname'];
//        return view('hamahang.Tools.Index', $arr);
//    }
//
//    public function saveGroup()
//    {
//        $validator = \Validator::make(Request::all(), [
//            'name' => 'required|string',
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
//                $gObj = ToolsGroup::find(Request::input('id'));
//            }
//            else
//            {
//                $gObj = new ToolsGroup();
//            }
//            $gObj->name = Request::input('name');
//            if ($gObj->save())
//            {
//                $this->ordering();
//                return json_encode(['success' => true, ['msg' => trans('tools.savedSuccessFully')]]);
//            }
//            else
//            {
//                return json_encode(['success' => false]);
//            }
//        }
//    }
//
//    public function groupList()
//    {
//        /*$list = DB::table('hamahang_tools_groups')
//            ->select('id', 'name', 'orders', 'id as index')
//            ->whereNull('deleted_at')
//            ->get();*/
//        $list = ToolsGroup::select('id', 'name', 'orders', 'id as index');
//        return Datatables::eloquent($list)->make(true);
//    }
//
//    public function editGroup()
//    {
//        $group = ToolsGroup::where('id', '=', Request::input('id'))->first();
//        return json_encode($group);
//    }
//
//    public function deleteGroup()
//    {
//
//        $deleted = ToolsGroup::where('id', '=', Request::input('id'))->delete();
//        if ($deleted)
//        {
//            return json_encode(['success' => true, 'msg' => trans('tools.group_deleted')]);
//        }
//        else
//        {
//            return json_encode(['success' => false]);
//        }
//    }
//
//    public function ordering()
//    {
//        $groups = ToolsGroup::orderBy('orders', 'asc')->get();
//        $i = 1;
//        foreach ($groups as $g)
//        {
//            $g->orders = $i;
//            $g->save();
//            $i++;
//        }
//    }
//
//    public function reOrder()
//    {
//        $option = Request::input('option');
//        $newOrder = (int)Request::input('orderVal');
//        $id = (int)Request::input('id');
//        $group = ToolsGroup::find($id);
//        switch ($option)
//        {
//            case  'up':
//            {
//
//                if (Request::input('sort') == 'asc')
//                {
//                    $afters = ToolsGroup::where('orders', '>=', $group->orders - 1)->orderBy('orders', 'asc')->get();
//                    foreach ($afters as $a)
//                    {
//                        $co = $a->orders;
//                        $a->orders = $co + 1;
//                        $a->save();
//
//                    }
//                    $group->orders = $group->orders - 2;
//                    $group->save();
//                }
//                else
//                {
//                    $afters = ToolsGroup::where('orders', '>', $group->orders + 1)->orderBy('orders', 'asc')->get();
//                    foreach ($afters as $a)
//                    {
//                        $co = $a->orders;
//                        $a->orders = $co + 1;
//                        $a->save();
//
//                    }
//                    $group->orders = $group->orders + 2;
//                    $group->save();
//                }
//                $this->ordering();
//                break;
//            }
//            case 'down':
//            {
//
//
//                if (Request::input('sort') == 'asc')
//                {
//                    $afters = ToolsGroup::where('orders', '>', $group->orders + 1)->orderBy('orders', 'asc')->get();
//
//                    foreach ($afters as $a)
//                    {
//                        $co = $a->orders;
//                        $a->orders = $co + 1;
//                        $a->save();
//
//                    }
//                    //  dd($afters);
//                    $group->orders = $group->orders + 2;
//                    $group->save();
//                    dd($group);
//
//                }
//                else
//                {
//
//                    $afters = ToolsGroup::where('orders', '>=', $group->orders - 1)->orderBy('orders', 'asc')->get();
//
//                    foreach ($afters as $a)
//                    {
//                        $co = $a->orders;
//                        $a->orders = $co + 1;
//                        $a->save();
//
//                    }
//                    $group->orders = $group->orders - 2;
//                    $group->save();
//                }
//                $this->ordering();
//            }
//            case 'in':
//            {
//
//
//                $afters = ToolsGroup::where('orders', '>', $newOrder)->orderBy('orders', 'asc')->get();
//
//                foreach ($afters as $a)
//                {
//                    $co = $a->orders;
//                    $a->orders = $co + 1;
//                    $a->save();
//
//                }
//
//                $group->orders = $newOrder;
//                $group->save();
//
//                $this->ordering();
//            }
//
//        }
//    }
//
//    public function saveGroupRole()
//    {
//        $validator = \Validator::make(Request::all(), [
//            'role_id' => 'required|int',
//            'group_id' => 'required|int'
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
//                $tgObj = ToolsGroupRole::find(Request::input('id'));
//            }
//            else
//            {
//                $tgObj = new ToolsGroupRole();
//            }
//            $tgObj->role_id = Request::input('role_id');
//            $tgObj->group_id = Request::input('group_id');
//            $tgObj->uid = Auth::id();
//            if ($tgObj->save())
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
//    public function groupRoleList()
//    {
//        $query = ToolsGroupRole::with('tools_group')->with('role')->whereHas('tools_group')->whereHas('role');
//        return Datatables::eloquent($query)->make(true);
//    }
//
//    public function editRole()
//    {
//        $role = ToolsGroupRole::where('id', '=', Request::input('id'))->first();
//        return json_encode($role);
//    }
//
//    public function deleteRole()
//    {  // DB::enableQueryLog();
//        $deleted = ToolsGroupRole::where('id', '=', Request::input('id'))->delete();
//        // dd(DB::getQueryLog());
//        if ($deleted)
//        {
//            return json_encode(['success' => true, 'msg' => trans('tools.group_role_deleted')]);
//        }
//        else
//        {
//            return json_encode(['success' => false]);
//        }
//    }
//
//    public function saveGroupUser()
//    {
//        $validator = \Validator::make(Request::all(), [
//            'user_id' => 'required|int',
//            'group_id' => 'required|int'
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
//                $tgObj = ToolsGroupUser::find(Request::input('id'));
//            }
//            else
//            {
//                $tgObj = new ToolsGroupUser();
//            }
//            $tgObj->user_id = Request::input('user_id');
//            $tgObj->group_id = Request::input('group_id');
//            $tgObj->uid = Auth::id();
//            if ($tgObj->save())
//            {
//                return json_encode(['success' => true, ['msg' => trans('tools.savedSuccessFully')]]);
//            }
//            else
//            {
//                return json_encode(['success' => false]);
//            }
//        }
//    }
//
//    public function groupUserList()
//    {
//        $list = DB::table('hamahang_access_tools_group_user as gu')
//            ->select('gu.id', 'gu.id as index', 'gu.user_id', 'gu.group_id', DB::raw("CONCAT(user.name,' ',user.family ) AS user_name"), 'tg.name as group_name')
//            ->join('user', 'user.id', 'gu.user_id')
//            ->join('hamahang_tools_groups as tg', 'tg.id', 'gu.group_id')
//            ->get();
//        return Datatables::of($list)->make(true);
//    }
//
//    public function editUser()
//    {
//        $user = DB::table('hamahang_access_tools_group_user as gu')
//            ->select('gu.id', 'gu.user_id', 'gu.group_id', DB::raw("CONCAT(user.name,' ',user.family ) AS user_name"))
//            ->join('user', 'user.id', 'gu.user_id')
//            ->where('gu.id', '=', Request::input('id'))->first();
//        return json_encode($user);
//    }
//
//    public function deleteUser()
//    {  // DB::enableQueryLog();
//        $deleted = ToolsGroupUser::where('id', '=', Request::input('id'))->delete();
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
}
