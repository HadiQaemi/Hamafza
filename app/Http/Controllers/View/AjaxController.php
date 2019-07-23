<?php

namespace App\Http\Controllers\View;

use App\Models\hamafza\Keyword;
use App\Models\hamafza\Pages;
use App\Models\hamafza\Post;
use App\Models\hamafza\Subject;
use App\Models\Hamahang\Bookmark;
use App\Models\Hamahang\Reward;
use App\Models\Hamahang\Score;
use App\User;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\HamafzaViewClasses\PublicClass;
use App\HamafzaViewClasses\FormClass;
use App\HamafzaViewClasses\substclass;
use App\HamafzaServiceClasses\UserClass;
use App\HamafzaServiceClasses\LoginClass;
use App\HamafzaViewClasses\AJAX;
use Auth;
use Illuminate\Support\Facades\DB;
use \App\HamafzaServiceClasses\ConfigurationClass;
use Illuminate\Support\Facades\Validator;
use App\HamafzaServiceClasses\PageClass;
use App\HamafzaServiceClasses\SubjectsClass;
use PDF;

class AjaxController extends Controller
{

    public function deletesubject(Request $request)
    {
        if (!auth()->check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        } else
        {
            $sid = $request->input('sid');
            $type = $request->input('type');
            $uid = auth()->id();
            $message = null;
            $error = false;
            $redirect_to_home = 0;
            $users = DB::table('subjects')->where('id', $sid)->select('manager', 'supporter', 'supervisor', 'admin')->first();

            $subject = Subject::findOrFail($sid);
            $access_edit_in_user = in_array(Auth::id(), array_column($subject->user_policies_edit->toArray(), 'id'));
            $user = User::where('id', Auth::id())->first();
            $roles = $user->_roles->toArray();
            foreach($roles as $Arole)
            {
                $access_edit_in_role = in_array($Arole['id'], array_column($subject->role_policies_edit->toArray(), 'id'));
                if($access_edit_in_role)
                    break;
            }
            if(($access_edit_in_user || $access_edit_in_role) || $subject->toArray()['admin']==Auth::id())
//            if ($users && ($users->manager == $uid || $users->supporter == $uid || $users->supervisor == $uid || $users->admin == $uid || '1' == UserClass::permission('DelSubjects', $uid)))
            {
                if ($type == 'recycle')
                {
                    DB::table('subjects')->where('id', $sid)->update(array('archive' => '1'));
                    Bookmark::where('target_table', 'App\Models\hamafza\Subject')->where('target_id', $sid)->delete();
                    /*
                    $pages = DB::table('pages')->where('sid', $sid)->select('id')->get();
                    foreach ($pages as $page)
                    {
                        DB::table('bookmarks')->where('link', $page->id)->delete();
                    }
                    */
                    $message = trans('labels.deleteOK');
                    $error = false;
                } else if ($type == 'delete')
                {
                    DB::table('subjects')->where('id', $sid)->update(array('archive' => '0'));
                    // DB::table('subject_key')->where('sid', $sid)->delete();
                    DB::table('pages')->where('sid', $sid)->delete();
                    DB::table('subjects')->where('id', $sid)->delete();
                    //  DB::table('subjectsup')->where('sid', $sid)->delete();
                    DB::table('subjects_rel')->where('sid1', $sid)->delete();
                    DB::table('subjects_rel')->where('sid2', $sid)->delete();
                    DB::table('process_subject')->where('sid', $sid)->delete();
                    DB::table('process_phase_subject')->where('sid', $sid)->delete();
                    DB::table('process_phase_subject')->where('sid', $sid)->delete();
                    $message = trans('labels.deletefinalOK');
                    $error = false;
                    $redirect_to_home = 1;
                } else
                {
                    if ($type == 'restore')
                    {
                        DB::table('subjects')->where('id', $sid)->update(array('archive' => '0'));
                        $message = trans('labels.restoreOK');
                        $error = false;
                    }
                }
            } else
            {
                $message = 'شما اجازه حذف ندارید.';
                $error = true;
            }
            return response()->json([$message, $error, $redirect_to_home]);
            //   return Redirect()->to('/'.$sid)->with('message', $mes)->with('mestype', 'error');
        }
    }










    public function GetSubjectFields(Request $request)
    {
        $kind = $request->input('kind');
        $uid = Auth::id();
        $sesid = 0;
        $s = SubjectsClass::Fields($uid, $sesid, $kind);
        $Fields = json_decode($s['Fields']);
        $str = '';
        $str .= '<table style="vertical-align: middle; width:100%">';
        if (is_array($s))
        {
            $keywords = '';
            if ($s['tag']['select'])
            {
                $req2 = '0';
                $req = '';
                if ($s['tag']['require'])
                {
                    $req = ' <font color="red">*</font>';
                    $req2 = '1';
                }
                $str .= '<tr>';
                $str .= '<td width="120">کلیدواژه‌ها' . $req . '</td></td><td>';
                $str .= '<input type="text" id="PS_Tags" name="keywords" />';
                $str .= '<script>$("#PS_Tags").tokenInput("Tagsearch", {
preventDuplicates: true,
        hintText: "عبارتی را وارد کنید",
        searchingText: "در حال جستجو",
    });</script>';
                // $keywords = (isset($keywords) ? $keywords : array() );
                //$admins->auto_keywords('keywords', $req2, '400', $keywords, 'chzn-select');
                $str .= '</td>';
                $str .= '</tr>';
            }
            if ($s['department']['select'])
            {
                $req2 = '0';
                $req = '';
                if ($s['department']['require'])
                {
                    $req = ' <font color="red">*</font>';
                    $req2 = '1';
                }
                //$groups = (isset($groups) ? $groups : array() );
                //$str=$admins->auto_groups('group', $req2, '400', $groups);
                $strs = '';
                $str .= '<tr>';
                $str .= '<td width="120">درگاه' . $req . '</td><td><div style="position:fix;">' . $strs . '</div></td>';
                $str .= '</tr>';
            }


            if ($s['proc']['select'])
            {
                $req2 = '0';
                $req = '';
                if ($s['proc']['require'])
                {
                    $req = ' <font color="red">*</font>';
                    $req2 = '1';
                }

                //$str = $admins->selectProcess($req2);
                $strs = '';
                $str .= '<tr>';
                $str .= '<td width="120">' . 'فرآیند' . $req . '</td><td><div style="position:fix;">' . $strs . '</div></td>';
                $str .= '</tr>';
            }

            if ($s['manager']['select'])
            {
                $req2 = '';
                $req = '';
                if ($s['manager']['require'])
                {
                    $req = ' <font color="red">*</font>';
                    $req2 = ' required';
                }
                $str .= '<tr>';
                $str .= '<td width="120">' . $s['manager']['title'] . $req . '</td><td><input class="form-control col-xs-6" name="manager" placeholder="" type="text" dir="rtl" value="" class="field person" style="width:400px;"  ' . $req2 . '/></td>';
                $str .= '</tr>';
            }
            if ($s['supervisor']['select'])
            {
                $req2 = '';
                $req = '';
                if ($s['supervisor']['require'])
                {
                    $req = ' <font color="red">*</font>';
                    $req2 = ' required';
                }
                $str .= '<tr>';
                $str .= '<td width="120">' . $s['supervisor']['title'] . $req . '</td><td><input class="form-control col-xs-6" name="manager" placeholder="" type="text" dir="rtl" value="" class="field person" style="width:400px;"  ' . $req2 . '/></td>';
                $str .= '</tr>';
            }
            if ($s['supporter']['select'])
            {
                $req2 = '';
                $req = '';
                if ($s['supporter']['require'])
                {
                    $req = ' <font color="red">*</font>';
                    $req2 = ' required';
                }
                $str .= '<tr>';
                $str .= '<td width="120">' . $s['supporter']['title'] . $req . '</td><td><input class="form-control col-xs-6" name="manager" placeholder="" type="text" dir="rtl" value="" class="field person" style="width:400px;"  ' . $req2 . '/></td>';
                $str .= '</tr>';
            }

