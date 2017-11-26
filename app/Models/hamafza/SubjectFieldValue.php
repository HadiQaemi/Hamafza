<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SubjectFieldValue extends Model
{
    use softdeletes;
    protected $table = 'subject_fields_report';

    public function types()
    {
        $this->hasOne('App\Models\hamafza\SubjectTypeField', 'id', 'field_id');
    }
}

