<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Help2 extends Model
{

    use softDeletes;

//    protected $table = 'hamahang_helps_new';
    protected $table = 'hamahang_helps';

    protected $fillable =
    [
        'title',
        'created_by',
        'content',
    ];

    public function HelpBlocks()
    {
        return $this->hasMany('App\Models\Hamahang\HelpBlock', 'help_id', 'id');
    }

    public function getUsagesAttribute()
    {
        return $this->Pages;
    }

    public function SeeAlsos()
    {
//        return $this->BelongsToMany('App\Models\Hamahang\Help', 'hamahang_help_see_alsos', 'id', 'help_1_id');
        return $this->hasMany('App\Models\Hamahang\Help2SeeAlso', 'help_1_id', 'id')->whereNull('deleted_at');
    }

    public function getBlocksCountAttribute()
    {
        return $this->HelpBlocks->count();
    }

    public function Pages()
    {
        return $this->morphedByMany('App\Models\hamafza\Pages', 'target', 'hamahang_help_relations', 'help_id');
    }

}
















