<?php

namespace App\Models\Hamahang\CalendarEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Sessions_Agenda extends Model
{
    use SoftDeletes;
    protected $table = "hamahang_calendar_sessions_agenda";
    protected $dates = ['deleted_at'];

}