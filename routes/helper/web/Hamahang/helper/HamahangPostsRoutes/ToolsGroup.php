<?php
Route::post('tools_group_list', ['as' => 'hamahang.tools_group.tools_group_list', 'uses' => 'ToolsGroupController@getToolsGroups']);
Route::post('add_new_tools_group', ['as' => 'hamahang.tools_group.add_new_tools_group', 'uses' => 'ToolsGroupController@addNewToolsGroups']);
Route::post('edit_tools_group', ['as' => 'hamahang.tools_group.edit_tools_group', 'uses' => 'ToolsGroupController@editToolsGroups']);
Route::post('delete_tools_group', ['as' => 'hamahang.tools_group.delete_tools_group', 'uses' => 'ToolsGroupController@DeleteToolsGroups']);
Route::post('set_item_order', ['as' => 'hamahang.tools_group.set_item_order', 'uses' => 'ToolsGroupController@setItemOrder']);
Route::post('set_visibility', ['as' => 'hamahang.tools_group.set_visibility', 'uses' => 'ToolsGroupController@setVisibility']);