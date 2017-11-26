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

    public static function create_task_assignment($employee_id, $task_id, $transferer_to = null, $transmitter_id = null, $reject_description = null, $assigner_id = -1, $uid = -1)
    {
        $assign = new task_assignments;
        $assign->uid = ($uid == -1) ? Auth::id() : $uid;
        $assign->assigner_id = ($assigner_id == -1) ? Auth::id() : $assigner_id;
        $assign->employee_id = $employee_id;
        $assign->task_id = $task_id;
        $assign->transferred_to_id = $transferer_to;
        $assign->transmitter_id = $transmitter_id;
        $assign->reject_description = $reject_description;
        $assign->save();
        return $assign;
    }

    /*------------------------------- relations ----------------------------------------*/
    public function Assigner()
    {
        return $this->hasOne('App\User', 'id', 'assigner_id');
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
