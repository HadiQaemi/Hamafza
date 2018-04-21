<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class resources extends Model
{
    use softDeletes;
    protected $table = 'new_hamafza_resources';

    public static function add_new_resource($resource)
    {
        $k = new resources;
        $k->resource = $resource;
        $k->uid = Auth::id();
        $k->save();

        return $k->id;
    }
}
