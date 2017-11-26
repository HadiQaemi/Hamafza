<?php
Route::group(['prefix' => 'Task', 'namespace' => 'Tasks', 'middleware' => ['dynamic_permission:pgs.desktop.hamahang.tasks']], function ()
{
    Route::group(['prefix' => 'MyTasks', 'middleware' => ['dynamic_permission:pgs.desktop.hamahang.tasks.my_tasks']], function ()
    {
        require(__DIR__ . '/helper/Tasks/MyTasks.php');
    });
    Route::group(['prefix' => 'MyAssignedTasks', 'middleware' => ['dynamic_permission:pgs.desktop.hamahang.tasks.my_assigned_tasks']], function ()
    {
        require(__DIR__ . '/helper/Tasks/MyAssignedTasks.php');
    });
});