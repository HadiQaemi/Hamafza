<?php

namespace App\Models\Hamahang\Tools;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ToolsAvailable extends Model
{
    use SoftDeletes;
    protected $table ='hamahang_tools_available';
    protected $dates = ['deleted_at'];
    public function getList()
    {
        $list = ToolsAvailable::select('id','title')->get();
        return json_encode($list);

    }
    public function tools()
    {
        return $this->hasMany('App\Models\Hamahang\Tools\Tools','available_id');
    }

}