            if (is_array($Fields))
            {
                foreach ($Fields as $key => $val)
                {
                    $str .= '<tr>';
                    $field_name = $val->name;
                    $field_type = $val->type;
                    $field_value = $val->defvalue;
                    $field_value = explode('|', $field_value);
                    $requires = $val->requires;
                    $Desc = $val->help;
                    $field_id = $val->id;
                    $str .= PublicClass::Newfield_view_bySedc($field_id, $field_name, $field_type, $field_value, $requires, $Desc);
                    $str .= '</tr>';
                }
            }
            $str . '</table>';
        }
        return $str;
    }

    public function AddCircle(Request $request)
    {
        $uid = (session('uid') != '') ? session('uid') : 0;
        $sesid = (session('SessionID') != '' && session('SessionID') != '') ? session('SessionID') : 0;
        $targetuid = $request->input('uid');
        $circle = $request->input('circle');
        $In = $request->input('In');
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

    public function Groupsearch(Request $request)
    {
        $uid = (session('uid') != '' && session('uid') != '') ? session('uid') : 0;
        $search = $request->input('q');
        return DB::table('user_group as g')->leftJoin('user_group_member as m', 'g.id', '=', 'm.gid')->where('m.uid', $uid)->whereRaw(" (m.admin = '1' || m.relation = '2') and name Like '%$search%'")->distinct()->select('g.id', 'g.name')->get();
    }

    public function PageWallPaging(Request $request)
    {
        $postid = $request->input('postid');
        $sid = $request->input('Uname');
        $cuid = (session('uid') != '' && session('uid') != '') ? session('uid') : 0;
        $sesid = (session('SessionID') != '' && session('SessionID') != '') ? session('SessionID') : 0;
        $uid = $cuid;
        $SP = new service();
        $name = $SP->ServicePost('SubjectWallJson', 'sid=' . $sid . '&cuid=' . $cuid . '&postid=' . $postid);
        // return 'SubjectWallJson'. 'sid=' . $sid . '&cuid=' . $cuid.'&postid='.$postid;
        $json_a = json_decode($name, true);
        $user_data = $json_a['data'];
        return AJAX::GetUserContentPaging($user_data);
    }

    public function GroupContentsPaging(Request $request)
    {
        $postid = $request->input('postid');
        $uname = $request->input('Uname');
        $cuid = (session('uid') != '' && session('uid') != '') ? session('uid') : 0;
        $sesid = (session('SessionID') != '' && session('SessionID') != '') ? session('SessionID') : 0;
        $uid = $cuid;
        $SP = new service();
        $name = $SP->ServicePost('GroupContentsPaging', 'gname=' . $uname . '&cuid=' . $cuid . '&postid=' . $postid);
        // return 'GroupContentsPaging'. 'uname=' . $uname . '&cuid=' . $cuid.'&postid='.$postid;
        $json_a = json_decode($name, true);
        $user_data = $json_a['posts'];
        return AJAX::GetUserContentPaging($user_data);
    }

    public function GetWallByPaging(Request $request)
    {
        $postid = $request->input('postid');
        $uname = $request->input('Uname');
        $cuid = (session('uid') != '' && session('uid') != '') ? session('uid') : 0;
        $sesid = (session('SessionID') != '' && session('SessionID') != '') ? session('SessionID') : 0;
        $uid = $cuid;
        $SP = new service();
        $name = $SP->ServicePost('GetWallByPaging', 'uname=' . $uname . '&cuid=' . $cuid . '&postid=' . $postid);
        // return 'GetWallByPaging'. 'uname=' . $uname . '&cuid=' . $cuid.'&postid='.$postid;
        $json_a = json_decode($name, true);
        $user_data = $json_a['posts'];
        return AJAX::GetUserContentPaging($user_data);
    }

    public function GetUserContentPaging(Request $request)
    {
        $postid = $request->input('postid');
        $uname = $request->input('Uname');
        $cuid = (session('uid') != '' && session('uid') != '') ? session('uid') : 0;
        $sesid = (session('SessionID') != '' && session('SessionID') != '') ? session('SessionID') : 0;
        $uid = $cuid;
        $SP = new service();
        $name = $SP->ServicePost('GetUserContentPaging', 'uname=' . $uname . '&cuid=' . $cuid . '&postid=' . $postid);
        // return 'GetUserContentPaging'. 'uname=' . $uname . '&cuid=' . $cuid.'&postid='.$postid;
        $json_a = json_decode($name, true);
        $user_data = $json_a['posts'];
        return AJAX::GetUserContentPaging($user_data); //.'GetUserContentPaging'. 'uname=' . $uname . '&cuid=' . $cuid.'&postid='.$postid;
    }

    public function FormReports(Request $request)
    {
        $keyword = $request->input('id');
        $SP = new service();
        $menu = $SP->ServicePost('FormReports', 'id=' . $keyword);
        $json_a = json_decode($menu, true);
        $s = $json_a['data'];
        return $s;
    }

    public function FormField(Request $request)
    {
        $menu = DB::table('forms as f')->join('forms_field as ff', 'f.id', '=', 'ff.form_id')
            ->where('f.id', $request->input('id'))
            ->select('ff.id', 'ff.field_name')->get();
        $s = json_decode($menu, true);
        //$s = $json_a['data'];
        return $s;
    }

    public function Tessearch(Request $request)
    {
        $keyword = $request->input('q');
        $urls = DB::table('subjects as s')
            ->join('subject_type_tab AS sk', 's.kind', '=', 'sk.stid')->where('sk.type', '20')
            ->select('s.title as name', 's.id')
            ->groupby('s.id')->get();
        return $urls;
    }










    public function Helpsearch(Request $request)
    {
        $keyword = $request->input('q');
        $page = array();
        $pages = DB::table('pages as p')->join('subjects as s', 's.id', '=', 'p.sid')->select('p.id', 's.title', 'p.body')->whereRaw("body like '%{{Help+%=%$keyword%}%'")->where('s.kind', '4')->get();
        $op = '';
        $ss = array();
        $i = 1;
        foreach ($pages as $page)
        {
            $body = $page->body;
            $pattern = "/{{Help\+.*=.*}}/";
            if ($num1 = preg_match_all($pattern, $body, $array))
            {
                for ($x = 0; $x < $num1; $x++)
                {
                    $orig = $array['0'][$x];
                    $key = str_replace("{{Help+", "", $array['0'][$x]);
                    $key = str_replace("}}", "", $key);
                    $pos = strpos($key, "=");
                    $key = substr($key, $pos + 1, strlen($key) - $pos);
                    $s = array("id" => $orig, "name" => $key);
                    $i++;
                    array_push($ss, $s);
                }
            }
        }
        $ss = json_encode($ss, true);
        return $ss;
    }










    public function showhelprel(Request $request)
    {
        $ContentHelps = $request->input('Helpnames');
        $helppage = $request->input('helppage');
        $v = $ContentHelps;
        $tag = str_replace("{{Help+", "", $ContentHelps);
        $tag = str_replace("}}", "", $tag);
        $pos = strpos($tag, "=");
        $tag = substr($tag, 0, $pos);
        $page = DB::table('page_help_groups')->where('rpid', $helppage)->where('R', $ContentHelps)->get();
        $page = json_encode($page);
        $page = json_decode($page);
        foreach ($page as $value)
        {
            $v = $value->T;
            $key = str_replace("{{Help+", "", $v);
            $key = str_replace("}}", "", $key);
            $pos = strpos($key, "=");
            $key = substr($key, $pos + 1, strlen($key) - $pos);
            $value->Tname = $key;
            $value->RID = $v;
        }
        $pages = DB::table('page_help_groups')->where('tpid', $helppage)->where('T', $ContentHelps)->get();
        foreach ($pages as $value)
        {
            $v = $value->R;
            $key = str_replace("{{Help+", "", $v);
            $key = str_replace("}}", "", $key);
            $pos = strpos($key, "=");
            $key = substr($key, $pos + 1, strlen($key) - $pos);
            $value->Tname = $key;
            $value->RID = $v;
        }
        if ($page)
        {
            $page = array_merge($page, $pages);
        }
        else
        {
            $page = $pages;
        }
        $pos = 0;
        $pos2 = 0;
        $tit = '';
        $TagName = '';
        $body = '';
        $newrow = DB::table('pages as p')->select('p.id', 'p.sid', 'p.body', 'p.form', 'p.view', 'p.edit', 'p.ver_date')->where('p.id', $id)->first();
        if ($newrow)
        {
            $body = $newrow->body;
        }

        $op = '';
        $pattern = "/{{Help\+$tag=.*}}/";
        if ($num1 = preg_match_all($pattern, $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $key = $array['0'][$x];
                $TagName = $key;
            }
        }

        $pattern = "/=.*}}/";
        if ($num1 = preg_match_all($pattern, $TagName, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $key = $array['0'][$x];
            }
            $tit = str_replace('=', '', $key);
            $tit = str_replace('}}', '', $tit);
        }

        $pattern = "/{{Help\+$tag=.*}}/";
        if ($num1 = preg_match_all($pattern, $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $key = $array['0'][$x];
                $pos = strpos($body, $key);
                $TagName = $key;
            }
        }
        $pattern = "/{{Help-$tag}}/";
        if ($num1 = preg_match_all($pattern, $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $key = $array['0'][$x];
                $pos2 = strpos($body, $key);
            }
        }
        $bodlen = strlen($body);
        if ($pos > 0 && $pos2)
        {
            $body = substr($body, $pos, $pos2 - $pos) . "<br>";
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
        return view('modals.helprel', array('orig' => $ContentHelps, 'pid' => $helppage, 'Rel' => $page, 'body' => $body));
    }

    public function showhelps(Request $request)
    {
        $keyword = $request->input('keyword');
        $page = array();
        $page = DB::table('pages as p')->where('id', $keyword)->first();
        $op = '';

        if ($page)
        {
            $body = $page->body;
            $pattern = "/{{Help\+.*=.*}}/";
            if ($num1 = preg_match_all($pattern, $body, $array))
            {
                for ($x = 0; $x < $num1; $x++)
                {
                    $orig = $array['0'][$x];
                    $key = str_replace("{{Help+", "", $array['0'][$x]);
                    $key = str_replace("}}", "", $key);
                    $pos = strpos($key, "=");
                    $key = substr($key, $pos + 1, strlen($key) - $pos);
                    $op .= $orig . ':' . $key . ';';
                }
            }
        }
        return $op;
    }

    public function GetPoodmanNode(Request $request)
    {
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
        $id = $request->input('id');
        $SP = new service();
        $menu = $SP->ServicePost('GetPoodmanNode', 'uid=' . $uid . '&sesid=' . $sesid . '&id=' . $id);
        $json_a = json_decode($menu, true);
        $s = $json_a['data'];
        return $s;
        return $mes;
    }

    public function AcceptUser2Group(Request $request)
    {
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
        $Cuid = $request->input('uid');
        $Gid = $request->input('gid');
        $e = $request->input('e');
        $SP = new \App\HamafzaServiceClasses\GroupsClass();
        $menu = $SP->AcceptUser2Group($uid, $sesid, $Gid, $Cuid, $e);
        //echo 'AcceptUser2Group', 'uid=' . $uid . '&sesid=' . $sesid . '&gid=' . $Gid.'&cuid='.$Cuid.'&add=1';
        return $menu;
    }

    public function addGroup(Request $request)
    {
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
        $Gid = $request->input('gid');
        $SP = new \App\HamafzaServiceClasses\GroupsClass();
        $menu = $SP->AddtoGroup($uid, $sesid, $Gid);
        //   echo 'AddtoGroup'. 'uid=' . $uid . '&sesid=' . $sesid . '&gid=' . $Gid;
        
        
       /* $UP = new UserClass();
          $menu = $UP->GetMyOrganGroups($uid, '');
        
        session('MyOrganGroups', $json_a['data']);*/
        return $menu;
    }

    public function changepageview(Request $request)
    {
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
        $pid = $request->input('pid');
        $sel = $request->input('sel');
        $view = $request->input('view');
        if (!Auth::check())
        {
            $mes = 'عدم دسترسی';
        }
        else
        {
            if ($view == 'ShowText')
            {
                DB::table('pages')->where('id', $pid)->update(array('viewtext' => $sel));
            }
            if ($view == 'ShowSlide')
            {
                DB::table('pages')->where('id', $pid)->update(array('viewslide' => $sel));
            }
            if ($view == 'ShowFilm')
            {
                DB::table('pages')->where('id', $pid)->update(array('viewfilm' => $sel));
            }
            $err = false;
            $mes = 'تغییرات انجام شد';
            return $mes;
        }
        return $mes;
    }

    public function searchPerson(Request $request)
    {
        $uid = Auth::id();
        $keyword = $request->input('key');
        $type = $request->input('type');
        $SP = new UserClass();
        $s = $SP->searchPerson($uid = 0, $keyword, $type);
        $res = '<ul class="person-list GroupList row">';
        if ($type == '1')
        {
            foreach ($s as $value)
            {
                $pic = 'pics/user/Users.png';
                if ($value->Pic != '')
                {
                    if (file_exists('pics/user/' . $value->id . '-' . $value->Pic))
                    {
                        $pic = 'pics/user/' . $value->id . '-' . $value->Pic;
                    }
                    else
                    {
                        if (file_exists('pics/user/' . $value->Pic))
                        {
                            $pic = 'pics/user/' . $value->Pic;
                        }
                    }
                }else{
                    $pic = route('FileManager.DownloadFile', ['type' => 'ID', 'id' => $value->avatar ? enCode($value->avatar) : -1, 'default_img' => 'user_avatar.png']);
                }
                $res .= '<li  class="selected" id="SelUser_181" types="multi" ><a  target="_blank" href="' . url('/') . '/' . $value->Uname . '"><img class="person-avatar mCS_img_loaded" src="' . $pic . '"></a><div class="person-detail"><div class="close"></div><div class="person-name"><a target="_blank" href="' . url('/') . '/' . $value->Uname . '">' . $value->Name . ' ' . $value->Family . '</a></div><div class="ssperson-moredetail text-align-right text-justify">' . $this->substr_word($value->Summary,100) . '</div><div class="person-relation"></div></div></li>';
            }
        }
        else
        {
            foreach ($s as $value)
            {
                $pic = 'pics/group/Groups.png';
                if ($value->pic != '')
                {
                    if (file_exists('pics/group/' . $value->id . '-' . $value->pic))
                    {
                        $pic = 'pics/group/' . $value->id . '-' . $value->pic;
                    }
                    else
                    {
                        if (file_exists('pics/group/' . $value->pic))
                        {
                            $pic = 'pics/group/' . $value->pic;
                        }
                    }
                }
                $subWord = $this->substr_word($value->summary,100);
//                $subWord = ($value->summary);
                $res .= '<li  class="selected" id="SelUser_181" types="multi" ><a  target="_blank" href="' . url('/') . '/' . $value->link . '"><img class="person-avatar mCS_img_loaded" src="' . $pic . '"></a><div class="person-detail"><div class="close"></div><div class="person-name"><a target="_blank" href="' . url('/') . '/' . $value->link . '">' . $value->name . ' ('.$value->post_view_count()->count().')' . '</a></div><div class="person-moredetail text-align-right text-justify">' . $subWord. '</div><div class="person-relation"></div></div></li>';
            }
        }
        return $res . '</ul>';
        return $mes;
    }
    public function substr_word($body,$maxlength){
        if (strlen($body)<$maxlength)
            return $body;
        $body = substr($body, 0, $maxlength);
        $rpos = strrpos($body,' ');
        if ($rpos>0)
            $body = substr($body, 0, $rpos);
        return $body.'...';
    }
    public function searchUser(Request $request)
    {
        $keyword = $request->input('query');
        $SP = new \App\HamafzaServiceClasses\UserClass();
        $s = '';

        if ($keyword != '' && strlen($keyword) > 3)
        {
            $uid = 0;
            $term = $keyword;
            $type = 0;
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
                    ->select('u.id', 'u.Uname', 'u.Name', 'u.Family', 'u.Summary', 'u.Pic')->get();
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
                $Groups = DB::table('user_group')->whereRaw("link LIKE '%$term%' OR name LIKE '%$term%' OR summary LIKE '%$term%' and isorgan='0'")
                    ->select('id', 'name', 'link', 'summary', 'pic')->get();
                return $Groups;
            }
            if ($type == 3)
            {
                $Organs = DB::table('user_group')->whereRaw("link LIKE '%$term%' OR name LIKE '%$term%' OR summary LIKE '%$term%' and isorgan='0'")
                    ->select('id', 'name', 'link', 'summary', 'pic')->get();
                return $Organs;
            }
        }
    }

    /*
    public function SearchTags(Request $request)
    {
        $keyword = $request->input('keyword')?$request->input('keyword'):'-1';
        $Pagess = '';
        $Postss = '';
        $Userss = '';
        $Groupss = '';
        $Pages = '';
        $Users = array();
        $myArray = explode(',', $keyword);
        $i = 1;
        $sql = '';
        foreach ($myArray as &$value)
        {
            $sql = "DROP TEMPORARY TABLE IF EXISTS t{$i};";
            DB::unprepared(DB::raw($sql));

            $sql = "CREATE TEMPORARY TABLE t{$i} select * from subject_key where kid={$value};";
            $productList = DB::insert(DB::raw($sql));
            $sql = "DROP TEMPORARY TABLE IF EXISTS p{$i};";
            DB::unprepared(DB::raw($sql));

            $sql = "CREATE TEMPORARY TABLE p{$i} select * from post_keys where kid={$value};";
            $productList = DB::insert(DB::raw($sql));


            $sql = "DROP TEMPORARY TABLE IF EXISTS g{$i};";
            DB::unprepared(DB::raw($sql));

            $sql = "CREATE TEMPORARY TABLE g{$i} select * from user_group_key where kid={$value};";
            $productList = DB::insert(DB::raw($sql));
            $i++;
        }
        --$i;
        $subsql = '';
        switch ($i)
        {
            case 1:
                $subsql = "select t1.sid from t1  group by t1.sid ";
                $subsql2 = "select p1.pid from p1  group by p1.pid ";
                $subsql3 = "select g1.gid from g1  group by g1.gid ";
                break;
            case 2:
                $subsql = "select t1.sid from t1 inner join t2  ON t1.sid=t2.sid  group by t1.sid ";
                $subsql2 = "select p1.pid from p1 inner join p2  ON p1.pid=p2.pid group by p1.pid ";
                $subsql3 = "select g1.gid from g1 inner join g2  ON g1.gid=g2.gid group by g1.gid ";

                break;
            case 3:
                $subsql = "select t1.sid from t1 inner join t2  ON t1.sid=t2.sid inner join t3  ON t1.sid=t3.sid group by t1.sid ";
                $subsql2 = "select p1.pid from p1 inner join p2  ON p1.pid=p2.pid inner join p3  ON p1.pid=p3.pid group by p1.pid ";
                $subsql3 = "select g1.gid from g1 inner join g2  ON g1.gid=g2.gid inner join g3  ON g1.gid=g3.gid group by g1.gid ";
                break;
        }


        $mSql2 = "SELECT  CONCAT(LEFT(p.desc, 50),'...') as matn,p.id as pid,sid,p.uid,u.Uname
					FROM
						posts as p inner join `user` as u on p.uid=u.id

					WHERE p.id in ({$subsql2}) ";

        $Posts = DB::select(DB::raw($mSql2));

        $mSql3 = "select ug.name,ug.link,ug.id from user_group as ug INNER JOIN user_group_key as ugk on ug.id=ugk.gid
					WHERE ug.id in ({$subsql3}) group by ug.id";

        $Groups = DB::select(DB::raw($mSql3));

        if ($i > 1)
        {
            $mSql = "SELECT p.id as pid, p.sid , s.title as title ,st.pretitle, s.kind , p.type
					FROM
						pages as p
					RIGHT JOIN
						subjects as s
					ON
						p.sid = s.id
                                                join
						subject_type as st
					ON
						st.id = s.kind
					WHERE  s.archive = 0 and (s.kind=3)  AND s.id in ({$subsql}) AND " . PageClass::Sel_Page();
            $Daneshnameh = DB::select(DB::raw($mSql));
            $mSql = "SELECT p.id as pid, p.sid , s.title as title ,st.pretitle, s.kind , p.type
					FROM
						pages as p
					RIGHT JOIN
						subjects as s
					ON
						p.sid = s.id
                                                join
						subject_type as st
					ON
						st.id = s.kind
					WHERE  s.archive = 0 and (s.kind=27)  AND s.id in ({$subsql}) AND " . PageClass::Sel_Page();
            $Dargah = DB::select(DB::raw($mSql));

            $mSql = "SELECT p.id as pid, p.sid , s.title as title ,st.pretitle, s.kind , p.type
					FROM
						pages as p
					RIGHT JOIN
						subjects as s
					ON
						p.sid = s.id
                                                join
						subject_type as st
					ON
						st.id = s.kind
					WHERE  s.archive = 0 and (s.kind!=3 or s.kind!=27) AND s.id in ({$subsql}) AND " . PageClass::Sel_Page();


            $Pages = DB::select(DB::raw($mSql));
            $res['Pages'] = $Pages;
            $res['Dargah'] = $Dargah;
            $res['Daneshnameh'] = $Daneshnameh;
            $res['Pages'] = $Pages;
            $res['Users'] = '';
            $res['Groups'] = '';
            $res['Posts'] = '';
        }
        else
        {
            if ($i == 1)
            {
                $d = DB::table('pages as p')
                    ->rightJoin('subjects AS s', 'p.sid', '=', 's.id')
                    ->leftJoin('subject_key AS c', 's.id', '=', 'c.sid')
                    ->leftJoin('subject_type as st', 'st.id', '=', 's.kind')
                    ->whereRaw('(s.kind!=3 or s.kind!=27)')
                    ->where('s.archive', '0')
                    ->where('c.kid', $keyword)
                    ->whereRaw(PageClass::Sel_Page())
                    ->select('p.id as pid', 'p.sid', 'st.pretitle', 's.title as title', 's.kind', 'p.type')
                    ->get();
                $Daneshnameh = DB::table('pages as p')
                    ->rightJoin('subjects AS s', 'p.sid', '=', 's.id')
                    ->leftJoin('subject_key AS c', 's.id', '=', 'c.sid')
                    ->leftJoin('subject_type as st', 'st.id', '=', 's.kind')
                    ->where('s.kind', '3')
                    ->where('s.archive', '0')
                    ->where('c.kid', $keyword)
                    ->whereRaw(PageClass::Sel_Page())
                    ->select('p.id as pid', 'p.sid', 'st.pretitle', 's.title as title', 's.kind', 'p.type')
                    ->get();
                $Dargah = DB::table('pages as p')->rightJoin('subjects AS s', 'p.sid', '=', 's.id')
                    ->leftJoin('subject_key AS c', 's.id', '=', 'c.sid')
                    ->leftJoin('subject_type as st', 'st.id', '=', 's.kind')
                    ->where('s.kind', '27')
                    ->where('s.archive', '0')
                    ->where('c.kid', $keyword)->whereRaw(PageClass::Sel_Page())
                    ->select('p.id as pid', 'p.sid', 'st.pretitle', 's.title as title', 's.kind', 'p.type')
                    ->get();
                $Pages = $d;
                $U1 = array();
                $U2 = array();
                $U3 = array();

                $USERS = $U3 + $U1 + $U2;
                $res['Users'] = $USERS;
                $res['Groups'] = $Groups;
                $res['Pages'] = $Pages;
                $res['Dargah'] = $Dargah;
                $res['Daneshnameh'] = $Daneshnameh;
                $res['Posts'] = $Posts;
            }
        }
        $s = $res;

        if (is_array($s['Users']))
        {
            foreach ($s['Users'] as $row)
            {
                $Userss .= '<li style="list-style: inside none square;"><a href="' . url('/') . '/' . $row->Uname . '">' . $row->Name . ' ' . $row->Family . '</a></li>';
            }
            if ($Userss != '')
            {
                $Userss = '<div><h1 id="b1" class="heading" style="font-size: 12pt;font-weight: bold;"><span class="icon icon-open"></span>کاربران</h1>'
                    . '<div ><ul>' . $Userss . '</ul></div></div>';
            }
        }
        if (is_array($s['Groups']))
        {
            foreach ($s['Groups'] as $row)
            {
                $Groupss .= '<li style="list-style: inside none square;"><a target="_blank" href="' . url('/') . '/' . $row->link . '/intro" rel="canonical">' . $row->name . '</a></li> ';
            }
            if ($Groupss != '')
            {
                $Groups = '<div><h1 id="b1" class="heading" style="font-size: 12pt;font-weight: bold;"><span class="icon icon-open"></span>گروه‌ها   </h1>'
                    . '<div ><ul>' . $Groupss . '</ul></div></div>';
            }
        }
        if (count($s['Pages']) > 0)
        {
            foreach ($s['Pages'] as $row)
            {
                $Pagess .= '<li style="list-style: inside none square;"><a target="_blank" href="' . url('/') . '/' . $row->pid . '" rel="canonical">' . $row->title . '</a></li> ';
            }
            if ($Pagess != '')
            {
                $Pagess = '<div ><h1 id="b1" class="heading" style="font-size: 12pt;font-weight: bold;"><span class="icon icon-open"></span>صفحات   </h1>'
                    . '<div ><ul>' . $Pagess . '</ul></div></div>';
            }
        }

        if (is_array($s['Posts']))
        {
            foreach ($s['Posts'] as $row)
            {
                if ($row->sid != '0')
                {
                    $Postss .= '<li style="list-style: inside none square;"><a target="_blank" href="' . url('/') . '/' . $row->sid . '/forum#post-' . $row->pid . '" rel="canonical">' . $row->matn . '</a></li> ';
                }
                else
                {
                    $Postss .= '<li style="list-style: inside none square;"><a target="_blank" href="' . url('/') . '/' . $row->Uname . '?tab=contents#post-' . $row->pid . '" rel="canonical">' . $row->matn . '</a></li> ';
                }
            }
            if ($Postss != '')
            {
                $Postss = '<div><h1 id="b1" class="heading" style="font-size: 12pt;font-weight: bold;"><span class="icon icon-open"></span>مطالب   </h1>'
                    . '<div ><ul>' . $Postss . '</ul></div></div>';
            }
        }
        $Dargahs = '';
        if (is_array($s['Dargah']))
        {
            foreach ($s['Dargah'] as $row)
            {
                $Dargahs .= '<li style="list-style: inside none square;"><a target="_blank" href="' . $row->pid . '" rel="canonical">' . $row->pretitle . ' ' . $row->title . '</a></li> ';
            }
            if ($Dargahs != '')
            {
                $Dargahs = '<div ><h1 id="b1" class="heading" style="font-size: 12pt;font-weight: bold;"><span class="icon icon-open"></span>درگاه‌ها</h1>'
                    . '<div ><ul>' . $Dargahs . '</ul></div></div>';
            }
        }
        $Daneshnamehs = '';
        if (is_array($s['Daneshnameh']))
        {
            foreach ($s['Daneshnameh'] as $row)
            {
                $Daneshnamehs .= '<li style="list-style: inside none square;"><a target="_blank" href="' . $row->pid . '" rel="canonical">' . $row->pretitle . ' ' . $row->title . '</a></li> ';
            }
            if ($Daneshnamehs != '')
            {
                $Daneshnamehs = '<div ><h1 id="b1" class="heading" style="font-size: 12pt;font-weight: bold;"><span class="icon icon-open"></span>دانشنامه</h1>'
                    . '<div ><ul>' . $Daneshnamehs . '</ul></div></div>';
            }
        }

        if ($Pagess != '' || $Postss != '' || $Userss != '' || $Groupss != '')
        {
            session('TagSearch', '<ul id="kwts">' . $Pagess . $Postss . $Userss . $Groupss . '</ul>');
            return '<ul id="kwts">' . $Userss . $Pagess . $Postss . $Groupss . '</ul>';
        }
        else
        {
            session('TagSearch', 'جستجو نتیجه ای در برنداشت');
            return '<ul id="kwts">جستجو نتیجه ای در برنداشت</ul>';
        }
    }
    */

    public function pophelp(Request $request)
    {
        $pid = $request->input('pid');
        $tagname = $request->input('tagname');
        $SP = new service();
        $menu = $SP->ServicePost('pophelp', 'pid=' . $pid . '&tagname=' . $tagname);
        return $menu;
    }

    public function GetTreeNode(Request $request)
    {
        $searchword = $request->input('ptid');
        $SP = new \App\HamafzaServiceClasses\PublicsClass();
        $menu = $SP->GetTreeNode($searchword);
        return $menu;
    }

    public function GetTreeNodes(Request $request)
    {
        $rows = '';
        if ($request->input('ptid'))
        {
            $searchword = $request->input('ptid');
            $row = DB::table('page_tree as pt')
                ->select('pt.id', 'pt.name', 'parent_id', 'pt.id as url', 'pt.*')
                ->where('pt.id', '>', $searchword)
                ->where('pt.parent_id', '0')
                ->orderBy('pt.parent_id')
                ->orderBy('pt.orders')
                ->take(1)
                ->orderBy('pt.id')->get();
            $PC = new PageClass();
            if ($row)
            {
                $rows = $PC->PageTreeBody($row);
                foreach ($row as $value)
                {
                    $rows .= '<input type="hidden" class="ptid" value="' . $value->id . '">';
                }
            }
        }
        return $rows;
    }

    /*
    public function search(Request $request)
    {
        $searchword = $request->input('searchw');
        $quote = '';
        $all = '';
        $any = '';
        $none = '';
        if ($searchword != '')
        {
            $searchword = PublicClass::Filter($searchword);
            $quote = '';
            $remain_string = stripslashes($searchword);
            if ($num = preg_match_all("/\"(.*?)\"/", $remain_string, $array))
            {
                for ($y = 0; $y < count($array['0']); $y++)
                {
                    $quote = $array['1'][$y];
                    $remain_string = str_replace($array['0'][$y], '', $remain_string);
                }
            }
            $all = '';
            $any = '';
            $none = '';
            $split = explode(' ', $remain_string);
            foreach ($split as $val)
            {
                $val = trim($val);
                if (substr($val, 0, 1) == '+')
                {
                    $all .= substr($val, 1) . ' ';
                }
                elseif (substr($val, 0, 1) == '-')
                {
                    $none .= substr($val, 1) . ' ';
                }
                else
                {
                    $any .= $val . ' ';
                }
            }
        }

        $new_string = '';
        if ((!$quote) || ($quote == ''))
        {
            $new_string .= '';
        }
        else
        {
            $new_string .= '"' . $quote . '" ';
        }
        if ((!$all) || ($all == ''))
        {
            $new_string .= '';
        }
        else
        {
            $new_string .= '+(' . $all . ') ';
        }
        if ((!$any) || ($any == ''))
        {
            $new_string .= '';
        }
        else
        {
            $new_string .= $any . ' ';
        }
        if ((!$none) || ($none == ''))
        {
            $new_string .= '';
        }
        else
        {
            $new_string .= '-(' . $none . ') ';
        }
        if (trim($new_string) != '')
        {
            $rows = DB::table('synonym')->select('first', 'second')->get();
            foreach ($rows as $row)
            {
                if (strstr($new_string, $row->first))
                {
                    $new_string .= str_replace($row->first, $row->second, $new_string) . ' ';
                }
                elseif (strstr($new_string, $row->second))
                {
                    $new_string .= str_replace($row['second'], $row->first, $new_string) . ' ';
                }
            }
        }
        $n = 0;
        $new_string = trim($new_string);
        $result = array();
        if ($request->exists('search_in_pages') || !$request->exists('search_in_posts'))
        {
            if (trim($new_string) != '')
            {
                $sql = "SELECT  p.description AS description  , p.body AS score, p.id, p.sid, p.type, p.description, p.body, s.title, s.kind, s.frame, s.theme FROM subjects as s LEFT JOIN pages as p ON s.id = p.sid WHERE ";
                if ($request->exists('title_filter'))
                {
                    $sql .= " s.title like '%$new_string%' ";
                    if ($request->exists('content_filter'))
                    {
                        $sql .= " or p.body like '%$new_string%' ";
                    }
                }
                else
                {
                    if ($request->exists('content_filter'))
                    {
                        $sql .= "  p.body like '%$new_string%' ";
                    }
                    else
                    {
                        $sql .= "  s.title like '%$new_string%' ";
                    }
                }


                $sql .= " GROUP BY s.id";
                $query = DB::select($sql);
                $total = 0;
                $kind = '';
                $n = 0;
                foreach ($query as $obj)
                {
                    $total++;
                    $len = mb_strlen($obj->body, 'UTF-8');
                    if ($len >= 0)
                    {
                        $result[$n]['score'] = $obj->title * 4 + $obj->description * 2 + $obj->score;
                        $pid = $obj->id;
                        $title = $obj->title;
                        $result[$n]['url'] = $pid;
                        $result[$n]['title'] = $obj->title;
                        $result[$n]['description'] = (trim($obj->title) != '');
                    }
                    $n++;
                }
            }
            $Res = array();
            if (count($result))
            {
                $Res['pages'] = $result;
            }
            else
            {
                $Res['pages'] = trans('labels.SearchNotResult');
            };
        }
        if ($request->exists('search_in_posts'))
        {
            if ($request->exists('searchw') && !empty($request->get('searchw')))
            {
                $find_posts = Post::where('title', 'like', '%' . $request->get('searchw') . '%')->orWhere('desc', 'like', '%' . $request->get('searchw') . '%')->whereHas('user')->with('subject')->with('user')->get()->toArray();
            }
            else
            {
                $find_posts = [];
            }
            $Res['posts'] = is_array($find_posts) ? $find_posts : [];
        }
        $s = $Res;
        $res = '';
        if (isset($s) && is_array($s))
        {
            $PC = new PublicClass();
            $res = $PC->SearchResult($s, $searchword);
        }
        return $res;
    }
    */

    public function endorse(Request $request)
    {
        $uid = Auth::id();
        $type = $request->input('type');
        $spid = $request->input('spid');
        $SP = new service();
        $menu = $SP->ServicePost('endorse', 'type=' . $type . '&spid=' . $spid . '&uid=' . $uid . '&sesid=' . $session_id);
        $json_a = json_decode($menu, true);
        $s = $json_a['data'];
        return $s;
    }

    public function DeleteRow(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = Auth::id();
            $page = $request->input('page');
            $id = $request->input('id');
            if ('post' == strtolower($page))
            {
                $a = DB::transaction(function () use ($uid, $page, $id)
                {
                    $post = Post::find($id);
                    if ($post->accepted)
                    {
                        return [0, 'پاسخ تائید شده، امکان حذف آن وجود ندارد.'];
                    }
                    else
                    {
                        if ($post->answerCount > 0)
                        {
                            return [0, 'پاسخ داده شده، امکان حذف آن وجود ندارد.'];
                        }
                        else
                        {
                            $SP = new \App\HamafzaServiceClasses\PublicsClass();
                            $menu = $SP->DeleteRow($page, $uid, 0, $id);

                            switch ($post->type)
                            {
                                case '1':
                                    $score_id = config('score.9');
                                    break;
                                case '2':
                                    $score_id = config('score.10');
                                    break;
                                case '3':
                                    $score_id = config('score.11');
                                    break;
                                case '4':
                                    $score_id = config('score.12');
                                    break;
                                case '12':
                                    $score_id = config('score.13');
                                    break;
                                case '13':
                                    $score_id = config('score.14');
                                    break;
                            }
                            score_unregister('App\Models\hamafza\Post', $id, $score_id);

                            if (2 == $post->type)
                            {
                                $reward = Reward::where('from_user_id', auth()->id())->where('target_table', 'App\Models\hamafza\Post')->where('target_id', $id);
                                if ($reward)
                                {
                                    $reward->delete();
                                }
                            }
                            return [1, $menu];
                        }
                    }
                });
                return $a[1];
            }
            else
            {
                $SP = new \App\HamafzaServiceClasses\PublicsClass();
                $menu = $SP->DeleteRow($page, $uid, 0, $id);
                return $menu;
            }
        }
    }

    public function NewTreeNode(Request $request)
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
        $old_id = $request->input('old_id');
        $repid = $request->input('sid');
        $SelReports = $request->input('SelReports');
        $parentid = $request->input('parentid');
        $type = $request->input('type');
        $Matn = $request->input('Matn');
        $Title = $request->input('Title');
        $tid = $request->input('tid');
        $isReport = $request->input('Report');
        $pages = $request->input('pages');
        $pageid = $request->input('pageid');
        $parentid = $request->input('parentid');
        $type = $request->input('type');
        $treeid = $request->input('treeid');
        $Matn = $request->input('Matn');
        $Title = $request->input('Title');
        $tozih = $request->input('tozih');
        $all = $request->input('all');
        $mosh = $request->input('mosh');
        $alamat = $request->input('alamat');
        $Matn_Part = $request->input('Matn_Part');
        $matinpart = $request->input('matinpart');
        $announces = $request->input('announces');
        $PishShomare_select = $request->input('PishShomare_select');
        $PishShomare = $request->input('PishShomare');
        if ($isReport == 'ok')
        {
            $SP = new service();
            $menu = $SP->ServicePost('DeleteTreeNode', 'ptid=' . $ptid . '&uid=' . $uid . '&sesid=' . $sesid);
            $json_a = json_decode($menu, true);
            $s = $json_a['data'];
            return $s;
        }
        else
        {
            $SP = new service();
            $menu = $SP->ServicePost('NewTreeNode', 'old_id=' . $old_id . '&repid=' . $repid . '&SelReports=' . $SelReports . '&parentid=' . $parentid . '&type=' . $type . '&Matn=' . $Matn . '&Title=' . $Title
                . '&tid=' . $tid . '&pages=' . $pages . '&pageid=' . $pageid . '&treeid=' . $treeid . '&tozih=' . $tozih . '&all=' . $all . '&mosh=' . $mosh . '&alamat=' . $alamat . '&Matn_Part=' . $Matn_Part
                . '&matinpart=' . $matinpart . '&announces=' . $announces . '&PishShomare_select=' . $PishShomare_select . '&PishShomare=' . $PishShomare . '&uid=' . $uid . '&sesid=' . $sesid);
            $json_a = json_decode($menu, true);
            $s = $json_a['data'];
            return $s;
        }
    }

    public function DeleteTreeNode(Request $request)
    {
        $ptid = $request->input('ptid');
        $SP = new service();
        $menu = $SP->ServicePost('NewTreeNode', 'old_id=' . $old_id . '&repid=' . $repid . '&SelReports=' . $SelReports . '&parentid=' . $parentid . '&type=' . $type . '&Matn=' . $Matn . '&Title=' . $Title
            . '&tid=' . $tid . '&pages=' . $pages . '&pageid=' . $pageid . '&treeid=' . $treeid . '&tozih=' . $tozih . '&all=' . $all . '&mosh=' . $mosh . '&alamat=' . $alamat . '&Matn_Part=' . $Matn_Part
            . '&matinpart=' . $matinpart . '&announces=' . $announces . '&PishShomare_select=' . $PishShomare_select . '&PishShomare=' . $PishShomare . '&uid=' . $uid . '&sesid=' . $sesid);
        $json_a = json_decode($menu, true);
        $s = $json_a['data'];
        return $s;
    }

    public function showhighlight(Request $request)
    {
        $id = $request->input('sid');
        $hid = $request->input('hid');

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
        $SP = new service();
        $menu = $SP->ServicePost('showhighlight', 'sid=' . $sid . '&uid=' . $uid);
        $json_a = json_decode($menu, true);
        $s = $json_a['data'];
        $res = '<select id="announces">';
        $res1 = '';
        foreach ($s as $value)
        {
            $sel = '';
            if ($s['id'] == $hid)
            {
                $sel = "selected";
            }
            $res1 .= '<option value="' . $s['id'] . '" ' . $sel . '>' . $s['title'] . '</option>';
        }
        if ($res1 == '')
        {
            $res = 'موردی یافت نشد.';
        }
        else
        {
            $res .= $res1;
            $res .= ' </select>';
        }
        return $res;
    }

    public function showpagebody(Request $request)
    {
        $id = $request->input('sid');
        $SP = new service();
        $menu = $SP->ServicePost('showpagebody', 'sid=' . $sid);
        $json_a = json_decode($menu, true);
        $s = $json_a['data'];
        $res = '';
        foreach ($s as $value)
        {
            $res .= $value['body'];
        }
        return $res;
    }

    public function showtabs(Request $request)
    {
        $id = $request->input('sid');
        $SP = new service();
        $menu = $SP->ServicePost('showtabs', 'sid=' . $sid);
        $json_a = json_decode($menu, true);
        $s = $json_a['data'];
        $i = 1;
        $res = '';
        foreach ($s as $value)
        {
            $ch = '';
            if ($i == 1)
            {
                $ch = "checked";
            }
            $res .= '<input type="checkbox" ' . $ch . ' value="' . $value['pid'] . '" name="TabsTb" class="TabsTbs" >' . $value['tab_name'];
            $i++;
        }

        if ($res == '')
        {
            $res = 'موردی یافت نشد.';
        }
        return $res;
    }

    public function keyrel(Request $request)
    {
        $id = $request->input('keyid');
        $SP = new service();
        $menu = $SP->ServicePost('keyrel', 'id=' . $id);
        $json_a = json_decode($menu, true);
        $s = $json_a['data'];
        return $s;
    }

    public function EditUDetail(Request $request)
    {
        $uid = Auth::id();
        $sesid = '0';
        $comment = $request->input('comment');
        $user_name = $request->input('user_name');
        $user_family = $request->input('user_family');
        $user_summary = $request->input('user_summary');
        $user_gender = $request->input('user_gender');
        $udate = $request->input('EditUdetdate');
        $City = $request->input('City');
        $Province = $request->input('Province');
        $tel_code = $request->input('tel_code');
        $tel_number = $request->input('tel_number');
        $fax_code = $request->input('fax_code');
        $fax_number = $request->input('fax_number');
        $user_website = $request->input('user_website');
        $user_mail = $request->input('user_mail');
        $user_mobile = $request->input('user_mobile');
        $SP = new \App\HamafzaServiceClasses\UserClass();
        $menu = $SP->EditUDetail($uid, 0, $comment, $user_name, $user_family, $user_summary, $user_gender, $udate, $City, $Province, $tel_code, $tel_number, $fax_code, $fax_number, $user_website, $user_mail, $user_mobile);
        return $menu;
    }

    public function EditUE(Request $request)
    {
        if (!Auth::check())
        {
            return 'عدم دسترسی';
        }
        else
        {
            $uid = Auth::id();
            $comment = $request->input('comment');
            $location = $request->input('locations');
            $trend = $request->input('trend');
            $level = $request->input('level');
            $University = $request->input('University');
            $Province = $request->input('Province');
            $City = $request->input('City');
            $sdate = $request->input('sdate');
            $edate = $request->input('edate');
            $id = $request->input('id');
            $SP = new \App\HamafzaServiceClasses\UserClass();
            $menu = $SP->EditUE($uid, 0, $comment, $location, $id, $trend, $level, $University, $Province, $City, $sdate, $edate);
            return $menu;
        }
    }

    public function EditUW(Request $request)
    {
        if (!Auth::check())
        {
            return 'عدم دسترسی';
        }
        else
        {
            $uid = Auth::id();
            $comment = $request->input('comment');
            $title = $request->input('title');
            $company = $request->input('company');
            $vahed = $request->input('vahed');
            $Province = $request->input('Province');
            $City = $request->input('City');
            $sdate = $request->input('sdate');
            $edate = $request->input('edate');
            $id = $request->input('id');
            $SP = new \App\HamafzaServiceClasses\UserClass();
            $menu = $SP->EditUW($uid, 0, $comment, $title, $id, $company, $vahed, $Province, $City, $sdate, $edate);

            return $menu;
        }
    }

    public function EditUP(Request $request)
    {
        if (!Auth::check())
        {
            return 'عدم دسترسی';
        }
        else
        {
            $UPvals = $request->input('UPvals');
            $Uname = (session('Uname') != '') ? session('Uname') : 0;
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $comment = $request->input('comment');
            $title = $request->input('title');
            $id = $request->input('id');
            $SP = new \App\HamafzaServiceClasses\UserClass();
            $menu = $SP->EditUP($uid, $sesid, $comment, $title, $id, $UPvals);
            return $menu;
        }
    }

    public function Export(Request $request)
    {
        $type = $request->input('type');
        $pids = $request->input('pid');
        $sid = $request->input('sid');
        $title = $request->input('title');
        $numbers = $request->input('numbers');
        $SP = new \App\HamafzaServiceClasses\PageClass();
        $menu = $SP->subjectPrint($type, $pids, $sid, $pids, $numbers);
        $html = $menu['print'];
        $html = str_replace('../../FileManager/', url('') . '/FileManager/', $html);
        if ($type == 'word')
        {
            $html = '<head><title></title></head><style>table {border-collapse: collapse;}table, th, td {border: 1px solid black;}</style><body><p>' . $title . '</p>' . $html . '</body>';
            $htmltodoc = new \App\HamafzaViewClasses\htmltodoc();
            $FULLSITE = url('/');
            $html = str_replace("<p", "<p lang=FA dir=RTL style='font-weight: normal;text-indent: 0.5cm;font-family:\"B mitra\";text-align: justify;font-size:14pt'", $html);
            $html = str_replace("<h1", "<h1 lang=FA dir=RTL style='font-family:\"B mitra\";'", $html);
            $html = str_replace("<h2", "<h1 lang=FA dir=RTL style='font-family:\"B mitra\";'", $html);
            $html = str_replace("</h2>", "</h1>", $html);

            $html = str_replace("<h3", "<h2 lang=FA dir=RTL style='font-family:\"B mitra\";'", $html);
            $html = str_replace("</h3>", "</h2>", $html);

            $html = str_replace("<h4", "<h3 lang=FA dir=RTL style='font-family:\"B mitra\";'", $html);
            $html = str_replace("</h4>", "</h3>", $html);

            $html = str_replace("<h5", "<h4 lang=FA dir=RTL style='font-family:\"B mitra\";'", $html);
            $html = str_replace("</h5>", "</h4>", $html);

            $html = str_replace("<h6", "<h5 lang=FA dir=RTL style='font-family:\"B mitra\";'", $html);
            $html = str_replace("</h6>", "</h5>", $html);


            $html = str_replace("<span", "<span lang=FA dir=RTL style='font-family:\"B mitra\";font-size:14pt'", $html);
            $html = str_replace("<a lang='en'", "<a align='center' lang=FA dir=RTL style='font-family:\"B mitra\";text-decoration:\"blink !important\"; font-size:12pt'", $html);
            $html = str_replace("<a lang='fa'", "<a align='center' lang=FA dir=RTL style='font-family:\"B mitra\";text-decoration:\"blink !important\"; font-size:14pt'", $html);
            $html = str_replace("<li", "<li lang=FA dir=RTL style='font-weight: normal;font-family:\"B mitra\";text-align: justify;font-size:14pt'", $html);
            $html = str_replace('class="number"', "class=\"number\" style='font-family:\"B mitra\";text-align: center;font-size:14pt'", $html);
            $html = str_replace("<table", "<table align='center' lang=FA dir=RTL style='font-family:\"B mitra\";font-size:12pt'", $html);
            $html = str_replace("<td", "<td lang=FA dir=RTL style='padding:0cm 5.4pt 0cm 5.4pt'font-size:14pt", $html);
            $htmltodoc->createDocFromContent($html, $title . '.doc', true);
            exit;
        }
        else
        {
            $html = '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><title></title></head><body>' . $html . '</body>';
            $FULLSITE = url('/');
            $html = str_replace("<p", "<p lang=FA dir=RTL style='font-family:\"B mitra\";text-align: justify;'", $html);
            $html = str_replace("<h1", "<h1 lang=FA dir=RTL style='font-family:\"B mitra\";'", $html);
            $html = str_replace("<h2", "<h2 lang=FA dir=RTL style='font-family:\"B mitra\";'", $html);
            $html = str_replace("<h3", "<h3 lang=FA dir=RTL style='font-family:\"B mitra\";'", $html);
            $html = str_replace("<h4", "<h4 lang=FA dir=RTL style='font-family:\"B mitra\";'", $html);
            $html = str_replace("<h5", "<h5 lang=FA dir=RTL style='font-family:\"B mitra\";'", $html);
            $html = str_replace("<span", "<span lang=FA dir=RTL style='font-family:\"B mitra\";'", $html);
            $html = str_replace("<a", "<a lang=FA dir=RTL style='font-family:\"B mitra\";text-decoration:\"blink !important\";'", $html);
            $html = str_replace("<li", "<li lang=FA dir=RTL style='font-family:\"B mitra\";text-align: justify;'", $html);
            $html = str_replace('class="number"', "class=\"number\" style='font-family:\"B mitra\";text-align: center;'", $html);
            $html = str_replace("<table", "<table lang=FA dir=RTL style='font-family:\"B mitra\";'", $html);
            $html = str_replace("<td", "<td lang=FA dir=RTL style='border:solid windowtext 1.0pt;mso-border-alt:solid windowtext .5pt;'", $html);
            $html = str_replace('src="', 'src="' . $FULLSITE . '/', $html);

//return PDFS::loadHTML($html)->setPaper('a4')->setOrientation('landscape')->setWarnings(false)->save('myfile.pdf');
            //  return PDF::load($html, 'A4', 'portrait')->download('my_pdf');
            ;
            require(base_path() . '\vendor\mpdf\mpdf\mpdf.php');
            //require("mpdf56/mpdf.php");
            //$mpdf = new PDF();
            $pdf = PDF::loadView('pdf.document', ['html' => $html]);
            return $pdf->stream('document.pdf');
            /* $mpdf->mirrorMargins = 1; // Use different Odd/Even headers and footers and mirror margins
             $mpdf->SetDirectionality('rtl');
             $mpdf->SetDisplayMode('fullpage');
             $mpdf->WriteHTML($html);
             $title = substr($title, 10);
             $mpdf->Output($title . '.pdf', 'D');*/
        }
    }

    public function highlight(Request $request)
    {
        if (!auth()->check())
        {
            return "خطای دسترسی: لطفا ابتدا وارد شوید.";
        }
        $text = $request->input('text');
        $pid = $request->input('pid');
        $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
        $highlight_id = DB::table('highlights')->insertGetId(
            [
                'pid' => $pid,
                'uid' => auth()->id(),
                'quote' => $text,
                'type' => '1',
                'reg_date' => $reg_date
            ]);
        $mes = "علامت گذاری با موفقیت ثبت شد";
        return $mes;
    }

    public function tagsearch(Request $request)
    {
        $search = $request->input('q');
        if ($search == '' && $request->input('query') != '')
        {
            $search = $request->input('query');
        }
        $type = $request->input('type');
        $activetype = $request->input('activetype');
        $SP = new \App\HamafzaServiceClasses\PublicsClass();
        $menu = $SP->tagsearch($search, $type, $activetype);
        return $menu;
    }

    public function pagesearch(Request $request)
    {
        $search = $request->input('q');
        $tabs = DB::table('pages as p')->join('subjects as s', 'p.sid', '=', 's.id')
            ->where('s.archive', '0')
            ->where('s.list', '=', '1')
            ->where('s.ispublic', '=', '1')
            ->whereRaw("s.title like '%$search%' or p.id='$search'")
            ->whereRaw(PageClass::Sel_Page())
            ->orderBy('p.id')
            ->select('p.sid as id', DB::Raw("CONCAT(s.title,' (' , p.id,')') as name"))
            ->get();
        return $tabs;
    }

    public function printsubject(Request $request)
    {
        $sid = $request->input('sid');
        $type = $request->input('type');
        $ch = $request->input('ch');
        $pid = $request->input('pid');
        $SP = new service();
        $params['pid'] = $pid;
        $params['sid'] = $sid;
        $params['ch'] = $ch;
        $params['type'] = $type;
        $poststr = http_build_query($params);
        $menu = $SP->ServicePost('subjectPrint', 'pid=' . $pid . '&sid=' . $sid . '&ch=' . $ch . '&type' . $type);
        $json_a = json_decode($menu, true);
        $s = $json_a['data'];
        return $s['print'];
    }

    public function DefimagePage(Request $request)
    {
        if (!Auth::check())
        {
            $mes = 'عدم دسترسی';
        }
        else
        {
            $path = '';
            $input = array('image' => $request->file('deimagefile'));
            $rules = array(
                'image' => 'image'
            );
            $validator = Validator::make($input, $rules);
            if ($validator->fails())
            {
                return 'لطفا تنها فایل تصویری انتخاب کنید';
            }
            else
            {
                $pid = $request->input('pid');
                $check = $request->input('showDefpic');
                if ($request->hasFile('deimagefile'))
                {
                    if ($request->file('deimagefile')->isValid())
                    {
                        $file = $request->file('deimagefile');
                        $tmpFilePath = '/pagefiles/Defpics/';
                        $tmpFileName = time() . '-' . $file->getClientOriginalName();
                        $file = $file->move(public_path() . $tmpFilePath, $pid . '-' . $tmpFileName);
                        $path = $tmpFilePath . $pid . '-' . $tmpFileName;
                        $check = 'on';
                    }
                }
            }
            $uid = Auth::id();
            $sesid = '0';
            if ($check == '')
            {
                $check = '0';
            }
            else
            {
                $check = '1';
            }
            $params['pid'] = $pid;
            $params['uid'] = $uid;
            $params['sesid'] = $sesid;
            $params['check'] = $check;
            $params['file'] = $file;
            $poststr = http_build_query($params);
            $SP = new \App\HamafzaServiceClasses\PageClass();
            $menu = $SP->DefimagePage($pid, $uid, $sesid, $check, $file);
            return $menu;
        }
        return $mes;
    }

    public function page_edit_description(Request $request)
    {
        $desc = $request->input('desc');
        $pid = $request->input('pid');
        if (session('uid') != '' && session('uid') != '')
        {
            $uid = session('uid');
            $sesid = session('SessionID');
        }
        else
        {
            $uid = '0';
            $sesid = '0';
        }
        $SP = new service();
        $menu = $SP->ServicePost('page_edit_description', 'uid=' . $uid . '&sesid=' . $sesid . '&descr=' . $desc . '&pid=' . $pid);
        $json_a = json_decode($menu, true);
        $s = $json_a['data'];
        return $s;
    }

    public function GetMyCircle(Request $request)
    {
        $uid = $request->input('uid');
        $sesid = 0;
        $sesid = session('SessionID');
        $SP = new service();
        $menu = $SP->ServicePost('GetMyCircle', 'uid=' . $uid . '&sesid=' . $sesid);
        $json_a = json_decode($menu, true);
        $s = $json_a['data'];
        return $s;
    }

    public function newpost(Request $request)
    {
        if ($request->input('reward') <= 0)
        {
            $request->merge(
                [
                    'reward' => ''
                ]);
        }
        $validator = Validator::make
        (
            $request->all(),
            [
                'reward' => 'integer|max:' . get_user_sumscores(),
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        $uid = $request->input('uid');
        $sesid = $request->input('sesid');
        $pid = $request->input('pid');
        $type = $request->input('type');
        $desc = $request->input('desc');
        $selectText = $request->input('selectText');
        $desc = preg_replace("/<img[^>]+\>/i", "", $desc);
        $video = $request->input('video');
        $all = $request->input('all');
        $keys = $request->input('keys');
        $cids = $request->input('cids');
        $gids = $request->input('gids');
        $title = $request->input('title');
        $Pid = $request->input('pid');
        $portal_id = $request->input('portal_id');
        $reward = $request->input('reward');
        $sesid = 0;
        $file = $request->file('image');
        $tmpFileName = '';
        if ($file)
        {
            if ($file->isValid())
            {
                $tmpFilePath = 'uploads/';
                $extension = $file->getClientOriginalExtension();
                $tmpFileName = $uid . time() . '.' . $extension; // renameing image
                $img = Image::make($file->getRealPath());
                $img->resize(800, null, function ($constraint)
                {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save('uploads/' . $tmpFileName)->destroy();
                $tmpFileName = $tmpFileName;
            }
        }
        $video = '';

        $SP = new \App\HamafzaServiceClasses\PostsClass();
        $time = time();
        $menu = $SP->NewPost($uid, $sesid, $Pid, $type, $desc, $tmpFileName, $video, $time, $all, $keys, $cids, $gids, $title, $portal_id, $reward, $selectText);
        if ($menu)
        {
            $file = HFM_SaveMultiFiles('comment_file', '\App\Models\Hamahang\FileManager\Fileable', 'fileable_id', $menu, ['created_by' => auth()->id(), 'fileable_type' => 'App\Models\hamafza\Pages', 'type' => 2]);
        }
        return $menu;
    }

    public function pagelike(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $tar_val = $request->input('tar_val');
            $tar_sid = $request->input('tar_sid');
            $tar_uid = $request->input('tar_uid');
            $type = $request->input('type');
            if ($type == 'Group')
            {
                $userid = $request->input('userid');
            }
            else
            {
                $userid = (session('uid') != '' && session('uid') != '') ? session('uid') : 0;
            }
            if ($type == 'button')
            {
                $type = 'subject';
            }
            if (session('uid') != '')
            {
                $uid = session('uid');
                $sesid = session('SessionID');
            }
            else
            {
                $uid = '0';
                $session_id = '0';
            }
            if ($tar_val == '1')
            {
                //dd('like');
                $session_id = 0;
                $SP = new \App\HamafzaServiceClasses\PageClass();
                $menu = $SP->Like($type, $userid, $tar_sid, $uid, $session_id);
                return $menu;
            }
            else
            {
                //dd('dislike');
                if ($tar_val == '0')
                {
                    $session_id = 0;
                    $SP = new \App\HamafzaServiceClasses\PageClass();
                    $menu = $SP->DisLike($type, $userid, $tar_sid, $uid, $session_id);
                    return $menu;
                }
            }
        }
    }

    public function pagefollow(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $tar_val = $request->input('tar_val');
            $tar_sid = $request->input('tar_sid');
            $tar_uid = $request->input('tar_uid');
            $userid = $request->input('userid');
            $type = $request->input('type');
            if (session('uid') != '')
            {
                $userid = (session('uid') != '' && session('uid') != '') ? session('uid') : $userid;
                $tar_uid = session('uid');
                $sesid = session('SessionID');
            }
            else
            {
                $userid = (session('uid') != '' && session('uid') != '') ? session('uid') : $userid;
                $tar_uid = '0';
                $sesid = '0';
            }
            if ($tar_val == '1')
            {
                //dd('Follow');
                $SP = new \App\HamafzaServiceClasses\PageClass();
                $menu = $SP->Follow($type, $userid, $tar_sid, $tar_uid, $sesid);
                return $menu;
            }
            else
            {
                //dd('UnFollow');
                if ($tar_val == '0')
                {
                    $SP = new \App\HamafzaServiceClasses\PageClass();
                    $menu = $SP->UnFollow($type, $userid, $tar_sid, $tar_uid, $sesid);
                    return $menu;
                }
            }
            return trans('app.operation_is_failed');
        }
    }

    public function postlike(Request $request)
    {
        $postid = $request->input('postid');
        $uid = Auth::id();
        $like = $request->input('like');
        $sesid = 0;
        $menu = \App\HamafzaServiceClasses\PostsClass::PostLike($uid, $postid, 0, $like);
        return $menu;
    }

    public function postcomment(Request $request)
    {
        $postid = $request->input('postid');
        $uid = Auth::id();
        $comment = $request->input('comment');
        $comment = json_encode($comment);
        $comment = str_replace("&", "[and]", $comment);
        $menu = \App\HamafzaServiceClasses\PostsClass::PostComment($uid, $postid, 0, $comment);
        return $menu;
    }

    public function bookmark_add(Request $request)
    {
        if (auth()->check())
        {
            $target_table = $request->input('target_table');
            $target_id = $request->input('target_id');
            $user_id = auth()->id();
            switch ($target_table)
            {
                case 'page':
                {
                    $page = Pages::find($target_id);
                    if ($page->count()) { $title = $page->subject->title; } else { return; }
                    $target_type = 'App\Models\hamafza\Pages';
                    break;
                }
                case 'subject':
                {
                    $subject = Subject::find($target_id);
                    if ($subject->count()) { $title = $subject->title; } else { return; }
                    $target_type = 'App\Models\hamafza\Subject';
                    break;
                }
                case 'user':
                {
                    $user = User::find($target_id);
                    if ($user->count()) { $title = $user->FullName; } else { return; }
                    $target_type = 'App\User';
                    break;
                }
            }

            $bookmark = Bookmark::where('target_table', $target_type)->where('target_id', $target_id)->where('user_id', $user_id);

            if ($bookmark->count())
            {
                $bookmark->delete();
                return response()->json(['fail', 'چوب الف با موفقیت حذف شد.']);
            }
            else
            {
                Bookmark::create(['title' => $title, 'target_table' => $target_type, 'target_id' => $target_id, 'user_id' => $user_id,]);
                return response()->json(['success', 'چوب الف با موفقیت ثبت شد.']);
            }
        }
        else
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
    }


    public function bookmarks(Request $request)
    {
        $term = trim($request->input('term'));
        $empty = ['user' => false, 'page' => false, 'subject' => false, 'group' => true, 'channel' => true, ];
        $bookmark_types = ['user' => 'کاربران', 'page' => 'صفحات', 'subject' => 'موضوعات', 'group' => 'گروه&zwnj;ها', 'channel' => 'کانال ها', ];
        $bookmarks = auth()->user()->bookmarks($term);
        $r = view('layouts.helpers.common.sections.helpers.nav_bar.left_nav_bar_bookmarks')->with(['bookmark_types' => $bookmark_types, 'bookmarks' => $bookmarks, 'empty' => $empty, ]);
        return $r;
    }

    public function bookmarks_delete(Request $request)
    {
        $id = $request->input('id');
        $bookmark = Bookmark::where('id', $id)->where('user_id', auth()->id())->get()->first();
        if ($bookmark)
        {
            $bookmark->delete();
            return 'حذف شد.';
        }
        else
        {
            abort(403);
        }
    }

    public function bookmarks_view($id)
    {
        $bookmark = Bookmark::where('id', $id)->where('user_id', auth()->id())->get()->first();
        if ($bookmark)
        {
            switch ($bookmark->target_table)
            {
                case 'App\User':
                {
                    $user = User::find($bookmark->target_id);
                    if ($user)
                    {
                        return redirect(url($user->Uname));
                    }
                    break;
                }
                case 'App\Models\hamafza\Pages':
                {
                    $page = Pages::find($bookmark->target_id);
                    if ($page)
                    {
                        return redirect(url($page->id));
                    }
                    break;
                }
                case 'App\Models\hamafza\Subject':
                {
                    $subject = Subject::find($bookmark->target_id);
                    if ($subject)
                    {
                        return redirect(url($subject->id) . '/desktop');
                    }
                    break;
                }
                case 'group':
                {
                    break;
                }
                case 'channel':
                {
                    break;
                }
                default:
                {

                }
            }
        }
        abort(403);
    }

    public function portals(Request $request)
    {
        $r = null;
        $subject_types = ['public' => 'رسمی', 'private' => 'شخصی',];
        $term = trim($request->input('term'));
        $subjects['public'] = Subject::whereIn('kind', [20, 21, 22, 27])->where('ispublic', '1')->where('list', '1')->where('archive', '0');
        if(auth()->check()){
            $subjects['private'] = Subject::whereIn('kind', [20, 21, 22, 27])->where('ispublic', '0')->where('admin', auth()->id());
            $subjects['private'] = $term ? $subjects['private']->where('title', 'like', "%$term%") : $subjects['private'];
            $subjects['private'] = $subjects['private']->get();
        }
        $subjects['public'] = $term ? $subjects['public']->where('title', 'like', "%$term%") : $subjects['public'];
        $subjects['public'] = $subjects['public']->get();

        $r = view('layouts.helpers.common.sections.helpers.nav_bar.left_nav_bar_portals')->with
        ([
            'subject_types' => $subject_types,
            'term' => $term,
            'subjects' => $subjects
        ]);
        return $r;
    }

    public function SearchTags(Request $request)
    {
        $r = null;
        $keyword_types = ['special' => 'تخصص&zwnj;ها', 'subject' => 'صفحات', 'enquiry_pages' => 'صفحات دیگر', ];
        $request_keywords = $request->exists('keywords') ? $request->keywords : [];

        if ($request->keywords_and_or)
        {
            $where_clause_id = [];
            $where_clause_kid = [];
            $subject_key = DB::table('subject_key as s');
            foreach ($request_keywords as $k=>$request_keyword)
            {
                $subject_key->leftjoin('subject_key as s'.$k, 's.sid', '=', 's'.$k.'.sid')
                    ->where('s'.$k.'.kid',$request_keyword);
                $where_clause_id[]=['keywords.id','=',$request_keyword];
                $where_clause_kid[]=['post_keys.kid','=',$request_keyword];
            }
            $sids = $subject_key->select('s.sid')->get();
            $whSid = [];
            foreach($sids as $sid)
                $whSid[] = $sid->sid;
            $subjects = Subject::whereIn('id',$whSid);
            $keywords['subject'] = $subjects;
            $keywords['special'] = User::whereHas('specials', function ($q) use ($where_clause_id)
            {
                return $q->where($where_clause_id);
            });
//            $keywords['subject'] = Subject::whereHas('keywords', function ($q) use ($where_clause_id)
//            {
//                return $q->where($where_clause_id);
//            });
            $keywords['enquiry_pages'] = Post::whereHas('keywords', function ($q) use ($where_clause_kid)
            {
                return $q->where($where_clause_kid);
            })->with('subject');
        }else{
            $keywords['special'] = User::whereHas('specials', function ($q) use ($request_keywords)
            {
                return $q->whereIn('keywords.id', $request_keywords);
            });
            $keywords['subject'] = Subject::whereHas('keywords', function ($q) use ($request_keywords)
            {
                return $q->whereIn('keywords.id', $request_keywords);
            });
            $keywords['enquiry_pages'] = Post::whereHas('keywords', function ($q) use ($request_keywords)
            {
                return $q->whereIn('post_keys.kid', $request_keywords);
            })->with('subject');
        }
        $keywords['special'] = $keywords['special']->get();
        $keywords['subject'] = $keywords['subject']->get();
        $keywords['enquiry_pages'] = $keywords['enquiry_pages']->get();
        $r = view('layouts.helpers.common.sections.helpers.nav_bar.left_nav_bar_searchTags')->with
        ([
            'keywords' => $keywords,
            'keyword_types' => $keyword_types,
        ]);
        return $r;
    }

    public function search(Request $request)
    {
        $r = null;
        $posts = null;
        $searchs = ['posts', 'pages' => ['title', 'content']];
        $term = trim($request->input('term', null));
        $for_title = (bool) $request->input('for_title', false);
        $for_content = (bool) $request->input('for_content', false);
        $in_posts = (bool) $request->input('in_posts', false);
        $in_pages = (bool) $request->input('in_pages', false);

        if ($in_pages && $for_title)
        {
            $searchs['pages']['title'] = Subject::where('title', 'like', "%$term%")
                ->where('list', '1')
                ->where('archive', '0')
                ->whereHas('pages')
                ->with('pages')
                ->get();
        }

        if ($in_pages && $for_content)
        {
            $searchs['pages']['content'] = Pages::where('body', 'like', "%$term%")
                ->with('subject','subject.tabs')
                ->get();
        }

        if ($in_posts)
        {
            $searchs['posts'] = Post::where(function ($query) use ($term, $for_title, $for_content)
            {
                if ($for_title)
                {
                    $posts = $query->orWhere('title', 'like', "%$term%");
                }
                if ($for_content)
                {
                    $posts = $query->orWhere('desc', 'like', "%$term%");
                }
            })->whereHas('subject')->with('subject')->get();
        }
        if ($in_posts)
        {
            $searchs['groups'] = Post::where(function ($query) use ($term, $for_title, $for_content)
            {
                if ($for_title)
                {
                    $posts = $query->orWhere('title', 'like', "%$term%");
                }
                if ($for_content)
                {
                    $posts = $query->orWhere('desc', 'like', "%$term%");
                }
            })->whereHas('group')->with('group')->get();
        }
//        dd($searchs);
        $r = view('layouts.helpers.common.sections.helpers.nav_bar.left_nav_bar_search')->with
        ([
            'searchs' => $searchs,
            'term' => $term,
            'in_posts' => $in_posts,
            'in_pages' => $in_pages,
            'for_title' => $for_title,
            'for_content' => $for_content,
        ]);
        return $r;
    }

}
