<?php
Route::post('get_page_files', ['as' => 'hamahang.pages.get_page_files', 'uses' => 'PagesController@getPageFiles', 'middleware' => ['dynamic_permission:posts.hamahang.pages.get_page_files']]);
Route::post('save_page_files', ['as' => 'hamahang.pages.save_page_files', 'uses' => 'PagesController@savePageFiles', 'middleware' => ['dynamic_permission:posts.hamahang.pages.save_page_files']]);
Route::post('remove_page_files', ['as' => 'hamahang.pages.remove_page_files', 'uses' => 'PagesController@removePageFiles', 'middleware' => ['dynamic_permission:posts.hamahang.pages.remove_page_files']]);
