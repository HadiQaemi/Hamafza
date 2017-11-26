<?php

namespace App\Http\Controllers\Hamahang;

use DB;

use Request;
use Validator;
use App\User;
use App\Http\Controllers\Controller;
use App\Models\Hamahang\OrgChart\org_organs;
use App\Models\Hamahang\OrgChart\org_charts;
use App\Models\Hamahang\OrgChart\org_chart_items;
use App\Models\Hamahang\OrgChart\org_charts_items_posts;

class OrgChartController extends Controller
{
    private function check_posts($array)
    {
        $arr = [];
        $ps = org_posts::where('parent_unit_id', $array['id'])->get();
        //exit(var_dump($ps));
        //echo '\n';
        if (sizeof($ps) > 0)
        {
            foreach ($ps as $p)
            {
//				//array_push($arr, ['title' => $p['title'], 'id' => $p['id'], 'node_type' =
                $arr['title'] = $p['title'];
                $arr['node_type'] = 1;
                $arr['id'] = $p['id'];
                //array_push($arr, ['title' => 'sss', 'id' => 'ssssss', 'node_type' => 'cdcdc']);
            }
        }
        var_dump($arr);
        echo "*$%$$$\n";

        if (isset($array['nodes']))
        {

            foreach ($array['nodes'] as $n)
                if ($n['node_type'] == 0)
                {
                    //echo $n['id']."***";
                    $this->check_posts($n);
                }
            $array['nodes'] += $arr;
        }
        else
        {
            $array['nodes'] = $arr;
        }
    }
    private function buildTree($flat_array, $pidKey, $parent = 0, $idKey = 'id', $children_key = 'children')
    {
        $grouped = array();
        foreach ($flat_array as $sub)
        {
            $grouped[$sub[$pidKey]][] = $sub;
        }

        $fnBuilder = function ($siblings) use (&$fnBuilder, $grouped, $idKey, $children_key)
        {
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

        $tree = $fnBuilder($grouped[$parent]);
        return $tree;
    }

    public function OrgOrgansList($username)
    {
        $arr = variable_generator('user','desktop',$username);
        $arr['Uname'] = $username;
        $arr['UName'] = $username;
        return view('hamahang.OrgChart.OrgOrgansList', $arr);
    }
    public function OrgChartList($UName, $OrgID)
    {
        org_organs::findOrFail($OrgID);
        $arr = user_page_variable_generator($UName);
        $arr['OrgID'] = $OrgID;
        return view('hamahang.OrgChart.OrgChartsList', $arr);
    }
    public function AjaxOrgOrgans()
    {
        $data = DB::table('hamahang_org_organs AS organs')
            ->leftJoin('user', 'user.id', '=', 'organs.uid')
            ->leftJoin('hamahang_org_organs AS ParentOrg', 'ParentOrg.id', '=', 'organs.parent_id')
            ->select(
                'user.Uname AS CreatorUserName',
                'user.Name AS CreatorName',
                'user.Family AS CreatorFamily',
                'ParentOrg.title AS ParentTitle',
                'organs.*'
            )->whereNull('organs.deleted_at')
            ->get();
        //return DB::getQueryLog();
        $data = collect($data)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $result['data'] = $data;
        return json_encode($result);
    }

    public function CreateOrgan()
    {
        $validator = Validator::make(Request::all(), [
            'organ_title' => 'required',
            'organ_parent_id' => 'required'
        ]);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $org = new org_organs;
            $org->uid = Auth::id();
            $org->parent_id = Request::input('organ_parent_id');
            $org->title = Request::input('organ_title');
            $org->description = Request::input('organ_description');
            $org->save();

            $result['org_id'] = $org->id;
            $result['success'] = true;
            return json_encode($result);
        }
    }
    public function UpdateOrgan()
    {
        $validator = Validator::make(Request::all(), [
            'organ_id' => 'required',
            'organ_title' => 'required'
        ]);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {

            $org = org_organs::find(Request::input('organ_id'));
            $org->uid = Auth::id();
            $org->parent_id = Request::input('organ_parent_id');
            $org->title = Request::input('organ_title');
            $org->description = Request::input('organ_description');
            $org->save();

            $result['org_id'] = $org->id;
            $result['success'] = true;
            return json_encode($result);
        }
    }
    public function RemoveOrgan()
    {
        DB::table('hamahang_org_organs')
            ->where('id', Request::input('id'))
            ->update(['deleted_at' => 1]);
        return json_encode('1');
    }

