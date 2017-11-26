<?php

namespace App\HamafzaPublicClasses;

class GridClass {

    private $colsName = "";
    private $Scripts = "";
    private $cols = "";
    private $Div = "";
    private $links = '';

    function __construct($pop='') {
        if ($pop == '') {
            $this->Scripts = "";
            $this->link = '<script src="' . url('/') . '/theme/Scripts/jquery.jqGrid.min.js" type="text/javascript"></script>
                       <script src="' . url('/') . '/theme/Scripts/i18n/grid.locale-fa.js" type="text/javascript"></script>
                                           <script src="' . url('/') . '/theme/Scripts/jquery.searchFilter.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="' . url('/') . '/theme/Content/css/ui.jqgrid-bootstrap-ui.css"/>
                       <link rel="stylesheet" type="text/css" href="' . url('/') . '/theme/Content/css/ui.jqgrid-bootstrap.css"/>
                       <link rel="stylesheet" type="text/css" href="' . url('/') . '/theme/Content/css/ui.jqgrid.css"/>';
            $this->Div = $this->link . "<script>
        $.jgrid.defaults.responsive = true;
        $.jgrid.defaults.styleUI = 'Bootstrap';
        $.jgrid.defaults.height = 500;
        </script>
        <table id='jqGrid'></table>
        <div id='jqGridPager'></div>";
        } else {
            $this->Scripts = "";
            $this->link = '
<script src="' . url('/') . '/theme/Scripts/jquery.jqGrid.min.js" type="text/javascript"></script>
                       <script src="' . url('/') . '/theme/Scripts/i18n/grid.locale-fa.js" type="text/javascript"></script>
                       <link rel="stylesheet" type="text/css" href="' . url('/') . '/theme/Content/css/ui.jqgrid-bootstrap-ui.css"/>
                       <link rel="stylesheet" type="text/css" href="' . url('/') . '/theme/Content/css/ui.jqgrid-bootstrap.css"/>
                       <link rel="stylesheet" type="text/css" href="' . url('/') . '/theme/Content/css/ui.jqgrid.css"/>';

        $this->Div = $this->link . "
        <table id='jqGridpop'></table>
        <div id='jqGridPagerpop'></div>";
        }

    }
  function PopGrid($Data, $Caption = '', $rowNum = 15) {
        $var = '<script type="text/javascript">var mydata = ' . $Data . ';';
        $var.='$(document).ready(function() {
        $("#jqGridpop").jqGrid({
            datatype: "local",
            direction: "rtl",
            autowidth: true,
            shrinkToFit: true,
            data: mydata,
             colNames: [' . $this->colsName . '],
            colModel: [' . $this->cols . '],
            viewrecords: true,
            caption: "' . $Caption . '",
            rowNum: ' . $rowNum . ',
            rownumbers: true,
             sortorder: "desc",
             jsonReader: { repeatitems : false },
             caption: "Complex search", 
            pager: "#jqGridPagerpop"
            });});
                 function formatImage(cellValue, options, rowObject) {
                       var imageHtml = "";
                          return imageHtml;
                     }            
        </script>';
        return $this->Div . $var . $this->Scripts;
    }

    function Grid($Data, $Caption = '', $rowNum = 15) {
        $var = '<script type="text/javascript">var mydata = ' . $Data . ';';
        $var.='$(document).ready(function() {
        $("#jqGrid").jqGrid({
            datatype: "local",
            direction: "rtl",
            autowidth: true,
            shrinkToFit: true,
            data: mydata,
             colNames: [' . $this->colsName . '],
            colModel: [' . $this->cols . '],
            viewrecords: true,
            caption: "' . $Caption . '",
            rowNum: ' . $rowNum . ',
            rownumbers: true,
             sortorder: "desc",
             jsonReader: { repeatitems : false },
            pager: "#jqGridPager"
            });});
                 function formatImage(cellValue, options, rowObject) {
                       var imageHtml = "";
                          return imageHtml;
                     } 
                      $("#jqGrid").jqGrid("filterToolbar", { searchOnEnter: true, enableClear: false });
        </script>';
        return $this->Div . $var . $this->Scripts;
    }

    public function AddCol($header, $name, $width = 100, $key = '', $align = 'center') {
        $headers = "'$header',";
        $key = ($key == '') ? 'false' : 'true';
        $str = "{ name: '$name', width: $width, key: $key,align: '$align'},";
        $this->cols.=$str;
        $this->colsName.=$headers;
    }

    public function AddHidenCol($header, $name, $key = '', $align = 'center') {
        $headers = "'$header',";
        $key = ($key == '') ? 'false' : 'true';
        $str = "{ name: '$name',hidden: true , key: $key,align: '$align'},";
        $this->cols.=$str;
        $this->colsName.=$headers;
    }
 public function AddEditPop($header, $field, $param, $title, $width = 100, $key = '', $page, $align = 'center',$paramname="sid",$otherparam='',$otherparamvalue='') {
        $headers = "'$header',";
        $str = '<script>function formatLink' . $field . '(cellValue, options, rowObject) {
                       var imageHtml = "<div class=\'ICONGRid\'><a class=\'jsPanels\' title=\'"+cellValue+"\' href=\'' . url('/') . '/modals/'.$page.'?'.$paramname.'="+rowObject.' . $param . '+"'.$otherparam.'"+rowObject.' . $otherparamvalue . '+"\'><span class=\'fonts GridIcon icon-alamatgozari\'></span></a></div>";
                          return imageHtml;
                     } </script> ';
        $this->Scripts.=$str;
        $key = ($key == '') ? 'false' : 'true';
        $str = "{ name: '$field', width: $width, key: $key,align: '$align', formatter: formatLink$field},";
        $this->cols.=$str;
        $this->colsName.=$headers;
    }
    public function AddColPop($header, $field, $link, $title, $width = 100, $key = '', $target = '_blank', $align = 'center',$paramname="sid",$otherparam='') {
        $headers = "'$header',";
        $str = '<script>function formatLink' . $field . '(cellValue, options, rowObject) {
                       var imageHtml = "<a class=\'jsPanels\' title=\'"+cellValue+"\' href=\'' . url('/') . '/modals/'.$target.'?'.$paramname.'="+rowObject.' . $link . '+"'.$otherparam.'\'>"+cellValue+"</a>";
                          return imageHtml;
                     } </script> ';
        $this->Scripts.=$str;
        $key = ($key == '') ? 'false' : 'true';
        $str = "{ name: '$field', width: $width, key: $key,align: '$align', formatter: formatLink$field},";
        $this->cols.=$str;
        $this->colsName.=$headers;
    }

    public function AddColPopMEs($header, $field, $link, $title, $width = 100, $key = '', $target = '_blank', $align = 'center',$paramname="sid",$otherparam='',$tt='') {
        $headers = "'$header',";
        $str = '<script>function formatLink' . $field . '(cellValue, options, rowObject) {
                       var imageHtml = "<a class=\'jsPanels\' title=\''.$tt.'\' href=\'' . url('/') . '/modals/'.$target.'?'.$paramname.'="+rowObject.' . $link . '+"'.$otherparam.'\'>"+cellValue+"</a>";
                          return imageHtml;
                     } </script> ';
        $this->Scripts.=$str;
        $key = ($key == '') ? 'false' : 'true';
        $str = "{ name: '$field', width: $width, key: $key,align: '$align', formatter: formatLink$field},";
        $this->cols.=$str;
        $this->colsName.=$headers;
    }

    public function AddColLink($header, $field, $link, $title, $width = 100, $key = '', $target = '_blank', $align = 'center') {
        $headers = "'$header',";
        $str = '<script>function formatLink' . $field . '(cellValue, options, rowObject) {
                       var imageHtml = "<a href=\'' . url('/') . '/"+rowObject.' . $link . '+"\' target=\'' . $target . '\' >"+cellValue+"</a>";
                          return imageHtml;
                     } </script> ';
        $this->Scripts.=$str;
        $key = ($key == '') ? 'false' : 'true';
        $str = "{ name: '$field', width: $width, key: $key,align: '$align', formatter: formatLink$field},";
        $this->cols.=$str;
        $this->colsName.=$headers;
    }

     public function AddColEdit($header, $field, $link,  $width = 100, $key = '',$align = 'center') {
        $headers = "'$header',";
        $uname=session('Uname');
        $str = '<script>function EditLink(cellValue, options, rowObject) {
                       var imageHtml = "<div class=\'ICONGRid\'><a href=\'' . url('/') . '/'.$uname.'/desktop/'.$link.'"+rowObject.' . $field . '+"\' ><span class=\'fonts GridIcon icon-alamatgozari\'></span></a></div>";
                          return imageHtml;
                     } </script> ';
        $this->Scripts.=$str;
        $key = ($key == '') ? 'false' : 'true';
        $str = "{ name: '$field', width: $width, key: $key,align: '$align', formatter: EditLink},";
        $this->cols.=$str;
        $this->colsName.=$headers;
    }

    public function AddColCopy($header, $field, $link, $width = 100, $key = '', $align = 'center') {
        $headers = "'$header',";
        $uname = session('Uname');
        $str = '<script>function CopyLink(cellValue, options, rowObject) {
                       var imageHtml = "<div class=\'ICONGRid\'><a href=\'' . url('/') . '/' . $uname . '/desktop/' . $link . '"+rowObject.' . $field . '+"\' ><span class=\'fonts GridIcon icon-2-4\'></span></a></div>";
                          return imageHtml;
                     } </script> ';
        $this->Scripts.=$str;
        $key = ($key == '') ? 'false' : 'true';
        $str = "{ name: '$field', width: $width, key: $key,align: '$align', formatter: CopyLink},";
        $this->cols.=$str;
        $this->colsName.=$headers;
    }

     public function AddFlowChart($header, $field, $link, $width = 100, $key = '', $align = 'center') {
        $headers = "'$header',";
        $uname = session('Uname');
        $str = '<script>function CopyLink(cellValue, options, rowObject) {
                       var imageHtml = "<div class=\'ICONGRid\'><a href=\'' . url('/') . '/' . $uname . '/desktop/' . $link . '"+rowObject.' . $field . '+"\' ><span class=\'fonts GridIcon icon-eye\'></span></a></div>";
                          return imageHtml;
                     } </script> ';
        $this->Scripts.=$str;
        $key = ($key == '') ? 'false' : 'true';
        $str = "{ name: '$field', width: $width, key: $key,align: '$align', formatter: CopyLink},";
        $this->cols.=$str;
        $this->colsName.=$headers;
    }

    public function AddColDelete($header, $field, $Page,  $width = 100, $key = '',$align = 'center') {
        $headers = "'$header',";
        $uname=session('Uname');
        $str = '<script>function DelLink(cellValue, options, rowObject) {
                       var imageHtml = "<div class=\'ICONGRid\'><span style=\'border:0px; cursor:pointer\' id=\'"+rowObject.' . $field . '+"\' action=\'delete\' page=\''.$Page.'\' class=\'fonts GridIcon icon-hazv Delicn\'></span></div>";
                          return imageHtml;
                     } </script> ';
        $this->Scripts.=$str;
        $key = ($key == '') ? 'false' : 'true';
        $str = "{ name: '$field', width: $width, key: $key,align: '$align', formatter: DelLink},";
        $this->cols.=$str;
        $this->colsName.=$headers;
    }

    public function AddAtachCol($header, $field, $width = 100, $key = '', $target = '_blank', $align = 'center') {
        $headers = "'$header',";
        $str = '<script>function formatLink' . $field . '(cellValue, options, rowObject) {
            if(cellValue>0)
                var imageHtml = "<img src=\'' . url('/') . '/img/clip.png\'>";
            else    
                var imageHtml = "";
            return imageHtml;
            } </script> ';
        $this->Scripts.=$str;
        $key = ($key == '') ? 'false' : 'true';
        $str = "{ name: '$field', width: $width, key: $key,align: '$align', formatter: formatLink$field},";
        $this->cols.=$str;
        $this->colsName.=$headers;
    }

        public function FormAnser($header, $field, $link, $title, $width = 100, $key = '', $target = '_blank', $align = 'center') {
            $headers = "'$header',";
        $str = '<script>function FormAnser' . $field . '(cellValue, options, rowObject) {
            if(cellValue>0)
                var imageHtml = "<a class=\'jsPanels\' title=\'"+rowObject.title+"\' href=\'' . url('/') . '/modals/'.$target.'?repid="+rowObject.' . $field . '+"&formid="+rowObject.' . $link . '+"\'>مشاهده/ ویرایش</a>";
            else    
                var imageHtml = "ندارد";
            return imageHtml;
            } </script> ';
        $this->Scripts.=$str;
        $key = ($key == '') ? 'false' : 'true';
        $str = "{ name: '$field', width: $width, key: $key,align: '$align', formatter: FormAnser$field},";
        $this->cols.=$str;
        $this->colsName.=$headers;
    }

     public function AddFormPop($header, $field, $link, $title, $width = 100, $key = '', $target = '_blank', $align = 'center',$paramname="sid",$otherparam='') {
        $headers = "'$header',";
        $str = '<script>function formatLink' . $field . '(cellValue, options, rowObject) {
                       var imageHtml = "<a class=\'jsPanels\' title=\'مشاهده پاسخ\' href=\'' . url('/') . '/modals/'.$target.'?'.$paramname.'="+rowObject.' . $link . '+"'.$otherparam.'\'>"+cellValue+"</a>";
                          return imageHtml;
                     } </script> ';
        $this->Scripts.=$str;
        $key = ($key == '') ? 'false' : 'true';
        $str = "{ name: '$field', width: $width, key: $key,align: '$align', formatter: formatLink$field},";
        $this->cols.=$str;
        $this->colsName.=$headers;
    }


}
