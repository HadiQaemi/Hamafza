<?php
namespace App\HamafzaServiceClasses;

use Illuminate\Support\Facades\DB;
class SubjectRelation {

    public function isTree($pid, $sid, $title) {
//        $pages = DB::table('pageTree as pt')->join('pages AS p', 'p.id', '=', 'pt.tid')->leftJoin('subjects as s', 'p.sid', '=', 's.id')->select('s.title', 'pt.tid as id')->where('pt.pid', $pid)->groupBy('s.id')->get();
//        $rel[0]['id'] = $pid;
//        $rel[0]['title'] = $title;
//        $Rel['right'] = $pages;
//        $Rel['left'] = $rel;
//        if ($pages && $Rel['right'] != $Rel['left'])
//            return $Rel;
//        else
            return '';
    }

    function TopRels($pid, $title, $sid, $shart, $cur = 0) {
        $Self = 0;
        if ($cur != 0) {
            $pages = DB::table('pages as p')->leftJoin('subjects as s', 'p.sid', '=', 's.id')->select('s.title', 'pt.tid as id')->where('sid', $cur)->whereRaw($shart)->groupBy('s.id')->first();
            if ($pages)
                $Self = $pages->id;
        }
        $Res1 = '';
        $pages1[0]['title'] = $title;
        $pages1[0]['id'] = $pid;

        $pages = DB::table('subjects_rel as sr')->join('subjects as s', 'sr.sid1', '=', 's.id')->join('pages as p', 'sr.sid1', '=', 'p.sid')
                        ->select('s.title', 'p.id')->where('sid2', $sid)->whereRaw($shart)->whereRaw('(rel=1 or rel=3 or rel=5 or rel=17)')->orderBy('sr.id', 'desc')->get();
        $Rel['left'] = $pages;
        $pages2 = DB::table('subjects_rel as sr')->join('subjects as s', 'sr.sid2', '=', 's.id')->join('pages as p', 'sr.sid2', '=', 'p.sid')
                        ->select('s.title', 'p.id')->where('sid1', $sid)->whereRaw($shart)->whereRaw('(rel=7 or rel=10)')->orderBy('sr.id', 'desc')->get();
        if (!$pages2)
            $pages2 = $pages1;
        $Rel['right'] = $pages1;
        if ($pages)
            return $Rel;
        else {
            $Rel['right'] = '';
            $Rel['left'] = '';

            return $Rel;
        }
    }

    function TopRel($pid, $title, $sid, $shart, $cur = 0) {
        $Self = 0;
        if ($cur != 0) {
            $pages = DB::table('pages as p')->leftJoin('subjects as s', 'p.sid', '=', 's.id')->select('s.title', 'pt.tid as id')->where('sid', $cur)->whereRaw($shart)->groupBy('s.id')->first();
            if ($pages)
                $Self = $pages->id;
        }
        $Res1 = '';
        $pages1[0]['title'] = $title;
        $pages1[0]['id'] = $pid;

        $pages = DB::table('subjects_rel as sr')->join('subjects as s', 'sr.sid1', '=', 's.id')->join('pages as p', 'sr.sid1', '=', 'p.sid')
                        ->select('s.title', 'p.id')->where('sid2', $sid)->whereRaw($shart)->whereRaw('(rel=1 or rel=3 or rel=5 or rel=17)')->orderBy('sr.id', 'desc')->get();
        $Rel['left'] = $pages;
        $pages2 = DB::table('subjects_rel as sr')->join('subjects as s', 'sr.sid2', '=', 's.id')->join('pages as p', 'sr.sid2', '=', 'p.sid')
                        ->select('s.title', 'p.id')->where('sid1', $sid)->whereRaw($shart)->whereRaw('(rel=7 or rel=10)')->orderBy('sr.id', 'desc')->get();
        if (!$pages2)
            $pages2 = $pages1;
        $Rel['right'] = $pages1;
        return $pages;
    }

    function SubRel($pid, $title, $sid, $shart) {
        $RES = array();
        $Res2 = '';
        $pages = DB::table('subjects_rel as sr')->join('subjects as s', 'sr.sid2', '=', 's.id')->join('pages as p', 'sr.sid2', '=', 'p.sid')
                        ->select('s.title', 's.id as Sid', 'p.id')->where('sid1', $sid)->whereRaw($shart)->whereRaw('(rel=1 or rel=3 or rel=5 or rel=17)')->orderBy('sr.id', 'desc')->get();
        foreach ($pages as $value) {
            $count = DB::table('asubjects')->where('cid', $value->Sid)->count();
            $pretitles = '';
            if ($count > 0)
                $pretitles = 'چارچوب';
            $value->title = $pretitles . ' ' . $value->title;
            $res['right'][0]['id'] = $value->id;
            $res['right'][0]['title'] = $value->title;
            $res['left'] = $this->TopRel($value->id, $value->title, $value->Sid, $shart);
            array_push($RES, $res);
        }
        $Rel['right'] = $pages;
        $pages = DB::table('subjects_rel as sr')->join('subjects as s', 'sr.sid1', '=', 's.id')->join('pages as p', 'sr.sid1', '=', 'p.sid')
                        ->select('s.title', 'p.id')->where('sid2', $sid)->whereRaw($shart)->whereRaw('(rel=7 or rel=10)')->orderBy('sr.id', 'desc')->get();
        $Rel['left'] = $pages;
        foreach ($pages as $value) {
            $res['right'][0]['id'] = $value->id;
            $res['right'][0]['title'] = $value->title;
            $res['left'] = $this->TopRel($value->id, $value->title, $value->Sid, $shart);
            array_push($RES, $res);
        }


        return $RES;
    }

