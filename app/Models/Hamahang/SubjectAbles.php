<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;

class SubjectAbles extends Model
{
    protected $table = 'hamahang_subject_ables';

    public function page(){
        return $this->belongsTo('App\Models\hamafza\Pages', 'subject_id', 'id');
    }
}

