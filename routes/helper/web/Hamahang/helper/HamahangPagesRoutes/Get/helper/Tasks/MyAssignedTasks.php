<?php
// PGS = Pages or Groups or Subjects

Route::get('list', ['as' => 'pgs.desktop.hamahang.tasks.my_assigned_tasks.list', 'uses' => 'MyAssignedTaskController@MyAssignedTasksList', 'middleware' => ['dynamic_permission:pgs.desktop.hamahang.tasks.my_assigned_tasks.list']]);
Route::get('priority', ['as' => 'pgs.desktop.hamahang.tasks.my_assigned_tasks.priority', 'uses' => 'MyAssignedTaskController@MyAssignedTasksPriority', 'middleware' => ['dynamic_permission:pgs.desktop.hamahang.tasks.my_assigned_tasks.priority']]); ////// user_tasks
Route::get('state', ['as' => 'pgs.desktop.hamahang.tasks.my_assigned_tasks.state', 'uses' => 'MyAssignedTaskController@MyAssignedTasksState', 'middleware' => ['dynamic_permission:pgs.desktop.hamahang.tasks.my_assigned_tasks.state']]); ////// user tasks state
Route::get('package', ['as' => 'pgs.desktop.hamahang.tasks.my_assigned_tasks.package', 'uses' => 'PackageController@MyAssignedTaskPackages', 'middleware' => ['dynamic_permission:pgs.desktop.hamahang.tasks.my_assigned_tasks.package']]); ////// user task packages