<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class org_charts_items_jobs_posts extends Model
{

    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'hamahang_org_charts_items_jobs_posts';
    protected $dates = ['deleted_at'];

//    public function job()
//    {
//        return $this->hasOne('App\Models\Hamahang\OrgChart\org_charts_items_jobs', 'id', 'job_id');
//    }

    public function job()
    {
        return $this->belongsTo('App\Models\Hamahang\OrgChart\org_charts_items_jobs','chart_item_job_id','id');
    }

    public function accesses()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts_access','chart_item_post_job_id','id');
    }

    public function adventages()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts_adventage','chart_item_post_job_id','id');
    }

    public function alternate_users()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts_alternate_users','chart_item_post_job_id','id');
    }

    public function users()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts_staff','chart_item_post_job_id','id');
    }

    public function staff()
    {
        return $this->belongsTo('App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts_staff','chart_item_post_job_id','id');
    }

    public function worktime()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts_worktime','chart_item_post_job_id','id');
    }
}