<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use softdeletes;
    protected  $table = 'forms';

    public function Admin_User()
    {
        return $this->belongsTo('App\User','admin','id');
    }
}

