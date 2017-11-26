<?php
Route::group(['prefix' => 'files', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.files']], function ()
{
    Route::get('Created_ME', ['as' => 'ugc.desktop.Hamahang.files.Created_ME', 'uses' => 'FileController@Created_ME', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.files.created_me']]);
    Route::get('Edited_ME', ['as' => 'ugc.desktop.Hamahang.files.Edited_ME', 'uses' => 'FileController@Edited_ME', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.files.edited_me']]);
    Route::get('follow_ME', ['as' => 'ugc.desktop.Hamahang.files.follow_ME', 'uses' => 'FileController@follow_ME', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.files.follow_me']]);
    Route::get('like_ME', ['as' => 'ugc.desktop.Hamahang.files.like_ME', 'uses' => 'FileController@like_ME', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.files.like_me']]);
    Route::get('highlight_ME', ['as' => 'ugc.desktop.Hamahang.files.highlight_ME', 'uses' => 'FileController@highlight_ME', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.files.highlight_me']]);
    Route::get('ano_ME', ['as' => 'ugc.desktop.Hamahang.files.ano_ME', 'uses' => 'FileController@ano_ME', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.files.ano_me']]);
    Route::get('Sug_ME', ['as' => 'ugc.desktop.Hamahang.files.Sug_ME', 'uses' => 'FileController@Sug_ME', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.files.sug_me']]);
    Route::get('visited_ME', ['as' => 'ugc.desktop.Hamahang.files.visited_ME', 'uses' => 'FileController@visited_ME', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.files.visited_me']]);
    Route::get('Proc_ME', ['as' => 'ugc.desktop.Hamahang.files.Proc_ME', 'uses' => 'FileController@Proc_ME', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.files.proc_me']]);
    Route::get('ALL_ME', ['as' => 'ugc.desktop.Hamahang.files.ALL_ME', 'uses' => 'FileController@ALL_ME', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.files.all_me']]);
    Route::get('ALL_Other', ['as' => 'ugc.desktop.Hamahang.files.ALL_Other', 'uses' => 'FileController@ALL_Other', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.files.all_other']]);
    Route::get('Deleted_pages', ['as' => 'ugc.desktop.Hamahang.files.Deleted_pages', 'uses' => 'FileController@Deleted_pages', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.files.deleted_pages']]);

});
