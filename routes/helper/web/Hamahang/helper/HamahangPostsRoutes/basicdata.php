<?php
Route::post('get_groups', ['as' => 'hamahang.basicdata.get_groups', 'uses' => 'BasicdataController@get_groups', 'middleware' => ['dynamic_permission:posts.hamahang.basicdata.get_groups']]);
Route::post('get_items', ['as' => 'hamahang.basicdata.get_items', 'uses' => 'BasicdataController@get_items', 'middleware' => ['dynamic_permission:posts.hamahang.basicdata.get_items']]);
Route::post('load_items', ['as' => 'hamahang.basicdata.load_items', 'uses' => 'BasicdataController@load_items', 'middleware' => ['dynamic_permission:posts.hamahang.basicdata.load_items']]);