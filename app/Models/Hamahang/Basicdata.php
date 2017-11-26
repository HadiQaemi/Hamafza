<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Basicdata extends Model
{
    use softDeletes;
    protected $table = 'hamahang_basicdata';
    protected $fillable =
    [
        'title',
        'comment',
        'inactive'
    ];

    public function items()
    {
        return $this->hasMany('App\Models\Hamahang\BasicdataValue', 'parent_id');
    }

    function attrs()
    {
        return $this->hasMany('App\Models\Hamahang\BasicdataAttributes', 'basicdata_id', 'id');
    }

}

