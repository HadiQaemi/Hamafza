<?php

namespace App\Http\Controllers\Hamahang\Tasks;


use App\Models\Hamahang\Tasks\task_priority;
use DB;
use Auth;
use Request;
use Route;
use Validator;
use App\Models\Hamahang\Tasks\tasks;
use App\Models\Hamahang\Tasks\task_packages;
use App\Models\Hamahang\Tasks\task_assignments;
use App\Models\Hamahang\Tasks\task_status;
use App\Models\Hamahang\Tasks\task_keywords;
use App\Models\Hamahang\FileManager\FileManager;
use App\Models\Hamahang\Tasks\task_follow_ups;
use App\Models\Hamahang\Tasks\task_files;
use App\Models\Hamahang\Tasks\drafts;
use App\Models\Hamahang\Tasks\hamahang_tasks_library;
use App\Models\Hamahang\Tasks\task_logs;
use App\Models\Hamahang\Tasks\hamahang_project_task;
use App\Models\Hamahang\Tasks\task_inheritance;
use App\Models\Hamahang\OrgChart\org_organs;
use App\Models\Hamahang\Tasks\project_task;
use App\HamahangCustomClasses\EncryptString;
use App\HamahangCustomClasses\jDateTime;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function ScheduleTaskCopy()
    {
        tasks::ScheduleTaskCopy(1, date('Y-m-d H:i:s'));
    }

    public function TaskInfo()
    {

        $task_responsible = DB::table('hamahang_task')
            ->join('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
            ->where('hamahang_task.id', '=', Request::input('t_id'))
            ->whereNull('hamahang_task.deleted_at')
            ->select('hamahang_task.uid', 'employee_id')
            ->first();
        if ($task_responsible->uid == Auth::id())
        {
            $t_info = tasks::TaskInfo(Request::input('t_id'));
            $arr['HFM_CNT'] = HFM_GenerateUploadForm(
                [
                    [
                        'AddNewFiles',
                        ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
                        'Multi'
                    ]
                ]
            );
            return json_encode([
                'header' => trans('tasks.task_info'),
                'content' => view('hamahang.Tasks.MyAssignedTask.helper.MyAssignedTasksListJSPanel', $arr)->with($t_info)->with('task_id', Request::input('t_id'))->render(),
                'footer' => view('hamahang.helper.JsPanelsFooter')->with('btn_type', 'MyAssignedTaskInfo')->render()
            ]);
        }
        elseif ($task_responsible->employee_id == Auth::id())
        {
            $packages = task_packages::where('uid', Auth::id())->get();
            $arr['HFM_CNT'] = HFM_GenerateUploadForm(
                [
                    [
                        'AddNewFiles',
                        ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
                        'Multi'
                    ]
                ]
            );
            return json_encode([
                'header' => trans('tasks.task_info'),
                'content' => view('hamahang.Tasks.MyTask.helper.MyTaskInfoJsPanel')->with('task_id', Request::input('t_id'))->with('packages', $packages)->render(),
                'footer' => view('hamahang.helper.JsPanelsFooter')->with('btn_type', 'MyTaskInfo')->render()
            ]);
        }
        else
        {
            abort(403);
        }
    }

    public function task_delete()
    {
        $id = deCode(Request::input('id'));
        $task = tasks::where('id', '=', $id)
            ->delete();
        $result['success'] = $task ? true : false;
        return $result;

    }
    public function use_selected_tasks()
    {
        switch (Request::input('type'))
        {
            case '0':
            {
                if (Request::exists('tasks'))
                {
                    $current_tasks =
                        DB::table('hamahang_task_user_package')
                            ->whereNull('deleted_at')
                            ->where('user_id', '=', Auth::id())
                            ->where('package_id', '=', Request::input('item_id'))
                            ->select('task_id')
                            ->get();
                    $Items = collect($current_tasks)->map(function ($x)
                    {
                        return (array)$x;
                    })->toArray();

                    foreach (Request::input('tasks') as $task)
                    {
                        $exist = 0;
                        for ($i = 0; $i < sizeof($Items); $i++)
                        {
                            if ($task == $Items[$i]['task_id'])
                            {
                                $exist = 1;
                                break;
                            }
                        }
                        if ($exist == 0)
                        {
                            $p = DB::table('hamahang_task_user_package')->insert([
                                ['task_id' => $task, 'user_id' => Auth::id(), 'uid' => Auth::id(), 'package_id' => Request::input('item_id')]
                            ]);
                        }
                    }
                }
                break;
            }
            case '1':
            {
                if (Request::exists('tasks'))
                {
                    foreach (Request::input('tasks') as $task_id)
                    {
                        $find = project_task::where('project_id', '=', Request::input('item_id'))->where('task_id', '=', $task_id)->count();
                        if ($find == 0)
                        {
                            $p_task = new hamahang_project_task;
                        }
                        $p_task->uid = Auth::id();
                        $p_task->project_id = Request::input('item_id');
                        $p_task->task_id = $task_id;
                        $p_task->save();
                    }
                }
            }
            case '2':
            {
                if (sizeof(Request::input('tasks')) > 0)
                {
                    $current_tasks = DB::table('hamahang_task_inheritance')
                        ->whereNull('deleted_at')
                        ->where('parent_task_id', '=', Request::input('item_id'))
                        ->select('id')
                        ->get();
                    $Items = collect($current_tasks)->map(function ($x)
                    {
                        return (array)$x;
                    })->toArray();
                    foreach (Request::input('tasks') as $task)
                    {
                        $exist = 0;
                        for ($i = 0; $i < sizeof($Items); $i++)
                        {
                            if ($task == $Items[$i])
                            {
                                $exist = 1;
                                break;
                            }
                        }
                        if ($exist == 0)
                        {
                            $p = DB::table('hamahang_task_inheritance')->insert([
                                ['task_id' => $task, 'uid' => Auth::id(), 'parent_task_id' => Request::input('item_id')]
                            ]);
                        }
                    }
                }
                break;
            }
            case '200':
            {

            }
        }
        return json_encode('ok');
    }

    public function FetchTasksForSelectTaskWindow()
    {
        switch (Request::input('window_use_type'))
        {
            case 0:
            {
                $task_type_arr = [];
                if (sizeof(Request::input('task_types')) > 0)
                {
                    foreach (Request::input('task_types') as $type)
                    {
                        switch ($type)
                        {
                            case 999:
                            {
                                array_push($task_type_arr, 0);
                                array_push($task_type_arr, 1);
                                array_push($task_type_arr, 2);
                                break;
                            }
                            case 100:
                            {
                                array_push($task_type_arr, 0);
                                break;
                            }
                            case 200:
                            {
                                array_push($task_type_arr, 1);
                                break;
                            }
                            case 300:
                            {
                                array_push($task_type_arr, 2);
                                break;
                            }
                        }
                    }
                }
                if (Request::input('tasks_assign_type') == 1)
                {
                    $total = DB::table('hamahang_task')
                        ->join('hamahang_task_status', 'hamahang_task.id', 'hamahang_task_status.task_id')
                        ->join('hamahang_task_priority', 'hamahang_task.id', 'hamahang_task_priority.task_id')
                        ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
                        ->whereRaw('hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id and uid = ? and deleted_at is NULL )', Auth::id())
                        ->whereNull('hamahang_task.deleted_at')
                        ->where('hamahang_task.uid', '=', Auth::id())
                        ->whereIn('hamahang_task.use_type', $task_type_arr)
                        ->select('hamahang_task.id as id', 'hamahang_task.title');
                    if (Request::exists('selected_task_states'))
                    {
                        $total->whereIn('hamahang_task_status.type', Request::input('selected_task_states'));
                    }
                    if (Request::exists('selected_task_importance'))
                    {
                        $total->whereIn('hamahang_task_priority.importance', Request::input('selected_task_importance'));
                    }
                    if (Request::exists('selected_task_immediate'))
                    {
                        $total->whereIn('hamahang_task_priority.immediate', Request::input('selected_task_immediate'));
                    }
                    if (Request::input('title') != null)
                    {
                        $total->where("hamahang_task.title", "LIKE", "%" . Request::input('title') . "%");
                    }
                    $res = $total->get();

                }
                elseif (Request::input('tasks_assign_type') == '2')
                {
                    $res = DB::table('hamahang_task')
                        ->join('hamahang_task_assignments', 'hamahang_task_assignments.task_id', '=', 'hamahang_task.id')
                        ->whereNull('hamahang_task.deleted_at')
                        ->where('hamahang_task_assignments.employee_id', '=', Auth::id())
                        ->whereIn('hamahang_task.use_type', $task_type_arr)
                        ->select('hamahang_task.id as id', 'hamahang_task.title')
                        ->get();
                }
                $data = collect($res)->map(function ($x)
                {
                    return (array)$x;
                })->toArray();
                $result['data'] = $data;
                return json_encode($result);
            }
            case 1:
            {

                if (Request::input('tasks_assign_type') == 1)
                {
                    $total = DB::table('hamahang_task')
                        ->join('hamahang_task_status', 'hamahang_task.id', 'hamahang_task_status.task_id')
                        ->join('hamahang_task_priority', 'hamahang_task.id', 'hamahang_task_priority.task_id')
                        ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
                        ->whereRaw('hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id and uid = ? and deleted_at is NULL )', Auth::id())
                        ->whereNull('hamahang_task.deleted_at')
                        ->where('hamahang_task.uid', '=', Auth::id())
                        ->where('hamahang_task.use_type', '=', 1)
                        ->select('hamahang_task.id as id', 'hamahang_task.title');
                    if (Request::exists('selected_task_states'))
                    {
                        $total->whereIn('hamahang_task_status.type', Request::input('selected_task_states'));
                    }
                    if (Request::exists('selected_task_importance'))
                    {
                        $total->whereIn('hamahang_task_priority.importance', Request::input('selected_task_importance'));
                    }
                    if (Request::exists('selected_task_immediate'))
                    {
                        $total->whereIn('hamahang_task_priority.immediate', Request::input('selected_task_immediate'));
                    }
                    if (Request::input('title') != null)
                    {
                        $total->where("hamahang_task.title", "LIKE", "%" . Request::input('title') . "%");
                    }
                    $res = $total->get();

                }
                elseif (Request::input('tasks_assign_type') == '2')
                {
                    $res = DB::table('hamahang_task')
                        ->join('hamahang_task_assignments', 'hamahang_task_assignments.task_id', '=', 'hamahang_task.id')
                        ->whereNull('hamahang_task.deleted_at')
                        ->where('hamahang_task_assignments.employee_id', '=', Auth::id())
                        ->where('hamahang_task.use_type', '=', 1)
                        ->select('hamahang_task.id as id', 'hamahang_task.title')
                        ->get();
                }
                $data = collect($res)->map(function ($x)
                {
                    return (array)$x;
                })->toArray();
                $result['data'] = $data;
                return json_encode($result);
            }
            case 2:
            {
                $task_type_arr = [];
                if (sizeof(Request::input('task_types')) > 0)
                {
                    foreach (Request::input('task_types') as $type)
                    {
                        switch ($type)
                        {
                            case 100:
                            {
                                array_push($task_type_arr, 0);
                                break;
                            }
                        }
                    }
                }
                if (Request::input('assigning_type') == 1)
                {
                    DB::enableQueryLog();
                    $total = DB::table('hamahang_task')
                        ->join('hamahang_task_status', 'hamahang_task.id', 'hamahang_task_status.task_id')
                        ->join('hamahang_task_priority', 'hamahang_task.id', 'hamahang_task_priority.task_id')
                        ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
                        ->whereRaw('hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id and uid = ? and deleted_at is NULL )', Auth::id())
                        ->whereNull('hamahang_task.deleted_at')
                        ->where('hamahang_task.uid', '=', Auth::id())
                        ->whereIn('hamahang_task.use_type', $task_type_arr)
                        ->select('hamahang_task.id as id', 'hamahang_task.title');
                    if (Request::exists('selected_task_states'))
                    {
                        $total->whereIn('hamahang_task_status.type', Request::input('selected_task_states'));
                    }
                    if (Request::exists('selected_task_importance'))
                    {
                        $total->whereIn('hamahang_task_priority.importance', Request::input('selected_task_importance'));
                    }
                    if (Request::exists('selected_task_immediate'))
                    {
                        $total->whereIn('hamahang_task_priority.immediate', Request::input('selected_task_immediate'));
                    }
                    if (Request::input('title') != null)
                    {
                        $total->where("hamahang_task.title", "LIKE", "%" . Request::input('title') . "%");
                    }
                    $res = $total->get();
                    //die(dd(DB::getQueryLog()));
                }
                elseif (Request::input('assigning_type') == '0')
                {
                    $res = DB::table('hamahang_task')
                        ->join('hamahang_task_assignments', 'hamahang_task_assignments.task_id', '=', 'hamahang_task.id')
                        ->whereNull('hamahang_task.deleted_at')
                        ->where('hamahang_task_assignments.employee_id', '=', Auth::id())
                        ->whereIn('hamahang_task.use_type', $task_type_arr)
                        ->select('hamahang_task.id as id', 'hamahang_task.title')
                        ->get();
                }
                $data = collect($res)->map(function ($x)
                {
                    return (array)$x;
                })->toArray();
                $result['data'] = $data;
                return json_encode($result);
            }
            case 100:
            {

                break;
            }
            case 200:
            {
                $tasks = DB::table('hamahang_task_library')->where('uid', '=', Auth::id())
                    ->whereNull('deleted_at')
                    ->get();
                $data = collect($tasks)->map(function ($x)
                {
                    return (array)$x;
                })->toArray();
                $result['data'] = $data;
                return json_encode($result);
                break;
            }
        }
    }

    public function SelectTaskWindow()
    {
//        return view('hamahang.Tasks.helper.SelectTaskWindow.select_task_window_modal')->with('uname');

        return json_encode([
            'header' => trans('tasks.select_tasks_window'),
            'content' => view('hamahang.Tasks.helper.SelectTaskWindow.select_task_window_modal')->render(),
            'footer' => view('hamahang.helper.JsPanelsFooter')->with('btn_type', 'select_task_window')->render()
        ]);
    }

    public function GanttChart($uname)
    {
        $arr = variable_generator('user', 'desktop', $uname);
        return view('hamahang.Tasks.TasksGanttChart', $arr);
    }

    public function TaskChildChangeWeight()
    {

        task_inheritance::where('id', '=', Request::input('cid'))
            ->update(['weight' => Request::input('NWeight')]);
        return json_encode(1);

    }

    public function FetchTaskChildsList($id)
    {
        $total = task_inheritance::FetchTaskChildsList($id);
        $data = collect($total)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $result['data'] = $data;
        return json_encode($result);
    }

    public function AddTaskChilds()
    {
        $task_id = task_assignments::where('id', '=', Request::input('tid'))->firstOrFail()->task_id;
        if (sizeof(Request::input('s_arr')))
        {
            foreach (Request::input('s_arr') as $t)
            {
                if ($t == $task_id)
                {
                    continue;
                }
                $check = task_inheritance::where('task_id', '=', $t)
                    ->where('parent_task_id', '=', $task_id)
                    ->whereNull('deleted_at')
                    ->count();
                if ($check == 0)
                {
                    task_inheritance::AddTaskChilds($t, $task_id);
                }
            }
        }
        return json_encode('ok');
    }

    public function RemoveTaskChilds()
    {
        task_inheritance::RemoveTaskChild(Request::input('cid'));
        return json_encode(1);
    }

    public function NewFollowUp()
    {
        $task_id = task_assignments::where('id', '=', Request::input('ass_id'))->firstOrFail()->task_id;

        task_follow_ups::CreateNewFollowUpRecord(Request::input('ass_id'), Request::input('text'), $task_id);

        return 'ok';

    }

    public function RemoveKeyword()
    {
        $task_id = task_assignments::where('id', '=', Request::input('id'))->firstOrFail()->task_id;
        $kw = task_keywords::where('id', Request::input('kid'))->where('uid', Auth::id())->update(['deleted_at' => time()]);

        $kw = task_keywords::where('task_id', $task_id)->where('uid', Auth::id())->whereNull('deleted_at')->select('id', 'keyword')->get();
        //
        // die(var_dump($kw));
        return json_encode($kw);
    }

    public function SearchKeywords()
    {
        $x = Request::input('data');
        $data = task_keywords::select("id", "title as text")->where("title", "LIKE", "%" . $x['q'] . "%")->get();
        $data = array('results' => $data);
        return response()->json($data);
    }

    private function check_existance($count, $task_title)
    {

        $task = task_packages::where('title', 'like', $task_title)->where('user_id', '=', Auth::id())->first();
        if ($task)
        {
            $count++;
            $this->check_existance($count, $task_title . '_' . $count);
        }
        else
        {
            return "zzz";
            if ($count == 0)
            {
                return $task_title;
            }
            else
            {
                return $task_title . '_' . $count;
            }

        }
    }

    public function action()
    {
        $packages = task_packages::all();
        $task_status = task_status::where('task_id', 2)->get();

        return view('hamafza.tasks.action')
            ->with('packages', $packages)
            ->with('task_status', $task_status);
    }

    public function ChangeAction()
    {
        $t = time();
        //DB::enableQueryLog();
        //$task_id = task_status::where('task_assignment_id', '=', Request::input('ass_id'))->firstOrFail()->task_id;
        //die($task_id);
        $prev_status = task_status::where('task_id', '=', Request::input('tid'))->orderBy('timestamp', 'DESC')->first();
        if ($prev_status->type == Request::input('sid') && $prev_status->percent == Request::input('percent'))
        {

        }
        else
        {
            $status = new task_status;
            $status->task_assignment_id = Request::input('ass_id');
            $status->type = Request::input('sid');
            $status->percent = Request::input('percent');
            $status->task_id = Request::input('tid');
            $status->user_id = Auth::id();
            $status->timestamp = $t;
            $status->save();
            task_logs::CreateNewLog(Request::input('tid'), Request::input('tid'), 'status', null, 0, $t);
        }
//        if (Request::exists('keyw'))
//        {
//            foreach (Request::exists('keyw') as $kw)
//            {
//                if (task_keywords::where('title', '=', $kw)->where('uid', '=', Auth::id())->where('task_id', '=', Request::input('tid'))->count() == 0)
//                {
//                    task_keywords::create_task_keyword(Request::input('tid'), $kw);
//                }
//            }
//        }


//        $kw = task_keywords::where('task_id', Request::input('tid'))->where('uid', Auth::id())->whereNull('deleted_at')->select('id', 'keyword')->get();
//        return json_encode($kw);
        return json_encode('ok');

    }

    public function getChildren($parent_id, $tree_string = array())
    {
        $tree = array();
        // getOneLevel() returns a one-dimensional array of child ids
        $tree = $this->getOneLevel($parent_id);
        if (count($tree) > 0 && is_array($tree))
        {
            $tree_string = array_merge($tree_string, $tree);
        }
        foreach ($tree as $key => $val)
        {
            $this->getChildren($val, $tree_string);
        }
        return $tree_string;
    }

    public function getOneLevel($catId)
    {
        $query = task_inheritance::whereNull('deleted_at')->where('parent_task_id', '=', $catId)->get();
        die(var_dump($query));
        $cat_id = array();
        if (sizeof($query) > 0)
        {
            foreach ($query as $q)
            {
                $cat_id[] = $q->task_id;
            }
        }
        return $cat_id;
    }

    public function child_progress($id)
    {
        $arr = [];
        $sum = 0;
        $average = 0;
        $couter = 0;
        $total_percent_sum = 0;
        DB::enableQueryLog();
        $progress = task_inheritance::where('parent_task_id', $id)->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task_inheritance.task_id')->whereNull('hamahang_task_inheritance.deleted_at')->select('hamahang_task_inheritance.id', 'hamahang_task_inheritance.task_id', 'weight', 'parent_task_id', 'percent')->get();
        $sum = task_inheritance::where('parent_task_id', $id)->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task_inheritance.task_id')->whereNull('hamahang_task_inheritance.deleted_at')->sum('weight');

        if (sizeof($progress) > 0)
        {
            foreach ($progress as $p)
            {
                $this->child_progress($p->task_id);

            }
        }
        if ($sum > 0)
        {
            foreach ($progress as $p)
            {
                $p->percent_of_total = ($p->weight * 100) / $sum;
                $p->tPercent = ((($p->percent) / 100) * (($p->percent_of_total) / 100)) * 100;
                $total_percent_sum += $p->tPercent;
            }
        }
        else
        {
            $total_percent_sum = 0;
        }
        return $total_percent_sum;
    }

    public function UserOrgs()
    {

        $x = Request::input('data');
        $data = org_organs::select("id", "title as text")->where("title", "LIKE", "%" . $x['q'] . "%")->where("uid", "=", Auth::id())->get();
        $data = array('results' => $data);
        return response()->json($data);

    }

    public function ShowTaskFiles()
    {
        $data = DB::table('hamahang_task_files')->select('hamahang_task_files.id', 'hamahang_task_files.file_id', 'hamahang_files.originalName', 'hamahang_files.size', 'hamahang_files.extension')
            ->join('hamahang_files', 'hamahang_task_files.file_id', '=', 'hamahang_files.id')
            ->where('hamahang_task_files.task_id', '=', Request::input('t_id'))
            ->whereNull('hamahang_task_files.deleted_at')
            ->get();
        $arr = [];
        $EncryptString = new EncryptString;
        $FileManager = new FileManager;
        foreach ($data as $f)
        {
            $ID_N = $EncryptString->encode($f->id);
            $f->ID_N = $ID_N;
            array_push($arr, ['title' => $f->originalName, 'id' => $f->file_id, 'size' => $f->size, 'extension' => $f->extension, 'ID_N' => $ID_N]);
        }
        $dd = collect($data)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $result['data'] = $dd;
        return json_encode($result);

        ///////////////////

//		$task_id = Request::input('id');
//		$data = DB::table('hamahang_files')
//			->select('hamahang_task_files.file_id', 'hamahang_files.originalName', 'hamahang_files.size', 'hamahang_files.extension')
//			->join('hamahang_task_files', 'hamahang_task_files.file_id', 'hamahang_files.id')
//			->where('hamahang_task_files.task_id', '=', $task_id)
//			->get();
//
//
//
////		$sort = Request::input('sort');
////		$current = Request::input('current');
////		$rowCount = Request::input('rowCount');
////		$searchPhrase = Request::input('searchPhrase');
////		//$task_id = task_assignments::where('id', '=', Request::input('id'))->firstOrFail()->task_id;
////		$task_id = Request::input('id');
////		$total = DB::table('hamahang_files')
////			->select('hamahang_task_files.file_id', 'hamahang_files.originalName', 'hamahang_files.size', 'hamahang_files.extension')
////			->join('hamahang_task_files', 'hamahang_task_files.file_id', 'hamahang_files.id')
////			->where('hamahang_task_files.task_id', '=', $task_id)
////			->count();
////		if ($rowCount == -1) {
////			$data = DB::table('hamahang_files')
////				->select('hamahang_task_files.file_id', 'hamahang_files.originalName', 'hamahang_files.size', 'hamahang_files.extension')
////				->join('hamahang_task_files', 'hamahang_task_files.file_id', 'hamahang_files.id')
////				->where('hamahang_task_files.task_id', '=', $task_id)
////				->where('hamahang_files.originalName', 'LIKE', '%' . $searchPhrase . '%')
////				->get();
////		} else {
////			if ($sort) {
////				$sort_field = array_keys($sort)[0];
////				$sort_order = $sort[array_keys($sort)[0]];
////			} else {
////				$sort_field = 'hamahang_files.id';
////				$sort_order = 'DESC';
////			}
////
////			if ($current == 1)
////				$cur = 0;
////			else
////				$cur = ($current - 1) * $rowCount;
////
////			$data = DB::table('hamahang_files')
////				->select('hamahang_task_files.file_id', 'hamahang_files.originalName', 'hamahang_files.size', 'hamahang_files.extension')
////				->join('hamahang_task_files', 'hamahang_task_files.file_id', 'hamahang_files.id')
////				->where('hamahang_task_files.task_id', '=', $task_id)
////				->where('hamahang_files.originalName', 'LIKE', '%' . $searchPhrase . '%')
////				->orderBy($sort_field, $sort_order)
////				->offset($cur)
////				->limit($rowCount)
////				->get();
////		}
//		$EncryptString = new EncryptString;
//		$FileManager = new FileManager;
//		foreach ($data as $d) {
//
//			$d->ID_N = $EncryptString->encode($d->file_id);
//			$d->file_size = $FileManager->FileSizeConvert($d->size);
//		}
////		$result = array(
////			'rows' => $data,
////			'total' => $total,
////			'rowCount' => $rowCount,
////			'current' => $current
////		);
//		//return json_encode($data);
//
//		$result['data'] = $data;
//		return json_encode($result);
    }

    public function AddNewFiles()
    {
        HFM_SaveMultiFiles('AddNewFiles', '\App\Models\Hamahang\Tasks\task_files', 'task_id', Request::input('tid'));
        return json_encode(1);
    }

    public function change_task_state()
    {

        $id = explode('a', Request::input('tid'));
        $task_info = tasks::where('id', '=', $id[0])->first();
        $task_use_type = $task_info->use_type;
        $task_end_statement = $task_info->end_on_assigner_accept;
        if ($task_end_statement == 1 && Request::input('to') == 4)
        {
            if ($task_info->uid == Auth::id())
            {
                if ($task_use_type == 0)
                {
                    $current_percent = task_status::where('task_id', '=', $id[0])->whereNull('deleted_at')
                        ->select('percent')->orderBy('id', 'DESC')->first();
                    $state = task_status::create_task_status($id[0], (Request::input('to')) - 1, $current_percent['percent']);
                    return json_encode(['success' => true]);
                }
                elseif ($task_use_type == 1)
                {
                    $new_status = (Request::input('to')) - 1;
                    $arr = [];
                    $conflict = 0;
                    $relations = DB::table('hamahang_project_task_relations')
                        ->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_project_task_relations.second_task_id')
                        ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_project_task_relations.second_task_id')
                        ->where('hamahang_project_task_relations.first_task_id', '=', $id[0])
                        ->whereNull('hamahang_project_task_relations.deleted_at')
                        ->whereNull('hamahang_task_status.deleted_at')
                        ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_project_task_relations.second_task_id )')
                        ->select('hamahang_project_task_relations.second_task_id', 'hamahang_task.title', 'hamahang_project_task_relations.relation', 'hamahang_task_status.type')
                        ->get();

                    foreach ($relations as $rel)
                    {
                        //echo $rel->relation.'->'.$new_status.'->'.$rel->type.'->'.$rel->second_task_id;
                        switch ($rel->relation)
                        {
                            case 0:
                            {
                                switch ($new_status)
                                {
                                    case 1:
                                    {
                                        if ($rel->type != 1)
                                        {
                                            array_push($arr, ["id" => $rel->second_task_id, "relation" => (int)$rel->relation, "task_title" => $rel->title, "err_type_title" => 'آغاز']);
                                            $conflict = 1;
                                        }
                                        break;
                                    }
                                    default:
                                    {

                                        break;
                                    }
                                }
                                break;
                            }
                            case 1:
                            {
                                switch ($new_status)
                                {
                                    case 3:
                                    {
                                        if ($rel->type != 3)
                                        {
                                            array_push($arr, ["id" => $rel->second_task_id, "relation" => (int)$rel->relation, "task_title" => $rel->title, "err_type_title" => 'آغاز']);
                                            $conflict = 1;
                                        }
                                        break;
                                    }
                                    default:
                                    {

                                        break;
                                    }
                                }

                            }
                            case 2:
                            {

                                switch ($new_status)
                                {
                                    case 3:
                                    {
                                        if ($rel->type != 1)
                                        {
                                            //$arr[] = ;
                                            array_push($arr, ["id" => $rel->second_task_id, "relation" => (int)$rel->relation, "task_title" => $rel->title, "err_type_title" => 'آغاز']);
                                            $conflict = 1;
                                        }
                                        break;
                                    }
                                    default:
                                    {

                                        break;
                                    }
                                }

                                break;
                            }
                            case 3:
                            {
                                switch ($new_status)
                                {
                                    case 3:
                                    {
                                        if ($rel->type != 3)
                                        {
                                            array_push($arr, ["id" => $rel->second_task_id, "relation" => (int)$rel->relation, "task_title" => $rel->title, "err_type_title" => 'آغاز']);
                                            $conflict = 1;
                                        }
                                        break;
                                    }
                                    default:
                                    {

                                        break;
                                    }
                                }
                            }

                        }

                    }
                    if ($conflict == 0)
                    {
                        $current_percent = task_status::where('task_id', '=', $id[0])->whereNull('deleted_at')->select('percent')->orderBy('id', 'DESC')->first();
                        $state = task_status::create_task_status($id[0], $id[1], (Request::input('to')) - 1, $current_percent['percent']);
                        return json_encode(1);
                    }
                    else
                    {
                        return json_encode($arr);
                    }

                }
            }
            else
            {
                return json_encode(['success' => false]);
            }
        }
        else
        {
            if ($task_use_type == 0)
            {
                $current_percent = task_status::where('task_id', '=', $id[0])->whereNull('deleted_at')
                    ->select('percent')->orderBy('id', 'DESC')->first();
                $state = task_status::create_task_status($id[0], (Request::input('to')) - 1, $current_percent['percent']);
                return json_encode(['success' => true]);
            }
            elseif ($task_use_type == 1)
            {
                $new_status = (Request::input('to')) - 1;
                $arr = [];
                $conflict = 0;
                $relations = DB::table('hamahang_project_task_relations')
                    ->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_project_task_relations.second_task_id')
                    ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_project_task_relations.second_task_id')
                    ->where('hamahang_project_task_relations.first_task_id', '=', $id[0])
                    ->whereNull('hamahang_project_task_relations.deleted_at')
                    ->whereNull('hamahang_task_status.deleted_at')
                    ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_project_task_relations.second_task_id )')
                    ->select('hamahang_project_task_relations.second_task_id', 'hamahang_task.title', 'hamahang_project_task_relations.relation', 'hamahang_task_status.type')
                    ->get();
                //dd($relations);

                foreach ($relations as $rel)
                {
                    //echo $rel->relation.'->'.$new_status.'->'.$rel->type.'->'.$rel->second_task_id;
                    switch ($rel->relation)
                    {
                        case 0:
                        {
                            switch ($new_status)
                            {
                                case 1:
                                {
                                    if ($rel->type != 1)
                                    {
                                        array_push($arr, ["id" => $rel->second_task_id, "relation" => (int)$rel->relation, "task_title" => $rel->title, "err_type_title" => 'آغاز']);
                                        $conflict = 1;
                                    }
                                    break;
                                }
                                default:
                                {

                                    break;
                                }
                            }
                            break;
                        }
                        case 1:
                        {
                            switch ($new_status)
                            {
                                case 3:
                                {
                                    if ($rel->type != 3)
                                    {
                                        array_push($arr, ["id" => $rel->second_task_id, "relation" => (int)$rel->relation, "task_title" => $rel->title, "err_type_title" => 'آغاز']);
                                        $conflict = 1;
                                    }
                                    break;
                                }
                                default:
                                {

                                    break;
                                }
                            }

                        }

                        case 2:
                        {

                            switch ($new_status)
                            {
                                case 3:
                                {
                                    if ($rel->type != 1)
                                    {
                                        //$arr[] = ;
                                        array_push($arr, ["id" => $rel->second_task_id, "relation" => (int)$rel->relation, "task_title" => $rel->title, "err_type_title" => 'آغاز']);
                                        $conflict = 1;
                                    }
                                    break;
                                }
                                default:
                                {

                                    break;
                                }
                            }

                            break;
                        }

                        case 3:
                        {
                            switch ($new_status)
                            {
                                case 3:
                                {
                                    if ($rel->type != 3)
                                    {
                                        array_push($arr, ["id" => $rel->second_task_id, "relation" => (int)$rel->relation, "task_title" => $rel->title, "err_type_title" => 'آغاز']);
                                        $conflict = 1;
                                    }
                                    break;
                                }
                                default:
                                {

                                    break;
                                }
                            }
                        }

                    }

                }
                if ($conflict == 0)
                {
                    $current_percent = task_status::where('task_id', '=', $id[0])->whereNull('deleted_at')->select('percent')->orderBy('id', 'DESC')->first();
                    $state = task_status::create_task_status($id[0], $id[1], (Request::input('to')) - 1, $current_percent['percent']);
                    return json_encode(['success' => true]);
                }
                else
                {
                    return json_encode($arr);
                }

            }
        }
    }

    public function filter_task_priority()
    {
        $Request = Request::all();
        $validator = Validator::make(Request::all(), [
            'task_title' => 'string',
            'respite' => 'integer',
            'official_type' => 'array',
            'task_status' => 'array',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
//            dd(\Route::currentRouteName(),Request::all());
            $respite = Request::get('respite');
            $task_title = Request::exists('task_title') ? Request::input('task_title') : Request::input('title');
            $task_status = Request::get('task_status');
            $official_type = Request::get('official_type');
            $source = Request::get('act');
            $filter_subject_id = Request::input('filter_subject_id') != "undefined" ? Request::input('filter_subject_id') : '';
//            DB::enableQueryLog();
            $with_array = tasks::MyTasksPriority(['filter_subject_id'=>$filter_subject_id],$task_status, $task_title, $respite, $official_type,$source);
//            dd(DB::getQueryLog());
            $result['data'] = view('hamahang.Tasks.helper.priority.content')->with($with_array)->render();
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function filter_task_priority_time()
    {
        //dd(Request::all());
        $validator = Validator::make(Request::all(), [
            'task_title' => 'string',
            'respite' => 'integer',
            'official_type' => 'array',
            'task_status' => 'array',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $respite = Request::get('respite');
            $task_title = Request::get('task_title');
            $task_status = Request::get('task_status');
            $official_type = Request::get('official_type');
            $with_array = tasks::MyTasksPriorityTime($task_status, $task_title, $respite, $official_type);
            $result['data'] = view('hamahang.Tasks.helper.priority.content')->with($with_array)->render();
            $result['success'] = true;
            return json_encode($result);
        }
    }

    /*public function change_task_priority_user()
    {
        //die('sssss');
        $task = task_priority::where('task_id', '=', Request::input('tid'))->where('user_id', '=', Auth::id())->orderBy('timestamp', 'DESC')->first()->id;
        //die('SA'.$task);
        //$task = task_priority::where('task_id','=',Request::input('tid'))->where('user_id','=',Auth::id())->whereRaw('hamahang_task_priority.timestamp = (select max(`timestamp`) from
        //hamahang_task_priority where `hamahang_task_priority`.`task_id` = ? )',[Request::input('tid')])->update(['deleted'=>'1']);
        task_priority::where('id', '=', $task)->update(['deleted_at' => time()]);
        $task = new task_priority;
        $task->user_id = Auth::id();
        $task->uid = Auth::id();
        $task->task_id = Request::input('tid');
        $task->timestamp = time();
        if (Request::input('to') == 1)
        {
            $task->importance = 1;
            $task->immediate = 1;
        }
        elseif (Request::input('to') == 2)
        {
            $task->importance = 1;
            $task->immediate = 0;
        }
        elseif (Request::input('to') == 3)
        {
            $task->importance = 0;
            $task->immediate = 1;
        }
        elseif (Request::input('to') == 4)
        {
            $task->importance = 0;
            $task->immediate = 0;
        }
        $task->save();

        return 'ok';
    }*/
    public function change_task_priority()
    {
//        dd(Request::all(),Route::currentRouteName(),Route::getCurrentRoute()->getActionName());
        $validator = Validator::make(Request::all(),
            [
            'type' => 'required|in:important_and_immediate,important_and_not_immediate,not_important_and_immediate,not_important_and_not_immediate',
            'task_id' => 'required|exists:hamahang_task,id',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $task_id = Request::get('task_id');
            $task = tasks::find($task_id);
//            $task->Priorities()->delete();

            $action = Request::get('action');
            if($action=='my_assigned' || $task->uid==auth()->id())
            {
                $is_assigner[] = 1;
                task_priority::delete_priority($task_id,1,auth()->id());
            }else{
                $is_assigner[] = 0;
                task_priority::delete_priority($task_id,0,auth()->id());
            }

            switch (Request::get('type'))
            {
                case 'important_and_immediate':
                {
                    task_priority::create_task_priority($task_id, 1, 1, $is_assigner, auth()->id(), auth()->id(), time());
                    break;
                }
                case 'important_and_not_immediate':
                {
                    task_priority::create_task_priority($task_id, 0, 1, $is_assigner, auth()->id(), auth()->id(), time());
                    break;
                }
                case 'not_important_and_immediate':
                {
                    task_priority::create_task_priority($task_id, 1, 0, $is_assigner, auth()->id(), auth()->id(), time());
                    break;
                }
                case 'not_important_and_not_immediate':
                {
                    task_priority::create_task_priority($task_id, 0, 0, $is_assigner, auth()->id(), auth()->id(), time());
                    break;
                }
                default :
                {
                    break;
                }
            }
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function MyAssignedTasksList($uname)
    {
        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.process.list':
                $arr = variable_generator('user', 'desktop', $uname);
                $arr['filter_subject_id'] = $arr["sid"];
                $arr['HFM_CNT'] = HFM_GenerateUploadForm(
                    [
                        ['AddNewFiles',
                            ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
                            'Multi'
                        ]
                    ]
                );
                return view('hamahang.Tasks.MyAssignedTask.MyAssignedTasksList', $arr);
                break;
            case 'ugc.desktop.hamahang.process.list':
                $arr['HFM_CNT'] = HFM_GenerateUploadForm(
                    [
                        ['AddNewFiles',
                            ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
                            'Multi'
                        ]
                    ]
                );
                $arr = variable_generator('user', 'desktop', $uname);
                return view('hamahang.Tasks.MyAssignedTask.MyAssignedTasksList', $arr);
                break;
        }

    }

    public function MyAssignedTasksFetch()
    {
        $Tasks = tasks::MyAssignedTasks(Auth::id(), Request::input('subject_id'));

        return Datatables::of($Tasks)
            ->editColumn('type', function ($data)
            {
                return GetTaskStatusName($data->type);
            })
            ->editColumn('use_type', function ($data)
            {
                return hamahang_get_task_use_type_name($data->use_type);
            })
            ->addColumn('respite', function ($data)
            {
                $date = new jDateTime;
                $r = $date->getdate(strtotime($data->schedule_time) + $data->duration_timestamp);
                return $r['year'] . '/' . $r['mon'] . '/' . $r['mday'];
            })
            ->editColumn('immediate', function ($data)
            {
                if ($data->immediate == 1)
                {
                    $output = 'فوری';
                }
                else
                {
                    $output = 'غیرفوری';
                }
                if ($data->importance == 1)
                {
                    $output .= ' و مهم';
                }
                else
                {
                    $output .= ' و غیرمهم ';
                }
                return $output;
            })
            ->addColumn('employee', function ($data)
            {
                return $data->Name . ' ' . $data->Family;
            })
            ->make(true);
    }

    public function SaveAsLibraryTask()
    {
        $validator = Validator::make(Request::all(), [
            'task_type' => 'required',
            'task_id' => 'required',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $type = Request::input('task_type');
            $task_id = Request::input('task_id');
            hamahang_tasks_library::save_task_in_lib($task_id, $type);
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function SaveNewFiles()
    {
        if (Session::has('Files'))
        {
            $exist_files = drafts::GetDraftTaskFiles();
            $exist_files = unserialize($exist_files->files);
            $files = Session::get('Files');
            if (isset($files['TaskDrafts']) && is_array($files['TaskDrafts']))
            {
                $task_files = $files['TaskDrafts'];
                //die(var_dump($task_files))
                foreach ($task_files as $key => $value)
                {
                    if (isset($exist_files[$key]))
                    {

                    }
                    else
                    {
                        array_push($exist_files, $key);
                    }

                }
            }
            $files = serialize($exist_files);
            drafts::where('uid', '=', Auth::id())->where('id', '=', Request::input('tid'))->update(['files' => $files]);
        }
        session()->forget('Files');
        return json_encode('ok');

    }

    public function RemoveTaskFile()
    {
        $id = new EncryptString();
        $id = $id->decode(Request::input('fid'));
        task_files::where('id', $id)->delete();
        return json_encode(1);
    }
}
