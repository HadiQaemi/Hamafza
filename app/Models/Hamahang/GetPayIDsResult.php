<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GetPayIDsResult extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'hamahang_bazaar_getpayids_results';
    protected $fillable =
    [
        'invoice_id',
        'errors',
        'invoice_serial',
        'pay_due_ids_tax_fine',
        'pay_request_date',
        'pay_request_trace_no',
        'status',
        'succeed',
        'full_data',
        'created_by',
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

}

