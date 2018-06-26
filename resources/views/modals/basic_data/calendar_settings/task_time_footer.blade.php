<div class="col-xs-12">
    <div class="col-md-12 " >
        <button class="btn btn-primary pull-left" act="" id="InsertBtn_task_time">درج</button>
    </div>
    </div>
</div>
<script>
    JalaliDate = {
        g_days_in_month: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
        j_days_in_month: [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29]
    };
    jalaliToGregorian = function(j_y, j_m, j_d)
    {
        j_y = parseInt(j_y);
        j_m = parseInt(j_m);
        j_d = parseInt(j_d);
        var jy = j_y-979;
        var jm = j_m-1;
        var jd = j_d-1;

        var j_day_no = 365*jy + parseInt(jy / 33)*8 + parseInt((jy%33+3) / 4);
        for (var i=0; i < jm; ++i) j_day_no += JalaliDate.j_days_in_month[i];

        j_day_no += jd;

        var g_day_no = j_day_no+79;

        var gy = 1600 + 400 * parseInt(g_day_no / 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
        g_day_no = g_day_no % 146097;

        var leap = true;
        if (g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */
        {
            g_day_no--;
            gy += 100*parseInt(g_day_no/  36524); /* 36524 = 365*100 + 100/4 - 100/100 */
            g_day_no = g_day_no % 36524;

            if (g_day_no >= 365)
                g_day_no++;
            else
                leap = false;
        }

        gy += 4*parseInt(g_day_no/ 1461); /* 1461 = 365*4 + 4/4 */
        g_day_no %= 1461;

        if (g_day_no >= 366) {
            leap = false;

            g_day_no--;
            gy += parseInt(g_day_no/ 365);
            g_day_no = g_day_no % 365;
        }

        for (var i = 0; g_day_no >= JalaliDate.g_days_in_month[i] + (i == 1 && leap); i++)
            g_day_no -= JalaliDate.g_days_in_month[i] + (i == 1 && leap);
        var gm = i+1;
        var gd = g_day_no+1;

        return [gy, gm, gd];
    }
    $('#InsertBtn_task_time').click(function(){
        if($(this).attr('act')=='singleTask')
        {
            var saveObj = {};

            startdate = $('#startdate').val().split('-');
            enddate = $('#enddate').val().split('-');
            title = $('#title_time_task').val();

            var startdate = jalaliToGregorian(startdate[0], startdate[1], startdate[2]);
            var enddate = jalaliToGregorian(enddate[0], enddate[1], enddate[2]);
            var task_id = $('#task_id').val();

            startdate = startdate[0] + '-' + startdate[1] + '-' + startdate[2] + " " + $('#starttime').val();
            enddate = enddate[0] + '-' + enddate[1] + '-' + enddate[2] + " " + $('#endtime').val();
            saveObj.hstartdate = startdate;
            saveObj.henddate = enddate;
            saveObj.htitle = title;
            saveObj.hcid = $('#cid').val();
            saveObj.event_type = "task";
            saveObj.task_id = task_id;
            $.ajax({
                url: '{{ URL::route('hamahang.calendar_events.save_task_event')}}',
                type: 'POST', // Send post dat
                data: saveObj,
                async: false,
                success: function (s) {
                    res = JSON.parse(s);
                    console.log(s);
                    console.log(res);
                    if (res.success == false) {
                        errorsFunc('{{trans('calendar_events.ce_error_label')}}', res.error, '', '');
                    } else {
                        var html = '{{trans("calendar.calendar_setTime_Task")}} <strong>' + saveObj.htitle + ' </strong> {{trans("calendar.success_operarion")}}';
                        messageModal('success', '{{trans("calendar.calendar_saveEvent_clicked_success_msg_header")}}', html);
                        (function ($) {
                            $("#calendar").fullCalendar('addEventSource', [{
                                start: startdate,
                                end: enddate,
                                title: title,
                                color: '#841f1f',
                                block: true,
                            },]);
                        })(jQuery_2);
                        newEventModal.close();
                    }

                }
            });
        }
        else if($(this).attr('act')=='multiTask')
        {
            var saveObj = {};
            startdate = $('#startdate').val().split('-');
            enddate = $('#enddate').val().split('-');
            var startdate = jalaliToGregorian(startdate[0], startdate[1], startdate[2]);
            var enddate = jalaliToGregorian(enddate[0], enddate[1], enddate[2]);

            saveObj.hstartdate = startdate[0] + '-' + startdate[1] + '-' + startdate[2] + " " + $('#starttime').val();
            saveObj.henddate = enddate[0] + '-' + enddate[1] + '-' + enddate[2] + " " + $('#endtime').val();
            saveObj.htitle = "";
            saveObj.hcid = $('#cid').val();
            saveObj.event_type = "task";
            task_id = $('#task_id').val();
            saveObj.task_id = task_id.split(',');
            $.ajax({
                url: '{{ URL::route('hamahang.calendar_events.save_multi_task_event')}}',
                type: 'POST', // Send post dat
                data: saveObj,
                async: false,
                success: function (s) {
                    res = JSON.parse(s);
                    console.log(s);
                    console.log(res);
                    if (res.success == false) {
                        errorsFunc('{{trans('calendar_events.ce_error_label')}}', res.error, '', '');
                    } else {
                        var html = '{{trans("calendar.calendar_setTime_Task")}} {{trans("calendar.success_operarion")}}';
                        messageModal('success', '{{trans("calendar.calendar_saveEvent_clicked_success_msg_header")}}', html);
                        for (i = 0; i < res.length; i++) {
                            (function ($) {
                                $("#calendar").fullCalendar('addEventSource', [{
                                    start: res[i].hstartdate,
                                    end: res[i].enddate,
                                    title: res[i].htitle,
                                    color: '#4A667D',
                                    block: true,
                                },]);
                            })(jQuery_2);
                        }
                        newEventModal.close();
                    }
                }
            });
            // for (i = 0; i < task_id.length; i++) {
            //     (function ($) {
            //         $("#calendar").fullCalendar('addEventSource', [{
            //             start: startdate,
            //             end: enddate,
            //             title: task_id[i],
            //             color: '#4A667D',
            //             block: true,
            //         },]);
            //     })(jQuery_2);
            // }
            // startdate = $('#startdate').val().split('-');
            // enddate = $('#enddate').val().split('-');
            // title = $('#title_time_task').val();
            // var startdate = jalaliToGregorian(startdate[0], startdate[1], startdate[2]);
            // var enddate = jalaliToGregorian(enddate[0], enddate[1], enddate[2]);
            //
            // startdate = startdate[0] + '-' + startdate[1] + '-' + startdate[2] + " " + $('#starttime').val();
            // enddate = enddate[0] + '-' + enddate[1] + '-' + enddate[2] + " " + $('#endtime').val();
            // newEventModal.close();
            // (function ($) {
            //     $("#calendar").fullCalendar('addEventSource', [{
            //         start: startdate,
            //         end: enddate,
            //         title: title,
            //         color: '#841f1f',
            //         block: true,
            //     },]);
            // })(jQuery_2);
        }
        else{
            var droppedOn = $('#droppedOn').val();
            var task_id = $('#task_id').val();
            startdate = $('#startdate').val().split('-');
            starttime = $('#starttime').val().split(':');
            enddate = $('#enddate').val().split('-');
            endtime = $('#endtime').val().split(':');

            start_block = Math.floor((starttime[0]-1)/2);
            end_block = Math.floor((endtime[0]-1)/2);

            x = $('.tr_task_list_'+startdate[2]).position();

            var table_task_time = $('#table_task_time').width();
            var end_stamo = parseInt(endtime[0]*60)+parseInt(endtime[1]);
            var start_stamo = parseInt(starttime[0]*60)+parseInt(starttime[1]);

            $('#table_task_time .task_item_'+task_id).css('position','absolute');
            $('#table_task_time .task_item_'+task_id).css('width',Math.floor((table_task_time*(end_stamo-start_stamo)/(24*60))+parseInt(((end_block-start_block+1)/(1.10*(end_block-start_block)))*table_task_time/200))+'px');
//        $('#table_task_time .task_item_'+task_id).css('right',x.right+'px');
            $('#table_task_time .task_item_'+task_id).css('right',Math.floor((table_task_time*start_stamo)/(24*60)+table_task_time/12)-table_task_time/24+'px');
            $('#table_task_time .task_item_'+task_id).css('top',x.top+'px');

            var saveObj = {};

            startdate = $('#startdate').val().split('-');
            enddate = $('#enddate').val().split('-');
            title = $('#title_time_task').val();
            console.log(startdate);
            console.log(enddate);
            var startdate = jalaliToGregorian(startdate[0], startdate[1], startdate[2]);
            var enddate = jalaliToGregorian(enddate[0], enddate[1], enddate[2]);
            var task_id = $('#task_id').val();

            startdate = startdate[0] + '-' + startdate[1] + '-' + startdate[2] + " " + $('#starttime').val();
            enddate = enddate[0] + '-' + enddate[1] + '-' + enddate[2] + " " + $('#endtime').val();
            console.log(startdate);
            console.log(enddate);
            saveObj.hstartdate = startdate;
            saveObj.henddate = enddate;
            saveObj.htitle = title;
            saveObj.hcid = $('#cid').val();
            saveObj.event_type = "task";
            saveObj.task_id = task_id;
            $.ajax({
                url: '{{ URL::route('hamahang.calendar_events.save_task_event')}}',
                type: 'POST', // Send post dat
                data: saveObj,
                async: false,
                success: function (s) {
                    res = JSON.parse(s);
                    console.log(s);
                    console.log(res);
                    if (res.success == false) {
                        errorsFunc('{{trans('calendar_events.ce_error_label')}}', res.error, '', '');
                    } else {
                        var html = '{{trans("calendar.calendar_setTime_Task")}} <strong>' + saveObj.htitle + ' </strong> {{trans("calendar.success_operarion")}}';
                        messageModal('success', '{{trans("calendar.calendar_saveEvent_clicked_success_msg_header")}}', html);
                        // (function ($) {
                        //     $("#calendar").fullCalendar('addEventSource', [{
                        //         start: startdate,
                        //         end: enddate,
                        //         title: title,
                        //         color: '#841f1f',
                        //         block: true,
                        //     },]);
                        // })(jQuery_2);
                        newEventModal.close();
                    }

                }
            });
        }

    });
</script>