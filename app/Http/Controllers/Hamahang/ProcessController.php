<?php

namespace App\Http\Controllers\Hamahang;

use DB;
use Auth;
use Session;
use Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\Hamahang\Tasks\tasks;
use App\Models\Hamahang\Tasks\process;
use App\HamahangCustomClasses\jDateTime;
use App\Models\Hamahang\Tasks\task_logs;
use App\Models\Hamahang\Tasks\task_files;
use App\Models\Hamahang\Tasks\task_staffs;
use App\Models\Hamahang\Tasks\task_notices;
use App\Models\Hamahang\Tasks\project_task;
use App\Models\Hamahang\Tasks\process_task;
use App\Models\Hamahang\Tasks\task_status;
use App\Models\Hamahang\Tasks\task_keywords;
use App\Models\Hamahang\Tasks\task_priority;
use App\Models\Hamahang\Tasks\process_keyword;
use App\Models\Hamahang\Tasks\task_assignments;
use App\Models\Hamahang\Tasks\task_transcripts;
use App\Models\Hamahang\Tasks\task_attachments;
use App\Models\Hamahang\Tasks\hamahang_subject_ables;
use App\Models\Hamahang\Tasks\hamahang_process_entity;
use App\Models\Hamahang\Tasks\hamahang_process_entity_log;
use App\Models\Hamahang\Tasks\hamahang_process_tasks_relations;
use App\Models\Hamahang\Tasks\hamahang_process_task_permitted_users;
use App\Models\Hamahang\Tasks\hamahang_process_relations;


class ProcessController extends Controller
{
    public function AddNewRelation()
    {
        $relation = new hamahang_process_relations;
        $relation->title = Request::input('title');
        $relation->process_id = Request::input('p_id');
        $relation->save();

        return json_encode('ok');
    }

    public function ModifyProcessInfo()
    {
        //die('ssss');
//        if (sizeof(Request::input('pages') == 0))
//        {
//            hamahang_subject_ables::where('item_id', '=', Request::input('process_id'))
//                ->where('item_type', '=', 2)
//                ->update(['deleted_at' => '2313']);
//
//        }
//        elseif (sizeof(Request::input('pages') > 0))
//        {
            hamahang_subject_ables::where('target_id', '=', Request::input('process_id'))
                ->where('target_type','=','App\\Models\\Hamahang\\Tasks\\task_process')
                ->whereNull('deleted_at')
                ->delete();
            //die(var_dump($current_pages));
            foreach (Request::input('pages') as $page_id)
            {
                hamahang_subject_ables::create_items_page($page_id, Request::input('process_id'),'App\Models\Hamahang\Tasks\task_process');
            }
//        }
    }

    public function ProcessValidation()
    {
        $process_start_and_end_taksk = process::where('id', '=', Request::input('process_id'))
            ->select('start_task_id', 'end_task_id')
            ->first();
        $first_step_tasks = hamahang_process_tasks_relations::where('hamahang_process_tasks_relations.task_id', '=', $process_start_and_end_taksk->start_task_id)
            ->select('hamahang_process_tasks_relations.next_task_id as id')
            ->whereNull('hamahang_process_tasks_relations.deleted_at')
            ->get();
        if ($first_step_tasks->count() > 0)
        {
            foreach ($first_step_tasks as $next)
            {
                $check_next = $this->check_next_task($next->id, Request::input('process_id'), $process_start_and_end_taksk->end_task_id);
                if ($check_next == true)
                {
                    $validation_result = true;
                }
                else
                {
                    $validation_result = false;
                    break;
                }
            }
        }
        else
        {
            $validation_result = false;
        }
        if ($validation_result == true)
        {
            process::where('id', '=', Request::input('process_id'))->update(['status' => 1]);
            return json_encode('ok');
        }
        elseif ($validation_result == false)
        {
            return json_encode('false');
        }

    }

    private function check_next_task($id, $pid, $end_task_id)
    {


        $first_step_tasks = DB::table('hamahang_process_tasks_relations')->where('hamahang_process_tasks_relations.task_id', '=', $id)
            ->select('hamahang_process_tasks_relations.next_task_id as id')
            ->whereNull('hamahang_process_tasks_relations.deleted_at')
            ->get();
        if ($first_step_tasks->count() > 0)
        {
            foreach ($first_step_tasks as $next)
            {
                if ($next->id == $end_task_id)
                {
                    $status = true;
                }
                else
                {
                    $status = $this->check_next_task($next->id, $pid, $end_task_id);
                }
            }
        }
        else
        {
            return false;
        }
        if ($status == true)
        {
            return true;
        }
    }

