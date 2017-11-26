<?php
// PGS = Pages or Groups or Subjects

Route::group(['prefix' => 'Process', 'middleware' => ['dynamic_permission:pgs.desktop.hamahang.process']], function ()
{
    Route::get('list', ['as' => 'pgs.desktop.hamahang.process.list', 'uses' => 'ProcessController@ProcessList', 'middleware' => ['dynamic_permission:pgs.desktop.hamahang.process.list']]);
});