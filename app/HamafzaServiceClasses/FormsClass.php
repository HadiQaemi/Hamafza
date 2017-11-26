<?php

namespace App\HamafzaServiceClasses;

use Request;
use Illuminate\Support\Facades\DB;

class FormsClass
{

    public function FiledType()
    {
        $field_type = array(
            'text' => 'متن کوتاه',
            'textarea' => 'متن طولانی',
            'number' => 'عدد',
            'email' => 'رایانامه',
            'mellicode' => 'کد ملی',
            'mobile' => 'تلفن همراه',
            'tel' => 'تلفن ثابت',
            'score' => 'امتیاز',
            'select' => 'چندگزینه ای: کرکره ای',
            'radio' => 'چندگزینه ای: رادیویی',
            'checkbox' => 'چندگزینه ای: چک باکس',
            'users' => 'کاربران',
            'persons' => 'کاربر و غیره',
            'hyperlink' => 'ابر لینک',
            'datapicker' => 'تاریخ: روز- ماه- سال',
            'datapicker2' => 'تاریخ:ماه ',
            'datapicker3' => 'تاریخ:سال ',
            'KEYWORD_11' => 'کلیدواژه، کاربر',
            'KEYWORD_12' => 'کلیدواژه، سازمان',
            'KEYWORD_13' => 'کلیدواژه، شهر',
            'KEYWORD_14' => 'کلیدواژه، استان',
            'KEYWORD_15' => 'کلیدواژه، توصیفی',
            'KEYWORD_16' => 'کلیدواژه، دانشگاه',
            'KEYWORD_17' => 'کلیدواژه، تخصص',
        );
        return $field_type;
    }

    public function GetFileds($uid, $sesid = 0)
    {
        $field_type = array(
            'text' => 'متن کوتاه',
            'textarea' => 'متن طولانی',
            'number' => 'عدد',
            'email' => 'رایانامه',
            'mellicode' => 'کد ملی',
            'mobile' => 'تلفن همراه',
            'tel' => 'تلفن ثابت',
            'score' => 'امتیاز',
            'select' => 'چندگزینه ای: کرکره ای',
            'radio' => 'چندگزینه ای: رادیویی',
            'checkbox' => 'چندگزینه ای: چک باکس',
            'users' => 'کاربران',
            'persons' => 'کاربر و غیره',
            'hyperlink' => 'ابر لینک',
            'datapicker' => 'تاریخ: روز- ماه- سال',
            'datapicker2' => 'تاریخ:ماه ',
            'datapicker3' => 'تاریخ:سال ',
            'KEYWORD_11' => 'کلیدواژه، کاربر',
            'KEYWORD_12' => 'کلیدواژه، سازمان',
            'KEYWORD_13' => 'کلیدواژه، شهر',
            'KEYWORD_14' => 'کلیدواژه، استان',
            'KEYWORD_15' => 'کلیدواژه، توصیفی',
            'KEYWORD_16' => 'کلیدواژه، دانشگاه',
            'KEYWORD_17' => 'کلیدواژه، تخصص',
        );
        $Type = array();
        foreach ($field_type as $key => $value)
        {
            $s['type'] = $key;
            $s['name'] = $value;
            array_push($Type, $s);
        }

        $Fileds = DB::table('fields as d')
            ->where('d.id', '>', '0')
            ->select('d.field_Desc', 'd.id as did', 'd.field_name', 'd.field_type', 'd.orders')
            ->orderBy('d.orders')->get();

        foreach ($Fileds as $value)
        {
            $Rets = DB::table('fields_value as v')
                ->where('v.field_id', $value->did)
                ->select('v.id as vid', 'v.field_value')
                ->orderBy('v.orders')->get();
            $value->values = $Rets;
        }

        $Ret['Type'] = $Type;
        $Ret['Fields'] = $Fileds;
        return $Ret;
    }

