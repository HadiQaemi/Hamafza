<?php
namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class hamahang_process_entity extends Model
{
    use SoftDeletes;

    protected $table = 'hamahang_process_entity';

    protected $dates = ['deleted_at'];
}
