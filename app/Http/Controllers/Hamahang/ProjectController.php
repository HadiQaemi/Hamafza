<?php

namespace App\Http\Controllers\Hamahang;

use App\HamafzaServiceClasses\SubjectsClass;
use App\Http\Controllers\Hamahang\Tasks\TaskController;
use App\Models\hamafza\Pages;
use App\Models\Hamahang\keywords;
use App\Models\Hamahang\Tasks\hamahang_project_task;
use App\Models\Hamahang\Tasks\projects;
use App\Models\Hamahang\Tasks\project_role_permission;
use App\Models\Hamahang\Tasks\task_status;
use App\Models\Hamahang\Tasks\tasks;
use App\User;
use Datatables;
use DB;
use Auth;
//use phpDocumentor\Reflection\Project;
use Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Validator;
use App\Http\Controllers\Controller;
use App\HamahangCustomClasses\jDateTime;
use App\HamafzaViewClasses\TaskClass;
use App\HamafzaViewClasses\DesktopClass;
use App\Models\Hamahang\Tasks\task_project;
use App\Models\Hamahang\Tasks\project_keyword;
use App\Models\Hamahang\Tasks\project_permissions;
use App\Models\Hamahang\Tasks\project_task;
use App\Models\Hamahang\Tasks\project_task_relation;
use App\Models\Hamahang\Tasks\hamahang_project_responsible;
use App\Models\Hamahang\Tasks\hamahang_subject_ables;

class ProjectController extends Controller
{
    public $x = 1;
    private $day_count = 0;
    private $startdate_probe = 0;
    private $is_original_node = 1;
    private $second_task_duration = 0;
    private $project_task_relations = [];
    private $project_tasks;
    public static  $_VIEW_PROJECT_PERMISSSION = 1;
    public static  $_MANAGE_TASK_PROJECT_PERMISSSION = 2;
    public static  $_MANAGE_PROJECT_PERMISSSION = 3;

    public static  $_PROJECT_MANAGER = 1;
    public static  $_PROJECT_SUPERVISOR = 2;
    public static  $_PROJECT_BASKET_MANAGER = 3;

    public function ProjectInfoWindow()
    {
//
        return json_encode([
            'header' => trans('tasks.project'),
            'content' => view('hamahang.Projects.create_show_project_window')->with('ProjectInfo', $this->ProjectInfo())->render(),
            'footer' => view('hamahang.helper.JsPanelsFooter')->with('btn_type', 'projectInfo')->render()
        ]);
    }

    public function ProjectTasksWindow()
    {
        return json_encode([
            'header' => trans('tasks.project'),
            'content' => view('hamahang.Projects.show_project_tasks_window')->with('ProjectInfo', $this->project_tasks(Request::input('pid')))->render()
        ]);
    }

    public function ProjectTasksListWindow()
    {
        $permission = self::TakeProjectPermissions(deCode(Request::input('pid')));
        if(in_array(self::$_VIEW_PROJECT_PERMISSSION,$permission) || in_array(self::$_MANAGE_PROJECT_PERMISSSION,$permission) || in_array(self::$_MANAGE_TASK_PROJECT_PERMISSSION,$permission)) {
            return json_encode([
                'success' => true,
                'header' => trans('tasks.project'),
                'content' => view('hamahang.Projects.show_project_tasks_list_window')->with('ProjectInfo', $this->project_tasks_list(Request::input('pid')))->render()
            ]);
        }else{
            $result['error'] = trans('projects.no_permissions');
            $result['success'] = false;
            return json_encode($result);
        }
    }

    public function ProjectTasksGanttWindow()
    {
        $permission = self::TakeProjectPermissions(deCode(Request::input('pid')));
        if(in_array(self::$_VIEW_PROJECT_PERMISSSION,$permission) || in_array(self::$_MANAGE_PROJECT_PERMISSSION,$permission) || in_array(self::$_MANAGE_TASK_PROJECT_PERMISSSION,$permission)) {
            return json_encode([
                'success' => true,
                'header' => trans('tasks.project'),
                'content' => view('hamahang.Projects.show_project_tasks_gantt_window')->with('ProjectInfo', $this->project_tasks_list(Request::input('pid')))->render()
            ]);
        }else{
            $result['error'] = trans('projects.no_permissions');
            $result['success'] = false;
            return json_encode($result);
        }
    }

    public function ProjectFetchGanttTasks()
    {
        $jdate = new jDateTime;
        $result = [];
        $pid = deCode(Request::input('pid'));
        $permission = self::TakeProjectPermissions($pid);
        if(in_array(self::$_VIEW_PROJECT_PERMISSSION,$permission) || in_array(self::$_MANAGE_PROJECT_PERMISSSION,$permission) || in_array(self::$_MANAGE_TASK_PROJECT_PERMISSSION,$permission)) {
            $items = DB::table('hamahang_project_task')
                ->where('project_id', '=', $pid)
                ->leftjoin('hamahang_task', 'hamahang_task.id', '=', 'hamahang_project_task.task_id')
                ->whereNull('hamahang_project_task.deleted_at')
                ->select('hamahang_project_task.*', 'hamahang_task.*', 'hamahang_project_task.id as hp_task')
                ->get();
//            dd(count($items));
            foreach($items as $item){
                $tasks = [];
                $start = $jdate ->getdate(strtotime($item->schedule_time) + 0);
                $start = jDateTime::convertElseNumbers($start['year'].'-'.$start['mon'].'-'.$start['mday']);
                $end = $jdate ->getdate(strtotime($item->schedule_time) + $item->duration_timestamp);
                $end = jDateTime::convertElseNumbers($end['year'].'-'.$end['mon'].'-'.$end['mday']);
//
                $start = $org_start = preg_split('/-/',$start);
                $start = $jdate ->Jalali_to_Gregorian($start[0],$start[1],$start[2]);
                $date = date_create($start[0]."-".$start[1]."-".$start[2]);
                date_sub($date,date_interval_create_from_date_string("79 days"));
                $new_start = $org_start[0].'-'.date_format($date,"m-d");
//
                $end = $org_end = preg_split('/-/',$end);
                $end = $jdate ->Jalali_to_Gregorian($end[0],$end[1],$end[2]);
                $date = date_create($end[0]."-".$end[1]."-".$end[2]);
                date_sub($date,date_interval_create_from_date_string("79 days"));
                $new_end = $org_end[0].'-'.date_format($date,"m-d");

                // rows
                $tasks['id'] = $item->id;
                $tasks['text'] = htmlspecialchars($item->title);
                $tasks['start'] = $new_start;
                $tasks['end'] = $new_end;
                $tasks['complete'] = $item->progress;
                $result[] = $tasks;
            }
            return json_encode($result);
        }else{
            $result['error'] = trans('projects.no_permissions');
            $result['success'] = false;
            return json_encode($result);
        }

    }

    public function DeleteTaskProject()
    {
        $pid = deCode(Request::input('pid'));
        $tid = deCode(Request::input('tid'));
        $permission = self::TakeProjectPermissions($pid);
        if(in_array(self::$_MANAGE_TASK_PROJECT_PERMISSSION,$permission)) {
            hamahang_project_task::where('project_id', '=', $pid)->where('task_id', '=', $tid)->delete();
            $result['success'] = true;
            return json_encode($result);
        }else{
            $result['error'] = trans('projects.no_permissions');
            $result['success'] = false;
            return json_encode($result);
        }
    }

    public function projectDelete()
    {
        $pid = deCode(Request::input('pid'));
        $permission = self::TakeProjectPermissions($pid);
        if(!in_array(self::$_MANAGE_PROJECT_PERMISSSION,$permission)) {
            $result['error'] = trans('projects.no_permissions');
            $result['success'] = false;
            return json_encode($result);
        }else{
            project_permissions::where('project_id', '=', $pid)->delete();
            project_role_permission::where('project_id', '=', $pid)->delete();
            hamahang_project_responsible::where('project_id', '=', $pid)->delete();
            hamahang_subject_ables::where('target_id', '=', $pid)->delete();
            project_keyword::where('project_id', '=', $pid)->delete();
            task_project::where('id', '=', $pid)->delete();
            return json_encode(['success' => true]);
        }
    }

    private function find_start_date($id)
    {
        $relation = DB::table('hamahang_project_task_relations')
            ->join('hamahang_task', 'hamahang_project_task_relations.second_task_id', '=', 'hamahang_task.id')
            ->whereNull('hamahang_project_task_relations.deleted_at')
            ->where('first_task_id', '=', $id)
            ->select('hamahang_project_task_relations.first_task_id', 'hamahang_project_task_relations.second_task_id', 'hamahang_project_task_relations.relation', 'hamahang_task.duration_day as duration')
            ->get();
        $arr_rel[] = 0;
        if ($relation->count() > 0)
        {
            foreach ($relation as $rel)
            {
                switch ($rel->relation)
                {
                    case 0:
                    {
                        $arr_rel[] = $this->find_start_date($rel->second_task_id);
                        break;
                    }
                    case 1:
                    {
                        $arr_rel[] = $this->find_end_date($rel->second_task_id, $rel->duration);
                        break;
                    }
                    default :
                        break;
                }
            }
        }
        else
        {
            $arr_rel[] = 0;
        }
        $this->day_count = max($arr_rel);
        return $this->day_count;
    }

    private function find_end_date($id, $dur)
    {
        $start = $this->find_start_date($id);
        $relation = DB::table('hamahang_project_task_relations')
            ->join('hamahang_task', 'hamahang_project_task_relations.second_task_id', '=', 'hamahang_task.id')
            ->whereNull('hamahang_project_task_relations.deleted_at')
            ->where('first_task_id', '=', $id)
            ->select('hamahang_project_task_relations.first_task_id', 'hamahang_project_task_relations.second_task_id', 'hamahang_project_task_relations.relation', 'hamahang_task.duration_day as duration')
            ->get();
        if ($relation->count() > 0)
        {
            $arr_rel[] = $dur;
            if (sizeof($relation) > 0)
            {
                foreach ($relation as $rel)
                {
                    switch ($rel->relation)
                    {
                        case 2:
                        {
                            echo 'st2*';
                            $arr_rel[] = $this->find_start_date($rel->second_task_id);
                            break;
                        }
                        case 3:
                        {
                            echo 'st3*';
                            $arr_rel[] = $this->find_end_date($rel->second_task_id);
                            break;
                        }
                        default:
                            break;
                    }
                }
            }
            return $start + max($arr_rel);
        }
        else
        {
            return $start + $dur;
        }
    }

