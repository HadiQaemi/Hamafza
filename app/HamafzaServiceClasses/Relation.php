<?php

namespace App\HamafzaServiceClasses;

use Illuminate\Support\Facades\DB;
use App\HamafzaPublicClasses\FunctionsClass;

class Relation {

    public static function Rel_FollowME($uid) {

        $UC = new UserClass();
        $myci = $UC->userCircle($uid, 0);
        $AM_Confirm = DB::table('user as u')
                        ->leftJoin('user_friend as f', 'u.id', '=', 'f.fid')
                        ->where('f.uid', $uid)->where('f.follow', '1')->groupBy('f.fid')->orderBy('u.id', 'ASC')
                        ->select('u.id', 'u.Uname', 'u.Name', 'u.Family', 'u.Summary', 'u.Pic')->get();
        foreach ($AM_Confirm as $row) {
            $tid = $row->id;
            $AC = DB::table('user_friend as f')
                            ->Join('user_friend_circle as c', 'c.fid', '=', 'f.id')
                            ->where('f.uid', $uid)->where('f.fid', $tid)->select('c.cid')->groupBy('c.cid')->get();
            $row->Circles = $AC;
            $row->Mycircle = $myci;
        }
        return Response::json(array(
                    'error' => 'false',
                    'data' => $AM_Confirm), 200
                )->setCallback(Input::get('callback'));
    }

    public static function Follow_Person($uid,$islocal='local') {
        $UC = new UserClass();
        $myci = $UC->userCircle($uid, 0);
        $AM_Confirm = DB::table('user as u')
                        ->leftJoin('user_friend as f', 'u.id', '=', 'f.fid')
                        ->where('f.uid', $uid)->where('u.id', '!=', $uid)->where('f.follow', '1')->groupBy('f.fid')->orderBy('u.id', 'ASC')
                        ->select('u.id', 'u.Uname', 'u.Name', 'u.Family', 'u.Summary', 'u.Pic')->get();
        foreach ($AM_Confirm as $row) {
            $tid = $row->id;
            $AC = DB::table('user_friend as f')
                            ->Join('user_friend_circle as c', 'c.fid', '=', 'f.id')
                            ->where('f.uid', $uid)->where('f.fid', $tid)->select('c.cid')->groupBy('c.cid')->get();
            $row->Circles = $AC;
            $row->Mycircle = $myci;
        }
        if($islocal=='local')
            return $AM_Confirm;
        else
            FunctionsClass::JSON ($AM_Confirm, false);
     
    }

    public static function Group_meFollow($uid) {
        $AM_Confirm = DB::table('user_group as g')
                        ->leftJoin('user_group_member as m', 'g.id', '=', 'm.gid')
                        ->where('m.uid', $uid)->where('m.admin', '0')->where('m.follow', '1')->where('g.isorgan', '0')
                        ->orderBy('m.reg_date', 'ASC')
                        ->select('g.id', 'g.uid', 'g.name', 'g.summary', 'g.link', 'g.pic')->get();
        return Response::json(array(
                    'error' => 'false',
                    'data' => $AM_Confirm), 200
                )->setCallback(Input::get('callback'));
    }

    public static function Group_MyAdmin($uid) {
        $AM_Confirm = DB::table('user_group as g')
                        ->leftJoin('user_group_member as m', 'g.id', '=', 'm.gid')
                        ->where('m.uid', $uid)->where('m.admin', '1')->where('g.isorgan', '0')
                        ->orderBy('m.reg_date', 'ASC')
                        ->select('g.id', 'g.uid', 'g.name', 'g.summary', 'g.link', 'g.pic')->get();
        return Response::json(array(
                    'error' => 'false',
                    'data' => $AM_Confirm), 200
                )->setCallback(Input::get('callback'));
    }

    public static function Group_IN($uid) {
        $AM_Confirm = DB::table('user_group as g')
                        ->leftJoin('user_group_member as m', 'g.id', '=', 'm.gid')
                        ->where('m.uid', $uid)->where('m.relation', '2')->where('g.isorgan', '0')
                        ->orderBy('m.reg_date', 'ASC')
                        ->select('g.id', 'g.uid', 'g.name', 'g.summary', 'g.link', 'g.pic')->get();
        return Response::json(array(
                    'error' => 'false',
                    'data' => $AM_Confirm), 200
                )->setCallback(Input::get('callback'));
    }

    public static function Follow_Group($uid,$islocal='local') {
        $AM_Confirm = DB::table('user_group as g')
                        ->leftJoin('user_group_member as m', 'g.id', '=', 'm.gid')
                        ->where('m.uid', $uid)->where('m.admin', '0')->where('m.follow', '1')->where('g.isorgan', '0')
                        ->orderBy('m.reg_date', 'ASC')
                        ->select('g.id', 'g.uid', 'g.name', 'g.summary', 'g.link', 'g.pic')->get();
        if($islocal=='local')
            return $AM_Confirm;
        else
            FunctionsClass::JSON ($AM_Confirm, false);
    }

