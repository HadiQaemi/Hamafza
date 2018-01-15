<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Smartdetect extends Model
{

    use softDeletes;

    protected $table = 'smartdetect';

    protected $fillable =
    [
        'content',
        'content_type',
        'action',
    ];


}

