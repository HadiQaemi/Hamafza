<?php


namespace app\Models\Hamahang\CalendarEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Sessions_Members extends Model
{
    use SoftDeletes;
    protected $table = "hamahang_calendar_sessions_members";
    protected $dates = ['deleted_at'];


}