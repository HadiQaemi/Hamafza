<script>
    $(document).ready(function () {
        $("#add_seesion_dialog").on('hidden.bs.modal', function () {
            $("#form-event-content").css('display', 'block');
        });
        $("#add_invitation_dialog").on('hidden.bs.modal', function () {
            $("#f#form-user-event-invitation").css('display', 'block');
        });
        $("#new_reminder_dialog").on('hidden.bs.modal', function () {
            $("#form-reminder-content").css('display', 'block');
        });
        $('.close-box-btn').click(function () {
            // alert("fffff");
            el = $(this).parent().parent();
            $(el).empty();
        });
        $(".DatePicker").persianDatepicker({
            autoClose: true,
            format: 'YYYY-MM-DD'

        });
        $(".DatePicker").val('');
        $(".TimePicker").persianDatepicker({
            format: "HH:mm",
            timePicker: {
                //showSeconds: false,
            },
            onlyTimePicker: true
        });
        $(".TimePicker").val('');
        $('input[name="allDay"]').click(function () {
            if ($('input[name="allDay"]').is(':checked')) {
                $('input[name="starttime"]').val('');
                $('input[name="endtime"]').val('');
            }
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
        /*----------------------------------------------------------------------------------------*/
        /*------------------------------------- show event modal ---------------------------------*/
        /*----------------------------------------------------------------------------------------*/
        $('#userEventModal').click(function () {
            $('#errMSg').html('');
            //$('#add_event_dialog .modal-title span:first-child').html('رویداد جدید');
            //$('#add_event_dialog').modal('show');
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
                    }
                }
            });
            newEventModal.content.html('<div class="loader"></div>');
            /*  $.ajax({
             url:'{{ URL::route('hamahang.calendar_events.new_event_modal' )}}',
             type:'post',
             dataType:'json',
             success :function(data)
             {
             //console.log(data);
             newEventModal = $.jsPanel({
             position: {my: "center-top", at: "center-top", offsetY: 15},
             contentSize: {width: 800, height: 300},
             headerTitle: data.header,
             content :data.content,
             footerToolbar:data.footer
             });
             }
             });*/
        });
        /*########################################################################################*/
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------save event ( in user evemnt modal)-------------------*/
        /*----------------------------------------------------------------------------------------*/
        $('#saveEvent').click(function () {
            var saveObj = {};
            $.ajax({
                url: '{{ URL::route('ugc.desktop.hamahang.calendar.user_calendar',['uname'=>$uname] )}}',
                type: 'GET', // Send post dat
                async: false,
                success: function (s) {
                    s = JSON.parse(s);
                    var options = '';
                    for (var i = 0; i < s.length; i++) {
                        if (s[i].is_default == 1) {
                            options += '<option  selected=true value="' + s[i].id + '">' + s[i].title + '</option>';
                        }
                        else {
                            options += '<option value="' + s[i].id + '">' + s[i].title + '</option>';
                        }
                    }
                    $(document).on('select[name="cid"]').append(options);
                    $('select[name="cid"]').select2({
                        dir: "rtl",
                        width: '100%'
                    });
                }
            });
            //console.log(saveObj);
            if ($('select[name="cid"]').length) {
                var res = saveEvent('form-event', 'errMSg');
            }
            // console.log(res);
            if (res.success == false) {
                var ul = document.createElement('ul');
            } else {
                if (res.mode == 'edit') {
                    reloadGrid();
                }
                // $('#add_event_dialog').modal('hide');
                $('#errMSg').empty();
                successFunc('ذخیره', {0: '{{trans("calendar_events.ce_saved_msg")}}'}, {id: 'MsgBox'});
                newEventModal.close();
            }
        });
        /*########################################################################################*/
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------save in session modal--------------------------------*/
        /*----------------------------------------------------------------------------------------*/
        $('#sessionEventSave').click(function () {
           // $('#add_seesion_dialog .modal-title span:first-child').html('جلسه جدید');
           // $('#form-session-content').hide();
            //$('#add_seesion_dialog').modal('show');
            //$('#sessionForm').trigger('reset');
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
                    }
                }
            });
            sessionModal.content.html('<div class="loader"></div>');
        });
        /*########################################################################################*/
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------show session view-----------------------------------*/
        /*----------------------------------------------------------------------------------------*/
        $('#sessionEventSave').click(function () {
            // $('#form-session-content').hide();
            //initialize_map();
        });
        /*########################################################################################*/
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------save  event of session modal------------------------*/
        /*----------------------------------------------------------------------------------------*/
        $(document).on('click', '#saveSessionUserEvent', function () {
            var result = saveEvent('sessionForm', 'sessionMsgBox');
            if (result.success == true) {
                if (result.mode == 'edit') {
                    var modal_btn = [
                        {
                            item: '<div >' +
                            '<button type="button" name="saveSession" id="saveSession" value="save"' +
                            'class="btn btn-warning"' +
                            'type="button">' +
                            '<i class="glyphicon  glyphicon-save-file bigger-125"></i>' +
                            '<span>{{trans('app.edit')}}</span>' +
                            '</button>' +
                            '</div>'
                        }
                    ];
                } else{
                    var modal_btn = [
                        {
                            item: '<div >' +
                            '<button type="button" name="saveSession" id="saveSession" value="save"' +
                            'class="btn btn-info"' +
                            'type="button">' +
                            '<i class="glyphicon  glyphicon-save-file bigger-125"></i>' +
                            '<span>{{trans('app.save')}}</span>' +
                            '</button>' +
                            '</div>'
                        }
                    ];
                }
                $('#saveSessionUserEvent').remove();
                sessionModal.toolbarAdd("footer", modal_btn);
                navigationWizard();
                $('#sessionMsgBox').html('');
                if (result.mode == 'edit') {
                    //console.log('kkkkkkkkkkkkkkk');
                    var obj = {};
                    obj.event_id = result.event_id;
                    $.ajax({
                        url: '{{ URL::route('hamahang.calendar_events.session_data' )}}',
                        type: 'POST', // Send post dat
                        data: obj,
                        async: false,
                        success: function (s) {
                            res = JSON.parse(s);
                            $('#agenda').val(res.agenda);
                            for (var i = 0; i < res.invitees.length; i++) {
                                if (res.invitees[i].user_type == 1) {
                                    $('select[name="session_voting_users[]"]').select2("trigger", "select", {
                                        data: {id: res.invitees[i].id.toString(), text: res.invitees[i].text}
                                    });
                                } else if (res.invitees[i].user_type == 2) {
                                    $('select[name="session_notvoting_users[]"]').select2("trigger", "select", {
                                        data: {id: res.invitees[i].id.toString(), text: res.invitees[i].text}
                                    });
                                }
                            }
                            if (res.chief != null) {
                                $('select[name="session_chief"]').select2("trigger", "select", {
                                    data: {id: res.chief.id.toString(), text: res.chief.Name + ' ' + res.chief.Family}
                                });
                            }
                            if (res.secretary != null) {
                                $('select[name="session_secretary"]').select2("trigger", "select", {
                                    data: {id: res.secretary.id.toString(), text: res.secretary.Name + ' ' + res.secretary.Family}
                                });
                            }
                            if (res.facilitator != null) {
                                $('select[name="session_facilitator"]').select2("trigger", "select", {
                                    data: {id: res.facilitator.id.toString(), text: res.facilitator.Name + ' ' + res.facilitator.Family}
                                });
                            }
                            $('input[name="term"]').val(res.term);
                            $('textarea[name="location"]').val(res.location);
                            $('input[name="location_phone"]').val(res.location_phone);
                            $('input[name="coordination_phone"]').val(res.coordination_phone);
                            $('input[name="long"]').val(res.long);
                            $('input[name="lat"]').val(res.lat);
                            if (res.send_Invitation) {
                                $('input[type="checkbox"][name="send_Invitation"]').attr('checked', true)
                            }
                            if (res.create_session_page) {
                                $('input[type="checkbox"][name="create_session_page"]').attr('checked', true)
                            }
                            if (res.allow_inform_invitees) {
                                $('input[type="checkbox"][name="allow_inform_invitees"]').attr('checked', true)
                            }
                            $(' input[type="radio"][name="session_type"][value="' + res.type + '"]').prop('checked', true);
                            $('textarea[name="location"]').append('<input type="hidden" name="event_id" value="' + res.event_id + '">');
                            $('textarea[name="location"]').append('<input type="hidden" name="mode" value="edit">');
                        }
                    });
                    $('#sessionFilesGrid').DataTable({
                        "dom": window.CommonDom_DataTables,
                        "language": LangJson_DataTables,
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{!! route('hamahang.calendar_events.file_list' )!!}',
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
                                data: 'originalName',
                                name: 'originalName',
                                width: '30%'
                            },
                            {
                                data: 'extension',
                                name: 'extension',
                                width: '20%'
                            },
                            {
                                data: 'size',
                                name: 'size',
                                width: '20%'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false,
                                width: '10%',
                                mRender: function (data, type, full) {
                                    // console.log(full);
                                    return '' +
                                        '<a class="cls3"   alt="حذف" title="حذف" style="margin: 2px" onclick="deleteEvent(' + full.id + ')" href="#">' +
                                        '   <i class="fa fa-close"></i>' +
                                        '</a>' +
                                        '<a class="cls3" target="_self" style="margin: 2px"  href="{{ route('FileManager.DownloadFile',['type'=> 'ID','id'=>'']) }}' + full.ID_N + '">'+
                                        '   <i ></i>'+
                                        '</a>';
                                }
                            }
                        ]
                    });
                }
                $('#form-event-content').hide();
                $('#form-session-content').show();
            }
        });
        /*########################################################################################*/
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------save session value ---------------------------------------*/
        /*----------------------------------------------------------------------------------------*/
        $(document).on('click', '#saveSession', function () {
            sessionObj = {};
            AjaxLoading('form-session-content', 1);
            sessionObj.hagenda = $('#agenda').val();
            sessionObj.session_chief = $('#form-session-content select[name="session_chief"]').select().val();
            sessionObj.session_secretary = $('#form-session-content select[name="session_secretary"]').select().val();
            sessionObj.session_facilitator = $('#form-session-content select[name="session_facilitator"]').select().val();
            sessionObj.session_voting_users = $('#form-session-content select[name="session_voting_users[]"]').select().val().toString();
            sessionObj.session_voting_users = $('#form-session-content select[name="session_voting_users[]"]').select().val().toString();
            sessionObj.session_notvoting_users = $('#form-session-content select[name="session_notvoting_users[]"]').select().val().toString();
            sessionObj.term = $('#form-session-content input[name="term"]').val();
            sessionObj.hlocation = $('#form-session-content textarea[name="location"]').val();
            sessionObj.long = $('#form-session-content input[name="long"]').val();
            sessionObj.lat = $('#form-session-content input[name="lat"]').val();
            sessionObj.type = $('#form-session-content input[name="session_type"]:checked').val();
            sessionObj.location_phone = $('#form-session-content input[name="location_phone"]').val();
            sessionObj.coordination_phone = $('#form-session-content input[name="coordination_phone"]').val();
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
                    AjaxLoading('saveSession', 0);
                    if (s.success == false) {
                        AjaxLoading('form-session-content', 0);
                        $('#sessionMsgBox').empty();
                        errorsFunc('{{trans("calendar_events.ce_error_label")}}', s.error, {id: 'sessionMsgBox'}, 'form-session-content');
                        // $('#sessionMsgBox').html(warning);
                    } else {
                        // if(s.mode =='edit')
                        // {
                        reloadGrid();
                        // }
                        sessionModal.close();
                        $('#add_seesion_dialog').modal('hide');
                        successFunc('ذخیره', {0: '{{trans("calendar_events.ce_saved_msg")}}'}, {id: 'MsgBox'});
                    }
                }
            });
        });
        /*########################################################################################*/
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------show invitation modal ---------------------------------------*/
        /*----------------------------------------------------------------------------------------*/
        $('#invitationEventSave').click(function () {
            //$('#add_invitation_dialog .modal-title span:first-child').html('دعوت نامه جدید');
            //$('#add_invitation_dialog').modal('show');
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
                        $('#form-invitation-content').hide();
                        $('#invitation_errorMsg').html('');
                        $('#invitation_form').trigger('reset');
                    }
                }
            });
            invitationModal.content.html('<div class="loader"></div>');
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
        });
        /*########################################################################################*/
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------ave event of invitatioon modal-----------------------*/
        /*----------------------------------------------------------------------------------------*/
        $(document).on('click', '#saveInvitationUserEvent', function () {
            var result = saveEvent('invitation_form', 'invitation_errorMsg');
            if (result.success == true) {
                $('#saveInvitationUserEvent').remove();
                if (result.mode == 'edit') {
                    var modal_btn = [
                        {
                            item: '' +
                            '<div >' +
                            '   <button type="button" name="saveInvitation" id="saveInvitation" value="save" class="btn btn-warning" type="button">' +
                            '       <i class="glyphicon  glyphicon-save-file bigger-125"></i>' +
                            '       <span>{{trans('app.edit')}}</span>' +
                            '   </button>' +
                            '</div>'
                        }
                    ];
                }else {
                    var modal_btn = [
                        {
                            item: '' +
                            '<div >' +
                            '   <button type="button" name="saveInvitation" id="saveInvitation" value="save" class="btn btn-info" type="button">' +
                            '       <i class="glyphicon  glyphicon-save-file bigger-125"></i>' +
                            '       <span>{{trans('app.save')}}</span>' +
                            '   </button>' +
                            '</div>'
                        }
                    ];
                }
                invitationModal.toolbarAdd("footer", modal_btn);
                navigationWizard();
                $('#invitation_errorMsg').html('');
                if (result.mode == 'edit') {
                    var obj = {};
                    obj.event_id = result.event_id;
                    $.ajax({
                        url: '{{ URL::route('hamahang.calendar_events.invitation_data')}}',
                        type: 'POST', // Send post dat
                        data: obj,
                        async: false,
                        success: function (s) {
                            res = JSON.parse(s);
                            $('#invitation_form input[name="about"]').val(res.about);
                            $('#invitation_form  input[name="term"]').val(res.term);
                            $('#invitation_form  textarea[name="location"]').val(res.location);
                            $('input[name="long"]').val(res.long);
                            $('input[name="latt"]').val(res.lat);
                            //console.log(res.type);
                            $('#invitation_form  input[name="invitation_type"][value="' + res.type + '"').prop('checked', true);
                            if (res.allow_inform_invitees == 1) {
                                $('input[type="checkbox"][name="allow_inform_invitees"]').prop('checked', true);
                            }
                            var option = new Array();
                            // console.log(res.invitees);
                            for (var i = 0; i < res.invitees.length; i++) {
                                option[i] = '<option selected="true value="' + res.invitees[i].id + '">' + res.invitees[i].text + '</option>';
                            }
                            $("select[name='invitationusers[]']").append(option);
                            $('textarea[name="location"]').append('<input type="hidden" name="event_id" value="' + res.event_id + '">');
                            $('textarea[name="location"]').append('<input type="hidden" name="mode" value="edit">');
                        }
                    });
                }
                $('#form-user-event-invitation').hide();
                $('#form-invitation-content').show();
                $("select[name='invitationusers[]']").select2({
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
            }
        });
        /*########################################################################################*/
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------save invitation value-------------------------------*/
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
                invitationObj.mode = 'edit';
            }
            if ($('input[type="checkbox"][name="allow_inform_invitees"]').is(':checked')) {
                invitationObj.allow_inform_invitees = 1;
            }
            else {
                invitationObj.allow_inform_invitees = 0;
            }
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
                        errorsFunc('{{trans("calendar_events.ce_error_label")}}', s.error, {id: 'invitation_errorMsg'}, 'form-invitation-content');
                        //$('#invitation_errorMsg').html(warning);
                    } else {
                        if (s.mode == 'edit') {
                            reloadGrid();
                        }
                        // $('#add_invitation_dialog').modal('hide');
                        successFunc('ذخیره', {0: '{{trans("calendar_events.ce_saved_msg")}}'}, {id: 'MsgBox'});
                        //$('#MsgBox').html(html);
                        if ($('#invitationGrid').length) {
                            alert('invitationgrid');
                            $('#invitationGrid').DataTable().ajax.reload();
                        }
                        invitationModal.close();
                    }
                }
            });
        });
        /*########################################################################################*/
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------show reminder miodal ---------------------------------------*/
        /*----------------------------------------------------------------------------------------*/
        $('#newReminder').click(function () {
            //$('#new_reminder_dialog .modal-title span:first-child').html('{{trans("calendar_events.ce_newreminder_label")}}');
            //$('.reminder_errorMsg').html('');
            //$('#new_reminder_dialog').modal('show');
            //$('#reminder_form').trigger('reset');
            reminderModdal = $.jsPanel({
                position: {my: "center-top", at: "center-top", offsetY: 15},
                contentSize: {width: 900, height: 400},
                contentAjax: {
                    url: '{{ URL::route('hamahang.calendar_events.reminder_modal' )}}',
                    method: 'POST',
                    dataType: 'json',
                    data : 'mode=reminder',
                    done: function (data, textStatus, jqXHR, panel) {
                        this.headerTitle(data.header);
                        this.content.html(data.content);
                        this.toolbarAdd('footer', [{item: data.footer}]);
                        $('#form-reminder-content').hide();
                    }
                }
            });
            reminderModdal.content.html('<div class="loader"></div>');
        });
        /*########################################################################################*/
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------save event od reminder modal---------------------------------------*/
        /*----------------------------------------------------------------------------------------*/
        $(document).on('click', '#saveReminderUserEvent', function () {
            var result = saveEvent('reminder_form', 'reminder_errorMsg');
            $('.form-reminder-content input[name="event_id"]').val(result.event_id);
            if (result.success == true) {
                $('#saveReminderUserEvent').remove();
                navigationWizard();
                $('.reminder_errorMsg').html('');
                if (result.mode == 'edit') {
                    var obj = {};
                    obj.event_id = result.event_id;
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
                }
                $('#form-user-event-reminder').hide();
                $('#form-reminder-content').show();
            }
        });
        /*########################################################################################*/
        /*----------------------------------------------------------------------------------------*/
        /*-------------------------------------save remiindeer ------------------------------------*/
        /*----------------------------------------------------------------------------------------*/
        $('input[type="checkbox"][name="allDay"]').click(function () {
            //console.log($('input[type="checkbox"][name="allDay"]').is(':checked'));
            if ($('input[type="checkbox"][name="allDay"]').is(':checked')) {
                $('input[name="starttime"]').prop('disabled', true);
                $('input[name="endtime"]').prop('disabled', true);
            }
            else {
                $('input[name="starttime"]').prop('disabled', false);
                $('input[name="endtime"]').prop('disabled', false);
            }
        });
    });
</script>