    public function ProcessEntityList($name)
    {
        $process_id = deCode($name);
        //die($process_id."*&^*&^");
        $entities = DB::table('hamahang_process_entity')->where('process_id', '=', $process_id)
            ->select('id')
            ->whereNull('deleted_at')
            ->get();
        $current_tasks = [];
        foreach ($entities as $entity)
        {
            $current_tasks = [];

            $tasks = hamahang_process_entity_log::where('entity_id', '=', $entity->id)
                ->join('hamahang_process_task', 'hamahang_process_task.id', '=', 'hamahang_process_entity_log.task_id')
                ->select('hamahang_process_task.id', 'hamahang_process_task.title')
                ->where('hamahang_process_entity_log.completed', '=', 0)
                ->get();

            foreach ($tasks as $task)
            {
                array_push($current_tasks, ['task_id' => $task->id, 'task_title' => $task->title]);
            }
            $entity->current_tasks = $current_tasks;
        }

        $process_tasks = collect($entities)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $result['data'] = $process_tasks;
        return json_encode($result);
    }

    public function ShowProcessEntity($uname, $name)
    {
        $arr = variable_generator('user','desktop',$uname);
        return view('hamahang.Process.ShowProcessEntity', $arr)->with('process_c_id', $name);
    }

    public function CreateNewProcessEntity()
    {
        $process_status = process::where('id', '=', Request::input('process_id'))->select('status')->first();
        if ($process_status->status == 1)
        {
            date_default_timezone_set('Asia/Tehran');
            $entity = new hamahang_process_entity;
            $entity->uid = Auth::id();
            $entity->process_id = Request::input('process_id');
            $entity->save();
            $start_task_id = process::where('id', Request::input('process_id'))
                ->select('start_task_id')->first();
            $fisrt_level_tasks = hamahang_process_tasks_relations::where('task_id', '=', $start_task_id->start_task_id)
                ->select('next_task_id as tid')->whereNull('deleted_at')->get();
            foreach ($fisrt_level_tasks as $first_task)
            {
                $log = new hamahang_process_entity_log;
                $log->entity_id = $entity->id;
                $log->task_id = $first_task->tid;
                $log->enter_timestamp = time();
                $log->uid = Auth::id();
                $log->save();

                ///////////////-----------------> create new real task in tasks table
                $task_details = DB::table('hamahang_process_task')
                    ->where('id', '=', $first_task->tid)
                    ->first();
                if ($task_details->assign_type == 0)
                {
                    $x = 0;
                    if (sizeof(Request::input('users') > 0))
                    {
                        $task = new tasks;
                        $task->title = $task_details->title;
                        $task->type = $task_details->type;
                        $task->desc = $task_details->desc;
                        $task->uid = Auth::id();
                        $task->use_type = 3;
                        $task->duration_timestamp = $task_details->respite;
                        $task->report_on_create_point = $task_details->report_on_create_point;
                        $task->report_on_completion_point = $task_details->report_on_completion_point;
                        $task->report_to_managers = $task_details->report_to_managers;
                        // $task->predicted_time = $task_details->predicted_time;
                        $task->end_on_assigner_accept = 0;
                        $task->transferable = $task_details->transferable;
                        //$task->draft = 0;
                        if ($task_details->report_on_create_point == true)
                        {
                            $task->report_on_create_point = 1;
                        }
                        if ($task_details->report_on_completion_point == true)
                        {
                            $task->report_on_completion_point = 1;
                        }
                        $task->save();
                        $assigner_status = new task_priority;
                        $assigner_status->uid = Auth::id();
                        $assigner_status->user_id = Auth::id();
                        $assigner_status->task_id = $task->id;
                        $assigner_status->timestamp = time();
                        $assigner_status->immediate = $task_details->immediate;
                        $assigner_status->importance = $task_details->importance;
                        $assigner_status->save();
                        //dd(unserialize($task_details->users));
                        foreach (unserialize($task_details->users) as $u)
                        {
                            if ($x == 0)
                            {

                                ////save first item as employee_id in task_assignments table
                                $assign = new task_assignments;
                                $assign->employee_id = $u;
                                $assign->assigner_id = Auth::id();
                                $assign->uid = Auth::id();
                                $assign->task_id = $task->id;
//                                $assign->current_state = 0;
                                $assign->save();
                                $assigner_status = new task_priority;
                                $assigner_status->uid = Auth::id();
                                $assigner_status->user_id = $u;
                                $assigner_status->task_id = $task->id;
                                $assigner_status->timestamp = time();
                                $assigner_status->immediate = $task_details->immediate;
                                $assigner_status->importance = $task_details->importance;
                                $assigner_status->save();
                                $status = new task_status;
                                $status->uid = Auth::id();
                                $status->task_id = $task->id;
                                $status->task_assignment_id = $assign->id;
                                $status->type = 0;
                                $status->user_id = Auth::id();
                                $status->timestamp = time();
                                $status->save();
                                $log = new task_logs;
                                $log->uid = Auth::id();
                                $log->type = 'create';
                                $log->timestamp = time();
                                $log->assign_id = $assign->id;
                                $log->task_id = $task->id;
                                $log->save();
                                $x = 1;
                            }
                            else
                            {
                                ////save other items as staff

                                $staff = new task_staffs;
                                $staff->uid = Auth::id();
                                $staff->assignment_id = $assign->id;
                                $staff->user_id = $u;
                                $staff->save();

                            }
                        }


                        $y = 0;

                        if (sizeof(unserialize($task_details->transcripts)) > 0)
                        {
                            foreach (unserialize($task_details->transcripts) as $tr)
                            {
                                $transcript = new task_transcripts;
                                $transcript->task_id = $task->id;
                                $transcript->user_id = $tr;
                                $transcript->save();
                                $y++;
                            }
                        }
//                        $keywords = unserialize($task_details->keywords);
//                        $keywords = explode(',', $keywords[0]);
//                        if (sizeof($keywords) > 0)
//                        {
//                            foreach ($keywords as $kw)
//                            {
//                                $keyword = new task_keywords;
//                                $keyword->task_id = $task->id;
//                                $keyword->keyword = $kw;
//                                $keyword->save();
//                            }
//                        }
                        $notice = new task_notices;
                        $notice->task_id = $task->id;
                        $notice->save();

                    } /////////////  951201
                    // die('created***');
                }
                elseif (Request::input('assign_type') == 2)
                {
                    foreach (Request::input('users') as $u)
                    {
                        $task = new tasks;
                        $task->title = Request::input('title');
                        $task->type = Request::input('type');
                        $task->desc = Request::input('task_desc');
                        $task->uid = Auth::id();
                        $task->use_type = Request::input('use_type');
                        $task->duration_timestamp = $task_details->respite;
                        $task->report_on_create_point = Request::input('report_on_cr');
                        $task->report_on_completion_point = Request::input('report_on_co');
                        $task->report_to_managers = Request::input('report_to_manager');
                        $task->predicted_time = Request::input('predicted_time');
                        $task->end_on_assigner_accept = Request::input('end_on_assigner_accept');
                        $task->transferable = Request::input('transferable');
                        if (Request::input('save_type') == 1)
                        {
                            $task->draft = 1;
                        }
                        else
                        {
                            $task->draft = 0;
                        }
                        if (Request::input('report_on_cr') == true)
                        {
                            $task->report_on_create_point = 1;
                        }
                        if (Request::input('report_on_co') == true)
                        {
                            $task->report_on_completion_point = 1;
                        }
                        $task->save();
                        $assigner_status = new task_priority;
                        $assigner_status->uid = Auth::id();
                        $assigner_status->user_id = Auth::id();
                        $assigner_status->task_id = $task->id;
                        $assigner_status->timestamp = time();
                        $assigner_status->immediate = Request::input('immediate');
                        $assigner_status->importance = Request::input('importance');
                        $assigner_status->save();


                        $assign = new task_assignments;
                        $assign->employee_id = $u;
                        $assign->assigner_id = Auth::id();
                        $assign->task_id = $task->id;
                        $assign->current_state = 0;
                        $assign->save();
                        $log = new task_logs;
                        $log->uid = Auth::id();
                        $log->type = 'create';
                        $log->timestamp = time();
                        $log->assign_id = $assign->id;
                        $log->task_id = $task->id;
                        $log->save();
                        $status = new task_status;
                        $status->task_id = $task->id;
                        $status->task_assignment_id = $assign->id;
                        $status->type = 0;
                        $status->user_id = Auth::id();
                        $status->timestamp = time();
                        $status->save();

                        $project = new project_task;
                        $project->project_id = Request::input('project')[0];
                        $project->task_id = $task->id;
                        $project->uid = Auth::id();
                        $project->save();

                        $assigner_status = new task_priority;
                        $assigner_status->uid = Auth::id();
                        $assigner_status->user_id = $u;
                        $assigner_status->task_id = $task->id;
                        $assigner_status->timestamp = time();
                        $assigner_status->immediate = Request::input('immediate');
                        $assigner_status->importance = Request::input('importance');
                        $assigner_status->save();

                        if (Session::has('Files'))
                        {
                            $files = Session::get('Files');
                            if (isset($files['CreateNewTask']) && is_array($files['CreateNewTask']))
                            {
                                $task_files = $files['CreateNewTask'];
                                foreach ($task_files as $key => $value)
                                {
                                    $f = new task_files;
                                    $f->task_id = $task->id;
                                    $f->file_id = $key;
                                    $f->save();
                                }
                            }

                        }
                        $y = 0;
                        if (sizeof(Request::input('transcripts')) > 0)
                        {
                            foreach (Request::input('transcripts') as $tr)
                            {
                                $transcript = new task_transcripts;
                                $transcript->task_id = $task->id;
                                $transcript->user_id = $tr;
                                $transcript->save();
                                $y++;
                            }
                        }
                        $keywords = Request::input('keyword');
                        $keywords = explode(',', $keywords[0]);
                        //dd($keywords);
                        if (sizeof($keywords) > 0)
                        {
                            foreach ($keywords as $kw)
                            {
                                $keyword = new task_keywords;
                                $keyword->task_id = $task->id;
                                $keyword->title= $kw;
                                $keyword->save();
                            }
                        }
                        $notice = new task_notices;
                        $notice->task_id = $task->id;
                        //$notice->sms = Request::input('sms');
                        //$notice->email = Request::input('email');
                        $notice->save();

                    }
                }

            }
            return json_encode(1);
        }
        else
        {
            return json_encode(0);
        }
    }

