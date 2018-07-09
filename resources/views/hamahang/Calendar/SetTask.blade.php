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
                    <div class="row" style="margin-bottom: 10px;font-size: large">
                        <div class="col-xs-4"><select name="cid" id="cid" class="chosen-rtl"></select></div>
                        <div class="col-xs-1" style="height: 30px;padding: 0px">
                            <div class="fc-button-group right" style="height: 30px;">
                                <button type="button" class="fc-prev-button fc-button fc-state-default fc-corner-right" style="height: 25px;line-height: 30px;padding: 0px;float: right;">
                                    <span class="fc-icon fc-icon-left-single-arrow next-month" style="color: #999;"></span>
                                </button>
                                <button type="button" class="fc-next-button fc-button fc-state-default fc-corner-left" style="height: 25px;line-height: 30px;padding: 0px;float: right;">
                                    <span class="fc-icon fc-icon-right-single-arrow previous-month" style="color: #999;"></span>
                                </button>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <span style="padding: 0px 14px" class="current-month" year="{{$date['cal'][0]}}" month="{{$date['cal'][1]}}" day="{{$date['cal'][2]}}">{{$date['getMonthNames'].''.$date['cal'][0]}}</span>
                        </div>
                        <div class="col-xs-1">
                        </div>
                    </div>
                        <table class="table-bordered" id="table_task_time" style="padding: 5px;width: 100%">
                            <tr>
                                <td style="padding: 5px 3px;width: 4%">روز</td>
                                @for($d=0;$d<12;$d++)
                                    <td style="width: 8%;padding: 5px 3px;text-align: center">{{(2*$d+2).'-'.(2*$d+1)}}</td>
                                @endfor
                            </tr>
                            <tbody id="tbody_table_task_time">
                                @for($d=1;$d<=($date['cal'][1]>6 ? 30 : 31);$d++)
                                    <tr numEvent="0" class="tr_task_list_{{$d}}" jalDate="{{$date['cal'][0].'-'.$date['cal'][1].'-'.$d}}" gerYear="{{$date['GeorgianYear']}}" gerMonth="{{$date['GeorgianMonth']}}" gerDay="{{$d}}">
                                        <td style="padding: 5px 3px;width: 4%">{{$d}}</td>
                                        @for($dd=0;$dd<12;$dd++)
                                            <td style="width: 8%;padding: 0px;" class=" droppable cursor-pointer ui-droppable ui-sortable" data-task_id="{{$d.'-'.$dd}}" id="{{$d.'-'.$dd}}" hour="{{(2*$dd+2).':59:59-'.(2*$dd+1).':00:00'}}" day="{{$date['cal'][0].'-'.$date['cal'][1].'-'.$d}}" data-t_id="{{$d.'-'.$dd}}" title="{{$d.'-'.$dd}}"></td>
                                        @endfor
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
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
                    <style>
                        #related_links {
                            padding: 1px;
                            left: 15px;
                            position: absolute;
                            top: -15px !important;
                            left:27px;
                            z-index:11;
                        }
                    </style>
                    <div style="position: relative;height: 100%;width: 100%;">
                        <div class="header_task">
                            <div class="space-4"></div>
                            <div class="row" style="position: relative;">
                                {{--                                @include('hamahang.Tasks.MyTask.helper.task_related_pages')--}}
                                @include('hamahang.Tasks.helper.priority.priority_filter_time')
                            </div>
                        </div>
                    </div>
                    <div id="priority_content_area">
                        @include('hamahang.Tasks.helper.priority.content')
                    </div>


                    {{--@include('hamahang.Tasks.MyAssignedTask.helper.RapidCreateTask',['function'=>'filter_tasks_priority'])--}}

                </div>
                <div class="clearfixed"></div>
                <input id="sample_test" type="hidden">
            </div>
        </div>
    </div>
