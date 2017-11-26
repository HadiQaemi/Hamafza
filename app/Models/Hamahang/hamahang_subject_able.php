<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hamahang_subject_able extends Model
{
    use softdeletes;
    protected $table = 'hamahang_subject_ables';
}
