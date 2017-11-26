<script>

    var substs_grid_table = "";

    function substsDataTable(target_id) {
        substs_grid_table = $('#' + target_id).DataTable({
            "dom": CommonDom_DataTables,
            "columnDefs": [
                {"className": "align-center", "targets": "_all"}
            ],
            "language": window.LangJson_DataTables,
            ajax: {
                url: '{!! route('hamahang.substs.get_substs') !!}',
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
                    width: '25%',
                    data: 'first',
                    name: 'first'
                },
                {
                    width: '60%',
                    className: "dt-center",
                    data: 'second',
                    name: 'second',
//                    mRender: function (data, type, full) {
//                        return full.comment.substr(0,75) + '...';
//                    }
                },
                {
                    width: '10%',
                    searchable: false,
                    sortable: false,
                    mRender: function (data, type, full) {
                        var result = '';
                        result += '' +
                            '<button style="margin-right: 3px;" title="ویرایش عبارت" type="button" class="btn btn-xs bg-warning-400 fa fa-edit btn_grid_item_edit" ' +
                            '   data-grid_item_id="' + full.id + '">' +
                            '</button>';
                        result += '' +
                            '<button style="margin-right: 3px;" title="حذف عبارت" type="button" class="btn btn-xs bg-danger-800 fa fa-trash-o btn_grid_destroy_item" data-grid_item_id="' + full.id + '"></button>';
                        return result;
                    }
                },
            ]
        });
    }

    function create_new_subst() {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.substs.add_new_subst')}}',
            dataType: "json",
            data: $('#create_new_subst').serialize(),
            success: function (result) {
                if (result.success == true) {
                    jQuery.noticeAdd({
                        text: result.message,
                        stay: false,
                        type: 'success'
                    });
                    substs_grid_table.ajax.reload();
                    $('a[href="#substs_list"]').click();
                    document.getElementById('create_new_subst').reset();
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

    function generate_edit_form(item_id) {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.substs.edit_subst_view')}}',
            dataType: "json",
            data: {item_id: item_id},
            success: function (result) {
                if (result.success == true) {
                    $('#edit_form_subst_id').val(item_id);
                    $('#subst_edit_form').html(result.content);
                    var li_tab = '<li class=""><a href="#edit_subst" data-toggle="tab" class="legitRipple edit_tab" aria-expanded="false"><span class=""></span> {{trans('subst.edit')}}</a></li>';
                    $('.edit_tab').remove();
                    $('#manage_tab_pane').append(li_tab);
                    $('#manage_tab_pane a[href="#edit_subst"]').tab('show');
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

    function edit_subst() {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.substs.edit_subst')}}',
            dataType: "json",
            data: $('#edit_form_subst').serialize(),
            success: function (result) {
                if (result.success == true) {
                    jQuery.noticeAdd({
                        text: result.message,
                        stay: false,
                        type: 'success'
                    });
                    substs_grid_table.ajax.reload();
                    $('a[href="#substs_list"]').click();
                    document.getElementById('edit_form_subst').reset();
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

    function destroy_subst(item_id) {
        confirmModal({
            title: '{{trans('subst.delete_subst')}}',
            message: '{{trans('subst.are_you_sure')}}',
            onConfirm: function () {
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.substs.delete_subst')}}',
                    dataType: "json",
                    data: {
                        item_id: item_id
                    },
                    success: function (result) {
                        if (result.success == true) {
                            jQuery.noticeAdd({
                                text: result.message,
                                stay: false,
                                type: 'success'
                            });
                            substs_grid_table.ajax.reload();
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
            },
            afterConfirm: 'close'
        });
    }

    $(document).click(function () {

        $("#btn_add_new_subst").off();
        $("#btn_add_new_subst").click(function () {
            create_new_subst();
        });


        $("#btn_edit_subst").off();
        $("#btn_edit_subst").click(function () {
            edit_subst();
        });

        $(".btn_grid_destroy_item").click(function () {
            var $this = $(this);
            var item_id = $this.data('grid_item_id');
            destroy_subst(item_id);
        });
    });

    $(document).on("click", ".btn_grid_item_edit", function () {
        var $this = $(this);
        var item_id = $this.data('grid_item_id');
        generate_edit_form(item_id);


    });

    $(document).on("click", "#btn_cancel_add_new_subst", function () {
        $('a[href="#substs_list"]').click();
        document.getElementById('create_new_subst').reset();


    });

    $(document).ready(function () {
        substsDataTable('SubstsGrid');
    });
</script>