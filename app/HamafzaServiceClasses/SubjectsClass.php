<?php

namespace App\HamafzaServiceClasses;

use App\Models\hamafza\Subject;
use App\Models\hamafza\SubjectFieldValue;
use Illuminate\Support\Facades\DB;

class SubjectsClass
{

    public static function GetMypage($uid, $type)
    {
        $selpage = PageClass::Sel_Page();
        $sql = "SELECT
			p.id , p.sid ,st.name as subjectkind, p.type, p.state , p.score , s.reg_date , p.edit_date , p.com_date , s.title, s.manager , s.supporter , s.supervisor ,s.visit,s.like,s.follow
					FROM 
						subjects as s 
					LEFT JOIN 
						pages as p
					ON 
						p.sid = s.id  LEFT JOIN 
						subject_type as st on st.id=s.kind
					WHERE
						{$selpage} AND s.archive = 0  ";
        switch ($type)
        {
            case 'Created_ME':
                $sql .= " and sid in (  select id from subjects where admin={$uid} group by id ) ORDER BY reg_date DESC";
                break;
            case 'New_Other':
                $sql .= "  ORDER BY reg_date DESC";
                break;
            case 'Edited_ME':
                $sql .= " and p.id in ( select id from pages where editor={$uid} UNION select id from page_draft where uid={$uid} group by id  )   ORDER BY edit_date DESC";
                break;
            case 'follow_ME':
                $sql .= " and  sid in (select sid from subject_member where uid={$uid} and follow ='1')   ORDER BY reg_date DESC";
                break;
            case 'like_ME':
                $sql .= " and  sid in (select sid from subject_member where uid={$uid} and `like`='1')   ORDER BY reg_date DESC";
                break;
            case 'ano_ME':
                $sql .= " and  p.id in (SELECT pid FROM announces where uid={$uid} group by pid)  ORDER BY reg_date DESC";
                break;
            case 'highlight_ME':
                $sql .= " and p.id in (select pid from highlights where uid={$uid} ) ORDER BY reg_date DESC";
                break;
            case 'Proc_ME':
                $sql .= " and sid in ( select id from subjects where (manager={$uid} or supervisor ={$uid} or supporter={$uid}) or admin={$uid} group by id ) ORDER BY reg_date DESC";
                break;
            case 'visited_ME':
                $sql .= " and p.id in ( select pid from page_visit where uid={$uid} group by pid ) ORDER BY reg_date DESC";
                break;
            case 'Sug_ME':
                $sql .= " and p.id in(select tid from  user_suggest where uid={$uid} and type='page' group by tid) ORDER BY reg_date DESC";
                break;
            case 'ALL_ME':
                $sql .= " and (sid in (  select id from subjects where admin={$uid} group by id ) or ( p.id in(select tid from  user_suggest where uid={$uid} and type='page' group by tid))  or"
                    . " (p.id in ( select pid from page_visit where uid={$uid} group by pid )) or  (sid in ( select id from subjects where (manager={$uid} or supervisor ={$uid} or supporter={$uid}) or admin={$uid} group by id )) "
                    . "or  (p.id in (select pid from highlights where uid={$uid} )) or (p.id in (SELECT pid FROM announces where uid={$uid} group by pid)) ) ORDER BY reg_date DESC";
                break;
            case 'ALL_Other':
                $sql .= " ORDER BY reg_date DESC";
                break;
            case 'Deleted_pages':
                $sql = "SELECT p.id , p.sid ,st.name as subjectkind, p.type, p.state , p.score , s.reg_date , p.edit_date , p.com_date , s.title, s.manager , s.supporter , s.supervisor ,s.visit,s.like,s.follow
					FROM 
						subjects as s 
					LEFT JOIN 
						pages as p
					ON 
						p.sid = s.id LEFT JOIN 
						subject_type as st on st.id=s.kind
					WHERE
						{$selpage} AND   sid in (sELECT id FROM subjects WHERE archive=1 group by id)  ORDER BY reg_date DESC";
                break;
        }

        $res = DB::select(DB::raw($sql));
        $i = 1;
        foreach ($res as $value)
        {
            $value->sortid = $i;
            $value->edit_date = \Morilog\Jalali\jDate::forge($value->edit_date)->format('%Y/%m/%d');
            $value->reg_date = \Morilog\Jalali\jDate::forge($value->reg_date)->format('%Y/%m/%d');
            $i++;
        }

        return $res;
    }

