<?php
Route::post('list', ['as' => 'hamahang.calendar_events.list', 'uses' => 'CalendarEventsController@fetchEvents', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.list']]);
Route::post('eventData', ['as' => 'hamahang.calendar_events.event_data', 'uses' => 'CalendarEventsController@eventData', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.event_data']]);
Route::post('sessionData', ['as' => 'hamahang.calendar_events.session_data', 'uses' => 'CalendarEventsController@sessionData', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.session_data']]);
Route::post('deleteEvent', ['as' => 'hamahang.calendar_events.delete_event', 'uses' => 'CalendarEventsController@deleteEvent', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.delete_event']]);
Route::post('reminderData', ['as' => 'hamahang.calendar_events.reminder_data', 'uses' => 'CalendarEventsController@reminderData', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.reminder_data']]);
Route::post('fileList', ['as' => 'hamahang.calendar_events.file_list', 'uses' => 'CalendarEventsController@calendarEventFileList', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.file_list']]);
Route::post('saveReminder', ['as' => 'hamahang.calendar_events.save_reminder', 'uses' => 'CalendarEventsController@saveReminder', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.save_reminder']]);
Route::post('sessionGuest', ['as' => 'hamahang.calendar_events.session_guest', 'uses' => 'CalendarEventsController@sessionGuest', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.session_guest']]);
Route::post('saveDecision', ['as' => 'hamahang.calendar_events.save_decision', 'uses' => 'CalendarEventsController@decisionsSave', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.save_decision']]);
Route::post('invitationData', ['as' => 'hamahang.calendar_events.invitation_data', 'uses' => 'CalendarEventsController@invitationData', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.invitation_data']]);
Route::post('saveUserEvent', ['as' => 'hamahang.calendar_events.save_user_event', 'uses' => 'CalendarEventsController@saveUserEvent', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.save_user_event']]);
Route::post('saveTaskEvent', ['as' => 'hamahang.calendar_events.save_task_event', 'uses' => 'CalendarEventsController@saveTaskEvent', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.save_user_event']]);
Route::post('saveMultiTaskEvent', ['as' => 'hamahang.calendar_events.save_multi_task_event', 'uses' => 'CalendarEventsController@saveMultiTaskEvent', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.save_user_event']]);
Route::post('fetchSession', ['as' => 'hamahang.calendar_events.fetch_session', 'uses' => 'CalendarEventsController@fetchSessionData', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.fetch_session']]);
Route::post('saveInvitation', ['as' => 'hamahang.calendar_events.save_invitation', 'uses' => 'CalendarEventsController@saveInvitation', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.save_invitation']]);
Route::post('deleteReminder', ['as' => 'hamahang.calendar_events.delete_reminder', 'uses' => 'CalendarEventsController@deleteReminder', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.delete_reminder']]);
Route::post('deleteDescision', ['as' => 'hamahang.calendar_events.delete_decision', 'uses' => 'CalendarEventsController@deleteDescision', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.delete_decision']]);
Route::post('getInfoToReminder', ['as' => 'hamahang.calendar_events.get_info_to_reminder', 'uses' => 'CalendarEventsController@getInfoToReminder', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.get_info_to_reminder']]);
Route::post('getCalendarEvents', ['as' => 'hamahang.calendar_events.get_calendar_events', 'uses' => 'CalendarEventsController@getCalendarEvents', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.get_calendar_events']]);
Route::post('saveTaskDecision', ['as' => 'hamahang.calendar_events.save_task_decision', 'uses' => 'CalendarEventsController@saveTaskDecision', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.save_task_decision']]);
Route::post('fetcTaskOfEvents', ['as' => 'hamahang.calendar_events.fetch_task_of_events', 'uses' => 'CalendarEventsController@fetcTaskOfEvents', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.fetch_task_of_events']]);
Route::post('saveSessionEvent', ['as' => 'hamahang.calendar_events.save_session_event', 'uses' => 'CalendarEventsController@saveSessionEvent', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.save_session_event']]);
Route::post('saveSelectedTaskEvent', ['as' => 'hamahang.calendar_events.save_selected_task_event', 'uses' => 'CalendarEventsController@saveSelectedTaskEvent', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.save_session_event']]);
Route::post('SessionUsersList', ['as' => 'hamahang.calendar_events.session_users_list', 'uses' => 'CalendarEventsController@SessionUsersList', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.session_users_list']]);
Route::post('fetchInvitation', ['as' => 'hamahang.calendar_events.fetch_invitation', 'uses' => 'CalendarEventsController@fetchinvitationsData', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.fetch_invitation']]);
Route::post('saveTemporaryTask', ['as' => 'hamahang.calendar_events.save_temporary_task', 'uses' => 'CalendarEventsController@saveTemporaryTask', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.save_temporary_task']]);
Route::post('addGuestToSession', ['as' => 'hamahang.calendar_events.add_guest_to_session', 'uses' => 'CalendarEventsController@addGuestToSession', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.add_guest_to_session']]);
Route::post('deleteGuestSession', ['as' => 'hamahang.calendar_events.delete_guest_to_session', 'uses' => 'CalendarEventsController@deleteGuestSession', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.delete_guest_to_session']]);
Route::post('deleteDecisionTask', ['as' => 'hamahang.calendar_events.delete_decision_task', 'uses' => 'CalendarEventsController@deleteDecisionTask', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.delete_decision_task']]);
Route::post('decisionsTemporaryTask', ['as' => 'hamahang.calendar_events.decisions_temporary_task', 'uses' => 'CalendarEventsController@getDecisionsTemporaryTask', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.decisions_temporary_task']]);
Route::post('saveSessionUsersPresent', ['as' => 'hamahang.calendar_events.save_session_users_present', 'uses' => 'CalendarEventsController@saveSessionUsersPresent', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.save_session_users_present']]);
Route::post('fetchSessionDecisions', ['as' => 'hamahang.calendar_events.fetch_session_decisions', 'uses' => 'CalendarEventsController@getDecisions', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.fetch_session_decisions']]);
Route::post('newEventModal', ['as' => 'hamahang.calendar_events.new_event_modal', 'uses' => 'CalendarEventsController@newEventModal', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.new_event_modal']]);
Route::post('sessionModal', ['as' => 'hamahang.calendar_events.session_modal', 'uses' => 'CalendarEventsController@sessionModal', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.session_modal']]);
Route::post('invitationModal', ['as' => 'hamahang.calendar_events.invitation_modal', 'uses' => 'CalendarEventsController@invitationModal', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.invitation_modal']]);
Route::post('reminderModal', ['as' => 'hamahang.calendar_events.reminder_modal', 'uses' => 'CalendarEventsController@reminderModal', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.reminder_modal']]);
Route::post('addReminderModal', ['as' => 'hamahang.calendar_events.add_reminder_modal', 'uses' => 'CalendarEventsController@addReminderModal', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.add_reminder_modal']]);
/* ??? */Route::post('minutesModal', ['as' => 'hamahang.calendar_events.minutes_modal', 'uses' => 'CalendarEventsController@minutesModal', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events.minutes_modal']]);