<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class org_staff extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'hamahang_org_staff';
    protected $fillable = ['uid','first_name','last_name','national_id','mobile','birth_date','is_married','is_man'];

    public function edus()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_staff_edu','staff_id','id');
    }

    public function jobs()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_staff_jobs','staff_id','id');
    }

}