    public static function CheckFormAccess($uid, $fid, $acc)
    {
        $isp = DB::table('form_access')->where('form_id', $fid)->where('actype', $acc)->count();
        if ($isp > 0)
        {
            $cns = DB::table('forms')->where('admin', $uid)->where('id', $fid)->select('id')->count();
            $cn = DB::table('form_access')->where('uid', $uid)->where('form_id', $fid)->where('actype', $acc)->count();
            return ($cns > 0 || $cn > 0) ? true : false;
        }
        else
        {
            return true;
        }
    }

    public function saveForm($uid, $sesid, $form_id, $field, $type, $pid, $sid)
    {
        $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
        $field = json_decode($field, true);
        $type = json_decode($type, true);
        $cn = DB::table('forms')->where('id', $form_id)->select('onereport')->first();
        $cns = ($cn) ? $cn->onereport : 0;
        if ($cns == 1)
        {
            $n = DB::table('forms_report')
                ->where('uid', $uid)->where('form_id', $form_id)->count();
            if ($n == 0)
            {
                $Forms = DB::table('forms_report')
                    ->insertGetId(
                        [
                            'uid' => $uid,
                            'form_id' => $form_id,
                            'pid' => $pid,
                            'sid' => $sid,
                            'ppsid' => '0',
                            'reg_date' => $reg_date,
                            'publish' => '1'
                        ]
                    );

                foreach ($field as $key => $value)
                {
                    DB::table('forms_report_value')
                        ->insertGetId(
                            [
                                'report_id' => $Forms,
                                'field_id' => $key,
                                'field_value' => $value
                            ]
                        );
                }
            }
            else
            {
                DB::table('forms_report')
                    ->where('uid', $uid)
                    ->where('form_id', $form_id)
                    ->delete();
                $Forms = DB::table('forms_report')
                    ->insertGetId(
                        [
                            'uid' => $uid,
                            'form_id' => $form_id,
                            'pid' => $pid,
                            'sid' => $sid,
                            'ppsid' => '0',
                            'reg_date' => $reg_date,
                            'publish' => '1'
                        ]
                    );

                foreach ($field as $key => $value)
                {
                    DB::table('forms_report_value')
                        ->insertGetId(
                            [
                                'report_id' => $Forms,
                                'field_id' => $key,
                                'field_value' => $value
                            ]
                        );
                }
            }
        }
        else
        {
            $Forms = DB::table('forms_report')->insertGetId(array('uid' => $uid, 'form_id' => $form_id, 'pid' => $pid,
                'sid' => $sid, 'ppsid' => '0', 'reg_date' => $reg_date, 'publish' => '1'));
            foreach ($field as $key => $value)
            {
                DB::table('forms_report_value')->insertGetId(array('report_id' => $Forms, 'field_id' => $key, 'field_value' => $value));
            }
        }

        return 'اطلاعات شما ثبت گردید.';
    }

    public function ViewFrom($uid, $sesid, $formid)
    {
        $cn = FormsClass::CheckFormAccess($uid, $formid, 2);
        if ($cn)
        {
            $form_add = array();
            $levels = array();
            $levels[0] = 0;
            $Forms = DB::table('forms')
                ->where('id', $formid)
                ->select(DB::RAW('title'))->first();
            $form_add['Form']['title'] = $Forms->title;
            $Forms = DB::table('forms as f')
                ->leftJoin('forms_field as d', 'f.id', '=', 'd.form_id')
                ->leftJoin('forms_field_value as v', 'd.id', '=', 'v.field_id')
                ->where('f.id', $formid)
                ->orderBy('d.orders')
                ->orderBy('v.orders')
                ->orderBy('v.id')
                ->select(DB::RAW('f.id as fid, f.title, f.help, f.col, d.id as did, d.field_name, d.field_type, d.requires, d.scores, v.id as vid, v.field_value,d.level,d.question'))
                ->get();
            $i = 0;
            foreach ($Forms as $value)
            {
                $form_add['fid'] = $value->fid;
                $form_add['title'] = $value->title;
                $form_add['help'] = $value->help;
                $form_add['col'] = $value->col;
                $width = round(100 / $value->col);
                $form_add['did'][$value->did] = $value->did;
                $form_add['question'][$value->did] = $value->question;
                $form_add['form_level'][$value->did] = $value->level;
                $form_add['field_name'][$value->did] = $value->field_name;
                $form_add['field_type'][$value->did] = $value->field_type;
                $form_add['requires'][$value->did] = $value->requires;
                $form_add['field_value'][$value->did][$value->vid] = $value->field_value;
                if (!in_array($value->level, $levels))
                {
                    $levels[$i] = $value->level;
                    $i++;
                }
            }
            $form_add['levels'] = $levels;
            $err = false;
            return $form_add;
        }
        return response()->json(array(
            'error' => true,
            'data' => 'شما اجازه پاسخدهی ندارید'), 200
        );
    }

