<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BasicdataAttributesValues extends Model
{
    use softDeletes;
    protected $table = 'hamahang_basicdata_attributes_values';
    protected $fillable =
    [
        'basicdata_value_id',
        'basicdata_attribute_id',
        'value',
        'created_by',
    ];

    /*
    public function groups()
    {
        return $this->hasMany('App\Models\Hamahang\BasicdataValue', 'parent', 'id');
    }

    public function get()
    {
        return $this->items->load('', '')->get();
    }

    public function items()
    {
        return $this->hasMany('App\Models\Hamahang\BasicdataValue', 'parent_id');
    }
    */

}

