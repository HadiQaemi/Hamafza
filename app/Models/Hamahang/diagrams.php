<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class diagrams extends Model
{
    use softDeletes;
    protected $table = 'hamafza_diagrams';

    public function keywords()
    {
        return $this->hasMany('App\Models\Hamahang\diagram_keywords','diagram_id','id');

    }
    public function users_permissions()
    {
        return $this->hasMany('App\Models\Hamahang\diagram_users_permission','diagram_id','id');

    }
}
