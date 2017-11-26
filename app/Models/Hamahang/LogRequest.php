<?php

namespace App\Models\Hamahang;
use Countries;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class LogRequest extends Model
{
    use softDeletes;
	protected $table = 'hamahang_log_requests';
    public function getCountryNameAttribute()
    {
        //dd($this->iso_code);
        return Countries::getOne($this->iso_code, 'fa');
    }
}
