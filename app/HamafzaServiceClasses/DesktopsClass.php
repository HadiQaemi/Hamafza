<?php

namespace App\HamafzaServiceClasses;

use Illuminate\Support\Facades\DB;

class DesktopsClass
{

    public function Measure($uid, $MeasureType, $sel)
    {
        $MC = new MeasureClass();
        $mc = $MC->Select($MeasureType, $uid, $sel);
        return $mc;
    }

    function Gethighlights($uid, $pid, $sid)
    {
        if ($sid != '' && intval($sid) > 0)
        {
            $Groups = DB::table('pages as p')
                ->Leftjoin('subjects as s', 'p.sid', '=', 's.id')
                ->Leftjoin('highlights as a', 'p.id', '=', 'a.pid')
                ->Leftjoin('user as u', 'a.uid', '=', 'u.id')
                ->where("a.uid", $uid)
                ->where("s.id", $sid)
                ->whereRaw("a.id IS NOT NULL")
                ->select('a.id', 'a.pid', 'a.quote', 'a.reg_date', 'p.type', 's.title', 's.kind', 'u.Name', 'u.Family')
                ->orderBy('a.reg_date', 'DESC')
                ->get();
        }
        else
        {
            $Groups = DB::table('pages as p')
                ->Leftjoin('subjects as s', 'p.sid', '=', 's.id')
                ->Leftjoin('highlights as a', 'p.id', '=', 'a.pid')
                ->Leftjoin('user as u', 'a.uid', '=', 'u.id')
                ->where("a.uid", $uid)
                ->whereRaw("a.id IS NOT NULL")
                ->select('a.id', 'a.pid', 'a.quote', 'a.reg_date', 'p.type', 's.title', 's.kind', 'u.Name', 'u.Family')
                ->orderBy('a.reg_date', 'DESC')
                ->get();
        }
        foreach ($Groups as $value)
        {
            $value->reg_date = \Morilog\Jalali\jDate::forge($value->reg_date)->format('%Y/%m/%d');
        }
        $err = false;
        $Ret = json_encode($Groups);
        $Ret = json_decode($Ret);

        return $Ret;
    }

    function Getannounces($uid, $pid, $sid)
    {
        if ($sid != '' && intval($sid) > 0)
        {
            $Groups = DB::table('pages as p')->Leftjoin('subjects as s', 'p.sid', '=', 's.id')
                ->Leftjoin('announces as a', 'p.id', '=', 'a.pid')
                ->Leftjoin('user as u', 'a.uid', '=', 'u.id')
                ->where("a.uid", $uid)
                ->where("s.id", $sid)
                ->select('a.id', 'a.title as atitle', 'a.pid', 'a.comment', 'a.quote', 'a.reg_date', 'p.type', 's.title', 's.kind', 'u.Name', 'u.Family')
                ->orderBy('a.reg_date', 'DESC')->get();
        }
        else
        {
            $Groups = DB::table('announces as a')
                ->Leftjoin('pages as p', 'p.id', '=', 'a.pid')
                ->Leftjoin('subjects as s', 'p.sid', '=', 's.id')
                ->Leftjoin('user as u', 'a.uid', '=', 'u.id')
                ->where("a.uid", $uid)
                ->select('a.id', 'a.title as atitle', 'a.pid', 'a.comment', 'a.quote', 'a.reg_date', 'p.type', 's.title', 's.kind', 'u.Name', 'u.Family')
                ->orderBy('a.reg_date', 'DESC')
                ->get();
        }

        foreach ($Groups as $value)
        {
            $value->reg_date = \Morilog\Jalali\jDate::forge($value->reg_date)->format('%Y/%m/%d');
            $value->keywords = DB::table('announce_keys as a')
                ->Leftjoin('keywords as k', 'a.key_id', '=', 'k.id')
                ->where("a.ann_id", $value->id)
                ->select('k.id', 'k.title')->get();
        }
        $err = false;
        $Ret = $Groups;

        return $Ret;
    }

