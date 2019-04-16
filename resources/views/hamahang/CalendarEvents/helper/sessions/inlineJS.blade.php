@include('hamahang.CalendarEvents.helper.sessions.inlineJS.document_ready')
@include('hamahang.CalendarEvents.helper.sessions.inlineJS.sessions_grid')
<script>
    function showMsgModal(title,msg)
    {

        $('#modal_msgBox .modal-title').html('');
        $('#modal_msgBox #modal_massage').html('');
        if(title !='')
        {
            $('#modal_msgBox .modal-title').html(title);
        }
        $('#modal_msgBox #modal_massage').html(msg);
        $('#modal_msgBox').modal({show:true});

    }
    /*##################################################################################################*/
    /*-----------------------------------------------------------------------------------------------*/
    /*---------------------------------------decisionGrid--------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    function decisionGrid(even_id)
    {
        $('#tasklist').hide();

//console.log(even_id);
        var obj = {};
        obj.event_id = even_id;
        $('#decisionGrid').DataTable().destroy();
        $('#decisionGrid').DataTable({
            "dom": window.CommonDom_DataTables,
            "language": LangJson_DataTables,
            processing: true,
            serverSide: true,
            pagingType: "numbers",
            autoWidth: false,
            sPaginationType : "bootstrap",
            pageLength: 5,
            lengthChange: false,
            ajax: {
                url: '{!! route('hamahang.calendar_events.fetch_session_decisions')!!}',
                type: 'POST',
                data : obj,
            },
            columns: [
                {
                    data: 'rowIndex',
                    name: 'rowIndex',
                    width: '1%'


                },
                {
                    data: 'title',
                    name: 'title',
                    width: '89%',

                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: '10%',
                    mRender: function (data, type, full) {


                        var actions =      '<a class="cls3"   alt='+'{{trans('calendar_events.ce_delete_label')}}'+' title='+'{{trans('calendar_events.ce_delete_label')}}'+'  style="margin: 2px" onclick="deleteDecisions(' + full.id +')" href="#"><i class="fa fa-close"></i></a>';
                         {{--actions +=      '<a class="cls3"  alt='+'{{trans('calendar_events.ce_helper_session_inlinejs_desicion_task')}}'+' title='+'{{trans('calendar_events.ce_helper_session_inlinejs_desicion_task')}}'+' style="margin: 2px" onclick="addTasks(' + full.id +','+ full.event_id+',\''+full.title+'\')" href="#"><i class="fa fa-tasks"></i></a>'--}}
                         ;

                        return actions;


                    }

                }

            ]
        });



    }
    /*##################################################################################################*/
    /*-----------------------------------------------------------------------------------------------*/
    /*------------------------------------session user list---------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/


    function sessionUsers(id)
    {
        var obj = {};
        obj.event_id=id;
        var html = '';

            $.ajax({
            url: '{{ URL::route('hamahang.calendar_events.session_users_list')}}',
            type: 'POST', // Send post dat
            data: obj,
            async: false,
            success: function (s) {
                res = JSON.parse(s);
                for (var i=0; i< res.length ;i++)
                {
                    html += '<tr>';
                    html += '<td class="text-center">'+res[i].rowIndex+'</td>';
                    html += '<td class="text-center">'+res[i].Uname+'</td>';
                    if(res[i].present==1)
                    {
                        html += '<td class="text-center">' +
                                    '<lable>{{trans("app.present")}}<input name="users['+res[i].id+']" type="radio" class="sUserList" data_id="'+res[i].id+'" value="1" checked="true"/></lable>'+
                                    '<lable>{{trans("app.absent")}}<input name="users['+res[i].id+']" type="radio"  class="sUserList" data_id="'+res[i].id+'" value="0" /></lable>'+
                                '</td>';
                    }
                    else
                    {
                        html += '<td class="text-center">' +
                                    '<lable>{{trans("app.present")}}<input name="users['+res[i].id+']" type="radio" class="sUserList" data_id="'+res[i].id+'"  value="1" /></lable>'+
                                    '<lable>{{trans("app.absent")}}<input name="users['+res[i].id+']" type="radio"  class="sUserList"  data_id="'+res[i].id+'" value="0" checked="true" /></lable>'+
                                '</td>';
                    }
                    html += '</tr>';
                    html +='<input type="hidden" name="event_id" value="'+id+'" />';
                }
                $('#sessionUserList tbody').html(html);
            }
        });
    }
    /*##################################################################################################*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    function taskDecisionList(id)
    {

//console.log(even_id);
        var obj = {};
        obj.event_id = id;

        $('#taskDecisionGrid').DataTable({
            "dom": window.CommonDom_DataTables,
            "language": LangJson_DataTables,
            processing: true,
            serverSide: true,
            pagingType: "numbers",
            autoWidth: false,
            sPaginationType : "bootstrap",
            pageLength: 5,
            destroy: true,
            lengthChange: false,
            ajax: {
                url: '{!! route('hamahang.calendar_events.fetch_task_of_events')!!}',
                type: 'POST',
                data : obj,
            },
            columns: [
                {
                    data: 'rowIndex',
                    name: 'rowIndex',
                    width: '1%'


                },
                {
                    data: 'decision',
                    name: 'decision',
                    width: '45%',

                },
                {
                    data: 'task',
                    name: 'task',
                    width: '44%',

                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: '10%',
                    mRender: function (data, type, full) {


                        var actions =      '<a class="cls3"   alt="حذف" title="حذف" style="margin: 2px" onclick="deletetaskDecisions(' + full.id +',\''+full.decision+'\',\''+full.task+'\')" href="#"><i class="fa fa-close"></i></a>';

                        return actions;


                    }

                }

            ]
        });




    }
    /*##################################################################################################*/

