@include('hamahang.Menus.helper.Index.JS.docuement_ready')
<script>
/*------------------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------edit menu fujnction--------------------------------------------------------------*/
/*------------------------------------------------------------------------------------------------------------------------*/
function editMenu(id)
{
  /*  menuModal = $.jsPanel({
        position: {my: "center-top", at: "center-top", offsetY: 15},
        contentSize: {width: 600, height: 400},
        headerTitle: "منو",
        contentAjax: {
            url: '{{route('Menus.menuModal')}}',
            type :'post',
            autoload: true
        }
    }).toolbarAdd("footer", tb);;*/

    $('a[href="#menuAccess"]').hide();
$.ajax({
    url: '{{ URL::route('Menus.getMenuRoutes',['uname'=>$uname] )}}',
    type: 'POST', // Send post dat
    async: false,
    success: function (s) {
        internalRoutes = JSON.parse(s);
        console.log(s);
        var options = '<option value="0">{{ trans('menus.select') }}</option>';
        for (var i = 0; i < internalRoutes.length; i++) {
            if(internalRoutes[i].route_title !='')
            {
                var routeTitle = internalRoutes[i].route_title;
            }
            else
            {
                var routeTitle = '{{ trans('menus.no_title_entered') }}';
            }
            options += '<option value="' + internalRoutes[i].route_name + '">' +routeTitle + '</option>';
        }
        //   console.log(options);
        $('#route_title').append(options);

        $('#route_title').select2({
            dir: "rtl",
            width: '100%',

        });
    }
});

    $.ajax({
        url: '{{ URL::route('auto_complete.menus')}}',
        type: 'POST', // Send post dat
        async: false,
        dataType:'json',
        success: function (data) {
            $('select[name="parent_id_search"]').select2({
                placeholder:'{{trans('app.select_a_option')}}',
                dir: "rtl",
                width: '100%',
                data:data
            }).val(null).trigger('change');
            $('#parentId').select2({
                placeholder:'{{trans('app.select_a_option')}}',
                dir: "rtl",
                width: '100%',
                data:data
            }).val(null).trigger('change');

            $('select[name="menus"]').select2({
                placeholder:'{{trans('app.select_a_option')}}',
                dir: "rtl",
                width: '100%',
                data:data
            }).val(null).trigger('change');
        }
    });
    var obj={};
    obj.id= id;
    $.ajax({
        url: '{{ URL::route('Menus.edit',['uname'=>$uname] )}}',
        data: obj,
        type: 'POST', // Send post dat
        success: function (s) {
            res = JSON.parse(s);
            console.log(res.route_name);
            $('#add_new_menu_form input[name="title"]').val(res.title);
            $('#add_new_menu_form select[name="menu_type_id"]').val(res.menu_type_id).trigger("change");
            $('#add_new_menu_form select[name="parent_id"]').val(res.parent_id).trigger("change");

            if(res.route_name !=null)
            {

                $('#add_new_menu_form input[name="menu_link_type"]').val(1).prop('checked',true);
                $('#add_new_menu_form select[name="route_title"]').val(res.route_name).trigger("change");
                var varbs =JSON.parse(res.route_variable);

                if(varbs !='')
                {
                    var html='<tr id="selectedRouteVars">'+
                            '<td class="col-xs-3"><label>{{ trans('menus.variables_of_this_route') }}</label></td>'+
                            '<td class="col-xs-9">' +
                            '<table class="col-xs-12" > ';
                    for(var i=0 ; i< varbs.length;i++)
                    {
                        //console.log();
                        var fname =Object.keys(varbs[i])[0];

                        var vname = varbs[i][fname];

                        html += '<tr>'+
                                '<td class="col-xs-4">'+fname+'</td>'+
                                '<td  class="col-xs-8"><input name="'+fname+'" value="'+vname+'"/></td>'+
                                '</tr>';



                    }
                    html += '</table>';
                    $('#routeRow').after(html);
                }

            }else {
                $('#add_new_menu_form  input[name="href"]').val(res.href);
                $('#add_new_menu_form input[name="menu_link_type"]').val(2).prop('checked',true);
                $('#add_new_menu_form  input[name="href_type"]').val(res.href_type).prop('checked',true);;

                $('#add_new_menu_form input[name="menu_link_type"]').trigger('click');

            }
            // $('#add_new_menu_form input[name="permission"]').val( res.permission );
             $('#add_new_menu_form  input[name="a_target"]:checked').val(res.a_target);
           $('#add_new_menu_form   input[name="id_name"]').val( res.id_name);
           $('#add_new_menu_form   input[name="class_name"]').val( res.class_name );
           $('#add_new_menu_form   textarea[name="li_atrr"]').val( res.li_atrr);
            $('#add_new_menu_form   textarea[name="a_attr"]').val(res.a_attr );
            $('#add_new_menu_form   textarea[name="custom_sql"]').val(res.custom_sql);
            $('#add_new_menu_form   textarea[name="state"]').val(res.state);
           /* if(res.is_relation)
            {
                $('#add_new_menu_form input[name="is_relation"]').prop('checked',true);

            }*/
            $('#add_new_menu_form input[name="edit_id"]').val(res.id);


            $('#menu_add').modal({show:true});
        }
    });
}

