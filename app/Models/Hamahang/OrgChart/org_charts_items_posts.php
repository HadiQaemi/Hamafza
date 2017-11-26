<?php

namespace App\Models\Hamahang\OrgChart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class org_charts_items_posts extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'hamahang_org_charts_items_posts';

   public function item()
   {
       return $this->belongsTo('App\Models\Hamahang\OrgChart\org_chart_items','chart_item_id','id');
   }
    public function Employee()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
