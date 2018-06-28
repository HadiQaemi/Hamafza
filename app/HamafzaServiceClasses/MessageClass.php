<?php

namespace App\HamafzaServiceClasses;

use Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class MessageClass
{

    public static function DeleteFromOut($uid, $id)
    {
        DB::table('tickets')->where('uid', $uid)->where('id', $id)->update(array('login' => '1'));
    }

    public static function DeleteFromInbox($uid, $id)
    {
        DB::table('ticket_recieve')->where('uid', $uid)->where('tid', $id)->update(array('del' => '1'));
    }

    function sharePage($uid, $sesid, $user_edits, $recipientmail2, $comment, $link, $tid, $type, $sendermail, $sendername)
    {
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
            $tid = intval($_POST["tid"]);
            if ($type == 'subject')
            {
                $type = 'page';
            }
            $comment = PublicClass::Filter($comment);
            $link = PublicClass::Filter($link);
            $comment = $comment . '<br><p><a target="_blank" href="' . $link . '">' . $link . '</a></ap>';
            $user_edits = json_decode($user_edits, true);
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
//            
//            DB::table('user_suggest')->insert(array('uid' => $uid, 'type' => $type, 'tid' => $tid, 'sname' => $sendername,
//                'semail' => $sendermail, 'ruid' => $uid, 'remail' => $recipientmail2, 'comment' => $comment, 'reg_date' => $reg_date));

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
            $err = false;
        }
        else
        {
            $mes = trans('labels.FailUser');
            $err = true;
        }
        return Response::json(array(
            'error' => $err,
            'data' => $mes), 200
        )->setCallback(Input::get('callback'));
    }

