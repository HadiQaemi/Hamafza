<?php

namespace App\Models\Hamahang\TimeAllocation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeAllocation extends Model
{
    use SoftDeletes;
    protected $table ='hamahang_time_allocation';
    protected $dates = ['deleted_at'];

}
