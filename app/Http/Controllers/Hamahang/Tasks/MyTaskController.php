<?php

namespace App\Http\Controllers\Hamahang\Tasks;


use DB;
use Auth;
use Request;
use Datatables;
use Redirect;
use Validator;
use App\User;
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
use App\Models\Hamahang\Tasks\hamahang_process_tasks_relations;
use App\HamahangCustomClasses\EncryptString;
use App\HamahangCustomClasses\jDateTime;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\Hamahang\keywords;

class MyTaskController extends Controller
{
    public function FetchAllTaskList(){
        Session::put('AllTaskTitle',Request::input('title'));
        Session::put('AllTaskOfficialType',Request::input('official_type'));
        Session::put('AllTaskTaskImportantImmediate',Request::input('task_important_immediate'));
        Session::put('AllTaskTaskImportantTaskStatus',Request::input('task_status'));
        Session::put('AllTaskTaskUsers',Request::input('users'));

        if(Request::exists('users'))
        {
            $users = User::whereIn('id', Request::input('users'))->select('id', 'Name', 'Family')->get();
            $keyValues = [];
            foreach ($users as $user)
            {
                $keyValues[] = [$user->id => $user->Name.' '.$user->Family];
            }
            Session::put('AllTaskTaskUsers', $keyValues);
        }else{
            Session::remove('AllTaskTaskUsers', null);
        }

        if(Request::exists('keywords'))
        {
            $keywords = keywords::whereIn('id', str_ireplace('exist_in', '', Request::input('keywords')))->select('id', 'title')->get();
            $keyValues = [];
            foreach ($keywords as $keyword)
            {
                $keyValues[] = [$keyword->id => $keyword->title];
            }
            Session::put('AllTaskTaskKeywords', $keyValues);
        }else{
            Session::remove('AllTaskTaskKeywords');
        }

        $date = new jDateTime;
        $Tasks = tasks::ListAllAssignedTasks(Auth::id(), Request::input('subject_id'));
        $Tasks = Datatables::of($Tasks)
            ->editColumn('type', function ($data)
            {
                return GetTaskStatusName($data->type);
            })
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->editColumn('assignment_created_at', function ($data)
            {
                $date = new jDateTime;
                $datetime = explode(' ', $data->assignment_created_at);
                $task_date = explode('-', $datetime[0]);
                $time = explode(':', $datetime[1]);
                $g_timestamp = mktime($time[0], $time[1], $time[2], $task_date [1], $task_date [2], $task_date [0]);
                $jdate = $date->getdate($g_timestamp);
                $jdateA = $jdate['year'] . '/' . $jdate['mon'] . '/' . $jdate['mday'];
                return ['jdate' => $jdateA, 'num_date' => ($date->convertElseNumbers($jdate['year'])*365 + $date->convertElseNumbers($jdate['mon'])*31 + $date->convertElseNumbers($jdate['mday']))];
            })
            ->editColumn('use_type', function ($data)
            {
                return hamahang_get_task_use_type_name($data->use_type);
            })
            ->addColumn('respite', function ($data)use ($date)
            {
                $r = $date->getdate(strtotime($data->schedule_time) + $data->duration_timestamp);
                $respite_days = hamahang_respite_remain(strtotime($data->schedule_time), $data->duration_timestamp);
                if ($respite_days[0]['delayed'] == 1)
                {
                    $respite_days = ($respite_days[0]['day_no']) * (-1);
                    $bg = 'bg_red';
                }
                else
                {
                    $respite_days = $respite_days[0]['day_no'];
                    $bg = 'bg_green';
                }
                return ['bg'=>$bg,'respite_days'=>$respite_days,'gdate'=>$r['year'].'/'.$r['mon'].'/'.$r['mday']];
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
            ->addColumn('employee', function ($data)
            {
                return $data->f_name . " " . $data->f_family;
            })->addColumn('assigner', function ($data)
            {
                return $data->t_name . " " . $data->t_family;
            })
            ->rawColumns(['employee'])
            ->rawColumns(['assigner'])
            ->make(true);
        Session::put('MyTasksFetch', $Tasks);
        return Session::get('MyTasksFetch');
    }

    public function get_transcripts($uname)
    {
        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.tasks.my_tasks.transcripts_list':
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
                return view('hamahang.Tasks.MyAssignedTask.MyTranscriptsTasksList', $arr);
                break;
            case 'ugc.desktop.hamahang.tasks.my_tasks.transcripts':
                $arr['HFM_CNT'] = HFM_GenerateUploadForm(
                    [
                        ['AddNewFiles',
                            ['jpeg', 'jpg', 'png', 'gif', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
                            'Multi'
                        ]
                    ]
                );
                $arr = variable_generator('user', 'desktop', $uname);
                return view('hamahang.Tasks.MyAssignedTask.MyTranscriptsTasksList', $arr);
                break;
        }
    }

    public function ListAllTask($uname){

        $packages = task_packages::where('uid', Auth::id())->get();

        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.tasks.my_tasks.all_task_list':
                $arr = variable_generator('page', 'desktop', $uname);
                $arr['packages'] = $packages;
                $arr['filter_subject_id'] = $arr["sid"];
                $arr['attach_files'] = HFM_GenerateUploadForm([['new_process_task', ['pdf', 'jpg', 'zip', 'docx', 'xlsx', 'ppt', 'pptx'], 'Multi']]);
                return view('hamahang.Tasks.MyTask.AllTasksList', $arr);
                break;
            case 'ugc.desktop.hamahang.tasks.my_tasks.all_task_list':
                $arr = variable_generator('user', 'desktop', $uname);
                $arr['packages'] = $packages;
                $arr['attach_files'] = HFM_GenerateUploadForm([['new_process_task', ['pdf', 'jpg', 'zip', 'docx', 'xlsx', 'ppt', 'pptx'], 'Multi']]);
                return view('hamahang.Tasks.MyTask.MyTasksList', $arr);
                break;
        }
    }

    public function FilterAllTaskState($uname){
        $arr = variable_generator('page', 'desktop', $uname);
        $arr['filter_subject_id'] = $arr["sid"];
        $arr['MyTasksInState'] = tasks::all_task_in_status($arr)->render();
        return view('hamahang.Tasks.MyTask.StateAllTasks', $arr);
    }

    public function ListAllTaskState($uname){
        $packages = task_packages::where('uid', Auth::id())->get();
        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.tasks.my_tasks.all_task_state':
                $arr = variable_generator('page', 'desktop', $uname);
                $arr['filter_subject_id'] = $arr["sid"];
//                $arr['MyTasksInState'] = tasks::all_task_in_status($arr)->render();
                return view('hamahang.Tasks.MyTask.StateAllTasks', $arr);
                break;
            case 'ugc.desktop.hamahang.tasks.my_tasks.all_task_state':
                $arr = variable_generator('page', 'desktop', $uname);
                $arr['filter_subject_id'] = $arr["sid"];
//                $arr['MyTasksInState'] = tasks::all_task_in_status($arr)->render();
                return view('hamahang.Tasks.MyTask.StateAllTasks', $arr);
                break;
        }
    }