    public function ViewFromReport($uid, $sesid, $formid, $repid)
    {
        $form_add = array();
        $Forms = DB::table('forms_report as r')
            ->leftJoin('forms as f', 'f.id', '=', 'r.form_id')
            ->leftJoin('user as u', 'r.uid', '=', 'u.id')
            ->where('r.form_id', $formid)->where('r.id', $repid)
            ->select(DB::RAW('r.id , r.uid , r.form_id , r.pid , r.sid , r.ppsid , r.reg_date , u.Name , u.Family , u.Email , f.title,u.Uname'))->first();

        $form_add['Form']['title'] = $Forms->title;
        $form_add['Form']['user'] = $Forms->Name . ' ' . $Forms->Family;
        $form_add['Form']['uname'] = $Forms->Uname;

        $Forms = DB::table('forms_report as r')
            ->leftJoin('forms_report_value as v', 'r.id', '=', 'v.report_id')
            ->where('r.id', $repid)
            ->select(DB::RAW('r.id, r.form_id, v.field_id, v.check_id, v.field_value'))->get();

        foreach ($Forms as $value)
        {
            $form_add['field_val'][$value->field_id][$value->check_id] = $value->field_value;
        }

        $Forms = DB::table('forms as f')->leftJoin('forms_field as d', 'f.id', '=', 'd.form_id')
            ->leftJoin('forms_field_value as v', 'd.id', '=', 'v.field_id')
            ->join('forms_report as fr', 'fr.form_id', '=', 'f.id')
            ->join('user as u', 'fr.uid', '=', 'u.id')
            ->where('f.id', $formid)->orderBy('d.orders')->orderBy('v.orders')->select(DB::RAW('CONCAT(u.Name," ",u.Family )	as uname,	f.id as fid, f.title, f.help, f.col, d.id as did, d.field_name, d.field_type, d.requires, d.scores, v.id as vid, v.field_value'))->get();
        foreach ($Forms as $value)
        {
            $form_add['fid'] = $value->fid;
            $form_add['title'] = $value->title;
            $form_add['help'] = $value->help;
            $form_add['col'] = $value->col;
            $width = round(100 / $value->col);
            $form_add['Reg'] = $value->uname;
            $form_add['did'][$value->did] = $value->did;
            $form_add['field_name'][$value->did] = $value->field_name;
            $form_add['field_type'][$value->did] = $value->field_type;
            $form_add['requires'][$value->did] = $value->requires;
            $form_add['field_value'][$value->did][$value->vid] = $value->field_value;
        }
        $err = false;
        return $form_add;
    }

