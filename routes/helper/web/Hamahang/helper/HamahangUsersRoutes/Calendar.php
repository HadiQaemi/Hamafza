<?php
Route::group(['prefix' => 'Calendar', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.calendar']], function ()
{
    Route::get('Index', ['as' => 'ugc.desktop.hamahang.calendar.index', 'uses' => 'CalendarController@Index', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.calendar.index']]);
    Route::get('getAllEvent', ['as' => 'hamahang.calendar.all_data', 'uses' => 'CalendarController@getAllEvent', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.calendar.all_data']]);
    Route::get('getUser', ['as' => 'ugc.desktop.hamahang.calendar.get_user', 'uses' => 'CalendarController@getAllUsers', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.calendar.get_user']]);
    Route::get('getOwnCalendar', ['as' => 'ugc.desktop.hamahang.calendar.get_own_calendar', 'uses' => 'CalendarController@getOwnCalendar', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.calendar.get_own_calendar']]);
    Route::get('usercalendar', ['as' => 'ugc.desktop.hamahang.calendar.user_calendar', 'uses' => 'CalendarController@getUserCalendar', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.calendar.user_calendar']]);
    /* ??? */Route::get('Calendar', ['as' => 'ugc.desktop.hamahang.calendar.index', 'uses' => 'CalendarController@Index']); ///// show fullcalendar
});