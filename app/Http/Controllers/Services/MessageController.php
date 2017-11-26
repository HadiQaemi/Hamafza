<?php

namespace App\Http\Controllers\Services;

use App\HamafzaPublicClasses;
use Request;
use App\Http\Controllers\Controller;
use App\HamafzaServiceClasses\UserClass;
use Validator;

class MessageController extends Controller
{
    public function get_inbox_messages()
    {
        if (!CheckToken(Request::input('token')))
        {
            $res =
                [
                    'status' => "-1",
                    'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
                ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $res =
            [
                'status' => "1",
                'main' =>
                    [
                        'type' => '14',
                        'data' =>
                            [
                                [
                                    'mid' => '45',
                                    'uid' => '253',
                                    'u_full_name' =>'سعید پیروز' ,
                                    'u_img'=>'http://hamafza.ir/pics/user/851469947763.jpg',
                                    'msg_content'=>'رضا فردا یادت نره امتحان تافل بیای ها ...',
                                    'create_time' => 'یک دقیقه پیش',
                                    'read'=>'1'
                                ],
                                [
                                    'mid' => '36',
                                    'uid' => '876',
                                    'u_full_name' => 'علی صدیقی',
                                    'u_img'=>'http://hamafza.ir/pics/user/42601465807093.jpg',
                                    'msg_content'=>'شرکت در گردهمایی بزرگداشت از استاد شهرام ناظری ...',
                                    'create_time' => 'پنچ ساعت قبل',
                                    'read'=>'0'
                                ],
                                [
                                    'mid' => '18',
                                    'uid' => '345',
                                    'u_full_name' => 'اکبر فردی',
                                    'u_img'=>'http://hamafza.ir/pics/user/Users.png',
                                    'msg_content'=>'امروز بک همایش جدید دعوت شدی ...',
                                    'create_time' => '2 روز پیش',
                                    'read'=>'1'
                                ],
                                [
                                    'md' => '3',
                                    'ud' => '456',
                                    'u_full_name' =>'نادر هاشمی' ,
                                    'u_img'=>'http://hamafza.ir/pics/user/Users.png',
                                    'msg_content'=>'سلام رضا کجایی پسر ؟؟؟ ..',
                                    'create_time' => 'یک ماه قبل',
                                    'read'=>'1'
                                ],
                            ]
                    ]
            ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }
}
