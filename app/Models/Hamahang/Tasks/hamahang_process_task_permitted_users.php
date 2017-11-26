<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hamahang_process_task_permitted_users extends Model
{
    use SoftDeletes;
    protected $table = 'hamahang_process_task_permitted_users';

    protected $dates = ['deleted_at'];
}