    private function get_project_task_startdate($id, $duration, $type = 0)
    {
        //dd($this->project_tasks);
        if ($this->is_original_node == 0)
        {
            $this->day_count += $duration;
        }
        $exist = 0;
        $relations = $this->project_task_relations;

        foreach ($relations as $key => $value)
        {
            if ($relations[$key]['relation'] == 0 || $relations[$key]['relation'] == 1)
            {
                if (array_key_exists('first_task_id', $relations[$key]) && $relations[$key]['first_task_id'] == $id)
                {
                    if ($relations[$key]['relation'] == 0)
                    {

                        $exist = 1;
                        $x = array_column($this->project_tasks, 'task_id');
                        $index = array_search($relations[$key]['second_task_id'], $x);
                        $dur = $this->project_tasks[$index]['duration_day'];
                        if ($dur == '')
                        {
                            $dur = 2;
                        }
                        if ($this->is_original_node == 1)
                        {
                            $this->second_task_duration = $dur;
                        }
                        $this->is_original_node = 0;
                        $this->startdate_probe = $this->get_project_task_startdate($relations[$key]['second_task_id'], $dur);
                    }
                    if ($relations[$key]['relation'] == 1)
                    {

                        $exist = 1;
                        $x = array_column($this->project_tasks, 'task_id');
                        $index = array_search($relations[$key]['second_task_id'], $x);
                        $dur = $this->project_tasks[$index]['duration_day'];
                        if ($dur == '')
                        {
                            $dur = 2;
                        }
                        $this->is_original_node = 0;
                        $this->startdate_probe = $this->get_project_task_startdate($relations[$key]['second_task_id'], $dur);
                    }

                    if ($relations[$key]['relation'] == 2 && $this->is_original_node == 0)
                    {

                        $exist = 1;
                        $x = array_column($this->project_tasks, 'task_id');
                        $index = array_search($relations[$key]['second_task_id'], $x);
                        $dur = $this->project_tasks[$index]['duration_day'];
                        if ($dur == '')
                        {
                            $dur = 2;
                        }
                        $this->is_original_node = 0;
                        $this->startdate_probe = $this->get_project_task_startdate($relations[$key]['second_task_id'], $dur, 1);
                    }

                    if ($relations[$key]['relation'] == 3 && $this->is_original_node == 0)
                    {

                        $exist = 1;
                        $x = array_column($this->project_tasks, 'task_id');
                        $index = array_search($relations[$key]['second_task_id'], $x);
                        $dur = $this->project_tasks[$index]['duration_day'];
                        if ($dur == '')
                        {
                            $dur = 2;
                        }
                        $this->is_original_node = 0;
                        $this->startdate_probe = $this->get_project_task_startdate($relations[$key]['second_task_id'], $dur, 1);
                    }

                    //echo $id."*<br/>";
                    //$exist =1;
                }
            }


        }
//		if($exist == 0)
//		{
        return ($this->day_count) - ($this->second_task_duration);
//			if($this->is_original_node == 0) {
//				return ($this->startdate_probe);
//			}
//			else{
//				return ($this->startdate_probe);
//			}
//		}

    }

    private function getChildren($parent)
    {
        //$x=1;
        //$query = "SELECT * FROM tableName WHERE parent_id = $parent";
        $result = DB::table('hamahang_task_inheritance')->where('hamahang_task_inheritance.parent_task_id', '=', $parent)
            ->join('hamahang_task', 'hamahang_task_inheritance.task_id', '=', 'hamahang_task.id')
            ->join('hamahang_task_assignments', 'hamahang_task_assignments.task_id', '=', 'hamahang_task.id')
            ->join('user', 'user.id', '=', 'hamahang_task_assignments.employee_id')
            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
            ->whereNull('hamahang_task_status.deleted_at')
            ->select('hamahang_task_status.percent', 'hamahang_task_inheritance.task_id', 'hamahang_task.title as name', DB::raw("CONCAT(Name,' ', Family) AS responsible_name"))
            ->get();
        //die(var_dump($result));

        $children = array();
        $i = 0;
        foreach ($result as $r)
        {
            if ($i == 0)
            {
                $this->x++;
            }
            $children[$i] = array();
            $children[$i]['name'] = $r->name;
            $children[$i]['task_id'] = $r->task_id;
            $children[$i]['parent_id'] = $parent;
            $children[$i]['r_name'] = $r->responsible_name;
            $children[$i]['percent'] = $r->percent;
            $children[$i]['children'] = $this->getChildren($r->task_id);
            $i++;
            //echo $r->name.'('.$r->parent.'-'.$r->id.')'.'\r\n';
        }
        return $children;
    }

    public static function MyProjectsPriority($arr, $status_filter = false, $title_filter = false, $respite_filter = false, $official_type = false)
    {
        $projects_roles = DB::table('hamahang_project')
            ->leftJoin('hamahang_project_role_permission', 'project_id','=','hamahang_project.id')
            ->whereRaw('hamahang_project_role_permission.role_id IN (SELECT role_user.role_id FROM role_user WHERE role_user.user_id = ?)', Auth::id())
            ->whereNull('hamahang_project_role_permission.deleted_at')
            ->whereNull('hamahang_project.deleted_at')
            ->select('hamahang_project.id');
        $projects_user = DB::table('hamahang_project')
            ->leftJoin('hamahang_project_user_permission', 'project_id','=','hamahang_project.id')
            ->whereNull('hamahang_project_user_permission.deleted_at')
            ->whereNull('hamahang_project.deleted_at')
            ->where('hamahang_project_user_permission.user_id','=',Auth::id())
            ->unionAll($projects_roles)
            ->pluck('hamahang_project.id')->unique()->toArray();
//        $projects_user_new = [];
//        foreach($projects_user as $project){
//            if(!in_array($project,$projects_user_new))
//                $projects_user_new[] = $project;
//        }
//        dd($projects_user, $projects_user_new);

        $projects_roles = task_project::whereIn('hamahang_project.id',$projects_user)
            ->select(DB::raw('CONCAT(Name, " ", Family) AS full_name'), 'hamahang_project.title', 'hamahang_project.draft', 'hamahang_project.status', 'hamahang_project.immediate', 'hamahang_project.progress', 'hamahang_project.importance', 'hamahang_project.end_date', 'hamahang_project.start_date', 'hamahang_project.id')
            ->leftJoin('hamahang_project_role_permission','hamahang_project_role_permission.project_id','=','hamahang_project.id')
            ->leftJoin('hamahang_project_responsible','hamahang_project_responsible.project_id','=','hamahang_project.id')
//            ->whereNull('hamahang_project_responsible.deleted_at')
            ->leftJoin('user','user.id','=','hamahang_project_responsible.user_id')
            ->leftJoin('hamahang_project_user_permission','hamahang_project_user_permission.project_id','=','hamahang_project.id')
        ;

        if (Request::exists('subject_id'))
        {
            $projects_roles->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_project.id')
                ->where('hamahang_subject_ables.subject_id', '=',Request::input('subject_id')/10)
                ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\task_project')
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $title = Request::exists('title') ? Request::input('title') : '';
        if (trim($title))
        {
            $projects_roles->where('hamahang_project.title', 'like', '%'.$title.'%');
        }
//        $official_type = Request::get('official_type');
//        if ($official_type)
//        {
//            $projects_roles->whereIn('hamahang_project.type', $official_type)
//                ->whereNull('hamahang_project.deleted_at');
//        }
//        else
//        {
//            $projects_roles->whereIn('hamahang_project.type', [11]);
//        }
        if(Request::exists('keywords'))
        {
            $search_task_keywords = [];
            foreach(Request::input('keywords') as $keyword)
            {
                $search_task_keywords[] = preg_replace('/exist_in/','',$keyword);
            }
            if ($search_task_keywords)
            {
                $projects_roles->join('hamahang_project_keyword', 'hamahang_project_keyword.project_id', '=', 'hamahang_project.id')
                    ->whereIn('hamahang_project_keyword.keyword_id', $search_task_keywords);
            }
        }
        if(Request::exists('users'))
        {
            $projects_roles->where(function ($result) {
                $result
                    ->whereIn('hamahang_project.uid', Request::input('users'))
                    ->orWhereIn('hamahang_project_responsible.user_id', Request::input('users'));
            });
        }
        $task_important_immediate = Request::input('task_important_immediate');
        if(is_array(Request::input('task_important_immediate'))){
            $projects_roles->where(function($q) use ($task_important_immediate) {
                foreach($task_important_immediate as $Atask_important_immediate)
                {
                    if($Atask_important_immediate == 0)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_project.immediate', 0)
                                ->whereNull('hamahang_project.deleted_at')
                                ->where('hamahang_project.importance', 0)
                                ->whereNull('hamahang_project.deleted_at');
                        });

                    }else if($Atask_important_immediate == 1)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_project.immediate', 1)
                                ->whereNull('hamahang_project.deleted_at')
                                ->where('hamahang_project.importance', 0)
                                ->whereNull('hamahang_project.deleted_at');
                        });
                    }else if($Atask_important_immediate == 2)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_project.immediate', 0)
                                ->whereNull('hamahang_project.deleted_at')
                                ->where('hamahang_project.importance', 1)
                                ->whereNull('hamahang_project.deleted_at');
                        });
                    }else if($Atask_important_immediate == 3)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_project.immediate', 1)
                                ->whereNull('hamahang_project.deleted_at')
                                ->where('hamahang_project.importance', 1)
                                ->whereNull('hamahang_project.deleted_at');
                        });
                    }
                }
            });
        }
        $task_final[] = 1;
        if(is_array(Request::input('task_status')))
        {
            if(in_array('10',Request::input('task_status')))
            {
                $task_final[] = 0;
            }
        }
        if ($task_final)
        {
            $projects_roles->whereIn('hamahang_project.draft', $task_final)
                ->whereNull('hamahang_project.deleted_at');
        }
        else
        {
            $projects_roles->whereIn('hamahang_task.is_save', [11]);
        }
        $task_status = Request::input('task_status');
