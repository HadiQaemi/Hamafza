<?php

namespace App\Http\Controllers\Hamahang;

use Datatables;
use Validator;
//use Illuminate\Http\Request;
use DB;
use Request;
use App\Http\Controllers\Controller;

use App\Models\Hamahang\Tasks\task_attachments;
use App\HamahangCustomClasses\jDateTime;
use App\Models\Hamahang\Tasks\hamahang_tasks_library;
//use Morilog\Jalali\jDate;
//use Morilog\Jalali\jDateTime;

class TasksLibraryController extends Controller
{
    public function save()
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
            hamahang_tasks_library::save_task_in_lib(serialize(Request::all()), Request::input('title'), Request::input('task_form_action'));
        }
        $result['success'] = true;
        return json_encode($result);

    }

    public function update()
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
            $task = hamahang_tasks_library::where('id','=',decode(\Session::get('TaskForm_tid')))->first();
//                ->update(['title' => Request::input('title'), 'type' => Request::input('task_form_action'),
//                    'task_attributes' => serialize(Request::all())]);
            $task->title = Request::input('title');
            $task->type = Request::input('task_form_action');
            $task->task_attributes = serialize(Request::all());
            $task->deleted_at = NULL;
            $task->save();
        }
        $result['success'] = true;
        return json_encode($result);

    }

    public function GeneralFetch()
    {
        $GeneralLiberary = DB::table('hamahang_task_library')
            ->select("hamahang_task_library.*", "user.Name", "user.Family")
            ->join('user', 'user.id', '=', 'hamahang_task_library.uid')
            ->where('hamahang_task_library.status','=',1)
//                ->whereNull('hamahang_task_assignments.transmitter_id')
            ->where('hamahang_task_library.type','=','public')
        ;

        $GeneralLiberary = $GeneralLiberary->get();

        return Datatables::of($GeneralLiberary)
            ->addColumn('created_at', function ($data)
            {
                $d = new jDateTime;
                $datetime = explode(' ', $data->created_at);
                $date = explode('-', $datetime[0]);
                $time = explode(':', $datetime[1]);
                $g_timestamp = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
                $jdate = $d->getdate($g_timestamp);
                return $jdate['year'] . '/' . $jdate['mon'] . '/' . $jdate['mday'];
            })
            ->addColumn('creator', function ($data)
            {
                return $data->Name . ' ' . $data->Family;
            })
            ->addColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->make(true);
    }

    public function PrivateFetch()
    {
        $GeneralLiberary = DB::table('hamahang_task_library')
            ->select("hamahang_task_library.*", "user.Name", "user.Family")
            ->join('user', 'user.id', '=', 'hamahang_task_library.uid')
//                ->whereNull('hamahang_task_assignments.transmitter_id')
            ->where('hamahang_task_library.status','=',1)
            ->where('hamahang_task_library.type','=','private')
        ;

        $GeneralLiberary = $GeneralLiberary->get();

        return Datatables::of($GeneralLiberary)
            ->addColumn('created_at', function ($data)
            {
                $d = new jDateTime;
                $datetime = explode(' ', $data->created_at);
                $date = explode('-', $datetime[0]);
                $time = explode(':', $datetime[1]);
                $g_timestamp = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
                $jdate = $d->getdate($g_timestamp);
                return $jdate['year'] . '/' . $jdate['mon'] . '/' . $jdate['mday'];
            })
            ->addColumn('creator', function ($data)
            {
                return $data->Name . ' ' . $data->Family;
            })->addColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->make(true);
    }

    public function GeneralList($uname)
    {
        $arr = variable_generator('user', 'desktop', $uname);
        return view('hamahang.TaskLiberary.GeneralLiberary', $arr);
    }

    public function PersonalList($uname)
    {
        $arr = variable_generator('user', 'desktop', $uname);
        return view('hamahang.TaskLiberary.PersonalList', $arr);
    }

    public function DeleteTaskLiberary()
    {
        hamahang_tasks_library::where('id','=',deCode(Request::input('id')))
            ->update(['status'=>0]);
        $result['success'] = true;
        return json_encode($result);
    }

    public function index($uname)
    {
        $arr = variable_generator('user','desktop',$uname);
        return view('hamahang.Tasks.TasksLibrary',$arr);
    }

    public function FetchTasks()
    {
        $tasks = DB::table('hamahang_task_library')
            ->whereNull('deleted_at')
            ->get();
        $data = collect($tasks)->map(function ($x) {
            return (array)$x;
        })->toArray();
        $result['data'] = $data;
        return json_encode($result);
    }

    public function RemoveLibraryTask()
    {
        hamahang_tasks_library::where('id','=',Request::input('tid'))
            ->update(['deleted_at'=>'111']);
        return json_encode('ok');
    }
}
