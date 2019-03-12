<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class org_charts_items_jobs_posts_worktime extends Model
{

    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'hamahang_org_charts_items_jobs_posts_worktime';
    protected $dates = ['deleted_at'];

    public function job()
    {
        return $this->hasOne('App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts', 'id', 'job_id');
    }
}