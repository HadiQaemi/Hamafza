<?php
Route::group(['prefix' => 'auto_complete', 'namespace' => 'Hamahang', 'middleware' => ['dynamic_permission:auto_complete']], function ()
{
    Route::post('users', ['as' => 'auto_complete.users', 'uses' => 'AutoCompleteController@users', 'middleware' => ['dynamic_permission:auto_complete.users']]);
    Route::post('users_new', ['as' => 'auto_complete.users_new', 'uses' => 'AutoCompleteController@users_new', 'middleware' => ['dynamic_permission:auto_complete.users_new']]);
    Route::post('onet_jobs', ['as' => 'auto_complete.onet_jobs', 'uses' => 'AutoCompleteController@onet_jobs', 'middleware' => ['dynamic_permission:auto_complete.users_new']]);
    Route::post('missions_job', ['as' => 'auto_complete.missions_job', 'uses' => 'AutoCompleteController@missions_job', 'middleware' => ['dynamic_permission:auto_complete.users_new']]);
    Route::post('onet_jobs_items', ['as' => 'auto_complete.onet_jobs_items', 'uses' => 'AutoCompleteController@onet_jobs_items', 'middleware' => ['dynamic_permission:auto_complete.users_new']]);
    Route::post('job_corp', ['as' => 'auto_complete.job_corp', 'uses' => 'AutoCompleteController@job_corp', 'middleware' => ['dynamic_permission:auto_complete.users_new']]);
    Route::post('job_pos', ['as' => 'auto_complete.job_pos', 'uses' => 'AutoCompleteController@job_pos', 'middleware' => ['dynamic_permission:auto_complete.users_new']]);
    Route::post('org_charts_items_posts', ['as' => 'auto_complete.org_charts_items_posts', 'uses' => 'AutoCompleteController@org_charts_items_posts', 'middleware' => ['dynamic_permission:auto_complete.users_new']]);
    Route::post('org_charts_posts', ['as' => 'auto_complete.org_charts_posts', 'uses' => 'AutoCompleteController@org_charts_posts', 'middleware' => ['dynamic_permission:auto_complete.users_new']]);
    Route::post('onet_skill', ['as' => 'auto_complete.onet_skill', 'uses' => 'AutoCompleteController@onet_skill', 'middleware' => ['dynamic_permission:auto_complete.users_new']]);
    Route::post('onet_ability', ['as' => 'auto_complete.onet_ability', 'uses' => 'AutoCompleteController@onet_ability', 'middleware' => ['dynamic_permission:auto_complete.users_new']]);
    Route::post('onet_knowledge', ['as' => 'auto_complete.onet_knowledge', 'uses' => 'AutoCompleteController@onet_knowledge', 'middleware' => ['dynamic_permission:auto_complete.users_new']]);
    Route::post('tasks', ['as' => 'auto_complete.tasks', 'uses' => 'AutoCompleteController@tasks', 'middleware' => ['dynamic_permission:auto_complete.tasks']]);
    Route::post('resources', ['as' => 'auto_complete.resources', 'uses' => 'AutoCompleteController@resources', 'middleware' => ['dynamic_permission:auto_complete.resources']]);
    Route::post('pages', ['as' => 'auto_complete.pages', 'uses' => 'AutoCompleteController@pages', 'middleware' => ['dynamic_permission:auto_complete.pages']]);
    Route::post('permissions', ['as' => 'auto_complete.permissions', 'uses' => 'AutoCompleteController@permissions', 'middleware' => ['dynamic_permission:auto_complete.pages']]);
    Route::post('keywords', ['as' => 'auto_complete.keywords', 'uses' => 'AutoCompleteController@keywords', 'middleware' => ['dynamic_permission:auto_complete.keywords']]);
    Route::post('about_user_keywords', ['as' => 'auto_complete.about_user_keywords', 'uses' => 'AutoCompleteController@about_user_keywords', 'middleware' => ['dynamic_permission:auto_complete.about_user_keywords']]);
    Route::post('organs', ['as' => 'auto_complete.organs', 'uses' => 'AutoCompleteController@organs', 'middleware' => ['dynamic_permission:auto_complete.organs']]);
    Route::post('units', ['as' => 'auto_complete.units', 'uses' => 'AutoCompleteController@units', 'middleware' => ['dynamic_permission:auto_complete.organs']]);
    Route::post('organ_chart_items', ['as' => 'auto_complete.organ_chart_items', 'uses' => 'AutoCompleteController@organ_chart_items', 'middleware' => ['dynamic_permission:auto_complete.chart_items']]);
    Route::post('sibling_chart_items', ['as' => 'auto_complete.sibling_chart_items', 'uses' => 'AutoCompleteController@sibling_chart_items', 'middleware' => ['dynamic_permission:auto_complete.chart_items']]);
    Route::post('chart_items', ['as' => 'auto_complete.chart_items', 'uses' => 'AutoCompleteController@chart_items', 'middleware' => ['dynamic_permission:auto_complete.chart_items']]);
    Route::post('projects', ['as' => 'auto_complete.projects', 'uses' => 'AutoCompleteController@projects', 'middleware' => ['dynamic_permission:auto_complete.projects']]);
    Route::post('process', ['as' => 'auto_complete.process', 'uses' => 'AutoCompleteController@process', 'middleware' => ['dynamic_permission:auto_complete.process']]);
    Route::post('calendars', ['as' => 'auto_complete.calendars', 'uses' => 'AutoCompleteController@calendars', 'middleware' => ['dynamic_permission:auto_complete.calendars']]);
    Route::post('tools', ['as' => 'auto_complete.tools', 'uses' => 'AutoCompleteController@tools', 'middleware' => ['dynamic_permission:auto_complete.tools']]);
    Route::post('roles', ['as' => 'auto_complete.roles', 'uses' => 'AutoCompleteController@roles', 'middleware' => ['dynamic_permission:auto_complete.roles']]);
    Route::post('all_roles', ['as' => 'auto_complete.all_roles', 'uses' => 'AutoCompleteController@allRoles']);
    Route::post('menuItems', ['as' => 'auto_complete.menu_items', 'uses' => 'AutoCompleteController@menuItems', 'middleware' => ['dynamic_permission:auto_complete.menu_items']]);
    Route::post('menus', ['as' => 'auto_complete.menus', 'uses' => 'AutoCompleteController@menus', 'middleware' => ['dynamic_permission:auto_complete.menus']]);
    Route::post('permissions', ['as' => 'auto_complete.permissions', 'uses' => 'AutoCompleteController@permissions', 'middleware' => ['dynamic_permission:auto_complete.permissions']]);
    Route::post('allPermissions', ['as' => 'auto_complete.all_permissions', 'uses' => 'AutoCompleteController@allPermissions', 'middleware' => ['dynamic_permission:auto_complete.all_permissions']]);
    Route::post('provinces', ['as' => 'auto_complete.provinces', 'uses' => 'AutoCompleteController@provinces', 'middleware' => ['dynamic_permission:auto_complete.provinces']]);
    Route::post('cities', ['as' => 'auto_complete.cities', 'uses' => 'AutoCompleteController@cities', 'middleware' => ['dynamic_permission:auto_complete.cities']]);
//    Route::post('hamahang_cities', ['as' => 'auto_complete.hamahang_cities', 'uses' => 'AutoCompleteController@hamahang_cities', 'middleware' => ['dynamic_permission:auto_complete.hamahang_cities']]);
    Route::post('getUserCalendar', ['as' => 'auto_complete.get_user_calendar', 'uses' => 'AutoCompleteController@getUserCalendar', 'middleware' => ['dynamic_permission:auto_complete.get_user_calendar']]);
    Route::post('acl_users', ['as' => 'auto_complete.acl_users', 'uses' => 'AutoCompleteController@aclUsers', 'middleware' => ['dynamic_permission:auto_complete.acl_users']]);
    Route::post('acl_categories', ['as' => 'auto_complete.acl_categories', 'uses' => 'AutoCompleteController@aclCategories', 'middleware' => ['dynamic_permission:auto_complete.acl_categories']]);
    Route::post('acl_parents_list', ['as' => 'auto_complete.acl_parents_list', 'uses' => 'AutoCompleteController@aclParentsList', 'middleware' => ['dynamic_permission:auto_complete.acl_parents_list']]);
    Route::post('keywordsWithSubjects', ['as' => 'auto_complete.keywords_with_subjects', 'uses' => 'AutoCompleteController@keywordsWithSubjects', 'middleware' => ['dynamic_permission:auto_complete.keywords_with_subjects']]);
    Route::post('subjects', ['as' => 'auto_complete.subjects', 'uses' => 'AutoCompleteController@subjects', 'middleware' => ['dynamic_permission:auto_complete.subjects']]);
    Route::post('help', ['as' => 'auto_complete.help', 'uses' => 'AutoCompleteController@help']);
});
Route::group(['prefix' => 'auto_complete', 'namespace' => 'Hamahang'], function ()
{
    Route::post('hamahang_cities', ['as' => 'auto_complete.hamahang_cities', 'uses' => 'AutoCompleteController@hamahang_cities']);
});