    public function change_process_task_edit_permission_group_type()
    {
        process_task::where('id', Request::input('tid'))
            ->update(['edit_permission_type' => Request::input('val')]);
        return json_encode('ok');
    }

    public function change_process_task_observation_permission_group_type()
    {
        process_task::where('id', Request::input('tid'))
            ->update(['observation_permission_type' => Request::input('val')]);
        return json_encode('ok');
    }

    public function ProcessTaskEditPermittedUsers($id)
    {
        $permitted = DB::table('hamahang_process_task_permitted_users')
            ->join('user', 'user.id', '=', 'hamahang_process_task_permitted_users.employee_id')
            ->where('hamahang_process_task_permitted_users.task_id', '=', $id)
            ->whereNull('hamahang_process_task_permitted_users.deleted_at')
            ->where('hamahang_process_task_permitted_users.permission_type', '=', 1)
            ->select('hamahang_process_task_permitted_users.id', DB::raw("CONCAT(Name,' ', Family) AS name"))
            ->get();
        $permitted = collect($permitted)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $result['data'] = $permitted;
        return json_encode($result);
    }

    public function ProcessTaskObservationPermittedUsers($id)
    {
        $permitted = DB::table('hamahang_process_task_permitted_users')
            ->join('user', 'user.id', '=', 'hamahang_process_task_permitted_users.employee_id')
            ->where('hamahang_process_task_permitted_users.task_id', '=', $id)
            ->whereNull('hamahang_process_task_permitted_users.deleted_at')
            ->where('hamahang_process_task_permitted_users.permission_type', '=', 0)
            ->select('hamahang_process_task_permitted_users.id', DB::raw("CONCAT(Name,' ', Family) AS name"))
            ->get();
        $permitted = collect($permitted)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $result['data'] = $permitted;
        return json_encode($result);
    }

