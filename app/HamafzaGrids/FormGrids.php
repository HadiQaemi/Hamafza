<?php

namespace App\HamafzaGrids;

use App\HamafzaPublicClasses\GridClass;
use Illuminate\Support\Facades\DB;

class FormGrids {

    public static function Lists($data, $sublink) {
        $GC = new GridClass();
        $GC->AddHidenCol("id", 'id');
        $GC->AddColPop('عنوان', 'title', 'id', 'title', '200', false, 'formshow', 'right', 'id');
        if ($sublink == 'me') {
            $GC->AddCol("تاریخ", 'resdate', '35');
            $GC->FormAnser('پاسخ', 'n', 'id', 'n', '35', false, 'editrports', 'right');
        } else {
            $GC->AddColPop('صفحات', 'pids', 'id', 'id', '20', false, 'viewsubjects', 'right', 'id', '&type=FormSubject');
            $GC->AddFormPop('پاسخ ها', 'nr', 'id', 'id', '20', false, 'viewreports', 'right', 'id', '');
            $GC->AddHidenCol("nr", 'nr');
            $GC->AddColCopy('کپی', 'id', 'form_list/copy?id=', '20', false, 'right');
            $GC->AddColEdit('ویرایش', 'id', 'form_list/edit?id=', '20', false, 'right');
            $GC->AddColDelete('حذف', 'id', 'Forms', '20', false, 'right');
        }
        $s = $GC->Grid(json_encode($data));
        return $s;



        $grid = \DataGrid::source($data)->paginate(50)->getSet();
        $grid->add('sortid', 'ردیف')->style("width:100px");
        $grid->add('id', 'ID', true)->style("display:none");
        $grid->add('title', '	عنوان');
        $grid->paginate(25);
        if ($sublink == 'me') {
            $grid->add('resdate', 'تاریخ پاسخ');

            $grid->add('rid', 'rID', true)->style("display:none");
            $grid->add('n', ' پاسخ ها');
            $grid->row(function ($row) {
                $row->cell('id')->style("display:none");
                $row->cell('rid')->style("display:none");
                $id = $row->cell('id')->value;
                $n = $row->cell('n')->value;
                $title = $row->cell('title')->value;
                $row->cell('title')->value = '<a href="' . Request::root() . '/modals/formshow?id=' . $id . '&tagname=safhe_dargaah&hid=139&pid=0&sid=0" title="' . $title . '" class="jsPanels">' . $title . '</a>';
                if ($row->cell('rid')->value != 'rid')
                    $row->cell('n')->value = '<a class="jsPanels" title="داده‌های فرم" href="' . Request::root() . '/modals/editrports?repid=' . $row->cell('rid')->value . '&formid=' . $row->cell('id')->value . '">مشاهده/ ویرایش</a>';
                else
                    $row->cell('n')->value = 'ندارد';
            });
        } else {
            $grid->add('pids', ' صفحات');
            $grid->add('n', ' پاسخ ها');
            $grid->add('nr', ' پاسخ ها')->style("display:none");
            $grid->add('edit', 'ویرایش');
            $grid->add('copy', 'کپی');
            $grid->add('del', 'حذف');
            $grid->row(function ($row) {
                $row->cell('id')->style("display:none");
                $pagecount = $row->cell('pids')->value;
                $id = $row->cell('id')->value;
                if ($pagecount != '0')
                    $row->cell('pids')->value = '<a class="jsPanels" title="مشاهده صفحات" href="' . Request::root() . '/modals/viewsubjects?id=' . $row->cell('id')->value . '&type=FormSubject">' . $pagecount . ' </a>';
                $n = $row->cell('n')->value;
                $nr = $row->cell('nr')->value;
                $nr = ($n != '0') ? $nr : '0';
                $title = $row->cell('title')->value;
                $row->cell('title')->value = '<a href="' . Request::root() . '/modals/formshow?id=' . $id . '&tagname=safhe_dargaah&hid=139&pid=0&sid=0" title="' . $title . '" class="jsPanels">' . $title . '</a>';
                if ($row->cell('n')->value != '0')
                    $row->cell('n')->value = '<a class="jsPanels" title="مشاهده پاسخ" href="' . Request::root() . '/modals/viewreports?id=' . $row->cell('id')->value . '">' . $nr . ' </a>';
                else
                    $row->cell('n')->value = '0';
                $row->cell('edit')->value = '<div style="height:10px;"><a href="edit?id=' . $row->cell('id')->value . '"><span class="fonts icon-alamatgozari" ></span> </a></div>';
                $row->cell('copy')->value = '<div style="height:10px;"><a href="copy?id=' . $row->cell('id')->value . '"><span class="fonts icon-2-4" style="height:10px;"></span> </a></div>';
                $row->cell('del')->value = '<div style="height:10px;"><span style="border:0px; cursor:pointer"  id="' . $row->cell('id')->value . '" action="delete" page="Forms" class="fonts icon-hazv Delicn" ></span></div>';
                $row->cell('nr')->style("display:none");
            });
        }



        return $grid;
    }

    public static function Reports($data) {
        $grid = \DataGrid::source($data)->paginate(50)->getSet();
        $grid->add('sortid', 'ردیف')->style("width:100px");
        $grid->add('id', 'ID', true)->style("display:none");

        $grid->add('rid', 'rid', true)->style("display:none");

        $grid->add('title', '	عنوان');
        $grid->add('stitle', 'عنوان موضوع');
        $grid->add('n', 'تعداد پاسخ ها');
        $grid->add('Name', 'پاسخ دهنده');
        $grid->add('Family', 'تعداد پاسخ ها')->style("display:none");
        $grid->add('Uname', 'تعداد پاسخ ها')->style("display:none");
        $grid->add('psid', 'تعداد پاسخ ها')->style("display:none");
        $grid->add('reg_date', 'تاریخ پاسخ');
        $grid->paginate(50);
        $grid->row(function ($row) {
            $row->cell('id')->style("display:none");
            $row->cell('rid')->style("display:none");
            $row->cell('psid')->style("display:none");
            $row->cell('Uname')->style("display:none");
            $stitle = ($row->cell('stitle')->value != 'stitle') ? $row->cell('stitle')->value : '';
            $row->cell('stitle')->value = "<a target='_blank' href='" . Request::root() . '/' . $row->cell('psid')->value . "'>" . $stitle . '</a>';
            $row->cell('Family')->style("display:none");
            $row->cell('Name')->value = "<a target='_blank' href='" . Request::root() . '/' . $row->cell('Uname')->value . "'>" . $row->cell('Name')->value . ' ' . $row->cell('Family')->value . '</a>';
            $row->cell('n')->value = '<a class="jsPanels" title="مشاهده پاسخ" href="' . Request::root() . '/modals/viewfromreport?formid=' . $row->cell('id')->value . '&repid=' . $row->cell('rid')->value . '">1 </a>';
        });

        return $grid;
    }

}
