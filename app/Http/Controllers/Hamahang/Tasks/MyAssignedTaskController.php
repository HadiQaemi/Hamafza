<?php

namespace App\Http\Controllers\Hamahang\Tasks;


use App\Http\Controllers\Hamahang\UserController;
use App\Models\hamafza\Pages;
use App\Models\Hamahang\Tasks\hamahang_process_tasks_relations;
use App\Models\Hamahang\Tasks\hamahang_project_task;
use App\Models\Hamahang\Tasks\task_history;
use App\Models\Hamahang\Tasks\task_action;
use App\Models\Hamahang\Tasks\task_priority_assigner;
use App\Models\Hamahang\Tasks\task_resources;
use App\Models\Hamahang\Tasks\task_relations;
use App\Models\Hamahang\Tasks\task_schedule;
use DB;
use Auth;
use Request;
use App\User;
use Datatables;
use Redirect;
use Validator;
use App\Models\Hamahang\Tasks\tasks;
use App\Models\Hamahang\Tasks\task_packages;
use App\Models\Hamahang\Tasks\task_assignments;
use App\Models\Hamahang\Tasks\task_status;
use App\Models\Hamahang\Tasks\task_staffs;
use App\Models\Hamahang\Tasks\task_transcripts;
use App\Models\Hamahang\Tasks\task_keywords;
use App\Models\Hamahang\Tasks\task_notices;
use App\Models\Hamahang\Tasks\task_qualities;
use App\Models\Hamahang\Tasks\task_rejections;
use App\Models\Hamahang\FileManager\FileManager;
use App\Models\Hamahang\Tasks\task_follow_ups;
use App\Models\Hamahang\Tasks\task_files;
use App\Models\Hamahang\Tasks\drafts;
use App\Models\Hamahang\Tasks\hamahang_tasks_library;
use App\Models\Hamahang\Tasks\task_transfers;
use App\Models\Hamahang\Tasks\task_logs;
use App\Models\Hamahang\Tasks\task_inheritance;
use App\Models\Hamahang\Tasks\task_priority;
use App\Models\Hamahang\OrgChart\org_organs;
use App\Models\Hamahang\Tasks\process_task;
use App\Models\Hamahang\Tasks\project_task;
use App\Models\Hamahang\Tasks\hamahang_subject_ables;
use App\Models\Hamahang\CalendarEvents\User_Event;
use App\Models\Hamahang\CalendarEvents\Events_Tasks;
use App\HamahangCustomClasses\EncryptString;
use App\HamahangCustomClasses\jDateTime;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\Hamahang\keywords;

