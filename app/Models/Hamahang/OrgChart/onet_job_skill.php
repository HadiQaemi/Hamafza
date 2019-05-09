<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class onet_job_skill extends Model
{

    protected $guarded = [];
    protected $table = 'hamafza_onet_job_skill';

    public function skill()
    {
        return $this->belongsTo('App\Models\Hamahang\OrgChart\onet_skill','skill_id','id');
    }
}
