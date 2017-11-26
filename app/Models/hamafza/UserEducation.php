<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEducation extends Model
{
    use softdeletes;
    protected  $table = 'user_education';

    public function getJalaliStartYearAttribute()
    {
        return HDate_GtoJ($this->start_year, 'Y/m/d');
    }

    public function getJalaliEndYearAttribute()
    {
        return HDate_GtoJ($this->end_year, 'Y/m/d');
    }

    public function province()
    {
        return $this->hasOne('App\Models\Hamahang\ProvinceCity\Province', 'id', 'province_id');
    }

    public function city()
    {
        return $this->hasOne('App\Models\Hamahang\ProvinceCity\City', 'id', 'city_id');
    }

    public function setStartYearAttribute($value)
    {
        $this->attributes['start_year'] = HDate_JtoG($value,'/',true);
    }

    public function setEndYearAttribute($value)
    {
        $this->attributes['end_year'] = HDate_JtoG($value,'/',true);
    }
}

