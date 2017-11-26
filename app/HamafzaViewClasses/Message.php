<?php

namespace App\HamafzaViewClasses;

use App\HamafzaGrids\MeasureDataGrid;
use App\HamafzaServiceClasses\UserClass;
use App\HamafzaServiceClasses\KeywordsClass;
use App\Models\hamafza\Ticket;
use Illuminate\Support\Facades\DB;
use App\HamafzaServiceClasses\PagesClass;
use App\HamafzaServiceClasses\MessageClass;
use App\HamafzaServiceClasses\DesktopsClass;
use App\HamafzaGrids\MessageDataGrid;
use Auth;

class Message
{

    public static function Conversation($uname, $uid, $sesid, $Tree)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $ret = DesktopClass::USER($uname);
            $M = new MessageClass();
            $s = $M->inbox($uid, $sesid);
            $C = MessageDataGrid::inbox($s);
            $uid = session('uid');
            $sesid = '';
            $Portals = PageClass::GetProtals($uid, $sesid);
            $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
            $MyOrganGroups = '';
            if (session('MyOrganGroups'))
            {
                $MyOrganGroups = session('MyOrganGroups');
            }
            $PgC = new PageClass();
            $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'sms');
            $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
            $shortTools = $tools['abzar'];
            return view('pages.Desktop', array('PageType' => 'desktop', 'SiteLogo' => $ret['SiteLogo'], 'MyOrganGroups' => $MyOrganGroups, 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
                'Title' => $ret['Title'], 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
                'menu' => $ret['menu'], 'content' => $C, 'Files' => '', 'keywords' => '',
                'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $ret['tabs'], 'Tree' => $Tree, 'tools' => $shortTools, 'tools_menu' => $MenuTools));
        }
    }

//    public static function ShowMessage($tid)
//    {
//        $files = Ticket::find($tid)->files;
//        if (!Auth::check())
//        {
//            return view('modals.viewmessage')->with('files', $files);
//        }
//        else
//        {
//            $M = new MessageClass();
//            $uid = session('uid');
//            $s = $M->ViewMessage($uid, $tid);
//            return view('hamahang.Tickets.view_ticket_modals.content', array('message' => $s, 'files' => $files));
//        }
//    }

    public static function Show($uname, $uid, $sesid, $Tree)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            //variable_generator('user','desktop',$uname);
            $ret = DesktopClass::USER($uname);
            $M = new MessageClass();
            $s = $M->inbox($uid, $sesid);
            $C = MessageDataGrid::inbox($s);
            $uid = session('uid');
            /*$sesid = '';
            $Portals = PageClass::GetProtals($uid, $sesid);
            $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
            $MyOrganGroups = '';
            if (session('MyOrganGroups')) {
                $MyOrganGroups = session('MyOrganGroups');
            }*/
            /*$PgC = new PageClass();
            $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'sms');
            $MenuTools = toolsGenerator([6=>['uid'=>$uid,'sid'=>0]],1,5);
            $shortTools = $tools['abzar'];*/
            return view('pages.Desktop',
                [
                    'PageType' => 'desktop',
                    //'SiteLogo' => $ret['SiteLogo'],
                    //'MyOrganGroups' => $MyOrganGroups,
                    'SiteTitle' => $ret['SiteTitle'],
                    'sid' => $uid,
                    'Title' => $ret['Title'],
                    'Small' => $ret['Small'],
                    'uname' => $ret['uname'],
                    'pid' => 'desktop',
                    'menu' => $ret['menu'],
                    'content' => $C,
                    'Files' => '',
                    'keywords' => '',
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

    public static function Outbox($uname, $uid, $sesid, $Tree)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $ret = DesktopClass::USER($uname);
            $M = new MessageClass();
            $s = $M->Outbox($uid, $sesid);
            $C = MessageDataGrid::outbox($s);
            $uid = session('uid');
            //$sesid = '';
            /*$Portals = PageClass::GetProtals($uid, $sesid);
            $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
            $MyOrganGroups = '';
            if (session('MyOrganGroups'))
            {
                $MyOrganGroups = session('MyOrganGroups');
            }*/
            /*$PgC = new PageClass();
            $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'sms');
            $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
            $shortTools = $tools['abzar'];*/
            return view('pages.Desktop',
                [
                    'PageType' => 'desktop',
                    //'SiteLogo' => $ret['SiteLogo'],
                    //'MyOrganGroups' => $MyOrganGroups,
                    'SiteTitle' => $ret['SiteTitle'],
                    'sid' => $uid,
                    'Title' => $ret['Title'],
                    'Small' => $ret['Small'],
                    'uname' => $ret['uname'],
                    'pid' => 'desktop',
                    'menu' => $ret['menu'],
                    'content' => $C,
                    'Files' => '',
                    'keywords' => '',
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
}
