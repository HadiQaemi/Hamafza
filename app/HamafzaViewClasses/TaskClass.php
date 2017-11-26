<?php

namespace App\HamafzaViewClasses;

class TaskClass
{

    public function ShowTask($name, $uid, $Tree)
    {
        $sesid = 0;
        $ret = DesktopClass::USER($name);
        $Portals = PageClass::GetProtals($uid, $sesid);
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $PgC = new PageClass();
        $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'measure');

        $MenuTools = toolsGenerator([6=>['uid'=>$uid,'sid'=>0]],1,5);
        $shortTools = $tools['abzar'];

        return array('RightContent' => 'Amir', 'MyOrganGroups' => $MyOrganGroups, 'SiteLogo' => $ret['SiteLogo'], 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
            'Title' => $ret['Title'], 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
            'menu' => $ret['menu'], 'Files' => '', 'keywords' => '', 'PageType' => 'desktop',
            'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $ret['tabs'], 'Tree' => $Tree, 'tools' => $shortTools, 'tools_menu' => $MenuTools);
        //return view('pages.Desktop.Task', array('content' => 'This is a test','RigghtContent'=>'Amir', 'MyOrganGroups' => $MyOrganGroups, 'SiteLogo' => $ret['SiteLogo'], 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
        //    'Title' => $ret['Title'], 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
        //    'menu' => $ret['menu'], 'Files' => '', 'keywords' => '', 'PageType' => 'desktop',
        //    'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $ret['tabs'], 'Tree' => $Tree, 'tools' => $shortTools, 'menutools' => $MenuTools));
    }

}
