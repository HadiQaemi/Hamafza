<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class hamahang_tasks_library extends Model
{
    use softdeletes;
    protected $table = 'hamahang_tasks_library';

    public static function save_task_in_lib($task_id, $type)
    {
        switch ($type)
        {
            case 0:
            {
                DB::transaction(function ($task_id) use ($task_id)
                {
                    $task_info = DB::table('hamahang_task')
                        ->select('hamahang_task.*', 'assignments.employee_id')
                        ->join('hamahang_task_assignments AS assignments', 'assignments.task_id', '=', 'hamahang_task.id')
                        ->where('hamahang_task.id', '=', $task_id)
                        ->where('hamahang_task.uid', '=', Auth::id())
                        ->whereNull('hamahang_task.deleted_at')
                        ->whereNull('assignments.transmitter_id')
                        ->first();

                    $lib_task = new hamahang_tasks_library;
                    $lib_task->uid = Auth::id();
                    $lib_task->user_id = Auth::id();
                    $lib_task->title = $task_info->title;
                    $lib_task->desc = $task_info->desc;
                    $lib_task->type = $task_info->type;
                    $lib_task->report_on_create_point = $task_info->report_on_create_point;
                    $lib_task->report_on_completion_point = $task_info->report_on_completion_point;
                    $lib_task->report_to_managers = $task_info->report_to_managers;
                    $lib_task->duration_timestamp = $task_info->duration_timestamp;
                    $lib_task->transferable = $task_info->transferable;
                    $lib_task->immediate = 0;
                    $lib_task->importance = 0;
                    $lib_task->users = $task_info->employee_id;

                    $transcripts = DB::table('hamahang_task_transcript')
                        ->where('hamahang_task_transcript.task_id', '=', $task_info->id)
                        ->whereNull('hamahang_task_transcript.deleted_at')
                        ->get();

                    $lib_task->transcripts = serialize($transcripts);
                    $keywords = DB::table('hamahang_task_keywords')
                        ->where('hamahang_task_keywords.task_id', '=', $task_info->id)
                        ->whereNull('deleted_at')
                        ->get();
                    $lib_task->keywords = serialize($keywords);
                    $lib_task->save();
                    hamahang_library_task_parent::save_lib_task_parent($task_id, $lib_task->id, 0);
                });
                break;
            }

            case 1:
            {
                braek;
            }

            case 2:
            {
                DB::transaction(function ($task_id) use ($task_id)
                {
                    $task_info = process_task::where('id', '=', Request::input('task_id'))
                        ->first();
                    $lib_task = new hamahang_tasks_library;
                    $lib_task->uid = Auth::id();
                    $lib_task->user_id = Auth::id();
                    $lib_task->title = $task_info->title;
                    $lib_task->desc = $task_info->desc;
                    $lib_task->type = $task_info->type;
                    $lib_task->report_on_create_point = $task_info->report_on_create_point;
                    $lib_task->report_on_completion_point = $task_info->report_on_completion_point;
                    $lib_task->report_to_managers = $task_info->report_to_managers;
                    $lib_task->duration_timestamp = $task_info->respite;
                    $lib_task->transferable = $task_info->transferable;
                    $lib_task->immediate = 0;
                    $lib_task->importance = 0;
                    $lib_task->users = $task_info->employee_id;
                    $lib_task->transcripts = $task_info->transcripts;
                    $lib_task->keywords = $task_info->keywords;
                    $lib_task->save();
                    hamahang_library_task_parent::save_lib_task_parent($task_id, $lib_task->id, 2);

                });
            }
        }
    }
}