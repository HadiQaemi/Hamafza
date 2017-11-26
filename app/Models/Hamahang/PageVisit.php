<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    protected $table = 'page_visit';

    public function page()
    {
        return $this->belongsTo('App\Models\hamafza\Pages','pid','id');
    }
}

