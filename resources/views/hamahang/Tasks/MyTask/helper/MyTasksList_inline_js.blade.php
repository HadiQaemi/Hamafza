<script>
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
        $("#r1").prop("checked", true);
    }
    //////////////////////////////////////////
    var send_info = {
        @if(isset($filter_subject_id))
        subject_id: '{{ $filter_subject_id }}'
        @endif

    };
    $(document).on('click', '.update_task', function () {
        var save_type = $("input[name='new_task_save_type']:checked").val();
        var $this = $(this);
        var form_id = $this.data('form_id');
        var save_again = $this.data('again_save');
        if (save_type == 1) {
            UpdateTask(form_id, save_again,'');
        }
        else if (save_type == 0) {
            UpdateTask(form_id, save_again,0);
            //save_as_draft(form_id, save_again);
        }
        else
        {
            alert('{{ trans('tasks.the_save_type_is_not_selected') }}');
        }
    });

    $('#MyTasksTable').DataTable({
        "dom": window.CommonDom_DataTables,
        "ajax": {
            "url": "{{ route('hamahang.tasks.my_tasks.fetch') }}",
            "type": "POST",
            "data": send_info
        },
        "autoWidth": false,
        "language": window.LangJson_DataTables,
        "processing": true,
        columns: [
            {
                visible: false,
                "data": "id", "width": "5%"},
            {
                visible: false,
                "data": "use_type"},
            {
                "data": "title",
                "mRender": function (data, type, full) {
                    var id = full.id;
                    // return "<a class='task_info cursor-pointer' data-t_id = '"+full.id+"'>"+full.title+"</a>";<a style="float: right;" class="jsPanels" href="/modals/ShowTaskForm?tid='+id+'" title="{{trans('tasks.show_task')}}">{{trans('tasks.show_task')}}</a>
                    return "<a class='cursor-pointer jsPanels' href='/modals/ShowAssignTaskForm?tid="+full.id+"&aid="+full.assignment_id+"'>"+full.title+"</a>";
                }
            },
            {"data": "employee"},
            {"data": "immediate"},
            {"data": "respite"},
            {"data": "type"}

//            , {
//                "data": "id", "width": "8%",
//                "bSearchable": false,
//                "bSortable": false,
//                "mRender": function (data, type, full) {
//                    var id = full.id;
//                    return "<a class='cls3' style='margin: 2px' onclick='f(" + full.id + ")' href=\"#\"><i class='fa fa-edit'></i></a><a style='margin:2px;' class='cls3' \
//                                                                                                                                                                                                                                onclick='del(" + full.id + ")' href=\"#\"><i class='fa fa-trash'></i></a>";
//                }
//            }
        ]
    })
    function call_modal(title, message, callback_function) {
        $('#confirm_modal_massage').html(message);
        $('#confirm_modal_title').html(title);
        $("#confirm_ok").attr("onclick", callback_function + "(1)");
        $('#confirm_modal').modal({show: true});
    }
    function close_modal() {

        $('#confirm_modal').modal('hide');

    }
    function RemovePackage(id) {
        $('#new_package').modal('hide');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var sendInfo = {
            id: id,
        };
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tasks.my_tasks.remove_from_package') }}',
            dataType: "json",
            data: sendInfo
        });
    }

    function RemoveKeyword(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var sendInfo = {
            kid: id,
            id: current_id
        };
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tasks.my_tasks.remove_keyword') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {
                // console.log(data);
                var cur_kw = '';
                $.each(data, function (key, value) {
                    cur_kw += '<a class="btn btn-default"  style="margin-right: 3px"><i class="fa fa-remove" style="margin-left: 5px" onclick="RemoveKeyword(' + value.id + ')"></i>'
                        + value.keyword + '</a>';
                })
                $('#current_kw').html(cur_kw);
            }
        });
    }
    function RemoveFromPackage(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var sendInfo = {
            pid: id,
            id: current_id

        };
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tasks.my_tasks.remove_from_package') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {
                var cur_pkg = '';
                $.each(data, function (key, value) {
                    cur_pkg += '<a class="btn btn-default"  style="margin-right: 3px"><i class="fa fa-remove" style="margin-left: 5px" onclick="RemoveFromPackage(' + value.id + ')"></i>' + value.title + '</a>';
                })
                $('#current_packages').html(cur_pkg);
            }
        });
    }
    function AddNewPackage() {
        $('#new_package').modal('hide');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var sendInfo = {
            title: $('#packagetitle').val(),
        };
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tasks.my_tasks.new_package') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {
                var p = '';
                for (var i = 0; i < data.length; i++) {
                    p += '<option id="' + data[i]['id'] + '">' + data[i]['title'] + '</option>';
                }
                $('#packages').html(p);
            }
        });
    }

    var t2_default;
    var current_tab = '';
    var current_id = '';

</script>