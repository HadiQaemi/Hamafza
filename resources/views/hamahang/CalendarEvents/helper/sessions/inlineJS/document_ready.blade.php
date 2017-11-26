<script>
    $(document).ready(function () {
        $('a[href="#decisions"]').click(function () {

            $('#taskForm').hide();
            $('#decisionGrid').show();
             $('#addAecision').hide();
        });
      //  $('a[href="#decisionlist"]').trigger('click');
        $('#addAecision').hide();
        $('#add_task_form').hide();
        $("select[name='users[]']").select2({
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


    });
</script>