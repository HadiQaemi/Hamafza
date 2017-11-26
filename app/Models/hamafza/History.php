<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class History extends Model
{
    use softdeletes;
    protected $table = 'history';

    public function page()
    {
        return $this->belongsTo('App\Models\hamafza\Pages', 'pid');
    }
}

