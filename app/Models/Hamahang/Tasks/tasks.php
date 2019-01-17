<?php

namespace App\Models\Hamahang\Tasks;

use App\HamafzaViewClasses\TaskClass;
use App\Models\Hamahang\keywords;
use DB;
use Auth;
use Request;
use App\HamahangCustomClasses\jDateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tasks extends Model
{
    use SoftDeletes;
    protected $table = 'hamahang_task';
    protected $dates = ['deleted_at'];

    public static function FetchDraftsTasks()
    {
        $total = DB::table('hamahang_task')
            ->whereNull('hamahang_task.deleted_at')
            ->where('hamahang_task.uid', '=', Auth::id())
            ->where('hamahang_task.is_save', '=', 0)
            ->select('hamahang_task.form_data as title', 'hamahang_task.id as id', 'hamahang_task.created_at as cr')
            ->get();

        foreach ($total as $draft)
        {
            //die(var_dump(unserialize($draft->title)));
            $draft->title = unserialize($draft->title)['title'];
        }
        return $total;
    }

    public static function DraftTaskInfo($id)
    {
        $total = DB::table('hamahang_task')
            ->whereNull('hamahang_task.deleted_at')
            ->where('hamahang_task.uid', '=', Auth::id())
            ->where('hamahang_task.id', '=', $id)
            ->first();

        return $total;
    }
    public static function ScheduleTaskCopy($relation_id, $schedule_time = 0)
    {
        $relation_targetid_res = DB::table('schedule_relations')->where('id', '=', $relation_id)->first();
        if ($relation_targetid_res)
        {
            $relation_targetid = $relation_targetid_res->id;
            $OrigTask = DB::table('hamahang_task')->where('id', '=', $relation_targetid)->first();
            $Orig_Task = unserialize($OrigTask->form_data);
            $task = tasks::CreateNewTask($OrigTask->form_data, $OrigTask->title, $OrigTask->desc, $OrigTask->type, $OrigTask->duration_timestamp, $OrigTask->use_type, $OrigTask->end_on_assigner_accept, $OrigTask->transferable, $OrigTask->report_on_create_point, $OrigTask->report_on_completion_point, $OrigTask->report_to_managers, $relation_id, $schedule_time);
            $assignment = task_assignments::create_task_assignment($Orig_Task['users'][0], $task->id);
            $status = task_status::create_task_status($task->id, 0, 0);
            $priority = task_priority::create_task_priority($task->id, $Orig_Task['immediate'], $Orig_Task['importance']);
            return $task->id;
        }
        return false;
    }

    public static function SaveTask($title, $type, $desc, $report_to_manager, $respite_timestamp, $predicted_time, $end_on_assigner_accept, $transferable, $report_on_cr, $report_on_co)
    {
        $task = new tasks;
        $task->title = $title;
        $task->type = $type;
        $task->desc = $desc;
        $task->uid = Auth::id();
        $task->report_to_managers = $report_to_manager;
        $task->respite = $respite_timestamp;
        $task->predicted_time = $predicted_time;
        $task->end_on_assigner_accept = $end_on_assigner_accept;
        $task->transferable = $transferable;
        $task->respite = $respite_timestamp;
        if ($report_on_cr == true)
        {
            $task->report_on_create_point = 1;
        }
        if ($report_on_co == true)
        {
            $task->report_on_completion_point = 1;
        }
        $task->save();
    }

    public static function FetchTasksForMyTasksState($filter_subject_id = false)
    {
        $tasks = tasks::select('hamahang_task.id', 'duration_timestamp', 'hamahang_task_assignments.id as assid', 'title', 'type', 'hamahang_task.created_at as created', 'employee_id')
            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
            ->join('hamahang_task_assignments', 'hamahang_task_assignments.task_id', '=', 'hamahang_task.id')
            ->where('hamahang_task_assignments.transmitter_id', '=', null)
            ->where('hamahang_task_assignments.employee_id', '=', Auth::id())
            ->whereNull('hamahang_task_assignments.reject_description')
            ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )');

        if ($filter_subject_id != false)
        {
            $tasks->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\tasks')
                ->whereNull('hamahang_subject_ables.deleted_at');
        }

        $tasks = $tasks->get();
        date_default_timezone_set('Asia/Tehran');
        foreach ($tasks AS $task)
        {
            $task->respite_days = hamahang_respite_remain(strtotime($task->created), $task->duration_timestamp);
            if ($task->respite_days[0]['delayed'] == 1)
            {
                $task->respite_days = ($task->respite_days[0]['day_no']) * (-1);
            }
            else
            {
                $task->respite_days = $task->respite_days[0]['day_no'];
            }
            $user_name = task_assignments::select('user.name AS user_name', 'employee_id', 'Pic')
                ->join('user', 'hamahang_task_assignments.employee_id', '=', 'user.id')
                ->where('hamahang_task_assignments.task_id', '=', $task->id)
                ->first();
            $task->user_name = $user_name['user_name'];
            $task->Pic = $user_name['Pic'];
        }
        return $tasks;
    }

    public static function FetchTasksForMyTasksPriority($filter_subject_id = false)
    {
        $tasks = tasks::select('hamahang_task.id', 'title', 'duration_timestamp', 'hamahang_task_priority.importance', 'hamahang_task_priority.immediate', 'hamahang_task.created_at as created', 'type')
            ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
            ->join('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
            ->where('hamahang_task_assignments.transmitter_id', '=', null)
            ->where('hamahang_task_assignments.reject_description')
            ->where('hamahang_task_priority.user_id', '=', Auth::id())
            ->whereRaw('`hamahang_task_priority`.`timestamp` = (select max(`timestamp`) from hamahang_task_priority where `task_id` = hamahang_task.id and `hamahang_task_priority`.`user_id`= ?)',
                [Auth::id()])
            ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
            ->where('hamahang_task_assignments.employee_id', '=', Auth::id());
        $tasks->where(function ($query)
        {
            $query->where('hamahang_task_status.type', '=', 0)
                ->orwhere('hamahang_task_status.type', '=', 1);

        });
        if ($filter_subject_id != false)
        {
            $tasks->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\tasks')
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $x = $tasks->get();
        date_default_timezone_set('Asia/Tehran');
        foreach ($x AS $task)
        {
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
        return $x;
    }

    public static function FetchTasksForMyAssignedTasksPriority($filter_subject_id = false)
    {
        $tasks = tasks::select('hamahang_task.id', 'title', 'duration_timestamp', 'hamahang_task_priority.importance', 'hamahang_task_priority.immediate', 'type', 'hamahang_task.created_at as created')
            ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
            ->join('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
            ->where('hamahang_task_assignments.transmitter_id', '=', null)
            ->where('hamahang_task_priority.user_id', '=', Auth::id())
            ->whereRaw('`hamahang_task_priority`.`id` = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id and hamahang_task_priority.`deleted_at` is Null and 
            `hamahang_task_priority`
            .`user_id`= ?)',
                [Auth::id()])
            ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
            ->where('hamahang_task.uid', '=', Auth::id());
        $tasks->where(function ($query)
        {

            $query->where('hamahang_task_status.type', '=', 0)
                ->orwhere('hamahang_task_status.type', '=', 1);

        });
        if ($filter_subject_id != false)
        {
            $tasks->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\tasks')
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $x = $tasks->get();
        date_default_timezone_set('Asia/Tehran');
        foreach ($x AS $task)
        {
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
        return $x;
    }

    public static function FetchTasksForMyAssignedTasksState($filter_subject_id = false)
    {
        date_default_timezone_set('Asia/Tehran');
        $tasks = tasks::select('hamahang_task.id', 'title', 'duration_timestamp', 'hamahang_task.created_at as created', 'type', 'employee_id')
            ->join('hamahang_task_assignments', 'hamahang_task_assignments.task_id', '=', 'hamahang_task.id')
            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
            ->where('hamahang_task_assignments.assigner_id', '=', Auth::id())
            ->where('hamahang_task_assignments.transmitter_id', '=', null)
            ->whereNull('hamahang_task.deleted_at')
            ->whereRaw('`hamahang_task_status`.`timestamp` = (select max(`timestamp`) from hamahang_task_status where hamahang_task_status.task_id = hamahang_task.id )');
        if ($filter_subject_id != false)
        {
            $tasks->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\tasks')
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $tasks = $tasks->get();
        foreach ($tasks AS $task)
        {
            $task->respite_days = hamahang_respite_remain(strtotime($task->created), $task->duration_timestamp);
            if ($task->respite_days[0]['delayed'] == 1)
            {
                $task->respite_days = ($task->respite_days[0]['day_no']) * (-1);
            }
            else
            {
                $task->respite_days = $task->respite_days[0]['day_no'];
            }
            $user_name = task_assignments::select('user.name AS user_name', 'employee_id')
                ->join('user', 'hamahang_task_assignments.employee_id', '=', 'user.id')
                ->where('hamahang_task_assignments.task_id', '=', $task->id)
                ->first();
            $task->user_name = $user_name['user_name'];
        }
        return $tasks;

    }

    public static function TaskInfo($task_id)
    {
        $date = new jDateTime();
        date_default_timezone_set('Asia/Tehran');
        $task_info = DB::table('hamahang_task_assignments')
            ->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
            ->select('hamahang_task.*', 'duration_timestamp', 'hamahang_task_assignments.assigner_id', DB::raw('unix_timestamp(hamahang_task.created_at) as created'))
            ->where('hamahang_task.id', $task_id)
            ->get();

        $r = $date->getdate($task_info[0]->duration_timestamp + $task_info[0]->created);
        $task_info[0]->respite_day = $r['year'] . '/' . $r['mon'] . '/' . $r['mday'];


        $keyword = DB::table('hamahang_task_keywords')
            ->join('keywords', 'hamahang_task_keywords.id', '=', 'keywords.id')
            ->select('title')//->where('hamahang_task_assignments.assigner_id','=','hamahang_task_keywords.uid')
            ->where('hamahang_task_keywords.task_id', $task_info[0]->id)->get();
        $arr1 = [];
        if (sizeof($keyword) > 0)
        {
            foreach ($keyword as $kw)
            {
                array_push($arr1, $kw->title);
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
                array_push($arr12, [$Mykw->id, $Mykw->title]);
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
            $follow_up = DB::table('hamahang_task_follow_up')->join('user', 'hamahang_task_follow_up.uid', '=', 'user.id')->where('hamahang_task_follow_up.assign_id', $task_id)->select('user.Name as uname', 'user.Family as fname', 'hamahang_task_follow_up.*', 'user.Pic')->orderBy('hamahang_task_follow_up.timestamp', 'Desc')->get();
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
            //$st->timestamp = $date->date("Y-m-d", $st->timestamp);
            $st->timestamp = $date->date("Y-m-d", time());
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

        $file = DB::table('hamahang_files')
            ->join('hamahang_task_files', 'hamahang_task_files.file_id', 'hamahang_files.id')
            ->where('hamahang_task_files.task_id', '=', $task_info[0]->id)
            ->get();
        $arr8 = [];
        foreach ($file as $f)
        {
            array_push($arr8, $f);
        }
        $task_info[0]->files = $arr8;
        $arr9 = [];
        $history = DB::table('hamahang_task_log')
            ->where('task_id', '=', $task_info[0]->id)
            ->orderBy('timestamp', 'DESC')
            ->get();
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
                    $user = DB::table('user')
                        ->where('id', '=', $h->uid)
                        ->select('Name', 'Family')
                        ->first();
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
//        DB::enableQueryLog();


//        $progress = task_inheritance::where('parent_task_id', $task_info[0]->id)
//            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task_inheritance.task_id')
//            ->whereNull('hamahang_task_inheritance.deleted_at')
//            ->select('hamahang_task_inheritance.id', 'hamahang_task_inheritance.task_id', 'weight', 'parent_task_id', 'percent')
//            ->get();
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
        return $x;
    }

    public static function CreateNewTask($serialize ,$title ,$task_form_action ,$desc ,$task_type, $task_kind, $task_status, $duration_timestamp, $use_type, $end_on_assigner_accept = 0, $transferable = 0, $creation_report = 0, $completion_report = 0, $report_to_managers = 0, $respite_timing_type , $schedule_id = 0, $schedule_time = 0)
    {
        $task = new tasks;
        $task->form_data = $serialize;
        $task->task_attributes = $serialize;
        $task->uid = Auth::id();
        $task->title = $title;
        $task->desc = $desc;
        $task->type = $task_type;
        $task->kind = $task_kind;
        $task->is_save = $task_form_action;
        $task->task_status = $task_status;
        $task->duration_timestamp = $duration_timestamp;
        $task->use_type = $use_type;
        $task->end_on_assigner_accept = $end_on_assigner_accept;
        $task->transferable = $transferable;
        $task->report_on_create_point = $creation_report;
        $task->report_on_completion_point = $completion_report;
        $task->report_to_managers = $report_to_managers;
        $task->respite_timing_type = $respite_timing_type;
        $task->schedule_id = $schedule_id;
        $task->schedule_time = ($schedule_time == 0)?date('Y-m-d H:i:s'): $schedule_time;
        $task->save();
        return $task;
    }

    public static function MyTasks($subject_id = false, $user_id = false, $justCount = false)
    {
        if ($user_id)
        {
            $uid = $user_id;
        }
        else
        {
            $uid = Auth::id();
        }
//        if ($api)
//        {
//            $result = DB::table('hamahang_task')
//                ->select("hamahang_task.id AS task_id", "hamahang_task.use_type", "hamahang_task.duration_timestamp", "hamahang_task.created_at", DB::raw("CAST( hamahang_task_status.type AS CHAR ) AS type"), DB::raw('CONCAT("user.Name"," ","user.Family") AS employee'), 'user.Pic AS employee_pic', "hamahang_task.id", "hamahang_task.title", "hamahang_task_priority.immediate", "hamahang_task_priority.importance")
//                ->join('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
//                ->join('user', 'user.id', '=', 'hamahang_task_assignments.assigner_id')
//                ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
//                ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
//                ->whereNull('hamahang_task_assignments.transmitter_id')
//                ->where('hamahang_task_assignments.employee_id', '=', $uid)
//                ->whereNull('hamahang_task_assignments.reject_description')
//                ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
//                ->whereRaw('hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id and user_id = ?)', [$uid]);
//
//            $result = DB::table('hamahang_task')
//                ->select("hamahang_task.id AS task_id", "hamahang_task.use_type", "hamahang_task.duration_timestamp", "hamahang_task.created_at", DB::raw("CAST( hamahang_task_status.type AS CHAR ) AS type"), DB::raw('CONCAT("user.Name"," ","user.Family") AS employee'), 'user.Pic AS employee_pic', "hamahang_task.id", "hamahang_task.title", "hamahang_task_priority.immediate", "hamahang_task_priority.importance")
//                ->join('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
//                ->join('user', 'user.id', '=', 'hamahang_task_assignments.assigner_id')
//                ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
//                ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
//                ->whereNull('hamahang_task_assignments.transmitter_id')
//                ->where('hamahang_task_assignments.employee_id', '=', $uid)
//                ->whereNull('hamahang_task_assignments.reject_description')
//                ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
//                ->whereRaw('hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id and user_id = ?)', [$uid]);
//            if ($subject_id)
//            {
//                $result->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
//                    ->where('hamahang_subject_ables.subject_id', '=',$subject_id)
//                    ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\tasks')
//                    ->whereNull('hamahang_subject_ables.deleted_at');
//            }
//            $result = $result->get();
//        }
//        else
//        {
//            $result = DB::table('hamahang_task')
//                ->select("hamahang_task.schedule_time", "hamahang_task.schedule_id", "hamahang_task.use_type", "hamahang_task.duration_timestamp", "hamahang_task.created_at", "hamahang_task_status.type", "user.Uname", "user.Name", "user.Family", "hamahang_task.id", "hamahang_task.title", "hamahang_task_priority.immediate", "hamahang_task_priority.importance")
//                ->join('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
//                ->join('user', 'user.id', '=', 'hamahang_task_assignments.assigner_id')
//                ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
//                ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
//                ->whereNull('hamahang_task_assignments.transmitter_id')
//                ->whereNull('hamahang_task_assignments.reject_description')
//                ->where('hamahang_task_assignments.employee_id', '=', $uid)
//                ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
//                ->whereRaw('hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id and user_id = ?)', [$uid]);
//            if ($subject_id)
//            {
//                $result->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
//                    ->where('hamahang_subject_ables.subject_id', '=',$subject_id)
//                    ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\tasks')
//                    ->whereNull('hamahang_subject_ables.deleted_at');
//            }
//            $result = $result->get();
//            //d($result4);
//        }
//        DB::enableQueryLog();

        $result = DB::table('hamahang_task')
            ->select("hamahang_task_assignments.id as assignment_id","hamahang_task_assignments.assignment as assignment_assignment","hamahang_task_assignments.created_at as assignment_created_at","hamahang_task_status.type as task_status","hamahang_task.schedule_time", "hamahang_task.schedule_id", "hamahang_task.use_type", "hamahang_task.duration_timestamp", "hamahang_task.created_at", "user.Uname", "user.Name", "user.Family", DB::raw('CONCAT("user.Name"," ","user.Family") AS employee'), "hamahang_task.id", "hamahang_task.title", "hamahang_task_priority.immediate", "hamahang_task_priority.importance")
            ->join('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
            ->join('user', 'user.id', '=', 'hamahang_task_assignments.uid')
            ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
            //->whereNull('hamahang_task_assignments.transmitter_id')
            ->where('hamahang_task_assignments.employee_id', '=', $uid)
//            ->where('hamahang_task_assignments.status', '=', 0)
//            ->whereNull('hamahang_task_assignments.reject_description')
            ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
            ->whereRaw('hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id)')
//            ->toSql()
        ;
        if ($subject_id)
        {
            $result->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',($subject_id > 99999 ? $subject_id/10 : $subject_id))
                ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\tasks')
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        if ($justCount){
            return count($result->groupBy('hamahang_task.id')->get());
        }
        $title = Request::get('title');
        $status_filter = Request::get('task_status');
        $official_type = Request::get('official_type');
        $important = Request::get('task_important');
        $immediate = Request::get('task_immediate');

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
        else if (!$user_id)
        {
            $result->whereIn('hamahang_task.type', [11]);
        }

        if ($status_filter)
        {
            $result->whereIn('hamahang_task_status.type', $status_filter)
                ->whereNull('hamahang_task_status.deleted_at');
        }
        else if (!$user_id)
        {
            $result->whereIn('hamahang_task_status.type', [11]);
        }

        $task_important_immediate = Request::input('task_important_immediate');
        if(is_array(Request::input('task_important_immediate'))){
            $result->where(function($q) use ($task_important_immediate) {
                foreach($task_important_immediate as $Atask_important_immediate)
                {
                    if($Atask_important_immediate == 0)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });

                    }else if($Atask_important_immediate == 1)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 2)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 3)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }
                }
            });
        }
//        if ($immediate)
//        {
//            $result->whereIn('hamahang_task_priority.immediate', $immediate)
//                ->whereNull('hamahang_task_priority.deleted_at');
////            dd($immediate);
//        }
//        else if (!$user_id)
//        {
//            $result->whereIn('hamahang_task_priority.immediate', [11]);
//        }
//
//        if ($important)
//        {
//            $result->whereIn('hamahang_task_priority.importance', $important)
//                ->whereNull('hamahang_task_priority.deleted_at');
////            dd($important);
//        }
//        else if (!$user_id)
//        {
//            $result->whereIn('hamahang_task_priority.importance', [11]);
//        }

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

        $result = $result->groupBy('hamahang_task.id')->orderBy('hamahang_task.id', 'DESC')->get();
        return $result;
    }
    public static function AllTasksList($subject_id = false, $user_id = false, $api = false)
    {
        if ($user_id)
        {
            $uid = $user_id;
        }
        else
        {
            $uid = Auth::id();
        }

        $result = DB::table('hamahang_task')
            ->select("hamahang_task_assignments.id as assignment_id","hamahang_task_status.type as task_status","hamahang_task.schedule_time", "hamahang_task.schedule_id", "hamahang_task.use_type", "hamahang_task.duration_timestamp", "hamahang_task.created_at", "user.Uname", "user.Name", "user.Family", DB::raw('CONCAT("user.Name"," ","user.Family") AS employee'), "hamahang_task.id", "hamahang_task.title", "hamahang_task_priority.immediate", "hamahang_task_priority.importance")
            ->join('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
            ->join('user', 'user.id', '=', 'hamahang_task_assignments.uid')
            ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
            //->whereNull('hamahang_task_assignments.transmitter_id')
            ->where('hamahang_task_assignments.employee_id', '=', $uid)
            ->where('hamahang_task_assignments.status', '=', 0)
            ->whereNull('hamahang_task_assignments.reject_description')
            ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
            ->whereRaw('hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id)')
        ;
        if ($subject_id)
        {
            $result->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$subject_id)
                ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\tasks')
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        $status_filter = Request::get('task_status');
        $official_type = Request::get('official_type');
        $important = Request::get('task_important');
        $immediate = Request::get('task_immediate');
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
        }
        else
        {
            $result->whereIn('hamahang_task_priority.immediate', [11]);
        }

        if ($important)
        {
            $result->whereIn('hamahang_task_priority.importance', $important)
                ->whereNull('hamahang_task_priority.deleted_at');
        }
        else
        {
            $result->whereIn('hamahang_task_priority.importance', [11]);
        }

        $result = $result->get();
        return $result;
    }
    
    public static function MyTasksSummary($uid, $time)
    {
               
        $result = DB::table('hamahang_task')
            ->select("hamahang_task_status.type as task_status","hamahang_task.title", "hamahang_task_priority.immediate", "hamahang_task_priority.importance","hamahang_task.duration_timestamp","hamahang_task.schedule_time")
            ->join('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
            ->join('user', 'user.id', '=', 'hamahang_task_assignments.uid')
            ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
            ->join('hamahang_calendar_events_task', 'hamahang_calendar_events_task.task_id', '=', 'hamahang_task.id')
            ->join('hamahang_calendar_user_events', 'hamahang_calendar_events_task.event_id', '=', 'hamahang_calendar_user_events.id')
          
            ->where('hamahang_task_assignments.employee_id', '=', $uid)
            ->where('hamahang_task_assignments.status', '=', 0)
            ->whereRaw('UNIX_TIMESTAMP(hamahang_calendar_user_events.startdate) <'.($time + 86399))
           ->whereRaw('UNIX_TIMESTAMP(hamahang_calendar_user_events.enddate) >'.$time)
          
            ->whereNull('hamahang_task_assignments.reject_description')
            ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
            ->whereRaw('hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id and user_id = ?)', [$uid])
            ->get();//
        return $result;
    }

    public static function ListAllAssignedTasks($user_id = false, $subject_id = false, $api = false)
    {
        $status_filter = Request::get('task_status');
        $official_type = Request::get('official_type');
        $important = Request::get('task_important');
        $immediate = Request::get('task_immediate');

        $title = Request::get('title');
        $filter_subject_id = Request::get('subject_id');
        $result = DB::table('hamahang_task')
            ->select("hamahang_task_assignments.id as assignment_id","hamahang_task.schedule_id", "hamahang_task.schedule_time", "hamahang_task.use_type", "hamahang_task_status.type", "to.Uname as t_uname", "to.Name as t_name", "to.Family as t_family", "from.Uname as f_uname", "from.Name as f_name", "from.Family as f_family", "to.Uname", "to.Name", "to.Family", "hamahang_task.id", "hamahang_task.title", "hamahang_task_priority.immediate", "hamahang_task_priority.importance", "hamahang_task.created_at", "hamahang_task.duration_timestamp")
            ->join('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
            ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
            ->leftjoin('user as to', 'to.id', '=', 'hamahang_task_assignments.employee_id')
            ->leftjoin('user as from', 'from.id', '=', 'hamahang_task_assignments.uid')
            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
            ->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
            ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
            ->whereNull('hamahang_subject_ables.deleted_at');
        ;
        $result->whereRaw('( hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id ) AND hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id)) ');

        if ($title)
        {
            $result->where('hamahang_task.title', 'like', '%'.$title.'%');
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
                $result->join('hamahang_task_keywords', 'hamahang_task_keywords.task_id', '=', 'hamahang_task.id')
                    ->whereIn('hamahang_task_keywords.keyword_id', $search_task_keywords);
            }
        }
        if(Request::exists('users'))
        {
            $result->where(function ($result) {
                $result
                    ->whereIn('hamahang_task.uid', Request::input('users'))
                    ->orWhereIn('hamahang_task_assignments.uid', Request::input('users'))
                    ->orWhereIn('hamahang_task_assignments.assigner_id', Request::input('users'))
                    ->orWhereIn('hamahang_task_assignments.employee_id', Request::input('users'));
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
        else{
            $result->whereIn('hamahang_task_status.type', [11]);
        }

        $task_important_immediate = Request::input('task_important_immediate');
        if(is_array(Request::input('task_important_immediate'))){
            $result->where(function($q) use ($task_important_immediate) {
                foreach($task_important_immediate as $Atask_important_immediate)
                {
                    if($Atask_important_immediate == 0)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });

                    }else if($Atask_important_immediate == 1)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 2)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 3)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }
                }
            });
        }

        $result = $result->groupBy('hamahang_task.id')->get();
        return $result;
    }

    public static function MyTranscriptsTasks($user_id = false, $subject_id = false, $api = false)
    {
        if ($user_id)
        {
            $uid = $user_id;
        }
        else
        {
            $uid = Auth::id();
        }
        $task_final = Request::get('task_final');
        $result = DB::table('hamahang_task')
            ->select("hamahang_task_assignments.id as assignment_id","hamahang_task.schedule_id", "hamahang_task.schedule_time", "hamahang_task.use_type", "hamahang_task_status.type", "user.Uname", "user.Name", "user.Family", "hamahang_task.id", "hamahang_task.title", "hamahang_task_priority.immediate", "hamahang_task_priority.importance", "hamahang_task.created_at", "hamahang_task.duration_timestamp")
            ->leftjoin('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
            ->leftjoin('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
            ->leftjoin('user', 'user.id', '=', 'hamahang_task_assignments.employee_id')
            ->leftjoin('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
            ->leftjoin('hamahang_task_transcript', 'hamahang_task_transcript.task_id', '=', 'hamahang_task.id')
            ->where('hamahang_task_transcript.user_id', '=', $uid)
            ->groupBy('hamahang_task_transcript.id');

        $status_filter = Request::get('task_status');
        $official_type = Request::get('official_type');
        $filter_subject_id = Request::get('filter_subject_id');
        $title = Request::exists('title') ? Request::input('title') : '';
        if (trim($title))
        {
            $result->where('hamahang_task.title', 'like', '%'.$title.'%');
        }

        if (isset($filter_subject_id))
        {
            if (trim($filter_subject_id)!='')
            {
                $result = $result->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                    ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                    ->whereNull('hamahang_subject_ables.deleted_at');
            }
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
//                $result->whereIn('hamahang_task_status.type', [11]);
        }
        $task_important_immediate = Request::input('task_important_immediate');
        if(is_array(Request::input('task_important_immediate'))){
            $result->where(function($q) use ($task_important_immediate) {
                foreach($task_important_immediate as $Atask_important_immediate)
                {
                    if($Atask_important_immediate == 0)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });

                    }else if($Atask_important_immediate == 1)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 2)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 3)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }
                }
            });
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
        return $result;
    }

    public static function MyAssignedTasks($user_id = false, $subject_id = false, $api = false)
    {
        if ($user_id)
        {
            $uid = $user_id;
        }
        else
        {
            $uid = Auth::id();
        }

        if ($api)
        {
            $result = DB::table('hamahang_task')
//                ->select("hamahang_task_assignments.id as assignment_id","hamahang_task_status.type as task_status","hamahang_task.schedule_time", "hamahang_task.schedule_id", "hamahang_task.use_type", "hamahang_task.duration_timestamp", "hamahang_task.created_at", "user.Uname", "user.Name", "user.Family", DB::raw('CONCAT("user.Name"," ","user.Family") AS employee'), "hamahang_task.id", "hamahang_task.title", "hamahang_task_priority.immediate", "hamahang_task_priority.importance")
                ->select("hamahang_task_assignments.id as assignment_id","hamahang_task.create_at as create_at","hamahang_task.schedule_id", "hamahang_task.schedule_time", "hamahang_task.use_type", "hamahang_task_status.type", "user.Uname", "user.Name", "user.Family", "hamahang_task.id", "hamahang_task.title", "hamahang_task_priority.immediate", "hamahang_task_priority.importance", "hamahang_task.created_at", "hamahang_task.duration_timestamp")
                ->join('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
                ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
                ->join('user', 'user.id', '=', 'hamahang_task_assignments.employee_id')
                ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
//                ->whereNull('hamahang_task_assignments.transmitter_id')
//                ->where('hamahang_task_assignments.status','=',0)
                ->where('hamahang_task_assignments.uid', '=', $uid)
                ->whereNull('hamahang_task_assignments.deleted_at')
                ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
                ->whereRaw('hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id and user_id = ?)', [Auth::id()]);
            if ($subject_id)
            {
                $result->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                    ->whereNull('hamahang_subject_ables.deleted_at')
                    ->where('hamahang_subject_ables.subject_id', '=', $subject_id)
                    ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\tasks');
            }
            $result = $result->get();
        }
        else
        {
//            db::enableQueryLog();
//            dd(Request::all());
            $task_important_immediate = Request::input('task_important_immediate');
            $task_final[] = 1;
            if(in_array('10',Request::input('task_status')))
            {
                $task_final[] = 0;
            }
            $result = DB::table('hamahang_task')
                ->select("hamahang_task_assignments.id as assignment_id","hamahang_task.schedule_id", "hamahang_task.schedule_time", "hamahang_task.use_type", "hamahang_task_status.type", "user.Uname", "user.Name", "user.Family", "hamahang_task.id", "hamahang_task.title", "hamahang_task_priority.immediate", "hamahang_task_priority.importance", "hamahang_task.created_at", "hamahang_task.duration_timestamp")
                ->leftjoin('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
                ->leftjoin('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
                ->leftjoin('user', 'user.id', '=', 'hamahang_task_assignments.employee_id')
                ->leftjoin('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
                ->whereNull('hamahang_task_assignments.deleted_at')
                ->where('hamahang_task.uid', '=', $uid);
            $title = Request::exists('title') ? Request::input('title') : '';
            if (trim($title))
            {
                $result->where('hamahang_task.title', 'like', '%'.$title.'%');
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
                    $result->join('hamahang_task_keywords', 'hamahang_task_keywords.task_id', '=', 'hamahang_task.id')
                        ->whereIn('hamahang_task_keywords.keyword_id', $search_task_keywords);
                }
            }
            if(Request::exists('users'))
            {
                $result->where(function ($result) {
                    $result
                        ->whereIn('hamahang_task.uid', Request::input('users'))
                        ->orWhereIn('hamahang_task_assignments.uid', Request::input('users'))
                        ->orWhereIn('hamahang_task_assignments.assigner_id', Request::input('users'))
                        ->orWhereIn('hamahang_task_assignments.employee_id', Request::input('users'));
                });
            }

            $status_filter = Request::get('task_status');
            $official_type = Request::get('official_type');

            $filter_subject_id = Request::get('filter_subject_id');

            if(is_array(Request::input('task_important_immediate'))){
                $result->where(function($q) use ($task_important_immediate) {
                    foreach($task_important_immediate as $Atask_important_immediate)
                    {
                        if($Atask_important_immediate == 0)
                        {
                            $q->orWhere(function($q) {
                                $q->where('hamahang_task_priority.immediate', 0)
                                    ->whereNull('hamahang_task_priority.deleted_at')
                                    ->where('hamahang_task_priority.importance', 0)
                                    ->whereNull('hamahang_task_priority.deleted_at');
                            });

                        }else if($Atask_important_immediate == 1)
                        {
                            $q->orWhere(function($q) {
                                $q->where('hamahang_task_priority.immediate', 1)
                                    ->whereNull('hamahang_task_priority.deleted_at')
                                    ->where('hamahang_task_priority.importance', 0)
                                    ->whereNull('hamahang_task_priority.deleted_at');
                            });
                        }else if($Atask_important_immediate == 2)
                        {
                            $q->orWhere(function($q) {
                                $q->where('hamahang_task_priority.immediate', 0)
                                    ->whereNull('hamahang_task_priority.deleted_at')
                                    ->where('hamahang_task_priority.importance', 1)
                                    ->whereNull('hamahang_task_priority.deleted_at');
                            });
                        }else if($Atask_important_immediate == 3)
                        {
                            $q->orWhere(function($q) {
                                $q->where('hamahang_task_priority.immediate', 1)
                                    ->whereNull('hamahang_task_priority.deleted_at')
                                    ->where('hamahang_task_priority.importance', 1)
                                    ->whereNull('hamahang_task_priority.deleted_at');
                            });
                        }
                    }
                });
            }
            if (isset($filter_subject_id))
            {
                if (trim($filter_subject_id)!='')
                {
                    $result = $result->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                        ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                        ->whereNull('hamahang_subject_ables.deleted_at');
                }
//            $tasks_immediate_importance->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
//                ->where('hamahang_subject_ables.subject_id', '=',$arr['filter_subject_id'])
//                ->whereNull('hamahang_subject_ables.deleted_at');
            }
//            dd($result->get(),db::getQueryLog());

            if ($task_final)
            {
//                $result->whereIn('hamahang_task.is_save', $task_final)
//                    ->whereNull('hamahang_task.deleted_at');
            }
            else
            {
//                $result->whereIn('hamahang_task.is_save', [11]);
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
            if(is_array($task_final))
            {
                if(count($task_final)>1)
                    $result->whereRaw('(( hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id ) AND hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id and uid = ? and is_assigner=1)) OR is_save in (0))', [Auth::id()]);
                else if(in_array(0,$task_final))
                    $result->whereRaw('is_save in (0)');
            }else{
                $result->whereRaw('( hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id ) AND hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id and uid = ? and is_assigner=1)) ', [Auth::id()]);
            }
//            $result = $result->tosql();
//            dd($result);


            $result = $result->groupBy('hamahang_task.id')->get();
//            dd(db::getQueryLog());
        }
        return $result;
    }
//    public static function f()
//    {
//        return DB::table('hamahang_project_task_relations')
//            ->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_project_task_relations.second_task_id')
//            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_project_task_relations.second_task_id')
//            ->where('hamahang_project_task_relations.first_task_id', '=', Request::input('tid'))
//            ->whereNull('hamahang_project_task_relations.deleted_at')
//            ->whereNull('hamahang_task_status.deleted_at')
//            ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_project_task_relations.second_task_id )')
//            ->select('hamahang_project_task_relations.second_task_id', 'hamahang_task.title', 'hamahang_project_task_relations.relation', 'hamahang_task_status.type')
//            ->get();
//    }

    public static function tasks_list_all($type = 'MyTasks', $status_filter = false, $title_filter = false, $respite_filter = false, $official_type = false)
    {
        $tasks_immediate_importance = self::whereHas('Assignment', function ($query) use ($type)
        {

            if ($type == 'MyTasks')
            {
                $query->whereHas('Employee', function ($query)
                {
                    $query->where('id', auth()->id());
                });
            }
            elseif($type == 'MyAssignedTasks')
            {
                $query->whereHas('Assigner', function ($query)
                {
                    $query->where('id', auth()->id());
                });
            }
        });
//        dd($tasks_immediate_importance);

        if ($status_filter)
        {
            $tasks_immediate_importance = $tasks_immediate_importance->whereHas('Status', function ($query) use ($status_filter)
            {
                $query->whereIn('type', $status_filter);
            });
        }
        else
        {
            $tasks_immediate_importance = $tasks_immediate_importance->whereHas('Status', function ($query)
            {
                $query->whereIn('type', [11]);
            });
        }

        if ($title_filter)
        {
            $tasks_immediate_importance = $tasks_immediate_importance->where('title', 'like', '%' . $title_filter . '%');
        }

        if ($official_type)
        {
            $tasks_immediate_importance = $tasks_immediate_importance->whereIn('type', $official_type);
        }else
            $tasks_immediate_importance = $tasks_immediate_importance->whereIn('type', [11]);

        $tasks_immediate_importance = $tasks_immediate_importance->get();
//        $tasks_immediate_importancess = $tasks_immediate_importance->toSql();
//        $tasks_immediate_importance = $tasks_immediate_importance->getBindings();
//        dd($tasks_immediate_importancess,$tasks_immediate_importance);
        if ($respite_filter)
        {
            $tasks_immediate_importance = $tasks_immediate_importance->filter(function ($item) use ($respite_filter)
            {
                return $item->RespiteRemain['days'] >= (int)$respite_filter;
            });
        }

        return $tasks_immediate_importance;
    }

    public static function tasks_immediate_importance($arr,$immediate = 0, $importance = 0, $type = 'MyTasks', $status_filter = false, $title_filter = false, $respite_filter = false, $official_type = false)
    {
        $tasks_immediate_importance = self::whereHas('Assignment', function ($query) use ($type)
        {

            if ($type == 'MyTasks')
            {
                $query->whereHas('Employee', function ($query)
                {
                    $query->where('id', auth()->id());
                });
            }
            elseif($type == 'MyAssignedTasks')
            {
                $query->whereHas('Assigner', function ($query)
                {
                    $query->where('id', auth()->id());
                });
                $is_assigner = 1;
            }
        });
        if ($type == 'MyTasks')
        {
            $is_assigner = 0;
            $tasks_immediate_importance = $tasks_immediate_importance->whereHas('Priority', function ($query) use ($immediate, $importance,$is_assigner)
            {
                $query->where('immediate', $immediate)->where('importance', $importance)
//                    ->where('is_assigner',$is_assigner)
                    ->whereNull('hamahang_task_priority.deleted_at');
            });
        }
        elseif($type == 'MyAssignedTasks')
        {
            $is_assigner = 1;
            $tasks_immediate_importance = $tasks_immediate_importance->whereHas('AssignerPriority', function ($query) use ($immediate, $importance,$is_assigner)
            {
                $query->where('immediate', $immediate)->where('importance', $importance)->whereNull('deleted_at');
            });
        }

        if ($status_filter)
        {
            $tasks_immediate_importance = $tasks_immediate_importance->whereHas('Status', function ($query) use ($status_filter)
            {
                $query->whereIn('type', $status_filter);
            });
        }
        else
        {
            $tasks_immediate_importance = $tasks_immediate_importance->whereHas('Status', function ($query)
            {
                $query->whereIn('type', [11]);
            });
        }
        if (isset($arr['filter_subject_id']))
        {
            if (trim($arr['filter_subject_id'])!='')
            {
                $tasks_immediate_importance = $tasks_immediate_importance->whereHas('Subjects', function ($query) use ($arr) {
                    $query->where('hamahang_subject_ables.subject_id', '=', $arr['filter_subject_id']);
                });
            }
        }
        $keywords = Request::input('keywords');
        if(Request::exists('keywords'))
        {
            $search_task_keywords = [];
            foreach($keywords as $keyword)
            {
                $search_task_keywords[] = preg_replace('/exist_in/','',$keyword);
            }
            if ($search_task_keywords)
            {
                $tasks_immediate_importance = $tasks_immediate_importance->whereHas('Keywords', function ($query) use ($search_task_keywords)
                {
                    $query->whereIn('keyword_id', $search_task_keywords);
                });
            }
        }

        if(Request::exists('users'))
        {
            $users = Request::input('users');
//            $tasks_immediate_importance->whereIn('hamahang_task.uid', $users);
            $tasks_immediate_importance->where(function ($result) use ($users){
                $result
                    ->whereIn('hamahang_task.uid', $users)
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('uid', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('assigner_id', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('employee_id', $users);
                    });

//                    ->orWhereIn('hamahang_task_assignments.uid', $users)
//                    ->orWhereIn('hamahang_task_assignments.assigner_id', $users)
//                    ->orWhereIn('hamahang_task_assignments.employee_id', $users)
                ;
            });
        }
        $task_final[] = 1;
        if(is_array(Request::input('task_status')))
            if(in_array('10',Request::input('task_status')))
            {
                $task_final[] = 0;
            }
        if ($task_final)
        {
//            $tasks_immediate_importance->whereIn('hamahang_task.is_save', $task_final)
//                ->whereNull('hamahang_task.deleted_at');
        }
        else
        {
            $tasks_immediate_importance->whereIn('hamahang_task.is_save', [11]);
        }

        if ($title_filter)
        {
            $tasks_immediate_importance = $tasks_immediate_importance->where('title', 'like', '%' . $title_filter . '%');
        }

        if ($official_type)
        {
            $tasks_immediate_importance = $tasks_immediate_importance->whereIn('type', $official_type);
        }else
        {
            $tasks_immediate_importance = $tasks_immediate_importance->whereIn('type', [11]);
        }
        if (Request::exists('task_final'))
        {
            $task_final = Request::input('task_final');
            if ($status_filter)
            {
//                $tasks_immediate_importance->whereIn('hamahang_task.is_save', $task_final)
//                    ->whereNull('hamahang_task.deleted_at');
            }
            else
            {
                $tasks_immediate_importance->whereIn('hamahang_task.is_save', [11]);
            }
        }

        $tasks_immediate_importance = $tasks_immediate_importance->get();
        return $tasks_immediate_importance;
    }

    public static function all_task_in_status($arr = false, $user = false)
    {

        $official_type = [0,1];
        $importance = [0,1];
        $immediate = [0,1];

        if (!$user)
        {
            $user = auth()->user();
        }
        $myTasks=[];

        $tasks_status = self::whereHas('Subjects', function ($query) use ($arr) {
            $query->where('hamahang_subject_ables.subject_id', '=', $arr['filter_subject_id'])
                ->whereNull('hamahang_subject_ables.deleted_at');
        });

        $tasks_status = $tasks_status->whereHas('AllPriority', function ($query) use ($immediate, $importance)
        {
            $query->whereIn('immediate', $immediate)->whereIn('importance', $importance)->whereNull('deleted_at');
        });

        if ($official_type)
        {
            $tasks_status = $tasks_status->whereIn('type', $official_type);
        }else
        {
            $tasks_status = $tasks_status->whereIn('type', [11]);
        }

        $myTasks['not_started'] = $tasks_status->whereHas('Status', function ($q){
            $q->where('type', 0);
        });
        $myTasks['not_started'] = $myTasks['not_started']->get();

        $myTasks['started'] = $tasks_status->whereHas('Status', function ($q){
            $q->where('type', 1);
        });
        $myTasks['started'] = $myTasks['started']->get();

        $myTasks['done'] =$tasks_status->whereHas('Status', function ($q){
            $q->where('type', 2);
        });
        $myTasks['done'] = $myTasks['done']->get();

        $myTasks['ended'] = $tasks_status->whereHas('Status', function ($q){
            $q->where('type', 3);
        });
        $myTasks['ended'] = $myTasks['ended']->get();
        $user = auth()->user();
        return view('hamahang.Tasks.MyTask..helper.MyTasksState.content', compact('user', 'myTasks'));
    }

    public static function all_tasks_immediate_importance($arr,$immediate = 0, $importance = 0, $type = 'MyTasks', $status_filter = false, $title_filter = false, $respite_filter = false, $official_type = false, $keywords=[], $users=[])
    {
//        db::enableQueryLog();
        $tasks_immediate_importance = self::whereHas('Subjects', function ($query) use ($arr) {
            $query->where('hamahang_subject_ables.subject_id', '=', $arr['filter_subject_id'])
                ->whereNull('hamahang_subject_ables.deleted_at');
        });

        $tasks_immediate_importance = $tasks_immediate_importance->whereHas('AllPriority', function ($query) use ($immediate, $importance)
        {
            $query->where('immediate', $immediate)->where('importance', $importance)->whereNull('deleted_at');
        });

        if ($status_filter)
        {
            $tasks_immediate_importance = $tasks_immediate_importance->whereHas('Status', function ($query) use ($status_filter)
            {
                $query->whereIn('type', $status_filter);
            });
        }
        else
        {
            $tasks_immediate_importance = $tasks_immediate_importance->whereHas('Status', function ($query)
            {
                $query->whereIn('type', [11]);
            });
        }

        if ($title_filter)
        {
            $tasks_immediate_importance = $tasks_immediate_importance->where('title', 'like', '%' . $title_filter . '%');
        }

        if ($official_type)
        {
            $tasks_immediate_importance = $tasks_immediate_importance->whereIn('type', $official_type);
        }else
        {
            $tasks_immediate_importance = $tasks_immediate_importance->whereIn('type', [11]);
        }

        if($keywords)
        {
            $search_task_keywords = [];
            foreach($keywords as $keyword)
            {
                $search_task_keywords[] = preg_replace('/exist_in/','',$keyword);
            }
            if ($search_task_keywords)
            {
                $tasks_immediate_importance = $tasks_immediate_importance->whereHas('Keywords', function ($query) use ($search_task_keywords)
                {
                    $query->whereIn('keyword_id', $search_task_keywords);
                });
            }
        }
        if($users)
        {
//            $tasks_immediate_importance->whereIn('hamahang_task.uid', $users);
            $tasks_immediate_importance->where(function ($result) use ($users){
                $result
                    ->whereIn('hamahang_task.uid', $users)
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('uid', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('assigner_id', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('employee_id', $users);
                    });

//                    ->orWhereIn('hamahang_task_assignments.uid', $users)
//                    ->orWhereIn('hamahang_task_assignments.assigner_id', $users)
//                    ->orWhereIn('hamahang_task_assignments.employee_id', $users)
                ;
            });
        }


        if (Request::exists('task_final'))
        {
            $task_final = Request::input('task_final');
            if ($status_filter)
            {
                $tasks_immediate_importance->whereIn('hamahang_task.is_save', $task_final)
                    ->whereNull('hamahang_task.deleted_at');
            }
            else
            {
                $tasks_immediate_importance->whereIn('hamahang_task.is_save', [11]);
            }
        }

        $tasks_immediate_importance = $tasks_immediate_importance->get();
//        dd($tasks_immediate_importance,db::getQueryLog());
        return $tasks_immediate_importance;
    }
    public static function MyTasksPriority($arr,$status_filter = false, $title_filter = false, $respite_filter = false, $official_type = false, $source='MyTasks')
    {
        return [
            'tasks_immediate_importance' => self::tasks_immediate_importance($arr,1, 1, $source, $status_filter, $title_filter, $respite_filter, $official_type),
            'tasks_not_immediate_importance' => self::tasks_immediate_importance($arr,0, 1, $source,$status_filter, $title_filter, $respite_filter, $official_type),
            'tasks_immediate_not_importance' => self::tasks_immediate_importance($arr,1, 0,$source, $status_filter, $title_filter, $respite_filter, $official_type),
            'tasks_not_immediate_not_importance' => self::tasks_immediate_importance($arr,0, 0,$source, $status_filter, $title_filter, $respite_filter, $official_type)
        ];
    }
    public static function AllTasksPriority($arr,$status_filter = false, $title_filter = false, $respite_filter = false, $official_type = false, $keywords=[], $users=[], $source='MyTasks')
    {
        return [
            'tasks_immediate_importance' => self::all_tasks_immediate_importance($arr,1, 1, $source, $status_filter, $title_filter, $respite_filter, $official_type,$keywords,$users),
            'tasks_not_immediate_importance' => self::all_tasks_immediate_importance($arr,0, 1, $source,$status_filter, $title_filter, $respite_filter, $official_type,$keywords,$users),
            'tasks_immediate_not_importance' => self::all_tasks_immediate_importance($arr,1, 0,$source, $status_filter, $title_filter, $respite_filter, $official_type,$keywords,$users),
            'tasks_not_immediate_not_importance' => self::all_tasks_immediate_importance($arr,0, 0,$source, $status_filter, $title_filter, $respite_filter, $official_type,$keywords,$users)
        ];
    }
    public static function MyTasksPriorityTime($status_filter = false, $title_filter = false, $respite_filter = false, $official_type = false)
    {
        return [
            'MyTasksPriorityTime' => self::tasks_list_all('MyTasks', $status_filter, $title_filter, $respite_filter, $official_type)
        ];
    }
    public static function AllTasksStatus($filter_subject_id=false,$importance=false,$immediate=false, $title_filter = false, $respite_filter = false, $official_type = false)
    {
        $user = auth()->user();
        $myTasks = [];
        $myTasks['not_started'] = '';
        $myTasks['started'] = '';
        $myTasks['done'] = '';
        $myTasks['ended'] = '';
        $title = Request::exists('title') ? Request::input('title') : '';
        $keywords = Request::exists('keywords') ? Request::input('keywords') : '';
        $users = Request::exists('users') ? Request::input('users') : '';

        if (empty($official_type)) {
            $official_type[0] = 11;
            $official_type[1] = 12;
        }
        if (empty($importance)) {
            $importance[0] = 11;
            $importance[1] = 12;
        }
        if (empty($immediate)) {
            $immediate[0] = 11;
            $immediate[1] = 12;
        }

        if (!$user) {
            $user = auth()->user();
        }
        $tasks_status = [];


        if (!$user)
        {
            $user = auth()->user();
        }
        $myTasks=[];

        $tasks_status = self::whereHas('Subjects', function ($query) use ($filter_subject_id) {
            $query->where('hamahang_subject_ables.subject_id', '=', $filter_subject_id)
                ->whereNull('hamahang_subject_ables.deleted_at');
        });

        $tasks_status = $tasks_status->whereHas('AllPriority', function ($query) use ($immediate, $importance)
        {
            $query->whereIn('immediate', $immediate)->whereIn('importance', $importance)->whereNull('deleted_at');
        });

        if ($official_type)
        {
            $tasks_status = $tasks_status->whereIn('type', $official_type);
        }else
        {
            $tasks_status = $tasks_status->whereIn('type', [11]);
        }

        if(trim($title)!='')
        {
            $tasks_status = $tasks_status->where('title','like','%'.$title.'%');
        }

        if($keywords)
        {
            $search_task_keywords = [];
            foreach($keywords as $keyword)
            {
                $search_task_keywords[] = preg_replace('/exist_in/','',$keyword);
            }
            if ($search_task_keywords)
            {
                $tasks_immediate_importance = $tasks_status->whereHas('Keywords', function ($query) use ($search_task_keywords)
                {
                    $query->whereIn('keyword_id', $search_task_keywords);
                });
            }
        }
        if($users)
        {
//            $tasks_immediate_importance->whereIn('hamahang_task.uid', $users);
            $tasks_status->where(function ($result) use ($users){
                $result
                    ->whereIn('hamahang_task.uid', $users)
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('uid', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('assigner_id', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('employee_id', $users);
                    });

//                    ->orWhereIn('hamahang_task_assignments.uid', $users)
//                    ->orWhereIn('hamahang_task_assignments.assigner_id', $users)
//                    ->orWhereIn('hamahang_task_assignments.employee_id', $users)
                ;
            });
        }

        $myTasks['not_started'] = $tasks_status->whereHas('Status', function ($q){
            $q->where('type', 0);
        });

        $myTasks['not_started'] = $myTasks['not_started']->get();

        $myTasks['started'] = $tasks_status->whereHas('Status', function ($q){
            $q->where('type', 1);
        });
        $myTasks['started'] = $myTasks['started']->get();

        $myTasks['done'] =$tasks_status->whereHas('Status', function ($q){
            $q->where('type', 2);
        });
        $myTasks['done'] = $myTasks['done']->get();

        $myTasks['ended'] = $tasks_status->whereHas('Status', function ($q){
            $q->where('type', 3);
        });
        $myTasks['ended'] = $myTasks['ended']->get();


        return $myTasks;
    }
    public static function MyTasksStatus($filter_subject_id=false,$importance=false,$immediate=false, $title_filter = false, $respite_filter = false, $official_type = false)
    {
        $user = auth()->user();
        $myTasks=[];
        $myTasks['not_started']='';
        $myTasks['started']='';
        $myTasks['done']='';
        $myTasks['ended']='';

        $title = Request::exists('title') ? Request::input('title') : '';
        $keywords = Request::exists('keywords') ? Request::input('keywords') : [];
        $users = Request::exists('users') ? Request::input('users') : [];
        $task_important_immediate = Request::input('task_important_immediate');

        if(empty($official_type))
        {
           $official_type[0]=11;
           $official_type[1]=12;
        }
        if(empty($importance))
        {
            $importance[0]=11;
            $importance[1]=12;
        }
        if(empty($immediate))
        {
            $immediate[0]=11;
            $immediate[1]=12;
        }

        if (!$user)
        {
            $user = auth()->user();
        }
        $myTasks=[];

        $myTasks['not_started'] = $user->MyTasks()
            ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id');

        if (trim($filter_subject_id)!='' && trim($filter_subject_id)!='undefined')
        {
            $myTasks['not_started']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        if(trim($title)!=''){
            $myTasks['not_started']->where('title','like','%'.$title.'%');
        }
        if($keywords)
        {
            $search_task_keywords = [];
            foreach($keywords as $keyword)
            {
                $search_task_keywords[] = preg_replace('/exist_in/','',$keyword);
            }
            if ($search_task_keywords)
            {
                $myTasks['not_started'] = $myTasks['not_started']->whereHas('Keywords', function ($query) use ($search_task_keywords)
                {
                    $query->whereIn('keyword_id', $search_task_keywords);
                });
            }
        }
        if($users)
        {
            $myTasks['not_started']->where(function ($result) use ($users){
                $result
                    ->whereIn('hamahang_task.uid', $users)
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('uid', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('assigner_id', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('employee_id', $users);
                    });
            });
        }
        if(is_array(Request::input('task_important_immediate'))){
            $myTasks['not_started']->where(function($q) use ($task_important_immediate) {
                foreach($task_important_immediate as $Atask_important_immediate)
                {
                    if($Atask_important_immediate == 0)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });

                    }else if($Atask_important_immediate == 1)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 2)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 3)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }
                }
            });
        }
        $myTasks['not_started']->whereIn('type', $official_type)->whereHas('Status', function ($q){
            $q->where('type', 0);
        });
        $myTasks['not_started'] = $myTasks['not_started']->groupBy('hamahang_task.id')->get();