    public static function Follow_Orgs($uid,$islocal='local') {
        $AM_Confirm = DB::table('user_group as g')
                        ->leftJoin('user_group_member as m', 'g.id', '=', 'm.gid')
                        ->where('m.uid', $uid)->where('m.admin', '0')->where('m.follow', '1')->where('g.isorgan', '1')
                        ->orderBy('m.reg_date', 'ASC')
                        ->select('g.id', 'g.uid', 'g.name', 'g.summary', 'g.link', 'g.pic')->get();
       if($islocal=='local')
            return $AM_Confirm;
        else
            FunctionsClass::JSON ($AM_Confirm, false);
    }

    public static function OrganMyadmin($uid) {
        $AM_Confirm = DB::table('user_group as g')
                        ->leftJoin('user_group_member as m', 'g.id', '=', 'm.gid')
                        ->where('m.uid', $uid)->where('m.admin', '1')->where('g.isorgan', '1')
                        ->orderBy('m.reg_date', 'ASC')
                        ->select('g.id', 'g.uid', 'g.name', 'g.summary', 'g.link', 'g.pic')->get();
        return Response::json(array(
                    'error' => 'false',
                    'data' => $AM_Confirm), 200
                )->setCallback(Input::get('callback'));
    }

    public static function OrganIn($uid) {
        $AM_Confirm = DB::table('user_group as g')
                        ->leftJoin('user_group_member as m', 'g.id', '=', 'm.gid')
                        ->where('m.uid', $uid)->where('m.admin', '0')->where('g.isorgan', '1')
                        ->orderBy('m.reg_date', 'ASC')
                        ->select('g.id', 'g.uid', 'g.name', 'g.summary', 'g.link', 'g.pic')->get();
        return Response::json(array(
                    'error' => 'false',
                    'data' => $AM_Confirm), 200
                )->setCallback(Input::get('callback'));
    }

    public static function Groups($uid) {
        $AM_Confirm = DB::table('user_group as g')
                        ->leftJoin('user_group_member as m', 'g.id', '=', 'm.gid')
                        ->where('m.uid', $uid)->where('g.isorgan', '0')
                        ->orderBy('m.reg_date', 'ASC')
                        ->select('g.id', 'g.uid', 'g.name', 'g.summary', 'g.link', 'g.pic')->get();
        return Response::json(array(
                    'error' => 'false',
                    'data' => $AM_Confirm), 200
                )->setCallback(Input::get('callback'));
    }

    public static function Rel_myCircle($uid, $Cid,$islocal='local') {
        $UC = new UserClass();
        $myci = $UC->userCircle($uid, 0);
        $AM_Confirm = DB::table('user as u')
                        ->leftJoin('user_friend as f', 'u.id', '=', 'f.fid')
                        ->leftJoin('user_friend_circle as c', 'f.id', '=', 'c.fid')
                        ->where('f.uid', $uid)->where('u.id', '!=', $uid)->where('c.cid', $Cid)->groupBy('f.fid')->orderBy('u.id', 'ASC')
                        ->select('u.id', 'u.Uname', 'u.Name', 'u.Family', 'u.Summary', 'u.Pic')->get();
        foreach ($AM_Confirm as $row) {
            $tid = $row->id;
            $AC = DB::table('user_friend as f')
                            ->Join('user_friend_circle as c', 'c.fid', '=', 'f.id')
                            ->where('f.uid', $uid)->where('f.fid', $tid)->select('c.cid')->groupBy('c.cid')->get();
            $row->Circles = $AC;
            $row->Mycircle = $myci;
        }
        if($islocal=='local')
            return $AM_Confirm;
        else
            FunctionsClass::JSON ($AM_Confirm, false);
       
    }

    public static function Circles($uid) {
        $UC = new UserClass();
        $myci = $UC->userCircle($uid, 0);
        $AM_Confirm = DB::table('user as u')
                        ->leftJoin('user_circle as uc', 'u.id', '=', 'uc.uid')
                        ->leftJoin('user_friend as f', 'u.id', '=', 'f.fid')
                        ->leftJoin('user_friend_circle as c', 'f.id', '=', 'c.fid')
                        ->where('f.uid', $uid)->where('u.id', '!=', $uid)->groupBy('f.fid')->orderBy('u.id', 'ASC')
                        ->select('u.id', 'u.Uname', 'u.Name', 'u.Family', 'u.Summary', 'u.Pic')->get();
        foreach ($AM_Confirm as $row) {
            $tid = $row->id;
            $AC = DB::table('user_friend as f')
                            ->Join('user_friend_circle as c', 'c.fid', '=', 'f.id')
                            ->where('f.uid', $uid)->where('f.fid', $tid)->select('c.cid')->groupBy('c.cid')->get();
            $row->Circles = $AC;
            $row->Mycircle = $myci;
        }
        return Response::json(array(
                    'error' => 'false',
                    'data' => $AM_Confirm), 200
                )->setCallback(Input::get('callback'));
    }

