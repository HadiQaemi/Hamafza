<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emails extends Model
{
    use softdeletes;
    protected  $table = 'emails';

    public function user()
    {
        return $this->belongsTo('App\User','uid','id');
    }

}

