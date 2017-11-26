<?php

namespace App\Models\Hamahang\Tasks;;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class process extends Model
{
    use softdeletes;
    protected $table = 'hamahang_process';
}
