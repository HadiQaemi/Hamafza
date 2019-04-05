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


}
