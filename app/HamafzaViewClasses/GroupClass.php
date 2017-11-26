<?php

namespace App\HamafzaViewClasses;

use App\HamafzaServiceClasses\GroupsClass;
use Auth;

class GroupClass
{

    public static function GroupSetting($sid, $pid, $uid, $sesid, $title = '')
    {
        $GC = new GroupsClass();
        $group = $GC->GroupDetail('', $uid, $sid);
        $SP = new GroupsClass();
        $Group = $SP->about($sid, $uid, $sid);
        $P = $Group['preview'];
        $admin = $P['adminid'];
        if ($admin == $uid)
        {
            return view('modals.group_setting', array('group_edit' => $Group['preview']));
        }
        else
        {
            return 'شما به این صفحه دسترسی ندارید';
        }
    }

    public function total_html($title, $html)
    {
        $Res = '<div class="total"><h1 class="heading" id="b5">
                 <span class="icon icon-open"></span>' . $title . '</h1>
                 <div class="inner">' . $html . '</div></div>';
        return $Res;
    }

    public function Other($group)
    {
        $Circles = array();
        $uid = Auth::id();

        $Circles = UsersClass::GetMycircle($uid);
        $res = '';
        $IsOrgan = $group['preview']['isorgan'];
        $members = $group['members'];
        $Other = $group['other'];
        $target = $Other['target'];
        $target_Title = $target['0'];
        $target_Det = $target['1'];
        if ($target_Det != '')
        {
            $Det = $this->total_html($target_Title, $target_Det);
            $res .= $Det;
        }

        $audience = $Other['audience'];
        $Title = $audience['0'];
        $Det = $audience['1'];
        if ($Det != '')
        {
            $Det = $this->total_html($Title, $Det);
            $res .= $Det;
        }

        $strategy = $Other['strategy'];
        $Det = $strategy['1'];
        $Title = $strategy['0'];
        if ($Det != '')
        {
            $Det = $this->total_html($Title, $Det);
            $res .= $Det;
        }

        if ($IsOrgan == '0')
        {
            $description = $Other['description'];
            $Title = $description['0'];
            $Det = $description['1'];
            if ($Det != '')
            {
                $Det = $this->total_html($Title, $Det);
                $res .= $Det;
            }
        }

        if ($IsOrgan == '1')
        {
            $address = $Other['address'];
            $Title = $address['0'];
            $Det = $address['1'];
            if ($Det != '')
            {
                $Det = $this->total_html($Title, $Det);
                $res .= $Det;
            }
            $tel = $Other['tel'];
            $Title = $tel['0'];
            $Det = $tel['1'];
            if ($Det != '')
            {
                $Det = $this->total_html($Title, $Det);
                $res .= $Det;
            }
            $email = $Other['email'];
            $Title = $email['0'];
            $Det = $email['1'];
            if ($Det != '')
            {
                $Det = $this->total_html($Title, $Det);
                $res .= $Det;
            }
            $description = $Other['description'];
            $Title = $description['0'];
            $Det = $description['1'];
            if ($Det != '')
            {
                $Det = $this->total_html($Title, $Det);
                $res .= $Det;
            }
        }
        if ($IsOrgan == '0')
        {
            $Det = '<ul class="person-list row">';
            foreach ($members as $value)
            {
                $sa = $group['preview'];
                $pic = ($value->Pic != '') ? url('/') . '/pics/user/' . $value->Pic : '/pics/user/avator.jpg';
                $Det .= '<li class=""><a href="' . url('/') . '/' . $value->Uname . '"><img src="' . $pic . '" class="person-avatar"></a>';
                if ($value->id == $sa['adminid'])
                {
                    $Det .= '<div class="person-detail"><div class="close"></div><div class="person-name"><a href="' . url('/') . '/' . $value->Uname . '">' . $value->Name . ' ' . $value->Family . '(مدیر)</a></div>';
                }
                else
                {
                    $Det .= '<div class="person-detail"><div class="close"></div><div class="person-name"><a href="' . url('/') . '/' . $value->Uname . '">' . $value->Name . ' ' . $value->Family . '</a></div>';
                }
                $Det .= '<div class="person-moredetail"></div><div class="person-relation"></div></div>';

                $Det .= UsersClass::DrawCircle($value->id, $uid, $Circles);
                $Det .= '</li>';
            }
            $Det .= '</ul>';
            $Det = $this->total_html('اعضا', $Det);
            $res .= $Det;
        }
        return $res;
    }