/*################################################################################################################*/
/*------------------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------deleted function--------------------------------------------------------------*/
/*------------------------------------------------------------------------------------------------------------------------*/
function deleteMenu(id) {
   // $('#remove_confirm_modal #modal_massage').html('آیا از حذف این منو اطمینان دارید ؟ ');
   // $('#remove_confirm_modal').modal('show');
    var obj = {};
    obj.id = id;
   /* $('.yes_no_btn').click(function () {

        if ($(this).val() == 'yes') {
            $.ajax({
                url: '{{ URL::route('Menus.delete',['uname'=>$uname] )}}',
                type: 'POST', // Send post dat
                data: obj,
                async: false,
                success: function (s) {
                    if (res.success == true) {
                        $('#remove_confirm_modal').modal('hide');
                        showMsgModal('حذف ', ' منو مورد نظر حذف گردید');
                        menusGrid.ajax.reload();
                    }else if(res.success == false && res.error !='')
                    {

                        showMsgModal('حذف ', 'بدلیل اینه منو مورد نظر والد منوی دیگری است حذف آن امکان ندارد');
                    }
                }

            });
        }

    });*/
    confirmModal({
        title:'{{ trans('menus.delete_menu_title') }}',
        message :'{{ trans('menus.sure_to_delete_this_menu') }}',
        onConfirm :function()
        {
            $.ajax({
                url: '{{ URL::route('Menus.delete',['uname'=>$uname] )}}',
                type: 'POST', // Send post dat
                data: obj,
                async: false,
                success: function (s) {
                    res = JSON.parse(s);

                    if (res.success == true) {

                        messageModal('success', '{{ trans('app.delete') }}' ,{0:'{{ trans('menus.selected_menu_deleted') }}'});
                        $('#menusGrid').DataTable().ajax.reload();
                    }else if(res.success == false && res.error !='')
                    {

                        messageModal('error','{{ trans('app.delete') }}', {0:'{{ trans('menus.cant_delete_cause_menu_is_parent_of_another_menu') }}'});
                    }
                }

            });
        },
        afterConfirm :'close'
    });

}
/*########################################################################################################################*/
/*------------------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------MenuType edit function------------------------------------------------------*/
/*------------------------------------------------------------------------------------------------------------------------*/

