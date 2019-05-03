<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\hamafza\keyword;
use App\Models\hamafza\Subject;
use App\Models\Hamahang\ACL\AclCategory;
use App\Models\Hamahang\OrgChart\org_chart_items;
use App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts;
use App\Models\Hamahang\OrgChart\org_organs;
use App\Models\Hamahang\ProvinceCity\City;
use App\Models\Hamahang\ProvinceCity\Province;
use App\Models\Hamahang\Tasks\tasks;
use App\Role;
use Auth;
use Illuminate\Http\Request;
use App\User;
use DB;


class AutoCompleteController extends Controller
{
    public function tasks(Request $request)
    {
        $x = $request->term;
        if ($x['term'] == '...')
        {
            $data = tasks::select("id", "title as text")->get();
        }
        else
        {
            $data = tasks::select("id", "title as text")->where("title", "LIKE", "%" . $x['term'] . "%")->get();
        }
        $data = array('results' => $data);
        return response()->json($data);
    }

    public function users(Request $request)
    {
        $x = $request->term;
        if ($x['term'] == '...')
        {
            $data = User::all(["id", DB::raw('CONCAT(Name, " ", Family, " (", Uname, ")") AS text')]);
        }
        else
        {
            $data = User::select("id", DB::raw('CONCAT(Name, " ", Family, " (", Uname, ")") AS text'))
                ->where("Name", "LIKE", "%" . $x['term'] . "%")
                ->Orwhere("Family", "LIKE", "%" . $x['term'] . "%")
                ->Orwhere("Uname", "LIKE", "%" . $x['term'] . "%")
                ->Orwhere("Email", "LIKE", "%" . $x['term'] . "%")
                ->get();
        }
        $data = array('results' => $data);
        return response()->json($data);
    }

    public function users_new(Request $request)
    {
        $x = $request->term;
        if ($x['term'] == '...')
        {
            $data = User::all(["id", DB::raw('CONCAT(Name, " ", Family, " (", Uname, ")") AS text')]);
        }
        else
        {
            $data = User::select("id", DB::raw('CONCAT(Name, " ", Family, " (", Uname, ")") AS text'))
                ->where("Name", "LIKE", "%" . $x['term'] . "%")
                ->Orwhere("Family", "LIKE", "%" . $x['term'] . "%")
                ->Orwhere("Uname", "LIKE", "%" . $x['term'] . "%")
                ->Orwhere("Email", "LIKE", "%" . $x['term'] . "%")
                ->get();
        }
        $users = [];
        foreach ($data as $user)
        {
            $users[] = ['id'=>'exist_in'.$user->id,'text'=>$user->text];//($request->exists('exist_in') ? $request->exist_in : 'exist_in') . $user->id;
        }
        $data = array('results' => $users);
        return response()->json($data);
    }

    public function hamahang_cities(Request $request)
    {
        $cities = City::where('province_id', $request->province_id)->get(['id', 'name as text']);
        return json_encode($cities);
    }

    public function pages(Request $request)
    {
        $x = $request->term;
        if ($x['term'] == '...')
        {
            $data = DB::table('pages')
                ->join('subjects', 'subjects.id', '=', 'pages.sid')
                ->select('subjects.title as text', 'pages.id')
                ->get();
        }
        else
        {
            $data = DB::table('pages')
                ->join('subjects', 'subjects.id', '=', 'pages.sid')
                ->where('subjects.title', "LIKE", "%" . $x['term'] . "%")
                ->select('subjects.title as text', 'pages.id')
                ->get();
        }
        $data = array('results' => $data);
        return response()->json($data);
    }

    public function onet_jobs_items(Request $request)
    {
        $x = $request->term;
        if ($x['term'] == '...')
        {
            $data = DB::table('hamafza_onet_job')
                ->join('hamahang_org_charts_items_jobs', 'hamafza_onet_job.id', '=', 'hamahang_org_charts_items_jobs.job_id')
                ->where('hamahang_org_charts_items_jobs.chart_item_id', "=", $request->item_id)
                ->select('title as text', 'hamahang_org_charts_items_jobs.id')
                ->get();
        }
        else
        {
            $data = DB::table('hamafza_onet_job')
                ->join('hamahang_org_charts_items_jobs', 'hamafza_onet_job.id', '=', 'hamahang_org_charts_items_jobs.job_id')
                ->where('hamahang_org_charts_items_jobs.chart_item_id', "=", $request->item_id)
                ->where('hamafza_onet_job.title', "LIKE", "%" . $x['term'] . "%")
                ->select('hamafza_onet_job.title as text', 'hamahang_org_charts_items_jobs.id')
                ->get();
        }
        $data = array('results' => $data);
        return response()->json($data);
    }


