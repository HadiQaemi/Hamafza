<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class hamahang_process_tasks_relations extends Model
{
    use SoftDeletes;
    protected $table = 'hamahang_process_tasks_relations';
    protected $dates = ['deleted_at'];

    public static function get_process_task_relations($task_id)
    {
        $relations = DB::table('hamahang_project_task_relations')
            ->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_project_task_relations.second_task_id')
            ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_project_task_relations.second_task_id')
            ->where('hamahang_project_task_relations.first_task_id', '=', $task_id)
            ->whereNull('hamahang_project_task_relations.deleted_at')
            ->whereNull('hamahang_task_status.deleted_at')
            ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_project_task_relations.second_task_id )')
            ->select('hamahang_project_task_relations.second_task_id', 'hamahang_task.title', 'hamahang_project_task_relations.relation', 'hamahang_task_status.type')
            ->get();
        return $relations;
    }
}
