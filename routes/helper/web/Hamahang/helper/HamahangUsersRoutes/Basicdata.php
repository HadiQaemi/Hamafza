<?php
Route::group(['prefix' => 'basicdata', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.basicdata']], function ()
{
    Route::get('/{ID}', ['as' => 'ugc.desktop.hamahang.basicdata.items', 'uses' => 'BasicdataController@items', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.basicdata.items']]);
    /* ??? */Route::get('/', ['as' => 'ugc.desktop.hamahang.basicdata.index', 'uses' => 'BasicdataController@index', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.basicdata.index']]);
});