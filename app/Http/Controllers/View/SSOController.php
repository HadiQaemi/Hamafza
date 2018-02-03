<?php

namespace App\Http\Controllers\View;

use App\Models\hamafza\UserCircle;
use Illuminate\Http\Request;
use App\HamafzaServiceClasses\SSOClass;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\HamafzaServiceClasses\UserClass;
use Illuminate\Support\Facades\Hash;

use App\HamafzaViewClasses\KeywordClass;
use App\HamafzaViewClasses;
use Validator;

class SSOController extends Controller
{

    public function Logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        session(['Login' => 'FALSE']);
        return Redirect()->to('/');
    }

    public function Login(Request $request)
    {
        $uname = $request->input('username');
        $password = $request->input('password');
        $device_type = $request->input('device');
        $Userss = DB::table('user')
            ->select('id', 'Temp_pass', 'password')
            ->where('Temp_pass', 0)
            ->where('Uname', $uname)
            ->first();
        if ($Userss)
        {
            $id = $Userss->id;
            $storedpass = $Userss->password;
            $originalSalt = substr($storedpass, 0, 9);
            $ssalt = substr($originalSalt, 0, 9);
            $Password = $originalSalt . sha1($originalSalt . $password);
            if ($storedpass == $Password)
            {
                $newpassword = Hash::make($password);
                DB::table('user')->where('id', $id)->update(['password' => $newpassword, 'Temp_pass' => 1]);
                $password = $newpassword;
            }
            else
            {
                session(['Login' => 'FALSE']);
                session(['uid' => 0]);
                $mes = trans('mainmessage.LoginFail');
                $mestype = 'error';
                return redirect()->back()->with('message', $mes)->with('mestype', $mestype);
            }
        }
        else
        {
            if (Auth::attempt(['Uname' => $uname, 'password' => $password]))
            {
                $session_id = '';
                $Userss = User::select('id', 'Uname', 'Pic', 'Name', 'Family', 'Active', 'Email')->where('Uname', $uname)->first();
                if ($Userss->state == '0')
                {
                    $ref['Login'] = FALSE;
                    $ref['Message'] = 'این کاربر وجود ندارد';
                    return $ref;
                }
                $dt = new \DateTime();
                $update = User::where('id', '=', $Userss->id)->first();
                $update->last_login = $dt->format('Y-m-d H:i:s');
                $update->device_type = $device_type;
                $update->last_session_id = $session_id;
                $update->save();
                session(['uid' => $Userss->id]);
                session(['Uname' => $Userss->Uname]);
                session(['Summary' => $Userss->Summary]);
                session(['Name' => $Userss->Name]);
                session(['Family' => $Userss->Family]);
                session(['pic' => $Userss->Pic]);
                session(['Login' => 'TRUE']);
                session(['email' => $Userss->Email]);
                $UC = new UserClass();
                $OG = $UC->MyOrganGroups($Userss->id, 0);
                $OG = json_encode($OG);
                $OG = json_decode($OG);
                session(['MyOrganGroups' => $OG]);
                $mes = trans('mainmessage.LoginOK');
                $mestype = 'success';
            }
            else
            {
                session(['Login' => 'FALSE']);
                session(['uid' => 0]);
                $mes = trans('mainmessage.LoginFail');
                $mestype = 'error';
            }
        }

        if ($request->input('login_state'))
        {
            $result['result'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
        else
        {
            return redirect()->back()->with('message', $mes)->with('mestype', $mestype);
        }
    }

    public function Register(Request $request)
    {
        if ($request->input('register_state'))
        {
//            dd($request->all());
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'email' => 'required|email|unique:user,Email',
                'pass' => 'required|min:6',
                'name' => 'required',
                'family' => 'required'
            ]);

            if ($validator->fails())
            {
                $result['error'] = $validator->errors();
                $result['success'] = false;
                return json_encode($result);
            }
            else
            {
                $ss = new SSOClass();
                $user = $ss->Register
                (
                    $request->input('username'),
                    $request->input('name'),
                    $request->input('family'),
                    $request->input('email'),
                    $request->input('pass'),
                    'local'
                );
                if (is_numeric($user))
                {
                    $s = SSOClass::Login($request->input('username'), $request->input('pass'), '0');
                    session(['NewUser' => 'NewUser']);
                }

                $result['registered_user'][] = $request->input('username');
                $result['header'][] = trans('app.register_is_success');
                $result['message'][] = trans('app.return_with_login_after_while');
                $result['success'] = true;
                return json_encode($result);
            }
        }
        else
        {
            $uname = $request->input('usename');
            $password = $request->input('passwordhid');
            $device_type = $request->input('device');
            $username = $request->input('username');
            $password = $request->input('pass');
            $name = $request->input('name');
            $family = $request->input('family');
            $email = $request->input('email');
            $ss = new SSOClass();
            $user = $ss->Register($username, $name, $family, $email, $password, 'local');
            if (is_numeric($user))
            {
                $s = SSOClass::Login($username, $password, '0');
                session(['NewUser' => 'NewUser']);
                return Redirect()->to(url($username));
            }
            else
            {
                return Redirect()->back()->with('message', $user)->with('mestype', 'error');
            }
        }
    }

    public function login_user()
    {
        if (!auth::check())
        {
            return view('layouts.helpers.auth_master.login');
        }
        else
        {
            return redirect()->route('home');
        }
    }

    public function register_user()
    {
        if (!auth::check())
        {
            return view('layouts.helpers.auth_master.register');
        }
        else
        {
            return redirect()->route('home');
        }
    }


    //Temp Login/Register
    public function testLogin(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'captcha_code' => 'required|check_captcha:login',
                'username' => 'required|min:6|max:255',
                'password' => 'required|min:1|max:255',
            ],
            [
                'check_captcha' => 'کد امنیتی نادرست است. لطفا مجددا سعی کنید.'
            ],
            [
                'captcha_code' => 'کد امنیتی'
            ]);
        if ($validator->fails())
        {
            if ($validator->errors()->has('captcha_code'))
            {
                $validator = Validator::make($request->all(),
                    [
                        'captcha_code' => 'required|check_captcha:login'
                    ],
                    [
                        'check_captcha' => 'کد امنیتی نادرست است. لطفا مجددا سعی کنید.'
                    ],
                    [
                        'captcha_code' => 'کد امنیتی'
                    ]);
                $result['error'] = $validator->errors();
                $result['success'] = false;
                return json_encode($result);
            }
            else
            {
                $result['error'] = $validator->errors();
                $result['success'] = false;
                return json_encode($result);
            }
        }
        else
        {
            if (Auth::attempt(['Uname' => $request->username, 'password' => $request->password]))
            {
                $result['result'][] = trans('app.operation_is_success');
                $result['success'] = true;
                return json_encode($result);
            }
            else
            {
                $result['result'][] = 'خطا در ورود';
                $result['success'] = false;
                return json_encode($result);
            }
        }
    }

    public function testRegister(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'captcha_code' => 'required|check_captcha:register',
                'username' => 'required|unique:user,Uname',
                'email' => 'required|email|unique:user,Email',
                'password' => 'required|confirmed|min:8', //|regex:/^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/
                'name' => 'required',
                'family' => 'required'
            ],
            [
                'password.regex' => 'کلمه عبور باید حداقل 8 کاراکتر باشد.'
            ]);

        if ($validator->fails())
        {
            if ($validator->errors()->has('captcha_code'))
            {
                $validator = Validator::make($request->all(),
                    [
                        'captcha_code' => 'required|check_captcha:register'
                    ],
                    [
                        'check_captcha' => 'کد امنیتی نادرست است. لطفا مجددا سعی کنید.'
                    ],
                    [
                        'captcha_code' => 'کد امنیتی'
                    ]);
                $result['error'] = $validator->errors();
                $result['success'] = false;
                return json_encode($result);
            }
            else
            {
                $result['error'] = $validator->errors();
                $result['success'] = false;
                return json_encode($result);
            }
        }
        else
        {
            $user = new User();
            $user->Uname = $request->username;
            $user->Email = $request->email;
            $user->Password = bcrypt($request->password);
            $user->Name = $request->name;
            $user->Family = $request->family;
            $user->save();
            $user->attachRole('registerd');
            for ($i = 0; $i <= 2; $i++)
            {
                $user_circle = new UserCircle();
                $user_circle->uid = $user->id;
                $user_circle->name = 'خانواده';
                $user->orders = $i;
                $user_circle->save();
            }
        }

        $result['message'][] = trans('app.register_is_success');
        $result['success'] = true;
        return json_encode($result);
    }
}
