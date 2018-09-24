<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $table = 'hamahang_bazaar_invoices';

    protected $fillable =
    [
        'user_id',
        'receiver_id',
        'postmethod_id',
        'tracking_code',
        'payable_amount',
        'invoice_year',
        'invoice_serial',
        'has_coupon',
        'created_by',
    ];

    public function receiver()
    {
        return $this->belongsTo('App\Models\Hamahang\Address','receiver_id');
    }

    public function postmethod()
    {
        return $this->belongsTo('App\Models\Hamahang\BasicdataValue','postmethod_id')->where('parent_id', config('bazaar.invoice_basicdata_id_postmethod'));
    }

    public function getPostmethodTitleAttribute($v)
    {
        return $this->postmethod()->orderBy('id', 'desc')->first()->title;
    }

    public function getInvoiceSerialAttribute($v)
    {
        return str_pad($this->attributes['invoice_serial'], '5', '0', STR_PAD_LEFT);
    }

    public function getCreatedAtJalaliAttribute($v)
    {
        return HDate_GtoJ($v, "Y/m/d");
    }

    public function getInvoiceNoAttribute($v)
    {
        return $this->invoice_year . $this->invoice_serial;
    }

    public function getSubjectCountAttribute($v)
    {
        return $this->items->count() . ' ' . trans('bazaar.invoice.subject_count_product') . ' (' . $this->items->sum('subject_count') . ' ' . trans('bazaar.invoice.subject_count_number') . ')';
    }

    public function items()
    {
        return $this->hasMany('App\Models\Hamahang\InvoiceItem','invoice_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function status()
    {
        return $this->belongsToMany('App\Models\Hamahang\BasicdataValue', 'hamahang_bazaar_invoice_statuses', 'invoice_id', 'status_id')->where('parent_id', '9')->withTimestamps()->withPivot(['id', 'user_id', 'created_at']);
    }

    public function getLastStatusAttribute($v)
    {
        $status = $this->status();
        if ($status->count())
        {
            $r = $status->orderBy('id', 'desc')->first()->title;
        } else
        {
            $r = 39;
        }
        return $r;
    }

}