    public function filter_all_task_priority()
    {
        Session::put('AllTaskTitle',Request::input('title'));
        Session::put('AllTaskOfficialType',Request::input('official_type'));
        Session::put('AllTaskTaskImportantImmediate',Request::input('task_important_immediate'));
        Session::put('AllTaskTaskImportantTaskStatus',Request::input('task_status'));
        Session::put('AllTaskTaskUsers',Request::input('users'));

        if(Request::exists('users'))
        {
            $users = User::whereIn('id', Request::input('users'))->select('id', 'Name', 'Family')->get();
            $keyValues = [];
            foreach ($users as $user)
            {
                $keyValues[] = [$user->id => $user->Name.' '.$user->Family];
            }
            Session::put('AllTaskTaskUsers', $keyValues);
        }else{
            Session::remove('AllTaskTaskUsers', null);
        }

        if(Request::exists('keywords'))
        {
            $keywords = keywords::whereIn('id', str_ireplace('exist_in', '', Request::input('keywords')))->select('id', 'title')->get();
            $keyValues = [];
            foreach ($keywords as $keyword)
            {
                $keyValues[] = [$keyword->id => $keyword->title];
            }
            Session::put('AllTaskTaskKeywords', $keyValues);
        }else{
            Session::remove('AllTaskTaskKeywords');
        }
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
            $respite = Request::get('respite');
            $task_title = Request::get('title');
            $task_status = Request::get('task_status');
            $official_type = Request::get('official_type');
            $keywords = Request::get('keywords');
            $users = Request::get('users');
            $source = Request::get('act');
            $filter_subject_id = Request::input('filter_subject_id') != "undefined" ? Request::input('filter_subject_id') : '';
//            DB::enableQueryLog();
            $with_array = tasks::AllTasksPriority(['filter_subject_id'=>$filter_subject_id],$task_status, $task_title, $respite, $official_type, $keywords, $users, $source);
//            dd(DB::getQueryLog());
            $result['data'] = view('hamahang.Tasks.helper.priority.content')->with($with_array)->render();
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function ListAllTaskPriority($uname){
        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.tasks.my_tasks.all_task_priority':
                $arr = variable_generator('page', 'desktop', $uname);
                $arr['filter_subject_id'] = $arr["sid"];
//                DB::enableQueryLog();
                $arr = array_merge($arr, tasks::AllTasksPriority($arr,[0,1],false,false,[0,1]));
//                dd(DB::getQueryLog());
                return view('hamahang.Tasks.PriorityAllTasks', $arr);
                //return view('hamahang.Tasks.MyTask.MyTasksPriority', $arr);
                break;
            case 'ugc.desktop.hamahang.tasks.my_tasks.all_task_priority':
                $arr = variable_generator('user', 'desktop', $uname);
                $arr = array_merge($arr, tasks::MyTasksPriority($arr,[0,1],false,false,[0,1]));
                return view('hamahang.Tasks.priority', $arr);
                //return view('hamahang.Tasks.MyTask.MyTasksPriority', $arr);
                break;
        }
    }

