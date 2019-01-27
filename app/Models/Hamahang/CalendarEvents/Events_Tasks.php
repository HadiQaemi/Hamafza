<?php


namespace app\Models\Hamahang\CalendarEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Events_Tasks extends Model
{
    use SoftDeletes;
    protected $table = "hamahang_calendar_events_task";
    protected $dates = ['deleted_at'];

    /*---------------------------------------------- relations --------------------------------------------*/
    public function Events()
    {
        return $this->hasOne('App\Models\Hamahang\CalendarEvents\User_Event', 'id', 'event_id');
    }

    public function User()
    {
        return $this->hasOne('App\User', 'id', 'uid');
    }
}