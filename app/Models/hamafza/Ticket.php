<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use softdeletes;
    protected  $table = 'tickets';
    protected $primaryKey = 'id';

    public function sender_user()
    {
        return $this->belongsTo('App\User','uid','id');
    }

    public function receiver_users()
    {
        return $this->belongsToMany('App\User','ticket_recieve','tid','uid');
    }

    public function ticket_answer()
    {
        return $this->hasOne('App\Models\hamafza\TicketAnswer','tid','id');
    }

    public function ticket_files()
    {
//        return $this->belongsToMany('App\User','ticket_answer','tid','uid');
        return $this->hasMany('App\Models\hamafza\TicketFile','aid','id');
    }

    public function files()
    {
        return $this->morphToMany('App\Models\Hamahang\FileManager\FileManager', 'fileable', 'fileables', 'fileable_id', 'file_id')->where('type', 1)->withTimestamps();
    }

    public function getJalaliRegDateAttribute()
    {
        return HDate_GtoJ($this->reg_date, "Y/m/d - H:i");
    }

    public function getJalaliAnswerDateAttribute()
    {
        return HDate_GtoJ($this->answer_date, "Y/m/d - H:i");
    }
}

