<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SubjectTypeField extends Model
{
    use softdeletes;
    protected $table = 'subject_type_fields';

    public function subjects()
    {
        $this->belongsToMany('App\Models\hamafza\Subject', 'subject_fields_report', 'field_id', 'sid');
    }

}

