<?php
namespace App\HamafzaViewClasses;
use App\HamafzaGrids\MeasureDataGrid;
use App\HamafzaServiceClasses\UserClass;
use App\HamafzaServiceClasses\KeywordsClass;
use Illuminate\Support\Facades\DB;
use App\HamafzaServiceClasses\PagesClass;
use App\HamafzaServiceClasses\DesktopsClass;
use Auth;

class Measure {

    public  function user_measures_show($uid, $mid, $sesid) {
       $SP = new \App\HamafzaServiceClasses\MeasureClass();
        $s = $SP->user_measures_show($uid, $mid);
        return $s;
    }
    
    public static function SelectType($uname, $Selected, $Tree,$sel='') {
        $uid = (session('uid') != '') ? session('uid') : 0;
        $sesid = (session('sesid') != '') ? session('sesid') : 0;
        return Measure::ME($uid, $sesid, $uname, $Selected, $Tree,$sel);
    }

    static function ME($uid, $sesid, $uname, $Selected, $Tree,$sel) {
        if (!Auth::check())
            return Redirect()->back()->with('message', 'عدم دسترسی')->with('mestype', 'error');
        else {
            $finish1 = "";
            $finish0 = "";
            $finish3 = "";
            $finish2 = "";
            $sels = explode(',', $sel);
            $emptyRemoved = array_diff($sels, array(NULL));
            foreach ($sels as $key) {
                 if ($key =="'1'")
                    $finish1 = "checked";
                elseif ($key == "'0'")
                    $finish0 = "checked";
                elseif ($key == "'3'")
                    $finish3 = "checked";
                 elseif ($key == "'2'")
                    $finish2 = "checked";
            }
            $sel = implode(',', $emptyRemoved);
            
            $ret = DesktopClass::USER($uname);
            $DC = new DesktopsClass();
            if($sel==''){
                                $sel="'0'";
 $finish0 = "'0'";
            }
            $s = $DC->Measure($uid, $Selected, $sel);
            $C = '';
            if ($Selected == 'Fme')
                $C = MeasureDataGrid::ME2($s);
            else
                $C = MeasureDataGrid::ME($s);
            $uid = (session('uid') != '' && session('uid') != '') ? session('uid') : 0;
            $sesid = (session('SessionID') != '' && session('SessionID') != '') ? session('SessionID') : 0;
            $Portals = PageClass::GetProtals($uid, $sesid);
            $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
            $MyOrganGroups = '';
            if (session('MyOrganGroups')) {
                $MyOrganGroups = session('MyOrganGroups');
            }
            $PgC = new PageClass();
            $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'measure');
            $MenuTools = toolsGenerator([6=>['uid'=>$uid,'sid'=>0]],1,5);
            $shortTools = $tools['abzar'];
            if ($Selected == 'ME' || $Selected == 'Fme') {
                return view('pages.Desktop.messuare', array('MyOrganGroups' => $MyOrganGroups, 'PType' => $Selected, 'SiteLogo' => $ret['SiteLogo'], 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
                    'finish1' => $finish1, 'finish0' => $finish0, 'finish3' => $finish3, 'finish2' => $finish2, 'Title' => $ret['Title'], 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
                    'menu' => $ret['menu'], 'content' => $C, 'Files' => '', 'keywords' => '', 'PageType' => 'desktop',
                    'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $ret['tabs'], 'Tree' => $Tree, 'tools' => $shortTools, 'tools_menu' => $MenuTools));
            } else
                return view('pages.Desktop', array('MyOrganGroups' => $MyOrganGroups, 'SiteLogo' => $ret['SiteLogo'], 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
                    'Title' => $ret['Title'], 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
                    'menu' => $ret['menu'], 'content' => $C, 'Files' => '', 'keywords' => '', 'PageType' => 'desktop',
                    'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $ret['tabs'], 'Tree' => $Tree, 'tools' => $shortTools, 'tools_menu' => $MenuTools));
        }
    }

    static function ME2($uid, $sesid, $uname, $Selected, $Tree) {
        $ret = DesktopClass::USER($uname);
        $SP = new service();
        $menu = $SP->ServicePost('Measure', 'uid=' . $uid . '&sesid=' . $sesid . '&type=' . $Selected);
        $json_a = json_decode($menu, true);
        $s = $json_a['data'];

        $C = json_encode($s, true);

        return View::make('pages.Desktop2', array('SiteLogo' => $ret['SiteLogo'], 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
                    'Title' => $ret['Title'], 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
                    'menu' => $ret['menu'], 'content' => $C, 'Files' => '', 'keywords' => '',
                    'tabs' => $ret['tabs'], 'Tree' => $Tree, 'tools' => $ret['tools'], 'tools_menu' => ''));
    }

}
