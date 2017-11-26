<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class project_keyword extends Model
{
    use softdeletes;
    protected $table = 'hamahang_project_keyword';

    public static function assign_project_keyword($project_id , $keyword_id)
    {
        $p_keyword = new project_keyword;
        $p_keyword->title = $keyword_id;
        $p_keyword->project_id = $project_id;
        $p_keyword->uid = Auth::id();
        $p_keyword->save();
    }
}
