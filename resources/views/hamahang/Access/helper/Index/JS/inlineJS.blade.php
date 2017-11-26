@include('hamahang.Access.helper.Index.JS.document_ready')
<script>
    var roleModal = '';
    var permissionModal = '';
    var userRoleModal = '';
    var permissionRoleModal = '';
    /*################################################################################################################*/
    /*------------------------------------------------------------------------------------------------------------------------*/
    /*---------------------------------------------edit role--------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------------------------------*/
    function editRole(id) {
        roleModal = $.jsPanel({
            position: {my: "center-top", at: "center-top", offsetY: 15},
            contentSize: {width: 600, height: 150},
            headerTitle: "{{trans('access.new_role')}}",
            contentAjax: {
                url: '{{route('Access.newRoleModal')}}',
                type: 'post',
                method: 'POST',
                dataType: 'json',
                done: function (data, textStatus, jqXHR, panel) {
                    console.log(data.content);
                    this.headerTitle(data.header);
                    this.content.html(data.content);
                    this.toolbarAdd('footer', [{item: data.footer}]);
                    $('#form-invitation-content').hide();
                }
            }
        }).toolbarAdd("footer", role_modal_btn);
        roleModal.content.html('<div class="loader"></div>');
        var obj = {};
        obj.id = id;
        $.ajax({
            url: '{!! route('Access.editRole',['username'=>$uname] )!!}',
            method: 'POST',
            data: obj,
            success: function (data) {
                res = JSON.parse(data);
                //console.log(res);
                $('#roles-form input[name="name"]').val(res.name);
                $('#roles-form input[name="display_name"]').val(res.display_name);
                $('#roles-form input[name="edit_id"]').val(id);
                $('#add_role').modal('show');

            }
        });
    }
    /*################################################################################################################*/
    /*------------------------------------------------------------------------------------------------------------------------*/
    /*---------------------------------------------edit Permission--------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------------------------------*/
    function editPermission(id) {
        permissionModal = $.jsPanel({
            position: {my: "center-top", at: "center-top", offsetY: 15},
            contentSize: {width: 600, height: 300},
            headerTitle: "{{trans('access.new_permission')}}",
            contentAjax: {
                url: '{{route('Access.newPermissionModal')}}',
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
        permissionModal.content.html('<div class="loader"></div>');
        var obj = {};
        obj.id = id;
        $.ajax({
            url: '{!! route('Access.editPermission',['username'=>$uname] )!!}',
            method: 'POST',
            data: obj,
            success: function (data) {
                res = JSON.parse(data);
                //console.log(res);
                $('#permission-form input[name="name"]').val(res.name);
                $('#permission-form input[name="display_name"]').val(res.display_name);
                $('#permission-form textarea[name="description"]').val(res.description);
                $('#permission-form input[name="edit_id"]').val(id);
                $('#add_permission').modal('show');

            }
        });
    }
    /*################################################################################################################*/
    /*------------------------------------------------------------------------------------------------------------------------*/
    /*---------------------------------------------user-role deleted--------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------------------------------*/
    function deleteUserRole(uid, roleid) {
        var obj = {};
        obj.uid = uid;
        obj.roleid = roleid;
        confirmModal({
            title: '{{trans('access.remove_access')}}',
            message: '{{trans('access.are_you_sure')}}',
            onConfirm: function () {
                $.ajax({
                    url: '{!! route('Access.deleteUserRole')!!}',
                    type: 'POST', // Send post dat
                    data: obj,
                    async: false,
                    success: function (s) {
                        res = JSON.parse(s);

                        if (res.success == true) {

                            messageModal('success', '{{trans('access.remove_access')}}', {0: '{{trans('access.removed_record')}}'});
                            $('#userRoleGrid').DataTable().ajax.reload();
                            $('#userRoleById').DataTable().ajax.reload();
                        }
                    }
                });
            },
            afterConfirm: 'close'
        });
    }
    /*################################################################################################################*/
    /*------------------------------------------------------------------------------------------------------------------------*/
    /*---------------------------------------------permission-role deleted--------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------------------------------*/
    function deletepermissionRole(permission, roleid) {
        var obj = {};
        obj.permission = permission;
        obj.roleid = roleid;
        confirmModal({
            title: '{{trans('access.remove_access')}}',
            message: '{{trans('access.are_you_sure')}}',
            onConfirm: function () {
                $.ajax({
                    url: '{!! route('Access.deletepermissionRole')!!}',
                    type: 'POST', // Send post dat
                    data: obj,
                    async: false,
                    success: function (s) {
                        res = JSON.parse(s);
                        if (res.success == true) {
                            messageModal('success', '{{trans('access.remove_access')}}', {0: '{{trans('access.removed_record')}}'});
                            $('#permissionRoleGrid').DataTable().ajax.reload();
                        }
                    }
                });
            },
            afterConfirm: 'close'
        });
    }
    /*################################################################################################################*/
    /*------------------------------------------------------------------------------------------------------------------------*/
    /*---------------------------------------------permission-role deleted--------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------------------------------*/
    function showUserRole(id) {
        userRoleModal = $.jsPanel({
            position: {my: "center-top", at: "center-top", offsetY: 15},
            contentSize: {width: 600, height: 300},
            headerTitle: "{{trans('access.edit_user_role')}}",
            contentAjax: {
                url: '{{route('Access.userRoleModal')}}',
                type: 'post',
                autoload: true
            }
        }).toolbarAdd('footer', role_user_modal_btn);
        var obj = {};
        obj.role_id = id;
        $("#show_user_role select[name='users']").select2({
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
        /* $.ajax({
         url:'{!! route('Access.roleUsers',['username'=>$uname] )!!}',
         type: 'POST', // Send post dat
         data: obj,
         dataType :'json',
         success: function (data) {
         /*  var f='';
         var s='';
         var t ='';
         for(var i=0 ; i< data.length;i +=3)
         {
         if(data[i])
         {
         f +='<lable>'+data[i].text+' '+data[i].family+'<input type="checkbox"  checked name="selectd-user" value="'+data[i].id+'"></lable><br/>';
         }
         if(data[i+1])
         {
         s +='<lable>'+data[i+1].text+' '+data[i+1].family+'<input type="checkbox" checked name="selectd-user" value="'+data[i+1].id+'"></lable><br/>';
         }
         if(data[i+2])
         {
         t +='<lable>'+data[i+2].text+' '+data[i+2].family+'<input type="checkbox" checked name="selectd-user" value="'+data[i+2].id+'"></lable><br/>';
         }
         }
         $('#show_user_role .fist-row').html(f);
         $('#show_user_role .second-row').html(s);
         $('#show_user_role .third-row').html(t);

         }
         })*/
        $('#show_user_role input[name="role_id"]').val(id);
        userRoleById = $('#userRoleById').DataTable({
            "dom": window.CommonDom_DataTables,
            language: LangJson_DataTables,
            processing: true,
            serverSide: true,
            pagingType: "numbers",
            autoWidth: false,
            sPaginationType: "bootstrap",
            pageLength: 5,
            lengthChange: false,
            "order": [[0, 'desc']],
            destroy: true,
            info: false,
            columnDefs: [
                {
                    targets: [0],
                    visible: false
                }
            ],
            ajax: {
                url: '{!! route('Access.roleUsers')!!}',
                type: 'POST',
                data: {'role_id': id}
            },
            columns: [
                {
                    data: 'created_at',
                    name: 'created_at',
                    width: '1%'
                },
                {
                    data: 'index',
                    name: 'index',
                    width: '1%'
                },
                {
                    data: 'text',
                    name: 'text',
                    mRender: function (data, type, full) {
                        return full.text + ' ' + full.family;
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    width: "10%",
                    mRender: function (data, type, full) {
                        var actions = '<a class="cls3"   style="margin: 2px" onclick="deleteUserRole2(' + full.id + ',' + full.role_id + ')" href="#"><i class="fa fa-close"></i></a>';
                        return actions;
                    }
                }
            ]
        });
        userRoleById.on('order.dt search.dt', function () {
            userRoleById.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }
    /*################################################################################################################*/
    /*------------------------------------------------------------------------------------------------------------------------*/
    /*---------------------------------------------delete user frol user role---------------------------------------------*/
    /*------------------------------------------------------------------------------------------------------------------------*/
    function deleteUserRole2(uid, roleid) {
        var obj = {};
        obj.uid = uid;
        obj.roleid = roleid;
        confirmModal({
            title: '{{trans('access.remove_access')}}',
            message: '{{trans('access.are_you_sure')}}',
            onConfirm: function () {
                $.ajax({
                    url: '{!! route('Access.deleteUserRole')!!}',
                    type: 'POST', // Send post dat
                    data: obj,
                    async: false,
                    success: function (s) {
                        res = JSON.parse(s);
                        if (res.success == true) {
                            successFunc('{{trans('access.remove_access')}}', {0: '{{trans('access.removed_record')}}'}, {'class': 'show_user_role_msgBox'});
                        }
                    }
                });
            },
            afterConfirm: 'close'
        });
    }
    /*################################################################################################################*/
    /*------------------------------------------------------------------------------------------------------------------------*/
    /*---------------------------------------------showPermissionRole function---------------------------------------------*/
    /*------------------------------------------------------------------------------------------------------------------------*/
    function showPermissionRole(id, title) {
        console.log(id);
        $('#role-permission-edit select[name="roles"]').val(id);
        $('#role-permission-edit select[name="roles"]').trigger('change');
        $('a[href="#role-permission-edit"]').trigger('click');
    }

    /*################################################################################################################*/
    /*------------------------------------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------------------------------------*/
</script>
