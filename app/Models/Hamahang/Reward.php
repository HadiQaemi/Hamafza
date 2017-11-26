<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reward extends Model
{
    use softDeletes;
    protected $table = 'hamahang_rewards';
    protected $fillable =
    [
        'from_user_id',
        'to_user_id',
        'target_table',
        'target_id',
        'score'
    ];


    public function target()
    {
        return $this->morphTo();
    }

}

