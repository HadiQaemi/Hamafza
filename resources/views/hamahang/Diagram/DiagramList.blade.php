@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
@stop
@section('inline_style')
    <style>
        td.details-control:before {
            content: '+';
            cursor: pointer;
        }
        tr.shown td.details-control:before {
            content: '-';
        }
    </style>
@stop
<style>
    .hd-body{
        overflow: hidden !important;
    }
</style>
@section('inline_scripts')
    @include('hamahang.Diagram.inline_js')
@stop

@section('content')
    <div class="row" style="margin-top: -10px;background: #eee" >
        <form id="form_filter_priority">
            <div class="row padding-bottom-20 opacity-7">
                <i class="fa fa-calendar-minus-o int-icon3"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <input type="text" class="form-control int-btm-brd" style="padding: 6px 20px;" id="title" name="title" placeholder="{{trans('tasks.search_title')}}" autocomplete="off">
                </div>
                <i class="fa fa-tags int-icon2"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="new_task_keywords" class="select2_auto_complete_keywords" name="keywords[]"
                            data-placeholder="{{trans('tasks.search_keyword_task')}}" multiple="multiple"></select>
                </div>
                <i class="fa fa-users int-icon1"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="new_task_users_all_tasks" name="users[]" class="select2_auto_complete_user col-xs-12"
                            data-placeholder="{{trans('tasks.search_some_persons')}}" multiple>
                        <option value=""></option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="container-fluid noLeftPadding noRightPadding task-list-height" id="base_items_div">
        <div class="row">
            <fieldset>
                <div class="col-md-12">
                    <table id="diagramListTable" class="{{--table-bordered--}} table dt-responsive nowrap display" style="width:100%">
                        <thead>
                        <tr>
                            <th class="col-lg-1" style="text-align: right;">عنوان</th>
                            <th class="col-lg-4" style="text-align: right;">کلیدواژه</th>
                            <th class="col-lg-2" class="table-no-sort" style="text-align: right;"></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </fieldset>
        </div>
    </div>
@stop
@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop

