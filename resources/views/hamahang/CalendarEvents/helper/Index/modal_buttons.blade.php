@if($btn_type=='newEvent')
    <button type="button" name="saveEvent" id="saveEvent" value="save"
            class="btn btn-info"
            type="button">
        <span>{{trans('calendar_events.ce_saved_label')}}</span>
    </button>
    @elseif($btn_type=='editEvent')
        <button type="button" name="saveEvent" id="saveEvent" value="save"
                class="btn btn-warning"
                type="button">
            <i class="glyphicon  glyphicon-save-file bigger-125"></i>
            <span>{{trans('calendar_events.ce_edit_lable')}}</span>
        </button>
    @elseif($btn_type=='session')
    <button type="button" name="saveSessionUserEvent" id="saveSessionUserEvent"
            class="btn btn-info pull-left">
        {{--<i class="glyphicon  glyphicon-arrow-left bigger-125"><span> {{trans('calendar_events.ce_saved_and_continue')}}</span></i>--}}
        <span> {{trans('calendar_events.ce_saved_label')}}</span>
    </button>
@elseif($btn_type=='editSession')
    <button type="button" name="saveSessionUserEvent" id="saveSessionUserEvent"
            class="btn btn-warning pull-left">
        <i class="glyphicon  glyphicon-arrow-left bigger-125"><span> {{trans('calendar_events.ce_edit_and_continue')}}</span></i>
    </button>
@elseif($btn_type=='editInvitation')
    <button type="button" name="saveInvitationUserEvent" id="saveInvitationUserEvent"
            class="btn btn-warning pull-left">
        <i class="glyphicon  glyphicon-arrow-left bigger-125"><span> {{trans('calendar_events.ce_edit_and_continue')}}</span></i>
    </button>
@elseif($btn_type=='invitation')
    <button type="button" name="saveInvitationUserEvent" id="saveInvitationUserEvent"
            class="btn btn-info pull-left">
        <span> {{trans('calendar_events.ce_modal_invitation_navbar_nav2')}}</span>
    </button>
@elseif($btn_type=='editReminder')
    <button type="button" name="saveReminderUserEvent" id="saveReminderUserEvent"
            class="btn btn-warning pull-left">
        <i class="glyphicon  glyphicon-arrow-left bigger-125"><span> {{trans('calendar_events.ce_edit_and_continue')}}</span></i>
    </button>
@elseif($btn_type=='reminder')
    <button type="button" name="saveReminderUserEvent" id="saveReminderUserEvent"
            class="btn btn-info pull-left">
        <i class="glyphicon  glyphicon-arrow-left bigger-125"><span> {{trans('calendar_events.ce_saved_and_continue')}}</span></i>
    </button>
@endif