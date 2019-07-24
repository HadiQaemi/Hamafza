<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class diagram_users_permission extends Model
{
    use softDeletes;
    protected $table = 'hamafza_diagram_users_permission';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');

    }

    public function diagram()
    {
        return $this->belongsTo('App\Models\diagrams','diagram_id','id');

    }
}
