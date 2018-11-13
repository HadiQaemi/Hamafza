<?php

namespace App\Http\Controllers\Services;

use Request;
use App\Models\Hamahang\Tasks\tasks;
use App\Http\Controllers\Controller;
use App\Models\Hamahang\Tasks\task_assignments;
use App\Models\Hamahang\Tasks\task_status;
use App\HamahangCustomClasses\jDateTime;

class TaskController extends Controller {

    public function get_my_tasks() {
        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $tasks = tasks::MyTasksSummary($user->id, \Request::input('time'));
        foreach ($tasks as $key => $value) {
            $value->respite = strtotime($value->schedule_time) + $value->duration_timestamp;
        }
        $res = [
            'status' => "1",
            'data' => $tasks
        ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

    public function rapid_new_task() {
        $validator = \Validator::make(Request::all(), [
                    'immediacy' => 'required|in:0,1',
                    'importance' => 'required|in:0,1',
                    'task_title' => 'required|string',
                    'respite_date' => 'required|jalali_date:-',
                    'selected_users' => 'required',
                        ], [
                    'selected_users.required' => 'باید کاربر انتخاب شود'
                        ], [
                    'task_title' => 'عنوان وظیفه',
                    'selected_users' => 'کاربر'
                        ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $user = getUser();
            if (!isset($user->id)) {
                return $user;
            }
            \DB::transaction(function () use (&$task, &$employee, &$respite_date, &$status) {
                $user = getUser();
                $immediacy = Request::input('immediacy');
                $importance = Request::input('importance');
                $task_title = Request::input('task_title');
                $respite_date = Request::input('respite_date');
                $selected_users = explode(",", Request::input('selected_users'));
                $respite_duration_timestamp = hamahang_make_task_respite($respite_date, '08:00:00');

                $task = new tasks;
                $task->title = $task_title;
                $task->duration_timestamp = $respite_duration_timestamp;
                $task->schedule_time = date('Y-m-d H:i:s');
                $task->use_type = 0;
                $task->type = 0;
                $task->uid = $user->id;
                $task->save();

                $x = 0;
                $staff = '';
                if (sizeof($selected_users) > 0) {
                    foreach ($selected_users as $u) {
                        if ($x == 0) {
                            ///////نفر اول بعنوان مسوول ثبت می شود
//                            $assign = task_assignments::create_task_assignment($u, $task->id);
                            $staff = $u;
                            $x = 1;
                        }
//                        else
//                        {
//                            /////////// ثبت سایر افراد وظیفه
//                            task_staffs::create_task_staff($assign->id, $u);
//                        }
                        task_assignments::create_task_assignment($u, $staff, $task->id, 0, null, $user->id);
                    }
                }

                $status = task_status::create_task_status($task->id, 0, 0, $user->id, -1, $user->id);
                //$priority = task_priority::create_task_priority($task->id, $immediacy, $importance);
                $employee = \App\User::find($staff);

                $respite_date = hamahang_respite_remain(strtotime($task->schedule_time), $task->duration_timestamp);
                if ($respite_date[0]['delayed'] == 1) {
                    $task->respite_days = ($respite_date[0]['day_no']) * (-1);
                } else {
                    $task->respite_days = $respite_date[0]['day_no'];
                }
            });

            $res = [
                'success' => 'success',
                'status' => 1
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
    }

    public function get_tasks() {
        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $pid = Request::input('page_id');
        if ($pid !== null && trim($pid) !== "") {
            $page = \App\Models\hamafza\Pages::find($pid);
            $pid = $page->subject->id;
        }
        $Tasks = \App\Models\Hamahang\Tasks\tasks::MyTasks($pid, $user->id, false);
        //return response()->json($Tasks);
        $date = ''; //new \App\HamahangCustomClasses\JDateTime;
//        dd(Request::input('subject_id'));
//        dd(Request::input('subject_id'));
        $res = \Datatables::of($Tasks)
                ->editColumn('type', function ($data) {
                    return GetTaskStatusName($data->task_status);
                })
                ->addColumn('respite', function ($data) use ($date) {
                    $r = \App\HamahangCustomClasses\jDateTime::getdate(strtotime($data->schedule_time) + $data->duration_timestamp);
                    return $r['year'] . '/' . $r['mon'] . '/' . $r['mday'];
                })
                ->addColumn('keywords', function ($data) {
                    $r = (\App\Models\Hamahang\Tasks\tasks::TakKeywords($data->id));

                    $rr = [];
                    foreach ($r as $Ar)
                        $rr[] = ['id' => $Ar->id, 'title' => $Ar->title];
                    return json_encode($rr);
                })
                ->editColumn('immediate', function ($data) {
                    if ($data->immediate == 1) {
                        $output = 'فوری';
                    } else {
                        $output = 'غیرفوری';
                    }
                    if ($data->importance == 1) {
                        $output .= ' و مهم';
                    } else {
                        $output .= ' و غیرمهم ';
                    }
                    return $output;
                })
                ->addColumn('employeeName', function ($data) {
                    return $data->Name . ' ' . $data->Family;
                })
                ->rawColumns(['employeeName'])
                ->addColumn('employeeUname', function ($data) {
                    return $data->Uname;
                })
                ->rawColumns(['employeeUname'])
                ->make(true);


        return response()->json($res);
    }

}
