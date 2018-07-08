<?php

namespace App\Http\Controllers\Hamahang;

use App\Models\Hamahang\Menus\MenuItem;
use App\Role;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Models\Hamahang\Menus\Menus;
use Illuminate\Http\Request;
use App\Models\ValueGroup;
use App\UserPolicy;
use Datatables;
use Validator;

class MenusController extends Controller
{
    //----- Functions ----------------------------------------------------------

    private function available_routes_by_route()
    {
        $result = '';
        $routeList = Route::getRoutes();
        $i = 0;
        foreach ($routeList as $route)
        {
            if (isset($route->action['menu']) && isset($route->action['route_title']))
            {
//                dd($route->action);
                $matches = array();
                preg_match_all('/\{(.*?)\}/', $route->uri, $matches);
                $variables = $matches[1];

                if ($route->action['namespace'] == 'App\Http\Controllers\frontend')
                {
                    $result['frontend'][$i] = [
                        'route_name' => $route->action['as'],
                        'route_title' => $route->action['route_title'],
                        'variables' => $variables
                    ];
                }
                if ($route->action['namespace'] == 'App\Http\Controllers\backend')
                {
                    $result['backend'][$i] = [
                        'route_name' => 'backend/' . $route->action['as'],
                        'route_title' => $route->action['route_title'],
                        'variables' => $variables
                    ];
                }

                $i++;
            }
        }
//        dd($result);
        return $result;
    }

    private function getRoutes()
    {
        $routes = ValueGroup::where('value_id', 4)
            ->get(['name', 'value', 'default']);

        $res = '';
        foreach ($routes as $route)
        {
            if (isset($route->variables))
            {
                foreach ($route->variables as $k => $v)
                {
                    if ($v->required)
                    {
                        switch ($v->input_type)
                        {
                            case "select":
                                if (!$v->dependent)
                                {
                                    if ($v->data->type == 'array')
                                    {
                                        $res = '';
                                    }
                                    elseif ($v->data->type == 'model')
                                    {
                                        $model = new $v->data->model;
                                        $query = $model::select($v->data->value . " as id", $v->data->column_title . " as text")
                                            ->groupBy($v->data->group_by);
                                        if ($v->data->distinct)
                                        {
                                            $res = $query->distinct()->get();
                                        }
                                        else
                                        {
                                            $res = $query->get();
                                        }

                                    }
                                }
                                else
                                {
                                    $dependent = $v->data->dependant;
                                    if ($route->variables->$dependent->data->type == 'model')
                                    {

                                    }
                                    elseif ($route->variables->$dependent->data->type == 'array')
                                    {

                                    }
                                    $model = new $v->data->model;
                                    $query = $model::select($v->data->value . " as id", $v->data->column_title . " as text")
                                        ->groupBy($v->data->group_by);
                                    if ($v->data->distinct)
                                    {
                                        $res = $query->distinct()->get();
                                    }
                                    else
                                    {
                                        $res = $query->get();
                                    }
                                }
                                break;
                        }
                    }
                }
            }
        }

        dd($res);
    }

    private function available_routes_by_db()
    {
        $routes = MenuItem::all();
        $i = 0;
        foreach ($routes as $route)
        {
            if ($route->menu_id == 1)
            {
                $result['backend'][$i] = [
                    'route_name' => $route->route_name,
                    'route_title' => $route->title,
                    'variables' => $route->variables
                ];
            }
            if ($route->menu_id == 2)
            {
                $result['frontend'][$i] = [
                    'route_name' => $route->route_name,
                    'route_title' => $route->title,
                    'variables' => $route->variables
                ];
            }
            $i++;
        }
//        dd($result);
        return $result;
    }

    //----- Menus ----------------------------------------------------------

    public function index($username)
    {
        $arr = variable_generator('user', 'desktop', $username);
        $arr['username'] = $username;
        return view('hamahang.Menus.menu', $arr);
    }

    public function getMenus()
    {
        $menus = Menus::all();

        return Datatables::of($menus)
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->addColumn('edit_access', function ($data)
            {
                $user = auth()->user();
                return $user->can(['posts.hamahang.menus.update_menu']);
            })
            ->addColumn('delete_access', function ($data)
            {
                $user = auth()->user();
                return $user->can(['posts.hamahang.menus.destroy_menu']);
            })
            ->addColumn('get_menu_items', function ($data)
            {
                $user = auth()->user();
                return $user->can(['posts.hamahang.menus.get_menu_items']);
            })
            ->make(true);
    }

