<?php
Route::post('editSave', ['as' => 'hamahang.calendar.edit_save', 'uses' => 'CalendarController@editSave', 'middleware' => ['dynamic_permission:posts.hamahang.calendar.edit_save']]);
Route::post('getAllEvent', ['as' => 'hamahang.calendar.all_data', 'uses' => 'CalendarController@getAllEvent', 'middleware' => ['dynamic_permission:posts.hamahang.calendar.all_data']]);
Route::post('yearEvents', ['as' => 'hamahang.calendar.year_events', 'uses' => 'CalendarController@yearEvents', 'middleware' => ['dynamic_permission:posts.hamahang.calendar.year_events']]);
Route::post('defaultEvents', ['as' => 'hamahang.calendar.default_events', 'uses' => 'CalendarController@defaultEvents', 'middleware' => ['dynamic_permission:posts.hamahang.calendar.default_events']]);
Route::post('sixMonthEvents', ['as' => 'hamahang.calendar.six_month_events', 'uses' => 'CalendarController@sixMonthEvents', 'middleware' => ['dynamic_permission:posts.hamahang.calendar.six_month_events']]);
Route::post('addNewCalendar', ['as' => 'hamahang.calendar.add_new_calendar', 'uses' => 'CalendarController@addNewCalendar', 'middleware' => ['dynamic_permission:posts.hamahang.calendar.add_new_calendar']]);
Route::post('getSeansonEvents', ['as' => 'hamahang.calendar.get_seanson_events', 'uses' => 'CalendarController@getSeansonEvents', 'middleware' => ['dynamic_permission:posts.hamahang.calendar.get_seanson_events']]);
Route::post('personalCalendar', ['as' => 'hamahang.calendar.personal_calendar', 'uses' => 'CalendarController@personalCalendar', 'middleware' => ['dynamic_permission:posts.hamahang.calendar.personal_calendar']]);
Route::post('updateCalendarSetting', ['as' => 'hamahang.calendar.update_calendar_setting', 'uses' => 'CalendarController@updateCalendarSetting', 'middleware' => ['dynamic_permission:posts.hamahang.calendar.update_calendar_setting']]);
Route::post('newCalendar', ['as' => 'hamahang.calendar.new_calendar', 'uses' => 'CalendarController@newCalendar', 'middleware' => ['dynamic_permission:posts.hamahang.calendar.new_calendar']]);
Route::post('editCalendar', ['as' => 'hamahang.calendar.edit_calendar', 'uses' => 'CalendarController@editCalendar', 'middleware' => ['dynamic_permission:posts.hamahang.calendar.edit_calendar']]);
Route::post('getOwnCalendar', ['as' => 'hamahang.calendar.get_own_calendar', 'uses' => 'CalendarController@getOwnCalendar', 'middleware' => ['dynamic_permission:posts.hamahang.calendar.get_own_calendar']]);
/* ??? */Route::post('calendar', ['as' => 'hamahang.calendar.data', 'uses' => 'CalendarController@calendar', 'middleware' => ['dynamic_permission:posts.hamahang.calendar.calendar']]);
/* ??? */Route::post('deleteCalendar', ['as' => 'hamahang.calendar.deleteCalendar', 'uses' => 'CalendarController@deleteCalendar', 'middleware' => ['dynamic_permission:posts.hamahang.calendar.delete_calendar']]);
/* ??? */Route::post('personalSearchEvent', ['as' => 'hamahang.calendar.personalSearchEvent', 'uses' => 'CalendarController@personalEventSearch', 'middleware' => ['dynamic_permission:posts.hamahang.calendar.personal_event_search']]);
/* ??? */Route::post('getPermissionCalendar', ['as' => 'hamahang.calendar.getPermissionCalendar', 'uses' => 'CalendarController@getPermissionCalendar', 'middleware' => ['dynamic_permission:posts.hamahang.calendar.get_permission_calendar']]);
/* ??? */Route::post('change_calendar', ['as' => 'hamahang.calendar.change_calendar', 'uses' => 'calendarController@change_calendar', 'middleware' => ['dynamic_permission:posts.hamahang.calendar.change_calendar']]);
/* ??? */Route::post('getCalendarInfo', ['as' => 'hamahang.calendar.getCalendarInfo', 'uses' => 'CalendarController@getCalendarInfo', 'middleware' => ['dynamic_permission:posts.hamahang.calendar.get_calendar_info']]);
