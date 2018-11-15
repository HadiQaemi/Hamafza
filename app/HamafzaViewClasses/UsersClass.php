<?php

namespace App\HamafzaViewClasses;

use App\HamafzaGrids\UsersGrids;
use App\HamafzaGrids\SubjectGrids;
use Illuminate\Support\Facades\DB;
use App\HamafzaServiceClasses\UserClass;
use App\HamafzaServiceClasses\SubjectsClass;
use App\HamafzaServiceClasses\DesktopsClass;
use App\HamafzaServiceClasses\ConfigurationClass;
use Auth;

class UsersClass
{

    public static function Alerts()
    {
        $uid = Auth::id();
        $mes = DB::table('emails')
            ->where('uid', $uid)
            ->Orderby("id", 'desc')
            ->take(50)
            ->get();
        $i = 1;
        foreach ($mes as $item)
        {
            $item->sortid = $i;
            $item->sendate = \Morilog\Jalali\jDate::forge($item->sendate)->format('%Y/%m/%d');
            $i++;
        }
        if (is_array($mes) && count($mes) > 0)
        {
            $s = UsersGrids::Alerts($mes);
        }
        else
        {
            $s = 'موردی یافت نشد';
        }
        return
            [
                'sid' => $uid,
                'current_tab' => 'desktop',
                'content' => $s,
                'PageType' => 'desktop'
            ];
    }

    public static function GetMycircle($uid)
    {
        $mes = DB::table('user_circle')->where('uid', $uid)->select('id', 'name', 'orders', 'nums')->take(50)->get();
        foreach ($mes as $item)
        {
            $items = DB::table('user_friend_circle as uf')->join('user_friend as f', 'uf.fid', '=', 'f.id')
                ->leftjoin('user as u', 'u.id', '=', 'f.fid')->where('uf.cid', $item->id)->select('f.id', 'u.Name', 'u.avatar', 'u.Family', 'u.id as uid')->take(50)->get();
            $item->members = $items;
        }
        return $mes;
    }

    public static function DrawCircle($uid, $cuid, $Circles)
    {
        $res = '';
        $incircle = false;
        if (is_array($Circles) && count($Circles) > 0)
        {
            foreach ($Circles as $item)
            {
                $title = 'افزودن به دوستان <span class="flaticon-plus"></span>';
                $class = 'grey';
                foreach ($item->members as $items)
                {
                    if ($items->uid == $uid)
                    {
                        $incircle = true;
                    }
                }
                if ($incircle)
                {
                    $title = 'عضو دوستان <span class="flaticon-tick"></span>';
                    $class = 'green';
                }
            }
        }
        else
        {
            $title = 'افزودن به دوستان <span class="flaticon-plus"></span>';
            $class = 'grey';
        }
        if ($cuid != '0' && $uid != $cuid)
        {
            $res = '<div class="person-circle ' . $class . '">';
            $res .= ' <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" id="avatar" href="#"><span class="caret"></span>';
            $res .= $title;
            $res .= ' </a><div class="dropdown-menu FontSmall CircleULli"> <UL>';
            foreach ($Circles as $value)
            {
                $val = '0';
                $check = '';
                $res .= '<div class="checkbox ';
                foreach ($value->members as $items)
                {
                    if ($items->uid == $uid)
                    {
                        $res .= 'incircle ';
                        $val = '1';
                        $check = 'checked';
                    }
                }

                $res .= '"> <label><input type="checkbox" ' . $check . ' class="CirclePas" uid="' . $uid . '" value="' . $value->id . '" incircle="' . $val . '">' . $value->name . '</label></div>';
            }
            $res .= '</UL></div></div>  ';
        }
        return $res;
    }

