<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HelpRelation extends Model
{

    use softDeletes;

    protected $table = 'hamahang_help_relations';

    protected $fillable =
    [
        'help_id',
        'target_table',
        'target_id',
        'created_by',
    ];

}
















