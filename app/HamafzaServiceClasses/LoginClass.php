<?php

namespace App\HamafzaServiceClasses;
use Hash;

use Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class LoginClass {

   
    public function LocalLogin($uname, $password, $device_type, $orig) {
        if (Auth::attempt(['Uname' => $uname, 'password' => $password])) {
            $session_id = '';
            $Userss = User::select('id', 'Uname', 'Name', 'Family', 'Active', 'Email', 'last_session_id')->where('Uname', $uname)->first();
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
            session(['Login' => 'TRUE']);
            session(['SessionID' => $Userss->SessionID]);
            session(['last_session_id' => $Userss->last_session_id]);
            session(['email' => $Userss->Email]);
            $UC = new UserClass();
            $OG = $UC->MyOrganGroups($Userss->id, 0);
            $OG = json_encode($OG);
            $OG = json_decode($OG);
            session(['MyOrganGroups' => $OG]);
//            session('DesktopNotificaton', $Userss->DesktopNotificaton);
//            session('WallNotificaton', $Userss->WallNotificaton);
            $pic = ($Userss->pic != '') ? 'pics/user/' . $Userss->pic : 'pics/user/Users.png';
            session('pic', $pic);
            session(['pic' => $pic]);
            return session('Login');
        } else {
            session(['Login' => 'FALSE']);
            session(['uid' => 0]);
            return false;
        }
    }

    public function UserSave($uid, $sesid, $editid, $user_name, $user_family, $user_summary, $comment, $user_gender, $user_byear, $user_mobile, $tel_number, $tel_code, $fax_number, $fax_code, $user_website, $user_mail, $user_Uname, $user_pass, $secgroup, $file) {
        if ($editid == '0') {
            $LoginType = '1';
            if ($LoginType == '1') {
                $user_add = array();
                $news_date = gmdate("Y-m-d H:i:s", time() + 12600);
                if ($user_Uname == "" || !$this->check_email($user_mail)) {
                    if ($user_Uname == "")
                        $message = trans('labels.error_user_name');
                    if ($user_Uname == "")
                        $message = trans('labels.error_user_name');
                    if (!$this->check_email($user_mail))
                        $message = trans('labels.error_user_mail');
                    $error = true;
                }
                elseif (!($this->checkUniqueUser("email", $user_mail) == TRUE) || (trim($user_Uname) != "" && !($this->checkUniqueUser("name", $user_Uname) == TRUE)) || $user_pass == "") {

                    if (!($this->checkUniqueUser("email", $user_mail) == TRUE))
                        $message = trans('labels.error_email_repeat');
                    if (!($this->checkUniqueUser("name", $user_Uname) == TRUE))
                        $message = trans('labels.error_uname_repeat');
                    if ($user_pass == "")
                        $message = trans('labels.error_user_pass');
                    $error = true;
                }
                else {
                  $password = Hash::make($user_pass);
                    $secgroup = $secgroup;
                    $tm = date("Y-m-d h:i:sa");
                    $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
                    $uid = DB::table('user')->insertGetId(array('Uname' => $user_Uname, 'Email' => $user_mail, 'Name' => $user_name, 'Family' => $user_family, 'Reg_date' => $reg_date, 'Password' => $password,
                        'SecGroups' => $secgroup, 'Active' => '1'));
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
                    DB::table('user_profile')->insert(array('uid' => $uid, 'Mobile' => $user_mobile, 'Comment' => $comment, 'Tel_number' => $tel_number, 'Tel_code' => $tel_code, 'Fax_code' => $fax_code, 'Fax_number' => $fax_number, 'Website' => $user_website));
                    $message = trans('labels.error_user_ok');
                    $error = false;
                }
            }
        } 
        else {
            if ($user_pass != '') {
                $ss = DB::table('user')->where('id', $editid)->select('user_id')->first();
                // $password = $this->generateHash($user_pass);
                $password = Hash::make($user_pass);
                DB::table('user')->where('id', $editid)->update(array('password' => $password));
            }
            if ($file != '')
                DB::table('user')->where('id', $editid)->update(array('Name' => $user_name, 'Family' => $user_family, 'Summary' => $user_summary, 'Gender' => $user_gender, 'Pic' => $file, 'SecGroups' => $secgroup));
            else
                DB::table('user')->where('id', $editid)->update(array('Name' => $user_name, 'Family' => $user_family, 'Summary' => $user_summary, 'Gender' => $user_gender, 'SecGroups' => $secgroup));

            DB::table('user_profile')->where('uid', $editid)->update(array('Mobile' => $user_mobile, 'Comment' => $comment, 'Tel_number' => $tel_number, 'Tel_code' => $tel_code, 'Fax_code' => $fax_code, 'Fax_number' => $fax_number, 'Website' => $user_website));
            $error = false;
            $message = 'انجام شد';
        }

        $Ret['err'] = $error;
        $Ret['mes'] = $message;
        return $message;
    }

    public static function UserListDelete($id) {
        //  DB::table('user')->where('id', '=', $id)->update(array('Active' => 0));
        $s = DB::table('user')->where('id', '=', $id)->select('user_id')->first();
        DB::table('user')->where('id', '=', $id)->delete();
        DB::table('users')->where('id', '=', $s->user_id)->delete();
        return Response::json(array(
                    'error' => false,
                    'data' => 'حذف شد'), 200
                )->setCallback(Input::get('callback'));
    }

    public static function UserSecurityDelete($id) {
        $Users = DB::table('sec_groups')->where('id', $id)->first();
        if ($Users && $Users->defualt == '1') {
            return Response::json(array(
                        'error' => true,
                        'data' => 'این سطح پیش فرض است نمی توانید آن را حذف کنید'), 200
                    )->setCallback(Input::get('callback'));
        } else {
            $Users = DB::table('sec_groups')->where('defualt', '=', '1')->first();
            $secid = $Users->id;
            DB::table('user')->where('SecGroups', '=', $id)->update(array('SecGroups' => $secid));
            DB::table('sec_groups')->where('id', '=', $id)->delete();
            return Response::json(array(
                        'error' => false,
                        'data' => 'حذف شد'), 200
                    )->setCallback(Input::get('callback'));
        }
    }

    private function getSalt($hashedPassword) {
        $originalSalt = substr($hashedPassword, 0, 9);
        return $originalSalt;
    }

    public function generateHash($password, $salt = null) {
        if ($salt === null) {
            $salt = substr(md5(uniqid(rand(), true)), 0, 9);
        } else {
            $ssalt = substr($salt, 0, 9);
        }
        return $salt . sha1($salt . $password);
    }

    public function LocalLogout($uname, $password, $device_type) {
        if (Auth::attempt(array('name' => $uname, 'password' => $password))) {
            $Users = User:: select('id', 'name', 'firstname', 'lastname', 'state', 'email', 'last_session_id')->where('name', '=', $uname)->first();
            $session_id = Session::getId();
            Session::put('uid', $Users->id);
            Session::put('Uname', $Users->name);
            Session::put('email', $Users->email);
            Session::put('fname', $Users->firstname);
            Session::put('lname', $Users->lastname);
            Session::put('state', $Users->state);
            $dt = new DateTime();
            $last_ses_id = $Users->last_session_id;
            $update = User::where('id', '=', $Users->id)->first();
            $update->last_login = $dt->format('Y-m-d H:i:s');
            $update->device_type = $device_type;
            $update->last_session_id = $session_id;
            $update->save();
            // DB::table('sso_session')->where('uid', $Users->id)->where('devtype', $device_type)->delete();
            Sessions::where('id', '=', $last_ses_id)->delete();


//            foreach (Session::get('name') as $item) {
//                echo $item . 's';
//            }
            if (Session::get('LAST_ACTIVITY') && (time() - Session::get('LAST_ACTIVITY') > 180 )) {
                Session:flush();
            }
//            Session::put('LAST_ACTIVITY', time());

            $ref = $Users;
            $ref['SessionID'] = $session_id;
            return Response::json(array(
                        'error' => false,
                        'user' => $ref), 200
                    )->setCallback(Input::get('callback'));
        } else {
            return Response::json(array(
                        'error' => true,
                        'user' => false), 200
                    )->setCallback(Input::get('callback'));
        }
    }

    public function CheckLogin_uid($uid, $session_id, $islocal) {
        if ($islocal == 'local') {
            if (session('Login') == 'TRUE' && session('uid') == $uid)
                $log = TRUE;
            else
                $log = FALSE;
        }
        else {
            $count = DB::table('users as uss')->join('user as u', 'uss.id', '=', 'u.user_id')
                            ->where('u.id', $uid)->where('u.id', $uid)->select('id')->count();
            if ($count == 0) {
                $log = FALSE;
            } else {
                $log = $this->IsUserLogin($session_id, $uid);
            }
        }
        return $log;
    }

    public function CheckLogin($user_id, $session_id) {
        $resss = $this->UserExists('id', $user_id);
        $log = FALSE;
        if ($this->UserExists('id', $user_id) == TRUE) {
            $log = $this->IsUserLogin($session_id, $user_id);
        }
        return $log;
    }

    private function UserExists($field, $user_id) {
        $count = User::select('id')->where($field, '=', $user_id)->count();
        if ($count == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    private function IsUserLogin($session_id, $user_id) {
        //$ses = Sessions:: select('id', 'LAST_ACTIVITY')->where('id', '=', $session_id)->first();
        //$count = Sessions::where('id', '=', $session_id)->count();
        //$ses = DB::table('sso_session')->where('uid', $user_id)->where('sesid', '=', $session_id)->first();
        $count = DB::table('sso_session')->where('uid', $user_id)->where('sesid', '=', $session_id)->count();
        if ($count == 0) {
            return FALSE;
        } else {
//            if ($ses->LAST_ACTIVITY && (time() - $ses->LAST_ACTIVITY > 1800 )) {
//                $ses->delete();
//                return FALSE;
//            } else {
            return TRUE;
            //}
        }
    }

    public function ForgetPass($user_email) {
        $setting = settings::select('login')->first();
        $LoginType = $setting->login;
        $error = false;
        if ($LoginType == '1') {
            if ($user_email == "" || !$this->check_email($user_email)) {
                $message = trans('labels.error_user_mail');
                $error = true;
            } elseif (!($this->checkUniqueUser("email", $user_email) == TRUE)) {
                $Users = User:: select('id', 'email')->where('email', '=', $user_email)->first();
                $newPas_s = $this->randomPassword();
                //$newPas = Hash::make($newPas_s);
                $newPas = $this->generateHash($newPas_s);
                $Users->password = $newPas;
                $Users->salt = '1';
                $Users->save();
                Mail::send('emails.forgetpas', array('msg' => $newPas_s, 'Users' => $Users), function ($m) use ($Users) {
                    $m->to($Users->email, $Users->email)->subject('تغییر کلمه عبور');
                });
                $message = trans('labels.ResetPasOK');
                ;
            } else {
                $message = trans('labels.error_email_fail');
                $error = true;
            }
        }

        return Response::json(array(
                    'error' => $error,
                    'user' => $message), 200
        );
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

    public function Register($user_name, $user_FirstName, $user_family, $user_mail, $user_pass) {
        $setting = settings::select('login')->first();
        $LoginType = $setting->login;
        $error = false;
        if ($LoginType == '1') {
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
            elseif (!($this->checkUniqueUser("email", $user_mail) == TRUE) || (trim($user_name) != "" && !($this->checkUniqueUser("name", $user_name) == TRUE)) || $user_pass == "") {
                if (!($this->checkUniqueUser("email", $user_mail) == TRUE))
                    $message = trans('labels.error_email_repeat');
                if (!($this->checkUniqueUser("name", $user_name) == TRUE))
                    $message = trans('labels.error_uname_repeat');
                if ($user_pass == "")
                    $message = trans('labels.error_user_pass');
                $error = true;
            }
            else {
                $password = $this->generateHash($user_pass);
                $secgroup = 0;
                $secgroups = DB::table('sec_groups')->where('defualt', '1')->select('id')->first();
                if ($secgroups)
                    $secgroup = $secgroups->id;
                $tm = date("Y-m-d h:i:sa");
                User::insert(array('name' => $user_name, 'email' => $user_mail, 'firstname' => $user_FirstName, 'lastname' => $user_family, 'created_at' => $tm, 'password' => $password, 'updated_at' => $tm));
                $work = DB::table('users')->select(DB::raw('max(id) as work'))->first();
                $id = $work->work;
                $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
                $uid = DB::table('user')->insertGetId(array('Uname' => $user_name, 'Email' => $user_mail, 'Name' => $user_FirstName, 'Family' => $user_family, 'Reg_date' => $reg_date, 'Password' => $password,
                    'SecGroups' => $secgroup, 'Active' => '1', 'user_id' => $id));

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

                $message = trans('labels.error_user_ok');

                $error = false;
            }
        }
        return Response::json(array(
                    'error' => $error,
                    'data' => $message), 200
        );
    }

    private function randomPassword() {
        $alphabet = "123456789";
        //         $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

}