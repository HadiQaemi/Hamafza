<?php

if (!function_exists('buildMenuTree'))
{
    /**
     * @param $flat_array
     * @param $pidKey
     * @param $current_url
     * @param $item
     * @param int $parent
     * @param string $idKey
     * @param string $children_key
     * @return mixed
     */
    function buildMenuTree($flat_array, $pidKey, $item = false, $current_url = '/', $parent = 0, $idKey = 'id', $children_key = 'children')
    {
        $grouped = array();
        foreach ($flat_array as $sub)
        {
            $sub['text'] = $sub['title'];
            if ($sub['href'] != '' && $sub['href_type'] == 0)
            {
                $sub['a_attr']['href'] = $sub['href'];
            }
            else
            {
                if ($sub['href'] != '' && $sub['href_type'] == 1 && Auth::check())
                {
                    $sub['href'] = str_replace('[username]', Auth::user()->Uname, $sub['href']);
                    if ($item)
                    {
                        $sub['href'] = str_replace('[subject_id]', $item, $sub['href']);
                        $sub['href'] = str_replace('[page_id]', $item, $sub['href']);
                    }
                    $sub['a_attr']['href'] = url($sub['href']);
                }
                else
                {
                    $route_var = json_decode($sub['route_variable']);
                    /* @FixedMe change username var to current login user */
                    if ($route_var != null)
                    {
                        $result_route_var = array();
                        foreach ($route_var as $rk => $rv)
                        {
                            //$rv =json_decode($rv);
                            if (isset($rv->username) || empty($rv->username))
                            {
                                $result_route_var[$rk] = Auth::user()->Uname;
                            }
                        }

                        $sub['a_attr']['href'] = route($sub['route_name'], $result_route_var);
                    }
                    else
                    {
                        $sub['a_attr']['href'] = $sub['href'];
                    }
                }
            }
            if ($current_url == $sub['a_attr']['href'])
            {
                //var_dump($sub['href']);
                $sub['state']['opened'] = true;
                $sub['state']['selected'] = true;
            }
            $menu_item = \App\Models\Hamahang\Menus\MenuItem::find($sub['id']);
            $policyObj = new \App\Policies\MenuPolicy();
            if (Auth::check())
            {
                $user = Auth::user();
            }
            else
            {
                $user = new \App\User();
            }

            $access = $policyObj->canView($user, $menu_item);

            if ($access)
            {
                $grouped[$sub[$pidKey]][] = $sub;
            }
        }
        $fnBuilder = function ($siblings) use (&$fnBuilder, $grouped, $idKey, $children_key)
        {
            $siblings = sort_arr($siblings);
            foreach ($siblings as $k => $sibling)
            {
                $id = $sibling[$idKey];
                if (isset($grouped[$id]))
                {
                    $sibling[$children_key] = $fnBuilder($grouped[$id]);
                }
                $siblings[$k] = $sibling;
            }
            return $siblings;
        };
        if (isset($grouped[$parent]))
        {
            $tree = $fnBuilder($grouped[$parent]);
        }
        else
        {
            $tree = [];
        }
        return $tree;
    }

}
if (!function_exists('menuGenerator'))
{
    /**
     * @param $menu_type_id int
     * @param $subject_id int
     * @param $option String
     * @return $this
     */
    function menuGenerator($menu_type_id, $type, $subject_id = false)
    {
        switch ($type)
        {
            case 'tree';
                $uname = auth()->user();
                return view('hamahang.Menus.helper.treemenu')
                    ->with('uname', $uname)
                    ->with('type_id', $menu_type_id)
                    ->with('subject_id', $subject_id);
                break;
            case 'horizontal':
                $menuObj = \App\Models\Hamahang\Menus\Menus::find($menu_type_id);
                $menus = $menuObj->items()->where('status', '1')->get();
                return view('hamahang.Menus.helper.horizental_menu')->with('menus', $menus);
                break;
            case 'footer':
                $menuObj = \App\Models\Hamahang\Menus\Menus::find($menu_type_id);
                if ($menuObj)
                {
                    $menus = $menuObj->items()->where('status', '1')->get();
                }
                else
                {
                    $menus = false;
                }
                return view('hamahang.Menus.helper.menu_horizental_footer')->with('menus', $menus);
                break;
        }
    }
}
if (!function_exists('toolsGenerator'))
{
    /**
     * @param $options array
     * @param $option array
     * @param $position int
     * @param $relation int
     * @return $this
     */
    function toolsGenerator($options, $position, $relation = 4, $option = ['subject_id' => '[subject_id]', 'page_id' => '[page_id]'])
    {
        $option_ids = [];
        $needed_variables = [];
        foreach ($options as $key_option => $value_opt)
        {
            $option_ids[] = $key_option;
            $needed_variables = array_merge($needed_variables, $value_opt);
        }
        $i = 0;
        $more_nv = '';
        $get_url_str = '?';
        foreach ($needed_variables as $nv_key => $nv_value)
        {
            if ($i > 0)
            {
                $more_nv = '&';
            }
            $get_url_str .= $more_nv . $nv_key . '=' . $nv_value;
            $i++;
        }
        $groups = \App\Models\Hamahang\Tools\ToolsGroup::where('visible', '=', "1")
            ->with(
                [
                    'tools' => function ($query) use ($option_ids)
                    {
                        $query->whereHas('options', function ($query) use ($option_ids)
                        {
                            $query->whereIn('hamahang_options.id', $option_ids);
                        })->where('visible', "1");
                    },
                    'tools.options' => function ($query) use ($option_ids)
                    {
                        $query->whereIn('hamahang_options.id', $option_ids);
                    }
                ])
            ->whereHas('tools', function ($query) use ($position)
            {
                $query->whereHas('positions', function ($query) use ($position)
                {
                    $query->where('hamahang_template_positions.id', '=', $position);
                })->where('visible', "1");
            })
            ->get();
        return view('hamahang.Tools.helper.tools_generator')
            ->with('groups', $groups)
            ->with('get_url_str', $get_url_str)
            ->with('option', $option);
    }
}
if (!function_exists('policy_CanView'))
{
    /**
     * @param $options array
     * @param $option array
     * @param $position int
     * @param $relation int
     * @return $this
     */
    function policy_CanView($id = '', $Model, $ModelPolicy, $PolicyMethod = 'canView', $abort = false)
    {
        //dd($Model,$ModelPolicy,$PolicyMethod);
        $item = '';
        if ($id != '')
        {
            $item = $Model::find($id);
        }

        $ResModelPolicy = new $ModelPolicy();
        // $policyObj = new $addr_policy;
        if (Auth::check())
        {
            $user = Auth::user();
        }
        else
        {
            $user = new \App\User();
        }

        $access = $ResModelPolicy->$PolicyMethod($user, $item);

        if (!$access && $abort)
        {
            abort($abort);
        }

        return $access;
    }
}

