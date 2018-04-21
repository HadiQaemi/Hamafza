<?php

namespace App\HamafzaViewClasses;

use App\HamafzaServiceClasses\UserClass;
use App\HamafzaServiceClasses\KeywordsClass;
use App\Models\Hamahang\Tasks\tasks;
use Illuminate\Support\Facades\DB;
use App\HamafzaServiceClasses\PagesClass;
use App\HamafzaServiceClasses\DesktopsClass;
use Auth;
use App\HamafzaPublicClasses\FunctionsClass;
use App\User;

class DesktopClass
{

    public static function subst($uname, $Selected, $Tree, $sublink)
    {
        $uid = (session('uid') != '') ? session('uid') : 0;
        $sesid = (session('SessionID') != '') ? session('SessionID') : 0;
        if ($sublink == '')
        {
            return substclass::show($uid, $sesid, $uname, $Selected, $Tree);
        }
        if ($sublink == 'add')
        {
            return substclass::add($uid, $sesid, $uname, $Selected, $Tree);
        }
        else
        {
            if ($sublink == 'edit')
            {
                if (isset($_GET['id']))
                {
                    $pid = $_GET['id'];
                    return substclass::edit($uid, $sesid, $uname, $Selected, $Tree, $pid);
                }
            }
            else
            {
                if ($sublink == 'view')
                {
                    if (isset($_GET['id']))
                    {
                        $pid = $_GET['id'];
                        return ProccessClass::FlowChart($uid, $sesid, $uname, $Selected, $Tree, $pid);
                    }
                }
            }
        }
    }

