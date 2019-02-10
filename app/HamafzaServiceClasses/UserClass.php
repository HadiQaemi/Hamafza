<?php

namespace App\HamafzaServiceClasses;

use App\Models\hamafza\UserGroup;
use Request;
use Illuminate\Support\Facades\DB;
use App\HamafzaPublicClasses\FunctionsClass;

class UserClass
{
    public function Bookmark($uid, $sesid, $title, $type, $tid)
    {
        if ($type == 'user' || $type == 'my')
        {

        }
        if ($type == 'user_group')
        {
            $sql = " SELECT ug.`name`,ug.link FROM user_group as ug WHERE ug.id ={$tid}";
            $query = mysql_query($sql);
            while ($row1 = mysql_fetch_assoc($query))
            {
                $title = ' گروه ' . $row1['name'];
                $tid = $row1['link'];
            }
        }
        if ($type == 'subjects')
        {
            $sr = DB::table('pages AS p')
                ->join('subjects as s', 's.id', '=', 'p.sid')
                ->join('subject_type_tab AS stt', 'stt.stid', '=', 's.kind')
                ->where('p.id', $tid)
                ->select('stt.name')
                ->count();
            if ($sr == 1)
            {
                $title = $title;
            }
            else
            {
                if ($sr > 1)
                {
                    $s = DB::table('pages AS p')->join('subjects as s', 's.id', '=', 'p.sid')
                        ->leftJoin('subject_type_tab AS stt', function ($join)
                        {
                            $join->on('stt.stid', '=', 's.kind');
                            $join->on('p.type', '=', 'stt.tid');
                        })
                        ->where('p.id', $tid)->select('stt.name')->first();
                    $title = $title . ' (' . $s->name . ')';
                }
            }
        }

        $book = DB::table('bookmarks')->where('uid', $uid)->where("link", $tid)->where('type', "$type")->count();
        if ($book == '0')
        {
            $work = DB::table('bookmarks')->insertGetId(
                array('Title' => $title, 'uid' => $uid, 'link' => $tid, 'type' => $type));
            $mes = trans('labels.bookmarkADD');
            $err = false;
        }
        else
        {
            $book = DB::table('bookmarks')->where('uid', $uid)->where("link", $tid)->where('type', $type)->delete();
            $mes = trans('labels.bookmarkRemove');
            $err = false;
        }
        return $mes;
    }

    public static function RelationManager($uid, $sesid, $type, $cid, $gid = 0)
    {

        switch ($type)
        {
            case 'Follow_Person':
                return Relation::Follow_Person($uid);
                break;
            case 'Group_meFollow':
                return Relation::Group_meFollow($uid);
                break;
            case 'Follow_Orgs':
                return Relation::Follow_Orgs($uid);
                break;
            case 'Follow_Group':
                return Relation::Follow_Group($uid);
                break;

            case 'Rel_myCircle':
                return Relation::Rel_myCircle($uid, $cid);
                break;
            case 'Rel_myFollow':
                return Relation::Rel_myFollow($uid);
                break;
            case 'Rel_InCircle':
                return Relation::Rel_InCircle($uid);
                break;
            case 'Group_meMan':
                return Relation::Group_meMan($gid, $uid);
                break;
            case 'Group_meReg':
                return Relation::Group_meReg($gid, $uid);
                break;
            case 'OrganMyadmin':
                return Relation::OrganMyadmin($uid);
                break;
            case 'OrganIn':
                return Relation::OrganIn($uid);
                break;
            case 'Groups':
                return Relation::Groups($uid);
                break;
            case 'Group_MyAdmin':
                return Relation::Group_MyAdmin($uid);
                break;
            case 'Group_IN':
                return Relation::Group_IN($uid);
                break;
            case 'Circles':
                return Relation::Circles($uid);
                break;
            case 'followed':
                return Relation::Follow_Person($uid);
                break;
            case 'Rel_FollowME':
                return Relation::Rel_FollowME($uid);
                break;
        }
    }

    public static function GetSecGroup($uid, $sesid)
    {
        $user = UserClass::CheckLogin($uid, $sesid);
        $user = ($user == TRUE) ? 'true' : 'false';
        if ($user)
        {
            if (UserClass::permission('manage_users', $uid) == '1')
            {
                $Ret = DB::table('sec_groups')->get();
                $err = false;
            }
            else
            {
                $err = true;
                $Ret = trans('labels.AdminFail');
            }
        }
        else
        {
            $err = true;
            $Ret = trans('labels.FailUser');
        }
        return $Ret;
    }

    public function searchPerson($uid = 0, $term, $type)
    {
        $Users = array();
        $Groups = array();
        $Organs = array();
        if ($type == 0)
        {
            $Users = DB::table('user as u')->whereRaw(" (CONCAT_WS(' ',Name,Family) LIKE '%$term%' or Name LIKE '%$term%' or Family LIKE '%$term%')")
                ->select('u.id', 'u.Name', 'u.Family')->get();
            $arr = array();
            foreach ($Users as $key => $value)
            {
                $arr[$key]['id'] = $value->id;
                $arr[$key]['name'] = $value->Name . ' ' . $value->Family;
            }
            return $arr;
        }
        if ($type == 1)
        {
            $Users = DB::table('user as u')->whereRaw("CONCAT_WS(' ',Name,Family) LIKE '%$term%' OR Summary LIKE '%$term%' ")
                ->select('u.id', 'u.Uname', 'u.Name', 'u.Family', 'u.Summary', 'u.Pic', 'u.avatar')->get();
            foreach ($Users as $value)
            {
                if ($uid != 0)
                {
                    $querys = DB::table('user_friend as f')->join('user_friend_circle as c', 'f.id', '=', 'c.fid')
                        ->where("f.uid", $uid)->where("f.fid", $value->id)->select('relation', 'follow', 'like')->first();
                    if ($querys)
                    {
                        $value->circle = '1';
                        $value->follow = ($querys->follow == '1') ? '1' : '0';
                        $value->like = ($querys->like == '1') ? '1' : '0';
                    }
                }
            }
            return $Users;
        }
        if ($type == 2)
        {
            $Groups = UserGroup::select('user_group.id', 'user_group.name', 'user_group.link', 'user_group.summary', 'user_group.pic')
                ->where('isorgan', 0)
                ->where(function ($query) use ($term) {
                    $query->where('link', 'like', "%$term%")
                        ->orWhere('name', 'LIKE', "%$term%")
                        ->orWhere('summary', 'LIKE', "%$term%");
                })
                ->with('post_view_count')
                ->take(4)->get();

//            $Groups = DB::table('user_group')->whereRaw("(link LIKE '%$term%' OR name  '%$term%' OR summary LIKE '%$term%') and isorgan='0'")
//                ->select('id', 'name', 'link', 'summary', 'pic')->get();
            return $Groups;
        }
        if ($type == 3)
        {
            $Organs = UserGroup::select('user_group.id', 'user_group.name', 'user_group.link', 'user_group.summary', 'user_group.pic')
                    ->where('isorgan', 1)
                ->where(function ($query) use ($term) {
                    $query->where('link', 'like', "%$term%")
                        ->orWhere('name', 'LIKE', "%$term%")
                    ->orWhere('summary', 'LIKE', "%$term%");
                })
                    ->with('post_view_count')
                    ->take(4)->get();
            return $Organs;
        }
    }

