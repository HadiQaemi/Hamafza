<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class task_logs extends Model
{
    use softdeletes;
    protected $table = 'hamahang_task_log';

    public static function CreateNewLog($task_id,$assign_id,$type='status',$task_type=null,$new_assign_id=0,$timestamp=-1,$uid=-1)
    {
        $log = new task_logs;
        $log->uid = ($uid==-1)? Auth::id():$uid;
        $log->task_id = $task_id;
        $log->assign_id = $assign_id;
        $log->task_type = $task_type;
        $log->new_assign_id = $new_assign_id;
        $log->type = $type;
        $log->timestamp = ($timestamp==-1)?time():$timestamp;
        $log->save();
    }
}
