<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Relations extends Model {

    use softdeletes;
    protected $table = 'relations';
    protected $fillable = [
        'name',
        'variables',
        'concepts',
        'pages',
        'directname',
        'Inversename',
        'dariche',
        'descr',
        'dariche_inver',
        'direction',
        'parent',
        'reg_date',
        'edit_date'
    ];

}