    public function DesktopDashboard($uid)
    {
        $Res = array();
        $Res['Measure'] = DashboardClass::NumberofMeasures($uid);
        $Res['SMS'] = DashboardClass::SMS($uid);
        $Res['Sale'] = DashboardClass::SaleReports($uid);
        $Res['Forms'] = DashboardClass::Forms($uid);
        $Res['Emails'] = DashboardClass::Emails($uid);
        if (UserClass::permission('manage_users', $uid) == '1')
        {
            $Res['NumberofUsers'] = DashboardClass::NumberofUsers($uid);
        }
        $err = false;
        $mes = $Res;

        return $mes;
    }

    public function ChangeUserSettingPAs($uid, $sesid, $user_name, $user_mail, $user_pass)
    {
        $user = UserClass::CheckLogin($uid, $sesid);
        if ($user == TRUE)
        {
            $user_name = trim(PublicsClass::Filter($user_name));
            $user_mail = trim(PublicsClass::Filter($user_mail));
            $user_pass = trim(PublicsClass::Filter($user_pass));
            $Uname = DB::table('user')->where('id', '=', $uid)->select('Uname')->first();
            if ($Uname->Uname == $user_name)
            {
                $password = UserController::generateHashStatic($user_pass);
                DB::table('users')->where('name', '=', $user_name)->update(array('password' => $password, 'salt' => '0'));
            }
            $message = trans('labels.USerEditOK');
            $error = false;
        }
        else
        {
            $mes = trans('labels.FailUser');
            $error = true;
        }
        return response()->json(array(
            'error' => $error,
            'data' => $message), 200
        )->setCallback(Request::input('callback'));
    }

    public function ChangeUserSetting($uid, $sesid, $user_name, $user_family, $user_summary, $delpic, $newpic)
    {
        $message = '0';

        $user_name = trim(PublicsClass::Filter($user_name));
        $user_family = trim(PublicsClass::Filter($user_family));
        $user_summary = trim(PublicsClass::Filter($user_summary));
        DB::table('user')->where('id', '=', $uid)->update(['Name' => $user_name, 'Family' => $user_family, 'Summary' => $user_summary]);
        if ($delpic == '1')
        {
            DB::table('user')->where('id', '=', $uid)->update(['Pic' => '']);
        }
        if ($newpic != '')
        {
            DB::table('user')->where('id', '=', $uid)->update(['Pic' => $newpic]);
        }
        $message = trans('labels.USerEditOK');
        $error = false;

        return $message;
    }

    public function FollowRemove($uid, $userid)
    {
        DB::table('user_friend')
            ->where('uid', '=', $uid)
            ->where('fid', '=', $userid)
            ->update(['follow' => '0']);
        DB::table('user')
            ->where('id', '=', $userid)
            ->decrement('follow');
        $message = trans('labels.followRemove');
        return $message;
    }

    public function FollowADD($uid, $userid)
    {
        $friend = DB::table('user_friend')
            ->where('uid', '=', $uid)
            ->where('fid', '=', $userid)
            ->count();
        if ($friend > 0)
        {
            DB::table('user_friend')
                ->where('uid', '=', $uid)
                ->where('fid', '=', $userid)
                ->update(['follow' => '1']);
        }
        else
        {
            DB::table('user_friend')
                ->insert(['uid' => $uid, 'fid' => $userid, 'follow' => '1']);
        }
        DB::table('user')->where('id', '=', $userid)->increment('follow');

        $message = trans('labels.followOK');
        return $message;
    }

    public function LikeADD($uid, $userid)
    {
        $friend = DB::table('user_friend')->where('uid', '=', $uid)->where('fid', '=', $userid)->count();
        if ($friend > 0)
        {
            DB::table('user_friend')->where('uid', '=', $uid)->where('fid', '=', $userid)->update(['like' => '1']);
            DB::table('user')->where('id', '=', $userid)->increment('like');
        }
        else
        {
            DB::table('user_friend')->insert(['uid' => $uid, 'fid' => $userid, 'like' => '1']);
            DB::table('user')->where('id', '=', $userid)->increment('like');
        }
        $message = trans('labels.LikeOK');
        return $message;
    }

    public function LikeRemove($uid, $userid)
    {
        DB::table('user_friend')->where('uid', '=', $uid)->where('fid', '=', $userid)->update(['like' => '0']);
        DB::table('user')->where('id', '=', $userid)->decrement('like');;
        $message = trans('labels.LikeRemove');
        return $message;
    }

    public function HomeDashboard($uid, $sesid, $islocal = 'local')
    {
        $user = UserClass::CheckLogin($uid, $sesid, $islocal);
        if ($user == TRUE)
        {
            $result = "";
//            $AM_EghdamNew = DB::table('actions as a')
//                ->leftJoin('action_recieve as r', 'a.id', '=', 'r.mid')
//                ->leftJoin('user as u', 'u.id', '=', 'a.admin')
//                ->leftJoin('pages as p', 'p.id', '=', 'a.pid')
//                ->leftJoin('subjects as s', 's.id', '=', 'p.sid')
//                ->where('r.uid', $uid)
//                ->where('is_bc', '0')
//                ->where('r.checked', '1')
//                ->select('r.id')
//                ->groupBy('a.id')->count();
            $AM_EghdamNew = DB::table('hamahang_task')
                ->select("hamahang_task_assignments.id as assignment_id","hamahang_task_status.type as task_status","hamahang_task.schedule_time", "hamahang_task.schedule_id", "hamahang_task.use_type", "hamahang_task.duration_timestamp", "hamahang_task.created_at", "user.Uname", "user.Name", "user.Family", DB::raw('CONCAT("user.Name"," ","user.Family") AS employee'), "hamahang_task.id", "hamahang_task.title", "hamahang_task_priority.immediate", "hamahang_task_priority.importance")
                ->join('hamahang_task_assignments', 'hamahang_task.id', '=', 'hamahang_task_assignments.task_id')
                ->join('user', 'user.id', '=', 'hamahang_task_assignments.uid')
                ->join('hamahang_task_priority', 'hamahang_task_priority.task_id', '=', 'hamahang_task.id')
                ->join('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
                //->whereNull('hamahang_task_assignments.transmitter_id')
                ->where('hamahang_task_assignments.employee_id', '=', $uid)
                ->where('hamahang_task_assignments.status', '=', 0)
                ->whereNull('hamahang_task_assignments.reject_description')
                ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
                ->whereRaw('hamahang_task_priority.id = (select max(`id`) from hamahang_task_priority where `task_id` = hamahang_task.id)')->count();
            $res['Eghdam'] = $AM_EghdamNew;
            $AM_EmailNew = DB::table('emails')->where('uid', $uid)->where('type', 'SMS_NEW')->where('view', '0')->count();
            $res['Email'] = $AM_EmailNew;

            $AM_Group = DB::table('user_group_member as ugm')->join('user_group as ug', 'ugm.gid', '=', 'ug.id')
                ->where('ugm.uid', $uid)->where('isorgan', "0")->where('ugm.relation', '!=', "0")->select('ug.id')->count();
            $res['Group'] = $AM_Group;
            $first = DB::table('user as u')->leftJoin('user_friend as f', 'u.id', '=', 'f.fid')->where('f.uid', $uid)->select(DB::Raw('DISTINCT u.id, u.Uname, u.Name, u.Family, u.Summary, u.Pic'))->where('u.id', '!=', $uid);
            $users = DB::table('user as u')->leftJoin('user_friend as f', 'u.id', '=', 'f.fid')
                ->leftJoin('user_friend_circle as c', 'f.id', '=', 'c.fid')
                ->where('f.uid', $uid)->select(DB::Raw('DISTINCT u.id, u.Uname, u.Name, u.Family, u.Summary, u.Pic'))->where('u.id', '!=', $uid)->union($first)->get();
            $i = 0;
            foreach ($users as $value)
            {
                $i++;
            }
            $res['User'] = $i;
            $AM_Post = DB::table('posts')->where('uid', $uid)->select('id')->count();
            $res['Post'] = $AM_Post;
            $selpage = PageClass::Sel_Page();
            $AM_Subject = DB::table('subjects as s')->leftJoin('pages as p', 'p.sid', '=', 's.id')
                ->leftJoin('subject_type as st', 'st.id', '=', 's.kind')
                ->where('s.admin', $uid)->where('s.archive', '0')->whereRaw($selpage)->select('s.id')->count();
            $res['Page'] = $AM_Subject;
            $err = false;
            $mes = $res;
        }
        else
        {
            $mes = trans('labels.FailUser');
            $err = true;
        }
        if ($islocal == 'local')
        {
            return $mes;
        }
        else
        {
            return FunctionsClass::JSON($mes, $err);
        }
    }

    public function SelUser($uid, $sesid)
    {
        $mes = array();
        if ($uid != 0)
        {
            $Tree = array();
            $Trees['id'] = '0';
            $Trees['title'] = 'همه کاربران';
            $Trees['url'] = 'others';
            $Trees['parent_id'] = '#';
            array_push($Tree, $Trees);
            $Trees['id'] = '1';
            $Trees['title'] = 'گروه‌ها';
            $Trees['url'] = 'groups';
            $Trees['parent_id'] = '#';
            array_push($Tree, $Trees);
            $Trees['id'] = '2';
            $Trees['title'] = 'کانال ها';
            $Trees['url'] = 'organs';
            $Trees['parent_id'] = '#';
            array_push($Tree, $Trees);
            $Trees['id'] = '3';
            $Trees['title'] = 'حلقه  ها';
            $Trees['url'] = 'circle';
            $Trees['parent_id'] = '#';
            array_push($Tree, $Trees);

            $groups = DB::table('user_group_member as ugm')
                ->join('user_group as ug', 'ugm.gid', '=', 'ug.id')
                ->where('ugm.uid', $uid)
                ->where('isorgan', '0')
                ->where('ug.relation', '0')
                ->select('ug.id as id', 'ug.pic as pic', 'ug.name as name', 'ug.summary as summary', 'ug.link as link')
                ->groupBy('ug.id')->get();

            foreach ($groups as $value)
            {
                $Trees['id'] = 'Group_' . $value->id;
                $Trees['title'] = $value->name;
                $Trees['url'] = 'Group_' . $value->id;
                $Trees['parent_id'] = '1';
                array_push($Tree, $Trees);

                $groups2 = DB::table('user_group_member as ugm')
                    ->join('user as u', 'u.id', '=', 'ugm.uid')
                    ->where('ugm.gid', $value->id)
                    ->select('u.id as id', 'u.Name', 'u.Family', 'u.Pic', 'u.Summary')
                    ->get();
                foreach ($groups2 as $row)
                {
                    $useID = $row->id;
                    $pic = 'pics/user/Users.png';
                    if (trim($row->Pic) != '')
                    {
                        $pic = 'pics/user/' . $row->Pic;
                    }
                    $row->Pic = $pic;
                }
                $value->members = $groups2;
            }
            $organs = DB::table('user_group_member as ugm')
                ->join('user_group as ug', 'ugm.gid', '=', 'ug.id')
                ->where('ugm.uid', $uid)
                ->where('isorgan', '1')
                ->where('ug.relation', '0')
                ->where('ugm.gid', '!=', '107')
                ->select('ug.id as id', 'ug.pic as pic', 'ug.name as name', 'ug.summary as summary', 'ug.link as link')
                ->groupBy('ug.id')->get();

            foreach ($organs as $value)
            {
                $Trees['id'] = 'Organs_' . $value->id;
                $Trees['title'] = $value->name;
                $Trees['url'] = 'Organs_' . $value->id;
                $Trees['parent_id'] = '2';
                array_push($Tree, $Trees);
                $groups2 = DB::table('user_group_member as ugm')
                    ->join('user as u', 'u.id', '=', 'ugm.uid')
                    ->where('ugm.gid', $value->id)
                    ->select('u.id as id', 'u.Name', 'u.Family', 'u.Pic', 'u.Summary')
                    ->get();
                foreach ($groups2 as $row)
                {
                    $useID = $row->id;
                    $pic = 'pics/user/Users.png';
                    if (trim($row->Pic) != '')
                    {
                        $pic = 'pics/user/' . $row->Pic;
                    }
                    $row->Pic = $pic;
                }
                $value->members = $groups2;
            }

            $Circles = DB::table('user_circle')->where('uid', $uid)->select('id', 'name', 'orders', 'nums')->take(50)->get();

            foreach ($Circles as $value)
            {
                $Trees['id'] = 'Circle_' . $value->id;
                $Trees['title'] = $value->name;
                $Trees['url'] = 'Circle_' . $value->id;
                $Trees['parent_id'] = '3';
                array_push($Tree, $Trees);

                $groups2 = DB::table('user as u')
                    ->leftJoin('user_friend AS f', 'u.id', '=', 'f.fid')->leftJoin('user_friend_circle AS c', 'f.id', '=', 'c.fid')
                    ->where('f.uid', $uid)
                    ->where('u.id', '!=', $uid)
                    ->where('c.cid', $value->id)
                    ->select('u.id as id', 'u.Name', 'u.Family', 'u.Pic', 'u.Summary')
                    ->groupBy('u.id')
                    ->get();
                foreach ($groups2 as $row)
                {
                    $useID = $row->id;
                    $pic = 'pics/user/Users.png';
                    if (trim($row->Pic) != '')
                    {
                        $pic = 'pics/user/' . $row->Pic;
                    }
                    $row->Pic = $pic;
                }
                $value->members = $groups2;
            }
            $Allusers = DB::table('users as ua')
                ->join('user as u', 'ua.id', '=', 'u.user_id')
                ->where('ua.state', '1')
                ->select('u.id as id', 'u.Name', 'u.Family', 'u.Pic', 'u.Summary')
                ->get();
            foreach ($Allusers as $row)
            {
                $useID = $row->id;
                $pic = 'pics/user/Users.png';
                if (trim($row->Pic) != '')
                {
                    $pic = 'pics/user/' . $row->Pic;
                }
                $row->Pic = $pic;
            }
            $Res['Tree'] = $Tree;

            $Res['Groups'] = $groups;
            $Res['Organs'] = $organs;
            $Res['Circles'] = $Circles;
            $Res['Allusers'] = $Allusers;
            $err = false;
            $mes = $Res;
        }
        return $mes;
    }

    public function MyNotif($uid, $num)
    {
        $nums = DB::table('emails as e')
            ->where('e.uid', $uid)
            ->orderBy('id', 'desc')->count();
        if ($nums > 0)
        {
            $groups = DB::table('emails as e')
                ->where('e.uid', $uid)
                ->orderBy('id', 'desc')->select('subject', 'id', 'link')->take($num)->get();
        }
        else
        {
            $groups = trans('labels.rhightcol_usernot_no_data');
        }
        return $groups;
    }

    public function MyGroupAdmin($uid, $num, $isOrgan = 0, $isadmin = 0)
    {

        $groups = DB::table('user_group_member as ugm')
            ->join('user_group as ug', 'ugm.gid', '=', 'ug.id')
            ->whereBetween('ugm.admin',array($isadmin , 1))
            ->where('ugm.relation', 2)
            ->select('ug.id as id', 'ug.pic as Pic', 'ug.name as name', 'ug.summary as summary', 'ug.link as link', 'ug.isorgan as isorgan')
            ->where('isorgan',$isOrgan)
            ->where('ugm.uid', $uid)
            ->groupBy('ug.id')->orderBy('ug.id','desc')->take($num)->get();
        //dd($groups);

        return $groups;
    }

    public function EditUDetail($uid, $sesid, $comment, $user_name, $user_family, $user_summary, $user_gender, $udate, $City, $Province, $tel_code, $tel_number, $fax_code, $fax_number, $user_website, $user_mail, $user_mobile)
    {

        $r = DB::table('user_profile')->where('uid', $uid)->select('id')->count();
        if ($r > 0)
        {
            DB::table('user_profile')
                ->where('uid', $uid)
                ->update(array('Mobile' => $user_mobile, 'Tel_code' => $tel_code, 'province' => $Province, 'city' => $City,
                    'Tel_number' => $tel_number, 'Fax_code' => $fax_code, 'Fax_number' => $fax_number, 'Website' => $user_website,
                    'Comment' => $comment));
        }
        else
        {
            DB::table('user_profile')
                ->Insert(array('Mobile' => $user_mobile, 'Tel_code' => $tel_code, 'province' => $Province, 'city' => $City,
                    'Tel_number' => $tel_number, 'Fax_code' => $fax_code, 'Fax_number' => $fax_number, 'Website' => $user_website,
                    'Comment' => $comment, 'uid' => $uid));
        }
        DB::table('user')
            ->where('id', $uid)
            ->update(array('Name' => $user_name, 'Family' => $user_family, 'gender' => $user_gender, 'Summary' => $user_summary));
        $err = false;
        $mes = trans('labels.user_det_ok');

        return $mes;
    }

    public function EditUE($uid, $sesid, $comment, $location, $id, $trend, $level, $University, $Province, $City, $sdate, $edate)
    {

        if ($id == '0')
        {
            DB::table('user_education')->insert(array('location' => $location, 'university' => $University, 'province' => $Province, 'city' => $City,
                'start_year' => $sdate, 'end_year' => $edate, 'grade' => $level, 'major' => $trend,
                'comment' => $comment, 'uid' => $uid));
            $mes = trans('labels.user_education_ok');
        }
        else
        {
            $i = DB::table('user_education')->where('uid', $uid)->where('id', $id)->count();
            if ($i == 1)
            {
                if ($comment == 'DelDelHDelDel')
                {
                    DB::table('user_education')->where('id', $id)->delete();
                    $mes = trans('labels.user_education_del');
                }
                else
                {
                    DB::table('user_education')
                        ->where('id', $id)
                        ->update(array('location' => $location, 'university' => $University, 'province' => $Province, 'city' => $City,
                            'start_year' => $sdate, 'end_year' => $edate, 'level' => $level, 'trend' => $trend,
                            'comment' => $comment));
                    $mes = trans('labels.user_education_ok');
                }
            }
            else
            {
                $mes = trans('labels.FailUser');
                $err = true;
            }
        }
        $err = false;

        return $mes;
    }

    public function EditUW($uid, $sesid, $comment, $title, $id, $company, $vahed, $Province, $City, $sdate, $edate)
    {

        if ($id == '0')
        {
            DB::table('user_work')->insert(array('post' => $title, 'company' => $company, 'province_id' => $Province, 'city_id' => $City,
                'start_year' => $sdate, 'end_year' => $edate, 'section' => $vahed,
                'comment' => $comment, 'uid' => $uid));
            $mes = trans('labels.user_work_ok');
        }
        else
        {
            $i = DB::table('user_work')->where('uid', $uid)->where('id', $id)->count();

            if ($i == 1)
            {
                if ($title == 'DelDelHDelDel' && $comment == 'DelDelHDelDel')
                {
                    DB::table('user_work')->where('id', $id)->delete();
                    $mes = trans('labels.user_work_del');
                }
                else
                {
                    DB::table('user_work')
                        ->where('id', $id)
                        ->update(array('post' => $title, 'company' => $company, 'province_id' => $Province, 'city_id' => $City,
                            'start_year' => $sdate, 'end_year' => $edate, 'section' => $vahed,
                            'comment' => $comment));
                    $mes = trans('labels.user_work_ok');
                }
            }
            else
            {
                $mes = trans('labels.FailUser');
                $err = true;
            }
        }
        $err = false;

        return $mes;
    }

    public function EditUP($uid, $sesid, $comment, $title, $id, $UPvals)
    {
        $sss = '';
        $UPvals = json_decode($UPvals);
        DB::table('user_special')->where('user_id', $uid)->delete();
        DB::table('user_key')->where('user_id', $uid)->delete();
        foreach ($UPvals as $value)
        {
            $title = $value->name;
            if (is_numeric($value->id))
            {
                DB::table('user_special')->insert(array('name' => $title, 'user_id' => $uid));
                DB::table('user_key')->insert(array('kid' => $value->id, 'user_id' => $uid));
            }
            else
            {
                $keyid = DB::table('keywords')->insertGetid(array('keyword' => $title, 'uid' => $uid, 'ttype' => '17'));
                DB::table('user_key')->insert(array('kid' => $keyid, 'uid' => $uid));

                DB::table('user_special')->insert(array('name' => $title, 'user_id' => $uid));
            }
        }
        return trans('labels.user_special_ok');
        if ($id == '0')
        {
            $mes = trans('labels.user_special_ok');
        }
        else
        {
            if ($title == 'DelDelHDelDel' && $comment == 'DelDelHDelDel')
            {
                DB::table('user_special')->where('id', $id)->delete();
                $mes = trans('labels.user_special_del');
            }
            else
            {
                DB::table('user_special')
                    ->where('id', $id)
                    ->update(array('name' => $title, 'comment' => $comment));
                $mes = trans('labels.user_special_ok');
            }
        }
        $err = false;
        return $mes;
    }

    public function user_tools($sesid, $uid, $userid = 0, $Type = '', $subtype, $islocal = '')
    {
        //return $subtype;
        $user = UserClass::CheckLogin($uid, $sesid);
        if ($user == TRUE)
        {
            $user = 'true';
        }
        else
        {
            $user = 'false';
        }
        if ($Type == 'user-my' && $subtype == 'about')
        {
            $help = PublicsClass::HelpManage(0, 'Moarefi', 'user_page');
        }
        elseif ($Type == '' && $subtype == 'moarefi')
        {
            $help = PublicsClass::HelpManage(0, 'Moarefi', 'user_page');
        }
        elseif ($Type == '' && $subtype != 'moarefi')
        {
            $help = PublicsClass::HelpManage(0, $subtype, 'user_page');
        }
        elseif ($Type == 'userpage' && $subtype == 'about')
        {
            $help = PublicsClass::HelpManage(0, 'Moarefi', 'user_page');
        }
        elseif ($Type != '' && $subtype != 'moarefi')
        {
            $help = PublicsClass::HelpManage(0, $subtype, 'user_page');
        }
        // $help=$Type.'+'.$subtype;
        if ($uid != 0)
        {
            if ($Type != 'user-my')
            {
                $pageDet = DB::table('user_friend')
                    ->where('uid', $uid)->where('fid', $userid)->select('id', 'relation', 'follow', 'like')->first();
                $res = array();
                if ($pageDet)
                {
                    $res['like'] = $pageDet->like;
                    $res['follow'] = $pageDet->follow;
                    $res['relation'] = $pageDet->relation;
                }
                else
                {
                    $res['like'] = '0';
                    $res['follow'] = 0;
                    $res['relation'] = 0;
                }
            }
            else
            {
                $res['like'] = '0';
                $res['follow'] = 0;
                $res['relation'] = 0;
            }
            $qty = ($Type == 'userpage') ? 'user' : 'user-my';
            $Taamol = array();
            $Abzar = array();
            $i = 1;
            $menutools = DB::table('tools_group')->orderBy('orders')->get();
            foreach ($menutools as $value)
            {
                $toolsCount = DB::table('tools')->where($qty, '1')->where('menuid', $value->id)->select('id')->count();

                $tools = DB::table('tools')->where($qty, '1')->where('menuid', $value->id)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->get();
                if ($toolsCount > 0)
                {
                    $Taamol['label'] = $value->name;
                    $Taamol['tools'] = $tools;
                    $Abzar[$i] = $Taamol;
                }

                $i++;
            }
        }
        else
        {
            $Taamol = array();
            $Abzar = array();
            $i = 1;
            $menutools = DB::table('tools_group')->orderBy('orders')->get();
            foreach ($menutools as $value)
            {
                $toolsCount = DB::table('tools')->where('user', '1')->where('menuid', $value->id)->where('login', '>', 0)->select('id')->count();
                $tools = DB::table('tools')->where('user', '1')->where('menuid', $value->id)->where('login', '>', 0)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->get();
                if ($toolsCount > 0)
                {
                    $Taamol['label'] = $value->name;
                    $Taamol['tools'] = $tools;
                    $Abzar[$i] = $Taamol;
                }

                $i++;
            }
        }


        $lang['like'] = trans('labels.Like');
        $lang['disLike'] = trans('labels.disLike');

        $lang['follow'] = trans('labels.follow');
        $lang['unfollow'] = trans('labels.unfollow');
        $res['comment'] = 'comment';
        $lang['comment'] = trans('labels.comment');
        $lang['uncomment'] = trans('labels.comment');


        $lang['relation'] = '0';


        if ($Type != 'user-my')
        {
            $Ret['val'] = $res;
            $Ret['label'] = $lang;
        }
        $Ret['Help'] = $help;
        $Ret['othermenus'] = $Abzar;
//-----------------------

        if ($islocal == 'local')
        {
            return $Ret;
        }
        else
        {
            \App\HamafzaPublicClasses\FunctionsClass::JSON($Ret, false);
        }
    }

    public static function CheckLogin($ui, $session_id, $islocal = 'local')
    {
        $LC = new LoginClass();
        $n = $LC->CheckLogin_uid($ui, $session_id, $islocal);
        return $n;
    }

    public function UserName2id($name)
    {
        $User = DB::table('users as uss')->join('user as u', 'uss.id', '=', 'u.user_id')
            ->where('uss.name', $name)->select('u.id')->first();
        if ($User)
        {
            return $User->id;
        }
        else
        {
            return 0;
        }
    }

    public function GetMyWall($uname, $session_id, $cuid, $islocal = '')
    {
        $PostsClass = new PostsClass();
        return $PostsClass->MyWall($uname, $cuid, 10, $islocal);
    }

    public function AddCircle($uid, $sesid, $targetuid, $circle, $In)
    {
        $c = DB::table('user_friend')->where('uid', $uid)->where('fid', $targetuid)->select('id')->count();
        if ($c > 0)
        {
            $ufid = DB::table('user_friend')->where('uid', $uid)->where('fid', $targetuid)->select('id')->first();
            $ufid = $ufid->id;
        }
        elseif ($c == 0)
        {
            $ufid = DB::table('user_friend')->insertGetId(array('uid' => $uid, 'fid' => $targetuid));
        }
        if ($In == '0')
        {
            DB::table('user_friend_circle')->insertGetId(array('cid' => $circle, 'fid' => $ufid));
            $message = 'اضافه شد';
        }
        else
        {
            DB::table('user_friend_circle')->where('cid', $circle)->where('fid', $ufid)->delete();

            $message = 'حذف شد';
        }
        return $message;
    }

    public function MyBookmark($uid)
    {

        return $message;
    }

    public function user_special($uid, $user)
    {
        return ['0',''];
        /*if ($uid == 'my')
        {
            $uid = $user;
        }
        $us = DB::table('user_special')->where('uid', $uid)->select('id', 'name', 'score', 'comment')->orderBy('orders')->get();
        foreach ($us as $value)
        {
            $name = $value->name;
            $key = DB::table('keywords')
                ->where('title', $name)
                ->select('id')
                ->first();
            $value->keyid = ($key) ? $key->id : 0;
            $ussr = DB::table('user_special_endorse as usd')
                ->join('user as u', 'usd.uid', '=', 'u.id')
                ->where('usspecialid', $value->id)
                ->select('u.Uname', 'u.Name', 'u.Family', 'u.id', 'Pic')
                ->get();
            $value->endorse = $ussr;
            $endorsed = DB::table('user_special_endorse as usd')
                ->where('usspecialid', $value->id)
                ->where('uid', $user)
                ->count();
            $value->endorsed = $endorsed;
        }

        $uss[0] = trans('labels.user_special');
        $uss[1] = $us;
        return $uss;*/
    }

    public function user_work($uid, $user)
    {
        if ($uid == 'my')
        {
            $uid = $user;
        }
        $uw = DB::table('user_work as u')
            ->leftJoin('province as p', 'p.id', '=', 'u.province_id')
            ->leftJoin('city as c', 'c.id', '=', 'u.city_id')
            ->where('u.uid', $uid)
            ->select('u.id', 'company', 'post', 'comment', 'start_year', 'end_year', 'section', 'c.city as city', 'c.id as cid', 'p.province as province', 'p.id as pid')
            ->orderBy('order')
            ->orderBy('id')->get();
        $uws[0] = trans('labels.user_work');
        $uws[1] = $uw;
        return $uws;
    }

    public function user_education($uid, $user)
    {
        if ($uid == 'my')
        {
            $uid = $user;
        }
        $ue = DB::table('user_education')->where('uid', $uid)->select('id', 'university', 'grade', 'major', 'comment', 'start_year', 'end_year')->orderBy('order')->orderBy('id')->get();
        $ues[0] = trans('labels.user_education');
        $ues[1] = $ue;
        return $ues;
    }

    public function user_tutorial($uid, $user)
    {
        if ($uid == 'my')
        {
            $uid = $user;
        }
        $ut = DB::table('user_tutorial')->where('uid', $uid)->select('id', 'company', 'course', 'comment', 'n_hour', 's_year')->orderBy('orders')->orderBy('id')->get();
        $uts[0] = trans('labels.user_tutorial');
        $uts[1] = $ut;
        return $uts;
    }

    public function user_other($uid, $user)
    {
        if ($uid == 'my')
        {
            $uid = $user;
        }
        $uo = DB::table('user_other')->where('uid', $uid)->select('id', 'comment', 'name')->orderBy('id')->get();
        $uos[0] = trans('labels.user_other');
        $uos[1] = $uo;
        return $uos;
    }

    public function About($uid, $cuid, $islocal = '')
    {
        $user = $cuid;
        $Aboute = array();
        $Aboute1 = array();
        $User = DB::table('user as u')
            ->leftJoin('user_profile as p', 'u.id', '=', 'p.uid')
            ->leftJoin('city as c', 'c.id', '=', 'p.City')
            ->where('u.id', $uid)
            ->distinct()
            ->select(
                'u.id',
                    'u.Uname as Uname',
                    'u.Name',
                    'u.Family',
                    'u.Email',
                    'u.SecGroups',
                    'Gender',
                    'Summary',
                    'Pic',
                    'Tel_number',
                    'Tel_code',
                    'Fax_code',
                    'Fax_number',
                    'Website',
                    'p.City',
                    'c.city as Shahr',
                    'p.Mobile',
                    'p.Province',
                    'p.Comment as Comment'
            )->first();
        if ($User)
        {
            $Aboute1['Mobile'] = $User->Mobile;
            $Aboute1['Comment'] = $User->Comment;
            $Aboute1['Tel_number'] = $User->Tel_number;
            $Aboute1['Tel_code'] = $User->Tel_code;
            $Aboute1['Fax_code'] = $User->Fax_code;
            $Aboute1['Fax_number'] = $User->Fax_number;
            $Aboute1['Website'] = $User->Website;
            $Aboute1['SecGroups'] = $User->SecGroups;
            $Aboute1['Province'] = $User->Province;
            $Aboute1['City'] = $User->City;
            $Aboute1['Shahr'] = $User->Shahr;
            $Aboute1['id'] = $User->id;
            $Aboute1['UName'] = $User->Uname;
            $Aboute1['Name'] = $User->Name;
            $Aboute1['Family'] = $User->Family;
            $Aboute1['Email'] = $User->Email;
            $Aboute1['Summary'] = $User->Summary;
            if ($User->Gender == '0')
            {
                $Aboute1['Gender'] = 'مرد';
            }
            elseif ($User->Gender == '1')
            {
                $Aboute1['Gender'] = 'زن';
            }
            else
            {
                $Aboute1['Gender'] = 'نامشخص';
            }
            $Aboute1['Pic'] = $User->Pic;
        }

        $Aboute['preview'] = $Aboute1;
        //-----------------------تخصص ها
        $uss = $this->user_special($uid, $user);
        $Aboute['user_special'] = $uss;
        $keys = array();
        if (is_array($uss[1]) && count($uss[1]) > 0)
        {
            foreach ($uss[1] as $value)
            {
                $keyss = DB::table('keywords')
                    ->where('title', $value->name)
                    ->select('title', 'id')
                    ->first();
                array_push($keys, $keyss);
            }
        }

        //--------------------سابقه کار
        $uws = $this->user_work($uid, $user);
        if (is_array($uws[1]) && count($uws[1]) > 0)
        {
            foreach ($uws[1] as $value)
            {
                $keyss = DB::table('keywords')
                    ->where('title', $value->company)
                    ->select('title', 'id')
                    ->first();
                array_push($keys, $keyss);
            }
        }

        $Aboute['user_work'] = $uws;
        //----------------تحصیلات------------------
        $ues = $this->user_education($uid, $user);
        $Aboute['user_education'] = $ues;
        if (is_array($ues[1]) && count($ues[1]) > 0)
        {
            foreach ($ues[1] as $value)
            {
                $keyss = DB::table('keywords')
                    ->where('title', $value->university)
                    ->select('title', 'id')
                    ->first();
                array_push($keys, $keyss);
            }
        }
        $keysF = array();
        foreach ($keys as $value)
        {
            if (!in_array($value, $keysF))
            {
                array_push($keysF, $value);
            }
        }
        $Aboute['user_keywords'][0] = 'کلید واژه ه';

        $Aboute['user_keywords'][1] = $keysF;


        //----------------دوره های اموزشی------------------
        $uts = $this->user_tutorial($uid, $user);
        $Aboute['user_tutorial'] = $uts;
        //---------------آثار------------------

        $up = $this->user_publications($uid);
        $Aboute['user_Publications'] = $up;


        //----------------دوره های اموزشی------------------
        $uos = $this->user_other($uid, $user);
        $Aboute['user_other'] = $uos;
        //----------------مدیر گروه ها------------------
        $ugs = $this->user_group_admin($uid, $user);
        $Aboute['user_groupadmin'] = $ugs;
        //----------------مدیر کانال ها------------------
        $ug = DB::table('user_group')->where('uid', $uid)->where('isorgan', '1')->select('id', 'pic', 'name', 'summary', 'link')->orderBy('id')->get();
        $ugs[0] = trans('labels.user_organadmin');
        $ugs[1] = $ug;
        $Aboute['user_organadmin'] = $ugs;
        //----------------عضو کانال ها------------------
        $i = 0;
        $uos = DB::table('user_group')->where('uid', $uid)->select('id')->get();
        foreach ($uos as $PKey)
        {
            $uoss[$i] = $PKey->id;
            $i++;
        }
        if ($i > 0)
        {
            $ug = DB::table('user_group_member AS ugm')->join('user_group AS ug', 'ugm.gid', '=', 'ug.id')->where('ugm.uid', $uid)->where('isorgan', '1')->where('ug.relation', '0')->whereNotIn('ug.id', $uoss)->select('ug.id AS id', 'ug.pic AS pic', 'ug.NAME AS name', 'ug.link AS link')->get();
            $ugs[0] = trans('labels.user_INorgan');
            $ugs[1] = $ug;
            $Aboute['user_INorgan'] = $ugs;
        }
        else
        {
            $ugs = array();
            $ug = '';
            $ugs[0] = trans('labels.user_INorgan');
            $ugs[1] = $ug;
            $Aboute['user_INorgan'] = $ugs;
        }
        //----------------عضو گروه ها------------------

        if ($i > 0)
        {
            $ug = DB::table('user_group_member AS ugm')
                ->join('user_group AS ug', 'ugm.gid', '=', 'ug.id')
                ->where('ugm.uid', $uid)
                ->where('isorgan', '0')
                ->where('ug.relation', '0')
                ->whereNotIn('ug.id', $uoss)
                ->select('ug.id AS id', 'ug.pic AS pic', 'ug.NAME AS name', 'ug.link AS link')
                ->get();
        }
        else
        {
            $ug = '';
        }
        $ugs[0] = trans('labels.user_INgroup');
        $ugs[1] = $ug;
        $Aboute['user_INgroup'] = $ugs;
        //Tabs
        $tabs = [];//$this->UserTabs($uid, $Aboute1['UName'], $cuid); // :TODO: check tabs and generate true tabs
        $Aboute['Tabs'] = $tabs;
        if ($islocal == 'local')
        {
            return $Aboute;
        }
        else
        {
            return $Aboute;
        }
    }

    public function userCircle($user_id, $sesid)
    {
//         $LC = new UserClass();
//        $LoginState = $LC->CheckLogin($user_id, $user_id);
        // if ($LoginState) {
        $mes = DB::table('user_circle')->where('uid', $user_id)->select('id', 'name', 'orders', 'nums')->take(50)->get();
        return $mes;
        //
    }

    public function userGroup($user_id, $sesid)
    {
        $Groups = DB::table('user_group as g')->leftJoin('user_group_member as m', 'g.id', '=', 'm.gid')->where('m.uid', $user_id)->whereRaw(" (m.admin = '1' || m.relation = '2') and isorgan='0'")->distinct()->select('g.id', 'g.name', 'g.uid as manageid', 'm.uid as myid')->take(50)->get();
        foreach ($Groups as $row)
        {
            $pic = config('constants.SiteAddress') . 'pics/group/' . $row->pic;
            $row->pic = $pic;
        }
        return response()->json(array(
            'error' => false,
            'data' => $Groups), 200
        )->setCallback(Request::input('callback'));
    }

    public function GetMyOrganGroups($user_id, $q)
    {
        $Groups = DB::table('user_group as g')->leftJoin('user_group_member as m', 'g.id', '=', 'm.gid')->where('m.uid', $user_id)->whereRaw(" (m.admin = '1' || m.relation = '2')")->distinct()->select('g.id', 'isorgan', 'g.name', 'g.uid as manageid', 'm.uid as myid')->take(50)->get();

        return response()->json(array(
            'error' => false,
            'data' => $Groups), 200
        )->setCallback(Request::input('callback'));
    }

    public function MyOrganGroups($user_id, $sesid)
    {
        $Groups = DB::table('user_group as g')->leftJoin('user_group_member as m', 'g.id', '=', 'm.gid')->where('m.uid', $user_id)->whereRaw(" (m.admin = '1' || m.relation = '2')")->distinct()->select('g.id', 'isorgan', 'g.name', 'g.uid as manageid', 'm.uid as myid')->take(50)->get();
        return $Groups;
    }

    public function MyOrgans($user_id, $sesid)
    {
        $Groups = DB::table('user_group as g')->leftJoin('user_group_member as m', 'g.id', '=', 'm.gid')->where('m.uid', $user_id)->where('g.isorgan', '1')->whereRaw(" (m.admin = '1' || m.relation = '2')")->distinct()->select('g.id', 'isorgan', 'g.name', 'g.uid as manageid', 'm.uid as myid')->take(50)->get();
        return $Groups;
    }

    public function MyGroups($user_id, $sesid)
    {
        $Groups = DB::table('user_group as g')->leftJoin('user_group_member as m', 'g.id', '=', 'm.gid')->where('m.uid', $user_id)->where('g.isorgan', '0')->whereRaw(" (m.admin = '1' || m.relation = '2')")->distinct()->select('g.id', 'isorgan', 'g.name', 'g.uid as manageid', 'm.uid as myid')->take(50)->get();
        return $Groups;
    }

    public function userOrgans($user_id, $sesid)
    {
        $Groups = DB::table('user_group as g')->leftJoin('user_group_member as m', 'g.id', '=', 'm.gid')->where('m.uid', $user_id)->whereRaw(" (m.admin = '1' || m.relation = '2') and isorgan='1'")->distinct()->select('g.id', 'g.name', 'g.uid as manageid', 'm.uid as myid')->take(50)->get();
        return response()->json(array(
            'error' => false,
            'data' => $Groups), 200
        )->setCallback(Request::input('callback'));
    }

    public function user_group_admin2($uid)
    {
        $ug = DB::table('user_group')->where('uid', $uid)->where('isorgan', '0')->select('id', 'pic', 'name', 'summary', 'link')->orderBy('id')->get();
        return $ug;
    }

    public function user_organ_admin2($uid)
    {
        $ug = DB::table('user_group')->where('uid', $uid)->where('isorgan', '1')->select('id', 'pic', 'name', 'summary', 'link')->orderBy('id')->get();
        return $ug;
    }

    public function user_group_admin($uid)
    {
        $ug = DB::table('user_group')->where('uid', $uid)->where('isorgan', '0')->select('id', 'pic', 'name', 'summary', 'link')->orderBy('id')->get();
        $ugs[0] = trans('labels.user_groupadmin');
        $ugs[1] = $ug;
        return $ugs;
    }

    public function user_publications($uid)
    {
        $ufname = '';
        $ufname2 = '';
        $user = DB::table('user')->where('id', $uid)->select('Name', 'Family')->first();
        if ($user)
        {
            $ufname = trim($user->Name) . ' ' . trim($user->Family);
            $ufname2 = trim($user->Family) . '، ' . trim($user->Name);
        }

//        ->whereRaw("f.field_type='persons'")
        $up = DB::table('subject_fields_report as fr')->join('fields as f', 'fr.field_id', '=', 'f.id')
            ->join('subjects as s', 's.id', '=', 'fr.sid')
            ->join('subject_type as st', 'st.id', '=', 's.kind')
            ->join('pages as p', 's.id', '=', 'p.sid')->whereRaw("f.field_type='persons'")
            ->whereRaw("(fr.field_value like '%{$ufname}%' or fr.field_value like '%{$ufname2}%')")
            ->groupBy('s.id')
            ->select('s.id', 's.title', 'p.id as pid', 'st.pretitle')->get();
        foreach ($up as $value)
        {
            if ($value->pretitle != '')
            {
                $value->title = $value->pretitle . ' ' . $value->title;
            }
        }
        $res = array();
        $res[0] = trans('labels.Publications');
        $res[1] = $up;
        return $res;
    }

    public function UserTabs($uid, $Uname, $cuid)
    {
        $user_tab = array();
        $user['tabs']['name']['0'] = 'معرفی';
        $user['tabs']['link']['0'] = 'intro';

        $user['tabs']['name']['1'] = 'مطالب';
        $user['tabs']['link']['1'] = 'contents';


//        $user['tabs']['name']['5'] = 'روابط';
//        $user['tabs']['link']['5'] = 'relations';

        $user['tabs']['name']['8'] = 'دیوار';
        $user['tabs']['link']['8'] = 'wall';

        $user['tabs']['name']['9'] = 'میزکار';
        $user['tabs']['link']['9'] = 'desktop';
        if (intval($uid) != 0)
        {
            foreach ($user['tabs']['name'] as $key => $val)
            {
                $Tab = array();
                $link = $user['tabs']['link'][$key];
                $href = ($key == 0) ? $Uname : $Uname . '/' . $user['tabs']['link'][$key];
                $distance = ($key == 1 || $key == 5 || $key == 8) ? 1 : '';
                $view = true;
                if (($key == 8 || $key == 9) && ($cuid == $uid))
                {
                    $view = true;
                }
                elseif (($key == 2 || $key == 5 || $key == 6 || $key == 7 || $key == 8 || $key == 10 || $key == 9) && ($cuid != $uid))
                {
                    $view = false;
                }
                if ($view == true)
                {
                    $Tab['link'] = $link;
                    $Tab['href'] = $href;
                    $Tab['title'] = $val;
                    array_push($user_tab, $Tab);
                }
            }
        }


        return $user_tab;
    }

    public static function permission($module, $uid)
    {
        switch ($module)
        {
            case 'subjects':
                return '1';
            break;
        }
        $access = '0';
        if (isset($uid))
        {
            $count = DB::table('user as u')
                ->join('group_access as ga', 'ga.secgroupid', '=', 'u.SecGroups')
                ->join('access as a', 'ga.accid', '=', 'a.id')
                ->where('a.name', $module)
                ->where('u.id', $uid)->
                select('ga.levelid as res')->first();
            if ($count)
            {
                $access = $count->res;
            }
        }
        return $access;
    }

    public function DesktopMenu($uid, $sesid)
    {
        $DC = new DesktopClass();
        $dcret = $DC->DesktopMenu($uid, $sesid);
        return $dcret;
    }

}
