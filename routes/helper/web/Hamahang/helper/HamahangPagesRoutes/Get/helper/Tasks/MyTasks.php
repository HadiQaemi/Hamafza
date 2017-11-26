<?php
// PGS = Pages or Groups or Subjects
Route::get('list', ['as' => 'pgs.desktop.hamahang.tasks.my_tasks.list', 'uses' => 'MyTaskController@MyTasksList', 'middleware' => ['dynamic_permission:pgs.desktop.hamahang.tasks.my_tasks.list']]);
Route::get('priority', ['as' => 'pgs.desktop.hamahang.tasks.my_tasks.priority', 'uses' => 'MyTaskController@MyTasksPriority', 'middleware' => ['dynamic_permission:pgs.desktop.hamahang.tasks.my_tasks.priority']]); ////// user_tasks
Route::get('state', ['as' => 'pgs.desktop.hamahang.tasks.my_tasks.state', 'uses' => 'MyTaskController@MyTasksState', 'middleware' => ['dynamic_permission:pgs.desktop.hamahang.tasks.my_tasks.state']]); ////// user tasks state
Route::get('package', ['as' => 'pgs.desktop.hamahang.tasks.my_tasks.package', 'uses' => 'PackageController@MyTaskPackages', 'middleware' => ['dynamic_permission:pgs.desktop.hamahang.tasks.my_tasks.package']]); ////// user task packages - pgs.desktop.hamahang.tasks.my_tasks.package