    private function my_task_in_status($arr = false, $user = false)
    {

        $official_type = [0,1];
        $importance = [0,1];
        $immediate = [0,1];

        if (!$user)
        {
            $user = auth()->user();
        }
        $myTasks=[];
        $filter_subject_id = isset($arr['filter_subject_id']) ? $arr['filter_subject_id'] : '';

//        $myTasks['not_started'] = $user->MyTasks()->whereIn('type', $official_type)->whereHas('Status', function ($q)
//        {
//            $q->where('type', 0);
//        })->whereHas('priority', function ($p)use($importance){$p->whereIn('importance',$importance);})
//            ->whereHas('priority', function ($p)use($immediate){$p->whereIn('immediate',$immediate);});
//        if(trim($title)!='')
//        {
//            $myTasks['not_started']->where('title','like','%'.$title.'%');
//        }

        $myTasks['not_started'] = $user->MyTasks()->whereIn('type', $official_type)->whereHas('priority', function ($p)use($importance){
            $p->whereIn('importance',$importance)->whereIn('importance',$importance);
        })->whereHas('priority', function ($p)use($immediate){
            $p->whereIn('immediate',$immediate);
        })->whereHas('Status', function ($q){
            $q->where('type', 0);
        });
        if (trim($filter_subject_id)!='' && trim($filter_subject_id)!='undefined')
        {
            $myTasks['not_started']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $myTasks['not_started'] = $myTasks['not_started']->groupBy('hamahang_task.id')->get();

        $myTasks['started'] = $user->MyTasks()->whereIn('type', $official_type)->whereHas('priority', function ($p)use($importance){
            $p->whereIn('importance',$importance)->whereIn('importance',$importance);
        })->whereHas('priority', function ($p)use($immediate){
            $p->whereIn('immediate',$immediate);
        })->whereHas('Status', function ($q){
            $q->where('type', 1);
        });
        if (trim($filter_subject_id)!='' && trim($filter_subject_id)!='undefined')
        {
            $myTasks['started']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $myTasks['started'] = $myTasks['started']->groupBy('hamahang_task.id')->get();

        $myTasks['done'] = $user->MyTasks()->whereIn('type', $official_type)->whereHas('priority', function ($p)use($importance){
            $p->whereIn('importance',$importance);
        })->whereHas('priority', function ($p)use($immediate){
            $p->whereIn('immediate',$immediate);
        })->whereHas('Status', function ($q){
            $q->where('type', 2);
        });
        if (trim($filter_subject_id)!='' && trim($filter_subject_id)!='undefined')
        {
            $myTasks['done']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $myTasks['done'] = $myTasks['done']->groupBy('hamahang_task.id')->get();

        $myTasks['ended'] = $user->MyTasks()->whereIn('type', $official_type)->whereHas('priority', function ($p)use($importance){
            $p->whereIn('importance',$importance);
        })->whereHas('priority', function ($p)use($immediate){
            $p->whereIn('immediate',$immediate);
        })->whereHas('Status', function ($q){
            $q->where('type', 3);
        });
        if (trim($filter_subject_id)!='' && trim($filter_subject_id)!='undefined')
        {
            $myTasks['ended']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $myTasks['ended'] = $myTasks['ended']->groupBy('hamahang_task.id')->get();

        $user = auth()->user();
        return view('hamahang.Tasks.MyTask..helper.MyTasksState.content', compact('user', 'myTasks'));
        if (!$user)
        {
            $user = auth()->user();
        }
        $myTasks=[];

        $myTasks['not_started'] = $user->MyTasks()->whereHas('Status', function ($q)
        {
            $q->where('type', 0);
        });
        if (isset($arr['filter_subject_id']))
        {
            $myTasks['not_started']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$arr['filter_subject_id'])
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $myTasks['not_started'] = $myTasks['not_started']->get();

        $myTasks['started'] = $user->MyTasks()->whereHas('Status', function ($q)
        {
            $q->where('type', 1);
        });
        if (isset($arr['filter_subject_id']))
        {
            $myTasks['started']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$arr['filter_subject_id'])
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $myTasks['started'] = $myTasks['started']->get();

        $myTasks['done'] = $user->MyTasks()->whereHas('Status', function ($q)
        {
            $q->where('type', 2);
        });
        if (isset($arr['filter_subject_id']))
        {
            $myTasks['done']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$arr['filter_subject_id'])
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $myTasks['done'] = $myTasks['done']->get();

        $myTasks['ended'] = $user->MyTasks()->whereHas('Status', function ($q)
        {
            $q->where('type', 3);
        });
        if (isset($arr['filter_subject_id']))
        {
            $myTasks['ended']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$arr['filter_subject_id'])
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $myTasks['ended'] = $myTasks['ended']->get();
        $user = auth()->user();
        return view('hamahang.Tasks.MyTask..helper.MyTasksState.content', compact('user', 'myTasks'));
    }

    public function MyTasksState($uname)
    {
        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.tasks.my_tasks.state':
                $arr = variable_generator('page', 'desktop', $uname);
                $arr['filter_subject_id'] = $arr["sid"];

                Session::put('filter_subject_id',$uname);
                $arr['MyTasksInState'] = $this->my_task_in_status($arr)->render();
                return view('hamahang.Tasks.MyTask.MyTasksState', $arr);
                break;
            case 'ugc.desktop.hamahang.tasks.my_tasks.state':
                $arr = variable_generator('user', 'desktop', $uname);
                $arr['MyTasksInState'] = $this->my_task_in_status($arr)->render();
                return view('hamahang.Tasks.MyTask.MyTasksState',$arr);
                break;
        }
    }

    public function MyTasksPriority($uname)
    {
//        asd
        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.tasks.my_tasks.priority':
                $arr = variable_generator('page', 'desktop', $uname);
                $arr['filter_subject_id'] = $arr["sid"];
//                DB::enableQueryLog();
                $arr = array_merge($arr, tasks::MyTasksPriority($arr,[0,1],false,false,[0,1]));
//                dd(DB::getQueryLog());
                return view('hamahang.Tasks.priority', $arr);
                //return view('hamahang.Tasks.MyTask.MyTasksPriority', $arr);
                break;
            case 'ugc.desktop.hamahang.tasks.my_tasks.priority':
                $arr = variable_generator('user', 'desktop', $uname);
                $arr = array_merge($arr, tasks::MyTasksPriority($arr,[0,1],false,false,[0,1]));
                return view('hamahang.Tasks.priority', $arr);
                //return view('hamahang.Tasks.MyTask.MyTasksPriority', $arr);
                break;
        }
    }

    public function MyTasksList($uname)
    {
//        $total = tasks::FetchDraftsTasks();
////        $total = drafts::FetchDraftsList();
//        foreach ($total as $t)
//        {
//            $d = new jDateTime;
//            $datetime = explode(' ', $t->cr);
//            $date = explode('-', $datetime[0]);
//            $time = explode(':', $datetime[1]);
//            $g_timestamp = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
//            $jdate = $d->getdate($g_timestamp);
//            $jdate = $jdate['year'] . '/' . $jdate['mon'] . '/' . $jdate['mday'];
//            $t->cr = $jdate;
//        }
//        $data = collect($total)->map(function ($x)
//        {
//            return (array)$x;
//        })->toArray();
//        $result['data'] = $data;
//        return json_encode($result);

        $packages = task_packages::where('uid', Auth::id())->get();
//        dd(\Route::currentRouteName());
        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.tasks.my_tasks.list':
                $arr = variable_generator('page', 'desktop', $uname);
                $arr['packages'] = $packages;
                $arr['filter_subject_id'] = $arr["sid"];
                $arr['attach_files'] = HFM_GenerateUploadForm([['new_process_task', ['pdf', 'jpg', 'zip', 'docx', 'xlsx', 'ppt', 'pptx'], 'Multi']]);
                return view('hamahang.Tasks.MyTask.MyTasksList', $arr);
                break;
            case 'ugc.desktop.hamahang.tasks.my_tasks.list':
                $arr = variable_generator('user', 'desktop', $uname);
                $arr['packages'] = $packages;
                $arr['attach_files'] = HFM_GenerateUploadForm([['new_process_task', ['pdf', 'jpg', 'zip', 'docx', 'xlsx', 'ppt', 'pptx'], 'Multi']]);
                return view('hamahang.Tasks.MyTask.MyTasksList', $arr);
                break;
        }
    }

    public function MyTasksFetch()
    {
//        db::enableQueryLog();
        $Tasks = tasks::MyTasks(Request::input('subject_id'));
//        dd(db::getQueryLog());
        $date = new jDateTime;
        $Tasks = Datatables::of($Tasks)
            ->editColumn('type', function ($data)
            {
                return GetTaskStatusName($data->task_status);
            })
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->editColumn('assignment_id', function ($data)
            {
                return enCode($data->assignment_id);
            })
            ->editColumn('use_type', function ($data)
            {
                return hamahang_get_task_use_type_name($data->use_type);
            })
            ->editColumn('assignment_created_at', function ($data)
            {
                $date = new jDateTime;
                $datetime = explode(' ', $data->assignment_created_at);
                $task_date = explode('-', $datetime[0]);
                $time = explode(':', $datetime[1]);
                $g_timestamp = mktime($time[0], $time[1], $time[2], $task_date [1], $task_date [2], $task_date [0]);
                $jdate = $date->getdate($g_timestamp);
                $jdateA = $jdate['year'] . '/' . $jdate['mon'] . '/' . $jdate['mday'];
                return ['jdate' => $jdateA, 'num_date' => ($date->convertElseNumbers($jdate['year'])*365 + $date->convertElseNumbers($jdate['mon'])*31 + $date->convertElseNumbers($jdate['mday']))];
            })
            ->addColumn('respite', function ($data) use ($date)
            {
                $r = $date->getdate(strtotime($data->schedule_time) + $data->duration_timestamp);
                $respite_days = hamahang_respite_remain(strtotime($data->schedule_time), $data->duration_timestamp);
                if ($respite_days[0]['delayed'] == 1)
                {
                    $respite_days = ($respite_days[0]['day_no']) * (-1);
                    $bg = 'bg_red';
                }
                else
                {
                    $respite_days = $respite_days[0]['day_no'];
                    $bg = 'bg_green';
                }
                return ['bg'=>$bg,'respite_days'=>$respite_days,'gdate'=>$r['year'].'/'.$r['mon'].'/'.$r['mday']];
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
            ->addColumn('pages', function ($data)
            {
                $pages = DB::table('hamahang_subject_ables')
                    ->where('hamahang_subject_ables.target_id', '=',$data->id)
                    ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\tasks')
                    ->whereNull('hamahang_subject_ables.deleted_at')->pluck('subject_id')->toArray();
                $pages = DB::table('pages')
                    ->leftJoin('subjects','subjects.id','=','pages.sid')
                    ->whereIn('sid',$pages)->groupBy('sid')->select('pages.id','subjects.title')->get()->toArray();
                $pages_detail = [];
                foreach($pages as $page)
                {
                    $pages_detail[] = ['id'=>$page->id,'title'=>$page->title];
                }
                return $pages_detail;
            })
            ->addColumn('employee', function ($data)
            {
                return '<a href="' . url('/' . $data->Uname) . '" target="_blank">' . $data->Name . ' ' . $data->Family . '</a>';
            })
            ->rawColumns(['employee'])
            ->make(true);
        Session::put('MyTasksFetch', $Tasks);
        return $Tasks;
    }

    public function reject()
    {
        $assign = task_assignments::where('task_id', '=', Request::input('id'))
            ->first();
        $assign->reject_description = Request::input('desc');
        $assign->save();
        return json_encode(['success' => true]);
    }

    public function ShowCustomMyTasks()
    {
        dd(Request::all());
        $data = DB::table('hamahang_task')
            ->select(
                "hamahang_task.id",
                "title",
                "hamahang_task_priority.importance",
                "hamahang_task_priority.immediate",
                "duration_timestamp",
                "hamahang_task.schedule_time as created",
                "hamahang_task_status.type",
                DB::raw('CONCAT(Name, " ", Family) AS full_name'))
            ->join('hamahang_task_assignments', 'hamahang_task_assignments.task_id', 'hamahang_task.id')
            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
            ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
            ->join('user', 'hamahang_task_assignments.assigner_id', '=', 'user.id')
            ->where('hamahang_task_assignments.employee_id', '=', Auth::id())
            ->whereNull('hamahang_task_assignments.reject_description')
            ->whereNull('hamahang_task_assignments.transmitter_id');

        if (Request::input('str') != '')
        {
            $data->where("hamahang_task.title", "LIKE", "%" . Request::input('str') . "%");
        }

        if (Request::input('respite_day_no') > 0)
        {
            date_default_timezone_set('Asia/Tehran');
            $timestamp = mktime(0, 0, 0, date('m'), date('d'), date('y'));
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
            `hamahang_task_priority`.`user_id`= ?)', [Auth::id()])->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )');
        if (Request::exists('page_id'))
        {
            $data->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->whereNull('hamahang_subject_ables.deleted_at')
                ->where('hamahang_subject_ables.subject_id', '=', Request::input('page_id'))
                ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\tasks');
        }
        $x = $data->get();
        date_default_timezone_set('Asia/Tehran');
        foreach ($x AS $task)
        {
            $respite_date = date('Y-m-d', $task->duration_timestamp);
            $date1 = date_create($respite_date);
            $date2 = date_create(date('Y-m-d'));
            $diff = date_diff($date2, $date1);
            // $task->respite_days = $diff->format("%R%a");
            $task->respite_days = hamahang_respite_remain(strtotime($task->created), $task->duration_timestamp);
            //die(var_dump($task->respite_days));
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

    public function change_type_task(Request $request)
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
                    if($task->end_on_assigner_accept!=0)
                    {
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
                    } else{
                        $result['success'] = false;
                    }
                    break;
                }
                default :
                {
                    break;
                }
            }
            $arr['filter_subject_id'] = Request::input('filter_subject_id');
            $result['data']=$this->my_task_in_status($arr)->render();
            return $result;

        }
    }

