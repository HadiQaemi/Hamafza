<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class task_rejections extends Model
{
    use softdeletes;
    protected $table = 'hamahang_task_rejection';
}