//    public function ViewMessage($uid, $tid, $islocal = 'local')
//    {
//
//        $m = DB::table('tickets AS t')
//            ->join('ticket_recieve AS r', 't.id', '=', 'r.tid')
//            ->join('ticket_answer AS a', 'a.tid', '=', 't.id')
//            ->leftJoin('user as u2', 'r.uid', '=', 'u2.id')
//            ->leftJoin('user as u', 'u.id', '=', 't.uid')
//            ->whereRaw("(r.uid = {$uid} or t.uid={$uid})  AND t.id = {$tid}")
//            ->select('t.title', 'u.id as uid', 'u.Name AS sendname', 'u.Family AS sendfamily', 'u2.Name AS recname', 'u2.Family AS recfamily', 'u.Uname', 'a.comment', 't.reg_date')
//            ->first();
//
//        $Rec = DB::table('tickets AS t')->join('ticket_recieve AS r', 't.id', '=', 'r.tid')
//            ->leftJoin('user as u', 'u.id', '=', 'r.uid')
//            ->where('r.tid', $tid)
//            ->select('u.id as id', 'u.Uname', 'u.Name', 'u.Family')
//            ->get();
//        $Files = DB::table('ticket_file AS t')->where('aid', $tid)->get();
//        DB::table('ticket_recieve')->where('tid', $tid)->where('uid', $uid)->update(array('view' => '1'));
//
//        $m->reg_date = \Morilog\Jalali\jDate::forge($m->reg_date)->format('%Y/%m/%d  -   h:i:s');
//        $m->Reciver = $Rec;
//        $m->Files = $Files;
//        $mes = $m;
//        $mes = json_encode($mes);
//        $mes = json_decode($mes);
//
//
//
//        if ($islocal == 'local')
//        {
//            return $mes;
//        }
//        else
//        {
//            \App\HamafzaPublicClasses\FunctionsClass::JSON($mes, '');
//        }
//    }

    public function Select($uid, $type)
    {
        if ($type == 'inbox')
        {
            $ret = $this->inbox($uid);
        }

        return $ret;
    }

    function Outbox($uid, $sesid, $add_script = true)
    {
        $m = DB::table('tickets AS t')->join('ticket_recieve AS r', 't.id', '=', 'r.tid')
            ->join('ticket_answer AS a', 'a.tid', '=', 't.id')
            ->leftJoin('ticket_file as tf', 'tf.aid', '=', 't.id')
            ->where('t.uid', $uid)->where('t.login', '0')
            ->select(DB::Raw('count(tf.aid) as attach'), 't.reg_date', 'a.comment', 'r.view', 't.title', 'r.uid AS reciver', 't.uid AS sender', 't.id as tid')
            ->groupBy('t.id')->orderBy('t.id', 'desc')->get();
        $i = 1;
        foreach ($m as $Group)
        {
            $Name = '';
            $User = '';
            $Group->sortid = $i;
            $string = '';
            if (strlen($Group->comment) > 15)
            {
                $string = mb_substr($Group->comment, 0, 10) . '...';
            }
            else
            {
                $string = $Group->comment . '...';
            }
            $string = strip_tags($string);

            $Group->title = $Group->title . ($add_script ? (' <span style="color: #000039;font-size: 8pt;">' . $string . '</span>') :'');
            $Group->reg_date = \Morilog\Jalali\jDate::forge($Group->reg_date)->format('%Y/%m/%d');
            $Rec = DB::table('tickets AS t')->join('ticket_recieve AS r', 't.id', '=', 'r.tid')
                ->leftJoin('user as u', 'u.id', '=', 'r.uid')
                ->where('r.tid', $Group->tid)
                ->select('u.id as id', 'u.Uname', 'u.Name', 'u.Family')
                ->get();
            $i = 1;
            foreach ($Rec as $Recs)
            {
                if ($i == 1)
                {
                    $Name = trim($Recs->Name) . ' ' . trim($Recs->Family);
                    $User = $Recs->Uname;
                }
                $i++;
            }
            if ($i > 2)
            {
                $Name .= ' و...';
            }
            $Group->Fname = $Name;
            $Group->uname = $User;

            $Group->Rec = $Rec;
            $i++;
        }
        $mes = $m;
        $err = false;
        return $m;
    }

    function inbox($uid, $sesid, $islocal = 'local',$add_script = true)
    {
        DB::table('emails')
            ->where('uid', $uid)
            ->where('type', 'SMS_NEW')
            ->update(array('view' => '1', 'read' => '1'));

        $m = DB::table('tickets AS t')
            ->join('ticket_recieve AS r', 't.id', '=', 'r.tid')
            ->join('ticket_answer AS a', 'a.tid', '=', 't.id')
            ->leftJoin('ticket_file as tf', 'tf.aid', '=', 't.id')
            ->join('user as u', 'u.id', '=', 't.uid')
            ->where('r.uid', $uid)
            ->where('r.del', '0')
            ->select
            (
                DB::Raw('count(tf.aid) as attach'),
                'a.comment',
                't.reg_date',
                't.title',
                'r.view',
                'r.uid AS reciver',
                't.uid AS sender',
                't.id as tid',
                'u.Name',
                'u.Family',
                'u.Uname as uname',
                'u.Pic',
                'u.id'
            )
            ->groupBy('t.id')
            ->orderBy('t.id', 'desc')
            ->get();
        $i = 1;
        foreach ($m as $Group)
        {
            $string = '';
            $com = strip_tags($Group->comment);

            $j = intval(strlen($com));
            if ($j > 15)
            {
                $string = mb_substr($com, 0, 35);
            }
            else
            {
                $string = $Group->comment . '...';
            }
            $string = strip_tags($string);
            $Group->title = $Group->title . ($add_script ? (' <span style="color: #000039;font-size: 8pt;">' . $string . '</span>') :'');
            $Group->sortid = $i;
            $Group->Fname = trim($Group->Name) . ' ' . trim($Group->Family);
            $Group->reg_date = \Morilog\Jalali\jDate::forge($Group->reg_date)->format('%Y/%m/%d h:i:s');
            $i++;
        }
        //$mes = $m;
        //$err = false;
        //$not = DB::table('emails')->where('uid', $uid)->where('read', '0')->whereRaw("type not like 'Endorse'")->count();
        //$DesktopNotificaton = $not;
        return $m;
    }

}