    public function org_charts_items_posts(Request $request)
    {
        if (!empty($request->term))
        {

            if ($request->term['term'] == '...')
            {
                $data = org_charts_items_jobs_posts::where("chart_item_job_id", "=",$request->item_id)
                    ->select("id", "extra_title as text")
                    ->get();
            }
            else
            {
                $data = org_charts_items_jobs_posts::select("id", "extra_title as text")
                    ->where("chart_item_job_id", "=",$request->item_id)
                    ->where("title", "LIKE", '%' . $request->term['term'] . '%')->get();
            }
            $data = array('results' => $data);
            return response()->json($data);
        }
    }

    public function org_charts_posts(Request $request)
    {
        if (!empty($request->term))
        {

            if ($request->term['term'] == '...')
            {
                $data = org_charts_items_jobs_posts::where("chart_item_job_id", "=",$request->item_id)
                    ->select("id", "extra_title as text")
                    ->get();
            }
            else
            {
                $data = org_charts_items_jobs_posts::select("id", "extra_title as text")
                    ->where("title", "LIKE", '%' . $request->term['term'] . '%')->get();
            }
            $data = array('results' => $data);
            return response()->json($data);
        }
    }

    public function onet_jobs(Request $request)
    {
        $x = $request->term;
        if ($x['term'] == '...')
        {
            $data = DB::table('hamafza_onet_job')
                ->select('title as text', 'id')
                ->get();
        }
        else
        {
            $data = DB::table('hamafza_onet_job')
                ->where('hamafza_onet_job.title', "LIKE", "%" . $x['term'] . "%")
                ->select('hamafza_onet_job.title as text', 'id')
                ->get();
        }
        $data = array('results' => $data);
        foreach ($data['results'] as $job)
        {
            $job->id = ($request->exists('exist_in') ? $request->exist_in : 'exist_in') . $job->id;
        }
        return response()->json($data);
    }

    public function missions_job(Request $request)
    {
        $x = $request->term;
        if ($x['term'] == '...')
        {
            $data = DB::table('hamafza_org_osi')
                ->select('title as text', 'id')
                ->get();
        }
        else
        {
            $data = DB::table('hamafza_org_osi')
                ->where('hamafza_org_osi.title', "LIKE", "%" . $x['term'] . "%")
                ->select('hamafza_org_osi.title as text', 'id')
                ->get();
        }
        $data = array('results' => $data);
        foreach ($data['results'] as $mission)
        {
            $mission->id = ($request->exists('exist_in') ? $request->exist_in : 'exist_in') . $mission->id;
        }

        return response()->json($data);
    }

    public function organs(Request $request)
    {
        $x = $request->data;
        if ($x['q'] == '...')
        {
            $data = org_organs::all(["id", "title as text"]);
        }
        else
        {
            $data = org_organs::select("id", "title as text")->where("title", "LIKE", "%" . $x['q'] . "%")->get();
        }
        $data = array('results' => $data);
        return response()->json($data);
    }

    public function units(Request $request)
    {
        if (!empty($request->term))
        {

            if ($request->term['term'] == '...')
            {
                $data = org_chart_items::select("id", "title as text")
                    ->get();
            }
            else
            {
                $data = org_chart_items::select("id", "title as text")
                    ->where("title", "LIKE", '%' . $request->term['term'] . '%')->get();
            }
            $data = array('results' => $data);
            return response()->json($data);
        }

    }
    public function organ_chart_items(Request $request)
    {
        if (!empty($request->term))
        {

            if ($request->term['term'] == '...')
            {
                $data = org_chart_items::select("id", "title as text")
                    ->whereHas('chart', function ($query) use ($request) {
                        $query->where('org_organs_id', '=', $request->organ);
                    })->get();
            }
            else
            {
                $data = org_chart_items::select("id", "title as text")
                    ->whereHas('chart', function ($query) use ($request) {
                        $query->where('org_organs_id', '=', $request->organ);
                    })
                    ->where("title", "LIKE", '%' . $request->term['term'] . '%')->get();
            }
            $data = array('results' => $data);
            return response()->json($data);
        }

    }

    public function chart_items(Request $request)
    {
        if (!empty($request->term))
        {
            if ($request->term == '...')
            {
                $data = org_chart_items::all(["id", "title as text"]);
            }
            else
            {
                $data = org_chart_items::select("id", "title as text")->where("title", "LIKE", '%' . $request->term . '%')->get();
            }
            return json_encode($data);
        }

    }

