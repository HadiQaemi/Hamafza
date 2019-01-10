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

        $('.tab_t4').on('click', function() {
            refreshDraftFiles($('#help_id').val());
        });
        $('#add_help_permission').on('click', function() {
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.tasks.add_help_permission') }}',
                dataType: "json",
                data: {permission_id: $('#permission_id').val(), help_id: $('#help_id').val()},
                success: function (data) {
                    if (data.success == false){
                        messageModal('error', '{{trans('app.operation_is_failed')}}', data.error);
                    }else{
                        window.permissions_help_grid.ajax.reload();
                    }
                }
            });
        });

        function refreshDraftFiles(id) {
            window.table_chart_grid2.destroy();
            window.permissions_help_grid = $('#permissions_help_grid').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    "url": '{{ URL::route('hamahang.tasks.take_help_permissions') }}',
                    "type": "POST",
                    "data": {help_id: id}
                },
                "autoWidth": false,
                "language": LangJson_DataTables,
                lengthChange: false,
                destroy: true,
                "serverside": true,
                "searching": false,
                columns: [
                    {"data": "id"},
                    {"data": "target_id"},
                    {
                        "data": "operations",
                        "mRender": function (data, type, full) {
                            var id = full.id;
                            return "<i class='fa fa-remove' rel='" + full.id + "'></i>";


                        }


                    }
                ]
            });
        }

    });


</script>