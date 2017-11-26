<?php

namespace App\HamafzaServiceClasses;

use Illuminate\Support\Facades\DB;

use App\HamafzaPublicClasses\FunctionsClass;

class PagesClass
{
    public function pageinsubject($id)
    {
        $Ret = DB::table('pages as p')->leftJoin('subjects as s', 's.id', '=', 'p.sid')->where('s.kind', $id)->where('s.archive', '0')->groupBy('p.sid')->select('s.id', 'p.id as pid', 's.title', 'p.edit_date')->get();
        $i = 1;
        foreach ($Ret as $value)
        {
            $value->sortid = $i;
            $value->edit_date = \Morilog\Jalali\jDate::forge($value->edit_date)->format('%Y/%m/%d');
            $i++;
        }

        return $Ret;
    }

    public function SubjectTabs($sid)
    {
        $page = DB::table('subjects as s')
            ->where('s.id', $sid)
            ->select('s.id', 's.title as Title', 's.kind')
            ->first();
        $Title = $page->Title;
        $sid = $page->id;
        $kind = $page->kind;

        $PageClass = new PageClass();
        $tabs = $PageClass->page_tabs($sid, $kind);
        $page->tabs = $tabs;
        return $page;
    }

    public static function pageView($type, $sid, $pid, $uid=-1)
    {
        // 0 : عدم نمایش
        //۱ : نمایش
        //۲ : نمایش محرمانه
        if ($type == 'view')
        {
            $admin = UserClass::permission('viewallpages', $uid);
            $view = 0;
            if (intval($sid) != 0)
            {
                $pc = new PageClass();
                $view = $pc->subjectView($sid);
                if ($view == 1 && intval($pid) != 0)
                {
                    $row = DB::table('pages as p')
                        ->leftJoin('subjects as s', 'p.sid', '=', 's.id')
                        ->select('p.view', 's.manager', 's.supporter', 's.supervisor', 's.ispublic')
                        ->where('p.id', $pid)
                        ->first();
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
        else
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
    }

    public static function PageDetail($pid, $ShType = '', $uid = 0, $hid = 0, $sesid = 0, $ContentType = '', $islocal)
    {
        $UC = new PageClass();
        $ISView = 1;
        $ISEdit = 0;
        $p = $UC->SubjectDetails($pid, 0);
        if (isset($p->id))
        {
            $sid = $p->id;
            $ISView = policy_CanView($sid, '\App\Models\hamafza\Subject', '\App\Policies\SubjectPolicy', 'canView'); //$UC->pageView($sid, $pid, $uid);
            $ISEdit = policy_CanView($sid, '\App\Models\hamafza\Subject', '\App\Policies\SubjectPolicy', 'canEdit');//$UC->pageEdit($sid, $pid, $uid);
        }
        else
        {
            return ($islocal == 'local') ? 'این صفحه موجود نیست' : FunctionsClass::JSON('این صفحه موجود نیست', true);
        }
        $PageClass = new PageClass();
        $page = DB::table('pages as p')
            ->join('subjects as s', 's.id', '=', 'p.sid')
            ->leftJoin('subject_type as sa', 's.kind', '=', 'sa.id')
            ->leftJoin('subject_type_tab as st', function ($join)
            {
                $join->on('s.kind', '=', 'st.stid');
                $join->on('p.type', '=', 'st.tid');
            })
            ->where('p.id', $pid)->select('s.ispublic', 'st.type as tabtype', 'sa.pretitle', 'p.viewslide', 'p.viewfilm', 'p.viewtext', 'p.defimage', 'p.showDefimg', 'p.id', 'p.sid', 'p.body', 'p.description', 'p.form', 'p.view', 'p.edit', 'p.ver_date', 's.title as Title', 's.kind', 's.archive', 'p.type as type')->first();
        $tabtypes = $page->tabtype;
        $subjectTypeTab =
            DB::table('subject_type_tab')
                ->where('stid', $page->kind)
                ->where('tid', $page->type)
                ->first();
        $pAGETabname = $subjectTypeTab->name;
        $first = 1;
        $pAGEtYPE = $subjectTypeTab->type;
        $thesarus = false;
        $tabtype = ($tabtypes == '20') ? true : false;
        if ($pAGEtYPE == '7')
        {
            if ($ContentType == 'OnlyTree')
            {
                $pc = new PageClass();
                $Trees = $pc->tree_bodyOnlyTree($pid);
                $Tree = $Trees['list'];
                $Body = $Trees['body'];
            }
            else
            {
                $pc = new PageClass();
                $Trees = $pc->tree_bodyOnlyList($pid);
                $Tree = $Trees['list'];
                $Body = $Trees['body'];
            }
        }
        else
        {
            $Body = $page->body;
            $Bodysss = $page->body;

            // $Body = $PageClass->bodyPara($Body);
            $Tree = $PageClass->bodyList($Body);
        }
        $pattern = "/<span class=\"ThesaurusCLS.*/";
        $array = array();
        if ($num1 = preg_match_all($pattern, $Body, $array))
        {
            $tabtype = true;
        }
        $IsPublic = $page->ispublic;
        $data['Alert'] = '';
        $data['IsPublic'] = $IsPublic;
        if ($IsPublic == '0')
        {
            $alert = DB::table('function_alert as f')
                ->join('alerts as a', 'a.id', '=', 'f.alertid')
                ->where('functionname', 'Ispublic')
                ->select('a.comment')
                ->first();
            $data['Alert'] = ($alert)?$alert->comment:'';
        }
        $Description = $page->description;
        $PreTitle = $page->pretitle;
        $Title = $PreTitle . ' ' . $page->Title;
        $sid = $page->sid;
        DB::table('subjects')->where('id', $sid)->increment('visit', 1);
        $defimage = $page->defimage;
        $showDefimg = $page->showDefimg;
        $viewtext = $page->viewtext;
        $viewslide = $page->viewslide;
        $viewfilm = $page->viewfilm;
        $kind = $page->kind;
        $archive = $page->archive;
        if ($first == '1')
        {
            $pFields = PageClass::page_field($pid, $sid, $kind);
        }
        else
        {
            $pFields = '';
        }
        $tabs = $PageClass->page_tabs($sid, $kind, $pid);
        $PClass = new PageClass();
        $Proccess = $PClass->Proccess($pid, $uid, $sesid, $sid);
        $keys = $PClass->PageKeywords($sid);
        $user = false;
        $data['id'] = $pid;
        $data['sid'] = $sid;
        if ($ShType != '1' && $ISView == 1)
        {
            $page = $PageClass->modifyText($Body, $uid, $pid, $sid, $tabtype);
            //   $page=$Body;
            $files = $PClass->page_files($pid);
            $slides = $PClass->page_slides($pid);
            $films = $PClass->page_films($pid);
            $page = $PageClass->bodyPara($page);

            $data['content'] = $page;
            $data['Tree'] = $Tree;
            $SR = new SubjectRelation();
            $Rel = $SR->Rel($pid, $sid, $Title);
            $data['Rel'] = $Rel;
            $data['Keywords'] = $keys;
            $data['Title'] = $Title;
            $data['Tabname'] = $pAGETabname;
            $data['tabs'] = $tabs;
            //$data['content'] = $PageClass->bodyPara( $data['content']);
        }
        elseif ($ShType != '1' && $ISView == 0)
        {
            $data['Tabname'] = '';
            $data['Title'] = 'عدم دسترسی به صفحه';
            $alert = DB::table('function_alert as f')
                ->join('alerts as a', 'a.id', '=', 'f.alertid')
                ->where('functionname', 'pageaccess')->select('a.comment')->first();
            if ($alert)
            {
                $data['content'] = $alert->comment;
            }
            else
            {
                $data['content'] = 'شما اجازه مشاهده این صفحه را ندارید';
            }
            $data['Tree'] = '';
            $data['Rel'] = array();
            $files = array();
            $slides = array();
            $films = array();
            $data['Keywords'] = array();
            $data['tabs'] = array();
        }
        if ($ShType == '1')
        {
            if ($ISEdit == 1)
            {
                $data['Tree'] = $Tree;
                $files = $PClass->page_files($pid);
                $slides = $PClass->page_slides($pid);
                $films = $PClass->page_films($pid);
                $data['Rel'] = array();
                $data['Keywords'] = $keys;
                $data['Title'] = $Title;
                $data['Tabname'] = $pAGETabname;
                $data['tabs'] = $tabs;
                $data['Body'] = $Body;
                $edit_det = PageClass::PreEditPage($uid, $pid);
                if ($edit_det)
                {
                    $data['editing'] = $edit_det->editing;
                    $data['last_date'] = $edit_det->last_date;
                    $data['editUfamily'] = $edit_det->editUfamily;
                    $data['editUname'] = $edit_det->editUname;
                }
            }
            else
            {
                $data['Body'] = 'EditNOK';
                return $data;
            }
        }
        if ($hid != '0')
        {
            $s = DB::table('history as h')
                ->leftjoin('edit_com as e', 'h.edit', '=', 'e.id')
                ->leftjoin('user as u', 'h.admin', '=', 'u.id')
                ->where('h.id', $hid)
                ->select('h.id', 'h.body', 'h.admin', 'h.part', 'h.edit', 'h.active', 'h.com', 'h.edit_date', 'e.name', 'u.Name', 'u.Family')
                ->first();
            if ($s)
            {
                $idt = \Morilog\Jalali\jDate::forge($s->edit_date)->format('H:i:s %Y/%m/%d ');
                $data['content'] = $PageClass->modifyText($s->body, $uid, $pid, $sid, $tabtype);
                $data['Alert'] = 'تاریخچه: ویرایش شده توسط:' . $s->Name . ' ' . $s->Family . ' در تاریخ: ' . $idt;
            }
        }
        $data['Description'] = $Description;
        $data['archive'] = $archive;
        $data['defimage'] = $defimage;
        $data['showDefimg'] = $showDefimg;
        $data['Type'] = $pAGEtYPE;
        $data['Proccess'] = $Proccess;
        $data['viewtext'] = $viewtext;
        $data['viewslide'] = $viewslide;
        $data['viewfilm'] = $viewfilm;
        $data['Files'] = $files;
        $data['Slides'] = $slides;
        $data['Films'] = $films;
        $data['Fields'] = $pFields;
        $data['Thesarus'] = $thesarus;
        return $data;
        //$data['content'] = $PageClass->bodyPara( $data['content']);
        return FunctionsClass::JSON($data, false);
    }

    public static function page_tools($sid, $pid = 0, $uid, $subtype = 'subject', $session_id, $islocal)
    {
        $help = '';
        $tabname = '';
        if ($islocal)
        {
            $user = 'true';
        }
        else
        {
            $user = UserClass::CheckLogin($uid, $session_id);
        }
        $user = ($user == TRUE) ? 'true' : 'false';
        if ($subtype == 'subject')
        {
            $help = array();
            $helps = DB::table('pages')->where('id', $pid)->select('help_pid', 'help_tag')->first();
            $typehelp = DB::table('subject_type_tab AS stt')->join('subjects AS s', 's.kind', '=', 'stt.stid')->where('s.id', $sid)->select('help_pid', 'help_tag')->first();
            if ($helps && $helps->help_pid != '' && $helps->help_pid != '0')
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
                if ($typehelp && $typehelp->help_pid != '' && $typehelp->help_pid != '0')
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
            $Admin = PagesClass::ISManagerPage($sid, $uid);
            $edit = PagesClass::allowEdit($pid, $uid);
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
        return $Ret;

    }

    public static function ISManagerPage($sid, $uid)
    {
        $s = DB::table('subjects')
            ->select('manager', 'supporter', 'supervisor', 'admin')
            ->where('id', $sid)->first();
        if ($s && ($s->manager == $uid || $s->supporter == $uid || $s->supervisor == $uid || $s->admin == $uid))
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
}
