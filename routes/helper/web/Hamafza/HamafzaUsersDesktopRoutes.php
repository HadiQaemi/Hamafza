<?php
Route::get('/', ['as' => 'ugc.desktop.index', 'uses' => 'View\UserController@DefDesktop', 'middleware' => ['dynamic_permission:ugc.desktop.index']]);
Route::get('subject_field', ['ugc.desktop.subject_field' => '', 'uses' => 'View\UserController@subject_field', 'middleware' => ['dynamic_permission:ugc.desktop.subject_field']]);
Route::get('notifications', ['as' => 'ugc.desktop.notifications', 'uses' => 'View\UserController@notifications', 'middleware' => ['dynamic_permission:ugc.desktop.notifications']]);
//Route::get('user_measures', 'View\UserController@user_measures');
//Route::get('user_measures_ME', 'View\UserController@user_measures_ME');
//Route::get('user_measures_BC', 'View\UserController@user_measures_BC');
//Route::get('inbox', ['as' => 'desktop.inbox', 'uses' => 'View\UserController@inbox']);
//Route::get('outbox', ['as' => 'desktop.outbox', 'uses' => 'View\UserController@Outbox']);
/* -------------------------------------------------------------- */
/* ------------------------ Menu Files -------------------------- */
/* -------------------------------------------------------------- */
Route::group(['prefix' => 'Files', 'middleware' => ['dynamic_permission:ugc.desktop.files']], function ($username)
{
    Route::get('New_Other', ['as' => 'ugc.desktop.new_other', 'uses' => 'View\UserController@New_Other', 'middleware' => ['dynamic_permission:ugc.desktop.files.new_other']]);
});
/* -------------------------------------------------------------- */
/* ------------------------ END Menu Files ---------------------- */
/* -------------------------------------------------------------- */
Route::get('announces', ['as' => 'ugc.desktop.announces', 'uses' => 'View\UserController@announces', 'middleware' => ['dynamic_permission:ugc.desktop.announces']]);
Route::get('homepage', ['as' => 'ugc.desktop.homepage', 'uses' => 'View\UserController@homepage', 'middleware' => ['dynamic_permission:ugc.desktop.homepage']]);
Route::get('departments', ['as' => 'ugc.desktop.departments', 'uses' => 'View\UserController@departments', 'middleware' => ['dynamic_permission:ugc.desktop.departments']]);
Route::get('highlights', ['as' => 'ugc.desktop.highlights', 'uses' => 'View\UserController@highlights', 'middleware' => ['dynamic_permission:ugc.desktop.highlights']]);
Route::get('asubadd', ['as' => 'ugc.desktop.asubadd', 'uses' => 'View\UserController@asubadd', 'middleware' => ['dynamic_permission:ugc.desktop.asubadd']]);
Route::group(['prefix' => 'form_list', 'middleware' => ['dynamic_permission:ugc.desktop.form_list']], function ($username)
{
    require(__DIR__ . '/helper/HamafzaUsersDesktopRoutes/Get/form_list.php');
});
/*Route::group(['prefix' => 'user_list'], function ($username)
{
    Route::get('/', 'View\UserController@user_list');
    Route::get('edit', 'View\UserController@user_list_edit');
    Route::get('add', 'View\UserController@user_list_add');
});*/
Route::get('showgroups', ['as' => 'ugc.desktop.show_groups', 'uses' => 'View\UserController@showgroups', 'middleware' => ['dynamic_permission:ugc.desktop.show_groups']]);

//Route::group(['prefix' => 'relations', 'middleware' => ['dynamic_permission:ugc.desktop.relations']], function ($username)
//{
//    require(__DIR__ . '/helper/HamafzaUsersDesktopRoutes/Get/relations.php');
//});

Route::group(['prefix' => 'subjects', 'middleware' => ['dynamic_permission:ugc.desktop.subjects']], function ($username)
{
    require(__DIR__ . '/helper/HamafzaUsersDesktopRoutes/Get/subjects.php');

});
//Route::group(['prefix' => 'alerts', 'middleware' => ['dynamic_permission:ugc.desktop.alerts']], function ($username)
//{
//    require(__DIR__ . '/helper/HamafzaUsersDesktopRoutes/Get/alerts.php');
//});
//Route::group(['prefix' => 'subst', 'middleware' => ['dynamic_permission:ugc.desktop.subst']], function ($username)
//{
//    require(__DIR__ . '/helper/HamafzaUsersDesktopRoutes/Get/subst.php');
//});
//        Route::get('user_measures_BC', 'View\UserController@user_measures_BC');