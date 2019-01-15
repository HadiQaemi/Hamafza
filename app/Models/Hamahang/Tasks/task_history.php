<?php

namespace App\Models\Hamahang\Tasks;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class task_history extends Model
{
    use softdeletes;
    protected $table = "hamahang_task_history";

    public static function create_task_history($task_id, $operation_type, $operation_value, $descript=null, $uid = -1)
    {

        $keyword = new task_history;
        $keyword->uid = ($uid == -1) ? Auth::id() : $uid;
        $keyword->operator_id = ($uid == -1) ? Auth::id() : $uid;
        $keyword->task_id = $task_id;
        $keyword->descript = $descript;
        $keyword->operation_type = $operation_type;
        $keyword->operation_value = $operation_value;
        $keyword->save();

        return 120;
    }
    public static function GetTaskHistory($id)
    {
        $total = DB::table('hamahang_task_history')
            ->join('user', 'hamahang_task_history.operator_id', '=', 'user.id')
            ->whereNull('hamahang_task_history.deleted_at')
            ->where('hamahang_task_history.task_id', '=', $id)
            ->select('hamahang_task_history.*', 'user.Name', 'user.Family')
            ->get();

        return $total;
    }
    /*------------------------------- relations ----------------------------------------*/
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'uid');
    }
}
