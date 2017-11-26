<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountCoupon extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'hamahang_discount_coupons';
    protected $fillable =
    [
        'coupon',
        'type',
        'value',
        'start_date',
        'expire_date',
        'disposable',
        'usage_quota',
        'used_count',
        'subject_id',
        'subject_usage_quota',
        'subject_used_count',
        'coupon_request_id',
        'inactive',
    ];

    /*
    var $attributes;
    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes = $attributes;
    }
    */

    public function getValueAttribute()
    {
        return number_format($this->attributes['value']);
    }

    public function getStartDateAttribute()
    {
        return HDate_GtoJ($this->attributes['start_date'], 'Y/m/d', false);
    }

    public function getExpireDateAttribute()
    {
        return HDate_GtoJ($this->attributes['expire_date'], 'Y/m/d', false);
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = implode('-', HDate_JtoG($value));
    }

    public function setExpireDateAttribute($value)
    {
        $this->attributes['expire_date'] = implode('-', HDate_JtoG($value));
    }

    public static function dispose($coupon)
    {
        self::where('coupon', $coupon)->update(['used_count' => '1']);
    }

    public function request()
    {
        //return $this->hasOne('App\Models\Hamahang\DiscountCouponRequest', 'id', 'coupon_request_id');
        return $this->belongsTo('App\Models\Hamahang\DiscountCouponRequest', 'coupon_request_id');
    }

}

