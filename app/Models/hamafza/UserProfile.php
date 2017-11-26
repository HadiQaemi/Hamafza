<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use softdeletes;
    protected $table = 'user_profile';

    public function user()
    {
        return $this->belongsTo('App\User', 'uid');
    }

    public function getBirthDateAttribute($value)
    {
        if (isset($value))
        {
            return HDate_GtoJ($value, 'Y/m/d');
        }
        else
        {
            return '';
        }
    }

    public function getJalaliBirthDateAttribute($value)
    {
        return HDate_GtoJ($this->birth_date, 'Y/m/d');
    }

    public function province()
    {
        return $this->hasOne('App\Models\Hamahang\ProvinceCity\Province', 'id', 'Province');
    }

    public function city()
    {
        return $this->hasOne('App\Models\Hamahang\ProvinceCity\City', 'id', 'City');
    }

    public function getMobileAttribute($value)
    {
        return $value;
    }

    public function getTelNumberAttribute($value)
    {
        if (isset($value))
        {
            return $value;
        }
        else
        {
            return '';
        }
    }

    public function getTelCodeAttribute($value)
    {
        if (isset($value))
        {
            return $value;
        }
        else
        {
            return '';
        }
    }

    public function getFaxNumberAttribute($value)
    {
        if (isset($value))
        {
            return $value;
        }
        else
        {
            return '';
        }
    }

    public function getFaxCodeAttribute($value)
    {
        if (isset($value))
        {
            return $value;
        }
        else
        {
            return '';
        }
    }

    public function getWebsiteAttribute($value)
    {
        if (isset($value))
        {
            return $value;
        }
        else
        {
            return '';
        }
    }


}

