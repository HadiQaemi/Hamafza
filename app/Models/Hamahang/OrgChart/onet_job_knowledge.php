<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class onet_job_knowledge extends Model
{

    protected $guarded = [];
    protected $table = 'hamafza_onet_job_knowledge';

    public function knowledge()
    {
        return $this->belongsTo('App\Models\Hamahang\OrgChart\onet_knowledge','knowledge_id','id');
    }
}
