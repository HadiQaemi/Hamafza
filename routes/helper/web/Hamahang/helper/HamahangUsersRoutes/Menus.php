<?php
Route::group(['prefix' => 'menus', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.menus']], function ()
{
    Route::get('index', ['as' => 'ugc.desktop.hamahang.menus.index', 'uses' => 'MenusController@index', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.menus.index']]);
    Route::get('items/{menu_id}', ['as' => 'ugc.desktop.hamahang.menus.items', 'uses' => 'MenusController@items', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.menus.items']]);
});
Route::group(['prefix' => 'MenuTypes', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.menus.menu_types']], function ()
{
    /* ??? */Route::get('Index', ['as' => 'ugc.desktop.hamahang.menu_types.index', 'uses' => 'MenuTypesController@Index', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.menu_types.index']]);
});