    public function update_Help($pid, $sid, $subject_helps, $subject_Alert)
    {
        $work = $sid;
        $helpid = 0;
        $helps = '';
        foreach ($subject_helps as $key => $value)
        {
            if ($value != '')
            {
                $helps = str_replace("Help ", "Help+", $value);
                $pages = DB::table('pages as p')->join('subjects as s', 's.id', '=', 'p.sid')->select('p.id', 's.title', 'p.body')->whereRaw("body like '%$helps%'")->first();
                if ($pages)
                {
                    $helpid = $pages->id;
                }
                DB::table('pages')->where('id', $key)->update(array('help_tag' => $helps, 'help_pid' => $helpid));
            }
        }
        $message = trans('labels.subjectAccessOK');
        return $message;
    }


    public static function update_relations($uid, $sesid, $sid, $subject2, $relation)
    {
        $relation = json_decode($relation, true);
        $subjects2 = json_decode($subject2, true);

        $user = UserClass::CheckLogin($uid, $sesid);
        if ($user == TRUE)
        {
            $user = 'true';
        }
        else
        {
            $user = 'false';
        }
        if ($user)
        {
            DB::table('subjects_rel')->where('sid1', $sid)->orWhere('sid2', $sid)->delete();
            foreach ($subjects2 as $key => $val)
            {
                if (!empty($val))
                {
                    $relate = $relation[$key];
                    if ($relate != 0)
                    {
                        $sid2 = $val;
                        if ($relate == '1' || $relate == '3' || $relate == '5' || $relate == '7' || $relate == '9' || $relate == '10' || $relate == '12' || $relate == '13' || $relate == '15' || $relate == '17')
                        {
                            $rel = $relate;
                            DB::table('subjects_rel')->insert(array('sid1' => $sid, 'sid2' => $sid2, 'rel' => $rel));
                        }
                        if ($relate == '2' || $relate == '4' || $relate == '6' || $relate == '8' || $relate == '11' || $relate == '14' || $relate == '16')
                        {
                            if ($relate == '2')
                            {
                                $rel = '1';
                            }
                            if ($relate == '4')
                            {
                                $rel = '3';
                            }
                            if ($relate == '6')
                            {
                                $rel = '5';
                            }
                            if ($relate == '8')
                            {
                                $rel = '7';
                            }
                            if ($relate == '11')
                            {
                                $rel = '10';
                            }
                            if ($relate == '14')
                            {
                                $rel = '13';
                            }
                            if ($relate == '16')
                            {
                                $rel = '17';
                            }
                            DB::table('subjects_rel')->insert(array('sid1' => $sid2, 'sid2' => $sid, 'rel' => $rel));
                        }
                    }
                }
            }

            $message = trans('labels.subjectRelOK');
            $err = false;
        }
        else
        {
            $message = trans('labels.FailUser');
            $err = true;
        }

        return Response::json(array(
            'error' => $err,
            'data' => $message), 200
        )->setCallback(Input::get('callback'));
    }