    public function ViewFromReports($uid, $sesid, $formid)
    {
        $cn = FormsClass::CheckFormAccess($uid, $formid, 2);
        if ($cn)
        {
            $form_add = array();
            $Forms = DB::table('forms_report as r')
                ->leftJoin('forms as f', 'f.id', '=', 'r.form_id')
                ->leftJoin('user as u', 'r.uid', '=', 'u.id')
                ->where('r.form_id', $formid)
                ->select(DB::RAW('r.id , r.uid , r.form_id , r.pid , r.sid , r.ppsid , r.reg_date , u.Name , u.Family , u.Email , f.title,u.Uname'))->first();
            $form_add['Form']['title'] = $Forms->title;
            $form_add['Form']['user'] = $Forms->Name . ' ' . $Forms->Family;
            $form_add['Form']['uname'] = $Forms->Uname;
            $Forms = DB::table('forms_report as r')
                ->leftJoin('forms_report_value as v', 'r.id', '=', 'v.report_id')
                ->leftJoin('user as u', 'u.id', '=', 'r.uid')
                ->where('r.form_id', $formid)
                ->select(DB::RAW('r.id as reportid, r.form_id, v.field_id, v.check_id, v.field_value,r.uid,u.Name,u.Family,u.Uname,r.reg_date'))->groupBy('r.id')->get();

            foreach ($Forms as $value)
            {
                $reg_date = \Morilog\Jalali\jDate::forge($value->reg_date)->format('%Y/%m/%d');

                $form_add['field_val'][$value->reportid] [$value->field_id] = $value->field_value;
                $form_add['users'][$value->reportid]['Name'] = $value->Name;
                $form_add['users'][$value->reportid]['Family'] = $value->Family;
                $form_add['users'][$value->reportid]['Uname'] = $value->Uname;
                $form_add['users'][$value->reportid]['Date'] = $reg_date;
            }
            $Forms = DB::table('forms_report as r')
                ->leftJoin('forms_report_value as v', 'r.id', '=', 'v.report_id')
                ->leftJoin('user as u', 'u.id', '=', 'r.uid')
                ->where('r.form_id', $formid)
                ->select(DB::RAW('r.id as reportid, r.form_id, v.field_id, v.check_id, v.field_value,r.uid,u.Name,u.Family,u.Uname,r.reg_date'))->get();
            foreach ($Forms as $value)
            {
                $form_add['field_val'][$value->reportid] [$value->field_id] = $value->field_value;
            }
            $Forms = DB::table('forms as f')
                ->leftJoin('forms_field as d', 'f.id', '=', 'd.form_id')
                ->leftJoin('forms_field_value as v', 'd.id', '=', 'v.field_id')
                ->join('forms_report as fr', 'fr.form_id', '=', 'f.id')
                ->join('user as u', 'fr.uid', '=', 'u.id')
                ->where('f.id', $formid)
                ->orderBy('d.orders')
                ->orderBy('v.orders')
                ->select(DB::RAW('CONCAT(u.Name," ",u.Family )	as uname,	f.id as fid, f.title, f.help, f.col, d.id as did, d.field_name, d.field_type, d.requires, d.scores, v.id as vid, v.field_value'))->get();
            foreach ($Forms as $value)
            {
                $form_add['fid'] = $value->fid;
                $form_add['title'] = $value->title;
                $form_add['help'] = $value->help;
                $form_add['col'] = $value->col;
                $width = round(100 / $value->col);
                $form_add['Reg'] = $value->uname;
                $form_add['did'][$value->did] = $value->did;
                $form_add['field_name'][$value->did] = $value->field_name;
            }
            $message = $form_add;
            $err = false;
        }
        elseif (!$cn)
        {
            $message = 'عدم دسترسی ';
            $err = true;
        }
        else
        {
            $message = trans('labels.FailUser');
            $err = true;
        }
        return $message;
    }