    public static function Rel_myFollow($uid) {
        $UC = new UserClass();
        $myci = $UC->userCircle($uid, 0);
        $AM_Confirm = DB::table('user as u')
                        ->leftJoin('user_friend as f', 'u.id', '=', 'f.uid')
                        ->where('f.fid', $uid)->where('u.id', '!=', $uid)->where('f.follow', '1')->groupBy('f.uid')->orderBy('u.id', 'ASC')
                        ->select('u.id', 'u.Uname', 'u.Name', 'u.Family', 'u.Summary', 'u.Pic')->get();
        foreach ($AM_Confirm as $row) {
            $tid = $row->id;
            $AC = DB::table('user_friend as f')
                            ->Join('user_friend_circle as c', 'c.fid', '=', 'f.id')
                            ->where('f.uid', $uid)->where('f.fid', $tid)->select('c.cid')->groupBy('c.cid')->get();
            $row->Circles = $AC;
            $row->Mycircle = $myci;
        }
        return $AM_Confirm;
    }

    public static function Rel_InCircle($uid,$islocal='local') {
        $UC = new UserClass();
        $myci = $UC->userCircle($uid, 0);
        $AM_Confirm = DB::table('user as u')
                        ->leftJoin('user_friend as f', 'u.id', '=', 'f.uid')
                        ->where('f.fid', $uid)->where('u.id', '!=', $uid)->where('f.relation', '1')->groupBy('f.uid')->orderBy('u.id', 'ASC')
                        ->select('u.id', 'u.Uname', 'u.Name', 'u.Family', 'u.Summary', 'u.Pic')->get();
        foreach ($AM_Confirm as $row) {
            $tid = $row->id;
            $AC = DB::table('user_friend as f')
                            ->Join('user_friend_circle as c', 'c.fid', '=', 'f.id')
                            ->where('f.uid', $uid)->where('f.fid', $tid)->select('c.cid')->groupBy('c.cid')->get();
            $row->Circles = $AC;
            $row->Mycircle = $myci;
        }
if($islocal=='local')
            return $AM_Confirm;
        else
            FunctionsClass::JSON ($AM_Confirm, false);
    }

    public static function Group_meMan($gid, $uid,$islocal='local') {

        $AboutGroup = DB::table('user_group')->where('id', $gid)->select('id', 'pic', 'name', 'link', 'summary', 'descrip')->first();
        $GroupMems = Relation::GroupMmebers($gid, $uid);
        $Group['about'] = $AboutGroup;
        $Group['admin'] = '';
        $Group['members'] = $GroupMems;
        if($islocal=='local')
            return $Group;
        else
            FunctionsClass::JSON ($Group, false);
        
    }

    public static function GroupMmebers($gid, $uid) {
        $UC = new UserClass();
        $myci = $UC->userCircle($uid, 0);
        $AM_Confirm = DB::table('user as u')
                        ->Join('user_group_member as f', 'u.id', '=', 'f.uid')
                        ->where('f.gid', $gid)->where('f.uid', '!=', $uid)->where('f.relation', '2')->groupBy('f.uid')->orderBy('u.id', 'ASC')
                        ->select('u.id', 'u.Uname', 'u.Name', 'u.Family', 'u.Summary', 'u.Pic')->get();

        foreach ($AM_Confirm as $row) {
            $tid = $row->id;
            $AC = DB::table('user_friend as f')
                            ->Join('user_friend_circle as c', 'c.fid', '=', 'f.id')
                            ->where('f.uid', $uid)->where('f.fid', $tid)->select('c.cid')->groupBy('c.cid')->get();
            $row->Circles = $AC;
            $row->Mycircle = $myci;
        }
        return $AM_Confirm;
    }

    public static function Group_meReg($gid, $uid) {

        $AboutGroup = DB::table('user_group')->where('id', $gid)->select('id', 'pic', 'name', 'link', 'summary', 'descrip')->first();
        $GroupMems = Relation::GroupMmebers($gid, $uid);
        $Groupadmin = Relation::GroupAdmin($gid, $uid);

        $Group['about'] = $AboutGroup;
        $Group['admin'] = $Groupadmin;

        $Group['members'] = $GroupMems;
        return $Group;
    }

    public static function GroupAdmin($gid, $uid) {
        $UC = new UserClass();
        $myci = $UC->userCircle($uid, 0);
        $AM_Confirm = DB::table('user as u')
                        ->Join('user_group as f', 'u.id', '=', 'f.uid')
                        ->where('f.id', $gid)
                        ->select('u.id', 'u.Uname', 'u.Name', 'u.Family', 'u.Summary', 'u.Pic')->first();

        $tid = $AM_Confirm->id;
        $AC = DB::table('user_friend as f')
                        ->Join('user_friend_circle as c', 'c.fid', '=', 'f.id')
                        ->where('f.uid', $uid)->where('f.fid', $tid)->select('c.cid')->groupBy('c.cid')->get();
        $AM_Confirm->Circles = $AC;
        $AM_Confirm->Mycircle = $myci;
        return $AM_Confirm;
    }

}