    public static function UpdateSubject($uid, $sesid, $subject_title, $PS_keywords, $field, $sid, $tt, $subject_help, $subject_pid)
    {
        $subject_help = json_decode($subject_help, true);
        $field_type = json_decode($tt, true);

        $work = $sid;
        $helpid = 0;
        $helps = '';
        if ($subject_help != '')
        {
            $helps = str_replace("Help ", "Help+", $subject_help);
            $pages = DB::table('pages as p')->join('subjects as s', 's.id', '=', 'p.sid')->select('p.id', 's.title', 'p.body')->whereRaw("body like '%$helps%'")->first();
            if ($pages)
            {
                $helpid = $pages->id;
            }
        }

        DB::table('pages')->where('id', $subject_pid)->update(array('help_tag' => $helps, 'help_pid' => $helpid));
        DB::table('subjects')->where('id', $sid)->update(array('title' => $subject_title));

        if (is_array($field_type))
        {
            DB::table('subject_fields_report')->where('sid', $work)->delete();
            foreach ($field_type as $key => $val)
            {
                if (!empty($val))
                {
                    if ($val == 'text' || $val == 'textarea' || $val == 'select' || $val == 'radio' || $val == 'keyword')
                    {
                        $value = (array_key_exists($key, $field)) ? $field[$key] : '';
                        DB::table('subject_fields_report')->insert(array('sid' => $work, 'field_id' => $key, 'field_value' => $value));
                    }
                    elseif ($val == 'checkbox')
                    {
                        if (isset($field[$key]) && is_array($field[$key]))
                        {
                            foreach ($field[$key] as $k => $v)
                            {
                                DB::table('subject_fields_report')->insert(array('sid' => $work, 'field_id' => $key, 'field_value' => '1', 'check_id' => $k));
                            }
                        }
                    }
                }
            }
        }
        DB::table('subject_key')->where('sid', $work)->delete();
        $PS_keywords = explode(',', $PS_keywords);
        $PS_keywords = json_encode($PS_keywords);
        $PS_keywords = json_decode($PS_keywords);

        foreach ($PS_keywords as $value)
        {
            if ($value != '')
            {
                DB::table('subject_key')->insert(array('sid' => $work, 'kid' => $value));
            }
        }
        $message = trans('labels.subjectSettingOK');
        $err = false;
        return $message;
    }

    public function ViewSubjects($uid = 0, $session_id = 0, $type = 0, $id = 0)
    {
        $user = UserClass::CheckLogin($uid, $session_id);
        if ($user)
        {
            if ($type == 'FormSubject')
            {
                $M = DB::table('forms as f')->leftJoin('forms_report as r', 'f.id', '=', 'r.form_id')
                    ->leftJoin('pages as p', 'p.id', '=', 'r.pid')
                    ->leftJoin('subjects as s', 'p.sid', '=', 's.id')
                    ->leftJoin('user as u', 'f.admin', '=', 'u.id')
                    ->where('f.id', $id)->where('p.id', '!=', '0')->groupBy('s.id')->orderBy('f.reg_date', 'desc')->select(DB::RAW('DISTINCT r.pid,f.id, f.admin, s.title , f.reg_date, u.Name, u.Family , count(*) as nr , ifnull(r.id, 0) as n,s.title as  stitle'))->get();
                $i = 1;
                foreach ($M as $value)
                {
                    $value->sortid = $i;
                    $i++;
                }
            }
            $message = $M;
            $err = false;
        }
        else
        {
            $message = trans('labels.FailUser');
            $err = true;
        }
        return $message;
    }

