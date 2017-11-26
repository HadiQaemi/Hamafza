<?php

namespace App\HamafzaViewClasses;

use Auth;
use App\HamafzaServiceClasses\KeywordsClass;
use Illuminate\Support\Facades\DB;
use App\HamafzaServiceClasses\PagesClass;
use App\HamafzaServiceClasses\UserClass;
use App\HamafzaGrids\KeywordGrids;

class KeywordClass {

   /* public static function keywords($sublink) {
        $uid = Auth::id();
        if ($sublink == 'add') {
            return KeywordClass::add($uid);
        } else {
            if (intval($sublink) != 0) {
                return KeywordClass::edit($uid);
            } else {
                if (UserClass::permission('newtag', $uid) == '1') {
                    $Ret = \App\Models\hamafza\Keyword::
                            with([
                                'subjects' => function($q) {
                                    return $q
                                        ->select('subjects.id');
                                },
                                'thesa' => function($q) {
                                    return $q
                                            ->select('subjects.title');
                                }])
                           ->get();
                    if (false) { view('pages.Desktop.keywords_list'); }
                    return array('viewname' => 'pages.Desktop.keywords_list', 'Ret' => $Ret, 'PageType' => 'desktop', 'pid' => 'desktop', 'content' => $Ret,);
                }
            }
        }
    }*/

    public static function edit($uid) {
        $ret = DesktopClass::USER($name);
        $SP = new service();
        // return 'Getkeyword_edit'. 'uid=' . $uid . '&sesid=' . $sesid . '&keyid='.$sublink;
        $menu = $SP->ServicePost('Getkeyword_edit', 'uid=' . $uid . '&sesid=' . $sesid . '&keyid=' . $sublink);
        $json_a = json_decode($menu, true);
        $s = $json_a['data'];
        $Err = $json_a['error'];
        if ($Err == true) {

            return Redirect::back()->with('message', $C)->with('mestype', 'error');
        } else {
            $menu = $SP->ServicePost('GetThesarus', 'uid=' . $uid . '&sesid=' . $sesid . '');

            $json_a = json_decode($menu, true);
            $thes = $json_a['data'];
            $Portals = PageClass::GetProtals($uid, $sesid);
            $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
            $MyOrganGroups = '';
            if (session('MyOrganGroups')) {
                $MyOrganGroups = session('MyOrganGroups');
            }
            $PgC = new PageClass();
            $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'SubjectType');
            $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);

            $shortTools = $tools['abzar'];
            return view('pages.Desktop.ADD.keyword_edit', array('PageType' => 'desktop', 'PageType' => 'desktop', 'SiteLogo' => $ret['SiteLogo'], 'MyOrganGroups' => $MyOrganGroups, 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
                'Title' => $ret['Title'], 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
                'menu' => $ret['menu'], 'keyword' => $s, 'Thesarus' => $thes, 'Files' => '', 'keywords' => '',
                'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $ret['tabs'], 'Tree' => $Tree, 'tools' => $shortTools, 'tools_menu' => $MenuTools));
        }
    }

