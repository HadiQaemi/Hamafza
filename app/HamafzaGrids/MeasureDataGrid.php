<?php

namespace App\HamafzaGrids;

use App\HamafzaPublicClasses\GridClass;
use Illuminate\Support\Facades\DB;

class MeasureDataGrid {

    public static function ME($data) {
        $GC = new GridClass();
        $GC->AddHidenCol("id", 'id');
        $GC->AddColPop('عنوان', 'title', 'id', 'title', '200', false, 'user_measures_show', 'right', 'id');
        $GC->AddCol("وضعیت", 'checked');
        $GC->AddCol("اولویت", 'priority');
        $GC->AddColLink("واگذار کننده", 'Fname', 'uname', 'Fname');
        $s = $GC->Grid(json_encode($data));
        return view('test', array('content' => $s));
    }

    public static function ME2($data) {
        $GC = new GridClass();
        $GC->AddHidenCol("id", 'id');
        $GC->AddColPop('عنوان', 'title', 'id', 'title', '200', false, 'user_measures_show', 'right', 'id');
        $GC->AddCol("وضعیت", 'checked');
        $GC->AddCol("اولویت", 'priority');
        $GC->AddColLink("مسئول", 'Fname', 'uname', 'Fname');
        $s = $GC->Grid(json_encode($data));
        return view('test', array('content' => $s));
    }

    public static function ME20($data) {

        $grid = \DataGrid::source($data)->paginate(10)->getSet();
        $grid->add('sortid', 'ردیف', true)->style("width:100px");
        ;
        $grid->add('id', 'ID', true)->style("display:none");
        $grid->add('title', '	عنوان');
        $grid->add('checked', 'وضعیت');

        $grid->add('priority', 'اولویت');
        $grid->add('urgency', 'فوریت')->style("display:none");
        $grid->add('Fname', 'مسئول ');
        $grid->add('reg_date', 'مهلت', true);
        $grid->add('uname', 'تاریخ', false)->style("display:none");
        $grid->orderBy('id', 'desc');
        $grid->paginate(25);
        $grid->row(function ($row) {
            $title = $row->cell('title')->value;
            $row->cell('title')->value = '<a class="jsPanels" title="' . $title . '" href="' . Request::root() . '/modals/user_measures_show?mid=' . $row->cell('id')->value . '">' . $title . '</a>';
            $uname = $row->cell('uname')->value;
            $row->cell('Fname')->value = '<a target="_blank" href="' . $uname . '">' . $row->cell('Fname')->value . '</a>';
            $row->cell('uname')->style("display:none");
            $row->cell('id')->style("display:none");
            $row->cell('urgency')->style("display:none");
            $row->cell('priority')->value = $row->cell('priority')->value . ' - ' . $row->cell('urgency')->value;
            if ($row->cell('checked')->value == 0)
                $row->cell('checked')->value = 'آغازنشده';
            else if ($row->cell('checked')->value == 1)
                $row->cell('checked')->value = 'در حال انجام';
            else if ($row->cell('checked')->value == 2)
                $row->cell('checked')->value = 'انجام شده';
            else if ($row->cell('checked')->value == 3)
                $row->cell('checked')->value = 'پایان یافته ';
        });

        return $grid;
    }

}
