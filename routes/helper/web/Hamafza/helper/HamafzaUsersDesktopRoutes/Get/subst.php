<?php
Route::get('/', ['as' => 'ugc.desktop.subst.index', 'uses' => 'View\UserController@subst', 'middleware' => ['dynamic_permission:ugc.desktop.subst.index']]);
Route::get('add', ['as' => 'ugc.desktop.subst.add', 'uses' => 'View\UserController@subst_add', 'middleware' => ['dynamic_permission:ugc.desktop.subst.add']]);
Route::get('edit', ['as' => 'ugc.desktop.subst.edit', 'uses' => 'View\UserController@subst_edit', 'middleware' => ['dynamic_permission:ugc.desktop.subst.edit']]);