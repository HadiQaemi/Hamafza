<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class project_task extends Model
{
    use softdeletes;
    protected $table = 'hamahang_project_task';

    public static function add_task_to_project($task_id,$project_id,$uid=-1,$type="App\Models\Hamahang\Tasks\tasks")
    {
        $project_task = new project_task;
        $project_task->task_id = $task_id;
        $project_task->project_id = $project_id;
        $project_task->target_type = $type;
        $project_task->uid = ($uid == -1)?auth()->id():$uid;
        $project_task->save();
        return $project_task;
    }

    /*------------------------------- relations ----------------------------------------*/
//    public function Project()
//    {
//        return $this->belongsTo('App\Models\Hamahang\Tasks\task_project', 'project_id', 'id');
//    }

    public function Task()
    {
        return $this->hasOne('App\Models\Hamahang\Tasks\tasks', 'id', 'task_id');
    }
}
