<?php

namespace App\HamafzaServiceClasses;

use App\Models\hamafza\SubjectType;
use Illuminate\Support\Facades\DB;
use App\Models\subjectKey;
use App\HamafzaViewClasses\PublicClass;

class ConfigurationClass
{

    public function endorse()
    {
        $type = Input::get('type');
        $spid = Input::get('spid');
        $uid = Input::get('uid');
        $sesid = Input::get('sesid');
        $TC = new ToolsClass();
        return $TC->endorse($uid, $sesid, $type, $spid);
    }

    public function Ostan()
    {
        $TC = new ToolsClass();
        return $TC->Ostan();
    }

    public function deletesubject()
    {
        $sid = Input::get('sid');
        $type = Input::get('type');
        $uid = Input::get('uid');
        $sesid = Input::get('sesid');
        $TC = new ToolsClass();
        return $TC->deletesubject($uid, $sesid, $type, $sid);
    }

    public function Bookmark()
    {
        $title = Input::get('title');
        $tid = Input::get('tid');
        $type = Input::get('type');
        $uid = Input::get('uid');
        $sesid = Input::get('sesid');
        $TC = new ToolsClass();
        return $TC->Bookmark($uid, $sesid, $title, $type, $tid);
    }

    public function highlight()
    {
        $text = Input::get('text');
        $uid = Input::get('uid');
        $sesid = Input::get('sesid');
        $pid = Input::get('pid');
        $TC = new ToolsClass();
        return $TC->highlight($uid, $sesid, $text, $pid);
    }

    /*public function AnnounceAdd($uid, $sesid, $title, $about, $comment, $alamat, $moarefi, $naghallow, $select, $naghl, $bookpage, $keywords, $pid)
    {
        $select = ($select == '') ? ' ' : $select;
        $bookpage = ($bookpage == '') ? 0 : $bookpage;
        $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
        if ($about != 'on')
        {
            $pid = 0;
        }
        $work = DB::table('announces')->insertGetId(
            array('pid' => $pid, 'uid' => $uid, 'quote' => $select, 'title' => $title, 'comment' => $comment
            , 'reg_date' => $reg_date, 'mostaghim' => $naghl, 'bookpage' => $bookpage)
        );
        $myArray = explode(',', $keywords);
        $myArray = json_encode($myArray);
        $myArray = json_decode($myArray);

        foreach ($myArray as &$value)
        {
            DB::table('announce_keys')->insert(
                array('ann_id' => $work, 'key_id' => $value)
            );
        }

        if ($alamat == 'on')
        {
            $work = DB::table('highlights')->insertGetId(
                array('pid' => $pid, 'uid' => $uid, 'quote' => $select, 'type' => '1', 'reg_date' => $reg_date));
        }
        $mes = trans('labels.ann_ok');
        return $mes;
    }*/

    public static function saveNewForm($uid, $sesid, $form_id, $field, $type, $pid, $sid)
    {
        $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
        $cn = DB::table('forms')->where('id', $form_id)->select('onereport')->first();
        $cns = ($cn) ? $cn->onereport : 0;
        if ($cns == 1)
        {
            $n = DB::table('forms_report')
                ->where('uid', $uid)->where('form_id', $form_id)->count();
            if ($n == 0)
            {
                $Forms = DB::table('forms_report')->insertGetId(array('uid' => $uid, 'form_id' => $form_id, 'pid' => $pid,
                    'sid' => $sid, 'ppsid' => '0', 'reg_date' => $reg_date, 'publish' => '1'));

                foreach ($field as $key => $value)
                {
                    DB::table('forms_report_value')->insertGetId(array('report_id' => $Forms, 'field_id' => $key, 'field_value' => $value));
                }
            }
            else
            {
                DB::table('forms_report')
                    ->where('uid', $uid)->where('form_id', $form_id)->delete();
                $Forms = DB::table('forms_report')->insertGetId(array('uid' => $uid, 'form_id' => $form_id, 'pid' => $pid,
                    'sid' => $sid, 'ppsid' => '0', 'reg_date' => $reg_date, 'publish' => '1'));

                foreach ($field as $key => $value)
                {
                    DB::table('forms_report_value')->insertGetId(array('report_id' => $Forms, 'field_id' => $key, 'field_value' => $value));
                }
            }
        }
        else
        {
            $Forms = DB::table('forms_report')->insertGetId(array('uid' => $uid, 'form_id' => $form_id, 'pid' => $pid,
                'sid' => $sid, 'ppsid' => '0', 'reg_date' => $reg_date, 'publish' => '1'));
            foreach ($field as $key => $value)
            {
                DB::table('forms_report_value')->insertGetId(array('report_id' => $Forms, 'field_id' => $key, 'field_value' => $value));
            }
        }

        return 'اطلاعات شما ثبت گردید.';
    }

    public static function saveForm($uid, $sesid, $form_id, $field, $type, $pid, $sid, $rpid)
    {
        $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
        $Forms = DB::table('forms_report')->where('id', $rpid)->update(array('reg_date' => $reg_date, 'publish' => '1'));
        DB::table('forms_report_value')->where('report_id', $rpid)->delete();
        foreach ($field as $key => $value)
        {
            DB::table('forms_report_value')->insertGetId(array('report_id' => $rpid, 'field_id' => $key, 'field_value' => $value));
        }
        return 'اطلاعات شما ثبت گردید.';
    }

    public function GetUserSecurityDetail($uid, $id)
    {
        $Ret['SecGroups'] = DB::table('sec_groups')->where('id', $id)->select('id', 'name', 'defualt', 'descr')->first();
        $i = 1;
        $ST = DB::table('access as a')
            ->leftJoin('tools_group as t', 't.id', '=', 'a.type')
            ->select(DB::Raw("a.id, a.name ,t.name as gname,a.Fname"))->where('group', '1')->orderby('gname')->get();
        foreach ($ST as $value)
        {
            $value->sortid = $i;
            $value->edit = '';
            $value->del = '';
            $i++;
        }
        $s['abzar'] = $ST;
        $ST = DB::table('access as a')
            ->select(DB::Raw("a.id, a.name ,a.Fname"))->where('group', '2')->get();
        foreach ($ST as $value)
        {
            $value->sortid = $i;
            $value->edit = '';
            $value->del = '';
            $i++;
        }
        $s['peik'] = $ST;

        $ST = DB::table('access as a')
            ->select(DB::Raw("a.id, a.name ,a.Fname"))->where('group', '3')->get();
        foreach ($ST as $value)
        {
            $value->sortid = $i;
            $value->edit = '';
            $value->del = '';
            $i++;
        }
        $s['pages'] = $ST;

        $Ret['Access'] = $s;
        $Ret['ACL'] = DB::table('accesslevel')->orderBy('id')->get();
        $Ret['GroupAccess'] = DB::table('access as a')->leftJoin('group_access as ga', 'ga.accid', '=', 'a.id')->where('secgroupid', $id)->get();
        $err = false;
        return $Ret;
    }

