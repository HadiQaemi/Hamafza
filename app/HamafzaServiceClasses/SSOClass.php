<?php

namespace App\HamafzaServiceClasses;
use Auth;
use App\HamafzaPublicClasses\FunctionsClass;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\settings;
use Illuminate\Support\Facades\Hash;

class SSOClass {

    public function GetAccessLevel($uid) {
        if (UserClass::permission('manage_users', $uid) == '1') {
            $i = 1;
            $ST = DB::table('access as a')
                            ->leftJoin('tools_group as t', 't.id', '=', 'a.type')
                            ->select(DB::Raw("a.id, a.name ,t.name as gname,a.Fname"))->where('group', '1')->orderby('gname')->get();
            foreach ($ST as $value) {
                $value->sortid = $i;
                $value->edit = '';
                $value->del = '';
                $i++;
            }
            $s['abzar'] = $ST;
            $ST = DB::table('access as a')
                            ->select(DB::Raw("a.id, a.name ,a.Fname"))->where('group', '2')->get();
            foreach ($ST as $value) {
                $value->sortid = $i;
                $value->edit = '';
                $value->del = '';
                $i++;
            }
            $s['peik'] = $ST;

            $ST = DB::table('access as a')
                            ->select(DB::Raw("a.id, a.name ,a.Fname"))->where('group', '3')->get();
            foreach ($ST as $value) {
                $value->sortid = $i;
                $value->edit = '';
                $value->del = '';
                $i++;
            }
            $s['pages'] = $ST;

            $Ret['Access'] = $s;
            $Ret['ACL'] = DB::table('accesslevel')->orderBy('id')->get();
            $err = false;
        } else {
            $err = true;
            $Ret = trans('labels.AdminFail');
        }

        return $Ret;
    }

    public static function Login($uname, $password, $device_type) {
        if (Auth::attempt(['Uname' => $uname, 'password' => $password])) {
            $session_id = '';
            $Userss = User::select('id', 'Uname','Pic', 'Name', 'Family', 'Active', 'Email', 'last_session_id')->where('Uname', $uname)->first();
            if ($Userss->state == '0') {
                $ref['Login'] = FALSE;
                $ref['Message'] = 'این کاربر وجود ندارد';
                return $ref;
            }
            $dt = new \DateTime();
            $last_ses_id = $Userss->last_session_id;
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
            return $OG;
            session(['MyOrganGroups' => $OG]);
//            session('DesktopNotificaton', $Userss->DesktopNotificaton);
//            session('WallNotificaton', $Userss->WallNotificaton);
            return session('Login');
        } else {
            session(['Login' => 'FALSE']);
            session(['uid' => 0]);
            return false;
        }
    }

    public function Register($user_name, $user_FirstName, $user_family, $user_mail, $user_pass, $islocal) {
        $error = false;
        $user_add = array();
        $news_date = gmdate("Y-m-d H:i:s", time() + 12600);
        if ($user_name == "" || !$this->check_email($user_mail)) {
            if ($user_name == "")
                $message = trans('labels.error_user_name');
            if ($user_name == "")
                $message = trans('labels.error_user_name');
            if (!$this->check_email($user_mail))
                $message = trans('labels.error_user_mail');
            $error = true;
        }
        elseif (!($this->checkUniqueUser("Email", $user_mail) == TRUE) || (trim($user_name) != "" && !($this->checkUniqueUser("Uname", $user_name) == TRUE)) || $user_pass == "") {
            if (!($this->checkUniqueUser("Email", $user_mail) == TRUE))
                $message = trans('labels.error_email_repeat');
            if (!($this->checkUniqueUser("Uname", $user_name) == TRUE))
                $message = trans('labels.error_uname_repeat');
            if ($user_pass == "")
                $message = trans('labels.error_user_pass');
            $error = true;
        }
        else {
            $password = Hash::make($user_pass);
            $secgroup = 0;
            $secgroups = DB::table('sec_groups')->where('defualt', '1')->select('id')->first();
            if ($secgroups)
                $secgroup = $secgroups->id;
            $tm = date("Y-m-d h:i:sa");
            $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
            $uid = DB::table('user')->insertGetId(array('Uname' => $user_name, 'Email' => $user_mail, 'Name' => $user_FirstName, 'Family' => $user_family, 'Reg_date' => $reg_date, 'Password' => $password,
                'SecGroups' => $secgroup, 'Active' => '1'));
            $user = User::find($uid);
            $user->attachRole('registerd');
            for ($i = 0; $i < 3; $i++) {
                $cid = $uid * 10 + $i;
                $name = 'صفحه جدید';
                if ($i == 0) {
                    $name = 'خانواده';
                }
                if ($i == 1) {
                    $name = 'دوستان';
                }
                if ($i == 2) {
                    $name = 'همکاران';
                }
                DB::table('user_circle')->insert(array('id' => $cid, 'uid' => $uid, 'name' => $name, 'orders' => $i));
            }

            $message = $uid;

            $error = false;
        }
        if ($islocal == 'local')
            return $message;
        else
            return FunctionsClass::JSON($message, $error);
    }

    public function check_email($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }

    public function checkUniqueUser($field, $value) {
        $count = User:: select('id')->where($field, '=', $value)->count();
        if ($count == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
