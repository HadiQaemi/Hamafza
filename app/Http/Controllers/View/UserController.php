<?php

namespace App\Http\Controllers\View;

use App\Models\hamafza\Keyword;
use App\Models\hamafza\UserEducation;
use App\Models\hamafza\UserSpecial;
use App\Models\hamafza\UserWork;
use App\Profile;
use App\User;
use Auth;
use function MongoDB\is_string_array;
use Validator;
use App\Http\Requests;
use App\Models\Hamahang\FileManager\FileManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HamafzaViewClasses\SNClass;
use App\HamafzaViewClasses\PageClass;
use App\HamafzaViewClasses\KeywordClass;
use App\HamafzaServiceClasses\UserClass;
use App\HamafzaPublicClasses\FunctionsClass;
use App\HamafzaViewClasses\PublicClass;
use App\HamafzaViewClasses\GroupClass;
use Intervention\Image\Facades\Image;
use App\HamafzaViewClasses\DesktopClass;
use App\HamafzaViewClasses\UsersClass;
use App\HamafzaViewClasses\Measure;
use App\HamafzaViewClasses\Message;
use App\HamafzaViewClasses\SubjectClass;
use App\HamafzaViewClasses\HelpClass;
use App\HamafzaViewClasses\FormClass;

class UserController extends Controller
{

    private function IsUoG($name)
    {
        $User = DB::table('user')->where('Uname', $name)->first();
        if ($User)
        {
            return 'USER';
        }
        else
        {
            $Group = DB::table('user_group')->where('link', $name)->first();
            if ($Group)
            {
                return 'GROUP';
            }
            else
            {
                return 'NONE';
            }
        }
    }

    public function DefDesktop($name)
    {
        $Type = $this->IsUoG($name);
        if ($Type == 'USER')
        {
            $res = variable_generator('user', 'DefDesktop', $name);
            if(in_array($res,[403,404]))
                return view('errors.'.$res);
            return view($res['viewname'], $res);
        } else if ($Type == 'GROUP'){
            $res = variable_generator('group', 'desktop', $name);
            if(in_array($res,[403,404]))
                return view('errors.'.$res);
            return view($res['viewname'], $res);
        }
    }

    public function notifications($name)
    {
        $res = variable_generator('user', 'notifications', $name);
        return view($res['viewname'], $res);
    }

    public function highlights($name)
    {
        $res = variable_generator('user', 'highlights', $name);
        return view($res['viewname'], $res);
    }

    public function asubadd($username)
    {
        /*$uid = auth()->id();
        $Tree = DesktopClass::DeskTopTree($uid, 0, '', '');
        return SubjectClass::AsubjectAdd($name, $uid, 0, $Tree);*/
        $arr = variable_generator('user', 'asubadd', $username);
        return view($arr['viewname'], $arr);
    }

    public function departments($name)
    {
        $uid = Auth::id();
        /* ??? *///$names = $name;
        /* ??? *///$this->Checkdesktop($name);
        $Tree = DesktopClass::DeskTopTree($uid, 0, '', '');
        return PublicClass::Departments($name, $uid, 0, '', $Tree, '');
    }

    public function user_measures($name)
    {
        $uid = Auth::id();
        /* ??? *///$names = $name;
        /* ??? *///$this->Checkdesktop($name);
        $Tree = DesktopClass::DeskTopTree($uid, 0, '', '');
        return Measure::SelectType($name, '', $Tree);
    }

   /* public function Outbox($uname)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $res = variable_generator('user', 'message_outbox', $uname);
            return view('pages.Desktop', $res);
        }
    }*/

    /* -------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------- */

   /* public function Created_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'Created_ME']);
        return view($res['viewname'], $res);
    }*/

