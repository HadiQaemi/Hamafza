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
        $('#title, .task_status, .task_immediate, .task_important, .official_type, input[name="task_status[]"], input[name="task_final[]"], input[name="task_immediate[]"], input[name="official_type[]"], input[name="task_important[]"], input[name="task_important_immediate[]"]').on('keyup change', function () {
            filter_mytask();
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

    function submit_change_type_task(type, task_id) {
        filter_subject_id = 0;
        if($('#filter_subject_id').val() != undefined)
            filter_subject_id = $('#filter_subject_id').val();
        $.ajax({
            url: '{{ route('hamahang.tasks.my_tasks.change_type_task') }}',
            method: 'POST',
            dataType: "json",
            data: {type: type, task_id: task_id, filter_subject_id: filter_subject_id},
            success: function (res) {
                if (!res.success) {
                    messageModal('fail', 'خطا', ['شما مجوز لازم را ندارید']);
                }
                $("#base_items").html(res.data);
                filter_mytask();
                //initDraggable();
            }
        });
    }
    function filter_mytask(data) {
        filter_subject_id = '';
        if($('#filter_subject_id').val() != undefined)
            filter_subject_id = $('#filter_subject_id').val();
        var form_filter_priority = $("#form_filter_priority").serialize() + '&filter_subject_id=' + filter_subject_id;
        console.log($("#form_filter_priority").serialize());
        $.ajax({
            url: '{{ route('hamahang.tasks.my_tasks.filter_my_task') }}',
            method: 'POST',
            dataType: "json",
            data: form_filter_priority,
            success: function (res) {
                console.log(res);
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

