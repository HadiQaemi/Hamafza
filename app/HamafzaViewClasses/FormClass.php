<?php

namespace App\HamafzaViewClasses;

use Auth;
use App\HamafzaServiceClasses\KeywordsClass;
use Illuminate\Support\Facades\DB;
use App\HamafzaServiceClasses\FormsClass;
use App\HamafzaServiceClasses\ProccesClass;
use App\HamafzaGrids\FormGrids;
use App\HamafzaServiceClasses\PublicsClass;
use App\HamafzaServiceClasses\UserClass;

class FormClass
{

    public static function SubjectType($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        if ($sublink == '')
        {
            return FieldClass::SubjectTypeList($name, $uid, $sesid, $Selected, $Tree);
        }
    }

    public static function SubjectTypeList($name, $uid, $sesid, $Selected, $Tree)
    {
        $ret = DesktopClass::USER($name);
        $SP = new service();
        $menu = $SP->ServicePost('GetSubjectType', 'uid=' . $uid . '&sesid=' . $sesid);
        $json_a = json_decode($menu, true);
        $s = $json_a['data'];
        $Err = $json_a['error'];
        if ($Err == true)
        {
            return Redirect::back()->with('message', $C)->with('mestype', 'error');
        }
        else
        {
            $SubjectType = $s;
            $c = SubjectTypeGrids::Lists($s);
            $uid = session('uid');
            $sesid = '';
            $uid = (session('uid') != '') ? $uid : 0;
            $Portals = PageClass::GetProtals($uid, $sesid);
            $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
            $MyOrganGroups = '';
            if (session('MyOrganGroups'))
            {
                $MyOrganGroups = session('MyOrganGroups');
            }
            $PgC = new PageClass();
            $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'SubjectType');
            $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
            $shortTools = $tools['abzar'];
            return view('pages.Desktop', array('SiteLogo' => $ret['SiteLogo'], 'MyOrganGroups' => $MyOrganGroups, 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
                'Title' => $ret['Title'], 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
                'menu' => $ret['menu'], 'content' => $c, 'Files' => '', 'keywords' => '',
                'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $ret['tabs'], 'Tree' => $Tree, 'tools' => $shortTools, 'tools_menu' => $MenuTools));
        }
    }

    public static function GetFields($uname)
    {
        $uid = Auth::id();
        if (UserClass::permission('subject_field', $uid) == '1')
        {
            $SP = new FormsClass();
            $s = $SP->GetFileds($uid);
            $s = json_encode($s);
            $s = json_decode($s);
            $Fileds = $s->Fields;
            $Type = $s->Type;
            return [
                'content' => 'subject_field', 'Files' => '', 'keywords' => '', 'Fileds' => $Fileds, 'Type' => $Type
            ];
        }
        else
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
    }

    public static function viewfromreport($uid, $session_id, $formid, $repid, $edit = '')
    {
        if (!Auth::check())
        {
            return 'برای استفاده از این قسمت می بایست عضو سایت شوید یا با نام کاربری و کلمه عبور خود وارد شوید';
        }
        else
        {
            $str = '';
            $SP = new FormsClass();
            $s = $SP->ViewFromReport($uid, $session_id, $formid, $repid);
            if (is_array($s))
            {
                $str .= '<table  class="table">';
                $str .= '<tr><th>' . $s['Form']['title'] . ' تکمیل شده توسط:   ' . '<label><a target="_blank" href="' . $s['Form']['uname'] . '">' . $s['Form']['user'] . '</a></label>';
                $str .= '</th>';
                $str .= '</tr>';

                if (is_array($s['did']))
                {
                    foreach ($s['did'] as $key => $val)
                    {
                        $str .= '<tr>';
                        $PC = new PublicClass();
                        $field_value = key_exists($key, $s['field_value']) ? $s['field_value'][$key] : '';
                        $field_val = key_exists($key, $s['field_val']) ? $s['field_val'][$key] : '';
                        $field_name = key_exists($key, $s['field_name']) ? $s['field_name'][$key] : '';
                        $field_type = key_exists($key, $s['field_type']) ? $s['field_type'][$key] : '';
                        $requires = key_exists($key, $s['requires']) ? $s['requires'][$key] : '';
                        $str .= $PC->field_view_iust($key, $field_name, $field_type, $field_value, $requires, $field_val, '', 'vertical');
                        $str .= '</tr>';
                    }
                }
                $str .= '</table>';
            }
            return view('modals.viewfromreport', array('Grid' => $str, 'showform' => $edit, 'repid' => $repid));
        }
    }

    public static function viewfrom($uid, $session_id, $formid, $pid, $sid)
    {
        if (!Auth::check())
        {
            return 'برای استفاده از این قسمت می بایست عضو سایت شوید یا با نام کاربری و کلمه عبور خود وارد شوید';
        }
        else
        {
            $SP = new FormsClass();
            $s = $SP->ViewFrom($uid, $session_id, $formid);
            $str = '';
            if (is_array($s))
            {
                $levels = $s['levels'];
                $last = count($levels);
                sort($levels);
                if (count($levels) >= 1)
                {
                    $str .= '<form role="form" id="RegFormsA" data-toggle="validator" enctype="multipart/form-data" action="' . url("/") . '/saveForm" method="post"><input type="hidden" name="pid" value="' . $pid . '"/><input type="hidden" name="sid" value="' . $sid . '"/><input type="hidden" name="form_id" value="' . $formid . '"/>';
                    $str .= '<input type="hidden" name="_token" value="' . csrf_token() . '" />';

                    $j = 0;
                    if (count($levels) > 1)
                    {
                        $str .= '<div class="navbar navbar-default"><ul class="nav nav-tabs">';
                        foreach ($levels as $value)
                        {
                            $a = '';
                            if ($j == 0)
                            {
                                $a = 'active';
                            }
                            $str .= '<li class="' . $a . '"><a class="sooreh-tab-' . $value . '"  aria-controls="sooreh-tab-' . $value . '" href="#sooreh-tab-' . $value . '" role="tab" data-toggle="tab">مرحله ' . $value . '</a></li>';
                            $j++;
                        }
                        $str .= '</ul></div>';
                    }
                    $j = 0;
                    $str .= '<div class="tab-content">';
                    foreach ($levels as $value)
                    {
                        $a = '';
                        if ($j == 0)
                        {
                            $a = 'active';
                        }
                        $str .= '<div id="sooreh-tab-' . $value . '" role="tabpanel" class="tab-pane ' . $a . '">';
                        if (is_array($s['did']))
                        {
                            foreach ($s['did'] as $key => $val)
                            {
                                if ($s['form_level'][$key] == $value)
                                {
                                    $PC = new PublicClass();
                                    $str .= $PC->field_view_kham($key, $s['field_name'][$key], $s['field_type'][$key], $s['field_value'][$key], $s['requires'][$key], '', 'vertical', $s['question'][$key]);
                                }
                            }
                        }
                        $j++;
                        $str .= '<div style="margin-bottom:  15px;">';
                        if ($last == $j)
                        {
                            $z = $j - 1;
                            $str .= '<input type="submit" onclick="$(\'#RegFormsA\').bsValidate();" id="submit" name="addSubject" style=" float: left" value="تایید " class="btn btn-primary">';
                            if (count($levels) > 1)
                            {
                                $str .= '<a  style="margin-left: 5px;" class="btn btn-default FloatLeft" onclick="$(\'#RegFormsA\').bsValidate();$(\'.sooreh-tab-' . $z . '\').trigger(\'click\');" >گام قبل</a>';
                            }
                        }
                        else
                        {
                            $z = $j + 1;
                            $z1 = $j - 1;
                            if (count($levels) > 1)
                            {
                                if ($j > 1)
                                {
                                    $str .= '<a style="margin-left: 5px;" class="btn btn-default FloatLeft" onclick="$(\'#RegFormsA\').bsValidate();$(\'.sooreh-tab-' . $z . '\').trigger(\'click\');" >گام بعد</a>';
                                    $str .= '<a style="margin-left: 5px;" class="btn btn-default FloatLeft" onclick="$(\'#RegFormsA\').bsValidate();$(\'.sooreh-tab-' . $z1 . '\').trigger(\'click\');" >گام قبل</a>';
                                }
                                else
                                {
                                    $str .= '<a class="btn btn-default FloatLeft" onclick="$(\'#RegFormsA\').bsValidate();$(\'.sooreh-tab-' . $z . '\').trigger(\'click\');" >گام بعد</a>';
                                }
                            }
                        }
                        $str .= '<br></div>';
                        $str .= '</div>';
                    }
                    $str .= '</div></form>';
                }
            }
            elseif ($s != '')
            {
                $str = $s;
            }
            else
            {
                $str = 'مجددا وارد سامانه شوید';
            }
            return view('modals.viewfromreport', array('Grid' => $str, 'showform' => ''));
        }
    }

    public static function ViewRepors($uid, $session_id, $id)
    {
        if (!Auth::check())
        {
            return Redirect()->back()->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $F = new FormsClass();
            $s = $F->ViewFromReports($uid, 0, $id);
            $users = $s['users'];
            $fileds = $s['field_name'];
            $vals = $s['field_val'];
            $C = '';
            return view('modals.viewreports', array('Users' => $users, 'fileds' => $fileds, 'vals' => $vals, 'Message' => $C));
        }
    }

    public static function EditForm(
        $uid, $session_id, $form_name, $form_type, $form_help, $column, $field_name, $field_type
        , $field_value, $requires, $question, $did, $form_id, $level, $one, $isdraft, $before_start, $after_end)
    {
        $field_name = (is_array($field_type)) ? implode(",", $field_name) : '';
        $field_type = (is_array($field_type)) ? implode(",", $field_type) : '';
        $field_value = (is_array($field_value)) ? implode(",", $field_value) : '';
        $requires = (is_array($requires)) ? implode(",", $requires) : '';
        $question = (is_array($question)) ? implode(",", $question) : '';
        $did = (is_array($did)) ? implode(",", $did) : '';
        $level = (is_array($level)) ? implode(",", $level) : '';
        $SP = new \App\HamafzaServiceClasses\FormsClass();
        $s = $SP->EditForm($form_id, $uid, $session_id, $form_name, $form_type, $form_help, $column, $field_name, $field_type, $field_value, $requires, $question, $did, $level, $one, $isdraft, $before_start, $after_end);
        return $s;
    }

    public static function ADDForm(
        $uid, $session_id, $form_name, $form_type, $form_help, $column, $field_name, $field_type
        , $field_value, $requires, $question, $level, $user_submit, $user_view, $user_edit, $end, $start, $pages, $one, $isdraft, $before_start, $after_end)
    {
        $field_name = (is_array($field_type)) ? implode(",", $field_name) : '';
        $field_type = (is_array($field_type)) ? implode(",", $field_type) : '';
        $field_value = (is_array($field_value)) ? implode(",", $field_value) : '';
        $requires = (is_array($requires)) ? implode(",", $requires) : '';
        $question = (is_array($question)) ? implode(",", $question) : '';
        $level = (is_array($level)) ? implode(",", $level) : '';
        $SP = new \App\HamafzaServiceClasses\FormsClass();
        $s = $SP->ADDForm($uid, $session_id, $form_name, $form_type, $form_help, $column, $field_name, $field_type, $field_value, $requires, $question, $level, $user_submit, $user_view, $user_edit, $start, $end, $pages, $one, $isdraft, $before_start, $after_end);
//        return 'ADDForm'.  'uid=' . $uid . '&sesid=' . $session_id . '&start=' . $start . '&end=' . $end . '&field_name=' . $field_name . '&field_type=' . $field_type . '&level=' . $level .
//                '&field_value=' . $field_value . '&user_submit=' . $user_submit . '&user_view=' . $user_view . '&user_edit=' . $user_edit . '&requires=' . $requires . '&form_name=' . $form_name . '&form_type=' . $form_type . '&form_help=' . $form_help . '&column=' . $column . '&question=' . $question . '&pages=' . $pages.'&one='.$one.'&isdraft='.$isdraft.'&before_start='.$before_start.'&after_end='.$after_end;

        return $s;
    }

    public static function SelectType($uname, $sublink)
    {
        $uid = Auth::id();
        $sesid = '0';
        if ($sublink == 'add')
        {
            return FormClass::ADD($uid);
        }
        else
        {
            if ($sublink == 'edit')
            {
                if (isset($_GET['id']))
                {
                    $pid = $_GET['id'];
                    return FormClass::Edit($uid, $pid);
                }
            }
            else
            {
                if ($sublink == 'copy')
                {
                    if (isset($_GET['id']))
                    {
                        $pid = $_GET['id'];
                        return FormClass::Edit($uid, $pid);
                    }
                }
                else
                {
                    if ($sublink == 'view')
                    {
                        if (isset($_GET['id']))
                        {
                            $pid = $_GET['id'];
                            return FormClass::Edit($uid, $sesid, $uname, $Selected, $Tree, $pid);
                        }
                    }
                }
            }
        }
        if ($sublink == 'drafts')
        {
            return FormClass::Showall($uid, $sublink);
        }
        else
        {
            return FormClass::Showall($uid, $sublink);
        }
    }

    public static function Showall($uid, $sublink)
    {

        $F = new FormsClass();
        $s = $F->ShowForms($uid, 0, $sublink);
        $C = FormGrids::Lists($s, $sublink);
        $SP = new ProccesClass();
        $s = $SP->NewProccessData();
        $forms = $s['Forms'];
        $alerts = $s['Alerts'];
        $Porsesh = $s['Porsesh'];
        return array('pid' => 'desktop',
            'content' => $C, 'forms' => $forms, 'alerts' => $alerts, 'Porsesh' => $Porsesh,
        );
    }

    public static function ADD($uid)
    {
        $SP = new FormsClass();
        $s = $SP->GetFileds($uid);
        $s = json_encode($s);
        $s = json_decode($s);
        return array('viewname' => 'Pages.Desktop.ADD.formadd', 'sid' => $uid,
            'PageType' => 'desktop', 'pid' => 'desktop',
            'fields' => $s,
        );
    }

    public static function Edit($uid, $pid)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $SP = new PublicsClass();
            $s = $SP->GetFields();
            $s = json_encode($s);
            $s = json_decode($s);
            $SP = new FormsClass();
            $C = $SP->GetForm($pid, $uid);
            $Form = $C['Form'];
            $Fields = $C['Fields'];
            $Fields = json_encode($Fields);
            $Fields = json_decode($Fields);
            $Pages = $C['Pages'];
            $ACC = $C['Acc'];
            $ACC = json_encode($ACC);
            $ACC = json_decode($ACC);
            $Pages = json_encode($Pages);
            $Pages = json_decode($Pages);
            $Form = json_encode($Form);
            $Form = json_decode($Form);
            $uid = session('uid');
            return [
                'viewname' => 'pages.Desktop.viewform',
                'PageType' => 'desktop',
                'current_tab' => 'desktop',
                'sublink' => 'copy',
                'content' => 'edit',
                'Pages' => $Pages,
                'ACC' => $ACC,
                'Form' => $Form,
                'Fields' => $Fields,
                'fields' => $s,
            ];
        }
    }

}
