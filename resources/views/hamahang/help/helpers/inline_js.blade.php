<script>

    $(document).ready(function () {
        $(".select2_auto_complete_see_also").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.help')}}",
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

        $('.tab_t4').on('click', function () {
            refreshDraftFiles($('#help_id').val());
        });
        $('#add_see_also_help').on('click', function () {
            var num = $('#see_also_list .margin-top-10').length;
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.help.add_see_also_help') }}',
                dataType: "json",
                data: {see_also_id: $('#see_also_id').val(), help_id: $('#help_id').val()},
                success: function (data) {
                    if (data.success == false) {
                        messageModal('error', '{{trans('app.operation_is_failed')}}', data.error);
                    } else {
                        $('#see_also_list').append(
                            '<div class="row margin-top-10">\n' +
                            '<div class="col-xs-1">' + (num + 1) + '</div>\n' +
                            '<div class="col-xs-10">' + $("#see_also_id option:selected").text() + '</div>\n' +
                            '<div class="col-xs-1">\n' +
                            '<i class="fa fa-remove pointer remove_see_also" also="' + data.see_also_id + '"></i>\n' +
                            '</div>\n' +
                            '</div>' +
                            '');
                    }
                }
            });
        });
        $('.remove_see_also').on('click', function () {
            var $this = $(this);
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.help.remove_see_also_help') }}',
                dataType: "json",
                data: {help_id: $(this).attr('also')},
                success: function (data) {
                    if (data.success == false) {
                        messageModal('error', '{{trans('app.operation_is_failed')}}', data.error);
                    } else {
                        $this.parent().parent().remove();
                    }
                }
            });
        });
        $('#add_help_permission').on('click', function () {
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.tasks.add_help_permission') }}',
                dataType: "json",
                data: {permission_id: $('#permission_id').val(), help_id: $('#help_id').val()},
                success: function (data) {
                    if (data.success == false) {
                        messageModal('error', '{{trans('app.operation_is_failed')}}', data.error);
                    } else {
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