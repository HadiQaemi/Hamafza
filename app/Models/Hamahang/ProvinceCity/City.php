<?php

namespace App\Models\Hamahang\ProvinceCity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use softdeletes;
    protected $table = "hamahang_city";

    public function province()
    {
        return $this->belongsTo('App\Models\Hamahang\ProvinceCity\Province', 'province_id');
    }

}
