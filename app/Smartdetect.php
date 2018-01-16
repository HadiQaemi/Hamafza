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

    public function getIpAttribute()
    {
        return $this->where('content_type', 'ip');
    }

    public function getUserEmailAttribute()
    {
        return $this->where('content_type', 'user_email');
    }

    public function getUserIdAttribute()
    {
        return $this->where('content_type', 'user_id');
    }

}

