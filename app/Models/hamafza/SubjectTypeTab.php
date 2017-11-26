<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectTypeTab extends Model
{
    use softdeletes;
    protected $table = 'subject_type_tab';

    public function subject()
    {
        return $this->belongsToMany('\App\Models\hamafza\Subject','tab_view', 'tabid', 'sid');
    }

}

