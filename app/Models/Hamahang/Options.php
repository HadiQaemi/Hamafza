<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Options extends Model
{
    use softDeletes;
    protected  $table = 'hamahang_options';
    public static function getList()
    {
        $list = Options::select('id','title','description')->get();
        return json_encode($list);
    }
    public function tools()
    {
        return $this->belongsToMany('\App\Models\Hamahang\Tools\Tools','hamahang_tools_options','option_id','id');
    }
}

