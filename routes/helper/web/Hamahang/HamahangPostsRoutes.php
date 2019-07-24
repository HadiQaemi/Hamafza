<?php
Route::group(['namespace' => 'Hamahang', 'middleware' => ['dynamic_permission:posts.hamahang']], function ()
{
    Route::group(['prefix' => 'TasksLibrary', 'middleware' => ['dynamic_permission:posts.hamahang.tasks_library']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/TasksLibrary.php');
    });

    Route::group(['prefix' => 'Diagrams', 'middleware' => ['dynamic_permission:posts.hamahang.tasks_library']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/diagrams.php');
    });

    Route::group(['prefix' => 'Calendar', 'middleware' => ['dynamic_permission:posts.hamahang.calendar']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/Calendar.php');
    });

    Route::group(['prefix' => 'Scheduler', 'middleware' => ['dynamic_permission:posts.hamahang.scheduler']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/scheduler.php');
    });

    Route::group(['prefix' => 'Enquiry', 'middleware' => ['dynamic_permission:posts.hamahang.enquiry']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/enquiry.php');
    });

    Route::group(['prefix' => 'News', 'middleware' => ['dynamic_permission:posts.hamahang.news']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/news.php');
    });

    Route::group(['prefix' => 'Basicdata', 'middleware' => ['dynamic_permission:posts.hamahang.basicdata']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/basicdata.php');
    });

    Route::group(['prefix' => 'Summary', 'middleware' => ['dynamic_permission:posts.hamahang.summary']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/summary.php');
    });

    Route::group(['prefix' => 'Bazaar', 'middleware' => ['dynamic_permission:posts.hamahang.bazaar']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/bazaar.php');
    });

    Route::group(['prefix' => 'Vote', 'middleware' => ['dynamic_permission:posts.hamahang.vote']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/vote.php');
    });

    Route::group(['prefix' => 'CalendarEvents', 'middleware' => ['dynamic_permission:posts.hamahang.calendar_events']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/CalendarEvents.php');
    });

    Route::group(['prefix' => 'OrgChart', 'middleware' => ['dynamic_permission:posts.hamahang.org_chart']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/OrgChart.php');
    });

    Route::group(['prefix' => 'Process', 'middleware' => ['dynamic_permission:posts.hamahang.process']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/Process.php');
    });

    Route::group(['prefix' => 'Project', 'middleware' => ['dynamic_permission:posts.hamahang.project']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/Project.php');
    });

    Route::group(['prefix' => 'Tasks', 'namespace' => 'Tasks', 'middleware' => ['dynamic_permission:posts.hamahang.tasks']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/Tasks.php');
    });

    Route::group(['prefix' => 'Tools', 'middleware' => ['dynamic_permission:posts.hamahang.tools']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/Tools.php');
    });

    Route::group(['prefix' => 'ToolsGroup', 'middleware' => ['dynamic_permission:posts.hamahang.tools_group']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/ToolsGroup.php');
    });

    Route::group(['prefix' => 'Charts', 'middleware' => ['dynamic_permission:posts.hamahang.charts']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/charts.php');
    });

    Route::group(['prefix' => 'Acl', 'middleware' => ['dynamic_permission:posts.hamahang.acl']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/acl.php');
    });

    Route::group(['prefix' => 'Menus', 'middleware' => ['dynamic_permission:posts.hamahang.menus']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/menus.php');
    });

    Route::group(['prefix' => 'Users', 'middleware' => ['dynamic_permission:posts.hamahang.users']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/users.php');
    });

    Route::group(['prefix' => 'Subjects', 'middleware' => ['dynamic_permission:posts.hamahang.subjects']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/Subjects.php');
    });

    Route::group(['prefix' => 'Tickets', 'middleware' => ['dynamic_permission:posts.hamahang.tickets']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/Tickets.php');
    });

    Route::group(['prefix' => 'Files', 'middleware' => ['dynamic_permission:posts.hamahang.files']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/Files.php');
    });

    Route::group(['prefix' => 'pages', 'middleware' => ['dynamic_permission:posts.hamahang.pages']], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/Pages.php');
    });

    Route::group(['prefix' => 'relations'], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/Relations.php');
    });

    Route::group(['prefix' => 'help'], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/Help.php');
    });

    Route::group(['prefix' => 'alerts'], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/Alerts.php');
    });

    Route::group(['prefix' => 'substs'], function ()
    {
        require(__DIR__ . '/helper/HamahangPostsRoutes/Substs.php');
    });

    Route::post('get_keyword_subject_list', ['as' => 'hamahang.keywords.get_keyword_subject_list', 'uses' => 'KeywordsController@get_keyword_subject_list']);

    /*
        Route::group(['prefix' => 'Access'], function ()
        {
            Route::post('roles', ['as' => 'Access.roles', 'uses' => 'AccessController@roles']);
            Route::post('editRole', ['as' => 'Access.editRole', 'uses' => 'AccessController@editRole']);
            Route::post('saveRole', ['as' => 'Access.saveRole', 'uses' => 'AccessController@saveRole']);
            Route::post('rolesList', ['as' => 'Access.rolesList', 'uses' => 'AccessController@rolesList']);
            Route::post('roleUsers', ['as' => 'Access.roleUsers', 'uses' => 'AccessController@roleUsers']);
            Route::post('saveUserRole', ['as' => 'Access.saveUserRole', 'uses' => 'AccessController@saveUserRole']);
            Route::post('userRoleList', ['as' => 'Access.userRoleList', 'uses' => 'AccessController@userRoleList']);
            Route::post('savePermission', ['as' => 'Access.savePermission', 'uses' => 'AccessController@savePermission']);
            Route::post('editPermission', ['as' => 'Access.editPermission', 'uses' => 'AccessController@editPermission']);
            Route::post('deleteUserRole', ['as' => 'Access.deleteUserRole', 'uses' => 'AccessController@deleteUserRole']);
            Route::post('permissionList', ['as' => 'Access.permissionList', 'uses' => 'AccessController@permissionList']);
            Route::post('permissionsList', ['as' => 'Access.permissionsList', 'uses' => 'AccessController@permissionsList']);
            Route::post('savePermissionRole', ['as' => 'Access.savePermissionRole', 'uses' => 'AccessController@savePermissionRole']);
            Route::post('permissionRoleList', ['as' => 'Access.permissionRoleList', 'uses' => 'AccessController@permissionRoleList']);
            Route::post('deletepermissionRole', ['as' => 'Access.deletepermissionRole', 'uses' => 'AccessController@deletepermissionRole']);
            Route::post('getPermissionByRoleId', ['as' => 'Access.getPermissionByRoleId', 'uses' => 'AccessController@getPermissionByRoleId']);
            Route::post('savePermissionRoleGroup', ['as' => 'Access.savePermissionRoleGroup', 'uses' => 'AccessController@savePermissionRoleGroup']);
        */
    /* ??? */
    /*
        Route::post('userList', ['as' => 'Access.userList', 'uses' => 'AccessController@userList']);
        Route::post('newRoleModal', ['as' => 'Access.newRoleModal', 'uses' => 'AccessController@newRoleModal']);
        Route::post('newPermissionModal', ['as' => 'Access.newPermissionModal', 'uses' => 'AccessController@newPermissionModal']);
        Route::post('userRoleModal', ['as' => 'Access.userRoleModal', 'uses' => 'AccessController@userRoleModal']);
        Route::post('permissionRoleModal', ['as' => 'Access.permissionRoleModal', 'uses' => 'AccessController@permissionRoleModal']);
    });
    */

});