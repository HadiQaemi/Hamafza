<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class task_process extends Model
{
    use softdeletes;
    protected $table = 'task_process';
}
