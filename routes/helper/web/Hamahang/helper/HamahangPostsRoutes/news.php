<?php
Route::post('index_ajax', ['as' => 'hamahang.news.index_ajax', 'uses' => 'NewsController@index_ajax', 'middleware' => ['dynamic_permission:posts.hamahang.news.index_ajax']]);
Route::post('get_keywords/{id}/{paginate}', ['as' => 'hamahang.news.get_keywords', 'uses' => 'NewsController@get_keywords', 'middleware' => ['dynamic_permission:posts.hamahang.news.get_keywords']]); //get?
/* ??? */Route::post('index_ajax_sidebar', ['as' => 'hamahang.news.index_ajax_sidebar', 'uses' => 'NewsController@index_ajax_sidebar', 'middleware' => ['dynamic_permission:posts.hamahang.news.index_ajax_sidebar']]); //get?
