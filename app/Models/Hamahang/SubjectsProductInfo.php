<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectsProductInfo extends Model
{
    use softDeletes;
    protected $table = 'subjects_product_info';
    protected $fillable =
    [
        'subject_id',
        'price',
        'discount',
        'tax',
        'responsible_for_sales_id',
        'weight',
        'size',
        'shipping_cost',
        'maximum_delivery_time',
        'how_to_send',
        'count',
        'payment_methods',
        'description',
        'ready_to_supply',
        'created_by',
    ];

    public function getCreatedAtNameAttribute()
    {
        $diff = h_human_date(strtotime($this->created_at));
        $r = false === $diff ? $this->JalaliRegDate : "$diff " . trans('enquiry.past');
        return $r;
    }

    public function responsible_for_sales()
    {
        return $this->hasOne('App\User', 'id', 'responsible_for_sales_id');
    }

}

