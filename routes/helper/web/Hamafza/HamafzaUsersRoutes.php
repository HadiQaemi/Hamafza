<?php
Route::get('/', ['as' => 'ugc.index', 'uses' => 'View\UserController@DefaultTab', 'middleware' => ['dynamic_permission:ugs.index']]);//p
Route::get('/wall', ['as' => 'ugc.wall', 'uses' => 'View\UserController@UserWall', 'middleware' => ['dynamic_permission:ugs.wall']]);
Route::get('/intro', ['as' => 'ugc.intro', 'uses' => 'View\UserController@AboutUser', 'middleware' => ['dynamic_permission:ugs.intro']]);//p
Route::get('/persons', ['as' => 'ugc.persons', 'uses' => 'View\UserController@Grouppersons', 'middleware' => ['dynamic_permission:ugs.persons']]);
Route::get('/contents', ['as' => 'contents.UserContents', 'uses' => 'View\UserController@UserContents', 'middleware' => ['dynamic_permission:ugs.contents']]);//p
Route::get('/desktop', ['as' => 'ugc.desktop', 'uses' => 'View\UserController@DefDesktop', 'middleware' => ['dynamic_permission:ugs.persons']]);