if (!function_exists('getShortToolDetail'))
{
    /**
     * @param $type int 1:subject ,2:user
     * @param $id int
     * @return $this
     */
    function getShortToolDetail($type = 0, $id = 0)
    {
        switch ($type)
        {
            case 'Page':
                $pageDet = DB::table('subject_member')
                    ->select('id', 'relation', 'follow', 'like')
                    ->where('uid', \Auth::id())
                    ->where('sid', $id)
                    ->first();
                break;
            case 'User':
            {
                $pageDet = DB::table('user_friend')
                    ->select('id', 'relation', 'follow', 'like')
                    ->where('uid', \Auth::id())
                    ->where('fid', $id)
                    ->first();
                break;
            }
            case 'Group':
            {
                $pageDet = DB::table('user_group_member')
                    ->select('id', 'relation', 'follow', 'like')
                    ->where('uid', \Auth::id())
                    ->where('gid', $id)
                    ->first();
            }
        }
        $res = array();
        if ($pageDet)
        {
            $res['like'] = $pageDet->like;
            $res['follow'] = $pageDet->follow;
            $res['relation'] = $pageDet->relation;
        }
        else
        {
            $res['like'] = '0';
            $res['follow'] = 0;
            $res['relation'] = 0;
        }
        return $res;
    }

}
if (!function_exists('shortToolsGenerator'))
{
    /**
     * @param $type  string page|user
     * @param $id int
     * @param $params array
     * @param $help int page_help_id
     * @return $this
     */
    function shortToolsGenerator($type, $id, $params, $help = 0)
    {
        $return = getShortToolDetail($type, $id);
        // dd($type,$id,$params,$help);
        return view('hamahang.Tools.helper.short_tools_generator')
            ->with('vals', $return)
            ->with('params', $params)
            ->with('help', $help)
            ->with('type', $type)
            ->with('id', $id);
    }

}

