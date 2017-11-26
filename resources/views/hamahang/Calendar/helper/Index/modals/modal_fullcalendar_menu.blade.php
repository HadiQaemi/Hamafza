<style>
    #modal_fullcalendar_menu table tr td
    {
        text-align: center;
    }
</style>
<div class="modal fade fade_1s" id="modal_fullcalendar_menu" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span>{{ trans('calendar.modal_fullcalendar_register_event_select_type') }}  </span>


                </h4>
            </div>
            <div class="modal-body">
                <div id="tab" class="container"  style="width: 90%">
                    <table width="100%">
                        <tbody>

                        <tr>
                            <td class="col-sm-6"><a href="#" onclick="showEvenModal()" > <div class="fa fa-calendar fa-4x"></div> <div >{{trans('calendar.modal_fullcalendar_menu_save_event')}}</div> </a></td>
                            <td class="col-sm-6"><a href="#" onclick="showSessionModal();"><div  class="fa fa fa-address-card fa-4x"></div><div >{{trans('calendar.modal_fullcalendar_menu_save_session')}}</div></a></td>
                        </tr>
                        <tr>
                            <td class="col-sm-6"><a href="#" onclick="showInvitationModal();"><div  class="fa fa-envelope fa-4x"></div><div >{{trans('calendar.modal_fullcalendar_menu_save_invitation')}}</div></a></td>
                            <td class="col-sm-6"><a href="#" onclick="showReminderModal();"><div  class="fa fa-bell fa-4x"></div><div >{{trans('calendar.modal_fullcalendar_menu_save_reminder')}}</div></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <table class=" col-md-12">
                    <tr>
                        <td class="col-md-3">{{ trans('calendar.modal_fullcalendar_start') }}</td>
                        <td class="col-md-1" id="modal_start_date"></td>
                        <td class="col-md-1" id="modal_start_time"></td>
                        <td class="col-md-5">{{ trans('calendar.modal_fullcalendar_end') }}</td>
                        <td class="col-md-1" id="modal_end_date"></td>
                        <td class="col-md-1" id="modal_end_time"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <input type="hidden" name="startdate" value="" >
    <input type="hidden" name="enddate" value="" >
    <input type="hidden" name="starttime" value="" >
    <input type="hidden" name="endtime" value="" >
</div>
