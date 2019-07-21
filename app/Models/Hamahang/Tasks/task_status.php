<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class task_status extends Model
{
//    use SoftDeletes;
    protected $table = 'hamahang_task_status';
//    protected $dates = ['deleted_at'];
    protected $fillable = ['uid', 'user_id', 'task_id', 'percent', 'type', 'deleted_at'];

    public static function create_task_status($task_id,$type=0,$percent=0,$user_id=-1,$timestamp=-1,$uid=-1)
    {
        $status = new task_status;
        $status->uid = ($uid ==-1)?Auth::id():$uid;
        $status->task_id = $task_id;
        $status->type = $type;
        $status->percent = $percent;
        $status->user_id = ($user_id ==-1)?Auth::id():$user_id;
        $status->timestamp = ($timestamp==-1)?time():$timestamp;
        $status->save();
        return $status;
    }

    /*---------------------------------------------- Accessors  --------------------------------------------*/

    public function getStatusTitleAttribute()
    {

         switch ($this->type)
         {
             case '0':
             {
                 return trans('tasks.status_not_started');
                 break;
             }
             case '1':
             {
                 return trans('tasks.status_started');
                 break;
             }
             case '2':
             {
                 return trans('tasks.status_done');
                 break;
             }
             case '3':
             {
                 return trans('tasks.status_finished');
                 break;
             }
             case '4':
             {
                 return trans('tasks.status_suspended');
                 break;
             }
             default :
                 return '';
         }
    }

    public static function getTaskStatusTitleAttribute($type)
    {

        switch ($type)
        {
            case '0':
                {
                    return trans('tasks.status_not_started');
                    break;
                }
            case '1':
                {
                    return trans('tasks.status_started');
                    break;
                }
            case '2':
                {
                    return trans('tasks.status_done');
                    break;
                }
            case '3':
                {
                    return trans('tasks.status_finished');
                    break;
                }
            case '4':
                {
                    return trans('tasks.status_suspended');
                    break;
                }
            default :
                return '';
        }
    }

    public function getStatusIconAttribute()
    {

        switch ($this->type)
        {
            case '0':
            {
                return '<i class="fa fa-cog fa-2x"></i>';
                break;
            }
            case '1':
            {
                return '<i class="fa fa-cog fa-spin fa-2x"></i>';
                break;
            }
            case '2':
            {
                return '<i class="fa fa-calendar-check-o fa-2x"></i>';
                break;
            }
            case '3':
            {
                return '<i class="fa fa-calendar-times-o fa-2x"></i>';
                break;
            }
            case '4':
            {
                return '<i class="fa fa-ban fa-2x"></i>';
                break;
            }

            default :
                return '';
        }
    }
    /*---------------------------------------------- Mutators --------------------------------------------*/

}
