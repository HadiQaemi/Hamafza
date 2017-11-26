<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class org_chart_items extends Model
{

    use SoftDeletes;

    protected $fillable = ['title', 'description', 'parent_id'];
    protected $table = 'hamahang_org_charts_items';
    protected $dates = ['deleted_at'];

    public function posts()
    {
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_chart_items_posts','chart_item_id','id');
    }

    public function chart()
    {
        return $this->belongsTo('App\Models\Hamahang\OrgChart\org_charts','chart_id','id');
    }
}
