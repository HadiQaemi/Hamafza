<?php
Route::get('/', ['as' => 'page.desktop.index', 'uses' => 'View\PageController@PageDesktop', 'middleware' => ['dynamic_permission:page.desktop.index']]);
Route::get('/announces', ['as' => 'page.desktop.announces', 'uses' => 'View\PageController@announces', 'middleware' => ['dynamic_permission:page.desktop.announces']]);
Route::get('/highlights', ['as' => 'page.desktop.highlights', 'uses' => 'View\PageController@highlights', 'middleware' => ['dynamic_permission:page.desktop.highlights']]);