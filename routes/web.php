<?php

use App\Http\Controllers\View;

require(__DIR__ . '/helper/web/TestRoutes.php');
require(__DIR__ . '/helper/web/LoginRegisterRoutes.php');

Route::get('DownloadFile/{type}/{id?}/{default_img?}', ['prefix' => 'FileManager', 'as' => 'FileManager.DownloadFile', 'uses' => 'Hamahang\FileManagerController@Download']);
Route::get('Captcha/{section}', ['as' => 'captcha', 'uses' => 'Hamahang\CaptchaController@index']);

//Route::group(['prefix' => 'services', 'middleware' => ['dynamic_permission:services']], function ()
//{
//    Route::post('GetMenus', ['as' => 'get_menus', 'uses' => 'Services\PublicController@GetMenus', 'middleware' => ['dynamic_permission:services.get_menus']]);
//});
Route::group(['prefix' => 'bookmarks'], function ()
{
    Route::get('/view/{id}', ['uses' => 'View\AjaxController@bookmarks_view', 'as' => 'bookmarks.view', ]);
});

Route::group(['prefix' => 'services'], function ()
{
    Route::post('GetMenus', 'Services\PublicController@GetMenus');
});

Route::group(['prefix' => 'Calendar', 'middleware' => ['dynamic_permission:calendar']], function ()
{
    Route::get('/GetAllEvents/{year}', ['as' => 'Calendar.GetAllEvents', 'uses' => 'Hamahang\CalendarController@GetAllEvents', 'middleware' => ['dynamic_permission:calendar.get_all_events']]);
    Route::get('Provinces', ['as' => 'calendar.provinces_and_cites.province', 'uses' => 'Hamahang\ProvinceCityController@getProvince', 'middleware' => ['dynamic_permission:calendar.provinces_and_cites.province']]);
    Route::get('Cities/{pId}', ['as' => 'calendar.provinces_and_cites.cities', 'uses' => 'Hamahang\ProvinceCityController@getCity', 'middleware' => ['dynamic_permission:calendar.provinces_and_cites.cities']]);
});
/* -------------------------------------------------------------------------------------------- */
//Route::group(['prefix' => 'Provinces_AND_Cites', 'middleware' => ['dynamic_permission:provinces_and_cites']], function ()
//{
//    Route::get('Import', ['as' => 'Provinces_AND_Cites.Import', 'uses' => 'Hamahang\ProvinceCityController@Import', 'middleware' => ['dynamic_permission:provinces_and_cites.import']]);
//});
/* -------------------------------------------------------------------------------------------- */

require(__DIR__ . '/helper/web/FileManagerRoutes.php');

/* -------------------------------------------------------------------------------------------- */
//Route::get('/', 'View\HomeController@index');

// callback
Route::get('/bazaar/Payment/gateway/pimacs/callback', ['as' => 'bazaar.callback', 'uses' => 'Hamahang\BazaarController@callback', 'middleware' => ['dynamic_permission:bazaar.callback']]);//p

Route::get('Export', ['as' => 'expert', 'uses' => 'View\AjaxController@Export', 'middleware' => ['dynamic_permission:expert']]);//p
Route::get('/Logout', ['as' => 'logout', 'uses' => 'View\SSOController@Logout', 'middleware' => ['dynamic_permission:logout']]);//p
Route::get('download', ['as' => 'download', 'uses' => 'ToolsController@downloadfile', 'middleware' => ['dynamic_permission:download']]);//p
Route::get('Tessearch', ['as' => 'tes_search', 'uses' => 'View\AjaxController@Tessearch', 'middleware' => ['dynamic_permission:tes_search']]);//p
Route::get('Helpsearch', ['as' => 'help_search', 'uses' => 'View\AjaxController@Helpsearch', 'middleware' => ['dynamic_permission:help_search']]);//p
Route::get('Pagesearch', ['as' => 'page_search', 'uses' => 'View\AjaxController@pagesearch', 'middleware' => ['dynamic_permission:page_search']]);//p
Route::get('Groupsearch', ['as' => 'group_search', 'uses' => 'View\AjaxController@Groupsearch', 'middleware' => ['dynamic_permission:group_search']]);//p
Route::get('/', ['as' => 'home', 'uses' => 'View\HomeController@index']);//p
Route::get('group_edit/{id}', ['as'=>'group.edit','uses'=>'View\UserController@GroupEdit', 'middleware' => ['dynamic_permission:group.edit']])->where('id', '[0-9]+');
Route::get('page_edit/{id}/{Type}', ['as' => 'page.edit', 'uses' => 'View\PageController@PageEditDetail'/*, 'middleware' => ['dynamic_permission:page.edit']*/])->where('id', '[0-9]+', 'Type', '[a-zA-Z\-_.]+');
Route::any('Tagsearch', ['as' => 'tag_search', 'uses' => 'View\AjaxController@tagsearch', 'middleware' => ['dynamic_permission:tag_search']]);//p
Route::get('history/{id}/{hid}', ['as' => 'history', 'uses' => 'View\PageController@history', 'middleware' => ['dynamic_permission:history']])->where('id', '[0-9]+')->where('hid', '[0-9]+');
//Route::post('UserList_settings',['as' => 'UserList_settings', 'uses' => 'Hamahang\AutoCompleteController@UsersList', 'middleware' => ['dynamic_permission:user_list_settings']]);
Route::post('search_list_user',['as' => 'search_list_user', 'uses' => 'Hamahang\AutoCompleteController@search_list_user', 'middleware' => ['dynamic_permission:search_list_user']]);
Route::post('search_list_task',['as' => 'search_list_task', 'uses' => 'Hamahang\AutoCompleteController@search_list_task', 'middleware' => ['dynamic_permission:search_list_task']]);
Route::post('selected_list_user',['as' => 'selected_list_user', 'uses' => 'Hamahang\AutoCompleteController@selected_list_user', 'middleware' => ['dynamic_permission:selected_list_user']]);
Route::post('selected_list_task',['as' => 'selected_list_task', 'uses' => 'Hamahang\AutoCompleteController@selected_list_task', 'middleware' => ['dynamic_permission:selected_list_task']]);