    /*function RelationMemus($uid, $sesid)
    {
        $menus = array();

        $menu['id'] = '#ashkhas';
        $menu['text'] = 'اشخاص';
        $menu['href'] = '#';
        $menu['parent'] = '#';
        array_push($menus, $menu);


        $menu['id'] = 'followed';
        $menu['text'] = 'دنبال شده‌ها';
        $menu['href'] = 'followed';
        $menu['parent'] = '#ashkhas';
        array_push($menus, $menu);

        $menu['id'] = 'Pfollowed2';
        $menu['text'] = 'افراد';
        $menu['href'] = 'Pfollowed2';
        $menu['parent'] = 'followed';
        array_push($menus, $menu);

        $menu['id'] = 'Gfollowed';
        $menu['text'] = 'گروه‌ها';
        $menu['href'] = 'Gfollowed';
        $menu['parent'] = 'followed';
        array_push($menus, $menu);

        $menu['id'] = 'Ofollowed';
        $menu['text'] = 'کانال‌ها';
        $menu['href'] = 'Ofollowed';
        $menu['parent'] = 'followed';
        array_push($menus, $menu);

//
//
//
        $menu['id'] = '#meafrad';
        $menu['text'] = 'افراد';
        $menu['href'] = '#meafrad';
        $menu['parent'] = '#ashkhas';
        array_push($menus, $menu);


        $menu['id'] = 'Pfollowed';
        $menu['text'] = 'دنبال شده‌ها';
        $menu['href'] = 'Pfollowed';
        $menu['parent'] = '#meafrad';
        array_push($menus, $menu);

        $menu['id'] = 'mefollow';
        $menu['text'] = 'دنبال کنندگان';
        $menu['href'] = 'mefollow';
        $menu['parent'] = '#meafrad';
        array_push($menus, $menu);

        $menu['id'] = 'Circles';
        $menu['text'] = 'اعضای حلقه‌ها';
        $menu['href'] = 'Circles';
        $menu['parent'] = '#meafrad';
        array_push($menus, $menu);
        $UC = new UserClass();
        $C = $UC->userCircle($uid, $sesid);
        foreach ($C as $value)
        {
            $menu['id'] = 'Circle/' . $value->id;
            $menu['text'] = $value->name;
            $menu['href'] = 'Circle/' . $value->id;
            $menu['parent'] = 'Circles';
            array_push($menus, $menu);
        }


        $menu['id'] = 'InCircle';
        $menu['text'] = ' عضو هستم در حلقه‌ها';
        $menu['href'] = 'InCircle';
        $menu['parent'] = '#meafrad';
        array_push($menus, $menu);

        $menu['id'] = 'Groups';
        $menu['text'] = 'گروه‌ها ';
        $menu['href'] = 'Groups';
        $menu['parent'] = '#ashkhas';
        array_push($menus, $menu);

        $menu['id'] = 'Gfollowed2';
        $menu['text'] = 'دنبال شده‌ها';
        $menu['href'] = 'Gfollowed2';
        $menu['parent'] = 'Groups';
        array_push($menus, $menu);


        $menu['id'] = 'Group_MyAdmin';
        $menu['text'] = 'مدیر هستم';
        $menu['href'] = 'Group_MyAdmin';
        $menu['parent'] = 'Groups';
        array_push($menus, $menu);
        $UC = new UserClass();
        $C = $UC->user_group_admin2($uid);
        foreach ($C as $value)
        {
            $menu['id'] = 'Group/' . $value->id;
            $menu['text'] = $value->name;
            $menu['href'] = 'Group/' . $value->id;
            $menu['parent'] = 'Group_MyAdmin';
            array_push($menus, $menu);
        }

        $menu['id'] = 'Group_IN';
        $menu['text'] = 'عضو هستم';
        $menu['href'] = 'Group_MyAdmin';
        $menu['parent'] = 'Groups';
        array_push($menus, $menu);
        $UC = new UserClass();
        $C = $UC->MyGroups($uid, $sesid);
        foreach ($C as $value)
        {
            $menu['id'] = 'InGroup/' . $value->id;
            $menu['text'] = $value->name;
            $menu['href'] = 'InGroup/' . $value->id;
            $menu['parent'] = 'Group_IN';
            array_push($menus, $menu);
        }

        $menu['id'] = 'Organs';
        $menu['text'] = 'کانال‌ها ';
        $menu['href'] = 'Organs';
        $menu['parent'] = '#ashkhas';
        array_push($menus, $menu);

        $menu['id'] = 'Ofollowed2';
        $menu['text'] = 'دنبال شده‌ها';
        $menu['href'] = 'Ofollowed2';
        $menu['parent'] = 'Organs';
        array_push($menus, $menu);


        $menu['id'] = 'Organ/MyAdmin';
        $menu['text'] = 'مدیر هستم';
        $menu['href'] = 'Organ/MyAdmin';
        $menu['parent'] = 'Organs';
        array_push($menus, $menu);
        $UC = new UserClass();
        $C = $UC->user_organ_admin2($uid);
        foreach ($C as $value)
        {
            $menu['id'] = 'Group/' . $value->id;
            $menu['text'] = $value->name;
            $menu['href'] = 'Group/' . $value->id;
            $menu['parent'] = 'Organ/MyAdmin';
            array_push($menus, $menu);
        }

        $menu['id'] = 'Organ/IN';
        $menu['text'] = 'عضو هستم';
        $menu['href'] = 'Organ/IN';
        $menu['parent'] = 'Organs';
        array_push($menus, $menu);
        $UC = new UserClass();
        $C = $UC->MyOrgans($uid, $sesid);
        foreach ($C as $value)
        {
            $menu['id'] = 'Group/' . $value->id;
            $menu['text'] = $value->name;
            $menu['href'] = 'Group/' . $value->id;
            $menu['parent'] = 'Organ/IN';
            array_push($menus, $menu);
        }

//        
//        
//        
//        $menu['id'] = 'Tels';
//        $menu['text'] = 'داری شماره تلفن';
//        $menu['href'] = 'Tels';
//        $menu['parent'] = '#';
//        array_push($menus, $menu);
//        
//        $menu['id'] = 'Emails';
//        $menu['text'] = 'دارای رایانامه';
//        $menu['href'] = 'Emails';
//        $menu['parent'] = '#';
//         $menu['id'] = 'AllContacts';
//        $menu['text'] = 'همه';
//        $menu['href'] = 'AllContacts';
//        $menu['parent'] = '#';
        //array_push($menus, $menu);

        return $menus;
    }

    public function DesktopMenu($uid, $sesid)
    {
        $menus = array();
        $menu['id'] = '#task';
        $menu['text'] = 'تسک ها';
        $menu['href'] = '#';
        $menu['parent'] = '#';
        array_push($menus, $menu);
        $menu['id'] = 'Task';
        $menu['text'] = 'مشاهده ';
        $menu['href'] = 'Task';
        $menu['parent'] = '#task';
        array_push($menus, $menu);
        $menu['id'] = '#faal';
        $menu['text'] = 'فعالیت‌ها ';
        $menu['href'] = '#';
        $menu['parent'] = '#';
        array_push($menus, $menu);
        $menu['id'] = '#mes';
        $menu['text'] = 'وظایف ';
        $menu['href'] = '#';
        $menu['parent'] = '#faal';
        array_push($menus, $menu);
        $menu['id'] = 'user_measures_ME';
        $menu['text'] = 'وظایف من';
        $menu['href'] = 'My_user_measures';
        $menu['parent'] = '#mes';
        array_push($menus, $menu);
        $menu['id'] = 'user_measures_BC';
        $menu['text'] = 'رونوشت‌ها به من';
        $menu['href'] = 'user_measures';
        $menu['parent'] = '#mes';
        array_push($menus, $menu);
        $menu['id'] = 'user_measures_Fme';
        $menu['text'] = 'واگذاری‌های من';
        $menu['href'] = 'user_measures';
        $menu['parent'] = '#mes';
        array_push($menus, $menu);

        $menu['id'] = 'user_measures_MeDrafts';
        $menu['text'] = 'پیش‌نویس‌ها';
        $menu['href'] = 'user_measures';
        $menu['parent'] = '#mes';
        array_push($menus, $menu);

        if (UserClass::permission('procces', $uid) == '1')
        {
            $menu['id'] = 'process_list';
            $menu['text'] = 'فرآیندها';
            $menu['href'] = 'process_list';
            $menu['parent'] = '#faal';
            array_push($menus, $menu);
        }
        $menusRet = array();
        $menus2['name'] = 'فعالیت‌ها';
        $menus2['menus'] = $menus;
        array_push($menusRet, $menus2);

        $menuss = $this->RelationMemus($uid, $sesid);
        $menus = array_merge($menus, $menuss);

        $menu['id'] = '#payam';
        $menu['text'] = 'پیام‌ها';
        $menu['href'] = '#';
        $menu['parent'] = '#';
        array_push($menus, $menu);

        $menu['id'] = 'ticket_list';
        $menu['text'] = 'مکالمه';
        $menu['href'] = 'ticket_list';
        $menu['parent'] = '#payam';
        array_push($menus, $menu);
        $menu['id'] = 'inbox';
        $menu['text'] = 'دریافتی‌ها';

        $menu['href'] = 'inbox';
        $menu['parent'] = '#payam';
        array_push($menus, $menu);

        $menu['id'] = 'outbox';
        $menu['text'] = 'ارسالی‌ها';

        $menu['href'] = 'outbox';
        $menu['parent'] = '#payam';
        array_push($menus, $menu);

        $menu['id'] = '#fileha';
        $menu['text'] = 'فایل‌ها';
        $menu['href'] = '#';
        $menu['parent'] = '#';
        array_push($menus, $menu);

        $menu['id'] = 'Files/Created_ME';
        $menu['text'] = 'صفحات';
        $menu['href'] = 'pages';
        $menu['parent'] = '#fileha';
        array_push($menus, $menu);

        if (UserClass::permission('listtag', $uid) == '1')
        {
            $menu['id'] = 'keywords';
            $menu['text'] = 'کلید واژه‌ها';
            $menu['href'] = 'keywords';
            $menu['parent'] = '#fileha';
            array_push($menus, $menu);
        }


        $menu['id'] = '#anno';
        $menu['text'] = 'یادداشت‌ها';
        $menu['href'] = 'announces';
        $menu['parent'] = '#';
        array_push($menus, $menu);
        $menu['id'] = 'announces';
        $menu['text'] = 'یادداشت‌ها';
        $menu['href'] = 'announces';
        $menu['parent'] = '#anno';
        array_push($menus, $menu);
        $menu['id'] = 'highlights';
        $menu['text'] = 'علامت‌گذاری‌ها';
        $menu['href'] = 'highlights';
        $menu['parent'] = '#anno';
        array_push($menus, $menu);

        $menu['id'] = '#formha';
        $menu['text'] = 'فرم‌ها';
        $menu['href'] = '#';
        $menu['parent'] = '#';
        array_push($menus, $menu);


        $menu['id'] = 'form_list/me';
        $menu['text'] = 'فرم‌های من';
        $menu['href'] = '#';
        $menu['parent'] = '#formha';
        array_push($menus, $menu);

        $menu['id'] = 'form_list/sent';
        $menu['text'] = 'درخواست‌های من';
        $menu['href'] = '#';
        $menu['parent'] = '#formha';
        array_push($menus, $menu);

        $menu['id'] = 'form_list/drafts';
        $menu['text'] = 'پیش‌نویس‌ها';
        $menu['href'] = '#';
        $menu['parent'] = '#formha';
        array_push($menus, $menu);
        //  if (UserClass::permission('Forms', $uid) === '1' || UserClass::permission('administrator', $uid) == '1') {
        $menu['id'] = 'form_list/all';
        $menu['text'] = 'همه';
        $menu['href'] = '#';
        $menu['parent'] = '#formha';
        array_push($menus, $menu);
        // }


        if (UserClass::permission('Hesab', $uid) == '1' || UserClass::permission('administrator', $uid) == '1')
        {
            $menu['id'] = 'notifications';
            $menu['text'] = 'رویدادها';
            $menu['href'] = 'notifications';
            $menu['parent'] = '#hesabkar';
            array_push($menus, $menu);
            $menu['id'] = '#hesabkar';
            $menu['text'] = 'حساب کاربری';

            $menu['href'] = 'notifications';
            $menu['parent'] = '#';
            array_push($menus, $menu);
        }

        if (UserClass::permission('manage_users', $uid) == '1')
        {

            $menu['id'] = '#karbaran';
            $menu['text'] = 'کاربران';
            $menu['href'] = '#';
            $menu['parent'] = '#';
            array_push($menus, $menu);

            $menu['id'] = 'user_security';
            $menu['text'] = 'سطوح دسترسی';
            $menu['href'] = 'user_security';
            $menu['parent'] = '#karbaran';
            array_push($menus, $menu);

            $menu['id'] = 'user_list';
            $menu['text'] = 'افراد';

            $menu['href'] = 'user_list';
            $menu['parent'] = '#karbaran';
            array_push($menus, $menu);
            $menu['id'] = 'showgroups';
            $menu['text'] = 'گروه‌ها';

            $menu['href'] = 'showgroups';
            $menu['parent'] = '#karbaran';
            array_push($menus, $menu);
            $menu['id'] = 'showorgans';
            $menu['text'] = 'کانال‌ها';
            $menu['href'] = 'showorgans';
            $menu['parent'] = '#karbaran';
            array_push($menus, $menu);
        }

        $peik = false;
        if (UserClass::permission('subjects', $uid) == '1')
        {
            $peik = true;
            $menu['id'] = 'subjects';
            $menu['text'] = ' موضوعات';
            $menu['href'] = '#';
            $menu['parent'] = '#peikareh';
            array_push($menus, $menu);
        }


        if (UserClass::permission('subject_field', $uid) == '1')
        {
            $peik = true;

            $menu['id'] = 'subject_field';
            $menu['text'] = 'فیلدها';
            $menu['href'] = '#';
            $menu['parent'] = '#peikareh';
            array_push($menus, $menu);
        }
        if (UserClass::permission('subst', $uid) == '1')
        {
            $peik = true;
            $menu['id'] = 'subst';
            $menu['text'] = 'ویراستاری';
            $menu['href'] = '#';
            $menu['parent'] = '#peikareh';
            array_push($menus, $menu);
        }

        if (UserClass::permission('departments', $uid) == '1')
        {
            $peik = true;
            $menu['id'] = 'departments';
            $menu['text'] = 'نوار ناوبری';
            $menu['href'] = '#';
            $menu['parent'] = '#peikareh';
            array_push($menus, $menu);
        }
        if (UserClass::permission('alerts', $uid) == '1')
        {
            $peik = true;

            $menu['id'] = 'alerts';
            $menu['text'] = 'اطلاعیه‌ها';
            $menu['href'] = '#';
            $menu['parent'] = '#peikareh';
            array_push($menus, $menu);
        }
        if (UserClass::permission('EditHomePage', $uid) == '1')
        {
            $peik = true;
            $menu['id'] = 'homepage';
            $menu['text'] = 'صفحه اول';
            $menu['href'] = '#';
            $menu['parent'] = '#peikareh';
            array_push($menus, $menu);
        }
        if (UserClass::permission('helps', $uid) == '1')
        {
            $peik = true;
            $menu['id'] = 'helps';
            $menu['text'] = 'راهنمای اینجا';
            $menu['href'] = '#';
            $menu['parent'] = '#peikareh';
            array_push($menus, $menu);
        }


        if ($peik)
        {
            $menu['id'] = '#peikareh';
            $menu['text'] = 'پیکره‌بندی';
            $menu['href'] = '#';
            $menu['parent'] = '#';
            array_push($menus, $menu);
        }
        return $menus;
    }*/

