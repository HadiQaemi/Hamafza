<script>

    $(".DatePicker").persianDatepicker({
        autoClose: true,
        format: 'YYYY-MM-DD'
    });

    $(document).ready(function () {

        initDraggable();
        $('#form_filter_priority').on('keyup change', 'input, select, textarea', 'checkbox', function () {
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
                // console.log("droped");
                $(this).removeClass("border").removeClass("over");
                var Drag_Destination = $(this).attr('id');
                var dropped = ui.draggable;
                var task_id = dropped.data('task_id');
                submit_change_priority(Drag_Destination, task_id);
                var droppedOn = $(this);
                $(dropped).detach().appendTo(droppedOn);
            },
            over: function (event, elem) {
                $(this).data('id');
                $(this).addClass("over");
                //console.log($(this).attr('id'));
                //console.log("over");
            },
            out: function (event, elem) {
                $(this).removeClass("over");
                //console.log($(this).attr('id'));
                //console.log("out");
            }
        });
        $(".droppable").sortable();
    }
    function filter_tasks_priority(data) {
        console.log(data);
        $.ajax({
            url: '{{ route('hamahang.tasks.priority.filter') }}',
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
    function submit_change_priority(type, task_id) {
        $.ajax({
            url: '{{ route('hamahang.tasks.priority.change') }}',
            method: 'POST',
            dataType: "json",
            data: {type: type, task_id: task_id},
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

</script>