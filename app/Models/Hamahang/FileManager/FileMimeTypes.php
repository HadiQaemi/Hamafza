<?php
namespace App\Models\Hamahang\FileManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class FileMimeTypes extends Model
{
    use softdeletes;
    protected $table = 'hamahang_file_mime_types';
}