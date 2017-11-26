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
    </style>
    @include('hamahang.CalendarEvents.helper.Index.inlineCss.inlineCss')
@stop
@section('content')
    <div id="MsgBox"></div>
    <div class="row-fluid">
        <div class="col-xs-12">
            <div class="col-xs-3">
                <button class="btn btn-default btn-xs" id="sessionEventSave">{{trans('calendar_events.ce_session_button_label')}}</button>
            </div>
            <div class="clearfixed"></div>
        </div>
        <div class="clearfixed"></div>
        <br/>
        <div class="row">
            <table id="sessionsGrid" class="table table-striped table-bordered dt-responsive nowrap display">
                <thead>
                <tr>
                    <th data-column-id="id"> {{trans('calendar_events.ce_rowindex_label')}}</th>
                    <th data-column-id="title"> {{trans('calendar_events.ce_agenda_label')}}</th>
                    <th data-column-id="startdate" data-formatter="startdate">{{trans('calendar_events.ce_startdate_label')}}</th>
                    <th data-column-id="enddate" data-formatter="enddate">{{trans('calendar_events.ce_enddate_label')}}</th>
                    <th>{{trans('calendar_events.ce_calendar_label')}}</th>
                    <th>{{trans('calendar_events.ce_action_label')}}</th>
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