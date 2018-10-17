<?php

namespace App\Http\Controllers\Hamahang\Tasks;


use DB;
use Auth;
use Request;
use Redirect;
use App\Models\Hamahang\Tasks\tasks;
use App\Models\Hamahang\Tasks\drafts;
use App\Models\Hamahang\Tasks\task_logs;
use App\Models\Hamahang\Tasks\task_files;
use App\Models\Hamahang\Tasks\task_status;
use App\Models\Hamahang\Tasks\task_staffs;
use App\Models\Hamahang\Tasks\task_notices;
use App\Models\Hamahang\Tasks\task_keywords;
use App\Models\Hamahang\Tasks\task_assignments;
use App\Models\Hamahang\Tasks\task_transcripts;
use App\Models\Hamahang\FileManager\FileManager;
use Illuminate\Support\Facades\Session;
use App\HamahangCustomClasses\jDateTime;
use App\HamahangCustomClasses\EncryptString;
use App\Http\Controllers\Controller;

class DraftController extends Controller
{
    public function save_drafts()
    {

        DB::transaction(function () {
            $date = new jDateTime();
            date_default_timezone_set('Asia/Tehran');
            $date_to_split = explode('-', Request::input('respite_date'));
            $time_to_split = explode(':', Request::input('respite_time'));
//$respite_timestamp = $date->mktime($time_to_split[0], $time_to_split[1], '0', $date_to_split['1'], $date_to_split[2], $date_to_split[0]);
//$respite_timestamp = hamahang_make_task_respite(Request::input('respite_date'), Request::input('respite_time'));

            $respite_timestamp = 0;
            $task = new drafts;
            $task->form_data = serialize(Request::all());
            $task->users = serialize(Request::input('users'));
            $task->transcripts = serialize(Request::input('transcripts'));
            $keywords = Request::input('keyword');
            $keywords = explode(',', $keywords[0]);
            $task->keywords = serialize($keywords);
            $task->title = Request::input('title');
            $task->type = Request::input('type');
            $task->desc = Request::input('task_desc');
            $task->uid = Auth::id();
            $task->report_on_create_point = Request::input('report_on_cr');
            $task->report_on_completion_point = Request::input('report_on_co');
            $task->report_to_managers = Request::input('report_to_manager');
            $task->importance = Request::input('importance');
            $task->immediate = Request::input('immediate');
            $task->timing_type = Request::input('respite_timing_type');
            $task->respite = $respite_timestamp;
//$task->predicted_time = Request::input('predicted_time');
//$task->respite = $respite_timestamp;
            if (Request::input('report_on_cr') == true) {
                $task->report_on_create_point = 1;
            }
            if (Request::input('report_on_co') == true) {
                $task->report_on_completion_point = 1;
            }
            if (Request::input('transferable') == true) {
                $task->transferable = 1;
            }
            if (Request::input('end_on_assigner_accept') == true) {
                $task->end_on_assigner_accept = 1;
            }

            $arr_files = [];
            if (Session::has('Files')) {
                $files = Session::get('Files');
                if (isset($files['CreateNewTask']) && is_array($files['CreateNewTask'])) {
                    $task_files = $files['CreateNewTask'];
                    if (is_array($task_files)) {
                        foreach ($task_files as $key => $value) {
                            array_push($arr_files, $key);
                        }
                    }
                }
            }
            $task->files = serialize($arr_files);
            $task->save();
        });
        return json_encode(1);
    }

