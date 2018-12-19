<?php
Route::post('change_project_priority', ['as' => 'hamahang.projects.priority.change', 'uses' => 'ProjectController@change_projects_priority', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.priority.change']]);
Route::post('UserOrgs', ['as' => 'hamahang.project.user_orgs', 'uses' => 'TaskController@UserOrgs', 'middleware' => ['dynamic_permission:posts.hamahang.project.user_orgs']]);
Route::post('ProjectInfo', ['as' => 'hamahang.project.info', 'uses' => 'ProjectController@ProjectInfo', 'middleware' => ['dynamic_permission:posts.hamahang.project.info']]);
Route::post('ProjectInfoWindow', ['as' => 'hamahang.project.project_info_window', 'uses' => 'ProjectController@ProjectInfoWindow', 'middleware' => ['dynamic_permission:posts.hamahang.project.project_info_window']]);
Route::post('ProjectTasksWindow', ['as' => 'hamahang.project.show_project_tasks', 'uses' => 'ProjectController@ProjectTasksWindow', 'middleware' => ['dynamic_permission:posts.hamahang.project.project_info_window']]);
Route::post('ProjectTasksListWindow', ['as' => 'hamahang.project.show_project_tasks_list', 'uses' => 'ProjectController@ProjectTasksListWindow', 'middleware' => ['dynamic_permission:posts.hamahang.project.project_info_window']]);
Route::post('FetchProjectList', ['as' => 'hamahang.projects.list', 'uses' => 'ProjectController@FetchProjects', 'middleware' => ['dynamic_permission:posts.hamahang.project.list']]);
Route::post('UserProjects', ['as' => 'hamahang.project.user_projects', 'uses' => 'ProjectController@UserProjects', 'middleware' => ['dynamic_permission:posts.hamahang.project.user_projects']]);
Route::post('SaveNewProject', ['as' => 'hamahang.project.save_new_project', 'uses' => 'ProjectController@SaveNewProject', 'middleware' => ['dynamic_permission:posts.hamahang.project.save_new_project']]);
Route::post('SaveNewProject', ['as' => 'hamahang.project.save_project', 'uses' => 'ProjectController@SaveNewProject', 'middleware' => ['dynamic_permission:posts.hamahang.project.save_new_project']]);
Route::post('SaveNewProject', ['as' => 'hamahang.project.edit_project', 'uses' => 'ProjectController@EditProject', 'middleware' => ['dynamic_permission:posts.hamahang.project.save_new_project']]);
Route::post('GetGanttData', ['as' => 'hamahang.project.get_gantt_data', 'uses' => 'ProjectController@prepare_gantt_data', 'middleware' => ['dynamic_permission:posts.hamahang.project.get_gantt_data']]);
Route::post('AddProjectTask', ['as' => 'hamahang.project.add_project_task', 'uses' => 'ProjectController@AddProjectTask', 'middleware' => ['dynamic_permission:posts.hamahang.project.add_project_task']]);
Route::post('FetchRelation', ['as' => 'hamahang.project.fetch_relation', 'uses' => 'ProjectController@FetchRelation', 'middleware' => ['dynamic_permission:posts.hamahang.project.fetch_relation']]);
Route::post('AddProjectTaskRelation', ['as' => 'hamahang.project.add_project_task_relation', 'uses' => 'ProjectController@AddProjectTaskRelation', 'middleware' => ['dynamic_permission:posts.hamahang.project.add_project_task_relation']]);
Route::post('RemoveProjectTaskRelation', ['as' => 'hamahang.project.remove_project_task_relation', 'uses' => 'ProjectController@RemoveProjectTaskRelation', 'middleware' => ['dynamic_permission:posts.hamahang.project.remove_project_task_relation']]);
/* ??? */Route::post('FetchList', ['as' => 'hamahang.project.list', 'uses' => 'ProjectController@FetchProject', 'middleware' => ['dynamic_permission:posts.hamahang.project.fetch_project']]);
/* ??? */Route::post('FetchRelations/{id}', ['as' => 'hamahang.project.fetch_relations', 'uses' => 'ProjectController@FetchRelations', 'middleware' => ['dynamic_permission:posts.hamahang.project.fetch_relations']]);
