<?php

namespace App\HamafzaViewClasses;

use Illuminate\Support\Facades\DB;
use App\HamafzaServiceClasses\PagesClass;
use App\HamafzaServiceClasses\PublicsClass;
use App\HamafzaGrids\ProccessGrids;
use App\HamafzaServiceClasses\ProccesClass;
use Auth;

class ProccessClass {

    public static function editProcess($uid, $session_id, $phase_name, $phase_score, $view, $phase_manager1, $phase_manager, $formid
    , $pformid, $persons, $alert, $process_name, $process_comment, $process_id) {
        $SP = new service();
        $params['phase_name'] = $phase_name;
        $params['uid'] = $uid;
        $params['sesid'] = $session_id;
        $params['phase_score'] = $phase_score;
        $params['view'] = $view;
        $params['phase_manager1'] = $phase_manager1;
        $params['phase_manager'] = $phase_manager;
        $params['formid'] = $formid;
        $params['pformid'] = $pformid;
        $params['persons'] = $persons;
        $params['alert'] = $alert;
        $params['process_name'] = $process_name;
        $params['process_comment'] = $process_comment;
        $poststr = http_build_query($params);
        $phase_name = (is_array($phase_name)) ? implode(",", $phase_name) : '';
        $phase_score = (is_array($phase_score)) ? implode(",", $phase_score) : '';
        $view = (is_array($view)) ? implode(",", $view) : '';
        $phase_manager1 = (is_array($phase_manager1)) ? implode(",", $phase_manager1) : '';
        $phase_manager = (is_array($phase_manager)) ? implode(",", $phase_manager) : '';
        $formid = (is_array($formid)) ? implode(",", $formid) : '';
        $pformid = (is_array($pformid)) ? implode(",", $pformid) : '';
        $persons = (is_array($persons)) ? implode(",", $persons) : '';
        $alert = (is_array($alert)) ? implode(",", $alert) : '';


        $data = $SP->ServicePost('EditProccess', 'uid=' . $uid . '&sesid=' . $session_id . '&phase_name=' . $phase_name . '&phase_score=' .
                $phase_score . '&view=' . $view . '&phase_manager1=' . $phase_manager1 . '&phase_manager=' . $phase_manager . '&formid=' . $formid
                . '&pformid=' . $pformid . '&persons=' . $persons . '&alert=' . $alert . '&process_name=' . $process_name . '&process_comment=' . $process_comment . '&process_id=' . $process_id);

        //  $data = $SP->ServicePostArray('ADDProccess', $poststr);
        $json_a = json_decode($data, true);
        $s = $json_a['data'];
        return $s;
    }

    public static function ADDProccess($uid, $session_id, $phase_name, $phase_score, $view, $phase_manager1, $phase_manager, $formid
    , $pformid, $persons, $alert, $process_name, $process_comment) {
        $SP = new \App\HamafzaServiceClasses\ProccesClass();
        $s = $SP->ADDProccess($uid, $session_id, $phase_name, $phase_score, $view, $phase_manager1, $phase_manager, $formid, $pformid, $persons, $alert, $process_name, $process_comment);
        return $s;
    }

    public static function SelectType($uname, $Selected, $Tree, $sublink) {
        $uid = (session('uid') != '') ? session('uid') : 0;
        $sesid = (session('sesid') != '') ? session('sesid') : 0;
        if ($sublink == '')
            return ProccessClass::ME($uid, $sesid, $uname, $Selected, $Tree);
        if ($sublink == 'add')
            return ProccessClass::Add($uid, $sesid, $uname, $Selected, $Tree);
        else if ($sublink == 'edit') {
            if (isset($_GET['id'])) {
                $pid = $_GET['id'];
                return ProccessClass::EditChart($uid, $sesid, $uname, $Selected, $Tree, $pid);
            }
        } else if ($sublink == 'view') {
            if (isset($_GET['id'])) {
                $pid = $_GET['id'];
                return ProccessClass::FlowChart($uid, $sesid, $uname, $Selected, $Tree, $pid);
            }
        }
    }

