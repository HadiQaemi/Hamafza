
<script type="text/javascript">
    $(document).ready(function () {
        $(".task_info_users").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            maximumSelectionLength: 1,
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
        $("#task_info_keywords").select2({
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
        current_tab = 0;
        //t2_default = '';
        window.table_chart_grid = $('#ChildsGrid').DataTable();
        window.table_chart_grid2 = $('#files_grid').DataTable({
            "dom": window.CommonDom_DataTables,
            "language": LangJson_DataTables
        });
        $('#progress').width(0);
        $('#progress_rext').html('بدون پیشرفت');
        //$('#t2').html(t2_default);
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
                console.log(data);
                $('#task_title').val(data['title']);
                $('#respite').val(data['respite_day']);
                $('#do_respite').html('مهلت انجام : ' + data['respite_day']);
                $('#panel_respite').val(data['respite_day']);
                $('#panel_task_title').val(data['title']);
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
                $('#task_info_keywords').val('');
                if (data['MyKw'].length == 0)
                    kw = '<p class="btn btn-default" style="margin-left: 5px">تعریف نشده</p>';
                for (i = 0; i < data['MyKw'].length; i++) {
                    $('#task_info_keywords').select2("trigger", "select", {
                        data: {id: 2, text: data['MyKw'][i][1]}
                    });
                    kw += '<p class="btn btn-default" style="margin-left: 5px">' + data['MyKw'][i][1] + '</p>';
                }
                $('#task_keywords').html(kw);
                $('#task_info_users').val('');
                var em = '';
                if (data['employee'].length == 0)
                    em = '<p class="btn btn-danger" style="margin-left: 5px">تعریف نشده</p>';
                for (i = 0; i < data['employee'].length; i++) {

                    $('#task_info_users').select2("trigger", "select", {

                        data: {id: data['employee'][i][2], text: data['employee'][i][0]}
                    });
                }
                if (data['staff'].length > 0) {
                    for (i = 0; i < data['staff'].length; i++) {
                        em += '<p class="btn btn-default" style="margin-left: 5px">' + data['staff'][i] + '</p>';
                    }
                }

                var tr = '';
                if (data['transcript'].length == 0)
                    tr = '<p class="btn btn-danger" style="margin-left: 5px">تعریف نشده</p>';

                for (i = 0; i < data['transcript'].length; i++) {
                    console.log(data['transcript'][i]);
                    $('#task_info_transcripts').select2("trigger", "select", {
                        data: {id: data['transcript'][i][1], text: data['transcript'][i][0]}
                    });
                    tr += '<p class="btn btn-default" style="margin-left: 5px">' + data['transcript'][i] + '</p>';
                }
                $('#task_transcript').html(tr);
                var follow_up = '';

                for (i = 0; i < data['follow_up'].length; i++) {
                    var clr = 'info';
                    var flt = 'left';
                    var writer_name = data['follow_up'][i][3];

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
                                <span class="qa-message-when-data">' + data['follow_up'][i][1]['year'] + '-' + data['follow_up'][i][1]['mon'] + '-' + data['follow_up'][i][1]['mday'] + '   ' + data['follow_up'][i][1]['hours'] + ':' + data['follow_up'][i][1]['minutes'] + ':' + data['follow_up'][i][1]['seconds'] + '</span>\
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

                RefreshStatusHistory(data['status']);

                if (data['quality'].length > 0)
                    switch (data['quality'][0]['quality_id']) {
                        case 0:
                            $('#q0').prop('checked', 'checked');
                            break;
                        case 1:
                            $('#q1').prop('checked', 'checked');
                            break;
                        case 2:
                            $('#q2').prop('checked', 'checked');
                            break;
                        case 3:
                            $('#q3').prop('checked', 'checked');
                            break;
                        case 4:
                            $('#q4').prop('checked', 'checked');
                            break;
                        case 5:
                            $('#q5').prop('checked', 'checked');
                            break;
                    }
                var q = '';
                var quality_h = '';
                if (data['quality'].length > 0)
                    for (i = 0; i < data['quality'].length; i++) {

                        switch (data['quality'][i]['quality_id']) {
                            case 0:
                                q = 'تعیین نشده';
                                break;
                            case 1:
                                q = 'عالی';
                                percent = data['status'][i]['percent']
                                break;
                            case 2:
                                q = 'خوب';
                                break;
                            case 3:
                                q = 'متوسط';
                                break;
                            case 4:
                                q = 'ضعیف';
                                break;
                            case 5:
                                q = 'بسیار ضعیف';
                                break;
                        }
                        quality_h += '<tr><td>' + q + '</td><td>' + data['quality'][i]['timestamp'] + '</td></tr>';
                    }
                $('#h2').html(quality_h);

                if (data['transferable'] == 'on') {
                    $("#transfer").removeAttr('disabled');
                }
                else {
                    $('#transfer').attr('disabled', 'disabled');
                }

                if (data['history'].length > 0) {
                    var x = 0;
                    var history = '';
                    var bg_color = '';
                    var event_title = '';
                    var event_content;
                    for (var i = 0; i < data['history'].length; i++) {
                        //alert('222');
                        switch (data['history'][i][0]) {
                            case 'create':
                                event_title = 'ایجاد';
                                event_content = 'توسط : ' + data['history'][i][10];
                                bg_color = 'lightblue';
                                break;
                            case 'status':
                                event_title = 'تغییر وضعیت';
                                event_content = 'وضعیت فعلی : ' + data['history'][i][7];
                                if (data['history'][i][9] == 1)
                                    event_content += '<br/>درصد پیشرفت فعلی : ' + data['history'][i][8];
                                bg_color = 'lightcyan';
                                break;
                            case 'reject':
                                event_title = 'بازگردانی';
                                bg_color = 'lightgreen';
                                event_content = '';
                                break;
                            case 'stop':
                                event_title = 'توقف';
                                bg_color = 'lightpink';
                                event_content = 'توسط : ' + data['history'][i][10];
                                break;
                            case 'transfer':
                                event_title = 'واگذاری';
                                event_content = 'انتقال دهنده : ' + data['history'][i][5] + '<br/> به :' + '<h6>' + data['history'][i][6] + '</h6>' + '<br/> علت :' + '<span>' +
                                    data['history'][i][4] + '</span>';
                                bg_color = 'yellow';
                                break;
                        }

                        if (x % 2 == 1) {
                            history += '<article class="timeline-entry">\
                                        <div class="timeline-entry-inner">\
                                    <time class="timeline-time" datetime="2014-01-10T03:45"><span>' + data['history'][i][1] + '</span><span>' + data['history'][i][2] + '</span></time>\
                            <div class="timeline-icon "  style="background-color: ' + bg_color + '">\
                                    <i class="entypo-feather"></i>\
                                    </div>\
                                    <div class="timeline-label" style="background-color: ' + bg_color + '">\
                                    <h2>' + event_title + '</h2>\
                            <p>' + event_content + '</p>\
                            </div>\
                            </div>\
                            </article>';
                            x++;
                        }
                        else if (x % 2 == 0) {
                            history += ' <article class="timeline-entry left-aligned">\
                                        <div class="timeline-entry-inner">\
                                        <time class="timeline-time" datetime=""><span>' + data['history'][i][1] + '</span><span>' + data['history'][i][2] + '</span><span></span></time>\
                            <div class="timeline-icon "  style="background-color: ' + bg_color + '">\
                                    <i class="entypo-suitcase"></i>\
                                    </div>\
                                    <div class="timeline-label" style="background-color: ' + bg_color + '">\
                                    <h2>' + event_title + '</h2>\
                            <p>' + event_content + '</p>\
                            </div>\
                            </div>\
                            </article>';
                            x++;
                        }
                    }
                    $('#Timeline').html(history);
                }
                else {
                    $('#Timeline').html('');
                }

                $('#progress').width(data['progress'] + "%");
                $('#progress_rext').html(data['progress'] + ' درصد');
            }

        });
        var x = 0;
        refreshChildsDatatable();
        refreshDraftFiles(id);
    })
    function refreshChildsDatatable() {

        var url = "{{ route('hamahang.tasks.my_assigned_tasks.fetch_task_childs_list',['id'=>'/' ]) }}" + "/" + current_id;

        window.table_chart_grid.destroy();

        setTimeout(function () {

            window.table_chart_grid = $('#ChildsGrid').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    "url": url,
                    "type": "POST"
                },
                "autoWidth": false,
                "language": LangJson_DataTables,
                "processing": true,
                columns: [
                    {"data": "id", "width": "5%"},
                    {"data": "title"},
                    {
                        "data": "weight",
                        "mRender": function (data, type, full) {
                            //console.log(data);
                            //console.log(type);
                            //console.log('f=>'+full);
                            var id = full.id;
                            if (data == null)
                                data = 0;
                            return '<div class="input-group pull-right">\
                                <input type="text" class="form-control col-xs-8" id="weight' + full.id + '" onkeyup="enableChange(' + full.id + ')" value="' + data + '"/>\
                                <span id="refreshBtn' + full.id + '" class="input-group-addon cursor-pointer" onclick="ChangeWeight(' + full.id + ')">\
                                        <i></i>\
                                        </span>\
                                        </div>';//8532020 270

//                                return "<div class='input-group pull-right' ><input type='text' class='form-control col-xs-8' id='weight"+full.id+"' value='"+data+"'/> \
//                                <span class='btn btn-default col-xs-3' onclick='ChangeWeight("+full.id+")'></span></div> ";
                        }


                    },
                    {
                        "data": "id", "width": "8%",
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            var id = full.id;
                            return '<span class="cursor-pointer" onclick="remove_child(' + full.id + ')"><i class="fa fa-remove" ></i></span>';
                        }
                    }
                ]
            });
        }, 100);
    }
    function refreshDraftFiles(id) {

        var url = "{{ route('hamahang.tasks.my_assigned_tasks.show_task_files') }}";

        window.table_chart_grid2.destroy();
        setTimeout(function () {

            send_info = {
                tid: current_id
            }
            window.table_chart_grid2 = $('#files_grid').DataTable({
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
                            //console.log(data);
                            //console.log(type);
                            var id = full.file_id;
                            if (data == null)
                                data = 0;


                            return "<a class='cls3' target='_self' style='margin: 2px'  href='{{ route('FileManager.DownloadFile',['type'=> 'ID','id'=>'']) }}/" + full.ID_N + "'><i class=''></i></a>" + '<span class="cursor-pointer" style="color: red" onclick="RemoveTaskFile(\'' + full.ID_N + '\')"><i class="fa fa-remove" ></i></span>';


                        }


                    }
                ]
            });
        }, 100);
    }
    function do_action() {
        switch (current_tab) {
            case 0:
                var sendInfo = {
                    id: current_tab
                };
                $.ajax({
                    type: "POST",
                    url: '{{ URL::route('hamahang.tasks.my_assigned_tasks.edit_task_info') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function (data) {

                        //console.log(data);

                    }
                });
                break;
            case 1:
                var sendInfo = {
                    id: current_tab,
                    tid: current_id,
                    qid: $('input[name=quality]:checked').val()
                };

                $.ajax({
                    type: "POST",
                    url: '{{ URL::route('hamahang.tasks.my_assigned_tasks.change_task_quality') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function (data) {
                        alert('با موفقیت انجام شد');
                        var q = '';
                        var quality_h = '';
                        if (data.length > 0)
                            for (i = 0; i < data.length; i++) {
                                switch (data[i]['quality_id']) {
                                    case 0:
                                        q = 'تعیین نشده';
                                        break;
                                    case 1:
                                        q = 'عالی';
                                        break;
                                    case 2:
                                        q = 'خوب';
                                        break;
                                    case 3:
                                        q = 'متوسط';
                                        break;
                                    case 4:
                                        q = 'ضعیف';
                                        break;
                                    case 5:
                                        q = 'بسیار ضعیف';
                                        break;
                                }
                                quality_h += '<tr><td>' + q + '</td><td>' + data[i]['timestamp'] + '</td></tr>';
                            }
                        $('#h2').html(quality_h);

                    }
                })
                break;
            case 2:
                var sendInfo = {
                    id: current_tab,
                    tid: current_id,
                    //sid: $('#')
                };

                $.ajax({
                    type: "POST",
                    url: '{{ URL::route('hamahang.tasks.my_assigned_tasks.add_new_files') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function (data) {
                        $('#HFM_ResultsArea_{{ enCode('AddNewFiles') }}').empty();
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
    function RefreshStatusHistory(data) {
        switch (data[0]['type']) {
            case 0:
                $('#status').html('{{trans('tasks.status_not_started')}}');
                $('#task_end').removeAttr("disabled");
                $('#task_stop').removeAttr("disabled");
                $("#task_restart").attr("disabled", "disabled");
                break;
            case 1:
                $('#status').html('درحال انجام  - میزان پیشرفت  ' + data[0]['percent'] + ' درصد');
                $('#task_end').removeAttr("disabled");
                $('#task_stop').removeAttr("disabled");
                $("#task_restart").attr("disabled", "disabled");
                break;
            case 2:
                $('#status').html('{{trans('tasks.status_done')}}');
                $("#task_restart").attr("disabled", "disabled");
                $('#task_end').removeAttr("disabled");
                $('#task_stop').removeAttr("disabled");
                break;
            case 3:
                $('#status').html('{{trans('tasks.status_finished')}}');
                $("#task_end").attr("disabled", "disabled");
                $("#task_restart").attr("disabled", "disabled");
                $('#task_stop').removeAttr("disabled");
                break;
            case 4:
                $('#status').html('متوقف');
                $("#task_stop").attr("disabled", "disabled");
                $("#task_end").attr("disabled", "disabled");
                $('#task_restart').removeAttr("disabled");
                break;
        }
        var status_h = '';
        var status = '';
        var percent = '-';
        for (i = 0; i < data.length; i++) {
            var percent = '-';
            switch (data[i]['type']) {
                case 0:
                    status = '{{trans('tasks.status_not_started')}}';
                    break;
                case 1:
                    status = '{{trans('tasks.status_started')}}';
                    percent = data[i]['percent']
                    break;
                case 2:
                    status = '{{trans('tasks.status_done')}}';
                    break;
                case 3:
                    status = '{{trans('tasks.status_finished')}}';
                    break;
                case 4:
                    status = 'متوقف';
                    break;
            }
            status_h += '<tr><td>' + status + '</td><td>' + percent + '</td><td>' + data[i]['timestamp'] + '</td></tr>';
        }

        $('#h1').html(status_h);
    }
</script>