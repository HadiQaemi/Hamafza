<?php


namespace app\Models\Hamahang\CalendarEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class User_Event extends Model
{
    use SoftDeletes;
    protected $table = "hamahang_calendar_user_events";
    protected $dates = ['deleted_at'];
    public function session()
    {
        return $this->hasOne('CalendarEvents\Session_Events');
    }
    public static function setType($rec_id,$type)
    {   //DB::enableQueryLog();
        DB::table('hamahang_calendar_user_events')
            ->where('id','=',$rec_id)
            ->update(['type'=>$type]);
        //die(dd(DB::getQueryLog()));

    }

}