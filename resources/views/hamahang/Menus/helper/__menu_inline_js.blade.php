<script>
    var Grid_Table = "";
    var Menu_Items_Grid_Table = "";
    var SubMenu_Grid_Table = "";

    function GoToManageTab() {
        $('a[href="#manage_tab"]').click();
    }

    function show_delete_modal(id, title) {
        $('#item_id_for_delete').val(id);
        $('#item-name-span').html(title);
        $('#delete-modal').modal('show');
    }

    function edit_grid_item() {
        var li_tab = '<li class=""><a href="#edit_tab" data-toggle="tab" class="legitRipple edit_cat_tab" aria-expanded="false"><span class=""></span> {{trans('menus.edit_tab')}}</a></li>';
        $('.edit_cat_tab').remove();
        $('#manage').append(li_tab);
        $('#manage a[href="#edit_tab"]').tab('show');
    }

    function show_menu_items(item_id, item_title) {
        $('#gallery_parent_title').html('آیتم‌های ' + item_title);
        if (SubMenu_Grid_Table)
            SubMenu_Grid_Table.destroy();
        load_menu_items(item_id);
        var li_tab = '<li class=""><a href="#list_submenu_tab" data-toggle="tab" class="legitRipple" aria-expanded="false"><span class="fa fa-edit"></span> {{trans('menus.list_submenu_tab')}}</a></li>';
        $('.edit_cat_tab').remove();
        $('#manage').append(li_tab);
        $('#manage a[href="#list_submenu_tab"]').tab('show');
    }

    function store_add_form_data(form_id) {
        var form_data = $('#' + form_id).serialize();
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.menus.store_menu')}}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                if (result.success == true) {
                    messageModal('success', 'افزودن منوی جدید', result.message);
                    document.getElementById(form_id).reset();
                    $('a[href="#manage_tab"]').click();
                    reload_Grid_Table();
                }
                else {
                    messageModal('error', 'خطا در ویرایش منو', result.error);
                }
            }
        });
    }

    function load_menu_items(item_id) {
        SubMenu_Grid_Table = $('#MenuItemsGridData').DataTable({
            "dom": window.CommonDom_DataTables,
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "language": window.LangJson_DataTables,
            ajax: {
                url: '{!! route('hamahang.menus.get_menu_items') !!}',
                "data": {
                    "item_id": item_id
                },
                type: 'POST'
            },
            columns: [
                {data: 'id'},
                {data: 'title'},
                {data: 'description'},
                {
                    data: 'action', name: 'action',
                    mRender: function (data, type, full) {
                        return '' +
                            '<button style="margin-right: 3px;" title="افزودن زیر منو" type="button" class="btn btn-xs bg-info-400 fa fa-plus btn_add_menu_item" data-grid_item_id="' + full.id + '"></button>' +
                            '<button style="margin-right: 3px;" title="ویرایش منو" type="button" class="btn btn-xs bg-warning-400 fa fa-edit btn_grid_item_edit" data-grid_item_id="' + full.id + '"></button>' +
                            '<button style="margin-right: 3px;" title="حذف منو" type="button" class="btn btn-xs bg-danger-800 fa fa-remove" onclick="show_delete_modal(\'' + full.id + '\', \'' + full.title + '\')"></button>';
                    }
                },
            ]
        });
        SubMenu_Grid_Table.on('draw.dt order.dt search.dt', function () {
            SubMenu_Grid_Table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }

    function update_edit_form_data(form_id) {
        var form_data = $('#' + form_id).serialize();
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.menus.update_menu')}}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                if (result.success == true) {
                    messageModal('success', 'ویرایش منو', result.message);
                    document.getElementById(form_id).reset();
                    $('a[href="#manage_tab"]').click();
                    $('.edit_cat_tab').remove();
                    reload_Grid_Table();
                }
                else {
                    messageModal('error', 'خطا در ویرایش منو', result.error);
                }
            }
        });
    }

    function destroy_item(item_id) {
        confirmModal({
            title: '{{trans('menus.delete_menu')}}',
            message: '{{trans('menus.are_you_sure')}}',
            onConfirm: function () {
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.menus.destroy_menu')}}',
                    dataType: "json",
                    data: {
                        item_id: item_id
                    },
                    success: function (result) {
                        $('#delete-modal').modal('hide');
                        if (result.success == true) {
                            messageModal('success', 'حذف منو', result.message);
                            $('a[href="#manage_tab"]').click();
                            reload_Grid_Table();
                        }
                        else {
                            messageModal('error', 'خطا در حذف منو', result.error);
                        }
                    }
                });
            },
            afterConfirm: 'close'
        });
    }

    @permission('posts.hamahang.menus.get_menus')
    function Data_Tables_Grid(target_id) {
        Grid_Table = $('#' + target_id).DataTable({
            "dom": window.CommonDom_DataTables,
            "processing": true,
            "serverSide": true,
            "language": window.LangJson_DataTables,
            ajax: {
                url: '{!! route('hamahang.menus.get_menus') !!}',
                type: 'POST'
            },
            columns: [
                {data: 'id'},
                {data: 'title'},
                {data: 'description'},
                {
                    data: 'action', name: 'action',
                    mRender: function (data, type, full) {
                        var result = '';
                        if (full.get_menu_items) {
                            result += '' +
                                '<a href="' + '{{ route('UGC.desktop.Hamahang.menus.items', ['username' => $username, 'menu_id' => '']) }}' +'/'+ full.id + '"><button style="margin-right: 3px;" title="مشاهده زیرمنوها" type="button" class="btn btn-xs bg-info-400 fa fa-eye"></button></a>';
                        }
                        if (full.edit_access) {
                            result += '' +
                                '<button style="margin-right: 3px;" title="ویرایش منو" type="button" class="btn btn-xs bg-warning-400 fa fa-edit btn_grid_item_edit" ' +
                                '   data-grid_item_id="' + full.id + '" ' +
                                '   data-grid_item_title="'+ full.title +'" ' +
                                '   data-grid_item_description="'+ full.description +'">' +
                                '</button>';
                        }
                        if (full.delete_access) {
                            result += '' +
                                '<button style="margin-right: 3px;" title="حذف منو" type="button" class="btn btn-xs bg-danger-800 fa fa-trash-o btn_grid_destroy_item" data-grid_item_id="' + full.id + '" data-grid_item_name="' + full.title + '"></button>';
                        }
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
    }
    @endpermission

    function reload_Grid_Table() {
        Grid_Table.ajax.reload();
    }

    $(document).ready(function () {

        $(document).on("mousemove", '[data-popup="tooltip"]', function () {
            var $this = $(this);
            $this.tooltip();
        });

        $(document).on("click", ".btn_grid_item_edit", function () {
            var $this = $(this);
            $('#edit_form_item_id').val($this.data('grid_item_id'));
            $('#edit_form_input_title').val($this.data('grid_item_title'));
            $('#edit_form_input_description').val($this.data('grid_item_description'));
            edit_grid_item();
        });

        $(document).on("click", ".btn_show_menu_items", function () {
            var $this = $(this);
            var item_id = $this.data('grid_item_id');
            var item_title = $this.data('grid_item_title');
            console.log(item_title);
            show_menu_items(item_id, item_title);
        });

        $(document).on("click", ".btn_add_menu_item", function () {
            var $this = $(this);
            var item_id = $this.data('grid_item_id');
            add_menu_item(item_id);
        });

        $(document).on("click", ".btn_edit_or_remove_img", function () {
//            $('#show_old_index_img').hide();
            $('#upload_new_index_img_area').show();
            var $this = $(this);
            $this.parent().parent().parent().remove();
            var item_id = $this.data('item_id');
            remove_index_img(item_id);
        });

        $(document).on("click", ".btn_grid_destroy_item", function () {
            var $this = $(this);
            var item_id = $this.data('grid_item_id');
            destroy_item(item_id);
        });

        $('.submit_form_btn').on('click', function () {
            var $this = $(this);
            var form_id = $this.data('form_id');
            if (form_id == 'form_edit_item') {
                update_edit_form_data(form_id);
            }
            if (form_id == 'form_created_new') {
                store_add_form_data(form_id);
            }
        });

        $('.cancel_form_btn').on('click', function () {
            var $this = $(this);
            var form_id = $this.data('form_id');
            if (form_id == 'form_edit_item') {
                document.getElementById(form_id).reset();
                $('.select').select2();
                GoToManageTab();
                $('.edit_cat_tab').remove();
                reload_Grid_Table();
            }
            if (form_id == 'form_created_new') {
                document.getElementById(form_id).reset();
                GoToManageTab();
                $('.select').select2();
                reload_Grid_Table();
            }
        });

        Data_Tables_Grid('GridData');

    });

</script>