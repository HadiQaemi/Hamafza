<?php
Route::get('me', ['as' => 'ugc.desktop.form_list.me', 'uses' => 'View\UserController@form_list_me', 'middleware' => ['dynamic_permission:ugc.desktop.form_list.me']]);
Route::get('sent', ['as' => 'ugc.desktop.form_list.sent', 'uses' => 'View\UserController@form_list_sent', 'middleware' => ['dynamic_permission:ugc.desktop.form_list.sent']]);
Route::get('copy', ['as' => 'ugc.desktop.form_list.copy', 'uses' => 'View\UserController@form_list_copy', 'middleware' => ['dynamic_permission:ugc.desktop.form_list.copy']]);
Route::get('edit', ['as' => 'ugc.desktop.form_list.edit', 'uses' => 'View\UserController@form_list_edit', 'middleware' => ['dynamic_permission:ugc.desktop.form_list.edit']]);
Route::get('drafts', ['as' => 'ugc.desktop.form_list.drafts', 'uses' => 'View\UserController@form_list_drafts', 'middleware' => ['dynamic_permission:ugc.desktop.form_list.drafts']]);
Route::get('all', ['as' => 'ugc.desktop.form_list.all', 'uses' => 'View\UserController@form_list_all', 'middleware' => ['dynamic_permission:ugc.desktop.form_list.all']]);
/* ??? */Route::get('add', ['as' => 'ugc.desktop.form_list.add', 'uses' => 'View\UserController@form_list_add']);
