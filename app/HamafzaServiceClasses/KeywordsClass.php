<?php

namespace App\HamafzaServiceClasses;

use App\Models\hamafza\Keyword;
use Illuminate\Support\Facades\DB;

class KeywordsClass
{

    public function TagsSearch($keyword)
    {
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


        $mSql2 = "SELECT  CONCAT(LEFT(p.desc, 50),'...') as matn,p.id as pid,sid,uid,u.Uname
					FROM 
						posts as p inner join `user` as u on p.uid=u.id 
					
					WHERE p.id in ({$subsql2}) ";
        $Posts = DB::select(DB::raw($mSql2));

        $mSql3 = "select ug.name,ug.link,ug.id from user_group as ug INNER JOIN user_group_key as ugk on ug.id=ugk.gid 
					WHERE ug.id in ({$subsql3}) group by ug.id";
        $Groups = DB::select(DB::raw($mSql3));
        if ($i > 1)
        {
            $mSql = "SELECT p.id as pid, p.sid , s.title as title , s.kind , p.type
					FROM 
						pages as p 
					RIGHT JOIN 
						subjects as s 
					ON 
						p.sid = s.id AND s.archive = 0 
					WHERE s.id in ({$subsql}) AND " . PageClass::Sel_Page();
            $Pages = DB::select(DB::raw($mSql));
            $res['Pages'] = $Pages;
            $res['Users'] = '';
            $res['Groups'] = '';
            $res['Posts'] = '';

        }
        else
        {
            if ($i == 1)
            {
                $d = DB::table('pages as p')->rightJoin('subjects AS s', 'p.sid', '=', 's.id')->leftJoin('subject_key AS c', 's.id', '=', 'c.sid')
                    ->where('s.archive', '0')->where('c.kid', $keyword)->whereRaw(PageClass::Sel_Page())
                    ->select('p.id as pid', 'p.sid', 's.title as title', 's.kind', 'p.type')
                    ->get();
                $Pages = $d;
                $U1 = array();
                $U2 = array();
                $U3 = array();

                $mSql4 = "select ttype,keyword from keywords where id={$keyword}";
                $query4 = DB::select(DB::raw($mSql4));
                $x = 0;
                foreach ($query4 as $value)
                {
                    $ttype = $value->ttype;
                    $keyword = $value->title;
                }
                if ($ttype == '16' || $ttype == '20')
                {
                    $sqls = "select u.`Name`,u.Family,u.Uname from user_education as ue INNER JOIN `user` as u on ue.uid=u.id where university='{$keyword}'  group by u.id";
                    $U1 = DB::select(DB::raw($sqls));
                }
                if ($ttype == '12' || $ttype == '20')
                {
                    $sqls = "select u.`Name`,u.Family,u.Uname from user_work as ue INNER JOIN `user` as u on ue.uid=u.id  where company='{$keyword}' group by u.id";
                    $U2 = DB::select(DB::raw($sqls));
                }
                if ($ttype == '17' || $ttype == '20')
                {
                    $sqls = "select u.`Name`,u.Family,u.Uname from user_special as ue INNER JOIN `user` as u on ue.uid=u.id  where ue.name='{$keyword}' group by u.id";
                    $U3 = DB::select(DB::raw($sqls));
                }
                $USERS = $U3 + $U1 + $U2;
                $res['Users'] = $USERS;
                $res['Groups'] = $Groups;
                $res['Pages'] = $Pages;
                $res['Posts'] = $Posts;
            }
        }
        return Response::json(array(
            'error' => 'false',
            'data' => $res), 200
        )->setCallback(Input::get('callback'));
    }

