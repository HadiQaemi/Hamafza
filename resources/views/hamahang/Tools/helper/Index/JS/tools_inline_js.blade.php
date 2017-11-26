<script>

    var tools_group_grid_table = "";
    var tools_grid_table = "";
    var tools_roles_table = "";
    var tools_users_table = "";

    function gridToolsGroupDataTable(target_id) {
        tools_group_grid_table = $('#' + target_id).DataTable({
            "dom": '<"space-10">' +
            ' <"row form-inline" <"col-xs-4"f> <"col-xs-8 text-left toolbar"> <"clearfixed">>' +
            ' <"row" <"col-xs-12" rt> <"clearfixed">>' +
            ' <"row" <"col-xs-5"<"col-xs-6"i><"col-xs-6"l>><"col-xs-7 pull-left text-left"p> <"clearfixed">>',
            "language": window.LangJson_DataTables,
            initComplete: function () {
                $("div.toolbar")
                    .html('' +
                        '<div class="col-xs-8 pull-left">' +
                        '<input type="text" class="form-control" placeholder="عنوان دسته" id="new_tools_group_name" name="new_tools_group_name"> ' +
                        '<input type="text" id="add_edit_tools_group" hidden> ' +
                        '<input type="text" id="edit_tools_group_id" hidden> ' +
                        '<button class="btn btn-primary btn_grid_add_new_tools_group" type="button">' +
                        '   <i ></i> ' +
                        '   {{ trans('app.register')}}' +
                        '</button>' +
                        '<button class="btn btn-default btn_grid_add_new_tools_group_cancel hide" type="button">' +
                        '   <i ></i> ' +
                        '   {{ trans('app.cancel')}}' +
                        '</button>' +
                        '</div>'
                    );
            },
            "columnDefs": [
                {
                    "targets": [1],
//                    "visible": false
                }
            ],

            "order": [[1, "asc"]],
            ajax: {
                url: '{!! route('hamahang.tools_group.tools_group_list') !!}',
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
                    data: 'orders',
                    name: 'orders',
                    mRender: function (data, type, full) {
                        return '' +
                            '<div class="tools_group_grid_ordering_elements ordering_disabled">' +
                            '   <table border="0">' +
                            '       <tbody>' +
                            '           <tr>' +
                            '               <td style="padding: 1px!important">' +
                            '                   <a id="tools_group_ordering_asc">' +
                            '                       <i data-item_id="' + full.id + '" data-order_type="up" data-one_order_step="asc" class="fa fa-2 fa-sort-asc tools_group_fa-sort-asc" aria-hidden="true"></i>' +
                            '                   </a>' +
                            '               </td>' +
                            '               <td style="padding: 1px!important;vertical-align: middle" rowspan="2">' +
                            '                   <input id="tools_group_ordering_input" style="width:30px; text-align: center;" type="text" name="tools_group_item_order[\'' + full.id + '\']" value="' + full.orders + '">' +
                            '                   <a class="save_btn tools_group_save_btn" data-item_id="' + full.id + '" data-order_type="save" data-one_order_step="data">' +
                            '                       <i class="fa fa-save"></i>' +
                            '                   </a>' +
                            '               </td>' +
                            '           </tr>' +
                            '           <tr>' +
                            '               <td style="padding: 1px!important">' +
                            '                   <a>' +
                            '                       <i data-item_id="' + full.id + '" data-order_type="down" data-one_order_step="desc" class="fa fa-2 fa-sort-desc tools_group_fa-sort-desc" aria-hidden="true"></i>' +
                            '                   </a>' +
                            '               </td>' +
                            '           </tr>' +
                            '       </tbody>' +
                            '   </table>' +
                            '</div>';
                    }
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'visible',
                    name: 'visible',
                    mRender: function (data, type, full) {
                        var ch = '';
                        if (parseInt(full.visible))
                            ch = 'checked';
                        else
                            ch = '';
                        return '<input class="styled" type="checkbox" name="special" data-item_id="' + full.id + '" onchange="set_visibility(this)" ' + ch + '>'
                    }
                },
                {
                    searchable: false,
                    sortable: false,
                    mRender: function (data, type, full) {
                        var result = '';
                        result += '' +
                            '<button style="margin-right: 3px;" title="ویرایش گروه" type="button" class="btn btn-xs bg-warning-400 fa fa-edit btn_grid_item_edit" ' +
                            '   data-grid_item_id="' + full.id + '" ' +
                            '   data-grid_item_type="edit" ' +
                            '   data-grid_item_name="' + full.name + '">' +
                            '</button>';
                        result += '' +
                            '<button style="margin-right: 3px;" title="حذف گروه" type="button" class="btn btn-xs bg-danger-800 fa fa-trash-o btn_grid_destroy_item" data-grid_item_id="' + full.id + '" data-grid_item_name="' + full.title + '"></button>';
                        return result;
                    }
                },
            ]
        });
        window.tools_group_grid_table.on('order.dt', function (e, details, edit) {
            if (window.tools_group_grid_table.order()[0][0] == 1) {
                $('.tools_group_grid_ordering_elements').removeClass('ordering_disabled');
            }
            else {
                $('.tools_group_grid_ordering_elements').addClass('ordering_disabled');
            }
        });
    }

    function gridToolsDataTable(target_id) {
        tools_grid_table = $('#' + target_id).DataTable({
            "dom": '<"space-10">' +
            ' <"row form-inline" <"col-xs-4"f> <"col-xs-8 text-left tools-toolbar"> <"clearfixed">>' +
            ' <"row" <"col-xs-12" rt> <"clearfixed">>' +
            ' <"row" <"col-xs-5"<"col-xs-6"i><"col-xs-6"l>><"col-xs-7 pull-left text-left footer"p> <"clearfixed">>',
            "language": window.LangJson_DataTables,
            initComplete: function () {
                $("div.tools-toolbar")
                    .html('' +
                        '<div class="col-xs-8 pull-left">' +
                        '   <a href="{{ route('modals.add_edit_tools') }}" class="jsPanels btn btn-primary" title="افزودن ابزار">' +
                        '       {{ trans('tools.new_tools')}}' +
                        '   </a>' +
                        '</div>'
                    );
            },
            "columnDefs": [
                {
                    "targets": [1],
//                    "visible": false
                }
            ],

            "order": [[1, "asc"]],
            ajax: {
                url: '{!! route('hamahang.tools.get_tools') !!}',
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
                    data: 'orders',
                    name: 'orders',
                    mRender: function (data, type, full) {
                        return '' +
                            '<div class="tools_grid_ordering_elements ordering_disabled">' +
                            '   <table border="0">' +
                            '       <tbody>' +
                            '           <tr>' +
                            '               <td style="padding: 1px!important">' +
                            '                   <a id="tools_ordering_asc">' +
                            '                       <i data-item_id="' + full.id + '" data-order_type="up" data-one_order_step="asc" class="fa fa-2 fa-sort-asc tools_fa-sort-asc" aria-hidden="true"></i>' +
                            '                   </a>' +
                            '               </td>' +
                            '               <td style="padding: 1px!important;vertical-align: middle" rowspan="2">' +
                            '                   <input id="tools_ordering_input" style="width:30px; text-align: center;" type="text" name="tools_item_order[\'' + full.id + '\']" value="' + full.orders + '">' +
                            '                   <a class="tools_save_btn" data-item_id="' + full.id + '" data-order_type="save" data-one_order_step="data">' +
                            '                       <i class="fa fa-save tools-fa-save"></i>' +
                            '                   </a>' +
                            '               </td>' +
                            '           </tr>' +
                            '           <tr>' +
                            '               <td style="padding: 1px!important">' +
                            '                   <a>' +
                            '                       <i data-item_id="' + full.id + '" data-order_type="down" data-one_order_step="desc" class="fa fa-2 fa-sort-desc tools_fa-sort-desc" aria-hidden="true"></i>' +
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
                    data: 'parent',
                    name: 'parent',
                    mRender: function (data, type, full) {
                        if (full.group)
                            return '<span>' + full.group.name + '</span>';
                        else
                            return '';
                    }
                },
                {
                    data: 'visible',
                    name: 'visible',
                    mRender: function (data, type, full) {
                        var ch = '';
                        if (parseInt(full.visible))
                            ch = 'checked';
                        else
                            ch = '';
                        return '<input class="styled" type="checkbox" name="special" data-item_id="' + full.id + '" onchange="set_tool_visibility(this)" ' + ch + '>'
                    }
                },
                {
                    searchable: false,
                    sortable: false,
                    mRender: function (data, type, full) {
                        var result = '';
                        result += '' +
                            '<button style="margin-right: 3px;" title="ویرایش ابزار" href="{!! route('modals.add_edit_tools') !!}?item_id=' + full.id + '" class="jsPanels btn btn-xs bg-warning-400 fa fa-edit" ' +
                            '   data-grid_item_id="' + full.id + '" ' +
                            '   data-grid_item_type="edit" ' +
                            '   data-grid_item_name="' + full.name + '">' +
                            '</button>';
                        result += '' +
                            '<button style="margin-right: 3px;" title="حذف گروه" type="button" class="btn btn-xs bg-danger-800 fa fa-trash-o btn_grid_destroy_tool" data-grid_item_id="' + full.id + '" data-grid_item_title="' + full.title + '"></button>';
                        return result;
                    }
                },
            ]
        });
        window.tools_grid_table.on('order.dt', function (e, details, edit) {
            if (window.tools_grid_table.order()[0][0] == 1) {
                $('.tools_grid_ordering_elements').removeClass('ordering_disabled');
            }
            else {
                $('.tools_grid_ordering_elements').addClass('ordering_disabled');
            }
        });
    }

    function gridToolsRolesDataTable(target_id, filter_tool, filter_role) {
        tools_roles_table = $('#' + target_id).DataTable({
            "dom": '<"space-10">' +
            ' <"row form-inline" <"col-xs-4"f> <"text-right tools_roles-toolbar"> <"clearfixed">>' +
            ' <"row" <"col-xs-12" rt> <"clearfixed">>' +
            ' <"row" <"col-xs-5"<"col-xs-6"i><"col-xs-6"l>><"col-xs-7 pull-left text-left"p> <"clearfixed">>',
            "language": window.LangJson_DataTables,
            {{--initComplete: function () {--}}
                {{--$("div.tools_roles-toolbar")--}}
                    {{--.html('' +--}}
{{--//                        '<div class="col-xs-8 pull-left">' +--}}
                        {{--'<form id="datatables_tools_role_form" method="post">' +--}}
                            {{--'<div class="col-xs-1" style="padding-left: 0;"><label><i class="fa fa-filter"></i> ابزار</label></div>' +--}}
                            {{--'<div class="col-xs-3" style="padding-right: 0;"><select style="text-align: right;" id="datatables_tools_list" class="select" name="datatables_tool_id" placeholder="انتخاب ابزار"><option value="0">همه</option></select></div> ' +--}}
                            {{--'<div class="col-xs-1" style="padding-left: 0;"><label><i class="fa fa-filter"></i> نقش</label></div>' +--}}
                            {{--'<div class="col-xs-3" style="padding-right: 0;"><select style="text-align: right" id="datatables_roles_list" class="select" name="datatables_role_id" placeholder="انتخاب نقش"><option value="0">همه</option></select></div> ' +--}}
                        {{--'</form>'--}}
                        {{--'<button class="btn btn-primary btn_grid_add_new_tools_group" type="button">' +--}}
                        {{--'   <i ></i> ' +--}}
                        {{--'   {{ trans('app.register')}}' +--}}
                        {{--'</button>' +--}}
{{--//                        '</div>'--}}
                    {{--);--}}
            {{--},--}}
            "columnDefs": [
                {
                    "targets": [1],
//                    "visible": false
                }
            ],
            destroy: true,

            "order": [[0, "asc"]],

            ajax: {
                url: '{!! route('hamahang.tools.get_tools_roles') !!}',
                type: 'POST',
                "data": function (d) {
                    d.filter_tool = filter_tool,
                    d.filter_role = filter_role;
                },
                {{--success:function(data) {--}}
                    {{--$('#datatables_tools_list').change(function(){--}}
{{--                        var id = '{!! session()->pull('datatables_tools_id') !!}';--}}
                        {{--$('#datatables_tools_list').val(data.filter_tool);--}}
                    {{--})--}}
                {{--}--}}
            },
            columns: [
                {
                    "data": "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'tools',
                    name: 'tools',
                    mRender: function (data, type, full) {
                            return '<span>' + full.tool_title + '</span>';
                    }
                },
                {
                    data: 'role',
                    name: 'role',
                    mRender: function (data, type, full) {
                        return '<span>'+ full.role_name + ' (' + full.role_display_name + ')' +'</span>';
                    }
                },
                {
                    searchable: false,
                    sortable: false,
                    mRender: function (data, type, full) {
                        var result = '';
                            result += '' +
                                '<button style="margin-right: 3px;" title="حذف گروه" type="button" class="btn btn-xs bg-danger-800 fa fa-trash-o btn_grid_destroy_tool_role" data-grid_tool_id="' + full.tool_id + '" data-grid_role_id="' + full.role_id + '"></button>';
                        return result;
                    }
                },
            ]
        });
    }

    function gridToolsUsersDataTable(target_id, filter_tool, filter_user) {
        tools_users_table = $('#' + target_id).DataTable({
            "dom": '<"space-10">' +
            ' <"row form-inline" <"col-xs-4"f> <"text-right tools_roles-toolbar"> <"clearfixed">>' +
            ' <"row" <"col-xs-12" rt> <"clearfixed">>' +
            ' <"row" <"col-xs-5"<"col-xs-6"i><"col-xs-6"l>><"col-xs-7 pull-left text-left"p> <"clearfixed">>',
            "language": window.LangJson_DataTables,
            "columnDefs": [
                {
                    "targets": [1],
//                    "visible": false
                }
            ],
            destroy: true,

            "order": [[1, "asc"]],

            ajax: {
                url: '{!! route('hamahang.tools.get_tools_users') !!}',
                type: 'POST',
                "data": function (d) {
                    d.filter_tool = filter_tool,
                    d.filter_user = filter_user;
                },
            },
            columns: [
                {
                    "data": "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'tools',
                    name: 'tools',
                    mRender: function (data, type, full) {
                            return '<span>' + full.tool_title + '</span>';
                    }
                },
                {
                    data: 'user',
                    name: 'user',
                    mRender: function (data, type, full) {
                        return '<span>'+ full.Uname + ' (' + full.Name + ' ' + full.Family + ')' +'</span>';
                    }
                },
                {
                    searchable: false,
                    sortable: false,
                    mRender: function (data, type, full) {
                        var result = '';
                            result += '' +
                                '<button style="margin-right: 3px;" title="حذف گروه" type="button" class="btn btn-xs bg-danger-800 fa fa-trash-o btn_grid_destroy_tool_user" data-grid_tool_id="' + full.tool_id + '" data-grid_user_id="' + full.user_id + '"></button>';
                        return result;
                    }
                },
            ]
        });
    }

    function add_new_tools_group() {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tools_group.add_new_tools_group')}}',
            dataType: "json",
            data: {
                name: $('#new_tools_group_name').val()
            },
            success: function (result) {
                if (result.success == true) {
                    jQuery.noticeAdd({
                        text: result.message,
                        stay: false,
                        type: 'success'
                    });
                    $('#new_tools_group_name').val('');
                    tools_group_grid_table.ajax.reload();
                }
                else {
                    var errors = '';
                    for(var k in result.error) {
                        errors += '' +
                            '<li>' + result.error[k] +'</li>'
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

    function edit_tools_group(item_id) {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tools_group.edit_tools_group')}}',
            dataType: "json",
            data: {
                item_id: item_id,
                name: $('#new_tools_group_name').val()
            },
            success: function (result) {
                if (result.success == true) {
                    jQuery.noticeAdd({
                        text: result.message,
                        stay: false,
                        type: 'success'
                    });
                    $('#new_tools_group_name').val('');
                    $('#add_edit_tools_group').val('add');
                    tools_group_grid_table.ajax.reload();
                }
                else {
                    var errors = '';
                    for(var k in result.error) {
                        errors += '' +
                            '<li>' + result.error[k] +'</li>'
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

    function destroy_item(item_id) {
        confirmModal({
            title: '{{trans('tools.delete')}}',
            message: '{{trans('app.are_you_sure')}}',
            onConfirm: function () {
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.tools_group.delete_tools_group')}}',
                    dataType: "json",
                    data: {
                        item_id: item_id
                    },
                    success: function (result) {
                        if (result.success == true) {
                            jQuery.noticeAdd({
                                text: 'حذف با موفقیت انجام شد',
                                stay: false,
                                type: 'success'
                            });
                            tools_group_grid_table.ajax.reload();
                        }
                        else {
                            var errors = '';
                            for(var k in result.error) {
                                errors += '' +
                                    '<li>' + result.error[k] +'</li>'
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

    function destroy_tool(item_id) {
        confirmModal({
            title: '{{trans('tools.delete')}}',
            message: '{{trans('app.are_you_sure')}}',
            onConfirm: function () {
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.tools.delete_tools')}}',
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
                            tools_grid_table.ajax.reload();
                        }
                        /*if (result.success) {
                            jQuery.noticeAdd({
                                text: 'ابزار با موفقیت افزوده شد.',
                                stay: false,
                                type: 'success'
                            });
                            $('.jsPanel-btn-close').click();
                            $('#toolsGrid').DataTable().ajax.reload();
//                       document.getElementById('new-tool-form').reset();
                        }*/
                        else {
                            var errors = '';
                            for(var k in data.error) {
                                errors += '' +
                                    '<li>' + data.error[k] +'</li>'
                            }
                            jQuery.noticeAdd({
                                text: errors,
                                stay: false,
                                type: 'error'
                            });
                            jQuery.noticeAdd({
                                text: result.error,
                                stay: false,
                                type: 'success'
                            });
                        }
                    }
                });
            },
            afterConfirm: 'close'
        });
    }

    function set_visibility(data) {
        var $this = $(data);
        var id = $this.data('item_id');
        var value = {
            'id': id
        };
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('hamahang.tools_group.set_visibility') !!}',
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
                    var errors = '';
                    for(var k in result.error) {
                        errors += '' +
                            '<li>' + result.error[k] +'</li>'
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

    function set_tool_visibility(data) {
        var $this = $(data);
        var id = $this.data('item_id');
        var value = {
            'id': id
        };
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('hamahang.tools.set_visibility') !!}',
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
                    var errors = '';
                    for(var k in result.error) {
                        errors += '' +
                            '<li>' + result.error[k] +'</li>'
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

    function change_tools_group_order(id, type, value, order_step) {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tools_group.set_item_order')}}',
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
                    tools_group_grid_table.ajax.reload();
                }
                else {
                    var errors = '';
                    for(var k in result.error) {
                        errors += '' +
                            '<li>' + result.error[k] +'</li>'
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

    function change_tools_order(id, type, value, order_step) {
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tools.set_item_order')}}',
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
                    tools_grid_table.ajax.reload();
                }
                else {
                    var errors = '';
                    for(var k in result.error) {
                        errors += '' +
                            '<li>' + result.error[k] +'</li>'
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

    $(document).click(function () {

        $(".btn_grid_add_new_tools_group").off();
        $(".tools_group_fa-sort-asc, .tools_group_fa-sort-desc, .tools_group_save_btn").off();
        $(".tools_fa-sort-asc, .tools_fa-sort-desc, .tools_save_btn").off();
        $(".btn_grid_destroy_item").off();
        $(".btn_grid_item_edit").off();
        $(".btn_grid_destroy_tool").off
        $(".btn_grid_add_new_tools").off();
        $("#add_tools_roles").off();
        $(".btn_grid_destroy_tool_role").off();
        $("#add_tools_users").off();
        $('.btn_grid_add_new_tools_group_cancel').off();

        $(".btn_grid_add_new_tools_group").click(function () {
            var item_id = $('#edit_tools_group_id').val();
            if ($('#add_edit_tools_group').val() == 'edit') {
                edit_tools_group(item_id);
            }
            else
                add_new_tools_group();
        });

        $(".btn_grid_add_new_tools_group_cancel").click(function () {
            $(".btn_grid_add_new_tools_group").html('ثبت');
            $('#new_tools_group_name').val('');
            $('.btn_grid_add_new_tools_group_cancel').addClass('hide');
        });

        $(".tools_group_fa-sort-asc, .tools_group_fa-sort-desc, .tools_group_save_btn").click(function () {
            var $this = $(this);
            var id = $this.data('item_id');
            var type = $this.data('order_type');
            var order_step = tools_group_grid_table.order()[0][1];
            var value = $('input[name="tools_group_item_order[\'' + id + '\']"]').val();
            change_tools_group_order(id, type, value, order_step);
        });

        $(".tools_fa-sort-asc, .tools_fa-sort-desc, .tools_save_btn").click(function () {
            var $this = $(this);
            var id = $this.data('item_id');
            var type = $this.data('order_type');
            var order_step = tools_grid_table.order()[0][1];
            var value = $('input[name="tools_item_order[\'' + id + '\']"]').val();
            change_tools_order(id, type, value, order_step);
        });

        $(".btn_grid_destroy_item").click(function () {
            var $this = $(this);
            var item_id = $this.data('grid_item_id');
            var item_name = $this.data('grid_item_name');
            destroy_item(item_id, item_name);
        });

        $(".btn_grid_destroy_tool").click(function () {
            var $this = $(this);
            var item_id = $this.data('grid_item_id');
            var item_name = $this.data('grid_item_title');
            destroy_tool(item_id, item_name);
        });

        $(".btn_grid_item_edit").click(function () {
            $(".btn_grid_add_new_tools_group").html('ویرایش');
            $('.btn_grid_add_new_tools_group_cancel').removeClass('hide');
            var $this = $(this);
            var item_id = $this.data('grid_item_id');
            var item_name = $this.data('grid_item_name');
            $('#new_tools_group_name').val(item_name);
            $('#add_edit_tools_group').val('edit');
            $('#edit_tools_group_id').val(item_id);
            tools_group_grid_table.on('page.dt', function () {
                $('html, body').animate({
                    scrollTop: $(".dataTables_wrapper").offset().top
                }, 'slow');
            });
        });

        $("#add_tools_roles").click(function () {
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.tools.add_tools_role')}}',
                dataType: "json",
                data: $('#tools_roles_form').serialize(),
                success: function (result) {
                    if (result.success == true) {
                        jQuery.noticeAdd({
                            text: 'افزودن به نقش با موفقیت انجام شد!',
                            stay: false,
                            type: 'success'
                        });
                        tools_grid_table.ajax.reload();
                        tools_roles_table.ajax.reload();
                    }
                    else {
                        var errors = '';
                        for(var k in result.error) {
                            errors += '' +
                                '<li>' + result.error[k] +'</li>'
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

        $("#add_tools_users").click(function () {
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.tools.add_tools_user')}}',
                dataType: "json",
                data: $('#tools_users_form').serialize(),
                success: function (result) {
                    if (result.success == true) {
                        jQuery.noticeAdd({
                            text: 'افزودن با موفقیت انجام شد!',
                            stay: false,
                            type: 'success'
                        });
                        tools_grid_table.ajax.reload();
                        tools_users_table.ajax.reload();
                    }
                    else {
                        var errors = '';
                        for(var k in result.error) {
                            errors += '' +
                                '<li>' + result.error[k] +'</li>'
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

        $(".btn_grid_destroy_tool_role").click(function () {
            var $this = $(this);
            var tool_id = $this.data('grid_tool_id');
            var role_id = $this.data('grid_role_id');
            confirmModal({
                title: '{{trans('tools.delete')}}',
                message: '{{trans('app.are_you_sure')}}',
                onConfirm: function () {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('hamahang.tools.delete_tools_role')}}',
                        dataType: "json",
                        data: {
                            tool_id: tool_id,
                            role_id: role_id

                        },
                        success: function (result) {
                            if (result.success == true) {
                                tools_roles_table.ajax.reload();
                                jQuery.noticeAdd({
                                    text: result.message,
                                    stay: false,
                                    type: 'success'
                                });
                            }
                            else {
                                var errors = '';
                                for(var k in result.error) {
                                    errors += '' +
                                        '<li>' + result.error[k] +'</li>'
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
        });

        $(".btn_grid_destroy_tool_user").click(function () {
            var $this = $(this);
            var tool_id = $this.data('grid_tool_id');
            var user_id = $this.data('grid_user_id');
            confirmModal({
                title: '{{trans('tools.delete')}}',
                message: '{{trans('app.are_you_sure')}}',
                onConfirm: function () {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('hamahang.tools.delete_tools_user')}}',
                        dataType: "json",
                        data: {
                            tool_id: tool_id,
                            user_id: user_id

                        },
                        success: function (result) {
                            if (result.success == true) {
                                tools_users_table.ajax.reload();
                                jQuery.noticeAdd({
                                    text: result.message,
                                    stay: false,
                                    type: 'success'
                                });
                            }
                            else {
                                var errors = '';
                                for(var k in result.error) {
                                    errors += '' +
                                        '<li>' + result.error[k] +'</li>'
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
        });

//        $(".btn_grid_add_new_tools").click(function () {
//            $('#tools_add').modal('show');
//        });


    });

    $(document).ready(function () {

        $('#tools_list, #datatables_tools_list, #tools_user_tools_list, #datatables_tools_user_tools_list').select2({
            dir: "rtl",
            width: '100%',
            placeholder: "{{ trans('tools.choose') }}",
            allowClear: true,
            data: {!! $all_tools !!}
        });

        $('#roles_list, #datatables_roles_list').select2({
            dir: "rtl",
            width: '100%',
            placeholder: "{{ trans('tools.choose') }}",
            allowClear: true,
            data: {!! $roles !!}
        });

        $("#tools_user_users_list, #datatables_tools_user_users_list").select2({
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

        gridToolsGroupDataTable('toolsGroupGrid');
        gridToolsDataTable('toolsGrid');
        gridToolsRolesDataTable('toolsRolesGrid', null, null)
        gridToolsUsersDataTable('toolsUserGrid', null, null)
    });

    $("#datatables_tools_list").on('change', function() {
        gridToolsRolesDataTable('toolsRolesGrid', $("#datatables_tools_list option:selected").val(), null);
    });

    $("#datatables_roles_list").on('change', function () {
        gridToolsRolesDataTable('toolsRolesGrid', null, $("#datatables_roles_list option:selected").val());
    });

    $("#datatables_tools_user_tools_list").on('change', function() {
        gridToolsUsersDataTable('toolsUserGrid', $("#datatables_tools_user_tools_list option:selected").val(), null);
    });

    $("#datatables_tools_user_users_list").on('change', function () {
        gridToolsUsersDataTable('toolsUserGrid', null, $("#datatables_tools_user_users_list option:selected").val());
    });

</script>