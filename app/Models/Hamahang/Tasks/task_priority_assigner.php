<?php

namespace App\Models\Hamahang\Tasks;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class task_priority_assigner extends Model
{
    use SoftDeletes;
    protected $table = 'hamahang_task_priority_assigner';
    protected $dates = ['deleted_at'];
    protected $fillable = ['uid', 'user_id', 'importance', 'immediate', 'timestamp'];

    public static function create_task_priority_assigner($task_id, $immediate = 0, $importance = 0, $user_id = -1, $uid = -1, $timestamp = -1)
    {
        $priority = new task_priority_assigner;
        $priority->uid = ($uid == -1) ? Auth::id() : $uid;
        $priority->user_id = ($user_id == -1) ? Auth::id() : $user_id;
        $priority->task_id = $task_id;
        $priority->importance = $importance;
        $priority->immediate = $immediate;
        $priority->timestamp = ($timestamp == -1) ? time() : $timestamp;
        $priority->save();
        return $priority;
    }
    public static function full_create_priority_assigner($task_id, $immediate = 0, $importance = 0, $employee_id = -1, $assigner_id = -1, $uid = -1, $timestamp = -1)
    {
        self::create_task_priority_assigner($task_id, $immediate, $importance, $assigner_id , $uid, $timestamp);
        self::create_task_priority_assigner($task_id, $immediate, $importance, $employee_id, $uid, $timestamp);
    }
}