    public function RemovePermission()
    {

        hamahang_process_task_permitted_users::where('id', Request::input('id'))
            ->delete();

        return json_encode('1');
    }

    public function AddTaskPermission()
    {
        $exist_permissions = DB::table('hamahang_process_task_permitted_users')->where('task_id', '=', Request::input('tid'))
            ->select('employee_id')
            ->where('permission_type', '=', Request::input('permission'))
            ->whereNull('deleted_at')
            ->get();

        $exist_permissions = collect($exist_permissions)->map(function ($x)
        {
            return (array)$x;
        })->toArray();

        $exist_permissions = array_column($exist_permissions, 'employee_id');
        $exist_permissions = array_unique($exist_permissions);
        $users = Request::input('users');
        foreach ($users as $user)
        {
            if (!in_array($user, $exist_permissions))
            {
                $permission = new hamahang_process_task_permitted_users;
                $permission->employee_id = $user;
                $permission->task_id = Request::input('tid');
                $permission->uid = Auth::id();
                $permission->permission_type = Request::input('permission');
                $permission->save();
            }
        }
        return json_encode(1);
    }

    public function FetchProcessTasks($id)
    {

        $tasks = DB::table('hamahang_process_task')
            ->where('hamahang_process_task.process_id', '=', $id)
            ->select('hamahang_process_task.id', 'hamahang_process_task.title', 'edit_permission_type as pe_type', 'observation_permission_type as po_type')
            ->whereNull('hamahang_process_task.deleted_at')
            ->get();
        $process_tasks = collect($tasks)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $result['data'] = $process_tasks;
        return json_encode($result);
    }

