<?php

namespace App\Http\Controllers\Hamahang;

use App\HamafzaServiceClasses\UserClass;
use App\Mail\SendPasswordChangedEmail;
use App\Mail\SendForgetPasswordEmail;
use App\Models\hamafza\UserEducation;
use App\Http\Controllers\Controller;
use App\Models\hamafza\UserProfile;
use App\Models\hamafza\UserSpecial;
use App\Models\hamafza\UserCircle;
use App\Models\hamafza\UserWork;
use App\Models\hamafza\Keyword;
use App\Models\Hamahang\FileManager\FileManager;
use App\Models\Hamahang\ProvinceCity\City;
use App\Role;
use App\UserRole;
use Illuminate\Http\Request;
use Route;
use Validator;
use App\User;
use Mail;
use Auth;

class UserController extends Controller
{
    private function must_be_removed_login_vars($user)
    {
        session(['uid' => $user->id]);
        session(['Uname' => $user->Uname]);
        session(['Summary' => $user->Summary]);
        session(['Name' => $user->Name]);
        session(['Family' => $user->Family]);
        session(['pic' => $user->Pic]);
        session(['Login' => 'TRUE']);
        session(['email' => $user->Email]);
        $UC = new UserClass();
        $OG = $UC->MyOrganGroups($user->id, 0);
        $OG = json_decode($OG);
        session(['MyOrganGroups' => $OG]);
        $dt = new \DateTime();
        $user->last_login = $dt->format('Y-m-d H:i:s');
        $user->device_type = '';
        $user->last_session_id = '';
        $user->save();
    }

    private function generateHash($password, $salt = null)
    {
        if ($salt === null)
        {
            $salt = substr(md5(uniqid(rand(), true)), 0, 9);
        }
        else
        {
            $ssalt = substr($salt, 0, 9);
        }
        return $salt . sha1($salt . $password);
    }

    private function oldAttempt($username, $non_hashed_password)
    {
        $user = User::where('Uname', '=',$username)
            ->where('new_pass', '!=',"1")
            ->first();
        if ($user)
        {
            $salt = substr($user->password, 0, 9);
            $password = $salt . sha1($salt . $non_hashed_password);
            if ($password == $user->password)
            {
                $user->password = bcrypt($non_hashed_password);
                $user->new_pass = "1";
                $user->save();
                return true;
            }
        }
        return false;
    }
    //*****************************************************************
    ///////////////////// User Management Methods ////////////////////

    public function index($name)
    {
//        $res = variable_generator('user', 'user_list', $name);
//        return view($res['viewname'], $res);

        $users = User::all();
//        return view('hamahang.users.index')->with('users', $users);
        $sr = '';
        if (isset($_GET['sr']) && $_GET['sr'] != '')
        {
            $sr = $_GET['sr'];
        }
        $res = variable_generator('user', 'user_list', $name, ['sr' => $sr]);
        return view($res['viewname'], $res)->with('users', $users);
    }

    public function getUsers(Request $request)
    {
        if (!empty($request->input('extra')))
        {
            $extra_search = $request->input('extra');
            $users = User::select('Uname', 'id', 'Name', 'Family', 'Active', 'created_at')
                ->with(['_roles' => function ($query) use ($extra_search)
                {
                    $query->whereIn('role_id', $extra_search);
                }])
                ->whereHas('_roles', function ($query) use ($extra_search)
                {
                    $query->whereIn('role_id', $extra_search);
                })
                ->orderBy('id', 'DESC');
            return \Datatables::eloquent($users)
                ->addColumn('id_code', function ($data)
                {
                    return enCode($data->id);
                })
                ->addColumn('date', function ($data)
                {
                    if (isset($data->created_at))
                    {
                        return HDate_GtoJ($data->created_at);
                    }
                    else
                    {
                        return '';
                    }
                })
                ->addColumn('total_scores', function ($data)
                {
                    return $data->TotalScores ? $data->TotalScores : 0;
                })
                ->make(true);
        }
        else
        {
            $users = User::select('Uname', 'id', 'Name', 'Family', 'Active', 'created_at')->orderBy('id', 'DESC')->with('_roles');
//            dd($users[0]);

            return \Datatables::eloquent($users)
                ->addColumn('id_code', function ($data)
                {
                    return enCode($data->id);
                })
                ->addColumn('date', function ($data)
                {
                    if (isset($data->created_at))
                    {
                        return HDate_GtoJ($data->created_at);
                    }
                    else
                    {
                        return '';
                    }
                })
                ->addColumn('total_scores', function ($data)
                {
                    return $data->TotalScores ? $data->TotalScores : 0;
                })
                ->make(true);
        }
    }

