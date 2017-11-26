<?php
Route::post('countryChart', ['as' => 'hamahang.charts.country_chart', 'uses' => 'ChartsController@chartCountry', 'middleware' => ['dynamic_permission:posts.hamahang.charts.country_chart']]);
Route::post('InsertChart', ['as' => 'hamahang.charts.insert_chart', 'uses' => 'ChartsController@InsertChart', 'middleware' => ['dynamic_permission:posts.hamahang.charts.insert_chart']]);
Route::post('ListCharts', ['as' => 'hamahang.charts.list_charts', 'uses' => 'ChartsController@ListCharts', 'middleware' => ['dynamic_permission:posts.hamahang.charts.list_charts']]);
Route::post('ListPost', ['as' => 'Hamahang.charts.ListPost', 'uses' => 'ChartsController@ListPost', 'middleware' => ['dynamic_permission:posts.hamahang.charts.list_post']]);
Route::post('ListOrganChartItem', ['as' => 'Hamahang.charts.ListOrganChartItem', 'uses' => 'ChartsController@ListOrganChartItem', 'middleware' => ['dynamic_permission:posts.hamahang.charts.list_organ_chart_item']]);
/* ??? */Route::post('subjectsChart', ['as' => 'hamahang.charts.subjects_chart', 'uses' => 'ChartsController@subjectsChart']);
