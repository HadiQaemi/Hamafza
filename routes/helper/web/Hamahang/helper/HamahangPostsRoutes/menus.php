<?php
Route::post('getMenus', ['as' => 'hamahang.menus.get_menus', 'uses' => 'MenusController@getMenus', 'middleware' => ['dynamic_permission:posts.hamahang.menus.get_menus']]);
Route::post('storeMenu', ['as' => 'hamahang.menus.store_menu', 'uses' => 'MenusController@storeMenu', 'middleware' => ['dynamic_permission:posts.hamahang.menus.store_menu']]);
Route::post('updateMenu', ['as' => 'hamahang.menus.update_menu', 'uses' => 'MenusController@updateMenu', 'middleware' => ['dynamic_permission:posts.hamahang.menus.update_menu']]);
Route::post('destroyMenu', ['as' => 'hamahang.menus.destroy_menu', 'uses' => 'MenusController@destroyMenu', 'middleware' => ['dynamic_permission:posts.hamahang.menus.destroy_menu']]);
Route::post('getMenuItems', ['as' => 'hamahang.menus.get_menu_items', 'uses' => 'MenusController@getMenuItems', 'middleware' => ['dynamic_permission:posts.hamahang.menus.get_menu_items']]);
Route::post('storeMenuItem', ['as' => 'hamahang.menus.store_menu_item', 'uses' => 'MenusController@storeMenuItem', 'middleware' => ['dynamic_permission:posts.hamahang.menus.store_menu_item']]);
Route::post('updateMenuItem', ['as' => 'hamahang.menus.update_menu_item', 'uses' => 'MenusController@updateMenuItem', 'middleware' => ['dynamic_permission:posts.hamahang.menus.update_menu_item']]);
Route::post('destroyMenuItem', ['as' => 'hamahang.menus.destroy_menu_item', 'uses' => 'MenusController@destroyMenuItem', 'middleware' => ['dynamic_permission:posts.hamahang.menus.destroy_menu_item']]);
Route::post('getMenuNodes', ['as' => 'hamahang.Menus.get_menu_nodes', 'uses' => 'MenusController@getMenuNodes', 'middleware' => ['dynamic_permission:posts.hamahang.menus.get_menu_nodes']]);
Route::post('setStatus', ['as' => 'hamahang.menus.set_status', 'uses' => 'MenusController@setStatus', 'middleware' => ['dynamic_permission:posts.hamahang.menus.set_status']]);
Route::post('setItemOrder', ['as' => 'hamahang.menus.set_item_order', 'uses' => 'MenusController@setItemOrder', 'middleware' => ['dynamic_permission:posts.hamahang.menus.set_item_order']]);
Route::post('setMenuPermissions', ['as' => 'hamahang.menus.set_menu_permissions', 'uses' => 'MenusController@setMenuPermissions', 'middleware' => ['dynamic_permission:posts.hamahang.menus.set_menu_permissions']]);
/* ??? */Route::post('getMenuPermissions', ['as' => 'hamahang.menus.get_menu_permissions', 'uses' => 'MenusController@getMenuPermissions', 'middleware' => ['dynamic_permission:posts.hamahang.menus.get_menu_permissions']]);
