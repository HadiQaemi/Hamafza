<?php
//-----------Begin---------------- Api Services -------------------Begin---------------//
if (!function_exists('CheckToken'))
{

    function CheckToken($token)
    {
        $t = Token::where('token', '=', $token)->first();
        if (isset($t) && $t)
        {
            $max_idle_time = strtotime($t->last_response_time) + $t->life_time;
            if (time() < $max_idle_time)
            {
                $t->last_response_time = date('c', time());
                $t->save();
                return $t;
            }
            else
            {
                $t->delete();
                return false;
            }
        }
        else
        {
            return false;
        }
    }

}
if (!function_exists('CheckTokenGustMode'))
{

    function CheckTokenGustMode($token)
    {
        $t = Token::where('token', '=', $token)->where('uid', '=', 0)->first();
        if (isset($t) && $t->guest_mode == 1)
        {
            $max_idle_time = strtotime($t->last_response_time) + $t->life_time;
            if (time() < $max_idle_time)
            {
                $t->last_response_time = date('c', time());
                $t->save();
                return true;
            }
            else
            {
                $t->delete();
                return false;
            }
        }
        else
        {
            return false;
        }
    }

}
if (!function_exists('validation_error_to_api_json'))
{

    function validation_error_to_api_json($errors)
    {
        $j = 0;
        foreach ($errors->getMessages() as $key => $value)
        {
            ++$j;
            $error[$j]['e_key'] = $key;
            $k = 0;
            foreach ($value as $ke => $v)
            {
                ++$k;
                $items_errors[$k]['e_text'] = $v;
            }
            $error[$j]['e_values'] = array_values($items_errors);
        }
        return array_values($error);
    }

}
if (!function_exists('GetMenu'))
{

    function GetMenu()
    {
        $menu = DB::table('departments')->where('view', '1')->select('name as title', DB::raw('CAST(pid as CHAR(12)) as pid'))->orderBy('orders')->get(); //DB::raw('CAST(id as CHAR(12)) as id'),
        return $menu;
    }

}
/*
 * $uid = (session('uid') != '') ? session('uid') : 0;
 * $sesid = (session('sesid') != '') ? session('sesid') : 0;
 */