@stop
@section('inline_scripts')
    @include('hamahang.Tasks.helper.priority.time_task_priority_js')
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
    <script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/jsclender/jalali.js"></script>
    <script type="text/javascript">var jQuery_2 = $.noConflict(true);</script>
    @include('hamahang.Calendar.helper.Index.inlineJS')
    <script>
        $('#cid').on('change', function() {
            createTableTaskTime(year,month);
            load_time_task(this.value);
            initDraggable();
        });
        var def_cid = 0;
        var last_cid = 0;
        $.ajax({
            url: '{{ URL::route('auto_complete.get_user_calendar')}}',
            type: 'Post', // Send post dat
            dataType:'json',
            success: function (s) {
                var options = '';
                $('select[name="cid"]').empty();
                for (var i = 0; i < s.length; i++) {
                    if(s[i].is_default ==1)
                    {
                        options += '<option  selected=true value="' + s[i].id + '">' + s[i].title + '</option>';
                        def_cid = s[i].id;

                    }
                    else{
                        options += '<option value="' + s[i].id + '">' + s[i].title + '</option>';
                    }
                    last_cid = s[i].id;
                }
                if(def_cid ==0)
                    def_cid = last_cid;
                $('select[name="cid"]').append(options);
                $('select[name="cid"]').select2({
                    dir: "rtl",
                    width: '100%',
                });
            },
            complete: function (data) {
                load_time_task(cid);
            }
        });
        function createTableTaskTime(year,month)
        {
            html = '';
            for (i=1;i<31;i++)
            {
                gerDate = JalaliDate.jalaliToGregorian(year,month,i);
                jDate = year+'-'+month+'-'+i;
                html += '<tr numEvent="0" class="tr_task_list_'+i+'" jalDate="'+jDate+'" gerYear="'+gerDate[0]+'" gerMonth="'+gerDate[1]+'" gerDay="'+gerDate[2]+'">' +
                    '                                        <td style="padding: 5px 3px;width: 4%">'+i+'</td>';
                for(j=0;j<12;j++)
                {
                    html += '<td class="droppable cursor-pointer ui-droppable ui-sortable" style="width: 8%;padding: 0px;" data-task_id="'+i+'-'+j+'" ' +
                        'id="'+i+'-'+j+'" hour="'+(2*j+2)+':59:59-'+(2*j+1)+':00:00" ' +
                        'day="'+jDate+'" data-t_id="'+i+'-'+j+'" title="'+i+'-'+j+'"></td>';
                }
                html +='</tr>';
            }
            $('#tbody_table_task_time').html(html);
        }
        $('.next-month').click(function () {
            year = $('.current-month').attr('year');
            month = $('.current-month').attr('month');
            day = $('.current-month').attr('day');

            $('.current-month').html(JalaliDate.j_month_name[parseInt(month)]+' '+year);
            month = (parseInt(month)+1)%12;
            if(month==0)
            {
                year = parseInt(year) + 1;
                // $('.current-month').html(JalaliDate.j_month_name[month]+' '+year);
            }
            $('.current-month').attr('year',parseInt(year));
            $('.current-month').attr('month',parseInt(month));
            $('.dynamic-add-task').css('display','none');
            createTableTaskTime(year,month);
            load_time_task();
            initDraggable();
        });
        $('.previous-month').click(function () {
            year = $('.current-month').attr('year');
            month = $('.current-month').attr('month');
            day = $('.current-month').attr('day');

            month = Math.abs(parseInt(month)-1);

            if(month==0)
            {
                year = parseInt(year) - 1;
                month = 12;
                // $('.current-month').html(JalaliDate.j_month_name[month]+' '+year);
            }
            $('.current-month').attr('year',parseInt(year));
            $('.current-month').attr('month',parseInt(month));
            $('.current-month').html(JalaliDate.j_month_name[parseInt(month)-1]+' '+year);
            $('.dynamic-add-task').css('display','none');
            createTableTaskTime(year,month);
            load_time_task();
            initDraggable();
        });
        function load_time_task(cid) {
            var obj = {};
            if(cid>0)
                obj.cid = cid;
            else
                obj.cid = {{trim(Session::get('cal_default'))!='' ? Session::get('cal_default') : 1}};
                // obj.cid = 24;
            year = $('.current-month').attr('year');
            month = $('.current-month').attr('month');
            day = $('.current-month').attr('day');
            gregorianDateStart = JalaliDate.jalaliToGregorian(year,month,1);
            gregorianDateEnd = JalaliDate.jalaliToGregorian(year,month,(month>6 ? 30 : 31));
            obj.startDate = gregorianDateStart[0]+'-'+gregorianDateStart[1]+'-'+gregorianDateStart[2];
            obj.endDate = gregorianDateEnd[0]+'-'+gregorianDateEnd[1]+'-'+gregorianDateEnd[2];

            createTableTaskTime(year,month);
            var height = {}
            var table_task_time = $('#table_task_time').width();
            top_table_task_time = $('#table_task_time').position();
            $.ajax({
                url: '{{ URL::route('hamahang.calendar_events.get_calendar_events')}}',
                type: 'POST',
                data: obj,
                async: false,
                success: function (s) {
                    res = JSON.parse(s);
                    var dayEvents = [[]];
                    var enddayEvents = [[]];
                    for(i=0;i<res.sharing_events.length;i++)
                    {
                        enddate = res['sharing_events'][i]['enddate'];
                        enddates = enddate.split(" ");
                        startdate = res['sharing_events'][i]['startdate'];
                        startdates = startdate.split(" ");
                        // console.log(res['sharing_events'][i]['title']);
                        // console.log(res['sharing_events'][i]);
                        if(height[enddates[0]]==undefined)
                            height[enddates[0]] = 1;
                        split_date = enddates[0].split('-');
                        split_date = JalaliDate.gregorianToJalali(split_date[0],split_date[1],split_date[2]);
                        //alert('.tr_task_list_'+split_date[2]);

                        endtime = enddates[1].split(':');
                        starttime = startdates[1].split(':');
                        var start_stamo = parseInt(starttime[0]*60)+parseInt(starttime[1]);
                        var end_stamo = parseInt(endtime[0]*60)+parseInt(endtime[1]);
                        // g = toGregorian(split_date[0],split_date[1],split_date[2]);

                        x = $('.tr_task_list_'+split_date[2]).position();
                        subClass = '';
                        for(sd=1;sd<split_date[2];sd++)
                        {
                            subClass += ' subClass'+sd;
                        }
                        var li = '<li start="'+res['sharing_events'][i]['startdate']+'" end="'+res['sharing_events'][i]['enddate']+'" class="draggable ui-draggable ui-draggable-handle '+subClass+'" style="border-radius: 5px;padding: 1px 10px;width: '+(Math.floor((end_stamo-start_stamo)*table_task_time/(24*60))+'px')+';position: absolute;right: '+ (typeof  x == 'undefined' ? 0 : (Math.floor((table_task_time*start_stamo)/(24*60)+table_task_time/12)-table_task_time/24)) +'px;top: ____height____px" data-action="task_timing" data-title="'+res['sharing_events'][i]['title']+'" data-task_id="">' +
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
                        if(typeof dayEvents[split_date[2]] == 'undefined')
                        {
                            console.log(split_date + ', ' + enddates);
                            dayEvents[split_date[2]] = [];
                        }
                        dayEvents[split_date[2]].push(li);

                        if(typeof enddayEvents[split_date[2]] == 'undefined')
                        {
                            enddayEvents[split_date[2]] = split_date[0]+'-'+split_date[1]+'-'+split_date[2];
                            console.log(split_date[0]+'-'+split_date[1]+'-'+split_date[2]);
                        }
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
                        // console.log(starttime);
                        // console.log(start_stamo);
                        // console.log(endtime);
                        // console.log(end_stamo);
                        // console.log(Math.floor((end_stamo-start_stamo)*table_task_time/(24*60)));
                        $("[jalDate='"+enddates[0]+"']").css('height',Math.floor(height[enddates[0]]*24)+'px');
                        // $("[jalDate='"+enddates[0]+"']").css('width',Math.floor((table_task_time*(end_stamo-start_stamo)/(24*60))+parseInt(((end_block-start_block+1)/(1.10*(end_block-start_block)))*table_task_time/200))+'px');
                        $("[jalDate='"+enddates[0]+"']").css('width',Math.floor((end_stamo-start_stamo)*table_task_time/(24*60))+'px');
                        // $('#table_task_time .task_item_'+task_id).css('right',x.right+'px');
                        $("[jalDate='"+enddates[0]+"']").css('right',Math.floor((table_task_time*start_stamo)/(24*60)+table_task_time/12)-table_task_time/24+'px');
                        height[enddates[0]] ++;
                    }
                    console.log(dayEvents);
                    var cnt_event = 0;
                    for(i=1;i<dayEvents.length;i++)
                    {
                        if(typeof dayEvents[i] !== 'undefined')
                        {
                            $("[jalDate='"+enddayEvents[i]+"']").css('height',Math.floor(dayEvents[i].length*24)+'px');
                            cnt_event += dayEvents[i].length;
                            xx = $('.tr_task_list_'+i).position();
                            for(j=0;j<dayEvents[i].length;j++)
                            {
                                $('.tr_task_list_'+i).attr("numEvent",parseInt($('.tr_task_list_'+i).attr("numEvent"))+1);
                                $("[jalDate='"+enddayEvents[i]+"']").append(dayEvents[i][j].replace('____height____',(parseInt(xx.top+j*25))));
                            }
                        }
                    }
                    // $("[jalDate='"+enddates[0]+"']").append(li);
                }
            });
        }
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