////////////////////////////////

        $myTasks['started'] = $user->MyTasks()->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id');


        if (trim($filter_subject_id)!='' && trim($filter_subject_id)!='undefined')
        {
            $myTasks['started']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        if(trim($title)!=''){
            $myTasks['started']->where('title','like','%'.$title.'%');
        }
        if($keywords)
        {
            $search_task_keywords = [];
            foreach($keywords as $keyword)
            {
                $search_task_keywords[] = preg_replace('/exist_in/','',$keyword);
            }
            if ($search_task_keywords)
            {
                $myTasks['started'] = $myTasks['started']->whereHas('Keywords', function ($query) use ($search_task_keywords)
                {
                    $query->whereIn('keyword_id', $search_task_keywords);
                });
            }
        }
        if($users)
        {
            $myTasks['started']->where(function ($result) use ($users){
                $result
                    ->whereIn('hamahang_task.uid', $users)
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('uid', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('assigner_id', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('employee_id', $users);
                    });
            });
        }

        if(is_array(Request::input('task_important_immediate'))){
            $myTasks['started']->where(function($q) use ($task_important_immediate) {
                foreach($task_important_immediate as $Atask_important_immediate)
                {
                    if($Atask_important_immediate == 0)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });

                    }else if($Atask_important_immediate == 1)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 2)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 3)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }
                }
            });
        }
        $myTasks['started']->whereIn('type', $official_type)->whereHas('Status', function ($q){
            $q->where('type', 1);
        });
        $myTasks['started'] = $myTasks['started']->groupBy('hamahang_task.id')->get();

