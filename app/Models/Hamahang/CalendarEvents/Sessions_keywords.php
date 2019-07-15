<?php


namespace app\Models\Hamahang\CalendarEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Sessions_keywords extends Model
{
    use SoftDeletes;
    protected $table = "hamahang_calendar_sessions_keywords";
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function keyword(){
        return $this->belongsTo('App\Models\hamafza\Keyword', 'keyword_id', 'id');
    }

}