//        $projects_roles->where(function($q) use ($task_status) {
//            if(is_array($task_status))
//                $task_status = array_diff($task_status, ["10"]);
//            if(count($task_status)){
//                foreach($task_status as $a_status){
//                    if($a_status == 0){
//                        $q->orWhere(function($q) {
//                            $q->where('hamahang_project.progress', '=', 0);
//                        });
//
//                    }else if($a_status == 1){
//                        $q->orWhere(function($q) {
//                            $q->where('hamahang_project.progress', '>', 0)->where('hamahang_project.progress', '<', 100);
//                        });
//                    }else if($a_status == 2){
//                        $q->orWhere(function($q) {
//                            $q->where('hamahang_project.progress', '=', 100);
//                        });
//                    }
//                }
//            }else{
//                $q->orWhere(function($q) {
//                    $q->where('hamahang_project.progress', '=', 200);
//                });
//            }
//        });

        $projects = $projects_roles->groupBy('hamahang_project.id')->orderBy('hamahang_project.id', 'desc')->get();
        $res['projects_immediate_importance'] = [];
        $res['projects_not_immediate_importance'] = [];
        $res['projects_immediate_not_importance'] = [];
        $res['projects_not_immediate_not_importance'] = [];
        foreach($projects as $project)
        {
            //project_info
            if($project->immediate==1 && $project->importance==1)
            {
                $res['projects_immediate_importance'][] = $project;
            }elseif($project->immediate==0 && $project->importance==1)
            {
                $res['projects_not_immediate_importance'][] = $project;
            }elseif($project->immediate==1 && $project->importance==0)
            {
                $res['projects_immediate_not_importance'][] = $project;
            }elseif($project->immediate==0 && $project->importance==0)
            {
                $res['projects_not_immediate_not_importance'][] = $project;
            }
        }
        return $res;
    }
    public function ProjectsPriorityFilter()
    {
        $res = self::MyProjectsPriority([],[0,1],false,false,[0,1]);
//        dd($res);
        $result['data'] = view('hamahang.Tasks.projects.priority_content', $res)->render();
        $result['success'] = true;
        return json_encode($result);
//        dd($res);
//        return view('hamahang.Tasks.MyAssignedTask.priority', $arr);
    }
    public function ProjectsPriority($uname)
    {
        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.tasks.my_assigned_tasks.priority':
                $arr = variable_generator('page', 'desktop', $uname);
                $arr['filter_subject_id'] = $arr["sid"];
                $arr = array_merge($arr, self::MyProjectsPriority($arr,[0,1],false,false,[0,1]));
                return view('hamahang.Tasks.MyAssignedTask.priority', $arr);
                break;
            case 'ugc.desktop.hamahang.project.priority':
                $arr = variable_generator('user', 'desktop', $uname);
                $arr = array_merge($arr, self::MyProjectsPriority($arr,[0,1],false,false,[0,1]));
                return view('hamahang.Tasks.projects.priority', $arr);
                break;
        }
    }
    public function ChangeTaskRelation()
    {
        $permissions = self::TakeProjectPermissions(deCode(Request::input('pid')));
        $responsibes = self::TakeProjectResponsible(deCode(Request::input('pid')));
        $message = trans('projects.no_permissions');
        $project = 0;
        $doing = 0;
        if(in_array(self::$_MANAGE_TASK_PROJECT_PERMISSSION, $permissions)) {
            $cnt = 0;
            $doing++;
            foreach(Request::input('task_project_weight') as $key=>$weight)
            {
                $split_weight = preg_split('/-/',$key);
                if($split_weight[0]=='parent')
                {
                    $project += (float) Request::input('task_project_progress')[$split_weight[2]] * $weight;
                    DB::table('hamahang_project_task')->where('id','=', (int) $split_weight[1])->update(['weight'=>(float) $weight]);
                }else{
                    DB::table('hamahang_task_relations')->where('id','=', (int) $split_weight[1])->update(['weight'=>(float) $weight]);
                }
                $cnt ++;
            }
            $message = trans('projects.change_progress_permissions');
        }
        if(in_array(self::$_PROJECT_MANAGER, $responsibes)) {
            $doing++;
            foreach(Request::input('task_project_progress') as $key=>$progress)
            {
                DB::table('hamahang_task')->where('id','=', (int) $key)->update(['progress'=>(float) $progress]);
                task_status::create_task_status($key, 1, $progress, Auth::id(), time());
            }

            $message = trans('projects.change_weights_permissions');
        }
        if($doing ==2 ){
            DB::table('hamahang_project')->where('id','=', (int) deCode(Request::input('pid')))->update(['progress'=>(float) $project/100]);
            return json_encode(['success'=>true, 'project'=>$project/100, 'message'=>$message]);
        }else if(trim($message)==trans('projects.no_permissions')){
            return json_encode(['success'=>false, 'message'=>$message]);
        }else{
            return json_encode(['success'=>false, 'message'=>$message]);
        }
    }
    public function project_tasks_list($pid)
    {
        $hashed_id = $pid;
        $pid = deCode($pid);
        date_default_timezone_set('Asia/Tehran');

        $res = [];
        $hamahang_project_task = DB::table('hamahang_project_task')
            ->where('project_id', '=', $pid)
            ->whereNull('deleted_at')
            ->pluck('task_id','id')->toArray();
        $task_project = [];
        foreach($hamahang_project_task as $k=>$v)
        {
            $task_project[$v] = $k;
        }
        $res['project_task_relations'] =  DB::table('hamahang_task_relations')
            ->leftjoin('hamahang_task as t1', 't1.id', '=', 'hamahang_task_relations.task_id1')
            ->leftjoin('hamahang_task as t2', 't2.id', '=', 'hamahang_task_relations.task_id2')
            ->whereIn('hamahang_task_relations.task_id1', $hamahang_project_task)
            ->whereIn('hamahang_task_relations.task_id2', $hamahang_project_task)
            ->whereNull('hamahang_task_relations.deleted_at')
            ->whereNull('t1.deleted_at')
            ->whereNull('t2.deleted_at')
            ->select("hamahang_task_relations.*", "t1.title as title1", "t2.title as title2")
            ->get();

        $end_start = [];
        $down_up = [];
        $res['parents'] = [];
        $res['childs'] = [];
        foreach($res['project_task_relations'] as $project_task_relation)
        {
            if($project_task_relation->relation == 'end_start')
                $end_start[$project_task_relation->task_id1] = $project_task_relation;
            else if($project_task_relation->relation == 'up')
            {
                $down_up[$project_task_relation->task_id1] = $project_task_relation;
                if(!in_array($project_task_relation->task_id2,$res['childs']))
                {
                    $res['parents'][$project_task_relation->task_id1][] = ['id'=>$project_task_relation->task_id2, 'rel'=>$project_task_relation->id];
                    $res['childs'][] = $project_task_relation->task_id2;
                }
            }
        }

        $hamahang_project_task = tasks::leftjoin('hamahang_project_task', 'hamahang_project_task.task_id', '=', 'hamahang_task.id')
            ->where('project_id', '=', $pid)
            ->whereNull('hamahang_project_task.deleted_at')
            ->select('hamahang_project_task.*', 'hamahang_task.*', 'hamahang_project_task.id as hp_task')
            ->get();
        $project_tasks = [];
        foreach($hamahang_project_task as $task)
        {
            $project_tasks[$task->id] = $task;
        }
        $res['end_start'] =  $end_start;
        $res['down_up'] =  $down_up;
        $res['task_project'] =  $task_project;
        $res['project_info'] =  $project_info = $this->ProjectInfo();
        $res['hamahang_project_task'] =  $hamahang_project_task;
        $res['ordered_project_tasks'] =  $project_tasks;
        $res['pid'] =  $pid;
        $res['hashed_id'] =  $hashed_id;
//        dd($res['hamahang_project_task'][0]->Assignment->Employee);
        return $res;
    }

    public function project_tasks($pid)
    {
        date_default_timezone_set('Asia/Tehran');
        $res = [];
        $hamahang_project_task = DB::table('hamahang_project_task')
            ->where('project_id', '=', $pid)
            ->whereNull('deleted_at')
            ->pluck('task_id')->toArray();

        $res['project_task_relations'] =  DB::table('hamahang_task_relations')
            ->leftjoin('hamahang_task as t1', 't1.id', '=', 'hamahang_task_relations.task_id1')
            ->leftjoin('hamahang_task as t2', 't2.id', '=', 'hamahang_task_relations.task_id2')
            ->whereIn('hamahang_task_relations.task_id1', $hamahang_project_task)
            ->whereIn('hamahang_task_relations.task_id2', $hamahang_project_task)
            ->whereNull('hamahang_task_relations.deleted_at')
            ->select("hamahang_task_relations.*", "t1.title as title1", "t2.title as title2")
            ->get();

        $end_start = [];
        $down_up = [];
        foreach($res['project_task_relations'] as $project_task_relation)
        {
            if($project_task_relation->relation == 'end_start')
                $end_start[$project_task_relation->task_id1] = $project_task_relation;
            else if($project_task_relation->relation == 'down')
                $down_up[$project_task_relation->task_id1] = $project_task_relation;

        }

        $res['project_task_relations_begins'] =  DB::table('hamahang_task as ht')
            ->whereNotExists(function ($query) {
                $query->select(\DB::raw(1))
                    ->from('hamahang_task_relations')
                    ->where('hamahang_task_relations.relation','=','end_start')
                    ->whereRaw('hamahang_task_relations.task_id2 = ht.id');
            })
            ->whereExists(function ($query) {
                $query->select(\DB::raw(1))
                    ->from('hamahang_task_relations')
                    ->where('hamahang_task_relations.relation','=','end_start')
                    ->whereRaw('hamahang_task_relations.task_id1 = ht.id');
            })
            ->whereIn('ht.id', $hamahang_project_task)
            ->get()
        ;

        $res['project_task_relations_up'] =  DB::table('hamahang_task as ht')
            ->whereNotExists(function ($query) {
                $query->select(\DB::raw(1))
                    ->from('hamahang_task_relations')
                    ->where('hamahang_task_relations.relation','=','down')
                    ->whereRaw('hamahang_task_relations.task_id2 = ht.id');
            })
            ->whereExists(function ($query) {
                $query->select(\DB::raw(1))
                    ->from('hamahang_task_relations')
                    ->where('hamahang_task_relations.relation','=','down')
                    ->whereRaw('hamahang_task_relations.task_id1 = ht.id');
            })
            ->whereIn('ht.id', $hamahang_project_task)
            ->get()
        ;


        $hamahang_project_task = DB::table('hamahang_project_task')
            ->where('project_id', '=', $pid)
            ->leftjoin('hamahang_task', 'hamahang_task.id', '=', 'hamahang_project_task.task_id')
            ->whereNull('hamahang_project_task.deleted_at')
            ->get();
        $project_tasks = [];
        foreach($hamahang_project_task as $task)
        {
            $project_tasks[$task->id] = $task;
        }
        $res['end_start'] =  $end_start;
        $res['down_up'] =  $down_up;
        $res['project_info'] =  $project_info = $this->ProjectInfo();
        $res['hamahang_project_task'] =  $hamahang_project_task;
        $res['ordered_project_tasks'] =  $project_tasks;
        return $res;
    }

    public function project_gantt_data($pid)
    {
        date_default_timezone_set('Asia/Tehran');
        $arr = [];
        $project_startdate = DB::table('hamahang_project')->where('id', '=', $pid)->first()->start_date;

        $project_task_relations = DB::table('hamahang_project_task_relations')
            ->where('project_id', '=', $pid)
            ->whereNull('deleted_at')
            ->select('first_task_id', 'second_task_id', 'relation')
            ->get();
        //die(var_dump($project_task_relations));
        //$this->project_task_relations = get_object_vars($project_task_relations);
        $this->project_task_relations = collect($project_task_relations)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        //$this->get_project_task_startdate($this->project_task_relations);

        $ProjectTasks = DB::table('hamahang_project_task')
            ->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_project_task.task_id')
            ->whereNull('hamahang_project_task.deleted_at')
            ->where('hamahang_project_task.project_id', '=', $pid)
            ->select('hamahang_project_task.task_id', 'hamahang_task.duration_day', 'hamahang_task.title')
            ->get();

        $this->project_tasks = collect($ProjectTasks)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        echo 'Project_start_date : ' . $project_startdate . '<hr/>';
//		foreach ($ProjectTasks as $pt) {
//			$this->day_count = 0;
//			$this->is_original_node = 1;
//			//$this->startdate_probe = $project_startdate;
//			$this->get_project_task_startdate($pt->task_id, $pt->duration_day);
//			echo $pt->st_date = $pt->task_id . '->' . (($this->day_count) * 86400 + $project_startdate);
//			echo '<br/>' . $this->day_count;
//			echo '<br/>';
//			//echo $pt->st_date;
//
//		}
        $arr_tasks_start = [];
        $arr_final = [];
        foreach ($ProjectTasks as $pt)
        {
            echo '<hr/>';
            $this->day_count = 0;
            $this->is_original_node = 1;
            //$this->startdate_probe = $project_startdate;
            $relation = DB::table('hamahang_project_task_relations')
                ->join('hamahang_task', 'hamahang_project_task_relations.second_task_id', '=', 'hamahang_task.id')
                ->whereNull('hamahang_project_task_relations.deleted_at')
                ->where('first_task_id', '=', $pt->task_id)
                ->select('hamahang_project_task_relations.first_task_id', 'hamahang_project_task_relations.second_task_id', 'hamahang_project_task_relations.relation', 'hamahang_task.duration_day as duration')
                ->count();
            if ($relation > 0)
            {
                $st = $this->find_start_date($pt->task_id);
                echo 'Returned value for task_id ' . $pt->task_id . ' is ' . $st . '<hr/>';
                array_push($arr_tasks_start, ['id' => $pt->task_id, 'start_date' => date('d-m-Y', $project_startdate + ($st * 86400)), 'duration' => $pt->duration_day, 'order' => 10, 'progress' => 0.5, 'parent' => 1]);
            }    //echo $pt->st_date = $pt->task_id . '->' . (($this->day_count) * 86400 + $project_startdate);
            //echo '<br/>' . $this->day_count;
            elseif ($relation == 0)
            {
                echo 'task_id ' . $pt->task_id . ' Direct Start';
                array_push($arr_tasks_start, ['id' => $pt->task_id, 'start_date' => date('d-m-Y', $project_startdate), 'duration' => $pt->duration_day, 'order' => 10, 'progress' => 0.5, 'parent' => 1]);
            }
            echo '<hr/>';
            echo '<br/>';
            //echo $pt->st_date;

        }
        $relation = DB::table('hamahang_project_task_relations')
            ->join('hamahang_task', 'hamahang_project_task_relations.second_task_id', '=', 'hamahang_task.id')
            ->whereNull('hamahang_project_task_relations.deleted_at')
            ->where('project_id', '=', 9)
            ->select('hamahang_project_task_relations.id', 'hamahang_project_task_relations.first_task_id as source', 'hamahang_project_task_relations.second_task_id as target', 'hamahang_project_task_relations.relation as type')
            ->get();

        echo "project start at : " . date('Y-m-d', $project_startdate);
        //echo "project start at : ".jdate($project_startdate);
        $arr_final['data'] = $arr_tasks_start;
        $arr_final['links'] = $relation;
        dd(json_encode($arr_final));
        die('END');
        $arr['data'] = $ProjectTasks;


    }

    public function prepare_gantt_data()
    {

        date_default_timezone_set('Asia/Tehran');
        $arr = [];
        $project_startdate = DB::table('hamahang_project')->where('id', '=', 2)->first()->start_date;

        $project_task_relations = DB::table('hamahang_project_task_relations')
            ->where('project_id', '=', 9)
            ->whereNull('deleted_at')
            ->select('first_task_id', 'second_task_id', 'relation')
            ->get();
        $this->project_task_relations = collect($project_task_relations)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $ProjectTasks = DB::table('hamahang_project_task')
            ->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_project_task.task_id')
            ->whereNull('hamahang_project_task.deleted_at')
            ->where('hamahang_project_task.project_id', '=', 9)
            ->select('hamahang_project_task.task_id', 'hamahang_task.duration_day', 'hamahang_task.title')
            ->get();

        $this->project_tasks = collect($ProjectTasks)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $arr_tasks_start = [];
        $arr_final = [];
        foreach ($ProjectTasks as $pt)
        {
            $this->day_count = 0;
            $this->is_original_node = 1;
            //$this->startdate_probe = $project_startdate;
            $relation = DB::table('hamahang_project_task_relations')
                ->join('hamahang_task', 'hamahang_project_task_relations.second_task_id', '=', 'hamahang_task.id')
                ->whereNull('hamahang_project_task_relations.deleted_at')
                ->where('first_task_id', '=', $pt->task_id)
                ->select('hamahang_project_task_relations.first_task_id', 'hamahang_project_task_relations.second_task_id', 'hamahang_project_task_relations.relation', 'hamahang_task.duration_day as duration')
                ->count();
            if ($relation > 0)
            {
                $st = $this->find_start_date($pt->task_id);
                array_push($arr_tasks_start, ['id' => $pt->task_id, 'text' => $pt->title, 'start_date' => date('d-m-Y', $project_startdate + ($st * 86400)), 'duration' => $pt->duration_day, 'progress' => 0.5, 'open' => true]);
            }
            elseif ($relation == 0)
            {
                array_push($arr_tasks_start, ['id' => $pt->task_id, 'text' => $pt->title, 'start_date' => date('d-m-Y', $project_startdate), 'duration' => $pt->duration_day, 'progress' => 0.5, 'open' => true]);
            }

        }
        $relation = DB::table('hamahang_project_task_relations')
            ->join('hamahang_task', 'hamahang_project_task_relations.second_task_id', '=', 'hamahang_task.id')
            ->whereNull('hamahang_project_task_relations.deleted_at')
            ->where('project_id', '=', 9)
            ->select('hamahang_project_task_relations.id', 'hamahang_project_task_relations.first_task_id as source', 'hamahang_project_task_relations.second_task_id as target', 'hamahang_project_task_relations.relation as type')
            ->get();
        foreach ($relation as $rel)
        {
            if ($rel->type == 0)
            {
                $rel->type = 1;
            }
            elseif ($rel->type == 1)
            {
                $rel->type = 3;
            }
            elseif ($rel->type == 2)
            {
                $rel->type = 0;
            }
            elseif ($rel->type == 3)
            {
                $rel->type = 2;
            }


        }
        //dd($arr_tasks_start);
        $arr_final['data'] = $arr_tasks_start;
        $arr_final['links'] = $relation;
        return json_encode($arr_final);

    }

    public function UserProjects()
    {

        $x = Request::input('data');
        $data = DB::table('hamahang_project')->select("id as id", "title")->where("title", "LIKE", "%" . $x['q'] . "%")->where('uid', '=', Auth::id())->get();
        foreach ($data as $t)
        {
            $t->text = $t->title;
        }
        $data = array('results' => $data);
        return response()->json($data);

    }

    public function ProjectTasks($uname, $id)
    {

        $project_childs = DB::table('hamahang_project_task')
            ->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_project_task.task_id')
            ->join('hamahang_task_assignments', 'hamahang_task_assignments.task_id', '=', 'hamahang_project_task.task_id')
            ->join('user', 'user.id', '=', 'hamahang_task_assignments.employee_id')
            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_project_task.task_id')
            ->whereNull('hamahang_task_status.deleted_at')
            ->where('hamahang_project_task.project_id', '=', 2)->select('hamahang_task_status.percent', 'hamahang_project_task.task_id', 'title', DB::raw("CONCAT(Name,' ', Family) AS responsible_name"))->get();
        $FirstLevelTasks = [];
        foreach ($project_childs as $child)
        {
            //$finalResult = $this->getChildren_type2($child->task_id);
            array_push($FirstLevelTasks, ['name' => $child->title, 'id' => $child->task_id, 'r_name' => $child->responsible_name]);
        }

    }

    public function HirericalView($uname, $id)
    {

        $project_childs = DB::table('hamahang_project_task')
            ->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_project_task.task_id')
            ->join('hamahang_task_assignments', 'hamahang_task_assignments.task_id', '=', 'hamahang_project_task.task_id')
            ->join('user', 'user.id', '=', 'hamahang_task_assignments.employee_id')
            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_project_task.task_id')
            ->whereNull('hamahang_task_status.deleted_at')
            ->where('hamahang_project_task.project_id', '=', 2)->select('hamahang_task_status.percent', 'hamahang_project_task.task_id', 'title', DB::raw("CONCAT(Name,' ', Family) AS responsible_name"))->get();
        //
        //die(var_dump($project_childs));
        $FirstLevelTasks = [];
        foreach ($project_childs as $child)
        {
            $finalResult = $this->getChildren($child->task_id);
            array_push($FirstLevelTasks, ['percent' => $child->percent, 'name' => $child->title, 'task_id' => $child->task_id, 'parent_id' => 0, 'r_name' => $child->responsible_name, 'children' => $finalResult]);
        }
        $this->printList($FirstLevelTasks);
        //echo '<hr/>';
        //echo $this->x;

        $dd = collect($FirstLevelTasks)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $result['data'] = $dd;
        return json_encode($result);

    }

    public function HirericalViewChild($uname, $id)
    {

//		$project_childs = DB::table('hamahang_project_task')
//			->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_project_task.task_id')
//			->join('hamahang_task_assignments', 'hamahang_task_assignments.task_id', '=', 'hamahang_project_task.task_id')
//			->join('user', 'user.id', '=', 'hamahang_task_assignments.employee_id')
//			->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_project_task.task_id')
//			->whereNull('hamahang_task_status.deleted_at')
//			->where('hamahang_project_task.project_id', '=', $id)->select('hamahang_task_status.percent', 'hamahang_project_task.task_id', 'title', DB::raw("CONCAT(Name,' ', Family) AS responsible_name"))->get();
//		//die(dd(DB::getQueryLog()));
        //die(var_dump($project_childs));
        //	$FirstLevelTasks = [];
        //	foreach ($project_childs as $child) {
        $finalResult = $this->getChildren($id);
        //array_push($FirstLevelTasks, ['percent' => $child->percent, 'name' => $child->title, 'task_id' => $child->task_id, 'parent_id' => 0, 'r_name' => $child->responsible_name, 'children' => $finalResult]);
        //	}
        //$this->printList($FirstLevelTasks);
        //echo '<hr/>';
        //echo $this->x;

        $dd = collect($finalResult)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $result['data'] = $dd;
        return json_encode($result);

    }

    public function printList($array = null)
    {
        if (count($array))
        {
            echo "<ul>";

            foreach ($array as $item)
            {
                echo "<li>";

                echo $item['task_id'] . '-' . $item['name'] . ':parent => ' . $item['parent_id'] . ' (responsible ) : ' . $item['r_name'] . ' (percent ) : ' . $item['percent'];
                if (count($item['children']))
                {
                    $this->printList($item['children']);
                }
                echo "</li>";
            }

            echo "</ul>";
        }

    }

    public function FetchRelation()
    {
        $total = DB::table('hamahang_project_task_relations')
            ->leftJoin('hamahang_task as first', 'first.id', '=', 'hamahang_project_task_relations.first_task_id')
            ->leftJoin('hamahang_task as second', 'second.id', '=', 'hamahang_project_task_relations.second_task_id')
            ->where('hamahang_project_task_relations.project_id', '=', Request::input('id'))
            ->whereNull('hamahang_project_task_relations.deleted_at')
            ->select('hamahang_project_task_relations.id', 'hamahang_project_task_relations.relation', 'first.title as title_f', 'second.title as title_s')
            ->get();
        foreach ($total as $r)
        {
            switch ($r->relation)
            {
                case 'start_start':
                {
                    $r->relation = 'شروع به شروع';
                    break;
                }
                case 'start_end':
                {
                    $r->relation = 'شروع به پایان';
                    break;
                }
                case 'end_start':
                {
                    $r->relation = 'پایان به شروع';
                    break;
                }
                case 'end_end':
                {
                    $r->relation = 'پایان به پایان';
                    break;
                }
            }
        }
        $dd = collect($total)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $result['data'] = $dd;
        return json_encode($result);
    }

    public function RemoveProjectTaskRelation()
    {

        $current = project_task_relation::where('id', '=', Request::input('id'))->update(['deleted_at' => 1]);
        return json_encode('ok');
    }

    public function AddProjectTaskRelation()
    {
        $exist_relations = project_task_relation::where('first_task_id', '=', Request::input('f_task'))
            ->where('second_task_id', '=', Request::input('s_task'))
            ->where('relation', '=', Request::input('r_type'))
            ->whereNull('deleted_at')
            ->get();
        //die(Request::input('r_type'));
        if (sizeof($exist_relations) == 0)
        {
            switch (Request::input('r_type'))
            {
                case 'start_start':
                {
                    DB::enableQueryLog();
                    $exist_relations1 = project_task_relation::where('first_task_id', '=', Request::input('f_task'))
                        ->where('second_task_id', '=', Request::input('s_task'))
                        ->where('relation', '=', 'end_start')
                        ->get();
                    $exist_relations2 = project_task_relation::where('first_task_id', '=', Request::input('f_task'))
                        ->where('second_task_id', '=', Request::input('s_task'))
                        ->where('relation', '=', 'start_end')
                        ->get();
                    $exist_relations3 = project_task_relation::where('first_task_id', '=', Request::input('s_task'))
                        ->where('second_task_id', '=', Request::input('f_task'))
                        ->where('relation', '=', 'start_start')
                        ->get();
                    if (sizeof($exist_relations1) == 0 && sizeof($exist_relations2) == 0 && sizeof($exist_relations3) == 0)
                    {

                        $relation = new project_task_relation;
                        $relation->project_id = Request::input('id');
                        $relation->first_task_id = Request::input('f_task');
                        $relation->second_task_id = Request::input('s_task');
                        $relation->relation = Request::input('r_type');
                        $relation->uid = Auth::id();
                        $relation->save();
                    }
                    break;
                }
                case 'start_end':
                {
                    $exist_relations1 = project_task_relation::where('first_task_id', '=', Request::input('f_task'))
                        ->where('second_task_id', '=', Request::input('s_task'))
                        ->where('relation', '=', 'end_start')
                        ->whereNull('deleted_at')
                        ->get();
                    $exist_relations2 = project_task_relation::where('first_task_id', '=', Request::input('f_task'))
                        ->where('second_task_id', '=', Request::input('s_task'))
                        ->where('relation', '=', 'start_start')
                        ->whereNull('deleted_at')
                        ->get();
                    $exist_relations3 = project_task_relation::where('first_task_id', '=', Request::input('f_task'))
                        ->where('second_task_id', '=', Request::input('s_task'))
                        ->where('relation', '=', 'end_end')
                        ->whereNull('deleted_at')
                        ->get();
                    if (sizeof($exist_relations1) == 0 && sizeof($exist_relations2) == 0 && sizeof($exist_relations3) == 0)
                    {
                        $relation = new project_task_relation;
                        $relation->project_id = Request::input('id');
                        $relation->first_task_id = Request::input('f_task');
                        $relation->second_task_id = Request::input('s_task');
                        $relation->relation = Request::input('r_type');
                        $relation->uid = Auth::id();
                        $relation->save();
                    }
                    break;
                }
                case 'end_start':
                {
                    $exist_relations1 = project_task_relation::where('first_task_id', '=', Request::input('s_task'))
                        ->where('second_task_id', '=', Request::input('f_task'))
                        ->where('relation', '=', 'start_end')
                        ->whereNull('deleted_at')
                        ->get();
                    $exist_relations2 = project_task_relation::where('first_task_id', '=', Request::input('f_task'))
                        ->where('second_task_id', '=', Request::input('s_task'))
                        ->where('relation', '=', 'end_end')
                        ->whereNull('deleted_at')
                        ->get();
                    if (sizeof($exist_relations1) == 0 && sizeof($exist_relations2) == 0)
                    {
                        $relation = new project_task_relation;
                        $relation->project_id = Request::input('id');
                        $relation->first_task_id = Request::input('f_task');
                        $relation->second_task_id = Request::input('s_task');
                        $relation->relation = Request::input('r_type');
                        $relation->uid = Auth::id();
                        $relation->save();
                    }
                    break;
                }
                case 'end_end':
                {
                    $exist_relations1 = project_task_relation::where('first_task_id', '=', Request::input('f_task'))
                        ->where('second_task_id', '=', Request::input('s_task'))
                        ->where('relation', '=', 'end_start')
                        ->get();
                    $exist_relations2 = project_task_relation::where('first_task_id', '=', Request::input('f_task'))
                        ->where('second_task_id', '=', Request::input('s_task'))
                        ->where('relation', '=', 'start_end')
                        ->get();
                    $exist_relations3 = project_task_relation::where('first_task_id', '=', Request::input('s_task'))
                        ->where('second_task_id', '=', Request::input('f_task'))
                        ->where('relation', '=', 'end_end')
                        ->get();
                    if (sizeof($exist_relations1) == 0 && sizeof($exist_relations2) == 0 && sizeof($exist_relations3) == 0)
                    {
                        $relation = new project_task_relation;
                        $relation->project_id = Request::input('id');
                        $relation->first_task_id = Request::input('f_task');
                        $relation->second_task_id = Request::input('s_task');
                        $relation->relation = Request::input('r_type');
                        $relation->uid = Auth::id();
                        $relation->save();
                    }
                    break;
                }
            }

        }
        return json_encode(1);

    }

    public function ProjectInfo()
    {
        \Session::put('pid',Request::input('pid'));
        $arr = task_project::project_info(Request::input('pid'));
        return json_encode($arr);
    }

    public function AddProjectTask()
    {

        foreach (Request::input('s_arr') as $tid)
        {
            $find = project_task::where('project_id', '=', Request::input('pid'))->where('task_id', '=', $tid)->count();
            if ($find == 0)
            {
                $task = new project_task;
                $task->project_id = Request::input('pid');
                $task->task_id = $tid;
                $task->uid = Auth::id();
                $task->save();
            }
        }
        return json_encode('ok');

    }

    public function FetchProjects()
    {
        $projects_roles = task_project::leftJoin('hamahang_project_role_permission', 'project_id','=','hamahang_project.id')
            ->whereRaw('hamahang_project_role_permission.role_id IN (SELECT role_user.role_id FROM role_user WHERE role_user.user_id = ?)', Auth::id())
            ->whereNull('hamahang_project_role_permission.deleted_at')
            ->leftJoin('hamahang_project_responsible','hamahang_project_responsible.project_id','=','hamahang_project.id')
            ->leftJoin('user','user.id','=','hamahang_project_responsible.user_id')
            ->whereNull('hamahang_project.deleted_at')->groupBy('hamahang_project.id')
            ->select(DB::raw('CONCAT(Name, " ", Family) AS full_name'), 'hamahang_project.title', 'hamahang_project.draft', 'hamahang_project.status', 'hamahang_project.immediate', 'hamahang_project.progress', 'hamahang_project.importance', 'hamahang_project.end_date', 'hamahang_project.start_date', 'hamahang_project.id');
        $projects_roles = task_project::leftJoin('hamahang_project_user_permission', 'project_id','=','hamahang_project.id')
            ->select(DB::raw('CONCAT(Name, " ", Family) AS full_name'), 'hamahang_project.title', 'hamahang_project.draft', 'hamahang_project.status', 'hamahang_project.immediate', 'hamahang_project.progress', 'hamahang_project.importance', 'hamahang_project.end_date', 'hamahang_project.start_date', 'hamahang_project.id')
            ->leftJoin('hamahang_project_role_permission','hamahang_project_role_permission.project_id','=','hamahang_project.id')
            ->leftJoin('hamahang_project_responsible','hamahang_project_responsible.project_id','=','hamahang_project.id')
//            ->whereNull('hamahang_project_responsible.deleted_at')
            ->leftJoin('user','user.id','=','hamahang_project_responsible.user_id')
            ->whereNull('hamahang_project_user_permission.deleted_at')
            ->whereNull('hamahang_project.deleted_at')
            ->where('hamahang_project_user_permission.user_id','=',Auth::id())->groupBy('hamahang_project.id')
            ->union($projects_roles)
        ;
//            ->pluck('hamahang_project.id')->unique()->toArray();
//        $projects_user_new = [];
//        foreach($projects_user as $project){
//            if(!in_array($project,$projects_user_new))
//                $projects_user_new[] = $project;
//        }
//        dd($projects_user, $projects_user_new);

//        $projects_roles = task_project::whereIn('hamahang_project.id',$projects_user)
//            ->select(DB::raw('CONCAT(Name, " ", Family) AS full_name'), 'hamahang_project.title', 'hamahang_project.draft', 'hamahang_project.status', 'hamahang_project.immediate', 'hamahang_project.progress', 'hamahang_project.importance', 'hamahang_project.end_date', 'hamahang_project.start_date', 'hamahang_project.id')
//            ->leftJoin('hamahang_project_role_permission','hamahang_project_role_permission.project_id','=','hamahang_project.id')
//            ->leftJoin('hamahang_project_responsible','hamahang_project_responsible.project_id','=','hamahang_project.id')
////            ->whereNull('hamahang_project_responsible.deleted_at')
//            ->leftJoin('user','user.id','=','hamahang_project_responsible.user_id')
//            ->leftJoin('hamahang_project_user_permission','hamahang_project_user_permission.project_id','=','hamahang_project.id')
//        ;
        if (Request::exists('subject_id'))
        {
            $projects_roles->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_project.id')
                ->where('hamahang_subject_ables.subject_id', '=',Request::input('subject_id')/10)
                ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\task_project')
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $title = Request::exists('title') ? Request::input('title') : '';
        if (trim($title))
        {
            $projects_roles->where('hamahang_project.title', 'like', '%'.$title.'%');
        }
        $official_type = Request::get('official_type');
        if ($official_type)
        {
            $projects_roles->whereIn('hamahang_project.type', $official_type)
                ->whereNull('hamahang_project.deleted_at');
        }
        else
        {
            $projects_roles->whereIn('hamahang_project.type', [11]);
        }
        if(Request::exists('keywords'))
        {
            $search_task_keywords = [];
            foreach(Request::input('keywords') as $keyword)
            {
                $search_task_keywords[] = preg_replace('/exist_in/','',$keyword);
            }
            if ($search_task_keywords)
            {
                $projects_roles->join('hamahang_project_keyword', 'hamahang_project_keyword.project_id', '=', 'hamahang_project.id')
                    ->whereIn('hamahang_project_keyword.keyword_id', $search_task_keywords);
            }
        }
        if(Request::exists('users'))
        {
            $projects_roles->where(function ($result) {
                $result
                    ->whereIn('hamahang_project.uid', Request::input('users'))
                    ->orWhereIn('hamahang_project_responsible.user_id', Request::input('users'));
            });
        }
        $task_important_immediate = Request::input('task_important_immediate');
        if(is_array(Request::input('task_important_immediate'))){
            $projects_roles->where(function($q) use ($task_important_immediate) {
                foreach($task_important_immediate as $Atask_important_immediate)
                {
                    if($Atask_important_immediate == 0)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_project.immediate', 0)
                                ->whereNull('hamahang_project.deleted_at')
                                ->where('hamahang_project.importance', 0)
                                ->whereNull('hamahang_project.deleted_at');
                        });

                    }else if($Atask_important_immediate == 1)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_project.immediate', 1)
                                ->whereNull('hamahang_project.deleted_at')
                                ->where('hamahang_project.importance', 0)
                                ->whereNull('hamahang_project.deleted_at');
                        });
                    }else if($Atask_important_immediate == 2)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_project.immediate', 0)
                                ->whereNull('hamahang_project.deleted_at')
                                ->where('hamahang_project.importance', 1)
                                ->whereNull('hamahang_project.deleted_at');
                        });
                    }else if($Atask_important_immediate == 3)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_project.immediate', 1)
                                ->whereNull('hamahang_project.deleted_at')
                                ->where('hamahang_project.importance', 1)
                                ->whereNull('hamahang_project.deleted_at');
                        });
                    }
                }
            });
        }
        $task_final[] = 1;
        if(is_array(Request::input('task_status')))
        {
            if(in_array('10',Request::input('task_status')))
            {
                $task_final[] = 0;
            }
        }
        if ($task_final)
        {
            $projects_roles->whereIn('hamahang_project.draft', $task_final)
                ->whereNull('hamahang_project.deleted_at');
        }
        else
        {
            $projects_roles->whereIn('hamahang_task.is_save', [11]);
        }
        $task_status = Request::input('task_status');
        $projects_roles->where(function($q) use ($task_status) {
            if(is_array($task_status))
                $task_status = array_diff($task_status, ["10"]);
            if(count($task_status)){
                foreach($task_status as $a_status){
                    if($a_status == 0){
                        $q->orWhere(function($q) {
                            $q->where('hamahang_project.progress', '=', 0);
                        });

                    }else if($a_status == 1){
                        $q->orWhere(function($q) {
                            $q->where('hamahang_project.progress', '>', 0)->where('hamahang_project.progress', '<', 100);
                        });
                    }else if($a_status == 2){
                        $q->orWhere(function($q) {
                            $q->where('hamahang_project.progress', '=', 100);
                        });
                    }
                }
            }else{
                $q->orWhere(function($q) {
                    $q->where('hamahang_project.progress', '=', 200);
                });
            }
        });

        return \Yajra\Datatables\Facades\Datatables::eloquent($projects_roles)
            ->editColumn('start_date', function ($data)
            {
                return jDateTime::date('Y-m-d',$data->start_date,1,1);
            })
            ->editColumn('pid', function ($data)
            {
                return enCode($data->id);
            })
            ->editColumn('progress', function ($data)
            {
                $out_image = '';
                $out_title = '';
                if($data->draft == 0){
                    $out_image = 'task00.png';
                    $out_title = 'پیش نویس';
                }else if($data->status == 1){
                    $out_image = 'task4.png';
                    $out_title = 'پایان یافته';
                }else if($data->status == 2){
                    $out_image = 'task4.png';
                    $out_title = 'متوقف';
                }else if($data->progress == null || $data->progress==0){
                    $out_image = 'task0.png';
                    $out_title = 'برای انجام';
                }else if($data->progress == 100){
                    $out_image = 'task2.png';
                    $out_title = 'انجا شده';
                }else if($data->progress < 100){
                    $out_image = 'task1.png';
                    $out_title = 'در حال انجام';
                }
                return $data->progress;//['output_image'=>$out_image, 'out_title'=>$out_title];
            })
            ->addColumn('keywords', function ($data)
            {
                $r = (self::ProjectKeywords($data->id));

                $rr = [];
                foreach($r as $Ar)
                    $rr[]= ['id'=>$Ar->id,'title'=>$Ar->title];
                return json_encode($rr);
            })
            ->editColumn('immediate', function ($data)
            {
                if ($data->importance == 1)
                {
                    $output = 'مهم ';
                    $output_num = 'priority1';
                }
                else
                {
                    $output = 'غیرمهم ';
                    $output_num = 'priority0';
                }

                if ($data->immediate == 1)
                {
                    $output .= 'و فوری';
                    $output_num .= '1';
                }
                else
                {
                    $output .= 'و غیرفوری';
                    $output_num .= '0';
                }
                return ['output'=>$output,'output_image'=>$output_num];
            })
            ->editColumn('end_date', function ($data)
            {
                return jDateTime::date('Y-m-d',$data->end_date,1,1);
            })->addColumn('pages', function ($data)
            {
                $pages = DB::table('hamahang_subject_ables')
                    ->where('hamahang_subject_ables.target_id', '=',$data->id)
                    ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\task_project')
                    ->whereNull('hamahang_subject_ables.deleted_at')->pluck('subject_id')->toArray();
                $pages = DB::table('pages')->whereIn('sid',$pages)->groupBy('sid')->pluck('id')->toArray();
                return $pages;
            })
            ->make(true);
    }

    public static function ProjectKeywords($pid)
    {
        $keywords = keywords::select('keywords.title', 'keywords.id')
            ->join('hamahang_project_keyword', 'hamahang_project_keyword.keyword_id', '=', 'keywords.id')
            ->where('hamahang_project_keyword.project_id', '=', $pid)
            ->whereNull('hamahang_project_keyword.deleted_at')
            ->get();
        return $keywords;
    }

    public static function create_task_priority($task_id, $immediate = 0, $importance = 0, $is_assigner = [0], $user_id = -1, $uid = -1, $timestamp = -1)
    {
        if(!is_array($is_assigner))
        {
            $priority = new task_priority;
            $priority->uid = ($uid == -1) ? Auth::id() : $uid;
            $priority->user_id = ($user_id == -1) ? Auth::id() : $user_id;
            $priority->task_id = $task_id;
            $priority->is_assigner = $is_assigner;
            $priority->importance = $importance;
            $priority->immediate = $immediate;
            $priority->timestamp = ($timestamp == -1) ? time() : $timestamp;
            $priority->save();
        }else{
            foreach($is_assigner as $Ais_assigner)
            {
                $priority = new task_priority;
                $priority->uid = ($uid == -1) ? Auth::id() : $uid;
                $priority->user_id = ($user_id == -1) ? Auth::id() : $user_id;
                $priority->task_id = $task_id;
                $priority->is_assigner = $Ais_assigner;
                $priority->importance = $importance;
                $priority->immediate = $immediate;
                $priority->timestamp = ($timestamp == -1) ? time() : $timestamp;
                $priority->save();
            }
        }
        return $priority;
    }
    public function ProjectsState($uname)
    {
        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.project.state':
                $arr = variable_generator('page', 'desktop', $uname);
                //$arr['tasks'] = tasks::FetchTasksForMyAssignedTasksState($uname);
                $arr['filter_subject_id'] = $arr["sid"];
                $arr['MyTasksInState'] = $this->my_assigned_task_in_status($arr)->render();
                return view('hamahang.Tasks.MyAssignedTask.MyAssignedTasksState', $arr);
                break;
            case 'ugc.desktop.hamahang.project.state':
                $arr = variable_generator('user', 'desktop', $uname);
                $arr['attach_files'] = HFM_GenerateUploadForm([['new_process_task', ['pdf', 'jpg', 'zip', 'docx', 'xlsx', 'ppt', 'pptx'], 'Multi']]);
                $arr['MyTasksInState'] = $this->my_project_in_status($arr)->render();
                return view('hamahang.Tasks.projects.MyState', $arr);
                break;
        }
    }
    private function my_project_in_status($arr =[],$user = false)
    {
        $projects_roles = DB::table('hamahang_project')
            ->leftJoin('hamahang_project_role_permission', 'project_id','=','hamahang_project.id')
            ->whereRaw('hamahang_project_role_permission.role_id IN (SELECT role_user.role_id FROM role_user WHERE role_user.user_id = ?)', Auth::id())
            ->whereNull('hamahang_project_role_permission.deleted_at')
            ->whereNull('hamahang_project.deleted_at')
            ->select('hamahang_project.id');
        $projects_user = DB::table('hamahang_project')
            ->leftJoin('hamahang_project_user_permission', 'project_id','=','hamahang_project.id')
            ->whereNull('hamahang_project_user_permission.deleted_at')
            ->whereNull('hamahang_project.deleted_at')
            ->where('hamahang_project_user_permission.user_id','=',Auth::id())
            ->unionAll($projects_roles)
            ->pluck('hamahang_project.id')->unique()->toArray();

        $projects_roles = task_project::whereIn('hamahang_project.id',$projects_user)
            ->select(DB::raw('CONCAT(Name, " ", Family) AS full_name'), 'hamahang_project.title', 'hamahang_project.draft', 'hamahang_project.status', 'hamahang_project.immediate', 'hamahang_project.progress', 'hamahang_project.importance', 'hamahang_project.end_date', 'hamahang_project.start_date', 'hamahang_project.id')
            ->leftJoin('hamahang_project_role_permission','hamahang_project_role_permission.project_id','=','hamahang_project.id')
            ->leftJoin('hamahang_project_responsible','hamahang_project_responsible.project_id','=','hamahang_project.id')
            ->leftJoin('user','user.id','=','hamahang_project_responsible.user_id')
            ->leftJoin('hamahang_project_user_permission','hamahang_project_user_permission.project_id','=','hamahang_project.id')
        ;
        if (Request::exists('subject_id'))
        {
            $projects_roles->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_project.id')
                ->where('hamahang_subject_ables.subject_id', '=',Request::input('subject_id')/10)
                ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\task_project')
                ->whereNull('hamahang_subject_ables.deleted_at');
        }

        $projects = $projects_roles->groupBy('hamahang_project.id')->orderBy('hamahang_project.id', 'desc')->get();
        $myProjects=[];
        foreach($projects as $project){
            if($project->progress == 0)
                $myProjects['not_started'][] = $project;
            else if($project->progress == 100)
                $myProjects['done'][] = $project;
            else
                $myProjects['started'][] = $project;
        }
        return view('hamahang.Tasks.projects.state', $myProjects);

    }
    public function change_projects_priority()
    {
        $validator = Validator::make(Request::all(),
            [
                'type' => 'required|in:important_and_immediate,important_and_not_immediate,not_important_and_immediate,not_important_and_not_immediate'
            ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $project_id = deCode(Request::get('project_id'));
            $permissions = self::TakeProjectPermissions($project_id);
            $responsibes = self::TakeProjectResponsible($project_id);
            $project = projects::find($project_id);
            $user = auth()->user();
            if(!(in_array(self::$_MANAGE_PROJECT_PERMISSSION, $permissions) || in_array(self::$_PROJECT_BASKET_MANAGER, $responsibes))) {
                $result['error'] = trans('projects.no_permissions');
                $result['success'] = false;
                return json_encode($result);
            }
//            $roles = $user->MyProjects()->where('permission_type','=',3)->where('project_id','=',$project_id)->get()->count();
//            if($roles>0)
//            {
                switch (Request::get('type'))
                {
                    case 'important_and_immediate':
                        {
                            $project->importance = 1;
                            $project->immediate = 1;
                            break;
                        }
                    case 'important_and_not_immediate':
                        {
                            $project->importance = 1;
                            $project->immediate = 0;
                            break;
                        }
                    case 'not_important_and_immediate':
                        {
                            $project->importance = 0;
                            $project->immediate = 1;
                            break;
                        }
                    case 'not_important_and_not_immediate':
                        {
                            $project->importance = 0;
                            $project->immediate = 0;
                            break;
                        }
                    default :
                        {
                            break;
                        }
                }
                $project->save();
                $result['success'] = true;
//            }else{
//                $result['success'] = false;
//                $result['error'] = trans('projects.no_permissioned');
//            }
            return json_encode($result);
        }
    }
    public function ProjectsList($uname)
    {
        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.project.list':
            {
                $arr = variable_generator('page', 'desktop',$uname);
                $arr['filter_subject_id'] = $arr["sid"];
                return view('hamahang.Tasks.ProjectsList', $arr);
                break;
            }
            case 'ugc.desktop.hamahang.project.list':
            {
                $arr = variable_generator('user', 'desktop',$uname);
                return view('hamahang.Tasks.ProjectsList', $arr);
                break;
            }
        }
    }

    public function SaveNewProject()
    {
        $result = '';
        $validator = Validator::make(Request::all(), [
            'p_title' => 'required|string'
//            ,
//            'p_type' => 'required|in:0,1',
//            'page_id' => 'integer',
//            'p_schedule_on' => 'required|in:1,2',
//            'start_date' => 'required_if:p_schedule_on,1',
//            'end_date' => 'required_if:p_schedule_on,2',
//            'p_responsible' => 'required'

        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {

            if(Request::input('create_page')=='yes')
            {
                $sesid = '';//(session('sesid') != '') ? session('sesid') : 0;
                $title = Request::input('p_title');
                $kind = 5;
                $tem = 'on';
                $ispublic = Request::input('p_type');
                $Framework = '';
                $field = [ '1818' => "",'1819' => "",'1820' => "",'1821' => "",'1822' => "",'1823' => ""];
                $TT_ttype = [];
                $field_type = [ '1818' => "text",'1819' => "text",'1820' => "text",'1821' => "text",'1822' => "text",'1823' => "text"];;
//                $submit = $request->input('submit');
//
                $uid = Auth::id();

                $user_group = DB::table('role_user as u')
                    ->select('role_id')
                    ->where('u.user_id', $uid)->get()->toArray();
                $roles = [];
                foreach($user_group as $role)
                    $roles[] = $role->role_id;
                $users_list_subject_view = Request::input('users_list_project_view');
                $roles_list_subject_view = Request::input('roles_list_project_view');
                $users_list_subject_edit = Request::input('users_list_project_edit_tasks');
                $roles_list_subject_edit = Request::input('roles_list_project_edit_tasks');

                $fields = array();
                $i = 1;
                if (is_array($field_type))
                {
                    foreach ($field_type as $key => $val)
                    {
                        $fields[$i]['type'] = $val;
                        $i++;
                    }
                }
                $tt = $field_type;
                $Skind = 5;
                $SP = new SubjectsClass();
                $keywords = Request::input('p_keyword');

                $subject = $SP->AddSubject($keywords, $roles_list_subject_edit, $users_list_subject_edit, $roles_list_subject_view, $users_list_subject_view, $uid, $sesid, $title, $tem, $kind, $Framework, $ispublic, $field, $TT_ttype, $tt, $Skind, '');
                $id = $subject['id'] / 10;

                score_unregister('App\Models\hamafza\Subject', $id, config('score.8'));

            }

            $date = new jDateTime();
            date_default_timezone_set('Asia/Tehran');
            $date_to_split = explode('-', Request::input('start_date'));
            $respite_timestsmp = $date->mktime('0', '0', '0', $date_to_split['1'], $date_to_split[2], $date_to_split[0]);
            $start_date = $respite_timestsmp;
            $date_to_split = explode('-', Request::input('end_date'));
            $respite_timestsmp = $date->mktime('0', '0', '0', $date_to_split['1'], $date_to_split[2], $date_to_split[0]);
            $end_date = $respite_timestsmp;
            $date_to_split = explode('-', Request::input('current_date'));
            $respite_timestsmp = $date->mktime('0', '0', '0', $date_to_split['1'], $date_to_split[2], $date_to_split[0]);
            $current_date = $respite_timestsmp;
            $date_to_split = explode('-', Request::input('state_date'));
            $respite_timestsmp = $date->mktime('0', '0', '0', $date_to_split['1'], $date_to_split[2], $date_to_split[0]);
            $state_date = $respite_timestsmp;
            $project = new task_project();
            $project->uid = Auth::id();
            $project->title = Request::input('p_title');
            $project->desc = Request::input('p_desc');
            $project->base_calendar = Request::input('base_calendar');
            //$project->page = Request::input('p_page');
            $project->priority = Request::input('p_priority');
            //$project->responsible = Request::input('p_responsible');
            $project->top_goals = Request::input('p_top_goals');
            $project->type = Request::input('p_type');
            $project->org_unit = Request::input('p_org_unit')[0];
            $project->immediate = Request::input('immediate');
            $project->importance = Request::input('importance');
            $project->start_date = $start_date;
            $project->end_date = $end_date;
            $project->state_date = $state_date;
            $project->current_date = $current_date;
            $project->schedule_on = Request::input('p_schedule_on');
            if (Request::input('observation_permission_type') == 'all')
            {
                $project->observation_permission_all = 1;
            }
            else
            {
                $project->observation_permission_all = 0;
            }
            if (Request::input('observation_permission_type') == 'all')
            {
                $project->modify_permission_all = 1;
            }
            else
            {
                $project->modify_permission_all = 0;
            }
            if (Request::input('save_type') == 11)
            {
                $project->draft = 0;
            }
            elseif (Request::input('save_type') == 22)
            {
                $project->draft = 1;
            }
            $project->save();

            if(Request::exists('p_responsible')){
                foreach(Request::input('p_responsible') as $req_user){
                    $responsible = new hamahang_project_responsible;
                    $responsible->uid = Auth::id();
                    if($req_user != null)
                    {
                        if (substr($req_user, 0, 8) == 'exist_in')
                        {
                            $responsible->user_id = (int)substr($req_user, 8);
                        }
                        else
                        {
                            $user = new User();
                            $user->Uname = $req_user;
                            $user->Email = $req_user;
                            $user->Name = $req_user;
                            $user->is_new = '1';
                            $user->save();
                            $responsible->user_id = $user->id;
                        }
                    }
                    $responsible->project_id = $project->id;
                    $responsible->permission_type = 1;
                    $responsible->save();
                }
            }
            if(Request::exists('p_observer')){
                foreach(Request::input('p_observer') as $req_user){
                    $responsible = new hamahang_project_responsible;
                    $responsible->uid = Auth::id();
                    if($req_user != null)
                    {
                        if (substr($req_user, 0, 8) == 'exist_in')
                        {
                            $responsible->user_id = (int)substr($req_user, 8);
                        }
                        else
                        {
                            $user = new User();
                            $user->Uname = $req_user;
                            $user->Email = $req_user;
                            $user->Name = $req_user;
                            $user->is_new = '1';
                            $user->save();
                            $responsible->user_id = $user->id;
                        }
                    }
                    $responsible->project_id = $project->id;
                    $responsible->permission_type = 2;
                    $responsible->save();
                }
            }
            if(Request::exists('p_supervisor')){
                foreach(Request::input('p_supervisor') as $req_user){
                    $responsible = new hamahang_project_responsible;
                    $responsible->uid = Auth::id();
                    if($req_user != null)
                    {
                        if (substr($req_user, 0, 8) == 'exist_in')
                        {
                            $responsible->user_id = (int)substr($req_user, 8);
                        }
                        else
                        {
                            $user = new User();
                            $user->Uname = $req_user;
                            $user->Email = $req_user;
                            $user->Name = $req_user;
                            $user->permission_type = 3;
                            $user->is_new = '1';
                            $user->save();
                            $responsible->user_id = $user->id;
                        }
                    }
                    $responsible->permission_type = 3;
                    $responsible->project_id = $project->id;
                    $responsible->save();
                }
            }
            if (sizeof(Request::input('ModifyPermissionUsers')) > 0)
            {
                foreach (Request::input('ModifyPermissionUsers') as $u)
                {
                    $p = new project_permissions;
                    $p->uid = Auth::id();
                    $p->user_id = $u;
                    $p->project_id = $project->id;
                    $p->permission_type = '011';
                    $p->save();
                }
            }
            if (sizeof(Request::input('users_list_project_view')) > 0)
            {
                foreach (Request::input('users_list_project_view') as $u)
                {
                    $p = new project_permissions;
                    $p->uid = Auth::id();
                    $p->user_id = $u;
                    $p->project_id = $project->id;
                    $p->permission_type = '1';
                    $p->save();
                }
            }
            if (sizeof(Request::input('users_list_project_edit_tasks')) > 0)
            {
                foreach (Request::input('users_list_project_edit_tasks') as $u)
                {
                    $p = new project_permissions;
                    $p->uid = Auth::id();
                    $p->user_id = $u;
                    $p->project_id = $project->id;
                    $p->permission_type = '2';
                    $p->save();
                }
            }
            if (sizeof(Request::input('users_list_project_edit')) > 0)
            {
                foreach (Request::input('users_list_project_edit') as $u)
                {
                    $p = new project_permissions;
                    $p->uid = Auth::id();
                    $p->user_id = $u;
                    $p->project_id = $project->id;
                    $p->permission_type = '3';
                    $p->save();
                }
            }
            if (sizeof(Request::input('roles_list_project_view')) > 0)
            {
                foreach (Request::input('roles_list_project_view') as $u)
                {
                    $p = new project_role_permission;
                    $p->uid = Auth::id();
                    $p->role_id = $u;
                    $p->project_id = $project->id;
                    $p->permission_type = '1';
                    $p->save();
                }
            }
            if (sizeof(Request::input('roles_list_project_edit_tasks')) > 0)
            {
                foreach (Request::input('roles_list_project_edit_tasks') as $u)
                {
                    $p = new project_role_permission;
                    $p->uid = Auth::id();
                    $p->role_id = $u;
                    $p->project_id = $project->id;
                    $p->permission_type = '2';
                    $p->save();
                }
            }
            if (sizeof(Request::input('roles_list_project_edit')) > 0)
            {
                foreach (Request::input('roles_list_project_edit') as $u)
                {
                    $p = new project_role_permission;
                    $p->uid = Auth::id();
                    $p->role_id = $u;
                    $p->project_id = $project->id;
                    $p->permission_type = '3';
                    $p->save();
                }
            }
            if (sizeof(Request::input('ObservationPermissionUsers')) > 0)
            {
                foreach (Request::input('ObservationPermissionUsers') as $u)
                {
                    $find = project_permissions::where('user_id', '=', $u)->where('project_id', '=', $project->id)->first();
                    if (sizeof($find) == 0)
                    {
                        $p = new project_permissions;
                        $p->uid = Auth::id();
                        $p->user_id = $u;
                        $p->project_id = $project->id;
                        $p->permission_type = '001';
                        $p->save();
                    }
                }
            }
            if(Request::input('create_page')=='yes')
            {
                $result['type'] = 'create_page';
                $result['pid'] = $subject['id'];
                hamahang_subject_ables::create_items_page($subject['id']/10,$project->id,'App\Models\Hamahang\Tasks\task_project');
            }else{
                $result['type'] = 'no_page';
            }
            if (sizeof(Request::input('p_page')) > 0)
            {
                $subjects = [];
                foreach (Request::input('p_page') as $subject_id)
                {
//                    $subject_id = $subject_id - $subject_id%10;
//                    $subjects[$subject_id/10] = 1;
                    hamahang_subject_ables::create_items_page($subject_id/10,$project->id,'App\Models\Hamahang\Tasks\task_project');

                }
//                foreach ($subjects as $subject_id => $v)
//                {
//                    hamahang_subject_ables::create_items_page($subject_id,$project->id,'App\Models\Hamahang\Tasks\task_project');
//                }
            }
            $keywords = Request::input('p_keyword');
            if (sizeof($keywords) > 0)
            {
                foreach ($keywords as $kw)
                {
                    project_keyword::assign_project_keyword($project->id, hamahang_add_keyword($kw));
                }
            }
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public static function TakeProjectPermissions($pid)
    {
        $projects_roles = DB::table('hamahang_project')
            ->leftJoin('hamahang_project_role_permission', 'project_id','=','hamahang_project.id')
            ->whereRaw('hamahang_project_role_permission.role_id IN (SELECT role_user.role_id FROM role_user WHERE role_user.user_id = ?)', Auth::id())
            ->whereNull('hamahang_project_role_permission.deleted_at')
            ->whereNull('hamahang_project.deleted_at')
            ->where('hamahang_project.id','=',$pid)
        ->select('permission_type');
        $projects_user = DB::table('hamahang_project')
            ->leftJoin('hamahang_project_user_permission', 'project_id','=','hamahang_project.id')
            ->whereNull('hamahang_project_user_permission.deleted_at')
            ->whereNull('hamahang_project.deleted_at')
            ->where('hamahang_project_user_permission.user_id', Auth::id())
            ->where('hamahang_project.id','=',$pid)
        ->unionAll($projects_roles)->pluck('permission_type')->toArray();
        return $projects_user;
    }

    public static function TakeProjectResponsible($pid)
    {

        $respons = DB::table('hamahang_project')
            ->leftJoin('hamahang_project_responsible', 'project_id','=','hamahang_project.id')
            ->where('hamahang_project_responsible.user_id', '=',Auth::id())
            ->whereNull('hamahang_project_responsible.deleted_at')
            ->whereNull('hamahang_project.deleted_at')
            ->where('hamahang_project.id','=',$pid)
        ->pluck('permission_type')->toArray();
        return $respons;
    }

    public function EditProject()
    {
        $result = '';
        $validator = Validator::make(Request::all(), [
            'p_title' => 'required|string'
//            ,
//            'p_type' => 'required|in:0,1',
//            'page_id' => 'integer',
//            'p_schedule_on' => 'required|in:1,2',
//            'start_date' => 'required_if:p_schedule_on,1',
//            'end_date' => 'required_if:p_schedule_on,2',
//            'p_responsible' => 'required'

        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if(Request::exists('create_new_project'))
            {
                return $this->SaveNewProject();
            }
            $pid = deCode(Request::input('p_id'));
            $permission = self::TakeProjectPermissions($pid);
            if(!in_array(self::$_MANAGE_PROJECT_PERMISSSION,$permission)){
                $result['error'] = trans('projects.no_permissions');
                $result['success'] = false;
                return json_encode($result);
            }
            $date = new jDateTime();
            date_default_timezone_set('Asia/Tehran');
            $date_to_split = explode('-', Request::input('start_date'));
            $respite_timestsmp = $date->mktime('0', '0', '0', $date_to_split['1'], $date_to_split[2], $date_to_split[0]);
            $start_date = $respite_timestsmp;
            $date_to_split = explode('-', Request::input('end_date'));
            $respite_timestsmp = $date->mktime('0', '0', '0', $date_to_split['1'], $date_to_split[2], $date_to_split[0]);
            $end_date = $respite_timestsmp;
            $date_to_split = explode('-', Request::input('current_date'));
            $respite_timestsmp = $date->mktime('0', '0', '0', $date_to_split['1'], $date_to_split[2], $date_to_split[0]);
            $current_date = $respite_timestsmp;
            $date_to_split = explode('-', Request::input('state_date'));
            $respite_timestsmp = $date->mktime('0', '0', '0', $date_to_split['1'], $date_to_split[2], $date_to_split[0]);
            $state_date = $respite_timestsmp;

//            $pid = \Session::get('pid');
            $project = task_project::find($pid);
            $project->uid = Auth::id();
            $project->title = Request::input('p_title');
            $project->desc = Request::input('p_desc');
            $project->base_calendar = Request::input('base_calendar');
            //$project->page = Request::input('p_page');
            $project->priority = Request::input('p_priority');
            //$project->responsible = Request::input('p_responsible');
            $project->top_goals = Request::input('p_top_goals');
            $project->type = Request::input('p_type');
            $project->immediate = Request::input('immediate');
            $project->importance = Request::input('importance');
            $project->org_unit = Request::input('p_org_unit')[0];
            $project->start_date = $start_date;
            $project->end_date = $end_date;
            $project->state_date = $state_date;
            $project->current_date = $current_date;
            $project->schedule_on = Request::input('p_schedule_on');
            if (Request::input('observation_permission_type') == 'all')
            {
                $project->observation_permission_all = 1;
            }
            else
            {
                $project->observation_permission_all = 0;
            }
            if (Request::input('observation_permission_type') == 'all')
            {
                $project->modify_permission_all = 1;
            }
            else
            {
                $project->modify_permission_all = 0;
            }
            if (Request::input('save_type') == 11)
            {
                $project->draft = 0;
            }
            elseif (Request::input('save_type') == 22)
            {
                $project->draft = 1;
            }
            $project->save();

            project_permissions::where('project_id', '=', $pid)->delete();
            project_role_permission::where('project_id', '=', $pid)->delete();
            hamahang_project_responsible::where('project_id', '=', $pid)->delete();
            hamahang_subject_ables::where('target_id', '=', $pid)->delete();
            project_keyword::where('project_id', '=', $pid)->delete();

//            $responsible = new hamahang_project_responsible;
//            $responsible->uid = Auth::id();
//            $req_user = Request::input('p_responsible')[0];
//            if($req_user != null)
//            {
//                if (substr($req_user, 0, 8) == 'exist_in')
//                {
//                    $responsible->user_id = (int)substr($req_user, 8);
//                }
//                else
//                {
//                    $user = new User();
//                    $user->Uname = $req_user;
//                    $user->Email = $req_user;
//                    $user->Name = $req_user;
//                    $user->is_new = '1';
//                    $user->save();
//                    $responsible->user_id = $user->id;
//                }
//            }
//            $responsible->project_id = $project->id;
//            $responsible->save();


            if(Request::exists('p_responsible')){
                foreach(Request::input('p_responsible') as $req_user){
                    $responsible = new hamahang_project_responsible;
                    $responsible->uid = Auth::id();
                    if($req_user != null)
                    {
                        if (substr($req_user, 0, 8) == 'exist_in')
                        {
                            $responsible->user_id = (int)substr($req_user, 8);
                        }
                        else
                        {
                            $user = new User();
                            $user->Uname = $req_user;
                            $user->Email = $req_user;
                            $user->Name = $req_user;
                            $user->is_new = '1';
                            $user->save();
                            $responsible->user_id = $user->id;
                        }
                    }
                    $responsible->project_id = $project->id;
                    $responsible->permission_type = 1;
                    $responsible->save();
                }
            }
            if(Request::exists('p_observer')){
                foreach(Request::input('p_observer') as $req_user){
                    $responsible = new hamahang_project_responsible;
                    $responsible->uid = Auth::id();
                    if($req_user != null)
                    {
                        if (substr($req_user, 0, 8) == 'exist_in')
                        {
                            $responsible->user_id = (int)substr($req_user, 8);
                        }
                        else
                        {
                            $user = new User();
                            $user->Uname = $req_user;
                            $user->Email = $req_user;
                            $user->Name = $req_user;
                            $user->is_new = '1';
                            $user->save();
                            $responsible->user_id = $user->id;
                        }
                    }
                    $responsible->project_id = $project->id;
                    $responsible->permission_type = 2;
                    $responsible->save();
                }
            }
            if(Request::exists('p_supervisor')){
                foreach(Request::input('p_supervisor') as $req_user){
                    $responsible = new hamahang_project_responsible;
                    $responsible->uid = Auth::id();
                    if($req_user != null)
                    {
                        if (substr($req_user, 0, 8) == 'exist_in')
                        {
                            $responsible->user_id = (int)substr($req_user, 8);
                        }
                        else
                        {
                            $user = new User();
                            $user->Uname = $req_user;
                            $user->Email = $req_user;
                            $user->Name = $req_user;
                            $user->permission_type = 3;
                            $user->is_new = '1';
                            $user->save();
                            $responsible->user_id = $user->id;
                        }
                    }
                    $responsible->permission_type = 3;
                    $responsible->project_id = $project->id;
                    $responsible->save();
                }
            }

            if (sizeof(Request::input('ModifyPermissionUsers')) > 0)
            {
                foreach (Request::input('ModifyPermissionUsers') as $u)
                {
                    $p = new project_permissions;
                    $p->uid = Auth::id();
                    $p->user_id = $u;
                    $p->project_id = $project->id;
                    $p->permission_type = '011';
                    $p->save();
                }
            }


            if (sizeof(Request::input('users_list_project_view')) > 0)
            {
                foreach (Request::input('users_list_project_view') as $u)
                {
                    $p = new project_permissions;
                    $p->uid = Auth::id();
                    $p->user_id = $u;
                    $p->project_id = $project->id;
                    $p->permission_type = '1';
                    $p->save();
                }
            }
            if (sizeof(Request::input('users_list_project_edit_tasks')) > 0)
            {
                foreach (Request::input('users_list_project_edit_tasks') as $u)
                {
                    $p = new project_permissions;
                    $p->uid = Auth::id();
                    $p->user_id = $u;
                    $p->project_id = $project->id;
                    $p->permission_type = '2';
                    $p->save();
                }
            }
            if (sizeof(Request::input('users_list_project_edit')) > 0)
            {
                foreach (Request::input('users_list_project_edit') as $u)
                {
                    $p = new project_permissions;
                    $p->uid = Auth::id();
                    $p->user_id = $u;
                    $p->project_id = $project->id;
                    $p->permission_type = '3';
                    $p->save();
                }
            }
            if (sizeof(Request::input('roles_list_project_view')) > 0)
            {
                foreach (Request::input('roles_list_project_view') as $u)
                {
                    $p = new project_role_permission;
                    $p->uid = Auth::id();
                    $p->role_id = $u;
                    $p->project_id = $project->id;
                    $p->permission_type = '1';
                    $p->save();
                }
            }
            if (sizeof(Request::input('roles_list_project_edit_tasks')) > 0)
            {
                foreach (Request::input('roles_list_project_edit_tasks') as $u)
                {
                    $p = new project_role_permission;
                    $p->uid = Auth::id();
                    $p->role_id = $u;
                    $p->project_id = $project->id;
                    $p->permission_type = '2';
                    $p->save();
                }
            }
            if (sizeof(Request::input('roles_list_project_edit')) > 0)
            {
                foreach (Request::input('roles_list_project_edit') as $u)
                {
                    $p = new project_role_permission;
                    $p->uid = Auth::id();
                    $p->role_id = $u;
                    $p->project_id = $project->id;
                    $p->permission_type = '3';
                    $p->save();
                }
            }
            if (sizeof(Request::input('ObservationPermissionUsers')) > 0)
            {
                foreach (Request::input('ObservationPermissionUsers') as $u)
                {
                    $find = project_permissions::where('user_id', '=', $u)->where('project_id', '=', $project->id)->first();
                    if (sizeof($find) == 0)
                    {
                        $p = new project_permissions;
                        $p->uid = Auth::id();
                        $p->user_id = $u;
                        $p->project_id = $project->id;
                        $p->permission_type = '001';
                        $p->save();
                    }
                }
            }

            if (sizeof(Request::input('p_page')) > 0)
            {
                foreach (Request::input('p_page') as $subject_id)
                {
                    hamahang_subject_ables::create_items_page($subject_id,$project->id,'App\Models\Hamahang\Tasks\task_project');

                }
            }
            $keywords = Request::input('p_keyword');
            if (sizeof($keywords) > 0)
            {
                foreach ($keywords as $kw)
                {
                    project_keyword::assign_project_keyword($project->id, hamahang_add_keyword(hamahang_get_keyword_value($kw)));
                }
            }
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function NewProject($uname)
    {
        $arr = variable_generator('user', 'desktop', $uname);
        $arr['calendars'] = DB::table('hamahang_calendar')->select('id', 'title')->where('uid', '=', Auth::id())->get();
        return view('hamahang.Projects.create_new_project', $arr);
    }

    public function GanttChartShow($uname, $ProjectID)
    {
        $uid = (session('uid') != '' && session('uid') != '') ? session('uid') : 0;
        $Tree = DesktopClass::DeskTopTree($uid, 0, '', '');
        $Tc = new TaskClass();
        $arr = $Tc->ShowTask($uname, $uid, $Tree);
        return view('hamahang.Projects.GanttChartShow', $arr);
    }

    public function ShowGanttChart($uname)
    {
        $uid = (session('uid') != '' && session('uid') != '') ? session('uid') : 0;
        $Tree = DesktopClass::DeskTopTree($uid, 0, '', '');
        $Tc = new TaskClass();
        $arr = $Tc->ShowTask($uname, $uid, $Tree);
        return view('hamahang.Projects.GanttChart', $arr);
    }

    public function HierarchicalView($uname)
    {
        $Tasks = [];
        $project_tasks = DB::table('hamahang_project_task')->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_project_task.task_id')->join('hamahang_task_assignments', 'hamahang_task_assignments.task_id', '=', 'hamahang_project_task.task_id')->join('user', 'user.id', '=', 'hamahang_task_assignments.employee_id')->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_project_task.task_id')->whereNull('hamahang_task_status.deleted_at')->where('hamahang_project_task.project_id', '=', 2)->select('hamahang_task.duration_timestamp AS duration', 'hamahang_task_status.percent', 'hamahang_project_task.task_id', 'hamahang_task.title AS title', DB::raw("CONCAT(user.Name,' ', user.Family) AS user_responsible_name"), 'user.id as user_responsible_id')->get();
        foreach ($project_tasks as $key => $task)
        {
            $Task = get_object_vars($task);
            $children = $this->getChildren($task->task_id);
            if (is_array($children) && !empty($children))
            {
                $Task['children'] = $children;
                $Task['folder'] = True;
            }
            else
            {
                $Task['children'] = [];
                $Task['folder'] = False;
            }
            $Task['duration'] = $Task['duration'] + 200000;
            $Task['expanded'] = True;
            $Tasks[] = $Task;
        }
        $arr = variable_generator('user', 'desktop', $uname);
        $arr['Tasks'] = json_encode($Tasks);
        return view('hamahang.Projects.HierarchicalView', $arr);
    }
}
