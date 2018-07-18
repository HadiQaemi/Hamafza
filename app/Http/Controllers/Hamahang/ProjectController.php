<?php

namespace App\Http\Controllers\Hamahang;

use Datatables;
use DB;
use Auth;
use Request;
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

    public function ProjectInfoWindow()
    {
//
        return json_encode([
            'header' => trans('tasks.task_info'),
            'content' => view('hamahang.Projects.helper.ProjectInfoWindow')->with('p_id', Request::input('p_id'))->render(),
            'footer' => view('hamahang.helper.JsPanelsFooter')->with('btn_type', 'MyAssignedTaskInfo')->render()
        ]);
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

    public function project_gantt_data($uname)
    {
        date_default_timezone_set('Asia/Tehran');
        $arr = [];
        $project_startdate = DB::table('hamahang_project')->where('id', '=', 2)->first()->start_date;

        $project_task_relations = DB::table('hamahang_project_task_relations')
            ->where('project_id', '=', 9)
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
            ->where('hamahang_project_task.project_id', '=', 9)
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


//        $relations = project_task_relation::where('first_task_id','=',Request::input('f_task'))
//            ->where('relation','=',Request::input('r_type'))
//            ->get();
        return json_encode(1);

    }

    public function ProjectInfo()
    {
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
        $projects = DB::table('hamahang_project')
            ->where('hamahang_project.uid', '=', Auth::id())
            ->whereNull('hamahang_project.deleted_at')
            ->select(DB::raw('CONCAT(Name, " ", Family) AS full_name'), 'hamahang_project.title', 'hamahang_project.draft', 'hamahang_project.end_date', 'hamahang_project.start_date')
            ->join('hamahang_project_responsible','hamahang_project_responsible.project_id','=','hamahang_project.id')
            ->join('user','user.id','=','hamahang_project_responsible.user_id')
        ;
        //die(var_dump($projects));
        if (Request::exists('subject_id'))
        {
            $projects->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_project.id')
                ->where('hamahang_subject_ables.subject_id', Request::input('subject_id'))
                ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\task_project')
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $projects = $projects->get()->toArray();

        $dd = collect($projects)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
//        $dd = Datatables::of($projects)
//            ->addColumn('fa_start_date', function ($data)
//            {
//                return date('Y-m-d',$data->start_date);
//            })
//            ->rawColumns(['fa_start_date'])
//            ->make(true);
////        dd($dd);
        $result['data'] = $dd;
        return json_encode($result);
    }

    public function ProjectsList($uname)
    {
        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.project.list':
            {
                $arr = variable_generator('page', 'desktop',$uname);
                $arr['filter_subject_id'] = $uname;
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
            $responsible = new hamahang_project_responsible;
            $responsible->uid = Auth::id();
            $responsible->user_id = Request::input('p_responsible')[0];
            $responsible->project_id = $project->id;
            $responsible->save();
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
                    project_keyword::assign_project_keyword($project->id, hamahang_add_keyword($kw));
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
