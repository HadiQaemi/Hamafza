<?php

namespace App\Models\Hamahang\Calendar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Calendar_Hiddentimes extends Model
{
    use SoftDeletes;
    protected $table = "hamahang_calendar_hiddentimes";
    protected $dates = ['deleted_at'];


    public function getCalendarHiddenTimes($id)
    {
        $hiddenTimes = Calendar_Hiddentimes::where('calendar_id', '=', $id)->whereNull('deleted_at')->get();
        return $hiddenTimes;
    }
}