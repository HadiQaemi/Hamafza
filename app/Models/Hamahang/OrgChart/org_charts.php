<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class org_charts extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'hamahang_org_charts';
    protected $fillable = ['uid','org_organs_id','title','description'];

    public function items()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_chart_items','chart_id','id');
    }

    public function organ()
    {
        return $this->belongsTo('App\Models\Hamahang\OrgChart\org_organs','org_organs_id','id');
    }
    public function creator()
    {
        return $this->belongsTo('App\User','uid','id');
    }
}
