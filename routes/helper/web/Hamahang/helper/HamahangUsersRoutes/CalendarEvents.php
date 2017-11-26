<?php
Route::group(['prefix' => 'CalendarEvents', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.calendar_events']], function ()
{
    Route::get('sessions', ['as' => 'ugc.desktop.hamahang.calendar_events.sessions', 'uses' => 'CalendarEventsController@sessionsGrid', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.calendar_events.sessions']]);
    Route::get('invitations', ['as' => 'ugc.desktop.hamahang.calendar_events.invitations', 'uses' => 'CalendarEventsController@invitationsGrid', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.calendar_events.invitations']]);
    /* ??? */Route::get('events', ['as' => 'ugc.desktop.hamahang.calendar_events.events', 'uses' => 'CalendarEventsController@index']);
});