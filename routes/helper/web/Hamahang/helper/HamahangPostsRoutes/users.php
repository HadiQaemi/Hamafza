<?php
//Route::post('getUser', ['as' => 'hamahang.users.get_users', 'uses' => 'UserController@getUsers', 'middleware' => ['dynamic_permission:posts.hamahang.users.get_users']]);
Route::post('getUser', ['as' => 'hamahang.users.get_users', 'uses' => 'UserController@getUsers', 'middleware' => ['role:administrator']]);
Route::post('countUser', ['as' => 'hamahang.users.countUser', 'uses' => 'UserController@countUser']);
Route::post('countFilterUser', ['as' => 'hamahang.users.countFilterUser', 'uses' => 'UserController@countFilterUser']);
Route::post('addUser', ['as' => 'hamahang.users.add_user', 'uses' => 'UserController@addUsers', 'middleware' => ['dynamic_permission:posts.hamahang.users.add_user']]);
Route::post('editUser', ['as' => 'hamahang.users.edit_user', 'uses' => 'UserController@editUser', 'middleware' => ['dynamic_permission:posts.hamahang.users.edit_user']]);
Route::post('editShowUsers', ['as' => 'hamahang.users.edit_show_users', 'uses' => 'UserController@editShowUsers', 'middleware' => ['dynamic_permission:posts.hamahang.users.edit_show_users']]);
Route::post('destroyUser', ['as' => 'hamahang.users.destroy_user', 'uses' => 'UserController@destroyUser', 'middleware' => ['dynamic_permission:posts.hamahang.users.destroy_user']]);
// User Avatar
Route::post('saveAvatar', ['as' => 'hamahang.users.save_avatar', 'uses' => 'UserController@saveAvatar', 'middleware' => ['dynamic_permission:posts.hamahang.users.save_avatar']]);
Route::post('removeAvatar', ['as' => 'hamahang.users.remove_avatar', 'uses' => 'UserController@removeAvatar', 'middleware' => ['dynamic_permission:posts.hamahang.users.remove_avatar']]);
Route::post('renameAvatar', ['as' => 'hamahang.users.rename_avatar', 'uses' => 'UserController@renameAvatar', 'middleware' => ['dynamic_permission:posts.hamahang.users.rename_avatar']]);
// User Special
Route::post('updateUserDetail', ['as' => 'hamahang.users.update_user_detail', 'uses' => 'UserController@updateUserDetail', 'middleware' => ['dynamic_permission:posts.hamahang.users.update_user_detail']]);
Route::post('updateUserPassword', ['as' => 'hamahang.users.updateUserPassword', 'uses' => 'UserController@updateUserPassword', 'middleware' => ['dynamic_permission:posts.hamahang.users.update_user_password']]);
Route::post('updateUserSpecials', ['as' => 'hamahang.users.update_user_specials', 'uses' => 'UserController@updateUserSpecials', 'middleware' => ['dynamic_permission:posts.hamahang.users.update_user_specials']]);
Route::post('addUserWork', ['as' => 'hamahang.users.add_user_work', 'uses' => 'UserController@addUserWork', 'middleware' => ['dynamic_permission:posts.hamahang.users.add_user_work']]);
Route::post('updateUserWork', ['as' => 'hamahang.users.update_user_work', 'uses' => 'UserController@updateUserWork', 'middleware' => ['dynamic_permission:posts.hamahang.users.update_user_work']]);
Route::post('deleteUserWork', ['as' => 'hamahang.users.delete_user_work', 'uses' => 'UserController@deleteUserWork', 'middleware' => ['dynamic_permission:posts.hamahang.users.delete_user_work']]);
Route::post('addUserEducation', ['as' => 'hamahang.users.add_user_education', 'uses' => 'UserController@addUserEducation', 'middleware' => ['dynamic_permission:posts.hamahang.users.add_user_education']]);
Route::post('updateUserEducation', ['as' => 'hamahang.users.update_user_education', 'uses' => 'UserController@updateUserEducation', 'middleware' => ['dynamic_permission:posts.hamahang.users.update_user_education']]);
Route::post('deleteUserEducation', ['as' => 'hamahang.users.delete_user_education', 'uses' => 'UserController@deleteUserEducation', 'middleware' => ['dynamic_permission:posts.hamahang.users.delete_user_education']]);
Route::post('userSpecialEndorse', ['as' => 'hamahang.users.user_special_endorse', 'uses' => 'UserController@userSpecialEndorse', 'middleware' => ['dynamic_permission:posts.hamahang.users.user_special_endorse']]);
Route::post('userEndorse', ['as' => 'hamahang.users.user_endorse', 'uses' => 'UserController@userEndorse', 'middleware' => ['dynamic_permission:posts.hamahang.users.user_endorse']]);
Route::get('fetchGroups', ['as' => 'hamahang.users.fetchGroups', 'uses' => 'UserController@fetchGroups']);
Route::post('removeGroup', ['as' => 'hamahang.users.removeGroup', 'uses' => 'UserController@removeGroup']);
Route::post('removeUserNew', ['as' => 'hamahang.users.remove_user_new', 'uses' => 'UserController@removeUserNew', 'middleware' => ['dynamic_permission:posts.hamahang.users.remove_user_new']]);
Route::post('cities', ['as' => 'hamahang.users.cities', 'uses' => 'UserController@cities', 'middleware' => ['dynamic_permission:posts.hamahang.users.cities']]);