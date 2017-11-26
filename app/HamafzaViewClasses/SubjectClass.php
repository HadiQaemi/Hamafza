<?php

namespace App\HamafzaViewClasses;

use App\HamafzaGrids\SubjectGrids;
use App\Models\hamafza\SubjectType;
use App\Policies\SubjectPolicy;
use App\Policies\ToolPolicy;
use Illuminate\Support\Facades\DB;
use App\HamafzaServiceClasses\UserClass;
use App\HamafzaServiceClasses\SubjectsClass;
use Auth;

class SubjectClass
{

    public static function notification($id)
    {
        $mes = DB::table('emails')->where('id', $id)->first();
        $minus = 'no';

        if ($mes)
        {
            $co = session('DesktopNotificaton');
            $co = $co * 1;
            $mes->sendate = \Morilog\Jalali\jDate::forge($mes->sendate)->format('%Y/%m/%d');
            if ($mes->read == '0')
            {
                $co--;
                Session::put('DesktopNotificaton', $co);
                $minus = 'yes';
            }
        }
        DB::table('emails')->where('id', $id)->update(array('read' => '1'));

        return view('modals.notification', array('Not' => $mes, 'minus' => $minus));
    }

    public static function history($sid, $pid, $type)
    {
        $s1 = DB::table('subjects as s')->leftjoin('pages as p', 'p.sid', '=', 's.id')
            ->leftjoin('user as u', 's.admin', '=', 'u.id')
            ->where('p.id', $pid)->select(DB::Raw('0 as part,0 as id,s.admin,s.reg_date as edit_date,"ایجاد صفحه" as name,u.Name, u.Family'))->get();
        $s = DB::table('history as h')
            ->leftjoin('edit_com as e', 'h.edit', '=', 'e.id')
            ->leftjoin('user as u', 'h.admin', '=', 'u.id')
            ->where('h.pid', $pid)->orderBy('h.edit_date', 'DESC')
            ->select('h.id', 'h.admin', 'h.part', 'h.edit_date', 'e.name', 'u.Name', 'u.Family', 'u.Uname')
            ->get();
        //$s= array_merge($s1, $s);
        foreach ($s1 as $i)
            $i->edit_date = \Morilog\Jalali\jDate::forge($i->edit_date)->format('H:i:s %Y/%m/%d ');

        foreach ($s as $i)
            $i->edit_date = \Morilog\Jalali\jDate::forge($i->edit_date)->format('H:i:s %Y/%m/%d ');

        return view('modals.history', array('H' => $s, 'H1' => $s1, 'sid' => $sid, 'pid' => $pid));
    }

    public static function MyPages($type)
    {
        $uid = Auth::id();
        $s = SubjectsClass::GetMypage($uid, $type);
        $c = $s;// SubjectGrids::Page($s);
        $ptype = 'me';
        $precoe = (config('constants.AllowPreCode')) ? url('/') . '/' . config('constants.PreCode') . '-' : url('/') . '/';
        return
            [
                'viewname' => 'pages.Desktop.showpages',
                'PageType' => 'desktop',
                'sid' => $uid,
                'precoe' => $precoe,
                'current_tab' => 'desktop',
                'ptype' => $ptype,
                'pname' => $type,
                'content' => $c
            ];
    }

    public static function ADDFilm($uid, $sesid, $films, $pics, $PreTitle, $Title, $Desce, $pid, $Time)
    {
        $SP = new service();
        $menu = $SP->ServicePost('ADDPageFilm', 'uid=' . $uid . '&sesid=' . $sesid . '&films=' . $films . '&pics=' . $pics
            . '&PreTitle=' . $PreTitle . '&Title=' . $Title . '&Desce=' . $Desce . '&pid=' . $pid . '&Time=' . $Time
        );
//       return  'ADDPageFilm'. 'uid=' . $uid . '&sesid=' . $sesid . '&films=' . $films . '&pics=' . $pics
//                . '&PreTitle=' . $PreTitle . '&Title=' . $Title . '&Desce=' . $Desce. '&pid=' . $pid.'&Time='.$Time;
        $json_a = json_decode($menu, true);
        $s = $json_a['data'];
        $Err = $json_a['error'];
        if ($Err == true)
        {

            return Redirect::back()->with('message', $s)->with('mestype', 'error');
        }
        else
        {
            return Redirect::back()->with('message', $s)->with('mestype', 'success');
        }
    }