    public function about_user_keywords(Request $request)
    {
        $data = $request->term;
        if ($data['term'] == '...')
        {
            $res ['results'] = DB::table('keywords')
                ->select("id", "title as text")->get();
        }
        else
        {
            $res ['results'] = DB::table('keywords')
                ->select("id", "title as text")
                ->where("title", "LIKE", "%" . $data['term'] . "%")->get();
        }
        return response()->json($res);
    }

    public function keywords(Request $request)
    {
        $data = $request->term;
        if ($data['term'] == '...')
        {
            $res ['results'] = DB::table('keywords')
                ->select("id", "title as text")->get();
        }
        else
        {
            $res ['results'] = DB::table('keywords')
                ->select("id", "title as text")
                ->where("title", "LIKE", "%" . $data['term'] . "%")->get();
        }
        foreach ($res ['results'] as $keyword)
        {
            $keyword->id = ($request->exists('exist_in') ? $request->exist_in : 'exist_in') . $keyword->id;
        }
        return response()->json($res);
    }

    public function resources(Request $request)
    {
        $data = $request->term;
        if ($data['term'] == '...')
        {
            $res ['results'] = DB::table('new_hamafza_resources')
                ->select("id", "resource as text")->get();
        }
        else
        {
            $res ['results'] = DB::table('new_hamafza_resources')
                ->select("id", "resource as text")
                ->where("resource", "LIKE", "%" . $data['term'] . "%")->get();
        }
        foreach ($res ['results'] as $keyword)
        {
            $keyword->id = ($request->exists('exist_in') ? $request->exist_in : 'exist_in') . $keyword->id;
        }
        return response()->json($res);
    }

    public function process(Request $request)
    {
        $data = $request->term;
        if ($data['term'] == '...')
        {
            $res ['results'] = DB::table('hamahang_process')
                ->select("id", "title as text")->get();
        }
        else
        {
            $res ['results'] = DB::table('hamahang_process')->select("id", "title as text")->where("title", "LIKE", "%" . $data['term'] . "%")->get();
            return response()->json($res);
        }
    }

    public function projects(Request $request)
    {
        $data = $request->term;
        if ($data['term'] == '...')
        {
            $res ['results'] = DB::table('hamahang_project')
                ->select("id", "title as text")->get();
        }
        else
        {
            $res ['results'] = DB::table('hamahang_project')->select("id", "title as text")->where("title", "LIKE", "%" . $data['term'] . "%")->get();
        }
        return response()->json($res);
    }

    public function calendars(Request $request)
    {
        $data = $request->term;
        if ($data['term'] == '...')
        {
            $res ['results'] = DB::table('hamahang_calendar')
                ->select("id", "title")->get();
        }
        else
        {
            $res ['results'] = DB::table('hamahang_calendar')
                ->select('id', 'title')
                ->where('uid', '=', Auth::id())
                ->where("title", "LIKE", "%" . $data['term'] . "%")
                ->get();
        }
        return response()->json($res);
    }

    public function tools()
    {
        $tools = \App\Models\Hamahang\Tools\Tools::select('id', 'title as text')->get();
        return json_encode($tools);
    }

    public function allRoles(Request $request)
    {
        $tools = Role::select('id', 'name as text')->get();
        return json_encode($tools);
    }

    public function roles(Request $request)
    {
        $x = $request->term;
        if ($x['term'] == '...')
        {
            $data = Role::all(["id", DB::raw('CONCAT(name, " ", display_name) AS text')]);
        }
        else
        {
            $data = Role::select("id", DB::raw('CONCAT(name, " ", display_name) AS text'))
                ->where("name", "LIKE", "%" . $x['term'] . "%")
                ->Orwhere("display_name", "LIKE", "%" . $x['term'] . "%")
                ->get();
        }
        $data = array('results' => $data);
        return response()->json($data);
    }

    public function menuItems(Request $request)
    {
        $menu_id = deCode($request->menu_id);
        $query = $request->term;
        if ($request->term == '...')
        {
            $menus = \App\Models\Hamahang\Menus\MenuItem::where("menu_id", $menu_id)
                ->get(["id", "title as text"]);
        }
        else
        {
            $menus = \App\Models\Hamahang\Menus\MenuItem::where("title", "LIKE", "%" . $query . "%")
                ->where("menu_id", $menu_id)
                ->get(["id", "title as text"]);
        }
        $menus = $menus->toArray();
        if($request->filter_items_by_parent)
        {
            array_unshift($menus,['id'=>'-1','text'=>'نمایش همه'],['id'=>'0','text'=>'نمایش ریشه']);
        }
        return response()->json($menus);
    }

