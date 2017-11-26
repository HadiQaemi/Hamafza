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
}
