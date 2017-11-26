<?php

namespace App\Models\Hamahang;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends Model
{
    use SoftDeletes;

    protected $table = 'hamahang_bazaar_invoice_items';

    protected $fillable =
    [
        'invoice_id',
        'subject_id',
        'subject_title',
        'subject_price',
        'subject_count',
        'total_price',
        'coupon_id',
        'final_price',
        'responsible_for_sales_id',
        'created_by',
    ];

    public function getResponsibleForSalesAttribute()
    {
        $user = User::find($this->responsible_for_sales_id);
        return $user ? $user->FullName : 'خطا';
    }

}

