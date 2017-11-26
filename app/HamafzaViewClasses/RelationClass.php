<?php

namespace App\HamafzaViewClasses;

use Illuminate\Support\Facades\DB;

use App\HamafzaServiceClasses\UserClass;

class RelationClass
{
    public static function Manager($name, $uid, $sesid, $Selected, $Tree, $sublink, $type)
    {
        switch ($type)
        {
            case 'Circle':
                return RelationClass::LoadCircle($name, $uid, $sesid, $Selected, $Tree, $sublink);
                break;
            case 'InCircle':
                return RelationClass::InCircle($name, $uid, $sesid, $Selected, $Tree, $sublink);
                break;
            case 'Group':
                return RelationClass::Group($name, $uid, $sesid, $Selected, $Tree, $sublink);
                break;
            case 'InGroup':
                return RelationClass::Group($name, $uid, $sesid, $Selected, $Tree, $sublink);
                break;
            case 'OrganMyadmin':
                return RelationClass::Organ($name, $uid, $sesid, $Selected, $Tree, $sublink);
                break;
            case 'Groups':
                return RelationClass::Groups($name, $uid, $sesid, $Selected, $Tree, $sublink);
                break;

            case 'Group_MyAdmin':
                return RelationClass::Group_MyAdmin($name, $uid, $sesid, $Selected, $Tree, $sublink);
                break;
            case 'Group_IN':
                return RelationClass::Group_IN($name, $uid, $sesid, $Selected, $Tree, $sublink);
                break;
            case 'Circles':
                return RelationClass::Circles($name, $uid, $sesid, $Selected, $Tree, $sublink);
                break;
            case 'followed':
                return RelationClass::Circles($name, $uid, $sesid, $Selected, $Tree, $sublink);
                break;
            case 'Rel_InCircle':
                return Relation::Rel_InCircle($uid);
                break;
            case 'Group_meMan':
                return Relation::Group_meMan($gid=$name, $uid);
                break;
            case 'Group_meReg':
                return Relation::Group_meReg($gid=$name, $uid);
                break;
            case 'Pfollowed2':
                return RelationClass::Cfollowed($name, $uid, $sesid, $Selected, $Tree, 'Follow_Person');
                break;
            case 'Pfollowed':
                return RelationClass::Cfollowed($name, $uid, $sesid, $Selected, $Tree, 'Follow_Person');
                break;

            case 'Gfollowed2':
                return RelationClass::GroupsShow($name, $uid, $sesid, $Selected, $Tree, 'Follow_Group');
                break;
            case 'Gfollowed':
                return RelationClass::GroupsShow($name, $uid, $sesid, $Selected, $Tree, 'Follow_Group');
                break;
            case 'Ofollowed':
                return RelationClass::GroupsShow($name, $uid, $sesid, $Selected, $Tree, 'Follow_Orgs');
                break;
            case 'Ofollowed2':
                return RelationClass::GroupsShow($name, $uid, $sesid, $Selected, $Tree, 'Follow_Orgs');
                break;

            case 'mefollow':
                return RelationClass::Cfollowed($name, $uid, $sesid, $Selected, $Tree, 'Rel_FollowME');
                break;


        }
    }

    public static function LoadCircle($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        $ret = DesktopClass::USER($name);
        /*$Portals = PageClass::GetProtals($uid, $sesid);
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $PgC = new PageClass();
        $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'SubjectType');
        $shortTools = $tools['abzar'];*/
        $tabs = json_encode($ret['tabs']);
        $tabs = json_decode($tabs);
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
        $user = UserClass::RelationManager($uid, $sesid, 'Rel_myCircle', $sublink);

        return view('pages.relations.Circle',
            [
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
                'Circle' => $user,
                'content' => 'ss',
                'Files' => '',
                'keywords' => '',
                //'Portals' => $Portals,
                //'keywordTab' => $keywordTab,
                'tabs' => $tabs,
                'Tree' => $Tree,
                //'tools' => $shortTools,
                'tools_menu' => $MenuTools
            ]);
    }

    public static function followed($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        $ret = DesktopClass::USER($name);
        /*$Portals = PageClass::GetProtals($uid, $sesid);
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $PgC = new PageClass();
        $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'SubjectType');
        $shortTools = $tools['abzar'];*/
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
        $user = UserClass::RelationManager($uid, $sesid, 'followed', $sublink);
        return view('pages.relations.Circle',
            [
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
                'Circle' => $user,
                'content' => 'ss',
                'Files' => '',
                'keywords' => '',
                //'Portals' => $Portals,
                //'keywordTab' => $keywordTab,
                'tabs' => $ret['tabs'],
                'Tree' => $Tree,
                //'tools' => $shortTools,
                'tools_menu' => $MenuTools
            ]);
    }