    public $prev_tasks = [];

    public function SaveNewProcessTask()
    {
        DB::transaction(function ()
        {

            $day_no = Request::input('duration_day');
            $hour_no = Request::input('duration_hour');
            $min_no = Request::input('duration_min');
            $sec_no = Request::input('duration_sec');
            $respite_duration_timestamp = hamahang_convert_respite_to_timestamp(0, 0, $day_no, $hour_no, $min_no, $sec_no);
            $task = new process_task;
            $task->users = serialize(Request::input('p_task_users'));
            $task->process_id = Request::input('process_id');
            $task->transcripts = serialize(Request::input('p_task_transcripts'));
            $task->respite = $respite_duration_timestamp;
            if (Request::input('p_task_keywords') != '')
            {
                $keywords = Request::input('p_task_keywords');
                $keywords = explode(',', $keywords[0]);
                $task->keywords = serialize($keywords);
            }
            $task->title = Request::input('title');
            $task->type = Request::input('type');
            $task->desc = Request::input('task_desc');
            $task->uid = Auth::id();
            $task->report_on_create_point = Request::input('report_on_cr');
            $task->report_on_completion_point = Request::input('report_on_co');
            $task->report_to_managers = Request::input('report_to_manager');
            //$task->respite = $respite_timestsmp;
            $task->predicted_time = Request::input('predicted_time');
            //$task->respite = $respite_timestsmp;
            if (Request::input('report_on_cr') == 1)
            {
                $task->report_on_create_point = 1;
            }
            if (Request::input('report_on_co') == 1)
            {
                $task->report_on_completion_point = 1;
            }
            if (Request::input('transferable') == 1)
            {
                $task->transferable = 1;
            }
            if (Request::input('end_on_assigner_accept') == 1)
            {
                $task->end_on_assigner_accept = 1;
            }

            $arr_files = [];
            if (Session::has('Files'))
            {
                $files = Session::get('Files');
                if (isset($files['CreateNewTask']) && is_array($files['CreateNewTask']))
                {
                    $task_files = $files['CreateNewTask'];
                    if (is_array($task_files))
                    {
                        foreach ($task_files as $key => $value)
                        {
                            array_push($arr_files, $key);
                        }
                    }
                }
            }
            $task->files = serialize($arr_files);
            $task->save();
//            $y = 0;
//            if (sizeof(Request::input('transcripts')) > 0) {
//                foreach (Request::input('transcripts') as $tr) {
//                    $transcript = new task_transcripts;
//                    $transcript->task_id = $task->id;
//                    $transcript->user_id = $tr;
//                    $transcript->save();
//                    $y++;
//                }
//            }
//            $keywords = Request::input('keyword');
//            $keywords = explode(',', $keywords[0]);
//            if (sizeof($keywords) > 0) {
//                foreach ($keywords as $kw) {
//                    $keyword = new task_keywords;
//                    $keyword->task_id = $task->id;
//                    $keyword->keyword = $kw;
//                    $keyword->save();
//                }
//            }
//            $notice = new task_notices;
//            $notice->task_id = $task->id;
//            $notice->save();
//
//
//            if (Session::has('Files')) {
//                if (isset($files['CreateNewTask']) && is_array($files['CreateNewTask'])) {
//                    unset($files['CreateNewTask']);
//                    Session::put('Files', $files);
//                }
//            }
        });
        //return Redirect::route('ugc.desktop.hamahang.process.index', ['username' => $uname]);
        return json_encode('ok');
    }

