<?php
Route::group(['prefix' => 'Tasks', 'namespace' => 'Tasks', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks']], function ()
{
    Route::get('SelectTaskWindow', ['as' => 'ugc.desktop.hamahang.tasks.select_task_window', 'uses' => 'TaskController@SelectTaskWindow', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.select_task_window']]);
    /* ??? */Route::get('OrgChart/{id}', ['as' => 'ugc.desktop.hamahang.org_chart.test', 'uses' => 'OrgChartController@OrgChart', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.org_chart.test']]);
    /* ??? */Route::get('TasksPackages', ['as' => 'ugc.desktop.hamahang.tasks.Packages', 'uses' => 'PackageController@TasksPackages', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.Packages']]);
    /* ??? */Route::get('CreateNewTask', ['as' => 'ugc.desktop.hamahang.Task.Create', 'uses' => 'MyAssignedTaskController@CreateNewTask', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.Task.Create']]); /////create new task
    /* ??? *///Route::get('ShowTaskForm', ['as' => 'ugc.desktop.hamahang.Task.Show', 'uses' => 'MyAssignedTaskController@ShowTaskForm', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.Task.Show']]); /////create new task
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
    /* ??? */Route::get('GenralList', ['as' => 'ugc.desktop.hamahang.tasks.library', 'uses' => 'TasksLibraryController@GeneralList', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.library']]);
    /* ??? */Route::get('PersonalList', ['as' => 'ugc.desktop.hamahang.tasks.library', 'uses' => 'TasksLibraryController@PersonalList', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tasks.library']]);
});