    public static function Cfollowed($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        $ret = DesktopClass::USER($name);
        /*$Portals = PageClass::GetProtals($uid, $sesid);
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $PgC = new PageClass();
        $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'SubjectType');
        $shortTools = $tools['abzar'];*/
        $tabs = json_encode($ret['tabs']);
        $tabs = json_decode($tabs);
        $user = UserClass::RelationManager($uid, $sesid, 'followed', $sublink);
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
        return view('pages.relations.Circle',
            [
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
                'Circle' => $user,
                'content' => 'ss',
                'Files' => '',
                'keywords' => '',
                //'Portals' => $Portals,
                //'keywordTab' => $keywordTab,
                'tabs' => $tabs,
                'Tree' => $Tree,
                //'tools' => $shortTools,
                'tools_menu' => $MenuTools
            ]);
    }

    public static function Circles($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        $ret = DesktopClass::USER($name);
        /* $Portals = PageClass::GetProtals($uid, $sesid);
         $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
         $MyOrganGroups = '';
         if (session('MyOrganGroups'))
         {
             $MyOrganGroups = session('MyOrganGroups');
         }
         $PgC = new PageClass();
         $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'SubjectType');
         $shortTools = $tools['abzar'];*/
        $tabs = json_encode($ret['tabs']);
        $tabs = json_decode($tabs);
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
        $user = UserClass::RelationManager($uid, $sesid, 'followed', $sublink);
        return view('pages.relations.Circle',
            [
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
                'Circle' => $user,
                'content' => 'ss',
                'Files' => '',
                'keywords' => '',
                //'Portals' => $Portals,
                //'keywordTab' => $keywordTab,
                'tabs' => $tabs,
                'Tree' => $Tree,
                //'tools' => $shortTools,
                'tools_menu' => $MenuTools
            ]);
    }


    public static function InCircle($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        $ret = DesktopClass::USER($name);
        /*$Portals = PageClass::GetProtals($uid, $sesid);
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $PgC = new PageClass();
        $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'SubjectType');
        $shortTools = $tools['abzar'];*/
        $tabs = json_encode($ret['tabs']);
        $tabs = json_decode($tabs);
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
        $user = UserClass::RelationManager($uid, $sesid, 'Rel_InCircle', $sublink);
        return view('pages.relations.Circle',
            [
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
                'Circle' => $user,
                'content' => 'ss',
                'Files' => '',
                'keywords' => '',
                //'Portals' => $Portals,
                //'keywordTab' => $keywordTab,
                'tabs' => $tabs,
                'Tree' => $Tree,
                //'tools' => $shortTools,
                'tools_menu' => $MenuTools
            ]);
    }

    public static function Group($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        $ret = DesktopClass::USER($name);
        /*$Portals = PageClass::GetProtals($uid, $sesid);
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $PgC = new PageClass();
        $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'Group');
        $shortTools = $tools['abzar'];*/
        $tabs = json_encode($ret['tabs']);
        $tabs = json_decode($tabs);

        $user = UserClass::RelationManager($uid, $sesid, 'Group_meMan', '', $sublink);
        $admin = $user['admin'];
        $about = $user['about'];
        $members = $user['members'];
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
        return view('pages.relations.Group',
            [
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
                'about' => $about,
                'admin' => $admin,
                'members' => $members,
                'content' => 'ss',
                'Files' => '',
                'keywords' => '',
                //'Portals' => $Portals,
                //'keywordTab' => $keywordTab,
                'tabs' => $tabs,
                'Tree' => $Tree,
                //'tools' => $shortTools,
                'tools_menu' => $MenuTools
            ]);
    }

