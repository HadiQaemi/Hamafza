<?php
namespace App\Models\Hamahang\Tasks;;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hamahang_subject_ables extends Model
{
    use SoftDeletes;
    protected $table = 'hamahang_subject_ables';
    protected $dates = ['deleted_at'];
    public static function create_items_page($subject_id,$target_id,$target_type,$user_id=-1)
    {
        $item = new hamahang_subject_ables;
        $item->subject_id = $subject_id;
        $item->target_id = $target_id;
        $item->target_type = $target_type;
        $item->created_by = ($user_id == -1)?auth()->id():$user_id;
        $item->save();
    }
}
