<?php

namespace App\Http\Controllers\View;

use App\Models\hamafza\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HamafzaViewClasses\PublicClass;
use App\HamafzaViewClasses\FormClass;
use App\HamafzaViewClasses\substclass;
use App\HamafzaServiceClasses\UserClass;
use App\HamafzaServiceClasses\LoginClass;
use Illuminate\Support\Facades\DB;
use \App\HamafzaServiceClasses\ConfigurationClass;
use App\HamafzaServiceClasses\SubjectsClass;
use Auth;
use Image;

class FormsController extends Controller
{

    public function keyword_update(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {

            $keyid = $request->input('keyid');
            $uid = Auth::id();
            $tmpFileName = '';
            $file = $request->file('PicFiles');
            $UpFiles = array();
            $tmpFilePath = '';
            if ($file)
            {
                if ($file->isValid())
                {
                    $tmpFilePath = 'files/keywords/';
                    $extension = $file->getClientOriginalExtension();
                    $tmpFileName = $uid . $keyid . time() . '.' . $extension; // renameing image
                    $img = IImage::make($file->getRealPath());
                    $img->resize(550, null, function ($constraint)
                    {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $img->save('files/keywords/' . $tmpFileName)->destroy();
                }
            }
            $shape = $request->input('shape');
            $rels = $request->input('rels');
            $keyname = $request->input('joz');
            $kootah = $request->input('kootah');
            $Tagtype = $request->input('Tagtype');
            $relation = $request->input('relation');
            $code = $request->input('code');
            $thes = $request->input('thes');
            $Descr = $request->input('Descr');
            $workflow = $request->input('workflow');
            $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
            $relation = ($relation == '') ? '0' : $relation;

            if ($keyid != 0)
            {
                DB::table('keywords')->where('id', $keyid)->update(array('keyword' => $shape
                , 'descr' => $Descr, 'type' => $Tagtype, 'uid' => $uid
                , 'ttype' => '15', 'workflow' => $workflow, 'code' => $code
                , 'morajah' => $relation, 'pic' => $tmpFilePath
                ));
            }
            else
            {
                $keyid = DB::table('keywords')->insertGetId(array('keyword' => $shape, 'reg_date' => $reg_date
                , 'descr' => "$Descr", 'type' => $Tagtype, 'uid' => $uid
                , 'ttype' => '15', 'workflow' => $workflow, 'code' => $code
                , 'morajah' => $relation, 'pic' => $tmpFileName
                ));
            }
            DB::table('thesaurus_keywords')->where('keyword_id', $keyid)->delete();
            $thes = explode(',', $thes);
            if (is_array($thes) && count($thes) > 0)
            {
                foreach ($thes as &$value)
                {
                    if ($value != '')
                    {
                        DB::table('thesaurus_keywords')->insert(array('keyword_id' => $keyid, 'subject_id' => $value));
                    }
                }
            }
            DB::table('keyword_relations')->where('keyword_1_id', $keyid)->delete();
            DB::table('keyword_relations')->where('keyword_2_id', $keyid)->delete();

            if (is_array($keyname) && count($keyname) > 0)
            {
                foreach ($keyname as $key => $value)
                {
                    $K2 = $value;
                    foreach ($K2 as $values)
                    {
                        if (intval($rels[$key]) < 100)
                        {
                            DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid, 'keyword_2_id' => $values, 'relation_type' => $rels[$key]));
                        }
                        else
                        {
                            $relss = str_replace("10", '', $rels[$key]);
                            DB::table('keyword_relations')->insert(array('keyword_1_id' => $values, 'keyword_2_id' => $keyid, 'relation_type' => $relss));
                        }
                    }
                }
            }
            if (is_array($kootah) && count($kootah) > 0)
            {
                foreach ($kootah as &$value)
                {
                    if ($value != '')
                    {
                        DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid, 'keyword_2_id' => $value, 'relation_type' => '11'));
                    }
                }
            }
            return 'انجام شد.';
        }
    }

    public function regProcess(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $Uname = (session('Uname') != '') ? session('Uname') : 0;
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $phase_name = $request->input('phase_name');
            $phase_score = $request->input('phase_score');
            $view = $request->input('view');
            $phase_manager1 = $request->input('phase_manager1');
            $phase_manager = $request->input('phase_manager');
            $formid = $request->input('formid');
            $pformid = $request->input('pformid');
            $persons = $request->input('persons');
            $alert = $request->input('alert');
            $process_name = $request->input('process_name');
            $process_comment = $request->input('process_comment');
            $MC = new \App\HamafzaViewClasses\ProccessClass;
            $mc = $MC->ADDProccess($uid, $sesid, $phase_name, $phase_score, $view, $phase_manager1, $phase_manager, $formid, $pformid, $persons, $alert, $process_name, $process_comment);
            return Redirect()->to($Uname . '/desktop/process_list')->with('message', $mc)->with('mestype', 'success');
        }
    }

    public function measure_add(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $quote = $request->input('select');
            $title = $request->input('title');
            $Descr = $request->input('Descr');
            $user_edits = $request->input('user_edits');
            $user_roonevesht = $request->input('user_roonevesht');
            $vagozari = $request->input('vagozari');
            $mohlat = $request->input('mohlat');
            if ($mohlat != '')
            {
                $myArray = explode('/', $mohlat);
                $edate1 = \Morilog\Jalali\jDateTime::toGregorian($myArray[0], $myArray[1], $myArray[2]);
                $mohlat = $edate1[0] . '/' . $edate1[1] . '/' . $edate1[2];
            }
            $foriat = $request->input('foriat');
            $ahamiat = $request->input('ahamiat');
            $Sendmail = $request->input('Sendmail');
            $sendsms = $request->input('sendsms');
            $mesure_tags = $request->input('mesure_tags');
            $isdraft = $request->input('isdraft');
            $filetitle = $request->input('ftitle');
            $files = $request->file('file');
            $pid = $request->input('pid');
            $sid = $request->input('sid');
            $moarefi = $request->input('moarefi');
            $naghallow = $request->input('naghallow');
            $naghl = $request->input('naghl');
            $keywords = $request->input('mesure_tags');
            $Slides = array();
            $uploadcount = 0;
            $tt = '';
            if (is_array($files))
            {
                foreach ($files as $key => $file)
                {
                    if ($file)
                    {
                        if ($file->isValid())
                        {
                            $tmpFilePath = 'files/measure/';
                            if (!file_exists(public_path() . '/' . $tmpFilePath))
                            {
                                mkdir(public_path() . '/' . $tmpFilePath, 0777, true);
                            }
                            $extension = $file->getClientOriginalExtension();
                            $tmpFileName = $uid . $key . time() . '.' . $extension; // renameing image
                            $file->move($tmpFilePath, $tmpFileName);
                            $Slides[$uploadcount]['name'] = $tmpFileName;
                            $Slides[$uploadcount]['title'] = $filetitle[$key];
                        }
                    }
                    $uploadcount++;
                }
            }
            $select = $quote;
            $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
            $mid = DB::table('actions')->insertGetId(
                array('admin' => $uid, 'pid' => $pid, 'title' => $title, 'quote' => $quote, 'Descr' => $Descr,
                    'allowredirect' => $vagozari, 'res_date' => $mohlat,
                    'urgency' => $foriat, 'priority' => $ahamiat, 'reg_date' => $reg_date, 'isdraft' => $isdraft));
            foreach ($Slides as $value)
            {
                DB::table('action_file')->insert(array('name' => $value['name'], 'admin' => $uid, 'mid' => $mid));
            }

            if ($isdraft == '1')
            {
                DB::table('action_recieve')->where('mid', $mid)->delete();
                $user_edits = explode(",", $user_edits);
                if (is_array($user_edits))
                {
                    foreach ($user_edits as $key => $val)
                    {
                        if (intval($val) != 0)
                        {
                            DB::table('action_recieve')->insert(array('mid' => $mid, 'uid' => $val, 'is_bc', '1'));
                        }
                    }
                }
                $user_roonevesht = explode(",", $user_roonevesht);

                if (is_array($user_roonevesht))
                {
                    foreach ($user_roonevesht as $key => $val)
                    {
                        if (intval($val) != 0)
                        {
                            DB::table('action_recieve')->insert(array('mid' => $mid, 'uid' => $val, 'is_bc' => '1'));
                        }
                    }
                }
            }
            else
            {
                if ($isdraft == '0')
                {
                    DB::table('action_recieve')->where('mid', $mid)->delete();
                    if (is_array($user_edits))
                    {
                        foreach ($user_edits as $key => $val)
                        {
                            if (intval($val) != 0)
                            {
                                DB::table('action_recieve')->insert(array('mid' => $mid, 'uid' => $val));
                                //Alerts::Measure($val, $uid, '1');
                            }
                        }
                    }

                    if (is_array($user_roonevesht))
                    {
                        foreach ($user_roonevesht as $key => $val)
                        {
                            if (intval($val) != 0)
                            {
                                DB::table('action_recieve')->insert(array('mid' => $mid, 'uid' => $val, 'is_bc' => '1'));
                                //Alerts::Measure($val, $uid, '0');
                            }
                        }
                    }
                }
            }

            $Ret = trans('labels.MeasureOK');
            return Redirect()->back()->with('message', $Ret)->with('mestype', 'success');
        }
    }

    /*public function keyword_save(Request $request) {
        if (!Auth::check())
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        else {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $tmpFileName = '';
            $file = $request->file('PicFiles');
            $UpFiles = array();
            if ($file) {
                if ($file->isValid()) {
                    $tmpFilePath = 'files/keywords/';
                    $extension = $file->getClientOriginalExtension();
                    $tmpFileName = $uid . $key . time() . '.' . $extension; // renameing image
                    $img = IImage::make($file->getRealPath());
                    $img->resize(550, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $img->save('files/keywords/' . $tmpFileName)->destroy();
                }
            }
            $shape = $request->input('shape');
            $Tagtype = $request->input('Tagtype');
            $workflow = $request->input('workflow');
            $code = $request->input('code');
            $relation = $request->input('relation');
            $thes = $request->input('thes');
            $Descr = $request->input('Descr');
            $joz = $request->input('joz');
            $keys = $request->input('keys');
            $mesdagh = $request->input('mesdagh');
            $jozmes = $request->input('jozmes');
            $kol = $request->input('kol');
            $aam = $request->input('aam');
            $kolaam = $request->input('kolaam');
            $hamarz = $request->input('hamarz');
            $moraj = $request->input('moraj');
            $hambaste = $request->input('hambaste');
            $eshterak = $request->input('eshterak');
            $kootah = $request->input('kootah');
            $english = $request->input('english');
            $arabic = $request->input('arabic');
            $motazad = $request->input('motazad');
            $eshtebah = $request->input('eshtebah');
            $file = $tmpFileName;
            $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
            $relation = ($relation == '') ? '0' : $relation;
            $keyid1 = DB::table('keywords')->insertGetId(array('keyword' => $shape, 'reg_date' => $reg_date
                , 'descr' => $Descr, 'type' => $Tagtype, 'uid' => $uid
                , 'ttype' => '15', 'workflow' => $workflow, 'code' => $code
                , 'morajah' => $relation, 'pic' => $file
            ));
            $thes = explode(',', $thes);
            if (is_array($thes) && count($thes) > 0) {
                foreach ($thes as &$value) {
                    if ($value != '')
                        DB::table('thesaurus_keywords')->insert(array('keyword_id' => $keyid1, 'subject_id' => $value));
                }
            }
            else {
                DB::table('thesaurus_keywords')->insert(array('keyword_id' => $keyid1, 'subject_id' => config('constans.defthesarus')));
            }
            $joz = explode(',', $joz);
            if (is_array($joz) && count($joz) > 0) {
                foreach ($joz as &$value) {
                    if ($value != '')
                        DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '1'));
                }
            }
            $mesdagh = explode(',', $mesdagh);

            if (is_array($mesdagh) && count($mesdagh) > 0) {

                foreach ($mesdagh as &$value) {
                    if ($value != '')
                        DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '3'));
                }
            }
            $jozmes = explode(',', $jozmes);
            if (is_array($jozmes) && count($jozmes) > 0) {

                foreach ($jozmes as &$value) {
                    if ($value != '')
                        DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '5'));
                }
            }
            $kol = explode(',', $kol);
            if (is_array($kol) && count($kol) > 0) {
                foreach ($kol as &$value) {
                    if ($value != '')
                        DB::table('keyword_relations')->insert(array('keyword_1_id' => $value, 'keyword_2_id' => $keyid1, 'relation_type' => '1'));
                }
            }

            $aam = explode(',', $aam);

            if (is_array($aam) && count($aam) > 0) {

                foreach ($aam as &$value) {
                    if ($value != '')
                        DB::table('keyword_relations')->insert(array('keyword_1_id' => $value, 'keyword_2_id' => $keyid1, 'relation_type' => '3'));
                }
            }
            $kolaam = explode(',', $kolaam);
            if (is_array($kolaam) && count($kolaam) > 0) {
                foreach ($kolaam as &$value) {
                    if ($value != '')
                        DB::table('keyword_relations')->insert(array('keyword_1_id' => $value, 'keyword_2_id' => $keyid1, 'relation_type' => '5'));
                }
            }
            $hamarz = explode(',', $hamarz);
            if (is_array($hamarz) && count($hamarz) > 0) {
                foreach ($hamarz as &$value) {
                    if ($value != '')
                        DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '7'));
                }
            }

            $moraj = explode(',', $moraj);

            if (is_array($moraj) && count($moraj) > 0) {
                foreach ($moraj as &$value) {
                    if ($value != '')
                        DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '8'));
                }
            }
            $hambaste = explode(',', $hambaste);

            if (is_array($hambaste) && count($hambaste) > 0) {
                foreach ($hambaste as &$value) {
                    if ($value != '')
                        DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '9'));
                }
            }
            $eshterak = explode(',', $eshterak);

            if (is_array($eshterak) && count($eshterak) > 0) {

                foreach ($eshterak as &$value) {
                    if ($value != '')
                        DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '10'));
                }
            }
            //$kootah = explode(',', $kootah);

            if (is_array($kootah) && count($kootah) > 0) {

                foreach ($kootah as &$value) {
                    if ($value != '')
                        mysql_query("INSERT INTO keyword_relations ( keyid1 , keyid2 , rel ) VALUES ( '$keyid1' , '$value' , '11' )") or die("no connect");
                }
            }
            $english = explode(',', $english);

            if (is_array($english) && count($english) > 0) {
                foreach ($english as &$value) {
                    if ($value != '')
                        DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '12'));
                }
            }
            $arabic = explode(',', $arabic);
            if (is_array($arabic) && count($arabic) > 0) {

                foreach ($arabic as &$value) {
                    if ($value != '')
                        DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '13'));
                }
            }
            $eshtebah = explode(',', $eshtebah);
            if (is_array($eshtebah) && count($eshtebah) > 0) {
                foreach ($eshtebah as &$value) {
                    if ($value != '')
                        DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '20'));
                }
            }
            $motazad = explode(',', $motazad);
            if (is_array($motazad) && count($motazad) > 0) {
                foreach ($motazad as &$value) {
                    if ($value != '')
                        DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '21'));
                }
            }
            return Redirect()->back()->with('message', 'انجام شد.')->with('mestype', 'success');
        }
    }*/

    public function newOrgGroup(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $group_title = $request->input('group_title');
            $group_link = $request->input('group_link');
            $group_summary = $request->input('group_summary');
            $group_type = $request->input('group_type');
            $group_limit = $request->input('group_limit');
            $group_limit = $request->input('group_limit');
            $isorgan = $request->input('isorgan');
            $Groupkeywords = $request->input('Groupkeywords');
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
//            $SP = new UserClass();
//            $menu = $SP->newOrgGroup($group_title, $group_link, $group_summary, $group_type, $group_limit, $isorgan, $Groupkeywords, $tmpFileName, $sesid, $uid);
            $count = DB::table('user_group')->where('link', $group_link)->count();
            if ($count == 0)
            {
                $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
                $gid = DB::table('user_group')->insertGetId(array('uid' => $uid, 'name' => $group_title, 'link' => $group_link,
                    'summary' => $group_summary, 'type' => $group_type, 'edit' => $group_limit, 'pic' => $tmpFileName, 'reg_date' => $reg_date, 'isorgan' => $isorgan));
                DB::table('user_group_member')->insert(array('uid' => $uid, 'gid' => $gid, 'follow' => '1',
                    'admin' => '1', 'relation' => '2', 'reg_date' => $reg_date));
                $keywords = explode(',', $Groupkeywords);
                foreach ($keywords as &$value)
                {
                    DB::table('user_group_key')->insert(array('gid' => $gid, 'kid' => $value));
                }
                $menu = $gid;
                if ($isorgan)
                {
                    session('newgroup', 'neworgan');
                }
                else
                {
                    session('newgroup', 'newgroup');
                }
                return Redirect()->route('group.edit', ['id' => $menu]);
            }
            else
            {
                $menu = 'این آدرس  تکراری است';
                session('newgroup', '');
                return Redirect()->back()->with('message', $menu)->with('mestype', 'success');
            }
        }
    }

    public function newCircle(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $circle_name = $request->input('circle_name');
            $orders = DB::table('user_circle')->where('uid', $uid)->max('orders');
            $orders++;
            $cid = intval($uid);
            $cid .= $orders;
            $userid = DB::table('user_circle')->insertGetId(array('id' => $cid, 'uid' => $uid, 'name' => $circle_name, 'orders' => $orders));
            $err = false;
            $mes = 'حلقه درج شد.';
            return Redirect()->back()->with('message', $mes)->with('mestype', 'success');
        }
    }

    public function sendMessage(Request $request)
    {
//        dd($request->all());
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = Auth::id();
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $title = $request->input('title');
            $comment = $request->input('comment');
            $user_edits = $request->input('user_edits');
//            dd($user_edits);
//            $files = $request->file('file');
//            $filetitle = $request->input('ftitle');
            $tt = '';
            $Slides = array();

//            $uploadcount = 0;
//            if (is_array($files) && count($files) > 0)
//            {
//                foreach ($files as $key => $file)
//                {
//                    if ($file)
//                    {
//                        if ($file->isValid())
//                        {
//                            $tmpFilePath = 'files/ticket/' . $uid . '/';
//                            if (!file_exists(public_path() . '/' . $tmpFilePath))
//                            {
//                                mkdir(public_path() . '/' . $tmpFilePath, 0777, true);
//                            }
//                            $extension = $file->getClientOriginalExtension();
//                            $tmpFileName = $uid . $key . time() . '.' . $extension; // renameing image
//                            $file->move($tmpFilePath, $tmpFileName);
//                            $Slides[$uploadcount]['name'] = $uid . '/' . $tmpFileName;
//                            $Slides[$uploadcount]['title'] = $filetitle[$key];
//                        }
//                    }
//                    $uploadcount++;
//                }
//            }
            $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
            $tid = DB::table('tickets')->insertGetId(array('uid' => $uid, 'title' => $title, 'login' => '0', 'reg_date' => $reg_date));

            $file = HFM_SaveMultiFiles('message_file', '\App\Models\Hamahang\FileManager\Fileable', 'fileable_id', $tid, ['created_by' => auth()->id(), 'fileable_type' => 'App\Models\hamafza\Ticket', 'type' => 1]);

            DB::table('ticket_answer')->insert(array('uid' => $uid, 'tid' => $tid, 'comment' => $comment, 'reg_date' => $reg_date));
            if (is_array($user_edits))
            {
                foreach ($user_edits as $key => $val)
                {
                    if (intval($val) != 0)
                    {
                        DB::table('ticket_recieve')->insert(array('tid' => $tid, 'uid' => $val, 'del' => 0));
                        //  Alerts::Message($val, $uid);
                    }
                }
            }
            if (is_array($Slides) && count($Slides) > 0)
            {
                foreach ($Slides as $value)
                {
                    DB::table('ticket_file')->insert(array('aid' => $tid, 'name' => $value['name'], 'title' => $value['title']));
                }
            }
            $mes = trans('labels.SMSSEndOK');
            return Redirect()->back()->with('message', $mes)->with('mestype', 'success');
        }
    }

    public function downloadfile(Request $request)
    {
        $fid = $request->input('fid');
        $pid = $request->input('pid');
        $page_id = $pid;
        $fname = $request->input('fname');
        $file_path = public_path() . '/files/page/' . $pid . '_' . $fname . '';
        $file = public_path() . '/files/page/' . $fname;
        if (file_exists($file_path))
        {
            output_file($file_path, $pid . '_' . $fname, '');
        }
        else
        {
            if (file_exists($file))
            {
                return \Response::download($file);
                exit;
            }
        }

    }

    public function deletesubject(Request $request)
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
        $sid = $request->input('sid');
        $type = $request->input('type');
        $TC = new ToolsClass();
        $mes = $TC->deletesubject($uid, $sesid, $sid, $type);
        return $mes;
    }

    public function announce_send(Request $request)
    {
        $uid = auth()->id();
        $title = $request->input('title');
        $about = $request->input('moarefi');
        $comment = $request->input('comment');
        $alamat = $request->input('alamat');
        //$moarefi = $request->input('moarefi');
        //$naghallow = $request->input('naghallow');
        $naghl = $request->input('naghl');
        $keywords = $request->input('keywords');
        $pid = $request->input('pid');

        $select = $request->input('select');
        $book_page = $request->input('bookpage');

        $select = ($select == '') ? ' ' : $select;
        $book_page = ($book_page == '') ? 0 : $book_page;

        $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
        if ($about != 'on')
        {
            $pid = 0;
        }
        $announce_id = DB::table('announces')->insertGetId(
            [
                'pid' => $pid,
                'uid' => $uid,
                'quote' => $select,
                'title' => $title,
                'comment' => $comment,
                'reg_date' => $reg_date,
                'mostaghim' => $naghl,
                'bookpage' => $book_page
            ]
        );
        $myArray = explode(',', $keywords);
        $myArray = json_encode($myArray);
        $myArray = json_decode($myArray);

        foreach ($myArray as &$value)
        {
            DB::table('announce_keys')->insert(
               [
                   'ann_id' => $announce_id,
                   'key_id' => $value
               ]
            );
        }

        if ($alamat == 'on')
        {
            DB::table('highlights')->insertGetId(
                [
                    'pid' => $pid,
                    'uid' => $uid,
                    'quote' => $select,
                    'type' => '1',
                    'reg_date' => $reg_date
                ]
            );
        }
        $mes = trans('labels.ann_ok');
        return Redirect()->back()->with('message', $mes)->with('mestype', 'success');
    }

    public function update_Help(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $pid = $request->input('Help_pid');
            $sid = $request->input('Help_sid');
            $subject_help = $request->input('subject_help');
            $subject_Alert = $request->input('subject_Alert');
            $SP = new SubjectsClass();
            $menu = $SP->update_Help($pid, $sid, $subject_help, $subject_Alert);
            return Redirect()->back()->with('message', $menu)->with('mestype', 'success');
        }
    }

    public function update_Access(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $show = $request->input('show');
            $sid = $request->input('access_sid');
            $pid = $request->input('access_pid');
            $subject_view = $request->input('subject_view');
            $subject_search = $request->input('subject_search');
            /* $uid = (session('uid') != '') ? session('uid') : 0;
             $sesid = (session('sesid') != '') ? session('sesid') : 0;
             $pid = $request->input('access_pid');
             $sid = $request->input('access_sid');
             $manager = $request->input('manager');
             $supporter = $request->input('supporter');
             $supervisor = $request->input('supervisor');
             $limit_edit = $request->input('limit_edit');
             $user_edits = $request->input('user_edits_limit');
             $limit_view = $request->input('limit_view');
             $user_view = $request->input('user_view_limit');
             $show = $request->input('show');
             $subject_view = $request->input('subject_view');
             $subject_search = $request->input('subject_search');
             DB::table('tab_view')->where('sid', $sid)->delete();
             if (is_array($show) && count($show) > 0) {
                 foreach ($show as $key => $value) {
                     DB::table('tab_view')->insert(array('tabid' => $value, 'sid' => $sid));
                 }
             }
             $manager = (is_array($manager)) ? $manager[0] : '';
             $supporter = (is_array($supporter)) ? $supporter[0] : '';
             $supervisor = (is_array($supervisor)) ? $supervisor[0] : '';

             DB::table('subjects')->where('id', $sid)->update(array('manager' => $manager, 'supporter' => $supporter, 'supervisor' => $supervisor));
             if ($manager != '0' && $manager != '') {
                 DB::table('subject_member')->insert(array('uid' => $manager, 'sid' => $sid, 'follow' => '1'));
             }
             if ($supporter != '0' && $supporter != '') {
                 DB::table('subject_member')->insert(array('uid' => $supporter, 'sid' => $sid, 'follow' => '1'));
             }
             if ($supervisor != '0' && $supervisor != '') {
                 DB::table('subject_member')->insert(array('uid' => $supervisor, 'sid' => $sid, 'follow' => '1'));
             }
             if (intval(trim($limit_edit)) == 1 || $limit_edit = '"1"') {
                 DB::table('pages')->where('sid', $sid)->update(array('edit' => '1'));
                 if (is_array($user_edits)) {
                     $pages = DB::table('pages')->where('sid', $sid)->get();
                     foreach ($pages as $page) {
                         DB::table('page_limit_edit')->where('pid', $page->id)->delete();
                         foreach ($user_edits as $value) {
                             $value = trim($value, ' ');
                             if ($value != '') {
                                 DB::table('page_limit_edit')->insert(array('pid' => $page->id, 'uid' => $value));
                             }
                         }
                     }
                 }
             } else {
                 DB::table('pages')->where('sid', $sid)->update(array('edit' => '0'));
                 $pages = DB::table('pages')->where('sid', $sid)->get();
                 foreach ($pages as $page) {
                     DB::table('page_limit_edit')->where('pid', $page->id)->delete();
                 }
             }
             if (intval($limit_view) == 0) {
                 DB::table('pages')->where('sid', $sid)->update(array('view' => '0'));
                 if (is_array($user_view)) {
                     $pages = DB::table('pages')->where('sid', $sid)->get();
                     foreach ($pages as $page) {
                         DB::table('page_limit_view')->where('pid', $page->id)->delete();
                         foreach ($user_view as $value) {
                             $value = trim($value, ' ');
                             if ($value != '') {
                                 DB::table('page_limit_view')->insert(array('pid' => $page->id, 'uid' => $value));
                             }
                         }
                     }
                 }
             } else {
                 DB::table('pages')->where('sid', $sid)->update(array('view' => '1'));
                 $pages = DB::table('pages')->where('sid', $sid)->get();
                 foreach ($pages as $page) {
                     DB::table('page_limit_view')->where('pid', $page->id)->delete();
                 }
             }
             DB::table('subjects')->where('id', $sid)->update(array('list' => $subject_view, 'search' => $subject_search));
             $message = trans('labels.subjectAccessOK');
             return Redirect()->back()->with('message', $message)->with('mestype', 'success');

             $err = false;*/
            // $pc = new \App\HamafzaViewClasses\PageClass();
            // return $pc->update_Access($uid, $sesid, $sid, $pid, $manager, $supporter, $supervisor, $limit_edit, $user_edits, $limit_view, $user_view, $show, $subject_view, $subject_search);


            DB::table('tab_view')->where('sid', $sid)->delete();
            if (is_array($show) && count($show) > 0)
            {
                foreach ($show as $key => $value)
                {
                    DB::table('tab_view')->insert(array('tabid' => $value, 'sid' => $sid));
                }
            }


            $subject = Subject::find($sid);
            $subject->list = $subject_view;
            $subject->search = $subject_search;
            $subject->save();


            if ($subject)
            {

                if ($request->input('users_list_setting_view'))
                {
                    $users_list_setting_view = $request->input('users_list_setting_view');
                    foreach ($users_list_setting_view as $key => $value)
                    {
                        $users_list_setting_view_array[$value] = ['type' => '1'];
                    }

                    $subject->user_policies_view()->sync($users_list_setting_view_array);
                }
                else
                {
                    $subject->user_policies_view()->sync([]);
                }

                if ($request->input('roles_list_setting_view'))
                {
                    $roles_list_setting_view = $request->input('roles_list_setting_view');
                    foreach ($roles_list_setting_view as $key => $value)
                    {
                        $roles_list_setting_view_array[$value] = ['type' => '1'];
                    }
                    $subject->role_policies_view()->sync($roles_list_setting_view_array);
                }
                else
                {
                    $subject->role_policies_view()->sync([]);
                }


                if ($request->input('users_list_setting_edit'))
                {
                    $users_list_setting_edit = $request->input('users_list_setting_edit');
                    foreach ($users_list_setting_edit as $key => $value)
                    {
                        $users_list_setting_edit_array[$value] = ['type' => '2'];
                    }
                    $subject->user_policies_edit()->sync($users_list_setting_edit_array);
                }
                else
                {
                    $subject->user_policies_edit()->sync([]);
                }

                if ($request->input('roles_list_setting_edit'))
                {
                    $roles_list_setting_edit = $request->input('roles_list_setting_edit');
                    foreach ($roles_list_setting_edit as $key => $value)
                    {
                        $roles_list_setting_edit_array[$value] = ['type' => '2'];
                    }
                    $subject->role_policies_edit()->sync($roles_list_setting_edit_array);
                }
                else
                {
                    $subject->role_policies_edit()->sync([]);
                }
            }
            $message = trans('labels.subjectAccessOK');
            return json_encode($message);

        }

    }

    public function update_subject(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $pid = $request->input('pid');
            $subject_help = $request->input('subject_help');
            $subject_pid = $request->input('subject_pid');
            $sid = $request->input('sid');
            $subject_title = $request->input('subject_title');
            $PS_keywords = $request->input('PS_keywords');
            $field = $request->input('field');
            $TT_ttype = $request->input('TT_ttype');
            $field_type = $request->input('type');
            $tt = '';
            $fields = array();
            $i = 1;
            $tt = json_encode($field_type);
            $pc = new \App\HamafzaViewClasses\PageClass();
            return $pc->update_subject($uid, $sesid, $sid, $subject_title, $PS_keywords, $field, $tt, $subject_help, $subject_pid);
        }
    }

    public function AddSubject(Request $request)
    {

        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            if (isset($request->sectype) && $request->sectype == 1)
            {

                if (!policy_CanView($request->Skind, '\App\Models\hamafza\SubjectType', '\App\Policies\SubjectPolicy', 'canAddOfficial'))
                {
                    return abort(403);
                }
            }
            elseif (isset($request->sectype) && $request->sectype == 0)
            {
                if (!policy_CanView($request->Skind, '\App\Models\hamafza\SubjectType', '\App\Policies\SubjectPolicy', 'canAddPersonal'))
                {
                    return abort(403);
                }
            }

            $validator = \Validator::make($request->all(), [
                'title' => 'required',
            ]);
            //DB::enableQueryLog();
            if ($validator->fails())
            {
                $result['error'] = $validator->errors();
                $result['success'] = false;
                return json_encode($result);
            }
            else
            {
                $uid = (session('uid') != '') ? session('uid') : 0;
                $sesid = (session('sesid') != '') ? session('sesid') : 0;
                $title = $request->input('title');
                $kind = $request->input('kind');
                $tem = $request->input('tem');
                $ispublic = $request->input('IsPublic');
                $Framework = $request->input('Framework');
                $field = $request->input('field');
                $TT_ttype = $request->input('TT_ttype');
                $field_type = $request->input('type');
                $keywords = $request->input('keywords');
                $submit = $request->input('submit');

                $users_list_subject_view = $request->input('users_list_subject_view');
                $roles_list_subject_view = $request->input('roles_list_subject_view');
                $users_list_subject_edit = $request->input('users_list_subject_edit');
                $roles_list_subject_edit = $request->input('roles_list_subject_edit');
                $keywords_list_subject = $request->input('keywords_list_subject');

                $tt = '';
                $fields = array();
                $i = 1;
                if (is_array($field_type))
                {
                    foreach ($field_type as $key => $val)
                    {
                        $fields[$i]['type'] = $val;
                        $i++;
                    }
                }
                $tt = $field_type;
                $Skind = $request->input('SKIND');
                $SP = new SubjectsClass();
                $user = $SP->AddSubject($keywords_list_subject, $roles_list_subject_edit, $users_list_subject_edit, $roles_list_subject_view, $users_list_subject_view, $uid, $sesid, $title, $tem, $kind, $Framework, $ispublic, $field, $TT_ttype, $tt, $Skind, $keywords);
                $id = $user['id'];
                $data = $user;
                $ShowEdit = $user['ShowEdit'];
                $Alert = $user['Alert'];

                score_unregister('App\Models\hamafza\Subject', $id / 10, config('score.8'));

                return json_encode($data);


                if (trim($submit) == 'ایجاد')
                {
                    session('NewAlert', $Alert);
                    $re = \App\HamafzaPublicClasses\FunctionsClass::CratePagelink($id, false);
                    return Redirect()->to($re)->with('NewAlert', $Alert);
                }
                else
                {
                    return Redirect()->route('page.edit', ['id' => $id, 'type' => 'text'])->with('NewAlert', $Alert);
                }
            }
        }
    }

    public function measure_sendReport(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $gozaresh = $request->input('gozaresh');
            $pishraft = $request->input('pishraft');
            $finish = $request->input('finish');
            $aid = $request->input('aid');
            $arid = $request->input('arid');
            $SP = new \App\HamafzaServiceClasses\MeasureClass();
            $menu = $SP->measure_sendReport($uid, $sesid, $gozaresh, $pishraft, $finish, $aid, $arid);
            return Redirect()->back()->with('message', $menu)->with('mestype', 'success');
        }
    }

    public function form_edit(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $Uname = (session('Uname') != '') ? session('Uname') : 0;
            $form_name = $request->input('form_name');
            $form_type = $request->input('form_type');
            $form_help = $request->input('form_help');
            $column = $request->input('column');
            $field_name = $request->input('field_name');
            $field_type = $request->input('field_type');
            $field_value = $request->input('field_value');
            $requires = $request->input('requires');
            $question = $request->input('SelType');
            $did = $request->input('did');
            $form_id = $request->input('form_id');
            $level = $request->input('level');
            $one = $request->input('one');
            $before_start = $request->input('before_start');
            $after_end = $request->input('after_end');
            $isdraft = ($request->input('newform') == 'تایید') ? 0 : 1;
            $MC = new FormClass();
            $after_end = $request->input('after_end');
            $MC = new FormClass();
            $mc = $MC->EditForm($uid, $sesid, $form_name, $form_type, $form_help, $column, $field_name, $field_type, $field_value, $requires, $question, $did, $form_id, $level, $one, $isdraft, $before_start, $after_end);
            return Redirect()->to($Uname . '/desktop/form_list/all')->with('message', $mc)->with('mestype', 'success');
        }
    }

    public function form_add(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $Uname = (session('Uname') != '') ? session('Uname') : 0;
            $form_name = $request->input('form_name');
            $form_type = $request->input('form_type');
            $form_help = $request->input('form_help');
            $column = $request->input('column');
            $field_name = $request->input('field_name');
            $field_type = $request->input('field_type');
            $field_value = $request->input('field_value');
            $before_start = $request->input('before_start');
            $after_end = $request->input('after_end');
            $requires = $request->input('requires');
            $question = $request->input('SelType');
            $level = $request->input('level');
            $start = $request->input('start');
            $one = $request->input('one');
            $pages = $request->input('pages');
            $isdraft = ($request->input('newform') == 'تایید') ? 0 : 1;
            if ($start != '')
            {
                $myArray = explode('-', $start);
                $date = $myArray[0];
                $time = $myArray[1];
                $myArray = explode('/', $date);
                $edate1 = jDateTime::toGregorian($myArray[0], $myArray[1], $myArray[2]);
                $mohlat = $edate1[0] . '/' . $edate1[1] . '/' . $edate1[2];
                $start = $mohlat . ' ' . $time;
            }
            $end = $request->input('end');
            if ($end != '')
            {
                $myArray = explode('-', $end);
                $date = $myArray[0];
                $time = $myArray[1];
                $myArray = explode('/', $date);
                $edate1 = jDateTime::toGregorian($myArray[0], $myArray[1], $myArray[2]);
                $mohlat = $edate1[0] . '/' . $edate1[1] . '/' . $edate1[2];
                $end = $mohlat . ' ' . $time;
            }
            $user_submit = $request->input('user_submit');
            $user_view = $request->input('user_view');
            $user_edit = $request->input('user_edit');
            $MC = new FormClass();
            $mc = $MC->ADDForm($uid, $sesid, $form_name, $form_type, $form_help, $column, $field_name, $field_type
                , $field_value, $requires, $question, $level, $user_submit, $user_view, $user_edit, $end, $start, $pages, $one, $isdraft, $before_start, $after_end);
            return Redirect()->to($Uname . '/desktop/form_list/all')->with('message', $mc)->with('mestype', 'success');
        }
    }

    public function saveForm(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $field = $request->input('field');
            $type = $request->input('type');
            $form_id = $request->input('form_id');
            $pid = $request->input('pid');
            $sid = $request->input('sid');
            $files = $request->file('file');
            $rpid = $request->input('repid');
            $UpFiles = array();
            if (is_array($files))
            {
                foreach ($files as $key => $file)
                {
                    if ($file)
                    {
                        if ($file->isValid())
                        {
                            $tmpFilePath = 'files/forms/';
                            $extension = $file->getClientOriginalExtension();
                            $tmpFileName = $uid . $key . time() . '.' . $extension; // renameing image
                            $img = IImage::make($file->getRealPath());
                            $img->resize(550, null, function ($constraint)
                            {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });
                            $img->save('files/forms/' . $tmpFileName)->destroy();
                            $field[$key] = $tmpFileName;
                        }
                    }
                }
            }
            $s = ConfigurationClass::saveNewForm($uid, $sesid, $form_id, $field, $type, $pid, $sid);
            return Redirect()->back()->with('message', $s)->with('mestype', 'success');
        }
    }

    public function report_save(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $field = $request->input('field');
            $type = $request->input('type');
            $form_id = $request->input('form_id');
            $pid = $request->input('pid');
            $sid = $request->input('sid');
            $files = $request->file('file');
            $rpid = $request->input('repid');
            $UpFiles = array();
            if (is_array($files))
            {
                foreach ($files as $key => $file)
                {
                    if ($file)
                    {
                        if ($file->isValid())
                        {
                            $tmpFilePath = 'files/forms/';
                            $extension = $file->getClientOriginalExtension();
                            $tmpFileName = $uid . $key . time() . '.' . $extension; // renameing image
                            $img = IImage::make($file->getRealPath());
                            $img->resize(550, null, function ($constraint)
                            {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });
                            $img->save('files/forms/' . $tmpFileName)->destroy();
                            $field[$key] = $tmpFileName;
                        }
                    }
                }
            }
            $s = ConfigurationClass::saveForm($uid, $sesid, $form_id, $field, $type, $pid, $sid, $rpid);
            return Redirect()->back()->with('message', $s)->with('mestype', 'success');
        }
    }

    public function UserSave(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $editid = $request->input('editid');
            $user_name = $request->input('user_name');
            $user_family = $request->input('user_family');
            $user_summary = $request->input('user_summary');
            $comment = $request->input('comment');
            $user_gender = $request->input('user_gender');
            $user_byear = $request->input('user_byear');
            $user_mobile = $request->input('user_mobile');
            $tel_number = $request->input('tel_number');
            $tel_code = $request->input('tel_code');
            $fax_number = $request->input('fax_number');
            $fax_code = $request->input('fax_code');
            $user_website = $request->input('user_website');
            $user_mail = $request->input('user_mail');
            $user_Uname = $request->input('user_Uname');
            $user_pass = $request->input('user_pass');
            $secgroup = $request->input('secgroup');
            $file = $request->file('user_pic');
            $tmpFileName = '';
            if ($file)
            {
                if ($file->isValid())
                {
                    $tmpFilePath = 'pics/user/';
                    $extension = $file->getClientOriginalExtension();
                    $tmpFileName = $uid . time() . '.' . $extension; // renameing image
                    $img = IImage::make($file->getRealPath());
                    $img->resize(450, null, function ($constraint)
                    {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $img->save('pics/user/' . $tmpFileName)->destroy();
                    $tmpFileName = $tmpFileName;
                }
            }
            $editid = $request->input('work');
            $user_gender = $request->input('user_gender');
            $user_byear = $request->input('user_byear');
            $user_mobile = $request->input('user_mobile');
            $tel_number = $request->input('tel_number');
            $tel_code = $request->input('tel_code');
            $fax_number = $request->input('fax_number');
            $fax_code = $request->input('fax_code');
            $user_website = $request->input('user_website');
            $user_mail = $request->input('user_mail');
            $user_Uname = $request->input('user_Uname');
            $user_pass = $request->input('user_pass');
            $secgroup = $request->input('secgroup');
            $SP = new LoginClass();
            $menu = $SP->UserSave($uid, $sesid, $editid, $user_name, $user_family, $user_summary, $comment, $user_gender, $user_byear, $user_mobile, $tel_number, $tel_code, $fax_number, $fax_code, $user_website, $user_mail, $user_Uname, $user_pass, $secgroup, $file);
            return Redirect()->back()->with('message', $menu)->with('mestype', 'success');
        }
    }

    public function AlertSave(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $alertid = PublicClass::Filter($request->input('alertid'));
            $alert_title = PublicClass::Filter($request->input('alert_name'));
            $descr = $request->input('descr');
            $SP = new ConfigurationClass();
            $menu = $SP->AlertSave($uid, $sesid, $alertid, $alert_title, $descr);
            return Redirect()->back()->with('message', $menu)->with('mestype', 'success');
        }
    }

    public function SaveDepartments(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $name = $request->input('name');
            $pid = $request->input('pid');
            $SP = new ConfigurationClass();
            $menu = $SP->SaveDepartments($name, $pid);
            return Redirect()->back()->with('message', $menu)->with('mestype', 'success');
        }
    }

    public function subst_save(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $first = $request->input('first');
            $second = $request->input('second');
            $id = $request->input('substid');
            return substclass::subst_save($id, $first, $second, $uid);
        }
    }

    public function UserSecSave(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $editid = $request->input('editid');
            $secgroup_name = $request->input('secgroup_name');
            $descr = $request->input('descr');
            $defualt = $request->input('defualt');
            $Access = $request->input('Access');
            $ACL = $request->input('ACL');
            $SP = new ConfigurationClass();
            $menu = $SP->UserSecSave($uid, $sesid, $editid, $secgroup_name, $descr, $defualt, $Access, $ACL);
            return Redirect()->back()->with('message', $menu)->with('mestype', 'success');
        }
    }

    public function SubjectTypeSave(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $editid = $request->input('editid');
            $name = $request->input('name');
            $department = $request->input('department');
            $department_select = $request->input('manager_select');
            $department_require = $request->input('manager_require');
            $pretitle = $request->input('pretitle');
            $keywords = $request->input('keywords');
            $tag_select = $request->input('tag_select');
            $tag_require = $request->input('tag_require');
            $manager_title = $request->input('manager_title');
            $manager_id = $request->input('manager_id');
            $writer_title = $request->input('writer_title');
            $manager_select = $request->input('manager_select');
            $manager_require = $request->input('manager_require');
            $supervisor_title = $request->input('supervisor_title');
            $supervisor_id = $request->input('supervisor_id');
            $supervisor_select = $request->input('supervisor_select');
            $supervisor_require = $request->input('supervisor_require');
            $supporter_title = $request->input('supporter_title');
            $supporter_id = $request->input('supporter_id');
            $supporter_select = $request->input('supporter_select');
            $supporter_require = $request->input('supporter_require');
            $process = $request->input('process');
            $proc_select = $request->input('proc_select');
            $proc_require = $request->input('proc_require');
            $ViewAlert = $request->input('ViewAlert');
            $editalertshow = $request->input('editalertshow');
            $EditAlert = $request->input('EditAlert');

            $field_type = $request->input('field_type');
            $field_name = $request->input('field_name');
            $field_descr = $request->input('field_descr');
            $requires = $request->input('requires');
            $field_defval = $request->input('field_defval');

            $charchoob = $request->input('charchoob');
            $users_public = $request->input('users_list_subject_type_public');
            $roles_public = $request->input('roles_list_subject_type_public');
            $users_private = $request->input('users_list_subject_type_private');
            $roles_private = $request->input('roles_list_subject_type_private');
            $help = $request->input('help');
            $comment = $request->input('comment');
            $tab_name = $request->input('tab_name');
            $tab_type = $request->input('tab_type');
            $tab_first = $request->input('tab_first');
            $tab_view = $request->input('tab_view');
            $tab_tem = $request->input('tab_tem');
            $tab_id = $request->input('tab_id');
            $tab_tid = $request->input('tab_tid');
            for ($i = 1; $i <= 10; $i++)
            {
                if (!array_key_exists($i, $tab_view))
                {
                    $tab_view[$i] = 0;
                }
            }
            ksort($tab_view);
            $del_did = $request->input('del_did');
            if ($del_did)
            {
                for ($i = 1; $i <= 10; $i++)
                {
                    if (!array_key_exists($i, $del_did))
                    {
                        $del_did[$i] = 0;
                    }
                }
                ksort($del_did);
                $tab_del_did = $del_did;
            }
            else
            {
                $tab_del_did = '';
            }
            foreach ($tab_tem as $key => $value)
            {
                $tab_tem[$key] = preg_replace("/'/", '"', $value);
            }
            $SP = new ConfigurationClass();

            $menu = $SP->SubjectTypeSave($tab_id, $tab_del_did, $editid, $uid, $name, $department, $field_descr, $tab_tem, $department_select, $department_require, $pretitle, $keywords, $tag_select, $tag_require, $manager_title, $manager_id, $manager_select, $manager_require, $supervisor_title, $supervisor_id, $supervisor_select, $supervisor_require, $supporter_title, $supporter_id, $supporter_select, $supporter_require, $process, $proc_select, $proc_require, $help, $ViewAlert, $editalertshow, $EditAlert, $field_type, $requires, $charchoob, $users_public, $roles_public, $users_private, $roles_private, $comment, $tab_name, $tab_type, $tab_first, $tab_view, $tab_tid, $writer_title, $field_name, $field_defval);
            return Redirect()->back()->with('message', $menu)->with('mestype', 'success');
        }
    }

}
