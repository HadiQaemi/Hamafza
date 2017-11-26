<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostComment extends Model
{
    use softdeletes;
    protected $table = 'post_comment';

    public function getIsOwnerAttribute()
    {
        return $this->uid == auth()->id();
    }

    public function getJalaliRegDateAttribute()
    {
        return HDate_GtoJ($this->reg_date, "H:i - Y/m/d");
    }

    public function getJalaliRegDateNameAttribute()
    {
        $diff = h_human_date($this->reg_date);
        $r = false === $diff ? $this->JalaliRegDate : "$diff " . trans('enquiry.past');
        return $r;
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'uid');
    }

}

