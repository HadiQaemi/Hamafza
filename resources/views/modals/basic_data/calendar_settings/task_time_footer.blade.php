<div class="col-xs-12">
    <div class="col-md-12 " >
        <button class="btn btn-primary pull-left" act="" id="InsertBtn_task_time">درج</button>
    </div>
    </div>
</div>
<script>
        $('#InsertBtn_task_time').click(function(){
        if($(this).attr('act')=='singleTask')
        {
            var saveObj = {};

            startdate = $('#startdate').val().split('-');
            enddate = $('#enddate').val().split('-');
            title = $('#title_time_task').val();

            var startdate = JalaliDate.jalaliToGregorian(startdate[0], startdate[1], startdate[2]);
            var enddate = JalaliDate.jalaliToGregorian(enddate[0], enddate[1], enddate[2]);
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
            var startdate = JalaliDate.jalaliToGregorian(startdate[0], startdate[1], startdate[2]);
            var enddate = JalaliDate.jalaliToGregorian(enddate[0], enddate[1], enddate[2]);

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
            numEvent = $('.tr_task_list_'+startdate[2]).attr("numEvent");
            $('#table_task_time .task_item_'+task_id).css('top',parseInt(x.top)+parseInt(numEvent*25)+'px');
            $('.tr_task_list_'+startdate[2]).attr('numEvent',parseInt(numEvent)+1);
            alert(numEvent);
            $('.tr_task_list_'+startdate[2]).css('height',parseInt((numEvent)*25+25)+'px');
            if(numEvent>1)
            {
                $('.subClass'+startdate[2]).each(function(index, elm) {
                    elm_position = $(elm).position();
                    $(elm).animate({top: parseInt(elm_position.top + 29) + 'px' }, 500);
                });
            }
            var saveObj = {};

            startdate = $('#startdate').val().split('-');
            enddate = $('#enddate').val().split('-');
            title = $('#title_time_task').val();
            var startdate = JalaliDate.jalaliToGregorian(startdate[0], startdate[1], startdate[2]);
            var enddate = JalaliDate.jalaliToGregorian(enddate[0], enddate[1], enddate[2]);
            var task_id = $('#task_id').val();



            startdate = startdate[0] + '-' + startdate[1] + '-' + startdate[2] + " " + $('#starttime').val();
            enddate = enddate[0] + '-' + enddate[1] + '-' + enddate[2] + " " + $('#endtime').val();
            console.log('startdate'+startdate);
            console.log('enddate'+enddate);
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