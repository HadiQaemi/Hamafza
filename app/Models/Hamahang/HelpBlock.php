<?php

namespace App\Models\Hamahang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HelpBlock extends Model
{

    use softDeletes;

    protected $table = 'hamahang_help_blocks';

    protected $fillable =
    [
        'help_id',
        'page_id',
        'content',
        'created_by',
    ];

    public function page()
    {
        return $this->belongsTo('App\Models\hamafza\Pages', 'page_id');
    }

    public function getSubjectTitleAttribute()
    {
        return $this->page->subject->title;
    }

}
















