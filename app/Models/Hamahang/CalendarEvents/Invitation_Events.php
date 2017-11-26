<?php

namespace App\Models\Hamahang\CalendarEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitation_Events extends Model
{
    use SoftDeletes;
    protected $table = "hamahang_calendar_invitation_events";
    protected $dates = ['deleted_at'];

}