<?php

namespace App\Models\Hamahang\Scheduler;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scheduler extends Model
{
    use softdeletes;
    //protected $table = "schedule";

}
