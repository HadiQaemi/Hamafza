<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class onet_job extends Model
{

    protected $guarded = [];
    protected $table = 'hamafza_onet_job';


    public function skill()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\onet_job_skill','job_id','id');
    }

    public function ability()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\onet_job_ability','job_id','id');
    }

    public function knowledge()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\onet_job_knowledge','job_id','id');
    }
}