function editMenuType(id, el) {

    var tr = $(el).parent().parent();
    var html = '<button id="reject-menu-type" class="center-block btn btn-danger  fa fa-close bigger-125 pull-left"type="button">'+
            'انصراف'+
            '</button> '+
                '<button type="button" id="edit-menu-type" value="save" class="center-block btn btn-info  fa fa-floppy-o  pull-left">'+
                '<span>ویرایش</span>'+
                '</button>';
                ;
    $('#menyTypeForm .mtype_btn').html(html);
    $('#menyTypeForm input[name="title"]').val($(tr).find('td:nth-child(2)').text());
    $('#menyTypeForm input[name="edit_id"]').val(id);



}
/*########################################################################################################################*/
/*------------------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------MenuType delete function------------------------------------------------------*/
/*------------------------------------------------------------------------------------------------------------------------*/
function deleteMenuType(id) {
   /* $('#remove_confirm_modal #modal_massage').html('آیا از حذف این منو اطمینان دارید ؟ ');
    $('#remove_confirm_modal').modal({backdrop: 'static', keyboard: false});
    var obj = {};
    obj.id = id;
    $('.yes_no_btn').click(function () {

        if ($(this).val() == 'yes') {
            $.ajax({
                url: '{{ URL::route('MenuTypes.delete',['uname'=>$uname] )}}',
                type: 'POST', // Send post dat
                data: obj,
                async: false,
                success: function (s) {
                    if (res.success == true) {
                       // alert('hhhh');
                        $('#remove_confirm_modal').modal('hide');
                        showMsgModal('حذف ', ' منو مورد نظر حذف گردید');
                        menuTypesGrid.ajax.reload();
                    }
                }

            });
        }

    });*/
    var obj = {};
    obj.id = id;
                confirmModal({
                    title:'{{ trans('menus.delete_menu_title') }}',
                    message :'{{ trans('menus.sure_to_delete_this_menu') }}',
                    onConfirm :function()
                    {
                        $.ajax({
                            url: '{{ URL::route('MenuTypes.delete',['uname'=>$uname] )}}',
                            type: 'POST', // Send post dat
                            data: obj,
                            async: false,
                            success: function (s) {
                                if (res.success == true) {
                                    messageModal('success', '{{ trans('app.delete') }}' ,{0:'{{ trans('menus.selected_menu_deleted') }}'});
                                    $('#menuTypesGrid').DataTable().ajax.reload();
                                }
                            }

                        });
                    },
                    afterConfirm :'close'
                });


}
/*########################################################################################################################*/
/*------------------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------reOder function by id------------------------------------------------------*/
/*------------------------------------------------------------------------------------------------------------------------*/
 function reOrder(id,option)
 {

    var order = $('input[name="order-'+id+'"]').val();
     var obj ={};
     obj.id= id;
     obj['option']= option;
     obj.orderVal=order;
     //console.log(currentRowIndex);return;

     $.ajax({
         url: '{{ URL::route('Menus.reOrder',['uname'=>$uname] )}}',
         type: 'POST', // Send post dat
         data: obj,
         async: false,
         dataType :'json',
         success: function (s) {
             if(s.success==true)
             {
                 $('#menusGrid').dataTable()._fnAjaxUpdate();
                 messageModal('success','{{trans('menus.reorder_save_title')}}',{0:'{{trans('menus.reorder_saved')}}'});
             }

         }

     });
 }

/*########################################################################################################################*/
/*------------------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------MenuRole edit function------------------------------------------------------*/
/*------------------------------------------------------------------------------------------------------------------------*/

function editMenuRole(id, el) {
    var obj={};
    obj.id=id;
$.ajax({
    url:'{!! route('Menus.editMenuRole',['username'=>$uname] )!!}',
            type: 'POST', // Send post dat
            data: obj,
            async: false,
    success :function(data)
    {
        var res = JSON.parse(data);
      //  console.log(res);
        $('#menuRoleForm select[name="menus"]').val(res.menu_id).trigger('change');
        $('#menuRoleForm select[name="roles"]').val(res.role_id).trigger('change');
         $('#menuRoleForm input[name="edit_id"]').val(id);
        var html = '<button id="reject-menu-role" class="center-block btn btn-danger  fa fa-close bigger-125 pull-left"type="button">'+
                'انصراف'+
                '</button> '+
                '<button type="button" id="edit-menu-role" value="save" class="center-block btn btn-info  fa fa-floppy-o  pull-left">'+
                '<span>ویرایش</span>'+
                '</button>';
        $('#menuRoleForm .btn_holder').html(html);
    }
});



}
/*########################################################################################################################*/
/*------------------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------MenuRole delete function------------------------------------------------------*/
/*------------------------------------------------------------------------------------------------------------------------*/
function deleteMenuRole(id) {
    var obj = {};
    obj.id = id;


    confirmModal({
        title:'{{ trans('menus.delete_access') }}',
        message :'{{ trans('menus.sure_to_delete_permission') }}',
        onConfirm :function()
        {
            $.ajax({
                url: '{{ URL::route('Menus.deleteMenuRole',['uname'=>$uname] )}}',
                type: 'POST', // Send post dat
                data: obj,
                async: false,
                success: function (s) {
                    if (res.success == true) {
                        messageModal('success', '{{ trans('app.delete') }}' ,{0:'{{ trans('menus.access_deleted') }}'});
                        $('#menuRolesGrid').DataTable().ajax.reload();
                    }
                }

            });
        },
        afterConfirm :'close'
    });


}
/*########################################################################################################################*/
/*------------------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------MenuUser edit function------------------------------------------------------*/
/*------------------------------------------------------------------------------------------------------------------------*/

