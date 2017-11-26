@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/OrgChart/dist/css/jquery.orgchart.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/Grid/dist/jquery.bootgrid.css')}}"/>
    <style>
        .onclick-menu-content {
            position: absolute;
            z-index: 999999;
            display: none;
        }
        .span_title{
            font-size: 17px;
        }
        .p_body_scrool{
            overflow-y: auto;
            overflow-x:hidden;
            max-height: 340px;
            height: auto;
            direction: ltr;
        }
    </style>
@stop
@section('content')
    <div class="row-fluid">
        <div class="row" style="height:25px;"></div>
        <div class="col-xs-12">
        <div>
            <span class="span_title">{{ trans('org_chart.edit_organization_chart') }} </span>
            <span  class="span_title" id="ChartTitle">{{$Chart->title}}</span>
            <a href="{!! route('modals.edit_chart',['chart_title'=>$Chart->title,'chart_id'=>$Chart->id])!!}" class="jsPanels pull-left btn btn-default"  >
                <span>{{ trans('org_chart.edit_chart_main_info') }}</span>
            </a>
            <button class="pull-left btn btn-default" type="button" id="add_root_item">
                <i ></i>
                <span>{{ trans('org_chart.register_main_unit') }}</span>
            </button>
        </div>
            <hr>
            <div class="panel panel-info" style="border:0px;">
                <div class="panel-body p_body_scrool">

                    <div id="chart-container" style="direction: ltr; text-align: center;"></div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div tabindex="0" class="onclick-menu">
        <div id="onclick-menu-content" class="onclick-menu-content">
            <div class=""
                 style="border-radius: 8px;padding: 10px;width: 300px;border: solid blue medium; background-color: #bbdefb;text-align: center;font-size: 12px">
                <h5>{{ trans('org_chart.set_employee') }}</h5>
                <select onchange="" id="select-user"
                        name="users"
                        class="chosen-rtl col-xs-12"
                        data-placeholder="{{trans('tasks.select_some_options')}}">
                    <option value=""></option>
                </select>

                <a onclick="hide_menu()" class="btn btn-default" style="margin-top: 10px;">{{ trans('org_chart.cancel') }}</a>
                <a onclick="add_post_user()" class="btn btn-info" style="margin-top: 10px;">{{ trans('org_chart.confirm') }}</a>
            </div>
        </div>
    </div>
    @include('hamahang.OrgChart.helper.OrgChartShow.modals')
@stop

@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/OrgChart/dist/js/jquery.orgchart.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.ajaxaddition.jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/Grid/js/moderniz.2.8.1.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/Grid/dist/jquery.bootgrid.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/Grid/dist/jquery.bootgrid.fa.js')}}"></script>
@stop
@section('inline_scripts')
    <script>
        window.ItemChildrenGrid = $('#ItemChildrenGrid').DataTable();
        $(document).ready(function () {
        });
    </script>
    @include('hamahang.OrgChart.helper.OrgChartShow.InlineJS')
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
