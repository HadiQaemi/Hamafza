<?php

namespace App\Models\Hamahang\Calendar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Calendar_Sharing extends Model
{
    use SoftDeletes;
    protected $table = "hamahang_calendar_sharing_events";
    protected $dates = ['deleted_at'];
}