if (!function_exists('set_item_order'))
{

    function set_item_order($model, $id, $order_step, $type, $value, $parent_id = null, $order_column_name = 'order')
    {
//        $table_name = with(new $model)->getTable();
//        $exist_parent_column = (Schema::hasColumn($table_name, $parent_id));

        $item = $model::findOrFail(deCode($id));
        if ($type == 'up')
        {
            if ($order_step == 'asc')
            {
                if ($parent_id)
                {
                    $up_item = $model::where("$order_column_name", '<', $item->$order_column_name)->where('parent_id', $item->parent_id)->orderBy("$order_column_name", 'desc')->first();
                }
                else
                {
                    $up_item = $model::where("$order_column_name", '<', $item->$order_column_name)->orderBy("$order_column_name", 'desc')->first();
                }

                if ($up_item)
                {
                    $up_item_order = $up_item->$order_column_name;
                    $up_item->$order_column_name = $item->$order_column_name;
                    $up_item->save();
                    $item->$order_column_name = $up_item_order;
                    $item->save();
                }
            }
            else
            {
                if ($parent_id)
                {
                    $up_item = $model::where("$order_column_name", '>', $item->$order_column_name)->where('parent_id', $item->parent_id)->orderBy("$order_column_name", 'desc')->first();
                }
                else
                {
                    $up_item = $model::where("$order_column_name", '>', $item->$order_column_name)->orderBy("$order_column_name", 'desc')->first();
                }

                if ($up_item)
                {
                    $up_item_order = $up_item->$order_column_name;
                    $up_item->$order_column_name = $item->$order_column_name;
                    $up_item->save();
                    $item->$order_column_name = $up_item_order;
                    $item->save();
                }
            }
        }
        elseif ($type == 'down')
        {
            if ($order_step == 'asc')
            {
                if ($parent_id)
                {
                    $up_item = $model::where("$order_column_name", '>', $item->$order_column_name)->where('parent_id', $item->parent_id)->orderBy("$order_column_name", 'asc')->first();
                }
                else
                {
                    $up_item = $model::where("$order_column_name", '>', $item->$order_column_name)->orderBy("$order_column_name", 'asc')->first();
                }

                if ($up_item)
                {
                    $up_item_order = $up_item->$order_column_name;
                    $up_item->$order_column_name = $item->$order_column_name;
                    $up_item->save();
                    $item->$order_column_name = $up_item_order;
                    $item->save();
                }
            }
            else
            {
                if ($parent_id)
                {
                    $up_item = $model::where("$order_column_name", '<', $item->$order_column_name)->where('parent_id', $item->parent_id)->orderBy("$order_column_name", 'asc')->first();
                }
                else
                {
                    $up_item = $model::where("$order_column_name", '<', $item->$order_column_name)->orderBy("$order_column_name", 'asc')->first();
                }

                if ($up_item)
                {
                    $up_item_order = $up_item->$order_column_name;
                    $up_item->$order_column_name = $item->$order_column_name;
                    $up_item->save();
                    $item->$order_column_name = $up_item_order;
                    $item->save();
                }
            }
        }
        elseif ($type == 'save')
        {
            if ($parent_id)
            {
                $old_items = $model::where('parent_id', $item->parent_id)->where("$order_column_name", '>=', $value)->get();
            }
            else
            {
                $old_items = $model::where("$order_column_name", '>=', $value)->get();
            }

            foreach ($old_items as $old_item)
            {
                $old_item->$order_column_name += 1;
                $old_item->save();
            }
            $item->$order_column_name = $value;
            $item->save();
        }
        orderItem($model, isset($item->parent_id) ? $item->parent_id : null, false, false, $order_column_name);
    }
}
if (!function_exists('orderItem'))
{
    function orderItem($model, $parent_id = null, $cat_culomn_name = false, $cat_id = false, $order_column_name = 'order')
    {
        if (isset($parent_id))
        {
            $items = $model::where('parent_id', $parent_id)->where('parent_id', $parent_id);
        }
        else
        {
            $items = $model::query();
        }
        if ($cat_culomn_name)
        {
            $items = $items->where("$cat_culomn_name", $cat_id);
        }
        $items = $items->orderBy("$order_column_name", 'asc')->get();

        $i = 0;
        foreach ($items as $item)
        {
            $item->$order_column_name = ++$i;
            $item->save();
        }
    }
}
//----------------End-------------- Menu And Tools -------------------End---------------//