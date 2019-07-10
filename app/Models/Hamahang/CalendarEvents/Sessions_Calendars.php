<?php


namespace app\Models\Hamahang\CalendarEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Sessions_Calendars extends Model
{
    use SoftDeletes;
    protected $table = "hamahang_calendar_sessions_calendars";
    protected $dates = ['deleted_at'];


}