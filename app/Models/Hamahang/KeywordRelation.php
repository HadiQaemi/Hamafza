<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeywordRelation extends Model
{

    use SoftDeletes;

    protected $table = 'keyword_relations';
    protected $dates = ['deleted_at'];

    protected $fillable =
    [
        'keyword_1_id',
        'keyword_2_id',
        //'thesaurus_keyword_id',
        'relation_type',
        'is_morajah',
        'created_by',
    ];

    public static function add_new_keyword($keyword)
    {
        $k = new keywords;
        $k->title = $keyword;
        $k->uid = Auth::id();
        $k->save();
        return $k->id;
    }

    public function keywords_2(){
        return $this->hasOne('\App\Models\hamafza\Keyword','id','keyword_2_id');
    }

    public function keywords_1(){
        return $this->hasOne('\App\Models\hamafza\Keyword','id','keyword_1_id');
    }

    /*
    public function thesaurus(){
        return $this->hasOne('\App\Models\Hamahang\ThesaurusKeyword','id','thesaurus_keyword_id');
    }
    */
}
