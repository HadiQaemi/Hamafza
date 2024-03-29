<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pages extends Model
{
    use softdeletes;
    public $timestamps = false;
    protected  $table = 'pages';
    
    public function subject()
    {
        return $this->belongsTo('App\Models\hamafza\Subject','sid');
    }

    public function highlights()
    {
       return $this->hasMany('App\Models\hamafza\Highlight','pid');
    }

    public function announces()
    {
       return $this->hasMany('App\Models\hamafza\Announces','pid');
    }

    public function user_suggests()
    {
       return $this->hasMany('App\Models\Hamahang\UserSuggest','tid');
    }

    public function page_visit()
    {
       return $this->hasMany('App\Models\Hamahang\PageVisit','pid');
    }

    public function files()
    {
        return $this->morphToMany('App\Models\Hamahang\FileManager\FileManager', 'fileable', 'fileables', 'fileable_id', 'file_id')->where('type', 2);
    }

    public function getTabNameAttribute()
    {
        if(isset($this->subject))
        {
            $subject = $this->subject;
            if (isset($subject->tabs[$this->type]))
            {
                return $this->subject->tabs[$this->type]->name;
            }
        }
        return "";
    }

    public function getTabHelpAttribute()
    {
        if(isset($this->subject))
        {
            $subject = $this->subject;
            if (isset($subject->tabs[$this->type]))
            {
                $hpid = $this->subject->tabs[$this->type]->help_pid;
                return $hpid ? enCode($hpid) : 0;
            }
        }
        return 0;
    }

    public function help()
    {
        return $this->morphToMany('App\Models\Hamahang\Help', 'target', 'hamahang_help_relations', 'target_id', 'help_id')->withTimestamps();
    }
}

