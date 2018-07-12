@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{url('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
    <link type="text/css" rel="stylesheet" href="{{url('assets/Packages/calendar/dist/fullcalendar.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{url('assets/Packages/calendar/lib/jquery-ui/jquery-ui.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{url('assets/Packages/calendar/lib/jquery-ui/jquery-ui.structure.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{url('assets/Packages/calendar/lib/jquery-ui/jquery-ui.theme.css')}}" />
    {{--<link type="text/css" rel="stylesheet" href="{{url('assets/Packages/calendar/dist/fullcalendar.print.css')}}" />--}}
    <link type="text/css" rel="stylesheet" href="{{url('assets/Packages/DataTables/datatables.css')}}">
@stop
@section('inline_style')
    <style>
        .dataTables_filter {
            display: none;
        }
        table.dataTable td, table.dataTable th {
            overflow: hidden; /* this is what fixes the expansion */
            text-overflow: ellipsis; /* not supported in all browsers, but I accepted the tradeoff */
            white-space: nowrap;
        }
        hr.hrstyle {
            border-top: 3px double #8c8b8b;
        }
        icker {
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
        #vrScroll2{
            padding-right: 10px !important;
        }
        #vrScroll2 .scrl{
            direction: ltr !important;
            padding-right: 0px !important;
        }
        #vrScroll2 .hd-tree{
            padding-right: 7px !important;
        }
        #pcol_32{
            overflow-y: visible !important;
        }
    </style>
    @include('hamahang.CalendarEvents.helper.Index.inlineCss.inlineCss')
    @include('hamahang.Calendar.helper.Index.inlineCss.inlineCss')
@stop
@section('content')
    <div class="row-fluid">
        <div id='wrap'>
            <!--<div class="col-xs-12">
                <div  class="col-sm-4" id="inlineDatepicker"></div>
                <div class="col-sm-4" id="inlineDatepicker2"></div>
                <div class="col-sm-4"  id="inlineDatepicker3"></div>
            </div>-->
            <div class="row-fluid">
                <div class="col-xs-12 rowv row-fluid calendar-main-setting">
                    {{--<div class="pull-right"></div>--}}
                    <input type="hidden" name="lastSelectdCalendar" id="lastSelectdCalendar" value=""/>
                    {{-- <div class="pull-left"></div>--}}
                </div>
               {{-- <hr style="margin: 4px ;	border: 1px solid #8c8b8b;">--}}
                <div id="calendar_sidebar" class="hidden"></div>
                <div id='calendar' class="col-xs-12"></div>
                <div class="clearfixed"></div>
            </div>
        </div>
        <div class="clearfixed"></div>
    </div>
@stop
@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{url('assets/Packages/bootstrap/js/bootstrap-filestyle.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/Packages/ChosenAjax/js/chosen.jquery.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/Packages/ChosenAjax/js/chosen.ajaxaddition.jquery.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/Packages/DataTables/datatables.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/Packages/calendar/lib/moment/moment.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/Packages/calendar/lib/moment/moment-jalaali.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/Jquery/jquery-2.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/Packages/calendar/dist/fullcalendar.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/Packages/calendar/lang/fa.js')}}"></script>
    <script type="text/javascript">var jQuery_2 = $.noConflict(true);</script>
    @include('hamahang.Calendar.helper.Index.inlineJS')
    <script>
        $('.ful-scrn').attr('rel',3);
        $('#inlineDatepicker').persianDatepicker({
            timePicker: {
                enabled: true
            },
            monthPicker: {
                scrollEnabled: false
            },
            dayPicker: {
                scrollEnabled: false
            }
        });
        $('#inlineDatepicker2').persianDatepicker({
            timePicker: {
                enabled: true
            },
            monthPicker: {
                scrollEnabled: false
            },
            dayPicker: {
                scrollEnabled: false
            }
        });
        $('#inlineDatepicker3').persianDatepicker({
            timePicker: {
                enabled: true
            },
            monthPicker: {
                scrollEnabled: false
            },
            dayPicker: {
                scrollEnabled: false
            }
        });
    </script>
    {!! $HFM_CalendarEvent['JavaScripts'] !!}
@stop
@include('sections.tabs')
@section('position_right_col_3')
    {!!userCalendarsWidget()!!}
    @include('sections.desktop_menu')
@stop

{{--@include('hamahang.Calendar.helper.Index.modals.modal_calendar_setting')--}}
{{--@include('hamahang.Calendar.helper.Index.modals.modal_calendar_add')--}}
{{--@include('hamahang.Calendar.helper.Index.modals.modal_calendar_edit')--}}
{{--@include('hamahang.Calendar.helper.Index.modals.remove_confirm_modal')--}}
{{--@include('hamahang.Calendar.helper.Index.modals.modal_msgBox')--}}
{{--@include('hamahang.Calendar.helper.Index.modals.modal_fullcalendar_menu')--}}
{{--@include('hamahang.CalendarEvents.helper.Index.modal_event')--}}
{{--@include('hamahang.CalendarEvents.helper.Index.modal_session')--}}
{{--@include('hamahang.CalendarEvents.helper.Index.modal_invitation')--}}
{{--@include('hamahang.CalendarEvents.helper.Index.modal_reminder')--}}