    public static function Fields($uid = 0, $session_id = 0, $kind = 0)
    {

        $Ret = array();
        $row = DB::table('subject_type as st')
            ->where('st.id', $kind)->first();
        if ($row)
        {
            $keywords = '';
            $manager['require'] = $row->manager_require == '1' ? true : false;
            $manager['title'] = trim($row->manager_title) != '' ? $row->manager_title : trans('labels.secreter');
            $avamel['manager'] = $manager;
            $supervisor['require'] = $row->supervisor_require == '1' ? true : false;
            $supervisor['title'] = trim($row->supervisor_title) != '' ? $row->supervisor_title : trans('labels.supervisor');
            $avamel['supervisor'] = $supervisor;
            $supporter['require'] = $row->supporter_require == '1' ? true : false;
            $supporter['title'] = trim($row->supporter_title) != '' ? $row->supporter_title : trans('labels.supporter');
            $avamel['supporter'] = $supporter;
            $Ret['avamel'] = $avamel;


            $tag['select'] = $row->tagselect == '1' ? true : false;
            $tag['require'] = $row->tagrequire == '1' ? true : false;
            $Ret['tag'] = $tag;

            $department['select'] = $row->department_select == '1' ? true : false;
            $department['require'] = $row->department_require == '1' ? true : false;
            $department['data'] = '';
            if ($row->department_select == '1')
            {
                $Data = DB::table('subjects as s')
                    ->where('s.kind', '27')->select('s.id', 's.title', 's.kind')->get();
                $department['data'] = $Data;
            }
            $Ret['department'] = $department;

            $proc['data'] = '';
            $proc['select'] = $row->department_select == '1' ? true : false;
            $proc['require'] = $row->department_require == '1' ? true : false;
            if ($row->proc_select == 1)
            {
                $Data = DB::table('process')->select('id', 'name')->get();
                $proc['data'] = $Data;
            }
            $Ret['proc'] = $proc;

            $manager['data'] = '';
            $manager['select'] = $row->manager_select == '1' ? true : false;
            $manager['require'] = $row->manager_require == '1' ? true : false;
            $Ret['manager'] = $manager;

            $supervisor['data'] = '';
            $supervisor['select'] = $row->supervisor_select == '1' ? true : false;
            $supervisor['require'] = $row->supervisor_require == '1' ? true : false;
            $Ret['supervisor'] = $supervisor;

            $supporter['data'] = '';
            $supporter['select'] = $row->supporter_select == '1' ? true : false;
            $supporter['require'] = $row->supporter_require == '1' ? true : false;
            $Ret['supporter'] = $supporter;
        }

        $Fields = DB::table('subject_type_fields as st')->where('st.stid', $kind)->orderBy('st.orders')->get();

//        $field_id = array();
//        $field_name = array();
//        $field_type = array();
//        $field_value = array();
//        $requires = array();
//        $Desc = array();
//
//        foreach ($rows as $row) {
//            $index = $row->id;
//            $field_id[$index] = $row->id;
//            $field_name[$index] = $row->field_name;
//            $field_type[$index] = $row->field_type;
//            $field_value[$index][$row->vid] = $row->field_value;
//            $requires[$index] = $row->requires;
//            $Desc[$index] = $row->help;
//        }
//        $Fields['id'] = $field_id;
//        $Fields['name'] = $field_name;
//        $Fields['type'] = $field_type;
//        $Fields['value'] = $field_value;
//        $Fields['requires'] = $requires;
//        $Fields['Desc'] = $Desc;

        $Ret['Fields'] = $Fields;

        $err = false;
        $message = $Ret;
        return $message;
    }

