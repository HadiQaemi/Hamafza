<?php

namespace App\Http\Controllers\Services;

use DB;
use Auth;
use Request;
use Validator;
use App\User;
use App\Token;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    public function login()
    {
        $guest_mode = Request::input('guest_mode');
        if( isset($guest_mode) && !empty($guest_mode))
        {
            $validator = Validator::make(Request::all(), [
                'imei'       => 'required',
                'os_name'    => 'required',
                'os_version' => 'required',
                'device_name'=> 'required'
            ]);
            if ($validator->fails())
            {
                $error = validation_error_to_api_json($validator->errors());
                $res =
                    [
                        'status'    => "-1",
                        'error'     => $error
                    ];
                return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8' ]);
            }
            $token = Token::GenerateToken(0,Request::input('imei'),Request::input('os_name'),Request::input('os_version'),Request::input('device_name'),1);
            $res =
                [
                    'status'  => "0",
                    'help'    => "http://hamafza.ir/18",
                    'menu'    => GetMenu(),
                    'main'    => array('type'=>'1', 'url'=>'api/v43/get_page_detail','data'=>Get_Portals()),
                    'token'   => $token['token'],
                ];
            return response()->json($res,200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8' ]);
        }

        $validator = Validator::make(Request::all(), [
            'username'   => 'required',
            'password'   => 'required',
            'imei'       => 'required',
            'os_name'    => 'required',
            'os_version' => 'required',
            'device_name'=> 'required'
        ]);

        if ($validator->fails())
        {
            $error = validation_error_to_api_json($validator->errors());
            $res =
                [
                    'status'    => "-1",
                    'error'     => $error
                ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8' ]);
        }
        $username = Request::input('username');
        $password = Request::input('password');
	if (Auth::attempt(['Uname' => $username, 'password' => $password],false,false) || Auth::attempt(['email' => $username, 'password' => $password],false,false) )
        {
            $user = Get_User_Info($username);
            $token = Token::GenerateToken($user->uid,Request::input('imei'),Request::input('os_name'),Request::input('os_version'),Request::input('device_name'));
            $res =
                [
                    'status'  => "1",
                    'help'    => "http://hamafza.ir/18",
                    'info'    => $user,
                    'menu'    => GetMenu(),
                    //'main'    => array('type'=>'2', 'url'=>'','data'=>Get_User_Wall($user->uid,1,0)),
                    'token'   => $token['token']
                ];
            return response()->json($res)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8' ]);
        }
        else
        {
            $res =
                [
                    'status'   => "-1",
                    'error'    => [ ['e_key'=>'username','e_values'=> [['e_text'=>"نام کاربری و رمزعبور نادرست است."]]] ]
                ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8' ]);
        }
    }

    public function register()
    {
        $validator = Validator::make(Request::all(), [
            'email'      => 'required|unique:user,Email',
            'username'   => 'required|unique:user,Uname',
            'password'   => 'required',
            'first_name' => 'required',
            'last_name'  => 'required',
            'imei'       => 'required',
            'os_name'    => 'required',
            'os_version' => 'required'
        ]);
        if ($validator->fails())
        {
            $error = validation_error_to_api_json($validator->errors());
            $res =
                [
                    'status'    => "-1",
                    'error'     =>$error
                ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8' ]);
        }

        $user = new User;
        $user->Uname = Request::input('username');
        $user->Email = Request::input('email');
        $user->Name = Request::input('first_name');
        $user->Password = Hash::make(Request::input('password'));
        $user->Family = Request::input('last_name');
        $user->save();
        $token = Token::GenerateToken($user->id,Request::input('imei'),Request::input('os_name'),Request::input('os_version'),Request::input('device_name'));
        $res =
            [
                'status'  => "1",
                'help'    => "http://hamafza.ir/18",
                'info'    => Get_User_Info(Request::input('username')),
                'menu'    => GetMenu(),
                //'main'    => array('type'=>'2', 'url'=>'','data'=>Get_User_Wall($user->uid,1,0)),
                'token'   => $token['token']
            ];
        return response()->json($res)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8' ]);
    }

    public function password_reset()
    {
        $validator = Validator::make(Request::all(), [
            'email'     => 'required|email|exists:user,Email'
        ]);

        if ($validator->fails())
        {
            $error = validation_error_to_api_json($validator->errors());
            $res =
                [
                    'status'    => "-1",
                    'error'     => $error
                ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8' ]);
        }
        $res =
            [
                'status'  => "1",
                'message'   =>  ['m_text'=>"لینک تغییر رمزعبور به ایمیل شما ارسال گردید."]
            ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8' ]);
    }

}
