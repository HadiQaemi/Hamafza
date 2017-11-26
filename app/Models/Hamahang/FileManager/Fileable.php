<?php

namespace App\Models\Hamahang\FileManager;

use Illuminate\Database\Eloquent\Model;

class Fileable extends Model
{
    public function file()
    {
        return $this->hasOne("App\Models\Hamahang\FileManager\FileManager", "id", 'file_id');
    }
}
