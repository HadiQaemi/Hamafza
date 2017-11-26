<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplatePosition extends Model
{
    use softDeletes;
    protected  $table = 'hamahang_template_positions';
    public function toolsPositions()
    {
        $this->belongsToMany('App\Models\Hamahang\Tools\ToolsPosition','templatepositions_toolsoption','id','position_id');
    }
    public static function getList()
    {
        $list = TemplatePosition::select('id','position','description')->get();
        return json_encode($list);
    }
    public function tools()
    {
        $this->belongsToMany('App\Models\Hamahang\Tools\Tools','hamahang_tools_position','position_id','id');
    }
}
