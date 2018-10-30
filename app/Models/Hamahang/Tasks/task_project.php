<?php

namespace App\Models\Hamahang\Tasks;

use App\Models\Hamahang\keywords;
use DB;
use App\HamahangCustomClasses\jDateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class task_project extends Model
{
    use softdeletes;
    protected $table = 'hamahang_project';

    public static function project_info($pid)
    {
        $project = DB::table('hamahang_project')
//            ->select('hamahang_project.title' , 'hamahang_calendar.title as c_title' , 'hamahang_project.start_date' , 'hamahang_project.end_date' , 'hamahang_project.schedule_on' , 'hamahang_project.type' ,'hamahang_project.desc',DB::raw('CONCAT(user.Name,\'  \',user.Family ) as full_name'))
            ->select('*', DB::raw('CONCAT(user.Name,\'  \',user.Family ) as full_name'))
//            ->join('hamahang_project_responsible','hamahang_project_responsible.project_id','=','hamahang_project.id')
//            ->join('hamahang_calendar' , 'hamahang_calendar.id' , '=', 'hamahang_project.base_calendar')
//            ->join('user','user.id','=','hamahang_project_responsible.user_id')
            ->join('user','user.id','=','hamahang_project.uid')
//            ->join('hamahang_subject_ables','hamahang_subject_ables.target_id' ,'=','hamahang_project.id')
//            ->where('hamahang_subject_ables.target_type' , '=', 'App\\Models\\Hamahang\\Tasks\\task_project')
//            ->whereNull('hamahang_project_responsible.deleted_at')
            ->where('hamahang_project.id','=',$pid)
            ->get();

        $pages = DB::table('hamahang_subject_ables')
            ->select('hamahang_subject_ables.subject_id','subjects.title')
            ->join('subjects' , 'subjects.id' , '=','hamahang_subject_ables.subject_id')
            ->where('hamahang_subject_ables.target_id','=', $pid)
            ->where('hamahang_subject_ables.target_type' , '=', 'App\\Models\\Hamahang\\Tasks\\task_project')
            ->whereNull('hamahang_subject_ables.deleted_at')
            ->get();

        $date = new jDateTime();
        $project[0]->start_date = $date::getdate($project[0]->start_date);
        $project[0]->end_date = $date::getdate($project[0]->end_date);

        $project_tasks = DB::table('hamahang_project_task')
            ->join('hamahang_project', 'hamahang_project.id', '=','hamahang_project_task.project_id')
            ->join('hamahang_task', 'hamahang_task.id', '=','hamahang_project_task.task_id')
            ->where('hamahang_project_task.project_id', '=', $pid)
            ->whereNull('hamahang_project_task.deleted_at')
            ->select('hamahang_task.title', 'hamahang_task.id')
            ->get();

        $project_keywords = keywords::select('keywords.title', 'keywords.id')
            ->join('hamahang_project_keyword', 'keywords.id', '=','hamahang_project_keyword.keyword_id')
            ->where('hamahang_project_keyword.project_id', '=', $pid)
            ->whereNull('hamahang_project_keyword.deleted_at')
            ->get();
//

        $responsibles = DB::table('hamahang_project_responsible')
            ->where('project_id', '=', $pid)
            ->join('user','user.id','=','hamahang_project_responsible.user_id')
            ->whereNull('hamahang_project_responsible.deleted_at')
            ->select('hamahang_project_responsible.user_id', DB::raw('CONCAT(user.Name,\'  \',user.Family ) as full_name'))
            ->get();

        $role_permission = DB::table('hamahang_project_role_permission')
            ->where('project_id', '=', $pid)
            ->join('roles','roles.id','=','hamahang_project_role_permission.role_id')
            ->whereNull('hamahang_project_role_permission.deleted_at')
            ->select('roles.id', 'roles.display_name', 'hamahang_project_role_permission.permission_type')
            ->get();

        $user_permission = DB::table('hamahang_project_user_permission')
            ->where('project_id', '=', $pid)
            ->join('user','user.id','=','hamahang_project_user_permission.user_id')
            ->whereNull('hamahang_project_user_permission.deleted_at')
            ->select('hamahang_project_user_permission.user_id', 'hamahang_project_user_permission.permission_type', DB::raw('CONCAT(user.Name,\'  \',user.Family ) as full_name'))
            ->get();

        $first_tasks = DB::table('hamahang_project_task_relations')
            ->where('project_id', '=', $pid)
            ->whereNull('hamahang_project_task_relations.deleted_at')
            ->select('hamahang_project_task_relations.first_task_id')
            ->get();
        $data = collect($first_tasks)->map(function ($x)
        {
            return (array)$x;
        })->toArray();
        $project_task_info = DB::table('hamahang_task')
            ->whereIn('hamahang_task.id', $data)
            ->select('hamahang_task.id', 'hamahang_task.title')
            ->get();

        //die(var_dump($project_task_info));
        foreach ($project_tasks as $t)
        {
            $relations = project_task_relation::where('project_id', '=', $pid)
                ->where('first_task_id', '=', $t->id)
                ->get();
        }
        $arr = [];
        array_push($arr,['project_tasks' => $project_tasks]);
        array_push($arr,['project_info' => $project]);
        array_push($arr,['pages' => $pages]);
        array_push($arr,['project_keywords' => $project_keywords]);
        array_push($arr,['responsibles' => $responsibles]);
        array_push($arr,['role_permission' => $role_permission]);
        array_push($arr,['user_permission' => $user_permission]);
        return $arr;
    }
}