    public function ViewReportValue($uid, $sesid, $id)
    {
        $user = UserClass::CheckLogin($uid, $sesid);
        if ($user)
        {
            $Forms = DB::table('forms as f')
                ->leftJoin('forms_report as r', 'f.id', '=', 'r.form_id')
                ->leftJoin('subjects as s', 'r.sid', '=', 's.id')
                ->leftJoin('pages as p', 's.id', '=', 'p.sid')
                ->leftJoin('user as u', 'r.uid', '=', 'u.id')
                ->where('f.id', $id)
                ->groupBy('r.id')
                ->orderBy('r.reg_date', 'desc')
                ->select(DB::RAW('DISTINCT r.pid,r.id as rid, f.id, f.admin, f.title , r.reg_date, u.Name, u.Family , count(*) as nr , ifnull(r.id, 0) as n,s.title as  stitle,p.id as psid,u.Uname'))->get();
            $i = 1;
            foreach ($Forms as $value)
            {
                $value->sortid = $i;
                $value->edit = $i;
                $value->copy = $i;
                $value->del = $i;
                $value->reg_date = \Morilog\Jalali\jDate::forge($value->reg_date)->format('%Y/%m/%d');
                $i++;
            }
            $message = $Forms;
            $err = false;
        }
        else
        {
            $message = trans('labels.FailUser');
            $err = true;
        }
        return response()->json(['error' => $err, 'data' => $message], 200);
    }

    public function EditForm(
        $form_id, $uid, $session_id, $form_name, $form_type, $form_help, $column, $field_name, $field_type
        , $field_value, $requires, $question, $did, $level, $one, $isdraft, $before_start, $after_end)
    {
        $user = UserClass::CheckLogin($uid, $session_id);
        if ($user)
        {
            $one = ($one != '') ? 1 : 0;
            $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
            DB::table('forms')
                ->where('id', $form_id)
                ->update(
                    [
                        'before_start' => $before_start,
                        'after_end' => $after_end,
                        'title' => $form_name,
                        'type' => $form_type,
                        'col' => $column,
                        'help' => $form_help,
                        'onereport' => $one,
                        'isdraft' => $isdraft
                    ]
                );
            $field_name = explode(',', $field_name);
            $field_type = explode(',', $field_type);
            $field_value = explode(',', $field_value);
            $requires = explode(',', $requires);
            $level = explode(',', $level);
            $did = explode(',', $did);
            foreach ($field_name as $key => $value)
            {
                if (trim($value) != '')
                {
                    $field_typeR = $field_type[$key];
                    $field_valueR = $field_value[$key];
                    $didR = (is_array($did) && array_key_exists($key, $did)) ? $did[$key] : 0;
                    if (is_array($requires) && array_key_exists($key, $requires))
                    {
                        $requiresR = $requires[$key];
                    }
                    if ($requiresR == 'on')
                    {
                        $requiresR = '1';
                    }
                    else
                    {
                        $requiresR = '0';
                    }
                    $questionR = (is_array($question) && array_key_exists($key, $question)) ? $question[$key] : 1;
                    $nums = DB::table('forms_report_value')->where('field_id', $didR)->count();
                    DB::table('forms_field')->where('id', $didR)->update(
                        array('field_name' => $value, 'orders' => $key, 'requires' => $requiresR, 'field_type' => $field_typeR, 'level' => $level[$key]));
                    DB::table('forms_field_value')->where('field_id', $didR)->delete();
                    $field_values = explode('|', $field_valueR);
                    if (is_array($field_values) && count($field_values))
                    {
                        foreach ($field_values as $k => $v)
                        {
                            if (trim($v) != '')
                            {
                                DB::table('forms_field_value')->insertGetId(
                                    array('field_id' => $didR, 'field_value' => trim($v)));
                            }
                        }
                    }
                    if ($didR == '0')
                    {
                        $field_id = DB::table('forms_field')->insertGetId(
                            array('form_id' => $form_id, 'field_name' => $value, 'field_type' => $field_typeR, 'orders' => $key,
                                'requires' => $requiresR, 'question' => $questionR, 'level' => $level[$key]));

                        $field_values = explode('|', $field_valueR);
                        foreach ($field_values as $k => $v)
                        {
                            if (trim($v) != '')
                            {
                                DB::table('forms_field_value')->insertGetId(
                                    array('field_id' => $field_id, 'field_value' => $v));
                            }
                        }
                    }
                }
            }
            $message = 'فرم ویرایش شد';
            $err = false;
        }
        else
        {
            $message = trans('labels.FailUser');
            $err = true;
        }
        return $message;
    }

