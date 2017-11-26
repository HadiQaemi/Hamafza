<script>
    var menusGrid='';

    var currentRowIndex=0;
var selectedMenus = new Array();
    function menuGridList(mtype,parent_id)
    {
        menusGrid = $('#menusGrid').DataTable({
            "language": LangJson_DataTables,
            processing: true,
            serverSide: true,
            "order": [[2, "asc"]],

            "dom": '<"col-xs-5"f><"col-xs-4 text-center"l><"toolbar">t<"col-xs-12 text-center"p><"clearfixed">',
            initComplete: function(){
                $("div.toolbar")
                        .html('<button  class="btn btn-default btn-xs btn-success col-xs-1 pull-left " id="addMenu">' +
                                '<i ></i>'+
                                '{{ trans('app.add') }}' +
                                '</button>');
            },
            columnDefs: [
                {
                    targets:[5],
                    visible:false

                },
                {
                    targets:[7],
                    visible:false

                }

            ],
            ajax: {
                url: '{!! route('Menus.list',['username'=>$uname] )!!}',
                type: 'POST',
                data : {'parent_id':parent_id,'mType':mtype},
            },
            columns: [
                {
                    data: 'index',
                    name: 'index',
                    width: '1%'
                },
                {
                    data: 'check',
                    name: 'check',
                    width: '1%',
                    mRender: function (data, type, full) {
                        return '<input type="checkbox" name="selected_menu" value="'+full.id+'" />';
                    }
                },

                {
                    data: 'title',
                    name: 'title',
                    width: '79%'
                },
                {
                    data: 'order',
                    name: 'order',
                    className: 'reorder',
                    mRender: function (data, type, full) {
                        return '<table  boder="0">' +
                                '<tr>' +
                                '<td  style="padding: 1px!important" ><a href="#" onclick="reOrder('+full.id+',\'up\');"><i class="fa fa-2 fa-sort-asc" aria-hidden="true"></i></a></td>'+
                                '<td  style="padding: 1px!important;vertical-align: middle" rowspan="2">'+
                                '<input style="width:30px" type="text" name="order-'+full.id+'" value="'+full.order+'">' +
                                '<a href="#" onclick="reOrder('+full.id+',\'in\');"><i class="fa fa-save"></i></a>'+
                                '</td>'+
                                '</tr>' +
                                '<tr>'+
                                '<td style="padding: 1px!important"><a href="#" onclick="reOrder('+full.id+',\'down\');"><i class="fa fa-2 fa-sort-desc" aria-hidden="true"></i></a></td>'+
                                '</tr>' +
                                '</table>';
                        ;
                    }

                },
                {
                    data: 'type_title',
                    name: 'type_title',
                    width: '79%'
                },
                {
                    data: 'mtype',
                    name: 'mtype'

                },

                {
                    data: 'parent_title',
                    name: 'parent_title',
                    width: '79%'
                },
                {
                    data: 'pid',
                    name: 'pid'

                },


                {
                    data: 'action',
                    name: 'action',
                    mRender: function (data, type, full) {
                        // console.log(full);
                        var actions = '<a class="cls3"   style="margin: 2px" onclick="editMenu(' + full.id +')" href="#"><i class="fa fa-edit"></i></a>' +
                                '<a class="cls3"  style="margin: 2px" onclick="deleteMenu(' + full.id + ')" href="#"><i class="fa fa-close"></i></a>';
                        if(full.invisible==0)
                        {
                            actions += '<a class="cls3" alert="{{ trans('app.visible_invisible') }}" title="" style="margin: 2px" onclick="invisible(' + full.id + ')" href="#"><i class="fa fa-eye"></i></a>';

                        }else {
                            actions+= '<a class="cls3" alert=""{{ trans('app.visible_invisible') }}" title=""{{ trans('app.visible_invisible') }}" style="margin: 2px" onclick="visible(' + full.id + ')" href="#"><i class="fa fa-eye-slash"></i></a>';
                        }
                        ;


                        return actions;
                    }


                },
            ],



        });

    }

    $('document').ready(function(){
        $('#hrefRow').hide();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var mObj = {};
        mObj['option'] ='tree';
        var treeMenuData ='';
   /*  $.ajax({
            url: '{{ URL::route('hamahang.Menus.get_menu_nodes')}}',
            data :mObj,
            type: 'POST',
            success: function (response) {
                treeMenuData = response;
                console.log(treeMenuData);
            }
        });*/

        //fill data to tree  with AJAX call

      /* $('#customMenu').jstree({

            "plugins" : ["themes", "html_data", "ui", "crrm", "contextmenu","wholerow", "checkbox","search"],
            'core' : {
                'dataType' : 'json',
                'data' : {
                    "url" :'{{ URL::route('hamahang.Menus.get_menu_nodes')}}',
                    type: 'POST',
                    "data" : function (node) {
                        return { "id" : node.id };
                    }
                },
                'check_callback': true
            }
        });
        $('#customMenu').on('click', 'li a', function () {window.location = $(this).attr('href'); });*/
        var internalRoutes = '';
        var menuTypesGrid = '';

        // ('#menu-types').html('');
        $.ajax({
            url: '{{ URL::route('auto_complete.menuTypes' )}}',
            type: 'POST', // Send post dat
            async: false,
            dataType :'json',
            success: function (data) {
                $('select[name="menu_type_search"]').select2({
                    placeholder: '{{trans('app.select_a_option')}}',
                    width: '100%',
                    allowClear: true,
                    data : data

                }).val(null).trigger('change');
                $('#menu-types').select2({
                    placeholder:'{{trans('app.select_a_option')}}',
                    width: '100%',
                    allowClear: true,
                    data : data

                }).val(null).trigger('change');
            }
        });

        $(document).on('click','#addMenu',function(){

            $.ajax({
                url: '{{ URL::route('Menus.getMenuRoutes',['uname'=>$uname] )}}',
                type: 'POST', // Send post dat
                async: false,
                success: function (s) {
                    internalRoutes = JSON.parse(s);
                    //console.log(s);
                    var options = '<option value="0">انتخاب نمایید ...</option>';
                    for (var i = 0; i < internalRoutes.length; i++) {
                        if(internalRoutes[i].route_title !='')
                        {
                            var routeTitle = internalRoutes[i].route_title;
                        }
                        else
                        {
                            var routeTitle = 'عنوانی وارد نشده ';
                        }
                        options += '<option value="' + internalRoutes[i].route_name + '">' +routeTitle + '</option>';
                    }
                    //   console.log(options);
                    $('#route_title').append('<option value="0"></option>'+options);
                    $('#route_title').select2({
                        placeholder: '{{trans('app.select_a_option')}}',
                        width: '100%',
                        allowClear: true

                    });;
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
            $('#add_new_menu_form select[name="menu_role"]').val([2,3]);
            $('#add_new_menu_form select[name="menu_role"]').trigger('change');


        });

        $('a[href="#menuRoleAcces"]').click(function(){
           // alert('gggggggggg');
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
        });
/*---------------------------------------------------------------------------------------------------------------*/
/*----------------------------add menu burtton clicke event-------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
     $(document).on('click','#addMenu',function(){
            $('a[href="#menuAccess"]').show()
         $('#menu_add').modal({show :'true'});
     });
/*################################################################################################################*/
/*---------------------------------------------------------------------------------------------------------------*/
/*----------------------------saveMenu burtton clicke event-------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
$('#savedMenu').click(function(){
    obj = {};
    obj.title = $('#add_new_menu_form input[name="title"]').val();
    obj.menu_type_id = $('#add_new_menu_form  select[name="menu_type_id"]').val();
    obj.parent_id = $('#add_new_menu_form  select[name="parent_id"]').val();
    if($('#add_new_menu_form input[name="menu_link_type"]:checked').val()==1)
    {
        obj.href_type = 1;
        obj.route_name = $('#add_new_menu_form select[name="route_title"]').val();
        if(('#selectedRouteVars input').length)
        {

            routeVarbArr = new Array();
            var index = 0;
            $('#selectedRouteVars input').each(function(index, value){
                varbsObj = {};
                varbsObj[this.name] = this.value;
                routeVarbArr[index] = varbsObj
                index++;
            });
           // console.log(varbsObj);return;
            obj.route_vars = JSON.stringify(routeVarbArr);
        }
    }else
    {
        obj.href = $('#add_new_menu_form  input[name="href"]').val();
        obj.href_type = 2;
    }
   // obj.permission =  $('#add_new_menu_form input[name="permission"]').val();
    obj.a_target = $('#add_new_menu_form  input[name="a_target"]').val();
    obj.id_name =$('#add_new_menu_form   input[name="id_name"]').val();
    obj.class_name =$('#add_new_menu_form   input[name="class_name"]').val();
    obj.li_atrr =$('#add_new_menu_form   textarea[name="li_atrr"]').val();
    obj.a_attr =$('#add_new_menu_form   textarea[name="a_attr"]').val();
    //obj.custom_sql =$('#add_new_menu_form   textarea[name="custom_sql"]').val();
   /* if($('#add_new_menu_form input[name="is_relation"]').is(':checked'))
    {
        obj.is_relation = 1;
    }
    else
    {
        obj.is_relation = 0;
    }*/
    obj.state =$('#add_new_menu_form   textarea[name="state"]').val();
    if( $('#add_new_menu_form input[name="edit_id"]').val())
    {
        obj.id= $('#add_new_menu_form input[name="edit_id"]').val();
    }
    obj.roles =$('#add_new_menu_form select[name="menu_role"]').val();
    obj.users =$('#add_new_menu_form select[name="menu_users"]').val();

    $.ajax({
        url: '{{ URL::route('Menus.save',['uname'=>$uname] )}}',
        data :obj,
        type: 'POST', // Send post dat
        async: false,
        success: function (s) {
            s = JSON.parse(s);
            if(s.success==false)
            {


                $('#menuErrorMsg').empty();
                errorsFunc('{{ trans('app.error') }}',s.error,{id:'menuErrorMsg'},'add_new_menu_form');
                //$('#menuErrorMsg').html(warning);
            }
            else
            {
                $('#menu_add').modal('hide');
                $('#sucsessMsg').empty();
                successFunc('',{0:'{{ trans('menus.data_saved_successfully') }}'},{id:'sucsessMsg'},'add_new_menu_form')
                $('#menusGrid').DataTable().ajax.reload();


            }
        }
    });

});
/*################################################################################################################*/
/*---------------------------------------------------------------------------------------------------------------*/
/*----------------------------menu type change event-------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
$('input[name="menu_link_type"]').change(function(){
  var param = $('input[name="menu_link_type"]:checked').val();
   if(param == 1)
   {
       $('#routeRow').show();
       $('#hrefRow').hide();
   }else if(param ==2 )
   {
       if($('#selectedRouteVars').length)
       {
           $('#selectedRouteVars').remove();
       }
       $('#routeRow').hide();
       $('#hrefRow').show();
   }

});

/*################################################################################################################*/
/*---------------------------------------------------------------------------------------------------------------*/
/*----------------------------route cange event-------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/

$('#route_title').change(function (){
    var selected=$(this).val();
    $('#selectedRouteVars').remove();
    var selectedIndex =0;
        for( var i=0; i< internalRoutes.length;i++)
        {

            if( internalRoutes[i].route_name == selected){

                 selectedIndex = i;
            }
        }
        if(selectedIndex)
        {
            var html='<tr id="selectedRouteVars">'+
                    '<td class="col-xs-3"><label>{{ trans('menus.variables_of_this_route') }}</label></td>'+
                    '<td class="col-xs-9">' +
                    '<table class="col-xs-12" > ';

            varbs = internalRoutes[selectedIndex].variables;
            if(varbs.indexOf('/') != -1){
                varbs = varbs.split('/');
                for(var i=0; i<varbs.length ; i++)
                {
                    html += '<tr>'+
                            '<td class="col-xs-4">'+varbs[i]+'</td>'+
                            '<td  class="col-xs-8"><input name="'+varbs[i]+'" value=""/></td>'+
                            '</tr>';

                }
            }else
            {
                html += '<tr>'+
                        '<td class="col-xs-4">'+varbs+'</td>'+
                        '<td  class="col-xs-8"><input name="'+varbs+'" value=""/></td>'+
                        '</tr>';
            }

            html += '</table>';
            $('#routeRow').after(html);
        }

});
/*################################################################################################################*/
/*---------------------------------------------------------------------------------------------------------------*/
/*----------------------------Menus GRID ------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
       menuDataobj={};
            menuDataobj.parent_id =0;
             menuDataobj.mtype =0 ;
        menuGridList(0,0);
        menusGrid.on('order.dt search.dt', function () {
            menusGrid.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();


        /*$.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var menu_typ = parseInt( $('#menu_type_search').val() );
                    var parent_id  = parseInt( $('#parent_id_search').val() );

                    if (  isNaN( menu_typ ) || isNaN( parent_id ))
                    {
                        return true;
                    }
                    return false;
                }
        );*/
        $('select[name="menu_type_search"]').select2();
        $('select[name="menu_type_search"]').change(function(){

           /* if($(this).val() == -1)
            {
                window.location.reload();
            }else
            {
                menusGrid.column(4).search($(this).val()).draw() ;
            }*/
            menusGrid.destroy();
            menuGridList($(this).val(),0);

        //   $('select[name="parent_id_search"]').select2('val',0);
        });
        $('select[name="parent_id_search"]').select2();
        $('select[name="parent_id_search"]').change(function(){

          /*  if($(this).val() == -1)
            {
                window.location.reload();
            }else
            {
                alert($(this).val());
                menusGrid.column(6).search($(this).val()).draw() ;
            }*/
            menusGrid.destroy();
            menuGridList(0,$(this).val());
           //$('select[name="menu_type_search"]').select2('val',-1);

        });
        $('.menu_refresh').click(function(){
           window.location.href = window.location.href
        })



    /*################################################################################################################*/
    /*---------------------------------------------------------------------------------------------------------------*/
    /*----------------------------menu types ---------------------------------------------------------------------*/
    /*---------------------------------------------------------------------------------------------------------------*/



        menuTypesGrid = $('#menuTypesGrid').DataTable({
            "dom": window.CommonDom_DataTables,
            "language": LangJson_DataTables,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('MenuTypes.list',['username'=>$uname] )!!}',
                type: 'POST'
            },
            columns: [
                {
                    data: 'index',
                    name: 'index',
                    width: '1%'
                },

                {
                    data: 'title',
                    name: 'title',
                    width: '79%'
                },
                {
                    data: 'action',
                    name: 'action',
                    mRender: function (data, type, full) {
                        var actions = '<a class="cls3"   style="margin: 2px" onclick="editMenuType(' + full.id + ',this)" href="#"><i class="fa fa-edit"></i></a>' +
                                '<a class="cls3"  style="margin: 2px" onclick="deleteMenuType(' + full.id + ')" href="#"><i class="fa fa-close"></i></a>';

                        return actions;
                    }


                },
            ]
        });
        menuTypesGrid.on('order.dt search.dt', function () {
            menuTypesGrid.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

       $('#add-menu-type').click(function () {
            var title = $('#menyTypeForm input[name="title"]').val();
            var edit_id = $('#menyTypeForm input[name="edit_id"]').val();
            var obj = {};
            if (edit_id > 0)
                obj.id = edit_id;
            obj.title = title;

            $.ajax({
                url: '{{ URL::route('MenuTypes.save',['uname'=>$uname] )}}',
                type: 'POST', // Send post dat
                data: obj,
                async: false,
                success: function (s) {
                    res = JSON.parse(s);
                    console.log(res);
                    if (res.success == true) {
                        var html = '{{ trans('menus.record_saved_successfully') }}' ;
                        successFunc('{{ trans('menus.register_menu') }}',{0:html},{id:'menTypeMsg'},'menyTypeForm');
                       // $('#menTypeMsg').html(html);
                        menuTypesGrid.ajax.reload();

                        $('#menyTypeForm')[0].reset();
                    }else if(res.success == false)
                    {
                        errorsFunc('{{ trans('app.error') }}',res.error,{id:'menTypeMsg'},'menyTypeForm');
                    }
                }
            });
        });
        /*#######################################################################################################*/
        /*-------------------------------------------------------------------------------------------------------*/
        /*-------------------------------------------------------------------------------------------------------*/
        /*-------------------------------------------------------------------------------------------------------*/
        $.ajax({
            url :'{{ route('auto_complete.roles') }}',
            method:'POST',
            dataType:'json',
            success : function(data) {
                $('select[name="roles"]').select2({
                    placeholder:'{{trans('app.select_a_option')}}',
                    dir: "rtl",
                    width: '100%',
                    data:data
                }).val(null).trigger('change');
                $('select[name="menu_role"]').select2({
                    placeholder:'{{trans('app.select_a_option')}}',
                    dir: "rtl",
                    width: '100%',
                    data:data
                }).val(null).trigger('change');
            }

            });
        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------saveMenuRole burtton clicke event-------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/

        $('#add-menu-role').click(function () {
            var menu_id = $('#menuRoleForm select[name="menus"]').val();
            var role_id = $('#menuRoleForm select[name="roles"]').val();
            var edit_id = $('#menuRoleForm input[name="edit_id"]').val();
            var obj = {};
            if (edit_id > 0)
                obj.id = edit_id;
            obj.menu_id = menu_id;
            obj.role_id = role_id;
            $.ajax({
                url: '{{ URL::route('Menus.saveMenuRole',['uname'=>$uname] )}}',
                type: 'POST', // Send post dat
                data: obj,
                async: false,
                success: function (s) {
                    res = JSON.parse(s);

                    if (res.success == true) {
                        $('#menuRolesGrid').DataTable().ajax.reload();
                        var html ='{{ trans('menus.registered_successfully') }}';
                        successFunc('{{ trans('menus.register_access') }}',{0:html},{id:'menRoleMsg'},'menuUserForm');
                      //  $('#menRoleMsg').html(html);


                        $('select[name="menus"]').val(-1).trigger('change');
                        $('select[name="roles"]').val(-1).trigger('change');
                    }
                }
            });
        });
        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------saveMenuRole grid-------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        var menuRoleGrid ='';


        menuRoleGrid = $('#menuRolesGrid').DataTable({
            "dom": window.CommonDom_DataTables,
            "language": LangJson_DataTables,
            processing: true,
            serverSide: true,
            columnDefs: [
                {
                    targets:[1],
                    visible:false

                },
                {
                    targets:[2],
                    visible:false

                }

            ],
            ajax: {
                url: '{!! route('Menus.menuRoleList',['username'=>$uname] )!!}',
                type: 'POST'
            },
            columns: [
                {
                    data: 'index',
                    name: 'index',
                    width: '1%'
                },
                {
                    data: 'menu_id',
                    name: 'menu_id',
                    width: '1%'
                },
                {
                    data: 'role_id',
                    name: 'role_id',
                    width: '1%'
                },

                {
                    data: 'title',
                    name: 'title',
                    width: '79%'
                },
                {
                    data: 'name',
                    name: 'name',
                    mRender :function(data,type,full)
                    {
                        return full.display_name+'<spaml>('+full.name+')</smal>';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    mRender: function (data, type, full) {
                        var actions = '<a class="cls3"   style="margin: 2px" onclick="editMenuRole(' + full.id + ',this)" href="#"><i class="fa fa-edit"></i></a>' +
                                '<a class="cls3"  style="margin: 2px" onclick="deleteMenuRole(' + full.id + ')" href="#"><i class="fa fa-close"></i></a>';

                        return actions;
                    }


                },
            ]
        });
        menuRoleGrid.on('order.dt search.dt', function () {
            menuRoleGrid.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------users select -------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        $("select[name='users']").select2({
            minimumInputLength: 2,
            dir: "rtl",
            width: '100%',
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
        $("select[name='menu_users']").select2({
            minimumInputLength: 2,
            dir: "rtl",
            width: '100%',
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
        /*----------------------------save user- menu -------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        $('#add-menu-user').click(function () {
            var user_id = $('#menuUserForm select[name="users"]').val();
            var menu_id = $('#menuUserForm select[name="menus"]').val();
            var edit_id = $('#menuUserForm input[name="edit_id"]').val();
            var obj = {};
            if (edit_id > 0)
                obj.id = edit_id;
            obj.user_id = user_id;
            obj.menu_id = menu_id;
            $.ajax({
                url: '{{ URL::route('Menus.saveMenuUser',['uname'=>$uname] )}}',
                type: 'POST', // Send post dat
                data: obj,
                async: false,
                success: function (s) {
                    res = JSON.parse(s);
                    console.log(res);
                    if (res.success == true) {
                        $('#menuUsersGrid').DataTable().ajax.reload();
                        var html = '{{ trans('menus.record_saved_successfully') }}' ;
                        successFunc('{{ trans('menus.register_access') }}',{0:html},{id:'menuUserMsg'},'menuUserForm');

                        $('select[name="menus"]').val(-1).trigger('change');
                        $('select[name="users"]').val(-1).trigger('change');
                    }
                }
            });
        });
        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------menuGrid grid-------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        var menuUsersGrid ='';


        menuUsersGrid = $('#menuUsersGrid').DataTable({
            "dom": window.CommonDom_DataTables,
            "language": LangJson_DataTables,
            processing: true,
            serverSide: true,
            columnDefs: [
                {
                    targets:[1],
                    visible:false

                },
                {
                    targets:[2],
                    visible:false

                }

            ],
            ajax: {
                url: '{!! route('Menus.menuUserList',['username'=>$uname] )!!}',
                type: 'POST'
            },
            columns: [
                {
                    data: 'index',
                    name: 'index',
                    width: '1%'
                },
                {
                    data: 'menu_id',
                    name: 'menu_id',
                    width: '1%'
                },
                {
                    data: 'user_id',
                    name: 'user_id',
                    width: '1%'
                },

                {
                    data: 'title',
                    name: 'title',
                    width: '79%'
                },
                {
                    data: 'uname',
                    name: 'uname',
                    width: '79%'
                },
                {
                    data: 'action',
                    name: 'action',
                    mRender: function (data, type, full) {
                        var actions = '<a class="cls3"   style="margin: 2px" onclick="editMenuUser(' + full.id + ',this)" href="#"><i class="fa fa-edit"></i></a>' +
                                '<a class="cls3"  style="margin: 2px" onclick="deleteMenuUser(' + full.id + ')" href="#"><i class="fa fa-close"></i></a>';

                        return actions;
                    }


                },
            ]
        });
        menuUsersGrid.on('order.dt search.dt', function () {
            menuUsersGrid.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------selectd all menus-------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        $('#menusGrid input[name="select_all"]').click(function(){
            if(this.checked)
            {
                $('#menusGrid input[name="selected_menu"]').each(function(){
                    this.checked = true;
                    selectedMenus[selectedMenus.length] = this.value;
                });
            }else {
                $('#menusGrid input[name="selected_menu"]').each(function(){
                    this.checked = false;
                    var index = selectedMenus.indexOf(this.value);
                    if(index != -1) {
                        selectedMenus.splice(index, 1);
                    }
                });
            }
        });
        $(document).on('click','#menusGrid input[name="selected_menu"]',function(){
            if(this.checked) {
                selectedMenus[selectedMenus.length] = this.value;
                this.checked = true;
            }else {
                this.checked = false;
                var index = selectedMenus.indexOf(this.value);
                if(index != -1) {
                    selectedMenus.splice(index, 1);
                }
                $('#menusGrid input[name="select_all"]').removeAttr('checked');
            }
        });
        menusGrid.on('draw', function(){
            // Update state of "Select all" control
            for(i in selectedMenus)
            {
                console.log(i);
               $('#menusGrid input[name="selected_menu"][value="'+selectedMenus[i]+'"').prop('checked',true);
            }
        })
        /*################################################################################################################*/
        /*---------------------------------------------------------------------------------------------------------------*/
        /*----------------------------save collrection menu access-------------------------------------------------------*/
        /*---------------------------------------------------------------------------------------------------------------*/
        $(document).on('click','#add-collection-menus .add-menu-access',function(){
            obj={};
            obj.menus = selectedMenus;
            obj.role_id = $('#add-collection-menus select[name="roles"]').val();
            obj.user_id = $('#add-collection-menus select[name="users"]').val();
            $.ajax({
                url: '{!! route('Menus.addMenusAccess',['username'=>$uname] )!!}',
                type: 'POST', // Send post dat
                data: obj,
                dataType: 'json',
                success: function (data) {
                    if(data.success==true)
                    {
                        messageModal('success','{{ trans('app.save') }} ',data.msg);
                        $('#menuRolesGrid').DataTable().ajax.reload();
                        $('#menuUsersGrid').DataTable().ajax.reload();
                        for(var i=0 ; i<selectedMenus.length;i++)
                        {
                            selectedMenus.splice(i, 1);
                        }
                    }else {
                        messageModal('error','{{ trans('app.save') }} ',data.error);
                    }

                }

            });
        });
        $(document).on('click','#reject-menu-type',function(){
            $('#menyTypeForm input[name="title"]').val(' ');
            $('#menyTypeForm input[name="edit_id"]').val(' ');
            var div= $(this).parent();
            div.html('<button type="button" id="add-menu-type" value="save" class="btn btn-info pull-left">'+
                    '<i class="glyphicon  glyphicon-save-file bigger-125 pull-left"></i>'+
                    '<span>ثبت</span>'+
                    '</button>');
        });
        $(document).on('click','#edit-menu-type',function(){
            var title = $('#menyTypeForm input[name="title"]').val();
            var edit_id = $('#menyTypeForm input[name="edit_id"]').val();
            var obj = {};
            if (edit_id > 0)
                obj.id = edit_id;
            obj.title = title;

            $.ajax({
                url: '{{ URL::route('MenuTypes.save',['uname'=>$uname] )}}',
                type: 'POST', // Send post dat
                data: obj,
                async: false,
                success: function (s) {
                    res = JSON.parse(s);
                    console.log(res);
                    if (res.success == true) {
                        var html = '{{ trans('menus.record_saved_successfully') }}' ;
                        successFunc('{{ trans('menus.register_menu') }}',{0:html},{id:'menTypeMsg'},'menyTypeForm');
                        // $('#menTypeMsg').html(html);
                        menuTypesGrid.ajax.reload();
                                   $('#reject-menu-type').trigger('click')  ;
                        $('#menyTypeForm')[0].reset();
                    }else if(res.success == false)
                    {
                        errorsFunc('{{ trans('app.error') }}',res.error,{id:'menTypeMsg'},'menyTypeForm');
                    }
                }
            });
        });
        $(document).on('click','#reject-menu-role',function(){
            $('#menuRoleForm select[name="menus"]').val('').trigger('change');
            $('#menuRoleForm select[name="roles"]').val('').trigger('change');
            $('#menuRoleForm input[name="edit_id"]').val('');
            var div= $(this).parent();
            div.html('<button type="button" id="add-menu-role" value="save" class="btn btn-info pull-left">'+
                    '<i class="glyphicon  glyphicon-save-file bigger-125 pull-left"></i>'+
                    '<span>ثبت</span>'+
                    '</button>');
        });
        $(document).on('click','#edit-menu-role',function(){
            var menu_id = $('#menuRoleForm select[name="menus"]').val();
            var role_id = $('#menuRoleForm select[name="roles"]').val();
            var edit_id = $('#menuRoleForm input[name="edit_id"]').val();
            var obj = {};
            if (edit_id > 0)
                obj.id = edit_id;
            obj.menu_id = menu_id;
            obj.role_id = role_id;
            $.ajax({
                url: '{{ URL::route('Menus.saveMenuRole',['uname'=>$uname] )}}',
                type: 'POST', // Send post dat
                data: obj,
                async: false,
                success: function (s) {
                    res = JSON.parse(s);

                    if (res.success == true) {
                        $('#menuRolesGrid').DataTable().ajax.reload();
                        var html ='{{ trans('menus.registered_successfully') }}';
                        successFunc('{{ trans('menus.register_access') }}',{0:html},{id:'menRoleMsg'},'menuUserForm');
                        //  $('#menRoleMsg').html(html);
                        $('#reject-menu-role').trigger('click')

                        $('select[name="menus"]').val(-1).trigger('change');
                        $('select[name="roles"]').val(-1).trigger('change');
                    }
                }
            });
        });
        $(document).on('click','#reject-menu-user',function(){
            $('#menuUserForm select[name="menus"]').val('').trigger('change');
            $("#menuUserForm select[name='users']").select2("trigger", "select", {
                data: { id :'' }
            });
            var div= $(this).parent();
            div.html('<button type="button" id="add-menu-user" value="save" class="btn btn-info pull-left">'+
                    '<i class="glyphicon  glyphicon-save-file bigger-125 pull-left"></i>'+
                    '<span>ثبت</span>'+
                    '</button>');
        });
        $(document).on('click','#edit-menu-user',function(){
            var user_id = $('#menuUserForm select[name="users"]').val();
            var menu_id = $('#menuUserForm select[name="menus"]').val();
            var edit_id = $('#menuUserForm input[name="edit_id"]').val();
            var obj = {};
            if (edit_id > 0)
                obj.id = edit_id;
            obj.user_id = user_id;
            obj.menu_id = menu_id;
            $.ajax({
                url: '{{ URL::route('Menus.saveMenuUser',['uname'=>$uname] )}}',
                type: 'POST', // Send post dat
                data: obj,
                async: false,
                success: function (s) {
                    res = JSON.parse(s);
                    console.log(res);
                    if (res.success == true) {
                        $('#menuUsersGrid').DataTable().ajax.reload();
                        var html = '{{ trans('menus.record_saved_successfully') }}' ;
                        successFunc('{{ trans('menus.register_access') }}',{0:html},{id:'menuUserMsg'},'menuUserForm');
                        $('#reject-menu-user').trigger('click')  ;
                        $('select[name="menus"]').val(-1).trigger('change');
                        $('select[name="users"]').val(-1).trigger('change');
                    }
                }
            });
        });
    });//end of document Reday

</script>
