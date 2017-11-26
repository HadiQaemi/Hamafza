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
use App\HamafzaPublicClasses\GridClass;

class substclass {

    public static function subst_save($id, $first, $second, $uid) {
        if ($id != '0')
            DB::table('subst')->where('id', $id)->update(array('first' => $first, 'second' => $second));
        else {
            $data = DB::table('subst')->insert(array('first' => $first, 'second' => $second, 'uid' => $uid));
        }
        return Redirect()->back()->with('message', 'تغییرات انجام شد')->with('mestype', 'success');
    }

    public static function show() {
        $sr = (isset($_GET['sr']) && $_GET['sr']) ? $_GET['sr'] : '';
        $i = 1;
        if ($sr != '')
            $data = DB::table('subst')->select('id', 'first', 'second')->whereRaw("first like '%$sr%' or second like '%$sr%' ")->get();
        else
            $data = DB::table('subst')->select('id', 'first', 'second')->get();
        foreach ($data as $value) {
            $value->sortid = $i;
            $i++;
        }

        $GC = new GridClass();
        $GC->AddHidenCol("id", 'id');
        $GC->AddCol("عبارت", 'first', '80');
        $GC->AddCol("جایگزین", 'second', '80');
        $GC->AddColEdit('ویرایش', 'id', 'subst/edit?id=', '20', false, 'right');
        $GC->AddColDelete('حذف', 'id', 'SubSt', '20', false, 'right');
        $grid = $GC->Grid(json_encode($data));
        return ['content' => $grid];
    }

    public static function edit($pid) {
        $data = DB::table('subst')->select('id', 'first', 'second')->where('id', $pid)->first();
        $fist = ($data) ? $data->first : '';
        $second = ($data) ? $data->second : '';
        $res['pid'] = 'desktop';
        $res['id'] = $pid;
        $res['fist'] =$fist;
        $res['second'] = $second;
        return $res;
    }

    public static function add($uid, $sesid, $uname, $Selected, $Tree) {

        return View::make('pages.Desktop.subst', array('MyOrganGroups' => $MyOrganGroups, 'SiteLogo' => $ret['SiteLogo'], 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
                    'Title' => $ret['Title'], 'PageType' => 'desktop', 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
                    'menu' => $ret['menu'], 'id' => '0', 'fist' => $fist, 'second' => $second, 'Files' => '', 'keywords' => '',
                    'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $ret['tabs'], 'Tree' => $Tree, 'tools' => $shortTools, 'menutools' => $MenuTools));
    }

}
