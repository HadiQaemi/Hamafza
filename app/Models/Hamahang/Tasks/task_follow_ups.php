<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class task_follow_ups extends Model
{
    use softdeletes;
	protected $table = 'hamahang_task_follow_up';
	public $timestamps = false;

	public static function CreateNewFollowUpRecord($ass_id,$desc,$task_id)
    {
        $follow_up = new task_follow_ups();
        $follow_up->uid = Auth::id();
        $follow_up->assign_id = $ass_id;
        $follow_up->description = $desc;
        $follow_up->timestamp = time();
        $follow_up->employee_id = null;
        $follow_up->task_id = $task_id;
        $follow_up->save();
    }
}
