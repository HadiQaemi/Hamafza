<?php

namespace App\Models\Hamahang\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Auth;

class task_packages extends Model
{
	use SoftDeletes;
	protected $table = 'hamahang_task_package';
	protected $dates = ['deleted_at'];

	public static function FetchPackageMyTasks($package_id)
    {
        $tasks = DB::table('hamahang_task_assignments')
            ->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
            ->join('hamahang_task_user_package', 'hamahang_task_assignments.task_id', '=', 'hamahang_task_user_package.task_id')
            ->where('hamahang_task_assignments.employee_id', '=', Auth::id())
            ->where('hamahang_task_user_package.package_id', '=', $package_id)
            ->whereNull('hamahang_task_user_package.deleted_at')
            ->whereNull('hamahang_task_assignments.reject_description')
            ->select('hamahang_task_assignments.id', 'hamahang_task.title', 'hamahang_task_user_package.id as utpid', 'hamahang_task_user_package.package_id as package_id')
            ->get();
        return $tasks;
    }

	public static function RemoveTaskFromPackage($user_task_package_id)
    {
        DB::table('hamahang_task_user_package')
            ->where('id',$user_task_package_id)
            ->update(['deleted_at' => time()]);
    }

	public static function FetchPackageMyAssignedTasks($package_id)
    {
        $tasks = DB::table('hamahang_task_assignments')
            ->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
            ->join('hamahang_task_user_package', 'hamahang_task_assignments.task_id', '=', 'hamahang_task_user_package.task_id')
            ->where('hamahang_task_assignments.assigner_id', '=', Auth::id())
            ->where('hamahang_task_user_package.package_id', '=', $package_id)
            ->whereNull('hamahang_task_user_package.deleted_at')
            ->select('hamahang_task_assignments.id', 'hamahang_task.title', 'hamahang_task_user_package.id as utpid', 'hamahang_task_user_package.package_id as package_id')
            ->get();
        return $tasks;
    }

	public static function PrepareDataForMyTasksPackages($filter_subject_id = false,$employee_id=false)
    {
        $package = DB::table('hamahang_task_package')
            ->where('hamahang_task_package.user_id', '=', Auth::id())
            ->whereNull('hamahang_task_package.deleted_at')->get();
        foreach ($package as $p)
        {
            $tasks = DB::table('hamahang_task')
                ->join('hamahang_task_assignments', 'hamahang_task_assignments.task_id', '=', 'hamahang_task.id')
                ->join('hamahang_task_user_package', 'hamahang_task_user_package.task_id', '=', 'hamahang_task.id')
                ->where('hamahang_task_assignments.employee_id', '=',($employee_id == false)?Auth::id():$employee_id)
                ->where('hamahang_task_user_package.package_id', '=', $p->id)
                ->whereNull('hamahang_task_user_package.deleted_at')
                ->whereNull('hamahang_task_assignments.reject_description')
                ->select('hamahang_task_assignments.id', 'hamahang_task.title', 'hamahang_task_user_package.id as utpid', 'hamahang_task_user_package.package_id as package_id');
            if ($filter_subject_id != false)
            {
                $tasks->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                    ->where('hamahang_subject_ables.subject_id', $filter_subject_id)
                    ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\tasks')
                    ->whereNull('hamahang_subject_ables.deleted_at');
            }
            $p->tasks = $tasks->get();
        }
        return $package;
    }
	public static function AllTasksPackages()
    {
        $package = DB::table('hamahang_task_package')
            ->whereNull('hamahang_task_package.deleted_at')
            ->where('hamahang_task_package.user_id', '=', Auth::id())
            ->get();
        foreach ($package as $p)
        {
            $tasks = DB::table('hamahang_task_assignments')
                ->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
                ->join('hamahang_task_user_package', 'hamahang_task_assignments.task_id', '=', 'hamahang_task_user_package.task_id')
                ->orWhere(function ($query)
                {
                    $query->where('hamahang_task_assignments.assigner_id', '=', Auth::id())
                        ->orWhere('hamahang_task_assignments.employee_id', '=', Auth::id());
                })
                ->where('hamahang_task_user_package.package_id', '=', $p->id)
                ->whereNull('hamahang_task_user_package.deleted_at')
                ->whereNull('hamahang_task_assignments.reject_description')
                ->select('hamahang_task_assignments.employee_id as do_type', 'hamahang_task_assignments.id', 'hamahang_task.title', 'hamahang_task_user_package.id as utpid',
                    'hamahang_task_user_package.package_id as package_id')
                ->get();
            foreach ($tasks as $task)
            {
                if ($task->do_type == Auth::id())
                {
                    $task->do_type = 1;
                }
                else
                {
                    $task->do_type = 2;
                }
            }
            $p->tasks = $tasks;
        }
        return $package;
    }
    public static function PrepareDataForMyAssignedTaskPackages($filter_subject_id = false)
    {
        $package = DB::table('hamahang_task_package')
            ->whereNull('hamahang_task_package.deleted_at')
            ->where('hamahang_task_package.user_id', '=', Auth::id())
            ->get();
        foreach ($package as $p)
        {
            $tasks = DB::table('hamahang_task_assignments')
                ->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
                ->join('hamahang_task_user_package', 'hamahang_task_assignments.task_id', '=', 'hamahang_task_user_package.task_id')
                ->where('hamahang_task_assignments.assigner_id', '=', Auth::id())
                ->where('hamahang_task_user_package.package_id', '=', $p->id)
                ->whereNull('hamahang_task_user_package.deleted_at')
                ->select('hamahang_task_assignments.id', 'hamahang_task.title', 'hamahang_task_user_package.id as utpid', 'hamahang_task_user_package.package_id as package_id');
            if ($filter_subject_id != false)
            {
                $tasks->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                    ->where('hamahang_subject_ables.subject_id', $filter_subject_id)
                    ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\tasks')
                    ->whereNull('hamahang_subject_ables.deleted_at');
            }
            $tasks = $tasks->get();
            $p->tasks = $tasks;
        }
        return $package;
    }
}
