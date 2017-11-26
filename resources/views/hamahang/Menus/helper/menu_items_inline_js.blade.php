<script>

    var Menu_Items_Grid_Table = "";

    function GoToManageTab() {
        $('a[href="#manage_tab"]').click();
    }

    function edit_grid_item() {
        var li_tab = '<li class=""><a href="#edit_tab" data-toggle="tab" class="legitRipple edit_tab" aria-expanded="false"><span class=""></span> {{trans('menus.edit_menu_tab')}}</a></li>';
        $('.edit_tab').remove();
        $('#manage').append(li_tab);
        $('#manage a[href="#edit_tab"]').tab('show');
    }

    function store_add_form_data(form_id) {
        var form_data = $('#' + form_id).serialize();
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.menus.store_menu_item')}}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                if (result.success == true) {
                    messageModal('success', 'افزودن زیرمنو', result.message);
                    document.getElementById(form_id).reset();
                    $('a[href="#manage_tab"]').click();
                    reload_Grid_Table();
                }
                else {
                    messageModal('error', 'خطا در حذف زیرمنو', result.error);
                }
            }
        });
    }

    function update_edit_form_data(form_id) {
        var form_data = $('#' + form_id).serialize();
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.menus.update_menu_item')}}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                //empty_all_msg_area();
                if (result.success == true) {
                    messageModal('success', '{{trans('menus.edit_a_new_menu_item')}}', result.message);
                    document.getElementById(form_id).reset();
                    $('a[href="#manage_tab"]').click();
                    $('.edit_tab').remove();
                    reload_Grid_Table();
                }
                else {
                    messageModal('error', '{{trans('app.operation_is_failed')}}', result.error);
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
                    url: '{{ route('hamahang.menus.destroy_menu_item')}}',
                    dataType: "json",
                    data: {
                        item_id: item_id
                    },
                    success: function (result) {
                        $('#delete-modal').modal('hide');
                        if (result.success == true) {
                            //messageModal('success', 'حذف زیرمنو', result.message);
                            $('a[href="#manage_tab"]').click();
                            reload_Grid_Table();
                        }
                        else {
                            messageModal('error', 'خطا در حذف زیرمنو', result.error);
                        }
                    }
                });
            },
            afterConfirm: 'close'
        });
    }

    function set_status(data) {
        var $this = $(data);
        var id = $this.data('item_id');
        var value = {
            'id': id
        };
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('hamahang.menus.set_status') !!}',
            data: value,
            success: function (result) {
                if (result.success == true) {
                    print_ajax_success_msg(result.message);
                }
                else {
                    print_ajax_error(result.error, "error_msg")
                }
            },
            error: function (jqXHR, exception) {
                print_ajax_error(result.error, "error_msg")
            },
        });
    }

    @permission('posts.hamahang.menus.get_menu_items')
    {{--function Data_Tables_Grid(target_id, parent_id) {--}}
        {{--Grid_Table = $('#' + target_id).DataTable({--}}
            {{--"dom": window.CommonDom_DataTables,--}}
            {{--"columnDefs": [--}}
                {{--{--}}
                    {{--"targets": [1],--}}
                    {{--"visible": false--}}
                {{--}--}}
            {{--],--}}
            {{--"processing": true,--}}
            {{--"serverSide": true,--}}
            {{--"language": window.LangJson_DataTables,--}}
            {{--"order": [[1, "asc"]],--}}
            {{--ajax: {--}}
                {{--url: '{!! route('hamahang.menus.get_menu_items') !!}',--}}
                {{--data: {--}}
                    {{--menu_id: '{{ $menu->id }}',--}}
                    {{--parent_id: parent_id--}}
                {{--},--}}
                {{--type: 'POST'--}}
            {{--},--}}
            {{--columns: [--}}
                {{--{--}}
                    {{--searchable: false,--}}
                    {{--sortable: false,--}}
                    {{--mRender: function (data, type, full) {--}}
                        {{--return '';--}}
                    {{--}--}}
                {{--},--}}
                {{--{--}}
                    {{--data: 'order',--}}
                    {{--name: 'order',--}}
                    {{--mRender: function (data, type, full) {--}}
                        {{--return '' +--}}
                            {{--'<div class="grid_ordering_elements ordering_disabled">' +--}}
                            {{--'   <table border="0">' +--}}
                            {{--'       <tbody>' +--}}
                            {{--'           <tr>' +--}}
                            {{--'               <td style="padding: 1px!important">' +--}}
                            {{--'                   <a id="ordering_asc">' +--}}
                            {{--'                       <i data-item_id="' + full.id + '" data-order_type="up" data-one_order_step="asc" class="fa fa-2 fa-sort-asc" aria-hidden="true"></i>' +--}}
                            {{--'                   </a>' +--}}
                            {{--'               </td>' +--}}
                            {{--'               <td style="padding: 1px!important;vertical-align: middle" rowspan="2">' +--}}
                            {{--'                   <input id="ordering_input" style="width:30px; text-align: center;" type="text" name="item_order[\'' + full.id + '\']" value="' + full.order + '">' +--}}
                            {{--'                   <a class="save_btn" data-item_id="' + full.id + '" data-order_type="save" data-one_order_step="data">' +--}}
                            {{--'                       <i class="fa fa-save"></i>' +--}}
                            {{--'                   </a>' +--}}
                            {{--'               </td>' +--}}
                            {{--'           </tr>' +--}}
                            {{--'           <tr>' +--}}
                            {{--'               <td style="padding: 1px!important">' +--}}
                            {{--'                   <a>' +--}}
                            {{--'                       <i data-item_id="' + full.id + '" data-order_type="down" data-one_order_step="desc" class="fa fa-2 fa-sort-desc" aria-hidden="true"></i>' +--}}
                            {{--'                   </a>' +--}}
                            {{--'               </td>' +--}}
                            {{--'           </tr>' +--}}
                            {{--'       </tbody>' +--}}
                            {{--'   </table>' +--}}
                            {{--'</div>';--}}
                    {{--}--}}
                {{--},--}}
                {{--{--}}
                    {{--data: 'title',--}}
                    {{--name: 'title'--}}
                {{--},--}}
                {{--{--}}
                    {{--data: 'description',--}}
                    {{--name: 'description'--}}
                {{--},--}}
                {{--{--}}
                    {{--data: 'status',--}}
                    {{--name: 'status',--}}
                    {{--mRender: function (data, type, full) {--}}
                        {{--var ch = '';--}}
                        {{--if (parseInt(full.status))--}}
                            {{--ch = 'checked';--}}
                        {{--else--}}
                            {{--ch = '';--}}
                        {{--return '<input class="styled" type="checkbox" name="special" data-item_id="' + full.id + '" onchange="set_status(this)" ' + ch + '>'--}}
                    {{--}--}}
                {{--},--}}
                {{--{--}}
                    {{--searchable: false,--}}
                    {{--sortable: false,--}}
                    {{--mRender: function (data, type, full) {--}}
                        {{--var result = '';--}}
                        {{--if (full.edit_access) {--}}
                            {{--result += '' +--}}
                                {{--'<button style="margin-right: 3px;" title="ویرایش منو" type="button" class="btn btn-xs bg-warning-400 fa fa-edit btn_grid_item_edit" ' +--}}
                                {{--'   data-grid_item_id="' + full.id + '" ' +--}}
                                {{--'   data-grid_item_parent_id="' + full.parent_id + '" ' +--}}
                                {{--'   data-grid_item_title="' + full.title + '" ' +--}}
                                {{--'   data-grid_item_description="' + full.description + '" ' +--}}
                                {{--'   data-grid_item_href_type="' + full.href_type + '" ' +--}}
                                {{--'   data-grid_item_href="' + full.href + '" ' +--}}
                                {{--'   data-grid_item_target="' + full.target + '" ' +--}}
                                {{--'   data-grid_item_status="' + full.status + '" ' +--}}
                                {{--'   data-grid_item_icon="' + full.icon + '" ' +--}}
                                {{--'   data-grid_item_permitted_users=\'' + JSON.stringify(full.permitted_users) + '\'' +--}}
                                {{--'   data-grid_item_permitted_roles=\'' + JSON.stringify(full.permitted_roles) + '\'>' +--}}
                                {{--'</button>';--}}
                        {{--}--}}
                        {{--if (full.delete_access) {--}}
                            {{--result += '' +--}}
                                {{--'<button style="margin-right: 3px;" title="حذف منو" type="button" class="btn btn-xs bg-danger-800 fa fa-trash-o btn_grid_destroy_item" data-grid_item_id="' + full.id + '" data-grid_item_name="' + full.title + '"></button>';--}}
                        {{--}--}}
                        {{--result += '' +--}}
                            {{--'<button style="margin-right: 3px;" title="ثبت مجوز دسترسی" type="button" class="btn btn-xs bg-info-800 fa fa-lock btn_grid_add_permission" ' +--}}
                            {{--'   data-grid_item_id="' + full.id + '" ' +--}}
                            {{--'   data-grid_item_permitted_users=\'' + JSON.stringify(full.permitted_users) + '\'' +--}}
                            {{--'   data-grid_item_permitted_roles=\'' + JSON.stringify(full.permitted_roles) + '\'' +--}}
                            {{--'   data-grid_item_name="' + full.title + '">' +--}}
                            {{--'</button>';--}}
                        {{--return result;--}}
                    {{--}--}}
                {{--},--}}
            {{--]--}}
        {{--});--}}
        {{--window.Grid_Table.on('order.dt', function (e, details, edit) {--}}
            {{--console.log(1);--}}
            {{--if (window.Grid_Table.order()[0][0] == 1) {--}}
                {{--$('.grid_ordering_elements').removeClass('ordering_disabled');--}}
            {{--}--}}
            {{--else {--}}
                {{--$('.grid_ordering_elements').addClass('ordering_disabled');--}}
            {{--}--}}
        {{--});--}}
        {{--Grid_Table.on('draw.dt order.dt search.dt', function () {--}}
            {{--Grid_Table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {--}}
                {{--cell.innerHTML = i + 1;--}}
            {{--});--}}
        {{--}).draw();--}}
    {{--}--}}
    @endpermission

    function change_order(id, type, value, order_step) {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.menus.set_item_order')}}',
            dataType: "json",
            data: {
                id: id,
                type: type,
                value: value,
                order_step: order_step
            },
            success: function (result) {
                if (result.success == true) {
                    messageModal('success', 'تغییر ترتیب آیتم منو', result.message);
                    reload_Grid_Table();
                }
                else {
                    messageModal('error', 'خطا در تغییر ترتیب آیتم منو', result.error);
                }
            }
        });
    }

    function reload_Grid_Table() {
        Grid_Table.ajax.reload();
    }

    $(document).ready(function () {

//        $('.available_routes').hide();
//        $('.route_variables').hide();
//        $('.route_name_div').hide();

        $('#filter_parent_id').change(function () {
            Grid_Table.destroy();
            Data_Tables_Grid('GridData', $(this).val());

            if ($(this).val() == -1) {
                Grid_Table.column(1).visible(0);
                $('.grid_ordering_elements').addClass('ordering_disabled');
            }
            else {
                Grid_Table.column(1).visible(1);
                $('.grid_ordering_elements').removeClass('ordering_disabled');
            }
        });

        {{--$(".parent_list").select2({--}}
            {{--minimumInputLength: 2,--}}
            {{--dir: "rtl",--}}
            {{--width: '100%',--}}
            {{--ajax: {--}}
                {{--url: "{{ route('auto_complete.menu_items') }}",--}}
                {{--dataType: 'json',--}}
                {{--type: "POST",--}}
                {{--quietMillis: 50,--}}
                {{--data: function (term) {--}}
                    {{--return {--}}
                        {{--term: term.term,--}}
                        {{--menu_id: '{{$menu->id}}'--}}
                    {{--};--}}
                {{--},--}}
                {{--processResults: function (data) {--}}
                    {{--return {--}}
                        {{--results: data--}}
                    {{--};--}}
                {{--},--}}
                {{--cache: true--}}
            {{--}--}}
        {{--});--}}

        $(".users_list").select2({
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
                    console.log(data);
                    return {
                        results: data.results
                    };
                },
                cache: true
            }
        });

        $(".roles_list").select2({
            minimumInputLength: 2,
            dir: "rtl",
            width: '100%',
            ajax: {
                url: "{{ route('auto_complete.roles') }}",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                processResults: function (data) {
                    console.log(data);
                    return {
                        results: data.results
                    };
                },
                cache: true
            }
        });


        $('input:radio[name="link_type"]').change(function () {
            if ($(this).is(':checked') && $(this).val() == 0) {
                $('.available_routes').show();
                $('.route_name_div').show();
                $('#route_name').prop('readonly', 'readonly');
            }
            else {
                $('.available_routes').hide();
                $('#route_variables').html('');
                $('.route_variables').hide();
                $('#route_name').prop('readonly', '');
                $('.route_name_div').show();
                $('#route_name').show();
                $('#route_name').html();
            }
        });


        function load_old_permissions(item_id) {
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.menus.getMenuPermissions')}}',
                dataType: "json",
                data: {
                    item_id: item_id
                },
                success: function (result) {
                    for (var k in result.user_policy) {
                        $("#users_list").select2("trigger", "select", {
                            data: {id: result.user_policy[k].id, text: result.user_policy[k].name}
                        });
                    }

                }
            });
        }

        $(document).on("click", ".btn_grid_item_edit", function () {
            $("#edit_roles_list").html('');
            $('#edit_users_list').html('');
            var $this = $(this);
            var item_id = $this.data('grid_item_id');
            $('#edit_form_item_id').val(item_id);
            $('#edit_form_item_parent').val($this.data('grid_item_parent_id')).trigger("change");
            $('#edit_form_item_title').val($this.data('grid_item_title'));
            $('#edit_form_item_description').val($this.data('grid_item_description'));
//            $('#edit_form_item_href_type').val();
            $('#edit_form_item_url').val($this.data('grid_item_href'));

            if ($this.data('grid_item_target') == '_self') {

                $("#edit_form_item_self").click();
            }
            else if ($this.data('grid_item_target') == '_blank') {
                $("#edit_form_item_blank").click();
            }

            if ($this.data('grid_item_status')) {
                if (document.querySelector('#edit_form_item_status').checked == false) {
                    $('#edit_form_item_status').click();
                }
            }
            else {
                if (document.querySelector('#edit_form_item_status').checked) {
                    $('#edit_form_item_status').click();
                }
            }
            $('#edit_form_item_icon').val($this.data('grid_item_icon'));

            var item_permitted_users = $this.data('grid_item_permitted_users');
            var users_list = item_permitted_users;
            for (var k in users_list) {
                $("#edit_users_list").select2("trigger", "select", {
                    data: {id: users_list[k].user_id, text: users_list[k].Name + ' ' + users_list[k].Family}
                });
            }

            var item_permitted_roles = $this.data('grid_item_permitted_roles');
            var roles_list = item_permitted_roles;
            for (var n in roles_list) {
                $("#edit_roles_list").select2("trigger", "select", {
                    data: {id: roles_list[n].role_id, text: roles_list[n].name + ' (' + roles_list[n].display_name + ')'}
                });
            }
            edit_grid_item();
        });

        $(document).on("click", ".btn_grid_destroy_item", function () {
            var $this = $(this);
            var item_id = $this.data('grid_item_id');
            var item_name = $this.data('grid_item_name');
            destroy_item(item_id, item_name);
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

        $('.cancel_form_permission_btn').on('click', function () {
            document.getElementById('form_permission_item').reset();
            $('#users_list').html('');
            GoToManageTab();
            $('.select').select2();
            reload_Grid_Table();
        });

        $('.cancel_form_btn').on('click', function () {
            var $this = $(this);
            var form_id = $this.data('form_id');
            if (form_id == 'form_edit_item') {
                document.getElementById(form_id).reset();
                $('.select').select2();
                GoToManageTab();
                $('.edit_tab').remove();
                $('#users_list').html('');
                reload_Grid_Table();
            }
            if (form_id == 'form_created_new') {
                document.getElementById(form_id).reset();
                GoToManageTab();
                $('.select').select2();
                reload_Grid_Table();
            }
        });

        $(document).on("click", ".btn_grid_add_permission", function () {
            $('#users_list').html('');
            $('#roles_list').html('');
            var $this = $(this);
            var item_permitted_users = $this.data('grid_item_permitted_users');
            var users_list = item_permitted_users;
            for (var k in users_list) {
                $("#users_list").select2("trigger", "select", {
                    data: {id: users_list[k].user_id, text: users_list[k].Name + ' ' + users_list[k].Family}
                });
            }

            var item_permitted_roles = $this.data('grid_item_permitted_roles');
            var roles_list = item_permitted_roles;
            for (var n in roles_list) {
                $("#users_list").select2("trigger", "select", {
                    data: {id: roles_list[n].role_id, text: roles_list[n].name + ' (' + roles_list[n].display_name + ')'}
                });
            }

//            load_old_permissions($this.data('grid_item_id'));
            $('#permission_form_item_id').val($this.data('grid_item_id'));
            var item_name = $this.data('grid_item_name');
            $('#menu_item_name').html($('#menu_item_name').html() + item_name);
            var li_tab = '<li class=""><a href="#permission_tab" data-toggle="tab" class="legitRipple permission_tab" aria-expanded="false"><span class=""></span> {{trans('menus.permission_tab')}}</a></li>';
            $('.permission_tab').remove();
            $('#manage').append(li_tab);
            $('#manage a[href="#permission_tab"]').tab('show');
        });

        $(document).on("click", ".submit_form_permission_btn", function () {
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.menus.set_menu_permissions')}}',
                dataType: "json",
                data: $('#form_permission_item').serialize() + '&item_id=' + $('#permission_form_item_id').val(),
                success: function (result) {
                    if (result.success == true) {
                        messageModal('success', 'ذخیره دسترسی‌ها', result.message);
                        $('#users_list').html('');
                        $('#roles_list').html('');
                        location.reload();

                    }
                    else {
                        messageModal('error', 'خطا در ذخیره دسترسی‌ها', result.error);
                    }
                }
            });
        });

        $(document).on("click", ".fa-sort-asc, .fa-sort-desc, .save_btn", function () {
            var $this = $(this);
            var id = $this.data('item_id');
            var type = $this.data('order_type');
            var order_step = Grid_Table.order()[0][1];
            var value = $('input[name="item_order[\'' + id + '\']"]').val();
            change_order(id, type, value, order_step);
        });

        Menu_Items_Grid_Table('MenuItemsGridData', '-1');

    });

</script>