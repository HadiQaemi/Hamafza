<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectLike extends Model
{
    use softDeletes;
    protected $table = 'subject_like';

}

