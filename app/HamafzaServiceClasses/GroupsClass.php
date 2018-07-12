<?php

namespace App\HamafzaServiceClasses;

use DB;

class GroupsClass
{
    public function LikeRemove($uid, $userid)
    {
        DB::table('user_group_member')->where('uid', '=', $uid)->where('gid', '=', $userid)->update(['like' => '0']);
        DB::table('user_group')->where('id', '=', $userid)->decrement('like');
        $message = trans('labels.LikeRemove');
        return $message;
    }

    public function LikeADD($uid, $userid)
    {
        $friend = DB::table('user_group_member')->where('uid', '=', $uid)->where('gid', '=', $userid)->count();
        if ($friend > 0)
        {
            DB::table('user_group_member')->where('uid', '=', $uid)->where('gid', '=', $userid)->update(['like' => '1']);
            DB::table('user_group')->where('id', '=', $userid)->increment('like');
        }
        else
        {
            DB::table('user_group_member')->insert(['uid' => $uid, 'gid' => $userid, 'like' => '1']);
            DB::table('user_group')->where('id', '=', $userid)->increment('like');
        }
        $message = trans('labels.LikeOK');
        return $message;
    }

    public function FollowRemove($uid, $userid)
    {
        DB::table('user_group_member')->where('uid', '=', $uid)->where('gid', '=', $userid)->update(['follow' => '0']);
        DB::table('user_group_member')->where('id', '=', $userid)->decrement('follow');
        $message = trans('labels.followRemove');
        return $message;
    }

    public function FollowADD($uid, $userid)
    {
        $friend = DB::table('user_group_member')->where('uid', '=', $uid)->where('gid', '=', $userid)->count();
        if ($friend > 0)
        {
            DB::table('user_group_member')->where('uid', '=', $uid)->where('gid', '=', $userid)->update(['follow' => '1']);
        }
        else
        {
            DB::table('user_group_member')->insert(['uid' => $uid, 'gid' => $userid, 'follow' => '1']);
        }
        DB::table('user_group')->where('id', '=', $userid)->increment('follow');

        $message = trans('labels.followOK');
        return $message;
    }

    public static function AcceptUser2Group($uid, $sid, $gid, $cuid, $e)
    {
        $user = UserClass::CheckLogin($uid, $sid);
        if ($user == TRUE)
        {
            $user = 'true';
        }
        else
        {
            $user = 'false';
        }
        $admin = DB::table('user_group_member')->where('gid', $gid)->where('uid', $uid)->select('admin')->first();
        if ($user)
        {
            if ($admin && $admin->admin == '1')
            {
                if ($e == '1')
                {
                    DB::table('user_group_member')->where('uid', $cuid)->where('gid', $gid)->update(array('relation' => '2'));
                    $Ret = 'عضویت در گروه انجام شد';
                }
                else
                {
                    DB::table('user_group_member')->where('uid', $cuid)->where('gid', $gid)->update(array('relation' => '0'));
                    $Ret = 'حذف از گروه انجام شد';
                }
                $err = false;
            }
            else
            {
                $Ret = 'شما اجازه این کار را ندارید';
                $err = true;
            }
        }
        else
        {
            $err = true;
            $Ret = trans('labels.FailUser');
        }
        return $Ret;
    }

    public function GroupPersons($group, $uid = 0, $gid = 0, $type = 0)
    {
        $user = array();
        if ($type == 1)
        {
            $user = DB::table('user_group_member as ugm')->join('user as u', 'u.id', '=', 'ugm.uid')
                ->where('ugm.gid', $group->id)->where('ugm.relation', '2')->select('u.id', 'u.Name', 'u.Family', 'u.Uname', 'u.Pic')->get();
        }
        else
        {
            $users = DB::table('user_group_member as ugm')->join('user as u', 'u.id', '=', 'ugm.uid')
                ->where('ugm.gid', $group->id)->where('ugm.relation', '2')->select('u.id', 'u.Name', 'u.Family', 'u.Uname', 'u.Pic')->get();
            $userrequest = DB::table('user_group_member as ugm')->join('user as u', 'u.id', '=', 'ugm.uid')
                ->where('ugm.gid', $group->id)->where('ugm.admin', '0')->where('ugm.relation', '1')->select('u.id', 'u.Name', 'u.Family', 'u.Uname', 'u.Pic')->get();

            $user['accept'] = $users;
            $user['request'] = $userrequest;
        }

        return $user;
    }