    public function New_Other($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'New_Other']);
        return view($res['viewname'], $res);
    }

   /* public function Edited_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'Edited_ME']);
        return view($res['viewname'], $res);
    }*/

   /* public function follow_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'follow_ME']);
        return view($res['viewname'], $res);
    }

    public function like_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'like_ME']);
        return view($res['viewname'], $res);
    }

    public function ano_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'ano_ME']);
        return view($res['viewname'], $res);
    }

    public function highlight_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'highlight_ME']);
        return view($res['viewname'], $res);
    }

    public function Proc_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'Proc_ME']);
        return view($res['viewname'], $res);
    }

    public function visited_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'visited_ME']);
        return view($res['viewname'], $res);
    }

    public function Sug_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'Sug_ME']);
        return view($res['viewname'], $res);
    }

    public function ALL_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'ALL_ME']);
        return view($res['viewname'], $res);
    }

    public function ALL_Other($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'ALL_Other']);
        return view($res['viewname'], $res);
    }

    public function Deleted_pages($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'Deleted_pages']);
        return view($res['viewname'], $res);
    }*/

    /* -------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------- */

    public function announces($name)
    {
        $res = variable_generator('user', 'announces', $name);
        return view($res['viewname'], $res);
    }

    public function form_list_me($name)
    {
        $res = variable_generator('user', 'form_list', $name, ['sublink' => 'me']);
        return view($res['viewname'], $res);
    }

    public function form_list_sent($name)
    {
        $res = variable_generator('user', 'form_list', $name, ['sublink' => 'sent']);
        return view($res['viewname'], $res);
    }

    public function form_list_copy($name)
    {
        $res = variable_generator('user', 'form_list', $name, ['sublink' => 'copy']);
        return view($res['viewname'], $res);
    }

    public function form_list_add($name)
    {
        $res = variable_generator('user', 'form_list', $name, ['sublink' => 'add']);
        return view($res['viewname'], $res);
    }

    public function form_list_edit($name)
    {
        $res = variable_generator('user', 'form_list', $name, ['sublink' => 'edit']);
        return view($res['viewname'], $res);
    }

    public function form_list_drafts($name)
    {
        $res = variable_generator('user', 'form_list', $name, ['sublink' => 'drafts']);
        return view($res['viewname'], $res);
    }

    public function form_list_all($name)
    {
        $res = variable_generator('user', 'form_list', $name, ['sublink' => 'all']);
        return view($res['viewname'], $res);
    }

    public function user_list($name)
    {
        $sr = '';
        if (isset($_GET['sr']) && $_GET['sr'] != '')
        {
            $sr = $_GET['sr'];
        }
        $res = variable_generator('user', 'user_list', $name, ['sr' => $sr]);
        return view($res['viewname'], $res);
    }

    public function user_list_edit($name)
    {
        $res = variable_generator('user', 'user_list_edit', $name);
        return view($res['viewname'], $res);
    }

    public function user_list_add($name)
    {
        $res = variable_generator('user', 'user_list_add', $name);
    }

    public function showgroups($uname)
    {
        
        $arr = variable_generator('user', 'desktop', $uname);
        return view('hamahang.Users.groups', $arr);
    }

    public function relationSave(Request $request)
    {
        $id = $request->editid;
        if ($id && $id != 0)
        {
            $r = \App\Models\hamafza\Relations::find($id);
            $r->fill($request->all());
            $r->save();
            $mes = 'ویرایش انجام شد';
        }
        else
        {
            $r = new \App\Models\hamafza\Relations();
            $r->fill($request->all());
            $r->save();
            $mes = 'درج انجام شد';
        }

        return Redirect()->back()->with('message', $mes)->with('mestype', 'success');
    }

    public function relations($name)
    {
        $uid = Auth::id();
        $res = variable_generator('user', 'Desktop_relations', $name);
        return view($res['viewname'], $res);
    }

    public function relations_add($name)
    {
        $uid = Auth::id();
        $res = variable_generator('user', 'Desktop_relations_add', $name);
        return view($res['viewname'], $res);
    }

    public function relations_edit($name, $id)
    {
        $param = ['username' => $name, 'id' => $id];
        $res = variable_generator('user', 'Desktop_relations_id', $name, $param);
        return view($res['viewname'], $res);
    }

    public function showorgans($name)
    {
        $uid = Auth::id();
        /* ??? *///$this->Checkdesktop($name);
        $Tree = DesktopClass::DeskTopTree($uid, 0, '', '');
        return UsersClass::showorgans($name, $uid, 0, '', $Tree, '');
    }

    public function subjects($name)
    {
        $uid = Auth::id();
        $res = variable_generator('user', 'Desktop_subjects', $name);
        return view($res['viewname'], $res);
    }

    public function subjectss($name, $id)
    {
        $param = ['username' => $name, 'subject_id' => $id];
        $res = variable_generator('user', 'Desktop_subjects_id', $name, $param);
        return view($res['viewname'], $res);
    }

    public function subject_field($name)
    {
        $res = variable_generator('user', 'Desktop_subject_field', $name);
        return view($res['viewname'], $res);
    }

    public function subst($name)
    {
        $res = variable_generator('user', 'subst', $name);
        return view($res['viewname'], $res);
    }

    public function subst_add($name)
    {
        $res = variable_generator('user', 'subst_add', $name);
        return view($res['viewname'], $res);
    }

    public function subst_edit($name)
    {
        $pid = $_GET['id'];
        $res = variable_generator('user', 'subst_edit', $name, ['id' => $pid]);
        return view($res['viewname'], $res);
    }

   /* public function inbox($uname)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $res = variable_generator('user', 'message_inbox', $uname);
            return view('pages.Desktop', $res);
        }
    }*/

    public function alerts($name)
    {
        $uid = Auth::id();
        $param = ['username' => $name, 'type' => ''];
        $res = variable_generator('user', 'Desktop_alerts', $name, $param);
        return view($res['viewname'], $res);
    }

    public function alerts_edit($name)
    {
        $param = ['username' => $name, 'type' => 'edit'];
        $res = variable_generator('user', 'alerts_edit', $name, $param);
        return view($res['viewname'], $res);
    }

    public function alerts_add($name)
    {
        $uid = Auth::id();
        $res = variable_generator('user', 'alerts_add', $name);
        return view($res['viewname'], $res);
    }

    public function homepage($name)
    {
        $uid = Auth::id();
        /* ??? *///$this->Checkdesktop($name);
        $Tree = DesktopClass::DeskTopTree($uid, 0, '', '');
        return PageClass::homepage($name, $uid, 0, '', $Tree, '');
    }

    public function user_measures_ME($name)
    {
        $uid = Auth::id();
        /* ??? *///$names = $name;
        $sel = (isset($_GET['sel']) && $_GET['sel'] != '') ? $_GET['sel'] : '';
        /* ??? *///$this->Checkdesktop($name);
        $Tree = DesktopClass::DeskTopTree($uid, 0, '', '');
        return Measure::SelectType($name, 'ME', $Tree, $sel);
    }

    public function user_measures_BC($name)
    {
        $uid = Auth::id();
        /* ??? *///$names = $name;
        /* ??? *///$sel = (isset($_GET['sel']) && $_GET['sel'] != '') ? $_GET['sel'] : '';
        /* ??? *///$this->Checkdesktop($name);
        $Tree = DesktopClass::DeskTopTree($uid, 0, '', '');
        return Measure::SelectType($name, 'BC', $Tree);
    }

    private function Checkdesktop($name)
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
        }
    }

    public function AboutUser($username)
    {
        $Type = $this->IsUoG($username);
        if ($Type == 'USER')
        {
            $res = variable_generator('user', 'About', $username);
            return view($res['viewname'], $res);
        }
        elseif ($Type == 'GROUP')
        {
            $res = variable_generator('group', 'About', $username);
            return view($res['viewname'], $res);
        }
        else
        {
            abort(404);
        }
    }
    
    public function DefaultTab($username)
    {
        $Type = $this->IsUoG($username);
        if ($Type == 'USER')
        {
            $res = variable_generator('user', 'About', $username);
            return view($res['viewname'], $res);
        }
        elseif ($Type == 'GROUP')
        {
            $res = variable_generator('group', 'Content', $username);
            return view($res['viewname'], $res);
        }
        else
        {
            abort(404);
        }
    }

    public function UserContents($username)
    {
        $Type = $this->IsUoG($username);
        if ($Type == 'USER')
        {
            $res = variable_generator('user', 'Content', $username);
            return view($res['viewname'], $res);
        }
        elseif ($Type == 'GROUP')
        {
            $res = variable_generator('group', 'Content', $username);
            return view($res['viewname'], $res);
        }
        else
        {
            return Redirect()->to('0');
        }
    }

    public function UserWall($uname)
    {
        $res = variable_generator('user', 'wall', $uname);
        return view($res['viewname'], $res);
    }

    public static function UserDesktop($uname, $type = '', $sublk = '')
    {
        $SN = new SNClass();
        return $SN->SelectDesktop($uname, $type, $sublk);
    }

    public static function Grouppersons($username)
    {
        $res = variable_generator('group', 'Persons', $username);
        return view($res['viewname'], $res);
    }

    public function GroupSettingUpdate(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            /* ??? *///$Uname = (session('Uname') != '') ? session('Uname') : 0;
            $uid = (session('uid') != '') ? session('uid') : 0;
            /* ??? *///$sesid = (session('sesid') != '') ? session('sesid') : 0;
            $group_title = PublicClass::Filter($request->input('group_title'));
            $group_link = PublicClass::Filter($request->input('group_link'));
            $group_summary = PublicClass::Filter($request->input('group_summary'));
            $group_descrip = PublicClass::Filter($request->input('group_descrip'));
            $group_type = PublicClass::Filter($request->input('group_type'));
            $user_edits = $request->input('user_edits');
            $group_limit = PublicClass::Filter($request->input('group_limit'));
            $gid = PublicClass::Filter($request->input('gid'));
            $file = $request->file('pic');
            $tmpFileName = '';
            if ($file)
            {
                if ($file->isValid())
                {
                    /* ??? *///$tmpFilePath = 'pics/group/';
                    $extension = $file->getClientOriginalExtension();
                    $tmpFileName = $uid . time() . '.' . $extension; // renameing image
                    $img = Image::make($file->getRealPath());
                    $img->resize(450, null, function ($constraint)
                    {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $img->save('pics/group/' . $tmpFileName)->destroy();
                    $tmpFileName = $tmpFileName;
                }
            }
            $SP = new \App\HamafzaServiceClasses\GroupsClass();
            $menu = $SP->GroupSettingUpdate($uid, $group_title, $group_summary, $group_descrip, $group_type, $group_limit, $gid, $tmpFileName, $user_edits);
            return Redirect()->to($group_link)->with('message', $menu)->with('mestype', 'success');
        }
    }

    public function GroupEdit($id)
    {
        $arr = variable_generator('group', 'edit', $id);
        return view('pages.groupEdit', $arr);
        /* $GC = new GroupClass();
          return $GC->editGroup($id); */
    }

    public function UpdateGroup(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            /* ??? *///$Uname = (session('Uname') != '') ? session('Uname') : 0;
            $uid = (session('uid') != '') ? session('uid') : 0;
            $group_title = $request->input('group_title');
            $group_summary = $request->input('group_summary');
            $Groupkeywords = $request->input('Groupkeywords');
            $group_descrip = $request->input('group_descrip');
            $group_type = $request->input('group_type');
            $group_target = $request->input('group_target');
            $group_audience = $request->input('group_audience');
            $group_strategy = $request->input('group_strategy');
            $description = $request->input('description');
            $subject = $request->input('subject');
            $address = $request->input('address');
            $tel = $request->input('tel');
            $url = $request->input('url');
            $email = $request->input('email');
            $group_limit = $request->input('group_limit');
            $gid = $request->input('gid');
            $gname = $request->input('gname');
            $group_activity = $request->input('group_activity');
            $file = $request->file('pic');
            $tmpFileName = '';
            if ($file)
            {
                if ($file->isValid())
                {
                    $tmpFilePath = 'pics/group/';
                    $extension = $file->getClientOriginalExtension();
                    $tmpFileName = $uid . time() . '.' . $extension; // renameing image
                    $img = Image::make($file->getRealPath());
                    $img->resize(450, null, function ($constraint)
                    {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $img->save('pics/group/' . $tmpFileName)->destroy();
                    $tmpFileName = $tmpFileName;
                }
            }
            $picname = $tmpFileName;
            $description = $request->input('description');
            $subject = $request->input('subject');
            $address = $request->input('address');
            $tel = $request->input('tel');
            $url = $request->input('url');
            $email = $request->input('email');
            $group_limit = $request->input('group_limit');
            if ($tmpFileName != '')
            {
                DB::table('user_group')
                    ->where('id', $gid)
                    ->update(
                        [
                            'name'  => $group_title,
                            'summary' =>$group_summary,
                            'descrip'  => $group_descrip,
                            'type'  => $group_type,
                            'target'  => $group_target,
                            'audience'  => $group_audience,
                            'strategy'  => $group_strategy,
                            'description'  => $description,
                            'edit' => $group_limit,
                            'subject' => $subject,
                            'tel' => $tel,
                            'address' => $address,
                            'url' => $url,
                            'url' => $url,
                            'pic' => $picname
                        ]
                    );
            }
            else
            {
                DB::table('user_group')
                    ->where('id', $gid)
                    ->update(
                        [
                            'name'  => $group_title,
                            'summary' =>$group_summary,
                            'descrip'  => $group_descrip,
                            'type'  => $group_type,
                            'target'  => $group_target,
                            'audience'  => $group_audience,
                            'strategy'  => $group_strategy,
                            'activity'  => $group_activity,
                            'description'  => $description,
                            'edit' => $group_limit,
                            'subject' => $subject,
                            'tel' => $tel,
                            'address' => $address,
                            'url' => $url,
                            'email' => $email
                        ]
                    );
            }
            DB::table('user_group_key')->where('gid', $gid)->delete();
            $myArray = explode(',', $Groupkeywords);
            foreach ($myArray as &$value)
            {
                if ($value != '' && $value != '0')
                {
                    DB::table('user_group_key')->insert(array('gid' => $gid, 'kid' => $value));
                }
            }
            $message = 'گروه ویرایش گردید';
            return Redirect()->to($gname)->with('message', $message)->with('mestype', 'success');
        }
    }

    public function sharePage(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = Auth::id();
            $user_edits = $request->input('user_edits');
            /* ??? *///$recipientmail2 = $request->input('recipientmail2');
            $comment = $request->input('comment');
            $link = $request->input('link');
            $tid = $request->input('tid');
            $type = $request->input('type');
            /* ??? *///$sendermail = $request->input('sendermail');
            /* ??? *///$sendername = $request->input('sendername');

            if ($type == 'subject')
            {
                $type = 'page';
            }
            $comment = PublicClass::Filter($comment);
            $link = PublicClass::Filter($link);
            $comment = $comment . '<br><p><a target="_blank" href="' . $link . '">' . $link . '</a></ap>';
            $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
            $title = 'باز نشر';
            if (is_array($user_edits))
            {
                $tickets = DB::table('tickets')->insertGetId(array('uid' => $uid, 'title' => $title, 'login' => '0', 'reg_date' => $reg_date));
                DB::table('ticket_answer')->insert(array('uid' => $uid, 'tid' => $tickets, 'comment' => $comment, 'reg_date' => $reg_date));
                foreach ($user_edits as $key => $val)
                {
                    if (intval($val) != 0)
                    {
                        DB::table('ticket_recieve')->insert(array('tid' => $tickets, 'uid' => $val));
                    }
                }
            }
            if ($tid != 0 && $type == 'user')
            {
                DB::table('user')->where('id', $tid)->increment('Suggest');
            }
            elseif ($tid != 0 && $type == 'group')
            {
                DB::table('user_group')->where('id', $tid)->increment('Suggest');
            }
            elseif ($tid != 0 && $type == 'page')
            {
                DB::table('subjects')->where('id', $tid)->increment('Suggest');
            }
            $mes = trans('labels.ShareOK');

            return Redirect()->back()->with('message', $mes)->with('mestype', 'success');
        }
    }

    //*****************************************************************
    //////////////////////// Hamahang Methods /////////////////////////

    public function save_avatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|mimes:jpg,png,gif,bmp,jpeg|max:1024',
        ]);
        if ($validator->fails())
        {
            $res = [
                'success' => false,
                'result' => $validator->errors()
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $upload = HFM_Upload($request->file('avatar'), 'Avatars/');
        $user = auth()->user();
        $user->avatar = $upload['ID'];
        $user->save();
        $res = [
            'success' => true,
            'result' => ['message' => trans('app.operation_is_success')],
            'img_id' => enCode($upload['ID'])
        ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

    public function remove_avatar()
    {
        $user = auth()->user();
        $user->avatar = null;
        $user->save();

        $res = [
            'success' => true,
            'result' => ['message' => trans('app.operation_is_success')],
        ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

    public function rename_avatar(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'avatar_name' => 'required|max:200',
            'image_file_id' => 'required'
        ]);
        if ($validator->fails())
        {
            $res = [
                'success' => false,
                'result' => $validator->errors()
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $file = FileManager::find($request->input('image_file_id'));
        $file->originalName = $request->input('avatar_name');
        $file->save();
        $res = [
            'success' => true,
            'result' => ['message' => trans('app.operation_is_success')],
        ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

    ///////////////////////////////////////////////////////////////////
    //*****************************************************************

    //*****************************************************************
    /////////////////////// User Specials Methods /////////////////////

    public function updateUserDetail(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|min:3|max:255',
                'family' => 'required|string|min:3|max:255',
                'summary' => 'min:3|max:255',
                'province' => 'numeric',
                'city' => 'numeric',
                'mobile' => 'mobile_phone',
                'tel_number' => 'numeric|min:8|max:8',
                'tel_code' => 'numeric',
                'fax_number' => 'numeric|min:8|max:8',
                'fax_code' => 'numeric',
                /*'email' => 'email',*/
            ],
            [
                'tel_code' => 'فرمت کد شهر فیلد تلفن ثابت رعایت نشده است.',
                'fax_code' => 'فرمت کد شهر فیلد فکس رعایت نشده است.',
            ],
            [
                'summary' => 'معرفی اجمالی',
                'tel_number' => 'شماره تلفن',
                'fax_number' => 'شماره فکس',
                'tel_code' => 'کد شهر فیلد تلفن ثابت',
                'fax_code' => 'کد شهر فیلد فکس'
            ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (auth()->check())
            {
                $user = auth()->user();
                $user->Name = $request->name;
                $user->Family = $request->family;
                $user->Summary = $request->summary;
                $user->Gender = $request->gender;
                /*$user->Email = $request->email;*/
                $user->save();

                $profile = Profile::where('uid', $user->id)->first();
                if (!$profile)
                {
                    $profile = new Profile();
                    $profile->uid = $user->id;
                    $profile->save();
                }
                $profile->comment = $request->comment;
                $profile->birth_date = HDate_JtoG($request->birthday, '/', true);
                $profile->Province = $request->province;
                $profile->City = $request->city;
                $profile->Mobile = $request->mobile;
                $profile->Tel_number = $request->tel_number;
                $profile->Tel_code = $request->tel_code;
                $profile->Fax_number = $request->fax_number;
                $profile->Fax_code = $request->fax_code;
                $profile->Website = $request->website;
                $profile->save();
            }

            $result['message'][] = trans('acl.role_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function updateUserSpecials(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:user,id',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (auth()->check())
            {
                $user = User::find($request->item_id);
                if (count($request->user_specials))
                {
                    foreach ($request->user_specials as $special)
                    {
                        if (!is_numeric($special))
                        {
                            $keyword = Keyword::where('title', $special)->first();
                            if (!$keyword)
                            {
                                $keyword = new Keyword();
                                $keyword->title = $special;
                                $keyword->save();
                            }
                            $array_keyword_ids[] = $keyword->id;
                        }
                        else
                        {
                            $array_keyword_ids[] = $special;
                        }
                    }
                    $user->specials()->sync($array_keyword_ids);
                }
                else
                {
                    $user->specials()->sync([]);
                }
            }

            $result['message'][] = trans('acl.role_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }

    }

    public function addUserWork(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid' => 'required',
            'province' => 'required|numeric',
            'city' => 'required|numeric',
            'company' => 'required|string|min:3|max:250',
            'section' => 'string|min:3|max:255',
            'post' => 'required|string|min:3|max:250',
            'start_year' => 'required|jalali_date',
            'end_year' => 'required|jalali_date',
        ],
            [],
            [
                'start_year' => 'تاریخ شروع',
                'end_year' => 'تاریخ پایان',
                'post' => 'سمت',
                'company' => 'شرکت'
            ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (auth()->check())
            {
                $user_work = new UserWork();
                $user_work->uid = $request->uid;
                $user_work->company = $request->company;
                $user_work->section = $request->section;
                $user_work->post = $request->post;
                $user_work->province_id = $request->province;
                $user_work->city_id = $request->city;
                $user_work->start_year = $request->start_year;
                $user_work->end_year = $request->end_year;
                $user_work->comment = $request->comment;
                $user_work->save();
            }

            $result['message'][] = trans('acl.role_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function updateUserWork(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
            'uid' => 'required',
            'province' => 'required|numeric',
            'city' => 'required|numeric',
            'company' => 'required|string|min:3|max:250',
            'section' => 'string|min:3|max:255',
            'post' => 'required|string|min:3|max:250',
            'start_year' => 'required|jalali_date',
            'end_year' => 'required|jalali_date',
        ],
            [

            ],
            [
                'start_year' => 'تاریخ شروع',
                'end_year' => 'تاریخ پایان',
                'post' => 'سمت',
                'company' => 'شرکت'
            ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (auth()->check())
            {
                $user_work = UserWork::find($request->item_id);
                $user_work->uid = $request->uid;
                $user_work->company = $request->company;
                $user_work->section = $request->section;
                $user_work->post = $request->post;
                $user_work->province_id = $request->province;
                $user_work->city_id = $request->city;
                $user_work->start_year = $request->start_year;
                $user_work->end_year = $request->end_year;
                $user_work->comment = $request->comment;
                $user_work->save();
            }

            $result['message'][] = trans('acl.role_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function deleteUserWork(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (auth()->check())
            {
                UserWork::find($request->item_id)->delete();
            }

            $result['message'][] = trans('acl.role_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function addUserEducation(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'uid' => 'required',
            'major' => 'required|string|min:3|max:250',
            'grade' => 'required|string',
            'university' => 'string|min:3|max:64',
            'province' => 'required|numeric',
            'city' => 'required|numeric',
            'start_year' => 'required|jalali_date',
            'end_year' => 'required|jalali_date',
        ],
            [

            ],
            [
                'start_year' => 'تاریخ شروع',
                'end_year' => 'تاریخ پایان',
                'major' => 'رشته تحصیلی',
                'grade' => 'مقطع تحصیلی'
            ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (auth()->check())
            {
                $user_education = new UserEducation();
                $user_education->uid = $request->uid;
                $user_education->major = $request->major;
                $user_education->grade = $request->grade;
                $user_education->university = $request->university;
                $user_education->province_id = $request->province;
                $user_education->city_id = $request->city;
                $user_education->start_year = $request->start_year;
                $user_education->end_year = $request->end_year;
                $user_education->comment = $request->comment;
                $user_education->save();
            }

            $result['message'][] = trans('acl.role_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function updateUserEducation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid' => 'required',
            'item_id' => 'required',
            'major' => 'required|string|min:3|max:250',
            'grade' => 'required|string',
            'university' => 'string|min:3|max:64',
            'province' => 'required|numeric',
            'city' => 'required|numeric',
            'start_year' => 'required|jalali_date',
            'end_year' => 'required|jalali_date',
        ],
            [

            ],
            [
                'start_year' => 'تاریخ شروع',
                'end_year' => 'تاریخ پایان',
                'major' => 'رشته تحصیلی',
                'grade' => 'مقطع تحصیلی'
            ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (auth()->check())
            {
                $user_education = UserEducation::find($request->item_id);
                $user_education->uid = $request->uid;
                $user_education->major = $request->major;
                $user_education->grade = $request->grade;
                $user_education->university = $request->university;
                $user_education->province_id = $request->province;
                $user_education->city_id = $request->city;
                $user_education->start_year = $request->start_year;
                $user_education->end_year = $request->end_year;
                $user_education->comment = $request->comment;
                $user_education->save();
            }

            $result['message'][] = trans('acl.role_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function deleteUserEducation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (auth()->check())
            {
                UserEducation::find($request->item_id)->delete();
            }

            $result['message'][] = trans('acl.role_edited_successfully');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    ///////////////////////////////////////////////////////////////////
    //*****************************************************************

    public function user_special_endorse(Request $request)
    {
        $arr = $request->all();

        $s = UserSpecial::with('endorse_users')->where('id',$arr['id'])->first();

        $UserSpecial = UserSpecial::find($arr['id']);

        $UserSpec = $UserSpecial->endorse_users()->wherePivot('user_id', auth()->id())->first();

        if($UserSpec){
            $UserSpecial->endorse_users()->detach([auth()->id()]);
            $count_user_special = $UserSpecial->endorse_users()->select('user.id')->get()->toArray();
            $result['message'] = false;
            $result['count_user_special'] = count($count_user_special);
            return json_encode($result);
        }else{
            $UserSpecial->endorse_users()->attach([auth()->id()]);
            $count_user_special = $UserSpecial->endorse_users()->select('user.id')->get()->toArray();
            $result['message'] = true;
            $result['count_user_special'] = count($count_user_special);
            return json_encode($result);
        }
    }

    public function user_endorse(Request $request)
    {
        $arr = $request->all();
        $UserSpecial = UserSpecial::find($arr['id']);
        $count_user_special = $UserSpecial->endorse_users()->get();
        $i = 0;
        foreach($count_user_special as $res){
            $count_user_special[$i]->avatar=enCode($res->avatar);
            $i++;
        }
        return json_encode($count_user_special);
    }

}