    public function countUser()
    {
        $users = User::all()->count();
        echo json_decode($users);
    }

    public function countFilterUser(Request $request)
    {
        if (!empty($request->input('extra')))
        {
            $extra_search = $request->input('extra');
            $users = User::select('Uname', 'id', 'Name', 'Family', 'Active', 'created_at')
                ->with(['_roles' => function ($query) use ($extra_search)
                {
                    $query->whereIn('role_id', $extra_search);
                }])
                ->whereHas('_roles', function ($query) use ($extra_search)
                {
                    $query->whereIn('role_id', $extra_search);
                })->count();

            echo json_decode($users);
        }
        else
        {
            $users = User::all()->count();
            echo json_decode($users);
        }
    }

    public function addUsers(Request $request)
    {
        $messages = [
            'Name.required' => 'فیلد نام الزامی است .',
            'Family.required' => 'فیلد نام خانوادگی الزامی است .',
            'Uname.required' => 'فیلد نام کاربری الزامی است .',
            'Uname.unique' => 'نام کاربری قبلا انتخاب شده است.',
            'Uname.min' => 'فیلد نام کاربری نباید کمتر از 6 کاراکتر باشد',
            'password.required' => 'فیلد رمز ورود الزامی است .',
            'Email.required' => 'فیلد ایمیل الزامی است .',
            'Email.email' => 'فرمت ایمیل معتبر نیست .',
            'Email.unique' => 'ایمیل قبلا ثبت شده است .',
        ];
        $validator = \Validator::make($request->all(), [
            'Name' => 'required',
            'Family' => 'required',
            'Uname' => 'required|unique:user|min:6',
            'password' => 'required|confirmed|min:6',
            'Email' => 'required|email|unique:user',
        ], $messages);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {

            $user = new User;
            $user->Uname = $request->Uname;
            $user->password = bcrypt($request->password);
            $user->Name = $request->Name;
            $user->Family = $request->Family;
            $user->Email = $request->Email;
            $user->Active = '1';
            $user->save();

            $role = Role::whereIn('id', $request->roles_list)->get();
            $user->syncRoles($role);

            if ($user)
            {
                $result['success'] = true;
                $result['message'] = array("نام کاربر با موفقیت ذخیره شد");
                return json_encode($result);
            }
        }

    }

