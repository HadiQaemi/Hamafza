<?php

namespace App\HamafzaServiceClasses;

use Illuminate\Support\Facades\DB;

class DashboardClass
{

    public static function Page_NumberofMeasures($userid, $pid, $sid)
    {
        $sr = PageClass::Sel_Page();
        $AM_Confirm = DB::table('actions AS a')
            ->leftJoin('action_recieve AS r', 'a.id', '=', 'r.mid')
            ->leftJoin('user as u', 'u.id', '=', 'r.uid')
            ->leftJoin('pages AS p', 'p.id', '=', 'a.pid')
            ->leftJoin('subjects AS s', 's.id', '=', 'p.sid')
            ->where('a.admin', $userid)->where('r.checked', '1')->where('p.sid', $sid)->groupBy('a.id')
            ->select('r.id')->count();

        $Measures['vazife-erjaat']['count'] = $AM_Confirm;

        $sql = "SELECT
                     count(  pps.id) as res 
                FROM
                        process as pr
                LEFT JOIN
                        process_phase as pp
                ON
                        (pr.id = pp.pid)
                LEFT JOIN
                        process_phase_subject as pps
                ON
                        (pps.pid = pr.id AND pps.ppid = pp.id)
                LEFT JOIN
                        subjects as s
                ON
                        (s.id = pps.sid)
                LEFT JOIN
                        pages as p
                ON
                        s.id = p.sid
                WHERE
                     s.id={$sid} and   ((pp.manager1 = 1 AND s.manager = {$userid}) OR (pp.manager1 = 2 AND s.supervisor = {$userid}) OR (pp.manager1 = 3 AND s.supporter = {$userid}) OR (pp.manager1 = 4 AND s.admin = {$userid}) OR (pp.manager = {$userid}))   AND (
	(kind = 4 AND type = 0)
	OR (kind = 3 AND type = 0)
	OR (kind = 5 AND type = 3)
	OR (kind = 8 AND type = 0)
	OR (kind = 37 AND type = 0)
	OR (kind = 27 AND type = 0)
	OR (kind = 33 AND type = 0)
	OR (kind = 45 AND type = 0)
	OR (kind = 46 AND type = 0)
) and {$sr}  and pps.view='0' 
                ORDER BY
                        pps.reg_date DESC";


        $query = DB::select(DB::raw($sql));
        foreach ($query as $value)
        {
            $AM_CountPhaseNew = $value->res;
        }

        $Measures['vazifefarayandi']['count'] = $AM_CountPhaseNew;


        $AM_MontazereTaeed = DB::table('actions AS a')
            ->leftJoin('action_recieve AS r', 'a.id', '=', 'r.mid')
            ->leftJoin('user as u', 'u.id', '=', 'r.uid')
            ->leftJoin('pages AS p', 'p.id', '=', 'a.pid')
            ->leftJoin('subjects AS s', 's.id', '=', 'p.sid')
            ->where('r.uid', $userid)->where('is_bc', '0')->where('complete', '<', '100')->where('r.checked', '0')->where('p.sid', $sid)
            ->groupBy('a.id')->select('r.id')->count();


        $Measures['vazifeman']['count'] = "$AM_MontazereTaeed";


        $AM_Yaddasht = DB::table('pages AS p')
            ->leftJoin('subjects AS s', 's.id', '=', 'p.sid')->leftJoin('announces as a', 'a.pid', '=', 'p.id')
            ->leftJoin('user as u', 'a.uid', '=', 'u.id')
            ->where('a.uid', $userid)->whereRaw('a.id IS NOT NULL')->where('p.sid', $sid)
            ->select('r.id')->count();

        $Measures['yaddasht']['count'] = "$AM_Yaddasht";


        $AM_Yaddasht = DB::table('pages AS p')
            ->leftJoin('subjects AS s', 's.id', '=', 'p.sid')->leftJoin('highlights as a', 'a.pid', '=', 'p.id')
            ->leftJoin('user as u', 'a.uid', '=', 'u.id')
            ->where('a.uid', $userid)->whereRaw('a.id IS NOT NULL')->where('p.sid', $sid)
            ->select('r.id')->count();

        $Measures['alamat']['count'] = "$AM_Yaddasht";

        return $Measures;
    }

