<script>
    $(document).ready(function ()
    {
        $(".select2_auto_complete_permission").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.permissions')}}",
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

        $('#add_help_permission').on('click', function() {
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.tasks.add_help_permission') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {
                    if (data.success == true) {}
                    else {
                        messageModal('error', '{{trans('app.operation_is_failed')}}', data.error);
                    }
                }
            });
        });
    });


</script>