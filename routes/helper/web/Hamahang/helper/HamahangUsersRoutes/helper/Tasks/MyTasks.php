<?php
Route::get('package', ['as' => 'ugc.desktop.hamahang.tasks.my_tasks.package', 'uses' => 'PackageController@MyTaskPackages', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.my_tasks.package']]); ////// user task packages
Route::get('state', ['as' => 'ugc.desktop.hamahang.tasks.my_tasks.state', 'uses' => 'MyTaskController@MyTasksState', 'menu' => 'true', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.my_tasks.state']]); ////// user tasks state
Route::get('priority', ['as' => 'ugc.desktop.hamahang.tasks.my_tasks.priority', 'uses' => 'MyTaskController@MyTasksPriority', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.tasks.my_tasks.priority']]); ////// user_tasks
Route::get('list', ['as' => 'ugc.desktop.hamahang.tasks.my_tasks.list', 'uses' => 'MyTaskController@MyTasksList', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.tasks.my_tasks.list']]);
Route::get('AllList', ['as' => 'ugc.desktop.hamahang.tasks.my_tasks.all_task_list', 'uses' => 'MyTaskController@ListAllTask', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.my_tasks.list']]);