    public function Rel($pid, $sid, $title) {
        $rels = array();
        $Rels = array();

        $SubjectTitle = $title;
        $SubjectID = $pid;
        $relations = DB::table('relations')->get();
        $rowsCount = DB::table('subjects_rel as sr')->leftjoin('subjects as s', 's.id', '=', 'sr.sid1')
                        ->leftjoin('pages as p', 'p.sid', '=', 's.id')
                        ->leftjoin('relations as r', 'r.id', '=', 'sr.rel')
                        ->where('s.archive', '0')->where('r.parent', '1')
                        ->where('s.list', '=', '1')
                        ->where('s.ispublic', '=', '1')
                        ->where('sr.sid2', $sid)
                        ->select('sr.rel', 'p.id', 's.title')->get();
        foreach ($relations as $row) {
            $rel = array();
            $rel['SubjectTitle'] = $SubjectTitle;
            $rel['SubjectID'] = '';
            $rel['title'] = $row->directname;
            $rel['DaricheTitle'] = $row->dariche_inver;
            $rel['pages'] = array();
            foreach ($rowsCount as $r) {
                if ($r->rel == $row->id)
                    array_push($rel['pages'], $r);
            }
            if (count($rel['pages']) > 0)
                array_push($rels, $rel);
        }

        
         $rowsCount = DB::table('subjects_rel as sr')->leftjoin('subjects as s', 's.id', '=', 'sr.sid2')
                        ->leftjoin('pages as p', 'p.sid', '=', 's.id')
                        ->leftjoin('relations as r', 'r.id', '=', 'sr.rel')
                        ->where('s.archive', '0')->where('r.parent', '1')
                        ->where('s.list', '=', '1')
                        ->where('s.ispublic', '=', '1')
                        ->where('sr.sid1', $sid)
                        ->select('sr.rel', 'p.id', 's.title')->get();
        foreach ($relations as $row) {
            $rel = array();
            $rel['SubjectTitle'] = $SubjectTitle;
            $rel['SubjectID'] = '';
            $rel['title'] = $row->directname;
            $rel['DaricheTitle'] = $row->dariche;
            $rel['pages'] = array();
            foreach ($rowsCount as $r) {
                if ($r->rel == $row->id)
                    array_push($rel['pages'], $r);
            }
            if (count($rel['pages']) > 0)
                array_push($rels, $rel);
        }

        
        

        $rowsCount = DB::table('subjects_rel as sr')->leftjoin('subjects as s', 's.id', '=', 'sr.sid2')
                        ->leftjoin('pages as p', 'p.sid', '=', 's.id')
                ->leftjoin('relations as r', 'r.id', '=', 'sr.rel')
                ->whereRaw(PageClass::Sel_Page())
                        ->where('s.archive', '0')->where('r.parent', '0')
                        ->where('s.list', '=', '1')
                        ->where('s.ispublic', '=', '1')
                        ->where('sr.sid1', $sid)
                        ->select('sr.rel', 'p.id', 's.title')->get();
         //->whereRaw(PageClass::Sel_Page())
        foreach ($relations as $row) {
            $rel = array();
            $rel['SubjectTitle'] = $SubjectTitle;
            $rel['SubjectID'] = $SubjectID;
            $rel['title'] = $row->directname;
            $rel['DaricheTitle'] = $row->dariche;
            $rel['pages'] = array();
            foreach ($rowsCount as $r) {
                if ($r->rel == $row->id)
                    array_push($rel['pages'], $r);
            }
            if (count($rel['pages']) > 0)
                array_push($rels, $rel);
        }

       

        $rowsCount = DB::table('subjects_rel as sr')->leftjoin('relations as r', 'r.id', '=', 'sr.rel')
                        ->where('sr.sid2', $sid)->where('parent', 0)
                        ->select('sr.sid1', 'rel')->get();
        foreach ($rowsCount as $row) {
            $Subject = DB::table('subjects as s')->leftjoin('pages as p', 'p.sid', '=', 's.id')
                    ->leftjoin('subject_type as st', 'st.id', '=', 's.kind')
                 ->whereRaw(PageClass::Sel_Page())
                    ->where('s.id', $row->sid1)
                    ->select('p.id', 's.title', 'st.pretitle')
                    ->first();
               //->whereRaw(PageClass::Sel_Page())
            $SubjectTitle = ($Subject) ? $Subject->pretitle . ' ' . $Subject->title : '';
            $SubjectID = ($Subject) ? $Subject->id : '0';

            $rowsCounts = DB::table('subjects_rel as sr')->leftjoin('subjects as s', 's.id', '=', 'sr.sid2')
                            ->leftjoin('pages as p', 'p.sid', '=', 's.id')
                            ->leftjoin('subject_type as st', 'st.id', '=', 's.kind')
                            ->where('s.archive', '0')
                            ->where('s.list', '=', '1')
                            ->where('s.ispublic', '=', '1')
                            ->where('sr.sid1', $row->sid1)
                            ->where('sr.rel', $row->rel)
                                                            ->whereRaw(PageClass::Sel_Page())

                            ->select('sr.rel', 'p.id', 's.title', 'st.pretitle')->get();

            foreach ($relations as $rows) {
                $rel = array();
                $rel['SubjectTitle'] = $SubjectTitle;
                $rel['SubjectID'] = $SubjectID;
                $rel['title'] = $rows->directname;
                $rel['DaricheTitle'] = $rows->dariche;
                $rel['pages'] = array();
                foreach ($rowsCounts as $r) {
                    if ($r->rel == $rows->id)
                        array_push($rel['pages'], $r);
                }
                if (count($rel['pages']) > 0)
                    array_push($rels, $rel);
            }


//            $rel = array();
//            $rel['titlePage'] = $row->Inversename;
//            $rel['title'] = $row->Inversename;
//            $rel['DaricheTitle'] = $row->dariche;
//            $rel['pages'] = array();
//            foreach ($rowsCount as $r) {
//                if ($r->rel == $row->id)
//                    array_push($rel['pages'], $r);
//            }
//            if (count($rel['pages']) > 0)
//                array_push($rels, $rel);
        }


        return $rels;

//        $first = DB::table('subjects_rel as sr')->join('subjects as s', 'sr.sid2', '=', 's.id')->join('pages as p', 'sr.sid2', '=', 'p.sid')
//                        ->select('s.title', 'p.id')->where('sid1', $sid)->whereRaw('(rel=15)')->whereRaw(PageClass::Sel_Page());
//        $second = DB::table('subjects_rel as sr')->join('subjects as s', 'sr.sid2', '=', 's.id')->join('pages as p', 'sr.sid2', '=', 'p.sid')
//                        ->select('s.title', 'p.id')->where('sid2', $sid)->whereRaw('(rel=15)')->whereRaw(PageClass::Sel_Page())->union($first)->get();
//        $res = $this->TopRels($pid, $title, $sid, PageClass::Sel_Page());
//        $res2 = $this->SubRel($pid, $title, $sid, PageClass::Sel_Page());
//        $res3 = $this->isTree($pid, $sid, $title);
//        $Rs['2'] = '';
//        if ($second) {
//            $res4['right'][0]['id'] = $pid;
//            $res4['right'][0]['title'] = $title;
//            $res4['left'] = $second;
//            $Rs['2'] = $res4;
//            foreach ($second as $key => $value) {
//                if ($key == 0 && $value->id == $pid)
//                    $Rs['2'] = '';
//            }
//        }
//        $Rs['1'] = $res;
//        $Rs['3'] = $res2;
//        $Rs['4'] = $res3;
//
//        return $Rs;
    }

    
    public function Relssss($pid, $sid, $title) {
        $first = DB::table('subjects_rel as sr')->join('subjects as s', 'sr.sid2', '=', 's.id')->join('pages as p', 'sr.sid2', '=', 'p.sid')
                        ->select('s.title', 'p.id')->where('sid1', $sid)->whereRaw('(rel=15)')->whereRaw(PageClass::Sel_Page());
        $second = DB::table('subjects_rel as sr')->join('subjects as s', 'sr.sid2', '=', 's.id')->join('pages as p', 'sr.sid2', '=', 'p.sid')
                        ->select('s.title', 'p.id')->where('sid2', $sid)->whereRaw('(rel=15)')->whereRaw(PageClass::Sel_Page())->union($first)->get();
        $res = $this->TopRels($pid, $title, $sid, PageClass::Sel_Page());
        $res2 = $this->SubRel($pid, $title, $sid, PageClass::Sel_Page());
        $res3 = $this->isTree($pid, $sid, $title);
        $Rs['2'] = '';
        if ($second) {
            $res4['right'][0]['id'] = $pid;
            $res4['right'][0]['title'] = $title;
            $res4['left'] = $second;
            $Rs['2'] = $res4;
            foreach ($second as $key => $value) {
                if ($key == 0 && $value->id == $pid)
                    $Rs['2'] = '';
            }
        }
        $Rs['1'] = $res;
        $Rs['3'] = $res2;
        $Rs['4'] = $res3;

        return $Rs;
    }

}
