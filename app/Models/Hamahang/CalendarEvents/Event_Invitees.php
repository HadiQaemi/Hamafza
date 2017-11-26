<?php


namespace App\Models\Hamahang\CalendarEvents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Event_Invitees extends Model
{
    use SoftDeletes;
    protected $table = "hamahang_calendar_events_invitees";
    protected $dates = ['deleted_at'];
}