    public function ProcessList($uname)
    {
        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.process.list':
                $arr = variable_generator('page','desktop',$uname);
                $arr['filter_subject_id'] = $uname;
                $arr['attach_files'] = HFM_GenerateUploadForm([['new_process_task', ['pdf', 'jpg', 'zip', 'docx', 'xlsx'], 'Multi']]);
                return view('hamahang.Tasks.ProcessList', $arr);
                break;
            case 'ugc.desktop.hamahang.process.list':
                $arr = variable_generator('user','desktop',$uname);
                $arr['attach_files'] = HFM_GenerateUploadForm([['new_process_task', ['pdf', 'jpg', 'zip', 'docx', 'xlsx'], 'Multi']]);
                return view('hamahang.Tasks.ProcessList', $arr);
                break;
        }
    }

    public function ProcessDraftsList($uname)
    {
        $attachment = HFM_GenerateUploadForm([['new_process_task', ['pdf', 'jpg', 'zip', 'docx', 'xlsx'], 'Multi']]);
        $arr = variable_generator('user','desktop',$uname);
        $arr['attach_files'] = $attachment;

        return view('hamahang.Tasks.ProcessDraftsList', $arr);
    }

    public function FetchProcess()
    {
        $processes = DB::table('hamahang_process')
            ->where('hamahang_process.uid', '=', Auth::id())
            ->whereNull('hamahang_process.deleted_at')
            ->where('hamahang_process.draft', '=', 0)
            ->select('hamahang_process.title', 'hamahang_process.id', 'hamahang_process.status');
        if (Request::exists('subject_id'))
        {
            $processes->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_process.id')
                ->where('hamahang_subject_ables.subject_id' , Request::input('subject_id') )
                ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\task_process')
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $processes = $processes->get();
        foreach ($processes as $p)
        {
            $p->c_id = enCode($p->id);
            switch ($p->status)
            {
                case 0:
                {
                    $p->status_title = 'ناقص';
                    break;
                }
                case 0:
                {
                    $p->status_title = 'تکمیل';
                    break;
                }
            }

        }
        $dd = collect($processes)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $result['data'] = $dd;
        return json_encode($result);
    }

    public function FetchProcessDrafts()
    {
        $projects = DB::table('hamahang_process')->where('uid', '=', Auth::id())->whereNull('deleted_at')->where('draft', '=', 1)->select('title', 'id', 'status')->get();
        foreach ($projects as $p)
        {
            $p->c_id = enCode($p->id);
            switch ($p->status)
            {
                case 0:
                {
                    $p->status_title = 'ناقص';
                    break;
                }
                case 0:
                {
                    $p->status_title = 'تکمیل';
                    break;
                }
            }

        }
        $dd = collect($projects)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $result['data'] = $dd;
        return json_encode($result);
    }

    public function RemoveProcessTaskRelation()
    {
        hamahang_process_tasks_relations::withTrashed()
            ->where('id', Request::input('r_id'))
            ->delete();
        process::where('id', '=', session('process_id'))->update(['status' => 0]);
        return json_encode('1');
    }

    public function FetchProcessTaskNextTasks($id)
    {
        $next_tasks = DB::table('hamahang_process_tasks_relations')->where('hamahang_process_tasks_relations.task_id', '=', $id)
            ->select('hamahang_process_tasks_relations.id as r_id', 'hamahang_process_task.id', 'hamahang_process_tasks_relations.task_id', 'hamahang_process_task.title')
            ->join('hamahang_process_task', 'hamahang_process_task.id', '=', 'hamahang_process_tasks_relations.next_task_id')
            ->whereNull('hamahang_process_tasks_relations.deleted_at')
            ->where('hamahang_process_tasks_relations.task_id', '=', $id)
            ->get();

        $dd = collect($next_tasks)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $result['data'] = $dd;
        return json_encode($result);
    }

    public function AddNextTask()
    {
        foreach (Request::input('tasks') as $task)
        {
            $rel = new hamahang_process_tasks_relations;
            $rel->process_id = Request::input('pid');
            $rel->uid = Auth::id();
            $rel->user_id = Auth::id();
            $rel->task_id = Request::input('tid');
            $rel->next_task_id = (int)$task;
            $rel->save();
        }
        process::where('id', '=', session('process_id'))->update(['status' => 1]);
        return json_encode('1');
    }

    public function SearchProcessTask($id)
    {
        $constant_process_tasks = process::where('id', '=', session('process_id'))
            ->select('start_task_id', 'end_task_id')
            ->first();
        $arr = [];
        array_push($arr, $constant_process_tasks['start_task_id']);
        array_push($arr, $constant_process_tasks['end_task_id']);
        $t = [];
        $prev_tasks = $this->GetPrevLevelTasks($id);
        $x = Request::input('data');
        $next_tasks = DB::table('hamahang_process_tasks_relations')
            ->where('task_id', '=', $id)
            ->select('next_task_id')
            ->whereNull('deleted_at')
            ->get();
        $exist_tasks = collect($next_tasks)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $exist_prev_tasks = collect($prev_tasks)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $data = process_task::select("id", "title as text")
            ->whereNull('deleted_at')
            ->where("title", "LIKE", "%" . $x['q'] . "%")
            ->where('hamahang_process_task.uid', '=', Auth::id())
            ->where('hamahang_process_task.process_id', '=', session('process_id'))
            ->where('hamahang_process_task.id', '<>', $id)
            ->where('hamahang_process_task.id', '<>', $constant_process_tasks['start_task_id'])
            ->whereNotIn('hamahang_process_task.id', $exist_tasks)
            ->whereNotIn('hamahang_process_task.id', $exist_prev_tasks)
            ->get();

        $data = array('results' => $data);
        return response()->json($data);
    }

    private function GetPrevLevelTasks($id)
    {
        $previous_tasks = DB::table('hamahang_process_tasks_relations')
            ->where('next_task_id', '=', $id)
            ->whereNull('deleted_at')
            ->select('task_id')
            ->get();

        if (sizeof($previous_tasks) > 0)
        {
            foreach ($previous_tasks as $task)
            {
                array_push($this->prev_tasks, $task->task_id);
                //$this->GetPrevLevelTasks($task->task_id);
            }
        }

    }

    public function ProcessTasksFetch($id)
    {
        $constant_process_tasks = process::where('id', '=', $id)
            ->select('start_task_id', 'end_task_id')
            ->first();
        $arr = [];
        array_push($arr, $constant_process_tasks['end_task_id']);
        $data = DB::table('hamahang_process_task')
            ->select('hamahang_process_task.*', 'hamahang_library_task_parent.library_task_id as library')
            ->leftJoin('hamahang_library_task_parent', 'hamahang_library_task_parent.parent_id', '=', 'hamahang_process_task.id')
            //->whereNull('hamahang_library_task_parent.deleted_at')
            //->where('hamahang_library_task_parent.parent_type','=',2)
            ->where('hamahang_process_task.process_id', '=', $id)
            ->where('hamahang_process_task.uid', '=', Auth::id())
            ->whereNull('hamahang_process_task.deleted_at')
            ->whereNotIn('hamahang_process_task.id', $arr)
            ->get();
        //die(var_dump($data));
        $date = new jDateTime;
        date_default_timezone_set('Asia/Tehran');
        foreach ($data as $d)
        {
            if ($d->library == null)
            {
                $d->library = 0;
            }
            else
            {
                $d->library = 1;
            }
            $d->next_tasks = DB::table('hamahang_process_tasks_relations')
                ->join('hamahang_process_task', 'hamahang_process_task.id', '=', 'hamahang_process_tasks_relations.next_task_id')
                ->where('hamahang_process_tasks_relations.task_id', '=', $d->id)
                ->whereNull('hamahang_process_tasks_relations.deleted_at')
                ->select('hamahang_process_task.title')
                ->get();
            if ($d->id == $constant_process_tasks['start_task_id'])
            {
                $d->title = 'نقطه آغاز (پیش فرض)';
            }
            $d->employee_name = "تعیین نشده";
            if ($d->users != '' && (int)unserialize($d->users)[0] > 0)
            {
                $employee_name = DB::table('user')
                    ->where('id', '=', (int)unserialize($d->users)[0])
                    ->select(DB::raw("CONCAT(Name,' ', Family) AS responsible_name"))
                    ->get();

                $d->employee_name = $employee_name[0]->responsible_name;
            }
        }
        $data1 = collect($data)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $result['data'] = $data1;
        return json_encode($result);
    }

    public function UserProcess()
    {

        $x = Request::input('data');
        $data = DB::table('hamahang_process')->select("id as id", "title")->where("title", "LIKE", "%" . $x['q'] . "%")->where('uid', '=', Auth::id())->get();
        foreach ($data as $t)
        {
            $t->text = $t->title;
        }
        $data = array('results' => $data);
        return response()->json($data);

    }

    public function ProcessInfo()
    {
        session(['process_id' => Request::input('pid')]);
        $arr = [];
        $process_info = process::where('hamahang_process.id', '=', Request::input('pid'))
            ->select('hamahang_process.type', 'hamahang_process.title', 'hamahang_process.description', 'hamahang_process.org_unit', 'hamahang_process.responsible')
            ->first();
        $process_info->responsible_name = '';
//        if ($process_info->responsible > 0)
//        {
            $process_responsible_name = DB::table('user')
                ->where('id', '=', $process_info->responsible)
                ->select(DB::raw("CONCAT(Name,' ', Family) AS name"))
                ->first();
            $process_info->responsible_name = $process_responsible_name->name;
//        }
        array_push($arr, $process_info);
        $process_levels = DB::table('hamahang_process_tasks_relations')
            ->join('hamahang_process_task', 'hamahang_process_task.process_id', '=', 'hamahang_process_tasks_relations.task_id')
            ->where('hamahang_process_task.process_id', '=', Request::input('pid'))
            ->whereNull('hamahang_process_tasks_relations.deleted_at')
            ->distinct('nest_task_id')->count('next_task_id');
        array_push($arr, $process_levels);

        $process_keywords = DB::table('hamahang_process_keyword')
            ->where('hamahang_process_keyword.process_id', '=', Request::input('pid'))
            ->join('keywords', 'keywords.id', '=', 'hamahang_process_keyword.keyword_id')
            ->whereNull('hamahang_process_keyword.deleted_at')
            ->select('hamahang_process_keyword.keyword_id')
            ->get();
        array_push($arr, $process_keywords);
//        DB::enableQueryLog();//        die(dd(DB::getQueryLog()));
        $pages = DB::table('hamahang_subject_ables')
            ->where('item_id', '=', Request::input('pid'))
            ->where('hamahang_subject_ables.target_type','=','App\\Models\\Hamahang\\Tasks\\task_process')
            ->whereNull('hamahang_subject_ables.deleted_at')
            ->join('subjects', 'subjects.id', '=', 'hamahang_subject_ables.subject_id')
            ->select('subjects.title','pages.sid')
            ->get();
        $page_arr = [];
        foreach ($pages as $page)
        {
            array_push($page_arr,['id' => $page->sid ] ,[ 'title' => $page->title]);
        }
        $subjects = DB::table('subjects')
            ->join('pages','pages.sid','=','subjects.id')
            ->whereIn('subjects.id',$page_arr)
            ->select('subjects.title','pages.id')
            ->get();
//        array_push($arr,['pages' => $subjects ]);
        array_push($arr,['pages' => $page_arr ]);
        return json_encode($arr);
    }

    public function SaveNewProcess()
    {
        $result = [];
        if (Request::input('save_type') == 0)
        {
            $validator = Validator::make(Request::all(), [
                'p_title' => 'required'
            ]);
        }
        else
        {
            $validator = Validator::make(Request::all(), [
                'p_title' => 'required',
                'p_type' => 'required',
                'p_org_unit' => 'required',
                'p_page' => 'required',
                'save_type' => 'required',
                //'p_responsible' => 'required'
                //'htype' => 'required|in:1,2,3',
            ]);
        }
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            DB::transaction(function ($uname)
            {
                $process = new process;
                $process->uid = Auth::id();
                $process->title = Request::input('p_title');
                $process->type = Request::input('p_type');
                $process->description = Request::input('p_desc');
                $process->responsible = Request::input('p_responsible')[0];
                $process->org_unit = Request::input('p_org_unitx');
                if (Request::input('save_type') == 0)
                {
                    $process->draft = 1;
                }
                else
                {
                    $process->draft = 0;
                }
                $process->save();
                $keywords = Request::input('p_keyword');
                $keywords = explode(',', $keywords);
                if (count($keywords) > 0)
                {
                    foreach ($keywords as $kw)
                    {
                        process_keyword::assign_process_keyword(hamahang_add_keyword($kw), $process->id);
                    }
                }

                $task1 = new process_task;
                $task1->process_id = $process->id;
                $task1->title = 'START';
                $task1->uid = Auth::id();
                $task1->save();

                $task2 = new process_task;
                $task2->process_id = $process->id;
                $task2->title = 'END';
                $task2->uid = Auth::id();
                $task2->save();

                process::where('id', $process->id)
                    ->update(['start_task_id' => $task1->id, 'end_task_id' => $task2->id]);
                if (count(Request::input('p_page')) > 0)
                {
                    foreach (Request::input('p_page') as $page_id)
                    {
                        hamahang_subject_ables::create_items_page($page_id, $process->id,'App\Models\Hamahang\Tasks\task_process');
                    }
                }
            });
            $result['success'] = true;
            return json_encode($result);
        }

    }

    public function Create($uname)
    {
        $arr = variable_generator('user','desktop',$uname);
        return view('hamahang.Tasks.process', $arr);
    }
}
