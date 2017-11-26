<?php
Route::group(['prefix' => 'subjects', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.subjects']], function ()
{
    Route::get('index', ['as' => 'ugc.desktop.hamahang.subjects.index', 'uses' => 'SubjectController@index', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.subjects.index']]);
});
