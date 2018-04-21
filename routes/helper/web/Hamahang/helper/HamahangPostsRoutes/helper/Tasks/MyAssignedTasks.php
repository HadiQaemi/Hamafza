<?php
Route::post('AddNewFiles', ['as' => 'hamahang.tasks.my_assigned_tasks.add_new_files', 'uses' => 'TaskController@AddNewFiles', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.add_new_files']]);
Route::post('MyAssignedTasksAddToPackage', ['as' => 'hamahang.tasks.my_assigned_tasks.add_to_package', 'uses' => 'PackageController@MyAssignedTasksAddToPackage', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.add_to_package']]);
Route::post('SaveAsLibraryTask', ['as' => 'hamahang.tasks.my_assigned_tasks.save_as_library_task', 'uses' => 'MyAssignedTaskController@SaveAsLibraryTask', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.save_as_library_task']]);
Route::post('RemoveFromPackage', ['as' => 'hamahang.tasks.my_assigned_tasks.remove_from_package', 'uses' => 'PackageController@RemoveFromPackage', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.remove_from_package']]);
Route::post('show_tasks_states', ['as' => 'hamahang.tasks.my_assigned_tasks.filter_states', 'uses' => 'MyAssignedTaskController@show_MyAssignedTasks_custom_for_states', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.filter_states']]); /// search tasks in states
Route::post('ShowTaskFiles', ['as' => 'hamahang.tasks.my_assigned_tasks.show_task_files', 'uses' => 'TaskController@ShowTaskFiles', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.show_task_files']]);
Route::post('AddTaskChilds', ['as' => 'hamahang.tasks.my_assigned_tasks.add_task_childs', 'uses' => 'TaskController@AddTaskChilds', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.add_task_childs']]);
Route::post('SaveNewFiles', ['as' => 'hamahang.tasks.my_assigned_tasks.save_new_files', 'uses' => 'MyAssignedTaskController@SaveNewFiles', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.save_new_files']]);
Route::post('EditTaskInfo', ['as' => 'hamahang.tasks.my_assigned_tasks.edit_task_info', 'uses' => 'MyAssignedTaskController@EditTaskInfo', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.edit_task_info']]);
Route::post('RemoveTaskChilds', ['as' => 'hamahang.tasks.my_assigned_tasks.remove_task_childs', 'uses' => 'TaskController@RemoveTaskChilds', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.remove_task_childs']]);
Route::post('RemoveDraft', ['as' => 'hamahang.tasks.my_assigned_tasks.remove_draft', 'uses' => 'DraftController@RemoveDraft', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.remove_draft']]);
Route::post('TaskChildChangeWeight', ['as' => 'hamahang.tasks.my_assigned_tasks.task_child_change_weight', 'uses' => 'TaskController@TaskChildChangeWeight', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.task_child_change_weight']]);
Route::post('FetchList', ['as' => 'hamahang.tasks.my_assigned_tasks.fetch', 'uses' => 'MyAssignedTaskController@MyAssignedTasksFetch', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.fetch']]);
Route::post('RemoveTaskDraftFile', ['as' => 'hamahang.tasks.my_assigned_tasks.remove_task_draft_file', 'uses' => 'DraftController@RemoveTaskDraftFile', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.remove_task_draft_file']]);
Route::post('RemoveTaskFile', ['as' => 'hamahang.tasks.my_assigned_tasks.remove_task_file', 'uses' => 'MyAssignedTaskController@RemoveTaskFile', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.remove_task_file']]);
Route::post('FetchTaskChildsList/{id}', ['as' => 'hamahang.tasks.my_assigned_tasks.fetch_task_childs_list', 'uses' => 'TaskController@FetchTaskChildsList', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.fetch_task_childs_list']]);
Route::post('FetchDraftFiles/{id}', ['as' => 'hamahang.tasks.my_assigned_tasks.fetch_draft_files', 'uses' => 'DraftController@FetchDraftFiles', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.fetch_draft_files']]);
Route::post('FetchDraftsList', ['as' => 'hamahang.tasks.my_assigned_tasks.fetch_drafts_list', 'uses' => 'DraftController@FetchDraftsList', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.fetch_drafts_list']]);
Route::post('TaskQuality', ['as' => 'hamahang.tasks.my_assigned_tasks.change_task_quality', 'uses' => 'MyAssignedTaskController@ChangeTaskQuality', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.change_task_quality']]);
Route::post('TaskStop', ['as' => 'hamahang.tasks.my_assigned_tasks.task_stop', 'uses' => 'MyAssignedTaskController@TaskStop', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.task_stop']]);
Route::post('TaskEnd', ['as' => 'hamahang.tasks.my_assigned_tasks.task_end', 'uses' => 'MyAssignedTaskController@TaskEnd', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.task_end']]);
Route::post('RestartTask', ['as' => 'hamahang.tasks.my_assigned_tasks.restart_task', 'uses' => 'MyAssignedTaskController@TaskRestart', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.restart_task']]);

Route::post('change_type_task_assigner', ['as' => 'hamahang.tasks.my_tasks_assigner.change_type_task', 'uses' => 'MyAssignedTaskController@change_type_task', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.my_tasks_assigner.change_type_task']]);
Route::post('filter_mytask_assigner', ['as' => 'hamahang.tasks.my_tasks_assigner.filter_my_assigned_task', 'uses' => 'MyAssignedTaskController@filter_mytask', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.my_tasks_assigner.filter_my_assigned_task']]);

/* ??? */Route::post('RefreshTaskChilds', ['as' => 'hamahang.tasks.my_assigned_tasks.RefreshTaskChilds', 'uses' => 'TaskController@RefreshTaskChilds', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.refresh_task_childs']]);
/* ??? */Route::post('GetData', ['as' => 'hamahang.tasks.my_assigned_tasks.GetData', 'uses' => 'TaskController@GetData', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.get_data']]);
/* ??? */Route::post('ShowDraftTaskFiles', ['as' => 'hamahang.tasks.my_assigned_tasks.ShowDraftTaskFiles', 'uses' => 'DraftController@ShowDraftTaskFiles', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.show_draft_task_files']]);
/* ??? */Route::post('NewFollowUp', ['as' => 'hamahang.tasks.my_assigned_tasks.NewFollowUp', 'uses' => 'TaskController@NewFollowUp', 'middleware' => ['dynamic_permission:posts.hamahang.tasks.my_assigned_tasks.new_follow_up']]);
