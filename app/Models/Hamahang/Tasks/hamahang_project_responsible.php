<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hamahang_project_responsible extends Model
{
    use softdeletes;
    protected $table = 'hamahang_project_responsible';
}