    public static function DesktopType($type, $name, $sublink = '')
    {
        if (session('uid') != '')
        {
            $uid = session('uid');
            $sesid = session('SessionID');
        }
        else
        {
            $uid = '0';
            $sesid = '0';
        }
        if ($type == '')
        {
            if ($uid != '0')
            {
                $Tree = DesktopClass::DeskTopTree($uid, $sesid, $type, '');
                $content = DesktopClass::DefDesktop($name, $Tree);
                return $content;
            }
            else
            {
                $Tree = '';
            }
            $content = DesktopClass::DefDesktop($name, $Tree);
            return $content;
        }
        else
        {
            $Selected = '';
            if (isset($_GET['tt']) && $_GET['tt'] != '')
            {
                $Selected = $_GET['tt'];
            }
            $Tree = DesktopClass::DeskTopTree($uid, $sesid, $type, $Selected);
            switch ($type)
            {
                case 'notifications':
                    $con = UsersClass::Alerts($name, $uid, $Tree);
                    return $con;
                    break;
                case 'user_measures':
                    $con = Measure::SelectType($name, $Selected, $Tree);
                    return $con;
                    break;
                case 'user_measures_ME':
                    $con = Measure::SelectType($name, 'ME', $Tree);
                    return $con;
                    break;
                case 'user_measures_BC':
                    $con = Measure::SelectType($name, 'BC', $Tree);
                    return $con;
                    break;
                case 'user_measures_Fme':
                    $con = Measure::SelectType($name, 'Fme', $Tree);
                    return $con;
                    break;
                case 'user_measures_MeDrafts':
                    $con = Measure::SelectType($name, 'MeDrafts', $Tree);
                    return $con;
                    break;
                case 'user_measures_ALL':
                    $con = Measure::SelectType($name, 'ALL', $Tree);
                    return $con;
                    break;
                case 'user_proccess':
                    $con = Proccess::showProcDesk($name, $uid, $sesid, $Tree, $sublink);
                    return $con;
                    break;
                case 'inbox':
                    $con = Message::Show($name, $uid, $sesid, $Tree);
                    return $con;
                    break;
                case 'subjects':
                    $con = SubjectClass::Asubjects($name, $uid, $sesid, $Tree, $sublink);
                    return $con;
                    break;
                case 'asubadd':
                    $con = SubjectClass::AsubjectAdd($name, $uid, $sesid, $Tree);
                    return $con;
                    break;
                case 'thesarus':
                    $con = KeywordClass::Thesarus($name, $uid, $sesid, $Tree, $sublink);
                    return $con;
                    break;
                case 'process_list':
                    $con = ProccessClass::SelectType($name, $Selected, $Tree, $sublink);
                    return $con;
                case 'subst':
                    $con = Localclass::subst($name, $Selected, $Tree, $sublink);
                    return $con;
                case 'form_list':
                    $con = FormClass::SelectType($name, $Selected, $Tree, $sublink);
                    return $con;
                case 'outbox':
                    $con = Message::Outbox($name, $uid, $sesid, $Tree);
                    return $con;
                    break;
                case 'ticket_list':
                    $con = Message::Conversation($name, $uid, $sesid, $Tree);
                    return $con;
                    break;
                case 'subject_field':
                    $con = FieldClass::GetFields($name, $uid, $sesid, $Tree);
                    return $con;
                    break;
                case 'subject_type_list':
                    $con = FieldClass::SubjectType($name, $uid, $sesid, $Selected, $Tree, $sublink);

                    return $con;
                case 'user_list':
                    $sr = '';
                    if (isset($_GET['sr']) && $_GET['sr'] != '')
                    {
                        $sr = $_GET['sr'];
                    }
                    $con = UsersClass::AdminUserList($name, $uid, $sesid, $Selected, $Tree, $sublink, $sr);
                    return $con;
                    break;
                    return $con;
                case 'user_security':
                    $con = UsersClass::GetUserSecurity($name, $uid, $sesid, $Selected, $Tree, $sublink);
                    return $con;
                    break;
                case 'showgroups':
                    $con = UsersClass::showgroups($name, $uid, $sesid, $Selected, $Tree, $sublink);
                    return $con;
                    break;
                case 'showorgans':
                    $con = UsersClass::showorgans($name, $uid, $sesid, $Selected, $Tree, $sublink);
                    return $con;
                    break;

                case 'alerts':
                    $con = UsersClass::showalerts($name, $uid, $sesid, $Selected, $Tree, $sublink);
                    return $con;
                    break;
                case 'homepage':
                    $con = PageClass::homepage($name, $uid, $sesid, $Selected, $Tree, $sublink);
                    return $con;
                    break;
                case 'Circle':
                    $con = RelationClass::Manager($name, $uid, $sesid, $Selected, $Tree, $sublink, 'Circle');
                    return $con;
                    break;
                case 'InCircle':
                    $con = RelationClass::Manager($name, $uid, $sesid, $Selected, $Tree, $sublink, 'InCircle');
                    return $con;
                    break;
                case 'Group':
                    $con = RelationClass::Manager($name, $uid, $sesid, $Selected, $Tree, $sublink, 'Group');
                    return $con;
                    break;
                case 'InGroup':
                    $con = RelationClass::Manager($name, $uid, $sesid, $Selected, $Tree, $sublink, 'InGroup');
                    return $con;
                    break;
                case 'Organ':
                    $con = RelationClass::Manager($name, $uid, $sesid, $Selected, $Tree, $sublink, 'OrganMyadmin');
                    return $con;
                    break;
                case 'Organs':
                    $con = RelationClass::Manager($name, $uid, $sesid, $Selected, $Tree, 'In', 'OrganMyadmin');
                    return $con;
                    break;

                case 'Groups':
                    $con = RelationClass::Manager($name, $uid, $sesid, $Selected, $Tree, 'In', 'Groups');
                    return $con;
                    break;
                case 'Group_MyAdmin':
                    $con = RelationClass::Manager($name, $uid, $sesid, $Selected, $Tree, 'In', 'Group_MyAdmin');
                    return $con;
                    break;
                case 'Group_IN':
                    $con = RelationClass::Manager($name, $uid, $sesid, $Selected, $Tree, 'In', 'Group_IN');
                    return $con;
                    break;
                case 'Circles':
                    $con = RelationClass::Manager($name, $uid, $sesid, $Selected, $Tree, 'In', 'Circles');
                    return $con;
                    break;
                case 'followed':
                    $con = RelationClass::Manager($name, $uid, $sesid, $Selected, $Tree, 'In', 'followed');
                    return $con;
                    break;
                case 'Pfollowed2':
                    $con = RelationClass::Manager($name, $uid, $sesid, $Selected, $Tree, 'In', 'Pfollowed');
                    return $con;
                    break;
                case 'Pfollowed':
                    $con = RelationClass::Manager($name, $uid, $sesid, $Selected, $Tree, 'In', 'Pfollowed');
                    return $con;
                    break;
                case 'Gfollowed2':
                    $con = RelationClass::Manager($name, $uid, $sesid, $Selected, $Tree, 'In', 'Gfollowed');
                    return $con;
                    break;

                case 'Gfollowed':
                    $con = RelationClass::Manager($name, $uid, $sesid, $Selected, $Tree, 'In', 'Gfollowed');
                    return $con;
                    break;

                case 'Ofollowed':
                    $con = RelationClass::Manager($name, $uid, $sesid, $Selected, $Tree, 'In', 'Ofollowed');
                    return $con;
                    break;
                case 'Ofollowed2':
                    $con = RelationClass::Manager($name, $uid, $sesid, $Selected, $Tree, 'In', 'Ofollowed');
                    return $con;
                    break;

                case 'mefollow':
                    $con = RelationClass::Manager($name, $uid, $sesid, $Selected, $Tree, 'In', 'mefollow');
                    return $con;
                    break;
                case 'helps':
                    $con = HelpClass::Show($name, $uid, $sesid, $Tree);
                    return $con;
                    break;
                case 'announces':
                    $con = UsersClass::announces($name, $uid, $sesid, $Selected, $Tree, '');
                    return $con;
                    break;
                case 'highlights':
                    $con = UsersClass::highlights($name, $uid, $sesid, $Selected, $Tree, '');
                    return $con;
                    break;
                case 'Files':
                    $con = SubjectClass::MyPages($name, $uid, $sesid, $Selected, $Tree, $sublink);
                    return $con;
                    break;

                case 'keywords':

                    $con = KeywordClass::keywords($name, $uid, $sesid, $Selected, $Tree, $sublink);
                    return $con;
                    break;
                case 'departments':
                    $con = PublicClass::Departments($name, $uid, $sesid, $Selected, $Tree, $sublink);
                    return $con;
                    break;



//                  case 'Files':
//                    $con = SubjectClass::MyPages($name, $uid, $sesid, $Selected, $Tree,'New_Other');
//                    return $con;
//                    break;
            }
        }
    }

