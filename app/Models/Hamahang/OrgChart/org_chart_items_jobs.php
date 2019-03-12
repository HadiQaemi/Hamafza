<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class org_chart_items_jobs extends Model
{

    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'hamahang_org_charts_items_jobs';
    protected $dates = ['deleted_at'];

    public function job()
    {
        return $this->hasOne('App\Models\Hamahang\OrgChart\onet_job', 'id', 'job_id');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts','chart_item_job_id','id');
    }
}