////////////////////////////////

        $myTasks['done'] = $user->MyTasks()->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id');

        if (trim($filter_subject_id)!='' && trim($filter_subject_id)!='undefined')
        {
            $myTasks['done']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        if(trim($title)!=''){
            $myTasks['done']->where('title','like','%'.$title.'%');
        }
        if($keywords)
        {
            $search_task_keywords = [];
            foreach($keywords as $keyword)
            {
                $search_task_keywords[] = preg_replace('/exist_in/','',$keyword);
            }
            if ($search_task_keywords)
            {
                $myTasks['done'] = $myTasks['done']->whereHas('Keywords', function ($query) use ($search_task_keywords)
                {
                    $query->whereIn('keyword_id', $search_task_keywords);
                });
            }
        }
        if($users)
        {
            $myTasks['done']->where(function ($result) use ($users){
                $result
                    ->whereIn('hamahang_task.uid', $users)
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('uid', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('assigner_id', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('employee_id', $users);
                    });
            });
        }


        if(is_array(Request::input('task_important_immediate'))){
            $myTasks['done']->where(function($q) use ($task_important_immediate) {
                foreach($task_important_immediate as $Atask_important_immediate)
                {
                    if($Atask_important_immediate == 0)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });

                    }else if($Atask_important_immediate == 1)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 2)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 3)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }
                }
            });
        }
        $myTasks['done']->whereIn('type', $official_type)->whereHas('Status', function ($q){
            $q->where('type', 2);
        });
        $myTasks['done'] = $myTasks['done']->groupBy('hamahang_task.id')->get();

