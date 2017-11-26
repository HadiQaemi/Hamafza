<?php
// UGC = User or Group or Chanel

Route::group(['prefix' => 'Tools', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tools']], function ()
{
    Route::get('Index', ['as' => 'ugc.desktop.hamahang.tools.index', 'uses' => 'ToolsController@Index', 'middleware' => ['dynamic_permission:ugc.desktop.hamahang.tools.index']]);
});