    public static function Organ($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        $ret = DesktopClass::USER($name);
        /*$Portals = PageClass::GetProtals($uid, $sesid);
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $PgC = new PageClass();
        $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'SubjectType');
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
        $shortTools = $tools['abzar'];*/
        $tabs = json_encode($ret['tabs']);
        $tabs = json_decode($tabs);
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
        if ($sublink == 'MyAdmin')
        {
            $user = UserClass::RelationManager($uid, $sesid, $sublink, 0, 'OrganMyadmin');
        }
        else
        {
            $user = UserClass::RelationManager($uid, $sesid, $sublink, 0, 'OrganIn');
        }
        return view('pages.relations.Circle',
            [
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
                'Circle' => $user,
                'content' => 'ss',
                'Files' => '',
                'keywords' => '',
                //'Portals' => $Portals,
                //'keywordTab' => $keywordTab,
                'tabs' => $tabs,
                'Tree' => $Tree,
                //'tools' => $shortTools,
                'tools_menu' => $MenuTools
            ]);
    }


    public static function Groups($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        $ret = DesktopClass::USER($name);
        /*$Portals = PageClass::GetProtals($uid, $sesid);
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $PgC = new PageClass();
        $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'SubjectType');
        $shortTools = $tools['abzar'];*/
        $tabs = json_encode($ret['tabs']);
        $tabs = json_decode($tabs);
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
        $user = UserClass::RelationManager($uid, $sesid, $sublink, 0, $sublink);
        return view('pages.relations.Circle',
            [
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
                'Circle' => $user,
                'content' => 'ss',
                'Files' => '',
                'keywords' => '',
                //'Portals' => $Portals,
                //'keywordTab' => $keywordTab,
                'tabs' => $tabs,
                'Tree' => $Tree,
                //'tools' => $shortTools,
                'tools_menu' => $MenuTools
            ]);
    }

    public static function Group_MyAdmin($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        $ret = DesktopClass::USER($name);
        /*$Portals = PageClass::GetProtals($uid, $sesid);
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $PgC = new PageClass();
        $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'Groups');
        $shortTools = $tools['abzar'];*/

        $SP = new service();

        $menu = $SP->ServicePost('Relation', "uid=$uid&sesid=$sesid&gid=$sublink&type=Group_MyAdmin");

        //  return $menu;
        $json_a = json_decode($menu, true);
        $user = $json_a['data'];
        //return $user;
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
        $err = $json_a['error'];
        return view('pages.relations.organ',
            [
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
                'Organs' => $user,
                'content' => 'ss',
                'Files' => '',
                'keywords' => '',
                //'Portals' => $Portals,
                //'keywordTab' => $keywordTab,
                'tabs' => $ret['tabs'],
                'Tree' => $Tree,
                //'tools' => $shortTools,
                'tools_menu' => $MenuTools
            ]);
    }

    public static function GroupsShow($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        $ret = DesktopClass::USER($name);
        /* $Portals = PageClass::GetProtals($uid, $sesid);
         $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
         $MyOrganGroups = '';
         if (session('MyOrganGroups')) {
             $MyOrganGroups =session('MyOrganGroups');
         }
         $PgC = new PageClass();
         $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'SubjectType');
         $shortTools = $tools['abzar'];*/
        $tabs = json_encode($ret['tabs']);
        $tabs = json_decode($tabs);
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
        $user = UserClass::RelationManager($uid, $sesid, $sublink, 0, $sublink);
        return view('pages.relations.organ',
            [
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
                'Organs' => $user,
                'content' => 'ss',
                'Files' => '',
                'keywords' => '',
                //'Portals' => $Portals,
                //'keywordTab' => $keywordTab,
                'tabs' => $tabs,
                'Tree' => $Tree,
                //'tools' => $shortTools,
                'menutools' => $MenuTools
            ]);
    }

    public static function Group_IN($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        $ret = DesktopClass::USER($name);
        /*$Portals = PageClass::GetProtals($uid, $sesid);
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $PgC = new PageClass();
        $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'SubjectType');
        $shortTools = $tools['abzar'];*/
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);

        $SP = new service();

        $menu = $SP->ServicePost('Relation', "uid=$uid&sesid=$sesid&gid=$sublink&type=Group_IN");

        //  return $menu;
        $json_a = json_decode($menu, true);
        $user = $json_a['data'];
        //return $user;

        $err = $json_a['error'];
        return view('pages.relations.organ',
            [
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
                'Organs' => $user,
                'content' => 'ss',
                'Files' => '',
                'keywords' => '',
                //'Portals' => $Portals,
                //'keywordTab' => $keywordTab,
                'tabs' => $ret['tabs'],
                'Tree' => $Tree,
                //'tools' => $shortTools,
                'tools_menu' => $MenuTools
            ]);
    }

}