////////////////////////////////

        $myTasks['ended'] = $user->MyTasks()->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id');

        if (trim($filter_subject_id)!='' && trim($filter_subject_id)!='undefined')
        {
            $myTasks['ended']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        if(trim($title)!=''){
            $myTasks['ended']->where('title','like','%'.$title.'%');
        }
        if($keywords)
        {
            $search_task_keywords = [];
            foreach($keywords as $keyword)
            {
                $search_task_keywords[] = preg_replace('/exist_in/','',$keyword);
            }
            if ($search_task_keywords)
            {
                $myTasks['ended'] = $myTasks['ended']->whereHas('Keywords', function ($query) use ($search_task_keywords)
                {
                    $query->whereIn('keyword_id', $search_task_keywords);
                });
            }
        }
        if($users)
        {
            $myTasks['ended']->where(function ($result) use ($users){
                $result
                    ->whereIn('hamahang_task.uid', $users)
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('uid', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('assigner_id', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('employee_id', $users);
                    });
            });
        }
        if(is_array(Request::input('task_important_immediate'))){
            $myTasks['ended']->where(function($q) use ($task_important_immediate) {
                foreach($task_important_immediate as $Atask_important_immediate)
                {
                    if($Atask_important_immediate == 0)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });

                    }else if($Atask_important_immediate == 1)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 2)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 3)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }
                }
            });
        }
        $myTasks['ended']->whereIn('type', $official_type)->whereHas('Status', function ($q){
            $q->where('type', 3);
        });
        $myTasks['ended'] = $myTasks['ended']->groupBy('hamahang_task.id')->get();

        return $myTasks;