    public static function NumberofMeasures($userid)
    {
        $sr = PageClass::Sel_Page();
        $AM_Confirm = DB::table('actions AS a')
            ->leftJoin('action_recieve AS r', 'a.id', '=', 'r.mid')
            ->where('a.admin', $userid)
            ->select('r.id')->count();
        $AM_Confirms = DB::table('emails')
            ->where('uid', $userid)->where('view', '1')->whereRaw("type like 'Eghdam_Confirm'")
            ->select('id')->count();
        $Measures['vazife-erjaat']['count'] = "$AM_Confirm";
        $Measures['vazife-erjaat']['unread'] = "$AM_Confirms";

        $AM_RuneveshtALL = DB::table('actions AS a')
            ->leftJoin('action_recieve AS r', 'a.id', '=', 'r.mid')
            ->where('r.uid', $userid)->where('is_bc', '1')
            ->select('r.id')->count();

        $AM_RuneveshtNew = DB::table('emails')
            ->where('uid', $userid)->where('view', '0')->whereRaw("type ='Eghdam_runevesht'")
            ->select('id')->count();
        $Measures['runevesht']['count'] = "$AM_RuneveshtALL";
        $Measures['runevesht']['unread'] = "$AM_RuneveshtNew";

        $AM_MontazereTaeed = DB::table('actions AS a')
            ->leftJoin('action_recieve AS r', 'a.id', '=', 'r.mid')
            ->where('r.uid', $userid)->where('is_bc', '0')
            ->select('r.id')->count();

        $AM_EghdamNew2 = DB::table('emails')
            ->where('uid', $userid)->where('view', '0')->whereRaw("type like 'Eghdam_New'")
            ->select('id')->count();
        $Measures['vazifeman']['count'] = "$AM_MontazereTaeed";
        $Measures['vazifeman']['unread'] = "$AM_EghdamNew2";


        return $Measures;
    }

    public static function SMS($userid)
    {
        $AM_CountInboxUnRead =
            DB::table('ticket_recieve')
                ->where('uid', $userid)
                ->where('view', '0')
                ->select('id')
                ->count();
        $AM_NEw =
            DB::table('emails')
                ->where('uid', $userid)
                ->where('view', '0')
                ->where('read', '0')
                ->whereRaw("type ='SMS_NEW'")
                ->select('id')
                ->count();
        $Measures['SMS']['count'] = (string)"$AM_CountInboxUnRead";
        $Measures['SMS']['unread'] = (string)"$AM_NEw";
        return $Measures;
    }

    public static function SaleReports($userid)
    {
        $result = "";
        $AM_CountShopping = 0;
        $AM_CountShopping = DB::table('shopping_cart')
            ->where('uid', $userid)->where('finall', '0')->select('id')->count();
        $Measures['Shopping']['count'] = "$AM_CountShopping";
        $Measures['Shopping']['unread'] = '0';
        $AM_CountFactors = DB::table('factors')
            ->where('uid', $userid)->where('pay', '2')->select('id')->count();
        $Measures['Sale']['count'] = "$AM_CountFactors";
        $Measures['Sale']['unread'] = '0';
        return $Measures;
    }

    public static function Forms($userid)
    {
        $result = "";
        $AM_CountShopping = 0;
        $AM_CountShopping = DB::table('forms')
            ->where('admin', $userid)
            ->select('id')
            ->count();
        $Measures['Forms']['count'] = "$AM_CountShopping";
        $Measures['Forms']['unread'] = '0';
        return $Measures;
    }

    public static function Emails($userid)
    {
        $result = "";
        $AM_CountShopping = 0;
        $AM_CountShopping = DB::table('emails')
            ->where('uid', $userid)
            ->select('id')
            ->count();
        $AM_Countnew = DB::table('emails')
            ->where('uid', $userid)
            ->where('read', 0)
            ->where('view', 0)
            ->select('id')
            ->count();
        $Measures['Forms']['count'] = "$AM_CountShopping";
        $Measures['Forms']['unread'] = "$AM_Countnew";
        return $Measures;
    }

    public static function NumberofUsers()
    {
        $AM_CountNew = DB::table('user')
            ->where('new', '0')
            ->where('active', '1')
            ->select('id')
            ->count();
        $AM_Count = DB::table('user')
            ->select('id')
            ->where('active', '1')
            ->whereRaw("email !=''")
            ->count();
        $Measures['User']['count'] = "$AM_Count";
        $Measures['User']['unread'] = "$AM_CountNew";

        $AM_Count = DB::table('user_group')
            ->where('isorgan', '1')
            ->select('id')
            ->count();
        $Measures['Organs']['count'] = "$AM_Count";
        $Measures['Organs']['unread'] = '0';
        $AM_Count = DB::table('user_group')
            ->where('isorgan', '0')
            ->select('id')
            ->count();
        $Measures['Group']['count'] = "$AM_Count";
        $Measures['Group']['unread'] = '0';

        $Measures['OnlineUser']['count'] = "$AM_Count";
        $Measures['OnlineUser']['unread'] = "$AM_CountNew";
        return $Measures;
    }

}
