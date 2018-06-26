@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{url('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
    <link type="text/css" rel="stylesheet" href="{{url('assets/Packages/calendar/dist/fullcalendar.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{url('assets/Packages/calendar/lib/jquery-ui/jquery-ui.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{url('assets/Packages/calendar/lib/jquery-ui/jquery-ui.structure.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{url('assets/Packages/calendar/lib/jquery-ui/jquery-ui.theme.css')}}" />
    {{--<link type="text/css" rel="stylesheet" href="{{url('assets/Packages/calendar/dist/fullcalendar.print.css')}}" />--}}
    <link type="text/css" rel="stylesheet" href="{{url('assets/Packages/DataTables/datatables.css')}}">

    @include('hamahang.Tasks.helper.priority.priority_style')
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
        .fix-box{
            width: 60%;
            font-size: 10px;
            float: right;
            margin-right: 1%;
        }
        .second-fix-boxt{
            width: 28%;
        }
        h2{
            font-size: 11px;
        }
        /*.fix-inr{*/
            /*height: 70vh;*/
        /*}*/
        .fc-time-grid-container{
            height: 50vh !important;
        }
        #important_and_immediate{
            height: 56.8vh !important;
        }
        .fc-state-default{
            /*display: none;*/
        }
        .calendar-time-task{
            display: block;
        }
        .season-view{
            padding: 0px;
        }
        .task_title{
            margin: 0px !important;
            padding: 0px !important;;
        }
        .state{
            display: none;
        }
        .ful-scrn{
            z-index: 10 !important;
        }
        h5{
            height: 20px;
            line-height: 20px;
            padding: 0px;
            margin: 0px;
        }
        .completed_tasks{
            display: none;
        }
        .done_tasks{
            display: none;
        }
    </style>
    @include('hamahang.CalendarEvents.helper.Index.inlineCss.inlineCss')
    @include('hamahang.Calendar.helper.Index.inlineCss.inlineCss')
@stop
@section('content')
            <div class="row-fluid">
                <div id='wrap' style="padding: 5px;">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-xs-4"></div>
                        <div class="col-xs-4">{{$date['getMonthNames'].''.$date['cal'][0]}}</div>
                        <div class="col-xs-4"></div>
                    </div>
                        <table class="table-bordered" id="table_task_time" style="padding: 5px">
                            <tr>
                                <td style="padding: 5px 3px;width: 4%">روز</td>
                                @for($d=0;$d<12;$d++)
                                    <td style="width: 8%;padding: 5px 3px;text-align: center">{{(2*$d+2).'-'.(2*$d+1)}}</td>
                                @endfor
                            </tr>
                            <tbody>
                                @for($d=1;$d<=($date['cal'][1]>6 ? 30 : 31);$d++)
                                    <tr class="tr_task_list_{{$d}}" gerDate="{{$date['Georgian'].'-'.$d}}" gerYear="{{$date['GeorgianYear']}}" gerMonth="{{$date['GeorgianMonth']}}" gerDay="{{$d}}">
                                        <td style="padding: 5px 3px;width: 4%">{{$date['cal'][1].'/'.$d}}</td>
                                        @for($dd=0;$dd<12;$dd++)
                                            <td class="droppable" style="width: 8%;padding: 0px;" class="draggable cursor-pointer" data-task_id="{{$d.'-'.$dd}}" id="{{$d.'-'.$dd}}" hour="{{(2*$dd+2).':59:59-'.(2*$dd+1).':00:00'}}" day="{{$date['cal'][0].'-'.$date['cal'][1].'-'.$d}}" data-t_id="{{$d.'-'.$dd}}" title="{{$d.'-'.$dd}}"></td>
                                        @endfor
                                    </tr>
                                @endfor
                            </tbody>
                        </table>




                    <!--<div class="col-xs-12">
                        <div  class="col-sm-4" id="inlineDatepicker"></div>
                        <div class="col-sm-4" id="inlineDatepicker2"></div>
                        <div class="col-sm-4"  id="inlineDatepicker3"></div>
                    </div>-->
                    {{--<div class="row-fluid">--}}
                        {{--<div class="col-xs-12 rowv row-fluid calendar-main-setting">--}}
                            {{--<div class="pull-right"></div>--}}
                            {{--<input type="hidden" name="lastSelectdCalendar" id="lastSelectdCalendar" value=""/>--}}
                             {{--<div class="pull-left"></div>--}}
                        {{--</div>--}}
                        {{--<hr style="margin: 4px ;	border: 1px solid #8c8b8b;">--}}
                        {{--<div id='calendar' class="col-xs-12"></div>--}}
                        {{--<div class="clearfixed"></div>--}}
                    {{--</div>--}}
                </div>
                <div class="clearfixed"></div>
            </div>
        </div>
    </div>
    <div class="panel panel-light fix-box second-fix-box" style="height: 100%;width: 35% !important;">
        <button class="ful-scrn" rel="2">
            <span class="glyphicon glyphicon-fullscreen"></span>
        </button>
        <div class="fix-inr" style="height: 100%;">
            <div class="row-fluid">
                <div id='wrap'>
                    <style> #related_links {
                            padding: 1px;
                            left: 15px;
                            position: absolute;
                            top: -15px !important;
                            left:27px;
                            z-index:11;
                        }</style>
                    <div style="position: relative;height: 100%;width: 100%;">
                        <div class="header_task">
                            <div class="space-4"></div>
                            <div class="row" style="position: relative;">
{{--                                @include('hamahang.Tasks.MyTask.helper.task_related_pages')--}}
                                @include('hamahang.Tasks.helper.priority.priority_filter_time')
                            </div>
                        </div>
                    </div>
                    @include('hamahang.Tasks.helper.priority.content')

                    {{--@include('hamahang.Tasks.MyAssignedTask.helper.RapidCreateTask',['function'=>'filter_tasks_priority'])--}}

                </div>
                <div class="clearfixed"></div>
            </div>
        </div>
    </div>
