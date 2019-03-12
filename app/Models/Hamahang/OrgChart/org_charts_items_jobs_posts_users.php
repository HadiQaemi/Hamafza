<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class org_charts_items_jobs_posts_users extends Model
{

    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'hamahang_org_charts_items_jobs_posts_users';
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function post()
    {
        return $this->belongsTo('App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts','chart_item_post_job_id','id');
    }

}