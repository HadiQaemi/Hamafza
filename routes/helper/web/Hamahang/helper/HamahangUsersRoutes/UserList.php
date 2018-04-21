<?php

Route::group(['prefix' => 'user_list', 'middleware' => ['role:administrator']], function ($username)
{
    //Route::get('/', ['as' => 'ugc.desktop.hamahang.user_list.index', 'uses' => 'UserController@index', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.user_list.index']]);
    Route::get('/', ['as' => 'ugc.desktop.hamahang.user_list.index', 'uses' => 'UserController@index', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.user_list.index']]);
    Route::get('edit',['as' => 'ugc.desktop.hamahang.user_list.edit', 'uses' => 'UserController@user_list_edit', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.user_list.edit']]);
    /* ??? */Route::get('add', 'UserController@user_list_add',['as' => 'ugc.desktop.hamahang.user_list.user_list_add', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.user_list.user_list_add']]);
});