/* * ======================___BEGIN___All Page Routes___BEGIN___==================* */
Route::pattern('id', '\d+');
Route::get('{PreCode}-{id}/{type?}', ['as' => 'pre_code', 'uses' => 'View\PageController@PageDetails', 'middleware' => ['dynamic_permission:pre_code']]);//p
Route::group(['prefix' => '{id}', 'middleware' => ['dynamic_permission:id']], function ($id)//p
{
    require(__DIR__ . '/helper/web/Hamafza/HamafzaPagesRoutes.php');
    Route::group(['prefix' => 'desktop', 'middleware' => ['dynamic_permission:id.desktop']], function ($id)
    {
        require(__DIR__ . '/helper/web/Hamafza/HamafzaPagesDesktopRoutes.php');
        require(__DIR__ . '/helper/web/Hamahang/HamahangPagesRoutes.php');
    });
    /* ??? *///Route::get('/{title}', 'View\PageController@PageDetails');
    Route::get('{type?}', ['as' => 'page_type', 'uses' => 'View\PageController@PageDetails', 'middleware' => ['dynamic_permission:id.page_type']]);//p
});
/* * =========================__END__All Page Routes___END___=====================* */


/* * ======================___BEGIN___All User Routes___BEGIN___==================* */
//Route::pattern('username', '^(?!.*__)^(?!.*\.\.)^(?!_)^(?!\.)(?!^\d+$)^[a-zA-Z\d-_.]{3,16}$/');
Route::pattern('username', '[a-zA-Z0-9\-_.]+');
Route::group(['prefix' => '{username}', 'middleware' => ['dynamic_permission:username']], function ($username)//p
{
    require(__DIR__ . '/helper/web/Hamafza/HamafzaUsersRoutes.php');

    Route::group(['prefix' => 'desktop', 'middleware' => ['dynamic_permission:desktop']], function ($username)
    {
        require(__DIR__ . '/helper/web/Hamafza/HamafzaUsersDesktopRoutes.php');
        /****************----------------------------------------------------------------------*************/
        /****************------------------------- Begin Hamahang Routes ----------------------*************/
        /*****************----------------------------------------------------------------------************/
        require(__DIR__ . '/helper/web/Hamahang/HamahangUsersRoutes.php');
        /*****************----------------------------------------------------------------------************/
        /*****************-------------------------- End Hamahang Routes -----------------------************/
        /*****************----------------------------------------------------------------------************/
        //:TODO:most be removed and moved and create route for every one of switch */
        Route::group(['prefix' => '{type?}', 'middleware' => ['dynamic_permission:desktop.type']], function ($type = null)
        {
            Route::get('/{sublk}', ['middleware' => ['dynamic_permission:desktop.type.sublk']], function ($username, $type, $sublk)
            {
                return View\UserController::UserDesktop($username, $type, $sublk);
            });
            Route::get('/', ['as' => 'type.index', 'uses' => 'View\UserController@UserDesktop', 'middleware' => ['dynamic_permission:desktop.type.index']]);
        });
    });
});
require(__DIR__ . '/helper/web/EditorModals.php');
/* * =========================__END__All User Routes___END___=====================* */



//-------------------------------------------Posts--------------------------------------------//
require(__DIR__ . '/helper/web/ModalsRoutes.php');
require(__DIR__ . '/helper/web/Hamahang/HamahangPostsRoutes.php');
require(__DIR__ . '/helper/web/AutoCompleteRoutes.php');
require(__DIR__ . '/helper/web/Hamafza/HamafzaPostsRoutes.php');
//---------------------------------------------------------------------------------------------------------//
