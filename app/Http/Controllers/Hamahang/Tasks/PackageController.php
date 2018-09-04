<?php

namespace App\Http\Controllers\Hamahang\Tasks;

use DB;
use Auth;
use Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\Hamahang\Tasks\task_packages;
use App\Models\Hamahang\Tasks\task_assignments;

class PackageController extends Controller
{
    public function MyAssignedTaskPackages($uname)
    {
        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.tasks.my_assigned_tasks.package':
                $arr = variable_generator('page', 'desktop', $uname);
                $arr['filter_subject_id'] = $arr["pid"];
                $arr['packages'] = task_packages::PrepareDataForMyAssignedTaskPackages($uname);
                return view('hamahang.Tasks.MyAssignedTask.MyAssignedTaskPackages',$arr);
                break;
            case 'ugc.desktop.hamahang.tasks.my_assigned_tasks.package':
                $arr = variable_generator('user', 'desktop', $uname);
                $arr['packages'] = task_packages::PrepareDataForMyAssignedTaskPackages();
                return view('hamahang.Tasks.MyAssignedTask.MyAssignedTaskPackages',$arr);
                break;
        }
    }

    public function MyTaskPackages($uname)
    {
        switch (\Route::currentRouteName())
        {
            case 'pgs.desktop.hamahang.tasks.my_tasks.package':
                $arr = variable_generator('page', 'desktop', $uname);
                $arr['filter_subject_id'] = $arr["pid"];
                $arr['packages'] = task_packages::PrepareDataForMyTasksPackages($uname);
                return view('hamahang.Tasks.MyTask.MyTaskPackages', $arr);
                break;
            case 'ugc.desktop.hamahang.tasks.my_tasks.package':
                $arr = variable_generator('user', 'desktop', $uname);
                $arr['packages'] = task_packages::PrepareDataForMyTasksPackages();
                return view('hamahang.Tasks.MyTask.MyTaskPackages', $arr);
                break;
        }
    }

    public function TasksPackages($uname)
    {
        $arr = variable_generator('user', 'desktop', $uname);
        $arr['packages'] = $package = task_packages::AllTasksPackages();
        return view('hamahang.Tasks.TasksPackages', $arr);
    }

    public function RemoveMyTaskFromPackage()
    {
        task_packages::RemoveTaskFromPackage(Request::input('utpid'));
        $tasks = task_packages::FetchPackageMyTasks(Request::input('pid'));
        return json_encode($tasks);
    }

    public function RemoveFromPackage()
    {
        task_packages::RemoveTaskFromPackage(Request::input('utpid'));
        $tasks = task_packages::FetchPackageMyAssignedTasks(Request::input('pid'));
        return json_encode($tasks);
    }

    public function MyTaskAddToPackage()
    {
        if (sizeof(Request::input('s_arr')) > 0)
        {
            $current_tasks = DB::table('hamahang_task_user_package')->whereNull('deleted_at')->where('user_id', '=', Auth::id())->where('package_id', '=', Request::input('pid'))
                ->select('task_id')->get();
            $Items = collect($current_tasks)->map(function ($x)
            {
                return (array)$x;
            })->toArray();

            foreach (Request::input('s_arr') as $task)
            {
                $exist = 0;
                for ($i = 0; $i < sizeof($Items); $i++)
                {
                    if ($task == $Items[$i]['task_id'])
                    {
                        $exist = 1;
                        break;
                    }
                }
                if ($exist == 0)
                {
                    $p = DB::table('hamahang_task_user_package')->insert([
                        ['task_id' => $task, 'user_id' => Auth::id(), 'uid' => Auth::id(), 'package_id' => Request::input('pid')]
                    ]);
                }
            }
        }
        $tasks = DB::table('hamahang_task_assignments')
            ->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
            ->join('hamahang_task_user_package', 'hamahang_task_assignments.task_id', '=', 'hamahang_task_user_package.task_id')
            ->where('hamahang_task_assignments.employee_id', '=', Auth::id())
            ->where('hamahang_task_user_package.package_id', '=', Request::input('pid'))
            ->whereNull('hamahang_task_user_package.deleted_at')
            ->select('hamahang_task_assignments.id', 'hamahang_task.title', 'hamahang_task_user_package.id as utpid', 'hamahang_task_user_package.package_id as package_id');
        if (Request::exists('filter_subject_id)'))
        {
            $tasks->where(function ($query)
            {
                $query->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                    ->where('hamahang_subject_ables.subject_id', '=', Request::input('filter_subject_id'))
                    ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\tasks')
                    ->whereNull('hamahang_subject_ables.deleted_at');
            });
        }
        $tasks = $tasks->get();

        return json_encode($tasks);
    }

    public function MyAssignedTasksAddToPackage()
    {
        if (sizeof(Request::input('s_arr')) > 0)
        {
            $current_tasks = DB::table('hamahang_task_user_package')->whereNull('deleted_at')->where('user_id', '=', Auth::id())->where('package_id', '=', Request::input('pid'))
                ->select('task_id')->get();
            $Items = collect($current_tasks)->map(function ($x)
            {
                return (array)$x;
            })->toArray();

            foreach (Request::input('s_arr') as $task)
            {
                $exist = 0;
                for ($i = 0; $i < sizeof($Items); $i++)
                {
                    if ($task == $Items[$i]['task_id'])
                    {
                        $exist = 1;
                        break;
                    }
                }
                if ($exist == 0)
                {
                    $p = DB::table('hamahang_task_user_package')->insert([
                        ['task_id' => $task, 'user_id' => Auth::id(), 'uid' => Auth::id(), 'package_id' => Request::input('pid')]
                    ]);
                }
            }
        }
        $tasks = DB::table('hamahang_task_assignments')
            ->join('hamahang_task', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
            ->join('hamahang_task_user_package', 'hamahang_task_assignments.task_id', '=', 'hamahang_task_user_package.task_id')
            ->where('hamahang_task_assignments.assigner_id', '=', Auth::id())
            ->where('hamahang_task_user_package.package_id', '=', Request::input('pid'))
            ->whereNull('hamahang_task_user_package.deleted_at')
            ->select('hamahang_task_assignments.id', 'hamahang_task.title', 'hamahang_task_user_package.id as utpid', 'hamahang_task_user_package.package_id as package_id');
        if (Request::exists('filter_subject_id)'))
        {
            $tasks->where(function ($query)
            {
                $query->join('hamahang_subject_ables', 'hamahang_subject_ables.target_id', '=', 'hamahang_task.id')
                    ->where('hamahang_subject_ables.subject_id', '=', Request::input('filter_subject_id'))
                    ->where('hamahang_subject_ables.target_type', '=', 'App\\Models\\Hamahang\\Tasks\\tasks')
                    ->whereNull('hamahang_subject_ables.deleted_at');
            });
        }
        $tasks = $tasks->get();

        return json_encode($tasks);
    }

    public function CreateNewPackage()
    {
        $result = '';
        $validator = Validator::make(Request::all(), [
            'title' => 'required|string'
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $check = 0;
            $count = 0;
            $task = task_packages::where('title', 'like', Request::input('title'))->where('user_id', '=', Auth::id())->first();
            if ($task)
            {
                while ($check == 0)
                {
                    $count++;
                    $task = task_packages::where('title', 'like', Request::input('title') . '_' . $count)->where('user_id', '=', Auth::id())->first();
                    if ($task)
                    {

                    }
                    else
                    {
                        $check = 1;
                    }
                }
            }

            //$title = $this->check_existance(0, Request::input('title'));

            $package = new task_packages;
            if ($check == 1)
            {
                $package->title = Request::input('title') . '_' . $count;
            }
            else
            {
                $package->title = Request::input('title');
            }
            $package->user_id = Auth::id();
            $package->uid = Auth::id();
            $package->save();
            $result['success'] = true;
            return json_encode($result);
        }
        //$pkg = task_packages::where('uid', '=', Auth::id())->select('id', 'title')->get();

    }

    public function ChangePackageTitle()
    {
        $result = '';
        $validator = Validator::make(Request::all(), [
            'nTitle' => 'required|string'
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $check = 0;
            $count = 0;
            $task = task_packages::where('title', 'like', Request::input('nTitle'))->where('user_id', '=', Auth::id())->first();
            if ($task)
            {
                while ($check == 0)
                {
                    $count++;
                    $task1 = task_packages::where('title', 'like', Request::input('nTitle') . '_' . $count)->where('user_id', '=', Auth::id())->first();
                    if (!$task1)
                    {
                        $check = 1;
                    }
                }
            }
            //$count = task_packages::where('title', 'like', Request::input('title'))->where('user_id', '=', Auth::id())->count();
            if ($check == 1)
            {
                task_packages::where('id', '=', Request::input('pid'))->update(['title' => Request::input('nTitle') . '_' . $count]);
            }
            else
            {
                task_packages::where('id', '=', Request::input('pid'))->update(['title' => Request::input('nTitle')]);
            }
            $result['success'] = true;
            return json_encode($result);
        }

    }

    public function RemovePackage()
    {

        task_packages::where('id', Request::input('pid'))->delete();

        return json_encode('ok');

    }

    public function RemoveFromPackage1()
    {
        $task_id = task_assignments::where('id', '=', Request::input('id'))->firstOrFail()->task_id;
        $x = DB::table('hamahang_task_user_package')->where('hamahang_task_user_package.package_id', Request::input('pid'))->where('hamahang_task_user_package.uid', Auth::id())->where('hamahang_task_user_package.task_id', $task_id)->update(['deleted_at' => time()]);

        $packages = DB::table('hamahang_task_user_package')->join('hamahang_task_package', 'hamahang_task_user_package.package_id', 'hamahang_task_package.id')->select('hamahang_task_package.id', 'hamahang_task_package.title')->where('hamahang_task_user_package.task_id', '=', $task_id)->where('hamahang_task_user_package.uid', '=', Auth::id())->whereNull('hamahang_task_user_package.deleted_at')->get();
        return json_encode($packages);
    }
}