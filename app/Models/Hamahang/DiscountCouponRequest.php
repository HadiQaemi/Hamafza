<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountCouponRequest extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'hamahang_discount_coupon_requests';
    protected $fillable =
    [
        'user_id',
        'applicant',
        'count',
        'document_file_id',
        'created_by',
    ];
}

