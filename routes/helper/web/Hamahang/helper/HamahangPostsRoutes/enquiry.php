<?php
Route::post('index_ajax', ['as' => 'hamahang.enquiry.index_ajax', 'uses' => 'EnquiryController@index_ajax', 'middleware' => ['dynamic_permission:posts.hamahang.enquiry.index_ajax']]);
Route::post('index_ajax_sidebar', ['as' => 'hamahang.enquiry.index_ajax_sidebar', 'uses' => 'EnquiryController@index_ajax_sidebar', 'middleware' => ['dynamic_permission:posts.hamahang.enquiry.index_ajax_sidebar']]);
Route::post('enquiry_answer', ['as' => 'hamahang.enquiry.answer', 'uses' => 'EnquiryController@answer', 'middleware' => ['dynamic_permission:posts.hamahang.enquiry.answer']]);
Route::post('enquiry_accept', ['as' => 'hamahang.enquiry.accept', 'uses' => 'EnquiryController@accept', 'middleware' => ['dynamic_permission:posts.hamahang.enquiry.accept']]);
Route::post('enquiry_get', ['as' => 'hamahang.enquiry.get', 'uses' => 'EnquiryController@get', 'middleware' => ['dynamic_permission:posts.hamahang.enquiry.get']]);
Route::post('get_keywords/{id}/{paginate}', ['as' => 'hamahang.enquiry.get_keywords', 'uses' => 'EnquiryController@get_keywords', 'middleware' => ['dynamic_permission:posts.hamahang.enquiry.get_keywords']]); //get?
/* ??? */Route::post('enquiry', ['as' => 'hamahang.enquiry.create', 'uses' => 'EnquiryController@create', 'middleware' => ['dynamic_permission:posts.hamahang.enquiry.create']]);

