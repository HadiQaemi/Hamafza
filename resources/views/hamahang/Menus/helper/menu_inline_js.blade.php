<script>

    var menus_grid_data = '';
    var menus_items_data = '';

    @permission('posts.hamahang.menus.get_menus')
    function menus_datatable_grid() {
        menus_grid_data = $('#MenusGridData').DataTable({
            "dom": window.CommonDom_DataTables,
            "processing": true,
            "serverSide": true,
            "language": window.LangJson_DataTables,
            ajax: {
                url: '{!! route('hamahang.menus.get_menus') !!}',
                type: 'POST'
            },
            columns: [
                {
                    "data": "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'title'},
                {data: 'description'},
                {
                    data: 'action', name: 'action',
                    mRender: function (data, type, full) {
                        var result = '';
                        if (full.get_menu_items) {
                            result += '' +
                                '<button style="margin-right: 3px;" title="مشاهده زیرشاخه‌ها" type="button" class="btn btn-xs bg-warning-400 fa fa-eye btn_grid_get_menu_items" ' +
                                '   data-grid_item_id="' + full.id + '">' +
                                '</button>';
                        }
                        if (full.edit_access) {
                            result += '' +
                                '<button style="margin-right: 3px;" title="ویرایش منو" href="{!! route('modals.add_edit_menu') !!}?item_id=' + full.id + '" class="jsPanels btn btn-xs bg-warning-400 fa fa-edit" ' +
                                '   data-grid_item_id="' + full.id + '" ' +
                                '   data-grid_item_title="' + full.title + '" ' +
                                '   data-grid_item_description="' + full.description + '" ' +
                                '   data-grid_item_type="edit" ' +
                                '</button>';

//                            result += '' +
//                                '<button style="margin-right: 3px;" title="ویرایش منو" type="button" class="btn btn-xs bg-warning-400 fa fa-edit btn_grid_menu_edit" ' +
//                                '   data-grid_item_id="' + full.id + '" ' +
//                                '   data-grid_item_title="' + full.title + '" ' +
//                                '   data-grid_item_description="' + full.description + '">' +
//                                '</button>';
                        }
                        if (full.delete_access) {
                            result += '' +
                                '<button style="margin-right: 3px;" title="حذف منو" type="button" class="btn btn-xs bg-danger-800 fa fa-trash-o btn_grid_destroy_menu" data-grid_item_id="' + full.id + '" data-grid_item_name="' + full.title + '"></button>';
                        }
                        return result;
                    }
                }
            ]
        });
    }
    @endpermission

    @permission('posts.hamahang.menus.get_menu_items')
    function menu_items_datatable_grid(menu_id, target_id, parent_id) {
        menus_items_data = $('#' + target_id).DataTable({
            "dom": window.CommonDom_DataTables,
            "columnDefs": [
                {
                    "targets": [1],
                    "visible": false
                }
            ],
            "serverSide": true,
            "destroy": true,
            "language": window.LangJson_DataTables,
            "order": [[1, "asc"]],
            ajax: {
                url: '{!! route('hamahang.menus.get_menu_items') !!}',
                data: {
                    menu_id: menu_id,
                    parent_id: parent_id
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
                    'width': '10%',
                    data: 'order',
                    name: 'order',
                    mRender: function (data, type, full) {
                        return '' +
                            '<div class="grid_ordering_elements ordering_disabled">' +
                            '   <table border="0">' +
                            '       <tbody>' +
                            '           <tr>' +
                            '               <td style="padding: 1px!important">' +
                            '                   <a id="ordering_asc">' +
                            '                       <i data-item_id="' + full.id + '" data-order_type="up" data-one_order_step="asc" class="fa fa-2 fa-sort-asc" aria-hidden="true"></i>' +
                            '                   </a>' +
                            '               </td>' +
                            '               <td style="padding: 1px!important;vertical-align: middle" rowspan="2">' +
                            '                   <input id="ordering_input" style="width:30px; text-align: center;" type="text" name="item_order[\'' + full.id + '\']" value="' + full.order + '">' +
                            '                   <a class="save_btn" data-item_id="' + full.id + '" data-order_type="save" data-one_order_step="data">' +
                            '                       <i class="fa fa-save"></i>' +
                            '                   </a>' +
                            '               </td>' +
                            '           </tr>' +
                            '           <tr>' +
                            '               <td style="padding: 1px!important">' +
                            '                   <a>' +
                            '                       <i data-item_id="' + full.id + '" data-order_type="down" data-one_order_step="desc" class="fa fa-2 fa-sort-desc" aria-hidden="true"></i>' +
                            '                   </a>' +
                            '               </td>' +
                            '           </tr>' +
                            '       </tbody>' +
                            '   </table>' +
                            '</div>';
                    }
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    'width': '15%',
                    data: 'status',
                    name: 'status',
                    mRender: function (data, type, full) {
                        var ch = '';
                        if (parseInt(full.status))
                            ch = 'checked';
                        else
                            ch = '';
                        return '<input class="styled" type="checkbox" name="special" data-item_id="' + full.id + '" onchange="set_status(this)" ' + ch + '>'
                    }
                },
                {
                    'width': '15%',
                    searchable: false,
                    sortable: false,
                    mRender: function (data, type, full) {
                        var result = '';
                        var permitted_users = '';
                        if(full.permitted_users.length){
                            for (i = 0; i < full.permitted_users.length; i++) {
                                permitted_users += (permitted_users.trim() == '' ? '' : ',') + full.permitted_users[0].user_id;
                            }
                        }
                        var permitted_roles = '';
                        if(full.permitted_roles.length){
                            for (i = 0; i < full.permitted_roles.length; i++) {
                                permitted_roles += (permitted_roles.trim() == '' ? '' : ',') + full.permitted_roles[0].role_id;
                            }
                        }
                        if (full.edit_access) {
                            result += '' +
                                '<button style="margin-right: 3px;" title="ویرایش منو" href="{!! route('modals.add_edit_menu_items') !!}?item_id=' + full.id + '" class="jsPanels btn btn-xs bg-warning-400 fa fa-edit" ' +
                                //                                '<button style="margin-right: 3px;" title="ویرایش منو" type="button" class="btn btn-xs bg-warning-400 fa fa-edit btn_grid_menu_item_edit" ' +
                                '   data-grid_item_id="' + full.id + '" ' +
                                '   data-grid_item_parent_id="' + full.parent_id + '" ' +
                                '   data-grid_item_title="' + full.title + '" ' +
                                '   data-grid_item_description="' + full.description + '" ' +
                                '   data-grid_item_href_type="' + full.href_type + '" ' +
                                '   data-grid_item_href="' + full.href + '" ' +
                                '   data-grid_item_target="' + full.target + '" ' +
                                '   data-grid_item_status="' + full.status + '" ' +
                                '   data-grid_item_icon="' + full.icon + '" ' +
                                '   data-grid_item_permitted_users=\'' + JSON.stringify(full.permitted_users) + '\'' +
                                '   data-grid_item_permitted_roles=\'' + JSON.stringify(full.permitted_roles) + '\'>' +
                                '</button>';
                        }
                        if (full.delete_access) {
                            result += '' +
                                '<button style="margin-right: 3px;" title="حذف منو" type="button" class="btn btn-xs bg-danger-800 fa fa-trash-o btn_grid_destroy_menu_item" data-grid_item_id="' + full.id + '" data-grid_item_name="' + full.title + '"></button>';
                        }
                        // result += '' +
                        //     '<button style="margin-right: 3px;" title="ثبت مجوز دسترسی" type="button" class="btn btn-xs bg-info-800 fa fa-lock btn_grid_add_permission" ' +
                        //     '   data-grid_item_id="' + full.id + '" ' +
                        //     '   data-grid_item_permitted_users=\'' + JSON.stringify(full.permitted_users) + '\'' +
                        //     '   data-grid_item_permitted_roles=\'' + JSON.stringify(full.permitted_roles) + '\'' +
                        //     '   data-grid_item_name="' + full.title + '">' +
                        //     '</button>';
                        return result;
                    }
                },
            ]
        });
    }
    @endpermission

    function add_new_menu() {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.menus.store_menu')}}',
            dataType: "json",
            data: $('#form_created_new_menu').serialize(),
            success: function (result) {
                if (result.success == true) {
                    jQuery.noticeAdd({
                        text: result.message,
                        stay: false,
                        type: 'success'
                    });
                    menus_grid_data.ajax.reload();
                    $('a[href="#menus_tab"]').click();
                    document.getElementById('form_created_new_menu').reset();
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

    {{--function edit_menu() {--}}
    {{--$.ajax({--}}
    {{--type: "POST",--}}
    {{--url: '{{ route('hamahang.menus.update_menu')}}',--}}
    {{--dataType: "json",--}}
    {{--data: $('#form_created_new_menu').serialize(),--}}
    {{--success: function (result) {--}}
    {{--if (result.success == true) {--}}
    {{--jQuery.noticeAdd({--}}
    {{--text: result.message,--}}
    {{--stay: false,--}}
    {{--type: 'success'--}}
    {{--});--}}
    {{--menus_grid_data.ajax.reload();--}}
    {{--document.getElementById('form_edit_menu').reset();--}}
    {{--$('a[href="#menus_tab"]').click();--}}
    {{--$('.edit_menu_tab').remove();--}}
    {{--}--}}
    {{--else {--}}
    {{--var errors = '';--}}
    {{--for (var k in result.error) {--}}
    {{--errors += '' +--}}
    {{--'<li>' + result.error[k] + '</li>'--}}
    {{--}--}}
    {{--jQuery.noticeAdd({--}}
    {{--text: errors,--}}
    {{--stay: false,--}}
    {{--type: 'error'--}}
    {{--});--}}
    {{--}--}}
    {{--}--}}
    {{--});--}}
    {{--}--}}

    function destroy_menu(item_id) {
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
                            jQuery.noticeAdd({
                                text: result.message,
                                stay: false,
                                type: 'success'
                            });
                            menus_grid_data.ajax.reload();
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

    function add_new_menu_item() {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.menus.store_menu_item')}}',
            dataType: "json",
            data: $('#menu_item_form_created_new').serialize(),
            success: function (result) {
                if (result.success == true) {
                    jQuery.noticeAdd({
                        text: result.message,
                        stay: false,
                        type: 'success'
                    });
                    document.getElementById('menu_item_form_created_new').reset();
                    $('a[href="#menu_items_tab"]').click();
                    menus_items_data.ajax.reload();
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

    function edit_menu_item() {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.menus.update_menu_item')}}',
            dataType: "json",
            data: $('#form_menu_item_edit_item').serialize(),
            success: function (result) {
                if (result.success == true) {
                    jQuery.noticeAdd({
                        text: result.message,
                        stay: false,
                        type: 'success'
                    });
                    document.getElementById('form_menu_item_edit_item').reset();
                    $('a[href="#menu_items_tab"]').click();
                    menus_items_data.ajax.reload();
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

    function destroy_menu_item(item_id) {
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
                            jQuery.noticeAdd({
                                text: result.message,
                                stay: false,
                                type: 'success'
                            });
                            menus_items_data.ajax.reload();
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
                    jQuery.noticeAdd({
                        text: result.message,
                        stay: false,
                        type: 'success'
                    });
                    menus_items_data.ajax.reload();
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
                    jQuery.noticeAdd({
                        text: result.message,
                        stay: false,
                        type: 'success'
                    });
                }
                else {
                    jQuery.noticeAdd({
                        text: errors,
                        stay: false,
                        type: 'error'
                    });
                }
            },
        });
    }

    $(document).click(function () {

        $(".add_new_menu_form_btn").off();
        $(".add_new_menu_form_btn").click(function () {
            add_new_menu();
        });
        $(".cancel_new_menu_form_btn").click(function () {
            $('a[href="#menus_tab"]').click();
            document.getElementById('form_created_new_menu').reset();
        });

        $(".btn_grid_menu_edit").click(function () {
            $('.edit_menu_tab').remove();
            var $this = $(this);
            $('#edit_form_item_id').val($this.data('grid_item_id'));
            $('#edit_form_input_title').val($this.data('grid_item_title'));
            $('#edit_form_input_description').val($this.data('grid_item_description'));
            var li_tab = '<li class=""><a href="#edit_tab" data-toggle="tab" class="legitRipple edit_menu_tab" aria-expanded="false"><span class=""></span> {{trans('menus.edit_tab')}}</a></li>';
            $('#manage').append(li_tab);
            $('#manage a[href="#edit_tab"]').tab('show');
        });

        $(".submit_menu_edit_btn").off();
        $(".submit_menu_edit_btn").click(function () {
            edit_menu()
        });
        $(".cancel_menu_edit_btn").click(function () {
            document.getElementById('form_edit_menu').reset();
            $('a[href="#menus_tab"]').click();
            $('.edit_menu_tab').remove();
        });

        $(".btn_grid_destroy_menu").off();
        $(".btn_grid_destroy_menu").click(function () {
            var $this = $(this);
            var item_id = $this.data('grid_item_id');
            destroy_menu(item_id);
        });

        $(".btn_grid_get_menu_items").off();
        $(".btn_grid_get_menu_items").click(function () {
            $(".parent_list").select2({
                minimumInputLength: 2,
                dir: "rtl",
                width: '100%',
                ajax: {
                    url: "{{ route('auto_complete.menu_items') }}",
                    dataType: 'json',
                    type: "POST",
                    quietMillis: 50,
                    data: function (term) {
                        return {
                            term: term.term,
                            menu_id: $('.menu_id').val()
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
            $(".parent_list_for_filter").select2({
                minimumInputLength: 2,
                dir: "rtl",
                width: '100%',
                ajax: {
                    url: "{{ route('auto_complete.menu_items') }}",
                    dataType: 'json',
                    type: "POST",
                    quietMillis: 50,
                    data: function (term) {
                        return {
                            term: term.term,
                            menu_id: $('.menu_id').val(),
                            filter_items_by_parent:true
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
            $('.get_menu_items_tab').remove();
            $('.menu_items_add_tab').remove();
            var $this = $(this);
            var menu_id = $this.data('grid_item_id');
            $('.menu_id').val(menu_id);
            $(".add_edit_menu_items").attr("menu_id", menu_id);
            menu_items_datatable_grid(menu_id, 'MenuItemsGridData', '-1');
            var li_menu_item_tab = '<li class=""><a href="#menu_items_tab" data-toggle="tab" class="legitRipple get_menu_items_tab" aria-expanded="false"><span class=""></span> {{trans('menus.menu_items')}} </a></li>';
            var li_menu_item_add_tab = '<li class=""><a href="#menu_item_add_tab" data-toggle="tab" class="legitRipple menu_items_add_tab" aria-expanded="false"><span class=""></span> {{trans('menus.add_menu_item')}} </a></li>';
            $('#manage').append(li_menu_item_tab);
            // $('#manage').append(li_menu_item_add_tab);
            $('#manage a[href="#menu_items_tab"]').tab('show');
        });

        //------------------------------------------------------------------
        //-------------------------- Menu Items ----------------------------
        //------------------------------------------------------------------

        $('#filter_parent_id').change(function () {
            menu_items_datatable_grid($('.menu_id').val(), 'MenuItemsGridData', $(this).val());

            if ($(this).val() == -1) {
                menus_items_data.column(1).visible(0);
                $('.grid_ordering_elements').addClass('ordering_disabled');
            }
            else {
                menus_items_data.column(1).visible(1);
                $('.grid_ordering_elements').removeClass('ordering_disabled');
            }
        });

        $(".menu_item_submit_form_btn").off();
        $(".menu_item_submit_form_btn").click(function () {
            add_new_menu_item();
        });
        $(".menu_item_cancel_form_btn").click(function () {
            document.getElementById('menu_item_form_created_new').reset();
            $('a[href="#menu_items_tab"]').click();
        });

        $(".btn_grid_menu_item_edit").off();
        $(".btn_grid_menu_item_edit").click(function () {
            $("#edit_roles_list").html('');
            $('#edit_users_list').html('');
            var $this = $(this);
            var item_id = $this.data('grid_item_id');
            $('#edit_form_menu_item_id').val(item_id);
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
            var li_tab = '<li class=""><a href="#menu_item_edit_tab" data-toggle="tab" class="legitRipple edit_menu_item_tab" aria-expanded="false"><span class=""></span> {{trans('menus.edit_menu_tab')}}</a></li>';
            $('.edit_menu_item_tab').remove();
            $('#manage').append(li_tab);
            $('#manage a[href="#menu_item_edit_tab"]').tab('show');
        });

        $(".menu_item_edit_submit_form_btn").off();
        $(".menu_item_edit_submit_form_btn").click(function () {
            edit_menu_item()
        });
        $(".cancel_menu_item_edit_form_btn").click(function () {
            document.getElementById('form_menu_item_edit_item').reset();
            $('a[href="#menu_items_tab"]').click();
        });

        $(".fa-sort-asc, .fa-sort-desc, .save_btn").off();
        $(".fa-sort-asc, .fa-sort-desc, .save_btn").click(function () {
            var $this = $(this);
            var id = $this.data('item_id');
            var type = $this.data('order_type');
            var order_step = menus_items_data.order()[0][1];
            var value = $('input[name="item_order[\'' + id + '\']"]').val();
            change_order(id, type, value, order_step);
        });

        $(".btn_grid_add_permission").click(function () {
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
            $('#menu_item_name').html('');
            $('#menu_item_name').html('دسترسی‌های: '  + item_name);
            var li_tab = '<li class=""><a href="#permission_tab" data-toggle="tab" class="legitRipple permission_tab" aria-expanded="false"><span class=""></span> {{trans('menus.permission_tab')}}</a></li>';
            $('.permission_tab').remove();
            $('#manage').append(li_tab);
            $('#manage a[href="#permission_tab"]').tab('show');
        });

        $(".submit_form_permission_btn").off();
        $(".submit_form_permission_btn").click(function () {
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.menus.set_menu_permissions')}}',
                dataType: "json",
                data: $('#form_permission_item').serialize() + '&item_id=' + $('#permission_form_item_id').val(),
                success: function (result) {
                    if (result.success == true) {
                        $('#users_list').html('');
                        $('#roles_list').html('');
                        jQuery.noticeAdd({
                            text: result.message,
                            stay: false,
                            type: 'success'
                        });
//                        location.reload();

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
        });
        $(".cancel_form_permission_btn").click(function () {
            $('a[href="#menu_items_tab"]').click();
        });

        $(".btn_grid_destroy_menu_item").click(function () {
            var $this = $(this);
            var item_id = $this.data('grid_item_id');
            var item_name = $this.data('grid_item_name');
            destroy_menu_item(item_id, item_name);
        });


    });

    $(document).ready(function () {
        menus_datatable_grid();

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
    });

</script>