    public static function DeskTopTree($uid, $sesid, $type = '', $Selected)
    {
        $newtree = '';
        if (Auth::check())
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $DC = new DesktopsClass();
            $Tree = $DC->DesktopMenu($uid, 0);
            $PC = new PublicClass();
            if (is_array($Tree) && count($Tree) > 0)
            {
                $newtree = $PC->CretaeTree1L($Tree, 'id', 'parent', 'text');
                $newtree = $PC->Json(0, $newtree, $type, $Selected);
            }
            else
            {
                $newtree = '';
            }
        }
        return $newtree;
    }

    public static function DefDesktop($uname, $uid)
    {
        $uids = $uid;
        $UC = new UserClass();
        $user_data = $UC->About($uids, $uid, 'local');
        $us = $user_data['preview'];
        $tools = '';
        $PageType = 'desktop';
        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        if ($uid == '0')
        {
            $c = 'برای دسترسی به این قسمت می بایست عضو سایت باشید';
        }
        else
        {
            $user_data = $UC->DesktopDashboard($uid);
            $c = DesktopClass::DrawDashboard($user_data);
        }
        $Portals = PageClass::GetProtals($uids, 0);
        $keywordTab = KeywordClass::GetPublicKeyword(0, $uid);
        $tools = SNClass::Tools($uid, 0, '', '', 'desktop');
        $MenuTools = $tools['other'];
        $user = User::where('Uname', $uname)->firstOrFail();
        $shortTools = shortToolsGenerator('User', $user->id, ['uid' => $uid, 'sessid' => $user->id, 'userid' => $user->id], ['pageid' => 0, 'tagname' => 0, 'id' => 0]);//$tools['abzar'];
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
        $tabparam['Uname'] = $uname;
        $tabparam['cuid'] = $uid;
        $tabparam['uid'] = $uids;
        $tabs = json_decode(json_encode(PageTabs('userpage', $tabparam)));
        $RightCol = RightCol($uid, 'userabout');
        return ['viewname' => 'pages.user_desktop_dashboard', 'MyOrganGroups' => $MyOrganGroups, 'PageType' => $PageType, 'Title' => $us['Name'] . ' ' . $us['Family'], 'Small' => $us['id'], 'sid' => $uid,
            'Portals' => $Portals, 'keywordTab' => $keywordTab, 'uname' => $uname, 'pid' => 'desktop', 'content' => $c, 'Files' => '', 'keywords' => '', 'tabs' => $tabs, 'tools' => $shortTools, 'tools_menu' => $MenuTools];
    }

    public static function DrawPageDashboard($user_data, $sid)
    {
        $res = '';
        if (is_array($user_data) && count($user_data) > 0)
        {
            $measure = $user_data['Measure'];
            $SMS = $user_data['SMS'];
            $Reports = $user_data['Sale'];
            $NumberofUsers = $user_data['NumberofUsers'];
            $res .= DesktopClass::Res($measure['vazife-erjaat']['count'], 'وظایف من ', 0, 'vazayef.png', 'user_measures_page/' . $sid . '?tt=ME');
            //  $res .=DesktopClass::Res($measure['vazifefarayandi']['count'], 'وظایف فرآیندی', 0, 'vazayef.png', 'user_measures_page/' . $sid . '?tt=ME');
            //   $res .=DesktopClass::Res($measure['vazifeman']['count'], 'وظایف من -منتظر تایید', 0, 'vazayef.png', 'user_measures_page/' . $sid . '?tt=ME');
            $res .= DesktopClass::Res($measure['yaddasht']['count'], 'یادداشت‌ها', 0, 'yddasht.png', 'announces/' . $sid);
            $res .= DesktopClass::Res($measure['alamat']['count'], 'علامت گذاری‌ها', 0, 'alamatgozari.png', 'highlights/' . $sid . '?type=XE');
        }
        return $res;
    }

    public static function DrawDashboard($user_id)
    {
        $UC = new UserClass();
        $user_data = $UC->DesktopDashboard($user_id);
        $res = '';
        $Uname = session('Uname');
        if (is_array($user_data) && count($user_data) > 0 && auth()->check())
        {
            $measure = $user_data['Measure'];
            $Emails = $user_data['Emails'];
            $Forms = $user_data['Forms'];

            $SMS = $user_data['SMS'];
            $Reports = $user_data['Sale'];
            $MyTasksCount = auth()->user()->MyTasksCount;
            $MyAssignmentTasksCount = auth()->user()->MyAssignedTasksCount;
            $res .= DesktopClass::Res($MyTasksCount/*$measure['vazifeman']['count']*/, 'وظایف من ', $MyTasksCount /*$measure['vazifeman']['unread']*/, 'vazayef.png', route('ugc.desktop.hamahang.tasks.my_tasks.list', $Uname));//url('/') . '/' . $Uname . '/desktop/user_measures_ME');
            $res .= DesktopClass::Res($MyAssignmentTasksCount/*$measure['vazife-erjaat']['count']*/, 'واگذاری‌های من', $MyAssignmentTasksCount /*$measure['vazife-erjaat']['unread']*/, 'vagozari.png', route('ugc.desktop.hamahang.tasks.my_assigned_tasks.list', $Uname));//url('/') . '/' . $Uname . '/desktop/user_measures_Fme');
            $res .= DesktopClass::Res($measure['runevesht']['count'], 'رونوشت به من‌ها', $measure['runevesht']['unread'], 'roonevesht.png', url('/') . '/' . $Uname . '/desktop/user_measures_BC');
            $res .= DesktopClass::Res(0, 'یادآوری‌ها', 0, 'yadavari.png', url('/') . '/' . $Uname . '/desktop/notifications');
// $res .=DesktopClass::Res($measure['vazifefarayandi']['count'], 'وظایف فرآیندی', $measure['vazifefarayandi']['unread'], 'icon-farayand1-1 DashBoardBrown', 'desktop/user_proccess');
            $res .= DesktopClass::Res($SMS['SMS']['count'], 'پیام خوانده نشده', $SMS['SMS']['unread'], 'payamha.png', url('/') . '/' . $Uname . '/desktop/inbox');
            $res .= DesktopClass::Res($Forms['Forms']['count'], 'فرم‌های من', $Forms['Forms']['unread'], 'formha.png', url('/') . '/' . $Uname . '/desktop/inbox');
            $res .= DesktopClass::Res($Reports['Shopping']['count'], ' خرید', $Reports['Shopping']['unread'], 'kharidha.png', '');
            $res .= DesktopClass::Res(get_user_sumscores(), 'امتیاز', 0, 'emtiyaz.png', route('ugc.desktop.hamahang.summary.index',auth()->user()->Uname));
            $res .= DesktopClass::Res(0, 'اعتبار', 0, 'etebar.png', '');
            if (array_key_exists('NumberofUsers', $user_data))
            {
                $NumberofUsers = $user_data['NumberofUsers'];
                $res .= DesktopClass::Res($NumberofUsers['User']['count'], 'کاربران', $NumberofUsers['User']['unread'], 'users.png', url('/') . '/' . $Uname . '/desktop/user_list');
                $res .= DesktopClass::Res($NumberofUsers['Group']['count'], 'گروه‌ها', $NumberofUsers['Group']['unread'], 'groups.png', url('/') . '/' . $Uname . '/desktop/showgroups');

                //   $res .=DesktopClass::Res($NumberofUsers['OnlineUser']['count'], 'کاربران آنلاین', $NumberofUsers['OnlineUser']['unread'], 'icon-b6 DashBoardBrown', '');
                $res .= DesktopClass::Res($NumberofUsers['Organs']['count'], 'کانال‌ها', $NumberofUsers['Organs']['unread'], 'kanalha.png', url('/') . '/' . $Uname . '/desktop/showorgans');
            }
        }
        return ['content' => $res];
    }

    static function Res($val, $title, $Type, $class, $link)
    {
        $Uname = session('Uname');

        $res = '<div class="col-lg-4"><div class="dashbox panel panel-default"><div class="panel-body">
		<div class="panel-left red"> <img src="' . url('/') . '/theme/Content/icons/' . $class . '"></div>
		<div class="panel-right"><div class="number"><a href="' . $link . '">' . $val . '</a></div>
                <div class="title">' . $title . '</div>';
        if ($Type != '0')
        {
            $res .= '<span class="label  DashBoardRed">' . $Type . '<i class="fa fa-arrow-up"></i></span>';
        }
        $res .= '</div></div></div></div>';
        return $res;
    }

    public static function USER($uname)
    {
        $PC = new PublicClass();
        $menu = $PC->GetSiteMenu();
        $cuid = (session('uid') != '') ? session('uid') : 0;

        $SiteTitle = config('constants.SiteTitle');
        $SiteLogo = config('constants.SiteLogo');
        $uid = FunctionsClass::UserName2id($uname);
        $UC = new UserClass();
        $user_data = $UC->About($uid, $cuid, 'local');
        $us = $user_data['preview'];
        $tools = '';
        $tabs = $user_data['Tabs'];
        $ret['tabs'] = $tabs;
        $ret['SiteLogo'] = $SiteLogo;
        $ret['SiteTitle'] = $SiteTitle;
        $ret['Title'] = Auth::user()->Name . ' ' . Auth::user()->Family;
        $ret['Small'] = Auth::id();
        $ret['uname'] = $uname;
        $ret['menu'] = $menu;
        return $ret;
    }

}
