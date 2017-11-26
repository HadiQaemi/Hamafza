<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class project_permissions extends Model
{
    use softdeletes;
    protected $table = 'hamahang_project_user_permission';
}
