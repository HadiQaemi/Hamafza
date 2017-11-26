<?php

namespace App\HamafzaGrids;

use App\HamafzaPublicClasses\GridClass;
use Illuminate\Support\Facades\DB;

class ProccessGrids {

    public static function Lists($data) {
         $GC = new GridClass();
        $GC->AddHidenCol("id", 'id');
                $GC->AddCol('عنوان', 'name', '100', false, 'right');
        $GC->AddCol('تعداد', 'nums', '10', false, 'center');
        $GC->AddHidenCol("nr", 'nr');
        $GC->AddColEdit('ویرایش', 'id', 'process_list/edit?id=', '10', false, 'right');
        $GC->AddFlowChart('نمودار', 'id', 'process_list/view?id=', '10', false, 'right');
        $GC->AddColDelete('حذف', 'id', 'process_list', '10', false, 'right');
        $s = $GC->Grid(json_encode($data));
        return $s;


        $grid = \DataGrid::source($data)->paginate(10)->getSet();
        $grid->add('sortid', 'ردیف')->style("width:100px");
        $grid->add('id', 'ID', true)->style("display:none");
        $grid->add('name', '	عنوان');
        $grid->add('nums', 'تعداد');
        $grid->add('edit', 'ویرایش');
        $grid->add('flowchart', 'نمودار');
        $grid->add('del', 'حذف');

        $grid->paginate(25);
        $grid->row(function ($row) {
            $title = $row->cell('name')->value;
            // $row->cell('name')->value = '<a  href="' . Request::root() . '/' . $row->cell('id')->value . '">' . $title . '</a>';
            $uname = $row->cell('name')->value;
            $row->cell('id')->style("display:none");
            $row->cell('edit')->value = '<div style="height:10px;"><a href="process_list/edit?id=' . $row->cell('id')->value . '"><span class="fonts icon-alamatgozari" ></span> </a></div>';
            $row->cell('flowchart')->value = '<div style="height:10px;"><a href="process_list/view?id=' . $row->cell('id')->value . '"><span class="fonts icon-eye" style="height:10px;"></span> </a></div>';
            $row->cell('del')->value = '<div style="height:10px;"><span style="border:0px; cursor:pointer"  id="' . $row->cell('id')->value . '" action="delete" page="process_list" class="fonts icon-hazv Delicn" ></span></div>';
        });

        return $grid;
    }

    public static function page($data) {


        $grid = \DataGrid::source($data)->paginate(10)->getSet();
        $grid->add('sortid', 'ردیف', true)->style("width:100px");
        $grid->add('sid', 'ID', true)->style("display:none");
        $grid->add('pid', 'ID', true)->style("display:none");
        $grid->add('title', '	عنوان');
        $grid->add('Fname', 'ارجاع دهنده');
        $grid->add('uname', 'تاریخ', false)->style("display:none");
        $grid->add('Name', 'اقدام');
        $grid->orderBy('id', 'desc');
        $grid->paginate(10);
        $grid->row(function ($row) {
            $title = $row->cell('title')->value;
            $row->cell('title')->value = '<a  href="' . Request::root() . '/' . $row->cell('pid')->value . '">' . $title . '</a>';
            $uname = $row->cell('uname')->value;
            $row->cell('Fname')->value = '<a target="_blank" href="' . Request::root() . '/' . $uname . '">' . $row->cell('Fname')->value . '</a>';
            $row->cell('uname')->style("display:none");
            $row->cell('sid')->style("display:none");
            $row->cell('pid')->style("display:none");
            $row->cell('Name')->value = 'اقدام';
        });

        return $grid;
    }

}
