<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bookmark extends Model
{

    use softDeletes;

    protected $table = 'hamahang_bookmarks';

    protected $fillable =
    [
        'title',
        'target_table',
        'target_id',
        'user_id',
        'created_by',
    ];

    /*
    public function target()
    {
        return $this->morphTo();
    }
    */

    /*
    public function user()
    {
        return $this->morphedByMany('','','','','');
    }
    */

}
