/*-----------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------*/
function minutesDailog(id)
{
    var event_id_field = '<input type="hidden" name="event_id" value="'+id+'" />';
    $('#modal_minutes_dialog .modal-footer').append(event_id_field);
    taskDecisionList(id);
    decisionGrid(id);
    sessionUsers(id);
    defaultGuests(id);
    $('#modal_minutes_dialog').modal({show:true});


}
/*##################################################################################################*/
/*-----------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------*/
 function saveDecision()
 {
    // alert('hhhhhhhhhhh');
     var obj={};
     obj.event_id = $('input[name="event_id"]').val();
     obj.title = $('.decisionForm input[name="title"]').val();
     obj.desc = $('.decisionForm textarea[name="desc"]').val();
    // console.log(obj);
     $.ajax({
         url: '{{ URL::route('hamahang.calendar_events.save_decision')}}',
         type: 'POST', // Send post dat
         data: obj,
         async: false,
         success: function (s) {
             //$('#decisionGrid').DataTable().ajax.reload();
             backtoDecistionList();
         }
     });

 }
/*##################################################################################################*/
/*-----------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------*/
function deleteDecisions(id)
{

        msg = 'آیا از حذف اطمینان دارید؟'+'<input name="decision_id" type="hidden" value="'+id+'"/>';
       // $('#remove_confirm_modal #modal_massage').html(msg);

   // $('#remove_confirm_modal').modal({show :true});

   /*$('.yes_no_btn').click(function(){

        if($(this).val()=='yes') {
            var obj = {};
            obj.id = $('input[name="decision_id"]').val();
            $.ajax({
                url: '{{ URL::route('hamahang.calendar_events.delete_decision')}}',
                type: 'POST', // Send post dat
                data: obj,
                async: false,
                success: function (s) {
                    $('#decisionGrid').DataTable().ajax.reload();
                    $('#remove_confirm_modal').modal('hide');

                }
            });
        }
   });*/
    var obj = {};
    obj.id = $('input[name="decision_id"]').val();
    confirmModal({
        title:'حذف ',
        message :msg,
        onConfirm :function()
        {
            $.ajax({
                url:'{{ URL::route('hamahang.calendar_events.delete_decision')}}',
                type: 'POST', // Send post dat
                data: obj,
                async: false,
                success: function (s) {
                    $('#decisionGrid').DataTable().ajax.reload();
                }

            });
        },
        afterConfirm :'close'
    });
}
    /*##################################################################################################*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    function addTasks(decision_id,event_id,title) {
        $.ajax({
            url: '{{ URL::route('ugc.desktop.hamahang.calendar.get_user',['uname'=>$uname])}}',
            type: 'GET', // Send post dat
            async: false,
            success: function (s) {
                s = JSON.parse(s);
                var options = '';
                var options = '';
                for (var i = 0; i < s.length; i++) {

                    options += '<option value="' + s[i].id + '">' + s[i].Uname + '</option>';
                }
                $("select[name='users[]']").empty();
                $("select[name='users[]']").append(options);


                $("select[name='users[]']").select2({
                    dir: "rtl",
                    width: '100%',
                });


            }


        });
        $('#add_task_form input[name="event_id"]').val(event_id);
        //var table = $('#decisionGrid').DataTable();


            $('.decisionTitle span:nth-child(2)').html(title);

        $('#add_task_form input[name="decision_id"]').val(decision_id);
       $('#decisionGrid').DataTable().destroy();
        $('#decisionGrid').hide();
        taskGrid(event_id);
        $('#tasklist').show();
        $('#addDecisionBtn').hide();
        $('#taskGridDecision').show();
        //$('#modal_tasks').modal({show:true});
        var html = ' <li class="breadcrumb-item "><a onclick="backtoDecistionList()" href="#"> مدیریت تصمیمات</a></li>';
        html += ' <li class="breadcrumb-item active"><a onclick="backtotaskDecisionGrid()" href="#">مدیریت وظایف</a></li>';
        $('#decisionBreadCrumb .breadcrumb').html(html);
    }
    /*##################################################################################################*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    function addNewTask()
    {


            if ($('#add_task_form input[name="immidiate"]:checked').val() == null || $('#add_task_form input[name="importance"]:checked').val() == null) {
                messageModal('error','اهمیت/ فوریت','اهمیت و فوریت تعیین نشده است');
            } else {

                var sendInfo = {
                    user_id: $('#states-multi-select-users').val(),
                    respite_date: $('#DatePicker').val(),
                    importance: $('input[name="importance"]:checked').val(),
                    immediate: $('input[name="immediate"]:checked').val(),
                    title: $('#new_task_title').val(),
                    event_id: $('input[name="event_id"]').val()
                };
                $.ajax({
                    type: "POST",
                    url: '{{ URL::route('hamahang.calendar_events.save_temporary_task') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function (s) {
                      //  s = JSON.parse(s);
                       // $('#taskGrid').DataTable().ajax().reload();
                      //  $('#taskGrid').DataTable().ajax.reload();
                        backtotaskDecisionGrid();
                    }
                });
            }
    }
    /*##################################################################################################*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    function addtasktoDecision()
    {
        var obj ={};
        obj.decision_id =  $('#add_task_form input[name="decision_id"]').val();
        var taskArr =new Array();
        $.each($('input[name="task_id[]"]'),function(index,rec) {
            if (rec.checked) {
                taskArr.push(rec.value);
            }
        });
        obj.tasks = taskArr.toString();
        $.ajax({
            type: "POST",
            url: '{{ URL::route('hamahang.calendar_events.save_task_decision') }}',
            data: obj,
            success: function (s) {
                res = JSON.parse(s);

               if(res.success==true)
               {

                   var html = 'وظایف';
                    html+='</ul>';
                    for(var i=0; i< res.titles.length;i++)
                    {
                        html +='<li>'+res.titles[i].title+'</li>';
                    }

                    html+='</ul>';
                   html +='<br/>';
                   html +='در ادمه تصمیم :';
                   html += $('.decisionTitle span:nth-child(2)').text();
                   html +='محول شد.';
                   $('#taskGrid').DataTable().ajax.reload();
                   messageModal('success','',html);
               }
            }
        });

    }
    /*##################################################################################################*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    function deletetaskDecisions(id,decision,task)
    {
        var msg = 'آیا ازحذف وظیفه'+ task+'برای تصمیم'+decision+'اطمینان دارید؟';
        {{--$('#remove_confirm_modal #modal_massage').html(msg);--}}


         {{--$('#remove_confirm_modal').modal({show :true});--}}
          {{--$('.yes_no_btn').click(function() {--}}

              {{--if ($(this).val() == 'yes') {--}}

                  {{--$.ajax({--}}
                      {{--type: "POST",--}}
                      {{--url: '{{ URL::route('hamahang.calendar_events.delete_decision_task') }}',--}}
                      {{--data: obj,--}}
                      {{--success: function (s) {--}}
                          {{--$('#remove_confirm_modal').modal('hide');--}}
                          {{--$('#taskDecisionGrid').DataTable().ajax.reload();--}}
                      {{--}--}}
                  {{--});--}}
              {{--}--}}
          {{--});--}}
        var obj = {};
        obj.rmId = id;
        confirmModal({
            title:'حذف ',
            message :msg,
            onConfirm :function()
            {
                $.ajax({
                    url: '{{ URL::route('hamahang.calendar_events.delete_decision_task') }}',
                    type: 'POST', // Send post dat
                    data: obj,
                    async: false,
                    success: function (s) {
                        $('#taskDecisionGrid').DataTable().ajax.reload();
                    }

                });
            },
            afterConfirm :'close'
        });

    }
    /*##################################################################################################*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    function savePersentUsers()
    {
        var event_id =$('#sessionUserList input[name="event_id"]').val();
        var sessionUsersAr = new Array();
        var selectId= 0;
        $.each($('#sessionUserList .sUserList'),function(index,rec) {
            if($(rec).attr('data_id') != selectId)
            {
                var selectId =$(rec).attr('data_id');
                sessionUsersAr[selectId]=$('#sessionUserList input[name="users['+selectId+']"]:checked').val();
            }
        });
        var obj = {};
        obj.event_id = event_id;
        obj.users = sessionUsersAr;
        //return;
        $.ajax({
            type: "POST",
            url: '{{ URL::route('hamahang.calendar_events.save_session_users_present') }}',
            data: obj,
            success: function (s) {
                messageModal('success','',' تغییرات انجام شد');
                sessionUsers(event_id);

            }
        });

    }
    /*##################################################################################################*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    function defaultGuests(id)
    {
        $('input[name="event_id"]').val(id);

        var obj={};
        obj.event_id = id;
        $('#guestGrid').DataTable({
            "dom": window.CommonDom_DataTables,
            "language": LangJson_DataTables,
            processing: true,
            pagingType: "numbers",
            autoWidth: false,
            sPaginationType : "bootstrap",
            destroy: true,
            pageLength: 5,
            lengthChange: false,
            ajax: {
                url: '{!! route('hamahang.calendar_events.session_guest')!!}',
                type: 'POST',
                data : obj,
            },
            columns: [
                {
                    data: 'rowIndex',
                    name: 'rowIndex',
                    width: '1%'
                },{
                    data: 'username',
                    name: 'username',
                    width: '89%'
                },{
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: '10%',
                    mRender: function (data, type, full) {
                        var actions = '<a class="cls3"   alt="حذف" title="حذف" style="margin: 2px" onclick="deleteGuest(' + full.id + ',\'' + full.username + '\')" href="#"><i class="fa fa-close"></i></a>';
                        return actions;
                    }
                },
            ],
            "drawCallback": function( settings ) {
                $('td').addClass('text-center');
            }
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
        $('#outOrganization').hide();
    }
    /*##################################################################################################*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    $('input[name="sp"]').change(function(){
        if( $('input[name="sp"]:checked').val()==1)
        {
            $('#inOrganization').show();
            $('#outOrganization').hide();
            $('input[name="user"]').val('');
        }
        else {
            $('select[name="user"]').val('');
            $('#outOrganization').show();
            $('#inOrganization').hide();
        }
    });
    /*##################################################################################################*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    function saveGuest()
    {
        var obj = {};
        obj.event_id =   $('input[name="event_id"]').val();
        if($('select[name="user"]').length && $('select[name="user"]').select().val())
        {
            obj.uid =$('select[name="user"]').select().val()
        }else {
            obj.uid = '';

        }
        if($('input[name="user"]').length && $('input[name="user"]').val())
        {
            obj.username =$('input[name="user"]').val()
        }
        else {
            obj.username = '';

        }
        $.ajax({
            type: "POST",
            url: '{{ URL::route('hamahang.calendar_events.add_guest_to_session') }}',
            data: obj,
            success: function (s) {
                $('#guestGrid').DataTable().ajax.reload();
            }
        });
    }

     function deleteGuest(id,uname)
    {
        var msg = 'آیا از حذف'+uname+' اطمینان دارید ؟';
       // $('#remove_confirm_modal #modal_massage').html(msg);


       /* $('#remove_confirm_modal').modal({show :true});
        $('.yes_no_btn').click(function() {

            if ($(this).val() == 'yes') {
                var obj = {};
                obj.rmId = id;
                $.ajax({
                    type: "POST",
                    url: '{{ URL::route('hamahang.calendar_events.delete_guest_to_session') }}',
                    data: obj,
                    success: function (s) {
                        $('#remove_confirm_modal').modal('hide');

                        showMsgModal();
                        $('#guestGrid').DataTable().ajax.reload();
                    }
                });
            }
        });*/
        var obj = {};
        obj.rmId = id;
        confirmModal({
            title:'حذف ',
            message :msg,
            onConfirm :function()
            {
                $.ajax({
                    url: '{{ URL::route('hamahang.calendar_events.delete_guest_to_session') }}',
                    type: 'POST', // Send post dat
                    data: obj,
                    async: false,
                    success: function (s) {
                        $('#guestGrid').DataTable().ajax.reload();
                        messageModal('success', 'حذف میمان', 'رکورد مورد نظر حذف گردید');
                    }

                });
            },
            afterConfirm :'close'
        });

    }
    /*##################################################################################################*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    function newDecision()
    {
        $('#decisionGrid').DataTable().destroy();
        $('#decisionGrid').hide();
        $('#addAecision').show();
        $('#addDecisionBtn').hide();
         var html = ' <li class="breadcrumb-item "><a onclick="backtoDecistionList();" href="#"> مدیریت تصمیمات</a></li>';
        html +=' <li class="breadcrumb-item active"><a href="#"> افزودن تصمیم</a></li>';
        $('#decisionBreadCrumb .breadcrumb').html(html);

    }
    /*##################################################################################################*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
   function backtoDecistionList()
   {
      // $('a[href="#decisionlist"]').trigger('click');
       event_id = $('input[name="event_id"]').val();
       //console.log(event_id);
       $('#decisionGrid').show();
       decisionGrid(event_id);
       $('#addDecisionBtn').show();
       $('#addAecision').hide();
       var html = ' <li class="breadcrumb-item active"><a onclick="backtoDecistionList();" href="#"> مدیریت تصمیمات</a></li>';
       $('#decisionBreadCrumb .breadcrumb').html(html);

   }
    /*##################################################################################################*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
   function newTask() {
        $('#taskGrid').DataTable().destroy();
       $('#taskGrid').hide();
       $('#add_task_form').show();
       $('#taskForm').show();
       $('#addDecisionBtn').hide();
       $('#addtasktoDecision').hide();
       $('#addtask-to-decisionbtn').hide();
       $('#addtaskBtn').hide();
       var html = ' <li class="breadcrumb-item "><a onclick="backtoDecistionList();" href="#"> مدیریت تصمیمات</a></li>';
       html += ' <li class="breadcrumb-item "><a onclick="backtotaskDecisionGrid()" href="#">مدیریت وظایف</a></li>';
       html += ' <li class="breadcrumb-item active"><a href="#">وظیفه جدید</a></li>';
       $('#decisionBreadCrumb .breadcrumb').html(html);

   }
    /*##################################################################################################*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    function backtotaskDecisionGrid()
    {
        $('#taskForm').hide();
        $('#addtaskBtn').show();
        $('#taskGridDecision').show();
        $('#taskGrid').show();
        $('#addtask-to-decisionbtn').show();
        $('#addtasktoDecision').show();
        $('#taskGrid').DataTable().destroy();
        var event_id = $('input[name="event_id"]').val();
        taskGrid(event_id);
        var html = ' <li class="breadcrumb-item "><a onclick="backtoDecistionList();" href="#"> مدیریت تصمیمات</a></li>';
        html += ' <li class="breadcrumb-item active"><a onclick="backtotaskDecisionGrid()" href="#">مدیریت وظایف</a></li>';

        $('#decisionBreadCrumb .breadcrumb').html(html);


    }
    /*##################################################################################################*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    /*-----------------------------------------------------------------------------------------------*/
    function taskGrid(id)
    {

        var obj={};
        obj.event_id = id;
        $('#taskGrid').DataTable({
            "dom": window.CommonDom_DataTables,
            "language": LangJson_DataTables,
            processing: true,
            pagingType: "numbers",
            autoWidth: false,
            sPaginationType : "bootstrap",
            pageLength: 5,
            lengthChange: false,
            ajax: {
                url: '{!! route('hamahang.calendar_events.decisions_temporary_task')!!}',
                type: 'POST',
                data : obj,
            },
            columns: [
                {
                    data: 'rowIndex',
                    name: 'rowIndex',
                    width: '1%'


                },
                {
                    data: 'check',
                    name: 'check',
                    width: '1%',
                    mRender: function (data, type, full)
                    {
                        return'<input type="checkbox" name="task_id[]" value="'+ full.task_id+'"/>';
                    }



                },
                {
                    data: 'title',
                    name: 'title',
                    width: '89%'

                },





            ]
        });
    }

</script>