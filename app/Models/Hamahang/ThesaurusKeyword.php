<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThesaurusKeyword extends Model
{

    use SoftDeletes;

    protected $table = 'thesaurus_keywords';
    protected $dates = ['deleted_at'];

    protected $fillable =
    [
        'subject_id',
        'keyword_id',
        'created_by',
    ];

}