    public function publish_draft()
    {
        DB::transaction(function ()
        {
            $date = new jDateTime();
            date_default_timezone_set('Asia/Tehran');
            $date_to_split = explode('-', Request::input('respite_date'));
            $time_to_split = explode(':', Request::input('respite_time'));
            $respite_timestamp = $date->mktime($time_to_split[0], $time_to_split[1], '0', $date_to_split['1'], $date_to_split[2], $date_to_split[0]);
            if (Request::input('assign_type') == 1)
            {
                $x = 0;
                if (sizeof(Request::input('users') > 0))
                {
                    $task_id = tasks::SaveTask(Request::input('title'),Request::input('type'),Request::input('task_desc'),Request::input('report_on_cr'),Request::input('end_on_assigner_accept'),Request::input('transferable'),Request::input('report_on_cr'),Request::input('report_on_co'));
                    foreach (Request::input('users') as $u)
                    {
                        if ($x == 0)
                        {
                            ////save first item as employee_id in task_assignments table
                            $assign = task_assignments::create_task_assignment($u, $task_id);
                            $status = new task_status;
                            $status->uid = Auth::id();
                            $status->task_id = $task_id;
                            $status->task_assignment_id = $assign->id;
                            $status->type = 0;
                            $status->user_id = Auth::id();
                            $status->timestamp = time();
                            $status->save();
                            task_logs::CreateNewLog($task_id, $assign->id, 'create');
                            $x = 1;
                        }
                        else
                        {
                            task_staffs::create_task_staff($assign->id, $u);
                        }
                    }
                    $exist_files = DB::table('hamahang_task_drafts')->where('uid', '=', Auth::id())->where('id', '=', Request::input('current_task_id'))->select('files')->first();
                    $exist_files = unserialize($exist_files->files);
                    if (sizeof($exist_files) > 0)
                    {
                        foreach ($exist_files as $key => $value)
                        {
                            $f = new task_files;
                            $f->task_id = $task_id;
                            $f->file_id = $value;
                            $f->save();
                        }
                    }

                    if (Request::exists('transcripts'))
                    {
                        foreach (Request::input('transcripts') as $transcript)
                        {
                            task_transcripts::create_task_transcript($task_id, $transcript);
                        }
                    }
                    if (Request::exists('keyword'))
                    {
                        foreach (Request::exists('keyword') as $kw)
                        {
                            task_keywords::create_task_keyword($task_id, $kw);
                        }
                    }
                    $notice = new task_notices;
                    $notice->task_id = $task_id;
                    $notice->save();

                }
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
                    $task->report_on_create_point = Request::input('report_on_cr');
                    $task->report_on_completion_point = Request::input('report_on_co');
                    $task->report_to_managers = Request::input('report_to_manager');
                    $task->respite = $respite_timestamp;
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
                    $task->respite = $respite_timestamp;
                    if (Request::input('report_on_cr') == true)
                    {
                        $task->report_on_create_point = 1;
                    }
                    if (Request::input('report_on_co') == true)
                    {
                        $task->report_on_completion_point = 1;
                    }
                    $task->save();
                    $assign = task_assignments::create_task_assignment($u, $task->id);
                    task_logs::CreateNewLog($task->id, $assign->id, 'create');
                    $status = new task_status;
                    $status->task_id = $task->id;
                    $status->task_assignment_id = $assign->id;
                    $status->type = 0;
                    $status->user_id = Auth::id();
                    $status->timestamp = time();
                    $status->save();
                    $exist_files = DB::table('hamahang_task_drafts')->where('uid', '=', Auth::id())->where('id', '=', Request::input('current_task_id'))->select('files')->first();
                    $exist_files = unserialize($exist_files->files);
                    if (sizeof($exist_files) > 0)
                    {
                        foreach ($exist_files as $key => $value)
                        {
                            $f = new task_files;
                            $f->task_id = $task->id;
                            $f->file_id = $value;
                            $f->save();
                        }
                    }
                    if (Request::exists('transcripts'))
                    {
                        foreach (Request::input('transcripts') as $transcript)
                        {
                            task_transcripts::create_task_transcript($task->id, $transcript);
                        }
                    }
                    if (Request::exists('keyword'))
                    {
                        foreach (Request::exists('keyword') as $kw)
                        {
                            task_keywords::create_task_keyword($task->id, $kw);
                        }
                    }
                    $notice = new task_notices;
                    $notice->task_id = $task->id;
                    //$notice->sms = Request::input('sms');
                    //$notice->email = Request::input('email');
                    $notice->save();

                }
            }

        });
        return Redirect::route('ugc.desktop.hamahang.tasks.my_assigned_tasks.list', ['username' => Auth::user()->Uname]);
    }

    public function RemoveDraft()
    {

        drafts::where('id', '=', Request::input('tid'))
            ->update(['deleted_at' => time()]);
        return json_encode('ok');

    }

    public function FetchDraftFiles($id)
    {
        $files = DB::table('hamahang_task_drafts')->where('uid', '=', Auth::id())->where('id', '=', $id)->select('files')->first();
        $files = unserialize($files->files);
        //die(var_dump($files));
        $arr = [];

        $DraftTaskDrafts = DB::table('hamahang_files')->whereIn('id', $files)->select('id', 'extension', 'originalName', 'size')->get();
        //die(var_dump($DraftTaskDrafts));


        $EncryptString = new EncryptString;
        $FileManager = new FileManager;
        //die(var_dump($DraftTaskDrafts));
        if (is_array($files))
        {
            foreach ($DraftTaskDrafts as $f)
            {
                $ID_N = $EncryptString->encode($f->id);
                array_push($arr, ['title' => $f->originalName, 'id' => $f->id, 'size' => $f->size, 'extension' => $f->extension, 'ID_N' => $ID_N]);
            }
        }

        $result['data'] = $arr;
        return json_encode($result);
    }

    public function FetchDraftsList()
    {
        $total = tasks::FetchDraftsTasks();
//        $total = drafts::FetchDraftsList();
        foreach ($total as $t)
        {
            $d = new jDateTime;
            $datetime = explode(' ', $t->cr);
            $date = explode('-', $datetime[0]);
            $time = explode(':', $datetime[1]);
            $g_timestamp = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
            $jdate = $d->getdate($g_timestamp);
            $jdate = $jdate['year'] . '/' . $jdate['mon'] . '/' . $jdate['mday'];
            $t->cr = $jdate;
        }
        $data = collect($total)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $result['data'] = $data;
        return json_encode($result);
    }

    public function ShowDrafts($uname)
    {
        $arr = variable_generator('user','desktop',$uname);
        $arr['HFM_TaskDrafts'] = HFM_GenerateUploadForm([['TaskDrafts', ['jpeg', 'jpg', 'png', 'bmp', 'gif', 'gif', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'], 'Multi']]);
        return view('hamahang.Tasks.ShowDrafts', $arr);
    }

    public function task_draft_info()
    {
        $date = new jDateTime();
        date_default_timezone_set('Asia/Tehran');
        $task_info = DB::table('hamahang_task_drafts')//->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
        ->select('hamahang_task_drafts.*')->where('hamahang_task_drafts.id', Request::input('id'))->get();
        ///die(var_dump($task_info));
        //die($task_info[0]->id.'ssss');
        $r = $date->getdate(($task_info[0]->respite + strtotime($task_info[0]->schedule_time)));
        $task_info[0]->respite_day = $r['year'] . '/' . $r['mon'] . '/' . $r['mday'];
        //DB::enableQueryLog();
//        $keyword = DB::table('hamahang_task_keywords')
////            ->join('hamahang_task_assignments', function ($join) {
////                $join->on('hamahang_task_keywords.task_id', '=', 'hamahang_task_assignments.task_id');
////                $join->on('hamahang_task_keywords.uid', '=', 'hamahang_task_assignments.assigner_id');
////            })
//            ->select('keyword')
//            //->where('hamahang_task_assignments.assigner_id','=','hamahang_task_keywords.uid')
//            ->where('hamahang_task_keywords.task_id', $task_info[0]->id)->get();
//        // die(dd(DB::getQueryLog()));
//        $arr1 = [];
//        if (sizeof($keyword) > 0)
//            foreach ($keyword as $kw) {
//                array_push($arr1, $kw->keyword);
//            }
//        $task_info[0]->kw = $arr1;

        $task_info[0]->kw = unserialize($task_info[0]->keywords);
        $task_info[0]->title = unserialize($task_info[0]->title);
        $task_info[0]->employee = unserialize($task_info[0]->users);
        $task_info[0]->transcript = unserialize($task_info[0]->transcripts);
        $task_info[0]->files = unserialize($task_info[0]->files);
        $arr_users = [];
        if (sizeof($task_info[0]->employee) > 0)
        {
            foreach ($task_info[0]->employee as $em)
            {
                //die(var_dump($em));
                $name = Db::table('user')->where('id', '=', (int)$em)->select('Name', 'Family')->first();
                array_push($arr_users, ['id' => $em, 'name' => $name->Name . ' ' . $name->Family]);
                //die(var_dump($name));
            }
        }
        $task_info[0]->employee = $arr_users;

        $arr_transcripts = [];
        if (sizeof($task_info[0]->transcript) > 0)
        {
            foreach ($task_info[0]->transcript as $tr)
            {
                $name = Db::table('user')->where('id', '=', (int)$tr)->select('Name', 'Family')->first();
                array_push($arr_transcripts, ['id' => $tr, 'name' => $name->Name . ' ' . $name->Family]);
                //die(var_dump($name));
            }
        }
        $task_info[0]->transcript = $arr_transcripts;

        $x = get_object_vars($task_info[0]);
        return json_encode($x);
    }

    public function RemoveTaskDraftFile()
    {
        $files = DB::table('hamahang_task_drafts')->where('uid', '=', Auth::id())->where('id', '=', Request::input('tid'))->select('files')->first();
        $files = unserialize($files->files);
        if (($key = array_search(Request::input('fid'), $files)) !== false)
        {
            unset($files[$key]);
        }
        $updated_files = serialize($files);
        drafts::where('id', '=', Request::input('tid'))->update(['files' => $updated_files]);
        return json_encode('ok');

    }

    public function ShowDraftTaskFiles()
    {

//        $sort = Request::input('sort');
//        $current = Request::input('current');
//        $rowCount = Request::input('rowCount');
//        $searchPhrase = Request::input('searchPhrase');
//        //$task_id = task_assignments::where('id', '=', Request::input('id'))->firstOrFail()->task_id;
//
//        $task_id = Request::input('id');
//
//        $files = DB::table('hamahang_task_drafts')->where('uid','=',Auth::id())->where('id','=',$task_id)->select('files')->first();
//        //
//        //die($files->files);
//        $files = unserialize($files->files);
//        //die($files);
//        $total = DB::table('hamahang_files')
//            ->select('hamahang_task_files.file_id', 'hamahang_files.originalName', 'hamahang_files.size', 'hamahang_files.extension')
//            ->join('hamahang_task_drafts', 'hamahang_task_drafts.file_id', 'hamahang_files.id')
//            ->whereIn('hamahang_task_files.id', $files)
//            ->count();
//        $total = sizeof($files);
//        if ($rowCount == -1) {
//            $data = DB::table('hamahang_files')
//                ->select('hamahang_task_files.file_id', 'hamahang_files.originalName', 'hamahang_files.size', 'hamahang_files.extension')
//                ->join('hamahang_task_files', 'hamahang_task_files.file_id', 'hamahang_files.id')
//                ->where('hamahang_task_files.task_id', '=', $task_id)
//                ->where('hamahang_files.originalName', 'LIKE', '%' . $searchPhrase . '%')
//                ->get();
//        } else {
//            if ($sort) {
//                $sort_field = array_keys($sort)[0];
//                $sort_order = $sort[array_keys($sort)[0]];
//            } else {
//                $sort_field = 'hamahang_files.id';
//                $sort_order = 'DESC';
//            }
//
//            if ($current == 1)
//                $cur = 0;
//            else
//                $cur = ($current - 1) * $rowCount;
//
//            $data = DB::table('hamahang_files')
//                ->join('hamahang_task_files', 'hamahang_task_files.file_id', 'hamahang_files.id')
//                ->select('hamahang_task_files.file_id', 'hamahang_files.originalName', 'hamahang_files.size', 'hamahang_files.extension')
//                ->where('hamahang_task_files.task_id', '=', $task_id)
//                ->where('hamahang_files.originalName', 'LIKE', '%' . $searchPhrase . '%')
//                ->orderBy($sort_field, $sort_order)
//                ->offset($cur)
//                ->limit($rowCount)
//                ->get();
//        }
//        $EncryptString = new EncryptString;
//        $FileManager = new FileManager;
//        foreach ($data as $d) {
//
//            $d->ID_N = $EncryptString->encode($d->file_id);
//            $d->file_size = $FileManager->FileSizeConvert($d->size);
//        }
//        $result = array(
//            'rows' => $data,
//            'total' => $total,
//            'rowCount' => $rowCount,
//            'current' => $current
//        );
//        return json_encode($result);
    }

}


