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
    <div>
        <input type="radio" name="new_session_save_type" class="new_session_save_type_draft" id="new_session_save_type_draft" value="0" checked/>
        <label for="new_session_save_type_draft" id="new_session_save_type_draft_l">{{ trans('general.draft') }}</label>
        <input type="radio" name="new_session_save_type" class="new_session_save_type_final" id="new_session_save_type_final" value="1"/>
        <label for="new_session_save_type_final" id="new_session_save_type_final_l">{{ trans('general.final') }}</label>
    </div>
    <a data-form_id = "create_new_event" data-again_save = "1" class="btn btn-primary pull-left save_session" id="">
        <i ></i>
        {{trans('calendar_events.ce_modal_session_save_and_create_new')}}
    </a>
    <button type="button" name="saveSessionUserEvent" id="saveSessionUserEvent" class="btn btn-primary pull-left">
        <span> {{trans('app.confirm')}}</span>
    </button>
@elseif($btn_type=='editSession')
    <button type="button" name="saveSessionUserEvent" id="saveSessionUserEvent"
            class="btn btn-primary pull-left">
        <i class="glyphicon  glyphicon-arrow-left bigger-125"><span> {{trans('app.confirm')}}</span></i>
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
    <div>
        <input type="radio" name="new_reminder_save_type" class="new_reminder_save_type_draft" id="new_reminder_save_type_draft" value="0" checked/>
        <label for="new_reminder_save_type_draft" id="new_reminder_save_type_draft_l">{{ trans('general.draft') }}</label>
        <input type="radio" name="new_reminder_save_type" class="new_reminder_save_type_final" id="new_reminder_save_type_final" value="1"/>
        <label for="new_reminder_save_type_final" id="new_reminder_save_type_final_l">{{ trans('general.final') }}</label>
    </div>
    <a data-form_id = "create_new_reminder" data-again_save = "1" class="btn btn-primary pull-left save_reminder" id="">
        <i ></i>
        {{trans('calendar_events.ce_modal_reminder_save_and_create_new')}}
    </a>
    <button type="button" name="saveReminderUserEvent" id="saveReminderUserEvent" class="btn btn-primary pull-left">
        <span> {{trans('app.confirm')}}</span>
    </button>
@endif