    public static function DeleteFormField($fid)
    {
        DB::table('forms_field')->where('id', $fid)->delete();
        DB::table('forms_field_value')->where('field_id', $fid)->delete();
        DB::table('forms_report_value')->where('field_id', $fid)->delete();
    }

    public static function DeleteForm($fid, $uid)
    {
        $cn = FormsClass::CheckFormAccess($uid, $fid, 3);
        $cn2 = DB::table('forms')->where('admin', $uid)->where('id', $fid)->select('id')->count();
        if ($cn || $cn > 0)
        {
            $field = DB::table('forms_field as d')
                ->where('d.form_id', $fid)
                ->select('d.id as did')->get();
            foreach ($field as $value)
            {
                DB::table('forms_field_value')->where('field_id', $value->did)->delete();
            }
            DB::table('forms_field')->where('form_id', $fid)->delete();
            DB::table('forms')->where('id', $fid)->delete();
            return 'حذف انجام شد';
        }
        else
        {
            return 'شما دسترسی حذف ندارید';
        }
    }

    public function GetForm($fid, $uid)
    {
        $cn = FormsClass::CheckFormAccess($uid, $fid, 3);
        if ($cn)
        {
            $Form = DB::table('forms as f')
                ->where('f.id', $fid)
                ->select(DB::RAW('f.id as fid, f.title, f.type, f.col, f.help,f.start_time,f.end_time,onereport,isdraft,before_start,after_end'))
                ->first();
            if ($Form)
            {
                $Form->end_time = \Morilog\Jalali\jDate::forge($Form->end_time)->format('%Y/%m/%d - H:i');
                $Form->start_time = \Morilog\Jalali\jDate::forge($Form->start_time)->format('%Y/%m/%d - H:i');
            }
            $res['Form'] = $Form;
            $acc = DB::table('form_access as f')
                ->join('user as u', 'u.id', '=', 'f.uid')
                ->where('f.form_id', $fid)
                ->select('u.Name', 'u.Family', 'u.id', 'f.actype')->get();
            $res['Acc'] = $acc;
            $acc = DB::table('form_pages as f')
                ->join('subjects as s', 's.id', '=', 'f.pid')
                ->where('f.form_id', $fid)
                ->select('s.id', 's.title')->get();
            $res['Pages'] = $acc;
            $field = DB::table('forms_field as d', 'f.id', '=', 'd.form_id')
                ->where('d.form_id', $fid)
                ->select(DB::RAW('d.question, d.id as did, d.field_name, d.field_type, d.requires, d.orders, d.scores,d.level'))
                ->orderBy('d.orders')->get();
            foreach ($field as $value)
            {
                $rows = DB::table('forms_field_value as v')->where('v.field_id', $value->did)
                    ->select(DB::RAW(' v.id as vid, v.field_value'))
                    ->orderBy('v.orders')->get();
                $value->values = $rows;
            }
            $res['Fields'] = $field;
            $err = false;
        }
        else
        {
            $res = 'شما امکان ویرایش ندارید';
            $err = true;
        }

        return $res;
    }