    public function load_mytask()
    {
        $result['data'] = $this->my_task_in_status()->render();
        $result['success'] = true;
        return $result;

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
            $filter_subject_id = Request::input('filter_subject_id');
            $respite = Request::get('respite');
            $task_title = Request::get('task_title');
            $task_important = Request::get('task_important');
            $task_immediate = Request::get('task_immediate');
            $official_type = Request::get('official_type');
//            db::enableQueryLog();
            $myTasks= tasks::MyTasksStatus($filter_subject_id, $task_important,$task_immediate, $task_title, $respite, $official_type);
//            dd(db::getQueryLog());
            $result['success'] = true;
            $result['data'] = view('hamahang.Tasks.MyTask.helper.MyTasksState.content', compact('user', 'myTasks'))->render();
            $result['success'] = true;
            return $result;
        }
    }

    public function filter_all_task_state()
    {
        Session::put('AllTaskTitle',Request::input('title'));
        Session::put('AllTaskOfficialType',Request::input('official_type'));
        Session::put('AllTaskTaskImportantImmediate',Request::input('task_important_immediate'));
        Session::put('AllTaskTaskImportantTaskStatus',Request::input('task_status'));
        Session::put('AllTaskTaskUsers',Request::input('users'));

        if(Request::exists('users'))
        {
            $users = User::whereIn('id', Request::input('users'))->select('id', 'Name', 'Family')->get();
            $keyValues = [];
            foreach ($users as $user)
            {
                $keyValues[] = [$user->id => $user->Name.' '.$user->Family];
            }
            Session::put('AllTaskTaskUsers', $keyValues);
        }else{
            Session::remove('AllTaskTaskUsers', null);
        }

        if(Request::exists('keywords'))
        {
            $keywords = keywords::whereIn('id', str_ireplace('exist_in', '', Request::input('keywords')))->select('id', 'title')->get();
            $keyValues = [];
            foreach ($keywords as $keyword)
            {
                $keyValues[] = [$keyword->id => $keyword->title];
            }
            Session::put('AllTaskTaskKeywords', $keyValues);
        }else{
            Session::remove('AllTaskTaskKeywords');
        }
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
            $filter_subject_id = Request::input('filter_subject_id');
            $respite = Request::get('respite');
            $task_title = Request::get('task_title');
            $task_important = Request::get('task_important');
            $task_immediate = Request::get('task_immediate');
            $official_type = Request::get('official_type');
//            db::enableQueryLog();
            $myTasks= tasks::AllTasksStatus($filter_subject_id, $task_important,$task_immediate, $task_title, $respite, $official_type);
//            dd(db::getQueryLog());
            $result['success'] = true;
            $result['data'] = view('hamahang.Tasks.MyTask.helper.MyTasksState.content', compact('user', 'myTasks'))->render();
            $result['success'] = true;
            return $result;
        }
    }

    public function TaskStart()
    {
        $task_use_type = tasks::find(Request::input('tid'))->use_type;
        if ($task_use_type == 1)
        {
            $new_status = 1;
            $arr = [];
            $conflict = 0;
            $relations = hamahang_process_tasks_relations::get_process_task_relations(Request::input('tid'));
            foreach ($relations as $rel)
            {
                switch ($rel->relation)
                {
                    case 0:
                    {
                        switch ($new_status)
                        {
                            case 1:
                            {
                                if ($rel->type == 0)
                                {
                                    $arr[] = array_push($arr, ["id" => $rel->second_task_id, "relation" => (int)$rel->relation, "task_title" => $rel->title]);
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
                            case 1:
                            {
                                if ($rel->type != 4)
                                {
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

                    }
                    default:
                    {
                        break;
                    }

                }

            }
            if ($conflict == 0)
            {
                return json_encode('ok');
            }
            else
            {
                return json_encode($arr);
            }

        }
    }
}