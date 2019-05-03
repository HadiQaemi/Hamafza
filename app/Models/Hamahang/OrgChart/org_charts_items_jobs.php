<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class org_charts_items_jobs extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'hamahang_org_charts_items_jobs';
    protected $dates = ['deleted_at'];

    public function job()
    {
        return $this->belongsTo('App\Models\Hamahang\OrgChart\onet_job', 'job_id', 'id');
    }
    public function posts()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts', 'chart_item_job_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Hamahang\OrgChart\org_chart_items', 'chart_item_id', 'id');
    }

    public function wage()
    {
        return $this->hasOne('App\Models\Hamahang\OrgChart\org_charts_items_jobs_wages', 'chart_item_job_id', 'id');
    }
}