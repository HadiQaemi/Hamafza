<script>
    $(document).ready(function () {
        initDraggable();
        $(".DatePicker").persianDatepicker({
            observer: true,
            autoClose: true,
            format: 'YYYY-MM-DD'
        });
        // $('#form_filter_priority').on('keyup change', 'input, select, textarea', 'checkbox', function () {
        //     filter_mytask();
        // });
        $('#new_task_users_all_tasks, #new_task_keywords').on('change', function () {
            filter_mytask();
        });
        $('#title, .task_status, .task_immediate, .task_important, .official_type, input[name="task_status[]"], input[name="task_fianl[]"], input[name="task_immediate[]"], input[name="official_type[]"], input[name="task_important[]"]').on('keyup change', function () {
            filter_mytask();
        });
    });
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
                $(this).removeClass("border").removeClass("over");
                var Drag_Destination = $(this).attr('id');
                var dropped = ui.draggable;
                var task_id = dropped.data('task_id');
                submit_change_type_task(Drag_Destination, dropped.attr('data-task_id'));
                var droppedOn = $(this);
                $(dropped).detach().appendTo(droppedOn);//.css({top: 0, left: 0,'background-color': '#e0f7fa', 'width':'auto','position': 'relative'})
            },
            over: function (event, elem) {

                $(this).data('id');
                $(this).addClass("over");
            },
            out: function (event, elem) {

                $(this).removeClass("over");
            }
        });
        $(".droppable").sortable();
    }
    function submit_change_type_task(type, task_id) {
        $.ajax({
            url: '{{ route('hamahang.tasks.my_tasks_assigner.change_type_task') }}',
            method: 'POST',
            dataType: "json",
            data: {type: type, task_id: task_id},
            success: function (res) {
                if (res.success == true) {
                    $("#base_items").html(res.data);
                    filter_mytask();
                } else if (res.success == false) {
                    var reserror = [res.error];
                    messageModal('no_li_error', '{{trans('app.operation_is_failed')}}', reserror);
                    filter_mytask();
                }
                //initDraggable();
            }
        });


    }
    function filter_mytask(data) {
        var form_filter_priority = $("#form_filter_priority").serialize()+'&filter_subject_id='+$('#filter_subject_id').val();
        $.ajax({
            url: '{{ route('hamahang.tasks.my_tasks_assigner.filter_my_assigned_task') }}',
            method: 'POST',
            dataType: "json",
            data: form_filter_priority,
            success: function (res) {
                if (res.success == true) {
                    $('#base_items').html(res.data);
                    initDraggable();

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