    public static function SaveDepartments($name, $pid)
    {
        DB::table('departments')->delete();
        foreach ($name as $key => $value)
        {
            if ($value != '' && $pid[$key] != '')
            {
                DB::table('departments')->insert(array('name' => $value, 'pid' => $pid[$key], 'view' => '1', 'orders' => $key));
            }
            $Ret = 'انجام شد';
        }
        $err = false;

        return $Ret;
    }

    public static function user_phase_page($uid, $ses_id, $sid, $pid)
    {
        $uid = ($uid != '') ? $uid : 0;
        $UC = new PageClass();
        $Selpage = $UC->Sel_Page();
        $ST = DB::table('process as pr')
            ->leftJoin('process_phase as pp', 'pr.id', '=', 'pp.pid')
            ->leftJoin('process_phase_subject as pps', function ($join)
            {
                $join->on('pps.pid', '=', 'pr.id');
                $join->on('pps.ppid', '=', 'pp.id');
            })
            ->leftJoin('subjects as s', 's.id', '=', 'pps.sid')
            ->leftJoin('pages as p', 's.id', '=', 'p.sid')
            ->whereRaw("((pp.manager1 = 1 AND s.manager = {$uid}) OR (pp.manager1 = 2 AND s.supervisor = {$uid}) OR (pp.manager1 = 3 AND s.supporter = {$uid}) OR (pp.manager1 = 4 AND s.admin = {$uid}) OR (pp.manager = {$uid})) AND {$Selpage} AND pps.active = 1")
            ->select(DB::Raw("pps.id ,pps.view, pps.psid ,s.id as sid, pps.reg_date , pp.name as ppname , pp.manager as ppmanager , pp.manager1 as ppmanager1 , pr.name as pname , s.kind, s.frame, s.theme, s.title, s.admin, s.manager , s.supporter , s.supervisor, p.type, p.id as pid"))
            ->orderBy('pps.reg_date', 'DESC')->get();

        return $ST;
    }

    public static function Getkeyword_edit($uid, $ses_id, $kid)
    {
        $keyid1 = DB::table('keywords')->where('id', $kid)->first();
        $t = DB::table('thesaurus_keywords as kt')
            ->join('subjects as p', 'p.id', '=', 'kt.subject_id')
            ->where('keyword_id', $kid)
            ->select('p.id', 'p.title')
            ->get();
        $Rel1 = DB::table('keyword_relations as kr')
            ->join('keywords as k', 'k.id', '=', 'kr.keyword_2_id')
            ->where('keyword_1_id', $kid)
            ->select('k.id', 'k.title', 'kr.rel')
            ->get();
        $Rel2 = DB::table('keyword_relations as kr')
            ->join('keywords as k', 'k.id', '=', 'kr.keyword_1_id')
            ->where('keyword_2_id', $kid)
            ->select('k.id', 'k.title', 'kr.rel')
            ->get();
        $keyid1->Rel1 = (is_array($Rel1)) ? $Rel1 : array();
        $keyid1->Rel2 = (is_array($Rel2)) ? $Rel2 : array();


        $keyid1->Thesarus = $t;
        return $keyid1;
    }