//
////        DB::enableQueryLog();
////            $tasks = DB::table('hamahang_task')->select('`hamahang_task`.*, `hamahang_task_assignments`.`employee_id` as `pivot_employee_id`, `hamahang_task_assignments`.`task_id` as `pivot_task_id` ')
////                ->join('hamahang_task_assignments','`hamahang_task_assignments`.`task_id`','=','`hamahang_task`.`id`')
////                ->join('hamahang_subject_ables','`hamahang_subject_ables`.`target_id`','=','`hamahang_task`.`id`')
////                ->join('hamahang_task_status','`hamahang_task_status`.`task_id`','=','`hamahang_task`.`id`')
////                ->join('hamahang_task_priority','`hamahang_task_priority`.`task_id`','=','`hamahang_task`.`id`')
////                ->whereIn('`hamahang_task_priority`.`importance`',$importance)
////                ->whereIn('`hamahang_task_priority`.`immediate`',$immediate)
////                ->whereIn('`hamahang_task`.`type`',$official_type)
////                ->where('`hamahang_task_assignments`.`employee_id`','=',auth()->user());
////            if(trim($title)!='')
////                $tasks->where('`hamahang_task`.`title`','=',$title);
////            $myTasks['not_started'] = $tasks->where('`hamahang_task_status`.`type`',0);
//            $myTasks['not_started'] = $user->MyTasks()->whereIn('type', $official_type)->whereHas('Status', function ($q)
//            {
//                $q->where('type', 0);
//            })->whereHas('priority', function ($p)use($importance){$p->whereIn('importance',$importance);})
//              ->whereHas('priority', function ($p)use($immediate){$p->whereIn('immediate',$immediate);});
//            if(trim($title)!='')
//            {
//                $myTasks['not_started']->where('title','like','%'.$title.'%');
//            }
////            if ($filter_subject_id != false)
////            {
////                $myTasks['not_started']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
////                    ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id);
////            }
//            $myTasks['not_started']->get();
////dd(Req::all());
//            if ($respite_filter)
//            {
//                $myTasks['not_started'] = $myTasks['not_started']->filter(function ($item) use ($respite_filter)
//                {
//                    return $item->RespiteRemain['days'] <= (int)$respite_filter;
//                });
//            }
//            $myTasks['started'] = $user->MyTasks()->where('title','like','%'.$title.'%')->whereIn('type', $official_type)->whereHas('Status', function ($q)
//            {
//                $q->where('type', 1);
//            })->whereHas('priority', function ($p)use($importance){$p->whereIn('importance',$importance);})->whereHas('priority', function ($p)use($immediate){$p->whereIn('immediate',$immediate);});
//            if ($filter_subject_id != false)
//            {
//                $myTasks['started']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
//                    ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id);
//            }
//            $myTasks['started']->get();
//            if ($respite_filter)
//            {
//                $myTasks['started'] = $myTasks['started']->filter(function ($item) use ($respite_filter)
//                {
//                    return $item->RespiteRemain['days'] <= (int)$respite_filter;
//                });
//            }
//            $myTasks['done'] = $user->MyTasks()->where('title','like','%'.$title.'%')->whereIn('type', $official_type)->whereHas('Status', function ($q)
//            {
//                $q->where('type', 2);
//            })->whereHas('priority', function ($p)use($importance){$p->whereIn('importance',$importance);})->whereHas('priority', function ($p)use($immediate){$p->whereIn('immediate',$immediate);});
//            if ($filter_subject_id != false)
//            {
//                $myTasks['done']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
//                    ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id);
//            }
//            $myTasks['done']->get();
//            if ($respite_filter)
//            {
//                $myTasks['done'] = $myTasks['done']->filter(function ($item) use ($respite_filter)
//                {
//                    return $item->RespiteRemain['days'] <= (int)$respite_filter;
//                });
//            }
//            $myTasks['ended'] = $user->MyTasks()->where('title','like','%'.$title.'%')->whereIn('type', $official_type)->whereHas('Status', function ($q)
//            {
//                $q->where('type', 3);
//            })->whereHas('priority', function ($p)use($importance){$p->whereIn('importance',$importance);})->whereHas('priority', function ($p)use($immediate){$p->whereIn('immediate',$immediate);});
//            if ($filter_subject_id != false)
//            {
//                $myTasks['ended']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
//                    ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id);
//            }
//            $myTasks['ended']->get();
//            if ($respite_filter)
//            {
//                $myTasks['ended'] = $myTasks['ended']->filter(function ($item) use ($respite_filter)
//                {
//                    return $item->RespiteRemain['days'] <= (int)$respite_filter;
//                });
//            }
////        dd(DB::getQueryLog());
//
//        return $myTasks;
    }
    public static function MyAssignerTasksStatus($filter_subject_id=false,$importance=false,$immediate=false, $title_filter = false, $respite_filter = false, $official_type = false)
    {
        $user = auth()->user();
        $myTasks=[];
        $myTasks['not_started']='';
        $myTasks['started']='';
        $myTasks['done']='';
        $myTasks['ended']='';
        $keywords = Request::exists('keywords') ? Request::input('keywords') : '';
        $users = Request::exists('users') ? Request::input('users') : '';
        $title = Request::exists('title') ? Request::input('title') : '';
        if(empty($official_type))
        {
            $official_type[0]=11;
            $official_type[1]=12;
        }
        $task_important_immediate = Request::input('task_important_immediate');


/////////////////////////////


        $myTasks['not_started'] = $user->MyAssignedTasks()->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id');

        if (trim($filter_subject_id)!='' && trim($filter_subject_id)!='undefined')
        {
            $myTasks['not_started']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        if(trim($title)!=''){
            $myTasks['not_started']->where('title','like','%'.$title.'%');
        }
        if($keywords)
        {
            $search_task_keywords = [];
            foreach($keywords as $keyword)
            {
                $search_task_keywords[] = preg_replace('/exist_in/','',$keyword);
            }
            if ($search_task_keywords)
            {
                $myTasks['not_started'] = $myTasks['not_started']->whereHas('Keywords', function ($query) use ($search_task_keywords)
                {
                    $query->whereIn('keyword_id', $search_task_keywords);
                });
            }
        }
        if($users)
        {
            $myTasks['not_started']->where(function ($result) use ($users){
                $result
                    ->whereIn('hamahang_task.uid', $users)
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('uid', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('assigner_id', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('employee_id', $users);
                    });
            });
        }
        if(is_array(Request::input('task_important_immediate'))){
            $myTasks['not_started']->where(function($q) use ($task_important_immediate) {
                foreach($task_important_immediate as $Atask_important_immediate)
                {
                    if($Atask_important_immediate == 0)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });

                    }else if($Atask_important_immediate == 1)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 2)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 3)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }
                }
            });
        }
        $myTasks['not_started']->whereIn('type', $official_type)
            ->whereHas('Status', function ($q){
                $q->where('type', 0);
            })
        ;
        if ($respite_filter)
        {
            $myTasks['not_started'] = $myTasks['not_started']->filter(function ($item) use ($respite_filter)
            {
                return $item->RespiteRemain['days'] <= (int)$respite_filter;
            });
        }
        if (trim($title)!='')
        {
            $myTasks['not_started'] = $myTasks['not_started']->where('title','like','%'.$title.'%');
        }
        $myTasks['not_started'] = $myTasks['not_started']->groupBy('hamahang_task.id')->get();

