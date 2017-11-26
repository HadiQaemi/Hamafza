<?php
Route::get('login', ['as' => 'login', 'uses' => 'Hamahang\UserController@login']);
Route::get('register', ['as' => 'register', 'uses' => 'Hamahang\UserController@register']);
Route::post('login_user', ['as' => 'login_user', 'uses' => 'Hamahang\UserController@login_user']);
Route::post('register_user', ['as' => 'register_user', 'uses' => 'Hamahang\UserController@register_user']);
Route::post('send_remember_password_email', ['as' => 'send_remember_password_email', 'uses' => 'Hamahang\UserController@send_remember_password_email']);
Route::get('reset_password/{reset_password_code}', ['as' => 'reset_password', 'uses' => 'Hamahang\UserController@reset_password']);
Route::post('reset_forgotten_password', ['as' => 'reset_forgotten_password', 'uses' => 'Hamahang\UserController@reset_forgotten_password']);