    public static function modaledit($id) {
        if (!Auth::check()) {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        } else {
            $uid = Auth::id();
            $kid = $id;
            if (UserClass::permission('edittag', $uid) == '1') {
                $keyid1 = DB::table('keywords')->where('id', $kid)->first();
                $t = DB::table('thesaurus_keywords as kt')->join('subjects as p', 'p.id', '=', 'kt.subject_id')->where('keyword_id', $kid)->select('p.id', 'p.title')->get();
                $Rel1 = DB::table('keyword_relations as kr')->join('keywords as k', 'k.id', '=', 'kr.keyword_2_id')->where('keyword_1_id', $kid)->where('rel', 1)->select('k.id', 'k.title', 'kr.rel')->get();
                $Rel110 = DB::table('keyword_relations as kr')->join('keywords as k', 'k.id', '=', 'kr.keyword_1_id')->where('keyword_2_id', $kid)->where('rel', 1)->select('k.id', 'k.title', 'kr.rel')->get();
                $Rel3 = DB::table('keyword_relations as kr')->join('keywords as k', 'k.id', '=', 'kr.keyword_1_id')->where('keyword_1_id', $kid)->where('rel', 3)->select('k.id', 'k.title', 'kr.rel')->get();
                $Rel310 = DB::table('keyword_relations as kr')->join('keywords as k', 'k.id', '=', 'kr.keyword_1_id')->where('keyword_2_id', $kid)->where('rel', 3)->select('k.id', 'k.title', 'kr.rel')->get();
                $Rel5 = DB::table('keyword_relations as kr')->join('keywords as k', 'k.id', '=', 'kr.keyword_1_id')->where('keyword_1_id', $kid)->where('rel', 5)->select('k.id', 'k.title', 'kr.rel')->get();
                $Rel510 = DB::table('keyword_relations as kr')->join('keywords as k', 'k.id', '=', 'kr.keyword_1_id')->where('keyword_2_id', $kid)->where('rel', 5)->select('k.id', 'k.title', 'kr.rel')->get();
                $Rel7 = DB::table('keyword_relations as kr')->join('keywords as k', 'k.id', '=', 'kr.keyword_1_id')->where('keyword_1_id', $kid)->where('rel', 7)->select('k.id', 'k.title', 'kr.rel')->get();
                $Rel8 = DB::table('keyword_relations as kr')->join('keywords as k', 'k.id', '=', 'kr.keyword_1_id')->where('keyword_1_id', $kid)->where('rel', 8)->select('k.id', 'k.title', 'kr.rel')->get();
                $Rel12 = DB::table('keyword_relations as kr')->join('keywords as k', 'k.id', '=', 'kr.keyword_1_id')->where('keyword_1_id', $kid)->where('rel', 12)->select('k.id', 'k.title', 'kr.rel')->get();
                $Rel13 = DB::table('keyword_relations as kr')->join('keywords as k', 'k.id', '=', 'kr.keyword_1_id')->where('keyword_1_id', $kid)->where('rel', 13)->select('k.id', 'k.title', 'kr.rel')->get();
                $Rel21 = DB::table('keyword_relations as kr')->join('keywords as k', 'k.id', '=', 'kr.keyword_1_id')->where('keyword_1_id', $kid)->where('rel', 21)->select('k.id', 'k.title', 'kr.rel')->get();
                $Rel20 = DB::table('keyword_relations as kr')->join('keywords as k', 'k.id', '=', 'kr.keyword_1_id')->where('keyword_1_id', $kid)->where('rel', 20)->select('k.id', 'k.title', 'kr.rel')->get();
                $Rel9 = DB::table('keyword_relations as kr')->join('keywords as k', 'k.id', '=', 'kr.keyword_1_id')->where('keyword_1_id', $kid)->where('rel', 9)->select('k.id', 'k.title', 'kr.rel')->get();
                $Rel10 = DB::table('keyword_relations as kr')->join('keywords as k', 'k.id', '=', 'kr.keyword_1_id')->where('keyword_1_id', $kid)->where('rel', 10)->select('k.id', 'k.title', 'kr.rel')->get();
                $Rel11 = DB::table('keyword_relations as kr')->join('keywords as k', 'k.id', '=', 'kr.keyword_1_id')->where('keyword_1_id', $kid)->where('rel', 11)->select('k.id', 'k.title', 'kr.rel')->get();
                $keyid1->Rel1 = (count($Rel1) > 0) ? $Rel1 : array();
                $keyid1->Rel110 = (count($Rel110) > 0) ? $Rel110 : array();
                $keyid1->Rel3 = (count($Rel3) > 0) ? $Rel3 : array();
                $keyid1->Rel310 = (count($Rel310) > 0) ? $Rel310 : array();
                $keyid1->Rel5 = (count($Rel5) > 0) ? $Rel5 : array();
                $keyid1->Rel510 = (count($Rel510) > 0) ? $Rel510 : array();
                $keyid1->Rel7 = (count($Rel7) > 0) ? $Rel7 : array();
                $keyid1->Rel8 = (count($Rel8) > 0) ? $Rel8 : array();
                $keyid1->Rel12 = (count($Rel12) > 0) ? $Rel12 : array();
                $keyid1->Rel13 = (count($Rel13) > 0) ? $Rel13 : array();
                $keyid1->Rel20 = (count($Rel20) > 0) ? $Rel20 : array();
                $keyid1->Rel9 = (count($Rel9) > 0) ? $Rel9 : array();
                $keyid1->Rel10 = (count($Rel10) > 0) ? $Rel10 : array();
                $keyid1->Rel11 = (count($Rel11) > 0) ? $Rel11 : array();
                $keyid1->Thesarus = $t;
                $keyid1 = json_encode($keyid1, true);
                $keyid1 = json_decode($keyid1);
                return view('modals.editkeyword', array('keyword' => $keyid1));
            } else {
                return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
            }
        }
    }

