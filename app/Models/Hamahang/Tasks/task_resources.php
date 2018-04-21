<?php

namespace App\Models\Hamahang\Tasks;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class task_resources extends Model
{
    use softdeletes;
    protected $table = "hamahang_task_resources";

    public static function create_task_resource($task_id, $amount, $cost, $resource_id, $uid = -1)
    {

        $keyword = new task_resources;
        $keyword->uid = ($uid == -1) ? Auth::id() : $uid;
        $keyword->task_id = $task_id;
        $keyword->amount = $amount;
        $keyword->cost = $cost;
        $keyword->resource_id = $resource_id;
        $keyword->save();

        return 120;
    }
}