    public function menus()
    {
        $types = \App\Models\Hamahang\Menus\Menus::select('id', 'title as text')->get();
        return json_encode($types);
    }

    public function permissions(Request $request)
    {
        $str = $request->term;
        if ($str['term'] == '...')
        {
            $permissions = DB::table('permissions')->select('id', 'display_name AS text')
                ->get();
        }
        else
        {
            $permissions = DB::table('permissions')->select('id', 'display_name AS text')
                ->where('display_name', 'LIKE', "%" . $str['term'] . "%")
                ->orWhere('name', 'LIKE', "%" . $str['term'] . "%")
                ->get();
        }
        $data = array('results' => $permissions);
        return response()->json($data);
    }

    public function allPermissions()
    {
        $permissions = DB::table('permissions')->select('id', 'display_name AS text')
            ->get();
        return response()->json($permissions);
    }

    public function provinces()
    {
        $p = \App\Models\Hamahang\ProvinceCity\Province::select('id', 'name as text')->get();
        return json_encode($p);
    }

    public function cities(Request $request)
    {

        $cities = \App\Models\Hamahang\ProvinceCity\City::select('id', 'name as text')
            ->where('province_id', '=', $request->pId)
            ->get();
        return json_encode($cities);
    }

    public function toolsOptions()
    {
        return \App\Models\Hamahang\Options::getList();
    }

    public function templatePosition()
    {
        return \App\Models\Hamahang\TemplatePosition::getList();
    }

    public function getDefaultCalendar()
    {

        $list = DB::table("hamahang_calendar")
            ->select('id', 'title', 'is_default')
            ->where('user_id', '=', \Auth::id())
            ->where('is_default', '=', 1)
            ->first();
        if(count($list)==0)
        {
            $list = DB::table("hamahang_calendar")
                ->select('id', 'title', 'is_default')
                ->where('user_id', '=', \Auth::id())
                ->first();
        }
        if(isset($list->id))
        {
            \Session::put('default_calendar',$list->id);
        }
        return json_encode($list);
    }

    public function getUserCalendar()
    {
        $this->getDefaultCalendar();
        $list = DB::table("hamahang_calendar")->select('id', 'title', 'is_default')->where('user_id', '=', \Auth::id())->get();
        return json_encode($list);
    }

    public function aclUsers(Request $request)
    {
        $str = $request->term;
        if ($request->data['term'] == '...')
        {
            $x = User::all(['Email as text', 'Uname as text', 'id'])->toArray();
        }
        else
        {
            $x = User::where('Uname', 'like', '%' . $request->data['term'] . '%')
                ->orWhere('Email', 'like', '%' . $request->data['term'] . '%')
                ->get(['Email as text', 'Uname as text', 'id'])->toArray();
        }
        return response()->json($x);
    }

    public function aclCategories()
    {
        $acl_categories = AclCategory::get(['title as text', 'id'])->toArray();
        return json_encode($acl_categories);
    }

    public function aclParentsList(Request $request)
    {
        $x = $request->term;
        if ($x['term'] == '...')
        {
            $data = AclCategory::select("id", 'title AS text')->get();
        }
        else
        {
            $data = AclCategory::select("id", 'title AS text')
                ->where("title", "LIKE", "%" . $x['term'] . "%")
                ->get();
        }
        $data = array('results' => $data);
        return response()->json($data);
    }

    public function keywordsWithSubjects(Request $request)
    {
        $x = $request->term;
        if ($x['term'] == '...')
        {
            $data = Keyword::select("id", DB::raw('CONCAT(title) AS text'))
                ->get();
        }
        else
        {
            $data = Keyword::select("id", DB::raw('CONCAT(title) AS text'))
                ->where("title", "LIKE", "%" . $x['term'] . "%")
                ->get();
        }
        $data = array('results' => $data);
        return response()->json($data);
    }

    public function subjects(Request $request)
    {
        $x = $request->term;
        if ($x['term'] == '...')
        {
            $data = Subject::select("id", DB::raw('CONCAT(title) AS text'))->get();
        }
        else
        {
            $data = Subject::select("id", DB::raw('CONCAT(title,", ",id) AS text'))
                ->where("title", "LIKE", "%" . $x['term'] . "%")
                ->get();
        }
        $data = array('results' => $data);
        return response()->json($data);
    }

