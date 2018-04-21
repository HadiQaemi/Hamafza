<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class keywords extends Model
{
    use softDeletes;
    protected $table = 'keywords';

    public static function add_new_keyword($keyword)
    {
        $k = new keywords;
        $k->title = $keyword;
//        $k->uid = Auth::id();
        $k->save();

        return $k->id;
    }
}
