<?php

namespace App\Models\Hamahang\Tasks;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class task_action extends Model
{
    use SoftDeletes;
    public $table = 'hamahang_task_action';
    protected $dates = ['deleted_at'];

    public static function create_task_action($task_id, $task_status, $percent, $action_status,$reject_description,
                                              $power_mental, $power_physical, $quality, $duration, $duration_type, $desc)
    {
        $action = new task_action;
        $action->uid = Auth::id();
        $action->user_id = Auth::id();
        $action->task_id = $task_id;
        $action->task_status = $task_status;
        $action->percent = $percent;
        $action->action_status = $action_status;
        $action->reject_description = $reject_description;
        $action->power_mental = $power_mental;
        $action->power_physical = $power_physical;
        $action->quality = $quality;
        $action->duration = $duration;
        $action->duration_type = $duration_type;
        $action->desc = $desc;
        $action->save();
        return $action;
    }

    /*------------------------------- relations ----------------------------------------*/

}
