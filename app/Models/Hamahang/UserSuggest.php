<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;

class UserSuggest extends Model
{
    protected $table = 'user_suggest';

    public function page()
    {
        return $this->belongsTo('App\Models\hamafza\Pages','tid','id');
    }
}