    public static function LoadPost($id)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = Auth::id();
            $SP = \App\HamafzaServiceClasses\PostsClass::GetPost($uid, $id, 0);
            return view('modals.postshare', array('content' => $SP, 'post_id' => $id));
        }
    }

    public function LoginAfetrReg($usename, $password)
    {
        $SP = new service();
        $menu = $SP->ServicePost('Login', "user=$usename&password=$password&device=1");
        $json_a = json_decode($menu, true);
        $user = $json_a['data'];
        Session::flush();
        if ($user['id'] != '' && $user['id'] != '-1')
        {
            Session::put('uid', $user['uid']);
            Session::put('Uname', $user['Uname']);
            Session::put('Summary', $user['Summary']);
            Session::put('Name', $user['Name']);
            Session::put('Family', $user['Family']);
            Session::put('Login', 'TRUE');
            Session::put('SessionID', $user['SessionID']);
            Session::put('last_session_id', $user['last_session_id']);
            Session::put('email', $user['email']);
            Session::put('state', $user['state']);
            Session::put('name', $user['name']);
            Session::put('DesktopNotificaton', $user['DesktopNotificaton']);
            Session::put('WallNotificaton', $user['WallNotificaton']);
            $Message = $user['Message'];
            $pic = 'pics/user/Users.png';
            if ($user['pic'] != '')
            {
                if (file_exists('pics/user/' . $user['uid'] . '-' . $user['pic']))
                {
                    $pic = 'pics/user/' . $user['uid'] . '-' . $user['pic'];
                }
                else
                {
                    if (file_exists('pics/user/' . $user['pic']))
                    {
                        $pic = 'pics/user/' . $user['pic'];
                    }
                }
            }
            Session::put('pic', $pic);
            Session::put('MyOrganGroups', $user['MyOrganGroups']);
            $PC = new PublicClass();

            if (is_array($user['Bookmarks']))
            {
                $newtree = $PC->CretaeTree1L($user['Bookmarks'], 'link', 'parent_id', 'Title');
                $newtree = $PC->Json(0, $newtree);
            }
            else
            {
                $newtree = '';
            }
            Session::put('Bookmarks', $newtree);
        }
        Session::put('NewUser', 'NewUser');
        return Redirect::to(Request::root() . '/' . $usename);
    }

    public static function GetAccessUsers($id)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = session('uid');
            if (UserClass::permission('manager_edit', $uid) == '1')
            {
                $Ret = DB::table('user as u')->leftJoin('users as ga', 'u.user_id', '=', 'ga.id')->where('u.SecGroups', $id)->select('u.id', 'u.Name', 'u.Family', 'ga.name', 'u.Reg_date')->get();
                $i = 1;
                foreach ($Ret as $value)
                {
                    $value->sortid = $i;
                    $value->reg_date = \Morilog\Jalali\jDate::forge($value->Reg_date)->format('%Y/%m/%d');
                    $value->FullNaME = $value->Name . ' ' . $value->Family;
                    $i++;
                }
                $err = false;
                $c = UsersGrids::UsersAc($Ret);
            }
            else
            {
                $err = true;
                $c = Lang::get('labels.AdminFail');
            }
            return view('modals.public', array('content' => $c));
        }
    }

    public static function highlights()
    {
        $uid = Auth::id();
        $s = new DesktopsClass();
        $s = $s->Gethighlights($uid, 0, 0);
        return [
            'PageType' => 'desktop',
            'type' => 'highlight',
            'sid' => $uid,
            'current_tab' => 'desktop',
            'content' => $s
        ];
    }

    public static function showalerts($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        if ($sublink == '')
        {
            return UsersClass::showalertsList($name, $uid, $sesid, $Selected, $Tree, $sublink);
        }
        else
        {
            if ($sublink == 'edit')
            {
                return UsersClass::EditAlert($name, $uid, $sesid, $Selected, $Tree, $sublink);
            }
            else
            {
                if ($sublink == 'add')
                {
                    return UsersClass::AddAlert($name, $uid, $sesid, $Selected, $Tree, $sublink);
                }
            }
        }
    }

    public static function showgroups($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        if ($sublink == '')
        {
            return UsersClass::showgroupsList($name, $uid, $sesid, $Selected, $Tree, $sublink);
        }
        if ($sublink == 'edit')
        {
            return UsersClass::GetUserDetail($name, $uid, $sesid, $Selected, $Tree, $sublink);
        }
    }

    public static function showorgans($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        if ($sublink == '')
        {
            return UsersClass::showorganList($name, $uid, $sesid, $Selected, $Tree, $sublink);
        }
        if ($sublink == 'edit')
        {
            return UsersClass::GetUserDetail($name, $uid, $sesid, $Selected, $Tree, $sublink);
        }
    }

    public static function GetUserSecurity($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        if ($uid == 0 || UsersClass::permission('manage_users', $uid) != '1')
        {
            return Redirect::back()->with('message', 'شما به این قسمت دسترسی ندارید')->with('mestype', 'error');
        }
        if ($sublink == '')
        {
            return UsersClass::GetUserSecurityList($name, $uid, $sesid, $Selected, $Tree, $sublink);
        }
        elseif ($sublink == 'edit')
        {
            return UsersClass::GetUserSecDetail($name, $uid, $sesid, $Selected, $Tree, $sublink);
        }
        elseif ($sublink == 'add')
        {
            return UsersClass::UserSecurityAdd($name, $uid, $sesid, $Selected, $Tree, $sublink);
        }
    }

