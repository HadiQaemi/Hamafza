<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Hamahang\ProjectController;
use App\Models\hamafza\Keyword;
use App\Models\hamafza\Pages;
use App\Models\hamafza\Subject;
use App\Models\hamafza\SubjectType;
use App\Models\hamafza\Ticket;
use App\Models\Hamahang\Address;
use App\Models\Hamahang\Basicdata;
use App\Models\Hamahang\BasicdataAttributes;
use App\Models\Hamahang\BasicdataAttributesValues;
use App\Models\Hamahang\BasicdataValue;
use App\Models\Hamahang\DiscountCoupon;
use App\Models\Hamahang\DiscountCouponRequest;
use App\Models\Hamahang\FileManager\FileManager;
use App\Models\Hamahang\Help;
use App\Models\Hamahang\Help2;
use App\Models\Hamahang\HelpBlock;
use App\Models\Hamahang\HelpRelation;
use App\Models\Hamahang\Invoice;
use App\Models\Hamahang\InvoiceItem;
use App\Models\Hamahang\KeywordRelation;
use App\Models\Hamahang\keywords;
use App\Models\Hamahang\Menus\MenuItem;
use App\Models\Hamahang\Menus\Menus;
use App\Models\Hamahang\Options;
use App\Models\Hamahang\OrgChart\onet_job;
use App\Models\Hamahang\OrgChart\org_chart_items;
use App\Models\Hamahang\OrgChart\org_chart_items_jobs;
use App\Models\Hamahang\OrgChart\org_charts;
use App\Models\Hamahang\OrgChart\org_charts_items_jobs;
use App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts;
use App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts_staff;
use App\Models\Hamahang\OrgChart\org_organs;
use App\Models\Hamahang\OrgChart\org_staff;
use App\Models\Hamahang\PaymentGatewayRawLogs;
use App\Models\Hamahang\ProvinceCity\City;
use App\Models\Hamahang\ProvinceCity\Province;
use App\Models\Hamahang\Score;
use App\Models\Hamahang\Tasks\projects;
use App\Models\Hamahang\Tasks\task_assignments;
use App\Models\Hamahang\Tasks\task_history;
use App\Models\Hamahang\Tasks\tasks;
use App\Models\Hamahang\TemplatePosition;
use App\Models\Hamahang\ThesaurusKeyword;
use App\Models\Hamahang\Tools\Tools;
use App\Models\Hamahang\Tools\ToolsAvailable;
use App\Models\Hamahang\Tools\ToolsGroup;
use App\Models\Hamahang\Tools\ToolsPosition;
use App\Role;
use App\User;
use Datatables;
use Illuminate\Http\Request;
use App\HamafzaViewClasses\PublicClass;
use App\Http\Controllers\Controller;
use App\HamafzaViewClasses\Message;
use App\HamafzaViewClasses\FormClass;
use App\HamafzaViewClasses\SubjectClass;
use App\HamafzaViewClasses\UsersClass;
use App\HamafzaViewClasses\PageClass;
use App\HamafzaViewClasses\AJAX;
use App\HamafzaViewClasses\GroupClass;
use App\Http\OpenModalController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\HamahangCustomClasses\jDateTime;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\View\UserController;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Validator;

class ModalController extends Controller
{

    public function Quran()
    {
        $rows = DB::table('quran_sura')->orderBy('id')->get();
        return view('modals.editor.Quran', array('sura' => $rows));
    }

    public function dashboard()
    {
        $formexcel = (isset($_GET['type']) && $_GET['type'] != '') ? $_GET['type'] : 'form';
        $formid = (isset($_GET['formid']) && $_GET['formid'] != '') ? $_GET['formid'] : '1';
        $nemodar = (isset($_GET['nemodar']) && $_GET['nemodar'] != '') ? $_GET['nemodar'] : '1';
        $width = (isset($_GET['width']) && $_GET['width'] != '') ? $_GET['width'] : '';
        $Xs = (isset($_GET['Xs']) && $_GET['Xs'] != '') ? $_GET['Xs'] : '';
        $Ys = (isset($_GET['Ys']) && $_GET['Ys'] != '') ? $_GET['Ys'] : '';

        $title = (isset($_GET['title']) && $_GET['title'] != '') ? $_GET['title'] : '';
        $filter = (isset($_GET['filter']) && $_GET['filter'] != '') ? $_GET['filter'] : '';
        $filtertype = (isset($_GET['filtertype']) && $_GET['filtertype'] != '') ? $_GET['filtertype'] : '';


        $rows = DB::table('forms')->orderBy('title')->get();
        return view('modals.editor.dashboard', array('filter' => $filter, 'filtertype' => $filtertype, 'Forms' => $rows, 'formexcel' => $formexcel, 'formid' => $formid
        , 'nemodar' => $nemodar, 'width' => $width, 'Xs' => $Xs, 'title' => $title, 'Ys' => $Ys
        ));
    }

    public function Forms()
    {
        $rows = DB::table('forms')->orderBy('title')->get();
        return view('modals.editor.forms', array('forms' => $rows));
    }

    public function Alerts()
    {
        $rows = DB::table('alerts')->select('id', 'name')->orderBy('id')->get();
        return view('modals.editor.alerts', array('sura' => $rows));

    }

    public function editor($name)
    {
        $mc = new editormodals();
        switch ($name)
        {
            case 'graph':
                return $mc->Graph();
                break;
            case 'content':
                return $mc->Content();
                break;
            case 'select_quran':
                return $mc->Quran();
                break;
            case 'sanat':
                return view('modals.editor.sanat');
                break;
            case 'alerts':
                return $mc->Alerts();
                break;
            case 'thesaurus':
                return $mc->thesaurus();
                break;

            case 'delete':
                return SubjectClass::delete($sid, $pid, $type);
                break;
            case 'seluser':
                $type = (isset($_GET['type'])) ? $_GET['type'] : 'single';
                return $type; // SNClass::Seluser($type);
                break;

        }
    }

    public function Route($route_name)
    {
        return Redirect::route($route_name);
    }

    public function URL($url_type, $url_href)
    {
        if ($url_type == 'external')
        {
            return Redirect::to("http://" . $url_href);
        }
        elseif ($url_type == 'internal')
        {
            return Redirect::to($url_href);
        }
        else
        {
            return "False Type";
        }
    }

    public function select($name)
    {
        $select = '';
        $id = (isset($_GET['id']) && (int)$_GET['id'] > 0) ? $_GET['id'] : '0';
        $pid = (isset($_GET['pid']) && (int)$_GET['pid'] > 0) ? $_GET['pid'] : '0';
        $sid = (isset($_GET['sid']) && (int)$_GET['sid'] > 0) ? $_GET['sid'] : '0';
        $type = isset($_GET['type']) ? $_GET['type'] : '0';
        $title = isset($_GET['title']) ? $_GET['title'] : '0';
        if (isset($_GET['sel']) && $_GET['sel'] != '')
        {
            $select = $_GET['sel'];
        }
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
        switch ($name)
        {


            /* case 'formshow':
                 return FormClass::viewfrom($uid, $sesid, $id, $pid, $sid);
                 break;*/
            /*case 'message':
                return view('modals.message');
                break;*/
            /*case 'user_measures_show':
                return $this->user_measures_show();
                break;*/
            /*  case 'measure':
                  return $this->measure($pid, $sid, $select, $title, $type);
                  break;*/
            /* case 'newsubject':
                 return SubjectClass::newsubject($uid, $sesid, $title);
                 break;*/
            /*case 'announce':
                return SubjectClass::announce($sid, $pid, $type, $title, 'false', $select);
                break;*/
            /*  case 'print':
                  return SubjectClass::subjectPrint($sid, $pid, $type);
                  break;*/
            /*case 'export':
                return SubjectClass::subjectExport($sid, $pid, $type);
                break;*/
            /* case 'notification':
                 return SubjectClass::notification($sid);
                 break;*/
            /* case 'delete':
                 return SubjectClass::delete($sid, $pid, $type);
                 break;*/
            /* case 'postlike':
                 return Localclass::Postlike($pid);
                 break;*/
            /* case 'history':
                 return SubjectClass::history($sid, $pid, $type);
                 break;*/
            /*case 'seluser':
                $type = (isset($_GET['type'])) ? $_GET['type'] : 'single';
                return \App\HamafzaViewClasses\SNClass::Seluser($type);
                break;*/
            /*  case 'postshare':
                  $id = (isset($_GET['postid'])) ? $_GET['postid'] : '0';
                  return UsersClass::LoadPost($id);
                  break;*/
            /* case 'viewsubjects':
                 $type = (isset($_GET['type'])) ? $_GET['type'] : 'single';
                 $id = (isset($_GET['id']) && (int)$_GET['id'] > 0) ? $_GET['id'] : '0';
                 return SubjectClass::ViewSubject($type, $id);
                 break;*/
            /*case 'viewreports':
                $type = (isset($_GET['type'])) ? $_GET['type'] : 'single';
                $id = (isset($_GET['id'])) ? $_GET['id'] : '0';
                return FormClass::ViewRepors($uid, $sesid, $id);
                break;*/
            /*case 'viewfromreport':
                $formid = (isset($_GET['formid'])) ? $_GET['formid'] : '0';
                $repid = (isset($_GET['repid'])) ? $_GET['repid'] : '0';
                return FormClass::viewfromreport($uid, $sesid, $formid, $repid);
                break;*/
            /*case 'editrports':
                $formid = (isset($_GET['formid']) && (int)$_GET['formid'] > 0) ? $_GET['formid'] : '0';
                $repid = (isset($_GET['repid']) && (int)$_GET['repid'] > 0) ? $_GET['repid'] : '0';
                return FormClass::viewfromreport($uid, $sesid, $formid, $repid, 'ok');
                break;*/

            /*case 'setting':
                $title = (isset($_GET['title'])) ? $_GET['title'] : 'عنوان';
                $type = (isset($_GET['type'])) ? $_GET['type'] : 'user';
                if ($type == 'user' || $type == 'aboutuser')
                {
                    return SNClass::usersetting($id, $uid, $sesid);
                }
                elseif ($type == 'subject')
                {
                    $sid = (isset($_GET['sid']) && (int)$_GET['sid'] > 0) ? $_GET['sid'] : '0';
                    $pid = (isset($_GET['pid'])) ? $_GET['pid'] : '0';
                    return PageClass::PageSetting($sid, $pid, $uid, $sesid, $title);
                }
                elseif ($type == 'group')
                {
                    $pid = (isset($_GET['pid'])) ? $_GET['pid'] : '0';
                    return GroupClass::GroupSetting($sid, $pid, $uid, $sesid, $title);
                }

                break;*/
            /* case 'newCircle':
                 return view('modals.newCircle');
                 break;*/
            /*case 'login':
                return view('modals.login');
                break;*/
            /* case 'addkeyword':
                 return view('modals.addkeyword');

                 break;*/
            /*case 'mergkeyword':
                return view('modals.mergkeyword', array('keyword' => $sid));
                break;*/

            /*case 'editkeyword':
                return \App\HamafzaViewClasses\KeywordClass::modaledit($sid);
                break;*/

            /*case 'newgroup':
                return view('modals.newgroup');

                break;*/
            /* case 'neworgan':
                 return view('modals.neworgan');
                 break;*/
            /*case 'viewmessage':
                return Message::ShowMessage($sid);
                break;*/
            /*case 'helpview':
                $id = (isset($_GET['id'])) ? $_GET['id'] : '0';
                $tagname = (isset($_GET['tagname'])) ? $_GET['tagname'] : 'tagname';
                $hid = (isset($_GET['hid'])) ? $_GET['hid'] : '0';
                $pid = (isset($_GET['pid'])) ? $_GET['pid'] : '0';
                return PublicClass::ShowHelp($id, $tagname, $hid, $pid);
                break;*/
            /* case 'share':
                 return \App\HamafzaViewClasses\PublicClass::Share($sid, $pid, $type, $title, 'false', $select);
                 break;*/
            /* case 'sociasearch':
                 return view('modals.socialsearch');
             case 'socialsearch':
                 return view('modals.socialsearch');
           /*      break;*/
            /*case 'addsubtem':
                return view('modals.editor');
                break;*/
            /*    case 'helprel':
                    $orig = (isset($_GET['orig'])) ? $_GET['orig'] : '0';
                    $pid = (isset($_GET['pid'])) ? intval($_GET['pid']) : '0';
                    $orig = str_replace("{{Help ", "{{Help+", $orig);
                    return AJAX::showhelprel($orig, $pid);
                    break;*/
            /* case 'getaccessusers':
                 return UsersClass::GetAccessUsers($sid);
                 break;*/
            /* case 'pageinsubject':
                 return PageClass::pageinsubject($sid);
                 break;*/
            /*case 'CreateNewTask':
                $user = \Auth::user()->getAttributes();
                $uname = $user['Uname'];
                return redirect()->route('Tasks.CreateNewTaskWindow', $uname);
                break;*/
            /*case 'CreateNewProject':
                $user = \Auth::user()->getAttributes();
                $uname = $user['Uname'];
                return redirect()->route('Project.project_window', $uname);
                break;*/
            /* case 'CreateNewProcess':
                 $user = \Auth::user()->getAttributes();
                 $uname = $user['Uname'];
                 return redirect()->route('Process.process_window', $uname);
                 break;*/
        }
    }

    private function getParams($params)
    {

        foreach ($params as $param)
        {
            if (\Request::exists($param))
            {
                $return [$param] = \Request::input($param);
            }
            else
            {
                $return [$param] = false;
            }
        }
        return $return;
    }

    public function profile_avatar()
    {
        $user = auth()->user();
        $HFMAvatarImage = HFM_GenerateUploadForm(
            [
                ['item_image', ['jpg', 'png', 'jpeg', 'gif', 'bmp'], "Multi"],
                ['item_file', ['zip', 'doc', 'docx', 'pdf', 'mp3', 'amr'], "Multi"],
                ['item_image_edit', ['jpg', 'png', 'jpeg', 'gif', 'bmp'], "Multi"],
                ['item_file_edit', ['zip', 'doc', 'docx', 'pdf', 'mp3', 'amr'], "Multi"],
            ]);

        return json_encode([
            'header' => trans('profile.user_avatar_change'),
            'content' => view('modals.avatar')
                ->with('user', $user)
                ->with('HFMAvatarImage', $HFMAvatarImage)
                ->render(),
            'footer' => view('modals.helper.avatar.footer.user_avatar_jspanel_footer')
                ->with('user', $user)
                ->with('HFMAvatarImage', $HFMAvatarImage)
                ->render()
        ]);
    }

    public function add_new_role()
    {
        return json_encode([
            'header' => trans('acl.add_new_role'),
            'content' => view('modals.add_new_role')
                ->render(),
            'footer' => view('modals.helper.acl.footer.add_new_role')->render()
        ]);
    }

    public function add_new_permission()
    {
        return json_encode([
            'header' => trans('acl.add_new_permission'),
            'content' => view('modals.add_new_permission')
                ->render(),
            'footer' => view('modals.helper.acl.footer.add_new_permission')->render()
        ]);
    }

    public function add_new_permission_cat()
    {
        return json_encode([
            'header' => trans('acl.add_new_permission_category'),
            'content' => view('modals.add_new_permission_cat')
                ->render(),
            'footer' => view('modals.helper.acl.footer.add_new_permission')->render()
        ]);
    }

