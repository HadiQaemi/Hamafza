<script>

    var relations_grid_table = "";

    function relationsDataTable(target_id) {
        relations_grid_table = $('#' + target_id).DataTable({
            "dom":CommonDom_DataTables ,
            "language": window.LangJson_DataTables,
            ajax: {
                url: '{!! route('hamahang.relations.get_relations') !!}',
                type: 'POST'
            },
            columns: [
                {
                    "data": "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'directname',
                    name: 'directname',
                },
                {
                    data: 'Inversename',
                    name: 'Inversename',
                },
                {
                    data: 'dariche',
                    name: 'dariche',
                },
                {
                    searchable: false,
                    sortable: false,
                    mRender: function (data, type, full) {
                        var result = '';
                        result += '' +
                            '<button style="margin-right: 3px;" title="ویرایش گروه" type="button" class="btn btn-xs bg-warning-400 fa fa-edit btn_grid_item_edit" ' +
                            '   data-grid_item_id="' + full.id + '" ' +
                            '   data-grid_item_name="' + full.name + '" ' +
                            '   data-grid_item_direct_name="' + full.directname + '" ' +
                            '   data-grid_item_inverse_name="' + full.Inversename + '" ' +
                            '   data-grid_item_direction="' + full.direction + '" ' +
                            '   data-grid_item_dariche="' + full.dariche + '" ' +
                            '   data-grid_item_dariche_inver="' + full.dariche_inver + '">' +
                            '</button>';
                        result += '' +
                            '<button style="margin-right: 3px;" title="حذف گروه" type="button" class="btn btn-xs bg-danger-800 fa fa-trash-o btn_grid_destroy_item" data-grid_item_id="' + full.id + '" data-grid_item_name="' + full.title + '"></button>';
                        return result;
                    }
                },
            ]
        });
    }

    function create_new_relation() {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.relations.add_new_relation')}}',
            dataType: "json",
            data: $('#create_new_relation').serialize(),
            success: function (result) {
                if (result.success == true) {
                    jQuery.noticeAdd({
                        text: result.message,
                        stay: false,
                        type: 'success'
                    });
                    relations_grid_table.ajax.reload();
                    $('a[href="#relations_list"]').click();
                    document.getElementById('create_new_relation').reset();
                }
                else {
                    var errors = '';
                    for (var k in result.error) {
                        errors += '' +
                            '<li>' + result.error[k] + '</li>'
                    }
                    jQuery.noticeAdd({
                        text: errors,
                        stay: false,
                        type: 'error'
                    });
                }
            }
        });
    }

    function edit_relation() {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.relations.edit_relation')}}',
            dataType: "json",
            data: $('#edit_form_relation').serialize(),
            success: function (result) {
                if (result.success == true) {
                    jQuery.noticeAdd({
                        text: result.message,
                        stay: false,
                        type: 'success'
                    });
                    relations_grid_table.ajax.reload();
                    $('.edit_tab').remove();
                    $('a[href="#relations_list"]').click();
                    document.getElementById('edit_form_relation').reset();
                }
                else {
                    var errors = '';
                    for (var k in result.error) {
                        errors += '' +
                            '<li>' + result.error[k] + '</li>'
                    }
                    jQuery.noticeAdd({
                        text: errors,
                        stay: false,
                        type: 'error'
                    });
                }
            }
        });
    }

    function destroy_relation(item_id) {
        confirmModal({
            title: '{{trans('relations.delete_relation')}}',
            message: '{{trans('relations.are_you_sure')}}',
            onConfirm: function () {
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.relations.delete_relation')}}',
                    dataType: "json",
                    data: {
                        item_id: item_id
                    },
                    success: function (result) {
                        $('#delete-modal').modal('hide');
                        if (result.success == true) {
                            relations_grid_table.ajax.reload();
                        }
                        else {
                            messageModal('error', 'خطا در حذف رابطه', result.error);
                        }
                    }
                });
            },
            afterConfirm: 'close'
        });
    }

    $(document).click(function () {

        $("#btn_new_relation").off();
        $("#btn_new_relation").click(function () {
            create_new_relation();
        });

        $("#btn_edit_relation").off();
        $("#btn_edit_relation").click(function () {
            edit_relation();
        });

        $(".btn_grid_destroy_item").click(function () {
            var $this = $(this);
            var item_id = $this.data('grid_item_id');
            destroy_relation(item_id);
        });

    });

    $(document).on("click", ".btn_grid_item_edit", function () {
        var $this = $(this);
        var id = $this.data('grid_item_id');
        var name = $this.data('grid_item_name');
        var direct_name = $this.data('grid_item_direct_name');
        var inverse_name = $this.data('grid_item_inverse_name');
        var direction = $this.data('grid_item_direction');
        var dariche = $this.data('grid_item_dariche');
        var dariche_inver = $this.data('grid_item_dariche_inver');

        $('#edit_form_relation_id').val(id);
        $('#edit_form_name').val(name);
        $('#edit_form_directname').val(direct_name);
        $('#edit_form_Inversename').val(inverse_name);
        $('#edit_form_dariche').val(dariche);
        $('#edit_form_dariche_inver').val(dariche_inver);
        if (direction) {
            $('#edit_form_direct').click();
        }
        else {
            $('#edit_form_indirect').click();
        }
        var li_tab = '<li class=""><a href="#edit_relation" data-toggle="tab" class="legitRipple edit_tab" aria-expanded="false"><span class=""></span> {{trans('relations.edit')}}</a></li>';
        $('.edit_tab').remove();
        $('#manage_tab_pane').append(li_tab);
        $('#manage_tab_pane a[href="#edit_relation"]').tab('show');
    });

    $("#btn_cancel_new_relation").click(function () {
        $('a[href="#relations_list"]').click();
        document.getElementById('create_new_relation').reset();
    });

    $("#btn_cancel_edit_relation").click(function () {
        $('a[href="#relations_list"]').click();
        $('.edit_tab').remove();
        document.getElementById('edit_form_relation').reset();
    });

    $(document).ready(function () {
        relationsDataTable('RelationsGrid');
    });
</script>