    public function ADDForm(
        $uid, $session_id, $form_name, $form_type, $form_help, $column, $field_name, $field_type
        , $field_value, $requires, $question, $level, $user_submit, $user_view, $user_edit, $start, $end, $pages, $one, $isdraft, $before_start, $after_end)
    {
        $user = UserClass::CheckLogin($uid, $session_id);
        if ($user)
        {
            $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
            if ($one != '')
            {
                $one = ($one != '') ? 1 : 0;
            }
            $form_id = DB::table('forms')->insertGetId(
                array('admin' => $uid, 'title' => $form_name, 'type' => $form_type, 'col' => $column, 'start_time' => $start,
                    'end_time' => $end, 'help' => $form_help, 'reg_date' => $reg_date, 'onereport' => $one, 'isdraft' => $isdraft, 'before_start' => $before_start, 'after_end' => $after_end));
            $field_name = explode(',', $field_name);
            $field_type = explode(',', $field_type);
            $field_value = explode(',', $field_value);
            $requires = explode(',', $requires);
            $level = explode(',', $level);
            $question = explode(',', $question);
            $pages = explode(',', $pages);
            foreach ($field_name as $key => $value)
            {
                if (trim($value) != '')
                {
                    $levelR = $level[$key];
                    $field_typeR = $field_type[$key];
                    $field_valueR = $field_value[$key];
                    if (array_key_exists($key, $requires))
                    {
                        $requiresR = $requires[$key];
                    }
                    if ($requiresR == 'on')
                    {
                        $requiresR = '1';
                    }
                    else
                    {
                        $requiresR = '0';
                    }
                    $questionR = $question[$key];
                    $field_id = DB::table('forms_field')->insertGetId(
                        array('form_id' => $form_id, 'field_name' => $value, 'field_type' => $field_typeR, 'orders' => $key,
                            'requires' => $requiresR, 'question' => $questionR, 'level' => $levelR));

                    $field_values = explode('|', $field_valueR);
                    foreach ($field_values as $k => $v)
                    {
                        DB::table('forms_field_value')->insertGetId(
                            array('field_id' => $field_id, 'field_value' => $v));
                    }
                }
            }
            if (is_array($user_submit))
            {
                foreach ($user_submit as $value)
                {
                    DB::table('form_access')->insert(
                        array('form_id' => $form_id, 'uid' => $value, 'actype' => 1));
                }
            }
            if (is_array($user_view))
            {
                foreach ($user_view as $value)
                {
                    DB::table('form_access')->insert(
                        array('form_id' => $form_id, 'uid' => $value, 'actype' => 2));
                }
            }
            if (is_array($user_edit))
            {
                foreach ($user_edit as $value)
                {
                    DB::table('form_access')->insert(
                        array('form_id' => $form_id, 'uid' => $value, 'actype' => 3));
                }
            }
            if (is_array($pages))
            {
                foreach ($pages as $value)
                {
                    DB::table('form_pages')->insert(
                        array('form_id' => $form_id, 'pid' => $value));
                }
            }

            $message = trans('labels.FormOK');
            $err = false;
        }
        else
        {
            $message = trans('labels.FailUser');
            $err = true;
        }
        return $message;
    }

