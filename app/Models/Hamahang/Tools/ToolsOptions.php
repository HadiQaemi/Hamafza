<?php

namespace App\Models\Hamahang\Tools;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolsOptions extends Model
{
    use SoftDeletes;
    protected $table ='hamahang_tools_options';
    protected $dates = ['deleted_at'];

}

