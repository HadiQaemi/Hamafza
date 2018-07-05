<?php

namespace App\HamafzaServiceClasses;

use Auth;
use Illuminate\Support\Facades\DB;

class PublicsClass
{

    public static function Histogram_2($id, $select = '', $title, $rows = '', $type, $Coltype, $i, $ytitle = '', $w = 500)
    {
        if ($w == '')
        {
            $w = 500;
        }
        $form_add = array();
        $form = array();
        $fields = '';
        if ($type == 'Histogram')
        {
            $chartype = 'column';
        }
        else
        {
            if ($type == 'Linear')
            {
                $chartype = 'line';
            }
        }
        $Fields = DB::table('forms_field')
            ->where('form_id', $id)->WhereRaw("id in($select)")
            ->select('field_name', 'id')->get();
        $Forms = DB::table('forms_report as r')
            ->leftJoin('forms_report_value as v', 'v.report_id', '=', 'r.id')
            ->leftJoin('forms as f', 'f.id', '=', 'r.form_id')
            ->leftJoin('user as u', 'r.uid', '=', 'u.id')
            ->where('r.form_id', $id)->WhereRaw("v.field_id in($rows)")
            ->select(DB::RAW('v.field_value ,r.id , r.uid , r.form_id , r.pid , r.sid , r.ppsid , r.reg_date , u.Name , u.Family , u.Email , f.title,u.Uname'))->get();

        foreach ($Forms as $value)
        {
            $fields .= "'" . trim($value->field_value) . "',";
        }

        $fields = rtrim($fields, ",");
        $site = config('constants.SiteAddress');
        $tbl = '
<div id="containerPie_' . $id . $i . '" style="min-width: 310px;direction:ltr; height: 400px; max-width: 600px; margin: 0 auto"></div>';

        $tbl .= "<script>$(function () {
    $('#containerPie_$id$i').highcharts({
        chart: {
            type: '$chartype',
            width: $w,
                   zoomType: 'xy'
        },
         legend: {
          rtl:true
        },
        title: {
            text: '$title'
        },
         xAxis: {
            categories: [
              $fields
            ],
            crosshair: true
        },
         yAxis: {
            min: 0,
            title: {
                text: '$ytitle'
            }
        },
          plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [
            ";
        $tbls = '';
        foreach ($Fields as $value)
        {
            $vals = "";
            $tbls .= "{
                name: '$value->field_name',data:[";
//                    if ($rows == 'ALL')
//            $Forms = DB::table('forms_report_value')->where('field_id', $value->id)->select('field_value')->get();
//        else   
            $Forms = DB::table('forms_report_value')
                ->where('field_id', $value->id)->select('field_value')->get();
            foreach ($Forms as $values)
            {
                $vals .= "$values->field_value,";
            }
            $vals = rtrim($vals, ",");
            $tbls .= "$vals]},";
        }
        $tbl .= $tbls . "]});});</script>";

        return $tbl;
    }

    public static function Histogram($id, $select = '', $title, $rows = '', $type, $Coltype, $i, $ytitle = '', $w = 500)
    {
        if ($w == '')
        {
            $w = 500;
        }
        $form_add = array();
        $form = array();
        $fields = '';

        $Fields = DB::table('forms_field')
            ->where('form_id', $id)->WhereRaw("id in($rows)")
            ->select('field_name', 'id')->get();

        foreach ($Fields as $value)
        {
            $fields .= "'" . trim($value->field_name) . "',";
        }
        $site = config('constants.SiteAddress');
        $tbl = '
<div id="containerPie' . $id . $i . '" style="min-width: 310px;direction:ltr; height: 400px; max-width: 600px; margin: 0 auto"></div>';

        $tbl .= "<script>$(function () {
    $('#containerPie$id$i').highcharts({
        chart: {
            type: 'column',
            width: $w,
                zoomType: 'xy'
        },
        title: {
            text: '$title'
        },
         legend: {
            rtl: true
        },
        subtitle: {
            text: ''
        },
         xAxis: {
            categories: [
              $fields
            ],
            crosshair: true
        },
           yAxis: {
            min: 0,
            title: {
                text: '$ytitle'
            }
        },
        series: [
            ";
        $Repss = DB::table('forms_report_value as fr')
            ->leftJoin('forms_field as ff', 'fr.field_id', '=', 'ff.id')
            ->WhereRaw("fr.field_id in($select)")
            ->select('fr.field_value', 'fr.field_id', 'ff.field_name', 'fr.report_id')
            ->get();
        foreach ($Repss as $value)
        {
            $Reps = DB::table('forms_report_value as fr')
                ->leftJoin('forms_field as ff', 'fr.field_id', '=', 'ff.id')
                ->WhereRaw("fr.field_id in($rows)")->where('fr.report_id', $value->report_id)
                ->select('fr.field_value', 'fr.field_id', 'ff.field_name')
                ->get();
            $vals = '';

            foreach ($Reps as $rp)
            {
                $vals .= $rp->field_value . ',';
            }
            $vals = rtrim($vals, ",");

            $tbl .= "{
                name: '$value->field_value',
                 data:[$vals] 
            },";

//            foreach ($Reps as $value) {
//                $tbl.="{
//                name: '$value->field_name',
//                y: $value->field_value
//            }," ;
//            }
        }
        $tbl .= "
       ]
        
    });
});</script>";

        return $tbl;
    }

    public static function ReportForContext($id, $select = '', $title, $rows = '', $type, $Coltype, $i, $ytitle = '')
    {
        $form_add = array();
        $form = array();
        $fields = '';
        if ($type == 'Histogram')
        {
            $chartype = 'column';
        }
        else
        {
            if ($type == 'Linear')
            {
                $chartype = 'line';
            }
        }
        $Fields = DB::table('forms_field')
            ->where('form_id', $id)->WhereRaw("id in($select)")
            ->select('field_name', 'id')->get();
        $Forms = DB::table('forms_report as r')
            ->leftJoin('forms as f', 'f.id', '=', 'r.form_id')
            ->leftJoin('user as u', 'r.uid', '=', 'u.id')
            ->where('r.form_id', $id)->WhereRaw("r.id in($rows)")
            ->select(DB::RAW('r.id , r.uid , r.form_id , r.pid , r.sid , r.ppsid , r.reg_date , u.Name , u.Family , u.Email , f.title,u.Uname'))->get();

        foreach ($Forms as $value)
        {
            $fields .= "'$value->Name $value->Family',";
        }

        $fields = rtrim($fields, ",");
        $site = config('constants.SiteAddress');
        $tbl = '
<div id="containerPie_' . $id . $i . '" style="min-width: 310px;direction:ltr; height: 400px; max-width: 600px; margin: 0 auto"></div>';

        $tbl .= "<script>$(function () {
    $('#containerPie_$id$i').highcharts({
        chart: {
          type: '$chartype'
        },
        title: {
            text: '$title'
        },
         xAxis: {
            categories: [
              $fields
            ],
            crosshair: true
        },
         yAxis: {
            min: 0,
            title: {
                text: '$ytitle'
            }
        },
          plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [
            ";
        $tbls = '';
        $vals = "";
        $Fields = DB::table('forms_field')
            ->where('form_id', $id)->WhereRaw("id in($rows)")
            ->select('field_name', 'id')->first();
        if ($Fields)
        {
            $name = $Fields->field_name;
        }
        else
        {
            $name = '';
        }
        $tbls .= "{
                name: '$name',data:[";
        $Forms = DB::table('forms_report_value')
            ->WhereRaw("field_id in($rows)")->select('field_value')->get();
        foreach ($Forms as $values)
        {
            $vals .= "$values->field_value,";
        }
        $vals = rtrim($vals, ",");
        $tbls .= "$vals ]},";
        $tbl .= $tbls . "]});});</script>";

        return $tbl;
    }

    public static function HistogramReportForContext($id, $select = '', $title, $rows = '', $type, $Coltype, $i, $ytitle = '')
    {
        $form_add = array();
        $form = array();
        $fields = '';
        if ($type == 'Histogram')
        {
            $chartype = 'column';
        }
        else
        {
            if ($type == 'Linear')
            {
                $chartype = 'line';
            }
        }
        $Fields = DB::table('forms_field')
            ->where('form_id', $id)->WhereRaw("id in($select)")
            ->select('field_name', 'id')->get();
        $Forms = DB::table('forms_report as r')
            ->leftJoin('forms_report_value as v', 'v.report_id', '=', 'r.id')
            ->leftJoin('forms as f', 'f.id', '=', 'r.form_id')
            ->leftJoin('user as u', 'r.uid', '=', 'u.id')
            ->where('r.form_id', $id)->WhereRaw("v.field_id in($rows)")
            ->select(DB::RAW('v.field_value ,r.id , r.uid , r.form_id , r.pid , r.sid , r.ppsid , r.reg_date , u.Name , u.Family , u.Email , f.title,u.Uname'))->get();

        foreach ($Forms as $value)
        {
            $fields .= "'$value->field_value',";
        }

        $fields = rtrim($fields, ",");
        $site = config('constants.SiteAddress');
        $tbl = '
<div id="containerPie_' . $id . $i . '" style="min-width: 310px;direction:ltr; height: 400px; max-width: 600px; margin: 0 auto"></div>';

        $tbl .= "<script>$(function () {
    $('#containerPie_$id$i').highcharts({
        chart: {
          type: '$chartype'
        },
         legend: {
          rtl:true
        },
        title: {
            text: '$title'
        },
         xAxis: {
            categories: [
              $fields
            ],
            crosshair: true
        },
         yAxis: {
            min: 0,
            title: {
                text: '$ytitle'
            }
        },
          plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [
            ";
        $tbls = '';
        foreach ($Fields as $value)
        {
            $vals = "";
            $tbls .= "{
                name: '$value->field_name',data:[";
//                    if ($rows == 'ALL')
//            $Forms = DB::table('forms_report_value')->where('field_id', $value->id)->select('field_value')->get();
//        else   
            $Forms = DB::table('forms_report_value')
                ->where('field_id', $value->id)->select('field_value')->get();
            $j = count($Forms);
            $i = 1;
            foreach ($Forms as $values)
            {
                if ($i == $j)
                {
                    $vals .= "$values->field_value,$i,$j";
                }
                else
                {
                    $vals .= "$values->field_value";
                }

                $i++;
            }
            $vals = rtrim($vals, ", ");
            $vals = rtrim($vals, ",");
            $vals = ltrim($vals, ", ");
            $vals = ltrim($vals, ",");
            $tbls .= "$vals]},";
        }
        $tbl .= $tbls . "]});});</script>";

        return $tbl;
    }

    public static function PieReportForContext($id, $select = '', $title, $rows = '')
    {
        $form_add = array();
        $form = array();
        $site = config('constants.SiteAddress');
        $tbl = '
<div id="containerPie" style="min-width: 310px;direction:ltr; height: 400px; max-width: 600px; margin: 0 auto"></div>';

        $tbl .= "<script>$(function () {
    $('#containerPie').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '$title'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'تعداد',
            colorByPoint: true,
            data: [
            ";
        if ($rows != '')
        {
            $Forms = DB::table('forms_report as r')
                ->leftJoin('forms as f', 'f.id', '=', 'r.form_id')
                ->leftJoin('user as u', 'r.uid', '=', 'u.id')
                ->where('r.form_id', $id)->WhereRaw("r.id in($rows)")
                ->select(DB::RAW('r.id , r.uid , r.form_id , r.pid , r.sid , r.ppsid , r.reg_date , u.Name , u.Family , u.Email , f.title,u.Uname'))->get();
        }
        else
        {
            $Forms = DB::table('forms_report as r')
                ->leftJoin('forms as f', 'f.id', '=', 'r.form_id')
                ->leftJoin('user as u', 'r.uid', '=', 'u.id')
                ->where('r.form_id', $id)
                ->select(DB::RAW('r.id , r.uid , r.form_id , r.pid , r.sid , r.ppsid , r.reg_date , u.Name , u.Family , u.Email , f.title,u.Uname'))->get();
        }

        foreach ($Forms as $value)
        {
            $Reps = DB::table('forms_report_value as fr')
                ->leftJoin('forms_field as ff', 'fr.field_id', '=', 'ff.id')
                ->WhereRaw("fr.field_id in($select)")->where('fr.report_id', $value->id)
                ->select('fr.field_value', 'fr.field_id', 'ff.field_name')
                ->get();

            foreach ($Reps as $value)
            {
                $tbl .= "{
                name: '$value->field_name',
                y: $value->field_value
            },";
            }
        }
        $tbl .= "
       ]
        }]
    });
});</script>";

        return $tbl;
    }

    public static function FormReportForContext($id, $select = '', $rows = '')
    {
        $form_add = array();
        $form = array();
        $tbl = '<table class="table table-striped"><tr class="info">';
        $Fields = DB::table('forms_field')
            ->where('form_id', $id)->WhereRaw("id in($select)")
            ->select('field_name')->get();
        foreach ($Fields as $value)
        {
            $tbl .= '<td>' . $value->field_name . '</td>';
        }
        $tbl .= '</tr>';
        if ($rows != '')
        {
            $Forms = DB::table('forms_report as r')
                ->leftJoin('forms as f', 'f.id', '=', 'r.form_id')
                ->leftJoin('user as u', 'r.uid', '=', 'u.id')
                ->where('r.form_id', $id)->WhereRaw("r.id in($rows)")
                ->select(DB::RAW('r.id , r.uid , r.form_id , r.pid , r.sid , r.ppsid , r.reg_date , u.Name , u.Family , u.Email , f.title,u.Uname'))->get();
        }
        else
        {
            $Forms = DB::table('forms_report as r')
                ->leftJoin('forms as f', 'f.id', '=', 'r.form_id')
                ->leftJoin('user as u', 'r.uid', '=', 'u.id')
                ->where('r.form_id', $id)
                ->select(DB::RAW('r.id , r.uid , r.form_id , r.pid , r.sid , r.ppsid , r.reg_date , u.Name , u.Family , u.Email , f.title,u.Uname'))->get();
        }

        foreach ($Forms as $value)
        {
            $Reps = DB::table('forms_report_value as fr')
                ->leftJoin('forms_field as ff', 'fr.field_id', '=', 'ff.id')
                ->WhereRaw("fr.field_id in($select)")->where('fr.report_id', $value->id)
                ->select('fr.field_value', 'fr.field_id', 'ff.field_name')
                ->get();
            $tbl .= '<tr>';

            foreach ($Reps as $value)
            {
                $tbl .= '<td>' . $value->field_value . '</td>';
            }
            $tbl .= '</tr>';
        }
        $tbl .= '</table>';

        return $tbl;
    }

    public function FormReports($id)
    {
        $form_add = array();
        $form = array();
        $Forms = DB::table('forms_report as r')
            ->leftJoin('forms as f', 'f.id', '=', 'r.form_id')
            ->leftJoin('user as u', 'r.uid', '=', 'u.id')
            ->where('r.form_id', $id)
            ->select(DB::RAW('r.id , r.uid , r.form_id , r.pid , r.sid , r.ppsid , r.reg_date , u.Name , u.Family , u.Email , f.title,u.Uname'))->get();
        foreach ($Forms as $value)
        {
            $form_add['id'] = $value->id;
            $form_add['reporter'] = $value->Name . ' ' . $value->Family;
            $form_add['reg_date'] = jDate::forge($value->reg_date)->format('%Y/%m/%d');
            array_push($form, $form_add);
        }
        return $form;
    }

    public function FormField($id)
    {
        $newrow = DB::table('forms as f')->join('forms_field as ff', 'f.id', '=', 'ff.form_id')
            ->where('f.id', $id)
            ->select('ff.id', 'ff.field_name')->get();
        return $newrow;
    }

    public function TagsSearch($keyword)
    {
        $KC = new KeywordClass();
        return $KC->TagsSearch($keyword);
    }

    public function pophelp($pid, $tagname)
    {
        $ref = $this->get_help($pid, $tagname);
        return $ref;
    }

    public function ShowHelp($id, $tagname, $hid, $pid)
    {
        $ref = $this->get_help($id, $tagname);
        return $ref;
    }

    function GetPageBody($id)
    {
        $body = '';
        $newrow = DB::table('pages as p')->select('p.id', 'p.sid', 'p.body', 'p.form', 'p.view', 'p.edit', 'p.ver_date')->where('p.id', $id)->first();
        if ($newrow)
        {
            $body = $newrow->body;
        }
        return $body;
    }

    function get_help($id, $tag)
    {
        $pos = 0;
        $pos2 = 0;
        $tit = '';
        $TagName = '';
        $body = $this->GetPageBody($id);
        $op = '';
        $pattern = "/{{Help\+$tag=.*}}/";
        if ($num1 = preg_match_all($pattern, $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $key = $array['0'][$x];
                $TagName = $key;
            }
        }

        $pattern = "/=.*}}/";
        if ($num1 = preg_match_all($pattern, $TagName, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $key = $array['0'][$x];
            }
            $tit = str_replace('=', '', $key);
            $tit = str_replace('}}', '', $tit);
        }

        $pattern = "/{{Help\+$tag=.*}}/";
        if ($num1 = preg_match_all($pattern, $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $key = $array['0'][$x];
                $pos = strpos($body, $key);
                $TagName = $key;
            }
        }
        $pattern = "/{{Help-$tag}}/";
        if ($num1 = preg_match_all($pattern, $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $key = $array['0'][$x];
                $pos2 = strpos($body, $key);
            }
        }
        $bodlen = strlen($body);
        if ($pos > 0 && $pos2)
        {
            $body = substr($body, $pos, $pos2 - $pos) . "<br>";
        }
        $pattern = "/{{Help\+.*=.*}}/";
        if ($num1 = preg_match_all($pattern, $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $body = str_replace($array['0'][$x], "", $body);
            }
        }
        $pattern = "/{{Help-.*}}/";
        if ($num1 = preg_match_all($pattern, $body, $array))
        {
            for ($x = 0; $x < $num1; $x++)
            {
                $body = str_replace($array['0'][$x], "", $body);
            }
        }

        $rel = $this->Relat($TagName);

        return '<b>' . $tit . '</b>' . '<br>' . $body . '<br>' . $rel;
    }

    function Relat($TagNames)
    {
        $pre = strpos($TagNames, '=');
        $TagNames = substr($TagNames, 0, $pre);
        $mes = '';
        $first = DB::table('page_help_groups')->select('T as Res', 'tpid as pid')->whereRaw("R like '{$TagNames}=%'");
        $out = '';
        $second = DB::table('page_help_groups')->select('R as Res', 'rpid as pid')->whereRaw("T like '{$TagNames}=%'")->union($first)->groupBy('Res')->get();
        $n = 0;
        foreach ($second as $row)
        {
            $bodys = $this->GetPageBody($row->pid);
            $body = $bodys;
            $T = $row->Res;
            $keyTag = $T;
            $pid = $row->pid;

            $pattern = "/=.*}}/";
            if ($num1 = preg_match_all($pattern, $T, $array))
            {
                for ($x = 0; $x < $num1; $x++)
                {
                    $key = $array['0'][$x];
                }
            }

            $tit = str_replace('=', '', $key);
            $T = str_replace('=' . $tit, '', $T);
            $pos = strpos($body, $T) + strlen($T);

            $tit = str_replace('{{', '', $tit);
            $tit = str_replace('}}', '', $tit);
            $keyTag = str_replace('=', '', $keyTag);
            $keyTag = str_replace($tit, '', $keyTag);
            $keyTag = str_replace('{{Help+', '', $keyTag);
            $keyTag = str_replace('}}', '', $keyTag);


            $T = str_replace('+', '-', $T);
            $pos2 = strpos($body, $T);
            if ($pos > 0 && $pos2 > 0)
            {
                $bodyn = substr($body, $pos, $pos2 - $pos) . "<br>";
                $n++;
                $bodyn = str_replace('}}', '', $bodyn);
                $bodyn = str_replace('=', '', $bodyn);
                $out .= '<li class="HelpFire" onclick="HelpFire(\'' . $pid . '\',\'' . $keyTag . '\')" style="list-style-type: none !important;" tagname="' . $keyTag . '" pid="' . $pid . '"><span style="color: #428bca;">   ' . $tit . ' </span></li>';
            }
        }
        //  $out .= '<li style="padding-right: 10px;list-style-type: none !important;"><a href="20" original-title="راهنما" class="stooltip">درگاه راهنما </a></li>';
        if (trim($out) != '')
        {
            $mes = '<span style="float:right;direction:rtl;font-weight: bold;">این موارد را نیز ببینید:</span><br><ul style="padding-right:5px;">' . $out . '</ul>';
        }
        return $mes;
    }

    public static function HelpManage($Helpid = 0, $tabname = '', $pageType = '')
    {
        $newrow = '';
        if ($pageType == 'subject')
        {
            $newrow = DB::table('page_help')->whereRaw("sid in(select kind from subjects  where  id=$Helpid)")->select('page_help.id as id', 'pageid', 'name as tagname')->first();
        }
        else
        {
            if ($tabname == '0')
            {
                $sids = $Helpid;
                $newrow = DB::table('page_help')->where('pname', $pageType)->where('pid', '0')->select('page_help.id as id', 'pageid', 'name as tagname')->first();
            }
            else
            {
                $newrow = DB::table('page_help')->where('pname', $pageType)->where('tabname', $tabname)->select('page_help.id as id', 'pageid', 'name as tagname')->first();
            }
        }
        return $newrow;
    }

    public static function to_latin_num($string)
    {
        //arrays of persian and latin numbers
        $persian_num = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $latin_num = range(0, 9);

        $string = str_replace($persian_num, $latin_num, $string);

        return $string;
    }

    public function GetTreeNode($searchword)
    {
        $newrow = DB::table('page_tree as pt')->select('pt.id', 'pt.name', 'parent_id', 'pt.id as url', 'pt.*')->where('pt.id', $searchword)->first();
        $pc = new PageClass();
        $Trees = $pc->CrtaeData($newrow);
        return $Trees;
    }
    
  

    public function search($searchword)
    {
        $quote = '';
        $all = '';
        $any = '';
        $none = '';
        if ($searchword != '')
        {
            $searchword = PublicClass::Filter($searchword);
            $searchword = PageClass::stem($searchword);
            $searchword = PublicClass::subst($searchword);
            $quote = '';
            $remain_string = stripslashes($searchword);
            if ($num = preg_match_all("/\"(.*?)\"/", $remain_string, $array))
            {
                for ($y = 0; $y < count($array['0']); $y++)
                {
                    $quote = $array['1'][$y];
                    $remain_string = str_replace($array['0'][$y], '', $remain_string);
                }
            }
            $all = '';
            $any = '';
            $none = '';
            $split = explode(' ', $remain_string);
            foreach ($split as $val)
            {
                $val = trim($val);
                if (substr($val, 0, 1) == '+')
                {
                    $all .= substr($val, 1) . ' ';
                }
                elseif (substr($val, 0, 1) == '-')
                {
                    $none .= substr($val, 1) . ' ';
                }
                else
                {
                    $any .= $val . ' ';
                }
            }
        }

        $new_string = '';
        if ((!$quote) || ($quote == ''))
        {
            $new_string .= '';
        }
        else
        {
            $new_string .= '"' . $quote . '" ';
        }
        if ((!$all) || ($all == ''))
        {
            $new_string .= '';
        }
        else
        {
            $new_string .= '+(' . $all . ') ';
        }
        if ((!$any) || ($any == ''))
        {
            $new_string .= '';
        }
        else
        {
            $new_string .= $any . ' ';
        }
        if ((!$none) || ($none == ''))
        {
            $new_string .= '';
        }
        else
        {
            $new_string .= '-(' . $none . ') ';
        }
        if (trim($new_string) != '')
        {
            $rows = DB::table('synonym')->select('first', 'second')->get();
            foreach ($rows as $row)
            {
                if (strstr($new_string, $row->first))
                {
                    $new_string .= str_replace($row->first, $row->second, $new_string) . ' ';
                }
                elseif (strstr($new_string, $row->second))
                {
                    $new_string .= str_replace($row['second'], $row->first, $new_string) . ' ';
                }
            }
        }
        $n = 0;
        $new_string = trim($new_string);
        $result = array();
        if (trim($new_string) != '')
        {
            $sql = "SELECT DISTINCT s.title AS ntitle  , p.description AS ndescription  , p.body AS score, p.id, p.sid, p.type, p.description, p.body, s.title, s.kind, s.frame, s.theme FROM subjects as s LEFT JOIN pages as p ON s.id = p.sid WHERE (s.archive = 0 AND (s.title OR p.body )) or (s.title) like '%$new_string%' GROUP BY s.id";
            $query = DB::select($sql);
            $total = 0;
            $kind = '';
            $n = 0;
            foreach ($query as $obj)
            {
                $total++;
                $len = mb_strlen($obj->body, 'UTF-8');
                if ($len >= 0)
                {
                    $result[$n]['score'] = $obj->ntitle * 4 + $obj->ndescription * 2 + $obj->score;
                    $pid = $obj->id;
                    $title = $obj->title;
                    $result[$n]['url'] = $pid;
                    $result[$n]['title'] = $obj->title;
                    $result[$n]['description'] = (trim($obj->title) != '');
                }
                $n++;
            }
        }
        $Res = array();
        if (count($result))
        {
            $Res['pages'] = $result;
        }
        else
        {
            $Res['pages'] = trans('labels.SearchNotResult');
        };
        return Response::json(array(
            'error' => false,
            'data' => $Res), 200
        )->setCallback(Input::get('callback'));
    }

    public static function GetForm($fid)
    {
        $rows = DB::table('forms as f')->leftJoin('forms_field as d', 'f.id', '=', 'd.form_id')
            ->leftJoin('forms_field_value as v', 'd.id', '=', 'v.field_id')->where('f.id', $fid)
            ->select(DB::RAW('f.id as fid, f.title, f.type, f.col, f.help, d.id as did, d.field_name, d.field_type, d.requires, d.orders, d.scores, v.id as vid, v.field_value'))
            ->orderBy('d.orders')->orderBy('v.orders')->get();
        return Response::json(array(
            'error' => false,
            'data' => $rows), 200
        )->setCallback(Input::get('callback'));
    }

    public function DeleteSubject($id)
    {
        $pages = DB::table('pages as p')->leftJoin('subjects as s', 's.id', '=', 'p.sid')
            ->where('s.kind', $id)->select('id')->count();
        if ($pages > 0)
        {
            return 'غیر قابل حذف';
        }
        else
        {
            DB::table('subject_type')->where('id', $id)->delete();
            DB::table('subject_type_fields')->where('stid', $id)->delete();
            DB::table('subject_type_key')->where('stid', $id)->delete();
            DB::table('subject_type_sec')->where('asubid', $id)->delete();
            DB::table('subject_type_tab')->where('stid', $id)->delete();
            return 'حذف شد';
        }
    }

    public function DeleteRow($page, $uid, $sesid, $id)
    {
        if ($page == 'process_list')
        {
            DB::table('process')->where('id', $id)->delete();
            DB::table('process_phase')->where('pid', $id)->delete();
            DB::table('process_subject')->where('pid', $id)->delete();
        }
        elseif ($page == 'Forms')
        {
            return FormClass::DeleteForm($id, $uid);
        }
        elseif ($page == 'subjects')
        {
            return $this->DeleteSubject($id);
        }
        elseif ($page == 'FormField')
        {
            FormClass::DeleteFormField($id);
        }
        elseif ($page == 'PageSlide')
        {
            PageClass::DeletePageSlide($id);
        }
        elseif ($page == 'PageFilm')
        {
            PageClass::DeletePageFilm($id);
        }
        elseif ($page == 'Post')
        {
            PostsClass::PosetDelete($id);
        }
        elseif ($page == 'alert')
        {
            DB::table('emails')->where('id', $id)->delete();
        }
        elseif ($page == 'SubSt')
        {
            DB::table('subst')->where('id', $id)->delete();
        }
        elseif ($page == 'Keywords')
        {
            DB::table('keywords')->where('id', $id)->delete();
        }
        elseif ($page == 'delpage')
        {
            PostsClass::delpage($id);
        }
        elseif ($page == 'Message')
        {
            MessageClass::DeleteFromInbox($uid, $id);
        }
        elseif ($page == 'MessageOut')
        {
            MessageClass::DeleteFromOut($uid, $id);
        }
        elseif ($page == 'comment')
        {

            PostsClass::CommentDelete($id);
        }
        elseif ($page == 'user_security')
        {
            return LoginClass::UserSecurityDelete($id);
        }
        elseif ($page == 'user_list')
        {
            return LoginClass::UserListDelete($id);
        }
        elseif ($page == 'Announce')
        {
            PageClass::DeleteAnnounces($id);
        }
        elseif ($page == 'Highlight')
        {
            PageClass::DeleteHighlight($id);
        }
        elseif ($page == 'Alert')
        {
            PageClass::DeleteAlert($id);
        }
        $message = trans('labels.DelOK');
        $err = false;
        return $message;
    }

    public static function GetFields()
    {
        $rows = DB::table('field_type')->get();
        return $rows;
    }

    public static function showhighlight($id, $uid)
    {
        $rows = DB::table('announces')->select('title', 'id')->where('pid', $id)->where('uid', $uid)->get();
        return Response::json(array(
            'error' => false,
            'data' => $rows), 200
        )->setCallback(Input::get('callback'));
    }

    public static function showpagebody($id)
    {
        $rows = DB::table('pages')->select('body')->where('id', $id)->get();
        return Response::json(array(
            'error' => false,
            'data' => $rows), 200
        )->setCallback(Input::get('callback'));
    }

    public static function showtabs($sid)
    {

        $rows = DB::table('pages as p')
            ->leftJoin('subject_type_tab as stt', 'p.type', '=', 'stt.tid')
            ->join('tab_view as tv', 'tv.tabid', '=', 'stt.id')
            ->where('p.sid', $sid)->where('tv.sid', $sid)->where('stt.view', '1')
            ->select('p.id as pid', 'p.view', 'stt.name as tab_name', 'stt.type', 'stt.tid', 'stt.sptid', 'stt.first', 'stt.dist', 'stt.orders', 'stt.view')->orderBy('stt.orders')->get();
        return Response::json(array(
            'error' => false,
            'data' => $rows), 200
        )->setCallback(Input::get('callback'));
    }

    public static function Alerts()
    {
        $rows = DB::table('alerts')->select('id', 'name')->orderBy('id')->get();
        $i = 1;
        foreach ($rows as $value)
        {
            $value->sortid = $i;
            $i++;
        }
        return $rows;
    }

    public static function Quran()
    {
        $rows = DB::table('quran_sura')->orderBy('id')->get();
        return $rows;
    }

    public static function Graph()
    {
        $rows = DB::table('forms')->orderBy('title')->get();
        return Response::json(array(
            'error' => false,
            'data' => $rows), 200
        )->setCallback(Input::get('callback'));
    }

    public static function Forms()
    {
        $rows = DB::table('forms')->orderBy('title')->get();
        return Response::json(array(
            'error' => false,
            'data' => $rows), 200
        )->setCallback(Input::get('callback'));
    }

    public static function RightCol($uid, $sesid, $sid, $type, $islocal = 0)
    {
        $menus = array();
        $menusRet = array();
        $Ret = array();
        $res = array();
        if ($type == 'subjects')
        {
            if (Auth::check())
            {
                $res[0] = trans('labels.rhightcol_mywall_title');
                $res[2] = 'wall';
                $PostsClass = new PostsClass();
                $res[1] = $PostsClass->UserWall($uid, 3);
                array_push($Ret, $res);
                $res[0] = trans('labels.rhightcol_pagewall_title');
                $PostsClass = new PostsClass();
                $Sw = $PostsClass->SubjectWall_rightCol($sid, $uid, 3);
                $res[1] = $PostsClass->SubjectWall_rightCol($sid, $uid, 3);
                $res[2] = 'desktop';
                array_push($Ret, $res);
            }
            else
            {
                $res[0] = trans('labels.rhightcol_mywall_title');
                $res[1] = trans('labels.rhightcol_mywall_no_data');
                array_push($Ret, $res);
            }
        }
        else
        {
            if ($type == 'subjectwall')
            {
                if (Auth::check())
                {
                    $res[0] = trans('labels.rhightcol_mywall_title');
                    $res[2] = 'wall';
                    $PostsClass = new PostsClass();
                    $res[1] = $PostsClass->UserWall($uid, 3);
                    array_push($Ret, $res);
                }
                else
                {
                    $res[0] = trans('labels.rhightcol_mywall_title');
                    $res[1] = trans('labels.rhightcol_mywall_no_data');
                    array_push($Ret, $res);
                }
            }
            else
            {
                if ($type == 'userwall')
                {
                    if (Auth::check())
                    {
                        $res[0] = 'آخرین رویدادها';
                        $res[2] = 'alerts';
                        $PostsClass = new UserClass();
                        $res[1] = Alerts::GetAlerts($uid);
                        array_push($Ret, $res);

                        $res[0] = trans('labels.rhightcol_mygroup_title');
                        $res[2] = 'userwall';
                        $PostsClass = new UserClass();
                        $res[1] = $PostsClass->MyGroupAdmin($uid, 50, 1);
                        array_push($Ret, $res);
                        $res[0] = trans('labels.rhightcol_mychannel_title');
                        $res[1] = $PostsClass->MyGroupAdmin($uid, 50, 2);
                        array_push($Ret, $res);
                    }
                    else
                    {
                        $res[0] = trans('labels.rhightcol_usernot_title');
                        $res[1] = trans('labels.rhightcol_usernot_no_data');
                        $res[2] = 'usernot';
                        array_push($Ret, $res);
                        $res[0] = trans('labels.rhightcol_mywall_title');
                        $res[1] = trans('labels.rhightcol_mywall_no_data');
                        array_push($Ret, $res);
                    }
                }
                else
                {
                    if ($type == 'userabout')
                    {
                        if (Auth::check())
                        {
                            $res[0] = trans('labels.rhightcol_mywall_title');
                            $res[2] = 'wall';
                            $PostsClass = new PostsClass();
                            $res[1] = $PostsClass->UserWall($uid, 3);
                            array_push($Ret, $res);
                        }
                        else
                        {
                            $res[0] = trans('labels.rhightcol_mywall_title');
                            $res[1] = trans('labels.rhightcol_mywall_no_data');
                            array_push($Ret, $res);
                        }
                    }
                }
            }
        }
        if ($islocal == 1)
        {
            return $Ret;
        }
    }

    public static function tagsearch($search, $type, $activetype)
    {
        if ($activetype == 1)
        {
            $rows = DB::table('keywords')
                ->select('id', 'title as name', 'is_morajah as morajah')
                ->where('title', 'like', "%$search%")
                ->where('ttype', $type)
                ->orderBy('name')
                ->get();
        }
        else
        {
            $rows = DB::table('keywords')
                ->select('id', 'title as name', 'is_morajah as morajah')
                ->where('title', 'like', "%$search%")
                ->orderBy('name')
                ->get();
        }
        return $rows;
    }

    public static function subst($string)
    {
        $rows = DB::table('subst')->select('first', 'second')->get();
        foreach ($rows as $row)
        {
            //hqi استفاده از استمر
            //$string = str_replace($row->first, $row->second, $string);
        }
        return trim($string);
    }

    public static function stem($string)
    {
        $newwords = array("ك" => "ک", "ي" => "ی", "&nbsp;" => " ", "­" => " ", "&zwnj;" => " ", "&zwj;" => " ", "&rlm;" => " ", "&lrm;" => " ", "&thinsp;" => " ", "&ensp;" => " ", "&emsp;" => " ", " " => " ", " " => " ", "  " => " ", "   " => " ", "    " => " ", "" => "‌"); //"‌"هشت‌ساله
        foreach ($newwords as $key => $val)
        {
            $string = str_replace($key, $val, $string);
        }
        return $string;
    }

    public static function Filter($value)
    {
        $value = trim(htmlentities(strip_tags($value)));
        $value = filter_var($value, FILTER_SANITIZE_STRING);
        $value = trim(strip_tags($value));
        if (get_magic_quotes_gpc())
        {
            $value = stripslashes($value);
        }
        else
        {
            $value = addslashes($value);
        }
        // $value = DB::connection()->getPdo()->quote($value);
        $value = PublicsClass::stem($value);
        return $value;
    }

    public static function FilterJon($value)
    {
        $value = json_decode($value, true);
        $value = trim(htmlentities(strip_tags($value)));
        $value = filter_var($value, FILTER_SANITIZE_STRING);
        $value = trim(strip_tags($value));
        if (get_magic_quotes_gpc())
        {
            $value = stripslashes($value);
        }
        else
        {
            $value = addslashes($value);
        }
        // $value = DB::connection()->getPdo()->quote($value);
        //$value= PublicClass::stem($value);
        return $value;
    }

    public static function timeAgo($datefrom, $dateto = -1)
    {
        if ($datefrom <= 0)
        {
            return "خیلی وقت پیش";
        }
        if ($dateto == -1)
        {
            $dateto = time();
        }
        $difference = $dateto - $datefrom;
        if ($difference < 60)
        {
            $interval = "s";
        }
        elseif ($difference >= 60 && $difference < 60 * 60)
        {
            $interval = "n";
        }
        elseif ($difference >= 60 * 60 && $difference < 60 * 60 * 24)
        {
            $interval = "h";
        }
        elseif ($difference >= 60 * 60 * 24 && $difference < 60 * 60 * 24 * 7)
        {
            $interval = "d";
        }
        elseif ($difference >= 60 * 60 * 24 * 7 && $difference <
            60 * 60 * 24 * 30
        )
        {
            $interval = "ww";
        }
        elseif ($difference >= 60 * 60 * 24 * 30 && $difference <
            60 * 60 * 24 * 365
        )
        {
            $interval = "m";
        }
        elseif ($difference >= 60 * 60 * 24 * 365)
        {
            $interval = "y";
        }
        switch ($interval)
        {
            case "m":
                $months_difference = floor($difference / 60 / 60 / 24 /
                    29);
                while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom) + ($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto)
                {
                    $months_difference++;
                }
                $datediff = $months_difference;
                if ($datediff == 12)
                {
                    $datediff--;
                }
                $res = ($datediff == 1) ? "$datediff ماه پیش" : "$datediff
                    ماه قبل";
                break;
            case "y":
                $datediff = floor($difference / 60 / 60 / 24 / 365);
                $res = ($datediff == 1) ? "$datediff سال پیش" : "$datediff
                    سال قبل";
                break;
            case "d":
                $datediff = floor($difference / 60 / 60 / 24);
                $res = ($datediff == 1) ? "$datediff روز پیش" : "$datediff
                    روز قبل";
                break;
            case "ww":
                $datediff = floor($difference / 60 / 60 / 24 / 7);
                $res = ($datediff == 1) ? "$datediff هفته پیش" : "$datediff
                    هفته قبل";
                break;
            case "h":
                $datediff = floor($difference / 60 / 60);
                $res = ($datediff == 1) ? "$datediff ساعت پیش" : "$datediff
                    ساعت قبل";
                break;
            case "n":
                $datediff = floor($difference / 60);
                $res = ($datediff == 1) ? "$datediff دقیقه پیش" :
                    "$datediff دقیقه قبل";
                break;
            case "s":
                $datediff = $difference;
                $res = ($datediff == 1) ? "$datediff ثانیه پیش" :
                    "$datediff ثانیه قبل";
                break;
        }
        return $res;
    }

    public function GetMenus()
    {
        $urls = departments:: where('view', '1')->select('id', 'name as title', 'pid')->orderBy('orders')->get();
        return Response::json(array(
            'error' => false,
            'menu' => $urls->toArray()), 200
        )->setCallback(Input::get('callback'));
    }
}
