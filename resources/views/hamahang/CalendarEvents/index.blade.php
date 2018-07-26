@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/stepy/datatables.css')}}">
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
                @permission('calendar_events_manager_new_event')
                <button class="btn btn-default btn-xs" id="userEventModal">{{trans('calendar_events.ce_events_button_label')}}</button>
                @endpermission
            </div>
            <div class="col-xs-3">
                @permission('calendar_events_manager_new_session')
                <button class="btn btn-default btn-xs" id="sessionEventSave">{{trans('calendar_events.ce_session_button_label')}}</button>
                @endpermission
            </div>
            <div class="col-xs-3">
                @permission('calendar_events_manager_new_invitation')
                <button class="btn btn-default btn-xs" id="invitationEventSave">{{trans('calendar_events.ce_invitation_button_label')}}</button>
                @endpermission
            </div>
            <div class="col-xs-3">
                @permission('calendar_events_manager_new_reminder')
                <button class="btn btn-default btn-xs" id="newReminder">{{trans('calendar_events.ce_reminder_button_label')}}</button>
                @endpermission
            </div>
        </div>
        <div class="clearfixed"></div>
    </div>
    <div class="clearfixed"></div>
    <br/>
    <div class="row">
        {{--<table id="gridDtataTable" class="table table-striped table-bordered dt-responsive nowrap display">--}}
        <table id="gridDtataTable" class="{{--table-bordered--}} table dt-responsive nowrap display" style="width:100%">

            <thead>
            <tr>
                <th data-column-id="id"> {{trans('calendar_events.ce_rowindex_label')}}</th>
                <th data-column-id="title">{{trans('calendar_events.ce_title')}}</th>
                <th data-column-id="startdate" data-formatter="startdate">{{trans('calendar_events.ce_startdate_label')}}</th>
                <th data-column-id="enddate" data-formatter="enddate">{{trans('calendar_events.ce_enddate_label')}}</th>
{{--                <th data-column-id="allDay" data-formatter="allDay">{{trans('calendar_events.ce_allday_label')}}</th>--}}
                <th data-column-id="type">{{trans('calendar_events.ce_type_label')}}</th>
                <th data-column-id="type">{{trans('calendar_events.ce_action_label')}}</th>
            </tr>
            </thead>
        </table>
        {{--@include('hamahang.CalendarEvents.helper.Index.modal_event')--}}
        {{--@include('hamahang.CalendarEvents.helper.Index.modal_session')--}}
        {{--@include('hamahang.CalendarEvents.helper.Index.modal_invitation')--}}
        {{--@include('hamahang.CalendarEvents.helper.Index.modal_reminder')--}}
        {{--@include('hamahang.CalendarEvents.helper.Index.modal_add_reminder')--}}
        @include('hamahang.CalendarEvents.helper.sessions.modal_minutes')

    </div>
@stop

@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::asset('assets/Packages/bootstrap/js/bootstrap-filestyle.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('assets/Packages/Grid/js/moderniz.2.8.1.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('assets/Packages/DataTables/datatables.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('assets/Packages/stepy/stepy.min.js')}}"></script>
@stop
@section('inline_scripts')
    @include('hamahang.CalendarEvents.helper.Index.inlineJS')
    @include('hamahang.CalendarEvents.helper.sessions.inlineJS')
    {!! $HFM_CalendarEvent['JavaScripts'] !!}
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop