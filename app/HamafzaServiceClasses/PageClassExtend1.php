<?php

namespace App\HamafzaServiceClasses;

use App\Models\hamafza\Pages;
use App\Models\hamafza\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\HamahangCustomClasses\HtmlDomSTR;
use Route;

class PageClassExtend1
{

    public function Like($type, $user_id, $sid, $uid, $session_id = "")
    {
        switch ($type)
        {
            case 'subject':
                $like = DB::table('subject_member')
                    ->where('uid', '=', $uid)
                    ->where('sid', '=', $sid)
                    ->get()->toArray();
                $PageClass = new PageClass();
                if(!isset($like[0]))
                {
                    return $PageClass->LikeADD($user_id, $sid);
                }
                else
                {
                    if($like[0]->like)
                    {
                        return $PageClass->LikeRemove($user_id, $sid);
                    }
                    else
                    {
                        return $PageClass->LikeADD($user_id, $sid);
                    }
                }
                break;
            case 'User':
                $UC = new UserClass();
                return $UC->LikeADD($uid, $user_id);
                break;
            case 'Group':
                $UC = new GroupsClass();
                return $UC->LikeADD($uid, $user_id);
                break;
        }
    }

    public function DisLike($type, $userid, $sid, $uid, $session_id)
    {
        switch ($type)
        {
            case 'subject':
                $like = DB::table('subject_member')
                    ->where('uid', '=', $uid)
                    ->where('sid', '=', $sid)
                    ->first();
                $PageClass = new PageClass();
                if(!isset($like))
                {
                    return $PageClass->LikeADD($userid, $sid);
                }
                else
                {
                    if($like->like)
                    {
                        return $PageClass->LikeRemove($userid, $sid);
                    }
                    else
                    {
                        return $PageClass->LikeADD($userid, $sid);
                    }
                }
                break;
            case 'User':
                $UC = new UserClass();
                return $UC->LikeRemove($uid, $userid);
                break;
            case 'Group':
                $UC = new GroupsClass();
                return $UC->LikeRemove($uid, $userid);
                break;
        }
    }

    public function Follow($type, $userid, $sid, $uid, $session_id)
    {
        switch ($type)
        {
            case 'subject':
                $follow = DB::table('subject_member')
                    ->where('uid', '=', $uid)
                    ->where('sid', '=', $sid)
                    ->first();
                $PageClass = new PageClass();
                if(!isset($follow))
                {
                    return $PageClass->FollowADD($userid, $sid);
                }
                else
                {
                    if($follow->follow)
                    {
                        return $PageClass->FollowRemove($uid, $sid);
                    }
                    else
                    {
                        return $PageClass->FollowADD($uid, $sid);
                    }
                }
                break;
            case 'button':
                $PageClass = new PageClass();
                return $PageClass->FollowADD($uid, $sid);
                break;
            case 'User':
                $UC = new UserClass();
                return $UC->FollowADD($uid, $userid);
                break;
            case 'Group':
                $UC = new GroupsClass();
                return $UC->FollowADD($uid, $userid);
                break;
        }
    }

    public function UnFollow($type, $userid, $sid, $uid, $session_id)
    {
        switch ($type)
        {
            case 'subject':
                $follow = DB::table('subject_member')
                    ->where('uid', '=', $uid)
                    ->where('sid', '=', $sid)
                    ->first();
                $PageClass = new PageClass();
                if(!isset($follow))
                {
                    return $PageClass->FollowADD($userid, $sid);
                }
                else
                {
                    if($follow->follow)
                    {
                        return $PageClass->FollowRemove($uid, $sid);
                    }
                    else
                    {
                        return $PageClass->FollowADD($uid, $sid);
                    }
                }
                break;
            case 'button':
                $PageClass = new PageClass();
                return $PageClass->FollowRemove($uid, $sid);
                break;
            case 'User':
                $UC = new UserClass();
                return $UC->FollowRemove($uid, $userid);
                break;
            case 'Group':
                $UC = new GroupsClass();
                return $UC->FollowRemove($uid, $userid);
                break;
        }
    }

//    public static function AttachFileinPage($uid, $sesid, $pid, $uppic, $delfile)
//    {
//
//        foreach ($uppic as $key => $value)
//        {
//            DB::table('page_file')
//                ->insert
//                (
//                    [
//                        'admin' => $uid,
//                        'pid' => $pid,
//                        'title' => $value['title'],
//                        'name' => $value['address'],
//                        'size' => $value['size'],
//                        'type' => $value['type']
//                    ]
//                );
//        }
//        if (is_array($delfile))
//        {
//            foreach ($delfile as $key => $value)
//            {
//                if ($value != '')
//                {
//                    DB::table('page_file')->where('id', $key)->delete();
//                }
//            }
//        }
//
//
//        $mes = 'انجام شد';
//        return $mes;
//    }

    public static function PreEditPage($uid, $pid)
    {
        $now_date = gmdate("Y-m-d H:i:s", time() + 12600 - 900);

        $page = DB::table('pages as p')
            ->leftJoin('page_draft as d', 'd.id', '=', 'p.id')
            ->leftJoin('user as u', 'd.uid', '=', 'u.id')
            ->where('p.id', $pid)
            ->select('u.Name as editUname', 'u.Family as editUfamily', 'p.part', 'p.type', 'p.view', 'p.form', 'p.body as pbody', 'p.ver_date', 'd.uid', 'd.edit_date', 'd.last_date', 'd.body as dbody', 'd.editing', 'p.viewtext', 'p.viewslide', 'p.viewfilm')
            ->first();

        if ($page)
        {
            $isdraft = is_null($page->dbody) ? 0 : 1;
            $page->editing = '1';
            if ($uid == $page->uid || $now_date > $page->last_date)
            {
                $page->editing = 0;
            }
            if ($page->part == 0)
            {
                $edit_date = gmdate("Y-m-d H:i:s", time() + 12600);
                if ($page->pbody != '')
                {
                    $body = $page->pbody;
                }
                else
                {
                    $body = '<br>';
                }
//                    $body = PublicsClass::to_latin_num($body);
//                    $body = PageClass::ModifyContent($body);
                if ($isdraft == 0)
                {
                    DB::table('page_draft')
                        ->insert(
                            [
                                'id' => $pid,
                                'uid' => $uid,
                                'body' => $body,
                                'edit_date' => $edit_date,
                                'last_date' => $edit_date,
                                'editing' => '1'
                            ]
                        );
                }
                elseif ($isdraft == 1)
                {
                    DB::table('page_draft')
                        ->where('id', $pid)
                        ->update(
                            [
                                'uid' => $uid,
                                'body' => $body,
                                'edit_date' => $edit_date,
                                'last_date' => $edit_date,
                                'editing' => '1'
                            ]
                        );
                }
            }
            $page->last_date = \Morilog\Jalali\jDate::forge($page->last_date)->format('H:i:s %Y/%m/%d ');
        }
        return $page;
    }

    public static function GetMypage($uid, $sesid, $type)
    {

        $mes = SubjectsClass::GetMypage($uid, $type);
        return $mes;
    }

    public function subjectView($sid, $uid = 0)
    {
        $view = 1;
        $admin = UserClass::permission('ViewSubjects', $uid);

        if (intval($sid) != 0)
        {
            $row = DB::table('process_phase as pp')
                ->leftJoin('process_phase_subject as pps', 'pp.id', '=', 'pps.ppid')
                ->select('pp.view')
                ->where('pps.sid', $sid)
                ->where('pps.active', '1')
                ->first();

            if ($row)
            {
                $view = 0;
                if ($row->view == '1')
                {
                    $view = 1;
                }
                else
                {
                    $row = DB::table('subjects')
                        ->select('manager', 'supporter', 'supervisor', 'admin')
                        ->where('id', $sid)
                        ->first();
                    if ($row)
                    {
                        if ((isset($uid) && ($row->admin == $uid || $row->manager == $uid || $row->supporter == $uid || $row->supervisor == $uid || $admin == '1')))
                        {
                            $view = 1;
                        }
                        else
                        {
                            $sr = '';
                            $show = 'on';
                            if ($show == 'in')
                            {
                                $sr = 'AND (pps.active = 1 OR pps.pass = 1)';
                            }
                            elseif ($show == 'on')
                            {
                                $sr = 'AND pps.active = 1';
                            }
                            elseif ($show == 'out')
                            {
                                $sr = 'AND pps.pass = 1';
                            }

                            $secid = $sid;
                            $sel = PageClass::Sel_Page();
                            $sql2 = " 
                                SELECT count( pps.id) as cnt FROM
                                            process as pr
                                    LEFT JOIN
                                            process_phase as pp
                                    ON
                                            (pr.id = pp.pid)
                                    LEFT JOIN
                                            process_phase_subject as pps
                                    ON
                                            (pps.pid = pr.id AND pps.ppid = pp.id)
                                    LEFT JOIN
                                            subjects as s
                                    ON
                                            (s.id = pps.sid)
                                    LEFT JOIN
                                            pages as p
                                    ON
                                            s.id = p.sid
                                    WHERE
                                            p.sid={$secid}  
                                            and  ((pp.manager1 = 1 
                                            AND s.manager = {$uid}) 
                                            OR (pp.manager1 = 2 
                                            AND s.supervisor = {$uid})
                                            OR (pp.manager1 = 3 
                                            AND s.supporter = {$uid}) 
                                            OR (pp.manager1 = 4 
                                            AND s.admin = {$uid}) 
                                            OR (pp.manager = {$uid})) 
                                            AND {$sel} {$sr}
                                    ORDER BY
                                            pps.reg_date DESC";
                            $row2 = DB::select(DB::raw($sql2));
                            if ($row2)
                            {
                                if ($row2->cnt > 0)
                                {
                                    $view = 1;
                                }
                            }
                            $row = DB::table('referee as r')
                                ->join('subjects as s', 's.id', '=', 'r.pid')
                                ->select('r.id')
                                ->where('r.uid', $uid)
                                ->where('pid', $secid)
                                ->count();
                            if ($row > 0)
                            {
                                $view = 1;
                            }
                        }
                    }
                }
            }
        }
        return $view;
    }

    public function pageEdit($sid, $pid, $uid)
    {
        $view = 0;
        $admin = UserClass::permission('editallpages', $uid);
        $allowEdit = UserClass::permission('subject_edit', $uid);
        $row = DB::table('pages as p')
            ->leftJoin('subjects as s', 'p.sid', '=', 's.id')
            ->select('p.edit', 's.manager', 's.supporter', 's.supervisor', 's.admin', 's.ispublic')->where('p.id', $pid)->first();
        if ($row)
        {
            $edit = $row->edit;
            if ((isset($uid) && ($row->manager == $uid || $row->supporter == $uid || $row->supervisor == $uid || $row->admin == $uid || $admin == '1' || $allowEdit == '1')))
            {
                $view = 1;
            }
            elseif ($edit == 1 || $edit == 2)
            {
                $users = array();
                $row = DB::table('page_limit_edit')->where('pid', $pid)->select('uid')->get();
                foreach ($row as $value)
                {
                    $users[] = $value->uid;
                }
                if (is_array($users))
                {
                    if ($uid != 0)
                    {
                        if (in_array($uid, $users))
                        {
                            $view = 1;
                        }
                    }
                }
            }
            elseif ($edit == 0)
            {
                $view = 1;
            }
        }

        return $view;
    }

    public function pageView($sid, $pid, $uid)
    {
        // 0 : عدم نمایش
        //۱ : نمایش
        //۲ : نمایش محرمانه
        if ($uid == 0)
        {
            $uid = '-1';
        }
        $admin = UserClass::permission('viewallpages', $uid);
        $view = 0;
        if (intval($sid) != 0)
        {
            $view = $this->subjectView($sid);
            if ($view == 1 && intval($pid) != 0)
            {
                $row = DB::table('pages as p')
                    ->leftJoin('subjects as s', 'p.sid', '=', 's.id')
                    ->select('p.view', 's.manager', 's.supporter', 's.supervisor', 's.ispublic')->where('p.id', $pid)->first();
                if ($row)
                {
                    $view = $row->view;
                    $ispublic = $row->ispublic;
                }

                if ((isset($uid) && ($row->manager == $uid || $row->supporter == $uid || $row->supervisor == $uid || $admin == '1')))
                {
                    $view = 1;
                }
                elseif ($view == 0 || $view == 2)
                {
                    $users = array();
                    $row = DB::table('page_limit_view')->where('pid', $pid)->select('uid')->get();
                    foreach ($row as $value)
                    {
                        $users[] = $value->uid;
                    }

                    if (is_array($users))
                    {
                        if ($uid != 0)
                        {
                            if (in_array($uid, $users))
                            {
                                $view = 1;
                            }
                        }
                    }
                }
            }
        }
        return $view;
    }

    public static function GetPoodmanNode($uid, $sesid, $id)
    {
        $user = UserClass::CheckLogin($uid, $sesid);
        if ($user == TRUE)
        {
            $user = 'true';
        }
        else
        {
            $user = 'false';
        }
        if ($user)
        {
            $n = DB::table('page_tree as pt')
                ->leftJoin('pages AS p', 'p.id', '=', 'pt.pid')->join('subjects AS s', 'p.sid', '=', 's.id')
                ->select('pt.*', 's.title', 's.id as Subjectid')->where('pt.id', $id)->count();
            if ($n == 0)
            {
                $s = DB::table('page_tree as pt')->select('pt.*')->where('pt.id', $id)->first();
            }
            else
            {
                $s = DB::table('page_tree as pt')
                    ->leftJoin('pages AS p', 'p.id', '=', 'pt.pid')->join('subjects AS s', 'p.sid', '=', 's.id')
                    ->select('pt.*', 's.title', 's.id as Subjectid')->where('pt.id', $id)->first();
            }
            $mes['Node'] = $s;
            $mes['Highlight'] = '';
            if ($s)
            {
                $pageid = $s->pid;

                $mes['Highlight'] = DB::table('announces')->where('pid', $pageid)->get();
            }


            $err = false;
        }
        else
        {
            $mes = trans('labels.FailUser');
            $err = true;
        }
        return response()->json(array(
            'error' => $err,
            'data' => $mes), 200
        )->setCallback(Input::get('callback'));
    }

    public static function changepageview($uid, $sesid, $pid, $sel, $view)
    {

    }

    public static function PageDashboard($uid, $sesid, $pid, $sid)
    {
        $Res['Measure'] = DashboardClass::Page_NumberofMeasures($uid, $pid, $sid);
        $Res['SMS'] = DashboardClass::SMS($uid);
        $Res['Sale'] = DashboardClass::SaleReports($uid);
        $Res['NumberofUsers'] = DashboardClass::NumberofUsers($uid);
        $err = false;
        $mes = $Res;
        return $mes;
    }

    public static function ADDPageFilm($uid, $sesid, $films, $pics, $PreTitle, $Title, $Desce, $pid, $Time)
    {
        foreach ($PreTitle as $key => $value)
        {
            $Titles = $Title[$key];
            $Desces = $Desce[$key];
            $picss = $pics[$key];
            $filmss = $films[$key];
            $Times = $Time[$key];
            DB::table('page_films')->insert(array('pid' => $pid, 'film' => $filmss, 'title' => $Titles, 'pic' => $picss, 'pretitle' => $value, 'length' => $Times, 'descr' => $Desces));
        }
        $mes = trans('labels.PageSlideOK');
        $err = false;

        return $mes;
    }

    function ChangeTitle($param)
    {
        switch ($param)
        {
            case "1":
                return 'جدول';
                break;
            case "2":
                return 'نمودار';
                break;
            case "3":
                return 'تصویر';
                break;
        }
    }

    public static function AddPageSlide($uid, $sesid, $pid, $files)
    {
        $order = DB::table('page_slides')->where('pid', $pid)->max('order');
        $order++;
        foreach ($files as $value)
        {
            DB::table('page_slides')->insert(array('pid' => $pid, 'src' => 'slides/' . $value['name'], 'title' => $value['title'], 'order' => $order));
        }
        $mes = trans('labels.PageSlideOK');

        $err = false;

        return $mes;
    }

    public static function DeletePageSlide($id)
    {
        DB::table('page_slides')->where('id', $id)->delete();
    }

    public static function DeletePageFilm($id)
    {
        DB::table('page_films')->where('id', $id)->delete();
    }

    public static function DeleteAnnounces($id)
    {
        DB::table('announces')->where('id', $id)->delete();
        DB::table('announce_keys')->where('ann_id', $id)->delete();
    }

    public static function DeleteHighlight($id)
    {
        DB::table('highlights')->where('id', $id)->delete();
    }

    public static function DeleteAlert($id)
    {
        DB::table('alerts')->where('id', $id)->delete();
    }

    public static function GetPageSetting($uid, $sesid, $sid, $pid)
    {
        try
        {
            $admin = UserClass::permission('manager_edit', $uid);
            $subject_edit = UserClass::permission('subject_edit', $uid);
            $manager_edit = UserClass::permission('manager_edit', $uid);
            $ManagerPage = PageClass::GetManagerPage($sid);
            if ($ManagerPage)
            {
                $manager = $ManagerPage->manager;
                $supporter = $ManagerPage->supporter;
                $supervisor = $ManagerPage->supervisor;
                $admin = $ManagerPage->admin;
            }

            $title = '';
            $Setting = array();
            $Setting['propertie'] = 0;
            //dd("admin: $admin == '1', subject_edit: $subject_edit == '1', $manager: $manager == uid: $uid, supporter: $supporter == uid: $uid, supervisor: $supervisor == uid: $uid, admin: $admin == uid: $uid");
            if ($admin == '1' || $subject_edit > 0 || $manager == $uid || $supporter == $uid || $supervisor == $uid || $admin == $uid)
            {
                $rowT = DB::table('subjects as s')
                    ->leftJoin('subject_type as sa', 'sa.id', '=', 's.kind')
                    ->select('s.title', 'sa.name', 's.kind', 's.sub_kind')
                    ->where('s.id', $sid)->first();

                $subjectKey = DB::table('subject_key as sk')
                    ->leftJoin('keywords as k', 'k.id', '=', 'sk.kid')
                    ->select('k.id', 'k.title')
                    ->where('sk.sid', $sid)->groupBy('k.id')->get();
                $T1['asubject'] = $rowT->name;
                $T1['title'] = $rowT->title;
                $T1['kind'] = $rowT->kind;
                $T1['sub_kind'] = $rowT->sub_kind;
                $T1['Fields'] = PageClass::GetFields($sid, $T1['kind']);
                $T1['keywords'] = $subjectKey;
                $Setting['propertie'] = $T1;
                $title = $rowT->title;
            }
            $Setting['Relations'] = '0';
            if ($admin == '1' || $subject_edit == '1' || $manager == $uid || $supporter == $uid || $supervisor == $uid || $admin == $uid)
            {
                $Setting['Relations'] = PageClass::GetRelations($sid);
            }
            $Setting['Access'] = PageClass::GetAccess($pid, $sid, $manager, $supporter, $supervisor, $admin);

            $rowT = DB::table('subjects as s')
                ->leftJoin('pages as p', 'p.sid', '=', 's.id')
                ->select('p.help_pid', 'p.help_tag', 'p.id')
                ->where('s.id', $sid)->get();


            foreach ($rowT as $value)
            {
                $pattern = "/{{Help\+.*=.*}}/";
                if ($num1 = preg_match_all($pattern, $value->help_tag, $array))
                {
                    for ($x = 0; $x < $num1; $x++)
                    {
                        $orig = $array['0'][$x];
                        $key = str_replace("{{Help+", "", $array['0'][$x]);
                        $key = str_replace("}}", "", $key);
                        $pos = strpos($key, "=");
                        $key = substr($key, $pos + 1, strlen($key) - $pos);
                        $value->help_name = $key;
                    }
                }
            }


            $Setting['Helps'] = $rowT;
            return $Setting;
        } catch (Exception $e)
        {
            return $e;
        }
    }

    public static function GetAccess($pid, $sid, $manager, $supporter, $supervisor, $admin)
    {
        if ($manager != 0)
        {
            $rowT = DB::table('user as u')
                ->select('Name', 'Family', 'id')
                ->where('u.id', $manager)->first();
            $user['id'] = $rowT->id;
            $user['Name'] = $rowT->Name;
            $user['Family'] = $rowT->Family;
            $USER['manager'] = $user;
        }
        else
        {
            $user['id'] = 0;
            $user['Name'] = '';
            $user['Family'] = '';
            $USER['manager'] = $user;
        }
        $user = array();

        if ($supporter != 0)
        {
            $rowT = DB::table('user as u')
                ->select('Name', 'Family', 'id')
                ->where('u.id', $supporter)->first();
            $user['id'] = $rowT->id;
            $user['Name'] = $rowT->Name;
            $user['Family'] = $rowT->Family;
            $USER['supporter'] = $user;
        }
        else
        {
            $user['id'] = 0;
            $user['Name'] = '';
            $user['Family'] = '';
            $USER['supporter'] = $user;
        }
        $user = array();
        if ($supervisor != 0)
        {
            $rowT = DB::table('user as u')
                ->select('Name', 'Family', 'id')
                ->where('u.id', $supervisor)->first();
            $user['id'] = $rowT->id;
            $user['Name'] = $rowT->Name;
            $user['Family'] = $rowT->Family;
            $USER['supervisor'] = $user;
        }
        else
        {
            $user['id'] = 0;
            $user['Name'] = '';
            $user['Family'] = '';
            $USER['supervisor'] = $user;
        }
        $user = array();
        if ($admin != 0)
        {
            $rowT = DB::table('user as u')
                ->select('Name', 'Family', 'id')
                ->where('u.id', $admin)->first();
            $user['id'] = $rowT->id;
            $user['Name'] = $rowT->Name;
            $user['Family'] = $rowT->Family;
            $USER['admin'] = $user;
        }
        else
        {
            $user['id'] = 0;
            $user['Name'] = '';
            $user['Family'] = '';
            $USER['admin'] = $user;
        }
        $rowT = DB::table('subjects as s')
            ->join('pages as p', 'p.sid', '=', 's.id')
            ->select('p.edit', 'p.view', 's.kind', 's.list', 's.search', 's.ispublic')
            ->where('p.id', $pid)->first();
        $user = array();
        $user['edit'] = $rowT->edit;
        $user['view'] = $rowT->view;
        $user['kind'] = $rowT->kind;
        $user['list'] = $rowT->list;
        $user['search'] = $rowT->search;
        $user['ispublic'] = $rowT->ispublic;

        $user['viewusers'] = array();
        $user['editusers'] = array();

        $kinds = $rowT->kind;
        if ($rowT->view == 0)
        {
            $rowTs = DB::table('user as u')
                ->leftJoin('page_limit_view as v', 'u.id', '=', 'v.uid')
                ->select(DB::Raw("u.id,  CONCAT(u.Name,' ', u.Family) as name"))
                ->where('v.pid', $pid)->get();
            $user['viewusers'] = $rowTs;
        }

        if ($rowT->edit == '1')
        {
            $rowTs = DB::table('user as u')
                ->leftJoin('page_limit_edit as e', 'u.id', '=', 'e.uid')
                ->select(DB::Raw("u.id,  CONCAT(u.Name,' ', u.Family) as name"))
                ->where('e.pid', $pid)->get();
            $user['editusers'] = $rowTs;
        }

        $rowTs = DB::table('pages as p')
            ->leftJoin('subject_type_tab as stt', 'p.type', '=', 'stt.tid')
            ->select(DB::Raw("p.id as pid, p.view as pview, stt.name as tab_name, stt.view,stt.id as sttid, stt.help_pid"))
            ->where('p.sid', $sid)->where('stt.stid', $kinds)->orderBy('stt.orders')->get();

        foreach ($rowTs as $value)
        {
            $value->check = '';
            $C = DB::table('tab_view as tv')
                ->select('tv.sid')
                ->where('tabid', $value->sttid)->where('tv.sid', $sid)->count();
            if ($C > 0)
            {
                $value->check = 'checked';
            }
        }
        $USER['tabs'] = $rowTs;
        $USER['access'] = $user;

        return $USER;
    }

    public static function GetRelations($sid)
    {
        $rels = array();
        $Rels = array();
        $rows = DB::table('subjects')
            ->select('id', 'title')->get();
        foreach ($rows as $row)
        {
            $subject[$row->id] = $row->title;
            $SubjectS[$row->id] = $row->id;
        }

        $rowsCount = DB::table('subjects_rel')
            ->where('sid1', $sid)->orWhere('sid2', $sid)
            ->select('id', 'sid1', 'sid2', 'rel')->count();
        if ($rowsCount > 0)
        {
            $rows = DB::table('subjects_rel')
                ->where('sid1', $sid)->orWhere('sid2', $sid)
                ->select('id', 'sid1', 'sid2', 'rel')->get();
            foreach ($rows as $row)
            {$sidd = '';
                if ($row->sid1 == $sid)
                {
                    $sub = $row->sid2;
                    $rel = 'D'.$row->rel;

                }
                elseif ($row->sid2 == $sid)
                {
                    $sub = $row->sid1;
                    $rel = 'I'.$row->rel;


                }

                $rels['right']['title'] = $subject[$sid];
                $rels['right']['id'] = $sid;
                $rels['rel'] = $rel;
                if (array_key_exists($sub, $subject))
                {
                    $rels['left']['title'] = $subject[$sub];
                }
                else
                {
                    $rels['left']['title'] = '';
                }

                $rels['left']['id'] = $sub;
                array_push($Rels, $rels);
            }
        }
        else
        {
            $rels['right']['title'] = $subject[$sid];
            $rels['right']['id'] = $sid;
            $rels['rel'] = 0;
            $rels['left']['title'] = 0;
            $rels['left']['id'] = 0;
            array_push($Rels, $rels);
        }

        return $Rels;
    }

    public static function GetFields($sid, $kind)
    {
//        $rows = DB::table('subject_fields_report as r')
//                        ->leftJoin('subject_type_fields as t', 'r.field_id', '=', 't.field_id')
//                        ->leftJoin('fields as f', 'r.field_id', '=', 'f.id')
//                        ->leftJoin('fields_value as v', 'v.field_id', '=', 'f.id')
//                        ->where('r.sid', $sid)->where('t.stid', $kind)
//                        ->orderBy('t.orders')->orderBy('v.orders')
//                        ->select('r.field_id as id', 'f.field_name', 'f.field_type', 'v.field_value', 't.requires', 'f.field_Desc', 'r.field_id', 'r.check_id', 'r.field_value as field_val', 'v.field_value', 'v.id as vid')->get();
        $rows = DB::table('subject_type_fields')
            ->where('stid', $kind)
            ->orderBy('orders')
            ->select('id', 'name', 'type', 'help', 'requires', 'defvalue')->get();
        $reports = DB::table('subject_fields_report')
            ->where('sid', $sid)
            ->select('field_id', 'field_value')->get();
        $Ret['fields'] = $rows;
        $Ret['reports'] = $reports;
        return $Ret;
//        $field_id = array();
//        $field_name = array();
//        $field_type = array();
//        $field_value = array();
//        $field_vals = array();
//        $requires = array();
//        $Desc = array();
//
//        foreach ($rows as $row) {
//            $index = $row->id;
//            $field_id[$index] = $index;
//
//            $field_name[$index] = $row->field_name;
//            $field_type[$index] = $row->field_type;
//            $requires[$index] = $row->requires;
//            $Desc[$index] = $row->field_Desc;
//        }
//        $rows = DB::table('subject_fields_report as r')
//                        ->leftJoin('fields as f', 'r.field_id', '=', 'f.id')
//                        ->where('r.sid', $sid)
//                        ->orderBy('f.orders')
//                        ->select('r.field_id as id', 'r.field_value as field_val')->get();
//        foreach ($rows as $row) {
//            $index = $row->id;
//            $field_vals[$index] = $row->field_val;
//        }
//        $rows = DB::table('subject_type_fields as t')
//                        ->leftJoin('fields as f', 't.field_id', '=', 'f.id')
//                        ->leftJoin('fields_value as v', 'v.field_id', '=', 'f.id')
//                        ->where('t.stid', $kind)
//                        ->orderBy('t.orders')->orderBy('v.orders')
//                        ->select('f.id as id', 'v.field_value', 'v.id as vid')->get();
//
//        foreach ($rows as $row) {
//            $index = $row->id;
//
//            $field_value[$index][$row->vid] = $row->field_value;
//        }
//        $Fields['id'] = $field_id;
//
//        $Fields['name'] = $field_name;
//        $Fields['type'] = $field_type;
//        $Fields['value'] = $field_value;
//        $Fields['vals'] = $field_vals;
//        $Fields['requires'] = $requires;
//        $Fields['Desc'] = $Desc;
        return $rows;
    }

    public static function GetManagerPage($sid)
    {
        return DB::table('subjects')
            ->select('manager', 'supporter', 'supervisor', 'admin')
            ->where('id', $sid)->first();
    }

    public static function ISManagerPage($sid, $uid)
    {
        $s = DB::table('subjects')
            ->select('manager', 'supporter', 'supervisor', 'admin')
            ->where('id', $sid)->first();

        if ($s->manager == $uid || $s->supporter == $uid || $s->supervisor == $uid || $s->admin == $uid)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function allowEdit($pid, $uid)
    {
        $s = DB::table('page_limit_edit')
            ->where('pid', $pid)->where('uid', $uid)->count();
        if ($s > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function Proccess($pid, $uid, $sesid, $sid)
    {
        $page_alert = '';
        $rowT = DB::table('alerts as a')
            ->leftJoin('process_phase as pp', 'a.id', '=', 'pp.alert')
            ->leftJoin('process_phase_subject as pps', 'pp.id', '=', 'pps.ppid')
            ->select('pps.id', 'pps.sid', 'pp.form', 'pp.pform', 'pp.alert', 'pp.view', 'a.name', 'a.scroll', 'a.comment')
            ->where('pps.sid', $sid)->where('pps.active', '1')->get();
        foreach ($rowT as $value)
        {
            $comment = $value->comment;
            if ($uid != 0)
            {
                $pattern = "/{{Form\+[0-9]+}}/";
                if ($num1 = preg_match_all($pattern, $comment, $array))
                {
                    for ($x = 0; $x < $num1; $x++)
                    {
                        $key = $array['0'][$x];
                    }
                }
                $key = str_replace('{{Form+', "", $key);
                $key = str_replace('}}', "", $key);
                $show = 'on';
                if ($show == 'in')
                {
                    $sr = 'AND (pps.active = 1 OR pps.pass = 1)';
                }
                elseif ($show == 'on')
                {
                    $sr = 'AND pps.active = 1';
                }
                elseif ($show == 'out')
                {
                    $sr = 'AND pps.pass = 1';
                }
                if ($key != '')
                {
                    $secid = $sid;
//                       $rowT = DB::table('process as pr')
//                                    ->leftJoin('process_phase as pp', 'pr.id', '=', 'pp.pid')
//                                    ->leftJoin('process_phase_subject as pps', function($join) {
//                                        $join->on('pps.pid', '=', 'pr.id');
//                                        $join->on('pps.ppid', '<=', 'pp.id');
//                                    })
//                                    ->leftJoin('subjects as s', 's.id', '=', 'p.sid')
//                                    ->select('pps.id')
//                                    ->where('p.sid', $sid)->where(DB::Raw("((pp.manager1 = 1 AND s.manager = {$uid}) OR (pp.manager1 = 2 AND s.supervisor = {$uid}) OR (pp.manager1 = 3 AND s.supporter = {$uid}) OR (pp.manager1 = 4 AND s.admin = {$uid}) OR (pp.manager = {$uid})) AND {$_SESSION['Selpage']} {$sr}"))
//                                    ->orderBy('pps.reg_date', 'desc')->get();
                    $sql1 = "SELECT
                        pps.id 
                FROM
                        process as pr
                LEFT JOIN
                        process_phase as pp
                ON
                        (pr.id = pp.pid)
                LEFT JOIN
                        process_phase_subject as pps
                ON
                        (pps.pid = pr.id AND pps.ppid = pp.id)
                LEFT JOIN
                        subjects as s
                ON
                        (s.id = pps.sid)
                LEFT JOIN
                        pages as p
                ON
                        s.id = p.sid
                WHERE
                        p.sid={$secid}  and  ((pp.manager1 = 1 AND s.manager = {$uid}) OR (pp.manager1 = 2 AND s.supervisor = {$uid}) OR (pp.manager1 = 3 AND s.supporter = {$uid}) OR (pp.manager1 = 4 AND s.admin = {$uid}) OR (pp.manager = {$uid})) AND {$_SESSION['Selpage']} {$sr}
                ORDER BY
                        pps.reg_date DESC";
                    $SQL2 = DB::table('process_phase_subject as pps')
                            ->leftJoin('process as p', 'p.id', '=', 'pps.pid')
                            ->leftJoin('process_phase as pp', function ($join)
                            {
                                $join->on('p.id', '=', 'pp.pid');
                                $join->on('pp.id', '=', 'pps.ppid');
                            })
                            ->leftJoin('subjects as s', 's.id', '=', 'pps.sid')
                            ->select('pps.id')
                            ->where('form', $key) > where('s.id', $secid)
                            ->where(DB::Raw("pps.id in ($sql1) "))
                            ->orderBy('pps.reg_date', 'desc')->get();

                    $i = 0;
                    foreach ($SQL2 as $values)
                    {
                        $i++;
                        $psid = $values->id;
                        if ($num1 = preg_match_all($pattern, $comment, $array))
                        {
                            for ($x = 0; $x < $num1; $x++)
                            {
                                $comments = str_replace($array['0'][$x], "<a href='process.php?processid=$psid&pid=$pid&secid=$sid' class='fancybox fancybox.ajax' style='text-size:12pt;'>", $comment);
                            }
                        }
                        $pattern = "/{{Form-.*}}/";
                        if ($num1 = preg_match_all($pattern, $comments, $array))
                        {
                            for ($x = 0; $x < $num1; $x++)
                            {
                                $comments = str_replace($array['0'][$x], "</a>", $comments);
                            }
                        }
                    }

                    if ($i == 0)
                    {
                        $pattern = "/{{Form+.*}}/";
                        if ($num1 = preg_match_all($pattern, $comment, $array))
                        {
                            for ($x = 0; $x < $num1; $x++)
                            {
                                $comments = str_replace($array['0'][$x], "", $comment);
                            }
                        }
                        $pattern = "/{{Form-.*}}/";
                        if ($num1 = preg_match_all($pattern, $comments, $array))
                        {
                            for ($x = 0; $x < $num1; $x++)
                            {
                                $comments = str_replace($array['0'][$x], "", $comments);
                            }
                        }
                    }
                }
            }

            $pform = $value->pform;
            if ($pform == 1)
            {
                $pform = DB::table('subjects as s')->select('s.pform')->where('id', $sid)->first();
            }
            $class = ($res['scroll'] == 1) ? 'class="gkCode1 highlight1" id="highlight"' : 'class="gkCode1"';

            if (1 == 1)
            {
                if ($forum == 0)
                {
                    if ($pform == 0)
                    {
                        $page_alert .= '<div ' . $class . ' style="margin-right:15px;">' . $comments . '</div>';
                    }
                    else
                    {
                        $page_alert .= '<div ' . $class . ' style="margin-right:15px;"><a class="fancybox fancybox.ajax" href="process.php?processid=' . $res['id'] . '&pid=' . $pid . '&form=public" style="text-size:12pt;">' . $comments . '</a></div>';
                    }
                }
                elseif ($forum == 1 && $pform != 0)
                {
                    $page_alert .= '<div ' . $class . ' style="margin-right:15px;"><a class="fancybox fancybox.ajax" href="process.php?processid=' . $res['id'] . '&pid=' . $pid . '&form=public"  style="text-size:12pt;">' . $comments . '</a></div>';
                }
            }
        }

        return $page_alert;
    }

    public static function EditTreeNode($old_id, $repid, $SelReports, $parentid, $type, $Matn, $Title, $tid, $pages, $pageid, $treeid, $tozih, $all, $mosh, $alamat, $Matn_Part, $matinpart, $announce, $PishShomare_select, $PishShomare, $uid, $sesid)
    {

        $user = UserClass::CheckLogin($uid, $sesid);
        $user = ($user == TRUE) ? 'true' : 'false';
        if ($user)
        {
            $despageid = $repid;
            $announces = '0';
            $showtype = '1';
            if (trim($Matn_Part) == 'قسمت مورد نظر را از متن زیر انتخاب و در اینجا درج نمایید')
            {
                $Matn_Part = '';
            }
            if ($tozih == 'true')
            {
                $showtype = '1';
            }
            if ($all == 'true')
            {
                $showtype = '2';
            }
            if ($mosh == 'true')
            {
                $showtype = '3';
            }
            if ($matinpart == 'true')
            {
                $showtype = '0';
            }
            if ($alamat == 'true')
            {
                $announces = $announce;
                $showtype = '4';
            }
            $select = '0';
            if ($PishShomare_select != 'true')
            {
                $select = '1';
                $PishShomare = '0';
            }
            if ($type == "add")
            {
                $work = $old_id;
                DB::table('page_tree')->where('id', $old_id)->update(
                    array('tid' => $pageid, 'uid' => $uid, 'name' => $Title, 'orders' => $order, 'reg_date' => 'CURRENT_TIMESTAMP()', 'descr' => $Matn, 'showtype' => $showtype, 'prenum' => $PishShomare,
                        'prenumselect' => $select, 'highid' => $announces, 'pid' => $despageid, 'slave' => '1', 'parent_id' => $parentid, 'partoftext' => $Matn_Part)
                );

                if ($showtype == '2')
                {
                    DB::table('pagetree_pages')->where('ptid', $work)->delete();
                    $myArray = explode(',', $pages);
                    if (is_array($myArray))
                    {

                        foreach ($myArray as $value)
                        {
                            if ($value != '')
                            {
                                DB::table('pagetree_pages')->insert(
                                    array('ptid' => $work, 'pid' => $value));
                            }
                        }
                    }
                    else
                    {
                        DB::table('pagetree_pages')->insert(
                            array('ptid' => $work, 'pid' => $pages));
                    }
                }
            }
            elseif ($type == "edit")
            {
                if ($despageid == '0')
                {
                    $showtype = '0';
                }
                if ($all = 'true')
                {
                    $showtype = '2';
                }
                DB::table('page_tree')
                    ->where('id', $treeid)
                    ->update(array('name' => $Title, 'descr' => $Matn, 'showtype' => $showtype, 'prenum' => $PishShomare, 'prenumselect' => $select
                    , 'highid' => $announces, 'pid' => $despageid));

                DB::table('pagetree_pages')->where('ptid', '=', $treeid)->delete();
                if ($all == 'true' && is_array($pages))
                {
                    foreach ($pages as $key => $value)
                    {
                        DB::table('pagetree_pages')->insert(
                            array('ptid' => $treeid, 'pid' => $value));
                    }
                }
            }

            $mes = trans('labels.PoodmanUpdate');
            $err = false;
        }
        else
        {
            $mes = trans('labels.FailUser');
            $err = true;
        }
        return response()->json(array(
            'error' => $err,
            'data' => $mes), 200
        )->setCallback(Input::get('callback'));
    }

    public static function NewTreeNode($old_id, $repid, $SelReports, $parentid, $type, $Matn, $Title, $tid, $pages, $pageid, $treeid, $tozih, $all, $mosh, $alamat, $Matn_Part, $matinpart, $announce, $PishShomare_select, $PishShomare, $uid, $sesid)
    {
        $user = UserClass::CheckLogin($uid, $sesid);
        $user = ($user == TRUE) ? 'true' : 'false';
        if ($user)
        {
            $despageid = $repid;
            $announces = '0';
            $order = DB::table('page_tree')->where('tid', $pageid)->where('parent_id', '0')->max('orders');
            $order++;

            $showtype = '1';
            if (trim($Matn_Part) == 'قسمت مورد نظر را از متن زیر انتخاب و در اینجا درج نمایید')
            {
                $Matn_Part = '';
            }
            if ($tozih == 'true')
            {
                $showtype = '1';
            }
            if ($all == 'true')
            {
                $showtype = '2';
            }
            if ($mosh == 'true')
            {
                $showtype = '3';
            }
            if ($matinpart == 'true')
            {
                $showtype = '0';
            }
            if ($alamat == 'true')
            {
                $announces = $announce;
                $showtype = '4';
            }
            $select = '0';
            if ($PishShomare_select != 'true')
            {
                $select = '1';
                $PishShomare = '0';
            }
            if ($type == "add")
            {
                $work = DB::table('page_tree')->insertGetId(
                    array('tid' => $pageid, 'uid' => $uid, 'name' => $Title, 'orders' => $order, 'reg_date' => 'CURRENT_TIMESTAMP()', 'descr' => $Matn, 'showtype' => $showtype, 'prenum' => $PishShomare,
                        'prenumselect' => $select, 'highid' => $announces, 'pid' => $despageid, 'slave' => '1', 'parent_id' => $parentid, 'partoftext' => $Matn_Part)
                );

                if ($showtype == '2')
                {
                    $myArray = explode(',', $pages);
                    if (is_array($myArray))
                    {
                        foreach ($myArray as $value)
                        {
                            if ($value != '')
                            {
                                DB::table('pagetree_pages')->insert(
                                    array('ptid' => $work, 'pid' => $value));
                            }
                        }
                    }
                    else
                    {
                        DB::table('pagetree_pages')->insert(
                            array('ptid' => $work, 'pid' => $pages));
                    }
                }
            }
            elseif ($type == "edit")
            {
                if ($despageid == '0')
                {
                    $showtype = '0';
                }
                if ($all = 'true')
                {
                    $showtype = '2';
                }
                DB::table('page_tree')
                    ->where('id', $treeid)
                    ->update(array('name' => $Title, 'descr' => $Matn, 'showtype' => $showtype, 'prenum' => $PishShomare, 'prenumselect' => $select, 'highid' => $announces, 'pid' => $despageid));

                DB::table('pagetree_pages')->where('ptid', '=', $treeid)->delete();
                if ($all == 'true')
                {
                    foreach ($pages as $key => $value)
                    {
                        DB::table('pagetree_pages')->insert(
                            array('ptid' => $treeid, 'pid' => $value));
                    }
                }
            }

            $mes = trans('labels.PoodmanUpdate');
            $err = false;
        }
        else
        {
            $mes = trans('labels.FailUser');
            $err = true;
        }
        return response()->json(array(
            'error' => $err,
            'data' => $mes), 200
        )->setCallback(Input::get('callback'));
    }

    public static function DeleteTreeNode($ptid, $uid, $sesid)
    {
        $user = UserClass::CheckLogin($uid, $sesid);
        $user = ($user == TRUE) ? 'true' : 'false';
        if ($user)
        {
            DB::table('page_tree')->where('id', '=', $ptid)->delete();
            $mes = trans('labels.PoodmanUpdate');
            $err = false;
        }
        else
        {
            $mes = trans('labels.FailUser');
            $err = true;
        }
        return response()->json(array(
            'error' => $err,
            'data' => $mes), 200
        )->setCallback(Input::get('callback'));
    }

    public function tree_bodyOnlyTree($pid)
    {
        $page = array();
        $sr = '';
        $x = 0;
        $rowT = DB::table('page_tree as pt')->select('pt.id', 'pt.name as url', 'parent_id', 'pt.id as url2')->where('pt.tid', $pid)->orderBy('pt.parent_id')->orderBy('pt.orders')->orderBy('pt.id')->get();
        $row = DB::table('page_tree as pt')->select('pt.id', 'pt.name', 'parent_id', 'pt.id as url', 'pt.*')->where('pt.tid', $pid)->where('pt.parent_id', '0')->orderBy('pt.parent_id')->orderBy('pt.orders')->take(1)->orderBy('pt.id')->get();
        $PC = new PageClass();
        if ($row)
        {
            $rows = $PC->PageTreeBody($row);
            foreach ($row as $value)
            {
                $rows .= '<input type="hidden" class="ptid" value="' . $value->id . '">';
            }
        }


        $res['body'] = $rows;
        $res['list'] = $rowT;
        return $res;
    }

    public function tree_bodyOnlyList($pid)
    {
        $page = array();
        $sr = '';
        $x = 0;
        $rowT = DB::table('page_tree as pt')->select('pt.id', 'pt.name as url', 'parent_id', 'pt.id as url2')->where('pt.tid', $pid)->orderBy('pt.parent_id')->orderBy('pt.orders')->orderBy('pt.id')->get();
        foreach ($rowT as $value)
        {
            if ($value->parent_id == '0')
            {
                $value->parent_id = '#';
            }
        }
        $row = DB::table('page_tree as pt')->select('pt.id', 'pt.name', 'parent_id', 'pt.id as url', 'pt.*')->where('pt.tid', $pid)->where('pt.parent_id', '0')->orderBy('pt.parent_id')->orderBy('pt.orders')->orderBy('pt.id')->get();
        $PC = new PageClass();
        $rows = $PC->PageTreeBody($row);
        $res['body'] = $rows;
        $res['list'] = $rowT;

        return $res;
    }

    public function PageTreeBody($rows)
    {
        $bodys = '';
        $route = Route::current();
        $route_type = strtolower($route->type);
        $route_id = $route->id;
        $first_node = DB::table('page_tree')->where('tid', $route_id)->where('parent_id', '>', '0')->where('pid', '>', '0')->orderBy('orders')->orderBy('id')->first();
        $page = Pages::find($first_node->pid);

        $bodys .= '<h1 id="' . $first_node->id . '">' . $first_node->name . '</h1>';
        $bodys .= $page->body;

        /*
        foreach ($rows as $row)
        {
            $Htext = '';
            $tarix2 = '';
            $newrow = DB::table('page_tree as pt')->select('pt.id', 'pt.name', 'parent_id', 'pt.id as url', 'pt.*')->where('pt.parent_id', $row->id)->orderBy('pt.orders')->orderBy('pt.id')->get();
            if ($newrow)
            {
                $bodys .= $this->CrtaeData($row);
                $bodys .= $this->PageTreeBody($newrow);
            }
            else
            {
                $bodys .= $this->CrtaeData($row);
            }
        }
        */
        return $bodys;
    }

    function CrtaeData($row)
    {
        $bodys = '';
        if ($row->parent_id == 0)
        {
            $bodys .= '<h1 id="' . $row->id . '">' . $row->name . '</h1>';
        }
        else
        {
            $bodys .= '<h2 id="' . $row->id . '">' . $row->name . '</h2>';
        }
        switch ($row->showtype)
        {
            case "0":
                $tarix2 = $row->partoftext;
                //$Page = DB::table('subjectss AS s')->join('pages AS p', 'p.sid', '=', 's.id')->select('s.title')->where('p.id', $row->pid)->first();
                //$tarixlink = '<a href="' . $Page->pid . '" target="_blank">ماخذ: ' . $Page->title . ' </a>';
//                    $tarix = '<br><span style="float:left">' . $tarixlink . '</span><br>';
//                    $Htext = $tarix2 . $tarix;
                $bodys .= $tarix2;
                break;
            case "1":
                if ($row->pid != '0')
                {
                    $Page = DB::table('pages')->select('description')->where('id', $row->pid)->first();
                    if ($Page)
                    {
                        $bodys .= $Page->description;
                    }
                }
                else
                {
                    $bodys .= '';
                }
                break;
            case "2":
                $Page = DB::table('page_tree_pages')->where('ptid', $row->id)->get();
                foreach ($Page as $value)
                {
                    $Pages = DB::table('pages')->where('id', $value->pid)->first();
                    if ($Pages)
                    {
                        $page_tree = DB::table('page_tree')->find($row->id);
                        if ('370450' == $page_tree->tid)
                        {
                            $bodys .= $Pages->body;
                        } else
                        {
                            $PageClass = new PageClass();
                            $bodys .= $PageClass->modifyText($Pages->body);
                        }
                    }
                }
                break;
            case "3":
                $Page = DB::table('subjects AS s')->join('pages AS p', 'p.sid', '=', 's.id')->select('s.title,s.kind,s.id')->where('p.id', $row->pid)->first();
                $sids = $Page->id;
                $kind = $Page->kind;
                $bodys .= PageClass::page_field_html($row->pid, $sid, $kind);
                break;
            case "4":
                $tarix = '';
                if ($row->highid != '0')
                {

                    $Page = DB::table('announces as a')->select('a.pid', 'a.id', 'a.title,a.quote')->where('id', $row->highid)->first();
                    $Htext = str_replace("\\n", ' ', $Page->quote);
                    $Htext = str_replace("\\r", ' ', $Htext);
                    $Htext = str_replace("\\", ' ', $Htext);
                    $bodys .= $Htext;
                }
//$Page = DB::table('subjects AS s')->join('pages AS p', 'p.sid', '=', 's.id')->select('s.title,s.kind,s.id')->where('p.id', $row->pid)->groupBy('p.id')->first();
//                        if ($Page) {
//                            $tarixlink = '<a href="' . $Page->pid. '" target="_blank">ماخذ: ' . $Page->title . ' </a>';
//                            $tarix = '<br><span style="float:left">' . $tarixlink . '</span><br>';
//                        }
//                        $Htext.=$tarix;
                break;
        }
        return $bodys;
    }

    public static function subjectExport($pid, $sid)
    {
        $page = DB::table('pages as p')
            ->join('subjects as s', 's.id', '=', 'p.sid')
            ->where('p.id', $pid)
            ->select('s.kind')
            ->first();
        $kind = $page->kind;
        $tabs = DB::table('pages as p')
            ->leftJoin("subject_type_tab as stt", 'p.type', '=', 'stt.tid')
            ->where('p.sid', $sid)
            ->where('stt.stid', $kind)
            ->where('stt.view', '1')
            ->select('p.id as pid', 'stt.name as name')
            ->orderBy('stt.orders')
            ->get();
        return $tabs;
    }

    public static function export_pdf($html, $title)
    {

    }

    public static function subjectPrint($type, $pid, $sid, $ch, $numbers = 1)
    {
        $ret = array();

        if ($type == '1')
        {
            $page = DB::table('pages as p')
                ->join('subjects as s', 's.id', '=', 'p.sid')
                ->where('p.id', $pid)->select('p.viewslide', 'p.viewfilm', 'p.viewtext', 'p.defimage', 'p.showDefimg', 'p.id', 'p.sid', 'p.body', 'p.description', 'p.form', 'p.view', 'p.edit', 'p.ver_date', 's.title as Title', 's.kind', 'p.type as type')->first();
            $PC = new PageClass();
            $kind = $page->kind;
            $subject_type_tab = DB::table('subject_type_tab')->where('stid', $kind)->where('tid', $page->type)->first();
            $pAGEtYPE = $subject_type_tab->type;
            if ($pAGEtYPE == '7')
            {
                $Trees = $PC->tree_bodyOnlyList($pid);
                $page = $Trees['body'];
            }
            else
            {
                $page = $PC->modifyText($page->body);
                $page = $PC->bodyPara($page, '', '', $numbers);
            }
            $tabs = DB::table('pages as p')->leftJoin("subject_type_tab as stt", 'p.type', '=', 'stt.tid')
                ->where('p.sid', $sid)->where('stt.stid', $kind)->where('stt.view', '1')
                ->select('p.id as pid', 'stt.name as name')->orderBy('stt.orders')->get();

            $ret['tabs'] = $tabs;
            $ret['print'] = $page;
            $err = false;
            $mes = $ret;
        }
        else
        {

            $page = '';
            $myArray = explode(',', $ch);
            foreach ($myArray as &$value)
            {
                $pages = DB::table('pages as p')
                    ->join('subjects as s', 's.id', '=', 'p.sid')
                    ->where('p.id', $value)->select('p.viewslide', 'p.viewfilm', 'p.viewtext', 'p.defimage', 'p.showDefimg', 'p.id', 'p.sid', 'p.body', 'p.description', 'p.form', 'p.view', 'p.edit', 'p.ver_date', 's.title as Title', 's.kind', 'p.type as type')->first();
                $PC = new PageClass();
                $kind = $pages->kind;
                $subject_type_tab = DB::table('subject_type_tab')->where('stid', $kind)->where('tid', $pages->type)->first();
                $pAGEtYPE = $subject_type_tab->type;
                if ($pAGEtYPE == '7')
                {
                    $Trees = $PC->tree_bodyOnlyList($pid);
                    $page = $Trees['body'];
                }
                else
                {
                    $page = $PC->modifyText($pages->body);
                    $page = $PC->bodyPara($page, '', '', $numbers);
                }

                // $page .= $PC->modifyText($pages->body);
            }

            $tabs = DB::table('pages as p')
                ->leftJoin("subject_type_tab as stt", 'p.type', '=', 'stt.tid')
                ->where('p.sid', $sid)
                ->where('stt.stid', $kind)
                ->where('stt.view', '1')
                ->select('p.id as pid', 'stt.name as name')
                ->orderBy('stt.orders')
                ->get();
            $ret['tabs'] = $tabs;
            $ret['print'] = $page;
            $err = false;
            $mes = $ret;
        }
        return $ret;
    }

    public static function DefimagePage($pid, $uid, $sesid, $check, $file)
    {
        if ($file != '')
        {
            DB::table('pages')
                ->where('id', $pid)
                ->update(array('defimage' => $file, 'showDefimg' => "$check"));
        }
        else
        {
            DB::table('pages')
                ->where('id', $pid)
                ->update(array('showDefimg' => "$check"));
        }
        $mes = trans('labels.editok');
        $err = false;
        return $mes;
    }

    public static function page_edit_description($pid, $uid, $sesid, $descr)
    {
        $user = UserClass::CheckLogin($uid, $sesid);
        $user = ($user == TRUE) ? 'true' : 'false';
        if ($user)
        {
            DB::table('pages')
                ->where('id', $pid)
                ->update(array('description' => $descr));
            $mes = trans('labels.editok');
            $err = false;
        }
        else
        {
            trans('labels.FailUser');
            $err = true;
        }
        return response()->json(array(
            'error' => $err,
            'data' => $mes), 200
        )->setCallback(Input::get('callback'));
    }

    public static function page_edit($pageid, $uid, $sesid, $content, $ver_comment, $ver_date, $edit_numm, $description)
    {
        $edit_date = gmdate("Y-m-d H:i:s", time() + 12600);
        $ver_date = $edit_date;
        $admin = $uid;
        $content = PublicsClass::to_latin_num($content);
        $content = PageClass::ModifyContent($content);
        DB::table('pages')
            ->where('id', $pageid)
            ->update(array('body' => $content, 'edit_date' => $edit_date, 'editor' => $admin, 'ver_date' => $ver_date, 'description' => $description));
        $ver = DB::table('page_version')
            ->where('pid', $pageid)
            ->select('vid')
            ->get();
        $newver = 0;
//        if ($ver)
//            $newver = $ver->vid;
        $newver++;
        DB::table('page_version')
            ->insert(
                [
                    'admin' => $uid,
                    'pid' => $pageid,
                    'vid' => $newver,
                    'body' => $content,
                    'comment' => $ver_comment,
                    'ver_date' => $ver_date
                ]);
        $first = 0;
        $second = 0;
        $part = 0;
        $edit_num = '1';
        $edit_com = '';
        DB::table('history')
            ->where('pid', $pageid)
            ->update(['active' => '0']);
        DB::table('history')->insert(
            [
                'admin' => $uid,
                'pid' => $pageid,
                'first' => $first,
                'second' => $second,
                'body' => $content,
                'edit_date' => $edit_date,
                'ver_date' => $ver_date,
                'part' => $part,
                'edit' => $edit_num,
                'com' => $edit_com,
                'active' => '1'
            ]);
        $mes = trans('labels.editok');
        $err = false;
        return $mes;
    }

    public static function ModifyContent($content)
    {
        $content = str_replace("<h2>&nbsp;</h2>", "", $content);
        $content = str_replace("<h2></h2>", "", $content);
        $content = str_replace("<h2> </h2>", "", $content);
        $content = str_replace("<h1>&nbsp;</h1>", "", $content);
        $content = str_replace("<h1></h1>", "", $content);
        $content = str_replace("<h1> </h1>", "", $content);
        $content = str_replace("<h3>&nbsp;</h3>", "", $content);
        $content = str_replace("<h3></h3>", "", $content);
        $content = str_replace("<h3> </h3>", "", $content);
        $content = str_replace("<h4>&nbsp;</h4>", "", $content);
        $content = str_replace("<h4></h4>", "", $content);
        $content = str_replace("<h4> </h4>", "", $content);
        $content = PageClass::stem($content);
//                if ($standard == 1)
//                    $content = $this->styleDel($content);
        $content = PublicsClass::subst($content);
        return $content;
    }

    public static function stem($string)
    {
        $newwords = array("ك" => "ک", "ي" => "ی", "&nbsp;" => " ", "­" => " ", "&zwnj;" => " ", "&zwj;" => " ", "&rlm;" => " ", "&lrm;" => " ", "&thinsp;" => " ", "&ensp;" => " ", "&emsp;" => " ", " " => " ", " " => " ", "  " => " ", "   " => " ", "    " => " ", "" => "‌"); //"‌"هشت‌ساله

        foreach ($newwords as $key => $val)
        {
            $string = str_replace($key, $val, $string);
        }
        return $string;
    }

    public static function page_field_html($pid = 0, $sid = 0, $kind)
    {
        $Pfields = array();
        if ($pid != 0)
        {
            $page_field = '';
            $pageDet = DB::table('subject_fields_report as r')
                ->leftJoin('subject_type_fields as t', 'r.field_id', '=', 't.field_id')
                ->leftJoin('fields as f', 'r.field_id', '=', 'f.id')
                ->leftJoin('fields_value as v', 'v.field_id', '=', 'f.id')
                ->where('r.sid', $sid)->where('t.stid', $kind)
                ->orderBy('t.orders')->orderBy('v.orders')
                ->select('r.field_id', 'r.check_id', 'r.field_value as field_val', 'f.field_name', 'f.field_type'
                    , 'v.field_value', 'v.id as vid')->get();
            if ($pageDet)
            {
                $name = array();
                $value = array();
                $i = 1;
                foreach ($pageDet as $row)
                {
                    $field_id = $row->field_id;
                    $name[$row->field_id] = $row->field_name;
                    if ($row->field_type == 'select' || $row->field_type == 'radio')
                    {
                        if ($row->field_val == $row->vid)
                        {
                            $value[$row->field_id] = $row->field_value;
                        }
                        else
                        {
                            $value[$row->field_id] = $row->field_value;
                        }
                    }
                    else
                    {
                        if ($row->field_type == 'checkbox')
                        {
                            if ($row->check_id == $row->vid)
                            {
                                $value[$row->field_id] = $row->field_value;
                            }
                            else
                            {
                                $index = $row->field_id + $i;
                                $value[$index] = $row->field_value;
                            }
                        }
                        else
                        {
                            $value[$row->field_id] = $row->field_val;
                        }
                    }
                    $i++;
                }
                foreach ($name as $key => $val)
                {
                    if (trim($value[$key]) != '')
                    {
                        $notempty = true;
                        $page_field['label'] = $val;

                        $page_field['val'] = $value[$key];
                        array_push($Pfields, $page_field);
                    }
                }
            }
        }
        $str = '';
        if (is_array($Pfields))
        {
            $str = '<table class="table-condensed">';
            foreach ($Pfields as $value)
            {
                $str .= '<tr><td style="padding:2px 5px 0 5px ;">' . $value['label'] . '</td><td>' . $value['val'] . '</td></tr>';
            }
            $str .= '</table>';
        }
    }

    public static function page_field($pid = 0, $sid = 0, $kind)
    {
        $Pfields = array();
        if ($pid != 0)
        {
            $page_field = '';
            $fields = DB::table('subject_type_fields')
                ->where('stid', $kind)
                ->orderBy('orders')
                ->select('name', 'type', 'id', 'defvalue')->get();
            $reps = DB::table('subject_fields_report as r')
                ->leftJoin('subject_type_fields as t', 'r.field_id', '=', 't.id')
                ->where('r.sid', $sid)->where('t.stid', $kind)
                ->orderBy('t.orders')
                ->select('t.name', 't.type', 't.defvalue', 't.id', 'r.check_id', 'r.field_value as field_val')->get();
        }

        return $reps;
    }

    public function GetSubjectType($uid = 0, $session_id = 0)
    {
        $pageDet = DB::table('subject_type')->select('id', 'name')->get();
        return response()->json(array(
            'error' => false,
            'data' => $pageDet), 200
        )->setCallback(Input::get('callback'));
    }

    public function charchoob()
    {
        //$pageDet = DB::table('charchoob')->get();
        $pageDet = DB::table('subjects as s')
            ->join('subject_key as sk', 's.id', '=', 'sk.sid')
            ->where('sk.kid', '212')->select('s.id', 's.title')->get();
        return response()->json(array(
            'error' => false,
            'data' => $pageDet), 200
        )->setCallback(Input::get('callback'));
    }

    public function template($subid = 0)
    {
        if ($subid == 0)
        {
            $pageDet = DB::table('subjects as s')
                ->join('subject_key as sk', 's.id', '=', 'sk.sid')
                ->where('sk.kid', '254')->select('s.id', 's.title')->get();
        }
        else
        {

        }

        return response()->json(array(
            'error' => false,
            'data' => $pageDet), 200
        )->setCallback(Input::get('callback'));
    }

    public function page_tools($sid, $pid = 0, $uid, $subtype = 'subject', $session_id)
    {
        $help = '';
        $tabname = '';
        $user = UserClass::CheckLogin($uid, $session_id);
        $user = ($user == TRUE) ? 'true' : 'false';
        if ($subtype == 'subject')
        {
            $help = array();
            $helps = DB::table('pages')->where('id', $pid)->select('help_pid', 'help_tag')->first();
            $typehelp = DB::table('subject_type_tab AS stt')->join('subjects AS s', 's.kind', '=', 'stt.stid')->where('s.id', $sid)->select('help_pid', 'help_tag')->first();
            if ($helps->help_pid != '' && $helps->help_pid != '0')
            {
                $help['id'] = $helps->help_pid;
                $help['pageid'] = $helps->help_pid;
                $tag = $helps->help_tag;
                $p = strpos($tag, '+');
                $e = strpos($tag, '=');
                $tag = substr($tag, $p + 1, $e - $p - 1);
                $help['tagname'] = $tag;
            }
            else
            {
                if ($typehelp->help_pid != '' && $typehelp->help_pid != '0')
                {
                    $help['id'] = $typehelp->help_pid;
                    $help['pageid'] = $typehelp->help_pid;
                    $tag = $typehelp->help_tag;
                    $p = strpos($tag, '+');
                    $e = strpos($tag, '=');
                    $tag = substr($tag, $p + 1, $e - $p - 1);
                    $help['tagname'] = $tag;
                }
                else
                {
                    $help = PublicsClass::HelpManage($sid, $tabname, $subtype);
                }
            }
        }
        elseif ($subtype == 'subjectdesktop')
        {
            $help = array();
            $help = PublicsClass::HelpManage($sid, 'Subject', 'Desktop');
        }
        elseif ($subtype == 'subjectwall')
        {
            $help = array();
            $help = PublicsClass::HelpManage($sid, 'Subject', 'bahs');
        }


        if ($user == 'true')
        {
            $pageDet = DB::table('subject_member')
                ->where('uid', $uid)->where('sid', $sid)->select('id', 'relation', 'follow', 'like')->first();
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
            $Taamol = array();
            $Abzar = array();
            $i = 1;
            if ($subtype == 'subject')
            {
                $menutools = DB::table('tools_group')->orderBy('orders')->get();
                foreach ($menutools as $value)
                {
                    $toolsCount = DB::table('tools')->where('subject', '1')->where('menuid', $value->id)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->count();
                    if ($toolsCount > 0)
                    {
                        $tools = DB::table('tools')->where('subject', '1')->where('menuid', $value->id)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->get();
                        $Taamol['label'] = $value->name;
                        $Taamol['tools'] = $tools;
                        $Abzar[$i] = $Taamol;
                    }
                    $i++;
                }
            }
            elseif ($subtype == 'subjectwall')
            {
                $menutools = DB::table('tools_group')->orderBy('orders')->get();
                foreach ($menutools as $value)
                {
                    $toolsCount = DB::table('tools')->where('subjectforum', '1')->where('menuid', $value->id)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->count();
                    if ($toolsCount > 0)
                    {
                        $tools = DB::table('tools')->where('subjectforum', '1')->where('menuid', $value->id)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->get();
                        $Taamol['label'] = $value->name;
                        $Taamol['tools'] = $tools;
                        $Abzar[$i] = $Taamol;
                    }
                    $i++;
                }
            }
            elseif ($subtype == 'subjectdesktop')
            {
                $menutools = DB::table('tools_group')->orderBy('orders')->get();
                foreach ($menutools as $value)
                {
                    $toolsCount = DB::table('tools')->where('subjectdesktop', '1')->where('menuid', $value->id)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->count();
                    if ($toolsCount > 0)
                    {
                        $tools = DB::table('tools')->where('subjectdesktop', '1')->where('menuid', $value->id)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->get();
                        $Taamol['label'] = $value->name;
                        $Taamol['tools'] = $tools;
                        $Abzar[$i] = $Taamol;
                    }
                    $i++;
                }
            }
        }
        else
        {
            $res['like'] = '0';
            $res['follow'] = 0;
            $res['relation'] = 0;
            $Taamol = array();
            $Abzar = array();
            $i = 1;
            if ($subtype == 'subject')
            {
                $menutools = DB::table('tools_group')->orderBy('orders')->get();
                foreach ($menutools as $value)
                {
                    $toolsCount = DB::table('tools')->where('subject', '1')->where('menuid', $value->id)->where('login', '>', 0)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->count();
                    if ($toolsCount > 0)
                    {
                        $tools = DB::table('tools')->where('subject', '1')->where('menuid', $value->id)->where('login', '>', 0)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->get();
                        $Taamol['label'] = $value->name;
                        $Taamol['tools'] = $tools;
                        $Abzar[$i] = $Taamol;
                    }
                    $i++;
                }
            }
            elseif ($subtype == 'subjectwall')
            {
                $menutools = DB::table('tools_group')->orderBy('orders')->get();
                foreach ($menutools as $value)
                {
                    $toolsCount = DB::table('tools')->where('subjectforum', '1')->where('menuid', $value->id)->where('login', '>', 0)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->count();
                    if ($toolsCount > 0)
                    {
                        $tools = DB::table('tools')->where('subjectforum', '1')->where('menuid', $value->id)->where('login', '>', 0)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->get();
                        $Taamol['label'] = $value->name;
                        $Taamol['tools'] = $tools;
                        $Abzar[$i] = $Taamol;
                    }
                    $i++;
                }
            }
            elseif ($subtype == 'subjectdesktop')
            {
                $menutools = DB::table('tools_group')->orderBy('orders')->get();
                foreach ($menutools as $value)
                {
                    $toolsCount = DB::table('tools')->where('subjectdesktop', '1')->where('menuid', $value->id)->where('login', '>', 0)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->count();
                    if ($toolsCount > 0)
                    {
                        $tools = DB::table('tools')->where('subjectdesktop', '1')->where('menuid', $value->id)->where('login', '>', 0)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->get();
                        $Taamol['label'] = $value->name;
                        $Taamol['tools'] = $tools;
                        $Abzar[$i] = $Taamol;
                    }
                    $i++;
                }
            }
        }
        if ($user)
        {
            $Admin = $this->ISManagerPage($sid, $uid);
            $edit = $this->allowEdit($pid, $uid);
            foreach ($Abzar as $value)
            {
                if (is_array($value['tools']) && count($value['tools']) > 0)
                {
                    $tt = $value['tools'];
                    foreach ($tt as $item)
                    {
                        $acess = UserClass::permission('subject_new', $uid);
                        if ($item->url == 'newsubject' && $acess == 2)
                        {
                            $item->modal = 100;
                        }
                        elseif ($item->url == 'newsubject' && $acess == 4)
                        {
                            $item->modal = 200;
                        }

                        $acess = UserClass::permission('manager_edit', $uid);
                        if ($item->url == 'setting' && $acess == 2)
                        {
                            if (!$Admin)
                            {
                                $item->modal = 100;
                            }
                        }
                        elseif ($item->url == 'setting' && $acess == 4)
                        {
                            if (!$Admin)
                            {
                                $item->modal = 200;
                            }
                        }
                        $acess = UserClass::permission('DelSubjects', $uid);
                        if ($item->url == 'delete' && $acess == 2)
                        {
                            if (!$Admin)
                            {
                                $item->modal = 100;
                            }
                        }
                        elseif ($item->url == 'delete' && $acess == 4)
                        {
                            if (!$Admin)
                            {
                                $item->modal = 200;
                            }
                        }

//                        $acess = UserClass::permission('subject_edit', $uid);
//                        if ($item->url == 'pageedit' && $acess == 2) {
//                            if (!$Admin || $edit)
//                                $item->modal = 100;
//                        }
//                        elseif ($item->url == 'pageedit' && $acess == 4) {
//                            if (!$Admin || !$edit)
//                                $item->modal = 200;
//                        }
                    }
                }
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


        $Ret['Help'] = $help;
        $Ret['val'] = $res;
        $Ret['label'] = $lang;
        $Ret['othermenus'] = $Abzar;
//-----------------------
        return response()->json(array(
            'error' => false,
            'data' => $Ret), 200
        )->setCallback(Input::get('callback'));
    }

    public function page_films($pid)
    {
        $Slides = DB::table('page_films')->where('pid', '=', $pid)->get();
        $slides = array();
        $slide = array();
        foreach ($Slides as $Slide)
        {
            $slide['id'] = $Slide->id;
            $slide['pretitle'] = $Slide->pretitle;
            $slide['title'] = $Slide->title;
            $slide['film'] = $Slide->film;
            $slide['pic'] = $Slide->pic;
            $slide['descr'] = $Slide->descr;
            $slide['length'] = $Slide->length;
            array_push($slides, $slide);
        }
        return $slides;
    }

    public function page_slides($pid)
    {
        $Slides = DB::table('page_slides')->where('pid', '=', $pid)->orderby('order')->get();
        $slides = array();
        $slide = array();
        foreach ($Slides as $Slide)
        {
            $slide['id'] = $Slide->id;
            $slide['src'] = $Slide->src;
            $slide['order'] = $Slide->order;
            array_push($slides, $slide);
        }
        return $slides;
    }

    public function page_files($pid)
    {
        $files = Pages::find($pid);
        $files = $files ? $files->files : [];
        /*$files = array();
        $fileD = array();
        $Files = DB::table('page_file')
            ->where('pid', '=', $pid)
            ->select('id', 'title', 'name', 'size')
            ->get();
        foreach ($Files as $File)
        {
            $ex = '';
            $size_format = sprintf("%01.2f", $File->size / 1000);
            $xmlFile = pathinfo($File->name);
            $xmlFile2 = pathinfo($File->title);
            if ($xmlFile && array_key_exists('extension', $xmlFile))
            {
                $ex = $xmlFile['extension'];
            }
            $filename = str_replace(".$ex", "", $File->title);
            if ($filename == '')
            {
                $filename = str_replace(".$ex", "", $File->name);
            }
            $fileD['size'] = $size_format;
            $fileD['id'] = $File->id;
            $fileD['title'] = $filename;
            $fileD['name'] = $File->name;
            $fileD['ext'] = $ex;
            array_push($files, $fileD);
        }
        */
        return $files;
    }

    public function PageKeywords($sid)
    {
        $keywordsAr = array();
        $keywordsArF = array();
        $keys_catch = '';
        $Keys = DB::table('subject_fields_report AS sfr')
            ->join('fields AS f', 'sfr.field_id', '=', 'f.id')
            ->where('sid', '=', $sid)
            ->where('field_value', '!=', '')
            ->whereRaw("f.field_type like 'KEYWORD_%'")
            ->get();
        //$keywords0 = '';
        $TT_ttype = array();
        if ($Keys)
        {
            foreach ($Keys as $Key)
            {
                //$value = $Key->field_value;
                //$myArray = explode(',', $value);
                //$nums = sizeof($myArray);
                //$nums--;
                foreach ($TT_ttype as $key => $value)
                {

                    if (trim($value) != '')
                    {
                        $keys = trim($value);
                        //$ttype = (isset($TT_ttype[$key])) ? $this->Filter($TT_ttype[$key]) : '';

                        $Keyws = DB::table('keywords')
                            ->where('title', '=', $keys)
                            ->select('id', 'title', 'user_id')
                            ->get();
                        foreach ($Keyws as $Keyw)
                        {
                            $keyword = $Keyw->title;
                            $keyword = str_replace('،', ' ', $keyword);
                            if ($Keyw->user_id != '')
                            {
                                $keywordsAr['type'] = 'user';
                                $keywordsAr['id'] = $Keyw->user_id;
                                $keywordsAr['title'] = $keyword;
                            }
                            else
                            {
                                $keywordsAr['type'] = 'keyword';
                                $keywordsAr['id'] = $Keyw->id;
                                $keywordsAr['title'] = $keyword;
                            }
                            array_push($keywordsArF, $keywordsAr);
                        }
                    }
                    //$n++;
                }
            }
        }
        $KeySs = DB::table('subject_key')
            ->where('sid', '=', $sid)
            ->select('kid')
            ->get();
        foreach ($KeySs as $KeyS)
        {
            $keys_catch .= $KeyS->kid . ',';
        }
        $keys_catch = substr($keys_catch, 0, (strLen($keys_catch) - 1));
        if ($keys_catch != "")
        {
            /* $nums = DB::table('keywords as k')
              ->leftJoin('subject_key as c', 'k.id', '=', 'c.kid')
              ->whereRaw('(k.id IN (' . $keys_catch . '))')
              ->groupBy('k.id')
              ->select(DB::raw('count(*) as n, k.id,k.keyword as keyword'))
              ->count(); */
            $KeySs = DB::table('keywords as k')
                ->leftJoin('subject_key as c', 'k.id', '=', 'c.kid')
                ->whereRaw('(k.id IN (' . $keys_catch . '))')
                ->groupBy('k.id')
                ->select(DB::raw('count(*) as n, k.id,k.title as keyword'))
                ->get();
            //$n = 1;
            //$All = '';
            //$keywords = '';
            foreach ($KeySs as $KeyS)
            {
                $keywordsAr['type'] = 'keyword';
                $keywordsAr['id'] = $KeyS->id;
                $keywordsAr['title'] = $KeyS->keyword;
                array_push($keywordsArF, $keywordsAr);
            }
        }
        return $keywordsArF;
    }

    public function LikeADD($user, $sid)
    {
        $like = DB::table('subject_member')->where('uid', '=', $user)->where('sid', '=', $sid)->first();
        if ($like)
        {
            DB::table('subject_member')->where('uid', '=', $user)->where('sid', '=', $sid)->update(['like' => '1']);;
        }
        else
        {
            DB::table('subject_member')->insert(['uid' => $user, 'sid' => $sid, 'like' => '1']);
        }
        DB::table('subjects')->where('id', '=', $sid)->increment('like');
        $message = array('val'=>'1','message'=>trans('labels.LikeOK'));
        return $message;
    }

    public function BookmarkADD($user, $link, $Title)
    {
        $type = 'subject';
        $bookmark = DB::table('bookmarks')->where('uid', '=', $user)->where('type', '=', $type)->where('link', '=', $link)->where('Title', '=', $Title)->first();
        if (is_null($bookmark))
        {
            DB::table('bookmarks')->insert(['uid' => $user, 'type' => $type, 'link' => $link, 'Title' => $Title]);
        }
        $message = trans('labels.BookmarkOK');
        return response()->json(array(
            'error' => false,
            'user' => 'lll'), 200
        )->setCallback(Input::get('callback'));
    }

    public function bookmarkRemove($user, $Bookid)
    {
        $like = DB::table('bookmarks')->where('uid', '=', $user)->where('id', '=', $Bookid)->first();
        if (is_null($like))
        {
            $message = trans('labels.Fail');
        }
        else
        {
            DB::table('bookmarks')->where('uid', '=', $user)->where('id', '=', $Bookid)->delete();
            $message = trans('labels.BookmarkRemove');
        }
        return response()->json(array(
            'error' => false,
            'user' => $message), 200
        )->setCallback(Input::get('callback'));
    }

    public function FollowADD($user, $sid)
    {
        $like = DB::table('subject_member')
            ->where('uid', '=', $user)
            ->where('sid', '=', $sid)
            ->first();
        if ($like)
        {
            DB::table('subject_member')
                ->where('uid', '=', $user)
                ->where('sid', '=', $sid)
                ->update(['follow' => '1']);
        }
        else
        {
            DB::table('subject_member')
                ->insert(['uid' => $user, 'sid' => $sid, 'follow' => '1']);
        }
        DB::table('subjects')
            ->where('id', '=', $sid)
            ->increment('follow');

        $message = array('val'=>'1','message'=>trans('labels.followOK'));
        return $message;
    }

    public function FollowRemove($user, $sid)
    {
        $Followed = DB::table('subject_member')
            ->where('uid', '=', $user)
            ->where('sid', '=', $sid)
            ->first();
        if (is_null($Followed))
        {
            $message = 'False';
        }
        else
        {
            DB::table('subject_member')
                ->where('uid', '=', $user)
                ->where('sid', '=', $sid)
                ->update(['follow' => '0']);
            $follow = DB::table('subjects')
                ->where('id', '=', $sid)
                ->where('follow', '>', '1')
                ->first();
            if (!is_null($follow))
            {
                DB::table('subjects')
                    ->where('id', '=', $sid)
                    ->decrement('follow');
            }
            $message = array('val'=>'0','message'=>trans('labels.followRemove'));
        }
        return $message;
    }

    public function LikeRemove($user, $sid)
    {
        $like = DB::table('subject_member')
            ->where('uid', '=', $user)
            ->where('sid', '=', $sid)
            ->first();
        if (is_null($like))
        {
            $message = 'False';
        }
        else
        {
            DB::table('subject_member')
                ->where('uid', '=', $user)
                ->where('sid', '=', $sid)
                ->update(['like' => '0']);
            //DB::table('subject_member')->where('uid', '=', $user)->where('sid', '=', $sid)->update(['follow' => '0']);
            $follow = DB::table('subjects')
                ->where('id', '=', $sid)
                ->where('like', '>', '1')
                ->first();
            if (!is_null($follow))
            {
                DB::table('subjects')
                    ->where('id', '=', $sid)
                    ->decrement('like');
            }

            $message = array('val'=>'0','message'=>trans('labels.LikeRemove'));
        }
        return $message;
    }

    public function SubjectDetails($pid, $sid)
    {
        $Subjects = '0';
        if ($pid != 0)
        {
            $Subjects = DB::table('subjects')
                ->join('pages', 'pages.sid', '=', 'subjects.id')
                ->where('pages.id', $pid)
                ->select('subjects.*')
                ->first();
        }
        else
        {
            if ($sid != 0)
            {
                $Subjects = DB::table('subjects')
                    ->where('id', $sid)
                    ->first();
            }
        }
        if ($Subjects)
        {
            return $Subjects;
        }
    }

    public function bodyPara($body, $nums = '', $ids = '', $headingNumber = '')
    {
        $page = array();
        $page['list'] = '';
        $h = array(
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
            '7' => 0,
            '8' => 0,
            '9' => 0
        );
        $head = preg_split("|<h1[^>]*>(.*)<\/h1>|U", $body, 2);
        $header = $head['0'];
        // $body = substr($body, strLen($head['0']), (strLen($body)));
        if (trim($head['0']) != '')
        {
            $header = '<div class="gkblock-4">' . $head['0'] . '</div>';
        }
        if ($num = preg_match_all("|<h([1-9]{1})[^>]*>(.*)<\/h[1-9]{1}>|U", $body, $array))
        {
            for ($x = 0; $x < $num; $x++)
            {
                if ($x > 0 && ($array['1'][$x] > $array['1'][$x - 1] + 1))
                {
                    $array['1'][$x] = $array['1'][$x - 1] + 1;
                }
                $depth = $array['1'][$x] - 1;
                $end_header = '';
//                if ($x > 0 && ($array['1'][$x] <= $array['1'][$x - 1])) {
//                    $end_header = str_repeat('</div></div>', $array['1'][$x - 1] - $array['1'][$x] + 1);
//                }
                if ($x > 0 && ($array['1'][$x] < $array['1'][$x - 1]))
                {
                    for ($z = $array['1'][$x - 1]; $z > $array['1'][$x]; $z--)
                    {
                        $h[$z] = 0;
                    }
                }
                $h[$array['1'][$x]] = (isset($h[$array['1'][$x]])) ? $h[$array['1'][$x]] + 1 : 1;
                $numeral1 = '';
                $numeral2 = '';
                $numeral3 = array();
                $id = '';
                $parent = '';
                for ($n = 1; $n <= $array['1'][$x]; $n++)
                {
                    $numeral3[$n] = $h[$n];
                    $id .= $h[$n] * 10;
                    if ($n != $array['1'][$x])
                    {
                        $parent .= $h[$n] * 10;
                    }
                }
                $numeral1 = $nums . implode(' - ', $numeral3) . ' - ';
                $title = strip_tags($array['2'][$x]);
                $sub_cache[$x]['id'] = $id;
                $sub_cache[$x]['x'] = $ids . ($x + 1);
                $sub_cache[$x]['parent_id'] = $parent;
                $sub_cache[$x]['title'] = $title;
                $tit = $sub_cache[$x]['title'];
                $hindex = intval($array['1'][$x]) + 1;
                $sub_cache[$x]['url'] = '<a rel="nofollow" href="#t' . $ids . ($x + 1) . '">' . $numeral1 . '' . $tit . '</a>';
                if ($headingNumber == 'on')
                {
                    $body = $this->str_replace_first($array['0'][$x], $end_header . '<h' . $hindex . ' id="t' . $id . '" class="heading">' . $numeral1 . $title . '</h' . $hindex . '>', $body);
                }
                else
                {
                    $body = $this->str_replace_first($array['0'][$x], $end_header . '<h' . $hindex . ' id="t' . $id . '" class="heading">' . $title . '</h' . $hindex . '>', $body);
                }
//                
//                 $body = $this->str_replace_first($array['0'][$x], $end_header . '<div class="total"><h' . $hindex . ' id="t' . $id . '" class="heading">
//				<span class="icon icon-open"></span>' . ' ' . $title . '</h' . $hindex . '><div class="inner">', $body);
            }
            //$end_header = str_repeat("</div></div>", $array['1'][$x - 1]);
            //  $body = $body . $end_header;
        }
        if (isset($sub_cache) && is_array($sub_cache))
        {
            $page['list'] = $sub_cache;
        }
        $pattern = "/{{Help\+.*=.*}}/";
        if ($num1 = preg_match_all($pattern, $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $body = str_replace($array['0'][$x], "", $body);
            }
        }
        $pattern = "/{{Help-.*}}/";
        if ($num1 = preg_match_all($pattern, $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $body = str_replace($array['0'][$x], "", $body);
            }
        }
        return $body;
    }

    public function bodyList($body, $nums = '', $ids = '')
    {
        $page = array();
        $page['list'] = '';
        $h = array(
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
            '7' => 0,
            '8' => 0,
            '9' => 0
        );
        $head = preg_split("|<h1[^>]*>(.*)<\/h1>|U", $body, 2);
        $header = $head['0'];
        $body = substr($body, strLen($head['0']), (strLen($body)));
        if (trim($head['0']) != '')
        {
            $header = '<div class="gkblock-4">' . $head['0'] . '</div>';
        }
        if ($num = preg_match_all("|<h([1-9]{1})[^>]*>(.*)<\/h[1-9]{1}>|U", $body, $array))
        {
            for ($x = 0; $x < $num; $x++)
            {
                if ($x > 0 && ($array['1'][$x] > $array['1'][$x - 1] + 1))
                {
                    $array['1'][$x] = $array['1'][$x - 1] + 1;
                }
                $depth = $array['1'][$x] - 1;
                $end_header = '';
                if ($x > 0 && ($array['1'][$x] <= $array['1'][$x - 1]))
                {
                    $end_header = str_repeat('</div></div>', $array['1'][$x - 1] - $array['1'][$x] + 1);
                }
                if ($x > 0 && ($array['1'][$x] < $array['1'][$x - 1]))
                {
                    for ($z = $array['1'][$x - 1]; $z > $array['1'][$x]; $z--)
                    {
                        $h[$z] = 0;
                    }
                }
                $h[$array['1'][$x]] = (isset($h[$array['1'][$x]])) ? $h[$array['1'][$x]] + 1 : 1;
                $numeral1 = '';
                $numeral2 = '';
                $numeral3 = array();
                $id = '';
                $parent = '';
                for ($n = 1; $n <= $array['1'][$x]; $n++)
                {
                    $numeral3[$n] = $h[$n];
                    $id .= $h[$n] * 10;
                    if ($n != $array['1'][$x])
                    {
                        $parent .= $h[$n] * 10;
                    }
                }
                $numeral3 = array_reverse($numeral3, true);
                $numeral1 = implode('-', $numeral3) . $nums . '-';

                $title = strip_tags($array['2'][$x]);
                $sub_cache[$x]['id'] = $id;
                $sub_cache[$x]['x'] = $ids . ($x + 1);
                $sub_cache[$x]['parent_id'] = $parent;
                $sub_cache[$x]['title'] = $title;
                $tit = $sub_cache[$x]['title'];
                $sub_cache[$x]['url'] = '<a rel="nofollow" href="#t' . $ids . ($x + 1) . '">' . $numeral1 . ' ' . $tit . '</a>';

                $body = $this->str_replace_first($array['0'][$x], $end_header . '<div class="total"><h' . $array['1'][$x] . ' id="t' . $ids . ($x + 1) . '" class="heading">
				<span class="icon icon-open"></span>' . $numeral1 . ' ' . $title . '</h' . $array['1'][$x] . '><div class="inner">', $body);
            }
            $end_header = str_repeat("</div></div>", $array['1'][$x - 1]);
            $body = $body . $end_header;
        }
        if (isset($sub_cache) && is_array($sub_cache))
        {
            $page['list'] = $sub_cache;
        }
        return $page['list'];
    }

    function array2json($arr)
    {
        if (function_exists('json_encode'))
        {
            return json_encode($arr);
        } //Lastest versions of PHP already has this functionality.
        $parts = array();
        $is_list = false;
        //Find out if the given array is a numerical array
        $keys = array_keys($arr);
        $max_length = count($arr) - 1;
        if (($keys[0] == 0) and ($keys[$max_length] == $max_length))
        {//See if the first key is 0 and last key is length - 1
            $is_list = true;
            for ($i = 0; $i < count($keys); $i++)
            { //See if each key correspondes to its position
                if ($i != $keys[$i])
                { //A key fails at position check.
                    $is_list = false; //It is an associative array.
                    break;
                }
            }
        }

        foreach ($arr as $key => $value)
        {
            if (is_array($value))
            { //Custom handling for arrays
                if ($is_list)
                {
                    $parts[] = array2json($value);
                } /* :RECURSION: */
                else
                {
                    $parts[] = '"' . $key . '":' . array2json($value);
                } /* :RECURSION: */
            }
            else
            {
                $str = '';
                if (!$is_list)
                {
                    $str = '"' . $key . '":';
                }
                //Custom handling for multiple data types
                if (is_numeric($value))
                {
                    $str .= $value;
                } //Numbers
                elseif ($value === false)
                {
                    $str .= 'false';
                } //The booleans
                elseif ($value === true)
                {
                    $str .= 'true';
                }
                else
                {
                    $str .= '"' . addslashes($value) . '"';
                }
                $parts[] = $str;
            }
        }
        $json = implode(',', $parts);
        if ($is_list)
        {
            return '[' . $json . ']';
        }
        return '{' . $json . '}';
    }

    public function modifyText($body, $uid = 0, $pid = 0, $sid = 0, $tabtype = false)
    {
        $body = PageClass::helper_viewer($body);
        $body = $this->Help_Replace($body);
        $list = $this->RefList($body);
        $body = ($list != '') ? $this->RefList_Replace($body, $list) : $body;
        $body = $this->Ref_Replace($body);
        $body = $this->context($body);
        $body = $this->replace_number($body);
        $body = $this->number($body);
        $body = $this->resource($body);
        $body = $this->replace_subtitle($body);
        $body = $this->subtitle($body);
        if ($tabtype)
        {
            $body = $this->thesaurusinPage($body, $sid);
        }
        if (config('constants.ChangeTable') == '1')
        {
            $body = $this->table($body);
        }
        $body = $this->Forms($body, $pid, $sid);
        $body = $this->Dashboard_Replace($body);
        if (config('constants.styleDel') == '1')
        {
            $body = $this->styleDel($body);
        }
        $body = $this->Person_Replace($body);
        //$body = $this->Group_Replace($body);
        //$body = $this->Chanel_Replace($body);
        $body = $this->quran_replace($body);
        $body = $this->Portal_replace($body);
        $body = $this->quran_Translate($body);
        //$body = $this->TaginPage($body);
        $body = $this->AsubjectinPage($body);
        $body = $this->KeywordinPage($body);
        $body = $this->Tag_replace($body);
        $body = $this->paragraph($body);

        $body = $this->insert_mohtava($body);
        $body = $this->tinymce_url($body);
        //$body = $this->FaqList_Replace($body);
        //$body = $this->table_replace($body);
        //$body = $this->ReplaceImages($body);
        $body = $this->pages_list($body);
        $body = $this->highlight($body, $uid, $pid);
        return $body;
    }

    public function AsubjectinPage($body) {
        $S = '';
        $pattern = "/<span class=\"ShowAsubInPage.*/";
        $S = '';
        $html = new HtmlDomSTR('str',$body);
        $i = 1;
        if ($body != '' && $html->find('.ShowAsubInPage')) {
            foreach ($html->find('span[class=ShowAsubInPage]') as $element) {
                $elements = $element->innertext;
                $rep = $elements;
                $elements = str_replace('نوع موضوع {', '', $elements);
                $elements = str_replace('}', '', $elements);
                $myArray = explode('_', $elements);
                $Tags = $myArray[0];
                $Tedad = $myArray[1];
                $Stype = $myArray[2];
                //$selpage = PageClass::Sel_Page();
                $row = DB::table('pages as p')
                    ->leftJoin('subjects as s', 'p.sid', '=', 's.id')
                    ->select('p.view', 's.manager', 's.supporter', 's.supervisor', 's.ispublic')
                    ->where('s.kind', $Tags)
                    ->select('p.id as pid', 's.id', 's.title')
                    //->whereRaw($selpage)
                    ->get();
                $count = 1;
                $S = '';
                $Sep = ' <span data-icon="I" class="FontIconsPack3Bullet UnSelectBut"></span>  ';
                if ($Stype == 2) {
                    $S = '<ol>';
                    $Sep = '<br>';
                }
                foreach ($row as $value) {
                    if ($count <= $Tedad) {
                        if ($Stype == 2) {
                            $S.='<li> <a href="' . $value->pid . '">' . $value->title . '</a></li> ';
                        } else {
                            $S.='<span> <a href="' . $value->pid . '">' . $value->title . '</a>' . $Sep . '</span> ';
                        }
                    }
                    $count++;
                }

                if ($Stype == 2) {
                    $S.='</ol>';
                }

                $body = str_replace($rep, $S, $body);
            }
        }

        return $body;
    }

    public function insert_mohtava($body)
    {
        $bodysss = '';
        if (trim($body) != '')
        {
            $html = new HtmlDomSTR('str', $body);
            foreach ($html->find('p[class=insert_mohtava]') as $element)
            {
                $Con = '';
                $innertext = $element->innertext;
                $pos = stripos($innertext, "(");
                $str = substr($innertext, $pos);
                $str_two = substr($str, strlen("("));
                $second_pos = stripos($str_two, ")");
                $str_three = substr($str_two, 0, $second_pos);
                $pid = trim($str_three); // remove whitespaces
                $Page = DB::table('pages')->where('id', '=', $pid)->select('body')->first();
                if ($Page)
                {
                    $PageClass = new PageClass();
                    $Con = ($Page) ? $PageClass->modifyText($Page->body) : "";
                }
                $body = str_replace($innertext, $Con, $body);
            }
            //$body = $html;
        }
        return $body;
    }

    public function thesaurusinPage($body, $sid)
    {
        return '';
        $S = '';
        $thespage = $this->thesaurus($sid);
        $count = DB::table('subject_keys as sk')
            ->join('keywords as k', 'k.id', '=', 'sk.kid')
            ->join('thesaurus_keywords as kt', 'k.id', '=', 'kt.keyword_id')
            ->select('k.id')
            ->where('kt.subject_id', $sid)
            ->groupBy('k.id')
            ->count();
        $kol = DB::table('keywords as k')
            ->select('id')
            ->join('thesaurus_keywords as kt', 'k.id', '=', 'kt.keyword_id')
            ->where('kt.subject_id', $sid)
            ->whereRaw("morajah='0'")
            ->count();
        $morajah = DB::table('keyword_relations as r')
            ->join('keywords as k', 'k.id', '=', 'r.keyword_1_id')
            ->join('thesaurus_keywords as kt', 'k.id', '=', 'kt.keyword_id')
            ->select('r.id')
            ->where('kt.subject_id', $sid)
            ->groupBy('keyword_1_id')
            ->count();
        $vabast = DB::table('keyword_relations as r')
            ->join('keywords as k', 'k.id', '=', 'r.keyword_1_id')
            ->join('thesaurus_keywords as kt', 'k.id', '=', 'kt.keyword_id')
            ->select('keyword_2_id')
            ->where('rel', '9')
            ->where('kt.subject_id', $sid)
            ->count();
        $movaghat = DB::table('keywords as k')
            ->join('thesaurus_keywords as kt', 'k.id', '=', 'kt.keyword_id')
            ->select('id')
            ->where('workflow', '1')
            ->where('kt.subject_id', $sid)
            ->count();
        $countMovaghat = $movaghat;
        $kol = '<td style="float:left;font-size:14pt;">' . $kol . '</td>';
        $morajah = '<td style="float:left;font-size:14pt;">' . $morajah . '</td>';
        $vabast = '<td style="float:left;font-size:14pt;">' . $vabast . '</td>';
        $countMovaghat = '<td style="float:left;font-size:14pt;">' . $countMovaghat . '</td>';
        $count = '<td style="float:left;font-size:14pt;">' . $count . '</td>';
        $estelahlist = '<table style="direction: rtl;width: 100%;">
   <tr> <td> اصطلاح‌ها  ' . $kol . ' </td></tr>
       <tr> <td>اصطلاح‌های مرجح' . $morajah . ' </td></tr>
            <tr> <td><span>اصطلاح‌های وابسته' . '</span>' . $vabast . ' </td></tr>
                
<tr> <td> اصطلاح‌های بکاررفته' . $count . ' </td></tr>
  <tr> <td> اصطلاح‌های موقت' . $countMovaghat . ' </td></tr>  

</table>';
        $_SESSION['estelahlist'] = $estelahlist;
        $pagess = '<div style="width:100%;margin:0 20px 20px 0">
        <a href="newTag.php"  class="fancybox fancybox.ajax Butt">کلیدواژه جدید</a> 
        <a class="fancybox fancybox.ajax Butt"  href="pages/tagmerger.php"  class="Butt">ادغام کلیدواژه ها</a> 
        <br>
    </div><table class="tblBorderLessFree"><tr><td style="width:60%;vertical-align:top;"><input type="hidden" id="TreeChart2" value="0">';
        $pagess = '<div id="Thes' . $sid . '" class="demo" style="min-height:400px;"></div></td><td style="vertical-align: top;text-align: right"><div id="KeyDetails" style="border-right: #838A8A;border-right-style: solid;border-right-width: 1px;   padding-right: 10px;"></div></td><tr></table>';
        //$page.=$thespage;
        $body = $pagess . $thespage;
        return $body;
    }

    public function thesaurus($keyids)
    {

        $keys = DB::table('keyword_relations as kr')
            ->join('keywords as k', 'k.id', '=', 'kr.keyword_2_id')
            ->select('k.title as text', 'keyword_1_id as parent', 'keyword_2_id as id')
            ->whereRAW('rel in(1,3,5) and keyword_2_id in (select k.id from keywords as k INNER JOIN `thesaurus_keywords` AS `kt` ON `k`.`id` = `kt`.`keyid` where kt.subject_id=' . $keyids . ')')
            ->groupBy('keyword_2_id')
            ->orderBy('keyword_1_id')
            ->get();
        $i = 1;
        $parent = array();
        $ids = array();
        $allRels = array();
        foreach ($keys as $value)
        {
            $parent[$i] = $value->parent;
            $ids[$i] = $value->id;
            array_push($parent, $value->parent);
            array_push($ids, $value->id);
            if ($i == '1')
            {
                $root = $value->parent;
            }
            array_push($allRels, $value);

            //   $allRels[] = $row;
            $i++;
        }
        $i = 1;
        foreach ($parent as $value)
        {
            if (!in_array($value, $ids))
            {
                $key = DB::table('keywords')
                    ->select('keyword', 'id')
                    ->where('id', $value)
                    ->first();
                $i++;
                if ($key)
                {
                    $ar['id'] = $key->id;
                    $ar['parent'] = '#';
                    $ar['text'] = $key->keyword;
                    array_push($allRels, $ar);
                }
                array_push($ids, $value);
            }
        }

        $json = json_encode($allRels);
        $res = "<script>
	$('#Thes" . $keyids . "').jstree({
		'core' : {
			'data' : " . $json . ",
                            'rtl': true,
                'themes': {
                 'icons': false
                }
		}
	}).bind('select_node.jstree', 
function (e, data) 
{ 
$(this).jstree('open_all');
var id = data.node.id;
  loadKeyDet( id);
}).bind('loaded.jstree', function (event, data) {
    $(this).jstree('open_all');
});
        

</script>";
        return $res;
    }

    public function Tag_replace($body)
    {
        return $body;
        $S = '';
        $pattern = "/STagT_.*/";
        if ($num1 = preg_match_all($pattern, $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $keys = $array['0'][$x];
                $key = str_replace('STagT_', '', $keys);
                $myArray = explode('_', $key);
                //dd($myArray);
                $Tags = $myArray[0];
                $Tedad = $myArray[1];
                $Stype = isset($myArray[2])?$myArray[2]:'';
                $myArray = explode(',', $Tags);
                $i = 1;
                $sql = '';
                $script = "";
                $n = 1;
                foreach ($myArray as &$value)
                {
                    $KEyVals = DB::table('keywords')->where('id', $value)->get();
                    $nums = DB::table('keywords')->where('id', $value)->count();
                    Schema::dropIfExists("t{$i}");
                    $productList = DB::insert(DB::raw("CREATE TEMPORARY TABLE t{$i} select * from subject_key where kid={$value};"));
                    $i++;
                    foreach ($KEyVals as $KEyVal)
                    {

                        if ($n == 1)
                        {
                            $script .= "AddTags('" . $KEyVal->id . "','" . $KEyVal->title . "',1);";
                        }
                        else
                        {
                            $script .= "AddTags('" . $KEyVal->id . "','" . $KEyVal->title . "',2);";;
                        }
                    }
                    $n++;
                }
                --$i;
                if ($i >= 1)
                {
                    $subsql = '';
                    switch ($i)
                    {
                        case 1:
                            $subsql = "select t1.sid from t1  group by t1.sid ";
                            break;
                        case 2:
                            $subsql = "select t1.sid from t1 inner join t2  ON t1.sid=t2.sid  group by t1.sid ";
                            break;
                        case 3:
                            $subsql = "select t1.sid from t1 inner join t2  ON t1.sid=t2.sid inner join t3  ON t1.sid=t3.sid group by t1.sid ";
                            break;
                    }

                    $SQL = DB::table('pages as p')->join('subjects as s ', 'p.sid', '=', 's.id')
                        ->where('s.archive', '0')
                        ->whereRaw("s.id in ({$subsql})")
                        ->where('s.list', '=', '1')
                        ->where('s.ispublic', '=', '1')
                        ->whereRaw($this->Sel_Page())
                        ->orderBy('p.id')
                        ->select('p.id as pid', 'p.sid', 's.title as title', 's.kind', 'p.type')
                        ->get();
                    $num_rows = DB::table('pages as p')->join('subjects as s ', 'p.sid', '=', 's.id')
                        ->where('s.archive', '0')
                        ->whereRaw("s.id in ({$subsql})")
                        ->where('s.list', '=', '1')
                        ->where('s.ispublic', '=', '1')
                        ->whereRaw($this->Sel_Page())
                        ->orderBy('p.id')
                        ->select('p.id as pid', 'p.sid', 's.title as title', 's.kind', 'p.type')
                        ->count();
                }
                $count = 1;
                $S = '';
                $Sep = ' <span style="font-size:4pt;height:5px;" class="icon-2-2"></span>  ';
                if ($Stype == 2)
                {
                    $Sep = '<br>';
                }
                foreach ($SQL as $value)
                {
                    if ($count <= $Tedad)
                    {
                        $S .= '<span> <a href="' . $value->pid . '">' . $value->title . '</a>' . $Sep . '</span> ';
                    }
                    $count++;
                }

                if ($count >= $Tedad)
                {
                    $S .= '<a style="cursor:pointer;" class="KeywordClick" onclick="' . $script . 'ShowTagPanel();"> <span style="font-weight:bold;">سایر موارد...</span></a>';
                }

                $body = str_replace($keys, $S, $body);;
            }
        }
        return $body;
    }

    public function keyword($body)
    {
        if ($num = preg_match_all("/\*\*(.*?)\*\*/", $body, $array))
        {
            for ($y = 0; $y < count($array['0']); $y++)
            {
                $vals = '';
                $subjects = '';
                $keywords = array();
                $c_catch = array();
                $s_catch = array();
                $sub_cache = array();
                $star = $array['0'][$y];
                $keyword = $array['1'][$y];
                $keyword = $this->keywords($keyword);
                if ($keyword == $this->lang['import'] || $keyword == $this->lang['export'])
                {
                    $cats = '';
                    if ($keyword == $this->lang['import'])
                    {
                        $sql = "SELECT DISTINCT 
										r.sid1 , r.sid2
									FROM 
										subjects_rel as r
									WHERE
										(r.sid2 = '{$this->sid}') AND r.rel = '13'";
                    }
                    if ($keyword == $this->lang['export'])
                    {
                        $sql = "SELECT DISTINCT 
										r.sid1 , r.sid2
									FROM 
										subjects_rel as r
									WHERE
										(r.sid1 = '{$this->sid}') AND r.rel = '13'";
                    }
                    $query = mysql_query($sql);
                    $nums = mysql_num_rows($query);
                    if ($nums != 0)
                    {
                        while ($row = mysql_fetch_assoc($query))
                        {
                            if ($row->sid2 == $this->sid)
                            {
                                $export1 = array();
                                $sub_cache[] = $row->sid1;
                                $sql1 = "SELECT DISTINCT 
												p.id , p.sid , s.title , s.kind , p.type , r.sid1 , r.sid2
											FROM 
												subjects_rel as r
											LEFT JOIN
												subjects as s
											ON
												r.sid1 = s.id
											LEFT JOIN
												pages as p
											ON
												p.sid = s.id AND s.archive = 0 
											WHERE 
												(r.sid2 = '{$row['sid1']}') AND r.rel = '13' AND ($this->sel_page)";
                                $query1 = mysql_query($sql1);
                                $nums1 = mysql_num_rows($query1);
                                if ($nums1 != 0)
                                {
                                    while ($row1 = mysql_fetch_assoc($query1))
                                    {
                                        $title = $this->url_text($row1['title']);
                                        if ($row1['kind'] != 3 && $row1['kind'] != 4)
                                        {
                                            $title .= '-' . $this->url_text($this->lang['page_types'][$row1['kind']][$row1['type']]);
                                        }
                                        $export1[] = '<a rel="canonical" href="' . HAMAFZA . '/' . $row1['id'] . '/' . $title . '/" target="_blank">' . $row1['title'] . '</a>';
                                    }
                                    mysql_free_result($query1);
                                    $export_to[$row['sid1']] = implode(' , ', $export1);
                                }
                            }
                            if ($row['sid1'] == $this->sid)
                            {
                                $export1 = array();
                                $sub_cache[] = $row->sid2;
                                $sql1 = "SELECT DISTINCT 
												p.id , p.sid , s.title , s.kind , p.type , r.sid1 , r.sid2
											FROM 
												subjects_rel as r
											LEFT JOIN
												subjects as s
											ON
												r.sid2 = s.id
											LEFT JOIN
												pages as p
											ON
												p.sid = s.id AND s.archive = 0 
											WHERE 
												(r.sid1 = '{$row->sid2}') AND r.rel = '13' AND ($this->sel_page)";
                                $query1 = mysql_query($sql1);
                                $nums1 = mysql_num_rows($query1);
                                if ($nums1 != 0)
                                {
                                    while ($row1 = mysql_fetch_assoc($query1))
                                    {
                                        $title = $this->url_text($row1['title']);
                                        if ($row1['kind'] != 3 && $row1['kind'] != 4)
                                        {
                                            $title .= '-' . $this->url_text($this->lang['page_types'][$row1['kind']][$row1['type']]);
                                        }
                                        $export1[] = '<a rel="canonical" href="' . HAMAFZA . '/' . $row1['id'] . '/' . $title . '/" target="_blank">' . $row1['title'] . '</a>';
                                    }
                                    mysql_free_result($query1);
                                    $export_to[$row->sid2] = implode(' , ', $export1);
                                }
                            }
                        }
                        mysql_free_result($query);
                        $cats = implode(',', $sub_cache);
                    }
                    if ($cats != '')
                    {
                        $subjects = '<div style="display: block; padding:0px 10px;" class="subjects">';
                        $sql = "SELECT
										p.id , p.sid , s.title , s.kind , p.type
									FROM 
										pages as p 
									RIGHT JOIN 
										subjects as s 
									ON 
										p.sid = s.id AND s.archive = 0 
									WHERE 
										(s.id IN ({$cats})) AND ($this->sel_page)";

                        $result = mysql_query($sql);
                        while ($row = mysql_fetch_assoc($result))
                        {
                            $title = $this->url_text($row['title']);
                            if ($row['kind'] != 3 && $row['kind'] != 4)
                            {
                                $title .= '-' . $this->url_text($this->lang['page_types'][$row['kind']][$row['type']]);
                            }
                            if ($row['sid'] != $this->sid)
                            {
                                $subjects .= '<span  style="font-size:12px;"><a rel="canonical" href="' . HAMAFZA . '/' . $row['id'] . '/' . $title . '/" target="_blank"><img src="theme/images/arrow.png">&nbsp;' . $row['title'] . '</a> ( ' . $export_to[$row['sid']] . ' ) </span><br/>';
                            }
                        }
                        $subjects .= '</div>';
                    }
                }
                else
                {
                    $keywords = explode(',', $keyword);
                    if (is_array($keywords))
                    {
                        $n = 0;
                        foreach ($keywords as $key => $val)
                        {
                            ++$n;
                            if (trim($val) != '')
                            {
                                $val = $this->Filter($val);
                                $val = $this->stem($val);

                                $skeys = mysql_query("SELECT id FROM keywords WHERE title = '" . $val . "'");
                                $nkeys = mysql_num_rows($skeys);
                                if ($nkeys != "0")
                                {
                                    $row = mysql_fetch_assoc($skeys);
                                    $keyid = $row['id'];

                                    $sql = "SELECT
													sid
												FROM
													subject_key
												WHERE
													kid = {$keyid}";
                                    $query = mysql_query($sql);
                                    $ncat = mysql_num_rows($query);

                                    if ($ncat != 0)
                                    {
                                        while ($row = mysql_fetch_assoc($query))
                                        {
                                            if ($n == 1)
                                            {
                                                $c_catch[$row['sid']] = $row['sid'];
                                            }
                                            else
                                            {
                                                if (in_array($row['sid'], $c_catch))
                                                {
                                                    $s_catch[$row['sid']] = $row['sid'];
                                                }
                                            }
                                        }
                                        if ($n != 1)
                                        {
                                            $c_catch = $s_catch;
                                        }
                                    }
                                    else
                                    {
                                        $c_catch = array();
                                    }
                                }
                                else
                                {
                                    $c_catch = array();
                                }
                            }
                        }
                        if (is_array($c_catch))
                        {
                            $cats = implode(',', $c_catch);
                            $c_catch = array();
                            $subjects = '';
                            if ($cats != '')
                            {
                                $subjects = '<div style="display: block; padding:0px 10px;" class="subjects">';
                                $sql = "SELECT
												p.id , p.sid , s.title , s.kind , p.type
											FROM 
												pages as p 
											RIGHT JOIN 
												subjects as s 
											ON 
												p.sid = s.id AND s.archive = 0 
											WHERE 
												(s.id IN ({$cats})) AND ($this->sel_page)";
                                $result = mysql_query($sql);
                                while ($row = mysql_fetch_assoc($result))
                                {
                                    $title = $this->url_text($row['title']);
                                    if ($row['kind'] != 3 && $row['kind'] != 4)
                                    {
                                        $title .= '-' . $this->url_text($this->lang['page_types'][$row['kind']][$row['type']]);
                                    }
                                    $subjects .= '<a class="ksubject1" rel="canonical" href="' . HAMAFZA . '/' . $row['id'] . '/' . $title . '/" target="_blank">&nbsp;' . $row['title'] . '</a>';
                                }
                                $subjects .= '</div>';
                            }
                        }
                    }
                }
                $body = str_replace($star, $subjects, $body);
            }
        }
        return $body;
    }

    public function KeywordinPage($body)
    {
        $S = '';
        $pattern = "/{{{.*}}}/";
        if ($num1 = preg_match_all($pattern, $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $keys = $array['0'][$x];
                $keys2 = $array['0'][$x];
            }
            if (intval(strpos($keys2, '-')) > 0)
            {
                $keys = str_replace("{{{", "", $keys);
                $keys = str_replace("}}}", "", $keys);
                $keys = str_replace("-", "", $keys);

                $Keywords = DB::table('keywords')
                    ->where('title', '=', $keys)
                    ->select('id', 'title')
                    ->first();
                $category = '';
                if ($Keywords)
                {
                    $id = $Keywords->id;
                    $name = $Keywords->title;
                    $strings = '<span style="cursor: pointer;color:#428bca;" class="KeywordClick" onclick="AddTags(\'' . $id . '\',\'' . $name . '\',1);">' . $name . '</span>';
                }
                else
                {
                    $strings = $keys;
                }

                $body = str_replace($keys2, $strings, $body);
            }
            else
            {
                $keys = str_replace("{{{", "", $keys);
                $keys = str_replace("}}}", "", $keys);
                $Keywords = DB::table('keywords')
                    ->where('title', '=', $keys)
                    ->select('id', 'title')
                    ->first();
                $category = '';
                if ($Keywords)
                {
                    $id = $Keywords->id;
                    $name = $Keywords->title;
                    $category = $this->thesaurus_tree($id);
                }
                else
                {
                    $category = $keys;
                }

                $body = str_replace("}}}", '', $body);
                $body = str_replace("{{{", '', $body);

                $body = str_replace($keys, $category, $body);
            }
        }
        return $body;
    }

    public function ReplaceImages($body)
    {
//        if ($num1 = preg_match_all("/<img src=\"/", $body, $array)) {
//            for ($x = 0; $x < $num1; $x++) {
//                $body = $array['0'][$x];
//                $body = str_replace('<img src="' , '<img src="'.$this->quranTranslate_create($array['0'][$x]), $body);
//            }
//        }
        $body = str_replace('<img src="', '<img src="' . config('constants.SiteAddress'), $body);

        return $body;
    }

    public function paragraph($body)
    {
        $n = 1;
        $t = 1;
        if ($num = preg_match_all("/<(p|table|ul|ol|h[1-9])([^>]*)>(.*?)<\/\\1>/is", $body, $array))
        {
            for ($y = 0; $y < count($array['0']); $y++)
            {
                $array['1'][$y] = strtolower($array['1'][$y]);
                if ($array['1'][$y] == 'h1' || $array['1'][$y] == 'h2' || $array['1'][$y] == 'h3' || $array['1'][$y] == 'h4' || $array['1'][$y] == 'h5' || $array['1'][$y] == 'h6' || $array['1'][$y] == 'h7' || $array['1'][$y] == 'h8' || $array['1'][$y] == 'h9')
                {
                    $id = 't' . $t;
                    ++$t;
                }
                else
                {
                    $id = $n;
                    ++$n;
                }

                $body = $this->str_replace_first($array['0'][$y], '<' . $array['1'][$y] . ' id="' . $id . '"' . $array['2'][$y] . '>' . $array['3'][$y] . '</' . $array['1'][$y] . '>', $body);
            }
        }
        return $body;
    }

    public function Ref_Replace($body)
    {
        $pattern = "/{{.{1,22}}}/";
        if ($num1 = preg_match_all($pattern, $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $Con = $array['0'][$x];
                $Con = str_replace("{{", "", $Con);
                $Con = str_replace("}}", "", $Con);
                $gid = trim($Con);
                $myArray = explode('|', $Con);
                if (is_array($myArray) && count($myArray) > 2)
                {
                    $sid = $myArray[0];
                    $type = $myArray[1];
                    $numb = $myArray[2];
                    $numb = ": " . $numb;
                    if (trim($type) == 'اس')
                    {
                        $reps = DB::table('subject_fields_report as r')
                            ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                            ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                            ->leftJoin('subject_type_fields as st', function ($join)
                            {
                                $join->on('st.stid', '=', 's.kind');
                                $join->on('st.id', '=', 'r.field_id');
                            })
                            ->where('st.field_id', '19')->where('p.id', $sid)
                            ->select('r.field_value as field_val', 'r.field_id')->first();
                        $year = ($reps && trim($reps->field_val) != '') ? trim($reps->field_val) : '';
                        if ($year == '')
                        {
                            $reps = DB::table('subject_fields_report as r')
                                ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                                ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                                ->leftJoin('subject_type_fields as st', function ($join)
                                {
                                    $join->on('st.stid', '=', 's.kind');
                                    $join->on('st.id', '=', 'r.field_id');
                                })
                                ->where('st.field_id', '14')->where('p.id', $sid)
                                ->select('r.field_value as field_val', 'r.field_id')->first();
                            $year = ($reps && trim($reps->field_val) != '') ? trim($reps->field_val) : '';
                        }
                        $nev = "<a target='_blank'  href='" . url('/') . "/$sid'>($year  $numb)</a>";
                    }
                    else
                    {
                        $repcount = DB::table('subject_fields_report as r')
                            ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                            ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                            ->leftJoin('subject_type_fields as st', function ($join)
                            {
                                $join->on('st.stid', '=', 's.kind');
                                $join->on('st.id', '=', 'r.field_id');
                            })
                            ->where('st.field_id', '7')->where('p.id', $sid)
                            ->select('r.field_value as field_val', 'r.field_id')->count();
                        $hamkar = ($repcount > 1) ? "و همکاران " : "";
                        $reps = DB::table('subject_fields_report as r')
                            ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                            ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                            ->leftJoin('subject_type_fields as st', function ($join)
                            {
                                $join->on('st.stid', '=', 's.kind');
                                $join->on('st.id', '=', 'r.field_id');
                            })
                            ->where('st.field_id', '7')->where('p.id', $sid)
                            ->select('r.field_value as field_val', 'r.field_id')->first();
                        $name = ($reps && trim($reps->field_val) != '') ? "$reps->field_val" . $hamkar : '';
                        $reps = DB::table('subject_fields_report as r')
                            ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                            ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                            ->leftJoin('subject_type_fields as st', function ($join)
                            {
                                $join->on('st.stid', '=', 's.kind');
                                $join->on('st.id', '=', 'r.field_id');
                            })
                            ->where('st.field_id', '19')->where('p.id', $Con)
                            ->select('r.field_value as field_val', 'r.field_id')->first();
                        $year = ($reps && trim($reps->field_val) != '') ? "، " . trim($reps->field_val) : '';
                        $myArrays = explode('؛', $name);
                        if (is_array($myArrays) && count($myArrays) > 0)
                        {
                            $hamkar = (count($myArrays) > 1) ? "و همکاران " : "";

                            $nev = $myArrays[0];
                            $my = explode('،', $nev);
                            $nev = (is_array($my) && count($my) > 0 && array_key_exists(1, $my)) ? $my[1] : '';
                            $nev = ($nev != '') ? "<a target='_blank'  href='" . url('/') . "/$sid'>($nev $year $numb)</a>" : '';
                        }
                        else
                        {
                            $nev = "<a target='_blank'  href='" . url('/') . "/$sid'>($name $year $numb)</a>";
                        }
                    }

                    $body = str_replace($array['0'][$x], $nev, $body);
                }
                else
                {
                    if (is_array($myArray) && count($myArray) > 1)
                    {
                        $nev = "";
                        $sid = $myArray[0];
                        $type = $myArray[1];
                        $nev = '';
                        if (trim($type) == 'اس')
                        {
                            $reps = DB::table('subject_fields_report as r')
                                ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                                ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                                ->leftJoin('subject_type_fields as st', function ($join)
                                {
                                    $join->on('st.stid', '=', 's.kind');
                                    $join->on('st.id', '=', 'r.field_id');
                                })
                                ->where('st.field_id', '19')->where('p.id', $sid)
                                ->select('r.field_value as field_val', 'r.field_id')->first();
                            $year = ($reps && trim($reps->field_val) != '') ? trim($reps->field_val) : '';
                            if ($year == '')
                            {
                                $reps = DB::table('subject_fields_report as r')
                                    ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                                    ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                                    ->leftJoin('subject_type_fields as st', function ($join)
                                    {
                                        $join->on('st.stid', '=', 's.kind');
                                        $join->on('st.id', '=', 'r.field_id');
                                    })
                                    ->where('st.field_id', '14')->where('p.id', $sid)
                                    ->select('r.field_value as field_val', 'r.field_id')->first();
                                $year = ($reps && trim($reps->field_val) != '') ? trim($reps->field_val) : '';
                            }
                            $nev = "<a target='_blank'  href='" . url('/') . "/$sid'>($year)</a>";
                        }
                        else
                        {
                            $repcount = DB::table('subject_fields_report as r')
                                ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                                ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                                ->leftJoin('subject_type_fields as st', function ($join)
                                {
                                    $join->on('st.stid', '=', 's.kind');
                                    $join->on('st.id', '=', 'r.field_id');
                                })
                                ->where('st.field_id', '7')->where('p.id', $sid)
                                ->select('r.field_value as field_val', 'r.field_id')->count();
                            $hamkar = ($repcount > 1) ? " و همکاران " : "";
                            $reps = DB::table('subject_fields_report as r')
                                ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                                ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                                ->leftJoin('subject_type_fields as st', function ($join)
                                {
                                    $join->on('st.stid', '=', 's.kind');
                                    $join->on('st.id', '=', 'r.field_id');
                                })
                                ->where('st.field_id', '7')->where('p.id', $sid)
                                ->select('r.field_value as field_val', 'r.field_id')->first();
                            $name = ($reps && trim($reps->field_val) != '') ? "$reps->field_val" . $hamkar : '';
                            $reps = DB::table('subject_fields_report as r')
                                ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                                ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                                ->leftJoin('subject_type_fields as st', function ($join)
                                {
                                    $join->on('st.stid', '=', 's.kind');
                                    $join->on('st.id', '=', 'r.field_id');
                                })
                                ->where('st.field_id', '19')->where('p.id', $Con)
                                ->select('r.field_value as field_val', 'r.field_id')->first();
                            $year = ($reps && trim($reps->field_val) != '') ? "، " . trim($reps->field_val) : '';
                            $myArrays = explode('؛', $name);
                            if (is_array($myArrays) && count($myArrays) > 0)
                            {
                                $nev = $myArrays[0];
                                $my = explode('،', $nev);
                                $nev = (is_array($my) && count($my) > 0 && array_key_exists(1, $my)) ? $my[1] : '';
                                $nev = ($nev != '') ? "<a target='_blank'  href='" . url('/') . "/$sid'>($nev $year)</a>" : '';
                            }
                            else
                            {
                                $nev = "<a target='_blank'  href='" . url('/') . "/$sid'>($name $year)</a>";
                            }
                        }
                        $body = str_replace($array['0'][$x], $nev, $body);
                    }
                    else
                    {
                        $nev = "<a target='_blank'  href='" . url('/') . "/$Con'>()</a>";
                        $reps = DB::table('subject_fields_report as r')
                            ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                            ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                            ->leftJoin('subject_type_fields as st', function ($join)
                            {
                                $join->on('st.stid', '=', 's.kind');
                                $join->on('st.id', '=', 'r.field_id');
                            })
                            ->where('st.field_id', '7')->where('p.id', $gid)
                            ->select('r.field_value as field_val', 'r.field_id')->first();
                        $name = ($reps && trim($reps->field_val) != '') ? "$reps->field_val" : '';
                        $reps = DB::table('subject_fields_report as r')
                            ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                            ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                            ->leftJoin('subject_type_fields as st', function ($join)
                            {
                                $join->on('st.stid', '=', 's.kind');
                                $join->on('st.id', '=', 'r.field_id');
                            })
                            ->where('st.field_id', '19')->where('p.id', $gid)
                            ->select('r.field_value as field_val', 'r.field_id')->first();
                        $year = ($reps && trim($reps->field_val) != '') ? "، " . trim($reps->field_val) : '';
                        $nev = "<a target='_blank'  href='" . url('/') . "/$Con'>($name ،$year)</a>";
                        if ($name != '')
                        {
                            $myArray = explode('؛', $name);
                            if (is_array($myArray) && count($myArray) > 1)
                            {
                                $nev = $myArray[0];
                                $my = explode('،', $nev);
                                $nev = (is_array($my) && count($my) > 0 && array_key_exists(1, $my)) ? $my[1] : '';
                                $nev = ($nev != '') ? "<a target='_blank'  href='" . url('/') . "/$Con'>($nev  و همکاران$year)</a>" : '';
                            }
                            else
                            {
                                $nev = "<a target='_blank'  href='" . url('/') . "/$Con'>($name ،$year)</a>";
                            }
                        }
                        $body = str_replace($array['0'][$x], $nev, $body);
                    }
                }
            }
        }
        return $body;
    }

    public function quran_Translate($body)
    {
        if ($num1 = preg_match_all("|QuranTran_([0-9]{1,2}-[0-9]{1,3}-[0-9]{1,2})|U", $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $body = str_replace('<p class="translate">' . $array['0'][$x] . '</p>', $this->quranTranslate_create($array['1'][$x]), $body);
            }
        }
        return $body;
    }

    public function Help_Replace($body)
    {
        $pattern = "/{{Help\+.*=.*}}/";
        if ($num1 = preg_match_all($pattern, $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $body = str_replace($array['0'][$x], "", $body);
            }
        }
        $pattern = "/{{Help-.*}}/";
        if ($num1 = preg_match_all($pattern, $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $body = str_replace($array['0'][$x], "", $body);
            }
        }
        return $body;
    }

    public function quranTranslate_create($qurans)
    {
        $text = '<div class="gdk"><table class="table">';
        $trans = '';
        $filter = explode('-', $qurans);
        $quran = intval(trim($filter['0']));
        $sura = intval(trim($filter['1']));
        $aya = intval(trim($filter['2']));
        if ($quran != 0 && $sura != 0)
        {
            if ($aya == 0)
            {
                $Qurans = DB::table('quran_text as Q')
                    ->join('fa_ansarian as T', 'Q.index', '=', 'T.index')
                    ->where('Q.sura', '=', $sura)->select('Q.text as matn', 'T.text as Trans', 'Q.aya as aya')->get();
                $text .= '<tr> <td style="text-align: justify;vertical-align: top;direction: rtl;width: 50%;"><span  class="Amirqurans">بسم الله الرحمن الرحیم<span class="aya_number">  </span></span></td>' . '<td style="text-align: justify;vertical-align: top;direction: rtl;width: 50%;font-size: 10pt;">به نام خداوند بخشاینده مهربان<span class="aya_number">  </span></td></tr>';
                foreach ($Qurans as $Quran)
                {
                    $text .= '<tr> <td style="text-align: justify;vertical-align: top;direction: rtl;width: 50%;"><span  class="Amirqurans">' . $Quran->matn . '<span class="aya_number"> (' . $Quran->aya . ') </span></span></td>' . '<td style="text-align: justify;vertical-align: top;direction: rtl;width: 50%;font-size: 10pt;">' . $Quran->Trans . '<span class="aya_number"> (' . $Quran->aya . ') </span></td></tr>';
                    $text = str_replace('بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ', '', $text);
                }
            }
            else
            {

                $Qurans = DB::table('quran_text as Q')
                    ->join('fa_ansarian as T', 'Q.index', '=', 'T.index')
                    ->where('Q.sura', '=', $sura)->where('Q.aya', '=', $aya)->select('Q.text as matn', 'T.text as Trans', 'Q.aya as aya')->get();
                foreach ($Qurans as $Quran)
                {
                    $text .= '<tr> <td style="text-align: justify;vertical-align: top;direction: rtl;width: 50%;"><span  class="Amirqurans"> ' . $Quran->matn . '</span><span class="aya_number"> (' . $Quran->aya . ') </span></td>' . '<td style="text-align: justify;vertical-align: top;direction: rtl;width: 50%;font-size: 10pt;">' . $Quran->Trans . '<span class="aya_number"> (' . $Quran->aya . ') </span></td>';
                }
            }
        }


        $text .= '</table></div>';
        return $text;
    }

    public function page_tabs($SID, $kind, $pid = 0)
    {
        $id = $SID;
        $ar = array();
        $posts = DB::table('pages as p')
            ->leftJoin('subject_type_tab as stt', 'p.type', '=', 'stt.tid')
            ->join('tab_view as tv', 'tv.tabid', '=', 'stt.id')
            ->where('p.sid', '=', $id)
            ->where('stt.stid', '=', $kind)
            ->where('tv.sid', $id)
            ->where('stt.view', '1')
            ->select('p.id as link', 'p.id as href', 'stt.name as title')
            ->groupBy('p.id')
            ->orderBy('stt.orders')
            ->get();
        foreach ($posts as $value)
        {
            $value->selected = "false";
            if ($pid == $value->href)
            {
                $value->selected = "true";
            }
        }
        $posts = json_decode(json_encode($posts), true);
        //dd($posts);
        $ar['link'] = $SID . '/forum';
        $ar['href'] = $ar['link'];
        $ar['title'] = 'بحث';
        $ar['selected'] = "false";

        array_push($posts, $ar);
        $ar['link'] = $SID . '/desktop';
        $ar['href'] = $ar['link'];
        $ar['title'] = 'میزکار';
        $ar['selected'] = "false";

        array_push($posts, $ar);
        return $posts;
    }

    public function Group_Replace($body)
    {
        if ($num1 = preg_match_all("|NewGroups|U", $body, $array))
        {
            $body = str_replace('<p class="NewGroups">لیست دسته</p>', $this->NewGroups(), $body);
        }
        return $body;
    }

    function NewGroups()
    {
        $res = '';
        $type = 'group';
        $user_groups = DB::table('user_group')->select('id', 'name', 'link', 'summary', 'pic')->where('isorgan', 0)->orderBy('reg_date', 'desc')
            ->take(4)->get();
        $Uscount = DB::table('user_group')->select('id')->where('isorgan', 0)->count();
        $i = 1;
        $ress = ' <section class="container"><div class="wrapper wrapperx col-sm-11">
                <div class="col-xs-12 col-sm-2 box-inf">
                    <div class="member-count">
                        <span class="count">
                            <span>' . $Uscount . ' </span>
                        </span>
                        <span class="member"><a class="jsPanels" title="جستجو " href="modals/sociasearch?type=group">جستجو </a></span>
                    </div>
                </div><table class=" person-list GroupList row col-md-9">';
        foreach ($user_groups as $UserS)
        {
            $tid = $UserS->id;
            $link = $UserS->link;
            $title = $UserS->name;
            $summary = $UserS->summary;
            $pic = (trim($UserS->pic)) ? $UserS->pic : 'Groups.png';
            $link = config('constants.SiteAddress') . $link;

            if ($i == 1)
            {
                $res .= '<tr>';
            }
            if ($i > 0 && $i < 3)
            {
                $res .= '<td style="width:50%;"><li  style="list-style:none !important; width: 90% !important;" class="col-sm-2"><img  src="pics/group/' . $pic . '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
                $res .= '<div class="close"></div><div class="person-name"><a href="' . $link . '">' . $title . '</a></div><div class="person-moredetail"></div>';
                $res .= '<div class="person-relation"></div></div><br><div class="" style="padding-left:10px;"></div></li></td>';
            }
            if ($i == 3)
            {
                $res .= '</tr><tr>'; //<td style="border: hidden;"><div id="' . $title . '" class="holder float"><a href="' . $link . '" target="_blank"><img src="pics/user/' . $pic . '"style="margin:1px 5px;float:right;border-radius: 50%; height:50px;width:50px;"/><span>' . $title . '</span>';
            }
            if ($i >= 3)
            {
                $res .= '<td><li  style="list-style:none !important; width: 90% !important;" class="col-sm-2"><img  src="pics/group/' . $pic . '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
                $res .= '<div class="close"></div><div class="person-name"><a href="' . $link . '">' . $title . '</a></div><div class="person-moredetail">' . '</div>';
                $res .= '<div class="person-relation"></div></div><br><div class="" style="padding-left:10px;"></div></li></td>';
            }
            if ($i > 4)
            {
                $res .= '</tr>'; //<td style="border: hidden;"><div id="' . $title . '" class="holder float"><a href="' . $link . '" target="_blank"><img src="pics/user/' . $pic . '"style="margin:1px 5px;float:right;border-radius: 50%; height:50px;width:50px;"/><span>' . $title . '</span>';
            }

            $i++;
        }
        $f = $ress . $res . '</table></div></section>';
        return $f;
    }

    public function Chanel_Replace($body)
    {
        if ($num1 = preg_match_all("|NewChanels|U", $body, $array))
        {
            $body = str_replace('<p class="NewChanels">لیست کانال</p>', $this->NewChanels(), $body);
        }
        return $body;
    }

    function NewChanels()
    {
        $res = '';
        $type = 'group';
        $user_groups = DB::table('user_group')->select('id', 'name', 'link', 'summary', 'pic')->where('isorgan', 1)->orderBy('reg_date', 'desc')
            ->take(4)->get();
        $Uscount = DB::table('user_group')->select('id')->where('isorgan', 1)->count();
        $i = 1;
        $ress = ' <section class="container"><div class="wrapper wrapperx col-sm-11">
                <div class="col-xs-12 col-sm-2 box-inf">
                    <div class="member-count">
                        <span class="count">
                            <span>' . $Uscount . ' </span>
                        </span>
                        <span class="member"><a class="jsPanels" title="جستجو " href="modals/sociasearch?type=chanel">جستجو </a></span>
                    </div>
                </div><table class=" person-list GroupList row col-md-9">';
        foreach ($user_groups as $UserS)
        {
            $tid = $UserS->id;
            $link = $UserS->link;
            $title = $UserS->name;
            $summary = $UserS->summary;
            $link = config('constants.SiteAddress') . $link;
            $pic = (trim($UserS->pic)) ? $UserS->pic : 'Groups.png';

            if ($i == 1)
            {
                $res .= '<tr>';
            }
            if ($i > 0 && $i < 3)
            {
                $res .= '<td style="width:50%;"><li  style="list-style:none !important; width: 90% !important;" class="col-sm-2"><img  src="pics/group/' . $pic . '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
                $res .= '<div class="close"></div><div class="person-name"><a href="' . $link . '">' . $title . '</a></div><div class="person-moredetail"></div>';
                $res .= '<div class="person-relation"></div></div><br><div class="" style="padding-left:10px;"></div></li></td>';
            }
            if ($i == 3)
            {
                $res .= '</tr><tr>'; //<td style="border: hidden;"><div id="' . $title . '" class="holder float"><a href="' . $link . '" target="_blank"><img src="pics/user/' . $pic . '"style="margin:1px 5px;float:right;border-radius: 50%; height:50px;width:50px;"/><span>' . $title . '</span>';
            }
            if ($i >= 3)
            {
                $res .= '<td><li  style="list-style:none !important; width: 90% !important;" class="col-sm-2"><img  src="pics/group/' . $pic . '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
                $res .= '<div class="close"></div><div class="person-name"><a href="' . $link . '">' . $title . '</a></div><div class="person-moredetail">' . '</div>';
                $res .= '<div class="person-relation"></div></div><br><div class="" style="padding-left:10px;"></div></li></td>';
            }
            if ($i > 4)
            {
                $res .= '</tr>'; //<td style="border: hidden;"><div id="' . $title . '" class="holder float"><a href="' . $link . '" target="_blank"><img src="pics/user/' . $pic . '"style="margin:1px 5px;float:right;border-radius: 50%; height:50px;width:50px;"/><span>' . $title . '</span>';
            }

            $i++;
        }
        $f = $ress . $res . '</table></div></section>';
        return $f;
    }

    public function Person_Replace($body)
    {
        if ($num1 = preg_match_all("|NewPersons|U", $body, $array))
        {
            $body = str_replace('<p class="NewPersons">لیست افراد</p>', $this->Newusers(), $body);
            // $body .= str_replace('<p class="NewPersons">لیست گروه‌ها</p>', $this->NewGroups(), $body);
        }
        return $body;
    }

    public function Dashboard_Replace($body)
    {
        $html = '';
        $res = '';
        if (trim($body) != '')
        {
            $html = new HtmlDomSTR('str', $body);
            $i = 1;
            try
            {
                foreach ($html->find('p[class=DashboardClass]') as $element)
                {
                    $res = '';
                    $class = $element->class;
                    $title = $element->innertext;
                    preg_match('#\((.*?)\)#', $title, $match);
                    $class = $match[1];
                    $title = str_replace('داشبورد:', '', $title);
                    $title = str_replace($class, '', $title);
                    $title = str_replace('(', '', $title);
                    $title = str_replace(')', '', $title);
                    $class = str_replace('DashboardClass ', '', $class);
                    $myArray = explode('_', $class);
                    $type = in_array(0, $myArray) ? $myArray[0] : 'table';
                    $ForE = in_array(1, $myArray) ? $myArray[1] : '2';
                    $FidorEid = in_array(2, $myArray) ? $myArray[2] : '0';
                    $Xs = $myArray[3];
                    $Xs = ltrim($Xs, ',');
                    $Ys = $myArray[4];
                    $Coltype = (array_key_exists(5, $myArray)) ? $myArray[5] : '';
                    $ytitle = (array_key_exists(6, $myArray)) ? $myArray[6] : '';
                    $w = (array_key_exists(7, $myArray)) ? $myArray[7] : 400;
                    $filter = (array_key_exists(8, $myArray)) ? $myArray[8] : 0;
                    $filtertype = (array_key_exists(9, $myArray)) ? $myArray[9] : 0;
                    $Ys = ltrim($Ys, ',');
                    if ($type == 'table' && $FidorEid != '0')
                    {
                        $res .= '<label>' . str_replace('داشبورد: ', '', $title) . '</label>';
                        $res .= PublicsClass::FormReportForContext($FidorEid, $Xs, $Ys, $filter, $filtertype);
                    }
                    elseif ($type == 'Pie' && $FidorEid != '0')
                    {
                        $res .= PublicClass::PieReportForContext($FidorEid, $Xs, $title, $Ys, $filter, $filtertype);
                    }
                    elseif (($type == 'Histogram' || $type == 'Linear') && $FidorEid != '0')
                    {

                        $rowsArr = ($Ys != '') ? explode($Ys, ',') : '';

                        $pos = strpos($Ys, ',');
                        $d = (is_array($rowsArr)) ? 'yes' : 'no';
                        if ($Xs != '' && $Ys != '')
                        {
                            if ($pos != '')
                            {
                                $res .= PublicsClass::Histogram($FidorEid, $Xs, $title, $Ys, $type, $Coltype, $i, $ytitle, $w, $filter, $filtertype);
                            }
                            else
                            {
                                $res .= PublicsClass::Histogram_2($FidorEid, $Xs, $title, $Ys, $type, $Coltype, $i, $ytitle, $w, $filter, $filtertype);
                            }
                        }
                        else
                        {
                            $res .= 'نمودار غیر قابل نمایش';
                        }

//               $res .=PublicClass::HistogramReportForContext($FidorEid, $Xs, $title, $Ys, $type, $Coltype, $i, $ytitle);
                    }

//                elseif (($type == 'Histogram' || $type == 'Linear' ) && ($Coltype == '1') && $FidorEid != '0') {
//                    $res .=PublicClass::ReportForContext($FidorEid, $Xs, $title, $Ys, $type, $Coltype, $i, $ytitle);
//                }

                    $i++;
                    $element->innertext = $res;
                }
            } catch (Exception $exc)
            {
                //echo $exc->getTraceAsString();
            }
        }
        return $html;
    }

    public function Portal_replace($body)
    {
        $S = '';
        $pattern = "/SPortal_.*/";
        if ($num1 = preg_match_all($pattern, $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $keys = $array['0'][$x];
                $key = str_replace('SPortal_', '', $keys);
                $myArray = explode('_', $key);
                $Tags = $myArray[0];
                $Tedad = $myArray[1];
                $Stype = $myArray[2];
                $Sep = '،  ';
                if ($Stype == 2)
                {
                    $Sep = '<br>';
                }
                $Portals = DB::table('subjects as s')
                    ->leftJoin('pages as p', 'p.sid', '=', 's.id')
                    ->join('subject_type AS st', 'st.id', '=', 's.kind')
                    ->select('p.id as pid', 'p.description as descr', 'p.sid', 'p.type', 's.title as title', 'p.state', 'p.score', 'p.edit_date', 'p.com_date', 's.title', 's.kind', 's.manager', 's.supporter', 's.supervisor', 'p.defimage as defimage')
                    ->whereRaw($this->Sel_Page())
                    ->where('s.archive', '=', 0)
                    ->where('st.did', '=', $Tags)
                    ->orWhere('s.group', '=', $Tags)
                    ->orderBy('p.id', 'desc')
                    ->take($Tedad)
                    ->get();
                foreach ($Portals as $Portal)
                {
                    $S .= '<a href="' . $Portal->pid . '">' . $Portal->title . '</a>' . $Sep;
                }

                $body = str_replace($keys, $S, $body);;
            }
        }
        return $body;
    }

    public static function Sel_Page()
    {
        $first = array();
        $PKeys = DB::table('subject_type_tab')
            ->select('tid', 'stid', 'name', 'first')
            ->get();
        foreach ($PKeys as $PKey)
        {
            if ($PKey->first == 1)
            {
                $first[$PKey->stid] = $PKey->tid;
            }
        }
        foreach ($first as $key => $val)
        {
            $selpage[] = '(kind = ' . $key . ' AND type = ' . $val . ')';
        }
        $sel_pages = '(' . implode($selpage, ' OR ') . ')';
        return $sel_pages;
    }

    public function styleDel($body)
    {
        if ($num = preg_match_all("/tr style=\"background-color: #78ceeb;\"/", $body, $array))
        {
            for ($x = 0; $x < count($array); $x++)
            {
                for ($y = 0; $y < count($array[$x]); $y++)
                {
                    $body = str_replace($array[$x][$y], 'tr class="th"', $body);
                }
            }
        }
        if ($num = preg_match_all("/tr style=\"background-color: #87ceeb;\"/", $body, $array))
        {
            for ($x = 0; $x < count($array); $x++)
            {
                for ($y = 0; $y < count($array[$x]); $y++)
                {
                    $body = str_replace($array[$x][$y], 'tr class="th"', $body);
                }
            }
        }
        if ($num = preg_match_all("/td style=\"background-color: #78ceeb;\"/", $body, $array))
        {
            for ($x = 0; $x < count($array); $x++)
            {
                for ($y = 0; $y < count($array[$x]); $y++)
                {
                    $body = str_replace($array[$x][$y], 'td class="th"', $body);
                }
            }
        }
        if ($num = preg_match_all("/td style=\"background-color: #87ceeb;\"/", $body, $array))
        {
            for ($x = 0; $x < count($array); $x++)
            {
                for ($y = 0; $y < count($array[$x]); $y++)
                {
                    $body = str_replace($array[$x][$y], 'td class="th"', $body);
                }
            }
        }

        if ($num = preg_match_all("/<td([^>]*)>(.*?)<\/td>/is", $body, $array))
        {
            for ($y = 0; $y < count($array['0']); $y++)
            {
                $pattern = "|<p[^>]*>(.*?)<\/p>|U";
                $replacement = "$1";
                $array['2'][$y] = preg_replace($pattern, $replacement, $array['2'][$y]);

                $body = str_replace($array['0'][$y], '<td' . $array['1'][$y] . '>' . $array['2'][$y] . '</td>', $body);
            }
        }

        if ($num = preg_match_all("/<span>(.*?)<\/span>/is", $body, $array))
        {
            for ($y = 0; $y < count($array['0']); $y++)
            {
                $body = str_replace($array['0'][$y], $array['1'][$y], $body);
            }
        }


        if ($num = preg_match_all("|<h[1-9]>(.*)<\/h[1-9]>|U", $body, $array))
        {
            for ($y = 0; $y < count($array['0']); $y++)
            {
                if (trim($array['1'][$y]) == '')
                {
                    $body = str_replace($array['0'][$y], '', $body);
                }
            }
        }
        if ($num = preg_match_all("/ style=\"[a-zA-Z0-9 :,\';#\-]+\"/", $body, $array))
        {
            for ($y = 0; $y < count($array['0']); $y++)
            {
                $body = str_replace($array['0'][$y], '', $body);
            }
        }
        if ($num = preg_match_all("/ align=\"[a-z]+\"/", $body, $array))
        {
            for ($x = 0; $x < count($array); $x++)
            {
                for ($y = 0; $y < count($array[$x]); $y++)
                {
                    $body = str_replace($array[$x][$y], '', $body);
//		echo $array[$x][$y] ;	
                }
            }
        }
        if ($num = preg_match_all("/ valign=\"[a-z]+\"/", $body, $array))
        {
            for ($x = 0; $x < count($array); $x++)
            {
                for ($y = 0; $y < count($array[$x]); $y++)
                {
                    $body = str_replace($array[$x][$y], '', $body);
//		echo $array[$x][$y] ;	
                }
            }
        }
        if ($num = preg_match_all("/ dir=\"RTL\"/", $body, $array))
        {
            for ($x = 0; $x < count($array); $x++)
            {
                for ($y = 0; $y < count($array[$x]); $y++)
                {
                    $body = str_replace($array[$x][$y], '', $body);
                }
            }
        }
        if ($num = preg_match_all("/ dir=\"rtl\"/", $body, $array))
        {
            for ($x = 0; $x < count($array); $x++)
            {
                for ($y = 0; $y < count($array[$x]); $y++)
                {
                    $body = str_replace($array[$x][$y], '', $body);
                }
            }
        }
        if ($num1 = preg_match_all("|table_([0-9]{1,2}-[0-9]{1,2}-[0-9]{1,2}-[0-9]{2})|U", $body, $array1))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $body = str_replace('<div class="tables">' . $array1['0'][$x] . '</div>', '<p class="tables">' . $array1['0'][$x] . '</p>', $body);
            }
        }
        $body = str_replace(array('\r\n', '\r', '\n', '\t', '  ', '    ', '    '), ' ', $body);
        $body = str_replace('../tinymce/upload-files', 'tinymce/upload-files', $body);
        return $body;
    }

    public function table($body)
    {
        $html = '';
        if (trim($body) != '')
        {
            $html = new HtmlDomSTR('str', $body);
            foreach ($html->find('table') as $element)
                $element->class = 'table table-bordered';
            $body = $html;
        }

        return $html;
    }

    /**
     * @param $body
     * @param $pid
     * @param $sid
     * @return HtmlDomSTR|string
     */
    public function Forms($body, $pid, $sid)
    {
        //dd();
        $html = '';
        if (trim($body) != '')
        {
            $html = new HtmlDomSTR('str', $body);
            foreach ($html->find('p[id=FormInPage]') as $element)
            {
                $title = strip_tags($element->outertext);
                $C = $element->class;
                $C = explode('_', $C);
//                if (array_key_exists(1, $C) && $C[1] == '2') {
                $element->outertext = '<a class="jsPanels" title="' . $title . '" href="modals/formshow?id=' . $C[0] . '&amp;tagname=safhe_dargaah&amp;hid=139&amp;pid=' . $pid . '&sid=' . $sid . '">' . $title . '</a>';
                // }
            }
            $body = $html;
        }

        return $html;
    }

    public function subtitle($body)
    {
        $last = '';
        $n = 0;
        $s = 1;
        if ($num = preg_match_all("|<span class=\"subtitle\"[^>]*>(.*)<\/span>|U", $body, $array))
        {
            for ($y = 0; $y < count($array['0']); $y++)
            {
                ++$n;
                ++$s;
                $body = $this->str_replace_first($array['0'][$y], '<sup><a id="s' . $n . '" rel="nofollow" href="#f' . $n . '">' . $n . '</a></sup>', $body);
                $last .= '<a id="f' . $n . '" rel="nofollow" href="#s' . $n . '">↑ [' . $n . ']</a> ' . $array['1'][$y] . ' <br />';
            }
        }
        if ($last != '')
        {
            $body .= '<hr style="background-color:#DDDDDD; height:1px; border:0px; ">' . $last;
        }
        return $body;
    }

    public function replace_subtitle($body)
    {
        $last = '';
        $n = 0;
        $s = 1;
        if ($num = preg_match_all("/\{\{(.*?)\|(.*?)\}\}/", $body, $array))
        {
            for ($y = 0; $y < count($array['0']); $y++)
            {
                $body = str_replace($array['0'][$y], '<span class="subtitle">' . $array['2'][$y] . '</span>', $body);
            }
        }
        return $body;
    }

    public function resource($body)
    {
        if ($num = preg_match_all("|<p class=\"resource\"[^>]*>(.*)<\/p>|U", $body, $array))
        {
            for ($y = 0; $y < count($array['0']); $y++)
            {

                $body = str_replace($array['0'][$y], '<p class="resource">مأخذ  : ' . strip_tags($array['1'][$y]) . '</p>', $body);
            }
        }
        return $body;
    }

    public function number($body, $reset = 1)
    {
        static $numbers = array();
        $numbers[1] = (!isset($numbers[1]) || $reset == 1) ? 0 : $numbers[1];
        $numbers[2] = (!isset($numbers[2]) || $reset == 1) ? 0 : $numbers[2];
        $numbers[3] = (!isset($numbers[3]) || $reset == 1) ? 0 : $numbers[3];
        static $number = array();
        $number[1] = (!isset($number[1]) || $reset == 1) ? 0 : $number[1];
        $number[2] = (!isset($number[2]) || $reset == 1) ? 0 : $number[2];
        $number[3] = (!isset($number[3]) || $reset == 1) ? 0 : $number[3];
        if ($num = preg_match_all("|<[p]*[span]* class=\"number([1-9]{0,1})\"[^>]*>(.*)<\/[p]*[span]*>|U", $body, $array))
        {
            for ($y = 0; $y < count($array['0']); $y++)
            {
                $n = $array['1'][$y];
                $name = trim(strip_tags($array['2'][$y]));

                if ($n == 0)
                {
                    if ($name == 'جدول بالا')
                    {
                        $n = 1;
                        if ($number[$n] == 0)
                        {
                            $number[$n] = $numbers[$n];
                        }
                        else
                        {
                            $number[$n] = $number[$n] - 1;
                        }
                    }
                    elseif ($name == 'جدول زیر')
                    {
                        $n = 1;
                        if ($number[$n] == 0)
                        {
                            $number[$n] = $numbers[$n] + 1;
                        }
                        else
                        {
                            $number[$n] = $number[$n] + 1;
                        }
                    }
                    if ($name == 'نمودار بالا')
                    {
                        $n = 2;
                        if ($number[$n] == 0)
                        {
                            $number[$n] = $numbers[$n];
                        }
                        else
                        {
                            $number[$n] = $number[$n] - 1;
                        }
                    }
                    elseif ($name == 'نمودار زیر')
                    {
                        $n = 2;
                        if ($number[$n] == 0)
                        {
                            $number[$n] = $numbers[$n] + 1;
                        }
                        else
                        {
                            $number[$n] = $number[$n] + 1;
                        }
                    }
                    if ($name == 'عکس بالا' || $name == 'تصویر بالا')
                    {
                        $n = 3;
                        if ($number[$n] == 0)
                        {
                            $number[$n] = $numbers[$n];
                        }
                        else
                        {
                            $number[$n] = $number[$n] - 1;
                        }
                    }
                    elseif ($name == 'عکس زیر' || $name == 'تصویر زیر')
                    {
                        $n = 3;
                        if ($number[$n] == 0)
                        {
                            $number[$n] = $numbers[$n] + 1;
                        }
                        else
                        {
                            $number[$n] = $number[$n] + 1;
                        }
                    }
                    if ($n == 1 || $n == 2 || $n == 3)
                    {
                        $body = $this->str_replace_first($array['0'][$y], '<span class="number">' . $this->ChangeTitle($n) . ' ' . $number[$n] . '</span>', $body);
                    }
                }
                else
                {
                    if (intval($n) != 0)
                    {
                        $number[$n] = 0;
                        ++$numbers[$n];
                        $body = $this->str_replace_first($array['0'][$y], '<p class="number">' . $this->ChangeTitle($n) . ' ' . $numbers[$n] . ' : ' . $name . '</p>', $body);
                    }
                }
            }
        }
        return $body;
    }

    public function str_replace_first($search, $replace, $subject)
    {
        $pos = strpos($subject, $search);
        if ($pos !== false)
        {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }
        return $subject;
    }

    public function quran_replace($body)
    {
        if ($num1 = preg_match_all("|quran_([0-9]{1,2}-[0-9]{1,3}-[0-9]{1,2})|U", $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $body = str_replace('<p class="qurans">' . $array['0'][$x] . '</p>', '<div class="Amirqurans">' . $this->quran_create($array['1'][$x]) . '</div>', $body);
            }
        }
        return $body;
    }

    public function RefList_Replace($body, $list)
    {
        try
        {
            if ($list != '')
            {
                $pattern = "/{{.{1,20}}}/";
                $i = 1;
                $str = '';
                $Books = array();
                $EnBooks = array();
                $Article = array();
                $EnArticle = array();
                $payan = array();
                $Enpayan = array();
                $list = rtrim($list, ',');
                $repss = DB::table('subjects as s')
                    ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                    ->whereRaw("p.id in($list)")
                    ->select('s.kind', 's.title', 'p.id as pid')
                    ->orderby('s.title')
                    ->get();
                foreach ($repss as $reps)
                {
                    $Nevisande = '';
                    $pid = $reps->pid;
                    $title = trim($reps->title);
                    $kind = $reps->kind;
                    $Ref['title'] = $title;
                    $Ref['pid'] = $pid;
                    $writer = DB::table('subject_fields_report as r')
                        ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                        ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                        ->leftJoin('subject_type_fields as st', function ($join)
                        {
                            $join->on('st.stid', '=', 's.kind');
                            $join->on('st.id', '=', 'r.field_id');
                        })
                        ->where('st.field_id', '7')->where('p.id', $pid)
                        ->select('r.field_value as field_val', 'r.field_id')->first();
                    $writer = ($writer) ? $writer->field_val : '-';
                    $zaban = 'fa';
                    $zabans = DB::table('subject_fields_report as r')
                        ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                        ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                        ->leftJoin('subject_type_fields as st', function ($join)
                        {
                            $join->on('st.stid', '=', 's.kind');
                            $join->on('st.id', '=', 'r.field_id');
                        })->where('st.field_id', '36')
                        ->where('p.id', $pid)
                        ->select('r.field_value as field_val', 'r.field_id')->first();
                    if ($zabans && $zabans->field_val == 'انگلیسی')
                    {
                        $zaban = 'en';
                    }

                    $motarjem = '';
                    $motarjems = DB::table('subject_fields_report as r')
                        ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                        ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                        ->leftJoin('subject_type_fields as st', function ($join)
                        {
                            $join->on('st.stid', '=', 's.kind');
                            $join->on('st.id', '=', 'r.field_id');
                        })->where('st.field_id', '8')
                        ->where('p.id', $pid)
                        ->select('r.field_value as field_val', 'r.field_id')
                        ->first();
                    $motarjem = ($motarjems) ? trim($motarjems->field_val) : '-';

                    $yeartarjome = '';
                    $yeartarjome = DB::table('subject_fields_report as r')
                        ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                        ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                        ->leftJoin('subject_type_fields as st', function ($join)
                        {
                            $join->on('st.stid', '=', 's.kind');
                            $join->on('st.id', '=', 'r.field_id');
                        })->where('st.field_id', '14')->where('p.id', $pid)
                        ->select('r.field_value as field_val', 'r.field_id')->first();
                    $yeartarjome = ($yeartarjome) ? $yeartarjome->field_val : '-';

                    $nashertarjome = DB::table('subject_fields_report as r')
                        ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                        ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                        ->leftJoin('subject_type_fields as st', function ($join)
                        {
                            $join->on('st.stid', '=', 's.kind');
                            $join->on('st.id', '=', 'r.field_id');
                        })
                        ->where('st.field_id', '35')
                        ->where('p.id', $pid)
                        ->select('r.field_value as field_val', 'r.field_id')
                        ->first();
                    $nashertarjome = ($nashertarjome) ? $nashertarjome->field_val : '-';


                    $year = DB::table('subject_fields_report as r')
                        ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                        ->leftJoin('subject_type_fields as st', function ($join)
                        {
                            $join->on('st.stid', '=', 's.kind');
                            $join->on('st.id', '=', 'r.field_id');
                        })
                        ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                        ->where('st.field_id', '19')
                        ->where('p.id', $pid)
                        ->select('r.field_value as field_val', 'r.field_id')
                        ->first();
                    $Ref['year'] = ($year) ? $year->field_val : '-';
                    $mahalenteshar = DB::table('subject_fields_report as r')
                        ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                        ->leftJoin('subject_type_fields as st', function ($join)
                        {
                            $join->on('st.stid', '=', 's.kind');
                            $join->on('st.id', '=', 'r.field_id');
                        })
                        ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                        ->where('st.field_id', '92')
                        ->where('p.id', $pid)
                        ->select('r.field_value as field_val', 'r.field_id')
                        ->first();
                    $Ref['mahalenteshar'] = ($mahalenteshar) ? $mahalenteshar->field_val : '';

                    $nasher = DB::table('subject_fields_report as r')
                        ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                        ->leftJoin('subject_type_fields as st', function ($join)
                        {
                            $join->on('st.stid', '=', 's.kind');
                            $join->on('st.id', '=', 'r.field_id');
                        })
                        ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                        ->where('st.field_id', '10')
                        ->where('p.id', $pid)
                        ->select('r.field_value as field_val', 'r.field_id')
                        ->first();
                    $Ref['nasher'] = ($nasher) ? $nasher->field_val : '';

                    if ($kind == '42')
                    {
                        if (trim($writer) == '')
                        {
                            $nasher = DB::table('subject_fields_report as r')
                                ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                                ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                                ->leftJoin('subject_type_fields as st', function ($join)
                                {
                                    $join->on('st.stid', '=', 's.kind');
                                    $join->on('st.id', '=', 'r.field_id');
                                })
                                ->where('st.field_id', '20')
                                ->where('p.id', $pid)
                                ->select('r.field_value as field_val', 'r.field_id')
                                ->first();
                            $Ref['Nevisande'] = ($nasher) ? $nasher->field_val : ' ';
                        }
                        else
                        {
                            $myArrays = explode('؛', $writer);
                            $Nevisande = '';
                            if (is_array($myArrays) && count($myArrays) > 0)
                            {
                                foreach ($myArrays as $value)
                                {
                                    $my = explode('،', $value);
                                    if (is_array($my) && count($my) > 0)
                                    {
                                        $family = (array_key_exists('1', $my)) ? $my[1] : '';
                                        $name = (array_key_exists('0', $my)) ? $my[0] : '';
                                        $Nevisande = (count($myArrays) > 1 && end($myArrays) == $value) ? ltrim($Nevisande, '. ') . ' و ' . $family . '، ' . $name : $Nevisande . $family . '، ' . $name . '. ';
                                    }
                                    else
                                    {
                                        $Nevisande .= $my . '. ';
                                    }
                                }
                            }
                            else
                            {
                                $my = explode('،', $writer);
                                if (is_array($my) && count($my) > 0)
                                {
                                    $family = (array_key_exists('1', $my)) ? $my[1] : '';
                                    $name = (array_key_exists('0', $my)) ? $my[0] : '';
                                    $Nevisande .= $family . '، ' . $name;
                                }
                                else
                                {
                                    $Nevisande .= $my;
                                }
                            }
                            $Ref['Nevisande'] = $Nevisande;
                        }


                        $Motargem = '';
                        if ($motarjem != '')
                        {

                            $myArrays = explode('؛', $motarjem);
                            if (is_array($myArrays) && count($myArrays) > 0)
                            {
                                foreach ($myArrays as $value)
                                {
                                    $my = explode('،', $value);
                                    if (is_array($my) && count($my) > 0)
                                    {
                                        $family = (array_key_exists('1', $my)) ? $my[1] : '';
                                        $name = (array_key_exists('0', $my)) ? $my[0] : '';
                                        $Motargem = (count($myArrays) > 1 && end($myArrays) == $value) ? ltrim($Motargem, '. ') . ' و ' . $family . '، ' . $name : $Motargem . $family . '، ' . $name . '. ';
                                    }
                                    else
                                    {
                                        $Motargem .= $my . '. ';
                                    }
                                }
                            }
                            else
                            {
                                $my = explode('،', $writer);
                                if (is_array($my) && count($my) > 0)
                                {
                                    $family = (array_key_exists('1', $my)) ? $my[1] : '';
                                    $name = (array_key_exists('0', $my)) ? $my[0] : '';
                                    $Motargem .= $family . '، ' . $name;
                                }
                                else
                                {
                                    $Motargem .= $my;
                                }
                            }
                        }

                        $Ref['Yeartarjome'] = $yeartarjome;
                        $Ref['Motargem'] = $Motargem;
                        $Ref['nashertarjome'] = $nashertarjome;


                        if ($zaban == 'en' && !in_array($Ref, $EnBooks))
                        {
                            array_push($EnBooks, $Ref);
                        }
                        elseif ($zaban == 'fa' && !in_array($Ref, $Books))
                        {
                            array_push($Books, $Ref);
                        }
                    }
                    elseif ($kind == '50')
                    {
                        $nasher = DB::table('subject_fields_report as r')
                            ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                            ->leftJoin('subject_type_fields as st', function ($join)
                            {
                                $join->on('st.stid', '=', 's.kind');
                                $join->on('st.id', '=', 'r.field_id');
                            })
                            ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                            ->where('st.field_id', '12')
                            ->where('p.id', $pid)
                            ->select('r.field_value as field_val', 'r.field_id')
                            ->first();
                        $Ref['nashrieh'] = ($nasher) ? $nasher->field_val : ' ';

                        $nasher = DB::table('subject_fields_report as r')
                            ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                            ->leftJoin('subject_type_fields as st', function ($join)
                            {
                                $join->on('st.stid', '=', 's.kind');
                                $join->on('st.id', '=', 'r.field_id');
                            })
                            ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                            ->where('st.field_id', '117')->where('p.id', $pid)
                            ->select('r.field_value as field_val', 'r.field_id')->first();
                        $Ref['dore'] = ($nasher) ? $nasher->field_val : ' ';
                        $nasher = DB::table('subject_fields_report as r')
                            ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                            ->leftJoin('subject_type_fields as st', function ($join)
                            {
                                $join->on('st.stid', '=', 's.kind');
                                $join->on('st.id', '=', 'r.field_id');
                            })
                            ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                            ->where('st.field_id', '16')->where('p.id', $pid)
                            ->select('r.field_value as field_val', 'r.field_id')->first();
                        $Ref['shomare'] = ($nasher) ? $nasher->field_val : ' ';
                        $nasher = DB::table('subject_fields_report as r')
                            ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                            ->leftJoin('subject_type_fields as st', function ($join)
                            {
                                $join->on('st.stid', '=', 's.kind');
                                $join->on('st.id', '=', 'r.field_id');
                            })
                            ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                            ->where('st.field_id', '120')->where('p.id', $pid)
                            ->select('r.field_value as field_val', 'r.field_id')->first();
                        $Ref['shomaresafhe'] = ($nasher) ? $nasher->field_val : ' ';
                        $myArrays = explode('؛', $writer);
                        $Nevisande = '';
                        if (is_array($myArrays) && count($myArrays) > 0)
                        {
                            foreach ($myArrays as $value)
                            {
                                $my = explode('،', $value);
                                if (is_array($my) && count($my) > 0)
                                {
                                    $family = (array_key_exists('1', $my)) ? $my[1] : '';
                                    $name = (array_key_exists('0', $my)) ? $my[0] : '';
                                    $Nevisande = (count($myArrays) > 1 && end($myArrays) == $value) ? ltrim($Nevisande, '.') . ' و ' . $family . '، ' . $name : $Nevisande . $family . '، ' . $name . '. ';
// $Nevisande.= (count($myArrays) > 1 && end($myArrays) == $value) ? ' و ' . $family . '،' . $name : $family . '،' . $name.'. ';
                                }
                                else
                                {
                                    $Nevisande .= $my . '. ';
                                }
                            }
                        }
                        else
                        {
                            $my = explode('،', $writer);
                            if (is_array($my) && count($my) > 0)
                            {
                                $family = (array_key_exists('1', $my)) ? $my[1] : '';
                                $name = (array_key_exists('0', $my)) ? $my[0] : '';
                                $Nevisande .= $family . '، ' . $name;
                            }
                            else
                            {
                                $Nevisande .= $my;
                            }
                        }
                        $Ref['Nevisande'] = $Nevisande;

                        if (trim($Nevisande) == '' || trim($Nevisande) == '،')
                        {
                            $nasher = DB::table('subject_fields_report as r')
                                ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                                ->leftJoin('subject_type_fields as st', function ($join)
                                {
                                    $join->on('st.stid', '=', 's.kind');
                                    $join->on('st.id', '=', 'r.field_id');
                                })
                                ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                                ->where('st.field_id', '20')->where('p.id', $pid)
                                ->select('r.field_value as field_val', 'r.field_id')->first();
                            $Ref['Nevisande'] = ($nasher) ? $nasher->field_val : ' ';
                        }
                        if ($zaban == 'en' && !in_array($Ref, $EnArticle))
                        {
                            array_push($EnArticle, $Ref);
                        }
                        elseif ($zaban == 'fa' && !in_array($Ref, $Article))
                        {
                            array_push($Article, $Ref);
                        }
                    }
                    elseif ($kind == '45')
                    {

                        $writer = DB::table('subject_fields_report as r')
                            ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                            ->leftJoin('subject_type_fields as st', function ($join)
                            {
                                $join->on('st.stid', '=', 's.kind');
                                $join->on('st.id', '=', 'r.field_id');
                            })
                            ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                            ->where('st.field_id', '146')->where('p.id', $pid)
                            ->select('r.field_value as field_val', 'r.field_id')->first();
                        $writer = ($writer) ? $writer->field_val : '-';
                        $Nevisande = '';

                        $my = explode('،', $writer);
                        if (is_array($my) && count($my) > 0)
                        {
                            $family = (array_key_exists('1', $my)) ? $my[1] : '';
                            $name = (array_key_exists('0', $my)) ? $my[0] : '';
                            $Nevisande = $family . '، ' . $name;
                        }
                        else
                        {
                            $Nevisande = $my;
                        }

                        $Ref['Nevisande'] = $Nevisande;


                        $nasher = DB::table('subject_fields_report as r')
                            ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                            ->leftJoin('subject_type_fields as st', function ($join)
                            {
                                $join->on('st.stid', '=', 's.kind');
                                $join->on('st.id', '=', 'r.field_id');
                            })
                            ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                            ->where('st.field_id', '150')->where('p.id', $pid)
                            ->select('r.field_value as field_val', 'r.field_id')->first();
                        $Ref['maghta'] = ($nasher) ? $nasher->field_val : '-';
                        $nasher = DB::table('fields_value')->where('id', $Ref['maghta'])->select('field_value')->first();
                        $Ref['maghta'] = ($nasher) ? $nasher->field_value : '';


                        $nasher = DB::table('subject_fields_report as r')
                            ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                            ->leftJoin('subject_type_fields as st', function ($join)
                            {
                                $join->on('st.stid', '=', 's.kind');
                                $join->on('st.id', '=', 'r.field_id');
                            })
                            ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                            ->where('st.field_id', '151')->where('p.id', $pid)
                            ->select('r.field_value as field_val', 'r.field_id')->first();
                        $Ref['year'] = ($nasher) ? $nasher->field_val : '-';

                        $nasher = DB::table('subject_fields_report as r')
                            ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                            ->leftJoin('subject_type_fields as st', function ($join)
                            {
                                $join->on('st.stid', '=', 's.kind');
                                $join->on('st.id', '=', 'r.field_id');
                            })
                            ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                            ->where('st.field_id', '149')->where('p.id', $pid)
                            ->select('r.field_value as field_val', 'r.field_id')->first();
                        $Ref['university'] = ($nasher) ? $nasher->field_val : ' ';
                        $nasher = DB::table('subject_fields_report as r')
                            ->leftjoin('subjects as s', 's.id', '=', 'r.sid')
                            ->leftJoin('subject_type_fields as st', function ($join)
                            {
                                $join->on('st.stid', '=', 's.kind');
                                $join->on('st.id', '=', 'r.field_id');
                            })
                            ->leftjoin('pages as p', 's.id', '=', 'p.sid')
                            ->where('st.field_id', '11')->where('p.id', $pid)
                            ->select('r.field_value as field_val', 'r.field_id')->first();
                        $Ref['country'] = ($nasher) ? $nasher->field_val : ' ';


                        if ($zaban == 'en' && !in_array($Ref, $Enpayan))
                        {
                            array_push($Enpayan, $Ref);
                        }
                        elseif ($zaban == 'fa' && !in_array($Ref, $payan))
                        {
                            array_push($payan, $Ref);
                        }
                    }
                }
                $i = 1;
                $str .= '<ol>';
                foreach ($Books as $value)
                {
                    $value['year'] = ($value['year'] != '') ? " ({$value['year']})" : '';
                    $value['Yeartarjome'] = ($value['Yeartarjome'] != '') ? " ({$value['Yeartarjome']})" : '';

                    if ($value['Motargem'] != '' && $value['Motargem'] != '، -. ')
                    {
                        $str .= '<li>' . $value['Motargem'] . $value['Yeartarjome'] . ' <i><a href="' . $value['pid'] . '">' . $value['title'] . '</a></i>. (' . trim($value['Nevisande']) . ') ' . $value['mahalenteshar'] . ': ' . $value['nashertarjome'] . '.' . $value['year'] . '</li>';
                    }
                    else
                    {
                        $str .= '<li>' . $value['Nevisande'] . $value['year'] . ' <i><a href="' . $value['pid'] . '">' . $value['title'] . '</a></i>. ' . $value['mahalenteshar'] . ': ' . $value['nasher'] . '.</li>';
                    }
                    $i++;
                }
                foreach ($Article as $value)
                {
                    $str .= '<li>' . $value['Nevisande'] . ' (' . $value['year'] . ') <a href="' . $value['pid'] . '">' . $value['title'] . '</a>. <i>' . $value['nashrieh'] . '. دوره ' . $value['dore'] . ' شماره ' . $value['shomare'] . ' صص ' . $value['shomaresafhe'] . '.</i></li>';
                    $i++;
                }
                foreach ($payan as $value)
                {
                    $str .= '<li>' . $value['Nevisande'] . ' (' . $value['year'] . ') <i><a href="' . $value['pid'] . '">' . $value['title'] . '</a></i>. ' . $value['maghta'] . ': ' . $value['university'] . '. ' . $value['country'] . '</li>';
                    $i++;
                }
                //$str .='</ol><div style="direction:ltr;"><ol style="direction:ltr;">';
                foreach ($EnBooks as $value)
                {
                    $str .= '<li>' . $value['Nevisande'] . '(' . $value['year'] . ') <i><a href="' . $value['pid'] . '">' . $value['title'] . '</a></i>. ' . $value['mahalenteshar'] . ': ' . $value['nasher'] . '.</li>';
                    $i++;
                }
                foreach ($EnArticle as $value)
                {
                    $str .= '<li>' . $value['Nevisande'] . ' (' . $value['year'] . ') <a href="' . $value['pid'] . '">' . $value['title'] . '</a>. <i>' . $value['nashrieh'] . '. Vol. ' . $value['dore'] . ' No. ' . $value['shomare'] . ' pp. ' . $value['shomaresafhe'] . '.</i></li>';

                    $i++;
                }
                foreach ($Enpayan as $value)
                {
                    $str .= '<li>' . $value['Nevisande'] . '(' . $value['year'] . ') <i><a href="' . $value['pid'] . '">' . $value['title'] . '</a></i>. ' . $value['maghta'] . ': ' . $value['university'] . '. ' . $value['country'] . '</li>';
                    $i++;
                }
                $str .= '</ol>';
                $body = $body . $str;
                return $body;
            }
        } catch (Exception $exc)
        {
            return '';
        }
    }

    public function RefList($body)
    {
        $str = '';
        $pattern = "/{{.{1,22}}}/";
        if ($num1 = preg_match_all($pattern, $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $Con = $array['0'][$x];
                //if (strpos($Con, "{{Help")!='') {
                $Con = str_replace("{{", "", $Con);
                $Con = str_replace("}}", "", $Con);
                $pid = trim($Con);
                $myArray = explode('|', $Con);
                if (is_array($myArray) && count($myArray) > 2)
                {
                    $pid = $myArray[0];
                }
                else
                {
                    if (is_array($myArray) && count($myArray) > 1)
                    {
                        $pid = $myArray[0];
                    }
                }
                $pid = trim(str_replace("و", ',', $pid));
                $pid = trim(str_replace("،", ',', $pid));
                if ($pid != '')
                {
                    $str .= $pid . ',';
                }
                else
                {
                    $str .= '';
                }
                // }
            }
        }
        $str = ($str == ',') ? '' : $str;
        return $str;
    }

    public function replace_number($body)
    {
        $numbers = array();
        $numbers[1] = 0;
        $numbers[2] = 0;
        $numbers[3] = 0;
        if ($num = preg_match_all("/\#\#(.*?)\|(.*?)\#\#/", $body, $array))
        {
            for ($y = 0; $y < count($array['0']); $y++)
            {
                $n = $array['1'][$y];
                if (intval($n) != 0)
                {
                    ++$numbers[$n];
                    $body = str_replace($array['0'][$y], '<p class="number' . $n . '">' . $array['2'][$y] . '</p>', $body);
                }
            }
        }
        return $body;
    }

    public function quran_create($qurans)
    {
        $text = '';
        $filter = explode('-', $qurans);
        $quran = intval(trim($filter['0']));
        $sura = intval(trim($filter['1']));
        $aya = intval(trim($filter['2']));
        if ($quran != 0 && $sura != 0)
        {
            if ($aya == 0)
            {
                $Qurans = DB::table('quran_text')->where('sura', '=', $sura)->select('index', 'aya', 'text')->get();
                foreach ($Qurans as $Quran)
                {
                    if ($Quran->aya == 1)
                    {
                        $text1 = $Quran->text;
                        $text1 = str_replace('بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ', '<div style="text-align:Center !important;font-family:Quran_Taha">' . 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ' . '</div>', $text1);
                        $text .= $text1 . '<img style="display: initial;padding-right: 15px;padding-left: 15px;" src="QuranImages/' . $Quran->aya . '.gif" />';
                    }
                    else
                    {
                        $text .= $Quran->text . '<img style="display: initial;padding-right: 15px;padding-left: 15px;" src="QuranImages/' . $Quran->aya . '.gif" />';
                    }
                }
            }
            else
            {
                $Qurans = DB::table('quran_text')->where('sura', '=', $sura)->where('aya', '=', $aya)->select('index', 'aya', 'text')->get();
                foreach ($Qurans as $Quran)
                {
                    $text = $Quran->text . '<span class="aya_number"> (' . $Quran->aya . ') </span>';
                }
            }
        }
        return $text;
    }

    public function context($body)
    {
        $pashapes = array();
        $tooltips = array();
        $contexts = DB::table('context')->select('id', 'pid', 'pshape', 'definition')->get();
        foreach ($contexts as $context)
        {

            $plusplus[$context->id] = '++' . $context->pshape . '++';
            $tooltips[$context->id] = '<a rel="canonical" href="' . config('constants.HAMAFZA') . '/' . $context->pid . '/' . $context->pshape . '/" class="stooltip" original-title="' . $context->definition . '" target="_blank">' . $context->pshape . '</a>';
        }

        $body = str_replace($plusplus, $tooltips, $body);


        return $body;
    }

    function Newusers()
    {
        $res = '';
        $Uscount = DB::table('user')->select('id')->count();
        $Users = DB::table('user as u')->where('u.Active', '1')->select('u.id', 'u.uname', 'u.Name', 'u.Family', 'u.Pic', 'u.Summary')->orderBy('id', 'desc')->take(4)->get();
        $i = 1;
        $j = 1;
        $ress =
            '<div class="col-xs-12 col-sm-6 CountDiVBordered">
				<div class="CountDiVBordered-header">
					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 noPadding">
						<span class="user-logo"></span>
					</div>
					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 noPadding">
						<span style="vertical-align: top;line-height: 80px;font-size: large;">کاربران</span>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"></div>
					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 noPadding">
						<span style="vertical-align: top;line-height: 80px;font-size: large;">' . $Uscount . '</span>
					</div>
				</div>
				<div class="col-xs-12" style="margin: 10px 0px;">
					<a class="jsPanels" title="جستجوی اعضاء" href="modals/sociasearch?type=user">جستجوی کاربران</a>
				</div>
			
				<div class="CountDiVBordered-content">
					<div class="CountDiVBordered-content-li">';
        foreach ($Users as $UserS)
        {
            $tid = $UserS->id;
            $title = $UserS->Name . ' ' . $UserS->Family;
            $title = wordwrap($title, 80, '<br/>', true);
            $title1 = explode('<br/>', $title);
            $title = (trim($title1[0]) != '' && strlen($title) > 80) ? $title1[0] . ' ...' : $title1[0];
            $summary = $UserS->Summary;
            $summary = wordwrap($summary, 100, '<br/>', true);
            $summary1 = explode('<br/>', $summary);
            $summary = (trim($summary1[0]) != '' && strlen($summary) > 100) ? $summary1[0] . ' ...' : $summary1[0];
            $pic = (trim($UserS->Pic)) ? $UserS->Pic : 'defusers.png';
            if (($UserS->uname) != '')
            {
                $link = config('constants.SiteAddress') . "$UserS->uname";
            }
            else
            {
                $link = config('constants.SiteAddress') . "user/{$tid}";
            }
            $ress .= '<div class="col-xs-12" style="background-color: #fff;margin: 5px 0px;height: 50px;">
						<div class="col-xs-3 noPadding" style="height: 50px;"><img  src="pics/user/' . $pic . '" class="person-avatar mCS_img_loaded" style="height: 50px;width: 50px;"></div>
						<div class="col-xs-9 text-align-right noPadding" style="line-height: 50px;"><a href="' . $link . '">' . $title . '</a></div>
					</div>';
            $i++;
        }
        $ress .= '</div></div>';

        $f = $ress . $res . '</span> </div> ';
        $res = '';
        $type = 'group';
        $user_groups = DB::table('user_group')->select('id', 'name', 'link', 'summary', 'pic')->where('isorgan', '0')->orderBy('reg_date', 'desc')
            ->take(4)->get();
        $Uscount = DB::table('user_group')->select('id')->where('isorgan', '0')->count();
        $i = 1;
        $ress =
            '<div class="col-xs-12 col-sm-6 CountDiVBordered">
				<div class="CountDiVBordered-header">
					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 noPadding">
						<span class="group-logo"></span>
					</div>
					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 noPadding">
						<span style="vertical-align: top;line-height: 80px;font-size: large;">گروه‌ها</span>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"></div>
					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 noPadding">
						<span style="vertical-align: top;line-height: 80px;font-size: large;">' . $Uscount . '</span>
					</div>
				</div>
				<div class="col-xs-12" style="margin: 10px 0px;">
					<a class="jsPanels" title="جستجوی دسته‌ها" href="modals/sociasearch?type=group">جستجوی گروه‌ها</a>
				</div>
				
				<div class="CountDiVBordered-content">
					<div class="CountDiVBordered-content-li">';
        foreach ($user_groups as $UserS)
        {
            $tid = $UserS->id;
            $link = $UserS->link;
            $title = $UserS->name;
            $summary = $UserS->summary;
            $pic = (trim($UserS->pic)) ? $UserS->pic : 'defgroup.png';
            $link = config('constants.SiteAddress') . $link;
            $ress .= '<div class="col-xs-12" style="background-color: #fff;margin: 5px 0px;height: 50px;">
						<div class="col-xs-3 noPadding" style="height: 50px;"><img  src="pics/group/' . $pic . '" class="person-avatar mCS_img_loaded" style="height: 50px;width: 50px;"></div>
						<div class="col-xs-9 text-align-right noPadding" style="line-height: 50px;"><a href="' . $link . '">' . $title . '</a></div>
					</div>';

            $i++;
        }
        $ress .= '</div></div>';
        $g = $ress . '</span> </div> ';

        $res = '';
        $type = 'group';
        $user_groups = DB::table('user_group')->select('id', 'name', 'link', 'summary', 'pic')->where('isorgan', 1)->orderBy('reg_date', 'desc')
            ->take(4)->get();
        $Uscount = DB::table('user_group')->select('id')->where('isorgan', 1)->count();
        $i = 1;
        $ress = '<div class="col-xs-4 col-sm-4 col-md-4 CountDiVBordered">
                        <div class="DivCounters CahenlCounter" >
                          <span>  ' . $Uscount . '  </span>
                        </div>
                        <span ><a class="jsPanels" title="جستجوی کانال‌ ها" href="modals/sociasearch?type=organ">جستجوی کانال‌ها</a></span>
                        <span class="member">کانال‌های جدید</span>    
                        <span class=" person-list GroupList">';
        $ress =
            '<div class="col-xs-12 col-sm-6 CountDiVBordered">
			<div class="CountDiVBordered-header">
				<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 noPadding">
					<span class="canal-logo"></span>
				</div>
				<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 noPadding">
					<span style="vertical-align: top;line-height: 80px;font-size: large;">کانال‌ها</span>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"></div>
				<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 noPadding">
					<span style="vertical-align: top;line-height: 80px;font-size: large;">' . $Uscount . '</span>
				</div>
			</div>
			<div class="col-xs-12" style="margin: 10px 0px;">
				<a class="jsPanels" title="جستجوی کانال‌ ها" href="modals/sociasearch?type=organ">جستجوی کانال‌ها</a>
			</div>
			
			<div class="CountDiVBordered-content">
				<div class="CountDiVBordered-content-li">';
        foreach ($user_groups as $UserS)
        {
            $tid = $UserS->id;
            $link = $UserS->link;
            $title = $UserS->name;
            $summary = $UserS->summary;
//            $pic = (trim($UserS->pic)) ? $UserS->pic : 'chanels.png';
            $pic = 'chanels.png';
            $link = config('constants.SiteAddress') . $link;
            $res .= '<li  style="list-style:none !important; width: 90% !important;" class="col-sm-2"><img  src="pics/group/' . $pic . '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
            $res .= '<div class="close"></div><div class="person-name"><a href="' . $link . '">' . $title . '</a></div><div class="person-moredetail"></div>';
            $res .= '<div class="person-relation"></div></div><br><div class="" style="padding-left:10px;"></div></li>';

            $ress .= '<div class="col-xs-12" style="background-color: #fff;margin: 5px 0px;height: 50px;">
						<div class="col-xs-3 noPadding" style="height: 50px;"><img  src="pics/group/' . $pic . '" class="person-avatar mCS_img_loaded" style="height: 50px;width: 50px;"></div>
						<div class="col-xs-9 text-align-right noPadding" style="line-height: 50px;"><a href="' . $link . '">' . $title . '</a></div>
					</div>';
            $i++;
        }
        $ress .= '</div></div></div>';
        $c = $ress . '</span> </div> ';
        return $f . $g . $c;
    }

    public function tinymce_url($html)
    {
        $res = str_replace('img src="tinymce' ,'img src="/tinymce',$html);
        return $res;
    }

// function Newusers() {
//        $res = '';
//        $Uscount = DB::table('users')->select('id')->count();
//        $Users = DB::table('user as u')->join('users as us', 'u.user_id', '=', 'us.id')->where('us.state', '1')->select('u.id', 'u.uname', 'u.Name', 'u.Family', 'u.Pic', 'u.Summary')->orderBy('id', 'desc')->take(4)->get();
//        $i = 1;
//        $j = 1;
//        $ress = ' <section class="container"><div class="wrapper wrapperx col-sm-11">
//                <div class="col-xs-12 col-sm-2 box-inf">
//                    <div class="member-count">
//                        <span class="count">
//                            <span>' . $Uscount . ' </span>
//                        </span>
//                        <span class="member"><a class="jsPanels" title="جستجوی اعضاء" href="modals/sociasearch?type=user">جستجو </a></span>
//                    </div>
//                </div><table class=" person-list GroupList row col-md-9">';
//        foreach ($Users as $UserS) {
//            $tid = $UserS->id;
//            $title = $UserS->Name . ' ' . $UserS->Family;
//            $title = wordwrap($title, 80, '<br/>', true);
//            $title1 = explode('<br/>', $title);
//            $title = (trim($title1[0]) != '' && strlen($title) > 80) ? $title1[0] . ' ...' : $title1[0];
//            $summary = $UserS->Summary;
//            $summary = wordwrap($summary, 100, '<br/>', true);
//            $summary1 = explode('<br/>', $summary);
//            $summary = (trim($summary1[0]) != '' && strlen($summary) > 100) ? $summary1[0] . ' ...' : $summary1[0];
//            $pic = (trim($UserS->Pic)) ? $UserS->Pic : 'Users.png';
//
//            if (($UserS->uname) != '')
//                $link = config('constants.SiteAddress') . "$UserS->uname";
//            else
//                $link = config('constants.SiteAddress') . "user/{$tid}";
//            if ($i == 1) {
//                $res .= '<tr>';
//            }
//            if ($i > 0 && $i < 3) {
//                $res.='<td style="width:50%;"><li  style="list-style:none !important; width: 90% !important;" class="col-sm-2"><img  src="pics/user/' . $pic . '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
//                $res.='<div class="close"></div><div class="person-name"><a href="' . $link . '">' . $title . '</a></div><div class="person-moredetail">' . $summary . '</div>';
//                $res.='<div class="person-relation"></div></div><br><div class="" style="padding-left:10px;"></div></li></td>';
//            }
//            if ($i == 3) {
//                $res .= '</tr><tr>'; //<td style="border: hidden;"><div id="' . $title . '" class="holder float"><a href="' . $link . '" target="_blank"><img src="pics/user/' . $pic . '"style="margin:1px 5px;float:right;border-radius: 50%; height:50px;width:50px;"/><span>' . $title . '</span>';
//            }
//            if ($i >= 3) {
//                $res.='<td><li  style="list-style:none !important; width: 90% !important;" class="col-sm-2"><img  src="pics/user/' . $pic . '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
//                $res.='<div class="close"></div><div class="person-name"><a href="' . $link . '">' . $title . '</a></div><div class="person-moredetail">' . $summary . '</div>';
//                $res.='<div class="person-relation"></div></div><br><div class="" style="padding-left:10px;"></div></li></td>';
//            }
//            if ($i > 4) {
//                $res .= '</tr>'; //<td style="border: hidden;"><div id="' . $title . '" class="holder float"><a href="' . $link . '" target="_blank"><img src="pics/user/' . $pic . '"style="margin:1px 5px;float:right;border-radius: 50%; height:50px;width:50px;"/><span>' . $title . '</span>';
//            }
//
//            $i++;
//        }
//        $f = $ress . $res . '</table></div></section>';
//
//
//
//        //$f.= $this->NewGroups();
//        return $f;
//    }

    private function thesaurus_tree($id = 0)
    {
        $Keys = DB::table('keywords AS k')
            ->join('keyword_relations as kr', 'kr.keyword_2_id', '=', 'k.id')
            ->select('k.title', 'k.id', 'kr.keyword_1_id', 'kr.keyword_2_id', 'k.morajah')
            ->whereRaw('kr.rel in(1,3,5)')
            ->where('kr.keyword_1_id', '=', $id)
            ->get();

        $defs = array();
        $array = (array)$Keys;
        $category_list2 = '';
        if ($Keys)
        {
            $PF = new PublicFunctions();
            $PF2 = $PF->CretaeTree1L($array, 'keyword_1_id', 'keyword_2_id', 'title');
            $PF2 = $PF->toUL($PF2);
        }
        $category_list = $PF2;
        return $category_list;
    }

    public function highlight($body, $uid = 0, $pid = 0)
    {
        if ($uid != 0)
        {
            if ($pid != 0)
            {
                $sr = "pid = '{$pid}' AND uid = '{$uid}'";
            }
            else
            {
                $sr = "pid = '0'";
            }
            $sql = "select id , quote , type , reg_date from highlights where (" . $sr . ") ";
            $h = DB::select(DB::raw($sql));
            $n = 0;
            foreach ($h as $value)
            {
                $n++;
                $quote[$value->id] = '' . $value->quote . '';
                $quotestyle[$value->id] = '<span class="highlight">' . $value->quote . '</span>';
            }
            if ($n > 0)
            {
                $body = str_replace($quote, $quotestyle, $body);
            }
            // dd($quote, $quotestyle, $body);
        }
        return $body;
    }










    static public function pages_list($html, $page = -1)
    {
        //return $html;
        $r = null;
        $result1 = null;
        $SPLIP_key = 'SPLIP';
        $preg_match = preg_match_all('/SPLIP_(.|[^SPLIP;]+)_SPLIP;/', $html, $matches, PREG_SET_ORDER);
        if ($preg_match)
        {
            foreach ($matches as $matche)
            {
                if (isset($matche[1]))
                {
                    $SPLIP = $matche[0];
                    $SPLIP_ed = $matche[1];
                    if ($SPLIP_ed)
                    {
                        $explode_ex = explode_ex('_', $SPLIP_ed);
                        @list ($types, $keywords, $admins, $count, $count_num, $all_links, $layout, $arrange, $order, $contents, $animates, $keywords_and_or) = @$explode_ex;
                        $types = explode_ex(',', $types);
                        $keywords = explode_ex(',', $keywords);
                        $admins = explode_ex(',', $admins);
                        $all_links = (bool) $all_links;
                        $contents = explode_ex(',', $contents);
                        $contents['image'] = array_shift($contents);
                        $contents['fields'] = array_shift($contents);
                        $contents['abstract'] = array_shift($contents);
                        $contents['date'] = array_shift($contents);
                        $subjects = Subject::whereIn('kind', $types)->whereHas('pages')->orderBy(1 == $arrange ? 'reg_date' : 'title', 1 == $order ? 'ASC' : 'DESC');
                        if ($keywords)
                        {
                            if ($keywords_and_or)
                            {
                                foreach ($keywords as $keyword)
                                {
                                    $subjects = $subjects->whereHas('keywords', function($q) use ($keyword)
                                    {
                                        $q->where('keywords.id', $keyword);
                                    });
                                }
                            } else
                            {
                                $subjects = $subjects->whereHas('keywords', function($q) use ($keywords)
                                {
                                    $q->whereIn('keywords.id', $keywords);
                                });
                            }
                        }
                        $subjects = $admins ? $subjects->whereIn('admin', $admins) : $subjects;
                        if (1 == $count)
                        {
                            $subjects = $subjects->get();
                        } elseif (2 == $count && $count_num)
                        {
                            if (-1 == $page)
                            {
                                $result1 = $subjects->count() - $count_num;
                                $subjects = $subjects->take($count_num)->get();
                            } else
                            {
                                $subjects = $subjects->paginate($count_num);
                                $subjects_array = $subjects->toArray();
                                $result1 = $subjects_array['total'] - ($subjects_array['current_page'] * $subjects_array['per_page']);
                                //if ($page >= $subjects_array['last_page']) { return '[:end:]'; };
                            }
                        } else
                        {
                            return $html;
                        }

                        if ($subjects)
                        {
                            $items = [];
                            foreach ($subjects as $subject)
                            {
                                $items[] = '<a href="' . url($subject->pages[0]->id) . '" target="_blank">' . trim($subject->title) . '</a>';
                            }
                            $is_showing_more = $all_links && -1 != $page;
                            $with = ['subjects' => $subjects, 'contents' => $contents, 'SPLIP' => $SPLIP, 'layout' => $layout, 'is_showing_more' => $is_showing_more, 'items' => $items, 'animates' => $animates, 'show_more' => $all_links, 'show_more_sign' => hash('crc32', $SPLIP . rand(100000, 999999)), 'more_count' => $result1, 'count_num' => $count_num];
                            switch (true)
                            {
                                case '1' == $layout:
                                {
                                    $r = view('modals.editor.pages-list-layout-1')->with($with);
                                    break;
                                }
                                case '2' == $layout && '0000' == implode(null, $contents):
                                {
                                    $r = view('modals.editor.pages-list-layout-2-ul')->with($with);
                                    break;
                                }
                                case '2' == $layout:
                                {
                                    $r = view('modals.editor.pages-list-layout-2')->with($with);
                                    break;
                                }
                                case '3' == $layout:
                                case '4' == $layout:
                                {
                                    $r = view('modals.editor.pages-list-layout-3')->with($with);
                                }
                            }
                            $include = view('modals.editor.pages-list-js')->with(['SPLIP' => $SPLIP])->render() . view('modals.editor.pages-list-css')->render();
                            $html = ($is_showing_more ? null : $include) . str_replace($SPLIP, $r, $html);
                        } else
                        {
                            return $html;
                        }
                    } else
                    {
                        return $html;
                    }
                } else
                {
                    return $html;
                }
            }
            return -1 == $page ? $html : [$html, $result1];
        } else
        {
            return $html;
        }
    }

}
