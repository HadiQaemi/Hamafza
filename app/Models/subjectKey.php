<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class subjectKey extends Model
{
    use softDeletes;
    protected $table = 'subject_key';

}
