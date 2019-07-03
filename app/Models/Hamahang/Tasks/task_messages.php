<?php

namespace App\Models\Hamahang\Tasks;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class task_messages extends Model {

    use softdeletes;
    public $timestamps = false;
    protected $table = 'hamahang_task_messages';

    public static function create_new_message($task_id, $message)
    {
        $notice = new task_messages;
        $notice->task_id = $task_id;
        $notice->message = $message;
        $notice->uid = Auth::id();
        $notice->save();
        return $notice;
    }
    public function user()
    {
        return $this->belongsTo('App\User','uid','id');
    }

}