class MyAssignedTaskController extends Controller
{
    public function MyAssignedTasksFetchPackeages()
    {
        $uname = Auth::id();
        $title = Request::get('title');
        $status_filter = Request::get('task_status');
        $official_type = Request::get('official_type');
        $important = Request::get('task_important');
        $immediate = Request::get('task_immediate');
        $filter_subject_id = Request::exists('filter_subject_id') ? Request::get('filter_subject_id') : '';

        $result = DB::table('hamahang_task')
            ->join('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
            ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
            ->join('user', 'user.id', '=', 'hamahang_task_assignments.employee_id')
            ->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
            ->where('hamahang_task_assignments.uid', '=', $uname)
            ->whereNull('hamahang_task_assignments.reject_description')
            ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
            ->whereRaw('hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id)')
            ->groupBy('hamahang_task.id');

        if(Request::input('package_type')=='persons')
        {
            $result = $result->select("hamahang_task.id as task_id", "hamahang_task_assignments.employee_id as type_field", "hamahang_task.title", "hamahang_task.id", "user.id as object_id", "user.Name", "user.Family", DB::raw('CONCAT(user.Name," ",user.Family) AS u_name'));
        }else if(Request::input('package_type')=='pages')
        {
            $result = $result
                ->join('pages', 'pages.id', '=', 'hamahang_subject_ables.subject_id')
                ->join('subjects', 'subjects.id', '=', 'pages.sid')
                ->select("hamahang_task.id as task_id","hamahang_subject_ables.subject_id as type_field", "hamahang_task.title", "subjects.id as object_id", "hamahang_task.id", "user.Name", "user.Family", 'subjects.title AS u_name');
        }else if(Request::input('package_type')=='keywords')
        {
            $result = $result->join('hamahang_task_keywords', 'hamahang_task_keywords.task_id', '=', 'hamahang_task.id')
                ->join('keywords', 'keywords.id', '=', 'hamahang_task_keywords.keyword_id')
                ->select("hamahang_task.id as task_id", "hamahang_subject_ables.subject_id as type_field", "keywords.id as object_id", "hamahang_task.title", "hamahang_task.id", "user.Name", "user.Family", 'keywords.title AS u_name');
        }

        if(trim($filter_subject_id)!='undefined')
        {
            $result->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id);
        }


        if ($title)
        {
            $result->where('hamahang_task.title', 'like', '%'.$title.'%');
        }

        if(Request::exists('users'))
        {
            $result->where(function ($result) {
                $result
                    ->whereIn('hamahang_task.uid', Request::input('users'))
                    ->orWhereIn('hamahang_task_assignments.uid', Request::input('users'));
            });
        }

        if ($official_type)
        {
            $result->whereIn('hamahang_task.type', $official_type)
                ->whereNull('hamahang_task.deleted_at');
        }
        else
        {
            $result->whereIn('hamahang_task.type', [11]);
        }

        if ($status_filter)
        {
            $result->whereIn('hamahang_task_status.type', $status_filter)
                ->whereNull('hamahang_task_status.deleted_at');
        }
        else
        {
            $result->whereIn('hamahang_task_status.type', [11]);
        }

        if ($immediate)
        {
            $result->whereIn('hamahang_task_priority.immediate', $immediate)
                ->whereNull('hamahang_task_priority.deleted_at');
//            dd($immediate);
        }
        else
        {
            $result->whereIn('hamahang_task_priority.immediate', [11]);
        }

        if ($important)
        {
            $result->whereIn('hamahang_task_priority.importance', $important)
                ->whereNull('hamahang_task_priority.deleted_at');
//            dd($important);
        }
        else
        {
            $result->whereIn('hamahang_task_priority.importance', [11]);
        }

        if(Request::exists('search_task_keywords'))
        {
            $search_task_keywords = [];
            foreach(Request::input('search_task_keywords') as $keyword)
            {
                $search_task_keywords[] = preg_replace('/exist_in/','',$keyword);
            }
            if ($search_task_keywords)
            {
                $result->join('hamahang_task_keywords', 'hamahang_task_keywords.task_id', '=', 'hamahang_task.id')
                    ->whereIn('hamahang_task_keywords.keyword_id', $search_task_keywords);
            }
        }

        $result = $result->get();
        $result_packages = [];
        foreach($result as $A_result)
        {
            $result_packages[$A_result->object_id]['tasks'][] = $A_result;
            $result_packages[$A_result->object_id]['name'] = $A_result->u_name;
            $result_packages[$A_result->object_id]['object_id'] = $A_result->object_id;
        }
        return view('hamahang.Tasks.MyAssignedTask.helper.MyAssignedTasksPackages.content', compact('uname', 'result_packages'));
    }
    public function FetchTranscriptsList()
    {
        $Tasks = tasks::MyTranscriptsTasks(Auth::id(), Request::input('subject_id'));

        return Datatables::of($Tasks)
            ->editColumn('type', function ($data)
            {
                return GetTaskStatusName($data->type);
            })
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
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
            ->addColumn('keywords', function ($data)
            {
                $r = (tasks::TakKeywords($data->id));

                $rr = [];
                foreach($r as $Ar)
                    $rr[]= ['id'=>$Ar->id,'title'=>$Ar->title];
                return json_encode($rr);
            })
            ->addColumn('employee', function ($data)
            {
                return "<a href='" . url('/' . $data->Uname) . "' target='_blank'>" . $data->Name . " " . $data->Family . "</a>";
            })
            ->rawColumns(['employee'])
            ->make(true);
    }
    public function get_transcripts($uname)
    {
        $get_menu = '';
        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.tasks.my_assigned_tasks.transcripts':
                $arr = variable_generator('page', 'desktop', $uname);
                $arr['get_menu'] = $get_menu;
                $arr['filter_subject_id'] = $arr["sid"];
                $arr['HFM_CNT'] = HFM_GenerateUploadForm(
                    [
                        ['AddNewFiles',
                            ['jpeg', 'jpg', 'png', 'gif', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
                            'Multi'
                        ]
                    ]
                );
                return view('hamahang.Tasks.MyAssignedTask.MyTranscriptsTasksList', $arr);
                break;
            case 'ugc.desktop.hamahang.tasks.my_assigned_tasks.transcripts':
                $arr['HFM_CNT'] = HFM_GenerateUploadForm(
                    [
                        ['AddNewFiles',
                            ['jpeg', 'jpg', 'png', 'gif', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
                            'Multi'
                        ]
                    ]
                );
                $arr = variable_generator('user', 'desktop', $uname);
                $arr['get_menu'] = $get_menu;
                return view('hamahang.Tasks.MyAssignedTask.MyTranscriptsTasksList', $arr);
                break;
        }
    }

    private function my_assigned_task_in_status($arr =[],$user = false)
    {
        if (!$user)
        {
            $user = auth()->user();
        }
        $filter_subject_id = isset($arr['filter_subject_id']) ? $arr['filter_subject_id'] : '';
        $official_type = [0,1];
        $importance = [0,1];
        $immediate = [0,1];

        $myTasks=[];
        $myTasks['not_started'] = $user->MyAssignedTasks()->whereHas('Status', function ($q)
        {
            $q->where('type', 0);
        });
        if (trim($filter_subject_id)!='')
        {
            $myTasks['not_started']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $myTasks['not_started'] = $myTasks['not_started']->groupBy('hamahang_task.id')->get();
        $myTasks['started'] = $user->MyAssignedTasks()->whereHas('Status', function ($q)
        {
            $q->where('type', 1);
        });
        if (trim($filter_subject_id)!='')
        {
            $myTasks['started']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $myTasks['started'] =  $myTasks['started']->groupBy('hamahang_task.id')->get();
        $myTasks['done'] = $user->MyAssignedTasks()->whereHas('Status', function ($q)
        {
            $q->where('type', 2);
        });
        if (trim($filter_subject_id)!='')
        {
            $myTasks['done']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $myTasks['done'] = $myTasks['done']->groupBy('hamahang_task.id')->get();
        $myTasks['ended'] = $user->MyAssignedTasks()->whereHas('Status', function ($q)
        {
            $q->where('type', 3);
        });
        if (trim($filter_subject_id)!='')
        {
            $myTasks['ended']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $myTasks['ended'] = $myTasks['ended']->groupBy('hamahang_task.id')->get();
        $user = auth()->user();


        return view('hamahang.Tasks.MyAssignedTask.helper.MyAssignedTaskState.content', compact('user', 'myTasks'));
    }

    private function my_assigned_tasks_package()
    {
        $user = auth()->user();
        $filter_subject_id = isset($arr['filter_subject_id']) ? '' : '';
        $official_type = [0,1];
        $importance = [0,1];
        $immediate = [0,1];

        $myTasks = $user->MyAssignedTasks()->with('subject');
        if (trim($filter_subject_id)!='')
        {
            $myTasks['not_started']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $myTasks = $myTasks->get();
        dd($myTasks);
        return view('hamahang.Tasks.MyAssignedTask.helper.MyAssignedTaskState.content', compact('user', 'myTasks'));
    }

    public function MyAssignedTasksPriority($uname)
    {
        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.tasks.my_assigned_tasks.priority':
                $arr = variable_generator('page', 'desktop', $uname);
                $arr['filter_subject_id'] = $arr["sid"];
//                db::enableQueryLog();
                $arr = array_merge($arr, tasks::MyAssignedTasksPriority($arr,[0,1],false,false,[0,1]));
//                dd(db::getQueryLog());
                return view('hamahang.Tasks.MyAssignedTask.priority', $arr);
                //return view('hamahang.Tasks.MyAssignedTask.MyAssignedTasksPriority', $arr);
                break;
            case 'ugc.desktop.hamahang.tasks.my_assigned_tasks.priority':
                $arr = variable_generator('user', 'desktop', $uname);
//                DB::enableQueryLog();dd(DB::getQueryLog());
                $arr = array_merge($arr, tasks::MyAssignedTasksPriority($arr,[0,1],false,false,[0,1]));
//                dd(DB::getQueryLog());
                return view('hamahang.Tasks.MyAssignedTask.priority', $arr);
                //return view('hamahang.Tasks.MyAssignedTask.MyAssignedTasksPriority', $arr);
                break;
        }
    }

    public function MyAssignedTasksState($uname)
    {
        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.tasks.my_assigned_tasks.state':
                $arr = variable_generator('page', 'desktop', $uname);
                //$arr['tasks'] = tasks::FetchTasksForMyAssignedTasksState($uname);
                $arr['filter_subject_id'] = $arr["sid"];
                $arr['MyTasksInState'] = $this->my_assigned_task_in_status($arr)->render();
                return view('hamahang.Tasks.MyAssignedTask.MyAssignedTasksState', $arr);
                break;
            case 'ugc.desktop.hamahang.tasks.my_assigned_tasks.state':
                $arr = variable_generator('user', 'desktop', $uname);
                $arr['attach_files'] = HFM_GenerateUploadForm([['new_process_task', ['pdf', 'jpg', 'zip', 'docx', 'xlsx', 'ppt', 'pptx'], 'Multi']]);
                $arr['MyTasksInState'] = $this->my_assigned_task_in_status($arr)->render();
                return view('hamahang.Tasks.MyAssignedTask.MyAssignedTasksState', $arr);
                break;
        }
    }

    public function change_type_task()
    {
        $validator = Validator::make(Request::all(),
            [
                'type' => 'required|in:task_notstarted,task_done,task_started,task_ended',
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
            switch (Request::get('type'))
            {
                case 'task_notstarted':
                {
                    $task->Status()->delete();
                    $task->Statuses()->create([
                        'uid' => auth()->id(),
                        'user_id' => auth()->id(),
                        'task_id' => $task_id,
                        'percent' => 0,
                        'type' => 0,
                        'timestamp' => time(),
                    ]);
                    $result['success'] = true;
                    break;
                }
                case 'task_done':
                {
                    $task->Status()->delete();
                    $task->Statuses()->create([
                        'uid' => auth()->id(),
                        'user_id' => auth()->id(),
                        'task_id' => $task_id,
                        'percent' => 0,
                        'type' => 2,
                        'timestamp' => time(),
                    ]);
                    $result['success'] = true;
                    break;
                }
                case 'task_started':
                {
                    $task->Status()->delete();
                    $task->Statuses()->create([
                        'uid' => auth()->id(),
                        'user_id' => auth()->id(),
                        'task_id' => $task_id,
                        'percent' => 0,
                        'type' => 1,
                        'timestamp' => time(),
                    ]);
                    $result['success'] = true;
                    break;
                }
                case 'task_ended':
                {
                    if($task->end_on_assigner_accept == 0 || auth()->id() != $task->uid){
                        $result['success'] = false;
                        $result['error']= trans('tasks.cant_end_this_task');
                        return $result;
                    }
                    else{
                        $task->Status()->delete();
                        $task->Statuses()->create([
                            'uid' => auth()->id(),
                            'user_id' => auth()->id(),
                            'task_id' => $task_id,
                            'percent' => 0,
                            'type' => 3,
                            'timestamp' => time(),
                        ]);
                        $result['success'] = true;
                    }
                    break;
                }
                default :
                {
                    break;
                }
            }

            $result['data']=$this->my_assigned_task_in_status()->render();
            return $result;

        }
    }

    public function filter_mytask()
    {
        $user=auth()->user();
        $validator = Validator::make(Request::all(), [
            'task_title' => 'string',
            'respite' => 'integer',
            'official_type' => 'array',
            'task_important' => 'array',
            'task_immediate' => 'array',

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
            $task_important = Request::get('task_important');
            $task_immediate = Request::get('task_immediate');
            $official_type = Request::get('official_type');
            $filter_subject_id = Request::input('filter_subject_id');
//            DB::enableQueryLog();
            $myTasks= tasks::MyAssignerTasksStatus($filter_subject_id,$task_important,$task_immediate, $task_title, $respite, $official_type);
//            dd(DB::getQueryLog());
            $result['success'] = true;
            $result['data'] = view('hamahang.Tasks.MyAssignedTask.helper.MyAssignedTaskState.content', compact('user', 'myTasks'))->render();
            $result['success'] = true;
            return $result;
        }
    }

    public function ShowCustomMyAssignedTasks()
    {
        DB::enableQueryLog();
        $data = DB::table('hamahang_task')
            ->select("hamahang_task.id", "title", "hamahang_task_priority.importance", "hamahang_task_priority.immediate", 'hamahang_task.schedule_time as created', "duration_timestamp", "type", DB::raw('CONCAT(Name, " ", Family) AS full_name'))
            ->join('hamahang_task_assignments', 'hamahang_task_assignments.task_id', 'hamahang_task.id')
            ->join('user', 'hamahang_task_assignments.employee_id', '=', 'user.id')
            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
            ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
            ->where('hamahang_task_assignments.assigner_id', '=', Auth::id())
            ->whereNull('hamahang_task_assignments.transmitter_id')
            ->whereNull('hamahang_task_assignments.deleted_at');
        if (Request::input('str') != '')
        {
            $data->where("hamahang_task.title", "LIKE", "%" . Request::input('str') . "%");
        }
        if (Request::input('respite_day_no') > 0)
        {
            date_default_timezone_set('Asia/Tehran');
            //$timestamp = mktime(0, 0, 0, date('m'), date('d'), date('y'));
            $timestamp = time();
            $timestamp = $timestamp - ($timestamp % 86400);

            $respite_max = ((Request::input('respite_day_no')) * 86400) + $timestamp;
            $data->where(DB::raw("duration_timestamp + UNIX_TIMESTAMP(`hamahang_task`.`schedule_time`)"), "<=", $respite_max);
        }
        $data->where(function ($query)
        {
            if (Request::input('started_tasks') == 1)
            {
                $query->orwhere('hamahang_task_status.type', "=", 1);
            }

            if (Request::input('not_started_tasks') == 1)
            {
                $query->orwhere('hamahang_task_status.type', "=", 0);
            }
            if (Request::input('done_tasks') == 1)
            {
                $query->orwhere('hamahang_task_status.type', "=", 2);
            }

            if (Request::input('completed_tasks') == 1)
            {
                $query->orwhere('hamahang_task_status.type', "=", 3);
            }

            if (Request::input('stoped_tasks') == 1)
            {
                $query->orwhere('hamahang_task_status.type', "=", 4);
            }

        });
        $data->where(function ($query)
        {
            if (Request::input('individual') == 1)
            {
                $query->orwhere('hamahang_task.type', "=", 1);
            }
            if (Request::input('official') == 1)
            {
                $query->orwhere('hamahang_task.type', "=", 0);
            }
        });
        $data->whereRaw('`hamahang_task_priority`.`id` = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id and hamahang_task_priority.`deleted_at` is Null and
            `hamahang_task_priority`.`user_id`= ?)', [Auth::id()])//->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
        ;
        $x = $data->get();
//        dd(DB::getQueryLog());
        date_default_timezone_set('Asia/Tehran');
        foreach ($x AS $task)
        {
            $respite_date = date('Y-m-d', $task->duration_timestamp);
            $date1 = date_create($respite_date);
            $date2 = date_create(date('Y-m-d'));
            $diff = date_diff($date2, $date1);
            $task->respite_days = hamahang_respite_remain(strtotime($task->created), $task->duration_timestamp);
            if ($task->respite_days[0]['delayed'] == 1)
            {
                $task->respite_days = ($task->respite_days[0]['day_no']) * (-1);
            }
            else
            {
                $task->respite_days = $task->respite_days[0]['day_no'];
            }
        }
        $data = array('data' => $x);
        return response()->json($data);
    }

    public function show_MyAssignedTasks_custom_for_states()
    {
        $data = tasks::select('hamahang_task.id', 'hamahang_task_assignments.id as assid', 'title', 'duration_timestamp', 'hamahang_task.schedule_time as created', 'type', 'employee_id')
            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
            ->join('hamahang_task_assignments', 'hamahang_task_assignments.task_id', '=', 'hamahang_task.id')
            ->where('hamahang_task_assignments.transmitter_id', '=', null)
            ->where('hamahang_task_assignments.assigner_id', '=', Auth::id())
            ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )');

        if (Request::input('str') != '')
        {
            $data->where("hamahang_task.title", "LIKE", "%" . Request::input('str') . "%");
        }

        if (Request::input('respite_day_no') > 0)
        {
            date_default_timezone_set('Asia/Tehran');
            $respite_max = ((Request::input('respite_day_no')) * 86400) + time() + 86400;
            $data->where(DB::raw("duration_timestamp + UNIX_TIMESTAMP(`hamahang_task`.`schedule_time`)"), "<=", $respite_max);
        }

        $data->where(function ($query)
        {
            if (Request::input('individual') == 1)
            {
                $query->orwhere('hamahang_task.type', "=", 1);
            }

            if (Request::input('official') == 1)
            {
                $query->orwhere('hamahang_task.type', "=", 0);
            }
        });
        if (Request::exists('page_id'))
        {
            $data->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=', Request::input('page_id'))
                ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\tasks')
                ->whereNull('hamahang_subject_ables.deleted_at');

        }
        $x = $data->get();

        date_default_timezone_set('Asia/Tehran');
        $temp = 0;
        foreach ($x AS $task)
        {

            $respite_date = date('Y-m-d', $task->respite);
            $date1 = date_create($respite_date);
            $date2 = date_create(date('Y-m-d'));
            $diff = date_diff($date2, $date1);
            $task->respite_days = hamahang_respite_remain(strtotime($task->created), $task->duration_timestamp);
//            var_dump($task->respite_days);
//            echo '<hr/>';

            if ($task->respite_days[0]['delayed'] == 1)
            {
                $task->respite_days = ($task->respite_days[0]['day_no']) * (-1);
            }
            else
            {
                $task->respite_days = $task->respite_days[0]['day_no'];
            }
            $user_name = task_assignments::select('user.name AS user_name', 'employee_id')->join('user', 'hamahang_task_assignments.employee_id', '=', 'user.id')->where('hamahang_task_assignments.task_id', '=', $task->id)->first();
            $task->user_name = $user_name['user_name'];
//            if($temp == 1)
//            die(var_dump($task));
//            $temp++;
        }

        $data = array('data' => $x);
        return response()->json($data);

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

    public function CreateNewTask($uname)
    {
        //Auth::loginUsingId('4870');
        $arr = variable_generator('user', 'desktop', $uname);
        $arr['HFM_CNT'] = HFM_GenerateUploadForm(
            [
                ['CreateNewTask',
                    ['jpeg', 'jpg', 'png', 'gif', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
                    'Multi'
                ]
            ]
        );
        return view('hamahang.Tasks.CreateNewTask', $arr);
    }

    public function MyAssignedTasksList($uname)
    {
        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.tasks.my_assigned_tasks.list':
                $arr = variable_generator('page', 'desktop', $uname);
                $arr['filter_subject_id'] = $arr["sid"];
                $arr['HFM_CNT'] = HFM_GenerateUploadForm(
                    [
                        ['AddNewFiles',
                            ['jpeg', 'jpg', 'png', 'gif', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
                            'Multi'
                        ]
                    ]
                );
                return view('hamahang.Tasks.MyAssignedTask.MyAssignedTasksList', $arr);
                break;
            case 'ugc.desktop.hamahang.tasks.my_assigned_tasks.list':
                $arr['HFM_CNT'] = HFM_GenerateUploadForm(
                    [
                        ['AddNewFiles',
                            ['jpeg', 'jpg', 'png', 'gif', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
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
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
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
            ->addColumn('keywords', function ($data)
            {
                $r = (tasks::TakKeywords($data->id));

                $rr = [];
                foreach($r as $Ar)
                    $rr[]= ['id'=>$Ar->id,'title'=>$Ar->title];
                return json_encode($rr);
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
                return "<a href='" . url('/' . $data->Uname) . "' target='_blank'>" . $data->Name . " " . $data->Family . "</a>";
            })
            ->rawColumns(['employee'])
            ->make(true);
    }

    public function RemoveTaskFile()
    {
        $id = new EncryptString();
        $id = $id->decode(Request::input('fid'));
        task_files::where('id', $id)->delete();
        return json_encode(1);
    }

    public function TaskRestart()
    {
        task_status::create_task_status(Request::input('tid'), 1, 0, -1, time());

        $status = task_status::where('task_id', '=', Request::input('tid'))
            ->select('type', 'percent', 'timestamp')->orderBy('id', 'Desc')->get();
        $date = new jDateTime();
        foreach ($status as $st)
        {
            $st->timestamp = $date->date("Y-m-d", $st->timestamp);
        }
        return json_encode($status);
    }

    public function SaveAsLibraryTask()
    {
        $validator = Validator::make(Request::all(), [
            'task_type' => 'required',
//            'task_id' => 'required',
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

    public function task_info()
    {
        $date = new jDateTime();
        date_default_timezone_set('Asia/Tehran');
        $task_info = DB::table('hamahang_task_assignments')
            ->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
            ->select('hamahang_task.end_on_assigner_accept as assigner_accept', 'hamahang_task.*', 'duration_timestamp', 'hamahang_task_assignments.assigner_id', DB::raw('unix_timestamp(hamahang_task.schedule_time) as created'))
            ->where('hamahang_task.id', Request::input('id'))
            ->get();
        $r = $date->getdate($task_info[0]->duration_timestamp + $task_info[0]->created);
        $task_info[0]->respite_day = $r['year'] . '/' . $r['mon'] . '/' . $r['mday'];
        $keyword = DB::table('hamahang_task_keywords')
            ->join('keywords', 'hamahang_task_keywords.id', '=', 'keywords.id')
            ->select('keyword')//->where('hamahang_task_assignments.assigner_id','=','hamahang_task_keywords.uid')
            ->where('hamahang_task_keywords.task_id', $task_info[0]->id)->get();
        $arr1 = [];
        if (sizeof($keyword) > 0)
        {
            foreach ($keyword as $kw)
            {
                array_push($arr1, $kw->keyword);
            }
        }
        $task_info[0]->kw = $arr1;
        $Mykeyword = DB::table('hamahang_task_keywords')
            ->join('keywords', 'keywords.id', '=', 'hamahang_task_keywords.keyword_id')
            ->select('keywords.title', 'hamahang_task_keywords.id')
            ->where('task_id', $task_info[0]->id)
            ->where('hamahang_task_keywords.uid', '=', Auth::id())->whereNull('hamahang_task_keywords.deleted_at')
            ->get();
        $arr12 = [];
        if (sizeof($Mykeyword) > 0)
        {
            foreach ($Mykeyword as $Mykw)
            {
                array_push($arr12, [$Mykw->id, $Mykw->keyword]);
            }
        }
        $task_info[0]->MyKw = $arr12;

        $task_packages = DB::table('hamahang_task_package')
            ->join('hamahang_task_user_package', 'hamahang_task_user_package.package_id', 'hamahang_task_package.id')
            ->select('title', 'hamahang_task_user_package.id')
            ->where('task_id', $task_info[0]->id)
            ->where('hamahang_task_user_package.uid', '=', Auth::id())
            ->whereNull('hamahang_task_user_package.deleted_at')
            ->get();
        $arr13 = [];
        if (sizeof($task_packages) > 0)
        {
            foreach ($task_packages as $tspc)
            {
                array_push($arr13, $tspc);
            }
        }
        $task_info[0]->task_packages = $arr13;


        $arr2 = [];
//        $att = DB::table('hamahang_task_attachment')->where('hamahang_task_attachment.task_id', $task_info[0]->id)->get();
//        if (sizeof($att) > 0)
//        {
//            foreach ($att as $at)
//            {
//                array_push($arr2, $at->file_id);
//            }
//        }
        $task_info[0]->att = $arr2;
        $employee = DB::table('hamahang_task_assignments')
            ->join('user', 'hamahang_task_assignments.employee_id', '=', 'user.id')
            ->select('user.id as uuid', 'user.Name', 'user.Family', 'user.Pic', 'hamahang_task_assignments.*')
            ->where('hamahang_task_assignments.task_id', $task_info[0]->id)//->where('hamahang_task_assignments.id', '=', Request::input('id'))
            ->get();

        $arr3 = [];

        if (sizeof($employee) > 0)
        {
            foreach ($employee as $em)
            {
                array_push($arr3, [$em->Name . ' ' . $em->Family, $em->Pic, $em->uuid]);
            }
            $task_info[0]->employee = $arr3;
        }
        if ($task_info[0]->assigner_id == Auth::id())
        {
            $follow_up = DB::table('hamahang_task_follow_up')->join('user', 'hamahang_task_follow_up.uid', '=', 'user.id')->where('hamahang_task_follow_up.task_id', $task_info[0]->id)->select('user.Name as uname', 'user.Family as fname', 'hamahang_task_follow_up.*', 'user.Pic')->orderBy('hamahang_task_follow_up.timestamp', 'Desc')->get();
        }
        else
        {
            $follow_up = DB::table('hamahang_task_follow_up')->join('user', 'hamahang_task_follow_up.uid', '=', 'user.id')->where('hamahang_task_follow_up.assign_id', Request::input('id'))->select('user.Name as uname', 'user.Family as fname', 'hamahang_task_follow_up.*', 'user.Pic')->orderBy('hamahang_task_follow_up.timestamp', 'Desc')->get();
        }
        //die(var_dump($follow_up));
        $arr4 = [];

        foreach ($follow_up as $fu)
        {
            if ($fu->employee_id == Auth::id())
            {
                $fu->employee_id = 'me';
                //$fu->uname = "";

            }
            if ($fu->Pic == '')
            {
                $fu->Pic = 'Users2.png';
            }
            array_push($arr4, [$fu->description, $date->getdate("H:m:s Y-m-d ", $fu->timestamp), $fu->employee_id, $fu->uname, $fu->fname, $fu->Pic]);
        }
        $task_info[0]->follow_up = $arr4;
        $transcripts = DB::table('hamahang_task_transcript')->join('user', 'hamahang_task_transcript.user_id', '=', 'user.id')->select('user.*')->where('hamahang_task_transcript.task_id', $task_info[0]->id)->get();
        $arr5 = [];

        if (sizeof($transcripts) > 0)
        {
            foreach ($transcripts as $tr)
            {
                array_push($arr5, [$tr->Name . ' ' . $tr->Family, $tr->id]);
            }
        }
        $task_info[0]->transcript = $arr5;
        $arr6 = [];
        if (isset($employee[0]->id))
        {
            $staffs = DB::table('hamahang_task_staff')->join('user', 'hamahang_task_staff.user_id', '=', 'user.id')->where('hamahang_task_staff.assignment_id', '=', $employee[0]->id)->get();

            if (sizeof($staffs) > 0)
            {
                foreach ($staffs as $st)
                {
                    array_push($arr6, $st->Name);
                }
            }
        }
        $task_info[0]->staff = $arr6;

        $status = task_status::where('task_id', '=', $task_info[0]->id)->select('type', 'percent', 'timestamp')->orderBy('id', 'Desc')->get();
//        $status = DB::table('hamahang_task_status')
//            ->where('hamahang_task_status.task_id', $task_info[0]->id)
//            ->get();

        $arr7 = [];
        foreach ($status as $st)
        {
            $st->timestamp = $date->date("Y-m-d", $st->timestamp);
            array_push($arr7, $st);
        }
        $task_info[0]->status = $arr7;


        $quality = task_qualities::where('task_id', '=', $task_info[0]->id)->select('quality_id', 'timestamp')->orderBy('id', 'Desc')->get();
        $arr10 = [];
        foreach ($quality as $qlty)
        {
            $qlty->timestamp = $date->date("Y-m-d", $qlty->timestamp);
            array_push($arr10, $qlty);
        }
        $task_info[0]->quality = $arr10;

//
//        $q = task_qualities::where('task_id', '=', $task_info[0]->id)->orderBy('timestamp', 'DESC')->first();
//        if (isset($q->quality_id))
//            $task_info[0]->quality = $q->quality_id;
//        else
//            $task_info[0]->quality = 0;

        $file = DB::table('hamahang_files')->join('hamahang_task_files', 'hamahang_task_files.file_id', 'hamahang_files.id')->where('hamahang_task_files.task_id', '=', $task_info[0]->id)->get();
        $arr8 = [];
        foreach ($file as $f)
        {
            array_push($arr8, $f);
        }
        $task_info[0]->files = $arr8;

        $arr9 = [];
        $history = DB::table('hamahang_task_log')->where('task_id', '=', $task_info[0]->id)->orderBy('timestamp', 'DESC')->get();

        foreach ($history as $h)
        {
            $h->transferer = '';
            $h->reason = '';
            $h->transfer_from = '';
            $h->transferred_to_id = '';
            $h->cur_state = '';
            $h->percent = 0;
            $h->cur_state_id = 0;
            $user = '';
            switch ($h->type)
            {
                case 'stop':
                    $user = DB::table('user')->where('id', '=', $h->uid)->select('Name', 'Family')->first();
                    $user = $user->Name . ' ' . $user->Family;
                    break;
                case 'create':
                    $user = DB::table('user')->where('id', '=', $h->uid)->select('Name', 'Family')->first();
                    $user = $user->Name . ' ' . $user->Family;
                    break;
                case 'status':
                    $sts = task_status::where('id', '=', $h->task_type)->first();
                    switch ($sts['type'])
                    {
                        case 0;
                            $h->cur_state_id = 0;
                            $h->cur_state = 'آغازنشده';
                            break;
                        case 1;
                            $h->cur_state_id = 1;
                            $h->cur_state = 'در حال انجام';
                            $h->percent = $sts->percent;
                            break;
                        case 2;
                            $h->cur_state_id = 2;
                            $h->cur_state = 'انجام شده';
                            break;
                        case 3;
                            $h->cur_state_id = 3;
                            $h->cur_state = 'پایان یافته';
                            break;
                        case 4;
                            $h->cur_state_id = 4;
                            $h->cur_state = 'متوقف';
                            break;
                    }
                    break;
                case 'reject':
                    //$h->type = 'بازگردانی';
                    break;
                case 'transfer':
                    $transferer = DB::table('user')->where('id', '=', $h->uid)->select('Name', 'Family')->get();
                    $transfer_info = DB::table('hamahang_task_assignments')->where('id', '=', $h->assign_id)->select('transferred_to_id', 'transmitter_id')->get();

                    $transfer_from = DB::table('user')->where('id', '=', $transfer_info[0]->transmitter_id)->select('Name', 'Family')->get();
                    $h->transfer_from = $transfer_from[0]->Name . ' ' . $transfer_from[0]->Family;
                    $transferred_to_id = DB::table('user')->where('id', '=', $transfer_info[0]->transferred_to_id)->select('Name', 'Family')->get();
                    $h->transferred_to_id = $transferred_to_id[0]->Name . ' ' . $transferred_to_id[0]->Family;
                    $h->transmitter_id = $transferer[0]->Name . ' ' . $transferer[0]->Family;
                    $transfer_reason = DB::table('hamahang_task_transfer')->where('assignment_id', '=', $h->assign_id)->get();
                    $h->reason = $transfer_reason[0]->description;
                    break;

            }
            array_push($arr9, [$h->type, $date->date("Y-m-d", $h->timestamp), $date->date("H:m:s", $h->timestamp), $h->transferer, $h->reason, $h->transfer_from, $h->transferred_to_id, $h->cur_state, $h->percent, $h->cur_state_id, $user]);
        }
        $task_info[0]->history = $arr9;
        $arr15 = [];
        DB::enableQueryLog();


        $progress = task_inheritance::where('parent_task_id', $task_info[0]->id)
            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task_inheritance.task_id')
            ->whereNull('hamahang_task_inheritance.deleted_at')
            ->select('hamahang_task_inheritance.id', 'hamahang_task_inheritance.task_id', 'weight', 'parent_task_id', 'percent')
            ->get();
//        die(dd($progress));
//        $sum = 0;
//        $average = 0;
//        $couter = 0;
//        foreach ($progress as $p) {
//            $sum += $p->weight;
//            $couter++;
//        }
//        $total_percent_sum = 0;
//        if ($sum > 0)
//            foreach ($progress as $p) {
//                $p->percent_of_total = ($p->weight * 100) / $sum;
//                $p->tPercent = ((($p->percent) / 100) * (($p->percent_of_total) / 100)) * 100;
//                $total_percent_sum += $p->tPercent;
//            }
//        else
//            $total_percent_sum = 0;


        //$xx = $this->getChildren($task_info[0]->id);
        // die(var_dump($xx));
        //$total_percent_sum = $this->child_progress($task_info[0]->id);
        //$total_percent_sum = (int)number_format($total_percent_sum,2,'.',',');
        // $total_percent_sum = 0;
        // $total_percent_sum = (float)sprintf('%0.2f', $total_percent_sum);
        //  die($total_percent_sum . "xxx");
        // $task_info[0]->progress = $total_percent_sum;
//        die(var_dump($progress));

        $x = get_object_vars($task_info[0]);
        return json_encode($x);
    }

    public function update_task()
    {
        $validator = Validator::make(Request::all(), [
            'title' => 'required|string',
            'users' => 'required|array',
        ],[
            'selected_users.required'=>'باید کاربر انتخاب شود'
        ],[
                'title'=>'عنوان وظیفه',
                'users'=>'کاربر'
            ]
        );
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else {
            $result = '';
            if (Request::input('respite_timing_type') == 1)
            {
                $respite_duration_timestamp = hamahang_make_task_respite(Request::input('respite_date'), Request::input('respite_time'));
            }
            elseif (Request::input('respite_timing_type') == 2)
            {
                $respite_duration_timestamp = hamahang_convert_respite_to_timestamp(0, 0, 0, 0, 0, 0);
            }
            elseif (Request::input('respite_timing_type') == 0)
            {
                $day_no = Request::input('duration_day');
                $hour_no = Request::input('duration_hour');//Request::input('duration_hour');
                $min_no = Request::input('duration_min');//Request::input('duration_min');
                $sec_no = 0;//Request::input('duration_sec');
                $respite_duration_timestamp = hamahang_convert_respite_to_timestamp(0, 0, $day_no, $hour_no, $min_no, $sec_no);
            }
            $task = tasks::where('id','=',deCode(Request::input('tid')))->first();

            if(Request::exists('task_form_action')==1)
            {
                if (Request::exists('new_task_resources_h'))
                {
                    DB::table('hamahang_task_resources')
                        ->where('hamahang_task_resources.task_id','=', deCode(Request::input('tid')))
                        ->whereNull('deleted_at')
                        ->update(['deleted_at'=>date('Y-m-d H:i:s')]);

                    $new_task_resources_amount = Request::input('new_task_resources_amount');
                    $new_task_resources_cost = Request::input('new_task_resources_cost');
                    foreach (Request::input('new_task_resources_h') as $k => $kw)
                    {
                        //$task_id, $amount, $cost, $resource_id
                        task_resources::create_task_resource($task->id, $new_task_resources_amount[$k],$new_task_resources_cost[$k],new_hamafza_add_resource($kw));
                    }
                }
                if (Request::exists('task_schedul'))
                {
                    DB::table('hamahang_task_schedule')
                        ->where('hamahang_task_schedule.task_id','=', deCode(Request::input('tid')))
                        ->whereNull('deleted_at')
                        ->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                    $schedul = array(
                        'task_schedul' => Request::input('task_schedul'),
                        'task_schedul_num' => Request::input(Request::input('task_schedul').'_num'),
                        'task_schedul_value' => Request::input(Request::input('task_schedul').'_value')
                    );

                    task_schedule::create_task_schedule($task->id, Request::input('task_schedul'),serialize($schedul),
                        Request::input('schedul_begin_date'), Request::input('schedul_end_date'), Request::input('schedul_end_date_date'), Request::input('schedul_end_num_events'));
                }
                if (Request::exists('pages'))
                {
                    DB::table('hamahang_subject_ables')
                        ->where('hamahang_subject_ables.target_id','=', deCode(Request::input('tid')))
                        ->whereNull('deleted_at')
                        ->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                    foreach (Request::input('pages') as $page_id)
                    {
                        hamahang_subject_ables::create_items_page($page_id, $task->id,  'App\Models\Hamahang\Tasks\tasks');
                    }
                }

                if (Request::exists('new_task_tasks_'))
                {
                    DB::table('hamahang_task_relations')
                        ->where('hamahang_task_relations.task_id1','=', deCode(Request::input('tid')))
                        ->whereNull('deleted_at')
                        ->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                    foreach (Request::input('new_task_tasks_') as $k=>$task_id)
                    {
                        task_relations::create_task_relation($task->id, $task_id, Request::input('new_task_delay_num')[$k], Request::input('new_task_delay_type')[$k], Request::input('new_task_relation')[$k], Request::input('new_task_weight')[$k]);
                    }
                }
                if (Request::exists('transcripts'))
                {
                    DB::table('hamahang_task_transcript')
                        ->where('hamahang_task_transcript.task_id','=', deCode(Request::input('tid')))
                        ->whereNull('deleted_at')
                        ->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                    if(Request::input('report_on_cr')==1)
                    {
                        foreach (Request::input('transcripts') as $transcript)
                        {
                            task_transcripts::create_task_transcript($task->id, $transcript);
                        }
                    }
                }
                if (Request::exists('keywords'))
                {
                    DB::table('hamahang_task_keywords')
                        ->where('hamahang_task_keywords.task_id','=', deCode(Request::input('tid')))
                        ->whereNull('deleted_at')
                        ->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                    foreach (Request::input('keywords') as $kw)
                    {
                        task_keywords::create_task_keyword($task->id, hamahang_add_keyword(hamahang_get_keyword_value($kw)));
                    }
                }
                if (Request::exists('project_tasks'))
                {
                    DB::table('hamahang_project_task')
                        ->where('hamahang_project_task.task_id','=', deCode(Request::input('tid')))
                        ->whereNull('deleted_at')
                        ->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                    foreach (Request::input('project_tasks') as $project_id)
                    {
                        hamahang_project_task::create_task_project($task->id, $project_id);
                    }
                }

                $staff = '';
                if (Request::exists('users'))
                {
                    DB::table('hamahang_task_assignments')
                        ->where('hamahang_task_assignments.task_id','=', deCode(Request::input('tid')))
                        ->whereNull('deleted_at')
                        ->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                    foreach (Request::input('users') as $key => $value_employee_id)
                    {
                        if(Request::input('assign_type') == 1 )
                        {
                            if($key == 0)
                            {
                                $staff = Request::input('users')[0];
                                task_assignments::create_task_assignment(Request::input('users')[$key] ,$staff ,$task->id);
                            }
                            else
                            {
                                task_assignments::create_task_assignment(Request::input('users')[$key] ,$staff ,$task->id);
                            }
                        }
                        elseif(Request::input('assign_type') == 2)
                        {
                            task_assignments::create_task_assignment(Request::input('users')[$key] ,Request::input('users')[$key] ,$task->id);
                        }
                        task_priority::create_task_priority($task->id, Request::input('immediate') ,Request::input('importance'),[0] , $value_employee_id);
                        task_status::create_task_status($task->id, 0, 0, $value_employee_id, time());
                    }
                }
            }

            $task->form_data = serialize(Request::all());
            $task->task_attributes = serialize(Request::all());
            $task->uid = Auth::id();
            $task->title = Request::input('title');
            $task->desc = Request::input('task_desc');
            $task->type = Request::input('type');
            $task->kind = Request::input('kind');
            $task->is_save = Request::input('save_type');
            $task->task_status = Request::input('task_status');
            $task->duration_timestamp = $respite_duration_timestamp;
            $task->use_type = Request::input('use_type');
            $task->end_on_assigner_accept = Request::input('end_on_assigner_accept');
            $task->transferable = Request::input('transferable');
            $task->report_on_create_point = Request::input('report_on_cr');
            $task->report_on_completion_point = Request::input('report_on_co');
            $task->report_to_managers = Request::input('report_to_manager');
            $task->respite_timing_type = Request::input('respite_timing_type');
            $task->save();
            task_history::create_task_history($task->id, 'edit_task', serialize(Request::all()), '');

        }
        $result['success'] = true;
        return json_encode($result);

    }

    public function SetActToTask()
    {
        $task_all = Session::get('TaskForm_task_all');
        $task_id = Session::get('TaskForm_tid');
        $assign_id = Session::get('TaskForm_aid');
        $task_assignment = task_assignments::where('id', '=', $assign_id)
            ->select('assigner_id', 'uid', 'staff_id')->first();
        if(Session::get('ShowAssignTaskForm_is_creator'))
        {
//            $task = task_assignments::find($assign_id);
//            $task->save();
        }
        else{

        }
//        dd(Request::all());
//        dd($task_id);
        //
        $action = "";
        if(Request::exists('assign_object'))
        {
            if(Request::exists('reject_assigner'))
            {
                $action = 'rejection';
                DB::table('hamahang_task_assignments')
                    ->where('id', (int) $assign_id)
                    ->update(['status' => 1,'reject_description'=>Request::input('explain_reject')]);
                task_assignments::create_task_assignment($task_assignment['uid'] ,$task_assignment['uid'] ,$task_id,$assign_id);
                task_history::create_task_history($task_id, 'reject', serialize(Request::all()),$task_assignment['uid']);
                task_status::create_task_status($task_id, 0, 0, $task_assignment['uid'], time());

            }else if (Request::exists('assigns_new'))
            {
                $action = 'assignmention';
                $staff = '';
                foreach (Request::input('assigns_new') as $key => $value_employee_id)
                {
                    if($key == 0)
                    {
                        $staff = Request::input('assigns_new')[$key];
                        task_assignments::create_task_assignment($value_employee_id ,$staff ,$task_id,$assign_id);
                    }
                    else
                    {
                        task_assignments::create_task_assignment($value_employee_id ,$staff ,$task_id,$assign_id);
                    }
                    task_priority::create_task_priority($task_id, $task_all['immediate'] ,$task_all['importance'] ,[0] ,$value_employee_id);
                    task_status::create_task_status($task_id, 0, 0, $value_employee_id, time());
                }
                $UserController = new UserController();
                task_history::create_task_history($task_id, 'assign', serialize(Request::all()), $UserController->getUser(Request::input('assigns_new')));
                DB::table('hamahang_task_assignments')
                    ->where('id', (int) $assign_id)
                    ->update(['status' => 1]);
            }
        }
        //task_status
        $reject_description = "";
        if (Request::exists('explain_reject'))
            $reject_description = Request::input('explain_reject');
        $power_physical = "";
        if (Request::exists('ready_body'))
            $power_physical = Request::input('ready_body');
        $power_mental = "";
        if (Request::exists('ready_mental'))
            $power_mental = Request::input('ready_mental');
        $quality = "";
        if (Request::exists('quality'))
            $quality = Request::input('ready_mental');

        $respite_duration_timestamp = 0;
        if (Request::input('done_time') == 'determined-time')
        {
            $respite_duration_timestamp = hamahang_make_task_respite(Request::input('action_date'), Request::input('action_time'));
        }
        elseif (Request::input('done_time') == 'not-determine')
        {
            $respite_duration_timestamp = null;
        }
        elseif (Request::input('done_time') == 'to_end')
        {
            if(Request::input('to_end') == 'daily')
                $respite_duration_timestamp = hamahang_convert_respite_to_timestamp(0, 0, 1, 0, 0, 0);
            if(Request::input('to_end') == 'weekly')
                $respite_duration_timestamp = hamahang_convert_respite_to_timestamp(0, 0, 7, 0, 0, 0);
            if(Request::input('to_end') == 'monthly')
                $respite_duration_timestamp = hamahang_convert_respite_to_timestamp(0, 0, 30, 0, 0, 0);
        }
        task_action::create_task_action($task_id, Request::input('task_status'), Request::input('progress'), $action,$reject_description,
            $power_mental, $power_physical, $quality, Request::input('action_duration')*Request::input('action_time_type'), $respite_duration_timestamp, Request::input('action_explain'));
        task_status::where('uid', '=', Auth::id())
            ->where('task_id', '=', $task_id)
            ->delete();
        task_status::create_task_status($task_id, Request::input('task_status'), Request::input('progress'));
        task_history::create_task_history($task_id, 'submit_action', serialize(Request::all()), trans('tasks.action').': '.task_status::getTaskStatusTitleAttribute(Request::input('task_status')).(Request::input('progress')> 0 ? ', '.trans('tasks.precent_progress').': '.Request::input('progress')  : ''));

        if (Request::exists('keywords'))
        {
            foreach (Request::input('keywords') as $kw)
            {
                task_keywords::create_task_keyword($task_id, hamahang_add_keyword($kw));
            }
        }


        $result['success'] = true;
        return json_encode($result);

    }
    public static function SaveTaskCopy($OrigTask, $schedule_time = 0)
    {
        if ($OrigTask)
        {
            $Orig_Task = unserialize($OrigTask->form_data);
            $task = tasks::CreateNewTask($OrigTask->form_data, $OrigTask->title, $OrigTask->is_save, $OrigTask->desc, $OrigTask->type, $OrigTask->kind, $OrigTask->task_status, $OrigTask->duration_timestamp, $OrigTask->use_type, $OrigTask->end_on_assigner_accept, $OrigTask->transferable, $OrigTask->report_on_create_point, $OrigTask->report_on_completion_point, $OrigTask->report_to_managers, $OrigTask->respite_timing_type, $OrigTask->id, $schedule_time);
            $assignment = task_assignments::create_task_assignment($Orig_Task['users'][0], $task->id);
            $staff = '';
            if (Request::exists('users'))
            {
                foreach (Request::input('users') as $key => $value_employee_id)
                {
                    if(Request::input('assign_type') == 1 )
                    {
                        if($key == 0)
                        {
                            $staff = Request::input('users')[0];
                            task_assignments::create_task_assignment(Request::input('users')[$key] ,$staff ,$task->id);
                        }
                        else
                        {
                            task_assignments::create_task_assignment(Request::input('users')[$key] ,$staff ,$task->id);
                        }
                    }
                    elseif(Request::input('assign_type') == 2)
                    {
                        task_assignments::create_task_assignment(Request::input('users')[$key] ,Request::input('users')[$key] ,$task->id);
                    }
                    task_priority::create_task_priority($task->id, Request::input('immediate') ,Request::input('importance'),[0] , $value_employee_id);
                    task_status::create_task_status($task->id, 0, 0, $value_employee_id, time());
                }
            }
            $status = task_status::create_task_status($task->id, 0, 0);
            $priority = task_priority::create_task_priority($task->id, $Orig_Task['immediate'], $Orig_Task['importance'],[0] );
            return $task->id;
        }
        return false;
    }
    public function save($OrigTask=0, $schedule_time = 0)
    {
        $validator = Validator::make(Request::all(),
            [
                'title' => 'required|string'
//              ,
//              'users' => 'required|array',
            ],
            [
//                'selected_users.required'=>'باید کاربر انتخاب شود'
            ],
            [
                'title'=>'عنوان وظیفه',
//                'users'=>'کاربر'
            ]
        );
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        if (Request::input('event_type') == "task" || Request::input('task_form_action') == "select_task")
        {
//            if (Request::input('event_id') && Request::input('mode') == 'edit')
//            {
//                $userEvent = User_Event::find(Request::input('event_id'));
//            }
//            else
//            {
//                $userEvent = new User_Event();
//            }
//            $uid = Auth::id();
//            $type = Request::input('type') ? Request::input('type') : 0;
//            $event_type = Request::input('event_type') ? Request::input('event_type') : 0;
//            dd(Request::all());
//            $jdate = new jDateTime();
//            $userEvent->uid = $uid;
//            $userEvent->title = Request::input('event_title');
//            $userEvent->allDay = Request::input('allDay');
//            $startdate = explode('-', Request::input('event_startdate'));
////            dd(Request::input('event_startdate'));
//            if (Request::input('allDay') == 1)
//            {
//                $userEvent->startdate = $jdate->Jalali_to_Gregorian($startdate[0], $startdate[1], $startdate[2], '-') . ' 00:00:00';
//            }
//            else
//            {
//                $userEvent->startdate = $jdate->Jalali_to_Gregorian($startdate[0], $startdate[1], $startdate[2], '-') . ' ' . Request::input('event_starttime');
//            }
//
//            //die(dd($startdate));
//
//            $enddate = explode('-', Request::input('event_enddate'));
//            if (Request::input('allDay') == 1)
//            {
//                $userEvent->enddate = $jdate->Jalali_to_Gregorian($enddate[0], $enddate[1], $enddate[2], '-') . ' 00:00:00';
//            }
//            else
//            {
//                $userEvent->enddate = $jdate->Jalali_to_Gregorian($enddate[0], $enddate[1], $enddate[2], '-') . ' ' . Request::input('event_endtime');
//            }
//            $userEvent->description = Request::input('description');
//            $userEvent->type = $type;
//            $userEvent->event_type = $event_type;
//            $userEvent->cid = Request::input('event_cid');
//            //die(dd(DB::getQueryLog()));
//            if ($userEvent->save())
//            {
//                $final_result = ['success' => true, 'event' => $userEvent, 'mode' => 'calendar'];
//            }
//            if (Request::input('task_form_action') == "select_task")
//            {
//
//                dd(Request::input('multiTaskTime'));
//                $eventTask = new Events_Tasks();
//                $eventTask->uid = $uid;
////                $eventTask->task_id = $task->id;
//                $eventTask->event_id = $userEvent->id;
//                $eventTask->save();
//
//                return json_encode($final_result);
//            }

        }

        $final_result = ['success' => true];
        if (Request::input('respite_timing_type') == 1)
        {
            $respite_duration_timestamp = hamahang_make_task_respite(Request::input('respite_date'), Request::input('respite_time'));
        }
        elseif (Request::input('respite_timing_type') == 2)
        {
            $respite_duration_timestamp = hamahang_convert_respite_to_timestamp(0, 0, 0, 0, 0, 0);
        }
        elseif (Request::input('respite_timing_type') == 0)
        {
            $day_no = Request::input('duration_day');
            $hour_no = Request::input('duration_hour');//Request::input('duration_hour');
            $min_no = Request::input('duration_min');//Request::input('duration_min');
            $sec_no = 0;//Request::input('duration_sec');
            $respite_duration_timestamp = hamahang_convert_respite_to_timestamp(0, 0, $day_no, $hour_no, $min_no, $sec_no);
        }
        $jDateObj = new jDateTime();
        $task = tasks::CreateNewTask(serialize(Request::all()), Request::input('title'), Request::input('task_form_action'), Request::input('task_desc'), Request::input('type'), Request::input('kind'), Request::input('task_status'), $respite_duration_timestamp, Request::input('use_type'), Request::input('end_on_assigner_accept'), Request::input('transferable'), Request::input('report_on_cr'), Request::input('report_on_co'), Request::input('report_to_manager'), Request::input('respite_timing_type'),$OrigTask, $schedule_time);

        if(Request::input('task_schedul_num') && !$OrigTask && !$schedule_time)
        {
            $end_type = Request::input('schedul_end_date');
            if($end_type=='schedul_end_date_none') // never end
            {

            }elseif($end_type=='schedul_end_date_events') // never end
            {

            }elseif($end_type=='schedul_end_date_date') // never end
            {
                $start_date = new \DateTime(Request::input('schedul_begin_date'));
                $end_date = new \DateTime(Request::input('schedul_end_date_date'));
                $get_date_diff = get_date_diff(Request::input('schedul_begin_date'), Request::input('schedul_end_date_date'));
                $weeks = intval($get_date_diff->days / 7);
                $schedul_type = Request::input('task_schedul');
                $schedule = [];
                $schedule_id = [];
                switch ($schedul_type)
                {
                    case 'daily': //daily
                        {
                            for ($i = 0; $i < $get_date_diff->days / Request::input('task_schedul_num'); $i++)
                            {
                                $datetime = new \DateTime(Request::input('schedul_begin_date'));
                                $datetime->add(new \DateInterval('P' . (Request::input('task_schedul_num') * $i) . 'D'));
                                $d = preg_split('/-/',$datetime->format("Y-m-d"));
                                $r = $jDateObj->jalali_to_gregorian($d[0],$d[1],$d[2]);
                                $schedul_date = $r[0].'-'.($r[1]>9 ? $r[1] : '0'.$r[1]).'-'.($r[2]>9 ? $r[2] : '0'.$r[2]).' '.str_ireplace(' AM','',str_ireplace(' PM','',Request::input('schedul_begin_time')));
                                $this->save($task, $schedul_date);
                            }
                            break;
                        }
                    case 'weekly': //weekly
                        {
                            $d = 0;

                            while ($d < $get_date_diff->days)
                            {
                                for ($wd = 0; $wd < 7; $wd++)
                                {
                                    $purpose_date = new \DateTime(Request::input('schedul_begin_date'));
                                    $purpose_date->add(new \DateInterval("P{$d}D"));
                                    if ((in_array(get_persian_weekday($purpose_date->format('w')), Request::input('weekly_value'))) && ($start_date <= $purpose_date) && ($purpose_date <= $end_date))
                                    {
                                        $s_d = preg_split('/-/',$purpose_date->format('Y-m-d'));
                                        $r = $jDateObj->jalali_to_gregorian($s_d[0],$s_d[1],$s_d[2]);
                                        $schedul_date = $r[0].'-'.($r[1]>9 ? $r[1] : '0'.$r[1]).'-'.($r[2]>9 ? $r[2] : '0'.$r[2]).' '.str_ireplace(' AM','',str_ireplace(' PM','',Request::input('schedul_begin_time')));
                                        $this->save($task, $schedul_date);
                                    }
                                    $d++;
                                }
                                $d += 7 * (Request::input('task_schedul_num') - 1);
                            }
                            break;
                        }
                    case 'monthly': //monthly
                        {
                            $weeknums = Request::input('monthly_value');
                            $om = 0;
                            $wn = 1;
                            for ($d = 0; $d <= $get_date_diff->days; $d++)
                            {
                                $purpose_date = new \DateTime(Request::input('schedul_begin_date'));
                                $purpose_date->add(new \DateInterval("P{$d}D"));
                                $cm = $purpose_date->format('m');
                                if ($om !== $cm)
                                {
                                    $wn = 1;
                                    $om = $cm;
                                }
                                $wd = ($purpose_date->format('w'));
                                if (in_array($wn, $weeknums))
                                {
                                    $s_d = preg_split('/-/',$purpose_date->format('Y-m-d'));
                                    $r = $jDateObj->jalali_to_gregorian($s_d[0],$s_d[1],$s_d[2]);
                                    $schedul_date = $r[0].'-'.($r[1]>9 ? $r[1] : '0'.$r[1]).'-'.($r[2]>9 ? $r[2] : '0'.$r[2]).' '.str_ireplace(' AM','',str_ireplace(' PM','',Request::input('schedul_begin_time')));
                                    $this->save($task, $schedul_date);
                                }
                                $wn += 6 == $wd ? 1 : 0;
                            }
                            break;
                        }
                    case 'seasonly': //seasonly
                        {
                            $seasons = Request::input('seasonly_value');
                            $diff = get_date_diff($start_date->format('Y-m'), $end_date->format('Y-m'));
                            $ms = get_date_diff_mounts($diff);
                            $season = 0;
                            for ($m = 0; $m < $ms; $m++)
                            {
                                $purpose_date = new \DateTime(Request::input('schedul_begin_date'));
                                $purpose_date->add(new \DateInterval("P{$m}M"));
                                if($purpose_date->format('m')<4)
                                    $season = 0;
                                else if($purpose_date->format('m')<7)
                                    $season = 1;
                                else if($purpose_date->format('m')<10)
                                    $season = 2;
                                else if($purpose_date->format('m')<=12)
                                    $season = 3;
                                if (in_array($season, $seasons))
                                {
                                    for ($d = 1; $d < ($season<2 ? 32 : 31); $d++)
                                    {
                                        $purpose_date->add(new \DateInterval("P{$d}D"));
                                        $recur_date = $purpose_date->format('Y-m-d');
                                        if((!($start_date <= $purpose_date) && ($purpose_date <= $end_date)))
                                            continue;
                                        $s_d = preg_split('/-/',$recur_date);
                                        $r = $jDateObj->jalali_to_gregorian($s_d[0],$s_d[1],$s_d[2]);
                                        $schedul_date = $r[0].'-'.($r[1]>9 ? $r[1] : '0'.$r[1]).'-'.($r[2]>9 ? $r[2] : '0'.$r[2]).' '.str_ireplace(' AM','',str_ireplace(' PM','',Request::input('schedul_begin_time')));
                                        $this->save($task, $schedul_date);
                                    }
                                }
                            }
                            break;
                        }
                    case 'yearly': //yearly
                        {
                            $months = Request::input('yearly_num');
                            $diff = get_date_diff($start_date->format('Y-m'), $end_date->format('Y-m'));
                            $ms = get_date_diff_mounts($diff);
                            for ($m = 0; $m < $ms; $m++)
                            {
                                $purpose_date = new \DateTime(Request::input('schedul_begin_date'));
                                $purpose_date->add(new \DateInterval("P{$m}M"));
                                if (in_array($purpose_date->format('m'), $months))
                                {

                                    for ($d = 1; $d < 32; $d++)
                                    {
                                        $recur_date = $purpose_date->format('Y-m') . "-$d";
                                        if((!($start_date <= $recur_date) && ($recur_date <= $end_date)))
                                            continue;
                                        $s_d = preg_split('/-/',$recur_date);
                                        $r = $jDateObj->jalali_to_gregorian($s_d[0],$s_d[1],$s_d[2]);
                                        $schedul_date = $r[0].'-'.($r[1]>9 ? $r[1] : '0'.$r[1]).'-'.($r[2]>9 ? $r[2] : '0'.$r[2]).' '.str_ireplace(' AM','',str_ireplace(' PM','',Request::input('schedul_begin_time')));
                                        $this->save($task, $schedul_date);
                                    }
                                }
                            }
                        }
                }
            }
        }


        if(Request::exists('task_form_action')==1)
        {
            if (Request::exists('new_task_resources_h'))
            {
                $new_task_resources_amount = Request::input('new_task_resources_amount');
                $new_task_resources_cost = Request::input('new_task_resources_cost');
                foreach (Request::input('new_task_resources_h') as $k => $kw)
                {
                    //$task_id, $amount, $cost, $resource_id
                    task_resources::create_task_resource($task->id, $new_task_resources_amount[$k],$new_task_resources_cost[$k],new_hamafza_add_resource($kw));
                }
            }
            if (Request::exists('task_schedul'))
            {
                $schedul = array(
                    'task_schedul' => Request::input('task_schedul'),
                    'task_schedul_num' => Request::input(Request::input('task_schedul').'_num'),
                    'task_schedul_value' => Request::input(Request::input('task_schedul').'_value')
                );

                task_schedule::create_task_schedule($task->id, Request::input('task_schedul'),serialize($schedul),
                    Request::input('schedul_begin_date'), Request::input('schedul_end_date'), Request::input('schedul_end_date_date'), Request::input('schedul_end_num_events'));
            }
            if (Request::exists('pages'))
            {
                foreach (Request::input('pages') as $page_id)
                {
                    hamahang_subject_ables::create_items_page($page_id, $task->id,  'App\Models\Hamahang\Tasks\tasks');
                }
            }

            if (Request::exists('project_tasks'))
            {
                foreach (Request::input('project_tasks') as $project_id)
                {
                    hamahang_project_task::create_task_project($task->id, $project_id);
                }
            }

            if (Request::exists('new_task_tasks_'))
            {
                foreach (Request::input('new_task_tasks_') as $k=>$task_id)
                {
                    task_relations::create_task_relation($task->id, $task_id, Request::input('new_task_delay_num')[$k], Request::input('new_task_delay_type')[$k], Request::input('new_task_relation')[$k], Request::input('new_task_weight')[$k]);
                }
            }

            if (Request::exists('transcripts'))
            {
                if(Request::input('report_on_cr')==1)
                {
                    foreach (Request::input('transcripts') as $transcript)
                    {
                        task_transcripts::create_task_transcript($task->id, $transcript);
                    }
                }
            }
            if (Request::exists('keywords'))
            {
                foreach (Request::input('keywords') as $kw)
                {
                    task_keywords::create_task_keyword($task->id, hamahang_add_keyword($kw));
                }
            }
            if (Request::exists('rel_tasks'))
            {
                foreach (Request::input('rel_tasks') as $p)
                {
                    if(strlen(trim($p))>0)
                        hamahang_project_task::create_task_project($task->id, $p);
                }
            }
            $staff = '';
            if (Request::exists('users'))
            {
                foreach (Request::input('users') as $key => $value_employee_id)
                {
                    if(Request::input('assign_type') == 1 )
                    {
                        if($key == 0)
                        {
                            $staff = Request::input('users')[0];
                            task_assignments::create_task_assignment(Request::input('users')[$key] ,$staff ,$task->id);
                        }
                        else
                        {
                            task_assignments::create_task_assignment(Request::input('users')[$key] ,$staff ,$task->id);
                        }
                    }
                    elseif(Request::input('assign_type') == 2)
                    {
                        task_assignments::create_task_assignment(Request::input('users')[$key] ,Request::input('users')[$key] ,$task->id);
                    }
                    task_priority::create_task_priority($task->id, Request::input('immediate') ,Request::input('importance'),[0] , $value_employee_id);
                    task_status::create_task_status($task->id, 0, 0, $value_employee_id, time());
                }
            }
            task_history::create_task_history($task->id, 'create', serialize(Request::all()));
            task_priority::create_task_priority($task->id, Request::input('immediate') ,Request::input('importance'),[1]);
//            task_priority_assigner::create_task_priority_assigner($task->id, Request::input('immediate') ,Request::input('importance'));
        }
        if (Request::input('event_type') == "task")
        {
            return json_encode(
                [
                    'task_id'=>$task->id,
                    'startdate'=>Request::input('startdate'),
                    'enddate'=>Request::input('enddate'),
                    'endtime'=>Request::input('endtime'),
                    'starttime'=>Request::input('starttime'),
                    'title'=>Request::input('title'),
                    'success'=>true
                ]
            );
        }
        return json_encode($final_result);
//        dd($task);
//
//
//
//        $messages =
//            [
//                'users.required' => 'انتخاب مسئول برای وظیفه الزامی است.',
//                'users.array' => 'انتخاب مسئول برای وظیفه الزامی است.',
//                'users.exists' => ' مسئول انتخاب شده برای وظیفه معتبر نمی باشد.',
//            ];
//        $rules =
//            [
//                'use_type' => 'required|in:0,1,2',
//                'assign_type' => 'required_if:use_type,0|in:1,2',
//                'project_id' => 'required_if:use_type,1',
//                'process_id' => 'required_if:use_type,2',
//                'respite_timing_type' => 'required_if:use_type,0|in:0,1',
//                'respite_date' => 'required_if:respite_timing_type,1',
//                'respite_time' => 'required_if:respite_timing_type,1',
//                'duration_day' => 'required_if:respite_timing_type,0|required_if:use_type,1,2|integer',
//                'duration_hour' => 'required_if:respite_timing_type,0|integer|max:59|min:0',
//                'duration_min' => 'required_if:respite_timing_type,0|integer|max:59|min:0|in:0,5,10,15,20,25,30,35,40,45,50,55',
//                //'duration_sec' => 'required_if:respite_timing_type,0',
//                'users' => 'required|array|exists:user,id',
//                'title' => 'required|string',
//                'type' => 'required',
//                //'task_desc' => 'required',
//                //'report_on_cr' => 'required',
//                //'report_on_co' => 'required',
//                //'report_to_manager' => 'required',
//                //'predicted_time' => 'required',
//                //'end_on_assigner_accept' => 'required',
//                //'transferable' => 'required',
//                'immediate' => 'required',
//                'importance' => 'required',
//                //'project' => 'required_if:use_type,1',
//                //'pages' => 'required',
//                //'transcripts' => 'required',
////            'keywords' => 'required',
//            'save_type' => 'required',
//            'process_id' => 'required_if:use_type,2',
//        ];
//        $validator = Validator::make(Request::all(), $rules, $messages);
//        if ($validator->fails())
//        {
//            $result['error'] = $validator->errors();
//            $result['success'] = false;
//            return json_encode($result);
//        }
//        else
//        {
//            if (Request::input('use_type') == 0)
//            {
//                if (Request::input('respite_timing_type') == 1)
//                {
//                    $respite_duration_timestamp = hamahang_make_task_respite(Request::input('respite_date'), Request::input('respite_time'));
//                }
//                elseif (Request::input('respite_timing_type') == 0)
//                {
//                    $day_no = Request::input('duration_day');
//                    $hour_no = Request::input('duration_hour');//Request::input('duration_hour');
//                    $min_no = Request::input('duration_min');//Request::input('duration_min');
//                    $sec_no = 0;//Request::input('duration_sec');
//                    $respite_duration_timestamp = hamahang_convert_respite_to_timestamp(0, 0, $day_no, $hour_no, $min_no, $sec_no);
//                }
//            }
//            elseif (Request::input('use_type') == 1 || Request::input('use_type') == 2)
//            {
//                $day_no = Request::input('duration_day');
//                $hour_no = 0;//Request::input('duration_hour');
//                $min_no = 0;//Request::input('duration_min');
//                $sec_no = 0;//Request::input('duration_sec');
//                $respite_duration_timestamp = hamahang_convert_respite_to_timestamp(0, 0, $day_no, $hour_no, $min_no, $sec_no);
//            }
//
//            if (Request::input('use_type') != 2)
//            {
//                if (Request::input('assign_type') == 1)
//                {
//                    $task = tasks::CreateNewTask(serialize(Request::all()), Request::input('title'), Request::input('task_desc'), Request::input('type'), $respite_duration_timestamp, Request::input('use_type'), Request::input('end_on_assigner_accept'), Request::input('transferable'), Request::input('report_on_cr'), Request::input('report_on_co'), Request::input('report_to_manager'));
//                    HFM_SaveMultiFiles('CreateNewTask', '\App\Models\Hamahang\Tasks\task_files', 'task_id', $task->id, ['field' => 1]);
//                    if (Request::exists('pages'))
//                    {
//                        foreach (Request::input('pages') as $page_id)
//                        {
//                            hamahang_subject_ables::create_items_page($page_id, $task->id,  'App\Models\Hamahang\Tasks\tasks');
//                        }
//                    }
//                    $assign = task_assignments::create_task_assignment(Request::input('users')[0], $task->id);
//                    project_task::add_task_to_project($task->id, Request::get('project_id'));
//                    task_status::create_task_status($task->id);
//                    task_logs::CreateNewLog($task->id, $assign->id, 'create');
//
//                    foreach (Request::input('users') as $key => $value_employee_id)
//                    {
//                        if ($key != 0)
//                        {
//                            task_staffs::create_task_staff($assign->id, $value_employee_id);
//                        }
//                        task_priority::create_task_priority($task->id, Request::input('immediate'), Request::input('importance'), $value_employee_id);
//                    }
//
//                    if (Request::exists('transcripts'))
//                    {
//                        foreach (Request::input('transcripts') as $transcript)
//                        {
//                            task_transcripts::create_task_transcript($task->id, $transcript);
//                        }
//                    }
//
//                    if (Request::exists('keywords'))
//                    {
//                        foreach (Request::input('keywords') as $kw)
//                        {
//                            task_keywords::create_task_keyword($task->id, hamahang_add_keyword($kw));
//                        }
//                    }
//                    $notice = new task_notices;
//                    $notice->task_id = $task->id;
//                    $notice->save();
//
//                    $result['success'] = true;
//                    return json_encode($result);
//                }
//                elseif (Request::input('assign_type') == 2)
//                {
//                    foreach (Request::input('users') as $u)
//                    {
//                        $task = tasks::CreateNewTask(serialize(Request::all()), Request::input('title'), Request::input('task_desc'), Request::input('type'), $respite_duration_timestamp, Request::input('use_type'), Request::input('end_on_assigner_accept'), Request::input('transferable'), Request::input('report_on_cr'), Request::input('report_on_co'), Request::input('report_to_manager'));
//                        $assign = task_assignments::create_task_assignment($u, $task->id);
//                        task_priority::full_create_priority($task->id, Request::input('immediate'), Request::input('importance'), $u, Auth::id());
//                        task_logs::CreateNewLog($task->id, $assign->id, 'create');
//                        task_status::create_task_status($task->id, $assign->id);
//                        project_task::add_task_to_project($task->id, Request::get('project_id'));
//                        HFM_SaveMultiFiles('CreateNewTask', '\App\Models\Hamahang\Tasks\task_files', 'task_id', $task->id);
//                        if (Request::exists('pages'))
//                        {
//                            foreach (Request::input('pages') as $page_id)
//                            {
//                                hamahang_subject_ables::create_items_page($page_id,$task->id,  'App\Models\Hamahang\Tasks\tasks');
//                            }
//                        }
//                        if (Request::exists('transcripts'))
//                        {
//                            foreach (Request::input('transcripts') as $transcript)
//                            {
//                                task_transcripts::create_task_transcript($task->id, $transcript);
//                            }
//                        }
//                        if (Request::exists('keyword'))
//                        {
//                            foreach (Request::exists('keyword') as $kw)
//                            {
//                                task_keywords::create_task_keyword($task->id, $kw);
//                            }
//                        }
//                        task_notices::create_new_notice($task->id);
//                    }
//                }
//            }
//            else
//            {
//                $task = new process_task;
//                $task->users = serialize(Request::input('users'));
//                $task->transcripts = serialize(Request::input('transcripts'));
//                $task->keywords = serialize(Request::input('keyword'));
//                //$task->page = serialize($)
//                $task->title = Request::input('title');
//                $task->process_id = Request::input('process_id')[0];
//                $task->type = Request::input('type');
//                $task->desc = Request::input('task_desc');
//                $task->uid = Auth::id();
//                $task->report_on_create_point = Request::input('report_on_cr');
//                $task->report_on_completion_point = Request::input('report_on_co');
//                $task->report_to_managers = Request::input('report_to_manager');
//                $task->importance = Request::input('importance');
//                $task->immediate = Request::input('immediate');
//                $task->respite = $respite_duration_timestamp;
//                $task->predicted_time = Request::input('predicted_time');
//                if (Request::input('report_on_cr') == true)
//                {
//                    $task->report_on_create_point = 1;
//                }
//                if (Request::input('report_on_co') == true)
//                {
//                    $task->report_on_completion_point = 1;
//                }
//                if (Request::input('transferable') == true)
//                {
//                    $task->transferable = 1;
//                }
//                if (Request::input('end_on_assigner_accept') == true)
//                {
//                    $task->end_on_assigner_accept = 1;
//                }
//                $arr_files = [];
//                if (Session::has('Files'))
//                {
//                    $files = Session::get('Files');
//                    if (isset($files['CreateNewTask']) && is_array($files['CreateNewTask']))
//                    {
//                        $task_files = $files['CreateNewTask'];
//                        if (is_array($task_files))
//                        {
//                            foreach ($task_files as $key => $value)
//                            {
//                                array_push($arr_files, $key);
//                            }
//                        }
//                    }
//                }
//                $task->files = serialize($arr_files);
//                $task->save();
//            }
////            if (Request::input('use_type') == 2)
////            {
////                return Redirect::route('ugc.desktop.Hamahang.Process.List', ['username' => Auth::user()->Uname]);
////            }
////            else
////            {
////                $result['success'] = true;
////                return json_encode($result);
////            }
//        }
    }

    public function TaskStop()
    {
        date_default_timezone_set('Asia/Tehran');
        $q = new task_status();
        $q->uid = Auth::id();
        $q->task_id = Request::input('tid');
        $q->timestamp = time();
        $q->type = 4;
        $q->save();
        task_logs::CreateNewLog(Request::input('tid'), 0, 'stop');

        $status = task_status::where('task_id', '=', Request::input('tid'))
            ->select('type', 'percent', 'timestamp')->orderBy('id', 'Desc')->get();
        $date = new jDateTime();
        foreach ($status as $st)
        {
            $st->timestamp = $date->date("Y-m-d", $st->timestamp);
        }
        return json_encode($status);
    }

    public function TaskEnd()
    {
        $id = explode('a', Request::input('tid'));
        $task_use_type = tasks::find(Request::input('tid'))->use_type;
        if ($task_use_type == 0)
        {
            $current_percent = task_status::where('task_id', '=', Request::input('tid'))->whereNull('deleted_at')->select('percent')->orderBy('id', 'DESC')->first();
            $state = new task_status;
            $state->uid = Auth::id();
            $state->user_id = Auth::id();
            $state->task_id = $id[0];
            $state->type = 3;
            $state->percent = $current_percent['percent'];
            $state->timestamp = time();
            $state->save();

            $status = task_status::where('task_id', '=', Request::input('tid'))
                ->select('type', 'percent', 'timestamp')->orderBy('id', 'Desc')->get();
            $date = new jDateTime();
            foreach ($status as $st)
            {
                $st->timestamp = $date->date("Y-m-d", $st->timestamp);
            }
            return json_encode($status);
        }
        elseif ($task_use_type == 1)
        {
            $new_status = 3;
            $arr = [];
            $conflict = 0;
            $relations = tasks::f();
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
                            case 0:
                            {
                                if ($rel->type != 1)
                                {
                                    $arr[] = $rel->second_task_id;
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
                                if ($rel->type != 4)
                                {
                                    $arr[] = $rel->second_task_id;
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
                                    array_push($arr, ["id" => $rel->second_task_id, "relation" => (int)$rel->relation, "task_title" => $rel->title]);
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
                                if ($rel->type != 4)
                                {
                                    $arr[] = [$rel->second_task_id, $rel->relation];
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
                $current_percent = task_status::where('task_id', '=', Request::input('tid'))->whereNull('deleted_at')->select('percent')->orderBy('id', 'DESC')->first();
                $state = new task_status;
                $state->uid = Auth::id();
                $state->user_id = Auth::id();
                $state->task_id = Request::input('tid');
                $state->type = 3;
                $state->percent = $current_percent['percent'];
                $state->timestamp = time();
                $state->save();

                return json_encode('ok');
            }
            else
            {
                return json_encode($arr);
            }

        }
    }

    public function ChangeTaskQuality()
    {
        date_default_timezone_set('Asia/Tehran');
        $q = new task_qualities();
        $q->uid = Auth::id();
        $q->task_id = Request::input('tid');
        $q->quality_id = Request::input('qid');
        $q->timestamp = time();
        $q->save();

        $date = new jDateTime();
        $quality = task_qualities::where('task_id', '=', Request::input('tid'))->select('quality_id', 'timestamp')->orderBy('id', 'Desc')->get();
        foreach ($quality as $qlty)
        {
            $qlty->timestamp = $date->date("Y-m-d", $qlty->timestamp);
        }
        return json_encode($quality);
    }

    public function rapid_new_task()
    {
        $validator = Validator::make(Request::all(), [
            'immediacy' => 'required|in:0,1',
            'importance' => 'required|in:0,1',
            'task_title' => 'required|string',
            'respite_date' => 'required|jalali_date:-',
            'selected_users' => 'required|array',
        ],[
            'selected_users.required'=>'باید کاربر انتخاب شود'
        ],[
                'task_title'=>'عنوان وظیفه',
                'selected_users'=>'کاربر'
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
            DB::transaction(function () use (&$task, &$employee, &$respite_date, &$status)
            {
                $immediacy = Request::get('immediacy');
                $importance = Request::get('importance');
                $task_title = Request::get('task_title');
                $respite_date = Request::get('respite_date');
                $selected_users = Request::get('selected_users');
                $respite_duration_timestamp = hamahang_make_task_respite($respite_date, '08:00:00');

                $task = new tasks;
                $task->title = $task_title;
                $task->duration_timestamp = $respite_duration_timestamp;
                $task->schedule_time = date('Y-m-d H:i:s');
                $task->use_type = 0;
                $task->type = 0;
                $task->uid = Auth::id();
                $task->save();

                $x = 0;
                $staff = '';
                if (sizeof($selected_users) > 0)
                {
                    foreach ($selected_users as $u)
                    {
                        if ($x == 0)
                        {
                            ///////نفر اول بعنوان مسوول ثبت می شود
//                            $assign = task_assignments::create_task_assignment($u, $task->id);
                            $staff = $u;
                            $x = 1;
                        }
//                        else
//                        {
//                            /////////// ثبت سایر افراد وظیفه
//                            task_staffs::create_task_staff($assign->id, $u);
//                        }
                        task_assignments::create_task_assignment($u ,$staff ,$task->id,0);
                    }
                }

                $status = task_status::create_task_status($task->id);
                $priority = task_priority::create_task_priority($task->id, $immediacy, $importance);
                $employee = User::find($staff);

                $respite_date = hamahang_respite_remain(strtotime($task->schedule_time), $task->duration_timestamp);
                if ($respite_date[0]['delayed'] == 1)
                {
                    $task->respite_days = ($respite_date[0]['day_no']) * (-1);
                }
                else
                {
                    $task->respite_days = $respite_date[0]['day_no'];
                }
            });

            $res =
                [
                    'success' => 'success',
                    'id' => $task->id,
                    'user_name' => $employee->name,
                    'respite_days' => $respite_date,
                    'type' => $status->type
                ];
            return response()->json($res);
        }
    }

    public function add_task_ajax()
    {
        $date = new jDateTime();
        date_default_timezone_set('Asia/Tehran');
        $date_to_split = explode('/', Request::input('respite'));
        $respite_timestamp = $date->mktime(0, 0, 0, $date_to_split[1], $date_to_split[0], $date_to_split[2]);

        $task = new tasks;
        $task->title = Request::input('task_title_new');

        $task->respite = $respite_timestamp;
//		$task->importance = Request::input('importance');
//		$task->immediate = Request::input('immediate');
        $task->save();
        $x = 0;
        if (sizeof(Request::input('users') > 0))
        {
            foreach (Request::input('users') as $u)
            {
                if ($x == 0)
                {
                    ///////نفر اول بعنوان مسوول ثبت می شود
                    $assign = task_assignments::create_task_assignment($u, $task->id);
                    $x = 1;
                }
                else
                {
                    /////////// ثبت سایر افراد وظیفه
                    task_staffs::create_task_staff($assign->id, $u);
                }
            }
        }
        $status = new task_status;
        $status->task_id = $task->id;
        $status->type = 0;
        $status->user_id = 125;
        $status->timestamp = time();
        $status->save();
        return response()->json($status);
    }

}