    public function Preview($group)
    {
        $Preview = $group['preview'];
        $Title = $Preview['name'];
        $summary = $Preview['summary'];
        $descrip = $Preview['descrip'];
        $pic = ($Preview['pic'] != '') ? $Preview['pic'] : '/pics/group/avator.jpg';
        $res = '<div style="margin:15px;" class="gkCode10"><table style="border:none;"><tbody><tr style="border:none;"><td width="150" style="border: none;vertical-align: top;padding-top: 15px;text-align: right;"><img style="max-width:100px; height:auto; margin-left:15px;" ';
        $res .= 'src="' . $pic . '"></td><td style="border:none;text-align:right;"><div style="max-width: 760px;display: inline-block;vertical-align: top;text-align: right;font-size:9pt;">';
        $res .= '<h1>' . nl2br($Title) . '</h1>' . nl2br($summary) . '<hr style="width:100%;margin:0;"><p>' . nl2br($descrip) . '</p></div></td></tr></tbody></table></div>';
        return $res;
    }

    public function about($gname)
    {
        $Circles = array();
        $SP = new GroupsClass();
        $Uname = $gname;
        $uid = Auth::id();
        $sesid = 0;
        $Group = $SP->about($gname, $uid, 0);
        $Preview = $Group['preview'];
        $HtmlPreview = $this->Preview($Group);
        $HtmlPreview .= $this->Other($Group);
        $Title = $Preview['PreTitle'] . ' ' . $Preview['name'];
        $admin = $Preview['adminid'];
        $groupid = $Preview['id'];
        $isorgan = $Preview['isorgan'];
        $id = $Preview['id'];
        $content = $HtmlPreview;
        $tabs = $Group['tabs'];
        $newtree = '';
        $Files = '';
        $tools = '';
        $PageType = 'group';
        $tabs = json_decode(json_encode($tabs));
        if ($isorgan == '1')
        {
            $type = 'Organ';
        }
        else
        {
            $type = 'group';
        }

        session('Gname', $gname);
        return ['viewname' => 'pages.public', 'Rel' => '', 'PageType' => $PageType,
            'Title' => $Title, 'Small' => $id,
            'pid' => 'intro', 'content' => $content, 'sid' => $id,
            'tabs' => $tabs, 'Tree' => $newtree,

        ];
    }

    public function Group_Persons($name)
    {
        $uid = Auth::id();
        $sesid = 0;
        $GC = new GroupsClass();
        $group = $GC->GroupDetail($name, $uid);
        $persons = $GC->GroupPersons($group, $uid);
        $Alert = $GC->Group_Title($group);
        $AG = array();
        $AG['preview'] = $Alert;
        $AG['Persons'] = $persons;
        $SP = new GroupsClass();
        $us = $Alert;
        $title = $us['PreTitle'] . ' ' . $us['name'];
        $adminid = $us['adminid'];
        $accept_users = $AG['Persons']['accept'];
        $request_users = $AG['Persons']['request'];
        $Tree = '';
        if ($adminid == $uid)
        {
            $Tree = 'groupadmin';
        }
        $uid = $us['id'];
        $tabs = $us['tabs'];
        $content2 = '';
        $tools = '';
        $PageType = 'group';
        $gid = $us['id'];
        $pid = 'persons';
        $accept_users = json_encode($accept_users);
        $accept_users = json_decode($accept_users);
        $request_users = json_encode($request_users);
        $request_users = json_decode($request_users);
        $tabs = json_decode(json_encode($tabs));

        return ['Rel' => '', 'PageType' => $PageType, 'Title' => $title, 'Small' => $uid,
            'pid' => $pid, 'request_users' => $request_users, 'accept_users' => $accept_users, 'content' => $content2, 'tabs' => $tabs, 'Tree' => '', 'sid' => $gid];
    }

