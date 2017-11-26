<?php

namespace App\Models\Hamahang\Tasks;;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class process_keyword extends Model
{
    use softdeletes;
    protected $table = 'hamahang_process_keyword';

    public static function assign_process_keyword($key_id , $process_id)
    {
        $keyword = new process_keyword;
        $keyword->uid = Auth::id();
        $keyword->keyword_id = $key_id;
        $keyword->process_id = $process_id;
        $keyword->save();
    }
}
