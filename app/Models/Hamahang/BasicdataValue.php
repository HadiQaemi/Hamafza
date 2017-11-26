<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BasicdataValue extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'hamahang_basicdata_values';
    protected $fillable =
    [
        'parent_id',
        'title',
        'value',
        'comment',
        'inactive'
    ];
    function attrs()
    {
        return $this->belongsToMany('App\Models\Hamahang\BasicdataAttributes', 'hamahang_basicdata_attributes_values', 'basicdata_value_id', 'basicdata_attribute_id')
            ;//-- ->where('hamahang_basicdata_attributes.basicdata_id', $this->parent_id)--}}
    }
    function basicdata()
    {
        return $this->hasOne('App\Models\Hamahang\Basicdata', 'id', 'parent_id');
    }
    function getBasicdatasAttributesAttribute()
    {
        return $this->basicdata->attrs;
    }
}