    public static function keyword_update($keyid1, $uid, $file, $shape, $Tagtype, $workflow, $code, $relation, $thes, $Descr, $joz, $keys, $mesdagh, $jozmes, $kol, $aam, $kolaam, $hamarz, $moraj, $hambaste, $eshterak, $kootah, $english, $arabic)
    {
        $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
        $relation = ($relation == '') ? '0' : $relation;
        DB::table('keywords')
            ->where('id', $keyid1)
            ->update(array(
                'title' => $shape,
                'descr' => $Descr,
                'type' => $Tagtype,
                'uid' => $uid,
                'ttype' => '15',
                'workflow' => $workflow,
                'code' => $code,
                'morajah' => $relation,
                'pic' => $file
            ));
        $thes = explode(',', $thes);
        DB::table('thesaurus_keywords')
            ->where('keyword_id', $keyid1)
            ->delete();

        if (is_array($thes) && count($thes) > 0)
        {
            foreach ($thes as &$value)
            {
                if ($value != '')
                {
                    DB::table('thesaurus_keywords')
                        ->insert(array('keyword_id' => $keyid1, 'subject_id' => $value));
                }
            }
        }
        $joz = explode(',', $joz);
        DB::table('keyword_relations')->where('keyword_1_id', $keyid1)->delete();
        DB::table('keyword_relations')->where('keyword_2_id', $keyid1)->delete();
        if (is_array($joz) && count($joz) > 0)
        {
            foreach ($joz as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')
                        ->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '1'));
                }
            }
        }
        $mesdagh = explode(',', $mesdagh);

        if (is_array($mesdagh) && count($mesdagh) > 0)
        {

            foreach ($mesdagh as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '3'));
                }
            }
        }
        $jozmes = explode(',', $jozmes);
        if (is_array($jozmes) && count($jozmes) > 0)
        {

            foreach ($jozmes as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')
                        ->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '5'));
                }
            }
        }
        $kol = explode(',', $kol);
        if (is_array($kol) && count($kol) > 0)
        {
            foreach ($kol as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')
                        ->insert(array('keyword_1_id' => $value, 'keyword_2_id' => $keyid1, 'relation_type' => '1'));
                }
            }
        }

        $aam = explode(',', $aam);

        if (is_array($aam) && count($aam) > 0)
        {

            foreach ($aam as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')
                        ->insert(array('keyword_1_id' => $value, 'keyword_2_id' => $keyid1, 'relation_type' => '3'));
                }
            }
        }
        $kolaam = explode(',', $kolaam);
        if (is_array($kolaam) && count($kolaam) > 0)
        {
            foreach ($kolaam as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')
                        ->insert(array('keyword_1_id' => $value, 'keyword_2_id' => $keyid1, 'relation_type' => '5'));
                }
            }
        }
        $hamarz = explode(',', $hamarz);
        if (is_array($hamarz) && count($hamarz) > 0)
        {
            foreach ($hamarz as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')
                        ->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '7'));
                }
            }
        }

        $moraj = explode(',', $moraj);

        if (is_array($moraj) && count($moraj) > 0)
        {
            foreach ($moraj as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')
                        ->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '8'));
                }
            }
        }
        $hambaste = explode(',', $hambaste);

        if (is_array($hambaste) && count($hambaste) > 0)
        {
            foreach ($hambaste as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')
                        ->insert(array('keyword_`_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '9'));
                }
            }
        }
        $eshterak = explode(',', $eshterak);

        if (is_array($eshterak) && count($eshterak) > 0)
        {

            foreach ($eshterak as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')
                        ->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '10'));
                }
            }
        }
        $kootah = explode(',', $kootah);

        if (is_array($kootah) && count($kootah) > 0)
        {

            foreach ($kootah as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')
                        ->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '11'));
                }
            }
        }
        $english = explode(',', $english);

        if (is_array($english) && count($english) > 0)
        {
            foreach ($english as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')
                        ->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '12'));
                }
            }
        }
        $arabic = explode(',', $arabic);
        if (is_array($arabic) && count($arabic) > 0)
        {

            foreach ($arabic as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '13'));
                }
            }
        }
        return 'انجام شد.';
    }

    public static function UserSecSave($uid, $sesid, $editid, $secgroup_name, $descr, $defualt, $Access, $ACL)
    {
        $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
        $edit_date = gmdate("Y-m-d H:i:s", time() + 12600);
        if ($editid == '0')
        {
            if ($defualt != '' || $defualt == '1')
            {
                $defualt = '1';
                DB::table('sec_groups')->update(array('defualt' => '0'));
            }
            else
            {
                $defualt = '0';
            }
            $editid = DB::table('sec_groups')->insertGetId(array('name' => $secgroup_name, 'defualt' => $defualt, 'descr' => $descr));
            foreach ($Access as $key => $value)
            {
                $acl = $ACL[$key];
                DB::table('group_access')->insert(array('accid' => $value, 'levelid' => $acl, 'secgroupid' => $editid));
            }

            $ST = 'درج سطح دسترسی انجام شد';
        }
        else
        {
            if ($defualt != '' || $defualt == '1')
            {
                $defualt = '1';
                DB::table('sec_groups')->update(array('defualt' => '0'));
            }
            else
            {
                $defualt = '0';
            }
            DB::table('sec_groups')->where('id', $editid)->update(array('name' => $secgroup_name, 'defualt' => $defualt, 'descr' => $descr));
            DB::table('group_access')->where('secgroupid', $editid)->delete();
            foreach ($Access as $key => $value)
            {
                if (array_key_exists($key, $ACL))
                {
                    $acl = $ACL[$key];
                    DB::table('group_access')->insert(array('accid' => $value, 'levelid' => $acl, 'secgroupid' => $editid));
                }
            }

            $ST = 'ویرایش  انجام شد';
        }

        return $ST;
    }

    public static function AlertSave($uid, $sesid, $alertid, $alert_title, $descr)
    {
        $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
        $edit_date = gmdate("Y-m-d H:i:s", time() + 12600);
        if ($alertid == '0')
        {
            $ST = DB::table('alerts')->select('orders')->orderBy('orders', 'desc')->first();
            $orders = $ST->orders;
            $orders = intval($orders) + 1;
            DB::table('alerts')->insert(array('name' => $alert_title, 'comment' => $descr, 'orders' => $orders
            , 'reg_date' => $reg_date, 'edit_date' => $edit_date));
            $ST = 'درج اطلاعیه انجام شد';
        }
        else
        {
            DB::table('alerts')->where('id', $alertid)->update(array('name' => $alert_title, 'comment' => $descr, 'edit_date' => $edit_date));
            $ST = 'ویرایش اطلاعیه انجام شد';
        }

        return $ST;
    }

    public static function GetAlerts($alertid)
    {
        $ST = DB::table('alerts')->select('id', 'name', 'comment', 'orders')->where('id', $alertid)->first();
        return $ST;
    }

    public static function GetAdminOrgans()
    {
        $i = 1;
        DB::table('user_group')->where('new', '0')->where('isorgan', '1')->update(array("new" => '1'));
        $ST = DB::table('user_group')->select('id', 'name', 'link', 'summary', 'pic', 'reg_date')->where('isorgan', '1')->orderBy('id', 'DESC')->get();
        foreach ($ST as $value)
        {
            $value->reg_date = \Morilog\Jalali\jDate::forge($value->reg_date)->format('%Y/%m/%d');

            $memcount = DB::table('user_group_member')->where('gid', $value->id)->count();
            $value->memcount = $memcount;
            $postcount = DB::table('post_view')->where('gid', $value->id)->count();
            $value->postcount = $postcount;
            $value->sortid = $i;
            $value->edit = '';
            $value->del = '';
            $i++;
        }
        return $ST;
    }

    public static function GetAdminGroups()
    {
        $i = 1;
        DB::table('user_group')->where('new', '0')->where('isorgan', '0')->update(array("new" => '1'));
        $ST = DB::table('user_group')->select('id', 'name', 'link', 'summary', 'pic', 'reg_date')->where('isorgan', '0')->orderBy('id', 'DESC')->get();
        foreach ($ST as $value)
        {
            $value->reg_date = \Morilog\Jalali\jDate::forge($value->reg_date)->format('%Y/%m/%d');

            $memcount = DB::table('user_group_member')->where('gid', $value->id)->count();
            $value->memcount = $memcount;
            $postcount = DB::table('post_view')->where('gid', $value->id)->count();
            $value->postcount = $postcount;
            $value->sortid = $i;
            $value->edit = '';
            $value->del = '';
            $i++;
        }
        return $ST;
    }

    public static function GetUserSecurity()
    {
        $i = 1;
        $ST = DB::table('sec_groups as sg')
            ->leftJoin('user as u', 'u.SecGroups', '=', 'sg.id')
            ->select(DB::Raw("sg.id, sg.name ,defualt,count(u.id) as cnt"))->GroupBy('sg.id')->orderBy('sg.id', 'DESC')->get();
        foreach ($ST as $value)
        {
            $value->sortid = $i;
            $value->defualt = ($value->defualt == '1') ? 'بلی' : 'خیر';
            $value->edit = '';
            $value->del = '';
            $i++;
        }
        return $ST;
    }

    public static function GetUserList($sr)
    {
        if ($sr != '')
        {
            $search = " u.Name like '%$sr%' or u.Uname like '%$sr%' or u.Family like '%$sr%'  ";
            $ST = DB::table('user as u')
                ->leftJoin('user_profile as p', 'u.id', '=', 'p.id')
                ->select('u.id', 'u.Uname as name', 'u.Name', 'u.Family', 'u.Reg_date')->where('Active', '1')->whereRaw($search)->orderBy('u.id', 'DESC')->get();
        }
        else
        {
            $ST = DB::table('user as u')
                ->leftJoin('user_profile as p', 'u.id', '=', 'p.id')
                ->select('u.id', 'u.Uname as name', 'u.Name', 'u.Family', 'u.Reg_date')->where('Active', '1')->orderBy('u.id', 'DESC')->get();
        }
        $i = 1;

        foreach ($ST as $value)
        {
            $value->sortid = $i;
            if ($value->Reg_date > '1999-12-01')
            {
                $value->Reg_date = \Morilog\Jalali\jDate::forge($value->Reg_date)->format('%Y/%m/%d');
            }

//            try {
//                $value->Reg_date = \Morilog\Jalali\jDate::forge($value->Reg_date)->format('%Y/%m/%d');
//            } catch (Exception $ex) {
//            }
            $value->Fullname = $value->Name . ' ' . $value->Family;

            $value->edit = '';
            $value->del = '';
            $i++;
        }
        return $ST;
    }

    public static function SubjectTypeEdit($stid)
    {
        $ST = DB::table('subject_type')->where('id', $stid)->first();
// return $ST;
        $em = array();
        $Fields = DB::table('subject_type_fields')->where('stid', $stid)->orderby('id')->get();
        if ($Fields)
        {
            $ST->fields = $Fields;
        }
        else
        {
            $ST->fields = $em;
        }
        $Fieldss = DB::table('subject_type_sec')->where('public', '1')->where('private', '0')->where('asubid', $stid)->get();
        if ($Fieldss)
        {
            $ST->public = $Fieldss;
        }
        else
        {
            $ST->public = $em;
        }
        $Fieldss = DB::table('subject_type_sec')->where('public', '0')->where('private', '1')->where('asubid', $stid)->get();
        if ($Fieldss)
        {
            $ST->private = $Fieldss;
        }
        else
        {
            $ST->private = $em;
        }
        $Tabs = DB::table('subject_type_tab')->where('stid', $stid)->select('id', 'type', 'name', 'tem', 'first', 'view', 'tid', 'help_tag')->get();
        foreach ($Tabs as $value)
        {
            $value->tem = str_replace('"', "'", $value->tem);
        }
        $ST->Tabs = $Tabs;
        return $ST;
    }

    public static function SubjectTypeSave($tabid, $tab_del_did, $editid, $uid, $name, $department, $field_descr, $tab_tem, $department_select, $department_require, $pretitle, $keywords, $tag_select, $tag_require, $manager_title, $manager_id, $manager_select, $manager_require, $supervisor_title, $supervisor_id, $supervisor_select, $supervisor_require, $supporter_title, $supporter_id, $supporter_select, $supporter_require, $process, $proc_select, $proc_require, $help, $ViewAlert, $editalertshow, $EditAlert, $fields, $requires, $charchoob, $users_public, $roles_public, $users_private, $roles_private, $comment, $tab_name, $tab_type, $tab_first, $tab_view, $tab_tid, $writer_title, $field_name, $field_defval)
    {
//        $users_public,$roles_public, $users_private,$roles_private
        $name = trim(PublicClass::Filter($name));
        $department = intval(PublicClass::Filter($department));
        $shname = isset($shname) ? 1 : 0;
        $manager_id = trim(PublicClass::Filter($manager_id));
        $manager_title = trim(PublicClass::Filter($manager_title));
        $manager_select = $manager_select != '' ? 1 : 0;
        $manager_require = $manager_require != '' ? 1 : 0;
        $tag_require = $tag_require != '' ? 1 : 0;
        $tag_select = $tag_select != '' ? 1 : 0;
        $supervisor_id = trim(PublicClass::Filter($supervisor_id));
        $supervisor_title = trim(PublicClass::Filter($supervisor_title));
        $supervisor_select = $supervisor_select != '' ? 1 : 0;
        $supervisor_require = $supervisor_require != '' ? 1 : 0;
        $supporter_id = trim(PublicClass::Filter($supporter_id));
        $supporter_title = trim(PublicClass::Filter($supporter_title));
        $supporter_select = trim($supporter_select) != '' ? 1 : 0;
        $supporter_require = $supporter_require != '' ? 1 : 0;
        $ShowEdit = $editalertshow != '' ? 1 : 0;
        $proc_select = $proc_select != '' ? 1 : 0;
        $proc_require = $proc_require != '' ? 1 : 0;
        $department_require = $department_require != '' ? 1 : 0;
        $department_select = $department_select != '' ? 1 : 0;
        $process = intval(PublicClass::Filter($process));
        $comment = trim(PublicClass::Filter($comment));
        $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
        $edit_date = gmdate("Y-m-d H:i:s", time() + 12600);
        if ($editid == 0)
        {
            $s_id = DB::table('subject_type')->insertGetId(array('admin' => $uid, 'name' => $name, 'writer_title' => $writer_title, 'did' => $department, 'shname' => $shname
            , 'manager' => $manager_id, 'manager_title' => $manager_title, 'manager_select' => $manager_select, 'manager_require' => $manager_require
            , 'supervisor' => $supervisor_id, 'supervisor_title' => $supervisor_title, 'supervisor_select' => $supervisor_select, 'supervisor_require' => $supervisor_require
            , 'supporter' => $supporter_id, 'supporter_title' => $supporter_title, 'supporter_select' => $supporter_select, 'supporter_require' => $supporter_require
            , 'process' => $process, 'comment' => $comment, 'reg_date' => $reg_date, 'edit_date' => $edit_date
            , 'tagselect' => $tag_select, 'tagrequire' => $tag_require, 'proc_select' => $proc_select, 'proc_require' => $proc_require
            , 'department_require' => $department_require, 'department_select' => $department_select, 'ShowEdit' => $ShowEdit, 'pretitle' => $pretitle
            , 'viewalert' => $ViewAlert, 'editalert' => $EditAlert, 'framework' => $charchoob
            ));
            $subject_type = SubjectType::find($s_id);
            if ($users_public)
            {
                foreach ($users_public as $key => $value)
                {
                    $users_public_array[$value] = ['type' => '2'];
                }

                $subject_type->user_policies_personal()->sync($users_public_array);
            }
            else
            {
                $subject_type->user_policies_personal()->sync([]);
            }

            if ($roles_public)
            {
                foreach ($roles_public as $key => $value)
                {
                    $roles_public_array[$value] = ['type' => '2'];
                }
                $subject_type->role_policies_personal()->sync($roles_public_array);
            }
            else
            {
                $subject_type->role_policies_personal()->sync([]);
            }


            if ($users_private)
            {
                foreach ($users_private as $key => $value)
                {
                    $users_private_array[$value] = ['type' => '1'];
                }
                $subject_type->user_policies_official()->sync($users_private_array);
            }
            else
            {
                $subject_type->user_policies_official()->sync([]);
            }

            if ($roles_private)
            {
                foreach ($roles_private as $key => $value)
                {
                    $roles_private_array[$value] = ['type' => '1'];
                }
                $subject_type->role_policies_official()->sync($roles_private_array);
            }
            else
            {
                $subject_type->role_policies_official()->sync([]);
            }
            /*if (is_array($public))
            {
                $public = array_unique($public);
                foreach ($public as $val)
                {
                    $val = intval($val);
                    if ($val != 0)
                    {
                        DB::table('subject_type_sec')->insert(
                            array('asubid' => $s_id, 'secid' => $val, 'public' => '1', 'private' => '0')
                        );
                    }
                }
            }
            if (is_array($private))
            {
                $public = array_unique($private);
                foreach ($private as $val)
                {
                    $val = intval($val);
                    if ($val != 0)
                    {
                        DB::table('subject_type_sec')->insert(
                            array('asubid' => $s_id, 'secid' => $val, 'public' => '0', 'private' => '1')
                        );
                    }
                }
            }*/
            if (is_array($field_name))
            {
                $field_name = array_unique($field_name);
                foreach ($field_name as $key => $val)
                {
                    if ($val != '')
                    {
                        $help = $field_descr[$key];
                        $field_defvals = $field_defval[$key];
                        $type = $fields[$key];
                        $requires = (isset($requires[$key]) ? 1 : 0);
                        DB::table('subject_type_fields')->insert(array(
                            'stid' => $s_id, 'requires' => $requires,
                            'orders' => $key, 'help' => $help, 'name' => $val, 'type' => $type, 'defvalue' => $field_defvals));
                    }
                }
            }


            $keyword1 = explode(",", $keywords);
            foreach ($keyword1 as $val)
            {
                $val = trim(PublicClass::Filter($val));
                DB::table('subject_type_key')->insert(array('stid' => $s_id, 'kid' => $val));
            }

            if (is_array($tab_name))
            {
                $tab_name = array_unique($tab_name);
                $tid = 0;
                foreach ($tab_name as $key => $val)
                {
                    if (trim($tab_name[$key]) != '')
                    {
                        $helpid = 0;
                        $helps = '';
                        if (is_array($help) && array_key_exists($key, $help))
                        {
                            $helps = $help[$key];
                            if ($helps != '')
                            {
                                $helps = str_replace("Help ", "Help+", $helps);
                                $pages = DB::table('pages as p')->join('subjects as s', 's.id', '=', 'p.sid')->select('p.id', 's.title', 'p.body')->where('s.kind', 4)->whereRaw("body like '%$helps%'")->first();
                                if ($pages)
                                {
                                    $helpid = $pages->id;
                                }
                            }
                        }

                        $tab_view[$key] = isset($tab_view[$key]) ? 1 : 0;
                        $first = ($tab_first == $tid) ? 1 : 0;
                        DB::table('subject_type_tab')->insert(array('admin' => $uid, 'stid' => $s_id, 'tid' => $tid, 'name' => $tab_name[$key], 'type' => $tab_type[$key]
                        , 'sptid' => '0', 'brief' => '0', 'first' => $first, 'view' => $tab_view[$key]
                        , 'dist' => '0', 'help_pid' => $helpid, 'help_tag' => $helps, 'orders' => $tid, 'reg_date' => $reg_date, 'tem' => $tab_tem[$key]));

                        $tid++;
                    }
                }
            }
            return 'موضوع درج گردید.';
        }
        else
        {
            if ($editid != 0)
            {
                $s_id = $editid;
                $subject_type = SubjectType::find($editid);
                $subject_type->admin = $uid;
                $subject_type->name = $name;
                $subject_type->did = $department;
                $subject_type->shname = $shname;
                $subject_type->manager = $manager_id;
                $subject_type->manager_title = $manager_title;
                $subject_type->writer_title = $writer_title;
                $subject_type->manager_select = $manager_select;
                $subject_type->manager_require = $manager_require;
                $subject_type->supervisor = $supervisor_id;
                $subject_type->supervisor_title = $supervisor_title;
                $subject_type->supervisor_select = $supervisor_select;
                $subject_type->supervisor_require = $supervisor_require;
                $subject_type->supporter = $supporter_id;
                $subject_type->supporter_title = $supporter_title;
                $subject_type->supporter_select = $supporter_select;
                $subject_type->supporter_require = $supporter_require;
                $subject_type->process = $process;
                $subject_type->comment = $comment;
                $subject_type->reg_date = $reg_date;
                $subject_type->edit_date = $edit_date;
                $subject_type->tagselect = $tag_select;
                $subject_type->tagrequire = $tag_require;
                $subject_type->proc_select = $proc_select;
                $subject_type->proc_require = $proc_require;
                $subject_type->department_require = $department_require;
                $subject_type->department_select = $department_select;
                $subject_type->ShowEdit= $ShowEdit;
                $subject_type->pretitle = $pretitle;
                $subject_type->viewalert = $ViewAlert;
                $subject_type->editalert = $EditAlert;
                $subject_type->framework = $charchoob;
                $subject_type->save();

               /* $subject_type = DB::table('subject_type')->where('id', $editid)->update(array('admin' => $uid, 'name' => $name, 'did' => $department, 'shname' => $shname
                , 'manager' => $manager_id, 'manager_title' => $manager_title, 'writer_title' => $writer_title, 'manager_select' => $manager_select, 'manager_require' => $manager_require
                , 'supervisor' => $supervisor_id, 'supervisor_title' => $supervisor_title, 'supervisor_select' => $supervisor_select, 'supervisor_require' => $supervisor_require
                , 'supporter' => $supporter_id, 'supporter_title' => $supporter_title, 'supporter_select' => $supporter_select, 'supporter_require' => $supporter_require
                , 'process' => $process, 'comment' => $comment, 'reg_date' => $reg_date, 'edit_date' => $edit_date
                , 'tagselect' => $tag_select, 'tagrequire' => $tag_require, 'proc_select' => $proc_select, 'proc_require' => $proc_require
                , 'department_require' => $department_require, 'department_select' => $department_select, 'ShowEdit' => $ShowEdit, 'pretitle' => $pretitle
                , 'viewalert' => $ViewAlert, 'editalert' => $EditAlert, 'framework' => $charchoob
                ));*/

                if ($users_public)
                {
                    foreach ($users_public as $key => $value)
                    {
                        $users_public_array[$value] = ['type' => '1'];
                    }

                    $subject_type->user_policies_personal()->sync($users_public_array);
                }
                else
                {
                    $subject_type->user_policies_personal()->sync([]);
                }

                if ($roles_public)
                {
                    foreach ($roles_public as $key => $value)
                    {
                        $roles_public_array[$value] = ['type' => '1'];
                    }
                    $subject_type->role_policies_personal()->sync($roles_public_array);
                }
                else
                {
                    $subject_type->role_policies_personal()->sync([]);
                }


                if ($users_private)
                {
                    foreach ($users_private as $key => $value)
                    {
                        $users_private_array[$value] = ['type' => '2'];
                    }
                    $subject_type->user_policies_official()->sync($users_private_array);
                }
                else
                {
                    $subject_type->user_policies_official()->sync([]);
                }

                if ($roles_private)
                {
                    foreach ($roles_private as $key => $value)
                    {
                        $roles_private_array[$value] = ['type' => '2'];
                    }
                    $subject_type->role_policies_official()->sync($roles_private_array);
                }
                else
                {
                    $subject_type->role_policies_official()->sync([]);
                }

                /*if (is_array($public))
                {
                    $public = array_unique($public);
                    DB::table('subject_type_sec')->where('asubid', $s_id)->where('public', '1')->where('private', '0')->delete();
                    foreach ($public as $val)
                    {
                        $val = intval($val);
                        if ($val != 0)
                        {
                            DB::table('subject_type_sec')->insert(
                                array('asubid' => $s_id, 'secid' => $val, 'public' => '1', 'private' => '0')
                            );
                        }
                    }
                }
                if (is_array($private))
                {
                    DB::table('subject_type_sec')->where('asubid', $s_id)->where('public', '0')->where('private', '1')->delete();
                    $public = array_unique($private);
                    foreach ($private as $val)
                    {
                        $val = intval($val);
                        if ($val != 0)
                        {
                            DB::table('subject_type_sec')->insert(
                                array('asubid' => $s_id, 'secid' => $val, 'public' => '0', 'private' => '1')
                            );
                        }
                    }
                }*/


                DB::table('subject_type_fields')->where('stid', $s_id)->delete();
                if (is_array($field_name))
                {
                    $field_name = array_unique($field_name);
                    foreach ($field_name as $key => $val)
                    {
                        if ($val != '')
                        {
                            $help = $field_descr[$key];
                            $field_defvals = $field_defval[$key];
                            $type = $fields[$key];
                            $requires = (isset($requires[$key]) ? 1 : 0);
                            DB::table('subject_type_fields')->insert(array(
                                'stid' => $s_id, 'requires' => $requires,
                                'orders' => $key, 'help' => $help, 'name' => $val, 'type' => $type, 'defvalue' => $field_defvals));
                        }
                    }
                }
//            if (is_array($fields)) {
//                $fields = array_unique($fields);
//                foreach ($fields as $key => $val) {
//                    $val = intval($val);
//                    if ($val != 0) {
//                        $helpX = $field_descr[$key];
//                        $requires = (isset($requires[$key]) ? 1 : 0);
//                        DB::table('subject_type_fields')->insert(array('stid' => $s_id, 'field_id' => $val, 'requires' => $requires, 'orders' => $key, 'help' => $helpX));
//                    }
//                }
//            }


                DB::table('subject_type_key')->where('stid', $s_id)->delete();
                $keyword1 = explode(",", $keywords);
                foreach ($keyword1 as $val)
                {
                    $val = trim(PublicClass::Filter($val));
                    DB::table('subject_type_key')->insert(array('stid' => $s_id, 'kid' => $val));
                }

                if (is_array($tab_name))
                {
                    $tab_name = array_unique($tab_name);
                    DB::table('subject_type_tab')->where('stid', $s_id)->delete();


                    $tab_first = $tab_first - 1;
                    $tid = 0;
                    foreach ($tab_name as $key => $val)
                    {
                        if (trim($tab_name[$key]) != '')
                        {

                            if ($tab_del_did[$key] != '0')
                            {
                                DB::table('subject_type_tab')->where('id', $tabid[$key])->delete();
                            }
                            else
                            {
                                $helpid = 0;
                                $helps = '';
                                if (is_array($help) && array_key_exists($key, $help))
                                {
                                    $helps = $help[$key];
                                    if ($helps != '')
                                    {
                                        $helps = str_replace("Help ", "Help+", $helps);
                                        $pages = DB::table('pages as p')->join('subjects as s', 's.id', '=', 'p.sid')->select('p.id', 's.title', 'p.body')->where('s.kind', 4)->whereRaw("body like '%$helps%'")->first();
                                        if ($pages)
                                        {
                                            $helpid = $pages->id;
                                        }
                                    }
                                }
                                $first = ($tab_first == $tid) ? 1 : 0;
                                $tab_view[$key] = isset($tab_view[$key]) ? 1 : 0;

                                $ttids = DB::table('subject_type_tab')->insertGetId(array('admin' => $uid, 'stid' => $editid, 'tid' => $tid, 'name' => $tab_name[$key], 'type' => $tab_type[$key]
                                , 'sptid' => '0', 'brief' => '0', 'first' => $first, 'view' => $tab_view[$key], 'help_pid' => $helpid, 'help_tag' => $helps
                                , 'dist' => '0', 'orders' => $tid, 'reg_date' => $reg_date, 'tem' => $tab_tem[$key]));
                                $subjects = DB::table('subjects')->where('kind', $s_id)->select('id')->get();
                                foreach ($subjects as $items)
                                {
                                    DB::table('tab_view')->insert(array('tabid' => $ttids, 'sid' => $items->id));
                                }
//                            $c = DB::table('subject_type_tab')->where('id', $tabid[$key])->count();
//                            if ($c > 0) {
//                                $tab_view[$key] = isset($tab_view[$key]) ? 1 : 0;
//                                $first = ($tab_first == $tid) ? 1 : 0;
//                                if ($tab_tid[$key] != '') {
//                                    DB::table('subject_type_tab')->where('id', $tabid[$key])->update(array('admin' => $uid, 'stid' => $editid, 'tid' => $tab_tid[$key], 'name' => $tab_name[$key], 'type' => $tab_type[$key]
//                                        , 'sptid' => '0', 'brief' => '0', 'first' => $first, 'view' => $tab_view[$key], 'help_pid' => $helpid, 'help_tag' => $helps
//                                        , 'dist' => '0', 'orders' => $tid, 'reg_date' => $reg_date, 'tem' => $tab_tem[$key]));
//                                } else {
//                                    DB::table('subject_type_tab')->where('id', $tabid[$key])->update(array('admin' => $uid, 'stid' => $editid, 'tid' => $tid, 'name' => $tab_name[$key], 'type' => $tab_type[$key]
//                                        , 'sptid' => '0', 'brief' => '0', 'first' => $first, 'view' => $tab_view[$key], 'help_pid' => $helpid, 'help_tag' => $helps
//                                        , 'dist' => '0', 'orders' => $tid, 'reg_date' => $reg_date, 'tem' => $tab_tem[$key]));
//                                }
//                            } else {
//                                $tab_view[$key] = isset($tab_view[$key]) ? 1 : 0;
//                                $first = ($tab_first == $tid) ? 1 : 0;
//                                DB::table('subject_type_tab')->insert(array('admin' => $uid, 'stid' => $editid, 'tid' => $tid, 'name' => $tab_name[$key], 'type' => $tab_type[$key]
//                                    , 'sptid' => '0', 'brief' => '0', 'first' => $first, 'view' => $tab_view[$key], 'help_pid' => $helpid, 'help_tag' => $helps
//                                    , 'dist' => '0', 'orders' => $tid, 'reg_date' => $reg_date, 'tem' => $tab_tem[$key]));
//                            }
                            }


                            $tid++;
                        }
                    }
                }

                return 'موضوع ویرایش گردید.';
            }
        }
    }

    public static function GetSubjetData($uid, $sesid)
    {
        if (UserClass::permission('subjects', $uid) == '1')
        {
            $Fileds = DB::table('fields as d')
                ->where('d.id', '>', '0')
                ->select('d.field_Desc', 'd.id as did', 'd.field_name', 'd.field_type', 'd.orders')
                ->orderBy('d.orders')->get();

            $Process = DB::table('process as p')->select('p.id', 'p.name as process_name')->get();
            $Alerts = PublicsClass::Alerts();
            $SecGroups = DB::table('sec_groups as a')->select('id', 'name')->get();
            $Framework = DB::table('subjects as s')
                ->join('subject_key as sk', 's.id', '=', 'sk.sid')
                ->where('sk.kid', '212')->select('s.id', 's.title')->get();
            $NotIn = subjectKey::select('sid')->where('kid', '=', '212')->get();
            $Shart = array();
            $i = 0;
            foreach ($NotIn as $PKey)
            {
                $Shart[$i] = $PKey->sid;
                $i++;
            }
            $UC = new PageClass();
            $Selpage = $UC->Sel_Page();
            $Portals = DB::table('subjects as s')
                ->leftJoin('pages as p', 'p.sid', '=', 's.id')
                ->where('s.kind', '=', '27')
                ->whereRaw($Selpage)
                ->where('s.archive', '=', '0')
                ->whereNotIn('s.id', $Shart)
                ->select('p.id as pid', 's.title as title')
                ->orderby('s.title')
                ->get();

            $Ret['Fileds'] = $Fileds;
            $Ret['Process'] = $Process;
            $Ret['Alerts'] = $Alerts;
            $Ret['SecGroups'] = $SecGroups;
            $Ret['Framework'] = $Framework;
            $Ret['Portals'] = $Portals;
            $err = false;
        }
        else
        {
            $err = true;
            $Ret = trans('labels.AdminFail');
        }

        return $Ret;
    }

    public static function GetSubjectType($uid, $sesid)
    {
        if (UserClass::permission('subjects', $uid) == '1')
        {
            $Ret = DB::table('subject_type as st')
                ->groupBy('st.id')
                ->select(DB::RAW("st.id, st.admin, st.name, st.comment, st.reg_date "))->orderBy('st.name')->get();
            $i = 1;
            foreach ($Ret as $value)
            {
//nums
                $Rets = DB::table('pages as p')->leftJoin('subjects as s', 's.id', '=', 'p.sid')->where('s.kind', $value->id)->where('s.archive', '0')->groupBy('p.sid')->select('s.id')->get();
                $j = 0;
                foreach ($Rets as $values)
                {
                    $j++;
                }

                $value->sortid = $i;
                $value->nums = $j;

                $value->reg_date = \Morilog\Jalali\jDate::forge($value->reg_date)->format('%Y/%m/%d');
                $i++;
            }
            $err = false;
        }
        else
        {
            $err = true;
            $Ret = trans('labels.AdminFail');
        }

        return $Ret;
    }

    public static function FieldUpdate($uid, $sesid, $field_name, $field_Desc, $field_type, $field_value, $update, $delete, $did)
    {
        $field_name = json_decode($field_name, true);
        $field_Desc = json_decode($field_Desc, true);
        $field_type = json_decode($field_type, true);
        $field_value = json_decode($field_value, true);
        $update = json_decode($update, true);
        $delete = json_decode($delete, true);
        $did = json_decode($did, true);
        $uid = Input::get('uid');
        $session_id = Input::get('sesid');
        $uc = new UserClass();
        $user = UserClass::CheckLogin($uid, $session_id);
        $user = ($user == TRUE) ? 'true' : 'false';
        if ($user)
        {
            $error = false;
            $n = 0;
            if (is_array($field_name))
            {
                foreach ($field_name as $key => $val)
                {
                    if (!empty($val))
                    {
                        $val = PublicClass::Filter($val);
                        if (isset($update[$key]) && intval($update[$key]) == 1)
                        {
                            $did[$key] = intval(PublicClass::Filter($did[$key]));
                            if (isset($delete[$key]))
                            {
                                $del[$key] = 1;
                            }
                            else
                            {
                                $del[$key] = 0;
                            }

                            if (isset($del[$key]) && $del[$key] == 1)
                            {
                                DB::table('fields')->where('id', $did[$key])->delete();
                                DB::table('fields_value')->where('field_id', $did[$key])->delete();
                                DB::table('subject_type_fields')->where('field_id', $did[$key])->delete();
                                DB::table('subject_fields_report')->where('field_id', $did[$key])->delete();
                            }
                            else
                            {
                                $nums = DB::table('subject_fields_report')->where('field_id', $did[$key])->select('id')->count();
                                $field_type[$key] = PublicClass::Filter($field_type[$key]);
                                if ($nums == 0)
                                {
                                    $sr = "field_type = '" . $field_type[$key] . "',";
                                }
                                else
                                {
                                    $sr = '';
                                }
                                $sql = "UPDATE
                                                fields
                                        SET
                                                 field_name = '" . $field_name[$key] . "'
                                                 ,{$sr}
                                                 orders = '" . $n . "'
                                        WHERE
                                                id = {$did[$key]}";
                                DB::select(DB::raw($sql));
                                $field_id = $did[$key];
                                if ($nums == 0)
                                {
                                    DB::table('fields_value')->where('field_id', $field_id)->delete();
                                    if ($field_type[$key] == 'select' || $field_type[$key] == 'radio' || $field_type[$key] == 'checkbox')
                                    {
                                        $order = 0;
                                        $field_values = explode('|', $field_value[$key]);
                                        foreach ($field_values as $k => $v)
                                        {
                                            $v = trim(PublicClass::Filter($v));
                                            if ($v != '')
                                            {
                                                DB::table('fields_value')->insert(array('field_id' => $field_id, 'field_value' => $v, 'orders' => $order));
                                                ++$order;
                                            }
                                        }
                                    }
                                    else
                                    {
                                        if ($field_value[$key] != '')
                                        {
                                            DB::table('fields_value')->insert(array('field_id' => $field_id, 'field_value' => $field_value[$key]));
                                        }
                                    }
                                }
                                else
                                {
                                    $v = '';
                                    if ($field_type[$key] == 'select' || $field_type[$key] == 'radio' || $field_type[$key] == 'checkbox')
                                    {
                                        $order = 0;
                                        $field_values = explode('|', $field_value[$key]);
                                        foreach ($field_values as $k => $v)
                                        {
                                            $v = trim(PublicClass::Filter($v));
                                            $nums1 = DB::table('fields_value as r')->leftJoin('subject_fields_report as d', 'd.field_id', '=', 'r.field_id')->where('r.field_value', 'd.id')
                                                ->where('r.field_id', $field_id)->where('d.field_value', $v)->select('r.id', 'd.id')->count();
                                            if ($nums1 == 0)
                                            {
                                                if ($v != '')
                                                {
                                                    DB::table('fields_value')->where('field_id', $field_id)->where('field_value', $v)->delete();
                                                    DB::table('fields_value')->insert(array('field_id' => $field_id, 'field_value' => $v, 'orders' => $order));
                                                }
                                            }
                                            if ($v != '')
                                            {

                                                DB::table('fields_value')->where('field_id', $field_id)->where('field_value', $v)->update(array('orders' => $order));
                                            }
                                            ++$order;
                                        }
                                    }
                                    else
                                    {
                                        if ($v != '')
                                        {
                                            DB::table('fields_value')->where('field_id', $field_id)->delete();
                                            DB::table('fields_value')->insert(array('field_id' => $field_id, 'field_value' => $field_value[$key]));
                                        }
                                    }
                                }
                            }
                        }
                        else
                        {
                            $field_id = DB::table('fields')->insertGetId(array('field_name' => $field_name[$key], 'field_type' => $field_type[$key], 'orders' => $n));

                            $field_values = explode('|', $field_value[$key]);
                            foreach ($field_values as $k => $v)
                            {
                                if (trim($v) != '')
                                {
                                    DB::table('fields_value')->insert(array('field_id' => $field_id, 'field_value' => $v));
                                }
                            }
                        }
                        ++$n;
                    }
                    else
                    {
                        if (isset($update[$key]) && intval($update[$key]) == 1)
                        {
                            $nums = DB::table('subject_field_report')->where('field_id', $did[$key])->select('id')->count();
                            if ($nums == 0)
                            {
                                DB::table('field')->where('id', $did[$key])->delete();
                                DB::table('field_value')->where('field_id', $did[$key])->delete();
                            }
                        }
                    }
                }
            }
            $message = 'فیلدها بروزآوری گردیدند.';
        }
        else
        {
            $message = trans('labels.FailUser');
            $error = true;
        }
        return Response::json(array(
            'error' => $error,
            'data' => $message), 200
        )->setCallback(Input::get('callback'));
    }

    public static function GetAsubjects($uid)
    {
        $Public = DB::table('subject_type as st')
            ->join('subject_type_sec AS asec', 'st.id', '=', 'asec.asubid')
            ->join('user AS u', 'u.SecGroups', '=', 'asec.secid')->select('st.id', 'st.name', 'st.Framework')->where('u.id', $uid)->where('asec.public', '1')->where('asec.private', '0')->get();
        $Private = DB::table('subject_type as st')
            ->join('subject_type_sec AS asec', 'st.id', '=', 'asec.asubid')
            ->join('user AS u', 'u.SecGroups', '=', 'asec.secid')->select('st.id', 'st.name', 'st.Framework')->where('u.id', $uid)->where('asec.public', '0')->where('asec.private', '1')->get();

        foreach ($Public as $value)
        {
            $id = $value->id;
            $value->tem = false;
            $tem = DB::table('subject_type_tab AS t')
                ->where('stid', $id)->select('tem')->get();
            foreach ($tem as $values)
            {
                if ($values->tem != '')
                {
                    $value->tem = true;
                }
            }
        }

        foreach ($Private as $value)
        {
            $id = $value->id;
            $value->tem = false;
            $tem = DB::table('subject_type_tab AS t')
                ->where('stid', $id)->select('tem')->get();
            foreach ($tem as $values)
            {
                if ($values->tem != '')
                {
                    $value->tem = true;
                }
            }
        }
        $subjects['public'] = $Public;
        $subjects['private'] = $Private;

        return $subjects;
    }

    public static function asubjectADD($uid, $sesid, $name, $pretitle, $charchoob, $them, $public, $private, $Skind)
    {
        $id = DB::table('asubject')->insertGetId(
            array('name' => $name, 'pretitle' => $pretitle, 'subjectkind' => $Skind, 'Framework' => $charchoob)
        );

        $myArray = explode(',', $them);
        foreach ($myArray as &$value)
        {
            if ($value != '')
            {
                DB::table('asubtem')->insert(
                    array('asubid' => $id, 'thmid' => $value)
                );
            }
        }


        $myArray = explode(',', $public);
        foreach ($myArray as &$value)
        {
            if ($value != '')
            {
                DB::table('asubjectSec')->insert(
                    array('asubid' => $id, 'secid' => $value, 'public' => '1', 'private' => '0')
                );
            }
        }
        $myArray = explode(',', $private);
        foreach ($myArray as &$value)
        {
            if ($value != '')
            {
                DB::table('asubjectSec')->insert(
                    array('asubid' => $id, 'secid' => $value, 'public' => '0', 'private' => '1')
                );
            }
        }

        return $message = trans('labels.Desktop.asubADD');
    }

    public static function AsubjectShow()
    {
        $Groups = DB::table('asubject as asub')
            ->Leftjoin('charchoob as ch', 'ch.pid', '=', 'asub.Framework')
            ->Leftjoin('asubtem as tem', 'tem.asubid', '=', 'asub.id')
            ->Leftjoin('subject_type as st', 'st.id', '=', 'asub.subjectkind')
            ->select('asub.id', 'asub.NAME as name', 'asub.pretitle', 'ch.NAME AS charchoob', 'ch.pid', 'st.name as subjectname')
            ->orderBy('asub.name')->get();
        $i = 1;
        foreach ($Groups as $value)
        {
            $value->sortid = $i;
            $i++;
        }

        return $Groups;
    }

}