/////////////////////////////

        $myTasks['started'] = $user->MyAssignedTasks()->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id');

        if (trim($filter_subject_id)!='' && trim($filter_subject_id)!='undefined')
        {
            $myTasks['started']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        if(trim($title)!=''){
            $myTasks['started']->where('title','like','%'.$title.'%');
        }
        if($keywords)
        {
            $search_task_keywords = [];
            foreach($keywords as $keyword)
            {
                $search_task_keywords[] = preg_replace('/exist_in/','',$keyword);
            }
            if ($search_task_keywords)
            {
                $myTasks['started'] = $myTasks['started']->whereHas('Keywords', function ($query) use ($search_task_keywords)
                {
                    $query->whereIn('keyword_id', $search_task_keywords);
                });
            }
        }
        if($users)
        {
            $myTasks['started']->where(function ($result) use ($users){
                $result
                    ->whereIn('hamahang_task.uid', $users)
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('uid', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('assigner_id', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('employee_id', $users);
                    });
            });
        }
        if(is_array(Request::input('task_important_immediate'))){
            $myTasks['started']->where(function($q) use ($task_important_immediate) {
                foreach($task_important_immediate as $Atask_important_immediate)
                {
                    if($Atask_important_immediate == 0)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });

                    }else if($Atask_important_immediate == 1)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 2)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 3)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }
                }
            });
        }
        $myTasks['started']->whereIn('type', $official_type)
            ->whereHas('Status', function ($q){
                $q->where('type', 1);
            });
        $myTasks['started'] = $myTasks['started']->groupBy('hamahang_task.id')->get();


