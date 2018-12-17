<?php

namespace App\Models\Hamahang\Tasks;;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hamahang_project_task extends Model
{
    use softdeletes;
    protected $table = 'hamahang_project_task';
    public static function create_task_project($task_id, $project_id, $weight, $uid = -1)
    {

        $project_task = new hamahang_project_task;
        $project_task->uid = ($uid == -1) ? Auth::id() : $uid;
        $project_task->task_id = $task_id;
        $project_task->weight = $weight;
        $project_task->project_id = $project_id;
        $project_task->save();

        return 120;
    }
}
