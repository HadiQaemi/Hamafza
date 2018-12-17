<?php

namespace App\Models\Hamahang\Tasks;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class task_relations extends Model
{
    use SoftDeletes;
    protected $table = 'hamahang_task_relations';
    protected $dates = ['deleted_at'];

    public static function create_task_relation($task_id1, $task_id2, $delay, $delay_type, $relation, $weight, $uid = -1)
    {
        $temp = '';
        if($relation == 'end_start')
        {
            $delay_type == 'start_end';
            $temp = $task_id1;
            $task_id1 = $task_id2;
            $task_id2 = $temp;
        }
        if($relation == 'down')
        {
            $relation = 'up';
            $temp = $task_id1;
            $task_id1 = $task_id2;
            $task_id2 = $temp;
        }
        $relations = new task_relations;
        $relations->uid = ($uid == -1) ? Auth::id() : $uid;
        $relations->task_id1 = $task_id1;
        $relations->task_id2 = $task_id2;
        $relations->delay = $delay;
        $relations->delay_type = $delay_type;
        $relations->relation = $relation;
        $relations->weight = $weight;
        $relations->save();

        return 120;
    }
}