    public function ShowForms($uid, $sesid, $Type)
    {

        switch ($Type)
        {
            case 'all':
                $Forms = DB::table('forms AS f')->leftJoin('forms_report AS r', 'f.id', '=', 'r.form_id')
                    ->leftJoin('pages AS p', 'p.id', '=', 'r.pid')
                    ->leftJoin('user AS u', 'u.id', '=', 'f.admin')
                    ->select(DB::Raw('DISTINCT f.id, f.admin, f.title , f.reg_date, u.Name, u.Family , count(*) as nr , ifnull(r.id, 0) as n'))
                    ->groupBy('f.id')->orderBy('f.reg_date', 'DESC')->get();
                break;
            case 'me':
                $sql = "(
	SELECT DISTINCT
		f.id,
		f.admin,
		f.title,
		f.reg_date,
		u. NAME,
		u.Family,
		count(*) AS nr,
		ifnull(r.id, 0) AS n,
		count(p.id) AS pids,r.reg_date as resdate,r.id as rid
	FROM
		`forms` AS `f`
	LEFT JOIN `forms_report` AS `r` ON `f`.`id` = `r`.`form_id`
	LEFT JOIN `pages` AS `p` ON `p`.`id` = `r`.`pid`
	LEFT JOIN `user` AS `u` ON `u`.`id` = `f`.`admin`
	WHERE
		f.id NOT IN (
			SELECT
				form_id
			FROM
				form_access
		)
	GROUP BY
		`r`.`id`,
		`id`
	ORDER BY
		`f`.`reg_date` DESC,r.id
)
UNION
	(
		SELECT DISTINCT
			f.id,
			f.admin,
			f.title,
			f.reg_date,
			u. NAME,
			u.Family,
			count(*) AS nr,
			ifnull(r.id, 0) AS n,
			count(p.id) AS pids,r.reg_date as resdate,r.id as rid
		FROM
			`forms` AS `f`
		LEFT JOIN `form_access` AS `fa` ON `f`.`id` = `fa`.`form_id`
		LEFT JOIN `forms_report` AS `r` ON `f`.`id` = `r`.`form_id`
		AND (`r`.`uid` = {$uid} or `fa`.`uid` = {$uid})
		LEFT JOIN `pages` AS `p` ON `p`.`id` = `r`.`pid`
		LEFT JOIN `user` AS `u` ON `u`.`id` = `f`.`admin`
		WHERE
			`fa`.`actype` = 1
		GROUP BY
			`r`.`id`
		ORDER BY
			`f`.`reg_date` DESC,r.id
	)
ORDER BY
	`reg_date` DESC,rid DESC";
                $Forms = DB::select(DB::raw($sql));
                foreach ($Forms as $value)
                {
                    $value->resdate = \Morilog\Jalali\jDate::forge($value->resdate)->format('%Y/%m/%d');
                }
                break;
            case 'drafts':
                $Forms = DB::table('forms AS f')->leftJoin('forms_report AS r', 'f.id', '=', 'r.form_id')
                    ->leftJoin('pages AS p', 'p.id', '=', 'r.pid')
                    ->leftJoin('user AS u', 'u.id', '=', 'f.admin')
                    ->where('admin', $uid)->where('isdraft', '1')
                    ->select(DB::Raw('DISTINCT f.id, f.admin, f.title , f.reg_date, u.Name, u.Family , count(*) as nr , ifnull(r.id, 0) as n,count(p.id) as pids,r.reg_date AS resdate,r.uid'))
                    ->groupBy('f.id')->orderBy('f.reg_date', 'DESC')->get();
                break;
            case 'sent':
                $Forms = DB::table('forms AS f')
                    ->leftJoin('forms_report AS r', 'f.id', '=', 'r.form_id')
                    ->leftJoin('pages AS p', 'p.id', '=', 'r.pid')
                    ->leftJoin('user AS u', 'u.id', '=', 'f.admin')
                    ->where('f.admin', $uid)->where('f.isdraft', 0)
                    ->select(DB::Raw('DISTINCT f.id, f.admin, f.title , f.reg_date, u.Name, u.Family , count(*) as nr , ifnull(r.id, 0) as n'))
                    ->groupBy('f.id')->orderBy('f.reg_date', 'DESC')->get();
                break;
            default :
                $Forms = DB::table('forms AS f')->leftJoin('forms_report AS r', 'f.id', '=', 'r.form_id')
                    ->leftJoin('pages AS p', 'p.id', '=', 'r.pid')
                    ->leftJoin('user AS u', 'u.id', '=', 'f.admin')
                    ->where('admin', $uid)
                    ->select(DB::Raw('DISTINCT f.id, f.admin, f.title , f.reg_date, u.Name, u.Family , count(*) as nr , ifnull(r.id, 0) as n,count(p.id) as pids,r.reg_date AS resdate,r.uid'))
                    ->groupBy('f.id')->orderBy('f.reg_date', 'DESC')->get();
                break;
        }
        $i = 1;

        foreach ($Forms as $value)
        {
            $pidss = DB::table('forms_report')->where('pid', '!=', '0')->where('form_id', $value->id)->groupBy('pid')->get();
            $j = 0;
            foreach ($pidss as $values)
            {
                $j++;
            }
            $value->pids = $j;
            $value->sortid = $i;
            $value->edit = $i;
            $value->copy = $i;
            $value->del = $i;

            $i++;
        }
        $message = $Forms;
        $err = false;

        return $message;
    }

}
