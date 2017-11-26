<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class task_qualities extends Model
{
    use softdeletes;
    protected $table = 'hamahang_task_quality';
    //public $timestamps = false;

}
