@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
@stop
@section('inline_style')
    <style>
        .clsDatePicker {
            z-index: 100000;
        }
        .TimePicker {

            direction: ltr;
            font-family: Verdana;
        }
        .DatePicker {

            direction: ltr;
            font-family: Verdana;
        }
         .hd-body{
             overflow: hidden !important;
         }
        .dataTable th{
            text-align: right !important;
        }
        .dataTable td{
            text-align: right !important;
        }
    </style>
    @include('hamahang.CalendarEvents.helper.Index.inlineCss.inlineCss')
@stop
@section('content')
    <div class="row opacity-7" style="margin-top: -10px;background: #eee" id="form_filter_priority">
        <form id="form_filter_sessions">
            <div class="row padding-bottom-20">
                <i class="fa fa-calendar-minus-o int-icon3"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <input type="text" class="form-control int-btm-brd" style="padding: 6px 20px;" id="title" name="title" placeholder="{{trans('tasks.search_title')}}" autocomplete="off">
                </div>
                <i class="fa fa-tags int-icon2"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="new_task_keywords" class="select2_auto_complete_keywords" name="keywords[]"
                            data-placeholder="{{trans('tasks.search_keyword_task')}}"
                            multiple="multiple"></select>
                </div>
                <i class="fa fa-users int-icon1"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="new_task_users_all_tasks" name="users[]" class="select2_auto_complete_user col-xs-12"
                            data-placeholder="{{trans('calendar_events.search_some_persons')}}" multiple>
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="row margin-bottom-15">
                <div class="pull-right" style="margin-top: 10px;">
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input" name="types[]" value="0" id="draft" checked>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="pull-right" style="margin-top: 10px;">
                    <span>{{trans('general.draft')}}</span>
                </div>
                <div class="pull-right" style="margin-top: 10px;">
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input" name="types[]" value="1" id="final" checked>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="pull-right" style="margin-top: 10px;">
                    <span>{{trans('general.final')}}</span>
                </div>
            </div>

            @if(isset($filter_subject_id))
                <input type="hidden" value="{{$filter_subject_id}}" name="filter_subject_id" id="filter_subject_id"/>
            @endif
            {{--</div>--}}
        </form>
    </div>
    <div class="row-fluid" id="base_items_div">
        {{--<div class="col-xs-12">--}}
            {{--<div class="col-xs-3">--}}
                {{--<button class="btn btn-default btn-xs" id="sessionEventSave">{{trans('calendar_events.ce_session_button_label')}}</button>--}}
            {{--</div>--}}
            {{--<div class="clearfixed"></div>--}}
        {{--</div>--}}
        <div class="clearfixed"></div>
        {{--<form id="form_filter_sessions" style="position: relative;top: 50px;right: 200px;z-index: 50;">--}}
            {{--<div class="form-inline" style="padding-right: 5px;" >--}}
                {{--<div class="checkbox">--}}
                    {{--<div class="form-inline">--}}
                        {{--<div class="checkbox">--}}
                            {{--<label>--}}
                                {{--<input type="checkbox" class="form-check-input" name="types[]" value="0" id="draft" checked>--}}
                                {{--<span>{{ trans('general.draft') }}</span>--}}
                            {{--</label>--}}
                            {{--<label>--}}
                                {{--<input type="checkbox" class="form-check-input" name="types[]" value="1" id="final" checked>--}}
                                {{--<span>{{ trans('general.final') }}</span>--}}
                            {{--</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</form>--}}
        {{--<div class="row">--}}
            {{--<table id="sessionsGrid" class="table table-striped table-bordered dt-responsive nowrap display">--}}
            {{--<table id="sessionsGrid" class="--}}{{--table-bordered--}}{{-- table dt-responsive nowrap display" style="width:100%">--}}
                <table id="sessionsGrid" class="{{--table-bordered--}} table dt-responsive nowrap display" style="width:100%">
                <thead>
                <tr>
                    <th class="text-right" style="width: 20%"> {{trans('calendar_events.ce_title')}}</th>
                    <th class="text-right" style="width: 20%">{{trans('calendar_events.ce_date_label')}}</th>
                    <th class="text-right" style="width: 20%">{{trans('calendar_events.ce_startdate_label')}}</th>
                    <th class="text-right" style="width: 10%">{{trans('calendar_events.ce_enddate_label')}}</th>
                    <th class="text-right" style="width: 10%">{{trans('calendar_events.ce_place')}}</th>
                    <th class="text-right" style="width: 10%">{{trans('calendar_events.ce_role')}}</th>
                    <th class="text-right" style="width: 10%">{{trans('calendar_events.ce_action_label')}}</th>
                </tr>
                </thead>
            </table>
            {{--@include('hamahang.calendar_events.helper.sessions.modal_session')
            @include('hamahang.CalendarEvents.helper.Index.modal_add_reminder')--}}
            @include('hamahang.CalendarEvents.helper.sessions.modal_minutes')
        </div>
    </div>
@stop

@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/Packages/bootstrap/js/bootstrap-filestyle.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.ajaxaddition.jquery.js')}}"></script>
    <script src="{{URL::asset('assets/Packages/Grid/js/moderniz.2.8.1.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('assets/Packages/Grid/dist/jquery.bootgrid.js')}}"></script>
    <script src="{{URL::asset('assets/Packages/Grid/dist/jquery.bootgrid.fa.js')}}"></script>
    <script src="{{URL::asset('assets/Packages/DataTables/datatables.js')}}"></script>
@stop
@section('inline_scripts')
    @include('hamahang.CalendarEvents.helper.Index.inlineJS')
    @include('hamahang.CalendarEvents.helper.sessions.inlineJS')
    {!! $HFM_Session['JavaScripts'] !!}
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop