<?php

//-----------Begin---------------- Api Services -------------------Begin---------------//
use App\User;
use App\Token;
use App\HamafzaServiceClasses\PageClass;
use App\HamafzaServiceClasses\PostsClass;

if (!function_exists('CheckToken')) {

    function CheckToken($token) {
        $t = Token::where('token', '=', $token)->first();
        if (isset($t) && $t) {
            $max_idle_time = strtotime($t->last_response_time) + $t->life_time;
            if (time() < $max_idle_time) {
                $t->last_response_time = date('c', time());
                $t->save();
                return $t;
            } else {
                $t->delete();
                return false;
            }
        } else {
            return false;
        }
    }

}

if (!function_exists('getUser')) {

    function getUser() {
        $validator = Validator::make(Request::all(), [
                    'token' => 'required',
        ]);
        if ($validator->fails()) {
            $error = validation_error_to_api_json($validator->errors());
            $res = [
                'status' => "-1",
                'error' => $error
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        if (!CheckToken(Request::input('token'))) {
            $res = [
                'status' => "401",
                'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        return Token::where('token', Request::input('token'))->first()->user;
       
        
    }

}
if (!function_exists('CheckTokenGustMode')) {

    function CheckTokenGustMode($token) {
        $t = Token::where('token', '=', $token)->where('uid', '=', 0)->first();
        if (isset($t) && $t->guest_mode == 1) {
            $max_idle_time = strtotime($t->last_response_time) + $t->life_time;
            if (time() < $max_idle_time) {
                $t->last_response_time = date('c', time());
                $t->save();
                return true;
            } else {
                $t->delete();
                return false;
            }
        } else {
            return false;
        }
    }

}
if (!function_exists('validation_error_to_api_json')) {

    function validation_error_to_api_json($errors) {
        $j = 0;
        foreach ($errors->getMessages() as $key => $value) {
            ++$j;
            $error[$j]['e_key'] = $key;
            $k = 0;
            foreach ($value as $ke => $v) {
                ++$k;
                $items_errors[$k]['e_text'] = $v;
            }
            $error[$j]['e_values'] = array_values($items_errors);
        }
        return array_values($error);
    }

}
if (!function_exists('GetMenu')) {

    function GetMenu() {
        $menu = DB::table('departments')->where('view', '1')->select('name as title', DB::raw('CAST(pid as CHAR(12)) as pid'))->orderBy('orders')->get(); //DB::raw('CAST(id as CHAR(12)) as id'),
        return $menu;
    }

}
/*
 * $uid = (session('uid') != '') ? session('uid') : 0;
 * $sesid = (session('sesid') != '') ? session('sesid') : 0;
 */
if (!function_exists('Get_Portals')) {

    function Get_Portals($uid = 0, $sesid = 0) {
        if ($uid != 0) {
            $NotIn = DB::table('subject_key')->select('sid')->where('kid', '=', '212')->get();
            $Shart = array();
            $i = 0;
            foreach ($NotIn as $PKey) {
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
        } else {
            $NotIn = DB::table('subject_key')->select('sid')->where('kid', '=', '212')->get();
            $Shart = array();
            $i = 0;
            foreach ($NotIn as $PKey) {
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
        foreach ($PortalsS as $value) {
            $value->sortid = "$i";
            $value->parent_id = "#";
            $i++;
        }
        return $Portals;
    }

}
if (!function_exists('Get_User_Wall')) {

    function Get_User_Wall($id,$limit,$offset) {
        //$UC = new UserClass();
        //$User = User::where('Uname', $user)->firstOrFail();

        $PostsClass = new PostsClass();
        return $PostsClass->UserWall($id, $limit,$offset,true);
    }

}
if (!function_exists('Get_User_Info')) {

    function Get_User_Info($username) {
        $user = User::where("Uname", $username)->select(DB::Raw('CAST(id AS CHAR(12)) as uid ,Name, Family, Summary, Email, Pic'))->first();
        if (isset($user->Pic) && !empty($user->Pic)) {
            $user->Pic = config('constants.SiteAddress') . 'userpic/' . $user->Pic;
        } else {
            $user->Pic = "";
        }
        $user->wall_count = "0";
        $user->desktop_count = "0";
        return $user;
    }

    if (!function_exists('can')) {

        function can($permission, $code = 403, $message = '', array $headers = []) {
            abort_unless(Auth::user()->can($permission), $code, $message, $headers);
        }

    }
    if (!function_exists('apiCan')) {

        function apiCan($permission) {
            if (!Auth::user()->can($permission)) {
                return json_encode(array('access' => false));
            } else {
                return json_encode(array('access' => true));
            }
        }

    }
}
if (!function_exists('GetUserDesktopInfo')) {

    function GetUserDesktopInfo($user_id) {
        $UC = new UserClass();
        $info = $UC->DesktopDashboard($user_id);
        return $info;
    }

}

//----------------End-------------- Api Services -------------------End---------------//