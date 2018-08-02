<?php

namespace App\Http\Controllers\Services;

use Request;
use App\Models\Hamahang\Tasks\tasks;
use App\Http\Controllers\Controller;

class TaskController extends Controller {

    public function get_my_tasks() {
        $user = getUser();
        $tasks = tasks::MyTasksSummary($user->id);
        foreach ($tasks as $key => $value) {
            $value->respite = strtotime($value->schedule_time) + $value->duration_timestamp;
        }
        $res = [
                    'status' => "1",
                    'data' => $tasks
        ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

}