    public static function ADDSLIDE($uid, $sesid, $files, $pid)
    {
        $SP = new service();
        $menu = $SP->ServicePost('ADDPageSlide', 'uid=' . $uid . '&sesid=' . $sesid . '&files=' . $files . '&pid=' . $pid);
        // return  'ADDPageSlide'. 'uid=' . $uid . '&sesid=' . $sesid . '&files='.$files.'&pid='.$pid;
        $json_a = json_decode($menu, true);
        $s = $json_a['data'];
        $Err = $json_a['error'];
        if ($Err == true)
        {

            return Redirect::back()->with('message', $s)->with('mestype', 'error');
        }
        else
        {
            return Redirect::back()->with('message', $s)->with('mestype', 'success');
        }
    }

    public static function ViewSubject($type, $id)
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
        $P = new SubjectsClass();
        $s = $P->ViewSubjects($uid, $sesid, $type, $id);
        $C = SubjectGrids::ModalSubView($s);
        return view('modals.viewsubjects', array('Subjects' => $C));
    }

    public static function delete($sid, $pid, $type)
    {
        if (session('SubjectArchive') != '')
        {
            $SubjectArchive = session('SubjectArchive');
            $SubjectArchive = $SubjectArchive[0];
        }
        return view('modals.delete', array('SubjectArchive' => $SubjectArchive, 'pid' => $pid, 'sid' => $sid));
    }

    public static function announce($sid, $pid, $type, $title, $alamat, $select)
    {
        $sid = is_numeric($sid) ? $sid : 0;
        $pid = is_numeric($pid) ? $pid : 0;
        return view('modals.announce', array('pid' => $pid, 'sid' => $sid, 'type' => $type, 'title' => $title, 'alamat' => $alamat, 'select' => $select));
    }

    public static function subjectPrint($sid, $pid)
    {
        $SP = new \App\HamafzaServiceClasses\PageClass();
        $menu = $SP->subjectPrint('1', $pid, $sid, $pid);
        $print = $menu['print'];
        $tabs = $menu['tabs'];
        $tabs = json_encode($tabs);
        $tabs = json_decode($tabs);
        return view('modals.print', array('print' => $print, 'tabs' => $tabs, 'sid' => $sid, 'pid' => $pid));
    }

    public static function subjectExport($sid, $pid)
    {
        $SP = new \App\HamafzaServiceClasses\PageClass();
        $menu = $SP->subjectExport($pid, $sid);
        $menu = json_encode($menu);
        $menu = json_decode($menu);
        return view('modals.export', array('tabs' => $menu, 'sid' => $sid, 'pid' => $pid));
    }

    public static function newsubject($uid, $sesid)
    {
        if (auth()->check())
        {
            $res_policy = policy_CanView('', '', '\App\Policies\SubjectPolicy', 'canAddSubject');
            if (!$res_policy)
            {
                return "شما به ابزار ایجاد صفحه جدید دسترسی ندارید!";
            }

            $PermittedPersonalSubjectTypes = PermittedPersonalSubjectTypes();
            $PermittedOfficialSubjectTypes = PermittedOfficialSubjectTypes();

            if (!count($PermittedPersonalSubjectTypes)>0)
            {
                $subject_type_policies_personal_check = false;
            }
            else
            {
                $subject_type_policies_personal_check = true;
            }

            if (!count($PermittedOfficialSubjectTypes)>0)
            {
                $subject_type_policies_Official_check = false;
            }
            else
            {
                $subject_type_policies_Official_check = true;
            }
            $arr =
                [
                    'user' => auth()->user(),
                    'OfficialSubjects' => $PermittedOfficialSubjectTypes,
                    'PersonalSubjects' => $PermittedPersonalSubjectTypes,
                    'subject_type_policies_personal_check' => $subject_type_policies_personal_check,
                    'subject_type_policies_Official_check' => $subject_type_policies_Official_check
                ];
            return view('hamahang.Subjects.new_subject_modals.content', $arr)->render();

        }
        else
        {
            $alert = 'برای دسترسی به این قسمت نیاز به عضویت دارید';
            $alerts = DB::table('function_alert as f')->join('alerts as a', 'a.id', '=', 'f.alertid')->where("functionname", 'LoginPop')->select('a.comment')->first();
            if ($alerts)
            {
                $alert = $alerts->comment;
            }
            return view('modals.mustlogin', array('alert' => $alert))->render();
        }

//        $SP = new \App\HamafzaServiceClasses\ConfigurationClass();
//        $Subjects = $SP->GetAsubjects($uid);
//        if (is_array($Subjects))
//        {
//            $publicSubjects = $Subjects['public'];
//            $privateSubjects = $Subjects['private'];
//            $arrayStr = '';
//            $allow = true;
//            $prCount = count($privateSubjects);
//            $publicSubjects = json_encode($publicSubjects);
//            $publicSubjects = json_decode($publicSubjects);
//            $privateSubjects = json_encode($privateSubjects);
//            $privateSubjects = json_decode($privateSubjects);
//            $pbCount = count($publicSubjects);
//            if ($prCount == 0 && $pbCount == 0)
//            {
//                $allow = false;
//            }
//            return view('modals.newsubject', array('publicSubjects' => $publicSubjects, 'privateSubjects' => $privateSubjects, 'allow' => $allow, 'prCount' => $prCount, 'pbCount' => $pbCount))->render();
//        }
//        else
//        {
//
//        }
    }

    public static function relations_add($uname)
    {
        $uid = Auth::id();
        $PageType = 'desktop';
        return ['viewname' => 'pages.Desktop.ADD.addrelations', 'i' => 1,
            'PageType' => $PageType, 'uname' => $uname, 'pid' => 'desktop',
            'sid' => $uid, 'content' => '', 'Files' => ''
        ];
    }

    public static function relations_edit($uname, $id)
    {
        $uid = Auth::id();
        $sublink = intval($id);
        $relation = \App\Models\hamafza\Relations::find($sublink);
        $PageType = 'desktop';
        return ['viewname' => 'pages.Desktop.editrelations', 'i' => 1, 'relation' => $relation,
            'PageType' => $PageType, 'uname' => $uname, 'pid' => 'desktop',
            'sid' => $uid, 'content' => '', 'Files' => ''
        ];
    }

    public static function subjects_edit($uname, $id)
    {
        $uid = Auth::id();
        if (UserClass::permission('subjects', $uid) == '1')
        {
            $sublink = intval($id);
            $SP = new \App\HamafzaServiceClasses\ConfigurationClass();
            $s = $SP->GetSubjetData($uid, 0);
            $Fileds = $s['Fileds'];
            $Fileds = json_encode($Fileds);
            $Fileds = json_decode($Fileds);
            $Process = $s['Process'];
            $Process = json_encode($Process);
            $Process = json_decode($Process);
            $Alerts = json_encode($s['Alerts']);
            $Alerts = json_decode($Alerts);
            $SecGroups = json_encode($s['SecGroups']);
            $SecGroups = json_decode($SecGroups);
            $Framework = json_encode($s['Framework']);
            $Framework = json_decode($Framework);
            $Departments = json_encode($s['Portals']);
            $Departments = json_decode($Departments);
            $SP = new \App\HamafzaServiceClasses\ConfigurationClass();
            $ST = $SP->SubjectTypeEdit($sublink);
            $ST = json_encode($ST);
            $ST = json_decode($ST);
            $FC = new \App\HamafzaServiceClasses\FormsClass();
            $FieldType = $FC->FiledType();
            $PageType = 'desktop';
            $subject_type = SubjectType::find($ST->id);

            return [
                'viewname' => 'pages.Desktop.editsubtype',
                'i' => 1,
                'FieldType' => $FieldType,
                'ST' => $ST,
                'PageType' => $PageType,
                'uname' => $uname,
                'pid' => 'desktop',
                'sid' => $uid,
                'content' => '',
                'Files' => '',
                'Alerts' => $Alerts,
                'Fileds' => $Fileds,
                'SecGroup' => $SecGroups,
                'Framework' => $Framework,
                'Process' => $Process,
                'Departments' => $Departments,
                'Process' => $Process,
                'subject_type' => $subject_type,
            ];
        }

    }

    public static function Asubjects($uname, $uid, $sublink)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            if (UserClass::permission('subjects', $uid) == '1')
            {
                $ret = DesktopClass::USER($uname);
                $Err = false;
                if ($sublink == '')
                {
                    $SP = new \App\HamafzaServiceClasses\ConfigurationClass();
                    $s = $SP->GetSubjectType($uid, 0);
                    $C = SubjectGrids::SubjectLists($s);
                }
                elseif ($sublink == 'asubadd')
                {
                    $C = SubjectClass::AsubjectAdd($uname, $uid, 0, '');
                }
                else
                {
                    $sublink = intval($sublink);
                    $SP = new \App\HamafzaServiceClasses\ConfigurationClass();
                    $s = $SP->GetSubjetData($uid, 0);
                    $Fileds = $s['Fileds'];
                    $Fileds = json_encode($Fileds);
                    $Fileds = json_decode($Fileds);
                    $Process = $s['Process'];
                    $Process = json_encode($Process);
                    $Process = json_decode($Process);
                    $Alerts = json_encode($s['Alerts']);
                    $Alerts = json_decode($Alerts);
                    $SecGroups = json_encode($s['SecGroups']);
                    $SecGroups = json_decode($SecGroups);
                    $Framework = json_encode($s['Framework']);
                    $Framework = json_decode($Framework);
                    $Departments = json_encode($s['Portals']);
                    $Departments = json_decode($Departments);
                    $MyOrganGroups = '';
                    if (session('MyOrganGroups'))
                    {
                        $MyOrganGroups = session('MyOrganGroups');
                    }
                    $SP = new \App\HamafzaServiceClasses\ConfigurationClass();
                    $ST = $SP->SubjectTypeEdit($sublink);
                    $ST = json_encode($ST);
                    $ST = json_decode($ST);
                    $tabparam['Uname'] = $uname;
                    $tabparam['cuid'] = $uid;
                    $tabparam['uid'] = $uid;
                    $tabs = json_decode(json_encode(PageTabs('userpage', $tabparam)));
                    $FC = new \App\HamafzaServiceClasses\FormsClass();
                    $FieldType = $FC->FiledType();
                    $PageType = 'desktop';
                    $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
                    return ['viewname' => 'pages.Desktop.editsubtype', 'i' => 1, 'FieldType' => $FieldType, 'ST' => $ST, 'MyOrganGroups' => $MyOrganGroups,
                        'PageType' => $PageType, 'Title' => $ret['Title'], 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
                        'sid' => $uid, 'menu' => $ret['menu'], 'content' => '', 'Files' => '', 'keywords' => '',
                        'Alerts' => $Alerts, 'Fileds' => $Fileds, 'SecGroup' => $SecGroups, 'Framework' => $Framework, 'Process' => $Process, 'Departments' => $Departments, 'Process' => $Process, 'tabs' => $tabs];
                }


                if ($Err == true)
                {

                    return Redirect::back()->with('message', $C)->with('mestype', 'error');
                }
                else
                {
                    $sesid = '';
                    $MyOrganGroups = '';
                    if (session('MyOrganGroups'))
                    {
                        $MyOrganGroups = session('MyOrganGroups');
                    }
                    $tabparam['Uname'] = $uname;
                    $tabparam['cuid'] = $uid;
                    $tabparam['uid'] = $uid;
                    $tabs = PageTabs('userpage', $tabparam);
                    return ['viewname' => 'pages.Desktop', 'MyOrganGroups' => $MyOrganGroups, 'sid' => $uid,
                        'Title' => $ret['Title'], 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
                        'PageType' => 'user', 'content' => $C, 'Files' => '', 'keywords' => '',
                        'tabs' => $tabs];
                }
            }
            else
            {
                return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
            }
        }
    }


    public static function SubjectShow($uname, $uid, $sesid, $Tree, $sublink)
    {
        if (UserClass::permission('subjects', $uid) == '1')
        {
            $sublink = intval($sublink);
            $SP = new \App\HamafzaServiceClasses\ConfigurationClass();
            $s = $SP->GetSubjetData($uid, $sesid);
            $Fileds = $s['Fileds'];
            $Fileds = json_encode($Fileds);
            $Fileds = json_decode($Fileds);
            $Process = $s['Process'];
            $Process = json_encode($Process);
            $Process = json_decode($Process);
            $Alerts = json_encode($s['Alerts']);
            $Alerts = json_decode($Alerts);
            $SecGroups = json_encode($s['SecGroups']);
            $SecGroups = json_decode($SecGroups);
            $Framework = json_encode($s['Framework']);
            $Framework = json_decode($Framework);
            $Departments = json_encode($s['Portals']);
            $Departments = json_decode($Departments);
            $MyOrganGroups = '';
            if (session('MyOrganGroups'))
            {
                $MyOrganGroups = session('MyOrganGroups');
            }
            $SP = new \App\HamafzaServiceClasses\ConfigurationClass();
            $ST = $SP->SubjectTypeEdit($sublink);
            $ST = json_encode($ST);
            $ST = json_decode($ST);
            return ['ST' => $ST, 'Alerts' => $Alerts, 'Fileds' => $Fileds, 'SecGroup' => $SecGroups, 'Framework' => $Framework, 'Process' => $Process, 'Departments' => $Departments, 'Process' => $Process, 'tabs' => $tabs];
        }
        else
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
    }


    public static function AsubjectAdd($uname, $uid, $sesid, $Tree)
    {

        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            //dd('sss');
            $ret = DesktopClass::USER($uname);
            $SP = new \App\HamafzaServiceClasses\ConfigurationClass();
            $s = $SP->GetSubjetData($uid, $sesid);
            //$Portals = PageClass::GetProtals($uid, $sesid);
            //$keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
            $MyOrganGroups = '';
            if (session('MyOrganGroups'))
            {
                $MyOrganGroups = session('MyOrganGroups');
            }
            $FC = new \App\HamafzaServiceClasses\FormsClass();
            $FieldType = $FC->FiledType();
            $PgC = new PageClass();
            //$tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'thesarus');
            //$shortTools = $tools['abzar'];
            $Fileds = $s['Fileds'];
            $Fileds = json_encode($Fileds);
            $Fileds = json_decode($Fileds);
            $Process = $s['Process'];
            $Process = json_encode($Process);
            $Process = json_decode($Process);
            $Alerts = json_encode($s['Alerts']);
            $Alerts = json_decode($Alerts);
            $SecGroups = json_encode($s['SecGroups']);
            $SecGroups = json_decode($SecGroups);
            $Framework = json_encode($s['Framework']);
            $Framework = json_decode($Framework);
            $Departments = json_encode($s['Portals']);
            $Departments = json_decode($Departments);
            $uid = session('uid');
            $sesid = '';
            $uid = (session('uid') != '') ? $uid : 0;
            //$Portals = PageClass::GetProtals($uid, $sesid);
            //$keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
            $tabs = json_encode($ret['tabs']);
            $tabs = json_decode($tabs);
            $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
            return view('pages.Desktop.ADD.AsubjectADD', [
                    'FieldType' => $FieldType,
                    'MyOrganGroups' => $MyOrganGroups,
                    'SiteLogo' => $ret['SiteLogo'],
                    'SiteTitle' => $ret['SiteTitle'],
                    'Title' => $ret['Title'],
                    'PageType' => 'desktop',
                    'Small' => $ret['Small'],
                    'uname' => $ret['uname'],
                    'pid' => 'desktop',
                    'sid' => $uid,
                    'menu' => $ret['menu'],
                    'content' => '',
                    'Files' => '',
                    'keywords' => '',
                    'Alerts' => $Alerts,
                    'Fileds' => $Fileds,
                    'SecGroup' => $SecGroups,
                    'Framework' => $Framework,
                    'Process' => $Process,
                    'Departments' => $Departments,
                    'Process' => $Process,
                    //'keywordTab' => $keywordTab,
                    'tabs' => $tabs,
                    'Tree' => $Tree,
                    //'tools' => $shortTools,
                    'tools_menu' => $MenuTools]
            );
        }
    }

}
