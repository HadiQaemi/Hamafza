<?php

namespace App\Models\Hamahang;

use App\Models\Hamahang\ProvinceCity\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alert extends Model
{
    use SoftDeletes;
    protected $table = 'alerts';

    public function getShortenCommentAttribute($value)
    {
        $t = strip_tags($this->comment);
        return mb_substr($t, 0, 60, 'utf8').'...';
    }
}

