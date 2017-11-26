<?php

namespace App\Http\Controllers\Services;

use Request;
use App\Models\Hamahang\Tasks\tasks;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{

    public function get_my_tasks()
    {
        $token = CheckToken(Request::input('token'));
        if (!$token)
        {
            $res =
                [
                    'status' => "-1",
                    'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
                ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $tasks = tasks::MyTasks(4260, true);
        foreach ($tasks as $key => $value)
        {
            $value->created_at = strtotime($value->created_at);
            $value->duration_timestamp = $value->duration_timestamp == null ? 0 : $value->duration_timestamp;
            $value->status_title = GetTaskStatusName($value->type);
            $value->respite = hamahang_respite_remain($value->created_at, $value->duration_timestamp, true);
            $value->use_type = hamahang_get_task_use_type_name($value->use_type);
            $value->immediate == 1 ? $value->immediate = 'فوری' : $value->immediate = 'غیرفوری';
            $value->importance == 1 ? $value->importance = 'مهم' : $value->importance = 'غیرمهم';
            $value->type = "$value->type";
            $value->task_id = "$value->task_id";
            $value->created_at = "$value->created_at";
            $value->duration_timestamp = "$value->duration_timestamp";
        }
        $res =
            [
                'status' => "1",
                'main' =>
                    [
                        'type' => '15',
                        'data' => $tasks
                    ]
            ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

}
