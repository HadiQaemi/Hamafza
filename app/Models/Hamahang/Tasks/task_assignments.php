<?php

namespace App\Models\Hamahang\Tasks;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class task_assignments extends Model
{
    use SoftDeletes;
    public $table = 'hamahang_task_assignments';
    protected $dates = ['deleted_at'];

    public static function create_task_assignment($employee_id,$staff_id , $task_id, $assigner_id = null, $reject_description = null, $uid = -1)
    {
        $assign = new task_assignments;
        $assign->uid = ($uid == -1) ? Auth::id() : $uid;
        $assign->assigner_id = $assigner_id == null ? 0 : $assigner_id;
        $assign->employee_id = $employee_id;
        $assign->task_id = $task_id;
//        $assign->is_response = $is_response;
//        $assign->transferred_to_id = $transferer_to;
//        $assign->transmitter_id = $transmitter_id;
        $assign->staff_id = $staff_id;
        $assign->reject_description = $reject_description;
        $assign->save();
        return $assign;
    }

    /*------------------------------- relations ----------------------------------------*/
    public function Assigner()
    {
        return $this->hasOne('App\User', 'id', 'uid');
    }

    public function Employee()
    {
        return $this->hasOne('App\User', 'id', 'employee_id');
    }

    public function Transmitter()
    {
        return $this->hasOne('App\User', 'id', 'transmitter_id');
    }

    public function TransferredTo()
    {
        return $this->hasOne('App\User', 'id', 'transferred_to_id');
    }

    public function Task()
    {
        return $this->belongsTo('App\Models\Hamahang\Tasks\tasks', 'task_id', 'id');
    }
}
