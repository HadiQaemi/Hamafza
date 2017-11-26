<?php
namespace App\HamafzaGrids;
use App\HamafzaPublicClasses\GridClass;
use Illuminate\Support\Facades\DB;

class KeywordGrids {

    public static function ThesarusGrids($data) {
        $grid = \DataGrid::source($data)->paginate(10)->getSet();
        $grid->add('sortid', 'ردیف')->style("width:100px");
        $grid->add('id', 'ID', true)->style("display:none");
        $grid->add('name', '	عنوان');
        $grid->add('del', 'حذف');
        $grid->add('edit', 'ویرایش');
        $grid->paginate(25);
        $grid->row(function ($row) {
            $uname = Session::get('Uname');
            $row->cell('del')->value = '<a  href="' . Request::root() . '/' . $row->cell('id')->value . '">حذف</a>';
            $row->cell('edit')->value = '<a  href="' . Request::root() . '/' . $uname . '/desktop/thesarus/add?id=' . $row->cell('id')->value . '&name=' . $row->cell('name')->value . '">ویرایش</a>';
            $row->cell('id')->style("display:none");
        });

        return $grid;
    }

    public static function KeywordsGrids($data) {
        
        
        $GC = new GridClass();
        $GC->AddHidenCol("id", 'id');
//        $GC->AddColLink('عنوان', 'title', 'id', 'title', 200,'false','_blank','right');
        $GC->AddCol("عنوان", 'keyword', '80');
        $GC->AddColEdit('ویرایش', 'id', 'keywords/', '10');

        $GC->AddColDelete('حذف', 'id', 'Keywords', '10', false);
        $s = $GC->Grid(json_encode($data));
        return $s;


        $grid = \DataGrid::source($data)->paginate(10)->getSet();
        $grid->add('sortid', 'ردیف')->style("width:100px");
        $grid->add('id', 'ID', true)->style("display:none");
        $grid->add('keyword', '	عنوان');
        $grid->add('del', 'حذف')->style("width:20px");
        ;
        $grid->add('edit', 'ویرایش')->style("width:20px");
        ;
        $grid->paginate(25);
        $grid->row(function ($row) {
            $uname = Session::get('Uname');
            // $row->cell('del')->value = '<a  href="' . Request::root() . '/' . $row->cell('id')->value . '">حذف</a>';
            $row->cell('edit')->value = '<div style="height:10px;"><a  style="height:10px;" href="' . Request::root() . '/modals/editkeyword?sid=' . $row->cell('id')->value . '" title="ویرایش کلید واژه " class="jsPanels" style="float: right;"><span class="fonts icon-alamatgozari" ></span></a></div>';
            $row->cell('del')->value = '<div style="height:10px;"><span style="border:0px; cursor:pointer"  id="' . $row->cell('id')->value . '" action="delete" page="Keywords" class="fonts icon-hazv Delicn" ></span></div>';
            $row->cell('id')->style("display:none");
        });

        return $grid;
    }

}
