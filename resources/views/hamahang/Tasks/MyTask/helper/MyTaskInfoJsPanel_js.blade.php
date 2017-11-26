<script type="text/javascript" src="{{URL::asset('assets/Packages/select2/dist/js/select2.full.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/Packages/select2/dist/js/i18n/fa.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
<script type="application/javascript">
    function check_start_statements() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var sendInfo = {
            tid: current_id,
            to: 1
        };
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tasks.my_tasks.task_start') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {
                ShowErrorModal(data);
            }
        });
    }
    function refresh_follow_ups() {
        var sendInfo = {
            id: current_id
        };
        $.ajax({
            type: "POST",
            url: '{{ URL::route('hamahang.tasks.task_info') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {
                var follow_up = '';
                for (i = 0; i < data['follow_up'].length; i++) {
                    var clr = 'info';
                    var flt = 'left';
                    var writer_name = data['follow_up'][i][3];
                    var follow_up_date = data['follow_up'][i][1]['weekday']+'('+data['follow_up'][i][1]['year']+'/'+data['follow_up'][i][1]['mon']+'/'+data['follow_up'][i][1]['mday']+' '+data['follow_up'][i][1]['hours']+':'+data['follow_up'][i][1]['minutes']+')';
                    if (data['follow_up'][i][2] == 'me') {
                        clr = 'default';
                        flt = 'right';
                        // writer_name='';
                    }
//                        follow_up += '<div class="panel panel-' + clr + '" style="width: 60%;float: ' + flt + ';">\
//                                        <div class="panel-heading"><span style="float: left;">' + data['follow_up'][i][1] + '</span> <span style="color: red;">' + writer_name +
//                                '</span></div>\
//                                        <div class="panel-body">' + data['follow_up'][i][0] + '</div>\
//                                    </div>';
                    follow_up += '<div class="message-item" id="m15">\
                                <div class="message-inner">\
                                <div class="message-head clearfix">\
                                <div class="avatar pull-left">\
                                <a href="./index.php?qa=user&qa_1=Oleg+Kolesnichenko"><img src="{{ URL::to('pics/user/') }}/' + data['follow_up'][i][5] + '"></a>\
                                </div>\
                                <div class="user-detail">\
                                <span class="qa-message-when-data">' + follow_up_date + '</span>\
                        <div class="post-meta">\
                                <div class="asker-meta">\
                                <span class="qa-message-what"></span>\
                                <span class="qa-message-when">\
                        </span><br/>\
                        <span class="qa-message-who">\
                                <span class="qa-message-who-pad">توسط </span>\
                                <span class="qa-message-who-data">' + writer_name + ' ' + data['follow_up'][i][4] + '</span>\
                        </span>\
                        </div>\
                        </div>\
                        </div>\
                        </div>\
                        <div class="qa-message-content"><h5 class="handle">' + data['follow_up'][i][0] + '</h5>\
                        </div>\
                        </div>\
                        </div>';
                }
                $('#desc12').val('');
                $('#follow_up_items').html(follow_up);
            }

        });

        $('#task_details').modal({show: true});


    }
    function do_action() {

        switch (current_tab) {
            case 0:
                var sendInfo = {
                    id: current_tab
                };

                $.ajax({
                    type: "POST",
                    url: '{{ URL::route('hamahang.tasks.task_info') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function (data) {

                        //console.log(data);

                    }
                });
                break;
            case 11:
                var sendInfo = {
                    id: current_tab
                };

                $.ajax({
                    type: "POST",
                    url: '{{ URL::route('hamahang.tasks.task_info') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function (data) {

                        // console.log(data);

                    }
                })
                break;
            case 1:
                var percent = 0;
                if ($('#percent').val() > 0 && $('#percent').val() <= 100)
                    percent = $('#percent').val();
                var sendInfo = {
                    id: current_tab,
                    tid: current_id,
                    sid: $('input[name=status]:checked').val(),
                    percent: percent,
                    keyw: $('#keywords').val()

                };

                $.ajax({
                    type: "POST",
                    url: '{{ URL::route('hamahang.tasks.my_tasks.change_action') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function (data) {
                        alert('ثبت شد');
                    }
                })
                break;
            case 3:
                var sendInfo = {
                    id: current_tab,
                    ass_id: current_id,
                    text: $('#desc12').val()
                };

                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.tasks.my_tasks.new_follow_up') }}',
                    //dataType: "json",
                    data: sendInfo,
                    success: function (data) {

                        refresh_follow_ups();

                    }
                });

                break;


        }
    }
    $('.nav-tabs a').click(function (e) {
        current_tab = $($(this).attr('href')).index();
    });
    function RejectTask() {
        var obj = {};
        obj.id = current_id;
        obj.desc = $('#TaskRejectReason').val();
        confirmModal({
            title: '{{trans('tasks.reject')}}',
            message: '{{trans('tasks.reject_confirm')}}',
            onConfirm: function () {
                $.ajax({
                    url: '{!! route('hamahang.tasks.my_tasks.task_reject')!!}',
                    type: 'POST', // Send post dat
                    data: obj,
                    async: false,
                    success: function (s) {
                        res = JSON.parse(s);
                        if (res.success == true) {
                            messageModal('success', '{{trans('tasks.reject')}}', {0: '{{trans('tasks.reject_success')}}'});
                            location.reload();
                        }
                    }
                });
            },
            afterConfirm: 'close'
        });
    }
    function del(id) {
        confirm("Are you sure ?");
    }
    var t2_default;
    var current_tab = '';
    var current_id = '';
    $(document).ready(function () {
        window.table_chart_grid3 = $('#grid3').DataTable();
        $('#t2').html(t2_default);
        current_id = '{{ $task_id }}';
        var sendInfo = {
            id: current_id
        };
        var imm = 'فوری';
        var imp = 'مهم';
        $.ajax({
            type: "POST",
            url: '{{ URL::route('hamahang.tasks.task_info') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {
                $('#task_title_panel').val(data['title']);
                switch (data['status'][0]['type']) {
                    case 0:
                        $("#r1").attr('checked', 'checked');
                        $('#percent').val('');
                        break;
                    case 1:
                        $("#r2").attr('checked', 'checked');
                        $('#percent').val(data['status'][0]['percent']);
                        break;
                    case 2:
                        $("#r3").attr('checked', 'checked');
                        $('#percent').val(data['status'][0]['percent']);
                        break;
                    case 3:
                        $("#r4").attr('checked', 'checked');
                        $('#percent').val(data['status'][0]['percent']);
                        break;
                    case 4:
                        $("#r5").attr('checked', 'checked');
                        $('#percent').val(data['status'][0]['percent']);
                        break;
                }
                if(data['assigner_accept'] == 1)
                {
                    $('#r4').attr('disabled', true);
                    $('#label_r4').css('color', '#bbb');
                    $('#label_r5').css('color', '#bbb');
                }
                $('#duration_predicted').find("input,button,textarea,select").attr("disabled", "disabled");
                if (data['MyKw'].length > 0) {
                    var MyKw = '';
                    for (var i = 0; i < data['MyKw'].length; i++) {
                        $('#keywords').select2("trigger", "select", {
                            data: {id: data['MyKw'][i][0], text: data['MyKw'][i][1]}
                        });
                    }
                    $('#current_kw').html(MyKw);
                }
                if (data['task_packages'].length > 0) {
                    var task_package = '';
                    for (var i = 0; i < data['task_packages'].length; i++) {
                        $('#task_package').select2("trigger", "select", {
                            data: {id: data['task_packages'][i]['id'], text: data['task_packages'][i]['title']}
                        });
                    }
                }
                $('#respite_panel').val(data['respite_day']);

                $('#description').html(data['desc']);

                if (data['immediate'] == 0)
                    imm = 'غیرفوری';
                if (data['importance'] == 0)
                    imp = 'غیرمهم';
                $('#priority').html(imm + " و " + imp);
                if (data['type'] == 0) {
                    $('#task_type').html('رسمی');
                }
                else if (data['type'] == 1) {
                    $('#task_type').html('شخصی');
                }
                var i;
                var kw = '';
                var em = '';
                if (data['employee'].length == 0)
                    em = '<p class="btn btn-danger" style="margin-left: 5px">تعریف نشده</p>';
                for (i = 0; i < data['employee'].length; i++) {
                    em += '<p class="btn btn-default" style="margin-left: 5px"><img src="{{ URL::to('pics/user/') }}/' + data['employee'][i][1] + '" style="width:35px;height:30px"/>' + data['employee'][i][0]
                        + '</p>';
                }
                if (data['staff'].length > 0) {
                    for (i = 0; i < data['staff'].length; i++) {
                        em += '<p class="btn btn-default" style="margin-left: 5px">' + data['staff'][i] + '</p>';
                    }
                }
                $('#task_employee').html(em);

                var tr = '';
                if (data['transcript'].length == 0)
                    tr = '<p class="btn btn-danger" style="margin-left: 5px">تعریف نشده</p>';
                for (i = 0; i < data['transcript'].length; i++) {
                    tr += '<p class="btn btn-default" style="margin-left: 5px">' + data['transcript'][i] + '</p>';
                }
                $('#task_transcript').html(tr);
                var follow_up = '';
                for (i = 0; i < data['follow_up'].length; i++) {
                    console.log(data['follow_up']);
                    var clr = 'info';
                    var flt = 'left';
                    var writer_name = data['follow_up'][i][3];
                    var follow_up_date = data['follow_up'][i][1]['weekday']+'('+data['follow_up'][i][1]['year']+'/'+data['follow_up'][i][1]['mon']+'/'+data['follow_up'][i][1]['mday']+' '+data['follow_up'][i][1]['hours']+':'+data['follow_up'][i][1]['minutes']+')';
                    if (data['follow_up'][i][2] == 'me') {
                        clr = 'default';
                        flt = 'right';
                    }
                    follow_up += '<div class="message-item" id="m15">\
                                <div class="message-inner">\
                                <div class="message-head clearfix">\
                                <div class="avatar pull-left">\
                                <a href="./index.php?qa=user&qa_1=Oleg+Kolesnichenko"><img src="{{ URL::to('pics/user/') }}/' + data['follow_up'][i][5] + '"></a>\
                                </div>\
                                <div class="user-detail">\
                                <span class="qa-message-when-data">' + follow_up_date + '</span>\
                        <div class="post-meta">\
                                <div class="asker-meta">\
                                <span class="qa-message-what"></span>\
                                <span class="qa-message-when">\
                        </span><br/>\
                        <span class="qa-message-who">\
                                <span class="qa-message-who-pad">توسط </span>\
                                <span class="qa-message-who-data">' + writer_name + ' ' + data['follow_up'][i][4] + '</span>\
                        </span>\
                        </div>\
                        </div>\
                        </div>\
                        </div>\
                        <div class="qa-message-content"><h5 class="handle">' + data['follow_up'][i][0] + '</h5>\
                        </div>\
                        </div>\
                        </div>';
                }
                $('#follow_up_items').html(follow_up);

                switch (data['status'][0]) {
                    case 0:
                        $('#status').html('{{trans('tasks.status_not_started')}}');
                        break;
                    case 1:
                        $('#status').html('{{trans('tasks.status_started')}}');
                        break;
                    case 2:
                        $('#status').html('{{trans('tasks.status_done')}}');
                        break;
                    case 3:
                        $('#status').html('{{trans('tasks.status_finished')}}');
                        break;
                    case 4:
                        $('#status').html('متوقف');
                        $('#TaskAlert').html('متوقف شده');
                        $("#TransferTaskToOther").prop('disabled', true);
                        break;
                }
                if (data['transferable'] == 'on') {
                    $("#transfer").removeAttr('disabled');
                }
                else {
                    $('#transfer').attr('disabled', 'disabled');
                }
            }

        });

        var x = 0;
        var url = "{{URL::route('hamahang.tasks.my_assigned_tasks.show_task_files') }}";

        refreshFiles();
        $('#task_package').select2({
             width: '100%'
        });
        $("#keywords").select2({
            minimumInputLength: 1,
            tags: false,
            dir: "rtl",
            width: '100%',
            ajax: {
                url: "{{ route('auto_complete.keywords') }}",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
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
        $("#transferred_to_id").select2({
            minimumInputLength: 1,
            tags: false,
            dir: "rtl",
            width: '100%',
            ajax: {
                url: "{{ route('auto_complete.users') }}",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
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
    });
    function do_reject(res) {
        //var res = confirm('آیا از بازگردانی وظیفه اطمینان دارید ؟');
        if (res == true) {
            var descc = $('#reject_description').val();
            var sendInfo = {
                id: current_id,
                description: descc
            };
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.tasks.my_tasks.task_reject') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {

                    location.reload();

                }
            });
        }
        else {
            cancel_transfer();
        }
    };
    function do_reject_pre_step() {
        t2_default = $('#t2').html();
        var transfer_area = '<div class="col-md-12" style="background-color: grey;height: 300px;padding: 30px">\
                    <div>\
                     <textarea type="text" style="width: 550px;height: 100px;" id="reject_description"></textarea>\
                    </div>\
                    <div class="pull-left">\
                    <a class="btn btn-danger" id="cancel_transfer" onclick="cancel_transfer()">لغو</a>\
                    <a class="btn btn-info" id="do_transfer" onclick="call_modal(\'هشدار\',\'آیا برای انتقال این وظیفه مطمئن هستید ؟\',\'do_transfer\')">ثبت</a>\
                    </div>\
                    </div>';
        $('#t2').html(transfer_area);
    };
    function do_transfer_pre_step() {
        t2_default = $('#t2').html();
        var transfer_area = '<div class="col-md-12" style="background-color: grey;height: 300px;padding: 30px">\
                    <div>\
                     <select id="states-multi-select-users" name="users[]" class="col-xs-12" \
                     data-placeholder="{{trans('tasks.select_some_options')}}" multiple>\
                     <option value=""></option>\
                    </select>\
                    </div>\
                    <div class="pull-left">\
                    <a class="btn btn-danger" id="cancel_transfer" onclick="cancel_transfer()">لغو</a>\
                    <a class="btn btn-info" id="do_transfer" onclick="do_transfer()">ثبت</a>\
                    </div>\
                    </div>';
        $('#t2').html(transfer_area);
    };
    var r;
    function do_transfer(res) {
        //r = confirm('آیا برای انجام عملیات واگذاری مطمئن هستید ؟');
        if (res == 1) {
            var sendInfo = {
                id: current_id,
                ttid: $('#transferred_to_id').val(),
                ttDesc: $('#TaskTransferDescription').val()
            };
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.tasks.my_tasks.task_transfer') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {

                    close_modal();

                }
            });
        }
        else {
            cancel_transfer();
        }
    };
    function cancel_transfer() {
        $('#t2').html(t2_default);
    };
    function refreshFiles() {

        var url = "{{ route('hamahang.tasks.my_assigned_tasks.show_task_files') }}";

        window.table_chart_grid3.destroy();
        send_info = {
            t_id: current_id
        }
        setTimeout(function () {

            window.table_chart_grid3 = $('#grid3').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    "url": url,
                    "type": "POST",
                    "data": send_info
                },
                "autoWidth": false,
                "language": LangJson_DataTables,
                "processing": true,
                "serverside": true,
                columns: [
                    {"data": "id"},
                    {"data": "originalName"},
                    {"data": "extension"},
                    {"data": "size"},
//                        {"data": "cr", "width": "20%"},
                    {
                        "data": "ID_N",
                        "mRender": function (data, type, full) {
                            var id = full.id;
                            if (data == null)
                                data = 0;
                            return "<a class='cls3' target='_self' style='margin: 2px'  href='{{ route('FileManager.DownloadFile',['type'=> 'ID','id'=>'']) }}/" + full.ID_N + "'><i class='fa \
                        fa-download'></i></a>" ;

                        }
                    }
                ]
            });
        }, 100);
    }
</script>