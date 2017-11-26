<?php

namespace App\Models\Hamahang\Tasks;;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class hamahang_library_task_parent extends Model
{
    use softdeletes;
    protected $table = 'hamahang_library_task_parent';

    public static function save_lib_task_parent($task_id,$lib_task_id, $parent_type)
    {
        $lib_parent_task = new hamahang_library_task_parent;
        $lib_parent_task->uid = Auth::id();
        $lib_parent_task->user_id = Auth::id();
        $lib_parent_task->library_task_id = $lib_task_id;
        $lib_parent_task->parent_type = $parent_type;
        $lib_parent_task->parent_id = $task_id;
        $lib_parent_task->save();
    }
}
