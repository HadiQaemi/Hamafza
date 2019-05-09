<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class onet_job_ability extends Model
{

    protected $guarded = [];
    protected $table = 'hamafza_onet_job_ability';

    public function ability()
    {
        return $this->belongsTo('App\Models\Hamahang\OrgChart\onet_ability','ability_id','id');
    }
}
