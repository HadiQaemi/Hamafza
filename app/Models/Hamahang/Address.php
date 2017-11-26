<?php

namespace App\Models\Hamahang;

use App\Models\Hamahang\ProvinceCity\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $table = 'hamahang_user_addresses';
    protected $fillable =
    [
        'user_id',
        'receiver_name',
        'receiver_family',
        'province_id',
        'city_id',
        'address',
        'postal_code',
        'emergency_phone',
        'land_phone_precode',
        'land_phone_number',
        'created_by',
    ];

    public function getProvinceAttribute()
    {
        //$province = Province::find($this->province_id);
        return 555;
    }

}

