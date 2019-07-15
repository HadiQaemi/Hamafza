<?php

namespace App\Models\Hamahang\CalendarEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Session_Events extends Model
{
    use SoftDeletes;
    protected $table = "hamahang_calendar_sessions_events";
    protected $dates = ['deleted_at'];
    protected $guarded = [];

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

    function agendas()
    {
        return $this->hasMany('App\Models\Hamahang\CalendarEvents\Sessions_Agenda','session_id','id');
    }

    function calendars()
    {
        return $this->hasMany('App\Models\Hamahang\CalendarEvents\Sessions_Calendars','session_id','id');
    }

    function keywords()
    {
        return $this->hasMany('App\Models\Hamahang\CalendarEvents\Sessions_keywords','session_id','id');
    }

    function members()
    {
        return $this->hasMany('App\Models\Hamahang\CalendarEvents\Sessions_Members','session_id','id');
    }

    function pages()
    {
        return $this->hasMany('App\Models\Hamahang\SubjectAbles','target_id','id')
            ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\CalendarEvents\\Session_Events')->whereNull('deleted_at')
            ;
    }

}