    /*public function user_tools($sid, $pid = 0, $uid, $subtype)
    {
        $help = '';
        $user = UserClass::CheckLogin($uid, $sid);
        if ($user == TRUE)
        {
            $user = 'true';
        }
        else
        {
            $user = 'false';
        }
        $help = PublicClass::HelpManage(0, 'Desktop', $subtype);
//            else
//        $help = PublicClass::HelpManage(0, 'desktop', 'user_page');

        if ($user)
        {

            $pageDet = DB::table('subject_member')
                ->where('uid', $uid)->where('sid', $sid)->select('id', 'relation', 'follow', 'like')->first();
            $res = array();
            if ($pageDet)
            {
                $res['like'] = $pageDet->like;
                $res['follow'] = $pageDet->follow;
                $res['relation'] = $pageDet->relation;
            }
            else
            {
                $res['like'] = '0';
                $res['follow'] = 0;
                $res['relation'] = 0;
            }
        }
        else
        {
            $res['like'] = '0';
            $res['follow'] = 0;
            $res['relation'] = 0;
        }


        $lang['like'] = trans('labels.Like');
        $lang['disLike'] = trans('labels.disLike');

        $lang['follow'] = trans('labels.follow');
        $lang['unfollow'] = trans('labels.unfollow');
        $res['comment'] = 'comment';
        $lang['comment'] = trans('labels.comment');
        $lang['uncomment'] = trans('labels.comment');


        $lang['relation'] = '0';

        $Taamol = array();
        $Abzar = array();
        $i = 1;
        $menutools = DB::table('tools_group')->orderBy('orders')->get();
        foreach ($menutools as $value)
        {
            //      if (DB::table('tools')->where('desktop', '1')->where('desktoptype', $subtype)->where('menuid', $value->id)->select('id', 'farsi', 'icon', 'url', 'modal')->orderBy('orders')->count() > 0) {

            if (DB::table('tools')->where('desktop', '1')->where('menuid', $value->id)->select('id', 'farsi', 'icon', 'url', 'modal')->orderBy('orders')->count() > 0)
            {
                $tools = DB::table('tools')->where('desktop', '1')->where('menuid', $value->id)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->get();
                $Taamol['label'] = $value->name;
                $Taamol['tools'] = $tools;
                $Abzar[$i] = $Taamol;
                $i++;
            }
            // array_push($Taamol, $Abzar);
        }
        $Ret['Help'] = $help;

        $Ret['val'] = $res;
        $Ret['label'] = $lang;
        $Ret['othermenus'] = $Abzar;
//-----------------------
        return Response::json(array(
            'error' => false,
            'data' => $Ret), 200
        )->setCallback(Input::get('callback'));
    }*/

}
