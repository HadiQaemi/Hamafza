@extends('layouts.master')
@section('specific_plugin_style')
    <link href='{{URL::to("assets/Packages/calendar/fullcalendar.css")}}' rel='stylesheet'/>
    <link href='{{URL::to("assets/Packages/calendar/jquery-ui.css")}}' rel='stylesheet'/>
    <link href='{{URL::to("assets/Packages/calendar/jquery-ui.structure.css")}}' rel='stylesheet'/>
    <link href='{{URL::to("assets/Packages/calendar/jquery-ui.theme.css")}}' rel='stylesheet'/>
    <link href='{{URL::to("assets/Packages/calendar/fullcalendar.print.css")}}' rel='stylesheet' media="print"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/bootstrap/css/bootstrap.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/bootstrap/css/bootstrap-rtl.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/FontAwesome/css/font-awesome.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/chosen/chosen.css')}}">
@stop
@section('inline_style')
    <style>
        label, input {
            display: block;
        }
        input.text {
            margin-bottom: 12px;
            width: 95%;
            padding: .4em;
        }
        fieldset {
            padding: 0;
            border: 0;
            margin-top: 25px;
        }
        h1 {
            font-size: 1.2em;
            margin: .6em 0;
        }
        div#users-contain {
            width: 350px;
            margin: 20px 0;
        }
        div#users-contain table {
            margin: 1em 0;
            border-collapse: collapse;
            width: 100%;
        }
        div#users-contain table td, div#users-contain table th {
            border: 1px solid #eee;
            padding: .6em 10px;
            text-align: left;
        }
        .ui-dialog .ui-state-error {
            padding: .3em;
        }
        .validateTips {
            border: 1px solid transparent;
            padding: 0.3em;
        }
    </style>
    <style>
        body {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;
        }
        #wrap {
            width: 1100px;
            margin: 0 auto;
        }
        #external-events {
            float: left;
            width: 150px;
            padding: 0 10px;
            border: 1px solid #ccc;
            background: #eee;
            text-align: left;
        }
        #external-events h4 {
            font-size: 16px;
            margin-top: 0;
            padding-top: 1em;
        }
        #external-events .fc-event {
            margin: 10px 0;
            cursor: pointer;
        }
        #external-events p {
            margin: 1.5em 0;
            font-size: 11px;
            color: #666;
        }
        #external-events p input {
            margin: 0;
            vertical-align: middle;
        }
        #calendar {
            float: right;
            width: 900px;
        }

        #oghat_sharee_view {
            background: #d3e0e9;
            border: 1px solid #b5b5b5;
        }
    </style>
