<?php

namespace App\Models\Hamahang\Tasks;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class task_staffs extends Model
{
    use softdeletes;
    protected $table = 'hamahang_task_staff';

    public static function create_task_staff($assignment_id,$user_id,$uid=-1)
    {
        $staff = new task_staffs;
        $staff->uid =($uid==-1)? Auth::id():$uid;
        $staff->assignment_id = $assignment_id;
        $staff->user_id = $user_id;
        $staff->save();
    }
}
