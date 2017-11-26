<?php
Route::post('get_tools', ['as' => 'hamahang.tools.get_tools', 'uses' => 'ToolsController@getTools']);
Route::post('save_tools', ['as' => 'hamahang.tools.save_tools', 'uses' => 'ToolsController@saveTools']);
Route::post('edit_tools', ['as' => 'hamahang.tools.edit_tools', 'uses' => 'ToolsController@editTools']);
Route::post('delete_tools', ['as' => 'hamahang.tools.delete_tools', 'uses' => 'ToolsController@deleteTools']);
Route::post('set_visibility', ['as' => 'hamahang.tools.set_visibility', 'uses' => 'ToolsController@setVisibility']);
Route::post('add_tools_role', ['as' => 'hamahang.tools.add_tools_role', 'uses' => 'ToolsController@addToolsRole']);
Route::post('add_tools_user', ['as' => 'hamahang.tools.add_tools_user', 'uses' => 'ToolsController@addToolsUser']);
Route::post('get_tools_roles', ['as' => 'hamahang.tools.get_tools_roles', 'uses' => 'ToolsController@getToolsRoles']);
Route::post('get_tools_users', ['as' => 'hamahang.tools.get_tools_users', 'uses' => 'ToolsController@getToolsUsers']);
Route::post('delete_tools_role', ['as' => 'hamahang.tools.delete_tools_role', 'uses' => 'ToolsController@deleteToolsRole']);
Route::post('delete_tools_user', ['as' => 'hamahang.tools.delete_tools_user', 'uses' => 'ToolsController@deleteToolsUser']);
Route::post('set_item_order', ['as' => 'hamahang.tools.set_item_order', 'uses' => 'ToolsController@setItemOrder']);