    public static function AddSubject($keywords_list_subject,$roles_list_subject_edit,$users_list_subject_edit,$roles_list_subject_view,$users_list_subject_view,$uid = 0, $session_id = 0, $title, $tem, $kind = 0, $framework = 0, $ispublic, $fields, $TT_ttype, $field_type, $Skind, $keywords)
    {
        $skind = $kind;
        $subject_title = PublicsClass::subst($title);
        $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
        $res = DB::table('subject_type as st')
            ->where('st.id', $skind)
            ->select('st.viewalert', 'st.editalert', 'st.ShowEdit', 'st.manager', 'st.supporter', 'st.supervisor', 'st.process')
            ->first();
        $processid = $res->process;
        $ShowEdit = $res->ShowEdit;
        $editalert = $res->editalert;
        $viewalert = $res->viewalert;
        $managerid = $res->manager;
        $supporterid = $res->supporter;
        $supervisorid = $res->supervisor;
        $admin = $uid;
        $manager = $managerid ? $managerid : $uid;
        $supporterid = $supporterid ? $supporterid : $uid;
        $supervisorid = $supervisorid ? $supervisorid : $uid;
        $subject_author = $admin;
        $list = '1';
        $graph = '0';
        $search = '1';
        $top = '0';
        $pform = '0';
        $group = '0';
        $priority = '1';
        $frameid = 0;
        $isframe = 0;
        $istheme = 0;

        $work = DB::table('subjects')->insertGetId(
            array('admin' => $admin, 'manager' => $managerid, 'supporter' => $supporterid, 'supervisor' => $supervisorid, 'title' => $subject_title
            , 'author' => $subject_author, 'kind' => $skind, 'group' => $group, 'pform' => $pform
            , 'theme' => $istheme, 'frame' => $isframe, 'frameid' => $frameid, 'list' => $list,
                'graph' => $graph, 'search' => $search, 'top' => $top, 'priority' => $priority
            , 'view' => '0', 'reg_date' => $reg_date, 'edit_date' => $reg_date, 'eve_date' => $reg_date, 'ispublic' => $ispublic, 'asubject' => $Skind, 'created_by' => $uid)
        );

        $subject = Subject::find($work);

        if (is_array($keywords_list_subject))
        {
            foreach ($keywords_list_subject as $key)
            {
                $keywords_list_subject_tmp[] = substr($key, 8);
            }
        } else
        {
            $keywords_list_subject_tmp = [];
        }

        $keywords_list_subject = $keywords_list_subject_tmp;

        if($keywords_list_subject)
        {
            $subject->keywords()->attach($keywords_list_subject);
        }

        if ($users_list_subject_view)
        {
            foreach ($users_list_subject_view as $key => $value)
            {
                $users_list_subject_view_array[$value] = ['type' => '1'];
            }

            $subject->user_policies_view()->attach($users_list_subject_view_array);
            $subject->user_policies_view()->attach(auth()->id());
        }

        if ($roles_list_subject_view)
        {
            foreach ($roles_list_subject_view as $key => $value)
            {
                $roles_list_subject_view_array[$value] = ['type' => '1'];
            }
            $subject->role_policies_view()->attach($roles_list_subject_view_array);
        }
        if ($users_list_subject_edit)
        {
            foreach ($users_list_subject_edit as $key => $value)
            {
                $users_private_array[$value] = ['type' => '2'];
            }
            $subject->user_policies_edit()->attach($users_private_array);
            $subject->user_policies_edit()->attach(auth()->id());
        }

        if ($roles_list_subject_edit)
        {
            foreach ($roles_list_subject_edit as $key => $value)
            {
                $roles_private_array[$value] = ['type' => '2'];
            }
            $subject->role_policies_edit()->attach($roles_private_array);
        }




        DB::table('subject_member')->insert(
            array('uid' => $admin, 'sid' => $work, 'follow' => '1'),
            array('uid' => $manager, 'sid' => $work, 'follow' => '1'),
            array('uid' => $supporterid, 'sid' => $work, 'follow' => '1'),
            array('uid' => $supervisorid, 'sid' => $work, 'follow' => '1')
        );


        $stt = DB::table('subject_type_tab as stt')
            ->where('stid', $skind)
            ->where('view', '1')
            ->select('id')
            ->get();
        if ($stt)
        {
            foreach ($stt as $value)
            {
                DB::table('tab_view')->insert(array('tabid' => $value->id, 'sid' => $skind));
            }
        }
        if ($framework != 0)
        {
            DB::table('subjects_rel')->insert(array('sid1' => $work, 'sid2' => $framework, 'rel' => '17'));
        }
        $pid = $work * 10;
        $first_pid = $work * 10;
        $first = $pid;
        $stt = DB::table('subject_type_tab as stt')
            ->where('stt.stid', $skind)
            ->select('stt.id', 'stt.tid', 'stt.name as sttname', 'stt.first', 'stt.view', 'tem')
            ->get();
        $first = 0;
        $tems = '';
        foreach ($stt as $res)
        {
            $tabid = $res->id;
            $tems = ($tem != '') ? $res->tem : '';
            $tems = str_replace("'", '"', $tems);
            $tid = $res->tid;
            $view = 1;
            if ($res->first == 1)
            {
                $first = $pid;
                $type = $tid;
            }
            if ($tems != '')
            {
                DB::table('pages')
                    ->insert(
                        array(
                            'id' => $pid,
                            'sid' => $work,
                            'type' => $tid,
                            'view' => $view,
                            'edit_date' => $reg_date,
                            'ver_date' => $reg_date,
                            'edit' => '1',
                            'body' => $tems
                        )
                    );
            }
            else
            {
                DB::table('pages')
                    ->insert(
                        array(
                            'id' => $pid,
                            'sid' => $work,
                            'type' => $tid,
                            'view' => $view,
                            'edit_date' => $reg_date,
                            'ver_date' => $reg_date,
                            'edit' => '1'
                        )
                    );
            }
            DB::table('tab_view')->insert(
                array(
                    'tabid' => $tabid,
                    'sid' => $work
                )
            );
            ++$pid;
        }
        $err = false;
        $int = (int)$work;
        $keywords = explode(',', $keywords);
        $keywords = json_encode($keywords);
        $keywords = json_decode($keywords);
        if (is_array($keywords))
        {
            foreach ($keywords as $value)
            {
                if ($value != '')
                {
                    DB::table('subject_key')->insert(array('sid' => $work, 'kid' => $value));
                }
            }
        }
        if (is_array($field_type))
        {
            SubjectFieldValue :: where('sid', $work)->delete();
            foreach ($field_type as $key => $val)
            {
                if (!empty($val))
                {
                    if ($val == 'text' || $val == 'textarea' || $val == 'select' || $val == 'radio' || $val == 'keyword')
                    {
                        $value = (array_key_exists($key, $fields)) ? $fields[$key] : '';
                        DB::table('subject_fields_report')
                            ->insert(
                                array(
                                    'sid' => $work,
                                    'field_id' => $key,
                                    'field_value' => $value
                                )
                            );
                    }
                    elseif ($val == 'checkbox')
                    {
                        if (isset($fields[$key]) && is_array($fields[$key]))
                        {
                            foreach ($fields[$key] as $k => $v)
                            {
                               /* DB::table('subject_fields_report')
                                    ->insert(
                                        array(
                                            'sid' => $work,
                                            'field_id' => $key,
                                            'field_value' => '1',
                                            'check_id' => $k
                                        )
                                    );*/
                                $subject_fields_report = new SubjectFieldValue();
                                $subject_fields_report->sid = $work ;
                                $subject_fields_report->field_id = $key ;
                                $subject_fields_report->field_value = '1' ;
                                $subject_fields_report->check_id = $k ;
                                $subject_fields_report->save();
                            }
                        }
                    }
                }
            }
        }
        $message['pid'] = $first_pid;
        $message['id'] = $int * 10;
        $message['ShowEdit'] = $ShowEdit;
        if ($ShowEdit == '1')
        {
            $alert = DB::table('alerts')->where('id', $editalert)->select('comment')->first();
        }
        else
        {
            $alert = DB::table('alerts')->where('id', $viewalert)->select('comment')->first();
        }
        if ($alert)
        {
            $message['Alert'] = $alert->comment;
        }
        else
        {
            $message['Alert'] = '';
        }
        $url = url('') ."/page_edit/" . $message['pid'] . "/text";
        $text = 'صفحه جدید با موفقیت ثبت شد.';
        $message['Alert'][]="<a style='color:#000' target='_blank' href='".$url."'>".$text."</a>";
        $message['success']=true;
        return $message;
    }

}
