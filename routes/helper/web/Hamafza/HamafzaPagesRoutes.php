<?php
Route::get('/', ['as' => 'page', 'uses' => 'View\PageController@PageDetails', 'middleware' => ['dynamic_permission:page.index']]);//p
Route::get('/forum', ['as' => 'page.forum', 'uses' => 'View\PageController@PageForum', 'middleware' => ['dynamic_permission:page.forum']]);//p
Route::get('/enquiry/{ID}', ['as' => 'enquiry.view', 'uses' => 'Hamahang\EnquiryController@show_question', 'middleware' => ['dynamic_permission:page.enquiry.view']]);//p