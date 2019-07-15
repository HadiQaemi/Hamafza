<script type="text/javascript">
    $("#add_seesion_dialog").on('hidden.bs.modal', function () {
        $("#form-event-content").css('display', 'block');
    });
    $("#add_invitation_dialog").on('hidden.bs.modal', function () {
        $("#form-user-event-invitation").css('display', 'block');
    });
    $("#new_reminder_dialog").on('hidden.bs.modal', function () {
        $("#form-reminder-content").css('display', 'block');
    });
    persianToEnDigit = {'۰': 0, '۱': 1, '۲': 2, '۳': 3, '۴': 4, '۵': 5, '۶': 6, '۷': 7, '۸': 8, '۹': 9};
    function persianToEngilshDigit(digit) {
        var enDigitArr = [], peDigitArr = [];
        for (var i = 0; i < digit.length; i++) {
            peDigitArr.push(digit[i]);
        }
        //console.log(peDigitArr);
        for (var j = 0; j < peDigitArr.length; j++) {
            enDigitArr.push(persianToEnDigit[peDigitArr[j]]);
        }
        return enDigitArr.join('');
    }
    function engilshToPersianDigit(digit) {
        EnDigitTopersian = {0: '۰', 1: '۱', 2: '۲', 3: '۳', 4: '۴', 5: '۵', 6: '۶', 7: '۷', 8: '۸', 9: '۹'};
        digit = digit.toString();
        var enDigitArr = [], peDigitArr = [];
        for (var i = 0; i < digit.length; i++) {
            enDigitArr.push(digit[i]);
        }
        //console.log(peDigitArr);
        for (var j = 0; j < enDigitArr.length; j++) {
            peDigitArr.push(EnDigitTopersian[enDigitArr[j]]);
        }
        return peDigitArr.join('');
    }
    function set_time_task()
    {
        $('#calendar_time_task').trigger('click');
        jQuery('#calendar_time_task').click();
    }
    /*#############################################################################################*/
    /*------------------------------------------------------------------------------------------------*/
    /*---------------------------------------second to tim --------------------------------------------*/
    /*------------------------------------------------------------------------------------------------*/
    function secondToTime(seconds) {
        var sec_num = parseInt(seconds, 10); // don't forget the second param
        var hours = Math.floor(sec_num / 3600);
        var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
        var seconds = sec_num - (hours * 3600) - (minutes * 60);
        if (hours < 10) {
            hours = "0" + hours;
        }
        if (minutes < 10) {
            minutes = "0" + minutes;
        }
        if (seconds < 10) {
            seconds = "0" + seconds;
        }
        return hours + ':' + minutes + ':' + seconds;
    }
    /*####################################################################################################################*/
    /*--------------------------------------------------------------------------------------------------------------------*/
    /*------------------------------------------------- ---------------------------------------------------*/
    var globalCalendar = '';
    var seasonEvents = '';
    var sixMonthEvents = '';
    var yearEvents = '';
    var addMenuDialog = '';
    var calendarModal = '';
    var editcalendarModal = '';
    $(document).ready(function () {
        $('#calendar_widget_current_month').persianDatepicker({
            timePicker: {
                enabled: false
            },
            monthPicker: {
                scrollEnabled: false
            },
            dayPicker: {
                scrollEnabled: false,
                onSelect: function (uninTime) {
                    d = persianDate(uninTime);
                    formatPersian = false;
                    console.log(d.format("YYYY/MM/DD"));
                    var pDateAr = d.format("YYYY/MM/DD").split('/');
                    var gDate = moment(d.format("YYYY/MM/DD").toString(), 'jYYYY/jM/jD').format('YYYY-M-D ');
                    gDateAr = gDate.split('-');
                    for (var i = 0; i < gDateAr.length; i++) {
                        gDateAr[i] = persianToEngilshDigit(gDateAr[i])
                    }
                    (function ($) {
                        globalCalendar.fullCalendar('gotoDate', gDateAr.join('-'));
                        globalCalendar.fullCalendar('changeView', 'agendaDay');
                    })(jQuery_2);
                }
            }
        });
        $(".DatePicker").persianDatepicker({
            autoClose: true,
            format: 'YYYY-MM-DD'
        });
        $(".DatePicker").val('');
        $('#pan_t3').on('click', function () {
            setTimeout(function () {
                $("#states-multi-select-users").ajaxChosen({
                    dataType: 'json',
                    type: 'POST',
                    url: "{{ route('auto_complete.users') }}"
                });
            }, 1000);
        });
        $('#pan_t3').on('click', function () {
            setTimeout(function () {
                $("#states-multi-select-users_edit").ajaxChosen({
                    dataType: 'json',
                    type: 'POST',
                    url: "{{ route('auto_complete.users',['username'=>$uname]) }}"
                });
            }, 1000);
        });
        /*$('input[name="beginning_day"]').change(
         function () {
         if ($('input[name="beginning_day"]:checked ').val() == 3) {
         // if( $('#hiden_holder').length)
         $('#hiden_holder').show();

         }
         else {

         $('#hiden_holder').hide();
         }
         });*/
        $(document).on('click', '#saveEdit', function () {
            var editPost = {};
            editPost.id = $('#form_edit_item_item_id').val();
            editPost.htitle = $('#item_title').val();
            editPost.htype = $('#item_edit input[name="type"]:checked').val();
            if ($('input[name="is_default"]').is(':checked')) {
                editPost.his_default = 1;
            }
            else {
                editPost.his_default = 0
            }
            loading({id: 'personalCalendarGrid'}, 1);
            editPost.hdescriotion = $('#item_edit textarea[name="descriotion"]').val();
            editPost.hprayer_times = $('input[name="prayer_times"]:checked').val();
            editPost.hprovince = $('#province').select().val();
            editPost.hcity = $('#item_prayer_time_city').select().val();
            editPost.hbeginning_day = $('input[type="radio"][name="beginning_day"]:checked').val();
            hiddenTimes_from = $('input[name="hidden_from[]"]');
            hiddenTimes_from_arr = new Array()
            for (var i = 0; i < hiddenTimes_from.length; i++) {

                hiddenTimes_from_arr[i] = hiddenTimes_from[i].value;
            }
            editPost.hhidden_from = hiddenTimes_from_arr.toString();
            hiddenTimes_to = $('input[name="hidden_to[]"]');
            hiddenTimes_to_arr = new Array()
            for (var i = 0; i < hiddenTimes_to.length; i++) {

                hiddenTimes_to_arr[i] = hiddenTimes_to[i].value;
            }
            editPost.hhidden_to = hiddenTimes_to_arr.toString();
            if ($('input[type="checkbox"][name="monasebat"]').is('checked')) {
                editPost.hmonasebat = 1;
            }
            else {
                editPost.hmonasebat = 0;
            }
            if ($('input[type="checkbox"][name="brith_day"]').is('checked')) {
                editPost.hbrith_day = 1;
            }
            else {
                editPost.hbrith_day = 0;
            }
            editPost.hviewPermissions = $('select[name="viewPermissions[]"]').val().toString();
            editPost.heditPermissions = $('select[name="editPermissions[]"]').val().toString();
            editPost.hsharing_calendars = $('input[name="sharing_calendars"]').val();
            var defaultOptions = {};
            $('#t5 .default-options input[type="checkbox"]').each(function () {
                if (this.checked) {
                    var ch = 1
                } else {
                    var ch = 0
                }
                //console.log(this.name);
                //console.log( $('#t5 .default-options input[name="'+this.name+'-color"]').val());
                var color = $('#t5 .default-options input[name="' + this.name + '-color"]').val();
                var obj = {checked: ch, color: color}
                defaultOptions[this.name] = obj;
            });
            editPost.default_options = JSON.stringify(defaultOptions);
            $.ajax({
                url: '{{ URL::route('hamahang.calendar.edit_save') }}',
                type: 'post', // Send post dat
                data: editPost,
                async: false,
                success: function (s) {
                    s = JSON.parse(s);
                    //console.log(s.success);
                    if (s.success == true) {
                        successFunc('ذخیره', {0: '{{trans("calendar.calendar_saveEdidt_success_msg")}}'}, {id: 'edit_form_error'}, 'calendar_info_form');
                    }
                    else {
                        errorsFunc('خطا', s.error, {id: 'edit_form_error'}, 'calendar_info_form');
                    }
                    // $('#edit_form_error').html(html);

                    //  calendarGridReload();
                    $('#personalCalendarGrid').DataTable().ajax.reload();
                    loading({id: 'personalCalendarGrid'}, 0);
                }
            });
        });
        $(document).contextmenu({
            delegate: ".hasmenu",
            preventContextMenuForPopup: true,
            preventSelect: true,
            menu: [
                {title: "Cut", cmd: "cut", uiIcon: "ui-icon-scissors"},
                {title: "Copy", cmd: "copy", uiIcon: "ui-icon-copy"},
                {title: "Paste", cmd: "paste", uiIcon: "ui-icon-clipboard", disabled: true},
            ],
            select: function (event, ui) {
                // Logic for handing the selected option
            },
            beforeOpen: function (event, ui) {
                // Things to happen right before the menu pops up
            }
        });
        now = new Date();
        nowArr = now.toISOString().split('T');
        function add(e) {
            if (addMenuDialog != '') {
                addMenuDialog.close();
            }
            addMenuDialog = $.jsPanel({
                position: {
                    my: 'center-bottom',
                    at: 'center-top',
                    of: e.target,
                    offsetY: -2
                },
                dragit: false,
                resizeit: false,
                headerRemove: true,
                autoclose: 400000,
                border: '1px solid gray',
                contentSize: '150 120',
                content: '' +
                '<div id="modal_fullcalendar_menu" class="list-group">' +
                '   <div style="margin-bottom: 4px;">' +
                '		<a href="#" class="list-group-item line-height-30 height-30" onclick="showMultiTaskingModal()">'+
                '           <i  class="fa fa-tasks "></i>{{trans('calendar.modal_fullcalendar_menu_defined_task')}}'+
                '       </a>' +
                '   </div>' +
                '   <div style="border-bottom:1px solid #aaa;">' +
                '       <a href="#" class="list-group-item line-height-30 height-30" onclick="showTaskModal()" > ' +
                '           <i  class="fa fa-tasks "></i>{{trans('calendar.modal_fullcalendar_menu_new_task')}}'+
                '       </a>' +
                '   </div>' +
                {{--'   <div style="border-bottom:1px solid #aaa">' +--}}
                {{--'       <a href="#" class="list-group-item" onclick="showReminderModal();">' +--}}
                {{--'           <i  class="fa fa fa-calendar "></i>{{trans('calendar.modal_calendar_new_time_border')}}'+--}}
                {{--'       </a>' +--}}
                {{--'   </div>' +--}}
                {{--'   <div>' +--}}
                {{--'       <a href="#" class="list-group-item" onclick="showEvenModal()" > ' +--}}
                {{--'           {{trans('calendar.modal_fullcalendar_menu_save_event')}}'+--}}
                {{--'       </a>' +--}}
                {{--'   </div>' +--}}
                '   <div style="margin-bottom: 4px;">' +
                '       <a href="#" class="list-group-item line-height-30 height-30" onclick="showSessionModal();">' +
                '           <i  class="fa fa fa-envelope "></i>{{trans('calendar.modal_fullcalendar_menu_save_session')}}'+
                '       </a>' +
                '   </div>' +
                {{--'   <div>' +--}}
                {{--'       <a href="#" class="list-group-item" onclick="showInvitationModal();">' +--}}
                {{--'           {{trans('calendar.modal_fullcalendar_menu_save_invitation')}}'+--}}
                {{--'       </a>' +--}}
                {{--'   </div>' +--}}
                '   <div style="margin-bottom: 4px;">' +
                '       <a href="#" class="list-group-item line-height-30 height-30" onclick="showReminderModal();">' +
                '           <i  class="fa fa fa-bell "></i>{{trans('calendar.modal_fullcalendar_menu_save_reminder')}}'+
                '       </a>' +
                '   </div>' +
                '   <div style="margin-bottom: 4px;">' +
                '       <a class="list-group-item line-height-30 height-30" >' +
                '           <i  class="fa fa fa-check "></i>{{trans('calendar.modal_fullcalendar_menu_presence')}}'+
                '       </a>' +
                '   </div>' +
                '   <div style="margin-bottom: 4px;">' +
                '       <a class="list-group-item line-height-30 height-30" >' +
                '           <i  class="fa fa fa-address-card "></i>{{trans('calendar.modal_fullcalendar_menu_memo')}}'+
                '       </a>' +
                '   </div>' +
                '   <input type="hidden" name="startdate" value="" >' +
                '   <input type="hidden" name="enddate" value="" >' +
                '   <input type="hidden" name="starttime" value="" >' +
                '   <input type="hidden" name="endtime" value="" >' +
                ' </div>'
            });
            $('.ui-resizable-handle').hide();
        }
        var $modal = $('#modal_fullcalendar_menu').modal('hide');
        (function ($) {
            $('#calendar').fullCalendar();
            $('#calendar').fullCalendar('destroy');
            var cid = $('.calendar-main-setting input[name="lastSelectdCalendar"]').val();
            globalCalendar = $('#calendar').fullCalendar({
                lang: 'fa',
                isJalaali: true,
                isRTL: true,
                defaultDate: nowArr[0],
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                droppable: false, // this allows things to be dropped onto the calendar
                drop: function() {
                    // is the "remove after drop" checkbox checked?
                    alert('adasdasd');
                },
                selectable: true,
                selectHelper: true,
                select: function (start, end, jsEvent, view) {
                    // console.log(start);
                    //console.log(end);
                    var pStart = moment(start._d).format('jYYYY/jMM/jDD HH:mm:ss');
                    var pEnd = moment(end._d).format('jYYYY/jMM/jDD HH:mm:ss');
                    pStart = pStart.split(' ');
                    pstarttime = pStart[1];
                    pstarttime = pstarttime.split(":");
                    for (var i = 0; i < pstarttime.length; i++) {
                        pstarttime[i] = persianToEngilshDigit(pstarttime[i])
                    }
                    realPstarttime = (parseInt(pstarttime[0]) * 60 * 60 + parseInt(pstarttime[1]) * 60 + parseInt(pstarttime[2])) - 12600 - 3600;
                    realPstarttime = secondToTime(realPstarttime);
                    pEnd = pEnd.split(' ');
                    pendtime = pEnd[1];
                    pendtime = pendtime.split(":");
                    for (var i = 0; i < pendtime.length; i++) {
                        pendtime[i] = persianToEngilshDigit(pendtime[i])
                    }
                    realPendttime = (parseInt(pendtime[0]) * 60 * 60 + parseInt(pendtime[1]) * 60 + parseInt(pendtime[2])) - 12600 - 3600;
                    realPendtime = secondToTime(realPendttime);
                    //$('#modal_start_date').text(pStart[0]);
                    // $('#modal_end_date').text(pEnd[0]);
                    // $('#modal_start_time').text(realPstarttime);
                    //$('#modal_end_time').text(realPendtime);
                    //  var  htm='<div id="menu" style="z-index:999999;width: 300px;height: 300px;">fffffffffffffff</div>';
                    // $("#modal_fullcalendar_menu").dialog({ modal: true });
                    //  $('#modal_fullcalendar_menu').modal();
                    /// $('#modal_fullcalendar_menu').modal("toggle");
                    //$modal.modal('show');
                    add(event);
                    //$('#calendar').contextmenu(function (e) {
                    //   e.preventDefault();
                    $('#modal_fullcalendar_menu input[name="startdate"]').val(pStart[0]);
                    $('#modal_fullcalendar_menu input[name="enddate"]').val(pEnd[0]);
                    $('#modal_fullcalendar_menu input[name="starttime"]').val(realPstarttime);
                    $('#modal_fullcalendar_menu input[name="endtime"]').val(realPendtime);
                    $("#calendar").fullCalendar("unselect");
                },
                events: function (start, end, timezone, callback) {
                    loading({id: 'calendar'}, 1);
                    //AjaxLoading('calendar',1);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{route('hamahang.calendar_events.get_calendar_events')}}',
                        type: 'POST',
                        dataType: 'json',
                        success: function (response) {
                            res = response;
                            //console.log(response);
                            loading({id: 'calendar'}, 0);
                            var eventIndex = 0;
                            var events = new Array();
                            var sharing_options = JSON.parse(res.sharing_options);
                            var defaultoptions = JSON.parse(res.defaultoptions);
                            if (res.events.length) {
                                for (var i = 0; i < res.events.length; i++) {
                                    events[eventIndex] = {
                                        className: 'event defautEvent',
                                        title: res.events[i].title,
                                        start: res.events[i].start,
                                        end: res.events[i].end,
                                        allDay: res.events[i].allDay
                                    };
                                    eventIndex++;
                                }
                            }
                            if (res.historical_events.length) {
                                for (var i = 0; i < res.historical_events.length; i++) {
                                    switch (res.historical_events[i].type) {
                                        case 'PersianCalendar': {
                                            var color = defaultoptions['jalali'].color;
                                            break;
                                        }
                                        case 'GregorianCalendar': {
                                            var color = defaultoptions['gergorian'].color;
                                            break;
                                        }
                                        case 'ObservedHijriCalendar': {
                                            var color = defaultoptions['ghamari'].color;
                                            break;
                                        }
                                    }
                                    // console.log(color);
                                    events[eventIndex] = {
                                        className: 'event event_historical',
                                        title: res.historical_events[i].title,
                                        start: res.historical_events[i].start,
                                        end: res.historical_events[i].end,
                                        allDay: res.historical_events[i].allDay,
                                        color: color
                                    };
                                    eventIndex++;
                                }
                            }
                            //console.log(defaultoptions.vacation.color);
                            if (res.vacation_events.length) {
                                for (var i = 0; i < res.vacation_events.length; i++) {
                                    // console.log(res.historical_events[i]);
                                    events[eventIndex] = {
                                        className: 'event event_vacation',
                                        title: res.vacation_events[i].title,
                                        start: res.vacation_events[i].start,
                                        end: res.vacation_events[i].end,
                                        allDay: res.vacation_events[i].allDay,
                                        color: defaultoptions.vacation.color
                                    };
                                    eventIndex++;
                                }
                            }
                            if (res.type_events.length) {
                                for (var i = 0; i < res.type_events.length; i++) {
                                    switch (res.type_events[i].type) {
                                        case 0: {
                                            var classes = 'event even_event';
                                            var color = defaultoptions.event.color;
                                            break;
                                        }
                                        case 1: {
                                            var classes = 'event even_session';
                                            var color = defaultoptions.session.color;
                                            break;
                                        }
                                        case 2: {
                                            var classes = 'event even_invitation';
                                            var color = defaultoptions.invitation.color;
                                            break;
                                        }
                                        case 3: {
                                            var classes = 'event even_reminder';
                                            var color = defaultoptions.reminder.color;
                                            break;
                                        }
                                    }
                                    events[eventIndex] = {
                                        className: classes,
                                        title: res.type_events[i].title,
                                        start: res.type_events[i].startdate,
                                        end: res.type_events[i].enddate,
                                        allDay: res.type_events[i].allDay,
                                        color: color
                                    };
                                    eventIndex++;
                                }
                            }
                            if (res.sharing_events.length) {
                                for (var i = 0; i < res.sharing_events.length; i++) {
                                    if (res.sharing_events[i].color != null) {

                                        var color = res.sharing_events[i].color;
                                    }
                                    else if (sharing_options != null && (typeof sharing_options[res.sharing_events[i].sharId] !== 'undefined' || sharing_options[res.sharing_events[i].sharId] != null)) {
                                        var color = sharing_options[res.sharing_events[i].sharId].color;
                                    }
                                    else {
                                        var color = '#1e893a';
                                    }
                                    allday = res.sharing_events[i].allDay == "1" ? 1 : null
                                    events[eventIndex] = {
                                        className: 'event  share_event share_event_' + res.sharing_events[i].sharId,
                                        title: res.sharing_events[i].title,
                                        start: res.sharing_events[i].startdate,
                                        end: res.sharing_events[i].enddate,
                                        allDay: allday,
                                        color: color
                                    };
                                    eventIndex++;
                                }
                            }
                            //showEvent(res.calendarInfo.id);
                            callback(events);
                        },
                        error: function (e) {
                            // console.log(e.responseText);
                        }
                    });
                }
            });
        })(jQuery_2);
        $('.fc-right .fc-button-group').prepend(
            {{--'<button type="button" class="fc-year-button fc-button fc-state-default fc-corner-left ">{{trans("calendar.calendar_year_button_title")}}  </button>' +--}}
{{--            '<button type="button" class="fc-6month-button fc-button fc-state-default " >{{trans("calendar.calendar_sixmonth_button_title")}} </button>' +--}}
            {{--'<button type="button" class="fc-seasonDay-button fc-button fc-state-default  ">{{trans("calendar.calendar_sesoan_button_title")}} </button>'+--}}
            {{--'<button type="button" class="fc-button fc-state-default calendar-time-task " id="calendar_time_task">{{trans("calendar.calendar_month_row_button_title")}} </button>'--}}
        );
        $('.fc-right').css('float','left');
        $('.fc-left').css('float','right');
        $('.fc-right').css('margin-left','20px');
        $('h2').css('border: ','20px');



        $('#calendar_time_task').click(function () {
            // alert('set_time_task set_time_taskddddddddd set_time_taskddddddddd');
            loading({id: 'calendar'}, 1);
            $('.fc-right .fc-button-group button').removeClass('fc-state-active');
            $(this).addClass('fc-state-active');
            $('.fc-view').html('<div class ="season-view col-md-12">' + '</div>');
            var selected = 0;
            if ($('input[name="selectedSeason"]').length != 0) {
                selected = $('input[name="selectedSeason"]').val();
            }
            if ($('input[name="selectedSeason"]').length != 0) {
                selected = $('input[name="selectedSeason"]').val();
            }
            //console.log(selected);
            var currentDate = persianDate(new Date());
            if (selected == 0 || selected == 'undefined' || typeof selected == 'undefined') {
                if (currentDate.pDate.month >= 10) {
                    selected = 4;
                } else if (currentDate.pDate.month >= 7) {
                    selected = 3;
                } else if (currentDate.pDate.month >= 4) {
                    selected = 2;
                } else {
                    selected = 1;
                }
            }
            //   console.log(selected);
            //alert(currentDate.pDate.month);
            if (selected == 4) {
                var season = new Array(10, 11, 12);
                var seansonPersian = '{{trans("calendar.calendar_season_button_clicked_winter")}}';

            } else if (selected == 3) {
                var season = new Array(7, 8, 9);
                var seansonPersian = '{{trans("calendar.calendar_season_button_clicked_fall")}}';
            } else if (selected == 2) {
                var season = new Array(4, 5, 6);
                var seansonPersian = '{{trans("calendar.calendar_season_button_clicked_summer")}}';
            } else {
                var season = new Array(1, 2, 3);
                var seansonPersian = '{{trans("calendar.calendar_season_button_clicked_spring")}}';
            }
            a = persianDate([currentDate.pDate.year, currentDate.pDate.month]);
            var title_html =
                '<h2 id="sesasonTitle">' + a.format('MMMM') + ' ' + currentDate.pDate.year + '</h2>' +
                '<input type="hidden" name="selectedSeason" value="' + selected + '"/>' +
                '<input type="hidden" name="selectedSeasonYear" value="' + selected + '"/>';
            $('.fc-center').html(title_html);
            var btn = '' +
                '<button type="button" class=" fc_next_season_btn fc-next-button fc-button fc-state-default fc-corner-right" onclick="nextSeason(' + selected + ');"><span class="fc-icon fc-icon-left-single-arrow"></span></button>' +
                '<button type="button" class="fc-prev-button fc-pre-season fc-button fc-state-default fc-corner-left" onclick="preSeason(' + selected + ');"><span class="fc-icon fc-icon-right-single-arrow"></span></button>';
            $('.fc-left').html(btn);
            var html = '<table class="col-md-12 table" style="direction: rtl">';
            html += '<thead class="fc-head"><th></th> ';
            for (var i = 1; i < 12; i++) {
                html += '<th class="col-md-3 fc-widget-header" style="padding: 7px 0px;">' + (2*i+1) + '-' + (2*i+2) + '</th>'
            }
            html += '</thead>';
            html += '<tbody lass="fc-body">';
            for (j = 1; j <= 31; j++) {
                html += '<tr>';
                html += '<td>' + j + '</td>';
                for (var i = 0; i < 12; i++) {
                    html += '<td data-id="' + season[0] + '_' + j + '_' + i + '" ></td>';
                }
                html += '</tr>';
            }
            html += '</tbody>';
            html += '</table><div class="clearfixed"></div>';
            var cid = $('.calendar-main-setting input[name="lastSelectdCalendar"]').val();
            $('.season-view').html(html);
            var obj = {};
            obj.cid = cid;
            obj.selected = selected;
            $.ajax({
                url: '{{ URL::route('hamahang.calendar.get_seanson_events')}}',
                type: 'post', // Send post dat
                async: false,
                data: obj,
                success: function (s) {
                    res = JSON.parse(s);
                    seasonEvents = res;
                    //console.log(seasonEvents);
                    loading({id: 'calendar'}, 0);
                    for (month in res) {
                        for (d in res[month]) {
                            //console.log(month+'_'+d);
                            // $('td[data-id="'++'"]');
                            // for( event in res[month][d])
                            //{
                            if (res[month][d].length > 0) {
                                var html = '';
                                html += '<div class="event-view-content">';
                                if (res[month][d].length > 3) {
                                    html += '<a >';
                                    '<div class=""  style="background-color:' + res[month][d][0].color + '" evenId="' + res[month][d][0].id + '"><span class="fc-title">' + res[month][d][0].title + '</span></div></a>';
                                    html += '<a style="margin: 2px;" class="">';
                                    html += '<div class="" style="background-color:' + res[month][d][1].color + '" evenId="' + res[month][d][1].id + '"><span class="fc-title">' + res[month][d][1].title + '</span></div></a>';
                                    html += '<a  class="">';
                                    html += '<div class="" style="background-color:' + res[month][d][2].color + '" evenId="' + res[month][d][2].id + '"><span    class="fc-title">' + res[month][d][2].title + '</span></div></a>';
                                    html += '<div evenId="all"><a href="#" onclick="seaonToDay(' + month + ',' + d + ')">{{trans("calendar.calendar_season_button_clicked_more")}}</a></div>';
                                } else {
                                    for (var i = 0; i < res[month][d].length; i++) {
                                        //console.log(res[month][d][i]['color']);
                                        html += '<a class="">';
                                        html += '<div class="" style="background-color:' + res[month][d][i].color + '"  evenId="' + res[month][d][i].id + '"><span class="fc-title">' + res[month][d][i].title + '</span></div></a>';
                                    }
                                }
                                html += '</div>';
                                // console.log($('td[data-id="' + month + '_' + d + '"]'));
                                $('td[data-id="' + month + '_' + d + '"]').html(html);
                            }
                            //}
                        }
                    }
                }
            });
        });
        $('.fc-seasonDay-button').click(function () {
            loading({id: 'calendar'}, 1);
            $('.fc-right .fc-button-group button').removeClass('fc-state-active');
            $(this).addClass('fc-state-active');
            $('.fc-view').html('<div class ="season-view col-md-12">' + '</div>');
            var selected = 0;
            if ($('input[name="selectedSeason"]').length != 0) {
                selected = $('input[name="selectedSeason"]').val();
            }
            if ($('input[name="selectedSeason"]').length != 0) {
                selected = $('input[name="selectedSeason"]').val();
            }
            //console.log(selected);
            var currentDate = persianDate(new Date());
            if (selected == 0 || selected == 'undefined' || typeof selected == 'undefined') {
                if (currentDate.pDate.month >= 10) {
                    selected = 4;
                } else if (currentDate.pDate.month >= 7) {
                    selected = 3;
                } else if (currentDate.pDate.month >= 4) {
                    selected = 2;
                } else {
                    selected = 1;
                }
            }
            //   console.log(selected);
            //alert(currentDate.pDate.month);
            if (selected == 4) {
                var season = new Array(10, 11, 12);
                var seansonPersian = '{{trans("calendar.calendar_season_button_clicked_winter")}}';

            } else if (selected == 3) {
                var season = new Array(7, 8, 9);
                var seansonPersian = '{{trans("calendar.calendar_season_button_clicked_fall")}}';
            } else if (selected == 2) {
                var season = new Array(4, 5, 6);
                var seansonPersian = '{{trans("calendar.calendar_season_button_clicked_summer")}}';
            } else {
                var season = new Array(1, 2, 3);
                var seansonPersian = '{{trans("calendar.calendar_season_button_clicked_spring")}}';
            }
            var title_html =
                '<h2 id="sesasonTitle">' + seansonPersian + ' ' + currentDate.pDate.year + '</h2>' +
                '<input type="hidden" name="selectedSeason" value="' + selected + '"/>' +
                '<input type="hidden" name="selectedSeasonYear" value="' + selected + '"/>';
            $('.fc-center').html(title_html);
            var btn = '' +
                '<button type="button" class=" fc_next_season_btn fc-next-button fc-button fc-state-default fc-corner-right" onclick="nextSeason(' + selected + ');"><span class="fc-icon fc-icon-left-single-arrow"></span></button>' +
                '<button type="button" class="fc-prev-button fc-pre-season fc-button fc-state-default fc-corner-left" onclick="preSeason(' + selected + ');"><span class="fc-icon fc-icon-right-single-arrow"></span></button>';
            $('.fc-left').html(btn);
            var html = '<table class="col-md-12 table" style="direction: rtl">';
            html += '<thead class="fc-head"><th style="width:2%;"></th> ';
            for (var i = 0; i < 3; i++) {
                a = persianDate([currentDate.pDate.year, season[i]]);
                html += '<th class="col-md-3 fc-widget-header">' + a.format('MMMM') + '</th>'
            }
            html += '</thead>';
            html += '<tbody lass="fc-body">';
            for (j = 1; j <= 31; j++) {
                html += '<tr>';
                html += '<td >' + j + '</td>';
                html += '<td data-id="' + season[0] + '_' + j + '" ></td>';
                html += '<td data-id="' + season[1] + '_' + j + '"></td>';
                html += '<td  data-id="' + season[2] + '_' + j + '"></td>';
                html += '</tr>';
            }
            html += '</tbody>';
            html += '</table><div class="clearfixed"></div>';
            var cid = $('.calendar-main-setting input[name="lastSelectdCalendar"]').val();
            $('.season-view').html(html);
            var obj = {};
            obj.cid = cid;
            obj.selected = selected;
            $.ajax({
                url: '{{ URL::route('hamahang.calendar.get_seanson_events')}}',
                type: 'post', // Send post dat
                async: false,
                data: obj,
                success: function (s) {
                    res = JSON.parse(s);
                    seasonEvents = res;
                    //console.log(seasonEvents);
                    loading({id: 'calendar'}, 0);
                    for (month in res) {
                        for (d in res[month]) {
                            //console.log(month+'_'+d);
                            // $('td[data-id="'++'"]');
                            // for( event in res[month][d])
                            //{
                            if (res[month][d].length > 0) {
                                var html = '';
                                html += '<div class="event-view-content">';
                                if (res[month][d].length > 3) {
                                    html += '<a >';
                                    '<div class=""  style="background-color:' + res[month][d][0].color + '" evenId="' + res[month][d][0].id + '"><span class="fc-title">' + res[month][d][0].title + '</span></div></a>';
                                    html += '<a style="margin: 2px;" class="">';
                                    html += '<div class="" style="background-color:' + res[month][d][1].color + '" evenId="' + res[month][d][1].id + '"><span class="fc-title">' + res[month][d][1].title + '</span></div></a>';
                                    html += '<a  class="">';
                                    html += '<div class="" style="background-color:' + res[month][d][2].color + '" evenId="' + res[month][d][2].id + '"><span    class="fc-title">' + res[month][d][2].title + '</span></div></a>';
                                    html += '<div evenId="all"><a href="#" onclick="seaonToDay(' + month + ',' + d + ')">{{trans("calendar.calendar_season_button_clicked_more")}}</a></div>';
                                } else {
                                    for (var i = 0; i < res[month][d].length; i++) {
                                        //console.log(res[month][d][i]['color']);
                                        html += '<a class="">';
                                        html += '<div class="" style="background-color:' + res[month][d][i].color + '"  evenId="' + res[month][d][i].id + '"><span class="fc-title">' + res[month][d][i].title + '</span></div></a>';
                                    }
                                }
                                html += '</div>';
                                // console.log($('td[data-id="' + month + '_' + d + '"]'));
                                $('td[data-id="' + month + '_' + d + '"]').html(html);
                            }
                            //}
                        }
                    }
                }
            });
        });
        $('.fc-6month-button').click(function () {
            loading({id: 'calendar'}, 1);
            $('.fc-right .fc-button-group button').removeClass('fc-state-active');
            $(this).addClass('fc-state-active');
            $('.fc-view').html('<div class="row-fluid">' +
                '<div class ="6month-view col-xs-12">' +
                '</div></div><div class="clearfixed"></div>');
            /*$('.fc-view').re*/
            var currentDate = persianDate(new Date());
            html = '';
            var selected = 0;
            var firstDisabled = '';
            var secondDisabled = '';
            if ($('input[name="selectedSixMonth"]').length != 0) {
                selected = $('input[name="selectedSixMonth"]').val();
            }
            if (selected == 0 || selected == 'undefined' || typeof selected == 'undefined') {
                if (currentDate.pDate.month < 6) {
                    selected = 1;
                    secondDisabled = ' disabled ';
                } else {
                    selected = 2
                    firstDisabled = ' disabled ';
                }
            }
            if (selected == 1) {
                var str = '{{trans("calendar.calendar_6month_button_clicked_first_half_of_year")}}';
            }
            else {
                var str = '{{trans("calendar.calendar_6month_button_clicked_second_half_of_year")}}';
            }
            var title_html =
                '<h2 id="sesasonTitle">' + str + ' ' + currentDate.pDate.year + '</h2>' +
                '<input type="hidden" name="selectedSixMonth" value="' + selected + '"/>' +
                $('.fc-center').html(title_html);
            var btn = '<button type="button"  class=" fc_next_sixmonth_btn fc-next-button btn btn-default ' + firstDisabled + '" onclick="preSixMonth(' + selected + ');"><span class="fc-icon fc-icon-left-single-arrow"></span></button>' +
                '<button type="button"  class="fc-prev-button fc-pre-sixmonth  btn btn-default' + secondDisabled + '" onclick="nextSixMonth(' + selected + ');"><span class="fc-icon fc-icon-right-single-arrow"></span></button>';
            $('.fc-left').html(btn);
            html += '<div class="col-xs-5" ><div class="row-fluid"><div class="col-xs-12" id="1-6month-view"></div></div></div>';
            html += '<div class="col-xs-5" ><div class="row-fluid"><div class="col-xs-12" id="2-6month-view"></div></div></div>';
            html += '<div class="col-xs-5" ><div class="row-fluid"><div class="col-xs-12" id="3-6month-view"></div></div></div>';
            // html +='</tr>';
            html += '<div class="col-xs-5" ><div class="row-fluid"><div class="col-xs-12" id="4-6month-view"></div></div></div>';
            html += '<div class="col-xs-5" ><div class="row-fluid"><div class="col-xs-12" id="5-6month-view"></div></div></div>';
            html += '<div class="col-xs-5" ><div class="row-fluid"><div class="col-xs-12" id="6-6month-view"></div></div></div>';
            $('.6month-view').prepend(html);
            //$('.6month-view').html(html);
            for (var i = 1; i <= 6; i++) {
                $('#' + i + '-6month-view').persianDatepicker({
                    timePicker: {
                        enabled: true
                    },
                    monthPicker: {
                        scrollEnabled: false
                    },
                    dayPicker: {
                        scrollEnabled: false,
                        onSelect: function (uninTime) {
                            $('.fc-center .fc-pre-sixmonth').remove();
                            $('.fc-center .fc_next_sixmonth_btn').remove();
                            $('.fc-right .fc-6month-button').removeClass('fc-state-active');
                            d = persianDate(uninTime);
                            formatPersian = false;
                            // console.log(d.format("YYYY/MM/DD"));
                            var pDateAr = d.format("YYYY/MM/DD").split('/');
                            var gDate = moment(d.format("YYYY/MM/DD").toString(), 'jYYYY/jM/jD').format('YYYY-M-D ');
                            gDateAr = gDate.split('-')
                            for (var i = 0; i < gDateAr.length; i++) {
                                gDateAr[i] = persianToEngilshDigit(gDateAr[i])

                            }
                            //   console.log(pDateAr);
                            // console.log(sixMonthEvents[pDateAr[1]][pDateAr[2]]);
                            // console.log(gDateAr);
                            (function ($) {
                                $('#calendar').fullCalendar('changeView', 'agendaDay');
                                $('#calendar').fullCalendar('gotoDate', gDateAr.join('-'));
                                //$("#calendar").fullCalendar('removeEvents');
                                // $("#calendar").fullCalendar('addEventSource', sixMonthEvents[parseInt(pDateAr[1])][parseInt(pDateAr[2])]);
                            })(jQuery_2);
                        }
                    }
                });
            }
            if (currentDate.pDate.month < 6) {
                for (var i = 1; i <= 6; i++) {
                    $('#' + i + '-6month-view').pDatepicker("setDate", [currentDate.pDate.year, i, 1, 11, 14]);
                    $('#' + i + '-6month-view table tbody tr td').each(function () {
                        if ($(this).find('span').attr('class') != "other-month") {
                            var d = $(this).find('span').text();
                            $(this).attr('data-id', i + '_' + persianToEnDigit[d]);
                        }
                    });
                    var txt = $('#' + i + '-6month-view .btn-switch').text()
                    $('#' + i + '-6month-view .datepicker-header').html('<div class="btn-switch" style="width:100%">' + txt + '</div>');
                }
            } else {
                var j = 6;
                for (var i = 1; i <= 6; i++) {
                    j++;
                    $('#' + i + '-6month-view').pDatepicker("setDate", [currentDate.pDate.year, j, 1, 11, 14]);
                    $('#' + i + '-6month-view table tbody tr td').each(function () {
                        if ($(this).find('span').attr('class') != "other-month") {
                            $(this).find('span').css('display', '');
                            var d = $(this).find('span').text();
                            $(this).attr('data-id', j + '_' + persianToEngilshDigit(d));
                        }
                    });
                    var txt = $('#' + i + '-6month-view .btn-switch').text();
                    $('#' + i + '-6month-view .datepicker-header').html('<div class="btn-switch" style="width:100%">' + txt + '</div>');
                }
            }
            $('.6month-view .datepicker-time-view').hide();
            //$( '.6month-view .btn-next').html('');
            // $( '.6month-view .btn-prev').html('');
            //$( '.6month-view .navigator').removeClass('btn-switch');
            $('table.table-days span.selected ').removeClass('selected');
            $('table.table-days span.today ').removeClass('today');
            $('.6month-view .toolbox').hide();
            var cid = $('.calendar-main-setting input[name="lastSelectdCalendar"]').val();
            var obj = {};
            obj.cid = cid;
            obj.selected = selected;
            $.ajax({
                url: '{{ URL::route('hamahang.calendar.six_month_events',['uname'=>$uname] )}}',
                type: 'post', // Send post dat
                async: false,
                data: obj,
                success: function (s) {
                    res = JSON.parse(s);
                    sixMonthEvents = res;
                    for (month in res) {
                        for (d in res[month]) {
                            if (res[month][d].length > 0) {
                                var tooTip = '';
                                tooTip += '<div  class=" tooltip_text">';
                                if (res[month][d].length > 3) {
                                    tooTip += res[month][d][0].title + '<br/>';
                                    tooTip += res[month][d][1].title + '<br/>';
                                    tooTip += res[month][d][2].title + '</br/>';
                                    tooTip += '{{trans("calendar.calendar_6month_button_clicked_more")}}';
                                } else {
                                    for (var i = 0; i < res[month][d].length; i++) {
                                        tooTip += res[month][d][i].title + '<br/>';
                                    }
                                }
                                tooTip += '</div >';
                                var html =
                                    tooTip + '<div class="circleDigit">' +
                                    '   <a class="calendarTooltip "  href="#">' +
                                    engilshToPersianDigit(res[month][d].length) +
                                    '   </a>' +
                                    '</div>';
                                //  $('td[data-id="' + month + '_' + d + '"]').append(month+'-'+d);
                                var getCid = ( month > 6 ) ? (month - 6) : month;
                                //console.log();
                                // if ($('#'+getCid+'-6month-view table tbody tr td[data-id="' + month + '_' + d + '"]').find('span').attr('class')!= "other-month") {
                                $('#' + getCid + '-6month-view table tbody tr td[data-id="' + month + '_' + d + '"]').addClass('tooltip_area').prepend(html);
                                // }
                            }
                        }
                    }
                    loading({id: 'calendar'}, 0);
                }
            });
        });
        $('.fc-year-button').click(function () {
            $('.fc-center').html('<h2>{{trans("calendar.calendar_year_button_clicked_title")}}</h2>');
            $('.fc-right .fc-button-group button').removeClass('fc-state-active');
            $(this).addClass('fc-state-active');
            $('.fc-view').html('<div class="row-fluid">' +
                '<div class ="year-view col-xs-12">' +
                '</div></div><div class="clearfixed"></div>');
            var currentDate = persianDate(new Date());
            loading({id: 'calendar'}, 1);
            var html = '';
            html += '<div class="col-xs-5" ><div class="row-fluid"><div class="col-xs-12" id="1-year-view"></div></div></div>';
            html += '<div class="col-xs-5" ><div class="row-fluid"><div class="col-xs-12" id="2-year-view"></div></div></div>';
            html += '<div class="col-xs-5" ><div class="row-fluid"><div class="col-xs-12" id="3-year-view"></div></div></div>';
            html += '<div class="col-xs-5" ><div class="row-fluid"><div class="col-xs-12" id="4-year-view"></div></div></div>';
            html += '<div class="col-xs-5" ><div class="row-fluid"><div class="col-xs-12" id="5-year-view"></div></div></div>';
            html += '<div class="col-xs-5" ><div class="row-fluid"><div class="col-xs-12" id="6-year-view"></div></div></div>';
            html += '<div class="col-xs-5" ><div class="row-fluid"><div class="col-xs-12" id="7-year-view"></div></div></div>';
            html += '<div class="col-xs-5" ><div class="row-fluid"><div class="col-xs-12" id="8-year-view"></div></div></div>';
            html += '<div class="col-xs-5" ><div class="row-fluid"><div class="col-xs-12" id="9-year-view"></div></div></div>';
            html += '<div class="col-xs-5" ><div class="row-fluid"><div class="col-xs-12" id="10-year-view"></div></div></div>';
            html += '<div class="col-xs-5" ><div class="row-fluid"><div class="col-xs-12" id="11-year-view"></div></div></div>';
            html += '<div class="col-xs-5" ><div class="row-fluid"><div class="col-xs-12" id="12-year-view"></div></div></div>';
            $('.year-view').html(html);
            for (var i = 1; i <= 12; i++) {
                $('#' + i + '-year-view').persianDatepicker({
                    timePicker: {
                        enabled: true
                    },
                    monthPicker: {
                        scrollEnabled: false
                    },
                    dayPicker: {
                        scrollEnabled: false,
                        onSelect: function (uninTime) {
                            $('.fc-right .fc-year-button').removeClass('fc-state-active');
                            d = persianDate(uninTime);
                            formatPersian = false;
                            // console.log(d.format("YYYY/MM/DD"));
                            var pDateAr = d.format("YYYY/MM/DD").split('/');
                            var gDate = moment(d.format("YYYY/MM/DD").toString(), 'jYYYY/jM/jD').format('YYYY-M-D ');
                            gDateAr = gDate.split('-');
                            for (var i = 0; i < gDateAr.length; i++) {
                                gDateAr[i] = persianToEngilshDigit(gDateAr[i])
                            }
                            //   console.log(pDateAr);
                            //   console.log(yearEvents);return;
                            // console.log(sixMonthEvents[gDateAr[1]][gDateAr[2]]);
                            (function ($) {
                                $('#calendar').fullCalendar('changeView', 'agendaDay');
                                $('#calendar').fullCalendar('gotoDate', gDateAr.join('-'));
                                $("#calendar").fullCalendar('removeEvents');
                                $("#calendar").fullCalendar('addEventSource', yearEvents[parseInt(pDateAr[1])][parseInt(pDateAr[2])]);
                            })(jQuery_2);
                        }
                    }
                });
            }
            for (var i = 1; i <= 12; i++) {
                $('#' + i + '-year-view').pDatepicker("setDate", [currentDate.pDate.year, i, 1, 11, 14]);
                $('#' + i + '-year-view table tbody tr td').each(function () {
                    if ($(this).find('span').attr("class") != "other-month") {
                        var d = $(this).find('span').text();
                        //console.log(d);
                        //console.log(d);
                        //console.log(persianToEnDigit[d]);
                        $(this).attr('data-id', i + '_' + persianToEngilshDigit(d));
                    }
                });
                var txt = $('#' + i + '-year-view .btn-switch').text()
                $('#' + i + '-year-view .datepicker-header').html('<div class="btn-switch" style="width:100%">' + txt + '</div>');
            }
            $('.year-view .datepicker-time-view').hide();
            // $( '.year-view .btn-next').html('');
            //$( '.year-view .btn-prev').html('');
            $('table.table-days span.selected ').removeClass('selected');
            $('table.table-days span.today ').removeClass('today');
            $('.year-view .toolbox').hide();
            var cid = $('.calendar-main-setting input[name="lastSelectdCalendar"]').val();
            var obj = {};
            obj.cid = cid;
            $.ajax({
                url: '{{ URL::route('hamahang.calendar.year_events',['uname'=>$uname] )}}',
                type: 'post', // Send post dat
                async: false,
                data: obj,
                success: function (s) {
                    res = JSON.parse(s);
                    loading({id: 'calendar'}, 0);
                    yearEvents = res;
                    for (month in res) {
                        for (d in res[month]) {
                            if (res[month][d].length > 0) {
                                var tooTip = '';
                                tooTip += '<div  class=" tooltip_text">';
                                if (res[month][d].length > 3) {
                                    tooTip += res[month][d][0].title + '<br/>';
                                    tooTip += res[month][d][1].title + '<br/>';
                                    tooTip += res[month][d][2].title + '</br/>';
                                    tooTip += '{{trans("calendar.calendar_year_button_clicked_more")}}';
                                } else {
                                    for (var i = 0; i < res[month][d].length; i++) {
                                        tooTip += res[month][d][i].title + '<br/>';
                                    }
                                }
                                tooTip += '</div >';
                                var html = tooTip + '<div class="circleDigit "><a class="calendarTooltip "  href="#">' +
                                    engilshToPersianDigit(res[month][d].length) + '</a></div>';
                                // $('td[data-id="'+month+'_'+d+'"]').append(html);
                                $('td[data-id="' + month + '_' + d + '"]').addClass('tooltip_area').prepend(html);
                            }
                        }
                    }
                }
            });
            /*$('.tooltip-show').tooltip('show');
             $('.tooltip-show').on('show.bs.tooltip', function () {
             alert("Alert message on show");
             })
             */
        });
        //$('.fc-right button:nth-child(4)').removeClass('fc-corner-left');
        $('.fc-right button').click(function () {
            if ($(this).hasClass('fc-agendaDay-button') || $(this).hasClass('fc-month-button') || $(this).hasClass('fc-agendaWeek-button') || $(this).hasClass('fc-agendaWeek-button')) {
                $('.fc-right .fc-year-button').removeClass('fc-state-active');
                $('.fc-right .fc-6month-button').removeClass('fc-state-active');
                $('.fc-right .fc-seasonDay-button').removeClass('fc-state-active');
                $('.fc-left').css('visibility', '');
            }
            else {
                //$('.fc-left').css('visibility','hidden');
                //  $('.fc-left').css('visibility','hidden');
            }
        });
        $('.fc-right button').click(function () {
            if ($(this).hasClass('fc-year-button')) {
                $('.fc-left').css('visibility', 'hidden');
            } else {
                $('.fc-left').css('visibility', '');
            }
            //  $('.fc-left').css('visibility','hidden');
        });
        $.ajax({
            url: '{{ URL::route('ugc.desktop.hamahang.calendar.user_calendar',['uname'=>$uname] )}}',
            type: 'GET', // Send post dat
            async: false,
            success: function (s) {
                s = JSON.parse(s);
                var options = '';
                $('select[name="cid"]').empty();
                for (var i = 0; i < s.length; i++) {
                    if (s[i].is_default == 1) {
                        options += '<option  selected=true value="' + s[i].id + '">' + s[i].title + '</option>';
                    }
                    else {
                        options += '<option value="' + s[i].id + '">' + s[i].title + '</option>';
                    }
                }
                $('select[name="cid"]').append(options);
                $('select[name="cid"]').select2({
                    dir: "rtl",
                    width: '100%'
                });
            }
        });
        $("select[name='session_voting_users[]']").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.users')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
        $("select[name='session_notvoting_users[]']").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.users')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
        $("select[name='session_chief']").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.users')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
        $("select[name='session_secretary']").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.users')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
        $("select[name='session_facilitator']").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.users')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------save task ( in user evemnt modal)---------------------------------------*/
        /*----------------------------------------------------------------------------------------*/
        function save_time_task(form_id, again,action) {
            //console.log(form_id);
            $('#task_form_action').val(action);
            var form_data = $('#' + form_id).serialize();
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.tasks.save_task')}}',
                dataType: "json",
                data: form_data,
                success: function (result) {

                    newEventModal.close();

                    // result = JSON.parse(result);
                    if (result.success == true) {
                        if (again == 1) {
                            ResetForm();
                        }
                        else {
                            $('.jsPanel-btn-close').click();
                        }
                        enddate = result.enddate;
                        endtime = result.endtime;
                        startdate = result.startdate;
                        starttime = result.starttime;
                        task_id = result.task_id;
                        title = result.title;
                        {{--messageModal('success','{{trans('tasks.create_new_task')}}' , {0:'{{trans('app.operation_is_success')}}'});--}}
                        showTimeAndTask(title,startdate,enddate,starttime,endtime,task_id);

                    }
                    else {
                        messageModal('error', '{{trans('app.operation_is_failed')}}', result.error);
                    }
                }
            });
        }
        function showTimeAndTask(title, startdate, enddate, starttime, endtime, task_id) {
            startdate = startdate.split("/");
            starttime = starttime.split("-");
            newEventModal = $.jsPanel({
                position: {my: "center-top", at: "center-top", offsetY: 15},
                contentSize: {width: 800, height: 300},
                contentAjax: {
                    url: '{{ URL::route('modals.task_time' )}}',
                    method: 'POST',
                    dataType: 'json',
                    done: function (data, textStatus, jqXHR, panel) {
                        this.headerTitle(data.header);
                        this.content.html(data.content);
                        this.toolbarAdd('footer', [{item: data.footer}]);

                        $('#form-multi-tasking input[name="startdate"]').val(startdate);
                        $('#form-multi-tasking input[name="enddate"]').val(enddate);
                        $('#form-multi-tasking input[name="starttime"]').val(starttime);
                        $('#form-multi-tasking input[name="endtime"]').val(endtime);
                        $('#form-multi-tasking #take_title').text("{{trans('calendar.modal_calendar_setting_title')}} : " + title);
                        $('#form-multi-tasking form').append('<input type="hidden" name="mode" value="calendar"/>');
                        $('#form-multi-tasking #title_time_task').val(title);
                        $('#form-multi-tasking #task_id').val(task_id);
                        $('#InsertBtn_task_time').attr('act','singleTask');
                    }
                }
            });

            newEventModal.content.html('<div class="loader"></div>');

        }

        $(document).on('click', '.save_time_task', function () {
            var save_type = $("input[name='new_task_save_type']:checked").val() != undefined ? $("input[name='new_task_save_type']:checked").val() :
                ($("input[name='show_task_save_type']:checked").val() != undefined ? $("input[name='show_task_save_type']:checked").val() :
                    ($("input[name='show_task_save_type_final']:checked").val() != undefined ? $("input[name='show_task_save_type_final']:checked").val() : '') );
            var $this = $(this);
            // alert('adasd');
            // return false;
            var form_id = $this.data('form_id');
            var save_again = $this.data('again_save');
            if (save_type == 1) {
                save_time_task(form_id, save_again,1);
            }
            else if (save_type == 0) {
                save_time_task(form_id, save_again,0);
                //save_as_draft(form_id, save_again);
            }
            else
            {
                if($("input[name='show_task_save_type_final']:checked").val()==1)
                    save_time_task(form_id, save_again,0);
                else
                    alert('{{ trans('tasks.the_save_type_is_not_selected') }}');
            }
        });
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------save event ( in user evemnt modal)---------------------------------------*/
        /*----------------------------------------------------------------------------------------*/
        $(document).on('click', '#saveEvent', function () {
            //console.log(saveObj);
            if ($('select[name="cid"]').length) {
                var res = saveEvent('form-event', 'errMSg');
            }
            // console.log(res);
            if (res.success == false) {
            } else {
                eventInfo = res.event;
                 console.log(eventInfo);
                (function ($) {
                    $("#calendar").fullCalendar('addEventSource', [{
                        start: eventInfo.startdate,
                        end: eventInfo.enddate,
                        title: eventInfo.title,
                        color: eventInfo.bgColor,
                        block: true,
                    },]);
                })(jQuery_2);
                newEventModal.close();
                //$('#add_event_dialog').modal('hide');
                var html = '{{trans("calendar.calendar_saveEvent_clicked_success_msg1")}}' + eventInfo.title + '{{trans("calendar.calendar_saved_success_msg2")}}';
                meessageModal('success', '{{trans("calendar.calendar_saveEvent_clicked_success_msg_header")}}', html);
            }
        });
        /*########################################################################################*/
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------sallDay cheked---------------------------------------*/
        /*----------------------------------------------------------------------------------------*/
        $('input[type="checkbox"][name="allDay"]').click(function () {
            //  console.log($('input[type="checkbox"][name="allDay"]').is(':checked'));
            if ($('input[type="checkbox"][name="allDay"]').is(':checked')) {
                $('input[name="starttime"]').val('');
                $('input[name="endtime"]').val('');
                $('input[name="starttime"]').prop('disabled', true);
                $('input[name="endtime"]').prop('disabled', true);
            }
            else {
                $('input[name="starttime"]').prop('disabled', false);
                $('input[name="endtime"]').prop('disabled', false);
            }
        });
        /*########################################################################################*/
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------save  event of session modal---------------------------------------*/
        /*----------------------------------------------------------------------------------------*/
        $(document).on('click', '.saveSessionUserEvents', function () {
            //alert('ffffffffffffffff');
            var do_again = $(this).attr('do_type');
            var saveObj = {};
            var cid = 0;
            var form_id = 'sessionForm';
            //console.log(document.forms[form_id].getElementsByTagName("cid"));
            // console.log('#' + form_id + ' select[name="cid"]');
            //console.log($('#' + form_id + ' select[name="cid"]').val());
            saveObj.htitle = $('#' + form_id + ' input[name="title"]').val();
            saveObj.event_type = $('#' + form_id + ' input[name="event_type"]').val();
            saveObj.session_pages = $('select[name="new_session_pages[]"]').select().val().toString();
            saveObj.description = $('#' + form_id + ' textarea[name="descriotion"]').val();
            saveObj.hstartdate = $('#' + form_id + ' input[name="startdate"]').val();
            saveObj.starttime = $('#' + form_id + ' input[name="starttime"]').val();
            saveObj.henddate = $('#' + form_id + ' input[name="enddate"]').val();
            saveObj.endtime = $('#' + form_id + ' input[name="endtime"]').val();
            saveObj.term = $('input[name="term"]').val();
            saveObj.hlocation = $('textarea[name="location"]').val();
            saveObj.hcid = $('#' + form_id + ' select[name="cid"]').val();


            ///////////////////////////////////////////////
            if ($('#' + form_id + ' input[type="checkbox"][name="allDay"]').is(':checked')) {
                saveObj.allDay = 1;
            }
            else {
                saveObj.allDay = 0;
            }

            if ($('#' + form_id + ' input[name="event_id"]').length && $('#' + form_id + ' input[name="event_id"]').val() > 0) {
                saveObj.mode = 'edit';
                saveObj.event_id = $('#' + form_id + ' input[name="event_id"]').val();
                saveObj.type = $('#' + form_id + ' input[name="type"]').val();
            }
            saveObj.mode = 'calendar';
            var errorMsg_id = 'sessionMsgBox';
            ///////////////////////////////////////////////
            // Session Data
            // sessionObj = {};
            saveObj.hagenda = $('#agenda').val();
            saveObj.session_chief = $('select[name="session_chief"]').select().val();
            saveObj.session_secretary = $('select[name="session_secretary"]').select().val();
            saveObj.session_facilitator = $('select[name="session_facilitator"]').select().val();
            saveObj.session_voting_users = $('select[name="new_session_save_type[]"]').select().val();
            saveObj.session_voting_users = $('select[name="session_voting_users[]"]').select().val().toString();
            saveObj.session_notvoting_users = $('select[name="session_notvoting_users[]"]').select().val().toString();
            saveObj.save_type = $('input[name="new_session_save_type"]:checked').val();
            saveObj.long = $('input[name="long"]').val();
            saveObj.lat = $('input[name="lat"]').val();
            saveObj.type = $('input[name="session_type"]:checked').val();
            saveObj.location_phone = $('input[name="location_phone"]').val();
            saveObj.coordination_phone = $('input[name="coordination_phone"]').val();
            // saveObj.hevent_id = result.event.id;
            saveObj.mode = 'calendar';
            if ($('input[name="mode"]').length) {
            }
            if ($('input[type="checkbox"][name="send_Invitation"]').is(':checked')) {
                saveObj.send_Invitation = 1;
            }
            else {
                saveObj.send_Invitation = 0;
            }
            if ($('input[type="checkbox"][name="create_session_page"]').is(':checked')) {
                saveObj.create_session_page = 1;
            }
            else {
                saveObj.create_session_page = 0;
            }
            if ($('input[type="checkbox"][name="allow_inform_invitees"]').is(':checked')) {
                saveObj.allow_inform_invitees = 1;
            }
            else {
                saveObj.allow_inform_invitees = 0;
            }
            // console.log(saveObj);

            var res = '';
            $.ajax({
                url: '{{ URL::route('hamahang.calendar_events.save_session_event')}}',
                type: 'POST', // Send post dat
                data: saveObj,
                async: false,
                success: function (s) {
                    res = JSON.parse(s);
                    if (res.success == false) {
                        $('#' + errorMsg_id).empty();
                        errorsFunc('{{trans('calendar_events.ce_error_label')}}', res.error, {id: errorMsg_id}, form_id);
                        // $('#' + errorMsg_id).html(warning);
                    } else {
                        console.log(res);
                        console.log(res.event);
                        // eventInfo = JSON.parse(res.event);
                        eventInfo = res.event;
                        (function ($) {
                            $("#calendar").fullCalendar('addEventSource', [{
                                start: eventInfo.startdate,
                                end: eventInfo.enddate,
                                title: eventInfo.title,
                                color: eventInfo.bgColor,
                                block: true
                            }]);
                        })(jQuery_2);
                        if(do_again=='close-form')
                        {
                            sessionModal.close();
                        }else{
                            $('.sessionForm input').val('');
                            var html = '{{trans("calendar.calendar_saveSession_clicked_success_msg1")}}' + eventInfo.title + '{{trans("calendar.calendar_saved_success_msg2")}}';
                            messageModal('success', '{{trans("calendar.calendar_saveSession_clicked_success_msg_header")}}', html);
                        }

                        var html = '{{trans("calendar.calendar_saveSession_clicked_success_msg1")}}' + eventInfo.title + '{{trans("calendar.calendar_saved_success_msg2")}}';
                        {{--messageModal('success', '{{trans("calendar.calendar_saveSession_clicked_success_msg_header")}}', html);--}}
                        {{--messageModal('success', '{{trans("calendar.calendar_saveSession_clicked_success_msg_header")}}', '{!! trans("calendar.calendar_saveSession_success") !!}');--}}
                    }
                }
            });
            // return res;
            //  console.log(result);return;
            // if (result.success == true) {
            /*
            by hadi
            var result = saveEvent('sessionForm', 'sessionMsgBox');
            var modal_btn = [
                {
                    item: '' +
                    '<div >' +
                    '   <button type="button" name="saveSession" id="saveSession" value="save" class="btn btn-info" type="button">' +
                    '       <i class="glyphicon  glyphicon-save-file bigger-125"></i>' +
                    '       <span>{trans('app.save')}}</span>' +
                    '   </button>' +
                    '</div>'
                }
            ];
            sessionModal.toolbarAdd("footer", modal_btn);
            $('#saveSessionUserEvent').remove();
            navigationWizard();
            $('#sessionMsgBox').html('');
            $('textarea[name="location"]').append('<input type="hidden" name="event_id" value="' + result.event.id + '">');
            $('textarea[name="location"]').append('<input type="hidden" name="mode" value="calendar">');
            $('#form-event-content').hide();
            $('#form-session-content').show();
            */
            // }
        });
        /*########################################################################################*/
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------save session value ---------------------------------------*/
        /*----------------------------------------------------------------------------------------*/
        $(document).on('click', '#saveSession', function () {
            sessionObj = {};
            sessionObj.hagenda = $('#agenda').val();
            sessionObj.session_chief = $('select[name="session_chief"]').select().val();
            sessionObj.session_secretary = $('select[name="session_secretary"]').select().val();
            sessionObj.session_facilitator = $('select[name="session_facilitator"]').select().val();
            sessionObj.session_voting_users = $('select[name="session_voting_users[]"]').select().val().toString();
            sessionObj.session_voting_users = $('select[name="session_voting_users[]"]').select().val().toString();
            sessionObj.session_notvoting_users = $('select[name="session_notvoting_users[]"]').select().val().toString();
            sessionObj.term = $('input[name="term"]').val();
            sessionObj.hlocation = $('textarea[name="location"]').val();
            sessionObj.long = $('input[name="long"]').val();
            sessionObj.lat = $('input[name="lat"]').val();
            sessionObj.type = $('input[name="session_type"]:checked').val();
            sessionObj.location_phone = $('input[name="location_phone"]').val();
            sessionObj.coordination_phone = $('input[name="coordination_phone"]').val();
            sessionObj.hevent_id = $('input[name="event_id"]').val();
            if ($('input[name="mode"]').length) {
                sessionObj.mode = $('input[name="mode"]').val();
            }
            if ($('input[type="checkbox"][name="send_Invitation"]').is(':checked')) {
                sessionObj.send_Invitation = 1;
            }
            else {
                sessionObj.send_Invitation = 0;
            }
            if ($('input[type="checkbox"][name="create_session_page"]').is(':checked')) {
                sessionObj.create_session_page = 1;
            }
            else {
                sessionObj.create_session_page = 0;
            }
            if ($('input[type="checkbox"][name="allow_inform_invitees"]').is(':checked')) {
                sessionObj.allow_inform_invitees = 1;
            }
            else {
                sessionObj.allow_inform_invitees = 0;
            }
            $.ajax({
                url: '{{ URL::route('hamahang.calendar_events.save_session_event')}}',
                type: 'POST', // Send post dat
                data: sessionObj,
                async: false,
                success: function (s) {
                    s = JSON.parse(s);
                    //console.log(s.error);
                    if (s.success == false) {
                        $('#sessionMsgBox').empty();
                        errorsFunc('{{trans("calendar_events.ce_error_label")}}', s.error, {id: 'sessionMsgBox'}, 'form-session-content');
                    } else {
                        eventInfo = JSON.parse(s.event);
                        // console.log(eventInfo);
                        // console.log(eventInfo.title);
                        (function ($) {
                            $("#calendar").fullCalendar('addEventSource', [{
                                start: eventInfo.startdate,
                                end: eventInfo.enddate,
                                title: eventInfo.title,
                                color: eventInfo.bgColor,
                                block: true
                            }]);
                        })(jQuery_2);
                        sessionModal.close();
                        var html = '{{trans("calendar.calendar_saveSession_clicked_success_msg1")}}' + eventInfo.title + '{{trans("calendar.calendar_saved_success_msg2")}}';
                        messageModal('succcess', '{{trans("calendar.calendar_saveSession_clicked_success_msg_header")}}', html);
                    }
                }
            });
        });
        /*########################################################################################*/
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------save user event invitatio ---------------------------------------*/
        /*----------------------------------------------------------------------------------------*/
        $(document).on('click', '#saveInvitationUserEvent', function () {
            var invitationObj = {};

            invitationObj.htitle = $('#invitation_form input[name="title"]').val();
            invitationObj.event_type = $('#' + form_id + ' input[name="event_type"]').val();
            invitationObj.hcid = $('#invitation_form select[name="cid"]').val();
            invitationObj.hstartdate = $('#invitation_form input[name="startdate"]').val();
            invitationObj.starttime = $('#invitation_form input[name="starttime"]').val();
            invitationObj.henddate = $('#invitation_form input[name="enddate"]').val();
            invitationObj.endtime = $('#invitation_form input[name="endtime"]').val();
            invitationObj.description = $('#invitation_form textarea[name="descriotion"]').val();
            if ($('#invitation_form input[type="checkbox"][name="allDay"]').is(':checked')) {
                invitationObj.allDay = 1;
            }
            else {
                invitationObj.allDay = 0;
            }
            if ($('#invitation_form input[name="event_id"]').length && $('#' + form_id + ' input[name="event_id"]').val() > 0) {
                invitationObj.mode = 'edit';
                invitationObj.event_id = $('#' + form_id + ' input[name="event_id"]').val();
                invitationObj.type = $('#' + form_id + ' input[name="type"]').val();
            }
            invitationObj.mode = 'calendar';

            invitationObj.about = $('#invitation_form input[name="about"]').val();
            invitationObj.term = $('#invitation_form  input[name="term"]').val();
            invitationObj.hlocation = $('#invitation_form  textarea[name="location"]').val();
            invitationObj.type = $('#invitation_form  input[name="invitation_type"]:checked').val();
            invitationObj.hevent_id = $('input[name="event_id"]').val();
            invitationObj.haudiences = $('select[name="invitationusers[]"]').select().val().toString();
            invitationObj.long = $('input[name="long"]').val();
            invitationObj.lat = $('input[name="latt"]').val();
            if ($('input[name="mode"]').length) {
                invitationObj.mode = 'calendar';
            }
            if ($('input[type="checkbox"][name="allow_inform_invitees"]').is(':checked')) {
                invitationObj.allow_inform_invitees = 1;
            }
            else {
                invitationObj.allow_inform_invitees = 0;
            }
            //console.log(invitationObj);
            $.ajax({
                url: '{{ URL::route('hamahang.calendar_events.save_invitation')}}',
                type: 'POST', // Send post dat
                data: invitationObj,
                async: false,
                success: function (s) {
                    s = JSON.parse(s);
                    console.log(s);
                    //console.log(s.error);
                    if (s.success == false) {
                        $('#invitation_errorMsg').empty();
                        errorsFunc('خطا', s.error, {id: 'invitation_errorMsg'}, 'invitation_errorMsg')
                        //  $('#invitation_errorMsg').html(warning);
                    } else {
                        eventInfo = s.event;
                        // console.log(eventInfo);
                        // console.log(eventInfo.title);
                        (function ($) {
                            $("#calendar").fullCalendar('addEventSource', [{
                                start: eventInfo.startdate,
                                end: eventInfo.enddate,
                                title: eventInfo.title,
                                color: eventInfo.bgColor,
                                block: true
                            }]);
                        })(jQuery_2);
                        invitationModal.close();
                        $('#add_invitation_dialog').modal('hide');
                        var html = '{{trans("calendar.calendar_saveInvitation_clicked_success_msg1")}}' + eventInfo.title + '{{trans("calendar.calendar_saved_success_msg2")}}';
                        messageModal('success', '{{trans("calendar.calendar_saveInvitation_clicked_success_msg_header")}}', html);
                    }
                }
            });
        });
        /*########################################################################################*/
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------save invitation ---------------------------------------*/
        /*----------------------------------------------------------------------------------------*/
        $(document).on('click', '#saveInvitation', function () {
            var invitationObj = {};
            invitationObj.about = $('#invitation_form input[name="about"]').val();
            invitationObj.term = $('#invitation_form  input[name="term"]').val();
            invitationObj.hlocation = $('#invitation_form  textarea[name="location"]').val();
            invitationObj.type = $('#invitation_form  input[name="invitation_type"]:checked').val();
            invitationObj.hevent_id = $('input[name="event_id"]').val();
            invitationObj.haudiences = $('select[name="invitationusers[]"]').select().val().toString();
            invitationObj.long = $('input[name="long"]').val();
            invitationObj.lat = $('input[name="latt"]').val();
            if ($('input[name="mode"]').length) {
                invitationObj.mode = 'calendar';
            }
            if ($('input[type="checkbox"][name="allow_inform_invitees"]').is(':checked')) {
                invitationObj.allow_inform_invitees = 1;
            }
            else {
                invitationObj.allow_inform_invitees = 0;
            }
            //console.log(invitationObj);
            $.ajax({
                url: '{{ URL::route('hamahang.calendar_events.save_invitation')}}',
                type: 'POST', // Send post dat
                data: invitationObj,
                async: false,
                success: function (s) {
                    s = JSON.parse(s);
                    //console.log(s.error);
                    if (s.success == false) {
                        $('#invitation_errorMsg').empty();
                        errorsFunc('خطا', s.error, {id: 'invitation_errorMsg'}, 'invitation_errorMsg')
                        //  $('#invitation_errorMsg').html(warning);
                    } else {
                        eventInfo = JSON.parse(s.event);
                        // console.log(eventInfo);
                        // console.log(eventInfo.title);
                        (function ($) {
                            $("#calendar").fullCalendar('addEventSource', [{
                                start: eventInfo.startdate,
                                end: eventInfo.enddate,
                                title: eventInfo.title,
                                color: eventInfo.bgColor,
                                block: true
                            }]);
                        })(jQuery_2);
                        invitationModal.close();
                        $('#add_invitation_dialog').modal('hide');
                        var html = '{{trans("calendar.calendar_saveInvitation_clicked_success_msg1")}}' + eventInfo.title + '{{trans("calendar.calendar_saved_success_msg2")}}';
                        messageModal('success', '{{trans("calendar.calendar_saveInvitation_clicked_success_msg_header")}}', html);
                    }
                }
            });
        });
        /*########################################################################################*/
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------save even reminder ---------------------------------------*/
        /*----------------------------------------------------------------------------------------*/
        $(document).on('click', '.saveReminderUserEvent', function () {
            // var result = saveEvent('reminder_form', 'reminder_errorMsg');
            var $this = $(this);
            form_id = 'reminder_form';
            var myForm = document.getElementById('reminder_form');
            //Extract Each Element Value
            var saveObj = {};
            var cid = 0;
            //console.log(document.forms[form_id].getElementsByTagName("cid"));
            // console.log('#' + form_id + ' select[name="cid"]');
            //console.log($('#' + form_id + ' select[name="cid"]').val());
            saveObj.save_type = $('input[name="new_reminder_save_type"]:checked').val();
            saveObj.in_day = $('input[name="in_day[]"]').serializeArray();
            saveObj.firstTyp_term = $('input[name="firstTyp_term[]"]').serializeArray();
            var save_again = $this.data('again_save');
            saveObj.htitle = $('#' + form_id + ' input[name="title"]').val();
            saveObj.hcid = $('#' + form_id + ' select[name="cid"]').val();
            saveObj.event_type = $('#' + form_id + ' input[name="event_type"]').val();
            saveObj.hstartdate = $('#' + form_id + ' input[name="in_day[]"]').val();
            saveObj.hstarttime = $('#' + form_id + ' input[name="firstTyp_term[]"]').val();
            saveObj.description = $('#' + form_id + ' textarea[name="descriotion"]').val();
            if ($('#' + form_id + ' input[type="checkbox"][name="allDay"]').is(':checked')) {
                saveObj.allDay = 1;
            }
            else {
                saveObj.allDay = 0;
            }
            saveObj.mode = 'insert';
            if ($('#' + form_id + ' input[name="event_id"]').length && $('#' + form_id + ' input[name="event_id"]').val() > 0) {
                saveObj.mode = 'edit';
                saveObj.event_id = $('#' + form_id + ' input[name="event_id"]').val();
                saveObj.type = $('#' + form_id + ' input[name="type"]').val();
            }
            //console.log(saveObj);
            var res = '';
            $.ajax({
                url: '{{ URL::route('hamahang.calendar_events.save_user_event')}}',
                type: 'POST', // Send post dat
                data: saveObj,
                async: false,
                success: function (s) {
                    res = JSON.parse(s);
                    if (res.success == false) {
                        $('#' + errorMsg_id).empty();
                        errorsFunc('{{trans('calendar_events.ce_error_label')}}', res.error, {id: errorMsg_id}, form_id);
                        // $('#' + errorMsg_id).html(warning);
                        reminderModdal.close();
                    } else {
                        if ($('#' + form_id + ' input[name="event_id"]').length) {
                            $('#' + form_id + ' input[name="event_id"]').val(res.event_id);
                        } else {
                            $('#' + form_id).append('<input type="hidden" name="event_id" value="' + res.event_id + '"/>');

                        }
                        var html = '{{trans("calendar.calendar_saveReminder_clicked_success_msg1").' '.trans("calendar.calendar_saved_success_msg2")}}';
                        messageModal('success', '{{trans("calendar.calendar_saveReminder_clicked_success_msg_header")}}', html);
                        if(save_again==0)
                            reminderModdal.close();
                    }
                }
            });

        });
        /*########################################################################################*/
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------save  reminder ---------------------------------------*/
        $(document).on('click', '.saveReminder', function () {
            var reminderObj = {firstType: {}, secondType: {}};
            var inDayArr = new Array();
            $.each($('input[name="in_day[]"]'), function (index, rec) {
                inDayArr.push(rec.value);
            });
            reminderObj.firstType.in_day = inDayArr.toString();
            firsTypeTermArr = new Array();
            $.each($('input[name="firstTyp_term[]"]'), function (index, rec) {

                firsTypeTermArr.push(rec.value);
            });
            reminderObj.firstType.term = firsTypeTermArr.toString();
            firstTypeInEventArr = new Array();
            $.each($('input[name="firstType_in_event[]"]'), function (index, rec) {
                if (rec.checked) {
                    firstTypeInEventArr.push(rec.value);
                }
                else {
                    firstTypeInEventArr.push(0);
                }
            });
            reminderObj.firstType.in_event = firstTypeInEventArr.toString();
            firstTypenotificationArr = new Array();
            $.each($('input[name="firstType_notification[]"]'), function (index, rec) {
                if (rec.checked) {
                    firstTypenotificationArr.push(rec.value);
                }
                else {
                    firstTypenotificationArr.push(0);
                }
            });
            reminderObj.firstType.notification = firstTypenotificationArr.toString();
            firstTypesmsArr = new Array();
            $.each($('input[name="firstType_sms[]"]'), function (index, rec) {
                if (rec.checked) {
                    firstTypesmsArr.push(rec.value);
                } else {
                    firstTypesmsArr.push(0);
                }
            });
            reminderObj.firstType.sms = firstTypesmsArr.toString();
            firstTpeEmailArr = new Array();
            $.each($('input[name="firstType_email[]"]'), function (index, rec) {
                if (rec.checked) {
                    firstTpeEmailArr.push(rec.value);
                } else {
                    firstTpeEmailArr.push(0);
                }
            });
            reminderObj.firstType.email = firstTpeEmailArr.toString();
            secondTypeBefordaysArr = new Array();
            $.each($('select[name="befordays[]"]').select(), function (index, rec) {
                secondTypeBefordaysArr.push(rec.value);
            });
            reminderObj.secondType.befordays = secondTypeBefordaysArr.toString();
            secondTypeBeforTypeArr = new Array();
            $.each($('select[name="beforType[]"]').select(), function (index, rec) {
                secondTypeBeforTypeArr.push(rec.value);
            });
            reminderObj.secondType.beforType = secondTypeBeforTypeArr.toString();
            secondTypeTermArr = new Array();
            $.each($('input[name="secondType_term[]"]'), function (index, rec) {
                secondTypeTermArr.push(rec.value);
            });
            reminderObj.secondType.term = secondTypeTermArr.toString();
            secondTypeInEventArr = new Array();
            $.each($('input[name="secondType_in_event[]"]'), function (index, rec) {
                if (rec.checked) {
                    secondTypeInEventArr.push(rec.value);
                } else {
                    secondTypeInEventArr.push(0);
                }
            });
            reminderObj.secondType.in_event = secondTypeInEventArr.toString();
            secondTypeNotificationArr = new Array();
            $.each($('input[name="secondType_notification[]"]'), function (index, rec) {
                if (rec.checked) {
                    secondTypeNotificationArr.push(rec.value);
                } else {
                    secondTypeNotificationArr.push(0);
                }
            });
            reminderObj.secondType.notification = secondTypeNotificationArr.toString();
            secondTypeSmsArr = new Array();
            $.each($('input[name="secondType_sms[]"]'), function (index, rec) {
                if (rec.checked) {
                    secondTypeSmsArr.push(rec.value);
                } else {
                    secondTypeSmsArr.push(0);
                }
            });
            reminderObj.secondType.sms = secondTypeSmsArr.toString();
            secondTypeemailArr = new Array();
            $.each($('input[name="secondType_email[]"]'), function (index, rec) {
                if (rec.checked) {
                    secondTypeemailArr.push(rec.value);
                } else {
                    secondTypeemailArr.push(0);
                }
            });
            reminderObj.secondType.email = secondTypeemailArr.toString();
            reminderObj.hevent_id = $('input[name="event_id"]').val();
            if ($('input[name="mode"]').length) {
                reminderObj.mode = $('input[name="mode"]').val();
                reminderObj.delReminder = $('input[name="delReminder"]').val();
            }
            //console.log(reminderObj);
            $.ajax({
                url: '{{ URL::route('hamahang.calendar_events.save_reminder')}}',
                type: 'POST', // Send post dat
                data: reminderObj,
                async: false,
                success: function (s) {
                    s = JSON.parse(s);
                    //console.log(s.error);
                    if (s.success == false) {
                        $('.reminder_errorMsg').empty();
                        errorsFunc('خطا', s.error, {class: 'reminder_errorMsg'})
                    } else {
                        eventInfo = JSON.parse(s.event);
                        // console.log(eventInfo);
                        // console.log(eventInfo.title);
                        (function ($) {
                            $("#calendar").fullCalendar('addEventSource', [{
                                start: eventInfo.startdate,
                                end: eventInfo.enddate,
                                title: eventInfo.title,
                                color: eventInfo.bgColor,
                                block: true
                            }]);
                        })(jQuery_2);
                        $('#add_seesion_dialog').modal('hide');
                        var html = '{{trans("calendar.calendar_saveInvitation_clicked_success_msg1")}}' + eventInfo.title + '{{trans("calendar.calendar_saved_success_msg2")}}';
                        messageModal('success', '{{trans("calendar.calendar_saveInvitation_clicked_success_msg_header")}}', html);
                    }
                }
            });
        });
        /*---------------------------------------------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------*/
        $('.add-reminder-row-secondType2').hide();
        $('input[name="reminderType2"]').change(function () {
            if ($('input[name="reminderType2"]:checked').val() == 1) {
                $('.add-reminder-row-firstType2').show();
                $('.add-reminder-row-secondType2').hide();
            } else {
                $('.add-reminder-row-firstType2').hide();
                $('.add-reminder-row-secondType2').show();
            }
        });
        /*---------------------------------------------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------*/
        $('.add-reminder-row-secondType').hide();
        $('input[name="reminderType"]').change(function () {
            if ($('input[name="reminderType"]:checked').val() == 1) {
                $('.add-reminder-row-firstType').show();
                $('.add-reminder-row-secondType').hide();
            } else {
                $('.add-reminder-row-firstType').hide();
                $('.add-reminder-row-secondType').show();
            }
        });
        $('#save-calendar-setting').click(function () {
            var defaultOptions = {};
            var sharingOptions = {};
            $('.default-options input[type="checkbox"]').each(function () {
                if (this.checked) {
                    var ch = 1
                } else {
                    var ch = 0
                }
                var color = $('input[name="' + this.name + '-color"]').val();
                var obj = {checked: ch, color: color};
                defaultOptions[this.name] = obj;
                //console.log(obj);
            });
            $('.sharing-options input[type="checkbox"]').each(function () {
                if (this.checked) {
                    var ch = 1;
                } else {
                    var ch = 0;
                }
                var color = $('input[name="' + this.name + '-color"]').val();
                var obj = {checked: ch, color: color};
                var nameArr = this.name.split('-');
                //console.log(nameArr)
                sharingOptions[nameArr[1]] = obj;
                //console.log(obj);
            });
            var cId = $('input[name="lastSelectdCalendar"]').val();
            postObj = {};
            postObj.option = JSON.stringify({cid: cId, defaultOptions: defaultOptions, sharingOptions: sharingOptions});
            $.ajax({
                url: '{{ URL::route('hamahang.calendar.update_calendar_setting')}}',
                type: 'POST', // Send post dat
                data: postObj,
                async: false,
                success: function (s) {
                    res = JSON.parse(s);
                    if (res.success == true) {
                        $('#modal_calendar_setting').modal('hide');
                        var html = '{{trans("calendar.calendar_save_calendar_setting_clicked_success_msg1")}}' + res.title + '{{trans("calendar.calendar_save_calendar_setting_clicked_success_msg2")}}';
                        messageModal('success', '{{trans("calendar.calendar_save_calendar_setting_clicked_success_msg3")}}', html);
                        showEvent(res.cid)
                    }
                }
            });
        });
    });//end document ready

    function offset(el) {
        var rect = el.getBoundingClientRect(),
            scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
            scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        return {top: rect.top + scrollTop, left: rect.left + scrollLeft}
    }
    function seaonToDay(month, day) {
        // console.log(month,day)
        $('.fc-right .fc-seasonDay-button').removeClass('fc-state-active');
        var now = new persianDate();
        // console.log([now.pDate.year,parseInt(month),parseInt(day)]);
        var selectdDay = new persianDate([now.pDate.year, parseInt(month), parseInt(day)]);
        selectdDay.formatPersian = false;
        selectdDay.format("YYYY/MM/DD").toString();
        var gDate = moment(selectdDay.format("YYYY/MM/DD").toString(), 'jYYYY/jM/jD').format('YYYY-M-D ');
        gDateAr = gDate.split('-')
        for (var i = 0; i < gDateAr.length; i++) {
            gDateAr[i] = persianToEngilshDigit(gDateAr[i])
        }
        //  console.log(gDateAr);
        //console.log(seasonEvents[month][day]);
        (function ($) {
            $('#calendar').fullCalendar('changeView', 'agendaDay');
            $('#calendar').fullCalendar('gotoDate', gDateAr.join('-'));
            $("#calendar").fullCalendar('removeEvents');
            $("#calendar").fullCalendar('addEventSource', seasonEvents[month][day]);
        })(jQuery_2);
    }
    /*****************************************************************************************/
    /*------------------------------------------------------------------------------------------*/
    /*--------------------------------------------prev season btn clicked event------------------------------------*/
    /*------------------------------------------------------------------------------------------*/
    function preSeason(selected) {
        if (selected > 1) {
            var pre = parseInt(selected) - 1;
            $('input[name="selectedSeason"]').val(pre);
            $('.fc-seasonDay-button').trigger('click');
        } else if (selected == 1) {
            $('.fc-pre-season').prop('disabled', true);
            $('.fc_next_season_btn ').prop('disabled', false);
        }
    }
    /*##########################################################################################*/
    /*------------------------------------------------------------------------------------------*/
    /*--------------------------------------------next season btn clicked event------------------------------------*/
    /*------------------------------------------------------------------------------------------*/
    function nextSeason(selected) {
        if (selected < 4) {
            var next = parseInt(selected) + 1;
            $('input[name="selectedSeason"]').val(next);
            $('.fc-seasonDay-button').trigger('click');
        } else if (selected == 4) {
            $('.fc_next_season_btn ').prop('disabled', true);
            $('.fc-pre-season').prop('disabled', false);
        }
    }
    /*###########################################################################################################*/
    /*------------------------------------------------------------------------------------------*/
    /*--------------------------------------------prev SixMonth btn clicked event------------------------------------*/
    /*------------------------------------------------------------------------------------------*/
    function preSixMonth(selected) {
        if (selected < 2) {
            var next = parseInt(selected) + 1;
            $('input[name="selectedSixMonth"]').val(next);
            $('.fc-6month-button').trigger('click');
        } else if (selected == 2) {
            $('.fc_next_sixmonth_btn ').prop('disabled', true);
            $('.fc-pre-sixmonth').prop('disabled', false);
        }
    }
    /*##########################################################################################*/
    /*------------------------------------------------------------------------------------------*/
    /*--------------------------------------------next sixMonth btn clicked event------------------------------------*/
    /*------------------------------------------------------------------------------------------*/
    function nextSixMonth(selected) {
        if (selected > 1) {
            var pre = parseInt(selected) - 1;
            $('input[name="selectedSixMonth"]').val(pre);
            $('.fc-6month-button').trigger('click');
        } else if (selected == 1) {
            $('.fc-pre-sixmonth').prop('disabled', true);
            $('.fc_next_sixmonth_btn ').prop('disabled', false);
        }
    }
</script>