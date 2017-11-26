<script>
    $(document).ready(function () {

        $("#create_rapid_task_multi_selected_users").select2({
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
    function reload_mytask(){
        $.ajax({
            url: '{{ route('Hamahang.Tasks.MyTasks.load_mytask') }}',
            method: 'POST',
            dataType: "json",
            data: $("#form_filter_priority").serialize(),
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
    function reload_my_assigned_task(){
        $.ajax({
            url: '{{ route('Hamahang.Tasks.MyTasks.load_mytask') }}',
            method: 'POST',
            dataType: "json",
            data: $("#form_filter_priority").serialize(),
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
    $("#create_rapid_task_btn_submit").off();
    $(document).on('click', '#create_rapid_task_btn_submit', function () {
        var sendInfo = $('#form_create_rapid_task').serialize();
        $.ajax({
            type: "POST",
            url: '{{ URL::route('hamahang.tasks.rapid_new_task') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {
                if (data.success == 'success') {
                    {{--   messageModal('success', '{{trans('app.operation_is_success')}}', {0: '{{trans('access.succes_insert_data')}}'}
                    @if(isset($function))
                        ,{!! $function !!},'data'
                    @endif
                    );--}}
                        reload_mytask();

                }
                else {
                    messageModal('error', '{{trans('app.operation_is_failed')}}', data.error);
                }
            }
        });
    });

</script>