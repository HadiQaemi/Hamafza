<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSpecial extends Model
{
    use softdeletes;
    protected $table = 'user_special';

    public function endorse_users()
    {

        return $this->belongsToMany('App\User', 'user_special_endorse', 'user_special_id', 'user_id');
    }

    public function getEndorsedByMeAttribute()
    {
        $res = $this->endorse_users()->select('user.id')->get()->toArray();
        $endorsed_user_ids = array_column($res,'id');
        if(in_array(auth()->id(),$endorsed_user_ids))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function getEndorsedByMeMobile($id)
    {
        $res = $this->endorse_users()->select('user.id')->get()->toArray();
        $endorsed_user_ids = array_column($res,'id');
        if(in_array($id,$endorsed_user_ids))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getCountEndorseAttribute()
    {
        $res = $this->endorse_users()->select('user.id')->get()->toArray();
        return count($res);
    }

    public function keyword()
    {
        return $this->hasOne('App\Models\hamafza\Keyword', 'id', 'keyword_id');
    }


}

