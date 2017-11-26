<?php
Route::post('scheduler', ['as' => 'hamahang.scheduler.create', 'uses' => 'SchedulerController@create', 'middleware' => ['dynamic_permission:posts.hamahang.scheduler.create']]);