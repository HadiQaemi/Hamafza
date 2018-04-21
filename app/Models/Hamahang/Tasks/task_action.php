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

    public static function create_task_action($task_id, $action_status, $reject_description, $power_mental, $power_physical, $quality, $duration, $duration_type, $desc, $percent)
    {
        $assign = new task_action;
        $assign->uid = Auth::id();
        $assign->user_id = Auth::id();
        $assign->task_id = $task_id;
        $assign->action_status = $action_status;
        $assign->reject_description = $reject_description;
        $assign->power_mental = $power_mental;
        $assign->power_physical = $power_physical;
        $assign->quality = $quality;
        $assign->duration = $duration;
        $assign->duration_type = $duration_type;
        $assign->desc = $desc;
        $assign->percent = $percent;
        $assign->save();
        return $assign;
    }

    /*------------------------------- relations ----------------------------------------*/

}