    public function editUser(Request $request)
    {

        $messages = [
            'Name.required' => 'فیلد نام الزامی است .',
            'Family.required' => 'فیلد نام خانوادگی الزامی است .',
            'Uname.required' => 'فیلد نام کاربری الزامی است .',
            'Uname.min' => 'فیلد نام کاربری نباید کمتر از 6 کاراکتر باشد',
            'password.required' => 'فیلد رمز ورود الزامی است .',
            'Email.required' => 'فیلد ایمیل الزامی است .',
            'Email.email' => 'فرمت ایمیل معتبر نیست .',
        ];
        $validator = \Validator::make($request->all(), [
            'Name' => 'required',
            'Family' => 'required',
            'Uname' => 'required|min:6',
            'password' => 'confirmed|min:6',
            'Email' => 'required|email',
        ], $messages);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $user = User::find(deCode($request->item_id));
            $user->Uname = $request->Uname;
            $user->password = bcrypt($request->password);
            $user->Name = $request->Name;
            $user->Family = $request->Family;
            $user->Email = $request->Email;
            $user->save();

            $role = Role::whereIn('id', $request->roles_list)->get();
            $user->syncRoles($role);

            if ($user)
            {
                $result['success'] = true;
                $result['message'] = array("نام کاربر با موفقیت  ویرایش شد");
                return json_encode($result);
            }
        }

    }

    public function editShowUsers(Request $request)
    {
        $users = User::where('id', deCode($request->id))->with('_roles')->first();
        return json_encode($users);
    }

    public function destroyUser(Request $request)
    {
        $User = User::destroy(deCode($request->id));
        if ($User)
        {
            $result['success'] = true;
            $result['message'] = array("کاربر مورد نظر با موفقیت حذف شد");
            return json_encode($result);
        }
    }

    //*****************************************************************
    ///////////////////// Login - Register Methods ////////////////////

    public function login()
    {
        if (auth()->check())
        {
            return redirect()->to(auth()->user()->Uname);
        } else
        {
            return view('layouts.helpers.auth_master.login');
        }
    }

    public function register()
    {
        if (!auth()->check())
        {
            return view('layouts.helpers.auth_master.register');
        }
        else
        {
            return redirect()->to(auth()->user()->Uname);
        }
    }










    public function login_user(Request $request)
    {

        $captcha = config('app.debug') ? '' : 'required|check_captcha:login';

        $validator = Validator::make($request->all(),
        [
            'captcha_code' => $captcha,
            'username' => 'required|max:255',
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
                    'captcha_code' => $captcha
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
            } else
            {
                $result['error'] = $validator->errors();
                $result['success'] = false;
                return json_encode($result);
            }
        } else
        {
            $username = str_replace(['.', ' '],'', $request->username);
            $username = strtolower($username);
            $old_user = $this->oldAttempt($username, $request->password);

            $check_attempt = Auth::attempt(['Uname' => $username, 'password' => $request->password], $request->remember_me == 'on' ? true : false);

            /*
            if ($request->remember_me == 'on')
            {
                $check_attempt = Auth::attempt(['Uname' => $username, 'password' => $request->password], true);
            } else
            {

                $check_attempt = Auth::attempt(['Uname' => $username, 'password' => $request->password]);

//              if ($request->remember_me == 'on')
//              {
//                  $remember_token = auth()->user()->remember_token;
//                  setcookie('remember_token', $remember_token, time() + (86400 * 30), "/");
//              }
            }
            */

            if ($check_attempt)
            {
//              if (rtrim(url()->previous(), '/') == route('home'))
//              {
//                  $previuos_url = '/' . auth()->user()->Uname;
//              } else
//              {
                    $previuos_url = url()->previous();
//              }
                $result['previous_url'] = $previuos_url;
                $result['result'][] = trans('app.operation_is_success');
                $result['success'] = true;
                session()->flash('message', 'خوش آمدید');
                session()->flash('mestype', 'success');
                //Old Values
                $this->must_be_removed_login_vars(User::where('Uname', $username)->first());
                //End Old Values
                return json_encode($result);
            }

        }

        $result['error']['login_failed'] = 'نام کاربری و یا کلمه عبور اشتباه وارد شده است. مجددا سعی نمایید.';
        $result['success'] = false;
        return json_encode($result);
    }










    public function register_user(Request $request)
    {
        if (config('app.debug'))
        {
            $captcha = '';
        }
        else
        {
            $captcha = 'required|check_captcha:register';
        }

        $validator = Validator::make($request->all(),
            [
                'captcha_code' => $captcha,
//                'username' => 'required|unique:user,Uname|regex:/^(?!.*__)^(?!.*\.\.)^(?!_)^(?!\.)(?!^\d+$)^[a-zA-Z\d-_.]{3,64}$/',
                'username' => 'required|unique:user,Uname|valid_username',
                'email' => 'required|email|min:6|max:255|unique:user,Email',
                'password' => 'required|confirmed|min:6|max:100|regex:/^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
                'name' => 'required',
                'family' => 'required'
            ],
            [
                'password.regex' => 'کلمه عبور باید حداقل دارای یک حرف کوچک، یک حرف بزرگ و یک عدد باشد.',
                'valid_username' => 'نام کاربری معتبر نمی‌باشد.'
//                'username.regex' => 'نام کاربری معتبر نمی‌باشد.'
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
            $valid_user = str_replace('.', '', $request->username);
            $valid_user = str_replace('_', '', $valid_user);
            $valid_user = str_replace(' ', '', $valid_user);

            $user = new User();
            $user->Uname = $valid_user;
            $user->Email = $request->email;
            $user->Password = bcrypt($request->password);
            $user->Name = $request->name;
            $user->Family = $request->family;
            $user->is_new = '1';
            $user->save();

            $registered_role = Role::find(config('constants.APP_REGISTERED_ROLE_ID'));
            $user->attachRole($registered_role);

            if (Auth::loginUsingId($user->id))
            {
                $result['user_profile_url'] = '/' . auth()->user()->Uname;
            }
        }


        $result['message'][] = trans('app.register_is_success');
        $result['success'] = true;
        session()->flash('message', 'ثبت نام با موفقیت انجام شد.');
        session()->flash('mestype', 'success');
        return json_encode($result);
    }

    public function send_remember_password_email(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'captcha_code' => 'required|check_captcha:remember_password',
            'email' => 'required|email|exists:user,Email'
        ]);

        if ($validator->fails())
        {
            if ($validator->errors()->has('captcha_code'))
            {
                $validator = Validator::make($request->all(),
                    [
                        'captcha_code' => 'required|check_captcha:remember_password'
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
            $user = User::where('Email', $request->email)->first();
            $user->reset_password_code = str_random(85);
            $user->reset_password_due_time = date("Y-m-d H:i:s");
            $user->save();
            $info =
            [
                'email' => $user->Uname,
                'reset_password' => $user->reset_password_code,
            ];
            Mail::to($request->input('email'))->send(new SendForgetPasswordEmail($info));
        }

        $result['message'][] = trans('app.register_is_success');
        session()->flash('message', 'ایمیل تغییر کلمه عبور ارسال شد.');
        session()->flash('mestype', 'success');
        $result['success'] = true;
        return json_encode($result);
    }

    public function reset_forgotten_password(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'captcha_code' => 'required|check_captcha:remember_password',
            'password' => 'required|confirmed|min:6|max:100|regex:/^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
        ]);

        if ($validator->fails())
        {
            if ($validator->errors()->has('captcha_code'))
            {
                $validator = Validator::make($request->all(),
                    [
                        'captcha_code' => 'required|check_captcha:remember_password'
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
            $user = User::where('Uname', $request->username)->first();
            $user->password = bcrypt($request->password);
            $user->reset_password_code = null;
            $user->save();
            $info = [
                'email' => $user->Uname
            ];
            Mail::to($user->Email)->queue(new SendPasswordChangedEmail($info));
        }

        $result['message'][] = trans('app.register_is_success');
        session()->flash('message', 'کلمه عبور با موفقیت تغییر یافت');
        session()->flash('mestype', 'success');
        $result['success'] = true;
        return json_encode($result);
    }

    public function reset_password($reset_password_code)
    {
        $user = User::where('reset_password_code', $reset_password_code)->first();
        if ($user)
        {
            if (strtotime($user->reset_password_due_time) + config('constants.APP_RESET_PASSWORD_DUE_TIME') > strtotime(date("Y-m-d H:i:s")))
            {
                return view('layouts.helpers.auth_master.reset_password')->with('username', $user->Uname);
            }
            else
            {
                session()->flash('message', 'اعتبار لینک تغییر کلمه عبور به پایان رسیده است؛ لطفا مجددا تلاش نمایید.');
                session()->flash('mestype', 'error');
                return redirect()->route('home');
            }
        }
        else
        {
            abort(403);
        }
    }

///////////////////////////////////////////////////////////////////
//*****************************************************************

//*****************************************************************
//////////////////////// Avatar Methods /////////////////////////

    public function saveAvatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|mimes:jpg,png,jpeg|max:1024',
        ]);
        if ($validator->fails())
        {
            $res = [
                'success' => false,
                'result' => $validator->errors()
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $upload = HFM_Upload($request->file('avatar'), 'Avatars/');
        $user = auth()->user();
        $user->avatar = $upload['ID'];
        $user->save();
        $res = [
            'success' => true,
            'result' => ['message' => trans('app.operation_is_success')],
            'img_id' => enCode($upload['ID'])
        ];

        session()->flash('message', 'تصویر پروفایل تغییر یافت');
        session()->flash('mestype', 'success');

        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

    public function removeAvatar()
    {
        $user = auth()->user();
        $user->avatar = null;
        $user->save();

        $res = [
            'success' => true,
            'result' => ['message' => trans('app.operation_is_success')],
        ];
        session()->flash('message', 'تصویر پروفایل حذف شد');
        session()->flash('mestype', 'success');
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

    public function renameAvatar(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'avatar_name' => 'required|max:200',
            'image_file_id' => 'required'
        ], [
            'image_file_id.required' => 'لطفا تصویری انتخاب نمایید',
        ], [
                'avatar_name' => 'نام تصویر',
                'image_file_id' => 'آیدی تصویر',
            ]
        );
        if ($validator->fails())
        {
            $res = [
                'success' => false,
                'result' => $validator->errors()
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $file = FileManager::find($request->input('image_file_id'));
        $file->originalName = $request->input('avatar_name');
        $file->save();
        $res = [
            'success' => true,
            'result' => ['message' => trans('app.operation_is_success')],
        ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

///////////////////////////////////////////////////////////////////
//*****************************************************************

//*****************************************************************
/////////////////////// User Specials Methods /////////////////////

    public function updateUserDetail(Request $request)
    {
//        dd($request->all());
        // dd($request->file('avatar_user'));
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|min:3|max:255',
                'family' => 'required|string|min:3|max:255',
                'summary' => 'min:3|max:255',
                'province' => 'numeric',
                'city' => 'numeric',
                'mobile' => 'mobile_phone',
                'tel_number' => 'numeric|digits:8',
                'tel_code' => 'numeric|digits:4',
                'fax_number' => 'numeric|digits:8',
                'fax_code' => 'numeric|digits:4',
                'avatar' => 'mimes:jpg,png,jpeg|max:1024',

            ],
            [
                'tel_code' => 'فرمت کد شهر فیلد تلفن ثابت رعایت نشده است.',
                'fax_code' => 'فرمت کد شهر فیلد فکس رعایت نشده است.',
                'avatar_user.mimes' => 'فرمت تصویر معتبر نیست',
            ],
            [
                'summary' => 'معرفی اجمالی',
                'tel_number' => 'شماره تلفن',
                'fax_number' => 'شماره فکس',
                'tel_code' => 'کد شهر فیلد تلفن ثابت',
                'fax_code' => 'کد شهر فیلد فکس',
                'avatar_user' => 'تصویر پروفایل'
            ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (auth()->check())
            {

                $user = auth()->user();
                $user->Name = $request->name;
                $user->Family = $request->family;
                $user->Summary = $request->summary;
                $user->Gender = $request->gender;
                if ($request->user_avatar)
                {
                    $upload = HFM_Upload($request->user_avatar, 'Avatars/');
                    $user = auth()->user();
                    $user->avatar = $upload['ID'];
                }

                $user->save();
                $profile = UserProfile::where('uid', $user->id)->first();
                if (!$profile)
                {
                    $profile = new UserProfile();
                    $profile->uid = $user->id;
                    $profile->save();
                }
                $profile->comment = $request->comment;
                $profile->birth_date = $request->birthday ? HDate_JtoG($request->birthday, '/', true) : null;
                $profile->Province = $request->province;
                $profile->City = $request->city;
                $profile->Mobile = $request->mobile;
                $profile->Tel_number = $request->tel_number;
                $profile->Tel_code = $request->tel_code;
                $profile->Fax_number = $request->fax_number;
                $profile->Fax_code = $request->fax_code;
                $profile->Website = $request->website;
                $profile->save();
            }
            $result['user_profile_url'] = '/' . auth()->user()->Uname;
            $result['message'][] = trans('acl.role_edited_successfully');
            $result['success'] = true;


//            $user->save();

            session()->flash('message', 'تغییرات با موفقیت ثبت گردید.');
            session()->flash('mestype', 'success');
            return redirect()->back();
//            return json_encode($result);
        }
    }

    public function updateUserPassword(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'pass_now' => 'required|regex:/^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
                'pass_new' => 'required|min:6|max:100|regex:/^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
                'pass_repeat' => 'required|in:' . $request->pass_new,

            ],
            [
                'pass_now.regex' => 'کلمه عبور فعلی صحیح نمی باشد',
                'pass_new.regex' => 'کلمه عبور باید حداقل دارای یک حرف کوچک، یک حرف بزرگ و یک عدد باشد.',
                'pass_repeat.in' => 'تکرار کلمه عبور صحیح نمی باشد',
            ],
            [
                'pass_now' => 'کلمه عبور فعلی',
                'pass_new' => 'کلمه عبور جدید',
                'pass_repeat' => 'تکرارکلمه عبور',

            ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (auth()->check())
            {
                if (auth()->user()->password == bcrypt($request->pass_now))
                {
                    $user = auth()->user();
                    $user->password = bcrypt($request->pass_new);
                    $user->save();
                    $result['message'][] = trans('acl.password_edited_successfully');
                    $result['success'] = true;
                    return json_encode($result);
                }
            }
        }
    }

    public function updateUserSpecials(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:user,id',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (auth()->check())
            {
                $user = User::find($request->item_id);
                if (count($request->user_specials))
                {
                    foreach ($request->user_specials as $special)
                    {
                        if (!is_numeric($special))
                        {
                            $keyword = Keyword::where('title', $special)->first();
                            if (!$keyword)
                            {
                                $keyword = new Keyword();
                                $keyword->title = $special;
                                $keyword->save();
                            }
                            $array_keyword_ids[] = $keyword->id;
                        }
                        else
                        {
                            $array_keyword_ids[] = $special;
                        }
                    }
                    $user->specials()->sync($array_keyword_ids);
                }
                else
                {
                    $user->specials()->sync([]);
                }
            }

            $result['message'][] = trans('acl.role_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }

    }

    public function addUserWork(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid' => 'required',
            'post' => 'required|string|min:3|max:250',
            'company' => 'required|string|min:3|max:250',
            'province' => 'numeric',
            'city' => 'numeric',
            'section' => 'string|min:3|max:255',
            'start_year' => 'jalali_date',
            'end_year' => 'jalali_date',
        ],
            [],
            [
                'start_year' => 'تاریخ شروع',
                'end_year' => 'تاریخ پایان',
                'post' => 'سمت',
                'company' => 'شرکت'
            ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (auth()->check())
            {
                $user_work = new UserWork();
                $user_work->uid = $request->uid;
                $user_work->company = $request->company;
                $user_work->section = $request->section;
                $user_work->post = $request->post;
                $user_work->province_id = $request->province;
                $user_work->city_id = $request->city;
                $user_work->start_year = $request->start_year;
                $user_work->end_year = $request->end_year;
                $user_work->comment = $request->comment;
                $user_work->save();
            }

            $result['message'][] = trans('acl.role_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function updateUserWork(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
            'uid' => 'required',
            'province' => 'required|numeric',
            'city' => 'required|numeric',
            'company' => 'required|string|min:3|max:250',
            'section' => 'string|min:3|max:255',
            'post' => 'required|string|min:3|max:250',
            'start_year' => 'required|jalali_date',
            'end_year' => 'required|jalali_date',
        ],
            [

            ],
            [
                'start_year' => 'تاریخ شروع',
                'end_year' => 'تاریخ پایان',
                'post' => 'سمت',
                'company' => 'شرکت'
            ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (auth()->check())
            {
                $user_work = UserWork::find($request->item_id);
                $user_work->uid = $request->uid;
                $user_work->company = $request->company;
                $user_work->section = $request->section;
                $user_work->post = $request->post;
                $user_work->province_id = $request->province;
                $user_work->city_id = $request->city;
                $user_work->start_year = $request->start_year;
                $user_work->end_year = $request->end_year;
                $user_work->comment = $request->comment;
                $user_work->save();
            }

            $result['message'][] = trans('acl.role_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function deleteUserWork(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (auth()->check())
            {
                UserWork::find($request->item_id)->delete();
            }

            $result['message'][] = trans('acl.role_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function addUserEducation(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'uid' => 'required',
            'major' => 'required|string|min:3|max:250',
            'grade' => 'required|string',
            'university' => 'string|min:3|max:64',
            'province' => 'required|numeric',
            'city' => 'required|numeric',
            'start_year' => 'required|jalali_date',
            'end_year' => 'required|jalali_date',
        ],
            [

            ],
            [
                'start_year' => 'تاریخ شروع',
                'end_year' => 'تاریخ پایان',
                'major' => 'رشته تحصیلی',
                'grade' => 'مقطع تحصیلی'
            ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (auth()->check())
            {
                $user_education = new UserEducation();
                $user_education->uid = $request->uid;
                $user_education->major = $request->major;
                $user_education->grade = $request->grade;
                $user_education->university = $request->university;
                $user_education->province_id = $request->province;
                $user_education->city_id = $request->city;
                $user_education->start_year = $request->start_year;
                $user_education->end_year = $request->end_year;
                $user_education->comment = $request->comment;
                $user_education->save();
            }

            $result['message'][] = trans('acl.role_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function updateUserEducation(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'uid' => 'required',
            'item_id' => 'required',
            'major' => 'required|string|min:3|max:250',
            'grade' => 'required|string',
            'university' => 'string|min:3|max:64',
            'province' => 'required|numeric',
            'city' => 'required|numeric',
            'start_year' => 'required|jalali_date',
            'end_year' => 'required|jalali_date',
        ],
            [

            ],
            [
                'start_year' => 'تاریخ شروع',
                'end_year' => 'تاریخ پایان',
                'major' => 'رشته تحصیلی',
                'grade' => 'مقطع تحصیلی'
            ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (auth()->check())
            {
                $user_education = UserEducation::find($request->item_id);
                $user_education->uid = $request->uid;
                $user_education->major = $request->major;
                $user_education->grade = $request->grade;
                $user_education->university = $request->university;
                $user_education->province_id = $request->province;
                $user_education->city_id = $request->city;
                $user_education->start_year = $request->start_year;
                $user_education->end_year = $request->end_year;
                $user_education->comment = $request->comment;
                $user_education->save();
            }

            $result['message'][] = trans('acl.role_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function deleteUserEducation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (auth()->check())
            {
                UserEducation::find($request->item_id)->delete();
            }

            $result['message'][] = trans('acl.role_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function userSpecialEndorse(Request $request)
    {
        $arr = $request->all();

        $s = UserSpecial::with('endorse_users')->where('id', $arr['id'])->first();

        $UserSpecial = UserSpecial::find($arr['id']);

        $UserSpec = $UserSpecial->endorse_users()->wherePivot('user_id', auth()->id())->first();

        if ($UserSpec)
        {
            $UserSpecial->endorse_users()->detach([auth()->id()]);
            $count_user_special = $UserSpecial->endorse_users()->select('user.id')->get()->toArray();
            $result['message'] = false;
            $result['count_user_special'] = count($count_user_special);
            return json_encode($result);
        }
        else
        {
            $UserSpecial->endorse_users()->attach([auth()->id()]);
            $count_user_special = $UserSpecial->endorse_users()->select('user.id')->get()->toArray();
            $result['message'] = true;
            $result['count_user_special'] = count($count_user_special);
            return json_encode($result);
        }
    }

    public function userEndorse(Request $request)
    {
        $arr = $request->all();
        $UserSpecial = UserSpecial::find($arr['id']);
        $count_user_special = $UserSpecial->endorse_users()->get();
        $i = 0;
        foreach ($count_user_special as $res)
        {
            $count_user_special[$i]->avatar = enCode($res->avatar);
            $i++;
        }
        return json_encode($count_user_special);
    }

    public function removeUserNew(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required'
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (auth()->check())
            {
                $user = User::find($request->item_id);
                $user->is_new = '0';
                $user->save();
            }

            $result['message'][] = trans('acl.role_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function cities(Request $request)
    {
        $cities = City::select('id', 'name as text')->where('province_id', $request->province_id)->get();
        return json_encode($cities);
    }

///////////////////////////////////////////////////////////////////
//*****************************************************************
}
