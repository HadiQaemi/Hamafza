<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keyword extends Model
{

    use SoftDeletes;

    protected $table = 'keywords';
    protected $dates = ['deleted_at'];
    protected $fillable =
    [
        'title',
        'short_code',
        'img_file_id',
        'description',
        'is_morajah',
        'is_approved',
        'created_by',
    ];

    public function subjects()
    {
      return $this->belongsToMany('App\Models\hamafza\Subject', 'subject_key','kid', 'sid');
    }

    public function user_specials()
    {
      return $this->belongsToMany('App\User', 'user_special','keyword_id', 'user_id');
    }

    public function thesa()
    {
       return $this->belongsToMany('App\Models\hamafza\Subject', 'thesaurus_keywords', 'keyword_id', 'subject_id')->whereNull('thesaurus_keywords.deleted_at');
    }

    public function posts()
    {
        return $this->belongsToMany('App\Models\hamafza\Post', 'post_keys', 'kid', 'pid');
    }

    public function questions(/*$sub_kind = 2*/)
    {
        return $this->belongsToMany('App\Models\hamafza\Post', 'post_keys', 'kid', 'pid')/*->where('type', $sub_kind)*/;
    }

    public function thesauruses()
    {
        return $this->hasMany('App\Models\Hamahang\ThesaurusKeyword', 'keyword_id');
    }

    public function relations()
    {
        return $this->hasMany('App\Models\Hamahang\KeywordRelation', 'keyword_1_id');
    }

    public function synonym_relations()
    {
        return $this->hasMany('App\Models\Hamahang\KeywordRelation', 'keyword_1_id')->where('relation_type', '7');
    }

    public function synonym_relations_reverse()
    {
        return $this->hasMany('App\Models\Hamahang\KeywordRelation', 'keyword_2_id')->where('relation_type', '7');
    }

    public function getRelationsByTypeAttribute()
    {
        $r = null;

        $relations1 = $this->hasMany('App\Models\Hamahang\KeywordRelation', 'keyword_1_id')->get()->toArray();
        if ($relations1)
        {
            foreach ($relations1 as $relation1)
            {
                $r[$relation1['relation_type']]['values'][] = $relation1['keyword_2_id'];
            }
        }
        $relations2 = $this->hasMany('App\Models\Hamahang\KeywordRelation', 'keyword_2_id')->get()->toArray();
        if ($relations2)
        {
            foreach ($relations2 as $relation2)
            {
                        $r[config('keyword.relation_types_relation.' . $relation2['relation_type'])]['values'][] = $relation2['keyword_1_id'];
            }
        }
        return $r;
    }

    /*
    public static function add_old($title, $short_code = '[:-empty-:]', $img_file_id = '[:-empty-:]', $description = '[:-empty-:]', $is_morajah = '[:-empty-:]', $created_by = '[:-empty-:]', $edit_id = 0)
    {
        $empty = '[:-empty-:]';
        $data_array =
        [
            'title' => $title,
            'short_code' => $short_code,
            'img_file_id' => $img_file_id,
            'description' => $description,
            'is_morajah' => $is_morajah,
            'created_by' => $created_by,
        ];
        if ($empty == $short_code)
        {
            unset($data_array['short_code']);
        }
        if ($empty == $img_file_id)
        {
            unset($data_array['img_file_id']);
        }
        if ($empty == $description)
        {
            unset($data_array['description']);
        }
        if ($empty == $is_morajah)
        {
            unset($data_array['is_morajah']);
        }
        if ($edit_id)
        {
            $keyword = Keyword::find($edit_id);
            unset($data_array['created_by']);
        } else
        {
            $keyword = new Keyword();
        }
        $keyword->fill($data_array);
        return ['result' => $keyword->save(), 'object' => $keyword];
    }
    */

    public static function add($data_array, $edit_id = 0)
    {
        if ($edit_id)
        {
            $keyword = Keyword::find($edit_id);
            unset($data_array['created_by']);
        } else
        {
            $keyword = new Keyword();
        }
        $keyword->fill($data_array);
        return ['result' => $keyword->save(), 'object' => $keyword];
    }

}
