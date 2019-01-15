<?php

namespace App\Models\Hamahang\Tasks;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class task_transcripts extends Model
{
    use softdeletes;
    protected $table = 'hamahang_task_transcript';

    public static function create_task_transcript ($task_id,$user_id,$uid=-1)
    {
        $transcript = new task_transcripts;
        $transcript->uid = ($uid==-1)?Auth::id():$uid;
        $transcript->task_id = $task_id;
        $transcript->user_id = $user_id;
        $transcript->save();
    }

    /*------------------------------- relations ----------------------------------------*/
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function Transcripter()
    {
        return $this->hasMany('App\User', 'id', 'user_id');
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
