@include('hamahang.CalendarEvents.helper.invitations.inlineJS.document_ready')
@include('hamahang.CalendarEvents.helper.invitations.inlineJS.invitations_grid')
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
    /*#####################################################################################*/
    /*-------------------------------------------------------------------------------------*/
    /*-------------------------------delete even in grid ------------------------------*/
    /*-------------------------------------------------------------------------------------*/
    function deleteّinvitattionEvent(id) {
        //  var answer = confirm('آیا از حذف این رکورد اطمینان دارید؟ ');
        var obj = {};
        obj.rec_id = id;
        var msg = '';
        var table = $('#invitationGrid').DataTable();

        $('#invitationGrid tbody').on('click', 'tr', function () {
            //  alert('ggggggggggggggg');
            var data = table.row(this).data();
            // console.log(data.title);
            msg = '{{trans("calendar_events.ce_delete_title1")}}' + data.title + ' {{trans("calendar_events.ce_delete_title2")}}';
            // $('#remove_confirm_modal #modal_massage').html(msg);

            confirmModal({
                title: 'حذف ',
                message: msg,
                onConfirm: function () {
                    $.ajax({
                        url: '{{ URL::route('hamahang.calendar_events.delete_event')}}',
                        type: 'POST', // Send post dat
                        data: obj,
                        async: false,
                        success: function (s) {
                            res = JSON.parse(s);
                            console.log(res);
                            if (res.success == false) {
                                messageModal('error', 'حذف دعوتنامه', '{{trans('calendar_events.ce_inlinejs_cant_delete_msg')}}');
                            }
                            else {

                                messageModal('success', '{{trans('calendar_events.ce_reminder_invitation_inlinejs_remove_invitattion')}}', {0: '{{trans('calendar_events.ce_inlinejs_this_record_deleted')}}'});
                                reloadinvitationGrid();
                            }
                        }

                    });
                },
                afterConfirm: 'close'
            });

        });


    }
    function reloadinvitationGrid()
    {

        $('#invitationGrid').DataTable().ajax.reload();


    }
</script>