    public static function keyrel($id)
    {
        $allow = TRUE;
        $code = '';
        $ar = array();
        $Rels = array();
        $res = '<table class="table">';
        $rs = DB::table('keywords')
            ->select('keyword', 'title as caption', 'code', 'pic', 'morajah', 'id')
            ->where('id', $id)
            ->first();

// array_push($ar, $rs);
        if ($rs)
        {
            $Rels['id'] = $id;
            $Rels['label'] = $rs->keyword;
            array_push($ar, $Rels);
            if ($rs->morajah != '0')
            {
                $allow = FALSE;
            }
            if ($rs->code != '')
            {
                $code = ' , ' . $rs->code;
            }
            $res .= '<tr><td colspan=2><b>' . $rs->title . $code . '</b> </td></tr>';
            if ($rs->pic != '')
            {
                $pic = $rs->pic;
                $res .= '<tr><td colspan=2><img style="max-width:150px;" src="' . $pic . '"/></td></tr>';
            }
        }
        $Rel = array();
        $Rel2 = array();

        if ($allow == TRUE)
        {
            $rs = DB::table('keyword_relations as kr')
                ->join('keywords as k', 'k.id', '=', 'kr.keyword_2_id')
                ->select('title', 'title as caption', 'k.id', 'relation_type', 'keyword_2_id')
                ->where('keyword_1_id', $id)
                ->whereRAW('relation_type in (1,3,5,2,4,6,7,8,9,10,11,12,13,14,15,16)')
                ->groupBy('k.id')
                ->get();

            $Hamarz = '';
            $Mor = '';
            $arabic = '';
            $english = '';
            $kootah = '';
            $hambaste = '';
            $mesdagh = '';
            $ajza = '';
            $jozmes = '';
            $eshterak = '';
            $eshteb = '';
            $motzazad = '';
            foreach ($rs as $value)
            {
                $Rels['id'] = $value->id;
                $Rels['label'] = $value->keyword;
                array_push($ar, $Rels);
                $Rel['from'] = $id;
                $Rel['to'] = $value->keyid2;
                $rel = $value->rel;
                switch ($rel)
                {
                    case '1':
                        ////$Rel['caption'] = 'اجزاء';
                        $ajza .= $value->title . '، ';
                        break;
                    case '3':
                        ////$Rel['caption'] = 'مصداق';

                        $mesdagh .= $value->title . '، ';
                        break;
                    case '5':
                        // //$Rel['caption'] = 'جزء مصداق';
                        $jozmes .= $value->title . '، ';
                        break;
                    case '7':
                        $Hamarz .= $value->title . '، ';
                        // //$Rel['caption'] = 'هم عرض';

                        break;
                    case '8':
                        $Mor .= $value->title . '، ';
                        // //$Rel['caption'] = 'مسسس';

                        break;

                    case '9':
                        //$Rel['caption'] = 'همبسته';
                        $hambaste .= $value->title . '، ';
                        break;
                    case '10':
                        //$Rel['caption'] = 'مشترک';

                        $eshterak .= $value->title . '، ';
                        break;
                    case '11':
                        //$Rel['caption'] = 'کوته نوشت';

                        $kootah .= $value->title . '، ';
                        break;
                    case '12':
                        //$Rel['caption'] = 'انگلیسی';

                        $english .= $value->title . '، ';
                        break;

                    case '13':
                        //$Rel['caption'] = 'عربی';

                        $arabic .= $value->title . '، ';
                        break;
                    case '15':
                        //$Rel['caption'] = 'متضاد';

                        $motzazad .= $value->title . '، ';
                        break;
                    case '16':
                        //$Rel['caption'] = 'اشتب';

                        $eshteb .= $value->title . '، ';
                        break;
                }
                array_push($Rel2, $Rel);
            }
            if ($ajza != '')
            {
                $ajza = '<tr><td width="110" style="text-align:right;font-weight:bold;">اجزاء</td><td style="text-align:right;">' . $ajza . '</td></tr>';
            }
            if ($mesdagh != '')
            {
                $mesdagh = '<tr><td width="110" style="text-align:right;font-weight:bold;">مصادیق</td><td style="text-align:right;">' . $mesdagh . '</td></tr>';
            }
            if ($jozmes != '')
            {
                $jozmes = '<tr><td width="110" style="text-align:right;font-weight:bold;">اجزاء و مصادیق</td><td style="text-align:right;">' . $jozmes . '</td></tr>';
            }
            if ($Hamarz != '')
            {
                $Hamarz = '<tr><td width="110" style="text-align:right;font-weight:bold;">هم ارزها</td><td style="text-align:right;">' . $Hamarz . '</td></tr>';
            }
            if ($Mor != '')
            {
                $Mor = '<tr><td width="110" style="text-align:right;font-weight:bold;">اصطلاح مرجح</td><td style="text-align:right;">' . $Mor . '</td></tr>';
            }
            if ($english != '')
            {
                $english = '<tr><td width="110" style="text-align:right;font-weight:bold;">هم‌ارز در انگلیسی</td><td style="text-align:right;">' . $english . '</td></tr>';
            }
            if ($arabic != '')
            {
                $arabic = '<tr><td width="110" style="text-align:right;font-weight:bold;">هم‌ارز در عربی</td><td style="text-align:right;">' . $arabic . '</td></tr>';
            }
            if ($hambaste != '')
            {
                $hambaste = '<tr><td width="110" style="text-align:right;font-weight:bold;">وابسته‌ها</td><td style="text-align:right;">' . $hambaste . '</td></tr>';
            }
            if ($eshterak != '')
            {
                $eshterak = '<tr><td width="110" style="text-align:right;font-weight:bold;">هم‌نویسه(اشتراک لفظی)</td><td style="text-align:right;">' . $eshterak . '</td></tr>';
            }
            if ($kootah != '')
            {
                $kootah = '<tr><td width="110" style="text-align:right;font-weight:bold;">کوته‌نوشت</td><td style="text-align:right;">' . $kootah . '</td></tr>';
            }
            if ($eshteb != '')
            {
                $eshteb = '<tr><td width="110" style="text-align:right;font-weight:bold;">اشتباه نشود</td><td style="text-align:right;">' . $eshteb . '</td></tr>';
            }
            if ($motzazad != '')
            {
                $motzazad = '<tr><td width="110" style="text-align:right;font-weight:bold;">متضاد</td><td style="text-align:right;">' . $motzazad . '</td></tr>';
            }
            //$rel = $admins->rel_keywords_thesarus($id);
            $res .= $ajza;
            $res .= $mesdagh;
            $res .= $jozmes;
            $res .= $Hamarz;
            $res .= $Mor;
            $res .= $english;
            $res .= $arabic;
            $res .= $hambaste;
            $res .= $eshterak;
            $res .= $kootah;
            $res .= $motzazad;
            $res .= $eshteb;
        }
        $res .= '</table>';
        $mes['table'] = $res;
        $mes['keywords'] = $ar;
        $mes['relations'] = $Rel2;

        return Response::json(array(
            'error' => 'false',
            'data' => $mes), 200
        )->setCallback(Input::get('callback'));
    }

