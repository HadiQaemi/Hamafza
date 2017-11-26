<?php

namespace App\HamafzaGrids;

use App\HamafzaPublicClasses\GridClass;
use Illuminate\Support\Facades\DB;
use App\HamafzaViewClasses\AJAX;

class SubjectGrids {

    public static function ModalSubView($data) {
        $GC = new GridClass();
        $GC->AddHidenCol("pid", 'pid');
        $GC->AddCol("نوع", 'title', '50');
        $s = $GC->Grid(json_encode($data));
        return $s;
    }

    public static function Page($data) {

        $GC = new GridClass();
        $GC->AddHidenCol("id", 'id');
        $GC->AddColLink('عنوان', 'title', 'id', 'title', 200, 'false', '_blank', 'right');
        $GC->AddCol("نوع", 'subjectkind', '50');
        $GC->AddCol("بازدید", 'visit', '35');
        $GC->AddCol("پسند", 'like', '35');
        $GC->AddCol("دنبال", 'follow', '35');
        $GC->AddCol("ثبت", 'reg_date', '40');
        $GC->AddCol("ویرایش", 'edit_date', '40');

        $s = $GC->Grid(json_encode($data));
        return $s;
    }

    public static function Pageinsubject($data) {
        $GC = new GridClass('pop');
        $GC->AddHidenCol("pid", 'pid');
        $GC->AddColLink('عنوان', 'title', 'pid', 'title', '200', false);
        $GC->AddCol("تاریخ ویرایش", 'edit_date', '35');
        $s = $GC->PopGrid(json_encode($data));
        return $s;
    }

    public static function Lists($data) {
        $grid = \DataGrid::source($data)->paginate(50)->getSet();
        $grid->add('sortid', 'ردیف')->style("width:100px");
        $grid->add('id', 'ID', true)->style("display:none");
        $grid->add('name', '	عنوان');
        $grid->add('comment', 'توضیح');
        $grid->add('nums', 'تعداد');

        $grid->add('reg_date', 'تاریخ ثبت');
        $grid->add('edit', 'ویرایش');
        $grid->add('del', 'حذف');
        $grid->paginate(25);
        $grid->row(function ($row) {
            $row->cell('id')->style("display:none");
            $row->cell('edit')->value = '<div style="height:10px;"><a href="edit?id=' . $row->cell('id')->value . '"><span class="fonts icon-alamatgozari" ></span> </a></div>';
            $row->cell('del')->value = '<div style="height:10px;"><span style="border:0px; cursor:pointer"  id="' . $row->cell('id')->value . '" action="delete" page="Forms" class="fonts icon-hazv Delicn" ></span></div>';
        });

        return $grid;
    }

    public static function Asubjects($data) {
        $grid = \DataGrid::source($data)->paginate(10)->getSet();
        $grid->add('sortid', 'ردیف')->style("width:100px");
        $grid->add('name', 'نام', true);
        $grid->add('pretitle', 'پیش عنوان', true);

        $grid->add('subjectname', 'صفحه بندی');
        $grid->add('charchoob', 'چارچوب');
        $grid->add('pid', 'تاریخ', false)->style("display:none");
        $grid->paginate(10);
        $grid->row(function ($row) {
            if ($row->cell('charchoob')->value == 'charchoob') {
                $row->cell('charchoob')->value = 'ندارد';
            }
            $row->cell('pid')->style("display:none");
        });
        return $grid;
    }

    public static function SubjectLists($uid) {
        $SP = new \App\HamafzaServiceClasses\ConfigurationClass();
        $data = $SP->GetSubjectType($uid, 0);
        $GC = new GridClass();
        $GC->AddHidenCol("id", 'id');
        $GC->AddCol("عنوان", 'name', '200');
        $GC->AddCol("توضیح", 'comment', '35');
        $GC->AddColPop("تعداد", 'nums', 'id', 'تعداد', 35, 'false', 'pageinsubject');
        $GC->AddCol("تاریخ ثبت", 'reg_date', '35');
        $GC->AddColEdit("ویرایش", 'id', 'subjects/', '15');
        $GC->AddColDelete("حذف", 'id', 'subjects', '15');
        $s = $GC->Grid(json_encode($data));
        return $s;
    }

    public static function GetRelations() {

        $data = \App\Models\hamafza\Relations::all();
        $GC = new GridClass();
        $GC->AddHidenCol("id", 'id');
        $GC->AddCol("عنوان", 'name', '200');
        $GC->AddColEdit("ویرایش", 'id', 'relations/', '15');
        $GC->AddColDelete("حذف", 'id', 'relations', '15');
        $s = $GC->Grid(json_encode($data));
        return $s;
    }

    /*
    public static function Helps() {
        $page = array();
        $pages = DB::table('pages as p')
            ->join('subjects as s', 's.id', '=', 'p.sid')
            ->select('p.id', 's.title', 'p.body')
            ->whereRaw("body like '%{{Help+%'")
            ->get();
        $op = '';
        $ss = array();
        $i = 1;
        foreach ($pages as $page) {
            $body = $page->body;
            $pattern = "/{{Help\+.*=.*}}/";
            if ($num1 = preg_match_all($pattern, $body, $array)) {
                for ($x = 0; $x < $num1; $x++) {
                    $orig = $array['0'][$x];
                    $key = str_replace("{{Help+", "", $array['0'][$x]);
                    $key = str_replace("}}", "", $key);
                    $pos = strpos($key, "=");
                    $key = substr($key, $pos + 1, strlen($key) - $pos);
                    $Rel = '';
                    $pages = DB::table('page_help_groups')->where('R', $orig)->get();
                    foreach ($pages as $values) {
                        $v = $values->T;
                        $keys = str_replace("{{Help+", "", $v);
                        $keys = str_replace("}}", "", $keys);
                        $pos = strpos($keys, "=");
                        $keys = substr($keys, $pos + 1, strlen($keys) - $pos);
                        $Rel .= ',' . $keys;
                    }

                    $s = array("pid" => $page->id, "page_title" => $page->title, "title" => $key, "orig" => $orig, "sortid" => $i, "Rel" => $Rel);
                    $pages = DB::table('page_help_groups')->where('T', $orig)->get();
                    foreach ($pages as $values) {
                        $v = $values->R;
                        $keys = str_replace("{{Help+", "", $v);
                        $keys = str_replace("}}", "", $keys);
                        $pos = strpos($keys, "=");
                        $keys = substr($keys, $pos + 1, strlen($keys) - $pos);
                        $Rel .= ',' . $keys;
                    }
                    $s = array("pid" => $page->id, "page_title" => $page->title, "title" => $key, "orig" => $orig, "sortid" => $i, "Rel" => $Rel);
                    array_push($ss, $s);
                    $i++;
                }
            }
        }
        $data = json_encode($ss, true);
        $GC = new GridClass();
        $GC->AddHidenCol("id", 'id');
        $GC->AddHidenCol("orig", 'orig');
        $GC->AddHidenCol("pid", 'pid');
        $GC->AddCol("عنوان راهنما", 'title', '60');
        $GC->AddColLink('صفحه', 'page_title', 'pid', 'page_title', '120');
        $GC->AddCol("پیوندها (این موارد را نیز ببینید)", 'Rel', '60');
        $GC->AddEditPop('صفحه', 'pid', 'orig', 'aaaaaa', 100, false, 'helprel', 'center', "orig", '&pid=', 'pid');
        $s = $GC->Grid(json_encode($data));
        return $s;
        $grid = \DataGrid::source($data)->paginate(50)->getSet();
        $grid->add('sortid', 'ردیف')->style("width:100px");
        $grid->add('page_title', 'عنوان صفحه');
        $grid->add('title', 'عنوان راهنما');
        $grid->add('orig', 'عنوان راهنما')->style("display:none");
        $grid->add('pid', 'عنوان راهنما')->style("display:none");
        $grid->add('Rel', 'روابط');
        $grid->add('edit', 'ویرایش');
        $grid->paginate(25);
        $grid->row(function ($row) {
            $row->cell('page_title')->value = '<a style="float: right;"  href="' . Request::root() . '/' . $row->cell('pid')->value . '" target="_blank">' . $row->cell('page_title')->value . '</a></div>';

            $row->cell('orig')->style("display:none");
            $row->cell('pid')->style("display:none");
            $row->cell('edit')->value = '<div style="height:10px;"><a class="jsPanels" height="600" title="راهنمای اینجا- روابط" href="' . Request::root() . '/modals/helprel?pid=' . $row->cell('pid')->value . '&orig=' . $row->cell('orig')->value . '&title=' . $row->cell('title')->value . '"><span class="fonts icon-alamatgozari"></span></a></div>';
        });
        return $grid;
    }
    */

    /*
    public static function help()
    {
        $data = \App\Models\Hamahang\Help::all();
        //dd($data[0]->usage_count);
        $grid_class = new GridClass();
        $grid_class->AddHidenCol('id', 'id');
        $grid_class->AddCol('عنوان', 'name', '200');
        $grid_class->AddCol('صفحات', 'usage_count', '200');
        $grid_class->AddColEdit('ویرایش', 'id', 'relations/', '15');
        $grid_class->AddColDelete('حذف', 'id', 'relations', '15');
        return $grid_class->Grid(json_encode($data));
    }
    */

}
