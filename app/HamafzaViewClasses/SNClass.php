<?php

namespace App\HamafzaViewClasses;

use App\HamafzaViewClasses\PublicClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\HamafzaViewClasses\PageClass;
use App\HamafzaViewClasses\KeywordClass;
use App\HamafzaServiceClasses\UserClass;
use App\HamafzaPublicClasses\FunctionsClass;
use App\HamafzaServiceClasses\PostsClass;
use App\HamafzaViewClasses\SubjectClass;
use App\HamafzaViewClasses\UsersClass;
use Auth;

class SNClass
{


    public static function SelectDesktop($name, $param, $sublink)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = Auth::id();
            $users = DB::table('user')->where('Uname', $name)->select('id')->first();
            if ($users && ($uid != $users->id))
            {
                $Tree = '';
                $PC = new PublicClass();
                $menu = $PC->GetSiteMenu();
                $SiteTitle = config('constants.SiteTitle');
                $SiteLogo = config('constants.SiteLogo');
                $uids = $uid;
                $UC = new UserClass();
                $user_data = $UC->About($uids, $uid, 'local');
                $us = $user_data['preview'];
                $tools = '';
                $tabs = $user_data['Tabs'];
                $tools = SNClass::Tools($uid, 0, '', '', 'desktop');
                $MenuTools = $tools['other'];
                $shortTools = $tools['abzar'];
                $PageType = 'desktop';
                $MyOrganGroups = '';
                if (session('MyOrganGroups'))
                {
                    $MyOrganGroups = session('MyOrganGroups');
                }
                $c = 'دسترسی به این قسمت مقدور نمی باشد';
                $Portals = PageClass::GetProtals($uids, 0);
                $keywordTab = KeywordClass::GetPublicKeyword(0, $uid);
                $MenuTools = json_encode($MenuTools);
                $MenuTools = json_decode($MenuTools);
                return view('pages.user_desktop_dashboard', array('MyOrganGroups' => $MyOrganGroups, 'PageType' => $PageType, 'SiteLogo' => $SiteLogo, 'SiteTitle' => $SiteTitle, 'Title' => $us['Name'] . ' ' . $us['Family'], 'Small' => $us['id'], 'sid' => $uid,
                    'Portals' => $Portals, 'keywordTab' => $keywordTab, 'uname' => $name, 'pid' => 'desktop', 'menu' => $menu, 'content' => $c, 'Files' => '', 'keywords' => '', 'tabs' => $tabs, 'Tree' => $Tree, 'tools' => $shortTools, 'menutools' => $MenuTools));
            }

