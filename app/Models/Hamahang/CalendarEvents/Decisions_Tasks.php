<?php


namespace app\Models\Hamahang\CalendarEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Decisions_Tasks extends Model
{
    use SoftDeletes;
    protected $table = "hamahang_calendar_events_decision_task";
    protected $dates = ['deleted_at'];
}