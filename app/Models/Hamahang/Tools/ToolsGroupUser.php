<?php

namespace App\Models\Hamahang\Tools;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolsGroupUser extends Model
{
    use softdeletes;
    protected $table ='hamahang_access_tools_group_user';
}
