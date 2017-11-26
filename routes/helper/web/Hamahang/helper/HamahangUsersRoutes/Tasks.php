<?php
Route::group(['prefix' => 'Tasks', 'namespace' => 'Tasks', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks']], function ()
{
    Route::get('SelectTaskWindow', ['as' => 'ugc.desktop.hamahang.tasks.select_task_window', 'uses' => 'TaskController@SelectTaskWindow', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.select_task_window']]);
    /* ??? */Route::get('OrgChart/{id}', ['as' => 'ugc.desktop.hamahang.org_chart.test', 'uses' => 'OrgChartController@OrgChart']);
    /* ??? */Route::get('TasksPackages', ['as' => 'ugc.desktop.hamahang.tasks.Packages', 'uses' => 'PackageController@TasksPackages']);
    /* ??? */Route::get('CreateNewTask', ['as' => 'ugc.desktop.hamahang.Task.Create', 'uses' => 'MyAssignedTaskController@CreateNewTask']); /////create new task
    /* ??? *///Route::get('CreateNewTaskWindow', ['as' => 'Tasks.CreateNewTaskWindow', 'uses' => 'MyAssignedTaskController@CreateNewTaskWindow']);
    /* ??? *///Route::get('CreateNewProjectWindow', ['as' => 'Tasks.CreateNewProjectWindow', 'uses' => 'TaskController@CreateNewProjectWindow']);

    Route::group(['prefix' => 'MyTasks', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.my_tasks']], function ()
    {
        require(__DIR__ . '/helper/Tasks/MyTasks.php');
    });
    Route::group(['prefix' => 'MyAssignedTasks', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.my_assigned_tasks']], function ()
    {
        require(__DIR__ . '/helper/Tasks/MyAssignedTasks.php');
    });
});
Route::group(['prefix' => 'TasksLibrary', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.task_library']], function ()
{
    /* ??? */Route::get('list', ['as' => 'ugc.desktop.hamahang.TasksLibrary.Library.list', 'uses' => 'TasksLibraryController@index']);
});