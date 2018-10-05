<script>

    $(".DatePicker").persianDatepicker({
        autoClose: true,
        format: 'YYYY-MM-DD'
    });

    $(document).ready(function () {

        // initDraggable();
        $('#new_task_users_all_tasks, #new_task_keywords').on('change', function () {
            filter_tasks_priority();
        });
        $('#title, .task_status, .task_immediate, .task_important, .official_type').on('keyup change', function () {
            filter_tasks_priority();
        });
        $("#states-multi-select-users").select2({
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
</script>
<script>
    function initDraggable() {
        $(".draggable").draggable({
            cursor: "all-scroll",
            zIndex: 100,
            revert: 'invalid',
            helper: 'clone',
            drag: function (event, ui) {
            }
        });
        $(".droppable").droppable({
            accept: ".draggable",
            drop: function (event, ui) {
                // alert('drop');
                $(this).removeClass("border").removeClass("over");
                var Drag_Destination = $(this).attr('id');
                var dropped = ui.draggable;
                var task_id = dropped.data('task_id');
                submit_change_type_task(Drag_Destination, dropped.attr('data-task_id'));
                var droppedOn = $(this);
                $(dropped).detach().appendTo(droppedOn);//.css({top: 0, left: 0,'background-color': '#e0f7fa', 'width':'auto','position': 'relative'})
            },
            over: function (event, elem) {
                // alert('over');
                $(this).data('id');
                $(this).addClass("over");
            },
            out: function (event, elem) {
                // alert('out');
                $(this).removeClass("over");
            }
        });
        $(".droppable").sortable();
    }
    function filter_tasks_priority(data) {
        var form_filter_priority = $("#form_filter_priority").serialize() + '&filter_subject_id=' + $('#filter_subject_id').val() + '&act=' + $('#act_form').val();
        console.log(data);
        $.ajax({
            url: '{{ route('hamahang.tasks.priority.all_task_filter') }}',
            method: 'POST',
            dataType: "json",
            data: form_filter_priority,
            success: function (res) {
                //console.log(res.success);
                if (res.success == true) {
                    $('#priority_content_area').html(res.data);
                    initDraggable();
                    //messageModal('success', '{{trans('app.operation_is_success')}}', {0: '{{trans('access.succes_insert_data')}}'});
                } else if (res.success == false) {
                    messageModal('error', '{{trans('app.operation_is_failed')}}', res.error);
                }
            }
        });
    }
    function filter_tasks_priority_time(data) {
        console.log(data);
        $.ajax({
            url: '{{ route('hamahang.tasks.priority.filter_time') }}',
            method: 'POST',
            dataType: "json",
            data: $("#form_filter_priority").serialize(),
            success: function (res) {
                //console.log(res.success);
                if (res.success == true) {
                    $('#priority_content_area').html(res.data);
                    initDraggable();
                    //messageModal('success', '{{trans('app.operation_is_success')}}', {0: '{{trans('access.succes_insert_data')}}'});
                } else if (res.success == false) {
                    messageModal('error', '{{trans('app.operation_is_failed')}}', res.error);
                }
            }
        });
    }
    function submit_change_priority(type, task_id, action) {
        $.ajax({
            url: '{{ route('hamahang.tasks.priority.change') }}',
            method: 'POST',
            dataType: "json",
            data: {type: type, task_id: task_id, action: action},
            success: function (res) {
                console.log(res.success);
                if (res.success == true) {
                    //messageModal('success', '{{trans('app.operation_is_success')}}', {0: '{{trans('access.succes_insert_data')}}'});
                } else if (res.success == false) {
                    messageModal('error', '{{trans('app.operation_is_failed')}}', res.error);
                }
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