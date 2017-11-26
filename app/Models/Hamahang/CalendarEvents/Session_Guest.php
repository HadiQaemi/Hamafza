<?php

namespace App\Models\Hamahang\CalendarEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Session_Guest extends Model
{
    use SoftDeletes;
    protected $table = "hamahang_calendar_events_session_guest";
    protected $dates = ['deleted_at'];

}