    public function Group_Contents($uname)
    {
        $uid = Auth::id();
        $sesid = 0;
        $PC = new GroupsClass();
        $user_data = $PC->GroupContent($uname, $uid);
        $us = $user_data['preview'];
        $adminid = $us['adminid'];
        $Tree = '';
        $Ismember = $us['Ismember'];
        $title = $us['PreTitle'] . ' ' . $us['name'];
        if ($adminid == $uid)
        {
            $Tree = 'groupadmin';
        }
        else
        {
            if ($Ismember == '1')
            {
                $Tree = 'ismember';
            }
        }
        $uid = $us['id'];
        $tabs = $us['tabs'];
        $content2 = $user_data['Posts'];
        foreach ($content2 as $value)
        {
            $value->desc = nl2br(stripslashes($value->desc));
            session('Gname', $uname);
            if (!empty($value->pic))
            {
                $value->desc .= '<img src="' . App::make('url')->to('/') . '/uploads/' . $value->pic . '">';
            }
        }
        $content2 = json_encode($content2);
        $content2 = json_decode($content2);
        $tools = '';
        $PageType = 'group';
        $gid = $us['id'];
        $pid = 'contents';
        $tabs = json_encode($tabs);
        $tabs = json_decode($tabs);
        return
            [
                'PageTypes' => 'GroupContent',
                'Uname' => $uname,
                'keywords' => '',
                'Rel' => '',
                'PageType' => $PageType,
                'Title' => $title,
                'Small' => $uid,
                'pid' => $pid,
                'content' => '0',//$content2,
                'tabs' => $tabs,
                'Tree' => $Tree,
                'sid' => $gid
            ];
    }