    public static function AddtoGroup($uid, $sid, $gid)
    {
        $user = UserClass::CheckLogin($uid, $sid);
        if ($user == TRUE)
        {
            $user = 'true';
        }
        else
        {
            $user = 'false';
        }
        $regAllow = DB::table('user_group')->where('id', $gid)->select('edit')->first();
        $allow = $regAllow->edit;
        if ($allow == 0)
        {
            $allow = 2;
        } else {
            $allow = 1;
        }
        if ($user)
        {
            $cn = DB::table('user_group_member')->where('uid', $uid)->where('gid', $gid)->count();
            if ($cn > 0)
            {
                $cn2 = DB::table('user_group_member')->where('uid', $uid)->where('gid', $gid)->whereRaw("(relation='1' or relation='2')")->count();
                if ($cn2 > 0)
                {
                    DB::table('user_group_member')->where('uid', $uid)->where('gid', $gid)->update(array('relation' => '0'));
                    $Ret = 'از این گروه خارج شدید';
                }
                else
                {
                    $cn3 = DB::table('user_group_member')->where('uid', $uid)->where('gid', $gid)->count();
                    if ($cn3 == 0)
                    {
                        DB::table('user_group_member')->insert(array('gid' => $gid, 'uid' => $uid, 'like' => "'0'", 'follow' => "'1'", 'relation' => "$allow"));
                    }
                    else
                    {
                        DB::table('user_group_member')->where('uid', $uid)->where('gid', $gid)->update(array('relation' => $allow));
                    }
                    if ($allow == '1')
                    {
                        $Ret = 'عضویت شما پس از تایید مدیر انجام خواهد شد';
                    }
                    else
                    {
                        $Ret = 'عضو این گروه شدید.';
                    }
                }
            }
            else
            {
                DB::table('user_group_member')->insert(array('gid' => $gid, 'uid' => $uid, 'like' => '0', 'follow' => '1', 'relation' => $allow));
                if ($allow == '1')
                {
                    $Ret = 'عضویت شما پس از تایید مدیر انجام خواهد شد';
                }
                else
                {
                    $Ret = 'عضویت این گروه شدید.';
                }
            }
            $err = false;
        }
        else
        {
            $err = true;
            $Ret = trans('labels.FailUser');
        }
        return $Ret;
    }

