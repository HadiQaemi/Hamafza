<script>

    $(".DatePicker").persianDatepicker({
        autoClose: true,
        format: 'YYYY-MM-DD'
    });

    $(document).ready(function () {

        // initDraggable();
        $('#form_filter_priority').on('keyup change', 'input, select, textarea', 'checkbox', function () {
            filter_tasks_priority();
        });
        $('#form_filter_priority_time').on('keyup change', 'input, select, textarea', 'checkbox', function () {
            filter_tasks_priority_time();
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

</script>