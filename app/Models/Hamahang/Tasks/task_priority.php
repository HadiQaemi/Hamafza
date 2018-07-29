<?php

namespace App\Models\Hamahang\Tasks;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class task_priority extends Model
{
    use SoftDeletes;
    protected $table = 'hamahang_task_priority';
    protected $dates = ['deleted_at'];
    protected $fillable = ['uid', 'user_id', 'importance', 'immediate', 'timestamp'];

    public static function create_task_priority($task_id, $immediate = 0, $importance = 0, $is_assigner = [0], $user_id = -1, $uid = -1, $timestamp = -1)
    {
        if(!is_array($is_assigner))
        {
            $priority = new task_priority;
            $priority->uid = ($uid == -1) ? Auth::id() : $uid;
            $priority->user_id = ($user_id == -1) ? Auth::id() : $user_id;
            $priority->task_id = $task_id;
            $priority->is_assigner = $is_assigner;
            $priority->importance = $importance;
            $priority->immediate = $immediate;
            $priority->timestamp = ($timestamp == -1) ? time() : $timestamp;
            $priority->save();
        }else{
            foreach($is_assigner as $Ais_assigner)
            {
                $priority = new task_priority;
                $priority->uid = ($uid == -1) ? Auth::id() : $uid;
                $priority->user_id = ($user_id == -1) ? Auth::id() : $user_id;
                $priority->task_id = $task_id;
                $priority->is_assigner = $Ais_assigner;
                $priority->importance = $importance;
                $priority->immediate = $immediate;
                $priority->timestamp = ($timestamp == -1) ? time() : $timestamp;
                $priority->save();
            }
        }
        return $priority;
    }
    public static function delete_priority($task_id, $is_assigner = 0, $user_id = -1)
    {
        $user_id = ($user_id == -1) ? Auth::id() : $user_id;
        \DB::table('hamahang_task_priority')->where('is_assigner','=',$is_assigner)->where('task_id','=',$task_id)->where('uid','=',$user_id)->update(['deleted_at'=>time()]);
    }
    public static function full_create_priority($task_id, $immediate = 0, $importance = 0, $employee_id = -1, $assigner_id = -1, $uid = -1, $timestamp = -1)
    {
        self::create_task_priority($task_id, $immediate, $importance, $assigner_id , $uid, $timestamp);
        self::create_task_priority($task_id, $immediate, $importance, $employee_id, $uid, $timestamp);
    }


}
