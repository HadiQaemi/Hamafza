<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class org_charts_items_jobs_wages extends Model
{

    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'hamahang_org_charts_items_jobs_wages';
    protected $dates = ['deleted_at'];

    public function job()
    {
        return $this->belongsTo('App\Models\Hamahang\OrgChart\org_charts_items_jobs','chart_item_job_id','id');
    }

}