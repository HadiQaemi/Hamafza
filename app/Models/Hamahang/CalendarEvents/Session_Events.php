<?php

namespace App\Models\Hamahang\CalendarEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Session_Events extends Model
{
    use SoftDeletes;
    protected $table = "hamahang_calendar_sessions_events";
    protected $dates = ['deleted_at'];
    public function event()
    {
        return $this->belongsTo('CalendarEvents\User_Event');
    }
    function chief()
    {
        return $this->hasOne('App\User','id','session_chief');
    }
    function secretary()
    {
        return $this->hasOne('App\User','id','session_secretary');
    }
    function facilitator()
    {
        return $this->hasOne('App\User','id','session_facilitator');
    }

    function agenda()
    {
        return $this->hasMany('App\Models\Hamahang\CalendarEvents\Sessions_Agenda','id','session_id');
    }

}