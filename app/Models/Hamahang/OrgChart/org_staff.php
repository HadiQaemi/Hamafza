<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class org_staff extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'hamahang_org_staff';
    protected $fillable = [
        'uid','first_name','last_name','national_id','mobile','birth_date','is_married','is_man',
        'home_type','contract_type','insurance_num','veteran_precent','captivity_duration','time_war','phone','address'
    ];

    public function edus()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_staff_edu','staff_id','id');
    }

    public function posts()
    {
        return $this->belongsToMany('App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts','hamahang_org_charts_items_jobs_posts_staff','staff_id','chart_item_post_job_id')
            ->whereNull('hamahang_org_charts_items_jobs_posts_staff.deleted_at');
    }

    public function jobs()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_staff_jobs','staff_id','id');
    }

    public function childs()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_staff_childs','staff_id','id');
    }

    public function relations()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_staff_relations','staff_id','id');
    }

    public function spouses()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_staff_spouses','staff_id','id');
    }

    public function families()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_staff_families','staff_id','id');
    }

}