if (!function_exists('Get_Portals'))
{

    function Get_Portals($uid = 0, $sesid = 0)
    {
        if ($uid != 0)
        {
            $NotIn = DB::table('subject_key')->select('sid')->where('kid', '=', '212')->get();
            $Shart = array();
            $i = 0;
            foreach ($NotIn as $PKey)
            {
                $Shart[$i] = $PKey->sid;
                $i++;
            }
            $UC = new PageClass();
            $Selpage = $UC->Sel_Page();
            $Portals = DB::table('subjects as s')
                ->leftJoin('pages as p', 'p.sid', '=', 's.id')
                ->where('s.kind', '=', '27')
                ->whereRaw("((( s.admin = $uid OR s.manager = $uid OR supporter = $uid OR supervisor = $uid )	AND ispublic = '0')	OR ispublic = '1')")
                ->whereRaw($Selpage)
                ->where('s.archive', '=', '0')
                ->where('s.list', '=', '1')
                ->whereNotIn('s.id', $Shart)
                ->select(DB::raw('CAST(p.id as CHAR(12)) as pid'), 's.title as title')
                ->orderby('s.title')
                ->get();
        }
        else
        {
            $NotIn = DB::table('subject_key')->select('sid')->where('kid', '=', '212')->get();
            $Shart = array();
            $i = 0;
            foreach ($NotIn as $PKey)
            {
                $Shart[$i] = $PKey->sid;
                $i++;
            }
            $UC = new PageClass();
            $Selpage = $UC->Sel_Page();
            $Portals = DB::table('subjects as s')
                ->leftJoin('pages as p', 'p.sid', '=', 's.id')
                ->where('s.kind', '=', '27')
                ->whereRaw($Selpage)
                ->where('s.archive', '=', '0')
                ->whereNotIn('s.id', $Shart)
                ->select(DB::raw('CAST(p.id as CHAR(12)) as pid'), 's.title as title')
                ->orderby('s.title')
                ->get();
        }
        $PortalsS = $Portals;
        $i = 1;
        foreach ($PortalsS as $value)
        {
            $value->sortid = "$i";
            $value->parent_id = "#";
            $i++;
        }
        return $Portals;
    }

}
if (!function_exists('Get_User_Wall'))
{

    function Get_User_Wall($user_id = 0)
    {
        $res = [
            [
                'post_id' => '15',
                'user_id' => '5',
                'pic' => 'https://srfatemi.ir/pics/user/Users.png',
                'time' => '5 هفته قبل',
                'full_name' => 'مدیر سامانه',
                'post' => 'عاشورا یکی از فروزان ترین خورشیدهای تاریخ است که در گذشته نمانده و همواره جاری است. شور عاشقانی که انتخاب شدند تا در این حماسه حاضر باشند، آبی که در حسرت لب های عباس ماند، خون علی اصغری که مظلومانه ترین بود، اسارتی که رقیه تحمل کرد و ... الهی رضا برضائک و تسلیماً لأمرک لامعبود سواک...',
                'comment_count' => '10',
                'like_count' => '4'
            ],
            [
                'post_id' => '45',
                'user_id' => '4280',
                'pic' => 'https://srfatemi.ir/pics/user/Users.png',
                'time' => '3 هفته قبل',
                'full_name' => 'ز. قربان اوغلی',
                'post' => 'مدتی است که نسخه 4 وب هم افزا به طور آزمایشی راه اندازی شده است. در این نسخه امکانات بیشتری برای کاربران فراهم شده که به زودی به اطلاع شما خواهیم رساند. از اینکه هم افزا برای شما مفید باشد، خوشحال می شویم!',
                'comment_count' => '0',
                'like_count' => '3'
            ],
            [
                'post_id' => '32',
                'user_id' => '2',
                'pic' => 'https://srfatemi.ir/pics/user/Users.png',
                'time' => '4 هفته قبل',
                'full_name' => 'ین رزاده',
                'post' => 'بخش های «تعریف محدوده» و «تدوین مستندات» چارچوب طرح سامانه دانش سازمان اصلاح و کامل شده اند. همکاران محترم به ویژه کسانی که در جلسات آموزشی در روز یکشنبه 95/03/16 شرکت نمودند، به موارد تکمیل شده توجه نمایند.',
                'comment_count' => '5',
                'like_count' => '7'
            ],
            [
                'post_id' => '23',
                'user_id' => '4260',
                'pic' => '',
                'time' => '1 هفته قبل',
                'full_name' => 'سید رضا فاطمی امین',
                'post' => 'سازمان ای پی کیو سی (APQC) فعالیت هایی در حوزه مدیریت دانش انجام می دهد و مستنداتی بر روی وبگاه خود قرار داده که برخی از آنها بدون عضویت قابل دریافت هستند.نشانی:https://www.apqc.org/knowledge-management',
                'comment_count' => 'ندارد',
                'like_count' => 'ندارد'
            ],
        ];
        return $res;
    }

}
if (!function_exists('Get_User_Info'))
{

    function Get_User_Info($username)
    {
        $user = User::where("Uname", $username)->select(DB::Raw('CAST(id AS CHAR(12)) as uid ,Name, Family, Summary, Email, Pic'))->first();
        if (isset($user->Pic) && !empty($user->Pic))
        {
            $user->Pic = config('constants.SiteAddress') . 'userpic/' . $user->Pic;
        }
        else
        {
            $user->Pic = "";
        }
        $user->wall_count = "10";
        $user->desktop_count = "15";
        return $user;
    }

    if (!function_exists('can'))
    {

        function can($permission, $code = 403, $message = '', array $headers = [])
        {
            abort_unless(Auth::user()->can($permission), $code, $message, $headers);
        }

    }
    if (!function_exists('apiCan'))
    {

        function apiCan($permission)
        {
            if (!Auth::user()->can($permission))
            {
                return json_encode(array('access' => false));
            }
            else
            {
                return json_encode(array('access' => true));
            }
        }

    }
}
if (!function_exists('GetUserDesktopInfo'))
{

    function GetUserDesktopInfo($user_id)
    {
        $UC = new UserClass();
        $info = $UC->DesktopDashboard($user_id);
        return $info;
    }

}
//----------------End-------------- Api Services -------------------End---------------//