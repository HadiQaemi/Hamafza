<?php
Route::get('list', ['as' => 'ugc.desktop.hamahang.tasks.my_assigned_tasks.list', 'uses' => 'MyAssignedTaskController@MyAssignedTasksList', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.my_assigned_tasks.list']]);
Route::get('state', ['as' => 'ugc.desktop.hamahang.tasks.my_assigned_tasks.state', 'uses' => 'MyAssignedTaskController@MyAssignedTasksState', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.my_assigned_tasks.state']]); ////// user tasks state
Route::get('priority', ['as' => 'ugc.desktop.hamahang.tasks.my_assigned_tasks.priority', 'uses' => 'MyAssignedTaskController@MyAssignedTasksPriority', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.my_assigned_tasks.priority']]); ////// user_tasks
Route::get('package', ['as' => 'ugc.desktop.hamahang.tasks.my_assigned_tasks.package', 'uses' => 'PackageController@MyAssignedTaskPackages', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.my_assigned_tasks.package']]); ////// user task packages
Route::get('drafts', ['as' => 'ugc.desktop.hamahang.tasks.my_assigned_tasks.show_drafts', 'uses' => 'DraftController@ShowDrafts', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.my_assigned_tasks.show_drafts']]);
/* ??? */Route::get('ScheduleTaskCopy', ['as' => 'ugc.desktop.hamahang.tasks.my_assigned_tasks.schedule_task_copy', 'uses' => 'TaskController@ScheduleTaskCopy', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.my_assigned_tasks.schedule_task_copy']]);
/* ??? */Route::get('gantt', ['as' => 'ugc.desktop.hamahang.tasks.my_assigned_tasks.Gantt', 'uses' => 'TaskController@GanttChart', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.my_assigned_tasks.gantt']]);