    public function AjaxOrgCharts($OrgID)
    {
        $data = DB::table('hamahang_org_charts AS Charts')
            ->leftJoin('user', 'user.id', '=', 'Charts.uid')
            ->leftJoin('hamahang_org_organs AS Organs', 'Organs.id', '=', 'Charts.org_organs_id')
            ->where('Charts.org_organs_id', '=', $OrgID)
            ->select
            (
                'user.Uname AS CreatorUserName',
                'user.Name AS CreatorName',
                'user.Family AS CreatorFamily',
                'Charts.*'
            )
            ->get();
        $data = collect($data)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $result['data'] = $data;
        //dd(json_encode($result));
       return $result;
        //return $result;
    }
    public function AjaxOrgChartDataShow()
    {

        $validator = Validator::make(Request::all(),
            [
                'id' => 'required|exists:hamahang_org_charts_items,chart_id|exists:hamahang_org_charts,id',
            ]
        );
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            //org_charts::findOrFail(Request::input('id'));
            $Items = DB::table('hamahang_org_charts_items')
                ->where('chart_id', '=', Request::input('id'))
                ->whereNull('deleted_at')
                ->select('parent_id', 'title AS name', 'description AS title', 'id')
                ->get();

            $Items = collect($Items)->map(function ($x)
            {
                return (array)$x;
            })->toArray();
            $tree = buildTree($Items, 'parent_id');

            return $tree;
        }

    }
     public function OrgChartShow($username,$chart_id)
     {
     /* $validator = Validator::make([$username,$chart_id],
           [
             'chart_id'=>'required'
           ],
           [],
           [
               'new_item_title' => 'عنوان ',
               'new_item_title' => 'عنوان ',
           ]
       );
       if ($validator->fails())
       {

           $result['error'] = $validator->errors();
           $result['success'] = false;
           return json_encode($result);
       }
       else
       {*/
           $Chart = org_charts::findOrFail($chart_id);
           $arr = variable_generator('user', 'desktop', $username);
           $arr['chart_id'] = $chart_id;
           $arr['Chart'] = $Chart;
           $arr['UName'] = $username;
           return view('hamahang.OrgChart.OrgChartShow', $arr);
       //}


   }

    public function ModifyChartInfo()
    {
        $chart = org_charts::findOrFail(Request::input('cid'));
        $chart->title = Request::input('nTitle');
        $chart->description = Request::input('nDesc');
        $chart->save();
        return json_encode('ok');
    }
    public function AddNewChart()
    {
        $chart = new org_charts;
        $chart->org_organs_id = Request::input('oid');
        $chart->title = Request::input('title');
        $chart->description = Request::input('desc');
        $chart->uid = auth()->id();
        $chart->save();
        return json_encode('1');
    }
    public function item_info()
    {
        $arr = [];
        $posts = DB::table('hamahang_org_charts_items_posts')
            ->whereNull('deleted_at')
            ->where('hamahang_org_charts_items_posts.chart_item_id', '=', Request::input('id'))
            ->get();
        foreach ($posts as $post)
        {
            if ($post->user_id == '')
            {
                $post->user_id = 'no';
            }
            else
            {
                $user = User::where('id', $post->user_id)->first();
                $post->user_info = $user;
            }
        }
        //die(var_dump($post));
        $arr[0] = $posts;
        $org_name = DB::table('hamahang_org_charts_items')
            ->join('hamahang_org_charts', 'hamahang_org_charts_items.chart_id', '=', 'hamahang_org_charts.id')
            ->join('hamahang_org_organs', 'hamahang_org_organs.id', '=', 'hamahang_org_charts.org_organs_id')
            ->where('hamahang_org_charts_items.id', Request::input('id'))
            ->whereNull('hamahang_org_charts_items.deleted_at')
            ->select('hamahang_org_charts_items.id AS item_id', 'hamahang_org_charts_items.title', 'hamahang_org_charts_items.description', 'hamahang_org_organs.title as org_title', 'hamahang_org_charts.id as chart_id', 'hamahang_org_charts.title as ch_title', 'hamahang_org_charts_items.parent_id as parent')
            ->first();
        //die(var_dump($org_name));
        $arr[1]['chart_id'] = $org_name->chart_id;
        $arr[1]['item_id'] = $org_name->item_id;
        $arr[1]['item_title'] = $org_name->title;
        $arr[1]['item_description'] = $org_name->description;

        $arr[1]['org_title'] = $org_name->org_title;
        $arr[1]['chart_title'] = $org_name->ch_title;
        if ($org_name->parent != 0)
        {
            $item_parent_name = org_chart_items::where('id', $org_name->parent)->get();
            //die(var_dump($item_parent_name));
            $arr[1]['parent_id'] = $item_parent_name[0]->id;
            $arr[1]['parent_title'] = $item_parent_name[0]->title;
        }
        else
        {
            $arr[1]['parent_id'] = 0;
        }
        $item_posts_count = org_charts_items_posts::where('chart_item_id', '=', Request::input('id'))->count();
        $arr[1]['post_count'] = $item_posts_count;
        $item_free_posts_count = org_charts_items_posts::where('chart_item_id', '=', Request::input('id'))
            ->where('user_id', '>', 0)->count();
        $arr[1]['free_post_count'] = $item_posts_count - $item_free_posts_count;
        $item_items = org_chart_items::where('parent_id', Request::input('id'))->get();

        foreach ($item_items as $q)
        {
            $c = org_chart_items::where('parent_id', $q->id)->count();
            $q->item_childs_count = $c;
        }

        $arr[1]['item_items'] = $item_items;

        $Chart_Items = DB::table('hamahang_org_charts_items')
            //->join('user', 'user.id', '=', 'org_charts_items.id')
            ->where('chart_id', '=', 1)
            ->whereNull('deleted_at')
            ->select('hamahang_org_charts_items.parent_id', 'hamahang_org_charts_items.title AS name', 'hamahang_org_charts_items.description AS title', 'hamahang_org_charts_items.id')
            ->get();

        $Chart_Items = collect($Chart_Items)->map(function ($x)
        {
            return (array)$x;
        })->toArray();

        $Chart_Items_tree = buildTree($Chart_Items, 'parent_id');
        $arr[1]['item_items_ch'] = json_encode($Chart_Items_tree);
        return $arr;
    }
    public function SubmitChange()
    {
        (int)$id = Request::get('draggedNode');
        (int)$patent_id = Request::get('dropZone');

        $target_item = org_chart_items::findOrFail($patent_id);
        $parent = $target_item->parent_id;

        $parents = array();
        while ($parent !== 0)
        {
            $parents[] = $parent;
            $target_item = org_chart_items::findOrFail($parent);
            $parent = $target_item->parent_id;
        };

        if (!in_array($id, $parents))
        {
            $item = org_chart_items::findOrFail($id)->update(['parent_id' => $patent_id]);
            $result[] = $item;
        }
        else
        {
            $result[] = False;
        }

        return json_encode($result);
    }
    public function add_new_node()
    {
        $validator = Validator::make(Request::all(), [
            'chart_id' => 'required',
            'item_id' => 'required',
            'new_item_title' => 'required',
            'new_item_description' => 'required',
        ]);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $node = new org_chart_items;
            $node->uid = Auth::id();
            $node->chart_id = Request::input('chart_id');
            $node->parent_id = Request::input('item_id');
            $node->title = Request::input('new_item_title');
            $node->description = Request::input('new_item_description');
            $node->save();

            $result['item_id'] = Request::input('item_id');
            $result['success'] = true;
            return json_encode($result);
        }

    }
    public function create_new_chart_item()
    {
        $request = new Request;
        $item = new org_chart_items;
        $item->uid = Auth::id();
        $item->chart_id = $request->get('chart_id');
        $item->parent_id = $request->get('parent_id');
        $item->title = $request->get('title');
        $item->description = $request->get('description');
        $item->save();
    }
    public function AddRootChartItem()
    {
        $validator = Validator::make(Request::all(), [
            'root_item_title' => 'required',
            'root_item_description' => 'required',
            'Organs_ID' => 'required',
            'Charts_ID' => 'required'
        ]);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $Charts_ID = Request::input('Charts_ID');
            $current_root = org_chart_items::where('chart_id', '=', $Charts_ID)->where('parent_id', '=', 0)->first();

            $node = new org_chart_items;
            $node->uid = auth()->id();
            $node->chart_id = $Charts_ID;
            $node->parent_id = 0;
            $node->title = Request::input('root_item_title');
            $node->description = Request::input('root_item_description');
            $node->save();

            if ($current_root)
            {
                $current_root->parent_id = $node->id;
                $current_root->save();
            }

            $result['item_id'] = Request::input('item_id');
            $result['success'] = true;
            return json_encode($result);
        }
    }
    public function UpdateChartItem()
    {
        $result = array();
        $item_id = Request::input('item_id');
        $item_title = Request::input('item_title');
        $item_parent_id = Request::input('item_parent_id');
        $item_description = Request::input('item_description');

        $item = org_chart_items::find($item_id);
        $item->title = $item_title;
        $item->parent_id = $item_parent_id;
        $item->description = $item_description;
        $item->save();
        $result['item_id'] = $item_id;
        return json_encode($result);
    }
    public function RemoveChartItem()
    {

        $ID = Request::input('item_id');
        org_chart_items::destroy($ID);
        return json_encode($ID);
    }
    public function add_new_post()
    {
        $post = new org_charts_items_posts();
        $post->title = Request::input('post_title');
        $post->chart_item_id = Request::input('item_id');
        $post->uid = 125;
        $post->save();

        $post = DB::table('hamahang_org_charts_items_posts')
            ->where('chart_item_id', '=', $post->chart_item_id)
            ->whereNull('deleted_at')
            ->get();

        foreach ($post as $p)
        {
            if ($p->user_id == '')
            {
                $p->user_id = 'no';
            }
            else
            {
                $user = User::find($p->user_id)->get();
                $p->user_info = $user[0];
            }
        }
        return $post;
    }
    public function add_post_user()
    {
        $p = org_charts_items_posts::find(Request::input('post_id'));
        $p->user_id = Request::input('user_id');
        $p->save();

        $post = DB::table('hamahang_org_charts_items_posts')
            ->whereNull('deleted_at')
            ->where('chart_item_id', '=', $p->chart_item_id)
            ->get();

        foreach ($post as $p)
        {
            if ($p->user_id == '')
            {
                $p->user_id = 'no';
            }
            else
            {
                $user = User::where('id', $p->user_id)->first();
                $p->user_info = $user->toArray();
            }
        }
//		/die(var_dump($post));
        return $post;
    }
    public function remove_post_user()
    {
        $p = org_charts_items_posts::find(Request::input('post_id'));
        $p->user_id = '';
        $p->save();
        $post = DB::table('hamahang_org_charts_items_posts')
            ->whereNull('deleted_at')
            ->where('chart_item_id', '=', $p->chart_item_id)
            ->get();
        foreach ($post as $p)
        {
            if ($p->user_id == '')
            {
                $p->user_id = 'no';
            }
            else
            {
                $user = User::find($p->user_id);
                $p->user_info = $user;
            }
        }
        return $post;
    }
    public function GetItemChildren()
    {
        $ID = Request::input('id');
        $sort = Request::input('sort');
        $current = Request::input('current');
        $rowCount = Request::input('rowCount');
        $searchPhrase = Request::input('searchPhrase');
        $OrgChartItem = new org_chart_items;
        $total = DB::table('hamahang_org_charts_items')->where('parent_id', '=', $ID)->select('title', 'description', 'created_at', 'updated_at', 'id')->get();
        //die(var_dump($total));
        $data = collect($total)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $result['data'] = $data;
        return json_encode($result);

//        $total = $OrgChartItem
//            ->where('title', 'LIKE', '%' . $searchPhrase . '%')
//            ->where('parent_id', '=', $ID)
//            ->count();
//        //Auth::id()
//        if ($sort) {
//            $sort_field = array_keys($sort)[0];
//            $sort_order = $sort[array_keys($sort)[0]];
//        } else {
//            $sort_field = 'id';
//            $sort_order = 'DESC';
//        }
//
//        if ($rowCount == -1) {
//            $data = $OrgChartItem
//                ->select("id", "title", "description", "parent_id", "updated_at", "created_at")
//                ->where('title', 'LIKE', '%' . $searchPhrase . '%')
//                ->where('parent_id', '=', $ID)
//                ->orderBy($sort_field, $sort_order)
//                ->get();
//            //Auth::id()
//        } else {
//            if ($current == 1) {
//                $cur = 0;
//            } else {
//                $cur = ($current - 1) * $rowCount;
//            }
//
//
//            $data = $OrgChartItem
//                ->select("id", "title", "description", "parent_id", "updated_at", "created_at")
//                ->where('title', 'LIKE', '%' . $searchPhrase . '%')
//                ->where('parent_id', '=', $ID)
//                ->orderBy($sort_field, $sort_order)
//                ->offset($cur)
//                ->limit($rowCount)
//                ->get();
//            //Auth::id()
//        }
//
//        $result = array(
//            'rows' => $data,
//            'total' => $total,
//            'rowCount' => $rowCount,
//            'current' => $current,
//            'id' => $ID
//        );
        //return json_encode($total);

    }
    public function select_list_organs()
    {
     return org_organs::where('title', 'Like', '%'.Request::get('term').'%')->select('id', 'title as text')->get();
    }
    public function insert_organs()
    {
        $validator = Validator::make(Request::all(),
            [
                'organ_title' => 'required',
                'parent_organ'=>'exists:hamahang_org_organs,id'
            ],
            [],
            [
                'organ_title' => 'عنوان ',
                'parent_organ' => 'سازمان ',
                'organ_description'=>'توضیحات'
            ]
        );
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else{
            $organ_title = Request::get('organ_title');
            $organ_description = Request::get('organ_description');
            $organ_parent= (Request::get('parent_organ')? Request::get('parent_organ') : 0);
            org_organs::create([
                'uid' => auth()->id(),
                'parent_id' => $organ_parent,
                'title' => $organ_title,
                'description' => $organ_description,
            ]);
            $result['success'] = true;
        }
        return json_encode($result);
    }
    public function edit_organs(){

        $validator = Validator::make(Request::all(),
            [
                'organ_title' => 'required',
                'parent_organ'=>'exists:hamahang_org_organs,id'
                /*'id_organ'=>'required|exists:hamahang_org_organs,id'*/
            ],
            [],
            [
                'organ_title' => 'عنوان ',
                'parent_organ' => 'سازمان ',
                'organ_description'=>'توضیحات'

            ]
        );
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else{

            $organ_title = Request::get('organ_title');
            $organ_description = Request::get('organ_description');
            $organ_id=4;
            $organ_parent= (Request::get('parent_organ')? Request::get('parent_organ') : 0);
            $organ=org_organs::find($organ_id);
            $organ->title=$organ_title;
            $organ->description=$organ_description;
            $organ->parent_id=$organ_parent;
            $organ->save();
            $result['success'] = true;
        }
       return $result;
    }
    public function edit_chart(){

        $validator = Validator::make(Request::all(),
            [
                'chart_title' => 'required',
                'chart_id'=>'required|exists:hamahang_org_charts,id'
            ],
            [],
            [
                'organ_title' => 'عنوان ',
            ]
        );
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else{
            $organ_title = Request::get('chart_title');
            $organ_description = Request::get('chart_description');
            $chart_id=Request::get('chart_id');
            $chart=org_charts::find($chart_id);
            $chart->title=$organ_title;
            $chart->description=$organ_description;
            $chart->save();
            $result['success'] = true;
        }
        return $result;
    }
    private function get_child($id)
    {
        $list_child= org_organs::select('id')->where('parent_id',4)->get();
    }
    public function select_list_edit_organs()
    {
        $validator = Validator::make(Request::all(),
            [
                'organ_id' => 'required|exists:hamahang_org_organs,id',
            ],
            [],
            [
                'organ_id' => 'سازمان ',
            ]
        );
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
       $list_child= org_organs::select('id')->where('parent_id',4)->get();
      // dd($list_child->toArray());
        return org_organs::where('title', 'Like', '%'.Request::get('term').'%')->whereNotIn('id',[$list_child->toArray()])->select('id', 'title as text')->get();
    }
    public function add_chart_item_child(){
        $validator = Validator::make(Request::all(),
            [
                'new_item_title' => 'required',
                'item_id' => 'required',
                'chart_id'=>'required|exists:hamahang_org_charts,id'
            ],
            [],
            [
                'new_item_title' => 'عنوان ',
                'new_item_title' => 'عنوان ',
            ]
        );
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else{
            $chart_item=new org_chart_items();
            $chart_item->title=Request::get('new_item_title');
            $chart_item->description=Request::get('new_item_description');
            $chart_item->parent_id=Request::get('item_id');
            $chart_item->chart_id=Request::get('chart_id');
            if($chart_item->save())
            $result['success'] = true;
            else $result['success']=false;
        }
        return $result;
    }
    public function  add_chart_item_post(){

        $validator = Validator::make(Request::all(),
            [
                'new_post_title' => 'required',
                'item_id' => 'required',

            ],
            [],
            [
                'new_post_title' => 'عنوان ',

            ]
        );
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else{
            $chart_item_post=new org_charts_items_posts();
            $chart_item_post->title=Request::get('new_post_title');
            $chart_item_post->description=Request::get('new_post_description');
            $chart_item_post->chart_item_id=Request::get('item_id');
            $chart_item_post->user_id=0;
            if($chart_item_post->save())
             $result['success'] = true;
            else $result['success']=false;
        }
        return $result;
    }
    public function delete_employ_post()
    {

        $validator = Validator::make(Request::all(),
            [
                'post_id' => 'required|exists:hamahang_org_charts_items_posts,id',

            ],
            [],
            [
                'post_id' => 'آیدی',
            ]
        );
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else{
            $chart_item_post=org_charts_items_posts::find(Request::get('post_id'));
            $chart_item_post->user_id=0;
            if($chart_item_post->save())
                $result['success'] = true;
            else $result['success']=false;
        }
        return json_encode($result);
    }
    public function select_list_employ(){
        if(!empty(Request::get('term')))
        return User::where('Uname', 'Like', '%'.Request::get('term').'%')->orwhere('Name', 'Like', '%'.Request::get('term').'%')->orwhere('Family', 'Like', '%'.Request::get('term').'%')->select('id', 'Family as text')->get();
    }
    public function add_employ_for_post(){

        $validator = Validator::make(Request::all(),
            [

                'post_id'=>'required|exists:hamahang_org_charts_items_posts,id'
            ],
            [],
            [
                'employ_id' => 'کارمند ',
            ]
        );
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else{
            $chart_item_post=org_charts_items_posts::find(Request::get('post_id'));
            $chart_item_post->user_id=(Request::get('employ_id')) ? Request::get('employ_id') : 0;
            if($chart_item_post->save())
                $result['success'] = true;
            else $result['success']=false;
        }
        return $result;
    }
    public function update_one_chart_item(){
{

            $validator = Validator::make(Request::all(),
                [
                    'item_title'=>'required',
                    'item_id'=>'required',
                    'item_parent_id'=>'required',
                ],
                [],
                [
                    /*'item_title' => 'عنوان',
                    'item_description' => 'توضیحات',
                    'item_parent_id'=>'والد',*/
                ]
            );
            if ($validator->fails())
            {
                $result['error'] = $validator->errors();
                $result['success'] = false;
                return json_encode($result);
            }
            else{

                $chart_item=org_chart_items::find(Request::get('item_id'));

                $chart_item->title=(Request::get('item_title'));
                $chart_item->description=(Request::get('item_description'));
                $chart_item->parent_id=(Request::get('item_parent_id'));
                if($chart_item->save())
                    $result['success'] = true;
                else $result['success']=false;
            }
            return json_encode($result);
        }
    }


}

