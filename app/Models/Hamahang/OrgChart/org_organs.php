<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class org_organs extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'hamahang_org_organs';
    protected $fillable = ['uid','parent_id','title','description'];

    public function charts()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_charts','org_organs_id','id');
    }
}

