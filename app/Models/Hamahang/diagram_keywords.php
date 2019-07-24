<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class diagram_keywords extends Model
{
    use softDeletes;
    protected $table = 'hamafza_diagrams_keywords';
    protected $guarded = [];

    public function keyword()
    {
        return $this->belongsTo('App\Models\keywords','keyword_id','id');

    }

    public function diagram()
    {
        return $this->belongsTo('App\Models\diagrams','diagram_id','id');

    }
}
