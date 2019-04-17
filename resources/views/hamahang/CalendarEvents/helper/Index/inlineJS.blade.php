@include('hamahang.CalendarEvents.helper.Index.inlineJS.document_ready')
@include('hamahang.CalendarEvents.helper.Index.inlineJS.events_grid')
<script>
    var newEventModal = '';
    var sessionModal = '';
    var invitationModal = '';
    var reminderModdal = '';
    var addReminderModal = '';
    var reminderList = '';
    /*-------------------------------------------------------------------------------------*/
    /*------------------------------Message Modal function --------------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function showMsgModal(title, msg) {

        $('#modal_msgBox .modal-title').html('');
        $('#modal_msgBox #modal_massage').html('');
        if (title != '') {
            $('#modal_msgBox .modal-title').html(title);
        }
        $('#modal_msgBox #modal_massage').html(msg);
        $('#modal_msgBox').modal({show: true});

    }
    /*########################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*------------------------------save event  from all modal by form_id -------------------*/
    /*-------------------------------------------------------------------------------------*/
    function saveEvent(form_id, errorMsg_id) {
        AjaxLoading(form_id, 1);
        var saveObj = {};
        //// console.log('#' + form_id + ' select[name="cid"]');
        // console.log($('#form-event select[name="cid"]').select().val());
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
        var res = '';
        $.ajax({
            url: '{{ URL::route('hamahang.calendar_events.save_user_event')}}',
            type: 'POST', // Send post dat
            data: saveObj,
            async: false,
            success: function (s) {
                res = JSON.parse(s);
                AjaxLoading(form_id, 0);
                if (res.success == false) {


                    /*   var warning = '<div class="alert alert-danger" role="alert">' +
                     '<div class=" close-box-btn" onclick="closeMsgBox(this);"><i class=" pull-left fa fa-window-close"></i></div>'+
                     '<div>'       +
                     '<strong st></strong> ' + errMsg +
                     '</div></div>';*/
                    $('#' + errorMsg_id).empty();
                    // console.log(res.error);
                    errorsFunc('{{trans('calendar_events.ce_error_label')}}', res.error, {id: errorMsg_id}, form_id);
                    //$('#' + errorMsg_id).html(warning);
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
    /*#####################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*-----------------------------clone the first type of reminder-------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function addFirstType(el) {

        saveReminders();
        $('.saveReminder').trigger('click');
        id = $('.form-reminder-content input[name="event_id"]').val();
        gerReminder(id);
        $('.nav-tabs a[href="#listR"]').tab('show');


    }
    /*#####################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*-----------------------------clone the first type of reminder--------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function addFirstType2(el) {
        saveReminders();
        id = $('.form-reminder-content input[name="event_id"]').val();
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
        id = $('.form-reminder-content input[name="event_id"]').val();
        gerReminder(id);
        $('.nav-tabs a[href="#listR"]').tab('show');

    }
    /*#####################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*-----------------------------add second type-----------------------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function addSecondType2(el) {
        saveReminders();
        id = $('.form-reminder-content input[name="event_id"]').val();
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
    /*----------deletev old register reminderrs in reminder list ----------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function deleteReminder(rec_id, index) {
        obj = {};
        obj.delReminder = rec_id;
        /*  msg = '{{trans("calendar_events.ce_delete_title1")}}{{trans("calendar_events.ce_delete_title2")}}';
         $('#remove_confirm_modal #modal_massage').html(msg);
         $('#remove_confirm_modal').modal({show: true});
         $('.yes_no_btn').click(function () {
         if ($(this).val() == 'yes') {

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
                        $('#remove_confirm_modal').modal('hide');

         }
         });
         }
         });*/
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
                        if ($('#reminderList2').is(':visible')) {
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
    /*-------------------------------delete even in grid ------------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function deleteEvent(id) {
        //  var answer = confirm('آیا از حذف این رکورد اطمینان دارید؟ ');

        var obj = {};
        obj.rec_id = id;
        if ($('#gridDtataTable').length) {
            var table = $('#gridDtataTable').DataTable();

            $('#gridDtataTable tbody').on('click', 'tr', function () {
                var data = table.row(this).data();
                // console.log(data.title);
                msg = '{{trans("calendar_events.ce_delete_title1")}}' + data.title + ' {{trans("calendar_events.ce_delete_title2")}} ';
                //   $('#remove_confirm_modal #modal_massage').html(msg);
                confirmModal({
                    title: 'حذف رویداد',
                    message: msg,
                    onConfirm: function () {
                        alert('asdasdasd');
                        $.ajax({
                            url: '{{ URL::route('hamahang.calendar_events.delete_event')}}',
                            type: 'POST', // Send post dat
                            data: obj,
                            async: false,
                            success: function (s) {
                                res = JSON.parse(s);
                                if (res.success == false) {
                                    /*  var html = '<div class="alert alert-warning">' +
                                     '<strong></strong> {{trans("calendar_events.ce_inlinejs_cant_delete_msg")}} ' +
                                     '</div>';*/

                                    //  showMsgModal(, html);
                                    messageModal('error', '{{trans("calendar_events.ce_inlinejs_remove_event_label")}}', '{{trans("calendar_events.ce_inlinejs_cant_delete_msg")}}');

                                }
                                else {
                                    /*var html = '<div class="alert alert-success">' +
                                     '<strong></strong> {{trans("calendar_events.ce_inlinejs_this_record_deleted")}}' +
                                     '</div>';*/
                                    //showMsgModal('{{trans("calendar_events.ce_inlinejs_remove_event_label")}}', html);
                                    reloadGrid();
                                    messageModal('success', '{{trans("calendar_events.ce_inlinejs_remove_event_label")}}', {0: '{{trans("calendar_events.ce_inlinejs_this_record_deleted")}}'});
                                    // $('#remove_confirm_modal').modal('hide');
                                    //$('#remove_confirm_modal').modal('hide');
                                }
                            }

                        });
                    },
                    afterConfirm: 'close'
                });

            });
        }


        if ($('#sessionsGrid').length) {
            table = $('#sessionsGrid').DataTable();
            $('#sessionsGrid tbody').on('click', 'tr', function () {
                var data = table.row(this).data();


                confirmModal({
                    title: 'حذف رویداد',
                    message: '{{trans("calendar_events.ce_delete_title1")}}' + data.agenda + ' {{trans("calendar_events.ce_delete_title2")}} ',
                    onConfirm: function () {
                        $.ajax({
                            url: '{{ URL::route('hamahang.calendar_events.delete_event')}}',
                            type: 'POST', // Send post dat
                            data: obj,
                            async: false,
                            success: function (s) {
                                res = JSON.parse(s);
                                if (res.success == false) {
                                    /*  var html = '<div class="alert alert-warning">' +
                                     '<strong></strong> {{trans("calendar_events.ce_inlinejs_cant_delete_msg")}} ' +
                                     '</div>';*/

                                    //  showMsgModal(, html);
                                    messageModal('error', '{{trans("calendar_events.ce_inlinejs_remove_event_label")}}', '{{trans("calendar_events.ce_inlinejs_cant_delete_msg")}}');

                                }
                                else {
                                    /*var html = '<div class="alert alert-success">' +
                                     '<strong></strong> {{trans("calendar_events.ce_inlinejs_this_record_deleted")}}' +
                                     '</div>';*/
                                    //showMsgModal('{{trans("calendar_events.ce_inlinejs_remove_event_label")}}', html);
                                    // reloadGrid();
                                    table.ajax.reload();
                                    {{--messageModal('success', '{{trans("calendar_events.ce_inlinejs_remove_event_label")}}', {0: '{{trans("calendar_events.ce_inlinejs_this_record_deleted")}}'});--}}
                                    // $('#remove_confirm_modal').modal('hide');
                                    //$('#remove_confirm_modal').modal('hide');
                                }
                            }

                        });
                    },
                    afterConfirm: 'close'
                });

            });
        }


    }
    /*#####################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*--------------------------------add reminder from event grid -------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function addReminder(id) {
        var obj = {};
        obj.id = id;
        $.ajax({
            url: '{{ URL::route('hamahang.calendar_events.get_info_to_reminder')}}',
            type: 'POST', // Send post dat
            data: obj,
            async: false,
            success: function (s) {
                res = JSON.parse(s);
                addReminderModal = $.jsPanel({
                    position: {my: "center-top", at: "center-top", offsetY: 15},
                    contentSize: {width: 900, height: 400},
                    contentAjax: {
                        url: '{{ URL::route('hamahang.calendar_events.add_reminder_modal' )}}',
                        method: 'POST',
                        dataType: 'json',
                        done: function (data, textStatus, jqXHR, panel) {
                            this.headerTitle(data.header);
                            this.content.html(data.content);
                            this.toolbarAdd('footer', [{item: data.footer}]);
                            $('#form-reminder-content').hide();
                            $('.reminder_add_title div:nth-child(1)').html('');
                            $('.reminder_add_title div:nth-child(1)').html(res.title);
                            $('.reminder_add_title div:nth-child(2)').html('');
                            $('.reminder_add_title div:nth-child(2)').html(res.titleStr);
                            $('.reminder_add_title div:nth-child(4)').html('');
                            $('.reminder_add_title div:nth-child(4)').html(res.titleTerm);
                            var html = '<input type="hidden" name="event_id" value="' + id + '"/>';
                            $('.form-reminder-content').append(html);
                            var html = '';
                            html += '<input name="mode" type="hidden" value="noChange"/>';
                            html += '<input name="delReminder" type="hidden" value=""/>';
                            $('#reminderList2').after(html);
                            var obj = {};
                            obj.event_id = id;


                            //$('#reminderList2').DataTable().ajax.reload();
                            $('#reminderList2').DataTable({
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
                                        name: 'remind_date',


                                    },
                                    {
                                        data: 'term',
                                        name: 'term',


                                    },
                                    {
                                        data: 'action',
                                        name: 'action',
                                        width: '20%',
                                        mRender: function (data, type, full) {
                                            return '<a style="margin:2px;" class="cls3" onclick="deleteReminder(' + full.id + ',' + full.rowIndex + ')" href="#"><i class="fa fa-close"></i></a>';
                                        }


                                    },

                                ]
                            });


                            $('.nav-tabs a[href="#listR2"]').tab('show')
                        }
                    }
                });
                addReminderModal.content.html('<div class="loader"></div>');
                //  $('#add_reminder_dialog').modal({show: true});

            }
        });


    }
    /*#####################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*--------------------------------edit event ---------------- -------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function editEvent(id, type=4) {
        var i = 0;
        switch (type) {
            case 0: {
                {{--form_id = 'form-event';--}}

                {{--//$('#add_event_dialog .modal-title span:first-child').html('{{trans("calendar_events.ce_inlinejs_event_edited")}}');--}}
                {{--// $('#add_event_dialog .modal-title span').empty();--}}
                {{--//   console.log(++i);--}}
                {{--//$('#add_event_dialog').modal('show');--}}

                        {{--//console.log(data);--}}
                        {{--newEventModal = $.jsPanel({--}}
                            {{--position: {my: "center-top", at: "center-top", offsetY: 15},--}}
                            {{--contentSize: {width: 800, height: 300},--}}
                            {{--contentAjax: {--}}
                                {{--url: '{{ URL::route('hamahang.calendar_events.new_event_modal' )}}',--}}
                                {{--method: 'POST',--}}
                                {{--dataType: 'json',--}}
                                {{--data :'mode=editEvent',--}}
                                {{--done: function (data, textStatus, jqXHR, panel) {--}}
                                    {{--console.log(data.content);--}}
                                    {{--this.headerTitle(data.header);--}}
                                    {{--this.content.html(data.content);--}}
                                    {{--this.toolbarAdd('footer', [{item: data.footer}]);--}}

                        {{--}--}}
                    {{--}--}}
                {{--});--}}
                {{--newEventModal.content.html('<div class="loader"></div>');--}}
                sessionModal = $.jsPanel({
                    position: {my: "center-top", at: "center-top", offsetY: 120},
                    contentSize: {width: 1000, height: 400},
                    contentAjax: {
                        url: '{{ URL::route('hamahang.calendar_events.reminder_modal' )}}',
                        method: 'POST',
                        dataType: 'json',
                        data: 'mode=editReminder&id=' + id,
                        done: function (data, textStatus, jqXHR, panel) {
                            this.headerTitle(data.header);
                            this.content.html(data.content);
                            this.toolbarAdd('footer', [{item: data.footer}]);
                            // $('#sessionForm input[name="event_type"]').val('session');
                            // $('#sessionForm input[name="startdate"]').val(startdate.join('-'));
                            // $('#sessionForm input[name="starttime"]').val(starttime);
                            // $('#sessionForm input[name="enddate"]').val(enddate.join('-'));
                            // $('#sessionForm input[name="endtime"]').val(endtime);
                            $('#sessionForm form').append('<input type="hidden" name="mode" value="'+id+'"/>');
                        }
                    }
                });


            }

                break;
            case 1: {
                form_id = 'form-event-content';

                //$('#add_seesion_dialog .modal-title span:first-child').html('{{trans("calendar_events.ce_inlinejs_session_edited")}}');
                //$('#add_seesion_dialog').modal('show');
                sessionModal = $.jsPanel({
                    position: {my: "center-top", at: "center-top", offsetY: 15},
                    contentSize: {width: 800, height: 400},
                    contentAjax: {
                        url: '{{ URL::route('hamahang.calendar_events.session_modal' )}}',
                        method: 'POST',
                        dataType: 'json',
                        data: 'mode=editSession',
                        done: function (data, textStatus, jqXHR, panel) {
                            this.headerTitle(data.header);
                            this.content.html(data.content);
                            this.toolbarAdd('footer', [{item: data.footer}]);
                        }
                    }
                });
                sessionModal.content.html('<div class="loader"></div>');

            }
                break;
            case 2: {

                form_id = 'invitation_form';
                //  $('#add_invitation_dialog .modal-title span:first-child').html('{{trans("calendar_events.ce_inlinejs_invitation_edited")}}');
                // $('#add_invitation_dialog').modal('show');

                $('#invitation_form').trigger('reset');
                invitationModal = $.jsPanel({
                    position: {my: "center-top", at: "center-top", offsetY: 15},
                    contentSize: {width: 900, height: 400},
                    contentAjax: {
                        url: '{{ URL::route('hamahang.calendar_events.invitation_modal' )}}',
                        method: 'POST',
                        dataType: 'json',
                        data: 'mode=editInvitation',
                        done: function (data, textStatus, jqXHR, panel) {
                            this.headerTitle(data.header);
                            this.content.html(data.content);
                            this.toolbarAdd('footer', [{item: data.footer}]);
                            $('#form-invitation-content').hide();
                        }
                    }
                });
                invitationModal.content.html('<div class="loader"></div>');

            }
                break;
            case 3: {
                form_id = 'reminder_form';
                $('#new_reminder_dialog .modal-title span:first-child').html('{{trans("calendar_events.ce_inlinejs_reminder_edited")}}');
                $('#new_reminder_dialog').modal('show');
                $('#reminder_form').trigger('reset');
                reminderModdal = $.jsPanel({
                    position: {my: "center-top", at: "center-top", offsetY: 15},
                    contentSize: {width: 900, height: 400},
                    contentAjax: {
                        url: '{{ URL::route('hamahang.calendar_events.reminder_modal' )}}',
                        method: 'POST',
                        dataType: 'json',
                        data: 'mode=editReminder',
                        done: function (data, textStatus, jqXHR, panel) {
                            this.headerTitle(data.header);
                            this.content.html(data.content);
                            this.toolbarAdd('footer', [{item: data.footer}]);
                            $('#form-reminder-content').hide();
                        }
                    }
                });
                reminderModdal.content.html('<div class="loader"></div>');

            }
                break;
            case 4: {
                sessionModal = $.jsPanel({
                    position: {my: "center-top", at: "center-top", offsetY: 120},
                    contentSize: {width: 1000, height: 400},
                    contentAjax: {
                        url: '{{ URL::route('hamahang.calendar_events.session_modal' )}}',
                        method: 'POST',
                        dataType: 'json',
                        data: 'mode=editSession&id=' + id,
                        done: function (data, textStatus, jqXHR, panel) {
                            this.headerTitle(data.header);
                            this.content.html(data.content);
                            this.toolbarAdd('footer', [{item: data.footer}]);
                            // $('#sessionForm input[name="event_type"]').val('session');
                            // $('#sessionForm input[name="startdate"]').val(startdate.join('-'));
                            // $('#sessionForm input[name="starttime"]').val(starttime);
                            // $('#sessionForm input[name="enddate"]').val(enddate.join('-'));
                            // $('#sessionForm input[name="endtime"]').val(endtime);
                            $('#sessionForm form').append('<input type="hidden" name="mode" value="'+id+'"/>');
                        }
                    }
                });

            }
                break;
        }
        {{--var obj = {};--}}
        {{--obj.id = id;--}}
        {{--$.ajax({--}}
            {{--url: '{{ URL::route('hamahang.calendar_events.event_data',['uname'=>$uname] )}}',--}}
            {{--type: 'POST', // Send post dat--}}
            {{--data: obj,--}}
            {{--success: function (s) {--}}
                {{--res = JSON.parse(s);--}}
                {{--//console.log('#' + form_id + ' input[name="title"]');--}}
                {{--$('#' + form_id + ' input[name="title"]').val(res.title);--}}
                {{--$('#' + form_id + ' select[name="cid"]').val(res.cid);--}}
                {{--$('#' + form_id + ' select[name="cid"]').trigger("updated");--}}
                {{--$('#' + form_id + ' input[name="startdate"]').val(res.startdate);--}}
                {{--$('#' + form_id + ' input[name="starttime"]').val(res.starttime);--}}
                {{--$('#' + form_id + ' input[name="enddate"]').val(res.enddate);--}}
                {{--$('#' + form_id + ' input[name="endtime"]').val(res.endtime);--}}
                {{--$('#' + form_id + ' textarea[name="descriotion"]').val(res.descriotion);--}}
                {{--$('.jsPanel-title').append(': ' + res.title);--}}
                {{--if (res.allDay == 1) {--}}
                    {{--$('#' + form_id + ' input[type="checkbox"][name="allDay"]').prop('checked', true);--}}
                {{--}--}}
                {{--if ($('#' + form_id + ' input[name="event_id"]').length == 0) {--}}
                    {{--$('#' + form_id).append('<input type="hidden" name="event_id" value="' + res.id + '"/>');--}}
                    {{--$('#' + form_id).append('<input type="hidden" name="type" value="' + res.type + '"/>');--}}
                {{--}--}}
                {{--else {--}}
                    {{--$('#' + form_id + ' input[name="event_id"]').val(res.id);--}}
                {{--}--}}


            {{--}--}}
        {{--});--}}

    }
    /*#####################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*--------------------------------ereload event grid ---------------- -------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function reloadGrid() {
        $('#gridDtataTable').DataTable().ajax.reload();

    }
    /*#############################################################################################*/
    /*------------------------------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------*/
    function navigationWizard() {
        $('.nav-wizard li:nth-child(1)').removeClass('active');
        $('.nav-wizard li:nth-child(2)').addClass('active');

    }
    /*################################################################################################*/
    /*------------------------------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------*/
    function initialize_map() {
        // create the map

        var myOptions = {
            zoom: 14,
            center: new google.maps.LatLng(0.0, 0.0),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map_canvas"),
            myOptions);

    }
    /*################################################################################################*/
    /*------------------------------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------*/
    function gerReminder(id) {
        var obj = {};
        obj.event_id = id;
        obj.event_id = id;

        var html = '';
        html += '<input name="mode" type="hidden" value="noChange"/>';
        html += '<input name="delReminder" type="hidden" value=""/>';
        if (reminderList == '') {
            reminderList = $('#reminderList').DataTable({
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
                    url: '{{ URL::route('hamahang.calendar_events.reminder_data',['uname'=>$uname] )}}',
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
                        name: 'remind_date',


                    },
                    {
                        data: 'term',
                        name: 'term',


                    },
                    {
                        data: 'action',
                        name: 'action',
                        width: '20%',
                        mRender: function (data, type, full) {
                            return '<a style="margin:2px;" class="cls3" onclick="deleteReminder(' + full.id + ',' + full.rowIndex + ')" href="#"><i class="fa fa-close"></i></a>';
                        }


                    },

                ]
            });

            $('#reminderList ').after(html);
        } else {
            $('#reminderList').DataTable().ajax.reload();
        }

        $('.nav-tabs a[href="#listR"]').tab('show');

    }
    /*################################################################################################*/
    /*------------------------------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------*/
    function gerReminder2(id) {
        var obj = {};
        obj.event_id = id;
        obj.event_id = id;

        var html = '';
        html += '<input name="mode" type="hidden" value="noChange"/>';
        html += '<input name="delReminder" type="hidden" value=""/>';
        $('#reminderList2').DataTable().ajax.reload();

    }
    /*################################################################################################*/
    /*------------------------------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------*/
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
        reminderObj.hevent_id = $('.form-reminder-content input[name="event_id"]').val();

        if ($('input[name="mode"]').length) {
            reminderObj.mode = $('input[name="mode"]').val();
            reminderObj.delReminder = $('input[name="delReminder"]').val();
        }

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
                    // errorsFunc('{{trans('calendar_events.ce_error_label')}}',s.error,{id:'.reminder_errorMsg'},'reminder_form');


                } else {
                    if (s.mode == 'edit') {

                        reloadGrid();
                    }
                    //  $('#new_reminder_dialog').modal('hide');
                    //  successFunc('','{{trans("calendar_events.calendar_saved_success_msg")}}',{id:'MsgBox'});


                }
            }
        });
    }
    /*#################################################################################################*/
    /*------------------------------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------*/
    function AjaxLoading(id, state) {
        //alert('sssss');
        var txt = "<div id='DivLoading'  style='z-index: 99999;position: absolute;left: 0 ; top: 0;text-align: center;display: none; ;width: 100%;height: 100%;background-color: rgba(0,0,0,0.1);margin: auto;'><span class='fa fa-spin' style='position: absolute;top: 45%;left: 46.5%;color: cornflowerblue'><i class='fa fa-spinner fa-5x fa-fw fa-pulse'></i> </span></div>"
        if (state == 1) {
            if ($('#DivLoading').length == 0)
                $("#" + id).append(txt);
            $('#DivLoading').show();
        }
        if (state == 0)
            $('#DivLoading').hide();

    }
    /*#################################################################################################*/
    /*------------------------------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------*/
    function closeMsgBox(el) {
        $(el).parent().parent().html('');
    }

</script>
