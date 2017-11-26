<?php
Route::group(['namespace' => 'Hamahang', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang']], function ()
{
    require(__DIR__ . '/helper/HamahangUsersRoutes/ACL.php');
    require(__DIR__ . '/helper/HamahangUsersRoutes/Tools.php');
    require(__DIR__ . '/helper/HamahangUsersRoutes/Bazaar.php');
    require(__DIR__ . '/helper/HamahangUsersRoutes/Menus.php');
    require(__DIR__ . '/helper/HamahangUsersRoutes/Tasks.php');
    require(__DIR__ . '/helper/HamahangUsersRoutes/WebRTC.php');
    require(__DIR__ . '/helper/HamahangUsersRoutes/Process.php');
    require(__DIR__ . '/helper/HamahangUsersRoutes/Projects.php');
    require(__DIR__ . '/helper/HamahangUsersRoutes/OrgCharts.php');
    require(__DIR__ . '/helper/HamahangUsersRoutes/Basicdata.php');
    require(__DIR__ . '/helper/HamahangUsersRoutes/Scheduler.php');
    require(__DIR__ . '/helper/HamahangUsersRoutes/Calendar.php');
    require(__DIR__ . '/helper/HamahangUsersRoutes/CalendarEvents.php');
    require(__DIR__ . '/helper/HamahangUsersRoutes/UserList.php');
    require(__DIR__ . '/helper/HamahangUsersRoutes/Subjects.php');
    require(__DIR__ . '/helper/HamahangUsersRoutes/Tickets.php');
    require(__DIR__ . '/helper/HamahangUsersRoutes/Files.php');

    Route::get('relations', ['as' => 'ugc.desktop.hamahang.relations_index', 'uses' => 'RelationsController@index']);
    Route::get('alerts', ['as' => 'ugc.desktop.hamahang.alerts_index', 'uses' => 'AlertsController@index']);
    Route::get('subst', ['as' => 'ugc.desktop.hamahang.subst_index', 'uses' => 'SubstsController@index']);
    Route::get('keywords', ['as' => 'ugc.desktop.keywords', 'uses' => 'KeywordsController@index', 'middleware' => ['dynamic_permission:ugc.desktop.keywords']]);

    Route::group(['prefix' => 'help'], function ()
    {
        Route::get('/', ['uses' => 'HelpController@help', 'as' => 'ugc.desktop.help', ]);
    });


    Route::get('chart', ['as' => 'chart', 'uses' => 'ChartsController@getCharts', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.chart']]);
    //Route::get('/faq', ['as' => 'ugc.desktop.hamahang.scheduler.index', 'uses' => 'SchedulerController@index',]);

    Route::group(['prefix' => 'summary', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.summary']], function ()
    {
        Route::get('/', ['as' => 'ugc.desktop.hamahang.summary.index', 'uses' => 'SummaryController@index', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.summary.index']]);
    });

    Route::group(['prefix' => 'TimeAllocation', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.time_allocation']], function ()
    {
        /* ??? */Route::get('index', ['as' => 'ugc.desktop.hamahang.time_allocation.index', 'uses' => 'TimeAllocationController@index', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.time_allocation.index']]);
    });
});