    public function UsersList(Request $request)
    {
        if ($request->term == '...')
        {
            $usermodel = User::select("id", DB::raw('CONCAT(Name, " ", Family, " (", Uname, ")") AS text'))->get();
        }
        else
        {
            $usermodel = User::select("id", DB::raw('CONCAT(Name, " ", Family, " (", Uname, ")") AS text'))
                ->where("Name", "LIKE", "%" . $request->term . "%")
                ->Orwhere("Family", "LIKE", "%" . $request->term . "%")
                ->Orwhere("Uname", "LIKE", "%" . $request->term . "%")
                ->Orwhere("Email", "LIKE", "%" . $request->term . "%")
                ->get();
        }
        echo json_encode($usermodel);
    }

    public function search_list_user(Request $request)
    {
        $array_selected = [];
        $users = User::where('Uname', 'Like', '%' . $request->term . '%')
            ->orwhere('Name', 'Like', '%' . $request->term . '%')
            ->orwhere('Family', 'Like', '%' . $request->term . '%');
        if ((isset($request->selected_array) && is_array($request->selected_array)))
        {
            $array_selected = $request->selected_array;
        }
        $users = $users->get();
        return view('modals.list_user_setting', compact('users', 'array_selected'));
    }

    public function search_list_task(Request $request)
    {
        $tasks = DB::table('hamahang_task')
            ->select("hamahang_task_assignments.id as assignment_id","hamahang_task_status.type as task_status","hamahang_task.schedule_time", "hamahang_task.schedule_id", "hamahang_task.use_type", "hamahang_task.duration_timestamp", "hamahang_task.created_at", "user.Uname", "user.Name", "user.Family", DB::raw('CONCAT("user.Name"," ","user.Family") AS employee'), "hamahang_task.id", "hamahang_task.title", "hamahang_task_priority.immediate", "hamahang_task_priority.importance")
            ->join('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
            ->join('user', 'user.id', '=', 'hamahang_task_assignments.uid')
            ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
            //->whereNull('hamahang_task_assignments.transmitter_id')
            ->where('hamahang_task_assignments.employee_id', '=', Auth::id())
//            ->where('hamahang_task_assignments.status', '=', 0)
            ->where('hamahang_task.title', 'Like', '%' . $request->term . '%')
//            ->whereNull('hamahang_task_assignments.reject_description')
            ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
            ->whereRaw('hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id and user_id = ?)', [Auth::id()])
//            ->toSql()
        ;
        $array_selected = [];
        if ((isset($request->selected_array) && is_array($request->selected_array)))
        {
            $array_selected = $request->selected_array;
        }
        $tasks = $tasks->get();
        return view('modals.list_task_setting', compact('tasks', 'array_selected'));
    }

    public function selected_list_user(Request $request)
    {
        if ((isset($request->selected_array) && is_array($request->selected_array)))
        {
            $users = User::whereIn('id', $request->selected_array)->get();
            $array_selected = $request->selected_array;
            return view('modals.list_user_setting', compact('users', 'array_selected'));
        }

    }

    public function selected_list_task(Request $request)
    {
        if ((isset($request->selected_array) && is_array($request->selected_array)))
        {
            $tasks = DB::table('hamahang_task')
                ->select("hamahang_task_assignments.id as assignment_id","hamahang_task_status.type as task_status","hamahang_task.schedule_time", "hamahang_task.schedule_id", "hamahang_task.use_type", "hamahang_task.duration_timestamp", "hamahang_task.created_at", "user.Uname", "user.Name", "user.Family", DB::raw('CONCAT("user.Name"," ","user.Family") AS employee'), "hamahang_task.id", "hamahang_task.title", "hamahang_task_priority.immediate", "hamahang_task_priority.importance")
                ->join('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
                ->join('user', 'user.id', '=', 'hamahang_task_assignments.uid')
                ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
                ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
                ->whereRaw('hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id and user_id = ?)', [Auth::id()])
                ->where('hamahang_task_assignments.employee_id', '=', Auth::id())
                ->groupBy('hamahang_task.id')
                ->whereIn('hamahang_task.id', $request->selected_array)->get();
            $array_selected = $request->selected_array;
            return view('modals.list_task_setting', compact('tasks', 'array_selected'));
        }

    }
    public function help(Request $request)
    {
        $data = $request->term;
        if ($data['term'] == '...')
        {
            $res['results'] = DB::table('hamahang_helps')
                ->select('id', 'title as text')
                ->get();
        } else
        {
            $res['results'] = DB::table('hamahang_helps')
                ->select('id', 'title as text')
                ->where('title', 'LIKE', "%$data[term]%")
                ->get();
        }
        return response()->json($res);
    }

}