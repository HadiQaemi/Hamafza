<?php


namespace app\Models\Hamahang\CalendarEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Event_Reminder extends Model
{
    use SoftDeletes;
    protected $table = "hamahang_calendar_events_reminders";
    protected $dates = ['deleted_at'];
}