    public function AddThesaurus($uid, $session_id, $name, $edit, $id)
    {
        $user = UserClass::CheckLogin($uid, $session_id);
        $user = ($user == TRUE) ? true : false;
        if ($user)
        {
            if (UserClass::permission('newtag', $uid) == '1')
            {
                if ($edit == 'ok')
                {
                    DB::table('thesaurus')->where('id', $id)->update(['name' => $name]);
                }
                else
                {
                    DB::table('thesaurus')->insert(['name' => $name, 'reg_date' => 'NOW()', 'reg_uid' => $uid]);
                }
                //DB::table('thesarus')->insert(['name' => $name, 'reg_date' => 'NOW()', 'reg_uid' => $uid]);
                $mes = trans('labels.Thesarus_add');
                $err = false;
            }
            else
            {
                $mes = trans('labels.FailUser');
                $err = true;
            }
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

    public function GetThesarus()
    {
        $urls = DB::table('subjects as s')
            ->join('subject_type_tab AS sk', 's.kind', '=', 'sk.stid')
            ->where('sk.type', '20')
            ->select('s.title', 's.id')
            ->groupby('s.id')->get();
        $i = 1;
        foreach ($urls as $value)
        {
            $value->sortid = $i;
            $i++;
        }
        return Response::json(array(
            'error' => false,
            'data' => $urls), 200
        )->setCallback(Input::get('callback'));
    }

    public function GetPublicKeyword()
    {
        $keywords = Keyword::whereHas('subjects')->select('id', 'title AS text')/*->withCount('subjects')*/->get();
        $i = 0;
        foreach ($keywords as $keyword)
        {
            $keyword->sortid = $i++;
        }
        return $keywords;
    }
}
