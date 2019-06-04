<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Help extends Model
{

    use softDeletes;

    protected $table = 'hamahang_helps';

    protected $fillable =
    [
        'title',
        'created_by',
    ];

    public function HelpBlocks()
    {
        return $this->hasMany('App\Models\Hamahang\HelpBlock', 'help_id', 'id');
    }

    public function getUsagesAttribute()
    {
        return $this->Pages;
    }

    public function SeeAlsos1()
    {
        return $this->hasMany('App\Models\Hamahang\Help2SeeAlso', 'help_1_id', 'id')->whereNull('hamahang_help_see_alsos.deleted_at');
    }

    public function SeeAlsos2()
    {
        return $this->hasMany('App\Models\Hamahang\Help2SeeAlso', 'help_2_id', 'id')->whereNull('hamahang_help_see_alsos.deleted_at');
    }

    public function SeeAlsos()
    {
        return $this->SeeAlsos1->union($this->SeeAlsos2);
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
















