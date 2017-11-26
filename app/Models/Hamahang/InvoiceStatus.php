<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceStatus extends Model
{
    use softDeletes;
    protected $table = 'hamahang_bazaar_invoice_statuses';

    protected $fillable =
    [
        'invoice_id',
        'status_id',
        'user_id',
        'created_by',
    ];

    public function invoice()
    {
        return $this->hasOne('App\Models\Hamahang\Invoice','id', 'invoice_id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\Hamahang\BasicdataValue','id', 'status_id');
    }

    public function user()
    {
        return $this->hasOne('App\User','id', 'user_id');
    }

    public function getCreatorAttribute()
    {
        return $this->user->FullName;
    }

    public function getCreatedAtJalaliAttribute()
    {
        return HDate_GtoJ($this->attributes['created_at'], "Y/m/d");
    }

}