    public function forShow()
    {
        $res = $this->getParams(['uid', 'sessid', 'id', 'pid', 'sid']);
        $content = FormClass::viewfrom($res['uid'], $res['sessid'], $res['id'], $res['pid'], $res['sid'])->render();
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);
    }

    public function message()
    {
        $HFM_message_file = HFM_GenerateUploadForm(
            [
                ['message_file', ['zip', 'doc', 'docx', 'pdf', 'mpga', 'amr', 'jpg', 'jpeg', 'png', 'gif', 'bmp', 'xls', 'xlsx', 'ppt', 'pptx'], "Multi"],
            ]);
        $content = view('modals.message')
            ->with('HFM_message_file', $HFM_message_file)
            ->render();
        return json_encode([
            'header' => '',
            'content' => $content,
            'footer' => view('modals.helper.message.footer')
                ->render()]);
    }

    public function newSubject()
    {
        $res = $this->getParams(['uid', 'sesid', 'title']);
        $content = SubjectClass::newsubject($res['uid'], $res['sesid'], $res['title']);
        $footer = view('hamahang.Subjects.new_subject_modals.footer')->render();
        return json_encode(['header' => '', 'content' => $content, 'footer' => $footer]);
    }

    public function viewSubject()
    {
        $res = $this->getParams(['sid']);
        $sid = deCode($res['sid']);
        $subjectType = SubjectType::find($sid);

        //$content = \SubjectClass::newsubject($res['uid'], $res['sesid'], $res['title']);
        $content = view('hamahang.Subjects.view_subject_modals.content')->with('sid', $sid)->render();
        $footer = view('hamahang.Subjects.view_subject_modals.footer')->render();
        return json_encode(['header' => 'صفحات - نوع :' . '  ' . $subjectType->name . '', 'content' => $content, 'footer' => $footer]);
    }

    public function announce()
    {
        $res = $this->getParams(['sid', 'pid', 'type', 'title', 'sel']);
        $header = view('modals.announce.helper.header', $res)->render();
        $content = view('modals.announce.content', $res)->render();
        $footer = view('modals.announce.helper.footer', $res)->render();
        return json_encode(['header' => $header, 'content' => $content, 'footer' => $footer]);
    }

    public function mPrint()
    {
        $res = $this->getParams(['sid', 'pid', 'type']);
        $content = SubjectClass::subjectPrint($res['sid'], $res['pid'], $res['type'])->render();
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);
    }

    public function FetchMyFiles()
    {
        $res = $this->getParams(['uid', 'act', 'item']);
        return json_encode([
            'header' => trans('filemanager.selectd_file'),
            'content' => view('hamahang.FileManager.ShowMyFiles')->with('act', $res['act'])->with('item', $res['item'])->render(),
            'footer' => view('hamahang.helper.JsPanelsFooter')->with('btn_type', 'ddd')->render()
        ]);
    }

    public function export()
    {
        $res = $this->getParams(['sid', 'pid', 'type']);
        if($res['type'] == 'EXCEL')
        {
            $Tasks = Session::get('MyTasksFetch');
            dd($Tasks);
            return Excel::create('Filename', function($excel) {
                $excel->sheet('Sheetname', function($sheet) {
                    $Tasks = Session::get('MyTasksFetch');
                    $sheet->fromArray(
                        $Tasks->original['data']
                    );
                });
            })->download('xls');
        }else{
            $content = SubjectClass::subjectExport($res['sid'], $res['pid'], $res['type'])->render();
            $footer = '<span class="FloatLeft">'
                . '<a id="wordexport" class="btn btn-primary">دریافت فایل ورد</a> '
                . '<a target="_blank" class="btn btn-danger" href="'.route('modals.exportExcel').'"> دریافت فایل اکسل</a>'
                //. ' <a id="pdfexport" class="btn btn-primary">دریافت فایل پی دی اف</a>'
                . '</span>';
            return json_encode(['header' => 'بارگیری', 'content' => $content, 'footer' => $footer]);
        }
    }

    public function exportExcel()
    {
//        $date = new jDateTime;
//        $datetime = explode(' ', date('Y-m-d h:i:s'));
//        $now = explode('-', $datetime[0]);
//        $time = explode(':', $datetime[1]);
//        $g_timestamp = mktime($time[0], $time[1], $time[2], $now[1], $now[2], $now[0]);
//        $jdate = $date->getdate($g_timestamp);
//        $jdateA = $jdate['year'] . '-' . $jdate['mon'] . '-' . $jdate['mday'].' '.$datetime[1];

        $res = $this->getParams(['display_name']);
        $Tasks = Session::get('MyTasksFetch');
        return Excel::create($res['display_name'].'---'.date('Y-m-d-h:i:s'), function($excel) {
            $excel->sheet('Sheetname', function($sheet) {
                $Tasks = Session::get('MyTasksFetch');
                $sheet->fromArray(
                    $Tasks->original['data']
                );

            });

        })->download('xls');
    }

    public function notification()
    {
        $res = $this->getParams(['sid']);
        $content = SubjectClass::notification($res['sid']);
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);
    }

    public function mDelete()
    {
        $res = $this->getParams(['sid', 'pid', 'type']);
        $content = SubjectClass::delete($res['sid'], $res['pid'], $res['type'])->render();
        $footer = '<button type="button" class="btn btn-primary" onclick="$(\'.jsglyph-close\').click();"><span> بستن </span></button>';
        return json_encode(['header' => '', 'content' => $content, 'footer' => $footer]);
    }

    public function postlike()
    {
        $res = $this->getParams(['pid']);
        $content = Localclass::Postlike($res['pid']);
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);
    }

    public function history()
    {
        $res = $this->getParams(['sid', 'pid', 'type']);
        $content = SubjectClass::history($res['sid'], $res['pid'], $res['type'])->render();
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);
    }

    public function seluser()
    {
        $res = $this->getParams(['type']);
        $type = (isset($res['type'])) ? $res['type'] : 'single';
        $content = \App\HamafzaViewClasses\SNClass::Seluser($type)->render();
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);
    }

    public function postshare()
    {
        $res = $this->getParams(['postid']);
        $id = (isset($res['postid'])) ? $res['postid'] : '0';
        $content = UsersClass::LoadPost($id)->render();
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);
    }

    public function viewSubjects()
    {
        $res = $this->getParams(['type', 'id']);
        $type = (isset($res['type'])) ? $res['type'] : 'single';
        $id = (isset($res['id']) && (int)$res['id'] > 0) ? $res['id'] : '0';
        $content = SubjectClass::ViewSubject($type, $id)->render();
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);
    }

    public function viewReports()
    {
        $res = $this->getParams(['id', 'sesid']);
        // $type = (isset($res['type'])) ? $res['type'] : 'single';
        $id = (isset($res['id'])) ? $res['id'] : '0';
        $content = FormClass::ViewRepors(\Auth::id(), $res['sesid'], $id);
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);
    }

    public function viewFromreport()
    {
        $res = $this->getParams(['formid', 'repid', 'sesid']);
        $formid = (isset($res['formid'])) ? $res['formid'] : '0';
        $repid = (isset($res['repid'])) ? $res['repid'] : '0';
        $content = FormClass::viewfromreport(\Auth::id(), $res['sesid'], $formid, $repid);
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);

    }

    public function editrPorts()
    {
        $res = $this->getParams(['formid', 'repid', 'sesid']);
        $formid = (isset($res['formid']) && (int)$res['formid'] > 0) ? $res['formid'] : '0';
        $repid = (isset($res['repid']) && (int)$res['repid'] > 0) ? $res['repid'] : '0';
        $content = FormClass::viewfromreport(\Auth::id(), $res['sesid'], $formid, $repid, 'ok');
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);

    }

    public function setting()
    {
        $res = $this->getParams(['type', 'title', 'id', 'sesid', 'sid', 'pid']);
        $title = (isset($res['title']) && $res['title']) ? $res['title'] : 'عنوان';
        $type = (isset($res['type']) && $res['type']) ? $res['type'] : 'user';
        $content = "";
        if ($type == 'user' || $type == 'aboutuser')
        {
            $content = view('modals.user_setting')->render();
        }
        elseif ($type == 'subject')
        {
            $sid = (isset($res['sid']) && (int)$res['sid'] > 0) ? $res['sid'] : '0';
            $pid = (isset($res['pid'])) ? $res['pid'] : '0';
            $content = PageClass::PageSetting($sid, $pid, \Auth::id(), $res['sesid'], $res['title']);
        }
        elseif ($type == 'group')
        {
            $pid = (isset($res['pid'])) ? $res['pid'] : '0';
            $content = GroupClass::GroupSetting($res['sid'], $pid, \Auth::id(), $res['sesid'], $title)->render();
        }
        $apply = '<input type="submit" class="btn btn-primary btn-footer omomi_btn" data-apply="apply" value="ذخیره " style=" float: left" id="submit2"> ';
        $save = '<input type="submit" class="btn btn-primary btn-footer omomi_btn" value="تایید " style=" float: left" id="submit2">';
        return json_encode(['header' => '', 'content' => $content, 'footer' => $apply . $save]);
    }

    public function newCircle()
    {
        $content = view('modals.newCircle')->render();
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);

    }

    public function login()
    {
        $content = view('modals.login')->render();
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);

    }

    public function mergKeyword()
    {
        $res = $this->getParams(['sid']);
        $content = view('modals.mergkeyword', array('keyword' => $res['sid']))->render();
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);

    }

    public function edit_Keyword()
    {
        $res = $this->getParams(['sid']);
        $content = \App\HamafzaViewClasses\KeywordClass::modaledit($res['sid'])->render();
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);

    }

    public function newGroup()
    {
        $content = view('modals.newgroup')->render();
        return json_encode(['header' => '', 'content' => $content, 'footer' => '<input type="submit" value="تایید " class="btn btn-primary FloatLeft" name="addUserGroup" id="addUserGroupBtn">']);

    }

    public function newOrgan()
    {
        $content = view('modals.neworgan')->render();
        return json_encode(['header' => '', 'content' => $content, 'footer' => '<input type="submit" value="تایید " class="btn btn-primary FloatLeft" name="addUserGroup" id="addUserOrganBtn">']);

    }

    public function viewMessage(Request $request)
    {
        $ticket = Ticket::find($request->sid);
        $content = view('hamahang.Tickets.view_ticket_modals.content')
            ->with('ticket', $ticket)
            ->render();
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);
    }

    public function share()
    {
        $res = $this->getParams(['sid', 'pid', 'type', 'title', 'select']);
        $content = \App\HamafzaViewClasses\PublicClass::Share($res['sid'], $res['pid'], $res['type'], $res['title'], 'false', $res['select'])->render();
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);
    }

    public function sociaSearch()
    {
        $arr['type'] = \Request::input('type');
        $content = view('modals.socialsearch', $arr)->render();
        return json_encode(['header' => trans('app.search'), 'content' => $content, 'footer' => '']);
    }

    public function helpView(Request $request)
    {
        $view = trans('app.no_result');
        $see_alsos = null;
        if ($request->exists('code'))
        {
            $id = deCode($request->input('code'));
            $help = \App\Models\Hamahang\Help::find($id);
            if ($help)
            {
                if ($blocks = $help->HelpBlocks)
                {
                    $view = "<h3 style=\"color: #6391C5;\">{$help->title}</h3>";
//                    dd($blocks);
                    foreach ($blocks as $block)
                    {
                        $view .= str_ireplace('src="tinymce', 'src="'.env('MASTER_URL').'/tinymce', str_ireplace('src="FileManager', 'src="'.env('MASTER_URL').'/FileManager', str_ireplace('src="../../', 'src="'.env('MASTER_URL').'/', str_ireplace('src="/FileManager', 'src="'.env('MASTER_URL').'/FileManager', $block->content))))."\n";
                    }
                }
                $see_alsos = $help->SeeAlsos();
            }
        } else
        {
            $res = $this->getParams(['id', 'tagname', 'hid', 'pid']);
            $id = (isset($res['id'])) ? $res['id'] : '0';
            $tagname = (isset($res['tagname'])) ? $res['tagname'] : 'tagname';
            $hid = (isset($res['hid'])) ? $res['hid'] : '0';
            $pid = (isset($res['pid'])) ? $res['pid'] : '0';
            $content = PublicClass::ShowHelp($id, $tagname, $hid, $pid);
            return json_encode(['header' => '', 'content' => $content->render(), 'footer' => '']);
        }
        $header = view('modals.help.view.header')->with([])->render();
        $content = view('modals.help.view.content')->with(['view' => $view, 'see_alsos' => $see_alsos, 'id' => $id])->render();
        $footer = view('modals.help.view.footer')->with([])->render();
        if ($request->exists('content'))
        {
            return $content;
        } else
        {
            return json_encode(['header' => $header, 'content' => $content, 'footer' => $footer]);
        }
    }

    public function addSubtem()
    {
        $content = view('modals.editor');
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);
    }

    public function helpRel()
    {
        $res = $this->getParams(['orig', 'pid']);
        $orig = (isset($res['orig'])) ? $res['orig'] : '0';
        $pid = (isset($res['pid'])) ? intval($res['pid']) : '0';
        $orig = str_replace("{{Help ", "{{Help+", $orig);
        $content = AJAX::showhelprel($orig, $pid);
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);
    }

    public function getAccessUsers()
    {
        $res = $this->getParams(['sid']);
        $content = UsersClass::GetAccessUsers($res['sid'])->render();
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);
    }

    public function pageinSubject()
    {
        $res = $this->getParams(['sid']);
        $content = PageClass::pageinsubject($res['sid'])->render();
        return json_encode(['header' => '', 'content' => $content, 'footer' => '']);
    }

    public function CreateNewTask()
    {
        $tid = '';
        $task = '';
        $res = $this->getParams(['sid', 'pid', 'sel', 'urid', 'kdid', 'tid']);
        if ($res['sid'])
        {
            $res['subject'] = Subject::find($res['sid']);
        }
        if ($res['urid'])
        {
            $res['responsible'] = User::find($res['urid'])->toArray();
        }
        if ($res['kdid'])
        {
            $res['keyword'] = Keyword::find($res['kdid']);
        }
        if ($res['tid'])
        {
            $tid = $res['tid'];
            $task = tasks::find(deCode($res['tid']));
            $res['task'] = $this->TakeTaskInfo($res,$task);
        }
        if ($res['pid'])
        {
            $tid = $res['pid'];
            $res['project'] = projects::find($res['pid']);
        }
        $arr['HFM_CN_Task'] = HFM_GenerateUploadForm(
            [
                ['CreateNewTask',
                    ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
                    'Multi']
            ]
        );
//        dd($res);
        $arr = array_merge($arr, $res);
        return json_encode([
            'header' => trans('tasks.create_new_task'),
            'content' => view('hamahang.Tasks.helper.CreateNewTask.CreateNewTaskWindow', $arr)->render(),
            'footer' => view('hamahang.helper.JsPanelsFooter',['tid'=>$tid])->with('btn_type', 'CreateNewTask')->render()
        ]);
    }

    public function TakeTaskInfo($res,$task)
    {
        if ($res['sid'])
        {
            $res['subject'] = Subject::find($res['sid']);
        }
        $task_all = $task;
//        dd($task);
//        dd($res['tid'],$task);

        $task_aid = $res['tid'];
        $task = unserialize($task->task_attributes);
        $task_pages = array();
        if(isset($task['pages']))
        {
            if(count($task['pages'])>0)
            {
                $pages = array();
                if(is_array($task['pages']))
                    $pages = $task['pages'];
                else
                    $pages = array($task['pages']);
                $task_pages = DB::table('subjects as s')
                    ->select('s.id', 's.title')
                    ->whereIn('s.id', $pages)->get();
            }
        }

        $task_projects = DB::table('hamahang_project_task')
            ->join('hamahang_project','hamahang_project.id','=','hamahang_project_task.project_id')
            ->select('hamahang_project.id', 'hamahang_project.title')
            ->whereNull('hamahang_project_task.deleted_at')
            ->where('hamahang_project_task.task_id','=', $task_aid)->get();
//        if(isset($task['project_tasks']))
//        {
//            if(count($task['project_tasks'])>0)
//            {
//                $projects = array();
//                if(is_array($task['project_tasks']))
//                    $projects = $task['project_tasks'];
//                else
//                    $projects = array($task['project_tasks']);
//                $task_pages = DB::table('hamahang_project_task as s')
//                    ->join('hamahang_project','project_id','=','id')
//                    ->select('hamahang_project.id', 'hamahang_project.title')
//                    ->whereIn('hamahang_project_task.project_id', $projects)->get();
//            }
//        }

        $task_users = array();
        if(isset($task['users']))
        {
            if(count($task['users'])>0)
            {
                $users = array();
                if(is_array($task['users']))
                    $users = $task['users'];
                else
                    $users = array($task['users']);
                $task_users = DB::table('user')
                    ->select('Name', 'Family', 'id')
                    ->whereIn('id', $users)->get();
            }
        }

        $task_transcripts = array();
        if(isset($task['transcripts']))
        {
            if(count($task['transcripts'])>0)
            {
                $transcripts = array();
                if(is_array($task['transcripts']))
                    $transcripts = $task['transcripts'];
                else
                    $transcripts = array($task['transcripts']);
                $task_transcripts = DB::table('user')
                    ->select('Name', 'Family', 'id')
                    ->whereIn('id', $transcripts)->get();
            }
        }

        $task_keywords = array();
        if(isset($task['keywords']))
        {
            if(count($task['keywords'])>0)
            {
                $keywords = array();
                if(is_array($task['keywords']))
                {
                    foreach ($task['keywords'] as $k=>$v)
                        $keywords[$k] = str_replace('exist_in','',$v);
                }
                else
                    $keywords = array(str_replace('exist_in','',$task['keywords']));
                $task_keywords = DB::table('keywords')
                    ->select('id', 'title')
                    ->whereIn('id', $keywords)->get();
            }
        }

        $task_history = task_history::GetTaskHistory($res['tid']);
//        dd($task_history);
        $d = new jDateTime;
        foreach ($task_history as $t)
        {

            $datetime = explode(' ', $t->created_at);
            $date = explode('-', $datetime[0]);
            $time = explode(':', $datetime[1]);
            $g_timestamp = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
            $jdate = $d->getdate($g_timestamp);
            $jdate = $jdate['year'] . '/' . $jdate['mon'] . '/' . $jdate['mday'];
            $t->created_at = $jdate;
        }
        if(isset($task['respite_date']))
        {
            $date = explode('-', $task['respite_date']);
            $task['respite_date'] = $d->Jalali_to_Gregorian($date[0], $date[1], $date[2],'-');
        }
        if(isset($task['schedul_begin_date'])) {
            $date = explode('-', $task['schedul_begin_date']);
            $task['schedul_begin_date'] = $d->Jalali_to_Gregorian($date[0], $date[1], $date[2],'-');
//            $task['schedul_begin_date'] = jDateTime::mktime(24, 0, 0, $date[1], $date[2], $date[0], true);
        }
        if(isset($task['schedul_end_date_date'])) {
            $date = explode('-', $task['schedul_end_date_date']);
            $task['schedul_end_date_date'] = $d->Jalali_to_Gregorian($date[0], $date[1], $date[2], '-');
//            mktime(24, 0, 0, $date[1], $date[2], $date[0], true);
//                mktime($hour, $minute, $second, $month, $day, $year, $jalali = null, $timezone = null)
        }
//        $task['respite_date'];
//        dd($res['tid']);
        Session::put('TaskForm_tid',($res['tid']));
        if(isset($res['aid']))
        {
            Session::put('TaskForm_aid',($res['aid']));
        }
        Session::put('TaskForm_is_creator',$task_all->uid != Auth::id() ? true : false);
        Session::put('TaskForm_task_all',$task);
        $res['task_all'] = $task_all;
        $res['task'] = $task;
        $res['task_id'] = enCode($res['tid']);
        $res['pages'] = $task_pages;
        $res['task_pages'] = $task_pages;
        $res['task_projects'] = $task_projects;
        $res['task_users'] = $task_users;
        $res['task_transcripts'] = $task_transcripts;
        $res['task_keywords'] = $task_keywords;
        $res['task_history'] = $task_history;
        return $res;
    }

    public function ShowLiberaryTaskForm()
    {
        $res = $this->getParams(['tid','sid','aid']);
        $task = array();
        if ($res['tid'])
        {
            $task = DB::table('hamahang_task_library')
                ->select('hamahang_task_library.*')
                ->where('id','=', decode($res['tid']))
                ->first();
        }
        $res = $this->TakeTaskInfo($res,$task);
        $arr['HFM_CN_Task'] = HFM_GenerateUploadForm(
            [
                ['CreateNewTask',
                    ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
                    'Multi']
            ]
        );
        $arr = array_merge($arr, $res);

        return json_encode([
            'header' => trans('tasks.show_task'),
            'content' => view('hamahang.Tasks.helper.ShowLiberaryTaskForm.ShowLiberaryTaskFormWindow', $arr)
                ->with('res', $res)->render(),
            'footer' => view('hamahang.helper.JsPanelsFooter')->with(['btn_type' => 'ShowLiberaryTaskForm' , 'type' => $task->type])->render()
        ]);
    }

    public function ShowAssignTaskForm()
    {
        $res = $this->getParams(['tid','sid','aid']);
        $task = array();
        if ($res['tid'])
        {
            $res['tid'] = deCode($res['tid']);
            $aid = deCode($res['aid']);

            $task = DB::table('hamahang_task_assignments as t')
                ->leftJoin('hamahang_task', 'hamahang_task.id', '=', 't.task_id')
                ->leftJoin('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
                ->leftjoin('hamahang_task_transcript', 'hamahang_task_transcript.task_id', '=', 'hamahang_task.id')
                ->select('hamahang_task.*','hamahang_task_status.type as task_status','hamahang_task_status.percent as percent')
                ->where('t.task_id','=', $res['tid'])
                ->where('t.id','=', $aid)
                ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
                ->whereNull('hamahang_task_status.deleted_at')
                ->where(function($q) {
                    $q->where('t.assigner_id', Auth::id())
                        ->orWhere('t.employee_id', Auth::id())
                        ->orWhere('t.employee_id', Auth::id())
                        ->orWhere('t.uid', Auth::id());
                })
                ->first();
        }
        $res = $this->TakeTaskInfo($res,$task);
        $res['task_status'] = $task->task_status;
        $res['events'] = DB::table('hamahang_calendar_events_task as t')->where('t.task_id','=',$res['tid'])
            ->leftJoin('hamahang_calendar_user_events as e','e.id','=','t.event_id')
            ->whereNull('t.deleted_at')
            ->whereNull('e.deleted_at')
            ->select(DB::Raw('t.id as ctid,e.*, TIMEDIFF(e.enddate, e.startdate) as dif'))->get();
        $res['events'] = (Datatables::of($res['events'])
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->editColumn('ctid', function ($data)
            {
                return enCode($data->ctid);
            })->make(true));

        $res['task_status'] = $task->task_status;
        $res['percent'] = $task->percent;
        $arr['HFM_CN_Task'] = HFM_GenerateUploadForm(
            [
                ['CreateNewTask',
                    ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
                    'Multi']
            ]
        );
        $arr = array_merge($arr, $res);
        return json_encode([
            'header' => trans('tasks.show_task'),
            'content' => view('hamahang.Tasks.helper.ShowAssignTaskForm.ShowAssignTaskFormWindow', $arr)
                ->with('res', $res)->render(),
            'footer' => view('hamahang.helper.JsPanelsFooter')->with('btn_type', 'ShowAssignTaskForm')->render()
        ]);
    }

    public function ViewStaffForm(){
        $res = $this->getParams(['sid']);
        $sid = deCode($res['sid']);
        $staff = org_staff::where('id', '=', $sid)->with('posts', 'edus', 'jobs', 'relations', 'childs', 'spouses', 'families', 'posts.job')->first();
        $d = new jDateTime;
//        $birth_date = preg_split('/ /', $staff->birth_date);
//        $date = preg_split('/-/', $birth_date[0]);
//        $staff->birth_date = $d->Jalali_to_Gregorian($date[0], $date[1], $date[2],'-');

        return json_encode([
            'header' => trans('org_chart.assign_new_staff'),
            'content' => view('modals.organ.add_organ.jsp_assign_staff_content')->with('staff', $staff)->with('sid', $res['sid'])
                ->render(),
            'footer' => view('modals.organ.add_organ.jsp_assign_edit_staff_footer')
                ->render()
        ]);
    }

    public function ViewStaffDoc(){
        $res = $this->getParams(['sid']);
        $sid = deCode($res['sid']);
        $staff = org_staff::where('id', '=', $sid)->with('childs', 'spouses', 'families')->first();
        return json_encode([
            'header' => trans('org_chart.staff'),
            'content' => view('modals.organ.add_organ.jsp_doc_staff_content')->with('staff', $staff)->with('sid', $res['sid'])
                ->render(),
            'footer' => view('modals.organ.add_organ.jsp_doc_staff_footer')
                ->render()
        ]);
    }

    public function ViewJobItem(){
        $sid = $this->getParams(['sid']);
        $data = onet_job::where('id', '=', $sid)->with('skill', 'skill.skill', 'ability', 'ability.ability', 'knowledge', 'knowledge.knowledge')->first();
        return json_encode([
            'header' => trans('org_chart.job'),
            'content' => view('modals.organ.add_organ.jsp_job_item_content')->with('job', $data)
                ->render(),
            'footer' => view('modals.organ.add_organ.jsp_job_item_footer')
                ->render()
        ]);
    }
    public function ViewJobForm(){
        $sid = $this->getParams(['sid']);
        $data = org_charts_items_jobs::where('id', '=', $sid)->with('posts', 'job', 'item')->first();
        return json_encode([
            'header' => trans('org_chart.job'),
            'content' => view('modals.organ.add_organ.jsp_job_content')->with('job', $data)
                ->render(),
            'footer' => view('modals.organ.add_organ.jsp_assign_edit_staff_footer')
                ->render()
        ]);
    }
    public function ViewTaskForm()
    {
        $res = $this->getParams(['tid','pid','aid']);
        $projectRole = [];
        $taskRole = [];
        if(trim($res['pid'])!=='')
        {
            $pid = deCode($res['pid']);
            $projectRole = ProjectController::TakeProjectPermissions($pid);
        }
        if(trim($res['tid'])!=='')
        {
            $tid = deCode($res['tid']);
            $taskRole = \App\Http\Controllers\Hamahang\Tasks\TaskController::TakeTaskRoles($tid);
        }
        $act = Input::has('act') ? Input::get('act') : '';
        if(in_array(\App\Http\Controllers\Hamahang\Tasks\TaskController::$_ROLE_CREATOR,$taskRole)){
            if($act=='do')
                return $this->ShowTaskFormOperatorMode();
            else
                return $this->ShowTaskFormOwnerMode();
        }elseif(in_array(\App\Http\Controllers\Hamahang\Tasks\TaskController::$_ROLE_ASSIGNER,$taskRole)){
            return $this->ShowTaskFormOperatorMode();
        }elseif(in_array(\App\Http\Controllers\Hamahang\Tasks\TaskController::$_ROLE_TRANSCRIPTION,$taskRole)){
            return $this->ShowTaskFormAbroadMode();
        }elseif(in_array(ProjectController::$_MANAGE_TASK_PROJECT_PERMISSSION,$projectRole) || in_array(ProjectController::$_MANAGE_PROJECT_PERMISSSION,$projectRole) || in_array(ProjectController::$_VIEW_PROJECT_PERMISSSION,$projectRole)){
            return $this->ShowTaskFormAbroadMode();
        }
    }

    public function ShowTranscriptTaskForm()
    {
        $res = $this->getParams(['tid','sid','aid']);
        $task = array();
        if ($res['tid'])
        {
            $res['tid'] = deCode($res['tid']);

            $task = DB::table('hamahang_task_assignments as t')
                ->leftJoin('hamahang_task', 'hamahang_task.id', '=', 't.task_id')
                ->leftJoin('hamahang_task_status', 'hamahang_task_status.task_id', '=', 'hamahang_task.id')
                ->leftjoin('hamahang_task_transcript', 'hamahang_task_transcript.task_id', '=', 'hamahang_task.id')
                ->select('hamahang_task.*','hamahang_task_status.type as task_status','hamahang_task_status.percent as percent')
                ->where('t.task_id','=', $res['tid'])
                ->where('t.id','=', $res['aid'])
                ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = hamahang_task.id )')
                ->whereNull('hamahang_task_status.deleted_at')
                ->where(function($q) {
                    $q->where('t.assigner_id', Auth::id())
                        ->orWhere('t.employee_id', Auth::id())
                        ->orWhere('t.employee_id', Auth::id())
                        ->orWhere('t.uid', Auth::id());
                })
                ->first();
        }
        $res = $this->TakeTaskInfo($res,$task);
        $res['task_status'] = $task->task_status;
        $res['percent'] = $task->percent;
        $arr['HFM_CN_Task'] = HFM_GenerateUploadForm(
            [
                ['CreateNewTask',
                    ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
                    'Multi']
            ]
        );
        $arr = array_merge($arr, $res);
        return json_encode([
            'header' => trans('tasks.show_task'),
            'content' => view('hamahang.Tasks.helper.ShowAssignTaskForm.ShowAssignTaskFormWindow', $arr)
                ->with('res', $res)->render(),
            'footer' => view('hamahang.helper.JsPanelsFooter')->with('btn_type', '')->render()
        ]);
    }

    public function ShowTaskFormOwnerMode()
    {
        $jdate = new jDateTime;
        $res = $this->getParams(['tid','sid','aid']);
        $tid = deCode($res['tid']);
        $task = tasks::where('id','=',$tid)
            ->with('Keywords', 'Status', 'Events', 'Subjects', 'Pages', 'Projects', 'Tasks1', 'Tasks2', 'Priority', 'Assignments', 'Transcripts', 'History')->first();
        if(isset($task->History)){
            foreach ($task->History as $k => $history){
                $created_at = preg_split('/ /', $history->created_at);
                $r = $jdate->getdate(strtotime($history->created_at));
                $task->History[$k]->jalali_created_at = $r['year'] . '/' . $r['mon'] . '/' . $r['mday'].' - '.$created_at[1];
            }
        }
        $res['task'] = $task;
        $jdate ->getdate(strtotime($task->schedule_time) + $task->duration_timestamp);
        $arr['HFM_CN_Task'] = HFM_GenerateUploadForm(
            [
                ['CreateNewTask',
                    ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
                    'Multi']
            ]
        );
        $date = new jDateTime;
        $res['respite'] = [];
        if($task->respite_timing_type == 0){
            $respite_date = $date->getdate(strtotime($task->schedule_time) + $task->duration_timestamp, false, false);
            $res['respite_date'] = [
                'date' => jDateTime::convertElseNumbers($respite_date['year'].'-'.$respite_date['mon'].'-'.$respite_date['mday']),
                'hour' => jDateTime::convertElseNumbers($respite_date['hours'].':'.$respite_date['minutes'].':'.$respite_date['seconds'])
            ];
            $res['respite'] = hamahang_convert_timestamp_to_respite($task->duration_timestamp);
        }else if($task->respite_timing_type == 1){
            $res['respite'] = hamahang_convert_timestamp_to_respite($task->duration_timestamp);
            $respite_date = $date->getdate(strtotime($task->schedule_time) + $task->duration_timestamp, false, false);
            $res['respite_date'] = [
                'date' => jDateTime::convertElseNumbers($respite_date['year'].'-'.$respite_date['mon'].'-'.$respite_date['mday']),
                'hour' => jDateTime::convertElseNumbers($respite_date['hours'].':'.$respite_date['minutes'].':'.$respite_date['seconds'])
            ];
        }
        $arr = array_merge($arr, $res);
        return json_encode([
            'header' => trans('tasks.show_task'),
            'content' => view('hamahang.Tasks.helper.ShowTaskForm.ShowTaskFormWindow', $arr)
                ->with('res', $res)->render(),
            'footer' => view('hamahang.helper.JsPanelsFooter')->with(['btn_type'=>'ShowTaskForm','is_save'=>$task->is_save])->render()
        ]);
    }

    public function ShowTaskFormOperatorMode()
    {
        $jdate = new jDateTime;
        $res = $this->getParams(['tid','sid','aid']);
        $tid = deCode($res['tid']);
        $task = tasks::where('id','=',$tid)
            ->with('Keywords', 'Status', 'Events', 'Subjects', 'Pages', 'Projects', 'Tasks1', 'Tasks2', 'Priority', 'Assignments', 'Transcripts', 'History')->first();
        if(isset($task->History)){
            foreach ($task->History as $k => $history){
                $created_at = preg_split('/ /', $history->created_at);
                $r = $jdate->getdate(strtotime($history->created_at));
                $task->History[$k]->jalali_created_at = $r['year'] . '/' . $r['mon'] . '/' . $r['mday'].' - '.$created_at[1];
            }
        }

        $res['task'] = $task;
        $jdate ->getdate(strtotime($task->schedule_time) + $task->duration_timestamp);
        $arr['HFM_CN_Task'] = HFM_GenerateUploadForm(
            [
                ['CreateNewTask',
                    ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
                    'Multi']
            ]
        );

        $res['respite'] = [];
        if($task->respite_timing_type == 0){
            $respite_date = $jdate->getdate(strtotime($task->schedule_time) + $task->duration_timestamp, false, false);
            $res['respite_date'] = [
                'date' => jDateTime::convertElseNumbers($respite_date['year'].'-'.$respite_date['mon'].'-'.$respite_date['mday']),
                'hour' => jDateTime::convertElseNumbers($respite_date['hours'].':'.$respite_date['minutes'].':'.$respite_date['seconds'])
            ];
            $res['respite'] = hamahang_convert_timestamp_to_respite($task->duration_timestamp);
        }else if($task->respite_timing_type == 1){
            $res['respite'] = hamahang_convert_timestamp_to_respite($task->duration_timestamp);
            $respite_date = $jdate->getdate(strtotime($task->schedule_time) + $task->duration_timestamp, false, false);
            $res['respite_date'] = [
                'date' => jDateTime::convertElseNumbers($respite_date['year'].'-'.$respite_date['mon'].'-'.$respite_date['mday']),
                'hour' => jDateTime::convertElseNumbers($respite_date['hours'].':'.$respite_date['minutes'].':'.$respite_date['seconds'])
            ];
        }
        $arr = array_merge($arr, $res);

        return json_encode([
            'header' => trans('tasks.show_task'),
            'content' => view('hamahang.Tasks.helper.ShowTaskForm.ShowTaskFormOperatorWindow', $arr)
                ->with('res', $res)->render(),
            'footer' => view('hamahang.helper.JsPanelsFooter')->with('btn_type', 'ShowAssignTaskForm')->render()
        ]);

        return json_encode([
            'header' => trans('tasks.show_task'),
            'content' => view('hamahang.Tasks.helper.ShowAssignTaskForm.ShowAssignTaskFormWindow', $arr)
                ->with('res', $res)->render(),
            'footer' => view('hamahang.helper.JsPanelsFooter')->with('btn_type', 'ShowAssignTaskForm')->render()
        ]);
    }


    public function ShowTaskFormAbroadMode()
    {
        $jdate = new jDateTime;
        $res = $this->getParams(['tid','sid','aid']);
        $tid = deCode($res['tid']);
        $task = tasks::where('id','=',$tid)
            ->with('Keywords')
            ->with('Status')
            ->with('Subjects')
            ->with('Pages')
            ->with('AbroadPriority')
            ->with('Assignments')
            ->with('Transcripts')
            ->with('History')
            ->first();
        if(isset($task->History)){
            foreach ($task->History as $k => $history){
                $created_at = preg_split('/ /', $history->created_at);
                $r = $jdate->getdate(strtotime($history->created_at));
                $task->History[$k]->jalali_created_at = $r['year'] . '/' . $r['mon'] . '/' . $r['mday'].' - '.$created_at[1];
            }
        }
        $res['task'] = $task;

        $arr['HFM_CN_Task'] = HFM_GenerateUploadForm(
            [
                ['CreateNewTask',
                    ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
                    'Multi']
            ]
        );
        $arr = array_merge($arr, $res);
        return json_encode([
            'header' => trans('tasks.show_task'),
            'content' => view('hamahang.Tasks.helper.ShowTaskForm.ShowTaskFormWindow', $arr)
                ->with('res', $res)->with('disabled', 'disabled')->render(),
//            'footer' => view('hamahang.helper.JsPanelsFooter')->with(['btn_type'=>'ShowTaskForm','is_save'=>$res["task"]->is_save])->render()
        ]);
    }


    public function ShowTaskForm()
    {

        $jdate = new jDateTime;
        $res = $this->getParams(['tid','sid','aid']);
        $tid = deCode($res['tid']);
        $task = tasks::where('id','=',$tid)
            ->with('Keywords', 'Status', 'Subjects', 'Pages', 'Priority', 'Assignments', 'Transcripts', 'History')->first();
        $res['task'] = $task;
        $jdate ->getdate(strtotime($task->schedule_time) + $task->duration_timestamp);

//        dd($task);

        $arr['HFM_CN_Task'] = HFM_GenerateUploadForm(
            [
                ['CreateNewTask',
                    ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
                    'Multi']
            ]
        );
        $arr = array_merge($arr, $res);
        return json_encode([
            'header' => trans('tasks.show_task'),
            'content' => view('hamahang.Tasks.helper.ShowTaskForm.ShowTaskFormWindow', $arr)
                ->with('res', $res)->render(),
            'footer' => view('hamahang.helper.JsPanelsFooter')->with(['btn_type'=>'ShowTaskForm','is_save'=>$res["task"]->is_save])->render()
        ]);


        $res = $this->getParams(['tid','sid','aid']);
        $task = array();
        if ($res['tid'])
        {
            $res['tid'] = deCode($res['tid']);
//            $task = tasks::DraftTaskInfo($res['tid']);
            $task = DB::table('hamahang_task as t')
                ->leftJoin('hamahang_task_status', 'hamahang_task_status.task_id', '=', 't.id')
                ->leftjoin('hamahang_task_transcript', 'hamahang_task_transcript.task_id', '=', 't.id')
                ->select('t.*','hamahang_task_status.type as task_status','hamahang_task_status.percent as percent')
                ->where('t.id','=', $res['tid'])
                ->whereRaw('hamahang_task_status.id = (select max(`id`) from hamahang_task_status where `task_id` = t.id )')
                ->whereNull('hamahang_task_status.deleted_at')
                ->first();
        }

        $res = $this->TakeTaskInfo($res,$task);
        $res['task_status'] = $task->task_status;
        $res['percent'] = $task->percent;
        $arr['HFM_CN_Task'] = HFM_GenerateUploadForm(
            [
                ['CreateNewTask',
                    ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],
                    'Multi']
            ]
        );
        $arr = array_merge($arr, $res);
        return json_encode([
            'header' => trans('tasks.show_task'),
            'content' => view('hamahang.Tasks.helper.ShowLiberaryTaskForm.ShowLiberaryTaskFormWindow', $arr)
                ->with('res', $res)->render(),
            'footer' => view('hamahang.helper.JsPanelsFooter')->with(['btn_type'=>'ShowTaskForm','is_save'=>1])->render()
        ]);
    }

    public function CreateNewProject()
    {
        $arr['calendars'] = DB::table('hamahang_calendar')->select('id', 'title')->where('uid', '=', Auth::id())->get();
        return json_encode([
            'header' => trans('projects.create_new_project'),
            'content' => view('hamahang.Projects.create_new_project_window', $arr)->render(),
            'footer' => view('hamahang.helper.JsPanelsFooter')->with('btn_type', 'CreateNewProject')->render()
        ]);
    }

    public function CreateNewProcess()
    {
        return json_encode([
            'header' => trans('process.new_process'),
            'content' => view('hamahang.Process.create_new_process_window')->render(),
            'footer' => view('hamahang.helper.JsPanelsFooter')->with('btn_type', 'NewProcessWindow')->render()
        ]);
    }

    public function CreateNewCalendar()
    {
        return json_encode([
            'header' => trans('calendar.modal_calendar_ header_title'),
            'content' => view('hamahang.Calendar.helper.Index.modals.modal_calendar_add')->render(),
            'footer' => view('hamahang.Calendar.helper.Index.modals.modal_buttons')->with('btn_type', 'newCalendar')->render()
        ]);
    }

    public function BasicData_create_view()
    {
        $r = json_encode(
            [
                'header' => trans('افزودن گروه اطلاعات پایه جدید'),
                'content' => view('hamahang.Basicdata.helper.createedit-content')->render(),
                'footer' => view('hamahang.Basicdata.helper.createedit-footer')->with(['editid' => 0])->render()
            ]);
        return $r;
    }

    public function BasicData_value_create_view(Request $request)
    {
        $parentid = $request->input('parentid');
        $r = json_encode(
            [
                'header' => trans('افزودن مورد جدید'),
                'content' => view('hamahang.Basicdata.helper.valuecreateedit-content')->with(['parentid' => $parentid,])->render(),
                'footer' => view('hamahang.Basicdata.helper.valuecreateedit-footer')->with(['editid' => 0])->render()
            ]);
        return $r;
    }

    public function BasicData_url_value_create_view(Request $request)
    {
        $parentid = $request->input('parentid');
        $r = json_encode(
            [
                'header' => trans('افزودن مورد جدید'),
                'content' => view('hamahang.Basicdata.helper.create_addsettings_value-content')->with(['parentid' => $parentid,])->render(),
                'footer' => view('hamahang.Basicdata.helper.create_addsettings_value-footer')->with(['editid' => 0])->render()
            ]);
        return $r;
    }

    public function BasicData_edit_view(Request $request)
    {
        $id = $request->input('id');
        $basicdata = Basicdata::find($id)->toArray();
        $r = json_encode(
            [
                'header' => trans('ویرایش گروه اطلاعات پایه'),
                'content' => view('hamahang.Basicdata.helper.createedit-content')->with(['basicdata' => $basicdata])->render(),
                'footer' => view('hamahang.Basicdata.helper.createedit-footer')->with(['editid' => $id])->render()
            ]);
        return $r;
    }

    public function BasicData_value_edit_view(Request $request)
    {
        $id = $request->input('id');
        $basicdatavalue = BasicdataValue::find($id)->toArray();
        $r = json_encode
        ([
            'header' => trans('ویرایش گروه اطلاعات پایه'),
            'content' => view('hamahang.Basicdata.helper.valuecreateedit-content')->with(['basicdatavalue' => $basicdatavalue])->render(),
            'footer' => view('hamahang.Basicdata.helper.valuecreateedit-footer')->with(['editid' => $id])->render()
        ]);
        return $r;
    }

    public function BasicData_createedit(Request $request)
    {
        $request->merge(array('title' => strip_tags($request->input('title'))));
        $validator = Validator::make
        (
            $request->all(),
            [
                'editid' => 'required',
                'title' => 'required',
                'inactive' => 'required',
                'attr_title' => 'array',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        $editid = $request->input('editid');
        $title = $request->input('title');
        $inactive = $request->input('inactive');
        $comment = $request->exists('comment') ? $request->input('comment') : null;
        $attr_titles = $request->input('attr_title', []);


        if ('0' == $editid)
        {
            $basicdata_create = Basicdata::create(
                [
                    'title' => $title,
                    'comment' => $comment,
                    'inactive' => $inactive,
                ]);
            $basicdataattributes_create = [];
            foreach ($attr_titles as $attr_title)
            {
                $basicdataattributes_create[] = BasicdataAttributes::create(
                    [
                        'basicdata_id' => $basicdata_create->id,
                        'title' => $attr_title,
                        'target_table' => null,
                        'target_id' => 0,
                        'description' => null,
                        'created_by' => auth()->id(),
                    ]);
            }
            return response()->json(['success' => true, 'result' => [$basicdata_create->id, ['با موفقیت ثبت شد.']]]);
        }
        else
        {
            Basicdata::find($editid)->update(['title' => $title, 'comment' => $comment, 'inactive' => $inactive]);
            return response()->json(['success' => true, 'result' => [$editid, ['با موفقیت ویرایش شد.']]]);
        }
    }

    public function BasicData_valuecreateedit(Request $request)
    {
        $request->merge(array('title' => strip_tags($request->input('title'))));
        $is_kmkz = 'kmkz' == config('constants.IndexView');
        $is_banader = 'banader' == config('constants.IndexView');
        $has_parentid_9 = 9 == $request->input('parentid', 0);
        $has_parentid_5 = 5 == $request->input('parentid', 0);
        $custom_value_type = ($is_kmkz && $has_parentid_9) || $is_banader && $has_parentid_5 ? 'string' : 'integer';
        $validator = Validator::make
        (
            $request->all(),
            [
                'editid' => 'required',
                'parentid' => 'required_if:editid,0',
                'title' => 'required',
                'value' => "required|$custom_value_type",
                'inactive' => 'required',
            ],
            [],
            [
                'value' => 'مقدار',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        $editid = $request->input('editid');
        $parentid = $request->input('parentid');
        $title = $request->input('title');
        $value = $request->input('value');
        $inactive = $request->input('inactive');
        $comment = $request->exists('comment') ? $request->input('comment') : null;

        if ('0' == $editid)
        {
            $basicdatavalue_create = BasicdataValue::create(['parent_id' => $parentid, 'title' => $title, 'value' => $value, 'comment' => $comment, 'inactive' => $inactive]);
            return response()->json(['success' => true, 'result' => [$basicdatavalue_create->id, ['با موفقیت ثبت شد.']]]);
        }
        else
        {
            BasicdataValue::find($editid)->update(['title' => $title, 'value' => $value, 'comment' => $comment, 'inactive' => $inactive]);
            return response()->json(['success' => true, 'result' => [$editid, ['با موفقیت ویرایش شد.']]]);
        }
    }

    public function BasicData_url_value_edit_view(Request $request)
    {
//        dd($request->all());
        $request->merge(array('title' => strip_tags($request->input('title'))));
        $validator = Validator::make
        (
            $request->all(),
            [
                'editid' => 'required',
                'parentid' => 'required_if:editid,0',
                'title' => 'required',
                'value' => 'required',
                'inactive' => 'required',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        $editid = $request->input('editid');
        $parentid = $request->input('parentid');
        $title = $request->input('title');
        $value = $request->input('value');
        $inactive = $request->input('inactive');
        $comment = $request->exists('comment') ? $request->input('comment') : null;

        if ('0' == $editid)
        {
            $basicdatavalue_create = BasicdataValue::create(['parent_id' => $parentid, 'title' => $title, 'comment' => $comment, 'inactive' => $inactive]);

            BasicdataAttributesValues::create(['basicdata_value_id' => $basicdatavalue_create->id, 'basicdata_attribute_id' => 5, 'value' => $value]);
            return response()->json(['success' => true, 'result' => [$basicdatavalue_create->id, ['با موفقیت ثبت شد.']]]);
        }
        else
        {
            $basicdatavalue_create = BasicdataValue::find($editid)->update(['title' => $title, 'value' => $value, 'comment' => $comment, 'inactive' => $inactive]);
            BasicdataAttributesValues::create(['basicdata_value_id' => $basicdatavalue_create->id, 'basicdata_attribute_id' => 5, 'value' => $value]);
            return response()->json(['success' => true, 'result' => [$editid, ['با موفقیت ویرایش شد.']]]);
        }
    }

    public function BasicdataValueCreateEdit_Scores(Request $request)
    {
        $request->merge(array('title' => strip_tags($request->input('title'))));
        $validator = Validator::make
        (
            $request->all(),
            [
                'editid' => 'required',
                'parentid' => 'required_if:editid,0',
                'title' => '',
                'value' => 'integer',
                'inactive' => '',
                'a' => '',
                'b' => '',
                'c' => '',
            ],
            [],
            [
                'value' => 'مقدار',
                'inactive' => 'وضعیت',
                'a' => 'حداکثر امتیاز قابل اکتساب',
                'b' => 'تعداد مورد نیاز برای کسب نشان',
                'c' => 'نشان',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        $editid = $request->input('editid');
        $parentid = $request->input('parentid');
        $title = $request->input('title');
        $value = $request->input('value');
        $inactive = $request->input('inactive');
        $comment = $request->exists('comment') ? $request->input('comment') : null;
        $a = $request->input('a');
        $b = $request->input('b');
        $c = $request->input('c');

        BasicdataAttributesValues::where('basicdata_value_id', $editid)->delete();

        BasicdataAttributesValues::create(['basicdata_value_id' => $editid, 'basicdata_attribute_id' => '1', 'value' => $a, 'created_by' => auth()->id(),]);
        BasicdataAttributesValues::create(['basicdata_value_id' => $editid, 'basicdata_attribute_id' => '2', 'value' => $b, 'created_by' => auth()->id(),]);
        BasicdataAttributesValues::create(['basicdata_value_id' => $editid, 'basicdata_attribute_id' => '3', 'value' => $c, 'created_by' => auth()->id(),]);

        if ('0' == $editid)
        {
            $basicdatavalue_create = BasicdataValue::create(['parent_id' => $parentid, 'title' => $title, 'value' => $value, 'comment' => $comment, 'inactive' => $inactive]);
            return response()->json(['success' => true, 'result' => [$basicdatavalue_create->id, ['با موفقیت ثبت شد.']]]);
        }
        else
        {
            BasicdataValue::find($editid)->update(['title' => $title, 'value' => $value, 'comment' => $comment, 'inactive' => $inactive]);
            return response()->json(['success' => true, 'result' => [$editid, ['با موفقیت ویرایش شد.']]]);
        }
    }

    public function BasicdataValueCreateEdit_Medals(Request $request)
    {
        $request->merge(array('title' => strip_tags($request->input('title'))));
        $validator = Validator::make
        (
            $request->all(),
            [
                'editid' => 'required',
                'parentid' => 'required_if:editid,0',
                'title' => 'required',
                'value' => 'required|integer',
                'inactive' => 'required',
                //'a' => 'required',
                //'b' => 'required',
                //'c' => 'required',
            ]
        );
        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }
        $editid = $request->input('editid');
        $parentid = $request->input('parentid');
        $title = $request->input('title');
        $value = $request->input('value');
        $inactive = $request->input('inactive');
        $comment = $request->exists('comment') ? $request->input('comment') : null;
        //$a = $request->input('a');
        //$b = $request->input('b');
        //$c = $request->input('c');
        if ('0' == $editid)
        {
            $basicdatavalue_create = BasicdataValue::create(['parent_id' => $parentid, 'title' => $title, 'value' => $value, 'comment' => $comment, 'inactive' => $inactive]);
            return response()->json(['success' => true, 'result' => [$basicdatavalue_create->id, ['با موفقیت ثبت شد.']]]);
        }
        else
        {
            BasicdataValue::find($editid)->update(['title' => $title, 'value' => $value, 'comment' => $comment, 'inactive' => $inactive]);
            return response()->json(['success' => true, 'result' => [$editid, ['با موفقیت ویرایش شد.']]]);
        }
        /*
        $basicdataattributesvalues_a_create = BasicdataAttributesValues::create(['basicdata_value_id' => $basicdatavalue_create->id, 'basicdata_attribute_id' => '1', 'value' => $a, 'created_by' => auth()->id(), ]);
        $basicdataattributesvalues_b_create = BasicdataAttributesValues::create(['basicdata_value_id' => $basicdatavalue_create->id, 'basicdata_attribute_id' => '2', 'value' => $b, 'created_by' => auth()->id(), ]);
        $basicdataattributesvalues_c_create = BasicdataAttributesValues::create(['basicdata_value_id' => $basicdatavalue_create->id, 'basicdata_attribute_id' => '3', 'value' => $c, 'created_by' => auth()->id(), ]);
        */
    }

    public function BasicdataValueCreateEdit_PostMethods(Request $request)
    {
        $request->merge(array('title' => strip_tags($request->input('title'))));
        $validator = Validator::make
        (
            $request->all(),
            [
                'editid' => 'required',
                'parentid' => 'required_if:editid,0',
                'title' => 'required',
                'value' => 'required|integer',
                'inactive' => 'required',
                'a' => 'required',
            ]
        );
        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }
        $editid = $request->input('editid');
        $parentid = $request->input('parentid');
        $title = $request->input('title');
        $value = $request->input('value');
        $inactive = $request->input('inactive');
        $comment = $request->exists('comment') ? $request->input('comment') : null;
        $a = $request->input('a');
        if ('0' == $editid)
        {
            $basicdatavalue_create = BasicdataValue::create(['parent_id' => $parentid, 'title' => $title, 'value' => $value, 'comment' => $comment, 'inactive' => $inactive]);
            return response()->json(['success' => true, 'result' => [$basicdatavalue_create->id, ['با موفقیت ثبت شد.']]]);
        }
        else
        {
            BasicdataValue::find($editid)->update(['title' => $title, 'value' => $value, 'comment' => $comment, 'inactive' => $inactive]);
            return response()->json(['success' => true, 'result' => [$editid, ['با موفقیت ویرایش شد.']]]);
        }
        /*
        $basicdataattributesvalues_a_create = BasicdataAttributesValues::create(['basicdata_value_id' => $basicdatavalue_create->id, 'basicdata_attribute_id' => '1', 'value' => $a, 'created_by' => auth()->id(), ]);
        $basicdataattributesvalues_b_create = BasicdataAttributesValues::create(['basicdata_value_id' => $basicdatavalue_create->id, 'basicdata_attribute_id' => '2', 'value' => $b, 'created_by' => auth()->id(), ]);
        $basicdataattributesvalues_c_create = BasicdataAttributesValues::create(['basicdata_value_id' => $basicdatavalue_create->id, 'basicdata_attribute_id' => '3', 'value' => $c, 'created_by' => auth()->id(), ]);
        */
    }

    public function BasicdataValueCreateEdit_adsettings(Request $request)
    {
//        dd($request->all());
        $request->merge(array('title' => strip_tags($request->input('title'))));
        $validator = Validator::make
        (
            $request->all(),
            [
                'editid' => 'required',
                'parentid' => 'required_if:editid,0',
                'parent_id' => 'required',
                'title' => 'required',
                'inactive' => 'required',
                'url_address' => 'required',
            ]
        );
        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }
        $editid = $request->input('editid');
        $parentid = $request->input('parentid');
        $parent_id = $request->input('parent_id');
        $title = $request->input('title');
        $value = $request->input('value');
        $inactive = $request->input('inactive');
        $comment = $request->exists('comment') ? $request->input('comment') : null;
        $url_address = $request->input('url_address');
        if ('0' == $editid)
        {
            $basicdatavalue_create = BasicdataValue::create(['parent_id' => $parentid, 'title' => $title, 'value' => $value, 'comment' => $comment, 'inactive' => $inactive]);
            $basicdataattributesvalues_update = BasicdataAttributesValues::where('basicdata_value_id', $editid)->first();
            $basicdataattributesvalues_update->value = $url_address;
            $basicdataattributesvalues_update->save();
            return response()->json(['success' => true, 'result' => [$basicdatavalue_create->id, ['با موفقیت ثبت شد.']]]);
        }
        else
        {
            BasicdataValue::find($editid)->update(['title' => $title, 'value' => $value, 'comment' => $comment, 'inactive' => $inactive]);
            $basicdataattributesvalues_update = BasicdataAttributesValues::where('basicdata_value_id', $editid)->first();
            $basicdataattributesvalues_update->value = $url_address;
            $basicdataattributesvalues_update->save();
            return response()->json(['success' => true, 'result' => [$editid, ['با موفقیت ویرایش شد.']]]);
        }

        /*
        $basicdataattributesvalues_a_create = BasicdataAttributesValues::create(['basicdata_value_id' => $basicdatavalue_create->id, 'basicdata_attribute_id' => '1', 'value' => $a, 'created_by' => auth()->id(), ]);
        $basicdataattributesvalues_b_create = BasicdataAttributesValues::create(['basicdata_value_id' => $basicdatavalue_create->id, 'basicdata_attribute_id' => '2', 'value' => $b, 'created_by' => auth()->id(), ]);
        $basicdataattributesvalues_c_create = BasicdataAttributesValues::create(['basicdata_value_id' => $basicdatavalue_create->id, 'basicdata_attribute_id' => '3', 'value' => $c, 'created_by' => auth()->id(), ]);
        */
    }

    public function BasicData_delete(Request $request)
    {
        $validator = Validator::make
        (
            $request->all(),
            [
                'deleteid' => 'required',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        $deleteid = $request->input('deleteid');
        Basicdata::find($deleteid)->delete();
        return response()->json(['success' => true, 'result' => [$deleteid, ['با موفقیت حذف شد.']]]);
    }

    public function BasicData_valuedelete(Request $request)
    {
        $validator = Validator::make
        (
            $request->all(),
            [
                'deleteid' => 'required',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        $deleteid = $request->input('deleteid');
        BasicdataValue::find($deleteid)->delete();
        return response()->json(['success' => true, 'result' => [$deleteid, ['با موفقیت حذف شد.']]]);
    }

    public function BasicData_value_set_default_ad(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make
        (
            $request->all(),
            [
                'item_id' => 'required',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        $basic_data_values = BasicdataValue::where('parent_id', 7)->get();
        foreach ($basic_data_values as $basic_data_value)
        {
            $basic_data_value->value = null;
            $basic_data_value->save();
        }

        $basic_data_value = BasicdataValue::find($request->item_id);
        $basic_data_value->value = '1';
        $basic_data_value->save();

        return response()->json(['success' => true, 'message' => [$basic_data_value->title . ' ' . 'با موفقیت به عنوان تبلیغ پیش‌فرض انتخاب شد.']]);
    }

    public function user_measures_show()
    {
        $uid = (session('uid') != '') ? session('uid') : 0;
        $sesid = (session('sesid') != '') ? session('sesid') : 0;
        $mid = (isset($_GET['id'])) ? $_GET['id'] : 0;
        $MC = new \App\HamafzaViewClasses\Measure();
        $c = $MC->user_measures_show($uid, $mid, $sesid);
        return view('modals.user_measures_show', array('row' => $c));
    }

    public function measure($pid, $sid, $select, $title, $type)
    {
        $res = $this->getParams(['pid', 'sid', 'select', 'title', 'type']);

        return view('modals.measure', array('pid' => $pid, 'sid' => $sid, 'select' => $select, 'title' => $title, 'type' => $type));
    }

    public function Sharepost(Request $request)
    {
        $uid = Auth::id();
        $sesid = 0;
        $ShareGroup = $request->input('ShareGroup');
        $users = $request->input('manager');
        $emails = $request->input('emails');
        $inmypage = $request->input('inmypage');
        $descr = $request->input('descr');
        $post_id = $request->input('post_id');
        $content = $request->input('content');
        $ShareGroup = json_encode($ShareGroup);
        $content = json_encode($content);
        $emails = json_encode($emails);
        $users = json_encode($users);
        $ShareGroup = json_encode($ShareGroup);
        $SP = new \App\HamafzaServiceClasses\PostsClass();
        $menu = $SP->Sharepost($uid, 0, $ShareGroup, $users, $emails, $inmypage, $descr, $post_id, $content);
//        return $menu;
//
//        $mes = AJAX::Sharepost($uid, $sesid, $ShareGroup, $users, $emails, $inmypage, $descr, $post_id, '');
        return Redirect::back()->with('message', 'بازنشر انجام شد')->with('mestype', 'success');
    }


    public function addresses_form(Request $request)
    {

    }

    public function addresses(Request $request)
    {

    }

    public function addresses_add_form(Request $request)
    {
        $bazaar_requirements = variable_generator('user', 'bazaar_requirements');
        $provinces = \App\Models\Hamahang\ProvinceCity\Province::all();
        $data = Address::find($request->input('edit_id', 0));
        if (null !== $data)
        {
            $city_id = $data->city_id;
        }
        else
        {
            $city_id = 0;
        }
        $r = json_encode
        ([
            'header' => view('hamahang.addresses.add.header')->with(['city_id' => $city_id])->render(),
            'content' => view('hamahang.addresses.add.content', $bazaar_requirements)->with(['data' => $data, 'provinces' => $provinces])->render(),
            'footer' => view('hamahang.addresses.add.footer')->render()
        ]);
        return ($r);
    }

    public function addresses_add(Request $request)
    {
        $validator = Validator::make
        (
            $request->all(),
            [
                'receiver_name' => 'required',
                'receiver_family' => 'required',
                'emergency_phone' => 'required|mobile_phone',
                'land_phone_precode' => 'required|numeric',
                'land_phone_number' => 'required|numeric',
                'province_id' => 'required',
                'city_id' => 'required',
                'address' => 'required',
                'postal_code' => 'required|numeric',
                'edit_id' => 'required',
            ],
            [],
            [
                'receiver_name' => 'نام دریافت کننده',
                'receiver_family' => 'نام‌خانوادگی تحویل گیرنده',
                'emergency_phone' => 'شماره تماس ضروری (تلفن همراه)',
                'land_phone_precode' => 'شماره تلفن ثابت تحویل گیرنده',
                'land_phone_number' => 'کد شهر تلفن ثابت تحویل گیرنده',
                'province_id' => 'استان تحویل گیرنده',
                'city_id' => 'شهر تحویل گیرنده',
                'address' => 'آدرس پستی',
                'postal_code' => 'کد پستی',
                'default_address' => 'آدرس پیشفرض',
                'edit_id' => 'شناسه',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        $bazaar_requirements = variable_generator('user', 'bazaar_requirements');
        $user_id = auth()->id();
        $receiver_name = $request->input('receiver_name');
        $receiver_family = $request->input('receiver_family');
        $city_id = $request->input('city_id');
        $city = City::find($city_id);
        $province_id = $city->province_id;
        $address = $request->input('address');
        $postal_code = $request->input('postal_code');
        $default_address = $request->exists('default_address');
        $emergency_phone = $request->input('emergency_phone');
        $land_phone_precode = $request->input('land_phone_precode');
        $land_phone_number = $request->input('land_phone_number');
        $edit_id = $request->input('edit_id');
        $data_array =
            [
                'user_id' => $user_id,
                'receiver_name' => $receiver_name,
                'receiver_family' => $receiver_family,
                'province_id' => $province_id,
                'city_id' => $city_id,
                'address' => $address,
                'postal_code' => $postal_code,
                'emergency_phone' => $emergency_phone,
                'land_phone_precode' => $land_phone_precode,
                'land_phone_number' => $land_phone_number,
            ];
        if ('0' == $edit_id)
        {
            $address = new Address();
            $address->fill($data_array);
            $address->save();
        }
        else
        {
            unset($data_array['user_id']);
            $address = Address::find($edit_id);
            $address->update($data_array);
        }
        if ($default_address)
        {
            $user = User::find($user_id);
            $user->default_address_id = $address->id;
            $user->save();
        }
        $default_address = Address::where('user_id', auth()->id())->where('id', auth()->user()->default_address_id)->get()->toArray();
        $other_addresses = Address::where('user_id', auth()->id())->where('id', '<>', auth()->user()->default_address_id)->get()->toArray();
        $addresses = array_merge($default_address, $other_addresses);
        $postmethods = BasicdataValue::where('parent_id', '3')->where('inactive', '0')->get();
        $html = view('hamahang.Bazaar.helper.shipping-content', $bazaar_requirements)->with(['addresses' => $addresses, 'postmethods' => $postmethods])->render();
        return response()->json(['success' => true, 'result' => [$html]]);
    }

    public function addresses_delete(Request $request)
    {
        $bazaar_requirements = variable_generator('user', 'bazaar_requirements');
        $delete_id = $request->input('delete_id');
        $address = Address::where('user_id', auth()->id())->where('id', $delete_id);
        $address->delete();
        $default_address = Address::where('user_id', auth()->id())->where('id', auth()->user()->default_address_id)->get()->toArray();
        $other_addresses = Address::where('user_id', auth()->id())->where('id', '<>', auth()->user()->default_address_id)->get()->toArray();
        $addresses = array_merge($default_address, $other_addresses);
        $postmethods = BasicdataValue::where('parent_id', '3')->where('inactive', '0')->get();
        $html = view('hamahang.Bazaar.helper.shipping-content', $bazaar_requirements)->with(['addresses' => $addresses, 'postmethods' => $postmethods])->render();
        return response()->json(['success' => true, 'result' => [$html]]);
    }

    /**
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     * begin discountcoupon functions
     *
     */

    public function discountcoupon_addedit_form(Request $request)
    {
        $data = DiscountCoupon::find($request->input('edit_id', 0));
        $r = json_encode
        ([
            'header' => view('hamahang.Bazaar.helper.discountcoupon-addedit-header')->with(['add' => $data ? false : true])->render(),
            'content' => view('hamahang.Bazaar.helper.discountcoupon-addedit-content')->with(['data' => $data])->render(),
            'footer' => view('hamahang.Bazaar.helper.discountcoupon-addedit-footer')->with(['add' => $data ? false : true])->render()
        ]);
        return ($r);
    }

    public function discountcoupon_addedit(Request $request)
    {
        $value_validation = null;
        if ($request->exists('type'))
        {
            $value_validation = $request->input('type') ? '|min:1' : '|between:1,100';
        }
        $validator = Validator::make
        (
            $request->all(),
            [
                'coupon_old' => 'required|numeric',
                'coupon' =>
                    [
                        'required',
                        'integer',
                        'min:1',
                        Rule::unique('hamahang_discount_coupons')->ignore($request->input('coupon_old'), 'coupon'),
                    ],
                'start_date' => 'required|jalali_date',
                'type' => 'required|integer|between:0,1',
                'value' => 'required|integer' . $value_validation,
                'inactive' => 'required|integer|between:0,1',
                'expire_date' => 'required|jalali_date',
                'disposable' => 'required|integer|between:0,1',
                'usage_quota' => 'required|integer|min:0',
                'inactive' => 'required|integer|between:0,1',
                'edit_id' => 'required|integer|min:0',
            ],
            [],
            [
                'coupon' => trans('bazaar.discountcoupon.coupon'),
                'type' => trans('bazaar.discountcoupon.type'),
                'value' => trans('bazaar.discountcoupon.value'),
                'start_date' => trans('bazaar.discountcoupon.start_date'),
                'expire_date' => trans('bazaar.discountcoupon.expire_date'),
                'disposable' => trans('bazaar.discountcoupon.disposable'),
                'usage_quota' => trans('bazaar.discountcoupon.usage_quota'),
                'inactive' => trans('bazaar.discountcoupon.status'),
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        $coupon = $request->input('coupon');
        $type = $request->input('type');
        $value = $request->input('value');
        $start_date = $request->input('start_date');
        $expire_date = $request->input('expire_date');
        $disposable = $request->input('disposable');
        $usage_quota = $request->input('usage_quota');
        $inactive = $request->input('inactive');
        $created_by = auth()->id();
        $edit_id = $request->input('edit_id');
        $data_array =
            [
                'coupon' => $coupon,
                'type' => $type,
                'value' => $value,
                'start_date' => $start_date,
                'expire_date' => $expire_date,
                'disposable' => 0 == $disposable && 1 == $usage_quota ? 1 : $disposable,
                'usage_quota' => $usage_quota,
                'inactive' => $inactive,
                'created_by' => $created_by,
            ];
        if ('0' == $edit_id)
        {
            $coupon = new DiscountCoupon();
            $coupon->fill($data_array);
            $success = $coupon->save();
            $result = [];
        }
        else
        {
            unset($data_array['created_by']);
            $coupon = DiscountCoupon::find($edit_id);
            $can_edit = 0 == $coupon->used_count;
            if ($can_edit)
            {
                $coupon->update($data_array);
            }
            $success = $can_edit;
            $result = [trans('bazaar.discountcoupon.operations_used_msg')];
        }
        return response()->json(['success' => $success, 'result' => $result]);
    }

    public function discountcoupon_delete(Request $request)
    {
        $delete_id = $request->input('delete_id');
        $coupon = DiscountCoupon::find($delete_id);
        $can_delete = 0 == $coupon->used_count;
        if ($can_delete)
        {
            $coupon->delete();
        }
        $success = $can_delete;
        return response()->json(['success' => $success, 'result' => []]);
    }

    public function discountcoupon_request_form(Request $request)
    {
        $document = HFM_GenerateUploadForm([['couponrequest_document', ['gif', 'bmp', 'jpg', 'jpeg', 'png',], 'Single',],]);
        if (auth()->check())
        {
            $content = view('hamahang.Bazaar.helper.discountcoupon-request-content')->with('document', $document)->render();
        }
        else
        {
            $content = '<div class="text-center"><h3 style="margin:50px; color:red; font-weight: bolder;" >' . "برای استفاده از این امکان باید وارد شوید." . '</h3></div>';
        }
        $r = json_encode
        ([
            'header' => view('hamahang.Bazaar.helper.discountcoupon-request-header')->render(),
            'content' => $content,
            'footer' => view('hamahang.Bazaar.helper.discountcoupon-request-footer')->render()
        ]);
        return ($r);
    }

    public function discountcoupon_request(Request $request)
    {
        $validator = Validator::make
        (
            $request->all(),
            [
                'applicant' => 'required|numeric',
                'count' => 'required|numeric|min:1',
            ],
            [],
            [
                'count' => trans('bazaar.discountcoupon.count'),
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        $data_array1 =
            [
                'user_id' => $user_id = auth()->id(),
                'applicant' => $applicant = $request->input('applicant'),
                'count' => $count = $request->input('count'),
                'created_by' => $created_by = '0',
            ];
        $couponrequest = new DiscountCouponRequest();
        $couponrequest->fill($data_array1);
        $couponrequest_result = $couponrequest->save();

        $save_single_file = false;
        $coupon_result = false;

        if ($couponrequest_result)
        {
            $save_single_file = HFM_SaveSingleFile('couponrequest_document', 'app\Models\Hamahang\DiscountCouponRequest', 'document_file_id', $couponrequest->id);
            $save_single_file = true;
            if ($save_single_file)
            {
                $coupon = time() . rand(100, 999);
                $date_time = new \DateTime(date('Y-m-d'));
                $date_interval = (array)$date_time->add(new \DateInterval('P1Y'));
                $date = explode(' ', $date_interval['date']);
                $data_array2 =
                    [
                        'coupon' => $coupon,
                        'type' => 0,
                        'value' => ['20', '40', '50', '15', '50', '70', '50', '70', '30',][$applicant - 1],
                        'start_date' => HDate_GtoJ(date('Y-m-d'), 'Y/m/d', false),
                        'expire_date' => HDate_GtoJ($date[0], 'Y/m/d', false),
                        'disposable' => 1,
                        'usage_quota' => $count,
                        'used_count' => 0,
                        'subject_id' => $subject_id = $request->input('subject_id'),
                        'subject_usage_quota' => $count,
                        'subject_used_count' => 0,
                        'coupon_request_id' => $couponrequest->id,
                        'inactive' => 0,
                        'created_by' => 0,
                    ];
                $discountcoupon = new DiscountCoupon();
                $discountcoupon->fill($data_array2);
                $coupon_result = $discountcoupon->save();
            }
            else
            {

            }
        }
        else
        {

        }

        return response()->json(['success' => $couponrequest_result && $save_single_file && $coupon_result, 'result' => [["کد تخفیف شما: $coupon"]]]);
    }

    /**
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     * begin invoces functions
     *
     */

    public function invoice_details_form(Request $request)
    {
        $id = $request->input('id');
        $invoice = Invoice::find($id);
        $r = json_encode
        ([
            'header' => view('hamahang.Bazaar.helper.invoice.details-header')->render(),
            'content' => view('hamahang.Bazaar.helper.invoice.details-content')->with(['invoice' => $invoice])->render(),
            'footer' => view('hamahang.Bazaar.helper.invoice.details-footer')->render()
        ]);
        return ($r);
    }

    public function invoice_status_form(Request $request)
    {
        $id = $request->input('id');
        $invoice = Invoice::find($id);
        $statuses = \App\Models\Hamahang\Basicdata::find(config('bazaar.invoice_basicdata_id_status'))->items()->where('inactive', '0')->whereNotIn('value', [])->get();
        $r = json_encode
        ([
            'header' => view('hamahang.Bazaar.helper.invoice.status-header')->render(),
            'content' => view('hamahang.Bazaar.helper.invoice.status-content')->with(['invoice' => $invoice, 'statuses' => $statuses])->render(),
            'footer' => view('hamahang.Bazaar.helper.invoice.status-footer')->with(['invoice' => $invoice, 'statuses' => $statuses])->render()
        ]);
        return ($r);
    }

    public function invoice_subjects_form(Request $request)
    {
        $id = $request->input('id');
        $my = $request->exists('my');
        /*
        $invoice = Invoice::find($id);
        $invoice_item = InvoiceItem::where('invoice_id', $id)->select('subject_id')->get();
        $subject_ids_array = array_map(function($input) { return (string) $input['subject_id']; }, $invoice_item->toArray());
        $subjects = Subject::whereIn('id', $subject_ids_array)->get()->toArray();
        dd($subjects);
        */
        $items = InvoiceItem::where('invoice_id', $id)->get();
        $r = json_encode
        ([
            'header' => view('hamahang.Bazaar.helper.invoice.subjects-header')->render(),
            'content' => view('hamahang.Bazaar.helper.invoice.subjects-content')->with(['items' => $items, 'my' => $my])->render(),
            'footer' => view('hamahang.Bazaar.helper.invoice.subjects-footer')->render()
        ]);
        return ($r);
    }

    public function invoice_coupon_form(Request $request)
    {
        $id = $request->input('id');
        $coupon = DiscountCoupon::find($id);
        $r = json_encode
        ([
            'header' => view('hamahang.Bazaar.helper.invoice.coupon-header')->render(),
            'content' => view('hamahang.Bazaar.helper.invoice.coupon-content')->with('coupon', $coupon)->render(),
            'footer' => view('hamahang.Bazaar.helper.invoice.coupon-footer')->render()
        ]);
        return ($r);
    }

    public function invoice_paymentdata_form(Request $request)
    {
        $invoice_id = $request->input('id');
        $items = PaymentGatewayRawLogs::where('invoice_id', $invoice_id)->get();
        $r = json_encode
        ([
            'header' => view('hamahang.Bazaar.helper.invoice.paymentdata-header')->render(),
            'content' => view('hamahang.Bazaar.helper.invoice.paymentdata-content')->with('items', $items)->render(),
            'footer' => view('hamahang.Bazaar.helper.invoice.paymentdata-footer')->render()
        ]);
        return ($r);
    }

    public function invoice_paymentdatadetails_form(Request $request)
    {
        $id = $request->input('id');
        $item = PaymentGatewayRawLogs::find($id);
        $r = json_encode
        ([
            'header' => view('hamahang.Bazaar.helper.invoice.paymentdatadetails-header')->render(),
            'content' => view('hamahang.Bazaar.helper.invoice.paymentdatadetails-content')->with('item', $item)->render(),
            'footer' => view('hamahang.Bazaar.helper.invoice.paymentdatadetails-footer')->render()
        ]);
        return ($r);
    }

    /**
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     * begin keyword functions
     *
     */

    public function keyword_addedit_form(Request $request)
    {
        $thesauruses = Subject::where('kind', config('keyword.thesaurus_kind_id'))->get();
        $keyword_id = $request->input('sid', false);
        if ($keyword_id)
        {
            $is_edit = true;
            $keyword = Keyword::find($keyword_id);
            $header_with = ['is_edit' => $is_edit, 'keyword' => $keyword,];
            $content_with = ['is_edit' => $is_edit, 'thesauruses' => $thesauruses, 'keyword' => $keyword, 'recursive_thesauruses_selected' => [],];
            $footer_with = ['is_edit' => $is_edit, 'keyword' => $keyword,];
        }
        else
        {
            $is_edit = false;
            $recursive_thesauruses_selected = explode(',', $request->input('thesauruses_selected', null));
            $header_with = ['is_edit' => $is_edit,];
            $content_with = ['is_edit' => $is_edit, 'thesauruses' => $thesauruses, 'recursive_thesauruses_selected' => $recursive_thesauruses_selected];
            $footer_with = ['is_edit' => $is_edit,];
        }

        $header = view('hamahang.Keywords.add_edit.header')->with($header_with)->render();
        $content = view('hamahang.Keywords.add_edit.content')->with($content_with)->render();
        $footer = view('hamahang.Keywords.add_edit.footer')->with($footer_with)->render();
        $r = json_encode(['header' => $header, 'content' => $content, 'footer' => $footer,]);
        return $r;
    }

    public function keyword_addedit(Request $request)
    {
        $request->merge(['title_old' => trim($request->input('title_old'))]);
        $request->merge(['title' => trim($request->input('title'))]);

        $relations = $request->input('relations');
        if ($relations)
        {
            foreach ($relations as $relation_key => $relation)
            {
                if (isset($relation['values']))
                {
                    $relations[$relation_key]['values'] = array_unique($relation['values']);
                }
            }
            $request->merge(['relations' => $relations]);
        }

        $validator = Validator::make
        (
            $request->all(),
            [
                'title_old' => 'string',
                'title' =>
                    [
                        'required',
                        'min:1',
                        'max:255',
                        Rule::unique('keywords')->ignore($request->input('title_old'), 'title')->whereNull('deleted_at'),
                    ],
                'short_code' => 'string',
                'description' => 'string',
                'subject_ids' => 'array',
                'relations' => 'array',
                'id' => 'required|integer|min:0',
            ], [],
            [
                'title' => 'عنوان',
                'short_code' => 'کد',
                'description' => 'توضیح (یادداشت دامنه)',
                'subject_ids' => 'اصطلاح‌نامه',
                'relation_types' => 'وابستگی ها',
                'id' => 'شناسه',
            ]
        );
        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        $success = false;
        $result = [];

        $title = $request->input('title');
        $short_code = $request->input('short_code');
        $description = $request->input('description');
        $is_morajah = $request->exists('is_morajah');
        $is_approved = $request->input('is_approved');
        $subject_ids = $request->input('subject_ids', [config('keyword.thesaurus_default_id')]);
        $relations = $request->input('relations');
        $id = $request->input('id');
        $keyword_data_array =
            [
                'title' => $title,
                'short_code' => $short_code,
                'img_file_id' => '0',
                'description' => $description,
                'is_morajah' => $is_morajah,
                'is_approved' => $is_approved,
                'created_by' => auth()->id(),
            ];
        $keyword_add = Keyword::add($keyword_data_array, $id);
        $keyword_result = $keyword_add['result'];
        if ($keyword_result)
        {
            $keyword = $keyword_add['object'];
            ThesaurusKeyword::where('keyword_id', $keyword->id)->delete();
            KeywordRelation::where('keyword_1_id', $keyword->id)->delete();
            KeywordRelation::where('keyword_2_id', $keyword->id)->delete();
            foreach ($subject_ids as $subject_id)
            {
                $thesaurus_data_array =
                    [
                        'subject_id' => $subject_id,
                        'keyword_id' => $keyword->id,
                        'created_by' => auth()->id(),
                    ];
                $thesaurus = new ThesaurusKeyword();
                $thesaurus->fill($thesaurus_data_array);
                $thesaurus->save();
            }
            if ($relations)
            {
                $exist_in = 'exist_in';
                foreach ($relations as $relation)
                {
                    $type = $relation['type'];
                    if (isset($relation['values']))
                    {
                        $values = $relation['values'];
                        foreach ($values as $value)
                        {
                            if ($value)
                            {
                                $exists = false !== strpos($value, $exist_in);
                                if ($exists)
                                {
                                    $keyword_2_id = substr($value, strlen($exist_in));
                                }
                                else
                                {
                                    $new_keyword_data_array =
                                        [
                                            'title' => $value,
                                            'created_by' => auth()->id(),
                                        ];
                                    $new_keyword_add = Keyword::add($new_keyword_data_array);
                                    $keyword_2_id = $new_keyword_add['object']->id;
                                }
                                $thesaurus_data_array =
                                    [
                                        'subject_id' => $subject_id,
                                        'keyword_id' => $keyword_2_id,
                                        'created_by' => auth()->id(),
                                    ];
                                $thesaurus = new ThesaurusKeyword();
                                $thesaurus->fill($thesaurus_data_array);
                                $thesaurus->save();
                                foreach ($subject_ids as $subject_id)
                                {
                                    if (in_array($type, [1, 110, 3, 310, 5, 510]))
                                    {
                                        $has_conflict = (bool)KeywordRelation::where('keyword_1_id', $keyword_2_id)->where('keyword_2_id', $keyword->id)->where('relation_type', $type)->get()->count();
                                    }
                                    else
                                    {
                                        $has_conflict = false;
                                    }
                                    if (!$has_conflict)
                                    {
                                        $count = KeywordRelation::where('keyword_1_id', $keyword->id)->where('keyword_2_id', $keyword_2_id)->where('relation_type', $type)->count();
                                        if (0 == $count)
                                        {
                                            $relation_data_array =
                                                [
                                                    'keyword_1_id' => $keyword->id,
                                                    'keyword_2_id' => $keyword_2_id,
                                                    'relation_type' => $type,
                                                    'created_by' => auth()->id(),
                                                ];
                                            $relation = new KeywordRelation();
                                            $relation->fill($relation_data_array);
                                            $relation->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $success = true;
        }
        $result = [$subject_ids];
        return response()->json(['success' => $success, 'result' => $result]);
    }

    public function keyword_delete(Request $request)
    {
        $id = $request->input('sid');
        $success = Keyword::find($id)->delete();
        return response()->json(['success' => $success, 'result' => []]);
    }

    /**
     *
     * end keyword functions
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     */

    //----------------------------------------------------------------------
    //*********************** Basicdata Add/Edit Forms *********************
    //----------------------------------------------------------------------
    public function basicdata_ad_settings_view(Request $request)
    {
//        dd($request->parent_id);
        $basic_data_value = BasicdataValue::find($request->data);
        $HFMAddAdImage = HFM_GenerateUploadForm(
            [
                ['ad_image', ['jpg', 'png', 'jpeg', 'gif', 'bmp'], "Single"],
            ]);

        return json_encode([
            'header' => trans('basic_data.edit_ad'),
            'content' => view('modals.basic_data.ads_settings.jsp_ad_form_content')
                ->with('HFMAddAdImage', $HFMAddAdImage)
                ->with('basic_data_value', $basic_data_value)
                ->render(),
            'footer' => view('modals.basic_data.ads_settings.jsp_ad_form_footer')
                ->with('basic_data_value', $basic_data_value)
                ->with('parent_id', $request->parent_id)
                ->render()
        ]);
    }

    public function basicdata_slider_settings_view(Request $request)
    {
        $basic_data_value = BasicdataValue::find($request->data);
        $HFMAddSliderImage = HFM_GenerateUploadForm(
            [
                ['slider_image', ['jpg', 'png', 'jpeg', 'gif', 'bmp'], "Single"],
            ]);

        return json_encode([
            'header' => trans('basic_data.edit_slider'),
            'content' => view('modals.basic_data.sliders_settings.jsp_slider_form_content')
                ->with('HFMAddSliderImage', $HFMAddSliderImage)
                ->with('basic_data_value', $basic_data_value)
                ->render(),
            'footer' => view('modals.basic_data.sliders_settings.jsp_sliders_form_footer')
                ->with('basic_data_value', $basic_data_value)
                ->with('parent_id', $request->parent_id)
                ->render()
        ]);
    }

    public function basicdata_social_settings_view(Request $request)
    {
        $basicdata_value_tabs = BasicdataValue::where('parent_id', 10)->get();
        $basicdata_value = BasicdataValue::find($request->data);
        $HFMEditItemImage = HFM_GenerateUploadForm(
            [
                ['edit_item_image', ['jpg', 'png', 'jpeg', 'gif', 'bmp'], "Single"],
            ]);
        $link = '';
        if ($item = $basicdata_value->attrs()->withPivot(['value'])->where('basicdata_attribute_id', 10)->first())
        {
            if (isset($item->pivot) && isset($item->pivot->value))
            {
                $link = $item->pivot->value;
            }
        }
        $image_encode_id = enCode(-1);
        if ($item = $basicdata_value->attrs()->withPivot(['value'])->where('basicdata_attribute_id', 11)->first())
        {
            if (isset($item->pivot) && isset($item->pivot->value))
            {
                $image_encode_id = enCode($item->pivot->value);
            }
        }
        return json_encode([
            'header' => trans('basic_data.edit_item'),
            'content' => view('modals.basic_data.social_settings.jsp_social_content')
                ->with('HFMEditItemImage', $HFMEditItemImage)
                ->with('basicdata_value_tabs', $basicdata_value_tabs)
                ->with('basicdata_value', $basicdata_value)
                ->with('image_encode_id', $image_encode_id)
                ->with('link', $link)
                ->with('add_true', false)
                ->render(),
            'footer' => view('modals.basic_data.social_settings.jsp_social_footer')
                ->with('parent_id', $request->parent_id)
                ->with('basicdata_value', $basicdata_value)
                ->with('add_true', false)
                ->render()
        ]);
    }

    public function basicdata_news_settings_view(Request $request)
    {
        $basic_data_value = BasicdataValue::find($request->data);
        if ($basic_data_value)
        {
            $values = unserialize($basic_data_value->value);
        }
        else
        {
            $values = [];
        }
        $keywords = [];
        foreach ($values as $key => $value)
        {
            $val = keyword::find($value);
            if ($val)
            {
                $keywords[$key] = ['id' => $val->id, 'text' => $val->title];
            }
        }
        return json_encode([
            'header' => trans('basic_data.edit_tab'),
            'content' => view('modals.basic_data.news_settings.jsp_news_form_content')
                ->with('basic_data_value', $basic_data_value)
                ->render(),
            'footer' => view('modals.basic_data.news_settings.jsp_news_form_footer')
                ->with('basic_data_value', $basic_data_value)
                ->with('keywords', $keywords)
                ->with('parent_id', $request->parent_id)
                ->render()
        ]);
    }

    public function basicdata_ad_social_view(Request $request)
    {
        $basicdata_value_tabs = BasicdataValue::where('parent_id', 10)->select('id', 'title')->get();
        $HFMAddItemImage = HFM_GenerateUploadForm(
            [
                ['add_item_image', ['jpg', 'png', 'jpeg', 'gif', 'bmp'], "Single"],
            ]);

        return json_encode([
            'header' => trans('basic_data.add_new_item'),
            'content' => view('modals.basic_data.social_settings.jsp_social_content')
                ->with('HFMAddItemImage', $HFMAddItemImage)
                ->with('basicdata_value_tabs', $basicdata_value_tabs)
                ->with('basicdata_id', $request->basicdata_id)
                ->with('basicdata_value', '')
                ->with('add_true', true)
                ->render(),
            'footer' => view('modals.basic_data.social_settings.jsp_social_footer')
                ->with('basicdata_value_tabs', $basicdata_value_tabs)
                ->with('parent_id', $request->basicdata_id)
                ->with('add_true', true)
                ->render()
        ]);
    }

    public function setting_user_view(Request $request)
    {
        return json_encode([
            'header' => trans('basic_data.add_user'),
            'content' => view('modals.basic_data.user_settings.jsp_user_setting_content')
                ->with('id_select', $request->id_select)
                ->render(),
            'footer' => view('modals.basic_data.user_settings.jsp_user_setting_footer')
                ->render()
        ]);
    }

    public function multi_task(Request $request)
    {
        return json_encode([
            'header' => trans('calendar.modal_fullcalendar_menu_defined_task'),
            'content' => view('modals.basic_data.calendar_settings.jsp_multi_task_setting_content')
                ->with('id_select', $request->id_select)
                ->render(),
            'footer' => view('modals.basic_data.calendar_settings.jsp_multi_task_setting_footer')
                ->render()
        ]);
    }

    public function task_time(Request $request)
    {
        return json_encode([
            'header' => trans('calendar.task_timming'),
            'content' => view('modals.basic_data.calendar_settings.task_time_content')
                ->render(),
            'footer' => view('modals.basic_data.calendar_settings.task_time_footer')
                ->render()
        ]);
    }

    public function basicdata_ad_research_view(Request $request)
    {
//        dd($request->parent_id);
        $basic_data_value = BasicdataValue::find($request->data);

        $HFMAddSliderImage = HFM_GenerateUploadForm(
            [
                ['research_image', ['jpg', 'png', 'jpeg', 'gif', 'bmp'], "Single"],
            ]);

        return json_encode([
            'header' => trans('basic_data.edit_ad'),
            'content' => view('modals.basic_data.items-research.jsp_research_form_content')
                ->with('HFMAddSliderImage', $HFMAddSliderImage)
                ->with('basic_data_value', $basic_data_value)
                ->render(),
            'footer' => view('modals.basic_data.items-research.jsp_research_form_footer')
                ->with('basic_data_value', $basic_data_value)
                ->with('parent_id', $request->parent_id)
                ->render()
        ]);
    }

    public function basicdata_items_research_view(Request $request)
    {
        $basic_data_value = BasicdataValue::find($request->data);
        $HFMAddSliderImage = HFM_GenerateUploadForm(
            [
                ['research_image', ['jpg', 'png', 'jpeg', 'gif', 'bmp'], "Single"],
            ]);

        return json_encode([
            'header' => trans('basic_data.edit_slider'),
            'content' => view('modals.basic_data.items-research.jsp_research_form_content')
                ->with('HFMAddSliderImage', $HFMAddSliderImage)
                ->with('basic_data_value', $basic_data_value)
                ->render(),
            'footer' => view('modals.basic_data.items-research.jsp_research_form_footer')
                ->with('basic_data_value', $basic_data_value)
                ->with('parent_id', $request->parent_id)
                ->render()
        ]);
    }

    public function add_user_view(Request $request)
    {
        return json_encode([
            'header' => trans('basic_data.add_user'),
            'content' => view('modals.basic_data.user_add.jsp_user_add_content')
                ->render(),
            'footer' => view('modals.basic_data.user_add.jsp_user_add_footer')
                ->render()
        ]);
    }

    public function changeScore(Request $request)
    {
        $job_id = $request->get('job_id');
        $score = $request->get('score');
        $value = $request->get('value');
        $options =[];
        switch ($score) {
            case 'effect_effect':
            $options = [
                ['title' => 'تحویل', 'desc' => 'انجام و ارائه خدمت و یا کالا طبق استانداردها و دستورالعمل های مشخص و صریح و راهنمای خدمات'],
                ['title' => 'عملیاتی', 'desc' => 'شاغل نحوه انجام فعالیت ها را در راستای دست یابی به اهداف عملیاتی و یا استاندادرهای خدمات تعیین میکند'],
                ['title' => 'تاکتیکی', 'desc' => 'تعیین ویژگی های خدمات، و فرایندهای جدید و ضوابط و استاندارهای ان بر مبنای استراتژی سازمان و یا تدوین برنامه های عملیاتی کوتاه مدت غالبا در یک حوزه وظیفه ای'],
                ['title' => 'استراتژیک', 'desc' => 'تدوین و یا اجرای استراتژی های شکت با رویکردی بلندمدت (معمولا سه تا 5 سال) بر مینای چشم اندازهای سازمان غالبا در سطح سازمان'],
                ['title' => 'آرمانی', 'desc' => 'رهبری یک سازمان برای توسعه، اجرا و تحقق ماموریت ها، چشم اندازها و ارزش های آن در سطح بنگاه']
            ];
            break;
            case 'effect_association':
                $options = [
                    ['title' => 'محدود و بسیار کم', 'desc' => 'شاغل مشارکت ناچیز در تعیین روش های انجام کار و یا تدوین اهداف و نتایج دارد به عبارتی نقش این شغل در مشارکت برای دست یابی به نتایج و اهداف به سختی قابل تعریف و تشخصیص است'],
                    ['title' => 'گاها و برخی مشارکت ها', 'desc' => 'سهم وی در مشارکت و تاثیرگذاری قابل تشخیص و اندازه گیری  است با این حال  معمولا اثر غیر مستقیم بر تحقق نتاجی خواهد داشت'],
                    ['title' => 'مستقیم', 'desc' => 'تاثیر مستقیم و بسیار روشنی بر مجموعه ای از فعالیت ها دارد که کیفیت دستیابی به نتایج را مشخص می نماید. شاغل مشارکت فعال در تعیین روش های انجام کار، و تعیین اهداف دارد'],
                    ['title' => 'معنادار و شاخص', 'desc' => 'نقش فرد در تعیین روش های انجام کار و تدوین اهداف برجسته و اصلی است. بسیاری از روش های انجام کار و اهداف با مشارکت اصلی فرد تعیین می شود'],
                    ['title' => 'عمده و گسترده', 'desc' => 'اصلی ترین فرد و با اختیارات کامل در تعیین اهداف و نتایج کلیدی است']
                ];
                break;
            case 'effect_size':
                $options = [
                    ['title' => 'سطح 1', 'desc' => ''],
                    ['title' => 'سطح 2', 'desc' => ''],
                    ['title' => 'سطح 3', 'desc' => ''],
                    ['title' => 'سطح 4', 'desc' => ''],
                    ['title' => 'سطح 5', 'desc' => '']
                ];
                break;

            case 'connections_type':
                $options = [
                    ['title' => 'انتقال و درک اطلاعات', 'desc' => 'کسب، فراهم آوردن و انتقال اطلاعات از طریق گزارش، پیشنهاد، فرم و یا به صورت رو در رو - درک صحیح اطلاعات توسط طرف مقابل'],
                    ['title' => 'مبادله اطلاعات و توافق', 'desc' => 'توضیح دادن اقدامات، سیاست ها و قایع به دیگران و دستیابی به هماهنگی -  درک جامع و مناسب اقدامات و سیاست ها و وقایع توسط طرف مقابل'],
                    ['title' => 'تاثیرگذاری و اقناع', 'desc' => 'تاثیرگذاری بر تغییرات و متقاعد سازی بدون برخورداری از اختیار مستقیم- فهم و پذیرش مدل ها و مفاهیم/ اقدامات و رویکردها توسط طرف مقابل'],
                    ['title' => 'مذاکره', 'desc' => 'ایجاد توافق از طریق مدیریت ارتباطات در خلال بحث ها، مذاکرات و جلسات مصالحه. مسائل و موضوعات بیشتر در سطح عملیاتی و تاکتیکی و برخی موارد محدود استراتژیک است. فهم و پذیرش کامل پیشنهادها و نظرات از طریق بحث و مصالحه توسط طرف/ طرف های مقابل'],
                    ['title' => 'مذاکرات استراتژیک و بلندمدت', 'desc' => 'مدیریت ارتباطات و مباحث در خصوص موضوعات و مسائل بسایر مهم در سطوح استراتژیک و بلندمدت در سطح کل سازمان- پذیرش  توافقات استراتژیک توسط طرف/ طرف های مقابل']
                ];
                break;
            case 'connections_frame':
                $options = [
                    ['title' => 'سطح 1', 'desc' => 'با افراد و واحدها داخلی سازمان (همکاران)  با اهداف و منافع مشترک که بیشتر نیازمند هماهنگی و پاسخگویی است'],
                    ['title' => 'سطح 2', 'desc' => 'با افراد و واحدهای داخل و خارج سازمان شامل همکاران، مشتریان، تامین کنندگان، با اهداف مشترک که بیشتر نیازمند پاسخگویی و هماهنگی است'],
                    ['title' => 'سطح 3', 'desc' => 'با افراد و واحدهای داخل سازمان با اهداف و منافع بعضا ناهماهنگ که نیازمند مذاکره، حل تعارض و دست یابی به راهکار اجماع شده می باشد'],
                    ['title' => 'سطح 4', 'desc' => 'بین افراد و واحدهای داخل و خارج سازمان با اهداف و منافع متضاد و متفاوت که نیازمند مذاکره، حل تعارض ها و دست یابی به راهکار اجماع شده می باشد']
                ];
                break;

            case 'problem_solving_innovation':
                $options = [
                    ['title' => 'توجه و عمل بر اساس روش ها و سیاست های موجود/ درک و دنبال کردن', 'desc' => 'بر اساس یک منبع، اصل و یا استاندارد و یا دستور، انتظار هیچگونه تغییری نیست'],
                    ['title' => 'توجه و عمل بر اساس روش ها و سیاست های موجود/ بررسی و ارزیابی', 'desc' => 'بررسی و ارزیابی شیوه های انجام کار مطابق با استاندارها و ضوابط اجرا و شناسایی نقاط انحراف، و ایجاد تغییرات کوچگ در جهت انتطباق'],
                    ['title' => 'تمرکز بر بهبود/ اصلاح', 'desc' => 'منطبق سازی و یا ارتقا کیفیت و یا ارزش افزایی روش های موجود؛ ساختن وضعیت بهتر به عنوان بخشی از فعالیت های روزانه'],
                    ['title' => 'تمرکز بر بهبود/ بهبود', 'desc' => 'ایجاد تغییر معنادار و برجسته از طریق ارتقا و بهبود فرایندها، سیستم ها و یا محصولات موجود'],
                    ['title' => 'ایجاد فرایندها، فناوری ها و محصولات جدید/ خلق، ایجاد و مدل سازی', 'desc' => 'توسعه مفاهیم و روشهای جدید که فرصت های تازه ایجاد می نماید'],
                    ['title' => 'ایجاد فرایندها، فناوری ها و محصولات جدید/ توسعه دستاوردهای علمی و فناوری', 'desc' => 'شکل دادن و ایجاد تحول و پیشرفت های بنیادین جدید یا انقلابی در دانش یا فنون']
                ];
                break;
            case 'problem_solving_complexity':
                $options = [
                    ['title' => 'تعریف شده و مشخص', 'desc' => 'مشکلات و مسائلی که باید مورد توجه قرار گیرد به راحتی درک می شوند، عموما در یک زمینه شغلی یا رشته کاری قرار می گیرند؛ دامنه مشکل به خوبی تعریف شده است، غالبا مسائل و مشکلات تکراری است'],
                    ['title' => 'مشکل', 'desc' => 'مشکلات و مسائل ممکن است تا حدودی مبهم بوده  و به راحتی درک نمیشوند و نیازمند درک و توجه به سایر زمینه های شغلی یا رشته های کاری یا سایر بخش ها در سازمان باشند، برخی موضوعات غیر تکراری وجود دارد'],
                    ['title' => 'پیچیده', 'desc' => 'مسائل و مشکلات مبهم بوده و  نیازمند راهکارهایی چند وجهی می باشند و نیازمند توجه به یک، دو یا هر سه بعد مالی، انسانی و فنی می باشند، غالبا موضوعات غیر تکراری و دارای چارچوب مشخص نمی باشند، با این حال امکان مقایسه با راهکارهای قبل وجود دارد'],
                    ['title' => 'وسیع و چندبعدی', 'desc' => 'مسائل و موضوعات کاملا مبهم بوده و به طور واضح دارای ابعادی وسیع و چندبعدی (انسانی، مالی، فنی، داخل و خارج سازمان).  نیازمند گام به گام حل مساله و یافتن راهکارها می باشند . راه حل ها تاثیر مستقیم بر تمام ابعاد انسانی مالی و فنی تاثیر گذارند، موضوعات کاملا کلی، انتزاعی، بدون الگو و غیر تکراری می باشند']
                ];
                break;

            case 'skill_technical_knowledge':
                $options = [
                    ['title' => 'دانش شغلی محدود', 'desc' => 'دانش پایه ای خصوص استانداردها، ضوابط و مقررات انجام کار در یک قلمرو محدود کاری'],
                    ['title' => 'دانش شغلی پایه', 'desc' => 'دانش و مهارت تخصصی پایه و خاص شده که در بخشی از  حوزه های  وظیفه ای مانند حسابداری، مالی، حقوقی، اداری، تولید، فروش و بازاریابی قرار می گیرد'],
                    ['title' => 'دانش شغلی گسترده', 'desc' => 'دانش گسترده از تئوری ها و اصول در یک رشته تخصصی حرفه ای خاص و یا دانش و مهارت عمیق درباره فعالیت های فنی و عملیاتی خاص'],
                    ['title' => 'تخصصی', 'desc' => 'مهارت  و دانش پیشرفته در یک رشته حرقه ای تخصص که دربردانده ترکیب و  تطبیق نظریه ها و اصول با مسائل، فعالیت ها و روش های انجام کار در سازمان است.'],
                    ['title' => 'حرفه ای', 'desc' => 'سرآمدی و حرفه ای در یک رشته و تخصصی حرفه ای خاص که دربردانده ترکیب دانش عمیق و گسترده نظریه ها و مسائل و فعالیت های خاص سازمان است. و یا برخورداری از تخصص  و مهارت در چندین رشته متفاوت و مختلف در یک حوزه وظیفه ای و یا چندین خانواده شغلی مختلف میان حوزه های وظیفه ای متفاوت'],
                    ['title' => 'دانش و تجربه سرپرستی', 'desc' => 'تجربه مدیریت مناسب در حوظه های وظیفه ای متفاوت و یا کسب و کارهای مختلف. و یا متخصص سازمان در یک رشته تخصص خاص که با سایر فعالیت های سازمان در ارتباط است .'],
                    ['title' => 'تجربه حرفه ای و مدیریت گسترده', 'desc' => 'تجریه مدیریت گسترده و قابل توجه میان حوزه های وظیفه ای گوناگون از جمله در فعالیت های صف و ستاد سازمان ها و نیز کسب و کارهای گوناگون. و یا متخصص صنعت در یک رشته تخصص گسترده. '],
                    ['title' => 'تجربه حرفه ای و مدیریت عمیق', 'desc' => 'تجریه حرفه ای مدیریت بسیار برجسته و قابل ملاحظه در کسب و کارهای متعدد و در بیشتر فعالیت های صف و ستاد که با تجریه عمیقی از کار در یک یا چند حوزه وظیفه ای بسیار مهم در سازمان ها همراه بوده است. ']
                ];
                break;
            case 'skill_communication_skills':
                $options = [
                    ['title' => 'پایه (عضو نیم و واحد کاری)', 'desc' => 'مشارکت و همکاری فرد با سایر افراد- فاقد مسئولیت مستقیم در سرپرستی و هدایت افراد حفظ ارتباطات مؤثر و کارآمد با دیگران برای درخواست یا انتقال اطلاعات، سوالات و یا درک مفاهیم و منظورها.'],
                    ['title' => 'مهم (سرپرست و هماهنگ کننده تیم و گروه کاری)', 'desc' => 'هدایت، سرپرستی و مربی گری یک تیم یا گروه کاری (حداقل 3 نفر) در مهارت ها، پیشبرد کار، روش ها، تخصیص ها، و رصد کار درک و تأثیرگذاری بر افراد نفوذ و متقاعد نمودن افراد در عین توجه به دیدگاه ها برای تغییر نظرات و یا تغییر موقعیت ها '],
                    ['title' => 'حیاتی (مدیر تیم / واحد کاری)', 'desc' => 'مدیریت و هدایت بیشتر از یک تیم یا گروه کاری، تعیین ساختار تیم/ گروه  و تعیین نقش اعضا به کارگیری مهارت های مختلف ارتباطات انسانی جهت نقوذ و برانگیختن افراد ']
                ];
                break;
            case 'skill_spread':
                $options = [
                    ['title' => 'سطح 1', 'desc' => 'یک سازمان (مستقر در یک منطقه جغرافیایی)/ منطقه ای'],
                    ['title' => 'سطح 2', 'desc' => 'در سطح یک سازمان (با پراکندگی جغرافیایی گسترده)/ ملی'],
                    ['title' => 'سطح 3', 'desc' => 'در سطح کل موسسات و آستان قدس رضوی (کل کشور)/ ملی و بین المللی']
                ];
                break;


            case 'risk_type':
                $options = [
                    ['title' => 'صدمات معمولی و جزئی', 'desc' => 'حوادث کار ممکن است گاها و به ندرت اتفاق بیفتد اما معمولا منجر به صدمات و یا آسیب های جدی نمی شود'],
                    ['title' => 'فشارهای ذهنی', 'desc' => 'مواجهه با استرس مستمر و بالای شغلی و فشارهای فکری و روحی که ممکمن است است سلامت فرد را تحت تاثیر قرار دهد می باشد'],
                    ['title' => 'صدمات عمیق', 'desc' => 'خطر رخداد صدمات جسمی و عمیق'],
                    ['title' => 'از کار آفتادگی', 'desc' => 'خطر نقص عضو کلی، از کارافتادگی و یا حتی مرگ وجود دارد']
                ];
                break;
            case 'risk_possibility':
                $options = [
                    ['title' => 'احتمال وقوع و در معرض بودن کم', 'desc' => 'امکان وقوع حوادث وجود دارد و گاها بر سلامتی تاثیر می گذارد'],
                    ['title' => 'احتمال وقوع و در معرض بودن زیاد', 'desc' => 'خطرات و حوادث کاری ممکن است به صورت متناوب اتفاق بیفتد و این حوادث سلامتی فرد را تحت تاثیر قرار می دهند'],
                    ['title' => 'احتمال وقوع و  در معرض بودن زیاد', 'desc' => 'به طور مداوم در معرض محیطی قرار می گیرند که ممکن است به طور دائمی برای سلامتی فرد مضر باشد']
                ];
                break;

            default:
        }
        return json_encode([
            'header' => trans('tasks.project'),
            'content' => view('hamahang.OrgChart.changeScore')
                ->with('options', $options)
                ->with('job_id', $job_id)
                ->with('score', $score)
                ->with('value', $value)
                ->render(),
            'footer' => view('hamahang.helper.JsPanelsFooter')->with('btn_type', 'changeScore')->render()
        ]);
    }
    public function manager_charts(Request $request)
    {

        return json_encode([
            'header' => trans('basic_data.manager_charts'),
            'content' => view('modals.org_chart.manager_charts.jsp_manager_charts_content')
                ->with('org_id', $request->org_id)
                ->with('username', auth()->user()->Uname)
                ->render(),
            'footer' => view('modals.org_chart.manager_charts.jsp_manager_charts_footer')
                ->render()
        ]);
    }

    public function add_new_organ(Request $request)
    {
        return json_encode([
            'header' => trans('org_chart.add_new_organization'),
            'content' => view('modals.organ.add_organ.jsp_add_new_organ_content')
                ->render(),
            'footer' => view('modals.organ.add_organ.jsp_add_organ_footer')
                ->render()
        ]);
    }

    public function assign_new_staff(Request $request)
    {
        return json_encode([
            'header' => trans('org_chart.assign_new_staff'),
            'content' => view('modals.organ.add_organ.jsp_assign_staff_content')
                ->render(),
            'footer' => view('modals.organ.add_organ.jsp_assign_new_staff_footer')
                ->render()
        ]);
    }

    public function edit_show_post(Request $request)
    {
        $post = org_charts_items_jobs_posts::with('job', 'accesses', 'users', 'adventages', 'worktime')->where('id', deCode($request->post))->first();
        return json_encode([
            'header' => trans('org_chart.edit_show_post'),
            'content' => view('modals.organ.add_organ.jsp_edit_show_post_content')
                ->with('post', $post)
//                ->with('item_id', $request->item_id)
//                ->with('items', json_encode(['results'=>$items]))
                ->render(),
            'footer' => view('modals.organ.add_organ.jsp_edit_show_post_footer')
                ->render()
        ]);
    }

    public function add_new_post(Request $request)
    {
        $item = org_chart_items::with('chart', 'jobs')->where('id', $request->item_id)->first();
        $items = '';
        foreach($item->jobs as $job){
            $items[] = [
                'id' => $job->id,
                'text' => $job->job->title
                ];
        }

        return json_encode([
            'header' => trans('org_chart.add_new_post'),
            'content' => view('modals.organ.add_organ.jsp_add_new_post_content')
                ->with('jobs', $item->jobs)
                ->with('item_id', $request->item_id)
                ->with('items', json_encode(['results'=>$items]))
                ->render(),
            'footer' => view('modals.organ.add_organ.jsp_add_post_footer')
                ->render()
        ]);
    }
    public function edit_job_unit(Request $request)
    {
        $job = org_chart_items_jobs::with('job', 'alternate_users')->where('id', $request->job_id)->first();
        return json_encode([
            'header' => trans('org_chart.edit_job_unit'),
            'content' => view('modals.organ.add_organ.jsp_edit_job_unit_content')
                ->with('job', $job)
                ->with('job_id', $request->job_id)
                ->render(),
            'footer' => view('modals.organ.add_organ.jsp_edit_job_unit_footer')
                ->render()
        ]);
    }

    public function add_new_organ_form(Request $request)
    {
        return json_encode([
            'header' => trans('org_chart.add_new_post'),
            'content' => view('modals.organ.add_organ.jsp_add_new_organ_form')
                ->render(),
            'footer' => view('modals.organ.add_organ.jsp_add_post_footer')
                ->render()
        ]);
    }

    public function add_organ(Request $request)
    {
        return json_encode([
            'header' => trans('org_chart.add_new_organization'),
            'content' => view('modals.organ.add_organ.jsp_add_organ_content')
                ->render(),
            'footer' => view('modals.organ.add_organ.jsp_add_organ_footer')
                ->render()
        ]);
    }

    public function edit_organ(Request $request)
    {
        return json_encode([
            'header' => view('modals.organ.edit_organ.jsp_edit_organ_header')
                ->with('title', trans('org_chart.edit_organization') . $request->org_title)
                ->render(),
            'content' => view('modals.organ.edit_organ.jsp_edit_organ_content')
                ->with('title', $request->org_title)
                ->with('description', $request->org_description)
                ->with('level', $request->level)
                ->with('org_id', $request->org_id)
                ->render(),
            'footer' => view('modals.organ.edit_organ.jsp_edit_organ_footer')
                ->render()
        ]);
    }

    public function show_edit_data_organ(Request $request)
    {
        $parent_id = 0;
        $parent_title = '';
        $item = org_chart_items::with('chart', 'jobs')->where('id', $request->item_id)->first();
        if (isset($item->parent_id) && ($item->parent_id != 0))
        {
            $item_parent_title = org_chart_items::find($item->parent_id);
            $parent_title = $item_parent_title->title;
            $parent_id = $item->parent_id;
        }
        $organ_title = org_organs::find($item->chart->org_organs_id)->title;
        return json_encode([
            'header' => view('modals.organ.show_edit_organ.jsp_show_edit_organ_header')
                ->with('title', $item->title)
                ->render(),
            'content' => view('modals.organ.show_edit_organ.jsp_show_edit_organ_content')
                ->with('item_id', $item->id)
                ->with('chart_id', $item->chart_id)
                ->with('title', $item->title)
                ->with('jobs', $item->jobs)
                ->with('description', $item->description)
                ->with('parent', [$parent_id, $parent_title])
                ->render(),
            'footer' => view('modals.organ.show_edit_organ.jsp_show_edit_organ_footer')
                ->with('organ_title', '1')
                ->with('chart_title', $item->chart->title)
                ->with('parent_title', $parent_title)
                ->with('organ_title', $organ_title)
                ->render()
        ]);
    }

    public function edit_chart(Request $request)
    {
        $chart = org_charts::find($request->chart_id)->first();
        return json_encode([
            'header' => view('modals.org_chart.edit_chart.jsp_edit_charts_header')
                ->with('title', trans('org_chart.edit_chart') . $request->chart_title)
                ->render(),
            'content' => view('modals.org_chart.edit_chart.jsp_edit_charts_content')
                ->with('chart_id', $request->chart_id)
                ->with('chart_title', $chart->title)
                ->with('chart_description', $chart->description)
                ->render(),
            'footer' => view('modals.org_chart.edit_chart.jsp_edit_charts_footer')
                ->render()
        ]);
    }

    public function edit_user_detail(Request $request)
    {
        $act = '';
        if($request->exists('act'))
            $act = $request->get('act');

        $user = User::find($request->user_id);
        $provinces = Province::all();
        $cities = City::all();
        return json_encode([
            'header' => $user['Name'].' '.$user['Family'],
            'content' => view('hamahang.Users.view_user_details_modal.content')
                ->with('user', $user)
                ->with('provinces', $provinces)
                ->with('cities', $cities)
                ->with('act', $act)
                ->render(),
            'footer' => view('hamahang.Users.view_user_details_modal.footer')
                ->render()
        ]);
    }

    public function basicdataGetUsersScores(Request $request)
    {
        $scores = Score::where('type_value_id', $request->item_id)->groupBy('uid')->get();
//        $user = \App\User::find($scores[1]->uid);
//        dd($user->spec_scores(1)->get());
        return json_encode([
            'header' => 'کاربران دارای امتیاز' . ' ' . $request->item_title,
            'content' => view('hamahang.Basicdata.helper.scores.users_csores')
                ->with('item_id', $request->item_id)
                ->with('scores', $scores)
                ->render(),
            'footer' => ''
        ]);
    }
    //----------------------------------------------------------------------
    //*********************** Basicdata Add/Edit Forms *********************
    //----------------------------------------------------------------------

    public function addEditTools(Request $request)
    {
        $tool = null;
        if ($request->item_id)
        {
            $tool = Tools::find(deCode($request->item_id));
        }
        $tools_availables = json_encode(ToolsAvailable::all('id', 'title as text'));
        $tools_groups = json_encode(ToolsGroup::all('id', 'name as text'));
        $options = Options::all(['id', 'title', 'description']);
        $positions = TemplatePosition::all(['id', 'position', 'description']);
        return json_encode([
            'header' => isset($tool) ? 'ویرایش ابزار' : 'افزودن ابزار',
            'content' => view('hamahang.Tools.helper.Index.modals.modal_add_edit_tool')
                ->with('options', $options)
                ->with('positions', $positions)
                ->with('tool', $tool)
                ->render(),
            'footer' => view('hamahang.Tools.helper.Index.modals.modal_add_edit_tool_footer')
                ->with('tools_availables', $tools_availables)
                ->with('tools_groups', $tools_groups)
                ->with('tool', $tool)
                ->render()
        ]);
    }

    public function addRolesTools(Request $request)
    {
        $tools = Tools::all(['id', 'title as text']);
        $roles = Role::all(['id', 'name', 'display_name']);
        foreach ($roles as $role)
        {
            $role->text = $role->name . ' (' . $role->display_name . ')';
        }

        $with_arr = [
            'roles' => json_encode($roles),
            'all_tools' => json_encode($tools),
        ];


        return json_encode([
            'header' => 'انتساب ابزار به نقش ها',
            'content' => view('hamahang.Tools.helper.Index.modals.modal_add_role_tool',$with_arr)
                ->render(),
            'footer' => view('hamahang.Tools.helper.Index.modals.modal_add_role_tool_footer')
                ->render()
        ]);
    }

    public function addUsersTools(Request $request)
    {
        $tools = Tools::all(['id', 'title as text']);
        $roles = Role::all(['id', 'name', 'display_name']);
        foreach ($roles as $role)
        {
            $role->text = $role->name . ' (' . $role->display_name . ')';
        }

        $with_arr = [
            'roles' => json_encode($roles),
            'all_tools' => json_encode($tools),
        ];


        return json_encode([
            'header' => 'انتساب ابزار به کاربران',
            'content' => view('hamahang.Tools.helper.Index.modals.modal_add_user_tool',$with_arr)
                ->render(),
            'footer' => view('hamahang.Tools.helper.Index.modals.modal_add_user_tool_footer')
                ->render()
        ]);
    }

    public function addEditMenu(Request $request)
    {
//        $tools = Tools::all(['id', 'title as text']);
//        $roles = Role::all(['id', 'name', 'display_name']);
//        foreach ($roles as $role)
//        {
//            $role->text = $role->name . ' (' . $role->display_name . ')';
//        }
//
//        $with_arr = [
//            'roles' => json_encode($roles),
//            'all_tools' => json_encode($tools),
//        ];

        $menu = null;
        if ($request->item_id)
        {
            $menu = Menus::find(deCode($request->item_id));
        }

        return json_encode([
            'header' => 'فهرست جدید',
            'content' => view('hamahang.Menus.helper.Index.modals.modal_add_edit_menu')
                ->with('menu', $menu)
                ->render()
            ,
            'footer' => view('hamahang.Menus.helper.Index.modals.modal_add_edit_menu_footer')
                ->with('menu', $menu)
                ->render()
        ]);
    }

    public function addEditMenuItems(Request $request)
    {
//        $tools = Tools::all(['id', 'title as text']);
//        $roles = Role::all(['id', 'name', 'display_name']);
//        foreach ($roles as $role)
//        {
//            $role->text = $role->name . ' (' . $role->display_name . ')';
//        }
//
//        $with_arr = [
//            'roles' => json_encode($roles),
//            'all_tools' => json_encode($tools),
//        ];

//        dd($request->all());
        $MenuItem = null;
        $User = null;
        if ($request->item_id)
        {
            $MenuItem = MenuItem::find(deCode($request->item_id));
//            $ST = DB::table('hamahang_menu_items as hmi')
//                ->leftJoin('user_profile as p', 'u.id', '=', 'p.id')
//                ->leftJoin('user_profile as p', 'u.id', '=', 'p.id')
//                ->select('u.id', 'u.Uname as name', 'u.Name', 'u.Family', 'u.Reg_date')->where('Active', '1')->whereRaw($search)->orderBy('u.id', 'DESC')->get();
        }
        if ($request->permitted_users)
        {
            $MenuItem = MenuItem::find(deCode($request->permitted_users));
        }
        return json_encode([
            'header' => 'فهرست جدید',
            'content' => view('hamahang.Menus.helper.Index.modals.modal_add_edit_menu_items')
                ->with('MenuItem', $MenuItem)
                ->with('PermittedUsers', $MenuItem==null ? '' : $MenuItem->getPermittedUsersAttribute())
                ->with('PermittedRoles', $MenuItem==null ? '' : $MenuItem->getPermittedRolesAttribute())
                ->render()
            ,
            'footer' => view('hamahang.Menus.helper.Index.modals.modal_add_edit_menu_items_footer')
                ->with('MenuItem', $MenuItem)
                ->render()
        ]);
    }

    public function help_view(Request $request)
    {
        $id = deCode($request->input('id'));
        $help = Help::whereNull('hamahang_helps.deleted_at')
            ->where('hamahang_helps.id', '=', $id)
            ->with('SeeAlsos2', 'SeeAlsos1', 'HelpBlocks')
            ->first();
//        dd($help);
//            ->get();
        return json_encode
        ([
            'header' => trans('محتوای مرتبط'),
            'content' => view('hamahang.help.helpers.view_content')->with(['items' => $help,'id'=>$request->input('id')])->render(),
            'footer' => view('hamahang.help.helpers.view_footer')->render()
        ]);
        $help_block = HelpBlock::where('help_id', $id)->with('page');
        if ($help_block->count())
        {
            $help_block = $help_block->get();
        }
        return json_encode
        ([
            'header' => trans('محتوای مرتبط'),
            'content' => view('hamahang.help.helpers.view_content')->with(['items' => $help_block])->render(),
            'footer' => view('hamahang.help.helpers.view_footer')->render()
        ]);
    }

    public function help_seealso(Request $request)
    {
        $id = deCode($request->input('id'));
        $help = Help::find($id);
        if ($help->count())
        {
            $help = $help->SeeAlsos;
        }
        return json_encode
        ([
            'header' => trans('help.see_also'),
            'content' => view('hamahang.help.helpers.seealso_content')->with(['help_id' => $id, 'items' => $help])->render(),
            'footer' => view('hamahang.help.helpers.seealso_footer')->render()
        ]);
    }

    public function help_seealso_add(Request $request)
    {
        $help_1_id = deCode($request->input('help_1_id'));
        $help_2_ids = $request->input('help_2_ids');
        $help = Help::find($help_1_id);
        if ($help->count())
        {
            $help->SeeAlsos()->sync($help_2_ids, false);
            return json_encode(['success', 'با موفقیت افزوده شد.']);
        }
    }

    public function content(){
        return view('modals.editor.content');
    }
    public function help_seealso_content(Request $request)
    {
        $id = deCode($request->input('id'));
        $help = Help::find($id);
        if ($help->count())
        {
            $help = $help->SeeAlsos;
        }
        return view('hamahang.help.helpers.seealso_content')->with(['help_id' => $id, 'items' => $help])->render();
    }

    public function help_seealso_delete(Request $request)
    {
        $help_1_id = deCode($request->input('help_1_id'));
        $help_2_id = deCode($request->input('help_2_id'));
        $help = Help::find($help_1_id);
        $help->SeeAlsos()->detach($help_2_id);
        return json_encode(['success', 'با موفقیت حذف شد.']);
    }

    public function help_relation_add(Request $request)
    {
        $help_ids = [];
        $target_type = $request->input('target_type');
        $target_id = $request->input('target_id');
        $help_items = $request->input('help_id');

        foreach ($help_items as $help_item)
        {
            //$get_id = str_replace(['help_relation_add[', ']'], null, $help_item['name']);
            $help_ids[/*$get_id*/] = $help_item['value'];
        }

        $get_page = Pages::find($target_id);
        if ($get_page)
        {
            if ($get_page->subject)
            {
                $get_subject_id = $get_page->subject->id;
                $pages = Pages::where('sid', $get_subject_id)->select('id')->get();
                if ($pages)
                {
                    foreach ($pages as $page_k => $page)
                    {
                        if (isset($help_ids[$page_k]))
                        {
                            if ($help_ids[$page_k])
                            {
                                DB::table('hamahang_help_relations')
                                    ->where('target_type', 'App\Models\hamafza\Pages')
                                    ->where('target_id', $page->id)->delete();
                                DB::table('hamahang_help_relations')->insert
                                ([
                                    'target_type' => 'App\Models\hamafza\Pages',
                                    'target_id' => $page->id,
                                    'help_id' => $help_ids[$page_k],
                                    'created_by' => auth()->id(),
                                ]);
                            }
                        }
                    }
                }
            }
        }
        return json_encode(['success', 'با موفقیت ثبت شد.']);
        /*
        dd('');

        foreach ($help_ids as $help_id)
        {
            //DB_table
        }

        dd($help_ids);
        //$created_by = auth()->id();
        if ($help_id)
        {
            switch ($target_type)
            {
                case 'page':
                {
                    Pages::find($target_id)->help()->sync($help_id);
                    break;
                }
            }
        }
        */
    }

    public function getKeywordsListSubjectUsages(Request $request)
    {
        $keyword_id = $request->get('keyword_id');
        $keyword = Keyword::find($keyword_id);
        $res = json_encode(
            [
                'header' => view('pages.Desktop.keywords_list_subject_usages_header', compact('keyword'))->render(),
                'content' => view('pages.Desktop.keywords_list_subject_usages_content', compact('keyword'))->render(),
                'footer' => view('pages.Desktop.keywords_list_subject_usages_footer')->render(),
            ]
        );
        return $res;
    }
}
