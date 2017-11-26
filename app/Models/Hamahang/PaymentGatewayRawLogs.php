<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentGatewayRawLogs extends Model
{
    use softDeletes;
    protected $table = 'hamahang_bazaar_payment_gateway_raw_logs';

    protected $fillable =
    [
        'invoice_id',
        'params',
        'get_pay_ids_response',
    ];

    public function getCreatedAtJalaliAttribute()
    {
        return HDate_GtoJ($this->attributes['created_at'], 'Y/m/d', false);
    }

}

