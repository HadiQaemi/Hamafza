<script>
    (function($){
        $.fn.serializeObject = function(){

            var self = this,
                json = {},
                push_counters = {},
                patterns = {
                    "validate": /^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
                    "key":      /[a-zA-Z0-9_]+|(?=\[\])/g,
                    "push":     /^$/,
                    "fixed":    /^\d+$/,
                    "named":    /^[a-zA-Z0-9_]+$/
                };


            this.build = function(base, key, value){
                base[key] = value;
                return base;
            };

            this.push_counter = function(key){
                if(push_counters[key] === undefined){
                    push_counters[key] = 0;
                }
                return push_counters[key]++;
            };

            $.each($(this).serializeArray(), function(){

                // skip invalid keys
                if(!patterns.validate.test(this.name)){
                    return;
                }

                var k,
                    keys = this.name.match(patterns.key),
                    merge = this.value,
                    reverse_key = this.name;

                while((k = keys.pop()) !== undefined){

                    // adjust reverse_key
                    reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');

                    // push
                    if(k.match(patterns.push)){
                        merge = self.build([], self.push_counter(reverse_key), merge);
                    }

                    // fixed
                    else if(k.match(patterns.fixed)){
                        merge = self.build([], k, merge);
                    }

                    // named
                    else if(k.match(patterns.named)){
                        merge = self.build({}, k, merge);
                    }
                }

                json = $.extend(true, json, merge);
            });

            return json;
        };
    })(jQuery);
    $('#form_filter_priority').on('keyup change', 'input, select, textarea', 'checkbox', function () {
        filter_tasks_priority();
    });
    $('#new_task_keywords').on('change', function () {
        filter_tasks_priority();
    });
    function filter_tasks_priority(data) {
        window.table_chart_grid3.destroy();
        readTable($("#form_filter_priority").serializeObject());
        {{--$.ajax({--}}
        {{--url: '{{ route('hamahang.tasks.my_tasks.fetch') }}',--}}
        {{--method: 'POST',--}}
        {{--dataType: "json",--}}
        {{--data: $("#form_filter_priority").serialize(),--}}
        {{--success: function (res) {--}}
        {{--//console.log(res.success);--}}
        {{--if (res.success == true) {--}}
        {{--$('#priority_content_area').html(res.data);--}}
        {{--//messageModal('success', '{{trans('app.operation_is_success')}}', {0: '{{trans('access.succes_insert_data')}}'});--}}
        {{--} else if (res.success == false) {--}}
        {{--messageModal('error', '{{trans('app.operation_is_failed')}}', res.error);--}}
        {{--}--}}
        {{--}--}}
        {{--});--}}

    }
    readTable($("#form_filter_priority").serializeObject());
    function  readTable(send_info) {
        if($('#new_task_keywords').val())
        {
            send_info["search_task_keywords"]= $('#new_task_keywords').val();
        }
        LangJson_DataTables = window.LangJson_DataTables;
        LangJson_DataTables.searchPlaceholder = '{{trans('tasks.search_in_task_title_placeholder')}}';
        window.table_chart_grid3 = $('#MyAssignedTasksTable').DataTable({
            "dom": window.CommonDom_DataTables,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('hamahang.tasks.my_assigned_tasks.fetch_transcripts') }}",
                "type": "POST",
                "data": send_info,

            },
            "searching": false,
            "autoWidth": false,
            "language": LangJson_DataTables,
            "processing": true,
            columns: [
                // {"data": "id", "width": "5%"},
                // {"data": "use_type", "width": "5%"},
                {
                    "data": "title",
                    "mRender": function (data, type, full) {
                        var id = full.id;
                        // return "<a class='task_info cursor-pointer' data-t_id = '"+full.id+"'>"+full.title+"</a>";ShowAssignTaskForm
                        return "<a class='cursor-pointer jsPanels' href='/modals/ShowTranscriptTaskForm?tid="+full.id+"&aid="+full.assignment_id+"'>"+full.title+"</a>";
                    }
                },
                {
                    "data": "employee",
                    "mRender": function (data, type, full) {
                        var keywords = full.keywords.replace(/&quot;/g,'"');
                        keywords = JSON.parse(keywords);
                        data2 = "";
                        $.each(keywords, function(index) {
                            data2 += '<span class="bottom_keywords one_keyword task_keywords" data-id="'+keywords[index].id+ '" ><i class="fa fa-tag"></i> <span style="color: #6391C5;">'+keywords[index].title+'</span></span>';
                        });
                        return full.employee+"<div class='' style='margin: 2px 0px;padding: 5px;'>"+data2+"</div>";
                    }},
                {"data": "immediate"},
                {"data": "respite"},
                {"data": "type"}
                // ,
                // {
                //     "data": "id", "width": "8%",
                //     "bSearchable": false,
                //     "bSortable": false,
                //     "mRender": function (data, type, full) {
                //         var id = full.id;
                //         return "<a style='margin:2px;' class='cls3' onclick='del(" + full.id + ")' href=\"#\"><i class='fa fa-trash'></i></a>";
                //     }
                // }
                // , {
                //     "data": "id",
                //     "bSearchable": false,
                //     "bSortable": false,
                //     "mRender": function (data, type, full) {
                //         var id = full.id;
                //         return "<a class='cls3' style='margin: 2px' onclick='save_as_library_task(" + full.id + ")' href=\"#\">افزودن به کتابخانه</a>";
                //     }
                // }
            ]
        });
    }

    var t2_default;
    var current_tab = '';
    var current_id = '';
    var selectedrow = [];
    var r;
    var editor; // use a global for the submit and return data rendering in the examples
    $(document).ready(function () {
        // alert('dataTables_filter ');
        // $('.dataTables_filter input').attr("placeholder","asdasd");
        var send_info = {
            @if(isset($filter_subject_id))
            subject_id: '{{ $filter_subject_id }}'
            @endif

        }

        window.table_chart_grid = $('#ChildsGrid').DataTable();
        window.table_chart_grid2 = $('#files_grid').DataTable();
        //editor = new $.fn.dataTables.Editor({});
        $(".DatePicker").persianDatepicker({
            observer: true,
            autoClose: true,
            format: 'YYYY-MM-DD'
        });
    });
    function save_as_library_task(id) {
        var sendInfo = {
            task_id: id,
            task_type: 0
        };
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tasks.my_assigned_tasks.save_as_library_task') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {
                if (data.success == true) {
                    messageModal('success', 'ذخیره در کتابخانه وظایف', data.message);
                }
                else {
                    messageModal('error', '{{ trans('app.operation_is_failed') }}', data.error);
                }
                //refreshChildsDatatable();
            }
        });

    }
    function close_modal() {
        $('#confirm_modal').modal('hide');
    }
    function SaveNewTask() {
        if ($('input[name="immediate"]:checked').val() == null || $('input[name="importance"]:checked').val() == null) {
            alert('اهمیت و فوریت تعیین نشده است');
        } else {

            var sendInfo = {
                user_id: $('#states-multi-select-users').val(),
                respite_date: $('#DatePicker').val(),
                importance: $('input[name="importance"]:checked').val(),
                immediate: $('input[name="immediate"]:checked').val(),
                title: $('#new_task_title').val()
            };
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.tasks.rapid_new_task') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {
                    $("#MyTasksGrid").bootgrid("destroy");
                    $("#MyTasksGrid").bootgrid({
                        ajax: true,
                        url: url,
                        selection: true,
                        multiSelect: true,
                        post: {type: id, kw: kw},
                        formatters: {
                            "link": function (column, row) {
                                return "<a class='cls3' style='margin: 2px' onclick='change_item(" + row.id + ")' href=\"#\"><i class='fa fa-edit'></i></a><a style='margin:2px;' class='cls3'  onclick='RemoveChartItem(" + row.id + ")' href=\"#\"><i >حذف</i></a>";
                            }
                        }
                    }).on("selected.rs.jquery.bootgrid", function (e, rows) {


                        for (var i = 0; i < rows.length; i++) {
                            var x = parseInt(rows[i].id);
                            selectedrow.push(x);
                            if (selectedrow.length < 0)
                                $('#selected_tasks_count').html(0);
                            else
                                $('#selected_tasks_count').html(selectedrow.length);
                            console.log('push=>' + selectedrow);
                        }
                    }).on("deselected.rs.jquery.bootgrid", function (e, rows) {
                        //alert('dec');
                        for (var i = 0; i < rows.length; i++) {
                            var x = parseInt(rows[i].id);
                            for (var j in selectedrow) {
                                if (selectedrow[i] == x) {
                                    selectedrow.splice(j, 1);
                                    break;
                                }
                            }
                        }
                        if (selectedrow.length <= 0)
                            $('#selected_tasks_count').html(0);
                        else
                            $('#selected_tasks_count').html((selectedrow.length) - 1);
                        console.log('splice=>' + selectedrow);
                    }).on('loaded.rs.jquery.bootgrid', function () {
                        $("#MyTasksGrid").bootgrid('select', selectedrow);
                    });

                    $('.nav-tabs a[href="#tab1"]').tab('show');
                }
            });
        }

    }
    $("#states-multi-select-users").select2({
        minimumInputLength: 1,
        tags: false,
        dir: "rtl",
        width: '100%',
        ajax: {
            url: "{{ route('auto_complete.users',['username'=>$uname]) }}",
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
    function add_task_childs() {

        if (selectedrow.length > 0) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var sendInfo = {
                s_arr: selectedrow,
                tid: current_id
            };
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.tasks.my_assigned_tasks.add_task_childs') }}',
                dataType: "json",
                data: sendInfo,
                success: function () {

                    refreshChildsDatatable();

                }
            });
        }


        $('#select_task').modal('hide');
    }
    function SelectTaskChilds() {
        $('#select_task').modal({show: true});
    }
    function RestartTask() {
        confirmModal({
            title: 'شروع مجدد پروژه',
            message: 'آیا برای شروع مجدد این وظیفه مطمئن هستید؟',
            onConfirm: function () {
                var sendInfo = {
                    tid: current_id
                };
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.tasks.my_assigned_tasks.restart_task') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function (data) {
                        RefreshStatusHistory(data);
                    }
                });
            },
            afterConfirm: 'close'
        });

    }
    function StopTask() {
        confirmModal({
            title: 'توقف وظیفه',
            message: 'آیا برای متوقف کردن این وظیفه مطمئن هستید؟',
            onConfirm: function () {
                var sendInfo = {
                    tid: current_id
                };
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.tasks.my_assigned_tasks.task_stop') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function (data) {
                        RefreshStatusHistory(data);
                    }
                });
            },
            afterConfirm: 'close'
        });
    }
    function EndTask() {

        confirmModal({
            title: 'پایان وظیفه',
            message: 'آیا برای پایان دادن به این وظیفه مطمئن هستید؟',
            onConfirm: function () {
                var sendInfo = {
                    tid: current_id
                };
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.tasks.my_assigned_tasks.task_end') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function (data) {
                        RefreshStatusHistory(data);
                    }
                });
            },
            afterConfirm: 'close'
        });
    }

    $('#btn_select_task_childs').click(function () {
        show_select_tasks_window_modal(2, current_id, 1);
    })
    function RemoveTaskFile(id) {

        var sendInfo = {
            fid: id
        };
        $.ajax({
            type: "POST",
            url: '{{ URL::route('hamahang.tasks.my_assigned_tasks.remove_task_file') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {


                refreshDraftFiles();


            }
        });

    }
    function ShowErrorModal(data) {

        err_list_txt = '';
        $.each(data, function (key, value) {
            err_list_txt += '';
            switch (value.relation) {
                case 0: {
                    err_list_txt += '<li>' + 'وظیفه ' + '<span style="color: limegreen">' + value.task_title + '(' + value.id + ')' + '</span>' + ' هنوز {{trans('tasks.status_not_started')}} است' + '</li>';
                    break;
                }
                case 1: {
                    err_list_txt += '<li>' + 'وظیفه ' + '<span style="color: limegreen">' + value.task_title + '(' + value.id + ')' + '</span>' + ' هنوز {{trans('tasks.status_not_started')}} است' + '</li>';
                    break;
                }
                case 2: {
                    err_list_txt += '<li>' + 'وظیفه ' + '<span style="color: limegreen">' + value.task_title + '(' + value.id + ')' + '</span>' + ' هنوز {{trans('tasks.status_not_started')}} است' + '</li>';
                    break;
                }
                case 3: {
                    err_list_txt += '<li>' + 'وظیفه ' + '<span style="color: limegreen">' + value.task_title + '(' + value.id + ')' + '</span>' + ' هنوز {{trans('tasks.status_not_started')}} است' + '</li>';
                    break;
                }
            }

        });
        $('#errors').html(err_list_txt);
        $('#change_statuts_err').modal({show: true});

    }
    function refreshDraftFiles(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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
                            console.log('f=>' + full);
                            var id = full.file_id;
                            if (data == null)
                                data = 0;


                            return "<a class='cls3' target='_self' style='margin: 2px'  href='{{ route('FileManager.DownloadFile',['type'=> 'ID','id'=>'']) }}/" + full.ID_N + "'></a>" + '<span class="cursor-pointer" style="color: red" onclick="RemoveTaskFile(\'' + full.ID_N + '\')"><i class="fa fa-remove" ></i></span>';


                        }


                    }
                ]
            });
        }, 100);
    }

    function refresh_follow_ups() {
        //current_id = id;
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
                $('#desc12').val('');
                $('#follow_up_items').html(follow_up);
            }

        });

        $('#task_details').modal({show: true});


    }
    function del(id) {
        confirm("Are you sure?");
    }
    function f(id) {
        show_task_info();
        $('#progress').width(0);
        $('#progress_rext').html('بدون پیشرفت');
        $('#t2').html(t2_default);
        current_id = id;
        var sendInfo = {
            id: id
        };
        var imm = 'فوری';
        var imp = 'مهم';
        $.ajax({
            type: "POST",
            url: '{{ URL::route('hamahang.tasks.task_info') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {
                $('#taskTitle').html(data['title']);
                $('#do_respite').html('مهلت انجام : ' + data['respite_day']);
                $('#respite').val(data['respite_day']);
                $('#task_title').val(data['title']);
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
                if (data['MyKw'].length == 0)
                    kw = '<p class="btn btn-default" style="margin-left: 5px">تعریف نشده</p>';
                for (i = 0; i < data['MyKw'].length; i++) {
                    console.log(data['MyKw'][i][1]);
                    kw += '<p class="btn btn-default" style="margin-left: 5px">' + data['MyKw'][i][1] + '</p>';
                }
                $('#task_keywords').html(kw);

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
//        $('#task_details').modal({show: true});
    }
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
                "language": LangJson,
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
                                        <i ></i>\
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
    function enableChange(id) {
        $('#refreshBtn' + id).css("pointer-events", "auto");
        $('#refreshBtn' + id).css("color", "blue");
        $('#weight' + id).css('color', 'red');
    }
    function ChangeWeight(id) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var sendInfo = {
            cid: id,
            NWeight: $('#weight' + id).val()
        };

        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tasks.my_assigned_tasks.task_child_change_weight') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {
                // document.getElementById('refreshBtn'+id).disabled = true;
                $('#refreshBtn' + id).css("pointer-events", "none");
                $('#refreshBtn' + id).css("color", "green");
                $('#weight' + id).css('color', 'green');


            }
        });

    }
    $('#transfer').click(function () {

    });
    (function () {

        $("#tags").select2({
            minimumInputLength: 1,
            dir: "rtl",
            width: "100%",
            tags: true
        });
        $("#states-multi-select-transcripts").select2({
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


    })(jQuery);
    function remove_child(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var sendInfo = {
            cid: id
        };

        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tasks.my_assigned_tasks.remove_task_childs') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {

                refreshChildsDatatable();

            }
        });
    }
    $(".select2_auto_complete_user").select2({
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
</script>
