<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class task_files extends Model
{
    use SoftDeletes;
    public $table = 'hamahang_task_files';

    protected $dates = ['deleted_at'];
}
