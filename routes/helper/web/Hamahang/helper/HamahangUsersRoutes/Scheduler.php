<?php
Route::group(['prefix' => 'scheduler', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.scheduler']], function ()
{
    Route::get('/', ['as' => 'ugc.desktop.hamahang.scheduler.index', 'uses' => 'SchedulerController@index', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.scheduler.index']]);
});