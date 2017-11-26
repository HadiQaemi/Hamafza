<?php
Route::post('get_alerts', ['as' => 'hamahang.alerts.get_alerts', 'uses' => 'AlertsController@getAlerts']);
Route::post('add_new_alert', ['as' => 'hamahang.alerts.add_new_alert', 'uses' => 'AlertsController@addNewAlert']);
Route::post('edit_alert_view', ['as' => 'hamahang.alerts.edit_alert_view', 'uses' => 'AlertsController@editAlertView']);
Route::post('edit_alert', ['as' => 'hamahang.alerts.edit_alert', 'uses' => 'AlertsController@editAlert']);
Route::post('delete_alert', ['as' => 'hamahang.alerts.delete_alert', 'uses' => 'AlertsController@deleteAlert']);
