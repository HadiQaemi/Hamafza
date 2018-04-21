<?php

namespace App\Models\Hamahang\Tasks;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class task_schedule extends Model
{
    use SoftDeletes;
    protected $table = 'hamahang_task_schedule';
    protected $dates = ['deleted_at'];

    public static function create_task_schedule($task_id, $schedule_type, $schedule_attributes, $start, $end_type, $end_time, $end_event, $event_done =0 , $uid = -1)
    {

        $keyword = new task_schedule;
        $keyword->uid = ($uid == -1) ? Auth::id() : $uid;
        $keyword->task_id = $task_id;
        $keyword->schedule_type = $schedule_type;
        $keyword->schedule_attributes = $schedule_attributes;
        $keyword->start = $start;
        $keyword->end_type = $end_type;
        $keyword->end_time = $end_time;
        $keyword->end_event = $end_event;
        $keyword->event_done = $event_done;
        $keyword->save();

        return 120;
    }
}
