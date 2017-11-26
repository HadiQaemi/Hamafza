<?php

namespace App\HamafzaServiceClasses;

use Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class MeasureClass {

    public static function PageALL($uid, $sid) {
        $Groups = DB::table('actions as a')->Leftjoin('action_recieve as r', 'a.id', '=', 'r.mid')
                        ->Leftjoin('user as u', 'a.admin', '=', 'u.id')
                        ->Leftjoin('pages as p', 'p.id', '=', 'a.pid')
                        ->Leftjoin('subjects as s', 'p.sid', '=', 's.id')
                        ->whereRaw("(complete <100 And r.checked='0')")
                        ->whereRaw('(r.uid=' . $uid . ' or a.admin=' . $uid . ')')->where('s.id', $sid)
                        ->select('r.new', 'r.checked', 'r.checked', 'a.id', 'a.id as sortid', 'a.title', 'a.priority', 'a.urgency', 'a.res_date as reg_date', 'u.id as uid', 'u.uname', DB::Raw("CONCAT(u.Name,' ',u.Family) as Fname"))
                        ->groupBy('a.id')->orderBy('a.reg_date', 'desc')->orderBy('r.checked')->get();
        $i = 1;
        foreach ($Groups as $Group) {
            $ugt = $Group->urgency;
            $Group->sortid = $i;
            $Group->urgency = trans('labels.column.urgency.type')[$ugt];
            $ugt = $Group->priority;
            $Group->priority = trans('labels.column.priority.type')[$ugt];
            $Group->reg_date =\Morilog\Jalali\jDate::forge($Group->reg_date)->format('%Y/%m/%d');
            $i++;
        }
        return $Groups;
    }

    public static function PageFme($uid, $sid) {
        $Groups = DB::table('actions as a')->Leftjoin('action_recieve as r', 'a.id', '=', 'r.mid')
                        ->Leftjoin('user as u', 'a.admin', '=', 'u.id')
                        ->Leftjoin('pages as p', 'p.id', '=', 'a.pid')
                        ->Leftjoin('subjects as s', 'p.sid', '=', 's.id')
                        ->whereRaw("(complete <100 And r.checked='0')")
                        ->where('a.admin', $uid)->where('s.id', $sid)
                        ->select('r.new', 'r.checked', 'r.checked', 'a.id', 'a.id as sortid', 'a.title', 'a.priority', 'a.urgency', 'a.res_date as reg_date', 'u.id as uid', 'u.uname', DB::Raw("CONCAT(u.Name,' ',u.Family) as Fname"))
                        ->groupBy('a.id')->orderBy('a.reg_date', 'desc')->orderBy('r.checked')->get();
        $i = 1;
        foreach ($Groups as $Group) {
            $ugt = $Group->urgency;
            $Group->sortid = $i;
            $Group->urgency = trans('labels.column.urgency.type')[$ugt];
            $ugt = $Group->priority;
            $Group->priority = trans('labels.column.priority.type')[$ugt];
            $Group->reg_date =\Morilog\Jalali\jDate::forge($Group->reg_date)->format('%Y/%m/%d');
            $i++;
            //$Group->trans('labels.column.reg_date') =\Morilog\Jalali\jDate::forge($Group-> trans('labels.column.reg_date') )->format('%Y/%m/%d');;
        }
        return $Groups;
    }

    public static function PageMeDrafts($uid, $sid) {
        $Groups = DB::table('actions as a')->Leftjoin('action_recieve as r', 'a.id', '=', 'r.mid')
                        ->Leftjoin('user as u', 'a.admin', '=', 'u.id')
                        ->Leftjoin('pages as p', 'p.id', '=', 'a.pid')
                        ->Leftjoin('subjects as s', 'p.sid', '=', 's.id')
                        ->where('a.isdraft', '1')->where('a.admin', $uid)->where('s.id', $sid)
                        ->select('r.new', 'r.checked', 'r.checked', 'a.id', 'a.id as sortid', 'a.title', 'a.priority', 'a.urgency', 'a.res_date as reg_date', 'u.id as uid', 'u.uname', DB::Raw("CONCAT(u.Name,' ',u.Family) as Fname"))
                        ->groupBy('a.id')->orderBy('a.reg_date', 'desc')->orderBy('r.checked')->get();
        $i = 1;
        foreach ($Groups as $Group) {
            $ugt = $Group->urgency;
            $Group->sortid = $i;
            $Group->urgency = trans('labels.column.urgency.type')[$ugt];
            $ugt = $Group->priority;
            $Group->priority = trans('labels.column.priority.type')[$ugt];
            $Group->reg_date =\Morilog\Jalali\jDate::forge($Group->reg_date)->format('%Y/%m/%d');
            $i++;
            //$Group->trans('labels.column.reg_date') =\Morilog\Jalali\jDate::forge($Group-> trans('labels.column.reg_date') )->format('%Y/%m/%d');;
        }
        return $Groups;
    }

    public static function PageME_BC($uid, $sid) {
        $Groups = DB::table('actions as a')->Leftjoin('action_recieve as r', 'a.id', '=', 'r.mid')
                        ->Leftjoin('user as u', 'a.admin', '=', 'u.id')
                        ->Leftjoin('pages as p', 'p.id', '=', 'a.pid')
                        ->Leftjoin('subjects as s', 'p.sid', '=', 's.id')
                        ->whereRaw("(complete <100 And r.checked='0')")
                        ->where('is_bc', '1')->where('r.uid', $uid)->where('s.id', $sid)
                        ->select('r.new', 'r.checked', 'r.checked', 'a.id', 'a.id as sortid', 'a.title', 'a.priority', 'a.urgency', 'a.res_date as reg_date', 'u.id as uid', 'u.uname', DB::Raw("CONCAT(u.Name,' ',u.Family) as Fname"))
                        ->groupBy('a.id')->orderBy('a.reg_date', 'desc')->orderBy('r.checked')->get();
        $i = 1;
        foreach ($Groups as $Group) {
            $ugt = $Group->urgency;
            $Group->sortid = $i;
            $Group->urgency = trans('labels.column.urgency.type')[$ugt];
            $ugt = $Group->priority;
            $Group->priority = trans('labels.column.priority.type')[$ugt];
            $Group->reg_date =\Morilog\Jalali\jDate::forge($Group->reg_date)->format('%Y/%m/%d');
            $i++;
            //$Group->trans('labels.column.reg_date') =\Morilog\Jalali\jDate::forge($Group-> trans('labels.column.reg_date') )->format('%Y/%m/%d');;
        }
        return $Groups;
    }

    public static function PageME($uid, $sid) {
        $Groups = DB::table('actions as a')->Leftjoin('action_recieve as r', 'a.id', '=', 'r.mid')
                        ->Leftjoin('user as u', 'a.admin', '=', 'u.id')
                        ->Leftjoin('pages as p', 'p.id', '=', 'a.pid')
                        ->Leftjoin('subjects as s', 'p.sid', '=', 's.id')
                        ->whereRaw("(complete <100 And r.checked='0')")
                        ->where('is_bc', '0')->where('r.uid', $uid)->where('s.id', $sid)
                        ->select('r.new', 'r.checked', 'a.id', 'a.id as sortid', 'a.title', 'a.priority', 'a.urgency', 'a.res_date as reg_date', 'u.id as uid', 'u.uname', DB::Raw("CONCAT(u.Name,' ',u.Family) as Fname"))
                        ->groupBy('a.id')->orderBy('a.reg_date', 'desc')->orderBy('r.checked')->get();
        $i = 1;
        foreach ($Groups as $Group) {
            $ugt = $Group->urgency;
            $Group->sortid = $i;
            $Group->urgency = trans('labels.column.urgency.type')[$ugt];
            $ugt = $Group->priority;
            $Group->priority = trans('labels.column.priority.type')[$ugt];
            $Group->reg_date =\Morilog\Jalali\jDate::forge($Group->reg_date)->format('%Y/%m/%d');
            $i++;
            //$Group->trans('labels.column.reg_date') =\Morilog\Jalali\jDate::forge($Group-> trans('labels.column.reg_date') )->format('%Y/%m/%d');;
        }
        return $Groups;
    }

    public function measure_sendReport($uid, $sesid, $gozaresh, $pishraft, $finish, $aid, $arid) {
        if ($aid != '') {
            $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
            DB::table('action_recieve')->where('id', $arid)->update(array('descr' => $gozaresh, 'complete' => $pishraft, 'checked' => $finish, 'checked_date' => $reg_date));

            $err = false;
            $Ret = 'تایید شد';
        }
        return $Ret;
    }

   
    public function PageSelect($type, $uid, $sid) {
        $res = '';
        switch (trim($type)) {
            case 'ME':
                $res = MeasureClass::PageME($uid, $sid);
                break;
            case 'BC':
                $res = MeasureClass::PageME_BC($uid, $sid);
                break;
            case 'Fme':
                $res = MeasureClass::PageFme($uid, $sid);
                break;
            case 'MeDrafts':
                $res = MeasureClass::PageMeDrafts($uid, $sid);
                break;
            case 'ALL':
                $res = MeasureClass::PageALL($uid, $sid);
                break;
        }
        return $res;
    }

    public function Select($type, $uid, $sel) {
        $res = '';
        switch (trim($type)) {
            case 'ME':
                $res = MeasureClass::ME($uid, $sel);
                break;
            case 'BC':
                $res = MeasureClass::ME_BC($uid);
                break;
            case 'Fme':
                $res = MeasureClass::Fme($uid, $sel);
                break;
            case 'MeDrafts':
                $res = MeasureClass::MeDrafts($uid);
                break;
            case 'ALL':
                $res = MeasureClass::ALL($uid);
                break;
        }
        return $res;
    }

    public static function ALL($uid) {
        $Groups = DB::table('actions as a')->Leftjoin('action_recieve as r', 'a.id', '=', 'r.mid')
                        ->Leftjoin('user as u', 'a.admin', '=', 'u.id')
                        ->Leftjoin('pages as p', 'p.id', '=', 'a.pid')
                        ->Leftjoin('subjects as s', 'p.sid', '=', 's.id')
                        ->whereRaw("(complete <100 And r.checked='0')")
                        ->whereRaw('(r.uid=' . $uid . ' or a.admin=' . $uid . ')')
                        ->select('r.new', 'r.checked', 'a.id', 'a.id as sortid', 'a.title', 'a.priority', 'a.urgency', 'a.res_date as reg_date', 'u.id as uid', 'u.uname', DB::Raw("CONCAT(u.Name,' ',u.Family) as Fname"))
                        ->groupBy('a.id')->orderBy('a.reg_date', 'desc')->orderBy('r.checked')->get();
        $i = 1;
        foreach ($Groups as $Group) {
            $ugt = $Group->urgency;
            $Group->sortid = $i;
            $Group->urgency = trans('labels.column.urgency.type')[$ugt];
            $ugt = $Group->priority;
            $Group->priority = trans('labels.column.priority.type')[$ugt];
            $Group->reg_date =\Morilog\Jalali\jDate::forge($Group->reg_date)->format('%Y/%m/%d');
            $i++;
            //$Group->trans('labels.column.reg_date') =\Morilog\Jalali\jDate::forge($Group-> trans('labels.column.reg_date') )->format('%Y/%m/%d');;
        }
        return $Groups;
    }

    public static function MeDrafts($uid) {
        $Groups = DB::table('actions as a')->Leftjoin('action_recieve as r', 'a.id', '=', 'r.mid')
                        ->Leftjoin('user as u', 'a.admin', '=', 'u.id')
                        ->Leftjoin('pages as p', 'p.id', '=', 'a.pid')
                        ->Leftjoin('subjects as s', 'p.sid', '=', 's.id')
                        ->where('a.isdraft', '1')->where('a.admin', $uid)
                        ->select('r.new', 'r.checked', 'a.id', 'a.id as sortid', 'a.title', 'a.priority', 'a.urgency', 'a.res_date as reg_date', 'u.id as uid', 'u.uname', DB::Raw("CONCAT(u.Name,' ',u.Family) as Fname"))
                        ->groupBy('a.id')->orderBy('a.reg_date', 'desc')->orderBy('r.checked')->get();
        $i = 1;
        foreach ($Groups as $Group) {
            $ugt = $Group->urgency;
            $Group->sortid = $i;
            $Group->urgency = trans('labels.column.urgency.type')[$ugt];
            $ugt = $Group->priority;
            $Group->priority = trans('labels.column.priority.type')[$ugt];
            $Group->reg_date =\Morilog\Jalali\jDate::forge($Group->reg_date)->format('%Y/%m/%d');
            $i++;
            //$Group->trans('labels.column.reg_date') =\Morilog\Jalali\jDate::forge($Group-> trans('labels.column.reg_date') )->format('%Y/%m/%d');;
        }
        return $Groups;
    }

    public static function ME($uid, $sel) {
        $DesktopNotificaton = 0;
        DB::table('emails')->where('uid', $uid)->where('type', 'Eghdam_NEW')->update(array('view' => '1', 'read' => '1'));
        $Groups = DB::table('actions as a')->Leftjoin('action_recieve as r', 'a.id', '=', 'r.mid')
                        ->Leftjoin('user as u', 'a.admin', '=', 'u.id')
                        ->Leftjoin('pages as p', 'p.id', '=', 'a.pid')
                        ->Leftjoin('subjects as s', 'p.sid', '=', 's.id')
                        ->where('is_bc', '0')->where('r.uid', $uid)
                 ->whereRaw("(r.checked in ($sel))")
                        ->select('r.checked', 'r.new', 'a.id', 'a.id as sortid', 'a.title', 'a.priority', 'a.urgency', 'a.res_date as reg_date', 'u.id as uid', 'u.uname', DB::Raw("CONCAT(u.Name,' ',u.Family) as Fname"))
                        ->groupBy('a.id')->orderBy('a.reg_date', 'desc')->orderBy('r.checked')->get();
        $i = 1;
        foreach ($Groups as $Group) {
            $ugt = $Group->urgency;
            $Group->sortid = $i;
            $Group->urgency = trans('labels.column.urgency.type')[$ugt];
            $ugt = $Group->priority;
            $Group->priority = trans('labels.column.priority.type')[$ugt];
            $Group->reg_date = \Morilog\Jalali\jDate::forge($Group->reg_date)->format('%Y/%m/%d');
             if ($Group->checked == 0)
                $Group->checked = 'آغازنشده';
            else if ($Group->checked == 1)
                $Group->checked = 'در حال انجام';
            else if ($Group->checked == 2)
                $Group->checked = 'انجام شده';
            else if ($Group->checked == 3)
                $Group->checked = 'پایان یافته ';
            $i++;
            //$Group->trans('labels.column.reg_date') =\Morilog\Jalali\jDate::forge($Group-> trans('labels.column.reg_date') )->format('%Y/%m/%d');;
        }
        return $Groups;
    }

    public static function ME_BC($uid) {
        DB::table('emails')->where('uid', $uid)->where('type', 'Eghdam_runevesht')->update(array('view' => '1', 'read' => '1'));
        $Groups = DB::table('actions as a')->Leftjoin('action_recieve as r', 'a.id', '=', 'r.mid')
                        ->Leftjoin('user as u', 'a.admin', '=', 'u.id')
                        ->Leftjoin('pages as p', 'p.id', '=', 'a.pid')
                        ->Leftjoin('subjects as s', 'p.sid', '=', 's.id')
                        ->whereRaw("(complete <100 And r.checked='0')")
                        ->where('is_bc', '1')->where('r.uid', $uid)
                        ->select('r.new', 'r.checked', 'a.id', 'a.id as sortid', 'a.title', 'a.priority', 'a.urgency', 'a.res_date as reg_date', 'u.id as uid', 'u.uname', DB::Raw("CONCAT(u.Name,' ',u.Family) as Fname"))
                        ->groupBy('a.id')->orderBy('a.reg_date', 'desc')->orderBy('r.checked')->get();
        $i = 1;
        foreach ($Groups as $Group) {
            $ugt = $Group->urgency;
            $Group->sortid = $i;
            $Group->urgency = trans('labels.column.urgency.type')[$ugt];
            $ugt = $Group->priority;
            $Group->priority = trans('labels.column.priority.type')[$ugt];
            $Group->reg_date =\Morilog\Jalali\jDate::forge($Group->reg_date)->format('%Y/%m/%d');
                        $Group->reg_date = \Morilog\Jalali\jDate::forge($Group->reg_date)->format('%Y/%m/%d');

            $i++;
            //$Group->trans('labels.column.reg_date') =\Morilog\Jalali\jDate::forge($Group-> trans('labels.column.reg_date') )->format('%Y/%m/%d');;
        }
        return $Groups;
    }

    public static function Fme($uid, $sel) {
        $Groups = DB::table('actions as a')->Leftjoin('action_recieve as r', 'a.id', '=', 'r.mid')
                        ->Leftjoin('user as u', 'r.uid', '=', 'u.id')
                        ->Leftjoin('pages as p', 'p.id', '=', 'a.pid')
                        ->Leftjoin('subjects as s', 'p.sid', '=', 's.id')
                       
                        ->where('a.admin', $uid)
                        ->select('r.new', 'r.checked', 'r.checked', 'a.id', 'a.id as sortid', 'a.title', 'a.priority', 'a.urgency', 'a.res_date as reg_date', 'u.id as uid', 'u.uname', DB::Raw("CONCAT(u.Name,' ',u.Family) as Fname"))
                        ->groupBy('a.id')->orderBy('a.reg_date', 'desc')->orderBy('r.checked')->get();
       //->whereRaw("(r.checked in ($sel))")
        $i = 1;
        foreach ($Groups as $Group) {
            $ugt = $Group->urgency;
            $Group->sortid = $i;
            $Group->urgency = trans('labels.column.urgency.type')[$ugt];
            $ugt = $Group->priority;
            $Group->priority = trans('labels.column.priority.type')[$ugt];
            $Group->reg_date =\Morilog\Jalali\jDate::forge($Group->reg_date)->format('%Y/%m/%d');
            $i++;
            //$Group->trans('labels.column.reg_date') =\Morilog\Jalali\jDate::forge($Group-> trans('labels.column.reg_date') )->format('%Y/%m/%d');;
        }
        return $Groups;
    }

    public function user_measures_show($uid, $mid) {
        DB::table('action_recieve')
                ->where('uid', $uid)
                ->where('mid', $mid)
                ->update(array('new' => '1'));
        $ret = array();
        $ret = DB::table('actions as a')->Leftjoin('action_recieve as r', 'a.id', '=', 'r.mid')
                ->Leftjoin('user as u', 'u.id', '=', 'a.admin')
                ->Leftjoin('pages as p', 'p.id', '=', 'a.pid')->Leftjoin('subjects as s', 's.id', '=', 'p.sid')
                ->whereRaw("((r.uid = $uid or  u.id=$uid) AND a.id = $mid)")
                ->select(DB::Raw('a.admin,r.id , r.uid as ruid , a.pid ,a.Descr, a.title , a.quote ,a.urgency, a.priority , a.reg_date , a.res_date , r.complete ,  r.descr , r.checked , u.Name , u.Family ,u.Uname , s.title as pagetitle , s.kind , p.type , file as fname'))
                ->first();
        $ret->reg_date =\Morilog\Jalali\jDate::forge($ret->reg_date)->format('%Y/%m/%d');
        $ret->res_date =\Morilog\Jalali\jDate::forge($ret->res_date)->format('%Y/%m/%d');
        $ugt = $ret->urgency;
        $ret->urgency = trans('labels.column.urgency.type')[$ugt];
        $ugt = $ret->priority;
        $ret->priority = trans('labels.column.priority.type')[$ugt];

        $ref = DB::table('action_recieve as r')
                        ->Leftjoin('user as u', 'u.id', '=', 'r.uid')
                        ->where('r.mid', $mid)->where('r.is_bc', '0')
                        ->select('u.Name', 'u.Family', 'u.Uname')->get();
        $ret->to = $ref;

        $ref = DB::table('action_recieve as r')
                        ->Leftjoin('user as u', 'u.id', '=', 'r.uid')
                        ->where('r.mid', $mid)->where('r.is_bc', '1')
                        ->select('u.Name', 'u.Family', 'u.Uname')->get();
        $ret->bc = $ref;
        $files = DB::table('action_file')
                        ->where('mid', $mid)
                        ->select('name', 'id')->get();
        $ret->files = $files;
        $allowreprt = ($ret->ruid == $uid) ? true : false;
        $alloaccept = ($ret->admin == $uid) ? true : false;
        $ret->allowaccept = $alloaccept;
        $ret->allowreport = $allowreprt;
        $ret->mid = $mid;
        return $ret;
    }

}
