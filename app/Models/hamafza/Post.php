<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use softdeletes;
    protected $table = 'posts';

    public function getHasAnsweredAttribute()
    {
         return (bool) $this::where('uid', auth()->id())->where('type', '201')->where('parent_id', $this->id)->count();
    }

    public function getIsOwnerAttribute()
    {
        return $this->uid == auth()->id();
    }

    public function getHasVotedAttribute()
    {
        $r = false;
        $result = $this->votes->where('uid', auth()->id());
        if ($result->count())
        {
            $r = $result->first()->type;
        }
        return $r;
    }

    public function getIsLikedAttribute()
    {
        $r = $this->user_likes->where('uid', auth()->id())->count() ? false : true;
        return $r;
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

    public function getTotalRewardAttribute()
    {
        $res = 0;
        foreach ($this->reward AS $r) { $res += $r->score; }
        return $res;
    }

    public function getVoteCountAttribute()
    {
        return $this->votes->count();
    }

    public function getVoteSumAttribute()
    {
        return $this->votes->sum('type');
    }

    public function getAnswerCountAttribute()
    {
        return $this->answers->count();
    }

    public function getHumanCreateTimeAttribute()
    {
        return h_human_date($this->reg_date)?h_human_date($this->reg_date)." قبل":HDate_GtoJ(date('Y/m/d H:M', $this->reg_date));
    }

    public function reward()
    {
        return $this->morphMany('App\Models\Hamahang\Reward', 'hamahang_rewards', 'target_table', 'target_id');
    }

    public function scores()
    {
        return $this->morphMany('App\Models\Hamahang\Score', 'hamahang_scores', 'target_table', 'target_id');
    }

    public function keywords()
    {
        return $this->belongsToMany('App\Models\hamafza\Keyword','post_keys', 'pid', 'kid');
    }

    public function answers()
    {
        return $this->hasMany('App\Models\hamafza\Post', 'parent_id', 'id')->where('type', '201')->where('uid', '!=', '0')->orderBy('accepted', 'desc');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\hamafza\PostComment', 'pid', 'id');
    }

    public function user_likes()
    {
        return $this->hasMany('App\Models\hamafza\PostLike', 'pid', 'id');
    }

    public function votes()
    {
        return $this->morphMany('App\Models\Hamahang\Vote', 'hamahang_votes', 'target_table', 'target_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'uid');
    }

    public function subject()
    {
        return $this->belongsTo('App\Models\hamafza\Subject', 'sid','id');
    }

    /*
    public function votes_count()
    {
        return $this->morphMany('App\Models\Hamahang\Vote', 'hamahang_votes', 'target_table', 'target_id')->count();
    }
    */

}

