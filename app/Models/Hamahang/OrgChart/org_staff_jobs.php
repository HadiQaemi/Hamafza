<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class org_staff_jobs extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'hamahang_org_staff_jobs';
    protected $fillable = ['uid','staff_id','staff_job_corp','staff_job_pos','staff_job_begin','staff_job_end'];


}
