<?php

namespace App\Models\Hamahang\Tasks;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class tasks_relations extends Model
{
    use SoftDeletes;
    protected $table = 'hamahang_task_relations';
    protected $dates = ['deleted_at'];

    public static function create_task_relation($task_id1, $task_id2, $delay, $delay_type, $relation, $weight, $uid = -1)
    {

        $keyword = new tasks_relations;
        $keyword->uid = ($uid == -1) ? Auth::id() : $uid;
        $keyword->task_id1 = $task_id1;
        $keyword->task_id2 = $task_id2;
        $keyword->delay = $delay;
        $keyword->delay_type = $delay_type;
        $keyword->relation = $relation;
        $keyword->weight = $weight;
        $keyword->save();

        return 120;
    }
}
