<script>

    Grid_Table = $('#subjectsGrid').DataTable({
        "dom": window.CommonDom_DataTables,
        "processing": true,
        "serverSide": true,
        "language": window.LangJson_DataTables,
        ajax: {
            url: '{!! route('hamahang.subjects.get_subjects') !!}',
            type: 'POST'
        },
        columns: [
            {
                mRender: function (data, type, full) {
                    return '';
                }
            },
            {
                data: 'name',class:'name',
                mRender: function (data, type, full) {
                    return full['name'];
                }
            },
            {
                data: 'comment',
                mRender: function (data, type, full) {
                    return full['comment'];
                }
            },
            {
                mRender: function (data, type, full) {
                    return '<a title="صفحات" href="{!! route('modals.view_subject')  !!}?sid=' + full['id'] + ' "  class="jsPanels viewSubjects">' + full['get_subject_count'] + '</a>';
                }
            },
            {
                mRender: function (data, type, full) {
                    return full['jdate'];
                }
            },
            {
                mRender: function (data, type, full) {
                    var result = '';


                    result += '' +
                        '<button style="margin-right: 3px;" title="ویرایش موضوع" type="button" class="btn btn-xs bg-warning-400 fa fa-edit btn_grid_item_edit" ' +
                        '   data-grid_item_id="' + full['id'] + '" ' +
                        '   data-grid_item_title="' + full['name'] + '" ' +
                        '   data-grid_item_description="' + full['comment'] + '">' +
                        '</button>';


                    result += '' +
                        '<button style="margin-right: 3px;" title="حذف موضوع" type="button" class="btn btn-xs bg-danger-800 fa fa-remove btn_grid_destroy_item" data-grid_item_id="' + full['id'] + '"></button>';

                    return result;
                }
            }
        ]
    });
    Grid_Table.on('draw.dt order.dt search.dt', function () {
        Grid_Table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    $(document).on('click', '.btn_grid_item_edit', function () {
        var item_id = $(this).attr('data-grid_item_id');
        $('.loader').show();
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.subjects.edit_subject_type')}}',
            dataType: "html",
            data: {id: item_id},
            success: function (result) {
                $('.body_edit').html(result);
                $('.edit_btn').click();
                $('.edit_btn').show();
                $('.loader').hide();
            }
        });
    });
    $('.edit_btn').hide();
    $(document).on('click', '.view_btn', function () {
        $('.body_edit').html('');
        $('.edit_btn').hide();
    });

    $(document).on('click', '.add_btn', function () {
        $('.body_edit').html('');
        $('.edit_btn').hide();
        $('.loader').show()
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.subjects.add_subject_type')}}',
            dataType: "html",
            success: function (result) {
                $('.body_add').html(result);
                $('.loader').hide();
            }
        });
    });


    $(document).on('click', '.btn_grid_destroy_item', function () {
        var item_id = $(this).attr('data-grid_item_id');
        var name = $(this).parent().parent().find('.name').html();
        confirmModal({
            title: 'حذف موضوع'+' '+ name,
            message: 'آیا مطمئن هستید ؟',
            onConfirm: function () {
                $('.loader').show();
                $.ajax({
                    type: 'post',
                    url: '{{ route('hamahang.subjects.destroy_subject_type')}}',
                    dataType: "json",
                    data: {id: item_id},
                    success: function (data) {
                        console.log(data.success);
                        if(data.success == false){
                            messageBox('error', '', data.message,{'id': 'alert_subject'});
                        }else{
                            messageBox('success', '', data.message,{'id': 'alert_subject'});
                            Grid_Table.ajax.reload();
                        }
                        $('.loader').hide();
                    },
                })
            },
            afterConfirm: 'close'
        });
    });
</script>