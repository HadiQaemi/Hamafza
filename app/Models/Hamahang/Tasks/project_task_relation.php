<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class project_task_relation extends Model
{
    use SoftDeletes;
    protected $table = 'hamahang_project_task_relations';
}
