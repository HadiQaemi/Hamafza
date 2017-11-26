<?php

namespace App\Models\Hamahang\CalendarEvents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Events extends Model
{
    use SoftDeletes;
    protected $table = "hamahang_calendar_events";
    protected $dates = ['deleted_at'];
}
