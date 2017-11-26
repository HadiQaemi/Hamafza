<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class task_notices extends Model {

    use softdeletes;
    public $timestamps = false;
    protected $table = 'hamahang_task_notices';

    public static function create_new_notice($task_id)
    {
        $notice = new task_notices;
        $notice->task_id = $task_id;
        $notice->save();
        return $notice;
    }

}
