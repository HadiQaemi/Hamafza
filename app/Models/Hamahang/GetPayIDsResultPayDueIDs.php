<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GetPayIDsResultPayDueIDs extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'hamahang_bazaar_getpayids_result_paydueids';
    protected $fillable =
    [
        'getpayids_result_id',
        'errors',
        '_id',
        'issue_date',
        'pay_due_serial',
        'status',
        'trace_no',
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

