<script>
    var Roles_Grid = "";
    var Permissions_Grid = "";
    var Categories_Grid = "";
    var RoleUsers_Grid = '';
    {{--    var cats = {!! json_encode($cats) !!}--}}

    function reload_Grid_Table(grid, type) {
        if (type == 0)
            window[grid].ajax.reload();
        else if (type == 1)
            grid.ajax.reload()
    }

    function Data_Tables_Roles_Grid() {
        Roles_Grid = $('#Roles_Grid').DataTable({
            "dom": window.CommonDom_DataTables,
            initComplete: function () {
                $("div.toolbar")
                    .html('' +
                        '<button class="btn btn-info fa fa-plus btn_grid_add_role" type="button">' +
                        '   <i ></i> ' +
{{--                        '   {{ trans('app.add_new_role')}}' +--}}
                        '</button>'
                    );
            },
            "processing": true,
            "serverSide": true,
            "language": window.LangJson_DataTables,
            ajax: {
                url: '{!! route('hamahang.acl.get_roles') !!}',
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
                },
                {
                    data: 'display_name',
                    mRender: function (data, type, full) {
                        return '<span>' + full.display_name + '<span>';
                    }
                },
                {
                    data: 'users_count',
                    searchable: false,
                    mRender: function (data, type, full) {
                        return '<a title="نمایش کاربران نقش" style="cursor: pointer;" class="grid_role_users" ' +
                            'data-role_id="' + full.id + '" ' +
                            'data-role_display_name="' + full.display_name + '" ' +
                            'data-role_name="' + full.name + '">' +
                            '<span>' + full._users_count + '<span></a>';
                    }
                },
                {
                    data: 'permissions_count',
                    searchable: false,
                    mRender: function (data, type, full) {
                        return '<a title="نمایش مجوزهای نقش" style="cursor: pointer;" class="get_role_permission"  data-item_id="' + full.id + '" data-item_name="' + full.display_name + '" >' + full._permissions_count + '</a>';
                    }
                },
                {
                    data: 'action',
                    searchable: false,
                    mRender: function (data, type, full) {
                        var result = '';
//                        if (full.edit_access) {
                        result += '' +
                            '   <button type="button" class="btn btn-xs bg-warning-400 fa fa-edit btn_grid_role_edit" ' +
                            '      data-grid_item_id="' + full.id + '" data-grid_item_name="' + full.name + ' " data-grid_type="role" ' +
                            '      data-grid_item_display_name="' + full.display_name + '" data-grid_item_description="' + full.description + '">' +
                            '   </button>';
//                        }
                        result += '' +
                            '   <button type="button" class="btn btn-xs bg-danger-800 fa fa-trash-o btn_grid_destroy_role" ' +
                            '      data-item_type="role" data-grid_item_id="' + full.id + '" ' +
                            '      data-grid_item_name="' + full.name + '">' +
                            '   </button>';
                        return result;
                    }
                }
            ]
        });
    }
    function Data_Tables_UsersPermissions_Grid() {
        UsersPermissions_Grid = $('#UsersPermissions_Grid').DataTable({
            "dom": window.CommonDom_DataTables,
            initComplete: function () {
                {{--$("div.toolbar")--}}
                {{--.html('' +--}}
                {{--'<button class="btn btn-info btn_grid_add_role" type="button">' +--}}
                {{--'   <i ></i> ' +--}}
                {{--'   {{ trans('app.add_new_role')}}' +--}}
                {{--'</button>'--}}
                {{--);--}}
            },
            "processing": true,
            "serverSide": true,
            "language": window.LangJson_DataTables,
            ajax: {
                url: '{!! route('hamahang.acl.get_user_permissions') !!}',
                "data": {
                    "user_id": $('#users_name').val(),
                    "permission_type": $('#permission_type').val(),
                },
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
                },
                {
                    data: 'display_name',
                    mRender: function (data, type, full) {
                        return '<span>' + full.display_name + '<span>';
                    }
                },
                {
                    data: 'action',
                    mRender: function (data, type, full) {
                        return '' +
                            '<button type="button" class="btn btn-xs bg-danger-800 fa fa-trash-o btn_grid_destroy_user_permission" ' +
                            '   data-item_type="permission" data-grid_user_id="' + full.user_id + '" ' +
                            '   data-grid_role_id="' + full.role_id + '">' +
                            '</button>';
                    }
                }
            ]
        });
    }

    function Data_Tables_Permissions_Grid() {
        $("div.toolbar").html('');
        Permissions_Grid = $('#Permissions_Grid').DataTable({
            "dom": window.CommonDom_DataTables,
            initComplete: function () {
                $("div.toolbar")
                    .html('' +
                        '<button class="btn btn-info fa fa-plus btn_grid_add_permission" type="button">' +
                        '   <i ></i> ' +
{{--                        '   {{ trans('app.add_new_permission')}}' +--}}
                        '</button>'
                    );
            },
            "processing": true,
            "serverSide": true,
            "language": window.LangJson_DataTables,
            ajax: {
                url: '{!! route('hamahang.acl.get_permissions') !!}',
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
                    mRender: function (data, type, full) {
                        return '<span>' + full.name + '<span>';
                    }
                },
                {
                    data: 'display_name',
                    mRender: function (data, type, full) {
                        return '<span>' + full.display_name + '<span>';
                    }
                },
                {
                    data: 'action',
                    mRender: function (data, type, full) {
                        return '' +
                            '<button type="button" class="btn btn-xs bg-warning-400 fa fa-edit btn_grid_permission_edit" ' +
                            '   data-grid_item_id="' + full.id + '" data-grid_item_name="' + full.name + '" ' +
                            '   data-grid_item_display_name="' + full.display_name + '" data-grid_item_description="' + full.description + '" data-grid_type="permission">' +
                            '</button> ' +
                            '<button type="button" class="btn btn-xs bg-danger-800 fa fa-trash-o btn_grid_destroy_permission" ' +
                            '   data-item_type="permission" data-grid_item_id="' + full.id + '" ' +
                            '   data-grid_item_name="' + full.name + '">' +
                            '</button>';
                    }
                }
            ]
        });
    }

    function Data_Tables_Categories_Grid() {
        Categories_Grid = $('#Categories_Grid').DataTable({
            "dom": window.CommonDom_DataTables,
            initComplete: function () {
                $("div.toolbar")
                    .html('' +
                        '<button class="btn btn-info fa fa-plus btn_grid_add_category" type="button">' +
                        '   <i ></i> ' +
{{--                        '   {{ trans('app.add_new_permission_category')}}' +--}}
                        '</button>'
                    );
            },
            "processing": true,
            "serverSide": true,
            "language": window.LangJson_DataTables,
            ajax: {
                url: '{!! route('hamahang.acl.get_categories') !!}',
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
                    data: 'title',
                    mRender: function (data, type, full) {
                        return '<span>' + full.title + '<span>';
                    }
                },
                {
                    data: 'description',
                    mRender: function (data, type, full) {
                        return '<span>' + full.description + '<span>';
                    }
                },
                {
                    data: 'parent',
                    mRender: function (data, type, full) {
                        if (full.parent_id == 0)
                            return '';
                        else if (full.parent)
                            return '<span>' + full.parent.title + '<span>';
                        else
                            return '';
                    }
                },
                {
                    data: 'action',
                    mRender: function (data, type, full) {
                        return '' +
                            '<button type="button" class="btn btn-xs bg-warning-400 fa fa-edit btn_grid_cat_item_edit" ' +
                            '   data-grid_item_id="' + full.id + '" data-grid_item_title="' + full.title + '" ' +
                            '   data-grid_item_description="' + full.description + '" data-parent_id="' + full.parent_id + '">' +
                            '</button> ' +
                            '<button type="button" class="btn btn-xs bg-danger-800 fa fa-trash-o btn_grid_destroy_category" ' +
                            '   data-item_type="cat" data-grid_item_id="' + full.id + '" ' +
                            '   data-grid_item_name="' + full.title + '">' +
                            '</button>';
                    }
                },
            ]
        });
    }

    function set_edit_form_role(id, name, display_name, description) {
        $('#edit_form_role_id').val(id);
        $('#modal_edit_title').html(name);
        $('#modal_edit_role_name').val(name);
        $('#modal_edit_role_display_name').val(display_name);
        $('#modal_edit_role_description').val(description);
        $('#modal_edit_role').modal('show');
    }

    function set_edit_form_permission(id, name, display_name, description) {
        $('#edit_form_permission_id').val(id);
        $('#modal_edit_title').html(name);
        $('#modal_edit_permission_name').val(name);
        $('#modal_edit_permission_display_name').val(display_name);
        $('#modal_edit_permission_description').val(description);
        $('#modal_edit_permission').modal('show');
    }

    function set_edit_cat_form_item(id, title, description, parent_id) {
        $('#edit_cat_id').val(id);
        $('#modal_edit_parent_list').val(parent_id).trigger("change");
        $('.modal_edit_cat_title').val(title);
        $('#modal_edit_cat_description').val(description);
        $('#modal_edit_cat_item').modal('show');
    }

    function add_new_role() {
        var form_data = $('#form_add_role').serialize();
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.acl.add_new_role')}}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                if (result.success == true) {
                    $('#modal_add_new_role').modal('hide');
                    messageModal('success', 'افزودن نقش جدید', result.message);
                    document.getElementById('form_add_role').reset();
                    reload_Grid_Table(Roles_Grid, 1);
                    $('#modal_edit_item').modal('hide');
                }
                else {
                    messageModal('error', 'خطا در ثبت نقش جدید', result.error);
                }
            }
        });
    }

    function add_new_permission() {
        var form_data = $('#form_add_permission').serialize();
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.acl.add_new_permission')}}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                if (result.success == true) {
                    $('#modal_add_new_permission').modal('hide');
                    messageModal('success', 'افزودن مجوز جدید', result.message);
                    document.getElementById('form_add_permission').reset();
                    reload_Grid_Table(Permissions_Grid, 1);
                }
                else {
                    messageModal('error', 'خطا در ثبت مجوز جدید', result.error);
                }
            }
        });
    }

    function add_new_category() {
        var form_data = $('#form_add_category').serialize();
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.acl.add_new_category')}}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                if (result.success == true) {
                    $('#modal_add_new_category').modal('hide');
                    messageModal('success', 'افزودن دسته‌بندی مجوز جدید', result.message);
                    document.getElementById('form_add_category').reset();
                    reload_Grid_Table(Categories_Grid, 1);
                    list_category_parents_list(result.cats);
                }
                else {
                    messageModal('error', 'خطا در ثبت دسته‌بندی مجوز جدید', result.error);
                }
            }
        });
    }

    function update_form_role_item() {
        var form_data = $('#form_edit_role').serialize();
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.acl.update_role')}}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                if (result.success == true) {
                    messageModal('success', 'ویرایش نقش', result.message);
                    document.getElementById('form_edit_role').reset();
                    reload_Grid_Table(Roles_Grid, 1);
                    $('#modal_edit_role').modal('hide');
                }
                else {
                    messageModal('error', 'خطا در ویرایش نقش', result.error);
                }
            }
        });
    }

    function update_form_permission_item() {
        var form_data = $('#form_edit_permission').serialize();
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.acl.update_permission')}}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                if (result.success == true) {
                    messageModal('success', 'ویرایش مجوز', result.message);
                    document.getElementById('form_edit_permission').reset();
                    reload_Grid_Table(Permissions_Grid, 1);
                    $('#modal_edit_permission').modal('hide');
                }
                else {
                    messageModal('error', 'خطا در ویرایش مجوز', result.error);
                }
            }
        });
    }

    function update_form_cat_item() {
        var form_data = $('#form_edit_cat_item').serialize();
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.acl.update_category')}}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                if (result.success == true) {
                    messageModal('success', 'ویرایش دسته‌بندی مجوز', result.message);
                    document.getElementById('form_edit_cat_item').reset();
                    reload_Grid_Table(Categories_Grid, 1);
                    $('#modal_edit_cat_item').modal('hide');
                }
                else {
                    messageModal('error', 'خطا در ویرایش دسته‌بندی مجوز', result.error);
                }
            }
        });
    }

    function get_role_users(item_id) {
        RoleUsers_Grid = $('#roleUserGrid').DataTable({
            "dom": window.CommonDom_DataTables,
            destroy: true,
            "processing": true,
            "serverSide": true,
            "language": window.LangJson_DataTables,
            ajax: {
                url: '{!! route('hamahang.acl.get_role_users') !!}',
                "data": {
                    "role_id": item_id
                },
                type: 'POST'
            },
            columns: [
                {
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    render: function (data, type, full) {
                        return full.row_id;
                    }
                },
                {
                    data: 'Uname',
                    mRender: function (data, type, full) {
                        var users_list = '<input type="checkbox" value="' + full.Uname + '">';
                        $('#users_list_to_add_to_role').append(users_list);
                        return '<a href="/' + full.Uname + '" target="_blank"><span>' + full.Uname /*+ ' (' + full.Name + ' ' + full.Family + ')'*/ + '</span></a>';
                    }
                },
                {
                    name: 'Name',
                    data: 'Name',
                    mRender: function (data, type, full) {
                        if (full.Name)
                            return full.Name;
                        else
                            return '';
                    }
                },
                {
                    name: 'Family',
                    data: 'Family',
                    mRender: function (data, type, full) {
                        if (full.Family)
                            return full.Family;
                        else
                            return '';
                    }
                },
                {
                    data: 'Email',
                    mRender: function (data, type, full) {
                        return '<span>' + full.Email + '</span>';
                    }
                },
                {
                    searchable: false,
                    sortable: false,
                    data: 'jalali_reg_date',
                    mRender: function (data, type, full) {
                        return full.jalali_reg_date;
                    }
                },
                {
                    searchable: false,
                    sortable: false,
                    data: 'action', name: 'remove_user',
                    mRender: function (data, type, full) {
                        var result = '';
                        result += '' +
                            '<button style="margin-right: 3px;" title="حذف کاربر از فهرست" type="button" class="btn btn-xs bg-danger-800 fa fa-times btn_grid_remove_role_user" data-grid_item_id="' + full.id + '"></button>';
                        return result;
                    }
                }
            ]
        });


        $('#modal_manage_role_users').modal('show');
    }

    function destroy_role(item_id, item_name) {
        confirmModal({
            title: '{{trans('acl.remove_role')}}',
            message: '{{trans('access.are_you_sure')}}',
            onConfirm: function () {
                $.ajax({
                    url: '{!! route('hamahang.acl.destroy_role')!!}',
                    type: 'POST', // Send post dat
                    dataType: "json",
                    data: {
                        item_id: item_id
                    },
                    async: false,
                    success: function (result) {
                        if (result.success == true) {
                            reload_Grid_Table(Roles_Grid, 1);
                        }
                        else {
                            messageModal('error', 'خطا در حذف', result.error);
                        }
                    }
                });
            },
            afterConfirm: 'close'
        });
    }

    function destroy_permission(item_id, item_name) {
        confirmModal({
            title: '{{trans('acl.remove_permission')}}',
            message: '{{trans('access.are_you_sure')}}',
            onConfirm: function () {
                $.ajax({
                    url: '{!! route('hamahang.acl.destroy_permission')!!}',
                    type: 'POST', // Send post dat
                    dataType: "json",
                    data: {
                        item_id: item_id
                    },
                    async: false,
                    success: function (result) {
                        if (result.success == true) {
                            reload_Grid_Table(Permissions_Grid, 1);
                        }
                        else {
                            messageModal('error', 'خطا در حذف', result.error);
                        }
                    }
                });
            },
            afterConfirm: 'close'
        });
    }

    function destroy_user_permission(item_id, item_name) {
        alert('hi hadi');
        {{--confirmModal({--}}
        {{--title: '{{trans('acl.remove_permission')}}',--}}
        {{--message: '{{trans('access.are_you_sure')}}',--}}
        {{--onConfirm: function () {--}}
        {{--$.ajax({--}}
        {{--url: '{!! route('hamahang.acl.destroy_permission')!!}',--}}
        {{--type: 'POST', // Send post dat--}}
        {{--dataType: "json",--}}
        {{--data: {--}}
        {{--item_id: item_id--}}
        {{--},--}}
        {{--async: false,--}}
        {{--success: function (result) {--}}
        {{--if (result.success == true) {--}}
        {{--reload_Grid_Table(Permissions_Grid, 1);--}}
        {{--}--}}
        {{--else {--}}
        {{--messageModal('error', 'خطا در حذف', result.error);--}}
        {{--}--}}
        {{--}--}}
        {{--});--}}
        {{--},--}}
        {{--afterConfirm: 'close'--}}
        {{--});--}}
    }

    function destroy_cat_permission(item_id, item_name) {
        confirmModal({
            title: '{{trans('acl.remove_acl_category')}}',
            message: '{{trans('access.are_you_sure')}}',
            onConfirm: function () {
                $.ajax({
                    url: '{!! route('hamahang.acl.destroy_category')!!}',
                    type: 'POST', // Send post dat
                    dataType: "json",
                    data: {
                        item_id: item_id
                    },
                    async: false,
                    success: function (result) {
                        if (result.success == true) {
                            reload_Grid_Table(Categories_Grid, 1);
                        }
                        else {
                            messageModal('error', 'خطا در حذف', result.error);
                        }
                    }
                });
            },
            afterConfirm: 'close'
        });
    }

    function remove_role_users(item_id, role_id) {
        confirmModal({
            title: '{{trans('acl.remove_role_user')}}',
            message: '{{trans('access.are_you_sure')}}',
            onConfirm: function () {
                $.ajax({
                    url: '{!! route('hamahang.acl.remove_role_user')!!}',
                    type: 'POST', // Send post dat
                    dataType: "json",
                    data: {
                        item_id: item_id,
                        role_id: role_id
                    },
                    async: false,
                    success: function (result) {
                        if (result.success == true) {
                            reload_Grid_Table(Roles_Grid, 1);
                            $('#modal_manage_role_users').modal('hide');
                        }
                        else {
                            messageModal('error', 'خطا در حذف', result.error);
                        }
                    }
                });
            },
            afterConfirm: 'close'
        });
    }

    $(document).ready(function()
    {
        $('#UsersPermissions_Grid').DataTable({});
        /*
        $('.get_user_permissions_form_btn').change(function () {
            $('#list_user_permissions').html('');
            $('#list_user_permissions').addClass('loader');
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.acl.get_user_permissions')}}',
                dataType: "json",
                data: {
                    user_id: $(".modal_users_list_user_permission").val()
                },
                success: function (result) {
                    $('#list_user_permissions').removeClass('loader');
                    $('#list_user_permissions').html('');
                    if (result.success == true) {
                        if(result.view) {
                            $('.set_user_permissions_form_btn').removeClass('hide');
                            $('#list_user_permissions').html(result.view);
                            $('.styled').uniform();
                        }
                        else {
                            $('.set_user_permissions_form_btn').addClass('hide');
                            $('#list_user_permissions').html('دسته‌بندی مجوزی ثبت نشده است.');
                        }
                    }
                    else {
                        messageModal('error', 'خطا در واکشی اطلاعات', result.error);
                    }


                }
            });
        });
        */
        $('.get_user_permissions_form_btn').click(function () {
            var tb = 0;
            $('.set_user_permissions_form_btn').addClass('hide');
            $('.cancel_user_permissions_form_btn').addClass('hide');
            if($('#permission_type').val()=='cases')
            {
                $('#list_user_permissions').html('');
                $('#list_user_permissions').addClass('loader');
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.acl.get_user_permissions')}}',
                    dataType: "json",
                    data: {
                        user_id: $("#users_name").val(),
                        permission_type: $('#permission_type').val()
                    },
                    success: function (result) {
                        $('#list_user_permissions').removeClass('loader');
                        $('#list_user_permissions').html('');
                        if (result.success == true) {
                            if(result.view) {
                                $('.set_user_permissions_form_btn').removeClass('hide');
                                $('.cancel_user_permissions_form_btn').removeClass('hide');
                                $('#list_user_permissions').html(result.view);
                                $('.styled').uniform();
                                $('#UsersPermissions_Grid_Row').addClass('hide');
                            }
                            else {
                                $('.set_user_permissions_form_btn').addClass('hide');
                                $('#list_user_permissions').html('دسته‌بندی مجوزی ثبت نشده است.');
                            }
                        }
                        else {
                            messageModal('error', 'خطا در واکشی اطلاعات', result.error);
                        }


                    }
                });
            }
            else
            {
                $('#UsersPermissions_Grid_Row').removeClass('hide');
                $('#UsersPermissions_Grid').dataTable().fnDestroy();
                Data_Tables_UsersPermissions_Grid();
            }

        });

        Data_Tables_Roles_Grid();

        $(".modal_users_list").select2({
            minimumInputLength: 2,
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
                processResults: function (data) {
                    return {
                        results: data.results
                    };
                },
                cache: true
            }
        });

        $(".modal_parent_list").select2({
            minimumInputLength: 2,
            dir: "rtl",
            width: '100%',
            ajax: {
                url: "{{ route('auto_complete.acl_parents_list') }}",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.results
                    };
                },
                cache: true
            }
        });

        $(document).on("click", ".roles_tab", function () {
            if (Roles_Grid) {
                reload_Grid_Table(Roles_Grid, 1);
            }
            else
                Data_Tables_Roles_Grid();
            $("div.toolbar")
                .html('' +
                    '<button class="btn btn-info fa fa-plus btn_grid_add_role" type="button">' +
                    '   <i ></i> ' +
{{--                    '   {{ trans('app.add_new_role')}}' +--}}
                    '</button>'
                );
        });

        $(document).on("click", ".permissions_tab", function () {
            if (Permissions_Grid)
                reload_Grid_Table(Permissions_Grid, 1);
            else
                Data_Tables_Permissions_Grid();
            $("div.toolbar")
                .html('' +
                    '<button class="btn btn-info fa fa-plus btn_grid_add_permission" type="button">' +
                    '   <i ></i> ' +
{{--                    '   {{ trans('app.add_new_permission')}}' +--}}
                    '</button>'
                );
        });

        $(document).on("click", ".acl_cats_tab", function () {
            if (Categories_Grid)
                reload_Grid_Table(Categories_Grid, 2);
            else
                Data_Tables_Categories_Grid();
            $("div.toolbar")
                .html('' +
                    '<button class="btn btn-info fa fa-plus btn_grid_add_category" type="button">' +
                    '   <i ></i> ' +
{{--                    '   {{ trans('app.add_new_permission_category')}}' +--}}
                    '</button>'
                );
        });

        $(document).on("click", ".acl_user_permissions_tab", function () {
            $("div.toolbar")
                .html('');
        });

        $(document).on("click", ".btn_grid_add_role", function () {
            $('#modal_add_new_role').modal('show');
        });

        $(document).on("click", ".btn_grid_add_permission", function () {
            $('#modal_add_new_permission').modal('show');
        });

        $(document).on("click", ".btn_grid_add_category", function () {
            $('#modal_add_new_category').modal('show');
        });

        $(document).on("click", ".btn_add_new_role", function () {
            add_new_role()
        });

        $(document).on("click", ".btn_add_new_permission", function () {
            add_new_permission()
        });

        $(document).on("click", ".btn_add_new_category", function () {
            add_new_category()
        });

        $(document).on("click", ".btn_edit_role", function () {
            update_form_role_item();
        });

        $(document).on("click", ".btn_edit_permission", function () {
            update_form_permission_item();
        });

        $(document).on("click", ".btn_edit_cat_item", function () {
            update_form_cat_item();
        });

        $(document).on("click", ".btn_grid_role_edit", function () {
            var $this = $(this);
            var id = $this.data('grid_item_id');
            var name = $this.data('grid_item_name');
            var display_name = $this.data('grid_item_display_name');
            var description = $this.data('grid_item_description');
            set_edit_form_role(id, name, display_name, description);
        });

        $(document).on("click", ".btn_grid_permission_edit", function () {
            var $this = $(this);
            var id = $this.data('grid_item_id');
            var name = $this.data('grid_item_name');
            var display_name = $this.data('grid_item_display_name');
            var description = $this.data('grid_item_description');
            set_edit_form_permission(id, name, display_name, description);
        });

        $(document).on("click", ".btn_grid_cat_item_edit", function () {
            var $this = $(this);
            var id = $this.data('grid_item_id');
            var parent_id = $this.data('parent_id');
            var title = $this.data('grid_item_title');
            var description = $this.data('grid_item_description');
            set_edit_cat_form_item(id, title, description, parent_id);
        });

        $(document).on("click", ".btn_grid_destroy_role", function () {
            var $this = $(this);
            var item_id = $this.data('grid_item_id');
            var item_name = $this.data('grid_item_name');
            destroy_role(item_id, item_name);
        });

        $(document).on("click", ".btn_grid_destroy_permission", function () {
            var $this = $(this);
            var item_id = $this.data('grid_item_id');
            var item_name = $this.data('grid_item_name');
            destroy_permission(item_id, item_name);
        });

        $(document).on("click", ".btn_grid_destroy_user_permission", function () {
            var $this = $(this);
            var role_id = $this.data('grid_role_id');
            var user_id = $this.data('grid_user_id');
            destroy_user_permission(role_id, user_id);
        });

        $(document).on("click", ".btn_grid_destroy_category", function () {
            var $this = $(this);
            var item_id = $this.data('grid_item_id');
            var item_name = $this.data('grid_item_name');
            destroy_cat_permission(item_id, item_name);
        });

        $(document).on("click", ".get_role_permission", function () {
            var $this = $(this);
            
            var item_id = $this.data('item_id');
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.acl.get_role_permissions')}}',
                dataType: "json",
                data: {item_id: item_id},
                success: function (result) {
                    if (result.success == true) {
                        if (result.view) {
                            $('.set_role_permissions_form_btn').removeClass('hide');
                            $('#role_permissions').html(result.view);
                        }
                        else {
                            $('.set_role_permissions_form_btn').addClass('hide');
                            $('#role_permissions').html('دسته‌بندی مجوزی ثبت نشده است.');
                        }

                        var li_tab = '' +
                            '<li class="">' +
                            '   <a href="#acl_cats_manage_tab_pan" data-toggle="tab" id="acl_cats_manage_tab" class="legitRipple edit_cat_tab" aria-expanded="false">' +
                            '       <span class=""></span>' +
                            '{{trans('acl.manage_role_permissions')}}' + ' ' + $this.data('item_name')
                            '   </a>' +
                            '</li>';

                        $('.edit_cat_tab').remove();
                        $('#manage_tab_pane').append(li_tab);
                        $('#acl_cats_manage_tab').click();
                    }

                    else {
                        messageModal('error', 'خطا در واکشی اطلاعات', result.error);
                    }
                }
            });
        })

        $(document).on("click", ".acl_cats_manage_tab_pan", function () {
            var $this = $(this);
            var item_id = $this.data('item_id');
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.acl.get_role_permissions')}}',
                dataType: "json",
                data: {item_id: item_id},
                success: function (result) {
                    if (result.success == true) {
                        $('#role_permissions').html(result.view);
                        $('.styled').uniform();

                        var li_tab = '' +
                            '<li class="">' +
                            '   <a href="#acl_cats_manage_tab_pan" data-toggle="tab" id="acl_cats_manage_tab" class="legitRipple edit_role_permission_tab" aria-expanded="false">' +
                            '       <span class=""></span>' +
                            '{{trans('backend.manage_permissions_categories_manage')}}' +
                            '   </a>' +
                            '</li>';

                        $('.edit_cat_tab').remove();
                        $('#manage_tab_pane').append(li_tab);
                        $('#acl_cats_manage_tab').click();

                    }
                    else {
                        print_ajax_error(result.error, "error_msg")
                    }


                }
            });
        });

        $(document).on("click", ".set_role_permissions_form_btn", function () {
//            var checked_permissions = $("input[name='selected_permission']").val();
//            var role_id = $("input[name='selected_permission']").data('role_id');
//            var checked_permissions = $('.checkbox_permissions:checkbox:checked').val();
//            var checked_permissions = $('.checkbox_permissions').val();
//            var role_id = $('.checkbox_permissions').data('role_id');
//            var form_data = $('#form_get_Permission_roles').serialize();
            var checked_permissions = $('[name="selected_permission[]"]').serialize();
            var role_id = $('#form_roles_id').val();
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.acl.set_role_permissions')}}',
                dataType: "json",
                data: checked_permissions + '&id=' + role_id,
                success: function (result) {
                    if (result.success == true) {
                        reload_Grid_Table(Roles_Grid, 1);
                        $('#role_permissions').html(result.view);
                        $('.edit_cat_tab').remove();
                        $('.roles_tab').click();
                    }
                    else {
                        messageModal('error', 'خطا در ثبت مجوزهای نقش', result.result);
                    }
                }
            });
        });

        $(document).on("click", ".set_user_permissions_form_btn", function () {
            var checked_permissions = $('[name="selected_permission[]"]').serialize();
            var user_id = $('#form_users_id').val();
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.acl.set_user_permissions')}}',
                dataType: "json",
                data: checked_permissions + '&id=' + user_id,
                success: function (result) {
                    if (result.success == true) {
                        messageModal('success', 'ثبت مجوزهای کاربر', result.result);
                        reload_Grid_Table(Roles_Grid, 1);
                        $('#role_permissions').html(result.view);
                        $('.edit_cat_tab').remove();
                        $('.acl_user_permissions_tab').click();
                    }
                    else {
                        messageModal('error', 'در ثبت مجوزهای کاربر خطایی رخ داده است.', result.result);
                    }
                }
            });
        });

        $(document).on("click", ".grid_role_users", function () {
            var $this = $(this);
            var role_id = $this.data('role_id');
            var role_name = $this.data('role_name');
            var role_display_name = $this.data('role_display_name');
            $('#modal_manage_role_users_role_title').html(role_display_name + '(' + role_name + ')');
            $('#attach_role_users').val(role_id);
            get_role_users(role_id);
        });

        $(document).on("click", ".btn_grid_remove_role_user", function () {
            var $this = $(this);
            var item_id = $this.data('grid_item_id');
            var role_id = $('#attach_role_users').val();
            remove_role_users(item_id, role_id);
        });

        $(document).on("click", ".add_user_to_role_btn", function () {
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.acl.set_role_users')}}',
                dataType: "json",
                data: $('#form_add_role_user').serialize(),
                success: function (result) {
                    if (result.success == true) {
                        messageModal('success', 'افزودن کاربر به نقش', result.message);
                        reload_Grid_Table(Roles_Grid, 1);
                        $('a[href="#users_list_tab"]').click();
                        $('.modal_users_list').html('')
                        $('#modal_manage_role_users').modal('hide');
                    }
                    else {
                        messageModal('error', 'خطا در افزودن کاربر به نقش', result.error);
                    }
                }
            });
        });

        $(document).on("click", ".cancel_modal_manage_role_users", function () {
            $('a[href="#users_list_tab"]').click();
            $('#modal_manage_role_users').modal('hide');
            $('.edit_role_permission_tab').html('');
        });

        $(document).on("click", ".cancel_role_permissions_form_btn", function () {
            $('a[href="#roles_tab"]').click();
        });

        $(document).on("click", ".cancel_user_permissions_form_btn", function () {
            $('a[href="#roles_tab"]').click();
        });
    });

</script>