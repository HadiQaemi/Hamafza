<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Subst extends Model
{
    use SoftDeletes;
    protected $table = 'subst';
}

