<?php

namespace App\Models\Hamahang\Tasks;

use App\HamafzaViewClasses\TaskClass;
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
        DB::enableQueryLog();


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

    public static function MyTasks($subject_id = false, $user_id = false, $api = false)
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
            ->whereRaw('hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id and user_id = ?)', [$uid])
//            ->toSql()
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

        $result = $result->get();
        return $result;
    }
    
     public static function MyTasksSummary($uid)
    {
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
            ->whereRaw('hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id and user_id = ?)', [$uid])
                ->select('schedule_time','duration_timestamp','immediate','importance','title','task_status')
//            ->toSql()
        ;
        
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
                ->select("hamahang_task_assignments.id as assignment_id","hamahang_task.schedule_id", "hamahang_task.schedule_time", "hamahang_task.use_type", "hamahang_task_status.type", "user.Uname", "user.Name", "user.Family", "hamahang_task.id", "hamahang_task.title", "hamahang_task_priority.immediate", "hamahang_task_priority.importance", "hamahang_task.created_at", "hamahang_task.duration_timestamp")
                ->join('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
                ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
                ->join('user', 'user.id', '=', 'hamahang_task_assignments.employee_id')
                ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
//                ->whereNull('hamahang_task_assignments.transmitter_id')
//                ->where('hamahang_task_assignments.status','=',0)
                ->where('hamahang_task_assignments.uid', '=', $uid)
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
            $result = DB::table('hamahang_task')
                ->select("hamahang_task_assignments.id as assignment_id","hamahang_task.schedule_id", "hamahang_task.schedule_time", "hamahang_task.use_type", "hamahang_task_status.type", "user.Uname", "user.Name", "user.Family", "hamahang_task.id", "hamahang_task.title", "hamahang_task_priority.immediate", "hamahang_task_priority.importance", "hamahang_task.created_at", "hamahang_task.duration_timestamp")
                ->join('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
                ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
                ->join('user', 'user.id', '=', 'hamahang_task_assignments.employee_id')
                ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
//                ->whereNull('hamahang_task_assignments.transmitter_id')
//                ->where('hamahang_task_assignments.status','=',0)
                ->where('hamahang_task_assignments.uid', '=', $uid)
                ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
                ->whereRaw('hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id and uid = ?)', [Auth::id()]);
            if ($subject_id)
            {
                $result->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                    ->whereNull('hamahang_subject_ables.deleted_at')
                    ->where('hamahang_subject_ables.subject_id', '=', $subject_id)
                    ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\tasks');
            }
//            $result = $result->tosql();
//            dd($result);

            $status_filter = Request::get('task_status');
            $official_type = Request::get('official_type');
            $important = Request::get('task_important');
            $immediate = Request::get('task_immediate');
            if ($official_type)
            {
                $result->whereIn('hamahang_task.type', $official_type)
                    ->whereNull('hamahang_task.deleted_at');
//            dd($immediate);
            }
            else
            {
                $result->whereIn('hamahang_task.type', [0,1]);
            }

            if ($status_filter)
            {
                $result->whereIn('hamahang_task_status.type', $status_filter)
                    ->whereNull('hamahang_task_status.deleted_at');
//            dd($immediate);
            }
            else
            {
                $result->whereIn('hamahang_task_status.type', [0,1,2,3]);
            }

            if ($immediate)
            {
                $result->whereIn('hamahang_task_priority.immediate', $immediate)
                    ->whereNull('hamahang_task_priority.deleted_at');
//            dd($immediate);
            }
            else
            {
                $result->whereIn('hamahang_task_priority.immediate', [0,1]);
            }

            if ($important)
            {
                $result->whereIn('hamahang_task_priority.importance', $important)
                    ->whereNull('hamahang_task_priority.deleted_at');
//            dd($important);
            }
            else
            {
                $result->whereIn('hamahang_task_priority.importance', [0,1]);
            }

            
            $result = $result->get();
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

    public static function tasks_immediate_importance($immediate = 0, $importance = 0, $type = 'MyTasks', $status_filter = false, $title_filter = false, $respite_filter = false, $official_type = false)
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
        $tasks_immediate_importance = $tasks_immediate_importance->whereHas('Priority', function ($query) use ($immediate, $importance)
        {
            $query->where('immediate', $immediate)->where('importance', $importance)->where('is_assigner',0);
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
            $tasks_immediate_importance = $tasks_immediate_importance->whereIn('type', [11]);

        $tasks_immediate_importance = $tasks_immediate_importance->get();

        if ($respite_filter)
        {
            $tasks_immediate_importance = $tasks_immediate_importance->filter(function ($item) use ($respite_filter)
            {
                return $item->RespiteRemain['days'] >= (int)$respite_filter;
            });
        }

        return $tasks_immediate_importance;
    }
    public static function MyTasksPriority($status_filter = false, $title_filter = false, $respite_filter = false, $official_type = false)
    {
        return [
            'tasks_immediate_importance' => self::tasks_immediate_importance(1, 1, 'MyTasks', $status_filter, $title_filter, $respite_filter, $official_type),
            'tasks_not_immediate_importance' => self::tasks_immediate_importance(0, 1, 'MyTasks',$status_filter, $title_filter, $respite_filter, $official_type),
            'tasks_immediate_not_importance' => self::tasks_immediate_importance(1, 0,'MyTasks', $status_filter, $title_filter, $respite_filter, $official_type),
            'tasks_not_immediate_not_importance' => self::tasks_immediate_importance(0, 0,'MyTasks', $status_filter, $title_filter, $respite_filter, $official_type)
        ];
    }
    public static function MyTasksPriorityTime($status_filter = false, $title_filter = false, $respite_filter = false, $official_type = false)
    {
        return [
            'MyTasksPriorityTime' => self::tasks_list_all('MyTasks', $status_filter, $title_filter, $respite_filter, $official_type)
        ];
    }
    public static function MyTasksStatus($importance=false,$immediate=false, $title_filter = false, $respite_filter = false, $official_type = false)
    {

        $user = auth()->user();
        $myTasks=[];
        $myTasks['not_started']='';
        $myTasks['started']='';
        $myTasks['done']='';
        $myTasks['ended']='';
        $official='';
        if(isset($title_filter))
          $title=$title_filter;
        else $title='';
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
            $myTasks['not_started'] = $user->MyTasks()->where('title','like','%'.$title.'%')->whereIn('type', $official_type)->whereHas('Status', function ($q)
            {
                $q->where('type', 0);
            })->whereHas('priority', function ($p)use($importance){$p->whereIn('importance',$importance);})
              ->whereHas('priority', function ($p)use($immediate){$p->whereIn('immediate',$immediate);})->get();

            if ($respite_filter)
            {
                $myTasks['not_started'] = $myTasks['not_started']->filter(function ($item) use ($respite_filter)
                {
                    return $item->RespiteRemain['days'] <= (int)$respite_filter;
                });
            }
            $myTasks['started'] = $user->MyTasks()->where('title','like','%'.$title.'%')->whereIn('type', $official_type)->whereHas('Status', function ($q)
            {
                $q->where('type', 1);
            })->whereHas('priority', function ($p)use($importance){$p->whereIn('importance',$importance);})
                ->whereHas('priority', function ($p)use($immediate){$p->whereIn('immediate',$immediate);})->get();
            if ($respite_filter)
            {
                $myTasks['started'] = $myTasks['started']->filter(function ($item) use ($respite_filter)
                {
                    return $item->RespiteRemain['days'] <= (int)$respite_filter;
                });
            }
            $myTasks['done'] = $user->MyTasks()->where('title','like','%'.$title.'%')->whereIn('type', $official_type)->whereHas('Status', function ($q)
            {
                $q->where('type', 2);
            })->whereHas('priority', function ($p)use($importance){$p->whereIn('importance',$importance);})
                ->whereHas('priority', function ($p)use($immediate){$p->whereIn('immediate',$immediate);})->get();
            if ($respite_filter)
            {
                $myTasks['done'] = $myTasks['done']->filter(function ($item) use ($respite_filter)
                {
                    return $item->RespiteRemain['days'] <= (int)$respite_filter;
                });
            }
            $myTasks['ended'] = $user->MyTasks()->where('title','like','%'.$title.'%')->whereIn('type', $official_type)->whereHas('Status', function ($q)
            {
                $q->where('type', 3);
            })->whereHas('priority', function ($p)use($importance){$p->whereIn('importance',$importance);})
                ->whereHas('priority', function ($p)use($immediate){$p->whereIn('immediate',$immediate);})->get();
            if ($respite_filter)
            {
                $myTasks['ended'] = $myTasks['ended']->filter(function ($item) use ($respite_filter)
                {
                    return $item->RespiteRemain['days'] <= (int)$respite_filter;
                });
            }

        return $myTasks;
    }
    public static function MyAssignerTasksStatus($importance=false,$immediate=false, $title_filter = false, $respite_filter = false, $official_type = false)
    {
        $user = auth()->user();
        $myTasks=[];
        $myTasks['not_started']='';
        $myTasks['started']='';
        $myTasks['done']='';
        $myTasks['ended']='';
        $official='';
        if(isset($title_filter))
            $title=$title_filter;
        else $title='';
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
            $myTasks['not_started'] = $user->MyAssignedTasks()->where('title','like','%'.$title.'%')->whereIn('type', $official_type)->whereHas('Status', function ($q)
            {
                $q->where('type', 0);
            })->whereHas('priority', function ($p)use($importance){$p->whereIn('importance',$importance);})
                ->whereHas('priority', function ($p)use($immediate){$p->whereIn('immediate',$immediate);})->get();
            if ($respite_filter)
            {
                $myTasks['not_started'] = $myTasks['not_started']->filter(function ($item) use ($respite_filter)
                {

                    return $item->RespiteRemain['days'] <= (int)$respite_filter;
                });
            }
         $myTasks['started'] = $user->MyAssignedTasks()->where('title','like','%'.$title.'%')->whereIn('type', $official_type)->whereHas('Status', function ($q)
            {
                $q->where('type', 1);
            })->whereHas('priority', function ($p)use($importance){$p->whereIn('importance',$importance);})
             ->whereHas('priority', function ($p)use($immediate){$p->whereIn('immediate',$immediate);})->get();
            if ($respite_filter)
            {
                $myTasks['started'] = $myTasks['started']->filter(function ($item) use ($respite_filter)
                {
                    return $item->RespiteRemain['days'] <= (int)$respite_filter;
                });
            }
            $myTasks['done'] = $user->MyAssignedTasks()->where('title','like','%'.$title.'%')->whereIn('type', $official_type)->whereHas('Status', function ($q)
            {
                $q->where('type', 2);
            })->whereHas('priority', function ($p)use($importance){$p->whereIn('importance',$importance);})
              ->whereHas('priority', function ($p)use($immediate){$p->whereIn('immediate',$immediate);})->get();
            if ($respite_filter)
            {
                $myTasks['done'] = $myTasks['done']->filter(function ($item) use ($respite_filter)
                {
                    return $item->RespiteRemain['days'] <= (int)$respite_filter;
                });
            }
            $myTasks['ended'] = $user->MyAssignedTasks()->where('title','like','%'.$title.'%')->whereIn('type', $official_type)->whereHas('Status', function ($q)
            {
                $q->where('type', 3);
            })->whereHas('priority', function ($p)use($importance){$p->whereIn('importance',$importance);})
              ->whereHas('priority', function ($p)use($immediate){$p->whereIn('immediate',$immediate);})->get();
            if ($respite_filter)
            {
                $myTasks['ended'] = $myTasks['ended']->filter(function ($item) use ($respite_filter)
                {
                    return $item->RespiteRemain['days'] <= (int)$respite_filter;
                });
            }
       return $myTasks;
    }
    public static function MyAssignedTasksPriority($status_filter = false, $title_filter = false, $respite_filter = false, $official_type = false)
    {
        return [
            'tasks_immediate_importance' => self::tasks_immediate_importance(1, 1, 'MyAssignedTasks',$status_filter, $title_filter, $respite_filter, $official_type),
            'tasks_not_immediate_importance' => self::tasks_immediate_importance(0, 1, 'MyAssignedTasks',$status_filter, $title_filter, $respite_filter, $official_type),
            'tasks_immediate_not_importance' => self::tasks_immediate_importance(1, 0, 'MyAssignedTasks',$status_filter, $title_filter, $respite_filter, $official_type),
            'tasks_not_immediate_not_importance' => self::tasks_immediate_importance(0, 0, 'MyAssignedTasks',$status_filter, $title_filter, $respite_filter, $official_type)
        ];
    }
    /*---------------------------------------------- relations --------------------------------------------*/
    public function Assignments()
    {
        return $this->hasMany('App\Models\Hamahang\Tasks\task_assignments', 'task_id', 'id');
    }

    public function Assignment()
    {
//        return $this->hasOne('App\Models\Hamahang\Tasks\task_assignments', 'task_id', 'id')->whereNull('transmitter_id')->whereNull('transferred_to_id');
        return $this->hasOne('App\Models\Hamahang\Tasks\task_assignments', 'task_id', 'id')->where('status','=',0);//->whereNull('assigner_id');
    }

    public function Priorities()
    {
        return $this->hasMany('App\Models\Hamahang\Tasks\task_priority', 'task_id', 'id')->where('user_id',auth()->id());
    }

    public function Priority()
    {
        return $this->hasOne('App\Models\Hamahang\Tasks\task_priority', 'task_id', 'id')->where('user_id',auth()->id());
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