    static function EditChart($uid, $sesid, $uname, $Selected, $Tree, $pid) {
        if (!Auth::check())
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        else {
            $ret = DesktopClass::USER($uname);
            $SP = new ProccesClass();
            $C = $SP->EditProcces($pid);
            $C = json_encode($C);
            $C = json_decode($C);
            return $C;
            $Portals = PageClass::GetProtals($uid, $sesid);
            $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
            $MyOrganGroups = '';
            if (session('MyOrganGroups')) {
                $MyOrganGroups = session('MyOrganGroups');
            }
            $PgC = new PageClass();
            $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'proccess');

            $shortTools = $tools['abzar'];

             $SP = new \App\HamafzaServiceClasses\ProccesClass();
            $s = $SP->NewProccessData();
            $forms = $s['Forms'];
            $alerts = $s['Alerts'];
            $Porsesh = $s['Porsesh'];
            $Porsesh = json_encode($Porsesh);
            $Porsesh = json_decode($Porsesh);
            $alerts = json_encode($alerts);
            $alerts = json_decode($alerts);
            $forms = json_encode($forms);
            $forms = json_decode($forms);
             $tabs = json_encode($ret['tabs']);
            $tabs = json_decode($tabs);
            $MenuTools =toolsGenerator([6=>['uid'=>$uid,'sid'=>0]],1,5);
            return view('pages.Desktop.viewproc', array('MyOrganGroups' => $MyOrganGroups, 'SiteLogo' => $ret['SiteLogo'], 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
                            'Title' => $ret['Title'], 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
                            'menu' => $ret['menu'], 'PageType' => 'desktop', 'content' => 'edit', 'proc' => $C, 'Files' => '', 'keywords' => '', 'forms' => $forms, 'alerts' => $alerts, 'Porsesh' => $Porsesh,
                            'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' =>$tabs, 'Tree' => $Tree, 'tools' => $shortTools, 'tools_menu' => $MenuTools));
        }
    }

    static function FlowChart($uid, $sesid, $uname, $Selected, $Tree, $pid) {
        $ret = DesktopClass::USER($uname);
        $SP = new ProccesClass();
        $C = $SP->EditProcces($pid);
        $C = json_encode($C);
        $C = json_decode($C);
        $uid = session('uid');
        $sesid = session('SessionID');
        $uid = (session('uid') != '' && session('uid') != '') ? $uid : 0;
        $sesid = (session('SessionID') != '' && session('SessionID') != '') ? $sesid[0] : 0;
        $Portals = PageClass::GetProtals($uid, $sesid);
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        $MyOrganGroups = '';
        if (session('MyOrganGroups')) {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $PgC = new PageClass();
        $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'proccess');
        $shortTools = $tools['abzar'];
        $tabs = json_encode($ret['tabs']);
        $tabs = json_decode($tabs);
        $MenuTools = toolsGenerator([6=>['uid'=>$uid,'sid'=>0]],1,5);
        return view('pages.Desktop.viewproc', array('MyOrganGroups' => $MyOrganGroups, 'SiteLogo' => $ret['SiteLogo'], 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
            'Title' => $ret['Title'], 'PageType' => 'desktop', 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
            'menu' => $ret['menu'], 'content' => $C, 'Files' => '', 'keywords' => '',
            'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $tabs, 'Tree' => $Tree, 'tools' => $shortTools, 'tools_menu' => $MenuTools));
    }

    static function ME($uid, $sesid, $uname, $Selected, $Tree) {
        $ret = DesktopClass::USER($uname);
        $SP = new \App\HamafzaServiceClasses\ProccesClass();
        $s = $SP->GetProcces($uid, $sesid);
        if (is_array($s))
            $C = ProccessGrids::Lists($s);
        else
            $C = $s;
        $Portals = PageClass::GetProtals($uid, $sesid);
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        $MyOrganGroups = '';
        if (session('MyOrganGroups')) {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $PgC = new PageClass();
        $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'proccess');
        $MenuTools =toolsGenerator([6=>['uid'=>$uid,'sid'=>0]],1,5);
        $shortTools = $tools['abzar'];
        return view('pages.Desktop', array('MyOrganGroups' => $MyOrganGroups, 'SiteLogo' => $ret['SiteLogo'], 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
            'Title' => $ret['Title'], 'PageType' => 'desktop', 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
            'menu' => $ret['menu'], 'content' => $C, 'Files' => '', 'keywords' => '',
            'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $ret['tabs'], 'Tree' => $Tree, 'tools' => $shortTools, 'tools_menu' => $MenuTools));
    }

    static function Add($uid, $sesid, $uname, $Selected, $Tree) {
        if (!Auth::check())
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        else {
            $Uname = (session('Uname') != '') ? session('Uname') : 0;
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $ret = DesktopClass::USER($uname);
            $SP = new \App\HamafzaServiceClasses\ProccesClass();
            $s = $SP->NewProccessData();
            $forms = $s['Forms'];
            $alerts = $s['Alerts'];
            $Porsesh = $s['Porsesh'];
            $Porsesh = json_encode($Porsesh);
            $Porsesh = json_decode($Porsesh);
            $alerts = json_encode($alerts);
            $alerts = json_decode($alerts);
            $forms = json_encode($forms);
            $forms = json_decode($forms);
            $C = 'ProccessAdd';
            $uid = session('uid');
            $sesid = session('SessionID');
            $uid = (session('uid') != '' && session('uid') != '') ? $uid : 0;
            $sesid = (session('SessionID') != '' && session('SessionID') != '') ? $sesid[0] : 0;
            $Portals = PageClass::GetProtals($uid, $sesid);
            $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
            $MyOrganGroups = '';
            if (session('MyOrganGroups')) {
                $MyOrganGroups = session('MyOrganGroups');
            }
            $PgC = new PageClass();
            $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'proccess');
            $MenuTools = toolsGenerator([6=>['uid'=>$uid,'sid'=>0]],1,5);
            $shortTools = $tools['abzar'];
            return view('pages.Desktop', array('MyOrganGroups' => $MyOrganGroups, 'SiteLogo' => $ret['SiteLogo'], 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
                'Title' => $ret['Title'], 'PageType' => 'desktop', 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
                'menu' => $ret['menu'], 'content' => $C, 'Files' => '', 'keywords' => '', 'forms' => $forms, 'alerts' => $alerts, 'Porsesh' => $Porsesh,
                'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $ret['tabs'], 'Tree' => $Tree, 'tools' => $shortTools, 'tools_menu' => $MenuTools));
        }
    }

}