function editMenuUser(id, el) {
    var obj={};
    obj.id=id;
    $.ajax({
        url:'{!! route('Menus.editMenuUser',['username'=>$uname] )!!}',
        type: 'POST', // Send post dat
        data: obj,
        async: false,
        success :function(data)
        {
            var res = JSON.parse(data);

            $('#menuUserForm select[name="menus"]').val(res.menu_id).trigger('change');
            $("#menuUserForm select[name='users']").select2("trigger", "select", {
                data: { id : res.user_id, text:res.uname }
            });
            $('#menuUserForm input[name="edit_id"]').val(id);
            var html = '<button id="reject-menu-user" class="center-block btn btn-danger  fa fa-close bigger-125 pull-left"type="button">'+
                    'انصراف'+
                    '</button> '+
                    '<button type="button" id="edit-menu-user" value="save" class="center-block btn btn-info  fa fa-floppy-o  pull-left">'+
                    '<span>ویرایش</span>'+
                    '</button>';
            $('#menuUserForm .btn_holder').html(html);
        }
    });



}
/*########################################################################################################################*/
/*------------------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------MenuUser delete function------------------------------------------------------*/
/*------------------------------------------------------------------------------------------------------------------------*/
function deleteMenuUser(id) {

    var obj = {};
    obj.id = id;

    confirmModal({
        title:'{{ trans('menus.delete_access') }}',
        message :'{{ trans('menus.sure_to_delete_permission') }}',
        onConfirm :function()
        {
            $.ajax({
                url: '{{ URL::route('Menus.deleteMenuUser',['uname'=>$uname] )}}',
                type: 'POST', // Send post dat
                data: obj,
                async: false,
                success: function (s) {
                    if (res.success == true) {
                        messageModal('success', '{{ trans('app.delete') }}' ,{0:'{{ trans('menus.access_deleted') }}'});
                        $('#menuUsersGrid').DataTable().ajax.reload();
                    }
                }

            });
        },
        afterConfirm :'close'
    });

}
/*########################################################################################################################*/
/*------------------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------undisplay menu fumnction------------------------------------------------------*/
/*------------------------------------------------------------------------------------------------------------------------*/
 function invisible(id)
 {
     var obj={};
     obj.id=id;
     $.ajax({
         url: '{{ URL::route('Menus.invisibleMenu',['uname'=>$uname] )}}',
         type: 'POST', // Send post dat
         data: obj,
         async: false,
         success: function (s) {
             res =JSON.parse(s);
             if (res.success == true) {
                 // alert('hhhh');

                 messageModal('success','{{ trans('menus.hide') }}', {0:'{{ trans('menus.selected_menu_deleted_from_showing_menus') }}'});
                 $('#menusGrid').DataTable().ajax.reload();

             }
         }

     });
 }
/*########################################################################################################################*/
/*------------------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------رهسهذمث menu fumnction------------------------------------------------------*/
/*------------------------------------------------------------------------------------------------------------------------*/
function visible(id)
{
    var obj={};
    obj.id=id;
    $.ajax({
        url: '{{ URL::route('Menus.visibleMenu',['uname'=>$uname] )}}',
        type: 'POST', // Send post dat
        data: obj,
        async: false,
        success: function (s) {
            res =JSON.parse(s);
            if (res.success == true) {
                // alert('hhhh');

                messageModal('success',' ', {0:'{{ trans('menus.selected_menu_became_showable') }}'});
                $('#menusGrid').DataTable().ajax.reload();

            }
        }

    });
}
</script>