    /* public function editGroup($id)
    {
        $SP = new GroupsClass();
        $Uname = (session('Uname') != '') ? session('Uname') : 0;
        $uid = (session('uid') != '') ? session('uid') : 0;
        $sesid = (session('sesid') != '') ? session('sesid') : 0;
        $json_a = $SP->about('', $uid, $id);
        $Group = $json_a;
        $Preview = $Group['preview'];
        $SiteTitle = config('constants.SiteTitle');
        $SiteLogo = config('constants.SiteLogo');
        $admin = $Preview['adminid'];
        $Title = 'ویرایش ' . $Preview['PreTitle'] . ' ' . $Preview['name'];
        $keywords = '';
        $groupid = $Preview['id'];
        $isorgan = $Preview['isorgan'];
        $gname = $Preview['link'];
        $id = $Preview['id'];
        $PC = new PublicClass();
        $menu = $PC->GetSiteMenu();
        $content = $Preview;
        $tabs = $Group['tabs'];
        $newtree = '';
        $Files = '';
        $tools = '';
        $PageType = 'group';
        $uid = session('uid');
        $sesid = session('SessionID');
        $uid = (session('uid') != '') ? $uid : 0;
        $sesid = (session('SessionID') != '') ? $sesid : 0;
        $Portals = PageClass::GetProtals($uid, $sesid);
        $PgC = new PageClass();
        $RightCol = $PgC->GetRightCol($uid, $sesid, $uid, 'userabout');
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        if ($isorgan == '1')
        {
            $type = 'Organ';
        }
        else
        {
            $type = 'group';
        }
        if ($uid == $admin)
        {
            $tools = $this->Tools($uid, $sesid, $type . '-my', $groupid, 'intro', $isorgan);
        }
        else
        {
            $tools = $this->Tools($uid, $sesid, $type . 'page', $groupid, 'intro', $isorgan);
        }
        session('Gname', $gname);
        $MenuTools = $tools['other'];
        $MenuTools = json_encode($tools['other']);
        $MenuTools = json_decode($MenuTools);
        $shortTools = $tools['abzar'];
        if ($admin == $uid)
        {
            return view('pages.groupEdit',
                [
                    'Rel' => '',
                    'RightCol' => $RightCol,
                    'MyOrganGroups' => $MyOrganGroups,
                    'Portals' => $Portals,
                    'keywordTab' => $keywordTab,
                    'PageType' => $PageType,
                    'SiteLogo' => $SiteLogo,
                    'SiteTitle' => $SiteTitle,
                    'Title' => $Title,
                    'Small' => $id,
                    'gname' => $gname,
                    'pid' => 'intro',
                    'menu' => $menu,
                    'content' => $content,
                    'sid' => $id,
                    'keywords' => $keywords,
                    'tabs' => $tabs,
                    'Tree' => $newtree,
                    'Files' => $Files,
                    'tools' => $shortTools,
                    'menutools' => $MenuTools
                ]
            );
        }
        else
        {
            return view('pages.groupEdit',
                [
                    'Rel' => '',
                    'RightCol' => $RightCol,
                    'MyOrganGroups' => $MyOrganGroups,
                    'Portals' => $Portals,
                    'keywordTab' => $keywordTab,
                    'PageType' => $PageType,
                    'SiteLogo' => $SiteLogo,
                    'SiteTitle' => $SiteTitle,
                    'Title' => $Title,
                    'Small' => $id,
                    'gname' => $gname,
                    'pid' => 'intro',
                    'menu' => $menu,
                    'content' => 'شما اجازه ویرایش ندارید',
                    'sid' => $id,
                    'keywords' => '',
                    'tabs' => $tabs,
                    'Tree' => $newtree,
                    'Files' => $Files,
                    'tools' => $shortTools,
                    'menutools' => $MenuTools
                ]);
        }
    }*/
    /*public static function Tools($uid, $sesid, $type = 'grouppage', $groupid = '0', $helppage = 'intro')
    {
        $res = '<div class="btn-group pull-right frst-wdt mr"><button type="button" id="rSubMenuBtn" class="btn  fa fa-align-justify icon-reorder" data-icon="U+E0CC" data-toggle="tooltip" data-placement="top" title="ابزارها"></button></div>';
        $UC = new GroupsClass();
        $s = $UC->Group_tools($groupid, $sesid, $uid, $type, $helppage);
        $val = $s['val'];
        $label = $s['label'];
        $help = $s['Help'];
        $others = $s['othermenus'];
        $islogin = session('Login');
        $uid = session('uid');
        if ($uid != '' && $uid != '0')
        {
            if ($val['like'] == '1')
            {
                $res .= '<div  class="btn-group pull-right mr"><button id="LikePage" type="Group" val="0" uid="' . $uid . '" sessid="' . $sesid . '" userid="' . $groupid . '" type="button" class="btnActive  fa fa-anchor icon-pasandidan" data-toggle="tooltip" data-placement="top" title="' . $label['disLike'] . '"></button></div>';
            }
            else
            {
                if ($val['like'] == '0')
                {
                    $res .= '<div  class="btn-group pull-right mr"><button id="LikePage" type="Group" val="1" uid="' . $uid . '" sessid="' . $sesid . '" userid="' . $groupid . '" type="button" class="btn  fa fa-anchor icon-pasandidan" data-toggle="tooltip" data-placement="top" title="' . $label['like'] . '"></button></div>';
                }
            }
            if ($val['follow'] == '1')
            {
                $res .= '<div class="btn-group pull-right mr"><button id="FollowPage" type="Group" val="0" uid="' . $uid . '" sessid="' . $sesid . '" userid="' . $groupid . '" type="button" class="btnActive  fa fa-anchor icon-rss" data-toggle="tooltip" data-placement="top" title="' . $label['unfollow'] . '"></button></div>';
            }
            else
            {
                if ($val['follow'] == '0')
                {
                    $res .= '<div class="btn-group pull-right mr"><button id="FollowPage" type="Group" val="1" uid="' . $uid . '" sessid="' . $sesid . '" userid="' . $groupid . '" type="button" class="btn  fa fa-anchor icon-rss" data-toggle="tooltip" data-placement="top" title="' . $label['follow'] . '"></button></div>';
                }
            }
            $res .= '<div class="btn-group" style="float: left;"><a href="' . url('/') . '/modals/helpview?id=' . $help->pageid . '&tagname=' . $help->tagname . '&hid=' . $help->id . '&pid=25" title=" راهنمای اینجا" class="jsPanels icon-help HelpIcons"> </a></div>';
        }
        else
        {
            $res .= '<div  class="btn-group pull-right mr"><button type="button" class="btn  fa fa-anchor icon-pasandidan login" data-toggle="modal" data-target="#loginWmessage" data-placement="top"  title="' . $label['like'] . '"></button></div>';
            $res .= '<div class="btn-group pull-right mr"><button  type="button" class="btn  fa fa-anchor icon-rss login" data-toggle="modal" data-target="#loginWmessage" data-placement="top" title="' . $label['unfollow'] . '"></button></div>';
        }
        $ret['abzar'] = shortoolsGenerator(0, 0, 'Group', $sesid, ['uid' => $uid, 'sessid' => $sesid, 'userid' => $groupid], ['pageid' => $help->pageid, 'tagname' => $help->tagname, 'id' => $help->id]);;
        $ret['other'] = $others;
        return $ret;
    }*/

}