@stop
@section('inline_scripts')
    @include('hamahang.Tasks.helper.priority.priority_js')
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
        var obj = {};
        obj.cid = 31;
        var height = {}
        var table_task_time = $('#table_task_time').width();
        $.ajax({
            url: '{{ URL::route('hamahang.calendar_events.get_calendar_events')}}',
            type: 'POST',
            data: obj,
            async: false,
            success: function (s) {
                res = JSON.parse(s);
                for(i=0;i<res.sharing_events.length;i++)
                {
                    enddate = res['sharing_events'][i]['enddate'];
                    enddates = enddate.split(" ");
                    startdate = res['sharing_events'][i]['startdate'];
                    startdates = startdate.split(" ");
                    console.log(res['sharing_events'][i]['title']);
                    console.log(res['sharing_events'][i]);
                    if(height[enddates[0]]==undefined)
                        height[enddates[0]] = 1;
                    split_date = enddates[0].split('-');
                    //alert('.tr_task_list_'+split_date[2]);

                    endtime = enddates[1].split(':');
                    starttime = startdates[1].split(':');
                    var start_stamo = parseInt(starttime[0]*60)+parseInt(starttime[1]);
                    var end_stamo = parseInt(endtime[0]*60)+parseInt(endtime[1]);
                    // g = toGregorian(split_date[0],split_date[1],split_date[2]);
                    x = $('.tr_task_list_'+split_date[2]).position();
                    var li = '<li start="'+res['sharing_events'][i]['startdate']+'" end="'+res['sharing_events'][i]['enddate']+'" class="draggable ui-draggable ui-draggable-handle" style="width: '+(Math.floor((end_stamo-start_stamo)*table_task_time/(24*60))+'px')+';position: absolute;right: '+ (typeof  x == 'undefined' ? 0 : (Math.floor((table_task_time*start_stamo)/(24*60)+table_task_time/12)-table_task_time/24)) +'px;top: '+ ((typeof  x == 'undefined' ? 0 : Math.floor(x.top))+ parseInt((height[enddates[0]]-1)*25))+'px" data-action="task_timing" data-title="'+res['sharing_events'][i]['title']+'" data-task_id="">' +
                    '   <div class="task_title">' +
                    '       <h5 class="text_ellipsis">' +
                    '           <a class="task_info cursor-pointer" data-t_id="" title="'+res['sharing_events'][i]['title']+'">'+res['sharing_events'][i]['title']+'</a>' +
                    '       </h5>' +
                    '   </div>' +
                    '   <div class="state">' +
                    '       <i class="fa fa-cog fa-2x"></i>' +
                    '   </div>' +
                    '   <div class="referrer"></div>' +
                    '</li>';

                    $("[gerdate='"+enddates[0]+"']").append(li);
                    // sss = res['sharing_events'][i]['enddate'];
                    // // console.log(res['sharing_events'][i]);
                    // www = sss.split("27");
                    // endtime = www[1];
                    // enddate = www[0];
                    // startdate = res['sharing_events'][i].startdate.split(" ");
                    // starttime = startdate[1];
                    // startdate = startdate[0];
                    // console.log(res.sharing_events[i].enddate);
                    // console.log(res.sharing_events[i].www);
                    // console.log(res.sharing_events[i].endtime);
                    // console.log(res.sharing_events[i].startdate);
                    console.log(starttime);
                    console.log(start_stamo);
                    console.log(endtime);
                    console.log(end_stamo);
                    console.log(Math.floor((end_stamo-start_stamo)*table_task_time/(24*60)));
                    $("[gerdate='"+enddates[0]+"']").css('height',Math.floor(height[enddates[0]]*24)+'px');
                    // $("[gerdate='"+enddates[0]+"']").css('width',Math.floor((table_task_time*(end_stamo-start_stamo)/(24*60))+parseInt(((end_block-start_block+1)/(1.10*(end_block-start_block)))*table_task_time/200))+'px');
                    $("[gerdate='"+enddates[0]+"']").css('width',Math.floor((end_stamo-start_stamo)*table_task_time/(24*60))+'px');
                    // $('#table_task_time .task_item_'+task_id).css('right',x.right+'px');
                    $("[gerdate='"+enddates[0]+"']").css('right',Math.floor((table_task_time*start_stamo)/(24*60)+table_task_time/12)-table_task_time/24+'px');
                    height[enddates[0]] ++;
                }
            }
        });
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
    {{--{!!userCalendarsWidget()!!}--}}
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