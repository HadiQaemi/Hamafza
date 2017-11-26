<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announces extends Model
{
    use softdeletes;
    protected  $table = 'announces';

    public function Users()
    {
        return $this->belongsTo('App\User','uid','id');
    }

    public function page()
    {
        return $this->belongsTo('App\Models\hamafza\Pages','pid','id');
    }

    public function getJalaliRegDateAttribute()
    {
        return HDate_GtoJ($this->reg_date, "Y/m/d - H:i");
    }
}

