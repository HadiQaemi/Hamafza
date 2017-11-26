<?php

namespace App\Models\Hamahang\Tools;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolsPosition extends Model
{
    use SoftDeletes;
    protected $table ='hamahang_tools_position';
    protected $dates = ['deleted_at'];


}
