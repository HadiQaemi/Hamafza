<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class org_charts_items_missions extends Model
{

    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'hamahang_org_charts_items_missions';
    protected $dates = ['deleted_at'];

}