    public function UpdateGroup($groupid, $sid, $uid, $type, $subtype)
    {
        $user = UserClass::CheckLogin($uid, $sid);
        if ($user == TRUE)
        {
            $user = 'true';
        }
        else
        {
            $user = 'false';
        }
        $help = PublicClass::HelpManage(0, $subtype, "user_group");
        if ($user)
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
            $menutools = DB::table('tools_group')->orderBy('orders')->get();
            foreach ($menutools as $value)
            {
                if ($type == 'group-my' || $type == 'chanel-my')
                {
                    $tools = DB::table('tools')->where('group-my', '1')->where('menuid', $value->id)->select('id', 'farsi', 'icon', 'url', 'modal')->orderBy('orders')->get();
                }
                else
                {
                    $tools = DB::table('tools')->where('groups', '1')->where('menuid', $value->id)->select('id', 'farsi', 'icon', 'url', 'modal')->orderBy('orders')->get();
                }

                if ($tools)
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
            $res['like'] = '0';
            $res['follow'] = 0;
            $res['relation'] = 0;


            $Taamol = array();
            $Abzar = array();
            $i = 1;
            $menutools = DB::table('tools_group')->orderBy('orders')->get();
            foreach ($menutools as $value)
            {
                $tools = DB::table('tools')->where('group_nouser', '1')->where('menuid', $value->id)->select('id', 'farsi', 'icon', 'url', 'modal')->orderBy('orders')->get();
                if ($tools)
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
        $Ret['Help'] = $help;
        $Ret['val'] = $res;
        $Ret['label'] = $lang;
        $Ret['othermenus'] = $Abzar;
//-----------------------
        return;
    }

    public function Group_tools($groupid, $sid, $uid, $type, $subtype)
    {
        $help = PublicsClass::HelpManage(0, $subtype, "user_group");
        if ($uid > 0)
        {
            $pageDet = DB::table('user_group_member')
                ->where('uid', $uid)->where('gid', $sid)->select('id', 'relation', 'follow', 'like')->first();
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
            $menutools = DB::table('tools_group')->orderBy('orders')->get();
            foreach ($menutools as $value)
            {
                if (($type == 'group-my' || $type == 'chanel-my') && $subtype == 'intro')
                {
                    $toolsc = DB::table('tools')->where('group-my', '1')->where('menuid', $value->id)->select('id')->count();
                    $tools = DB::table('tools')->where('group-my', '1')->where('menuid', $value->id)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->get();
                }
                elseif (($type == 'group-my' || $type == 'chanel-my') && $subtype != 'intro')
                {
                    $toolsc = DB::table('tools')->where('group-my-others', '1')->where('menuid', $value->id)->select('id')->count();
                    $tools = DB::table('tools')->where('group-my-others', '1')->where('menuid', $value->id)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->get();
                }
                else
                {
                    $toolsc = DB::table('tools')->where('groups', '1')->where('menuid', $value->id)->select('id')->count();
                    $tools = DB::table('tools')->where('groups', '1')->where('menuid', $value->id)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->get();
                }
                if ($toolsc > 0)
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
            $res['like'] = '0';
            $res['follow'] = 0;
            $res['relation'] = 0;


            $Taamol = array();
            $Abzar = array();
            $i = 1;
            $menutools = DB::table('tools_group')->orderBy('orders')->get();
            foreach ($menutools as $value)
            {
                $toolsc = DB::table('tools')->where('groups', '1')->where('menuid', $value->id)->where('login', '>', 0)->select('id')->count();
                $tools = DB::table('tools')->where('groups', '1')->where('menuid', $value->id)->where('login', '>', 0)->select('id', 'farsi', 'icon', 'url', 'modal', 'login')->orderBy('orders')->get();
                if ($toolsc > 0)
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

        $Ret['Help'] = $help;

        $Ret['val'] = $res;
        $Ret['label'] = $lang;
        $Ret['othermenus'] = $Abzar;
//-----------------------
        return $Ret;
    }

    public function GroupSettingUpdate(
        $uid, $group_title, $group_summary, $group_descrip, $group_type, $group_limit, $gid
        , $picname, $user_edits)
    {
        if ($picname != '')
        {
            $sql = "UPDATE
                                        user_group
                                SET
                                        `name`  = '{$group_title}' ,
                                        `summary` = '{$group_summary}' ,
                                        `descrip`  = '{$group_descrip}' ,
                                        `type`  = '{$group_type}' ,
                                        `edit` = '{$group_limit}' ,
                                        `pic` = '{$picname}' 
                                WHERE 
                                        id = {$gid} ";
        }
        else
        {
            $sql = "UPDATE
                                        user_group
                                SET
                                         `name`  = '{$group_title}' ,
                                        `summary` = '{$group_summary}' ,
                                        `descrip`  = '{$group_descrip}' ,
                                        `type`  = '{$group_type}' ,
                                        `edit` = '{$group_limit}' 
                                       
                                WHERE 
                                        id = {$gid}";
        }
        DB::select(DB::raw($sql));
        if (is_array($user_edits) && count($user_edits) > 0)
        {
            foreach ($user_edits as $value)
            {
                $n = DB::table('user_group_member')->where('uid', $value)->where('gid', $gid)->count();
                if ($n > 0)
                {
                    DB::table('user_group_member')->where('gid', $gid)->update(array('admin' => '0'));
                    DB::table('user_group_member')->where('uid', $value)->where('gid', $gid)->update(array('admin' => '1'));

                }
                else
                {
                    DB::table('user_group_member')->insert(array('uid' => $value, 'gid' => $gid, 'admin' => '1', 'relation' => '2'));
                }

            }

        }
        $message = 'تنظیمات جدید اعمال گردید';
        $err = false;

        return $message;
    }

    public function GroupDetail($name = '', $uid = 0, $gid = 0)
    {
        if ($gid != 0)
        {
            $Group = DB::table('user_group as ug')->join('user_group_member as ugm', 'ug.id', '=', 'ugm.gid')
                ->join('user as u', 'u.id', '=', 'ugm.uid')
                ->where('ug.id', $gid)->where('ugm.admin', '1')->select('ug.*', 'ugm.uid as adminid', 'ugm.uid as owner', 'u.Name', 'u.Family')->first();
        
             $key = DB::table('user_group as ug')->join('user_group_key as ugk', 'ug.id', '=', 'ugk.gid')
            ->join('keywords as k', 'k.id', '=', 'ugk.kid')
            ->where('ug.id', $gid)->select('k.id', 'k.title')->get();

        }
        else
        {
            $Group = DB::table('user_group as ug')->join('user_group_member as ugm', 'ug.id', '=', 'ugm.gid')
                ->join('user as u', 'u.id', '=', 'ugm.uid')
                ->whereRaw("ug.link='$name'")->where('ugm.admin', '1')->select('ug.*', 'ugm.uid as adminid', 'ugm.uid as owner', 'u.Name', 'u.Family')->first();
        
            $key = DB::table('user_group as ug')->join('user_group_key as ugk', 'ug.id', '=', 'ugk.gid')
            ->join('keywords as k', 'k.id', '=', 'ugk.kid')
            ->where('ug.link', $name)->select('k.id', 'k.title')->get();

        }
        
        if ($Group)
        {
            $Group->Ismember = '0';
        }

        if ($uid != '0')
        {
            $us = DB::table('user_group as ug')->join('user_group_member as ugm', 'ugm.gid', '=', 'ug.id')
                ->where('ug.link', $name)->where('ugm.uid', $uid)->where('ugm.relation', '2')->select('ug.id')->count();
            if ($us > 0)
            {
                $Group->Ismember = '1';
            }
            else
            {
                $Group->Ismember = '0';
            }
        }


        $Group->keywords = $key;
        if ($Group->adminid == $uid)
        {
            $Group->owner = '1';
        }
        else
        {
            $Group->owner = '0';
        }
        if ($Group)
        {
            return $Group;
        }
        else
        {
            return 0;
        }
    }

    function Group_Title($group)
    {
        $G = array();
        if ($group->id != '')
        {
            $G['id'] = $group->id;
            $G['name'] = $group->name;
            $G['PreTitle'] = ($group->isorgan == '0') ? 'گروه' : '';
            $G['summary'] = $group->summary;
            $G['descr'] = $group->descrip;
            $G['pic'] = $group->pic;
            $G['isorgan'] = $group->isorgan;
            $G['link'] = $group->link;
            $G['Ismember'] = $group->Ismember;
            $G['description'] = $group->description;

            $G['owner'] = $group->owner;
            $G['adminid'] = $group->adminid;
            $G['type'] = $group->type;
            $G['tel'] = $group->tel;
            $G['address'] = $group->address;
            $G['url'] = $group->url;
            $G['email'] = $group->email;
            $G['allowreg'] = $group->edit;
            $G['descrip'] = $group->descrip;
            $G['target'] = $group->target;
            $G['AdminName'] = $group->Name;
            $G['AdminFamily'] = $group->Family;
            $G['audience'] = $group->audience;
            $G['strategy'] = $group->strategy;
            $G['subject'] = $group->subject;
            $G['tel'] = $group->tel;
            $G['address'] = $group->address;
            $G['url'] = $group->url;
            $G['email'] = $group->email;
            $G['activity'] = $group->activity;
            $G['keywords'] = $group->keywords;
            $Group_Tabs = $this->Group_Tabs($group);
            $G['tabs'] = $Group_Tabs;
        }
        return $G;
    }

    function Group_Other($group)
    {
        $Group_Other = array();
        if ($group->id != '')
        {
            $Target = array();
            $Target[0] = trans('labels.GroupTarget');;
            $Target[1] = $group->target;

            $audience = array();
            $audience[0] = trans('labels.Groupaudience');
            $audience[1] = $group->audience;

            $strategy = array();
            $strategy[0] = trans('labels.Groupstrategy');
            $strategy[1] = $group->strategy;

            $description = array();
            $description[0] = trans('labels.Groupdescription');
            $description[1] = $group->description;


            $address = array();
            $address[0] = trans('labels.Groupaddress');
            $address[1] = $group->address;

            $tel = array();
            $tel[0] = trans('labels.Grouptel');
            $tel[1] = $group->tel;


            $url = array();
            $url[0] = trans('labels.Groupurl');
            $url[1] = $group->tel;


            $email = array();
            $email[0] = trans('labels.Groupemail');
            $email[1] = $group->email;


            $Group_Other['target'] = $Target;
            $Group_Other['audience'] = $audience;
            $Group_Other['strategy'] = $strategy;
            $Group_Other['description'] = $description;
            $Group_Other['address'] = $address;
            $Group_Other['tel'] = $tel;
            $Group_Other['email'] = $email;
        }


        return $Group_Other;
    }

    function Group_Tabs($group, $uid = 0)
    {
        $group_tab = array();
        $groups['tabs']['name']['0'] = 'درباره';
        $groups['tabs']['link']['0'] = 'intro';
        $groups['tabs']['name']['1'] = 'مطالب';
        $groups['tabs']['link']['1'] = 'contents';
        $groups['tabs']['name']['5'] = 'میزکار';
        $groups['tabs']['link']['5'] = 'desktop';
        $groups['tabs']['name']['6'] = 'گروه‌ها';
        $groups['tabs']['link']['6'] = 'groups';
        $groups['tabs']['name']['8'] = 'دیوار';
        $groups['tabs']['link']['8'] = 'wall';
        $groups['tabs']['name']['9'] = 'میزکار';
        $groups['tabs']['link']['9'] = 'desktop';
        $Uname = $group->link;
        if ($group->id != '')
        {
            $group_id = $group->id;

            foreach ($groups['tabs']['name'] as $key => $val)
            {
                $Tab = array();
                $link = $groups['tabs']['link'][$key];
                $href = $Uname . '/' . $groups['tabs']['link'][$key];
                $distance = ($key == 1 || $key == 5 || $key == 8) ? 1 : '';
                $view = true;
                if (($key == 5) && ($group->owner == 1))
                {
                    $view = true;
                }
                else
                {
                    if (($key == 5) && ($group->owner == 0))
                    {
                        $view = false;
                    }
                }
                if (($key == 6 || $key == 7 || $key == 8 || $key == 9))
                {
                    $view = false;
                }

                if ($view == true)
                {

                    $Tab['link'] = $link;

                    $Tab['href'] = $href;
                    $Tab['title'] = $val;
                    array_push($group_tab, $Tab);
                }
            }
        }
        return $group_tab;
    }

    function Group_return($group, $uid = 0)
    {
        $Alert = $this->Group_Title($group);
        $AG = array();
        $AG['preview'] = $Alert;
        $other = $this->Group_Other($group);
        $AG['other'] = $other;
        $tabs = $this->Group_Tabs($group, $uid);
        $AG['tabs'] = $tabs;
        $MEMBERS = $this->GroupPersons($group, $uid, 0, 1);
        $AG['members'] = $MEMBERS;
        return $AG;
    }

    public function about($group, $uid = 0, $gid = 0)
    {
        $GC = new GroupsClass();
        $group = $GC->GroupDetail($group, $uid, $gid);
        if ($group)
        {
            return $this->Group_return($group, $uid);
        }

    }

    public function GroupContent($name, $uid)
    {
        $GC = new GroupsClass();
        $group = $GC->GroupDetail($name, $uid);
        $pc = new PostsClass();
        $posts = $pc->GroupContents($group, $uid);
        $Alert = $GC->Group_Title($group);
        $AG = array();
        $AG['preview'] = $Alert;
        $AG['Posts'] = $posts;
        if ($group)
        {
            return $AG;
        }
        else
        {
            return '';
        }
    }

}
