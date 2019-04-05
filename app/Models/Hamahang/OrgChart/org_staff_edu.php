<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class org_staff_edu extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'hamahang_org_staff_edu';
    protected $fillable = ['uid','staff_id','staff_edu_uni','staff_edu_grade','staff_edu_major','staff_edu_date_grade'];


}
