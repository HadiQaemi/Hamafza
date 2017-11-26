<?php

namespace App\Models\Hamahang\ProvinceCity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use softdeletes;
    protected $table = "hamahang_province";
}