@stop
@section('content')
    <br/>
    <br/>
    <div class="row-fluid">
        <div class="col-xs-4">
            <select name="province" class="chosen-rtl" id="province">
                <option value="0">لطفا یک استان انتخاب نمایید</option>
            </select>
        </div>
        <div class="col-xs-4">
            <select name="city" id="city" class="chosen-rtl">
                <option value="0">لطفا یک شهر انتخاب نمایید</option>
            </select>
        </div>
        <div class="col-xs-2">
            <input type="button" id="oghatcal" name="oghatcal" class="default-btn" value="محاسبه اوقات شرعی">
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row-fluid" id="oghat_sharee_view">
        <div class="clearfix"></div>
    </div>
    <br/>
    <div id="event_options" class="row-fluid">
        <div class="col-xs-3"><label>تقویم هجری شمسی</label><input type="checkbox" checked name="show_event" value="jalali_event"></div>
        <div class="col-xs-3"><label>تقویم میلادی</label><input type="checkbox" checked name="show_event" value="gerregorian_event"></div>
        <div class="col-xs-3"><label>تقویم قمری</label><input type="checkbox" checked name="show_event" value="ghamari_event"></div>
        <div class="col-xs-3"><label>تقویم رویدادهای شخصی</label><input type="checkbox" checked name="show_event" value="personal_event"></div>
    </div>
    <fieldset>
        <legend>test</legend>
        <div class="row-fluid">
            <div class="col-xs-3">
                {{$uname}}
            </div>
            <div class="col-xs-9">
                <h3 id="clndr_ttl">{{ $cal_title }}</h3>
                <hr/>
            </div>
        </div>
        <div class="row-fluid">
            <div class="col-xs-3">
                <div class="panel panel-default">
                    <div class="panel-heading">انتخاب تقویم</div>
                    <div class="panel-body">
                        @foreach($cal as $ca)
                            <div level="{{ $ca->id }}" class="btn change_calendar">
                                <h5>{{ $ca->title }}</h5>
                            </div>
                            <br/>
                        @endforeach
                    </div>
                </div>
                <hr/>
                <div class="panel panel-default">
                    <div class="panel-heading">افزودن تقویم جدید</div>
                    <div class="panel-body">
                        <label for="new_calendar_title">عنوان : </label>
                        <input type="text" name="new_calendar_title" id="new_calendar_title" value="" class="text ui-widget-content ui-corner-all">
                        <button id="change_ttl">ثبت</button>
                    </div>
                </div>
            </div>
            <div class="col-xs-9">
                <div id='wrap'>
                    <div id='calendar'></div>
                    <div id='external-events'>
                        <h4>Draggable Events</h4>
                        <div class='fc-event' style="background-color: red" level="1">وظیفه</div>
                        <div class='fc-event' style="background-color:green" level="2">جلسه</div>
                        <div class='fc-event' style="background-color:blue" level="3">رویداد</div>
                        <div class='fc-event' style="background-color:pink" level="4">یادآوری</div>
                        <div class='fc-event' style="background-color:graytext" level="5">My Event 5</div>
                        <p>
                            <input type='checkbox' id='drop-remove'/>
                            <label for='drop-remove'>remove after drop</label>
                        </p>
                    </div>
                    <div id="eventContent" title="Event Details" style="display:none;">
                        <fieldset>
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="Jane Smith" class="text ui-widget-content ui-corner-all">
                            <label for="respite_date">start date</label>
                            <input type="text" class="form-control DatePicker" name="start_date" id="start_date">
                            <label for="respite_time">start time</label>
                            <input type="text" class="form-control TimePicker" name="start_time" id="start_time" aria-describedby="respite_time">
                            <label for="respite_date">end date</label>
                            <input type="text" class="form-control DatePicker" name="end_date" id="end_date" aria-describedby="respite_date">
                            <label for="respite_time">end time</label>
                            <input type="text" class="form-control TimePicker" name="end_time" id="end_time" aria-describedby="respite_time">
                            <button id="change_ttl">ثبت</button>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
@stop

