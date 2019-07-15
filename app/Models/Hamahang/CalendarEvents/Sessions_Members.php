<?php


namespace App\Models\Hamahang\CalendarEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Sessions_Members extends Model
{
    use SoftDeletes;
    protected $table = "hamahang_calendar_sessions_members";
    protected $dates = ['deleted_at'];
    protected $guarded = [];


    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function session(){
        return $this->belongsTo('App\Models\Hamahang\CalendarEvents\Session_Events','session_id','id');
    }


}