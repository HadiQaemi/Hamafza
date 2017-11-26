<?php

namespace App\Models\Hamahang\FileManager;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileManager extends Model
{
    use softdeletes;
	protected $table = 'hamahang_files';

    public function fileables()
    {
        return $this->hasMany("hamahang_files", "fileable_id");
    }

    public function getHumanSizeAttribute()
    {
        return HFM_FileSizeConvert($this->size);
    }

}
