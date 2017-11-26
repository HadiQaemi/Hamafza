<?php



namespace App\Models\Hamahang\CalendarEvents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Persian_Event extends Model
{
    use SoftDeletes;
    protected $table = "hamahang_calendar_persian_events";
    protected $dates = ['deleted_at'];
}