/////////////////////////////

        $myTasks['done'] = $user->MyAssignedTasks()->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id');

        if (trim($filter_subject_id)!='' && trim($filter_subject_id)!='undefined')
        {
            $myTasks['done']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        if(trim($title)!=''){
            $myTasks['done']->where('title','like','%'.$title.'%');
        }
        if($keywords)
        {
            $search_task_keywords = [];
            foreach($keywords as $keyword)
            {
                $search_task_keywords[] = preg_replace('/exist_in/','',$keyword);
            }
            if ($search_task_keywords)
            {
                $myTasks['done'] = $myTasks['done']->whereHas('Keywords', function ($query) use ($search_task_keywords)
                {
                    $query->whereIn('keyword_id', $search_task_keywords);
                });
            }
        }
        if($users)
        {
            $myTasks['done']->where(function ($result) use ($users){
                $result
                    ->whereIn('hamahang_task.uid', $users)
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('uid', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('assigner_id', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('employee_id', $users);
                    });
            });
        }
        if(is_array(Request::input('task_important_immediate'))){
            $myTasks['done']->where(function($q) use ($task_important_immediate) {
                foreach($task_important_immediate as $Atask_important_immediate)
                {
                    if($Atask_important_immediate == 0)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });

                    }else if($Atask_important_immediate == 1)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 2)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 3)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }
                }
            });
        }
        $myTasks['done']->whereIn('type', $official_type)->whereHas('Status', function ($q){
                $q->where('type', 2);
            });
        $myTasks['done'] = $myTasks['done']->groupBy('hamahang_task.id')->get();
