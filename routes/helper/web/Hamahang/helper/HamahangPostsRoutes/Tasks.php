<?php
Route::post('SelectTaskWindow', ['as' => 'hamahang.tasks.select_task_window', 'uses' => 'TaskController@SelectTaskWindow', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.select_task_window']]);
Route::post('FetchTasksForSelectTaskWindow', ['as' => 'hamahang.tasks.fetch_tasks_for_select_task_window', 'uses' => 'TaskController@FetchTasksForSelectTaskWindow', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.fetch_tasks_for_select_task_window']]);
Route::post('list', ['as' => 'hamahang.tasks.use_selected_tasks', 'uses' => 'TaskController@use_selected_tasks', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.use_selected_tasks']]);
Route::post('save_task', ['as' => 'hamahang.tasks.save_task', 'uses' => 'MyAssignedTaskController@save', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.save_task']]);
Route::post('set_act_to_task', ['as' => 'hamahang.tasks.set_act_to_task', 'uses' => 'MyAssignedTaskController@SetActToTask', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.set_act_to_task']]);
Route::post('add_message_to_task', ['as' => 'hamahang.tasks.add_message_to_task', 'uses' => 'MyAssignedTaskController@addMessage', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.set_act_to_task']]);
Route::post('update_task', ['as' => 'hamahang.tasks.update_task', 'uses' => 'MyAssignedTaskController@update_task', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.update_task']]);
Route::post('save_drafts', ['as' => 'hamahang.tasks.save_drafts', 'uses' => 'DraftController@save_drafts', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.save_drafts']]);
Route::post('draft_info', ['as' => 'hamahang.tasks.draft_info', 'uses' => 'DraftController@task_draft_info', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.draft_info']]);
Route::post('resave_drafts', ['as' => 'hamahang.tasks.resave_drafts', 'uses' => 'TaskController@resave_drafts', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.resave_drafts']]);
Route::post('publish_draft', ['as' => 'hamahang.tasks.publish_draft', 'uses' => 'DraftController@publish_draft', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.publish_draft']]);
Route::post('rapid_new_task', ['as' => 'hamahang.tasks.rapid_new_task', 'uses' => 'MyAssignedTaskController@rapid_new_task', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.rapid_new_task']]); //// create new task in quick state
Route::post('rapid_new_task_to_project', ['as' => 'hamahang.tasks.rapid_new_task_to_project', 'uses' => 'MyAssignedTaskController@rapid_new_task_to_project', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.rapid_new_task']]); //// create new task in quick state
Route::post('SearchKeywords', ['as' => 'hamahang.tasks.search_keywords', 'uses' => 'TaskController@SearchKeywords', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.search_keywords']]);  /// return keywords for chosen selects
Route::post('new_package', ['as' => 'hamahang.tasks.new_package', 'uses' => 'PackageController@CreateNewPackage', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.new_package']]); /// create new task package
Route::post('remove_package', ['as' => 'hamahang.tasks.remove_package', 'uses' => 'PackageController@RemovePackage', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.remove_package']]); /// create new task package
Route::post('ChangePackageTitle', ['as' => 'hamahang.tasks.change_package_title', 'uses' => 'PackageController@ChangePackageTitle', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.change_package_title']]); /// create new task package
Route::post('change_priority', ['as' => 'hamahang.tasks.priority.change', 'uses' => 'TaskController@change_task_priority', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.priority.change']]); ////change task priority using ajax
Route::post('filter_priority', ['as' => 'hamahang.tasks.priority.filter', 'uses' => 'TaskController@filter_task_priority', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.priority.filter']]); ////filter task priority using ajax
Route::post('all_task_filter', ['as' => 'hamahang.tasks.priority.all_task_filter', 'uses' => 'MyTaskController@filter_all_task_priority', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.priority.filter']]); ////filter task priority using ajax
Route::post('filter_priority_time', ['as' => 'hamahang.tasks.priority.filter_time', 'uses' => 'TaskController@filter_task_priority_time', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.priority.filter']]); ////filter task priority using ajax
Route::post('AllListState', ['as' => 'hamahang.tasks.my_tasks.filter_all_task_state', 'uses' => 'MyTaskController@FilterAllTaskState', 'middleware' => ['dynamic_permission:pgs.desktop.hamahang.tasks.my_tasks.list']]);

Route::post('change_task_state', ['as' => 'hamahang.tasks.change_task_state', 'uses' => 'TaskController@change_task_state', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.change_task_state']]); ///change task state using ajax
Route::post('show_tasks_custom', ['as' => 'hamahang.tasks.custom_tasks_priority', 'uses' => 'MyTaskController@ShowCustomMyTasks', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.custom_tasks_priority']]); /// search tasks in priority
Route::post('TaskInfo', ['as' => 'hamahang.tasks.task_info', 'uses' => 'TaskController@TaskInfo', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.task_info']]);
Route::post('task_delete', ['as' => 'hamahang.tasks.task_delete', 'uses' => 'TaskController@task_delete', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.task_info']]);
/* ??? */Route::post('task_states', ['as' => 'hamahang.tasks.add_task_ajax', 'uses' => 'MyAssignedTaskController@add_task_ajax', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.add_task_ajax']]); /// create new task using ajax
/* ??? */Route::post('task_details2', ['as' => 'hamahang.tasks.info2', 'uses' => 'TaskController@task_info2', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.task_info2']]); /// return item details for OrgChart
/* ??? */Route::post('OrgChart', ['as' => 'hamahang.tasks.ugc.desktop.hamahang.org_chart.Test', 'uses' => 'OrgChartController@OrgChart', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.org_chart']]);
/* ??? */Route::post('show_tasks_custom1', ['as' => 'hamahang.tasks.my_assigned_tasks.CustomTasksPriority', 'uses' => 'MyAssignedTaskController@ShowCustomMyAssignedTasks', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.show_custom_my_assigned_tasks']]); /// search tasks in priority
/* ??? */Route::post('show_tasks_states', ['as' => 'hamahang.tasks.filter_states', 'uses' => 'TaskController@show_tasks_custom_for_states', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.show_tasks_custom_for_states']]); /// search tasks in states
/* ??? */Route::post('task_details', ['as' => 'hamahang.tasks.details', 'uses' => 'MyAssignedTaskController@task_info', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.details']]); /// return item details for OrgChart
/* ??? *///Route::post('FetchMyAssignedTasks', ['as' => 'hamahang.tasks.FetchMyAssignedTasks', 'uses' => 'UserTasksController@FetchMyAssignedTasks']);



Route::group(['prefix' => 'MyTasks', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_tasks']], function ()
{
    require(__DIR__ . '/helper/Tasks/MyTasks.php');
});
Route::group(['prefix' => 'MyAssignedTasks', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks']], function ()
{
    require(__DIR__ . '/helper/Tasks/MyAssignedTasks.php');
});