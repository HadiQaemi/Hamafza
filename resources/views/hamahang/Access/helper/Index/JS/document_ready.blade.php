<script>
    $('document').ready(function () {
        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------Roles GRID ------------------------------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        var rolesGrid = '';
        var currentRowIndex = 0;
        rolesGrid = $('#rolesGrid').DataTable({
            "language": LangJson_DataTables,
            processing: true,
            serverSide: true,
            "dom": '<"col-xs-5"f><"col-xs-4 text-center"l><"roles_toolbar">t<"col-xs-12 text-center"p><"clearfixed">',
            initComplete: function () {
                $("div.roles_toolbar")
                    .html('<button style="margin:16px;" class="btn btn-default btn-success pull-left  add-roles">' +
                        '<i ></i>' +
                        '{{trans('access.new_role')}}' +
                        '</button>');
            },
            ajax: {
                url: '{!! route('Access.rolesList')!!}',
                type: 'POST'
            },
            columns: [
                {
                    data: 'index',
                    name: 'index',
                    width: '1%'
                },
                {
                    data: 'name',
                    name: 'name',

                },
                {
                    data: 'display_name',
                    name: 'display_name',

                },
                {
                    data: 'user_cnt',
                    name: 'user_cnt',
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="showUserRole(' + full.id + ')" >' + data + '</a>';
                    }
                },
                {
                    data: 'permission_cnt',
                    name: 'permission_cnt',
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="showPermissionRole(' + full.id + ',\'' + full.display_name + '\')" >' + data + '</a>';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    mRender: function (data, type, full) {
                        var actions = '<a class="cls3"   style="margin: 2px" onclick="editRole(' + full.id + ',this)" href="#"><i class="fa fa-edit"></i></a>';
                        return actions;
                    }
                }
            ]
        });
        rolesGrid.on('order.dt search.dt', function () {
            rolesGrid.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------open role modal ------------------------------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        role_modal_btn = [
            {
                item: '<div>' +
                '           <button type="button" name="saveRole" id="saveRole" value="save" class="btn btn-info" type="button">' +
                '               <i class="glyphicon  glyphicon-save-file bigger-125"></i>' +
                '               <span>{{trans('app.save')}}</span>' +
                '           </button>' +
                '       </div>'
            }
        ]

        $(document).on("click", '.add-roles', function () {
            //$('#add_role').modal('show');
            roleModal = $.jsPanel({
                position: {my: "center-top", at: "center-top", offsetY: 15},
                contentSize: {width: 600, height: 150},
                headerTitle: "{{trans('access.new_role')}}",
                contentAjax: {
                    url: '{{route('Access.newRoleModal')}}',
                    method: 'POST',
                    dataType: 'json',
                    done: function (data, textStatus, jqXHR, panel) {
                        console.log(data.content);
                        this.headerTitle(data.header);
                        this.content.html(data.content);
                        this.toolbarAdd('footer', [{item: data.footer}]);

                    }
                }
            });
            roleModal.content.html('<div class="loader"></div>');
        });

        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------Permission GRID ------------------------------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        var PermissionGrid = '';
        PermissionGrid = $('#permissionGrid').DataTable({
            "language": LangJson_DataTables,
            processing: true,
            serverSide: true,
            "dom": '<"col-xs-5"f><"col-xs-4 text-center"l><"permissions_toolbar">t<"col-xs-12 text-center"p><"clearfixed">',
            initComplete: function () {
                $("div.permissions_toolbar")
                    .html('<button style="margin:16px;" class="btn btn-default btn-success pull-left  add-permission">' +
                        '<i ></i>' +
                        '{{trans('access.add_permission')}}</button>');
            },
            ajax: {
                url: '{!! route('Access.permissionsList' )!!}',
                type: 'POST'
            },
            columns: [
                {
                    data: 'index',
                    name: 'index',
                    width: '1%'
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'display_name',
                    name: 'display_name',
                },
                {
                    data: 'action',
                    name: 'action',
                    mRender: function (data, type, full) {
                        var actions = '<a class="cls3"   style="margin: 2px" onclick="editPermission(' + full.id + ',this)" href="#"><i class="fa fa-edit"></i></a>';
                        return actions;
                    }
                }
            ]
        });
        PermissionGrid.on('order.dt search.dt', function () {
            PermissionGrid.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------open permission modal ------------------------------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        permission_modal_btn = [
            {
                item: '' +
                '<div >' +
                '   <button type="button" name="savePermission" id="savePermission" value="save" class="btn btn-info" type="button">' +
                '       <i class="glyphicon  glyphicon-save-file bigger-125"></i>' +
                '       <span>{{trans('app.save')}}</span>' +
                '   </button>' +
                '</div>'
            }
        ];
        $(document).on('click', '.add-permission', function () {
            // $('#add_permission').modal('show');
            permissionModal = $.jsPanel({
                position: {my: "center-top", at: "center-top", offsetY: 15},
                contentSize: {width: 600, height: 300},
                headerTitle: "{{trans('access.new_permission')}}",
                contentAjax: {
                    url: '{{route('Access.newPermissionModal')}}',
                    method: 'POST',
                    dataType: 'json',
                    done: function (data, textStatus, jqXHR, panel) {
                        this.headerTitle(data.header);
                        this.content.html(data.content);
                        this.toolbarAdd('footer', [{item: data.footer}]);
                    }
                }
            });
            permissionModal.content.html('<div class="loader"></div>');
        });

        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------open use-role ------------------------------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        role_user_modal_btn = [
            {
                item: '' +
                '<div >' +
                '   <button type="button" name="saveUser-Role" id="saveUser-Role" value="save" class="btn btn-info" type="button">' +
                '       <i class="glyphicon  glyphicon-save-file bigger-125"></i>' +
                '       <span>{{trans('app.save')}}</span>' +
                '   </button>' +
                '</div>'
            }
        ];
        $('.add-user-role').click(function () {
            // $('#user-role-form')[0].reset();
            userRoleModal = $.jsPanel({
                position: {my: "center-top", at: "center-top", offsetY: 15},
                contentSize: {width: 600, height: 200},
                headerTitle: "{{trans('access.new_user_role')}}",
                contentAjax: {
                    url: '{{route('Access.userRoleModal')}}',
                    type: 'post',
                    autoload: true,
                    dataType: 'json',
                    done: function (data, textStatus, jqXHR, panel) {
                        this.headerTitle(data.header);
                        this.content.html(data.content);
                        this.toolbarAdd('footer', [{item: data.footer}])
                    }
                }
            });
            userRoleModal.content.html('<div class="loader"></div>');
        });
        $("select[name='user']").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.users')}}",
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
        $("select[name='user_search']").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.users')}}",
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
        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------save use-role ------------------------------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        $(document).on('click', '#saveUser-Role', function () {
            var obj = {};
            $('#user-role-form select').each(function () {
                obj[this.name] = this.value;
            });
            $.ajax({
                url: '{{ route('Access.saveUserRole') }}',
                method: 'POST',
                data: obj,
                success: function (data) {
                    res = JSON.parse(data);
                    console.log(res.success);
                    if (res.success == true) {
                        // $('#add_user_role').modal('hide');
                        userRoleModal.close();
                        $('#userRoleGrid').DataTable().ajax.reload();
                        messageModal('success', '{{trans('app.save')}}', {0: '{{trans('access.succes_insert_data')}}'});
                    } else if (res.success == false && res.error == 'insertError') {
                        $('#user-role-error-msg').empty();
                        errorsFunc('{{trans('app.error')}}', {0: '{{trans('access.saved_unsuccessfull')}}'}, {id: 'user-role-error-msg'}, 'user-role-form');
                    }
                }
            });
        });
        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------userRoleList GRID ------------------------------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        var userRoleGrid = '';

        function uRoleGrid(user_id, role_id) {

            userRoleGrid = $('#userRoleGrid').DataTable({
                "language": LangJson_DataTables,
                processing: true,
                serverSide: true,
                "dom": '<"col-xs-5"f><"col-xs-4 text-center"l><"user_role_toolbar">t<"col-xs-12 text-center"p><"clearfixed">',
                columnDefs: [
                    {
                        targets: [1],
                        visible: false
                    },
                    {
                        targets: [2],
                        visible: false
                    }
                ],
                ajax: {
                    url: '{!! route('Access.userRoleList' )!!}',
                    type: 'POST',
                    data: {'user_id': user_id, 'role_id': role_id},
                },
                columns: [
                    {
                        data: 'index',
                        name: 'index',
                        width: '1%'
                    },
                    {
                        data: 'user_id',
                        name: 'user_id',
                        width: '1%'
                    },
                    {
                        data: 'role_id',
                        name: 'role_id',
                        width: '1%'
                    },
                    {
                        data: 'UName',
                        name: 'UName',
                        mRender: function (data, type, full) {
                            //  console.log(full);
                            return full.Name + ' ' + full.Family + '(' + full.UName + ')';
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',

                    },
                    {
                        data: 'action',
                        name: 'action',
                        mRender: function (data, type, full) {
                            var actions = '<a class="cls3"   style="margin: 2px" onclick="deleteUserRole(' + full.user_id + ',' + full.role_id + ')" href="#"><i class="fa fa-close"></i></a>';
                            return actions;
                        }
                    }
                ]
            });
            userRoleGrid.on('order.dt search.dt', function () {
                userRoleGrid.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        }
        uRoleGrid(0, 0);
        $('select[name="role_search"]').on("change", function (e) {
            userRoleGrid.destroy();
            uRoleGrid(0, this.value);
        });
        $('select[name="user_search"]').on("change", function (e) {
            userRoleGrid.destroy();
            uRoleGrid(this.value, 0);
        });
        $(document).on('click', '.refresh', function () {
            // alert('ggggggggg');
            window.location.href = window.location.href;
        });
        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------open permission-role ------------------------------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        $('a[href="#role-permission"]').click(function () {
            $('select[name="permission"]').select2({
                minimumInputLength: 3,
                dir: "rtl",
                width: "100%",
                tags: false,
                ajax: {
                    url: '{{ route('auto_complete.permissions') }}',
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
            $('select[name="permission_search"]').select2({
                minimumInputLength: 3,
                dir: "rtl",
                width: "100%",
                tags: false,
                ajax: {
                    url: '{{ route('auto_complete.permissions') }}',
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

        });
        permission_role_modal_btn = [
            {
                item: '' +
                '<div >' +
                '   <button type="button" name="savePermission-Role" id="savePermission-Role" value="save" class="btn btn-info" type="button">' +
                '       <i class="glyphicon  glyphicon-save-file bigger-125"></i>' +
                '       <span>{{trans('app.save')}}</span>' +
                '   </button>' +
                '</div>'
            }
        ];
        $('.add-permission-role').click(function () {
            permissionRoleModal = $.jsPanel({
                position: {my: "center-top", at: "center-top", offsetY: 15},
                contentSize: {width: 600, height: 200},
                headerTitle: "{{trans('access.new_permission_role')}}",
                contentAjax: {
                    url: '{{route('Access.permissionRoleModal')}}',
                    type: 'post',
                    autoload: true,
                    dataType: 'json',
                    done: function (data, textStatus, jqXHR, panel) {
                        this.headerTitle(data.header);
                        this.content.html(data.content);
                        this.toolbarAdd('footer', [{item: data.footer}])
                    }
                }
            });
            permissionRoleModal.content.html('<div class="loader"></div>');
            $('select[name="permission"]').val('').trigger('change');
            //$('#add_permission_role').modal('show');

        });
        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------save use-role ------------------------------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        $(document).on('click', '#savePermission-Role', function () {
            var obj = {};
            $("#permission-role-form select").each(function () {
                obj[this.name] = this.value;
            });
            $.ajax({
                url: '{{ route('Access.savePermissionRole') }}',
                method: 'POST',
                data: obj,
                success: function (data) {
                    res = JSON.parse(data);
                    if (res.success == true) {
                        //$('#add_permission_role').modal('hide');
                        permissionRoleModal.close();
                        $('#permissionRoleGrid').DataTable().ajax.reload();
                        messageModal('success', '{{trans('app.save')}}', {0: '{{trans('access.saved_successfully')}}'});
                    } else if (res.success == false && res.error == 'insertError') {
                        $('#permission-role-error-msg').empty();
                        errorsFunc('{{trans('app.error')}}', {0: '{{trans('access.saved_unsuccessfull')}}'}, {id: 'permission-role-error-msg'}, 'permission-role-form');
                    }
                }
            });
        });
        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------permissionRoleList GRID ------------------------------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        var permissionRoleGrid = '';
        function pRgrid(permission_id, role_id) {
            permissionRoleGrid = $('#permissionRoleGrid').DataTable({
                "language": LangJson_DataTables,
                processing: true,
                serverSide: true,
                "dom": '<"col-xs-5"f><"col-xs-4 text-center"l><"permissions_role_toolbar">t<"col-xs-12 text-center"p><"clearfixed">',
                columnDefs: [
                    {
                        targets: [1],
                        visible: false
                    },
                    {
                        targets: [2],
                        visible: false
                    }
                ],
                ajax: {
                    url: '{!! route('Access.permissionRoleList' )!!}',
                    type: 'POST',
                    data: {'permission_id': permission_id, 'role_id': role_id}
                },
                columns: [
                    {
                        data: 'index',
                        name: 'index',
                        width: '1%'
                    },
                    {
                        data: 'permission_id',
                        name: 'permission_id',
                        width: '1%'
                    },
                    {
                        data: 'role_id',
                        name: 'role_id',
                        width: '1%'
                    },
                    {
                        data: 'permission_name',
                        name: 'permission_name'

                    },
                    {
                        data: 'role_name',
                        name: 'role_name'

                    },
                    {
                        data: 'action',
                        name: 'action',
                        mRender: function (data, type, full) {
                            var actions = '<a class="cls3"   style="margin: 2px" onclick="deletepermissionRole(' + full.permission_id + ',' + full.role_id + ')" href="#"><i class="fa fa-close"></i></a>';
                            return actions;
                        }
                    }
                ]
            });
            permissionRoleGrid.on('order.dt search.dt', function () {
                permissionRoleGrid.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        }
        pRgrid(0, 0);
        $('select[name="role_search"]').on("change", function (e) {
            permissionRoleGrid.destroy();
            pRgrid(0, this.value);
        });
        $('select[name="permission_search"]').on("change", function (e) {
            permissionRoleGrid.destroy();
            pRgrid(this.value, 0);
        });
        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------added user to role in roler-user modal ----------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        $(document).on('click', '#show_user_role #add-user', function () {
            var sid = $("#show_user_role select[name='users'] option:selected").val();
            /* var clumnLength={};
             clumnLength.fist = $('#show_user_role .fist-row input').length;
             clumnLength.second = $('#show_user_role .second-row input').length;
             clumnLength.third = $('#show_user_role .third-row input').length;
             var selectedItem ='';
             var min = 1000000000;
             for(item in clumnLength)
             {

             if(parseInt(clumnLength[item]) < min )
             {
             min =parseInt(clumnLength[item]) ;
             selectedItem = item;
             }
             }
             $('#show_user_role .'+selectedItem+'-row ').append('<lable>'+txt+'<input type="checkbox"  checked name="selectd-user" value="'+sid+'"></lable><br/>');*/
            var obj = {};
            obj.user = $("#show_user_role select[name='users'] option:selected").val();
            obj.roles = $('#show_user_role input[name="role_id"]').val();
            $.ajax({
                url: '{{ route('Access.saveUserRole') }}',
                method: 'POST',
                data: obj,
                success: function (data) {
                    res = JSON.parse(data);
                    if (res.success == true) {
                        $('#userRoleById').DataTable().ajax.reload();
                        $('#rolesGrid').DataTable().ajax.reload();
                        showMsgModal('success', '{{trans('app.save')}}', '{{trans('access.saved_successfully')}}');
                    } else if (res.success == false && res.error == 'insertError') {
                        errorsFunc('{{trans('app.error')}}', {0: '{{trans('access.saved_unsuccessfull')}}'}, {id: 'user-role-error-msg'}, 'user-role-form');
                    }
                }
            });
        });
        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------get permission list ----------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        //  $('a[href="#role-permission-edit"]').on('click',function(){
        $.ajax({
            url: '{{ route('auto_complete.all_permissions') }}',
            method: 'POST',
            dataType: 'json',
            success: function (data) {
                var f = '';
                var s = '';
                var t = '';
                //console.log(data);
                for (var i = 0; i < data.length; i += 3) {
                    if (data[i]) {
                        f += '<lable><input type="checkbox"   name="selected-permission" value="' + data[i].id + '">' + data[i].text + '</lable><br/>';
                    }
                    if (data[i + 1]) {
                        s += '<lable><input type="checkbox"   name="selected-permission" value="' + data[i + 1].id + '">' + data[i + 1].text + '</lable><br/>';
                    }
                    if (data[i + 2]) {
                        t += '<lable><input type="checkbox"   name="selected-permission" value="' + data[i + 2].id + '">' + data[i + 2].text + '</lable><br/>';
                    }
                }
                $('#role-permission-edit .fist-row').html(f);
                $('#role-permission-edit .second-row').html(s);
                $('#role-permission-edit .third-row').html(t);
            }
        });
        //  });

        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------saveRolePermission ----------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        $(document).on('click', '#role-permission-edit button[name="saveRolePermission"]', function () {
            var obj = {};
            obj.role_id = $("#role-permission-edit select[name='roles'] option:selected").val();
            var permissions = new Array();
            $('#role-permission-edit input[name="selected-permission"]:checked').each(function (index, value) {
                permissions[index] = this.value;
            });
            obj.permissions = permissions;
            $.ajax({
                url: '{{ route('Access.savePermissionRoleGroup') }}',
                method: 'POST',
                dataType: 'json',
                data: obj,
                success: function (data) {
                    if (data.success == true) {
                        $('#add_permission_role').modal('hide');
                        $('#permissionRoleGrid').DataTable().ajax.reload();
                        $('#rolesGrid').DataTable().ajax.reload();
                        messageModal('success', '{{trans('app.save')}}', {0: '{{trans('access.saved_successfully')}}'});
                    } else if (data.success == false && data.error == 'insertError') {
                        errorsFunc('{{trans('app.error')}}', {0: '{{trans('access.saved_unsuccessfull')}}'}, {id: 'permission-role-error-msg'}, 'permission-role-form');
                    }
                }
            });
        });
        $(document).on('change', '#role-permission-edit select[name="roles"]', function () {
            var obj = {};
            obj.role_id = this.value;
            $.ajax({
                url: '{!! route('Access.getPermissionByRoleId' )!!}',
                type: 'POST', // Send post dat
                data: obj,
                dataType: 'json',
                async: false,
                success: function (data) {
                    //  $('a[href="#role-permission-edit"]').html(' دسترسی های ' + title);
                    $('#role-permission-edit input[name="selected-permission"]').removeAttr('checked');
                    var f = '';
                    var s = '';
                    var t = '';
                    for (var i = 0; i < data.length; i++) {
                        $('#role-permission-edit input[name="selected-permission"][value="' + data[i].permission_id + '"]').prop("checked", "true");
                    }
                }
            });
        });
    });//end document ready
</script>