@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::asset('assets/Packages/calendar/lib/moment/moment.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('assets/Packages/calendar/lib/moment/moment-jalaali.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('assets/Packages/calendar/lib/jquery/dist/jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('assets/Packages/calendar/dist/fullcalendar.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('assets/Packages/calendar/lib/jquery-ui/jquery-ui.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('assets/Packages/calendar/lang/fa.js')}}"></script>
    <script src="{{URL::asset('assets/Packages/bootstrap/js/bootstrap.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/chosen/chosen.jquery.js')}}"></script>
@stop
@section('inline_scripts')
    <script>
        $(document).ready(function () {
            $.ajax({
                url: '{{ URL::route('calendar.provinces_and_cites.province')}}',
                type: 'GET', // Send post dat
                async: false,
                success: function (s) {
                    s = JSON.parse(s);
                    var options = '';
                    for (var i = 0; i < s.length; i++) {
                        options += '<option value="' + s[i].id + '">' + s[i].name + '</option>';
                    }
                    $('#province').append(options);
                    $('#province').chosen();
                }
            });
            $('#province').change(function () {
                var pid = $('#province').val();
                $.ajax({
                    url: '{{ URL::route('calendar.provinces_and_cites.cities',['pId'=>''])}}/' + pid,
                    type: 'GET', // Send post dat
                    async: false,
                    success: function (s) {
                        s = JSON.parse(s);
                        var options = '';
                        for (var i = 0; i < s.length; i++) {
                            options += '<option value="' + s[i].id + '">' + s[i].name + '</option>';
                        }
                        $("#city").chosen("destroy");
                        $("#city").empty();
                        //$('#city').val('').trigger('cliszt:updated');
                        $('#city').append(options);
                        $('#city').chosen();
                    }
                });
            });
            $('#oghatcal').click(function () {
                city_id = $("#city").val();
                console.log(city_id);
                if (city_id == 0) {
                    alert('لطفا یک شهر را انتخاب کنید');
                }
                else {
                    $.ajax({
                        url: '{{ URL::route('Calendar.oghatSharee',['cityId'=>''])}}/' + city_id,
                        type: 'GET', // Send post dat
                        async: false,
                        success: function (s) {
                            list = JSON.parse(s);
                            var html = '';
                            html += ' <div class="col-xs-4">' +
                                '<div class="col-xs-12"><label> صبح</lable></div>' +
                                '<div class="col-xs-12"><label> اذان</lable>' + list['s'] + '</div>' +
                                '<div class="col-xs-12"><label>طلوع آفتاب</lable>' + list['t'] + '</div>' +
                                '<div class="clearfix"></div>' +
                                '</div>';
                            html += '<div class="col-xs-4">' +
                                '<div class="col-xs-12"><label> ظهر</lable></div>' +
                                '<div class="col-xs-12"><label> اذان</lable>' + list['z'] + '</div>' +
                                '<div class="col-xs-12"><label>غروب آفتاب</lable>' + list['g'] + '</div>' +
                                '<div class="clearfix"></div>' +
                                '</div>';

                            html += ' <div class="col-xs-4">' +
                                '<div class="col-xs-12"><label>مغرب</lable></div>' +
                                '<div class="col-xs-12"><label> اذان</lable>' + list['m'] + '</div>' +
                                '<div class="col-xs-12"><label>نیمه شب شرعی</lable>' + list['n'] + '</div>' +
                                '<div class="clearfix"></div>' +
                                '</div>';
                            $('#oghat_sharee_view').html(html);
                        }
                    });
                }
            });
            $('#event_options').click(function () {
                evts = $('input[name="show_event"]');
                console.log(evts);
                for (i = 0; i < evts.length; i++) {
                    //console.log(evts[i]);
                    //console.log(evts[i].value);
                    if (evts[i].checked == true) {
                        $("." + evts[i].value).show();
                    }
                    else {
                        $("." + evts[i].value).hide();
                    }
                }
            });
            $(".TimePicker").persianDatepicker({
                format: "HH:mm:ss a",
                timePicker: {
                    //showSeconds: false,
                },
                onlyTimePicker: true
            });
            $(".DatePicker").persianDatepicker({
                observer: true,
                autoClose: true,
                format: 'YYYY-MM-DD'
            });
            var ev;
            var etype = '';
            var event_id = '';
            var zone = "08:00";  //Change this to your timezone
            /*$.ajax({
             url: '{--{ URL::route('hamahang.calendar.data',['uname'=>$uname] )--}}',
             type: 'POST', // Send post data
             data: 'type=fetch',
             async: false,
             success: function (s) {

             json_events = s;
             }
             });*/
            $.ajax({
                url: '{{ URL::route('hamahang.calendar.all_data')}}',
                type: 'POST', // Send post data
                data: 'type=fetch',
                async: false,
                success: function (s) {

                    json_events = s;
                    json_events = JSON.parse(json_events);
                }
            });
            $.ajax({
                url: 'getAllEvent',
                type: 'POST', // Send post data
                data: 'type=fetch',
                async: false,
                success: function (s) {
                    freshevents = s;
                }
            });
            $('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
            var currentMousePos = {
                x: -1,
                y: -1
            };
            jQuery(document).on("mousemove", function (event) {
                currentMousePos.x = event.pageX;
                currentMousePos.y = event.pageY;
            });
            /* initialize the external events
             -----------------------------------------------------------------*/
            $(".fc-event").mousedown(function () {
                etype = ($(this).attr('level'));
            });
            $('#external-events .fc-event').each(function () {
// store data so the calendar knows to render an event upon drop
                $(this).data('event', {
                    title: $.trim($(this).text()), // use the element's text as the event title
                    stick: true // maintain when user navigates (see docs on the renderEvent method)
                });
// make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 999,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                });
            });
            /* initialize the calendar
             -----------------------------------------------------------------*/
            $('#calendar').fullCalendar({
                events: json_events.res,

//events: [{"id":"14","title":"New Event","start":"2016-11-21T16:00:00+04:00","allDay":true}],
                utc: true,
                header: {
                    left: 'next,prev, today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                isJalaali: true,
                isRTL: true,
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar
                drop: function () {
                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }
                },
                eventLimit: false,
                eventReceive: function (event) {
                    var title = event.title;
                    var start = event.start.format("YYYY-MM-DD"); ///[T]HH:mm:SS
                    //alert(start);
                    $.ajax({
                        url: 'calendar',
                        data: 'type=new&title=' + title + '&startdate=' + start + '&zone=' + zone + '&event_type=' + etype,
                        type: 'POST',
                        dataType: 'json',
                        success: function (response) {
                            event.id = response.eventid;
                            event.color = response.color;
                            $('#calendar').fullCalendar('updateEvent', event);
                        },
                        error: function (e) {
                            console.log(e.responseText);
                        }
                    });
                    $('#calendar').fullCalendar('updateEvent', event);
                    // console.log(event);
                    // console.log('s3');
                },
                eventDrop: function (event, delta, revertFunc) {
                    var title = event.title;
                    var start = event.start.format();
                    var end = (event.end == null) ? start : event.end.format();
                    $.ajax({
                        url: 'calendar',
                        data: 'type=resetdate&title=' + title + '&start=' + start + '&end=' + end + '&eventid=' + event.id,
                        type: 'POST',
                        dataType: 'json',
                        success: function (response) {
                            if (response.status != 'success')
                                revertFunc();
                        },
                        error: function (e) {
                            revertFunc();
                            alert('Error processing your request: ' + e.responseText);
                        }
                    });
                },
                eventClick: function (event, jsEvent, view) {
                    ev = event;
                    console.log(event.id);
                    console.log('s2');
                    event_id = event.id;
                    $('#name').val(event.title);
                    $("#startTime").html(moment(event.start).format('MMM Do h:mm A'));
                    $("#endTime").html(moment(event.end).format('MMM Do h:mm A'));
                    $("#eventInfo").html(event.description);
                    $("#eventLink").attr('href', event.url);
                    $("#eventContent").dialog({modal: true, title: event.title, width: 350});
//                        var title = prompt('Event Title:', event.title, { buttons: { Ok: true, Cancel: false} });
//                        if (title){
//                            event.title = title;
//                            console.log('type=changetitle&title='+title+'&eventid='+event.id);
//                            $.ajax({
//                                url: 'process.php',
//                                data: 'type=changetitle&title='+title+'&eventid='+event.id,
//                                type: 'POST',
//                                dataType: 'json',
//                                success: function(response){
//                                    if(response.status == 'success')
//                                        $('#calendar').fullCalendar('updateEvent',event);
//                                },
//                                error: function(e){
//                                    alert('Error processing your request: '+e.responseText);
//                                }
//                            });

                },
                eventResize: function (event, delta, revertFunc) {
                    // console.log(event);
                    var title = event.title;
                    var end = event.end.format();
                    var start = event.start.format();
                    //console.log('s1');
                    $.ajax({
                        url: 'calendar',
                        data: 'type=resetdate&title=' + title + '&start=' + start + '&end=' + end + '&eventid=' + event.id,
                        type: 'POST',
                        dataType: 'json',
                        success: function (response) {
                            if (response.status != 'success')
                                revertFunc();
                        },
                        error: function (e) {
                            revertFunc();
                            alert('Error processing your request: ' + e.responseText);
                        }
                    });
                }
            });
            function getFreshEvents() {
                /*$.ajax({
                 url: 'calendar',
                 type: 'POST', // Send post data
                 data: 'type=fetch',
                 async: false,
                 success: function (s) {
                 freshevents = s;
                 }
                 });*/
            }
            function isElemOverDiv() {
                var trashEl = jQuery('#trash');
                var ofs = trashEl.offset();
                var x1 = ofs.left;
                var x2 = ofs.left + trashEl.outerWidth(true);
                var y1 = ofs.top;
                var y2 = ofs.top + trashEl.outerHeight(true);
                if (currentMousePos.x >= x1 && currentMousePos.x <= x2 &&
                    currentMousePos.y >= y1 && currentMousePos.y <= y2) {
                    return true;
                }
                return false;
            }
            $(function () {
                var dialog, form,
                    // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                    emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
                    name = $("#name"),
                    email = $("#email"),
                    password = $("#password"),
                    allFields = $([]).add(name).add(email).add(password),
                    tips = $(".validateTips");
                function updateTips(t) {
                    tips
                        .text(t)
                        .addClass("ui-state-highlight");
                    setTimeout(function () {
                        tips.removeClass("ui-state-highlight", 1500);
                    }, 500);
                }
                function checkLength(o, n, min, max) {
                    if (o.val().length > max || o.val().length < min) {
                        o.addClass("ui-state-error");
                        updateTips("Length of " + n + " must be between " +
                            min + " and " + max + ".");
                        return false;
                    } else {
                        return true;
                    }
                }
                function checkRegexp(o, regexp, n) {
                    if (!(regexp.test(o.val()))) {
                        o.addClass("ui-state-error");
                        updateTips(n);
                        return false;
                    } else {
                        return true;
                    }
                }
                function addUser() {
                    var valid = true;
                    allFields.removeClass("ui-state-error");
                    valid = valid && checkLength(name, "username", 3, 16);
                    valid = valid && checkLength(email, "email", 6, 80);
                    valid = valid && checkLength(password, "password", 5, 16);
                    valid = valid && checkRegexp(name, /^[a-z]([0-9a-z_\s])+$/i, "Username may consist of a-z, 0-9, underscores, spaces and must begin with a letter.");
                    valid = valid && checkRegexp(email, emailRegex, "eg. ui@jquery.com");
                    valid = valid && checkRegexp(password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9");
                    if (valid) {
                        $("#users tbody").append("<tr>" +
                            "<td>" + name.val() + "</td>" +
                            "<td>" + email.val() + "</td>" +
                            "<td>" + password.val() + "</td>" +
                            "</tr>");
                        dialog.dialog("close");
                    }
                    return valid;
                }
                dialog = $("#dialog-form").dialog({
                    autoOpen: false,
                    height: 400,
                    width: 350,
                    modal: true,
                    buttons: {
                        "Create an account": addUser,
                        Cancel: function () {
                            dialog.dialog("close");
                        }
                    },
                    close: function () {
                        form[0].reset();
                        allFields.removeClass("ui-state-error");
                    }
                });
                form = dialog.find("form").on("submit", function (event) {
                    event.preventDefault();
                    addUser();
                });
                $("#create-user").button().on("click", function () {
                    dialog.dialog("open");
                });
            });
            $('.change_calendar').click(function () {
                    var c = $(this).attr('level');
                    $.ajax({
                        url: 'change_calendar',
                        data: 'c=' + c,
                        type: 'POST',
                        dataType: 'json',
                        success: function (response) {
                            $('#calendar').fullCalendar('removeEvents');
                            $.ajax({
                                url: 'calendar',
                                type: 'POST', // Send post data
                                data: 'type=fetch',
                                async: false,
                                success: function (s) {
                                    //console.log(s);
                                    freshevents = s;
                                }
                            });
                            $('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
                            document.getElementById('clndr_ttl').innerText = s.clndr_ttl;
                        },
                        error: function (e) {
                            alert('Error processing your request: ' + e.responseText);
                        }
                    });
                }
            );
            $('#change_ttl').click(function () {
                $("#eventContent").dialog("close");
                var event_title = document.getElementById('name').value;
                var start_date = document.getElementById('start_date').value;
                var start_time = document.getElementById('start_time').value;
                var end_date = document.getElementById('end_date').value;
                var end_time = document.getElementById('end_time').value;
//console.log('type=changetitle&title=' + event_title + '&eventid=' + event_id + '&start_date=' + start_date + '&start_time =' + start_time + '&end_date =' + end_date);
                $.ajax({
                    url: 'calendar',
                    data: 'type=changetitle&title=' + event_title + '&eventid=' + event_id + '&start_date=' + start_date + '&start_time=' + start_time + '&end_date=' + end_date + '&end_time=' + end_time,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == 'success') {
                            ev.title = event_title;
                            $('#calendar').fullCalendar('updateEvent', ev);
                        }
                    },
                    error: function (e) {
                        alert('Error processing your request: ' + e.responseText);
                    }
                });
            });
        });
    </script>
    <script>
        $(function () {
            var dialog, form,
                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
                name = $("#name"),
                email = $("#email"),
                password = $("#password"),
                allFields = $([]).add(name).add(email).add(password),
                tips = $(".validateTips");
            function updateTips(t) {
                tips
                    .text(t)
                    .addClass("ui-state-highlight");
                setTimeout(function () {
                    tips.removeClass("ui-state-highlight", 1500);
                }, 500);
            }
            function checkLength(o, n, min, max) {
                if (o.val().length > max || o.val().length < min) {
                    o.addClass("ui-state-error");
                    updateTips("Length of " + n + " must be between " +
                        min + " and " + max + ".");
                    return false;
                } else {
                    return true;
                }
            }
            function checkRegexp(o, regexp, n) {
                if (!(regexp.test(o.val()))) {
                    o.addClass("ui-state-error");
                    updateTips(n);
                    return false;
                } else {
                    return true;
                }
            }
            function addUser() {
                var valid = true;
                allFields.removeClass("ui-state-error");
                valid = valid && checkLength(name, "username", 3, 16);
                valid = valid && checkLength(email, "email", 6, 80);
                valid = valid && checkLength(password, "password", 5, 16);
                valid = valid && checkRegexp(name, /^[a-z]([0-9a-z_\s])+$/i, "Username may consist of a-z, 0-9, underscores, spaces and must begin with a letter.");
                valid = valid && checkRegexp(email, emailRegex, "eg. ui@jquery.com");
                valid = valid && checkRegexp(password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9");
                if (valid) {
                    $("#users tbody").append("<tr>" +
                        "<td>" + name.val() + "</td>" +
                        "<td>" + email.val() + "</td>" +
                        "<td>" + password.val() + "</td>" +
                        "</tr>");
                    dialog.dialog("close");
                }
                return valid;
            }
            dialog = $("#dialog-form").dialog({
                autoOpen: false,
                height: 400,
                width: 350,
                modal: true,
                buttons: {
                    "Create an account": addUser,
                    Cancel: function () {
                        dialog.dialog("close");
                    }
                },
                close: function () {
                    form[0].reset();
                    allFields.removeClass("ui-state-error");
                }
            });
            form = dialog.find("form").on("submit", function (event) {
                event.preventDefault();
                addUser();
            });
            $("#create-user").button().on("click", function () {
                dialog.dialog("open");
            });
        });
    </script>
@stop
@section('CustomRightMenu')
    <div class="panel-heading panel-heading-darkblue"> فهرست</div>
    <div class="panel-body searching-cntnt" style="margin-bottom: 10px">
        <div accordion="" class="panel-group accordion" id="accordion">
            {!!$RightContent!!}
        </div>
    </div>
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