    public function storeMenu(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
            if($request->item_id)
            {
                $menu = Menus::find(($request->input('item_id')));
                $menu->uid = auth()->id();
                $menu->title = $request->input('title');
                $menu->description = $request->input('description');
                $menu->save();
            }
            else
            {
                $menu = new Menus();
                $menu->uid = auth()->id();
                $menu->title = $request->input('title');
                $menu->description = $request->input('description');
                $menu->save();

            }

            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function getMenu(Request $request)
    {
        $item = Menus::findOrFail(deCode($request->input('id')))->toArray();
        $item['id'] = enCode($item['id']);
        return json_encode($item);
    }

    public function updateMenu(Request $request)
    {
        $validator = Validator::make($request->all(), [

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
            $menu = Menus::find(deCode($request->input('item_id')));
            $menu->uid = auth()->id();
            $menu->title = $request->input('title');
            $menu->description = $request->input('description');
            $menu->save();
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }

    }

    public function destroyMenu(Request $request)
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
            $item_id = deCode($request->input('item_id'));
            Menus::destroy($item_id);
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    //----- Menu_Items ----------------------------------------------------------

    //Load menu items page(MenuItems index)
    public function items($username, $menu_id)
    {
        $arr = variable_generator('user', 'desktop', $username);
        $arr['username'] = $username;
        $menu = Menus::where('id', deCode($menu_id))->get(['id', 'title'])->first();
        $roles = Role::all();
        $menu_items = MenuItem::where('menu_id', decode($menu_id))->get(['id', 'title', 'menu_id']);
        foreach ($menu_items as $item)
        {
            $item->menu_id = enCode($item->id);
        }
        $menu = json_decode(json_encode($menu));
        $menu->id = enCode($menu->id);
        return view('hamahang.Menus.menu_items', $arr)
            ->with('menu_items', $menu_items)
            ->with('menu', $menu)
            ->with('available_routes', $this->available_routes_by_db())
            ->with('roles', $roles);
    }

    public function getMenuItems(Request $request)
    {
        switch ($request->input('parent_id'))
        {
            case '-1':
                $submenus = MenuItem::where('menu_id', deCode($request->input('menu_id')))
                    ->with('parent')
                    ->with('user');
                break;
            case '0':
                $submenus = MenuItem::where('menu_id', deCode($request->input('menu_id')))
                    ->where('parent_id', 0)
                    ->with('parent')
                    ->with('user');
                break;
            default:
                $submenus = MenuItem::where('menu_id', deCode($request->input('menu_id')))
                    ->where('parent_id', $request->input('parent_id'))
                    ->with('parent')
                    ->with('user');
        }

        return Datatables::eloquent($submenus)
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->addColumn('edit_access', function ($data)
            {
                $user = auth()->user();
                return $user->can(['posts.hamahang.menus.update_menu_item']);
            })
            ->addColumn('delete_access', function ($data)
            {
                $user = auth()->user();
                return $user->can(['posts.hamahang.menus.destroy_menu_item']);
            })
            ->addColumn('permitted_users', function ($data)
            {
                return $data->permitted_users;
            })
            ->addColumn('permitted_roles', function ($data)
            {
                return $data->permitted_roles;
            })
            ->make(true);
    }

    public function storeMenuItem(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'link_address' => 'required',
            'title' => 'required',
        ], [

        ],[
            'link_address' => 'آدرس لینک',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if($request->item_id){
//                dd($request->all());
                $menu_item = MenuItem::where('id', $request->input('item_id'))
                    ->where('menu_id', deCode($request->input('menu_id')))
                    ->first();
                $menu_item->menu_id = decode($request->input('menu_id'));
                $menu_item->parent_id = $request->input('parent');
                $menu_item->title = $request->input('title');
                $menu_item->description = $request->input('description');
                $menu_item->href_type = $request->input('link_type') == 0 ? '0' : '1';
                $menu_item->href = $request->input('link_address');
                $menu_item->status = $request->input('status') == 'on' ? '1' : '0';
                $menu_item->icon = $request->input('icon');
                $menu_item->target = $request->input('target');
                $menu_item->save();
                if ($request->users_list)
                {
                    $menu_item->user_policy()->sync($request->users_list);
                }
                else
                {
                    $menu_item->user_policy()->sync([]);
                }

                if ($request->roles_list)
                {
                    $menu_item->role_policy()->sync($request->roles_list);
                }
                else
                {
                    $menu_item->role_policy()->sync([]);
                }

                $result['message'][] = trans('app.operation_is_success');
                $result['success'] = true;
                return json_encode($result);
            }else{
                $item = new MenuItem();
//            $item->uid = auth()->id();
                $item->menu_id = decode($request->input('menu_id'));
                $item->parent_id = $request->input('parent');
                $item->title = $request->input('title');
                $item->description = $request->input('description');
                $item->href_type = $request->input('link_type') == 0 ? '0' : '1';
                $item->href = $request->input('link_address');
                $item->target = $request->input('target');
                $item->status = $request->input('status') == 'on' ? '1' : '0';
                $item->icon = $request->input('icon');
                $item->save();

                if ($request->users_list)
                {
                    $item->user_policy()->sync($request->users_list);
                }
                else
                {
                    $item->user_policy()->sync([]);
                }

                if ($request->roles_list)
                {
                    $item->role_policy()->sync($request->roles_list);
                }
                else
                {
                    $item->role_policy()->sync([]);
                }

                $result['message'][] = trans('app.operation_is_success');
                $result['success'] = true;
                return json_encode($result);
            }
        }
    }

    public function updateMenuItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'link_address' => 'required',
        ], [

        ],[
            'link_address' => 'آدرس لینک',
        ]);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $menu_item = MenuItem::where('id', deCode($request->input('item_id')))
                ->where('menu_id', deCode($request->input('menu_id')))
                ->first();
            $menu_item->menu_id = decode($request->input('menu_id'));
            $menu_item->parent_id = $request->input('parent');
            $menu_item->title = $request->input('title');
            $menu_item->description = $request->input('description');
            $menu_item->href_type = $request->input('link_type') == 0 ? '0' : '1';
            $menu_item->href = $request->input('link_address');
            $menu_item->status = $request->input('status') == 'on' ? '1' : '0';
            $menu_item->icon = $request->input('icon');
            $menu_item->target = $request->input('target');
            $menu_item->save();
            if ($request->users_list)
            {
                $menu_item->user_policy()->sync($request->users_list);
            }
            else
            {
                $menu_item->user_policy()->sync([]);
            }

            if ($request->roles_list)
            {
                $menu_item->role_policy()->sync($request->roles_list);
            }
            else
            {
                $menu_item->role_policy()->sync([]);
            }

            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function setStatus(Request $request)
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
            $item = MenuItem::find($id);
            if ($item->status)
            {
                $item->status = '0';
            }
            else
            {
                $item->status = '1';
            }
            $item->save();
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function destroyMenuItem(Request $request)
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
            $item_id = deCode($request->input('item_id'));
            MenuItem::destroy($item_id);
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function setMenuPermissions(Request $request)
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
            $menu_item = MenuItem::find(deCode($request->item_id));
            if ($request->users_list)
            {
                $menu_item->user_policy()->sync($request->users_list);
            }
            else
            {
                $menu_item->user_policy()->sync([]);
            }

            if ($request->roles_list)
            {
                $menu_item->role_policy()->sync($request->roles_list);
            }
            else
            {
                $menu_item->role_policy()->sync([]);
            }


            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }

    }

    public function getMenuPermissions(Request $request)
    {
//        dd($request->all());
        $res = [];
        $menu_item = MenuItem::find(deCode($request->item_id));
        $res['user_policy'] = $menu_item->user_policy;
        $res['role_policy'] = $menu_item->role_policy;
        return json_encode($res);

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
            set_item_order('App\Models\Hamahang\Menus\MenuItem',
                $request->input('id'),
                $request->input('order_step'),
                $request->input('type'),
                $request->input('value'), 1);

            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function menusList($menutype = 1, $subject_id = false)
    {

        $treeMenu = \Session::get('treeMenu');
        if(!is_array($treeMenu) || count($treeMenu)==0)
        {
            $menuObj = Menus::with('items')->find($menutype);
            $menus = $menuObj->items()->where('status', '1')->get()->toArray();
            $treeMenu = buildMenuTree($menus, 'parent_id', $subject_id, \Request::input('current_url'));
            \Session::put('treeMenu',$treeMenu);
        }else{
            $treeMenu = $treeMenu;
        }


        return \Response::json($treeMenu);
    }

    public function getMenuNodes(Request $request)
    {
        $option = 'tree'; //Request::input('option');
        $type_id = $request->input('type_id');
        switch ($option)
        {
            case 'tree':
                {
                    if ($request->exists('subject_id'))
                    {
                        return $this->menusList($type_id, $request->input('subject_id'));
                    }
                    return $this->menusList($type_id);
                    break;
                }
        }
    }

    public function readMenuItem(Request $request)
    {

    }
}
