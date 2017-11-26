<?php

Route::post('get_file_created', ['as' => 'hamahang.files.get_file_created', 'uses' => 'FileController@get_file_created']);
Route::post('get_file_edited', ['as' => 'hamahang.files.get_file_edited', 'uses' => 'FileController@get_file_edited']);

Route::post('get_file_follow', ['as' => 'hamahang.files.get_file_follow', 'uses' => 'FileController@get_file_follow']);
Route::post('get_file_like', ['as' => 'hamahang.files.get_file_like', 'uses' => 'FileController@get_file_like']);
Route::post('get_file_highlight', ['as' => 'hamahang.files.get_file_highlight', 'uses' => 'FileController@get_file_highlight']);
Route::post('get_file_ano', ['as' => 'hamahang.files.get_file_ano', 'uses' => 'FileController@get_file_ano']);
Route::post('get_file_sug', ['as' => 'hamahang.files.get_file_sug', 'uses' => 'FileController@get_file_sug']);
Route::post('get_file_visited', ['as' => 'hamahang.files.get_file_visited', 'uses' => 'FileController@get_file_visited']);
Route::post('get_file_proc', ['as' => 'hamahang.files.get_file_proc', 'uses' => 'FileController@get_file_proc']);
Route::post('get_file_all', ['as' => 'hamahang.files.get_file_all', 'uses' => 'FileController@get_file_all']);
Route::post('get_file_all_other', ['as' => 'hamahang.files.get_file_all_other', 'uses' => 'FileController@get_file_all_other']);
Route::post('get_file_deleted_pages', ['as' => 'hamahang.files.get_file_deleted_pages', 'uses' => 'FileController@get_file_deleted_pages']);

Route::post('add_subjects_role_show', ['as' => 'hamahang.files.add_subjects_role_show', 'uses' => 'FileController@addSubjectsRoleShow']);
Route::post('delete_subjects_role_show', ['as' => 'hamahang.files.delete_subjects_role_show', 'uses' => 'FileController@deleteSubjectsRoleShow']);
Route::post('add_subjects_role_edit', ['as' => 'hamahang.files.add_subjects_role_edit', 'uses' => 'FileController@addSubjectsRoleEdit']);
Route::post('delete_subjects_role_edit', ['as' => 'hamahang.files.delete_subjects_role_edit', 'uses' => 'FileController@deleteSubjectsRoleEdit']);
