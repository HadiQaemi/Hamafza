<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostKey extends Model
{
    use softdeletes;
    protected $table = 'post_keys';

    public function abc()
    {
        return $this->hasMany('App\Models\hamafza\Keyword','id', 'kid');
    }

}

