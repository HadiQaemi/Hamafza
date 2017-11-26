<?php
namespace App\Models\Hamahang\CalendarEvents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Sessions_Decisions extends Model
{
use SoftDeletes;
protected $table = "hamahang_calendar_sessions_decisions";
protected $dates = ['deleted_at'];
}