<?php

namespace App\Models\Hamahang\Tasks;


use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;


class task_inheritance extends Model
{
    use softdeletes;
    protected $table = 'hamahang_task_inheritance';

    public static function RemoveTaskChild($id)
    {
        $child = task_inheritance::where('id', '=', $id)->first();
        $child->deleted_at = 'x';
        $child->save();
    }

    public static function AddTaskChilds($t,$task_id)
    {
        $task = new task_inheritance;
        $task->task_id = $t;
        $task->parent_task_id = $task_id;
        $task->uid = Auth::id();
        $task->save();
    }

    public static function FetchTaskChildsList($id)
    {
        $task_id = task_assignments::where('id', '=', $id)->firstOrFail()->task_id;
        DB::table('hamahang_task_inheritance')
            ->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_task_inheritance.task_id')
            ->where('parent_task_id', '=', $task_id)
            ->whereNull('hamahang_task_inheritance.deleted_at')
            ->select('hamahang_task_inheritance.id as id', 'hamahang_task_inheritance.weight as weight', 'hamahang_task.title as title')
            ->get();
    }
}
