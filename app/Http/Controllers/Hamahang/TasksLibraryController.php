<?php

namespace App\Http\Controllers\Hamahang;

use App\Models\Hamahang\Tasks\hamahang_process_tasks_relations;
use App\Models\Hamahang\Tasks\project_task;
use Illuminate\Support\Facades\Session;
use Validator;
//use Illuminate\Http\Request;
use DB;
use Auth;
use Request;
use App\Http\Controllers\Controller;
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
use App\User;
use App\Models\Hamahang\FileManager\FileManager;
use App\Models\Hamahang\Tasks\task_attachments;
use App\Models\Hamahang\Tasks\task_follow_ups;
use App\HamahangCustomClasses\EncryptString;
use DateTime;
use App\HamahangCustomClasses\jDateTime;
use App\Models\Hamahang\Tasks\task_files;
use Redirect;
use App\Models\Hamahang\Tasks\drafts;
use App\Models\Hamahang\Tasks\hamahang_tasks_library;
//use Morilog\Jalali\jDate;
//use Morilog\Jalali\jDateTime;

use App\Models\Hamahang\Tasks\task_transfers;
use App\Models\Hamahang\Tasks\task_logs;
use App\Models\Hamahang\Tasks\task_inheritance;
use App\Models\Hamahang\Tasks\task_priority;
use App\Models\Hamahang\OrgChart\org_organs;
use App\Models\Hamahang\Tasks\process_task;

class TasksLibraryController extends Controller
{
    public function index($uname)
    {
        $arr = variable_generator('user','desktop',$uname);
        return view('hamahang.Tasks.TasksLibrary',$arr);
    }

    public function FetchTasks()
    {
        $tasks = DB::table('hamahang_tasks_library')
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
