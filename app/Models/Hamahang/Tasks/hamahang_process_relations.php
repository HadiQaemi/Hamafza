<?php
namespace App\Models\Hamahang\Tasks;;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class hamahang_process_relations extends Model
{
    use softdeletes;
    protected $table = 'hamahang_process_relations';
}
