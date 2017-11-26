<?php

namespace App\Models\Hamahang\Tasks;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class task_keywords extends Model
{
    use softdeletes;
    protected $table = "hamahang_task_keywords";

    public static function create_task_keyword($task_id, $key_word_id, $uid = -1)
    {

        $keyword = new task_keywords;
        $keyword->uid = ($uid == -1) ? Auth::id() : $uid;
        $keyword->task_id = $task_id;
        $keyword->keyword_id = $key_word_id;
        $keyword->save();

        return 120;
    }
}
