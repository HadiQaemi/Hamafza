@include('hamahang.Widgets.UserCalendar.JS.calendars_grid')
@include('hamahang.Calendar.helper.Index.inlineJS.document_ready')
<script type="text/javascript">
    var newEventModal = '';
    var sessionModal = '';
    var invitationModal = '';
    var reminderModdal = '';
    /*#####################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*--------------------------------ereload event grid ---------------- -------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function reloadGrid() {
        $('#personalCalendarGrid').DataTable().ajax.reload();
        //    alert('hhhhhhhhhhhh');
        $('#sessionsGrid').DataTable().ajax.reload();
    }
    function ediPersonalCalendar(id, title) {
        $('#edit_form_error').html('');
        $('#item_details .modal-title span:first').html('');
        //  titleStr = '{{ trans('calendar.edit_calendar') }}  :'+title;
        // $('#item_details .modal-title span').html(titleStr);
        // $('#item_details').modal({show: true});
        editcalendarModal = $.jsPanel({
            position: {my: "center-top", at: "center-top", offsetY: 15},
            contentSize: {width: 900, height: 400},
            contentOverflow: 'auto',
            contentAjax: {
                url: '{{ URL::route('hamahang.calendar.edit_calendar' )}}',
                method: 'POST',
                dataType: 'json',
                data: 'id=' + id,
                done: function (data, textStatus, jqXHR, panel) {
                    this.headerTitle(data.header);
                    this.content.html(data.content);
                    this.toolbarAdd('footer', [{item: data.footer}]);
                    //******************add to info
                    $('#item_edit input[name="item_id"]').val(data.info.calendar.id);
                    $('#item_edit input[name="title"]').val(data.info.calendar.title);
                    if (data.info.calendar.is_default) {
                        $('input[name="is_default"]').attr('checked', 'true');
                    }
                    $('#item_edit input[name="type"][value="' + data.info.calendar.type + '"').prop('checked', true);
                    $('#item_edit textarea[name="descriotion"]').html(data.info.calendar.description);
                    //****************************add setting
                    $('#item_edit input[name="prayer_times"][value="' + data.info.calendar.prayer_times + '"').prop('checked', true);
                    //************ add city and province
                    // console.log(data.info.calendar.prayer_time_province);
                    $('#province').val(data.info.calendar.prayer_time_province);
                    $('#province').trigger('change');
                    $('#item_prayer_time_city').val(data.info.calendar.prayer_time_city).trigger('change');
                    //******************** add hiddentime
                    $(' input[type="radio"][name="beginning_day"][value="' + data.info.calendar.beginning_day + '"]').prop('checked', true);
                    $('input[type="radio"][name="beginning_day"]').trigger('change');
                    if ($('#hidentime hr ').length == 0) {
                        var hr = '<hr class="hrstyle"/>'
                        $(hr).insertAfter('#hiden_holder');
                    }
                    if (data.info.hiddenTimes.length > 0) {
                        for (var i = 0; i < data.info.hiddenTimes.length; i++) {
                            var c = $('#hiden_holder:first').clone();
                            c.find('a:first').remove();
                            c.find('input[name="hidden_from[]"]').val(data.info.hiddenTimes[i].time_from).end();
                            c.find('input[name="hidden_to[]"]').val(data.info.hiddenTimes[i].time_to).end();
                            c.insertAfter('#hidentime hr ');
                        }
                    }
                    if (data.info.calendar.monasebat == 1) {
                        $('input[type="checkbox"][name="monasebat"]').prop('checked', true);
                    }
                    if (data.info.calendar.brith_day == 1) {
                        $('input[type="checkbox"][name="brith_day"]').prop('checked', true);
                    }
                    //************************add permission
                    //console.log(s.permissions.length);
                    if (data.info.permissions.length > 0) {
                        for (var i = 0; i < data.info.permissions.length; i++) {
                            if (data.info.permissions[i].access == '001') {
                                $('select[name="viewPermissions[]"]').append('<option value="' + data.info.permissions[i].uid + '" selected ">' + data.info.permissions[i].uname + '</option>');
                                //  console.log('ddd');
                            }
                            if (data.info.permissions[i].access == '011') {
                                $('select[name="editPermissions[]"]').append('<option value="' + data.info.permissions[i].uid + '" selected ">' + data.info.permissions[i].uname + '</option>');
                                // console.log('fff');
                            }
                        }
                    }
                    //**************************** add Sharing
                    if (data.info.sharings.length > 0) {
                        var ShgarStr = '';
                        var sharing_options = JSON.parse(data.info.calendar.sharing_options);
                        $('input[name="sharing_calendars"]').val('');
                        for (var i = 0; i < data.info.sharings.length; i++) {

                            ShgarStr += '<tr id="row-' + data.info.sharings[i].id + '">' +
                                '<td>' + (i + 1) + '</td>' +
                                '<td>' + data.info.sharings[i].title + '</td>' +
                                '<td style="width:10px;background-color:' + sharing_options[data.info.sharings[i].id] + ' "></td>' +
                                '<td><a class="btn btn-default btn-xs fa fa-close" href="#"onclick="removeSharing(' + data.info.sharings[i].id + ');"></a></td></tr>';
                            //console.log(ShgarStr);
                            $('input[name="sharing_calendars"]').val(JSON.stringify(sharing_options));

                        }
                        $('#lastShring table tbody').append(ShgarStr);
                    }
                    //*********************edit default option**********************
                    if (data.info.calendar.default_options.length) {
                        var defaultOptions = JSON.parse(data.info.calendar.default_options);
                        for (x in defaultOptions) {
                            // console.log(x);
                            // console.log(defaultOptions[x].checked);
                            // console.log(defaultOptions[x].color);
                            if (defaultOptions[x].checked == 1) {
                                $('#t5 .default-options  input[name="' + x + '"][type="checkbox"]').prop('checked', true);
                                //console.log($('#t5 .default-options  input[name="'+x+'-color"]'));
                                $('#t5 .default-options  input[name="' + x + '-color"]').val(defaultOptions[x].color);
                                // $('#t5 .default-options .'+x+'-color input[type="checkbox"]').prop('checked',true);
                                $('#t5 .default-options .' + x + '-color').colorpicker('setValue', defaultOptions[x].color)
                            }
                        }
                    }
                    setTimeout(function () {
                        $('#pan_t1').trigger('click');
                    }, 3000);
                }
            }
        });
        editcalendarModal.content.html('<div class="loader"></div>');
    }
    function addPersonalCalendar() {

        $('#add_form_error').html('');
        // $('#calendar_add_info_form')[0].reset();
        //$('#item_add').modal({show: true});
        //console.log(data);
        calendarModal = $.jsPanel({
            position: {my: "center-top", at: "center-top", offsetY: 15},
            contentSize: {width: 700, height: 300},
            contentAjax: {
                url: '{{ URL::route('hamahang.calendar.new_calendar' )}}',
                method: 'POST',
                dataType: 'json',
                done: function (data, textStatus, jqXHR, panel) {
                    console.log(data.content);
                    this.headerTitle(data.header);
                    this.content.html(data.content);
                    this.toolbarAdd('footer', [{item: data.footer}]);
                    $('#form-invitation-content').hide();
                }
            }
        });
        calendarModal.content.html('<div class="loader"></div>');
    }
    $(".TimePicker").persianDatepicker({
        format: "HH:mm",
        timePicker: {
            //showSeconds: false,
        },
        onlyTimePicker: true
    });
    function addNewHideTime() {
        if ($('#hidentime hr ').length == 0) {
            var hr = '<hr class="hrstyle"/>'
            $(hr).insertAfter('#hiden_holder');
        }
        var clone = $('#hiden_holder').clone();
        console.log(clone);
        clone.removeAttr("id").addClass('hiden_holder row');
        clone.find('a').remove();
        // clone.append('<a class="btn btn-default btn-xs fa fa-close" href="#" onclick="removeHiddenTime(this);"></a>');
        clone.append('<div class="col-xs-2"><a class="btn btn-default btn-xs fa fa-close" href="#" onclick="removeHiddenTime(this);"></a></div>');
        clone.insertAfter('#hidentime hr');
    }
    function removeHiddenTime(el) {
        //   console.log($(el));
        // $(el).parent().remove();
        $(el).parent().parent().remove();
    }
    function removeAllHiddenTime() {
        $('.hiden_holder').remove();
    }
    function addNewSharing(el) {
        //$('#sharingSelect').clone().insertAfter('#sharingSelect');\
        var id = $('select[name="sharing_calendar_list[]').select().val();
        var color = $('input[name="sharing-color[]"] ').val();
        var sharing_type1 = $('input[name="sharing_type[]"]:checked ').val();
        var sharing_type = $('#'+sharing_type1).html();
        $('#lastShring').removeClass('hidden');
        vals = {};
        if (parseInt(id)) {
            /*
			var old = $('input[name="sharing_calendars"]').val();
            if (old != false) {
                vals = JSON.parse(old);
            }
            vals[id] = color;
            $('input[name="sharing_calendars"]').val(JSON.stringify(vals));
			*/
            if ($('#lastShring > table tr:last > td:first').length) {
                var lastRow = $('#lastShring > table tr:last > td:first').text();
            } else {
                var lastRow = 0;
            }
            var txt = $('select[name="sharing_calendar_list[]"] > option:selected').text();
            addRow = '<tr id="row-' + id + '">';
            addRow += '<th>' + (parseInt(lastRow) + 1) + '</th>';
            addRow += '<th>' + txt + '</th>';
            addRow += '<th>' + sharing_type + '</th>';
            addRow += '<th style="width:10px;background-color:' + color + '"></th>';
            addRow += '<th><a class="btn btn-default btn-xs fa fa-close" href="#"onclick="removeSharing(' + id + ');"></a></th></tr>';
            addRow += '</tr>';
            $('#lastShring table tbody').append(addRow);
        }
    }
    function removeSharing(eId) {
        console.log(eId);
        var vals = JSON.parse($('input[name="sharing_calendars"]').val());
        //console.log(eId);
        // var Arr = vals.split(",");
        /* var nArr = new Array();
         for (index in Arr) {
         if (Arr[index] != eId) {
         nArr.push(Arr[index]);
         }
         }*/
        delete vals[eId];
        //console.log(vals);
        $('input[name="sharing_calendars"]').val(JSON.stringify(vals));
        $('#lastShring > table tr#row-' + eId).remove();

    }
    /*-------------------------------------------------------------------------------------------------------------*/
    /*-------------show events odf selected calendar  by cclick view in calendar list-------------------------------*/
    /*-------------------------------------------------------------------------------------------------------------*/
    function showEvent(id) {
        var obj = {};
        obj.cid = id;
        currenCalendar = id;
        loading({id: 'calendar'}, 1);
        $.ajax({
            url: '{{ URL::route('hamahang.calendar_events.get_calendar_events')}}',
            type: 'POST',
            data: obj,
            async: false,
            success: function (s) {
                res = JSON.parse(s);
                //console.log(res);
                loading('calendar', 0);
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
                            end: res.events[i].end
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
                            color: color
                        };
                        eventIndex++;
                    }
                }
                if (res.sharing_events.length) {
                    for (var i = 0; i < res.sharing_events.length; i++) {
                        // console.log(res.sharing_events[i].sharId)
                        if (sharing_options != null && typeof sharing_options[res.sharing_events[i].sharId] != 'undefined') {
                            var color = sharing_options[res.sharing_events[i].sharId].color;
                        }
                        else {
                            var color = '#1e893a';
                        }
                        events[eventIndex] = {
                            className: 'event  share_event share_event_' + res.sharing_events[i].sharId,
                            title: res.sharing_events[i].title,
                            start: res.sharing_events[i].startdate,
                            end: res.sharing_events[i].enddate,
                            color: color
                        };
                        eventIndex++;
                    }
                }
                for (var dp in defaultoptions) {

                    var obj = defaultoptions[dp];
                    if (obj.checked == 1) {
                        $('input[name="' + dp + '"]').prop('checked', true);
                    }
                    $('#' + dp + '-color').colorpicker('setValue', obj.color);
                }
                var html = '';
                if (res.sharing_ids != null) {
                    for (var i = 0; i < res.sharing_ids.length; i++) {
                        html += '<tr>';
                        html += '<td class="col-xs-1"><input type="checkbox" name="sharing-' + res.sharing_ids[i].calendar_share_of + '"/> </td>';
                        html += '<td class="col-xs-5">' + res.sharing_ids[i].title + '</td>';
                        html += '<td class="col-xs-6"> <div id="sharing-' + res.sharing_ids[i].calendar_share_of + '-color" class="input-group colorpicker-component">';
                        html += '<input type="text" value="" name="sharing-' + res.sharing_ids[i].calendar_share_of + '-color" class="form-control" />';
                        html += ' <span class="input-group-addon"><i></i></span>';
                        html += '</div>';
                        html += '<script>';
                        html += '$(function() {';
                        html += '$("#sharing-' + res.sharing_ids[i].calendar_share_of + '-color").colorpicker({';
                        html += 'container : \'#sharing-' + res.sharing_ids[i].calendar_share_of + '-color\'';
                        html += '});';
                        html += '});';
                        html += '</\script>';
                        html += '</td>';
                        html += '</tr>';
                        $('.sharing-options table tbody').html(html);
                    }
                } else {
                    for (sp in sharing_options) {
                        var obj = sharing_options[sp];
                        console.log(obj);
                        if (obj.checked == 1) {
                            var chStr = ' checked="chcked" ';
                        }
                        else {
                            var chStr = '';
                        }
                        html += '<tr>';
                        html += '<td class="col-xs-1"><input ' + chStr + 'type="checkbox" name="sharing-' + sp + '"/> </td>';
                        html += '<td class="col-xs-5">' + obj.title + '</td>';
                        html += '<td class="col-xs-6"> <div id="sharing-' + sp + '-color" class="input-group  shring-colorpicker colorpicker-component">';
                        html += '<input type="text" value="" name="sharing-' + sp + '-color" class="form-control" />';
                        html += ' <span class="input-group-addon"><i></i></span>';
                        html += '</div>';
                        html += '<script>';
                        html += '$("#sharing-' + sp + '-color").colorpicker({';
                        html += 'container : \'#sharing-' + sp + '-color\'';
                        html += '});';
                        html += '</\script>';
                        html += '</td>';
                        html += '</tr>';
                        $('.sharing-options table tbody').html(html);
                        $('#sharing-' + sp + '-color').colorpicker('setValue', obj.color);
                    }
                }
                // console.log(res.calendarInfo);
                $('.calendar-main-setting input[name="lastSelectdCalendar"]').val(res.calendarInfo.id);
                $('.calendar-main-setting div:nth-child(1)').html(res.calendarInfo.title);
                ///  $('.calendar-main-setting div:last-child').html('<button href="#" onclick="showSettingModal();" class="btn btn-success fa fa-cog  " > تنظیمات </button>');
                //console.log(events);
                jQuery_2('#calendar').fullCalendar('removeEvents');
                jQuery_2('#calendar').fullCalendar('addEventSource', events);
                jQuery_2('#calendar').fullCalendar('renderEvents');
            }
        });
        $('#personalCalendarGrid tbody').on('click', 'tr', function () {
            $('#personalCalendarGrid  tr').removeAttr('style');
            $('#personalCalendarGrid  td').removeAttr('style');
            $(this).css('background', '#ededed');
            var ii = $('#personalCalendarGrid  i');
            for (x = 0; x < ii.length; x++) {
                // console.log($(ii[x]));
                if ($(ii[x]).hasClass('fa-eye')) {
                    $(ii[x]).removeClass('fa-eye');
                    $(ii[x]).addClass('fa-eye-slash');
                }
            }
            var i = $(this).find('i ');
            $(i[1]).removeClass('fa-eye-slash');
            $(i[1]).addClass('fa-eye');
            var tds = $(this).find('td');
            $(tds[1]).css('font-weight', 'bold');
        });
    }
    /*####################################################################################################################*/
    /*--------------------------------------------------------------------------------------------------------------------*/
    /*-------------------------------------------------deletecalendar ---------------------------------------------------*/
    function deletePersonalCalendar(id) {
        var table = $('#personalCalendarGrid').DataTable();
        var msg = '';
        $('#personalCalendarGrid tbody').on('click', 'tr', function () {
            var data = table.row(this).data();
            // console.log(data.title);
            msg = data.title;
            // $('#remove_confirm_modal #modal_massage').html(msg);
            //console.log(msg);
        });
        var obj = {};
        obj.cid = id;
        confirmModal({
            title: '{{ trans('calendar.delete_calendar') }}',
            message: '{!!trans("calendar.calendar_delete_title1")!!}' + msg + '{!! trans("calendar.calendar_delete_title2")!!}',
            onConfirm: function () {
                $.ajax({
                    url: '{{ URL::route('hamahang.calendar.deleteCalendar')}}',
                    type: 'POST', // Send post dat
                    data: obj,
                    async: false,
                    success: function (s) {
                        res = JSON.parse(s);
                        if (res.success == true) {
                            title = '{{trans("calendar.calendar_deletePersonalCalendar_func_msg1")}}  ';
                            msg = '{{trans("calendar.calendar_deletePersonalCalendar_func_msg2")}} ' + res.title + '{{trans("calendar.calendar_deletePersonalCalendar_func_msg3")}}';
                            messageModal('success', title, {0:msg});
                            reloadGrid();
                        }
                    }
                });
            },
            afterConfirm: 'close'
        });
    }
    /*####################################################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*------------------------------save event  from all modal by form_id -------------------*/
    /*-------------------------------------------------------------------------------------*/
    function saveEvent(form_id, errorMsg_id) {
        var myForm = document.getElementById(form_id);
        //Extract Each Element Value
        var saveObj = {};
        var cid = 0;
        //console.log(document.forms[form_id].getElementsByTagName("cid"));
        // console.log('#' + form_id + ' select[name="cid"]');
        //console.log($('#' + form_id + ' select[name="cid"]').val());
        saveObj.htitle = $('#' + form_id + ' input[name="title"]').val();
        saveObj.hcid = $('#' + form_id + ' select[name="cid"]').val();
        saveObj.hstartdate = $('#' + form_id + ' input[name="startdate"]').val();
        saveObj.starttime = $('#' + form_id + ' input[name="starttime"]').val();
        saveObj.henddate = $('#' + form_id + ' input[name="enddate"]').val();
        saveObj.endtime = $('#' + form_id + ' input[name="endtime"]').val();
        saveObj.description = $('#' + form_id + ' textarea[name="descriotion"]').val();
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
                } else {
                    if ($('#' + form_id + ' input[name="event_id"]').length) {
                        $('#' + form_id + ' input[name="event_id"]').val(res.event_id);
                    } else {
                        $('#' + form_id).append('<input type="hidden" name="event_id" value="' + res.event_id + '"/>');

                    }
                }
            }
        });
        return res;
    }
    /*####################################################################################################################*/
    /*--------------------------------------------------------------------------------------------------------------------*/
    /*-------------------------------------------------show multiTaskingModal ---------------------------------------------------*/
    function showMultiTaskingModal() {
        // $('#form-event')[0].reset();
        $('#errMSg').html('');
        startdate = $('#modal_fullcalendar_menu input[name="startdate"]').val().split("/");
        var starttime = new Array();
        enddate = $('#modal_fullcalendar_menu input[name="enddate"]').val().split("/");
        var starttime = $('#modal_fullcalendar_menu input[name="starttime"]').val();
        var starttime = $('#modal_fullcalendar_menu input[name="starttime"]').val();
        var endtime = $('#modal_fullcalendar_menu input[name="endtime"]').val();
        var starttime = $('#modal_fullcalendar_menu input[name="starttime"]').val();
        //console.log(startdate);return;
        for (var i = 0; i < startdate.length; i++) {
            startdate[i] = persianToEngilshDigit(startdate[i]);
        }
        for (var i = 0; i < enddate.length; i++) {
            enddate[i] = persianToEngilshDigit(enddate[i]);
        }
        enddate = enddate.join('-');
        startdate = startdate.join('-');
        newEventModal = $.jsPanel({
            position: {my: "center-top", at: "center-top", offsetY: 15},
            contentSize: {width: 800, height: 300},
            contentAjax: {
                url: '{{ URL::route('modals.multi_task' )}}',
                method: 'POST',
                dataType: 'json',
                done: function (data, textStatus, jqXHR, panel) {
                    this.headerTitle(data.header);
                    this.content.html(data.content);
                    this.toolbarAdd('footer', [{item: data.footer}]);
                    $('#form-multi-tasking input[name="event_type"]').val('multi_task');
                    $('#form-multi-tasking input[name="startdate"]').val(startdate);
                    $('#form-multi-tasking input[name="enddate"]').val(enddate);
                    $('#form-multi-tasking input[name="starttime"]').val(startdate);
                    $('#form-multi-tasking input[name="endtime"]').val(endtime);
                    $('#form-multi-tasking input[name="starttime"]').val(starttime);
                    // $('#form-event .modal-title span:first-child').html('{{ trans('calendar.new_event') }}');
                    $('#form-multi-tasking form').append('<input type="hidden" name="mode" value="calendar"/>');
                }
            }
        });

        newEventModal.content.html('<div class="loader"></div>');
        addMenuDialog.close();
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
            }
        });
    }
	    /*####################################################################################################################*/
    /*--------------------------------------------------------------------------------------------------------------------*/
    /*-------------------------------------------------show create task modal---------------------------------------------------*/
    function showTaskModal() {
        // $('#form-event')[0].reset();
        $('#errMSg').html('');
        startdate = $('#modal_fullcalendar_menu input[name="startdate"]').val().split("/");
        var starttime = new Array();
        enddate = $('#modal_fullcalendar_menu input[name="enddate"]').val().split("/");
        var starttime = $('#modal_fullcalendar_menu input[name="starttime"]').val();
        var starttime = $('#modal_fullcalendar_menu input[name="starttime"]').val();
        var endtime = $('#modal_fullcalendar_menu input[name="endtime"]').val();
        var starttime = $('#modal_fullcalendar_menu input[name="starttime"]').val();
        //console.log(startdate);return;
        for (var i = 0; i < startdate.length; i++) {
            startdate[i] = persianToEngilshDigit(startdate[i]);
        }
        for (var i = 0; i < enddate.length; i++) {
            enddate[i] = persianToEngilshDigit(enddate[i]);
        }
        enddate = enddate.join('-');
        startdate = startdate.join('-');
        newEventModal = $.jsPanel({
            position: {my: "center-top", at: "center-top", offsetY: 15},
            contentSize: {width: 800, height: 400},
            contentAjax: {
                url: '{{ URL::route('modals.create_new_task' )}}',
                method: 'POST',
                dataType: 'json',
                done: function (data, textStatus, jqXHR, panel) {
                    this.headerTitle(data.header);
                    this.content.html(data.content);
                    this.toolbarAdd('footer', [{item: data.footer}]);
                    $('#create_new_task input[name="event_type"]').val('task');
                    $('#create_new_task input[name="startdate"]').val(startdate);
                    $('#create_new_task input[name="enddate"]').val(enddate);
                    $('#create_new_task input[name="starttime"]').val(startdate);
                    $('#create_new_task input[name="endtime"]').val(endtime);
                    $('#create_new_task input[name="starttime"]').val(starttime);
                    $('#create_new_task #task_form_action').val('add_event');
                    $('#create_new_task').css("overflow-y", "scroll");
                    $('#create_new_task').css("height", "350px");
                    $('#new_task_save_type_draft').css("display", "none");
                    $('#new_task_save_private_library').css("display", "none");
                    $('#new_task_save_public_library').css("display", "none");
                    $('#new_task_save_type_final').css("display", "none");
                    $('#new_task_save_type_draft_l').css("display", "none");
                    $('#new_task_save_private_library_l').css("display", "none");
                    $('#new_task_save_public_library_l').css("display", "none");
                    $('#new_task_save_type_final_l').css("display", "none");
                    $('#define').removeClass('active');
                    $('#create_new_task #tab_t1').removeClass('active');
                    $('.eventTask').addClass('active');
                    $('#save_commit').addClass('save_time_task');
                    $('#save_commit').removeClass('save_task');
                    $('#form-event .modal-title span:first-child').html('{{ trans('calendar.new_event') }}');
                    $('#create_new_task form').append('<input type="hidden" name="mode" value="calendar"/>');
                }
            }
        });

        newEventModal.content.html('<div class="loader"></div>');
        addMenuDialog.close();
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
            }
        });
    }
    /*####################################################################################################################*/
    /*--------------------------------------------------------------------------------------------------------------------*/
    /*-------------------------------------------------show eventModal ---------------------------------------------------*/
    function showEvenModal() {
        // $('#form-event')[0].reset();
        $('#errMSg').html('');
        startdate = $('#modal_fullcalendar_menu input[name="startdate"]').val().split("/");
        var starttime = new Array();
        enddate = $('#modal_fullcalendar_menu input[name="enddate"]').val().split("/");
        var starttime = $('#modal_fullcalendar_menu input[name="starttime"]').val();
        var starttime = $('#modal_fullcalendar_menu input[name="starttime"]').val();
        var endtime = $('#modal_fullcalendar_menu input[name="endtime"]').val();
        var starttime = $('#modal_fullcalendar_menu input[name="starttime"]').val();
        
        //console.log(startdate);return;
        for (var i = 0; i < startdate.length; i++) {
            startdate[i] = persianToEngilshDigit(startdate[i]);
        }
        for (var i = 0; i < enddate.length; i++) {
            enddate[i] = persianToEngilshDigit(enddate[i]);
        }
        enddate = enddate.join('-');
        startdate = startdate.join('-');
        newEventModal = $.jsPanel({
            position: {my: "center-top", at: "center-top", offsetY: 15},
            contentSize: {width: 800, height: 300},
            contentAjax: {
                url: '{{ URL::route('hamahang.calendar_events.new_event_modal' )}}',
                method: 'POST',
                dataType: 'json',
                done: function (data, textStatus, jqXHR, panel) {
                    this.headerTitle(data.header);
                    this.content.html(data.content);
                    this.toolbarAdd('footer', [{item: data.footer}]);
                    $('#form-event input[name="event_type"]').val('event');
                    $('#form-event input[name="startdate"]').val(startdate);
                    $('#form-event input[name="enddate"]').val(enddate);
                    $('#form-event input[name="starttime"]').val(startdate);
                    $('#form-event input[name="endtime"]').val(endtime);
                    $('#form-event input[name="starttime"]').val(starttime);
                    // $('#form-event .modal-title span:first-child').html('{{ trans('calendar.new_event') }}');
                    $('#form-event form').append('<input type="hidden" name="mode" value="calendar"/>');
                }
            }
        });

        newEventModal.content.html('<div class="loader"></div>');
        addMenuDialog.close();
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
            }
        });
    }
    /*#############################################################################################*/
    /*------------------------------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------*/
    function showSessionModal() {
        startdate = $('#modal_fullcalendar_menu input[name="startdate"]').val().split("/");
        var starttime = new Array();
        enddate = $('#modal_fullcalendar_menu input[name="enddate"]').val().split("/");
        var starttime = $('#modal_fullcalendar_menu input[name="starttime"]').val();
        var starttime = $('#modal_fullcalendar_menu input[name="starttime"]').val();
        var endtime = $('#modal_fullcalendar_menu input[name="endtime"]').val();
        var starttime = $('#modal_fullcalendar_menu input[name="starttime"]').val();
        //console.log(startdate);return;
        for (var i = 0; i < startdate.length; i++) {
            startdate[i] = persianToEngilshDigit(startdate[i]);
        }
        for (var i = 0; i < enddate.length; i++) {
            enddate[i] = persianToEngilshDigit(enddate[i]);
        }
        sessionModal = $.jsPanel({
            position: {my: "center-top", at: "center-top", offsetY: 15},
            contentSize: {width: 800, height: 400},
            contentAjax: {
                url: '{{ URL::route('hamahang.calendar_events.session_modal' )}}',
                method: 'POST',
                dataType: 'json',
                done: function (data, textStatus, jqXHR, panel) {
                    this.headerTitle(data.header);
                    this.content.html(data.content);
                    this.toolbarAdd('footer', [{item: data.footer}]);
                    $('#sessionForm input[name="event_type"]').val('session');
                    $('#sessionForm input[name="startdate"]').val(startdate.join('-'));
                    $('#sessionForm input[name="starttime"]').val(starttime);
                    $('#sessionForm input[name="enddate"]').val(enddate.join('-'));
                    $('#sessionForm input[name="endtime"]').val(endtime);
                    $('#sessionForm form').append('<input type="hidden" name="mode" value="calendar"/>');
                }
            }
        });
        sessionModal.content.html('<div class="loader"></div>');
        $('#errMSg').html('');
        $('#form-session-content').hide();
        $('#add_seesion_dialog').modal('show');
        addMenuDialog.close();
    }
    /*#############################################################################################*/
    /*------------------------------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------*/
    function navigationWizard() {
        $('.nav-wizard li:nth-child(1)').removeClass('active');
        $('.nav-wizard li:nth-child(2)').addClass('active');

    }
    /*#############################################################################################*/
    /*------------------------------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------*/
    function showInvitationModal() {
        startdate = $('#modal_fullcalendar_menu input[name="startdate"]').val().split("/");
        var starttime = new Array();
        enddate = $('#modal_fullcalendar_menu input[name="enddate"]').val().split("/");
        var starttime = $('#modal_fullcalendar_menu input[name="starttime"]').val();
        var starttime = $('#modal_fullcalendar_menu input[name="starttime"]').val();
        var endtime = $('#modal_fullcalendar_menu input[name="endtime"]').val();
        var starttime = $('#modal_fullcalendar_menu input[name="starttime"]').val();
        //console.log(startdate);return;
        for (var i = 0; i < startdate.length; i++) {
            startdate[i] = persianToEngilshDigit(startdate[i]);
        }
        for (var i = 0; i < enddate.length; i++) {
            enddate[i] = persianToEngilshDigit(enddate[i]);
        }
        invitationModal = $.jsPanel({
            position: {my: "center-top", at: "center-top", offsetY: 15},
            contentSize: {width: 900, height: 400},
            contentAjax: {
                url: '{{ URL::route('hamahang.calendar_events.invitation_modal' )}}',
                method: 'POST',
                dataType: 'json',
                done: function (data, textStatus, jqXHR, panel) {
                    console.log(data.content);
                    this.headerTitle(data.header);
                    this.content.html(data.content);
                    this.toolbarAdd('footer', [{item: data.footer}]);
                    $('#invitation_form input[name="startdate"]').val(startdate.join('-'));
                    $('#invitation_form input[name="starttime"]').val(starttime);
                    $('#invitation_form input[name="enddate"]').val(enddate.join('-'));
                    $('#invitation_form input[name="endtime"]').val(endtime);
                    $('#invitation_form form').append('<input type="hidden" name="mode" value="calendar"/>');
                    $('#form-invitation-content').hide();
                }
            }
        });
        invitationModal.content.html('<div class="loader"></div>');
        $('#invitation_errorMsg').html('');
        addMenuDialog.close();
    }
    /*#############################################################################################*/
    /*------------------------------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------*/
    function showReminderModal() {
        startdate = $('#modal_fullcalendar_menu input[name="startdate"]').val().split("/");
        var starttime = new Array();
        enddate = $('#modal_fullcalendar_menu input[name="enddate"]').val().split("/");
        var starttime = $('#modal_fullcalendar_menu input[name="starttime"]').val();
        var starttime = $('#modal_fullcalendar_menu input[name="starttime"]').val();
        var endtime = $('#modal_fullcalendar_menu input[name="endtime"]').val();
        var starttime = $('#modal_fullcalendar_menu input[name="starttime"]').val();
        //console.log(startdate);return;
        for (var i = 0; i < startdate.length; i++) {
            startdate[i] = persianToEngilshDigit(startdate[i]);
        }
        for (var i = 0; i < enddate.length; i++) {
            enddate[i] = persianToEngilshDigit(enddate[i]);
        }
        reminderModdal = $.jsPanel({
            position: {my: "center-top", at: "center-top", offsetY: 15},
            contentSize: {width: 900, height: 400},
            contentAjax: {
                url: '{{ URL::route('hamahang.calendar_events.reminder_modal' )}}',
                method: 'POST',
                dataType: 'json',
                done: function (data, textStatus, jqXHR, panel) {
                    this.headerTitle(data.header);
                    this.content.html(data.content);
                    this.toolbarAdd('footer', [{item: data.footer}]);
                    $('#reminder_form input[name="event_type"]').val('reminder');
                    $('#reminder_form input[name="startdate"]').val(startdate.join('-'));
                    $('#reminder_form input[name="starttime"]').val(starttime);
                    $('#form-reminder-content').hide();
                    $('#reminder_form input[name="enddate"]').val(enddate.join('-'));
                    $('#reminder_form input[name="endtime"]').val(endtime);
                    $('#new_reminder_dialog form').append('<input type="hidden" name="mode" value="calendar"/>');
                }
            }
        });
        reminderModdal.content.html('<div class="loader"></div>');
        $('#reminder_errorMsg').html('');
        addMenuDialog.close();
    }
    /*#####################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*-----------------------------clone the first type of reminder--------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function addFirstType(el) {
        saveReminders();
        id = $('input[name="event_id"]').val();
        gerReminder(id);
        $('.nav-tabs a[href="#listR"]').tab('show');
    }
    /*#####################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*-----------------------------clone the first type of reminder--------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function addFirstType2(el) {
        saveReminders();
        /*var newDiv = $('.add-reminder-row-firstType2').clone();//insertAfter('.add-reminder-row-firstType');
         newDiv.remove('.add_firsType_nav_btn');
         newDiv.insertAfter('.add-reminder-row-firstType2');
         newDiv.find('input.DatePicker').persianDatepicker({

         autoClose: true,
         format: 'YYYY-MM-DD',

         });
         newDiv.find("input.TimePicker").persianDatepicker({
         format: "HH:mm",
         timePicker: {
         //showSeconds: false,
         },
         onlyTimePicker: true
         });*/
        id = $('input[name="event_id"]').val();
        gerReminder2(id);
        $('.nav-tabs a[href="#listR2"]').tab('show');
    }
    /*#####################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*-----------------------------remove of first type -----------------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function removeFirstType(el) {
        $(el).parent().parent().parent().remove();
    }
    /*#####################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*-----------------------------add second type-----------------------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function addSecondType(el) {
        saveReminders();
        id = $('input[name="event_id"]').val();
        gerReminder(id);
        $('.nav-tabs a[href="#listR"]').tab('show');
    }
    /*#####################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*-----------------------------add second type-----------------------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function addSecondType2(el) {
        /* newDiv=$('.add-reminder-row-secondType2').clone();
         newDiv.remove('.add_secondType_nav');
         newDiv.insertAfter('.add-reminder-row-secondType2');
         newDiv.find("input.TimePicker").persianDatepicker({
         format: "HH:mm",
         timePicker: {
         //showSeconds: false,
         },
         onlyTimePicker: true
         });*/
        saveReminders();
        id = $('input[name="event_id"]').val();
        gerReminder2(id);
        $('.nav-tabs a[href="#listR2"]').tab('show');
    }
    /*#####################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*-----------------------------remove second type ---------------------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function removeSecondType(el) {
        $(el).parent().parent().parent().remove();
    }
    /*#####################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*-----------------------------saveReminders---------------------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function saveReminders() {
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
            url: '<?php echo e(URL::route('hamahang.calendar_events.save_reminder')); ?>',
            type: 'POST', // Send post dat
            data: reminderObj,
            async: false,
            success: function (s) {
                s = JSON.parse(s);
                //console.log(s.error);
                if (s.success == false) {

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
                }
            }
        });
    }
    /*------------------------------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------*/
    function gerReminder(id) {
        if ($.fn.DataTable.isDataTable('#reminderList')) {
            $('#reminderList').DataTable().destroy();
        }
        $('#reminderList tbody').empty();
        var obj = {};
        obj.event_id = id;
        obj.event_id = id;
        var html = '';
        html += '<input name="mode" type="hidden" value="noChange"/>';
        html += '<input name="delReminder" type="hidden" value=""/>';
        $('#reminderList').DataTable({
            "dom": window.CommonDom_DataTables,
            "language": LangJson_DataTables,
            processing: true,
            serverSide: true,
            pagingType: "numbers",
            autoWidth: false,
            sPaginationType: "bootstrap",
            pageLength: 5,
            lengthChange: false,
            ajax: {
                url: '{{ URL::route('hamahang.calendar_events.reminder_data')}}',
                type: 'POST',
                data: obj
            },
            columns: [
                {
                    data: 'rowIndex',
                    name: 'rowIndex',
                    width: '1%'
                },
                {
                    data: 'remind_date',
                    name: 'remind_date'
                },
                {
                    data: 'term',
                    name: 'term'
                },
                {
                    data: 'action',
                    name: 'action',
                    width: '20%',
                    mRender: function (data, type, full) {
                        return '<a style="margin:2px;" class="cls3" onclick="deleteReminder(' + full.id + ',' + full.rowIndex + ')" href="#"><i class="fa fa-close"></i></a>';
                    }
                }
            ]
        });
        $('#reminderList ').after(html);
        $('.nav-tabs a[href="#listR"]').tab('show');
    }
    function gerReminder2(id) {
        var obj = {};
        obj.event_id = id;
        obj.event_id = id;
        var html = '';
        html += '<input name="mode" type="hidden" value="noChange"/>';
        html += '<input name="delReminder" type="hidden" value=""/>';
        $('#reminderList2').DataTable().ajax.reload();
    }
    /*#####################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*----------deletev old register reminderrs in reminder list ----------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function deleteReminder(rec_id, index) {
        if ($('#add_reminder_dialog').is(':visible')) {
            var table = $('#reminderList2').DataTable();
            var tbl_id = reminderList2;
        }
        else {
            var table = $('#reminderList').DataTable();
            var tbl_id = reminderList;
        }
        var obj = {};
        obj.delReminder = rec_id;
        confirmModal({
            title: 'حذف یادآور',
            message: '{{trans("calendar_events.ce_delete_title1")}}{{trans("calendar_events.ce_delete_title2")}}',
            onConfirm: function () {
                $.ajax({
                    url: '{{ URL::route('hamahang.calendar_events.delete_reminder')}}',
                    type: 'POST', // Send post dat
                    data: obj,
                    async: false,
                    success: function (s) {
                        if ($('#add_reminder_dialog').is(':visible')) {
                            $('#reminderList2').DataTable().ajax.reload();
                        }
                        else {
                            $('#reminderList').DataTable().ajax.reload();
                        }
                    }
                });
            },
            afterConfirm: 'close'
        });
    }
    /*#####################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*-----------------------------opencalendar modal settings---------------------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function showSettingModal() {
        $('#modal_calendar_setting').modal({show: true});
    }
    /*#################################################################################################*/
    /*------------------------------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------*/
    function calendarGridRelaod() {

        $('#personalCalendarGrid').DataTable().ajax.reload();
    }
    /*#################################################################################################*/
    /*------------------------------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------*/
    function closeMsgBox(el) {
        $(el).parent().parent().html('');
    }
</script>