            $uid = Auth::id();
            $Tree = DesktopClass::DeskTopTree($uid, 0, '', '');
            $sesid = 0;
            switch ($param)
            {
                /*case 'Task':
                    $SN = new TaskClass();
                    return $SN->ShowTask($name, $uid, $Tree);
                    break;*/
                /*case 'user_measures_ME':
                    $sel = (isset($_GET['sel']) && $_GET['sel'] != '') ? $_GET['sel'] : '';
                    $con = Measure::SelectType($name, 'ME', $Tree, $sel);
                    return $con;
                    break;*/
                /*case 'user_measures_BC':
                    $con = Measure::SelectType($name, 'BC', $Tree);
                    return $con;
                    break;*/
                /*case 'user_measures_Fme':
                    $con = Measure::SelectType($name, 'Fme', $Tree);
                    return $con;
                    break;*/
                /*case 'user_measures_MeDrafts':
                    $con = Measure::SelectType($name, 'MeDrafts', $Tree);
                    return $con;
                    break;*/
                /*case 'user_measures_ALL':
                    $con = Measure::SelectType($name, 'ALL', $Tree);
                    return $con;
                    break;*/
                /*case 'user_proccess':
                    $con = Proccess::showProcDesk($name, $uid, $sesid, $Tree, $sublink);
                    return $con;
                    break;*/

                case 'thesarus':
                    $con = KeywordClass::Thesarus($name, $uid, $sesid, $Tree, $sublink);
                    return $con;
                    break;
                /*case 'process_list':
                    $con = ProccessClass::SelectType($name, '', $Tree, $sublink);
                    return $con;*/

                case 'ticket_list':
                    $con = Message::Conversation($name, $uid, $sesid, $Tree);
                    return $con;
                    break;

                case 'subject_type_list':
                    $con = FieldClass::SubjectType($name, $uid, $sesid, '', $Tree, $sublink);
                    return $con;
                    break;
                case 'user_security':
                    return UsersClass::GetUserSecurity($name, $uid, $sesid, '', $Tree, $sublink);
                    break;
                case 'Circle':
                    $con = RelationClass::Manager($name, $uid, $sesid, '', $Tree, $sublink, 'Circle');
                    return $con;
                    break;
                case 'InCircle':
                    $con = RelationClass::Manager($name, $uid, $sesid, '', $Tree, '', 'InCircle');
                    return $con;
                    break;
                case 'Group':
                    $con = RelationClass::Manager($name, $uid, $sesid, '', $Tree, $sublink, 'Group');
                    return $con;
                    break;
                case 'InGroup':
                    $con = RelationClass::Manager($name, $uid, $sesid, '', $Tree, $sublink, 'InGroup');
                    return $con;
                    break;
                case 'Organ':
                    $con = RelationClass::Manager($name, $uid, $sesid, '', $Tree, $sublink, 'OrganMyadmin');
                    return $con;
                    break;
                case 'Organs':
                    $con = RelationClass::Manager($name, $uid, $sesid, '', $Tree, 'In', 'OrganMyadmin');
                    return $con;
                    break;
                case 'Groups':
                    $con = RelationClass::Manager($name, $uid, $sesid, '', $Tree, 'In', 'Groups');
                    return $con;
                    break;
                case 'Group_MyAdmin':
                    $con = RelationClass::Manager($name, $uid, $sesid, '', $Tree, 'In', 'Group_MyAdmin');
                    return $con;
                    break;
                case 'Group_IN':
                    $con = RelationClass::Manager($name, $uid, $sesid, '', $Tree, 'In', 'Group_IN');
                    return $con;
                    break;
                case 'Circles':
                    $con = RelationClass::Manager($name, $uid, $sesid, '', $Tree, 'In', 'Circles');
                    return $con;
                    break;
                case 'followed':
                    $con = RelationClass::Manager($name, $uid, $sesid, '', $Tree, 'In', 'followed');
                    return $con;
                    break;
                case 'Pfollowed2':
                    $con = RelationClass::Manager($name, $uid, $sesid, '', $Tree, 'In', 'Pfollowed');
                    return $con;
                    break;
                case 'Pfollowed':
                    $con = RelationClass::Manager($name, $uid, $sesid, '', $Tree, 'In', 'Pfollowed');
                    return $con;
                    break;
                case 'Gfollowed2':
                    $con = RelationClass::Manager($name, $uid, $sesid, '', $Tree, 'In', 'Gfollowed');
                    return $con;
                    break;
                case 'Gfollowed':
                    $con = RelationClass::Manager($name, $uid, $sesid, '', $Tree, 'In', 'Gfollowed');
                    return $con;
                    break;
                case 'Ofollowed':
                    $con = RelationClass::Manager($name, $uid, $sesid, '', $Tree, 'In', 'Ofollowed');
                    return $con;
                    break;
                case 'Ofollowed2':
                    $con = RelationClass::Manager($name, $uid, $sesid, '', $Tree, 'In', 'Ofollowed');
                    return $con;
                    break;
                case 'mefollow':
                    $con = RelationClass::Manager($name, $uid, $sesid, '', $Tree, 'In', 'mefollow');
                    return $con;
                    break;
                default:
                    return "";
            }
        }
    }

    public function DefDesktop($uname)
    {
        $uid = Auth::id();
        $Tree = DesktopClass::DeskTopTree($uid, 0, '', '');
        $content = DesktopClass::DefDesktop($uname, $Tree, $uid);
        return $content;
    }

    public function UserWall($uname, $new = false)
    {
        $sesid = 0;
        $cuid = Auth::id();
        $uids = FunctionsClass::UserName2id($uname);
        $PageType = 'user';
        $SP = new UserClass();
        $user_data = $SP->GetMyWall($uname, 0, $cuid, 'local');
        $us = $user_data['preview'];
        $uid = $us['id'];
        $content2 = json_encode($user_data['Posts']);
        $content2 = json_decode($content2);
        $alert = '';
        if ($new)
        {
            $alerts = DB::table('function_alert as f')->join('alerts as a', 'a.id', '=', 'f.alertid')->where("functionname", 'Userwall')->select('a.comment')->first();
            if ($alerts)
            {
                $alert = $alerts->comment;
            }
        }
        if ($cuid == 0)
        {
            $content2 = '';
            $alerts = DB::table('function_alert as f')->join('alerts as a', 'a.id', '=', 'f.alertid')->where("functionname", 'wallwithoulogin')->select('a.comment')->first();
            if ($alerts)
            {
                $alert = $alerts->comment;
            }
        }
        $PageTypes = 'userwall';
        return
            [
                'Uname' => $uname,
                'PageTypes' => $PageTypes,
                'PageType' => $PageType,
                'sid' => $uid,
                'Small' => $uid,
                'sesid' => $sesid,
                'sid' => $uid,
                'pid' => 'wall',
                'alert' => $alert,
                'content' => $content2
            ];
    }

    public function UserContents($uname)
    {
        $sesid = 0;
        $cuid = Auth::id();
        $uids = FunctionsClass::UserName2id($uname);
        $PS = new PostsClass();
        $json_a = $PS->UserContent($uids, $cuid, 'local');
        $us = $json_a['preview'];
        $uid = $us['id'];
        $content20 = json_encode($json_a['Posts']);
        $content2 = json_decode($content20);
        if (!is_array($content2))
        {
            $content2 = json_decode($content20, true);
        }
        $PageType = 'user';
        $RightCol = RightCol($uid, 'userwall');
        $PageTypes = 'contents';
        return [
            'PageTypes' => $PageTypes,
            'Uname' => $uname,
            'PageType' => $PageType,
            'Small' => $uid,
            'sesid' => $sesid,
            'sid' => $uid,
            'RightCol' => $RightCol,
            'pid' => 'contents',
            'content' => $content2
        ];
    }

    public function AboutUser($username)
    {
        $user = \App\User::where('Uname',$username)->firstOrFail();
        $uid = Auth::id();
        $PC = new PublicClass();
        $Ostan = json_encode(FunctionsClass::Ostan());
        $uids = FunctionsClass::UserName2id($username);
        $UC = new UserClass();
        $user_data = $UC->About($uids, $uid, 'local');
        $alert = '';
        if (session('NewUser') == 'NewUser')
        {
            $alerts = DB::table('function_alert as f')
                ->join('alerts as a', 'a.id', '=', 'f.alertid')
                ->where("functionname", 'Abouuser')
                ->select('a.comment')->first();
            if ($alerts)
            {
                $alert = $alerts->comment;
            }
            session(['NewUser' => '']);
        }
        $menusA = array();
        $i = 1;
        foreach ($user_data as $value)
        {
            if ($i > 1 && $i < 13 && array_key_exists("1", $value) && is_array($value[1]) && count($value[1]) > 0)
            {
                if ($value[0] != 'کلید واژه ه')
                {
                    $menuA['parent'] = '#';
                    $menuA['url'] = '#ss';
                    $menuA['text'] = $value[0];
                    $menuA['id'] = '#' . $menuA['text'];
                    array_push($menusA, $menuA);
                }
            }
            $i++;
        }
        $menus = json_encode($menusA);
        $menus = str_replace("[", "", $menus);
        $menus = str_replace("]", "", $menus);
        $Keywords = $user_data['user_keywords'][1];

        $us = $user_data['preview'];
        $Ab = '';
        $usp = $user_data['user_special'];

        $usw = $user_data['user_work'];
        // $Ab .= $this->AboutUW($usw);

        $use = $user_data['user_education'];
        //$Ab .= $this->AboutUE($use);

        $use = $user_data['user_Publications'];
        $Ab .= $this->AboutUPub($use, $uids, $uid);

        $use = $user_data['user_groupadmin'];
        $Ab .= $this->AboutUGA($use);

        $use = $user_data['user_INgroup'];
        $Ab .= $this->AboutInG($use);
        $tools = '';


        return
            [
                'Alert' => $alert,
                'uids' => $uids,
                'uid' => $uid,
                'user_education' => $user_data['user_education'],
                'Ostan' => $Ostan,
                'user_work' => $user_data['user_work'],
                'user_special' => $user_data['user_special'],
                'specials' => $user->specials,
                'preview' => $user_data['preview'],
                'PageType' => 'aboutuser',
                'pid' => 'intro',
                'content' => $Ab
            ];
    }

    public static function usersetting($id)
    {
        return view('modals.user_setting');
    }

    public static function Seluser($type)
    {
        $uid = '0';
        $sesid = '0';
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
        $SP = new UserClass();
        $s = $SP->SelUser($uid, $sesid);
        $Tree = $s['Tree'];
        if (is_array($Tree))
        {
            $PC = new PublicClass();
            $newtree = $PC->CretaeTree1L($Tree, 'id', 'parent_id', 'title');
            $newtree = $PC->Json(0, $newtree);
        }
        else
        {
            $newtree = '';
        }

        $Groups = $s['Groups'];
        $Groups = json_encode($Groups, true);
        // $Groups = json_decode($Groups);

        $Organs = $s['Organs'];
        // $Organs = json_encode($Organs, true);
        //      $Organs = json_decode($Organs);

        $Circles = $s['Circles'];
        //$Circles = json_encode($Circles, true);
        //       $Circles = json_decode($Circles);

        $Allusers = $s['Allusers'];
        // $Allusers = json_encode($Allusers, true);
        //                $Allusers = json_decode($Allusers);

        return view('modals.seluser', array('Tree' => $newtree, 'Type' => $type, 'Groups' => $Groups, 'Organs' => $Organs, 'Circles' => $Circles, 'Allusers' => $Allusers));
    }

    public function IsUoG($name)
    {
        $SP = new service();
        $name = $SP->ServicePost('IsUoG', 'name=' . $name);
        $json_a = json_decode($name, true);
        $s = $json_a['data'];
        return $s;
    }

    private function AboutU($user)
    {
        //$user_alert = '<script type="text/javascript" src="'.App::make('url')->to('/').'/theme/Scripts/user_edit.js"></script>';
        $user_alert = '';
        $user_alert .= '<div class="gkCode10" style="  margin: 10px;">'
            . '<div style="max-width:170px; display:inline-block; vertical-align:top" ><img src="' . $user['Pic'] . '" style="width:100px; height: 100px; margin:0 10px;float:right;border-radius: 50%; border: 1px solid #CCCCCC;background: #FFF;padding: 2px; "  /></div>'
            . '<div style="max-width:760px; display:inline-block; vertical-align:top">'
            . '<h1>' . $user['Name'] . ' ' . $user['Family'] . '</h1>'
            . $user['Summary'] . '<br>'
            . $user['Email'] . '<br>'
            . $user['Mobile'] . '</div>'
            . '<div style="padding: 10px"></div></div>';

        return $user_alert;
    }

    private function EditUP($id, $title, $com)
    {
        $user_p = '<div id="EditUP_' . $id . '" class="editDiv"><table class="table-striped"><tr><td>عنوان</td><td><input  type="text" value="' . $title . '" class="required form-control"  id="EditUP_title_' . $id . '" ></td></tr><tr><td>توضیح</td><td><textarea class="form-control"  id="EditUP_comment_' . $id . '" name="comment" id="EditUP_comment_' . $id . '">' . $com . '</textarea></td></tr><tr><td></td><td><span class="FloatLeft"><input type="button" class="btn btn-primary EditUPOK" editid="' . $id . '" value="تایید"><input type="button" class="btn btn-primary closeBut" value="لغو"></td></tr></table></div>';
        return $user_p;
    }

    private function AboutUP($user, $uids, $uid)
    {
        $user_p = '';
        if (is_array($user[1]))
        {
            $title = $user[0];
            if ($uids == $uid)
            {
                $title .= '<span style="padding-left: 20px;" class="FloatLeft IconHeight" ><span class="icon-hazv icon-plus EditUP"  val="EditUP_0"></span></span>';
            }
            $user_p .= '<div class="total"><h1 class="heading" id="b4">
                                <span class="icon icon-open"></span><a id="specials">' . $title . '</a></h1>';
            $user_p .= '<div class="inner"><table style="width:100%">';
            $i = 1;
            foreach ($user[1] as $value)
            {
                if ($value['comment'] != '')
                {
                    $comment = $value['comment'];
                }
                else
                {
                    $comment = '';
                }
                if ($uids == $uid)
                {
                    $user_p .= '<tr><td><h2 style="display:inline-block;padding:0;width:100%;">' . $i . '- ' . $value->name . '</h2></td><td><span class="FloatLeft IconHeight" ><span class="icon-hazv Dellicon iconEdit" val="' . $value->id . '"></span><span  class="icon-pencil-1 iconEdit  EditUP" val="EditUP_' . $value->id . '"></span></span></td><tr><td colspan="2">' . $comment;
                    $user_p .= $this->EditUP($value->id, $value->name, $value['comment']) . '</td></tr>';
                }
                else
                {
                    $user_p .= '<tr><td colspan="2"><h2 style="display:inline-block;padding:0;width:100%;">' . $i . '- ' . $value->name . '</h2><br><td></tr><tr><td colspan="2"><span>' . $comment . '</span></td></tr>';
                }
                $i++;
                // $user_p .= '</div>';
            }
//

            $user_p .= '</table>';
            if ($uids == $uid)
            {
                $user_p .= $this->EditUP(0, '', '');
            }
            $user_p .= ' </div>';
        }
        return $user_p;
    }

    private function AboutUW($user)
    {
        $user_p = '';
        if (is_array($user[1]))
        {
            $user_p .= '<div class="total"><h1 class="heading" id="b4">
                                <span class="icon icon-open"></span><a id="specials">' . $user[0] . '</a></h1>
                                <div class="inner"><div>';
            $i = 1;
            foreach ($user[1] as $value)
            {
                if ($value['comment'] != '')
                {
                    $comment = '<br>' . $value['comment'];
                }
                else
                {
                    $comment = '';
                }
                $user_p .= '<h2 style="display:inline-block;padding:0;">' . $i . '- ' . $value['post'] . '</h2>؛ ' . $value['company'] . ' ؛ ' . $value['s_year'] . ' - ' . $value['e_year'] . $comment . '<br>';
                $i++;
            }
            $user_p .= '</div></div>';
        }
        return $user_p;
    }

    private function AboutUE($user)
    {
        $user_p = '';
        if (is_array($user[1]))
        {
            $user_p .= '<div class="total"><h1 class="heading" id="b4">
                                <span class="icon icon-open"></span><a id="specials">' . $user[0] . '</a></h1>
                                <div class="inner"><div>';
            $i = 1;
            foreach ($user[1] as $value)
            {
                if ($value['comment'] != '')
                {
                    $comment = '<br>' . $value['comment'];
                }
                else
                {
                    $comment = '';
                }
                switch ($value['level'])
                {
                    case '1':
                        $grade = "دیپلم";
                        break;
                    case '2':
                        $grade = "فوق دیپلم";
                        break;
                    case '3':
                        $grade = "کارشناسی";
                        break;
                    case '4':
                        $grade = "کارشناسی ارشد";
                        break;
                    case '5':
                        $grade = "دکتری";
                        break;
                    case '6':
                        $grade = "فوق دکتری";
                        break;
                }
                $trend = '';
                if ($value['trend'] != '')
                {
                    $trend = $value['trend'] . ' ؛ ';
                }

                $e_year = $value['e_year'];
                if ($e_year == '1')
                {
                    $e_year = 'ادامه دارد';
                }
                $user_p .= '<h2 style="display:inline-block;padding:0;">' . $i . '- ' . $value['location'] . '</h2>؛ ' . $trend . $grade . ' ؛ ' . $value['university'] . ' ؛ ' . $value['s_year'] . ' - ' . $e_year . $comment . '<br>';
                $i++;
            }
            $user_p .= '</div></div>';
        }
        return $user_p;
    }

    private function AboutUGA($user)
    {
        $user_p = '';
        if (is_array($user[1]) && count($user[1]) > 0)
        {
            $user_p .= '<div class="total"><h1 class="heading" id="' . $user[0] . '">
                                <span class="icon icon-open"></span><a id="specials">' . $user[0] . '</a></h1>
                                <div class="inner"><div>';
            $i = 0;
            $res = '';
            foreach ($user[1] as $value)
            {
                $pic = $value->pic;
                if ($pic != '' && file_exists('pics/group/' . $pic))
                {
                    $pic = 'pics/group/' . $pic;
                }
                elseif ($pic != '' && file_exists('pics/group/' . $value->id . '-' . $pic))
                {
                    $pic = 'pics/group/' . $value->id . '-' . $pic;
                }
                else
                {
                    $pic = 'pics/group/Groups.png';
                }
                if ($i % 2 == 0)
                {
                    $res .= '<tr style="border:none;"><td style="border: hidden;width:50%"><div id="Group_' . $value->id . '" class="holder float"><a href="' . $value->link . '" target="_blank"><img src="' . $pic . '"style="margin:1px 5px;float:right;border-radius: 50%; height:50px;width:50px;"/><span>' . $value->name . '</span>';
                    $res .= '<br/><span>' . $value->summary . '</span></a></div></td>';
                }
                else
                {
                    if ($i % 2 == 1)
                    {
                        $res .= '<td style="border: hidden;"><div id="' . $value->name . '" class="holder float"><a href="' . $value->link . '" target="_blank"><img src="' . $pic . '"style="margin:1px 5px;float:right;border-radius: 50%; height:50px;width:50px;"/><span>' . $value->name . '</span>';
                        $res .= '<br/><span>' . $value->summary . '</span></a></div></td></tr>';
                    }
                }
                $i++;
            }
            if ($res != '')
            {
                $res = '<table class="tblBorderLessFree" style="width:100%">' . $res . '</table>';
            }
            $user_p .= $res . '</div></div></div>';
        }
        return $user_p;
    }

    private function AboutInG($user)
    {
        $user_p = '';
        if (is_array($user[1]) && count($user[1]) > 0)
        {
            $user_p .= '<div class="total"><h1 class="heading" id="' . $user[0] . '">
                                <span class="icon icon-open"></span><a id="specials">' . $user[0] . '</a></h1>
                                <div class="inner"><div>';
            $i = 0;
            $res = '';
            foreach ($user[1] as $value)
            {
                $pic = $value->pic;
                if ($pic != '' && file_exists('pics/group/' . $pic))
                {
                    $pic = 'pics/group/' . $pic;
                }
                elseif ($pic != '' && file_exists('pics/group/' . $value->id . '-' . $pic))
                {
                    $pic = 'pics/group/' . $value->id . '-' . $pic;
                }
                else
                {
                    $pic = 'pics/group/Groups.png';
                }
                //  $pic = (trim($pic) != '' && file_exists($pic)) ? $pic : 'pics/group/Groups.png';
                if ($i % 2 == 0)
                {
                    $res .= '<tr style="border:none;"><td style="border: hidden;width:50%"><div id="Group_' . $value->id . '" class="holder float"><a href="' . $value->link . '" target="_blank"><img src="' . $pic . '"style="margin:1px 5px;float:right;border-radius: 50%; height:50px;width:50px;"/><span>' . $value->name . '</span>';
                    $res .= '</a></div></td>';
                }
                else
                {
                    if ($i % 2 == 1)
                    {
                        $res .= '<td style="border: hidden;"><div id="' . $value->name . '" class="holder float"><a href="' . $value->link . '" target="_blank"><img src="' . $pic . '"style="margin:1px 5px;float:right;border-radius: 50%; height:50px;width:50px;"/><span>' . $value->name . '</span>';
                        $res .= '</a></div></td></tr>';
                    }
                }
                $i++;
            }
            if ($res != '')
            {
                $res = '<table class="tblBorderLessFree" style="width:100%">' . $res . '</table>';
            }

            $user_p .= $res . '</div></div></div>';
        }
        return $user_p;
    }

    private function AboutUPub($user, $uid, $cuid)
    {
        if ($cuid == $uid || (is_array($user[1]) && count($user[1]) > 0))
        {
            $user_p = '';
            $user_p .= '<div class="total"><h1 class="heading"  id="' . $user[0] . '" style="height: 10px;">
                                <span class="icon icon-open"></span><a id="specials">' . $user[0] . '</a>';
            if ($cuid == $uid)
            {
                $user_p .= '<a href="modals/newsubject" title=" صفحه جدید" class="jsPanels"> <span targetid="0" class="icon-hazv icon-plus "></span></a>';
            }
            $user_p .= '</h1>
                                <div class="inner"><div>';
            if (is_array($user[1]) && count($user[1]) > 0)
            {

                $i = 1;
                foreach ($user[1] as $value)
                {
                    $user_p .= '<label style="display:inline-block;padding:0;">' . $i . '- <a target="_blank" href="' . $value->pid . '">' . $value->title . '</a></label><br>';
                    $i++;
                }
            }

            $user_p .= '</div></div><p></p>';
            return $user_p;
        }
    }

    public function User_Wall($uname, $new = false)
    {
        $uid = session('uid');
        $sesid = session('SessionID');
        $cuid = (session('uid') != '') ? $uid : 0;
        $uid = $cuid;
        $sesid = (session('SessionID') != '') ? $sesid : 0;
        $PC = new PublicClass();
        $menu = $PC->GetSiteMenu();
        $SiteTitle = config('constants.SiteTitle');
        $SiteLogo = config('constants.SiteLogo');
        $SP = new service();
        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $PageType = 'user';

        $PgC = new PageClass();
        $RightCol = $PgC->GetRightCol($cuid, $sesid, $cuid, 'userwall');


        $SP = new service();
        // echo 'GetWall'. 'uname=' . $uname . '&cuid=' . $cuid;
        $name = $SP->ServicePost('GetWall', 'uname=' . $uname . '&cuid=' . $cuid);
        $json_a = json_decode($name, true);
        $user_data = $json_a['posts'];
        $tools = $this->Tools($uid, $sesid, '', '', 'wall');
        $MenuTools = $tools['other'];
        $shortTools = $tools['abzar'];
        $us = $user_data['preview'];

        $title = $us['Name'] . ' ' . $us['Family'];
        $uid = $us['id'];
        $tabs = $user_data['Tabs'];
        $content2 = $user_data['Posts'];
        $Portals = PageClass::GetProtals($uid, $sesid);
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        $alert = '';
        if ($new)
        {
            $alerts = DB::table('function_alert as f')->join('alerts as a', 'a.id', '=', 'f.alertid')->where("functionname", 'Userwall')->select('a.comment')->first();
            if ($alerts)
            {
                $alert = $alerts->comment;
            }
        }

        if ($cuid == 0)
        {
            $content2 = '';
            $alerts = DB::table('function_alert as f')->join('alerts as a', 'a.id', '=', 'f.alertid')->where("functionname", 'wallwithoulogin')->select('a.comment')->first();
            if ($alerts)
            {
                $alert = $alerts->comment;
            }
        }
        $PageTypes = 'userwall';
        return view('pages.contents', array('Uname' => $uname, 'PageTypes' => $PageTypes, 'keywords' => '', 'RightCol' => $RightCol, 'PageType' => $PageType, 'sid' => $uid, 'MyOrganGroups' => $MyOrganGroups, 'SiteLogo' => $SiteLogo, 'SiteTitle' => $SiteTitle, 'Title' => $title, 'Small' => $uid, 'sesid' => $sesid, 'sid' => $uid,
            'Portals' => $Portals, 'keywordTab' => $keywordTab, 'pid' => 'wall', 'alert' => $alert, 'menu' => $menu, 'content' => $content2, 'tabs' => $tabs, 'Tree' => '', 'tools' => $shortTools, 'menutools' => $MenuTools));
    }

    public function User_Contents($uname)
    {
        $uid = session('uid');
        $sesid = session('SessionID');
        $cuid = (session('uid') != '' && session('uid') != '') ? $uid : 0;
        $sesid = (session('SessionID') != '' && session('SessionID') != '') ? $sesid : 0;
        $uid = $cuid;
        $SP = new service();

        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $PC = new PublicClass();
        $menu = $PC->GetSiteMenu();
        $SiteTitle = config('constants.SiteTitle');
        $SiteLogo = config('constants.SiteLogo');
        //echo 'GetUserContent'. 'uname=' . $uname . '&cuid=' . $cuid;
        $name = $SP->ServicePost('GetUserContent', 'uname=' . $uname . '&cuid=' . $cuid);
        $json_a = json_decode($name, true);
        $user_data = $json_a['posts'];
        $us = $user_data['preview'];
        $title = $us['Name'] . ' ' . $us['Family'];
        $uid = $us['id'];
        $tabs = $user_data['Tabs'];
        $content2 = $user_data['Posts'];
        $tools = '';
        $Portals = PageClass::GetProtals($uid, $sesid);
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        $tools = $this->Tools($uid, $sesid, 'user', '', 'contents');
        $MenuTools = $tools['other'];
        $shortTools = $tools['abzar'];
        $PageType = 'user';
        $PgC = new PageClass();
        $RightCol = $PgC->GetRightCol($cuid, $sesid, $cuid, 'userwall');
        //return $RightCol;
        $PageTypes = 'contents';
        return view('pages.contents', array('PageTypes' => $PageTypes, 'Uname' => $uname, 'keywords' => '', 'PageType' => $PageType, 'MyOrganGroups' => $MyOrganGroups, 'SiteLogo' => $SiteLogo, 'SiteTitle' => $SiteTitle, 'Title' => $title, 'Small' => $uid, 'sesid' => $sesid, 'sid' => $uid,
            'Portals' => $Portals, 'RightCol' => $RightCol, 'keywordTab' => $keywordTab, 'pid' => 'contents', 'menu' => $menu, 'content' => $content2, 'tabs' => $tabs, 'Tree' => '', 'tools' => $shortTools, 'menutools' => $MenuTools));
    }

    public static function Page_Wall($sid)
    {
        $uid = session('uid');
        $sesid = session('SessionID');
        $cuid = (session('uid') != '') ? $uid : 0;
        $sesid = (session('SessionID') != '') ? $sesid : 0;
        $uid = $cuid;
        $SP = new service();
//echo 'SubjectWall'. 'sid=' . $sid . '&uid=' . $uid . '&sesid=' . $sesid;
        $menu = $SP->ServicePost('SubjectWall', 'sid=' . $sid . '&uid=' . $uid . '&sesid=' . $sesid);
        $json_a = json_decode($menu, true);
        $MyOrganGroups = $json_a['data'];
        return $MyOrganGroups;
    }

    public static function Tools($sesid, $uid, $userid, $type, $helptype)
    {

        $UC = new UserClass();
        $res = '<div class="btn-group pull-right frst-wdt mr"><button type="button" id="rSubMenuBtn" class="btn  fa fa-align-justify icon-reorder" data-icon="U+E0CC" data-toggle="tooltip" data-placement="top" title="ابزارها"></button></div>';
        $type = 'userpage';
        if ($uid == $userid)
        {
            $type = 'user-my';
        }
        $s = $UC->user_tools($sesid, $uid, $userid, $type, $helptype, 'local');
        $val = '';
        $label = '';
        $s = json_encode($s);
        $s = json_decode($s);

        if (is_array($s) && array_key_exists('val', $s))
        {
            $val = $s->val;
            $label = $s->label;
        }

        $help = $s->Help;
        $others = $s->othermenus;
        $islogin = session('Login');
        if ($islogin == 'TRUE')
        {
            $uid = session('uid');
            if (is_array($val) && array_key_exists('like', $val))
            {
                if ($val->like == '1')
                {
                    $res .= '<div  class="btn-group pull-right mr"><button id="LikePage" type="User" val="0" uid="' . $uid . '" sessid="' . $sesid . '" userid="' . $userid . '" type="button" class="btnActive  fa fa-anchor icon-pasandidan" data-toggle="tooltip" data-placement="top" title="' . $label->disLike . '"></button></div>';
                }
                else
                {
                    if ($val->like == '0')
                    {
                        $res .= '<div  class="btn-group pull-right mr"><button id="LikePage" type="User" val="1" uid="' . $uid . '" sessid="' . $sesid . '" userid="' . $userid . '" type="button" class="btn  fa fa-anchor icon-pasandidan" data-toggle="tooltip" data-placement="top" title="' . $label->like . '"></button></div>';
                    }
                }
                if ($val->follow == '1')
                {
                    $res .= '<div class="btn-group pull-right mr"><button id="FollowPage" type="User" val="0" uid="' . $uid . '" sessid="' . $sesid . '" userid="' . $userid . '" type="button" class="btnActive  fa fa-anchor icon-rss" data-toggle="tooltip" data-placement="top" title="' . $label->unfollow . '"></button></div>';
                }
                else
                {
                    if ($val->follow == '0')
                    {
                        $res .= '<div class="btn-group pull-right mr"><button id="FollowPage" type="User" val="1" uid="' . $uid . '" sessid="' . $sesid . '" userid="' . $userid . '" type="button" class="btn  fa fa-anchor icon-rss" data-toggle="tooltip" data-placement="top" title="' . $label->follow . '"></button></div>';
                    }
                }
            }
        }
        $res .= '<div class="btn-group" style="float: left"><a href="' . url('/') . '/modals/helpview?id=' . $help->pageid . '&tagname=' . $help->tagname . '&hid=' . $help->id . '&pid=25" title="راهنمای اینجا" class="jsPanels icon icon-help HelpIcons"></a></div>';
        $ret['abzar'] = shortToolsGenerator('User', $userid, ['uid' => $uid, 'sessid' => $sesid, 'userid' => $userid], ['pageid' => $help->pageid, 'tagname' => $help->tagname, 'id' => $help->id]);
        $ret['other'] = $others;
        return $ret;
    }

}