//    public static function AdminUserList($name, $sublink, $sr = '') {
//        $uid=Auth::id();
//        if ($uid == 0 || UsersClass::permission('manage_users', $uid) != '1')
//            return Redirect::back()->with('message', 'شما به این قسمت دسترسی ندارید')->with('mestype', 'error');
//
//        if ($sublink == 'edit')
//            return UsersClass::GetUserDetail($name, $uid,$sublink);
//        if ($sublink == 'add')
//
//    }

    public static function GetUserSecDetail($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            if (UserClass::permission('manage_users', $uid) == '1')
            {
                $ret = DesktopClass::USER($name);
                $uidsx = (isset($_GET['id']) && $_GET['id'] != '') ? intval($_GET['id']) : 0;
                $secid = $uidsx;
                $SP = new ConfigurationClass();
                $s = $SP->GetUserSecurityDetail($uid, $uidsx);
                $Access = $s['Access'];
                $ACL = $s['ACL'];
                $SecGroup = $s['SecGroups'];
                $GroupAccess = $s['GroupAccess'];
                $sesid = '';
                $uid = (session('uid') != '') ? session('uid') : 0;
                $Portals = PageClass::GetProtals($uid, $sesid);
                $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
                $MyOrganGroups = '';
                if (session('MyOrganGroups'))
                {
                    $MyOrganGroups = session('MyOrganGroups');
                }
                $PgC = new PageClass();
                $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'SubjectType');
                $shortTools = $tools['abzar'];
                $tabs = json_encode($ret['tabs']);
                $tabs = json_decode($tabs);
                $SecGroup = json_encode($SecGroup, true);
                $SecGroup = json_decode($SecGroup);
                $GroupAccess = json_encode($GroupAccess, false);
                $GroupAccess = json_decode($GroupAccess);
                $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
                return view('pages.Desktop.ADD.NewUserSec', array('id' => $secid, 'PageType' => 'desktop', 'SiteLogo' => $ret['SiteLogo'], 'MyOrganGroups' => $MyOrganGroups, 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
                    'Title' => $ret['Title'], 'SecGroup' => $SecGroup, 'GroupAccess' => $GroupAccess, 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
                    'menu' => $ret['menu'], 'content' => '', 'ACL' => $ACL, 'Access' => $Access, 'Files' => '', 'keywords' => '',
                    'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $tabs, 'Tree' => $Tree, 'tools' => $shortTools, 'tools_menu' => $MenuTools));
            }
        }
    }

    public static function GetUserDetail($name)
    {
        $uid = Auth::id();
        if (isset($_GET['id']) && $_GET['id'] != '')
        {
            $uidsx = intval($_GET['id']);
        }
        $SP = new UserClass();
        $SecGroup = $SP->GetSecGroup($uid, 0);
        $UC = new UserClass();
        $user_data = $UC->About($uidsx, $uid, 'local');
        $us = $user_data['preview'];
        $us = json_encode($us);
        $us = json_decode($us);
        $c = 'user_edit';
        return
            [
                'current_tab' => 'desktop',
                'content' => $c,
                'SecGroup' => $SecGroup,
                'user_id' => $uidsx,
                'user_add' => $us
            ];
    }

    public static function AddUserDetail($name)
    {
        $uid = Auth::id();
        $SP = new UserClass();
        $SecGroup = $SP->GetSecGroup($uid, 0);
        $c = 'user_add';
        return array('pid' => 'desktop', 'content' => $c, 'SecGroup' => $SecGroup, 'user_id' => '0', 'user_add' => '');
    }


    public static function EditAlert($name)
    {
        $uid = Auth::id();
        if (isset($_GET['id']) && $_GET['id'] != '')
        {
            $uidsx = intval($_GET['id']);
        }
        $SP = new \App\HamafzaServiceClasses\ConfigurationClass();
        $s = $SP->GetAlerts($uidsx);
        $Comment = $s->comment;
        $name = $s->name;
        $id = $s->id;
        $UploadURL = 'files/alerts';
        return
            [
                'PageType' => 'desktop',
                'sid' => $uid,
                'current_tab' => 'desktop',
                'Comment' => $Comment,
                'id' => $id,
                'name' => $name,
                'content' => ''
            ];
    }

    public static function GetUserList($name, $sr)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $SP = new ConfigurationClass();
            $menu = $SP->GetUserList($sr);
            $c = UsersGrids::Users($menu);
            return
                [
                    'current_tab' => 'desktop',
                    'content' => $c,
                    'sr' => $sr
                ];
        }
    }

    public static function GetUserSecurityList($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $ret = DesktopClass::USER($name);
            $SP = new ConfigurationClass();
            $menu = $SP->GetUserSecurity();
            $c = UsersGrids::UserSecurity($menu);
            $sesid = '';
            $uid = (session('uid') != '') ? $uid : 0;
            //$Portals = PageClass::GetProtals($uid, $sesid);
            //$keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
            $MyOrganGroups = '';
            if (session('MyOrganGroups'))
            {
                //$MyOrganGroups = session('MyOrganGroups');
            }
            //$PgC = new PageClass();
            //$tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'SubjectType');
            //$MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
            //$shortTools = $tools['abzar'];
            return view('pages.Desktop', [
                'PageType' => 'desktop',
                'SiteLogo' => $ret['SiteLogo'],
                //'MyOrganGroups' => $MyOrganGroups,
                'SiteTitle' => $ret['SiteTitle'],
                'sid' => $uid,
                'Title' => $ret['Title'],
                'Small' => $ret['Small'],
                'uname' => $ret['uname'],
                'pid' => 'desktop',
                'menu' => $ret['menu'],
                'content' => $c,
                'Files' => '',
                'keywords' => '',
                //'Portals' => $Portals,
                //'keywordTab' => $keywordTab,
                'tabs' => $ret['tabs'],
                'Tree' => $Tree,
                //'tools' => $shortTools,
                //'tools_menu' => $MenuTools
            ]);
        }
    }

    public static function UserSecurityAdd($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        $ret = DesktopClass::USER($name);
        if ($uid == 0 || UsersClass::permission('manage_users', $uid) != '1')
        {
            return Redirect::back()->with('message', 'شما به این قسمت دسترسی ندارید')->with('mestype', 'error');
        }
        if ($uid != 0 && UsersClass::permission('manage_users', $uid) == '1')
        {
            $SP = new ConfigurationClass();
            $s = $SP->GetUserSecurityDetail($uid, 0);
            $Access = $s['Access'];
            $ACL = $s['ACL'];
        }
        else
        {
            return Redirect()->back()->with('message', $C)->with('mestype', 'error');
        }

        $uid = session('uid');
        $sesid = '';
        $uid = (session('uid') != '') ? $uid : 0;
        $Portals = PageClass::GetProtals($uid, $sesid);
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $PgC = new PageClass();
        $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'SubjectType');
        $shortTools = $tools['abzar'];
        $tabs = json_encode($ret['tabs']);
        $tabs = json_decode($tabs);
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
        return view('pages.Desktop.ADD.NewUserSec', array('PageType' => 'desktop', 'SiteLogo' => $ret['SiteLogo'], 'MyOrganGroups' => $MyOrganGroups, 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
            'Title' => $ret['Title'], 'SecGroup' => '', 'GroupAccess' => '', 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
            'menu' => $ret['menu'], 'content' => '', 'ACL' => $ACL, 'Access' => $Access, 'Files' => '', 'keywords' => '',
            'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $tabs, 'Tree' => $Tree, 'tools' => $shortTools, 'tools_menu' => $MenuTools));
    }

    public static function Getannounces()
    {
        $uid = Auth::id();
        $s = new DesktopsClass();
        $s = $s->Getannounces($uid, 0, 0);
        $s = json_encode($s);
        $s = json_decode($s);
        return
            [
                'viewname' => 'pages.desktopcontents',
                'PageType' => 'desktop',
                'type' => 'announce',
                'current_tab' => 'desktop',
                'content' => $s
            ];
    }

    public static function showgroupsList($name)
    {
        $uid = Auth::id();
        $SP = new ConfigurationClass();
        $s = $SP->GetAdminGroups($uid, 0);
        $c = UsersGrids::UserGroup($s);
        return
            [
                'current_tab' => 'desktop',
                'content' => $c
            ];
    }

    public static function showorganList($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $ret = DesktopClass::USER($name);
            $SP = new ConfigurationClass();
            $s = $SP->GetAdminOrgans($uid, $sesid);
            $c = UsersGrids::UserOrgan($s);
            $uid = session('uid');
            $sesid = '';
            $uid = (session('uid') != '') ? $uid : 0;
            //$Portals = PageClass::GetProtals($uid, $sesid);
            //$keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
            $MyOrganGroups = '';
            if (session('MyOrganGroups'))
            {
                //$MyOrganGroups = session('MyOrganGroups');
            }
            //$PgC = new PageClass();
            //$tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'SubjectType');
            //$MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
            //$shortTools = $tools['abzar'];
            return view('pages.Desktop', [
                    'PageType' => 'desktop',
                    'SiteLogo' => $ret['SiteLogo'],
                    //'MyOrganGroups' => $MyOrganGroups,
                    'SiteTitle' => $ret['SiteTitle'],
                    'sid' => $uid,
                    'Title' => $ret['Title'],
                    'Small' => $ret['Small'],
                    'uname' => $ret['uname'],
                    'pid' => 'desktop',
                    'menu' => $ret['menu'],
                    'content' => $c,
                    'Files' => '',
                    //'keywords' => '',
                    //'Portals' => $Portals,
                    //'keywordTab' => $keywordTab,
                    'tabs' => $ret['tabs'],
                    'Tree' => $Tree,
                    //'tools' => $shortTools,
                    //'tools_menu' => $MenuTools
                ]
            );
        }
    }

    public static function permission($module, $uid)
    {
        $access = '0';
        if (isset($uid))
        {
            $count = DB::table('user as u')->join('group_access as ga', 'ga.secgroupid', '=', 'u.SecGroups')
                ->join('access as a', 'ga.accid', '=', 'a.id')
                ->where('a.name', $module)->where('u.id', $uid)->select('ga.levelid as res')->first();
            if ($count)
            {
                $access = $count->res;
            }
        }
        return $access;
    }

}