//            if ($respite_filter)
//            {
//                $myTasks['done'] = $myTasks['done']->filter(function ($item) use ($respite_filter)
//                {
//                    return $item->RespiteRemain['days'] <= (int)$respite_filter;
//                });
//            }


/////////////////////////////

        $myTasks['ended'] = $user->MyAssignedTasks()->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id');

        if (trim($filter_subject_id)!='' && trim($filter_subject_id)!='undefined')
        {
            $myTasks['ended']->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                ->where('hamahang_subject_ables.subject_id', '=',$filter_subject_id)
                ->whereNull('hamahang_subject_ables.deleted_at');
        }
        if(trim($title)!=''){
            $myTasks['ended']->where('title','like','%'.$title.'%');
        }
        if($keywords)
        {
            $search_task_keywords = [];
            foreach($keywords as $keyword)
            {
                $search_task_keywords[] = preg_replace('/exist_in/','',$keyword);
            }
            if ($search_task_keywords)
            {
                $myTasks['ended'] = $myTasks['ended']->whereHas('Keywords', function ($query) use ($search_task_keywords)
                {
                    $query->whereIn('keyword_id', $search_task_keywords);
                });
            }
        }
        if($users)
        {
            $myTasks['ended']->where(function ($result) use ($users){
                $result
                    ->whereIn('hamahang_task.uid', $users)
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('uid', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('assigner_id', $users);
                    })
                    ->orWhereHas('Assignments', function ($query) use ($users)
                    {
                        $query->whereIn('employee_id', $users);
                    });
            });
        }
        if(is_array(Request::input('task_important_immediate'))){
            $myTasks['ended']->where(function($q) use ($task_important_immediate) {
                foreach($task_important_immediate as $Atask_important_immediate)
                {
                    if($Atask_important_immediate == 0)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });

                    }else if($Atask_important_immediate == 1)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 0)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 2)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 0)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }else if($Atask_important_immediate == 3)
                    {
                        $q->orWhere(function($q) {
                            $q->where('hamahang_task_priority.immediate', 1)
                                ->whereNull('hamahang_task_priority.deleted_at')
                                ->where('hamahang_task_priority.importance', 1)
                                ->whereNull('hamahang_task_priority.deleted_at');
                        });
                    }
                }
            });
        }
        $myTasks['ended']
            ->whereIn('type', $official_type)->whereHas('Status', function ($q){
                $q->where('type', 3);
            });
        $myTasks['ended'] = $myTasks['ended']->groupBy('hamahang_task.id')->get();
//            if ($respite_filter)
//            {
//                $myTasks['ended'] = $myTasks['ended']->filter(function ($item) use ($respite_filter)
//                {
//                    return $item->RespiteRemain['days'] <= (int)$respite_filter;
//                });
//            }
       return $myTasks;
    }
    public static function MyAssignedTasksPriority($arr, $status_filter = false, $title_filter = false, $respite_filter = false, $official_type = false)
    {
        return [
            'tasks_immediate_importance' => self::tasks_immediate_importance($arr, 1, 1, 'MyAssignedTasks',$status_filter, $title_filter, $respite_filter, $official_type),
            'tasks_not_immediate_importance' => self::tasks_immediate_importance($arr, 0, 1, 'MyAssignedTasks',$status_filter, $title_filter, $respite_filter, $official_type),
            'tasks_immediate_not_importance' => self::tasks_immediate_importance($arr, 1, 0, 'MyAssignedTasks',$status_filter, $title_filter, $respite_filter, $official_type),
            'tasks_not_immediate_not_importance' => self::tasks_immediate_importance($arr, 0, 0, 'MyAssignedTasks',$status_filter, $title_filter, $respite_filter, $official_type)
        ];
    }

    public static function TakKeywords($tid)
    {
        $keywords = keywords::select('keywords.title', 'keywords.id')
            ->join('hamahang_task_keywords', 'hamahang_task_keywords.keyword_id', '=', 'keywords.id')
            ->where('hamahang_task_keywords.task_id', '=', $tid)
            ->whereNull('hamahang_task_keywords.deleted_at')
            ->get();
        return $keywords;
    }

    /*---------------------------------------------- relations --------------------------------------------*/
    public function Transcripts()
    {
        return $this->hasMany('App\Models\Hamahang\Tasks\task_transcripts', 'task_id', 'id');
    }

    public function Keywords()
    {
        return $this->hasMany('App\Models\Hamahang\Tasks\task_keywords', 'task_id', 'id');
    }

    public function Assignments()
    {
        return $this->hasMany('App\Models\Hamahang\Tasks\task_assignments', 'task_id', 'id');
    }

    public function Assignment()
    {
//        return $this->hasOne('App\Models\Hamahang\Tasks\task_assignments', 'task_id', 'id')->whereNull('transmitter_id')->whereNull('transferred_to_id');
        return $this->hasOne('App\Models\Hamahang\Tasks\task_assignments', 'task_id', 'id');//->where('status','=',0);//->whereNull('assigner_id');

//        return $this->morphToMany('App\User', '','hamahang_task_assignments','task_id','employee_id');
    }

    public function Priorities()
    {
        return $this->hasMany('App\Models\Hamahang\Tasks\task_priority', 'task_id', 'id')->where('user_id',auth()->id());
    }

    public function AllPriority()
    {
        return $this->hasOne('App\Models\Hamahang\Tasks\task_priority', 'task_id', 'id');
    }

    public function Priority()
    {
        return $this->hasOne('App\Models\Hamahang\Tasks\task_priority', 'task_id', 'id')->where('user_id',auth()->id());
    }

    public function AbroadPriority()
    {
        return $this->hasOne('App\Models\Hamahang\Tasks\task_priority', 'task_id', 'id')->whereNull('deleted_at');
    }

    public function History()
    {
        return $this->hasMany('App\Models\Hamahang\Tasks\task_history', 'task_id', 'id');
    }

    public function AssignerPriority()
    {
        return $this->hasOne('App\Models\Hamahang\Tasks\task_priority', 'task_id', 'id')->where('uid',auth()->id())->where('is_assigner',1)->whereNull('deleted_at');//->whereNull('assigner_id');
    }

    public function Statuses()
    {
        return $this->hasMany('App\Models\Hamahang\Tasks\task_status', 'task_id', 'id');
    }

    public function Status()
    {
        return $this->hasOne('App\Models\Hamahang\Tasks\task_status', 'task_id', 'id');
    }

    public function Action()
    {
        return $this->hasOne('App\Models\Hamahang\Tasks\task_action', 'task_id', 'id');
    }

    public function Subjects()
    {
        return $this->morphToMany('App\Models\hamafza\Subject', 'target','hamahang_subject_ables','target_id','subject_id');
    }

    public function Pages()
    {
        return $this->morphToMany('App\Models\hamafza\Pages', 'target','hamahang_subject_ables','target_id','subject_id')->whereNull('hamahang_subject_ables.deleted_at');
    }
    /* public function getPriorityAttribute()
     {
         //dd($this->priorities->first());
         if(isset($this->priorities->first()->importance)&& isset($this->priorities->first()->immediate))
         {
             if ($this->priorities->first()->importance && $this->priorities->first()->immediate)
             {
                 return 'فوری' . ' - ' . 'مهم';
             }
             elseif (!$this->priorities->first()->importance && $this->priorities->first()->immediate)
             {
                 return 'فوری' . ' - ' . 'غیر مهم';
             }
             elseif ($this->priorities->first()->importance && !$this->priorities->first()->immediate)
             {
                 return 'غیر فوری' . ' - ' . 'مهم';
             }
             elseif (!$this->priorities->first()->importance && !$this->priorities->first()->immediate)
             {
                 return 'غیر فوری' . ' - ' . 'غیر مهم';
             }
         }
         return 'اهمیت - اولویت ';
     }*/
    /*---------------------------------------------- Accessors  --------------------------------------------*/
    public function getImportanceAttribute()
    {
        return $this->priority->importance;
    }

    public function getImmediateAttribute()
    {
        return $this->priority->immediate;
    }

    public function getRespiteRemainAttribute()
    {
        $respite_days = hamahang_respite_remain(strtotime($this->schedule_time), $this->duration_timestamp);
        if ($respite_days[0]['delayed'] == 1)
        {
            $res['days'] = ($respite_days[0]['day_no']) * (-1);
            $res['bg_color_class'] = 'bg_red';
            $res['border_color_class'] = 'border_red';
        }
        else
        {
            $res['days'] = $respite_days[0]['day_no'];
            $res['bg_color_class'] = 'bg_green';
            $res['border_color_class'] = 'border_green';
        }
        return $res;
    }
    public function getUseTypeNameAttribute()
    {
        return hamahang_get_task_use_type_name($this->use_type);
    }
    /*---------------------------------------------- Mutators --------------------------------------------*/

}
