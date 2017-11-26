<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class hamahang_process_entity_log extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hamahang_process_entity_log';

    protected $dates = ['deleted_at'];
}