    public static function add($name, $uid, $sesid, $Selected, $Tree, $sublink) {
        $ret = DesktopClass::USER($name);
        $SP = new service();
        $menu = $SP->ServicePost('GetThesarus', 'uid=' . $uid . '&sesid=' . $sesid . '');
        $json_a = json_decode($menu, true);
        $s = $json_a['data'];
        $Err = $json_a['error'];
        if ($Err == true) {

            return Redirect::back()->with('message', $C)->with('mestype', 'error');
        } else {
            $thes = $s;
            $uid = session('uid');

            $sesid = '';
            $uid = (session('uid') != '') ? $uid : 0;
            $Portals = PageClass::GetProtals($uid, $sesid);
            $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
            $MyOrganGroups = '';
            if (session('MyOrganGroups')) {
                $MyOrganGroups = session('MyOrganGroups');
            }
            $PgC = new PageClass();
            $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'SubjectType');
            $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
            $shortTools = $tools['abzar'];
            return view('pages.Desktop.ADD.keyword', array('PageType' => 'desktop', 'PageType' => 'desktop', 'SiteLogo' => $ret['SiteLogo'], 'MyOrganGroups' => $MyOrganGroups, 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
                'Title' => $ret['Title'], 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
                'menu' => $ret['menu'], 'content' => '', 'Thesarus' => $thes, 'Files' => '', 'keywords' => '',
                'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $ret['tabs'], 'Tree' => $Tree, 'tools' => $shortTools, 'tools_menu' => $MenuTools));
        }
    }

    public static function view($uid) {
        
    }

    public function AddThesaurus($uid, $session_id, $name, $edit, $id) {
        $SP = new service();
        //return 'AddThesaurus'. 'uid=' . $uid . '&sesid=' . $session_id . '&name=' . $name.'&edit='.$edit.'&id='.$id;
        $data = $SP->ServicePost('AddThesaurus', 'uid=' . $uid . '&sesid=' . $session_id . '&name=' . $name . '&edit=' . $edit . '&id=' . $id);
        $json_a = json_decode($data, true);
        $s = $json_a['data'];
        return $s;
    }

    public static function GetPublicKeyword() {
        $uid = Auth::id();
        $sesid = 0;
        $SP = new KeywordsClass();
        $data = $SP->GetPublicKeyword($uid, $sesid);
        $s = json_encode($data);
        $s = json_decode($s, true);
        $PC = new PublicClass();
        if (is_array($s)) {
            $e = array();
            foreach ($s as $value) {
                $d['id'] = $value['id'];
                $d['text'] = $value['text'];
                $d['parent_id'] = '#';
                array_push($e, $d);
            }
            $newtree = $PC->CretaeTree1L($e, 'id', 'parent_id', 'text');
            $newtree = $PC->Json(0, $newtree);
        } else {
            $newtree = '';
        }
        return $newtree;
    }

    public static function Thesarus($name, $uid, $sesid, $Tree, $sublink) {
        if (session('uid') != '') {
            $uid = session('uid');
            $sesid = session('SessionID');
        } else {
            $uid = '0';
            $sesid = '0';
        }
        if ($sublink == '') {
            return KeywordClass::Thes_show($uid, $sesid, $name, '', $Tree);
        } else {
            if (isset($_GET['id']) && isset($_GET['name']) && $_GET['id'] != '') {
                $id = $_GET['id'];
                $names = $_GET['name'];
                return KeywordClass::Thes_Sublink($uid, $sesid, $name, '', $Tree, $sublink, $id, $names);
            } else {
                return KeywordClass::Thes_Sublink($uid, $sesid, $name, '', $Tree, $sublink, 0, '');
            }
        }
    }

    private static function Thes_Sublink($uid, $sesid, $uname, $Selected, $Tree, $sublink, $id = 0, $names = '') {
        $ret = DesktopClass::USER($uname);
        $SP = new service();
        $C = 'thesarusadd';
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
        $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'thesarus');
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
        $shortTools = $tools['abzar'];

        return view('pages.Desktop', array('id' => $id, 'name' => $names, 'MyOrganGroups' => $MyOrganGroups, 'SiteLogo' => $ret['SiteLogo'], 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
            'Title' => $ret['Title'], 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
            'menu' => $ret['menu'], 'content' => $C, 'Files' => '', 'keywords' => '',
            'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $ret['tabs'], 'Tree' => $Tree, 'tools' => $shortTools, 'tools_menu' => $MenuTools));
    }

    private static function Thes_show($uid, $sesid, $uname, $Selected, $Tree) {
        $ret = DesktopClass::USER($uname);
        $SP = new service();
        $menu = $SP->ServicePost('GetThesarus', '');
        $json_a = json_decode($menu, true);
        $s = $json_a['data'];
        $Err = $json_a['error'];
        if (is_array($s)) {
            $C = KeywordGrids::ThesarusGrids($s);
        } else {
            $C = $s;
        }

        if ($Err == true) {

            return Redirect::back()->with('message', $C)->with('mestype', 'error');
        } else {
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
            $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'thesarus');
            $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
            $shortTools = $tools['abzar'];

            return view('pages.Desktop', array('MyOrganGroups' => $MyOrganGroups, 'SiteLogo' => $ret['SiteLogo'], 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
                'Title' => $ret['Title'], 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
                'menu' => $ret['menu'], 'content' => $C, 'Files' => '', 'keywords' => '',
                'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $ret['tabs'], 'Tree' => $Tree, 'tools' => $shortTools, 'tools_menu' => $MenuTools));
        }
    }

}
